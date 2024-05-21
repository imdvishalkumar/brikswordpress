<?php

/*
	Plugin Name: Kwikturn Media Social Tags
	Plugin URI: http://kwikturnmedia.com
	Description: Adds the necessary meta tags for Pinterest's Rich Pins, Twitter Cards, and more.
	Version: 1.0.2
	Author: Kwikturn Media
	Author URI: http://kwikturnmedia.com
*/

class WP_Social_Tags {
	var $menuPageName = "social-options";

	public function __construct(){
		
		// Add the social tags to the WordPress <head>
		add_action('wp_head',array($this,'add_social_tags'));

		// Register Settings for website
		add_action("admin_init",array($this,"register_settings"));

		// Override Yoast's og:type meta tag
		add_action('wp_loaded',function(){
			add_action("wpseo_opengraph_type",function($type){
				if(function_exists("is_product") && is_product()){
					$type = "product";
				}
				return $type;
			});
		});

		// Add options page to the back-end.
		add_action("admin_menu",function(){
			add_options_page("Social Options","Social Options","edit_posts",$this->menuPageName,array($this,"add_options_page"));
		});

		// Add action for Wordpress Footer
		add_action("wp_footer",array($this,"add_foot_fields"));

	}

	function register_settings(){
		// Add Sections and fields for each section
		add_settings_section("social_settings","Social Settings",function(){
			// Twitter Website Username
			add_settings_field("twitter_site_username","Twitter Website Username",function(){
				echo '@ <input type="text" name="twitter_site_username" id="twitter_site_username" value="'.get_option("twitter_site_username").'" class="regular-text" />';
			},$this->menuPageName,"social_settings");
			// Pinterest Verify
			add_settings_field("pinterest_domain_verify","Pinterest Domain Verify",function(){
				echo '<input type="text" name="pinterest_domain_verify" id="pinterest_domain_verify" value="'.get_option("pinterest_domain_verify").'" class="regular-text" />
				<p>Place only the "content" of the p:domain_verify link provided by Pinterest.</p>';
			},$this->menuPageName,"social_settings");
		},$this->menuPageName);


		//'Additional Fields' Section
		add_settings_section("wp_additional_fields","Additional Fields (for scripts & verification tags)",function(){
			// TextArea for adfditional Header fields
			add_settings_field("head_addi_field","WP Head Additional Fields",function(){
				echo '<textarea name="head_addi_field" id="head_addi_field" class="large-text code">'.get_option("head_addi_field").'</textarea>';
				echo '<p>You can use this field to place meta tags and other required tags in the "head" section of the site. Please use the "WP Footer" fields below for added scripts to prevent page speed impact.</p>';
			},$this->menuPageName,"wp_additional_fields");
			// TextArea for additional footer fields
			add_settings_field("foot_addi_field","WP Footer Additional Fields",function(){
				echo '<textarea name="foot_addi_field" id="foot_addi_field" class="large-text code">'.get_option("foot_addi_field").'</textarea>';
			},$this->menuPageName,"wp_additional_fields");
		},$this->menuPageName);

		register_setting($this->menuPageName,"twitter_site_username");
		register_setting($this->menuPageName,"pinterest_domain_verify");
		register_setting($this->menuPageName,"head_addi_field");
		register_setting($this->menuPageName,"foot_addi_field");
	}

	function add_social_tags(){
		$this->add_og_tags();
		$this->add_twitter_tags();
		$this->add_head_fields();
		$this->add_pinterest_tags();
	}

	function add_head_fields(){
		echo get_option("head_addi_field");
	}

	function add_foot_fields(){
		echo get_option("foot_addi_field");
	}

	function add_og_tags(){
		// Define type for og:type fallback
		$type = "";
		if(function_exists("is_product") && is_product()){
			$type = "product";
		}elseif(is_page() || is_single()){
			$type = "article";
		}

		// See if it is a product and output the correct tags
		if(function_exists('is_product') && is_product()):
			if(function_exists("wc_get_product")){
				$product = wc_get_product();
			}else {
				$product = get_product();
			}

			$currency = get_option("woocommerce_currency");

			?>
			<meta property="og:price:amount" content="<?php echo $product->get_price(); ?>" />
			<meta property="og:price:currency" content="<?php echo $currency; ?>" />
		<?php endif;
		if(!has_action("wpseo_opengraph_type")): ?>
			<meta property="og:type" content="<?php echo $type; ?>"/>
		<?php endif;
	}


	function add_twitter_tags(){
		$twitterSiteUsername = get_option("twitter_site_username");
		// one of the following: summary,summary_large_image,photo,gallery,product,app,player

		$cardType = "summary";
		if(function_exists('is_product') && is_product()){
			$cardType = "product";
		}elseif(is_single() && has_post_thumbnail()){
			$cardType = "summary_large_image";
		}

		ob_start();
		?>
		<meta name="twitter:card" content="<?php echo $cardType; ?>" />
		<?php if(!empty($twitterSiteUsername)): ?>
			<meta name="twitter:site" content="<?php echo $twitterSiteUsername; ?>" />
			<meta name="twitter:creator" content="<?php echo $twitterSiteUsername ?>" />
		<?php endif; ?>
		<?php if($cardType == "product"):
			if(function_exists("wc_get_product")){
				$product = wc_get_product();
			}else {
				$product = get_product();
			}
			?>
			<meta name="twitter:label1" content="Description">
			<meta name="twitter:data1" content="<?php echo strip_tags(esc_attr(substr(get_the_excerpt(),0,150))); ?>...">
			<meta name="twitter:label2" content="Price">
			<meta name="twitter:data2" content="<?php echo get_woocommerce_currency_symbol().number_format($product->get_price(),2); ?>">
		<?php
		endif;
		echo ob_get_clean();
	}

	function add_pinterest_tags(){
		$pinDomainVerify = get_option("pinterest_domain_verify");
		if(!empty($pinDomainVerify)): ?>
			<meta name="p:domain_verify" content="<?php echo $pinDomainVerify; ?>"/>
		<?php endif;
	}

	function add_options_page(){
		?>
		<form method="POST" action="options.php">
			<?php
			settings_fields($this->menuPageName);
			do_settings_sections($this->menuPageName);
			?>
			<?php submit_button(); ?>
		</form>
		<?php
	}
}

$wpSocialTags = new WP_Social_Tags();

