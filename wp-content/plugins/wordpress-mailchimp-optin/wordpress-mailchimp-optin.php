<?php
/*
Plugin Name: WordPress Mailchimp Opt-in
Plugin URI: http://kwikturnmedia.com
Description: Adds an opt-in field to the checkout page and as a shortcode so a user can opt-in to a MailChimp list.
Version: 1.4.0
Author: Kwikturn Media
Author URI: http://kwikturnmedia.com
*/

if ( ! defined( 'ABSPATH' ) )  {
	exit; // Exit if accessed directly
}

class WordPress_MailChimp_OptIn {
	private $PLUGIN_PATH;

	function __construct() {
		// Set Plugin Path
		$this->PLUGIN_PATH = plugins_url( '' , __FILE__ );

		// Run admin hooks
		if(is_admin()){
			add_action('admin_menu',array($this,'add_settings_menu'));
			add_action('admin_init',array($this,'register_settings'));
			add_action('wp_ajax_handle_mailchimp_ajax',array($this,'handle_ajax_actions'));
			add_action('wp_ajax_nopriv_handle_mailchimp_ajax',array($this,'handle_ajax_actions'));

			// CF7 Integration
			add_action( 'wpcf7_admin_init', array( $this, 'wpcf7_tag_generator' ), 15 );
		}else {
			add_action('woocommerce_checkout_fields',array($this,'add_checkout_optin_field'),10,1);
			add_action('woocommerce_checkout_process',array($this,'checkout_add_user_to_list'));
			add_action('wp_enqueue_scripts',function(){
				if(!wp_script_is('jquery-blockui','registered')){
					wp_register_script( 'jquery-blockui', $this->PLUGIN_PATH . '/assets/jquery.blockUI.min.js', array( 'jquery' ), '2.70' );
				}
				wp_register_script( 'mailchimp-signup-js', $this->PLUGIN_PATH . '/assets/mailchimp-signup.min.js', array( 'jquery', 'jquery-blockui' ), '1.0.1' );
			});
			add_shortcode('mailchimp_newsletter_signup',array($this,'shortcode_add_user_to_list'));
			add_action("widgets_init",function(){
				if(!class_exists('MailChimp_Widget')){
					include(__DIR__.'/includes/mailchimp-widget.php');
					register_widget('MailChimp_Widget');
				}
			});

			// CF7 Integration
			add_action( 'wpcf7_init', array( $this, 'wpcf7_register_types' ) );
			add_action( 'wpcf7_submit', array( $this, 'wpcf7_mail_sent' ), 10, 2 );
		}
	}


	/**
	 * Hook to enable signing up for MailChimp list on completion of an email being sent
	 *
	 * @param $wpcf7 WPCF7_ContactForm
	 * @param $result
	 */
	function wpcf7_mail_sent( $wpcf7, $result ) {
		if($result['status'] != "mail_sent") return;

		$email = "";

		$tags = $wpcf7->form_scan_shortcode();

		// Gather options for mailchimp
		foreach($tags as $tag){
			if($tag['type'] == "mailchimp"){
				foreach($tag['options'] as $option){
					if(strpos($option, 'emailfield') !== FALSE){
						$email = explode(':', $option)[1];
					}
				}
			}
		}

		if ( isset( $_POST[ $email ] ) && isset( $_POST['wpcf7-mailchimp'] ) ) {
			$this->add_user_to_list(
				get_option("mailchimp_widget_api_key"),
				get_option("mailchimp_widget_list_id"),
				$_POST[$email]
			);
		}
	}

	/**
	 * Register Contact Form 7 Shortcodes for signing people up
	 */
	function wpcf7_register_types() {
		wpcf7_add_form_tag( array( 'mailchimp', 'mailchimp*' ), array( $this, 'wpcf7_frontend_handler' ), false );
	}

	/**
	 * Handler to output the HTML for the CF7 Shortcode
	 *
	 * @param $tag
	 *
	 * @return string
	 */
	function wpcf7_frontend_handler( $tag ) {
		$tag = new WPCF7_FormTag( $tag );

		// $tag = new WPCF7_Shortcode( $tag );

		$class = wpcf7_form_controls_class( $tag->type, 'wpcf7-mailchimp' );

		$atts = array();
		if ( in_array( 'enabledbydefault', $tag->options ) ) {
			$atts['checked'] = "checked";
		}
		$atts['class'] = $tag->get_class_option( $class );
		$atts['id']    = $tag->get_id_option();
		$atts          = wpcf7_format_atts( $atts );

		$html = sprintf( '<span class="wpcf7-form-control-wrap %1$s"><input name="wpcf7-mailchimp" type="checkbox" %2$s /></span>', sanitize_html_class( $tag->name ), $atts );

		return $html;
	}

