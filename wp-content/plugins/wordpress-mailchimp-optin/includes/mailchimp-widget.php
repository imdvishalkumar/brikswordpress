<?php
/**
 * Created by PhpStorm.
 * User: logan.graham
 * Date: 5/8/2015
 * Time: 10:03
 */

if ( ! defined( 'ABSPATH' ) )  {
	exit; // Exit if accessed directly
}

class MailChimp_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'wordpress_mailchimp_optin', 'Wordpress MailChimp Optin' );
	}

	public function widget( $args, $instance ) {
		echo $args["before_widget"];
		global $wc_mailchimp_optin;
		if(isset($wc_mailchimp_optin)){
			echo $wc_mailchimp_optin->shortcode_add_user_to_list(array(
				'name_fields'=> $instance['include_name']
			));
		}
		echo $args["after_widget"];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		//$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '1';
		$instance['include_name'] = isset( $new_instance['include_name'] ) ? 1 : 0 ;
		return $instance;
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'MailChimp Optin', 'text_domain' );
		$include_name = isset( $instance['include_name'] ) ? (bool) $instance['include_name'] : false ;
		?>
		<!--<p>
			<label for="<?php /*echo $this->get_field_id( 'title' ); */?>"><?php /*_e( 'Title:' ); */?></label>
			<input class="widefat" id="<?php /*echo $this->get_field_id( 'title' ); */?>" name="<?php /*echo $this->get_field_name( 'title' ); */?>" type="text" value="<?php /*echo esc_attr( $title ); */?>">
		</p>-->
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'include_name' ); ?>" name="<?php echo $this->get_field_name( 'include_name' ); ?>" type="checkbox" value="<?php echo esc_attr( $include_name ); ?>" <?php checked($include_name); ?>>
			<label for="<?php echo $this->get_field_id( 'include_name' ); ?>"><?php _e( 'Include Name Field' ); ?></label>
		</p>
	<?php
	}
}