	/**
	 * Handler to generate tags for use with CF7
	 */
	function wpcf7_tag_generator() {
		$tag_generator = WPCF7_TagGenerator::get_instance();
		$tag_generator->add( 'mailchimp', __( 'mailchimp', 'wordpress-mailchimp-optin' ), array(
			$this,
			'wpcf7_shortcode_tag_generator'
		) );
	}

	/**
	 * Handler to generate popup window for use with CF7 back-end
	 *
	 * @param        $contact_form
	 * @param string $args
	 */
	function wpcf7_shortcode_tag_generator( $contact_form, $args = '' ){
		$args = wp_parse_args( $args, array() );
		$type = $args['id'];

		$description = __( "This is used for setting up mailchimp opt-ins, please verify that you have the keys setup %s in order for it to work properly. It will be using the 'widget' listid.", 'wordpress-mailchimp-optin' );

		$desc_link = wpcf7_link( __( admin_url('options-general.php?page=mailchimp_integration') , 'wordpress-mailchimp-optin' ), __( 'here', 'wordpress-mailchimp-optin' ) );

		?>
		<div class="control-box">
			<fieldset>
				<legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

				<table class="form-table">
					<tbody>

					<tr>
						<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'wordpress-mailchimp-optin' ) ); ?></label></th>
						<td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /><input type="hidden" name="required" /></td>
					</tr>

					<tr>
						<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-default' ); ?>"><?php echo esc_html( __( 'Enabled by default', 'wordpress-mailchimp-optin' ) ); ?></label></th>
						<td><input type="checkbox" name="enabledbydefault" class="defaultvalue option" id="<?php echo esc_attr( $args['content'] . '-default' ); ?>" /></td>
					</tr>

					<tr>
						<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-emailfield' ); ?>"><?php echo esc_html( __( 'Email Field Name (Required)', 'wordpress-mailchimp-optin' ) ); ?></label></th>
						<td><input type="text" name="emailfield" class="emailfield oneline option" id="<?php echo esc_attr( $args['content'] . '-emailfield' ); ?>" /></td>
					</tr>

					<tr>
						<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'wordpress-mailchimp-optin' ) ); ?></label></th>
						<td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
					</tr>

					<tr>
						<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'wordpress-mailchimp-optin' ) ); ?></label></th>
						<td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
					</tr>

					</tbody>
				</table>
			</fieldset>
		</div>

		<div class="insert-box">
			<input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

			<div class="submitbox">
				<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'wordpress-mailchimp-optin' ) ); ?>" />
			</div>

			<br class="clear" />

			<p class="description mail-tag"><label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'wordpress-mailchimp-optin' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?><input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" /></label></p>
		</div>
		<?php
	}

	/**
	 * Function to handle AJAXed actions to WordPress's admin-ajax.php
	 */
	function handle_ajax_actions(){
		global $wc_mailchimp_optin;
		$ajax = isset($_POST['ajax']);

		$fname = (isset($_POST["mailchimp_fname"])) ? $_POST["mailchimp_fname"] : "" ;
		$lname = (isset($_POST["mailchimp_lname"])) ? $_POST["mailchimp_lname"] : "" ;
		$email = (isset($_POST["mailchimp_email"])) ? $_POST["mailchimp_email"] : "" ;

		if(isset($wc_mailchimp_optin)){
			$result = $wc_mailchimp_optin->add_user_to_list(
				get_option("mailchimp_widget_api_key"),
				get_option("mailchimp_widget_list_id"),
				$email,
				$fname,
				$lname
			);

			if( !isset($result['status']) ) {
				if(!$ajax){
					wp_redirect(home_url('?action=subscribed'));
				}
			}elseif( $result['status'] == 'error' ) {
				if(!$ajax){
					wp_redirect(home_url('?action=failed'));
				}
			}

			echo json_encode($result);

		}
		wp_die();
	}

	/**
	 * Function to enqueue the options page.
	 */
	function add_settings_menu(){
		add_options_page('MailChimp Integration','MailChimp Integration','edit_posts',"mailchimp_integration",array($this,'render_settings_menu'));
	}

	/**
	 * Register and add settings menus to save.
	 */
	function register_settings() {
		add_settings_section( 'mailchimp_options', 'MailChimp Options', '', "mailchimp_integration" );

		add_settings_section( 'label_options', 'Label Options', '', "mailchimp_integration" );

		// Add Settings
		if ( class_exists( 'WooCommerce' ) ){
			add_settings_field( "mailchimp_api_key", 'MailChimp API Key', function () {
				WordPress_MailChimp_OptIn::return_input_field( array(
					'type'  => 'text',
					'id'    => "mailchimp_api_key",
					'value' => get_option( "mailchimp_api_key" )
				) );
			}, "mailchimp_integration", 'mailchimp_options' );

			add_settings_field( "mailchimp_list_id", 'MailChimp List ID', function () {
				WordPress_MailChimp_OptIn::return_input_field( array(
					'type'  => 'text',
					'id'    => "mailchimp_list_id",
					'value' => get_option( "mailchimp_list_id" )
				) );
			}, "mailchimp_integration", 'mailchimp_options' );

			add_settings_field( "mailchimp_label_title", 'Checkout Label Title', function () {
				WordPress_MailChimp_OptIn::return_input_field( array(
					'type'  => 'text',
					'id'    => "mailchimp_label_title",
					'value' => get_option( "mailchimp_label_title" )
				) );
			}, "mailchimp_integration", 'label_options' );

			add_settings_field( "mailchimp_label_description", 'Checkout Label Description', function () {
				WordPress_MailChimp_OptIn::return_input_field( array(
					'type'  => 'textarea',
					'id'    => "mailchimp_label_description",
					'value' => get_option( "mailchimp_label_description" )
				) );
			}, "mailchimp_integration", 'label_options' );
		}

		// Add Shortcode Settings
		add_settings_field("mailchimp_widget_api_key",'MailChimp API Key (Widget)',function(){
			WordPress_MailChimp_OptIn::return_input_field(array(
				'type'=>'text',
				'id'=>"mailchimp_widget_api_key",
				'value'=>get_option("mailchimp_widget_api_key")
			));
		},"mailchimp_integration",'mailchimp_options');

		add_settings_field("mailchimp_widget_list_id",'MailChimp List ID (Widget)',function(){
			WordPress_MailChimp_OptIn::return_input_field(array(
				'type'=>'text',
				'id'=>"mailchimp_widget_list_id",
				'value'=>get_option("mailchimp_widget_list_id")
			));
		},"mailchimp_integration",'mailchimp_options');

		add_settings_field("mailchimp_widget_label_title",'Label Title (Widget)',function(){
			WordPress_MailChimp_OptIn::return_input_field(array(
				'type'=>'text',
				'id'=>"mailchimp_widget_label_title",
				'value'=>get_option("mailchimp_widget_label_title")
			));
		},"mailchimp_integration",'label_options');

		add_settings_field("mailchimp_widget_label_description",'Label Description (Widget)',function(){
			WordPress_MailChimp_OptIn::return_input_field(array(
				'type'=>'textarea',
				'id'=>"mailchimp_widget_label_description",
				'value'=>get_option("mailchimp_widget_label_description")
			));
		},"mailchimp_integration",'label_options');

		add_settings_field("mailchimp_widget_result_success",'Description if Success (Widget)',function(){
			WordPress_MailChimp_OptIn::return_input_field(array(
				'type'=>'textarea',
				'id'=>"mailchimp_widget_result_success",
				'value'=>get_option("mailchimp_widget_result_success"),
				'rows'=>2,
				'default'=>'Thank you for signing up!'
			));
		},"mailchimp_integration",'label_options');

		add_settings_field("mailchimp_widget_result_failed",'Description if Failed (Widget)',function(){
			WordPress_MailChimp_OptIn::return_input_field(array(
				'type'=>'textarea',
				'id'=>"mailchimp_widget_result_failed",
				'value'=>get_option("mailchimp_widget_result_failed"),
				'rows'=>2,
				'default'=>'An error occured. Please verify your information and try again.'
			));
		},"mailchimp_integration",'label_options');

		add_settings_field("option_shortcode_result_email_wrong",'Description if Email is in an incorrect format (Widget)',function(){
			WordPress_MailChimp_OptIn::return_input_field(array(
				'type'=>'textarea',
				'id'=>"option_shortcode_result_email_wrong",
				'value'=>get_option("option_shortcode_result_email_wrong"),
				'rows'=>2,
				'default'=>'Please verify your email then try again.'
			));
		},"mailchimp_integration",'label_options');


		// Register Settings
		if(class_exists('WooCommerce')) {
			register_setting( "mailchimp_integration", "mailchimp_api_key" );
			register_setting( "mailchimp_integration", "mailchimp_list_id" );
			register_setting( "mailchimp_integration", "mailchimp_label_title" );
			register_setting( "mailchimp_integration", "mailchimp_label_description" );
		}
		// Register Shortcode Settings
		register_setting("mailchimp_integration","mailchimp_widget_api_key");
		register_setting("mailchimp_integration","mailchimp_widget_list_id");
		register_setting("mailchimp_integration","mailchimp_widget_label_title");
		register_setting("mailchimp_integration","mailchimp_widget_label_description" );
		register_setting("mailchimp_integration","mailchimp_widget_result_success" );
		register_setting("mailchimp_integration","mailchimp_widget_result_failed" );
		register_setting("mailchimp_integration","option_shortcode_result_email_wrong" );
	}

	/**
	 * Return the HTML needed to render the settings menu.
	 */
	function render_settings_menu(){
		?>
		<div class="wpbody-content">
			<div class="wrap">
				<h2>MailChimp Integration</h2>
				<form method="post" action="options.php">
					<?php
						settings_fields("mailchimp_integration");
						do_settings_sections("mailchimp_integration");
						submit_button();
					?>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * Function that adds the required opt-in field to the Checkout page.
	 *
	 * @param $checkout_fields
	 *
	 * @return mixed
	 */
	function add_checkout_optin_field($checkout_fields){
		$checkout_fields['billing']["mailchimp_integration"] = array(
			'type'=>'checkbox',
			'label'=>get_option("mailchimp_label_title"),
			'default'=>1,
			'description'=>"\n".get_option("mailchimp_label_description")
		);
		return $checkout_fields;
	}


	/**
	 * Function to add the user to a list specified for Checkout
	 */
	function checkout_add_user_to_list(){
		$api_key = get_option("mailchimp_api_key");
		$list_id = get_option("mailchimp_list_id");
		if(isset($_POST['billing_email']) && $api_key && $list_id){
			$email = $_POST['billing_email'];
			$first_name = (isset($_POST['billing_first_name'])) ? $_POST['billing_first_name'] : "";
			$last_name = (isset($_POST['billing_last_name'])) ? $_POST['billing_last_name'] : "";

			$this->add_user_to_list($api_key,$list_id,$email,$first_name,$last_name);
		}
	}

	/**
	 * Function to add the user to a list specified for the Shortcode
	 *
	 * @param array  $attributes
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	function shortcode_add_user_to_list($attributes = array() , $content = ""){
		$atts = shortcode_atts($defaults = array(
			'name_fields'=>false,
			'id'=>'mailchimp-form'
		),$attributes);

		// Enqueue Javascript File
		wp_enqueue_script('mailchimp-signup-js');

		ob_start();
		?>
		<div class="mailchimp-signup-widget">
			<form class="<?php echo $atts['id']; ?> mailchimp-signup" id="<?php echo $atts['id']; ?>" action="<?php echo admin_url('admin-ajax.php'); ?>" data-positive="<?php echo htmlspecialchars(get_option("mailchimp_widget_result_success")); ?>" data-negative="<?php echo htmlspecialchars(get_option("mailchimp_widget_result_failed")); ?>" data-email_incorrect="<?php echo htmlspecialchars(get_option("option_shortcode_result_email_wrong")); ?>" method="POST">

				<?php
					$title = get_option("mailchimp_widget_label_title");
					if(!empty($title)){
						?><h3 class="mailchimp-title"><?php echo $title; ?></h3><?php
					}
					$description = get_option("mailchimp_widget_label_description");
					if(!empty($description)){
						?><p class="mailchimp-description"><?php echo $description; ?></p><?php
					}
				?>

				<?php

					if($atts['name_fields']){
						WordPress_MailChimp_OptIn::return_input_field(array(
							'type'=>'text',
							'class'=>'fname',
							'id'=>'mailchimp_fname',
							'placeholder'=>apply_filters('mailchimp_optin_name_placeholder','Name')
						));
					}

					WordPress_MailChimp_OptIn::return_input_field(array(
						'type'=>'email',
						'class'=>'email',
						'placeholder'=>apply_filters('mailchimp_optin_email_placeholder','Email'),
						'id'=>'mailchimp_email'
					));

					WordPress_MailChimp_OptIn::return_input_field(array(
						'type'=>'submit',
						'value'=>apply_filters('mailchimp_optin_button_value','Sign Up'),
						'class'=>apply_filters('mailchimp_optin_button_class','button')
					));

					if(isset($_GET['action'])){
						switch($_GET['action']){
							case 'subscribed':
								echo '<div id="result" class="success">'.get_option("mailchimp_widget_result_success").'</div>';
								break;
							case 'failed':
								echo '<div id="result" class="failed">'.get_option("mailchimp_widget_result_failed").'</div>';
								break;
						}
					}else {
						echo '<div id="result" style="display: none;"></div>';
					}

				?>

				<style>
					.mailchimp-signup #result {
						margin-top:15px;
						color:white;
						padding:15px;
						text-align: center;
					}

					.mailchimp-signup #result.success {
						background:#4BBA59;
					}

					.mailchimp-signup #result.failed {
						background:#D75050;
					}
				</style>
			</form>
		</div>
		<?php
		return ob_get_clean();
	}


	/**
	 * Function to add user to MailChimp list by API key and list ID
	 *
	 * @param string $api_key
	 * @param string $list_id
	 * @param string $email
	 * @param string $first_name
	 * @param string $last_name
	 *
	 * @return object result
	 */
	function add_user_to_list($api_key,$list_id,$email,$first_name = "",$last_name = ""){
		include(__DIR__.'/includes/MailChimp.php');

		$MailChimp = new \Drewm\MailChimp($api_key);
		$result = $MailChimp->call('lists/subscribe',array(
			'id'=>$list_id,
			'email'=>array(
				'email'=>sanitize_text_field($email)
			),
			'merge_vars'=>array(
				'FNAME'=>sanitize_text_field($first_name),
				'LNAME'=>sanitize_text_field($last_name)
			),
			'update_existing'=>true,
			'send_welcome'=>false,
			'double_optin'=>false
		));

		return $result;
	}

	/**
	 * Helper function to return an input field based off of passed arguments
	 *
	 * @version 1.2.1
	 *
	 * @param $args Array of arguments to pass for creating an input field.
	 */
	static function return_input_field($args){
		// Set defaults for input fields
		$defaults = array(
			'id'=>'DEFAULT_ID',
			'checked'=>0,
			'type'=>'text',
			'value'=>'',
			'default'=>'',
			'placeholder'=>'',
			'description'=>'',
			'min'=>'0',
			'max'=>'',
			'rows'=>10
		);

		// Merge user supplied into defaults
		$args = array_merge($defaults,$args);

		$id = $args['id'];
		$class = (!empty($args['class'])) ? $args['class'] : 'regular-text ' . $id ;
		$type = $args['type'];
		$value = ($temp_value = $args['value']) ? $temp_value : $args['default'] ;
		$placeholder = $args['placeholder'];
		$rows = $args['rows'];
		$description = $args['description'];
		$min = $args['min'];
		$max = $args['max'];
		$checked = $args['checked'];

		switch($type){
			case 'text':
				?><input type="text" class="<?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id;  ?>"  value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>"/><?php
				break;
			case 'email':
				?><input type="email" class="<?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id;  ?>"  value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>"/><?php
				break;
			case 'textarea':
				?><textarea class="<?php echo $class; ?>" rows="<?php echo $rows; ?>" cols="50" name="<?php echo $id; ?>" id="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>"><?php echo $value; ?></textarea><?php
				break;
			case 'submit':
				?><input type="submit" id="<?php echo $id; ?>" class="<?php echo $class; ?>" value="<?php echo $value; ?>"/><?php
				break;
			case 'checkbox':
				?><input id="<?php echo $id; ?>" name="<?php echo $id; ?>" type="checkbox" value="<?php echo (!empty($value)) ? $value : 1 ; ?>" <?php checked($value,$checked); ?>/><?php
				break;
			case 'number':
				?><input type="number" class=" <?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id;  ?>"  value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>" min="<?php echo $min; ?>" <?php if(!empty($max)):?> max="<?php echo $max; ?>" <?php endif; ?>  /><?php
				break;
			case 'hidden':
				?><input type="hidden" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo $value; ?>" /><?php
				break;
		}

		if(!empty($description)){
			?><p class="description"><?php echo $description; ?></p><?php
		}
	}

}

$wc_mailchimp_optin = new WordPress_MailChimp_OptIn();