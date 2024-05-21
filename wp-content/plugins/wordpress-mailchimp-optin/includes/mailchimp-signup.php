<?php
/**
 * Created by PhpStorm.
 * User: logan.graham
 * Date: 3/20/2015
 * Time: 10:53
 */


include(substr(getcwd(),0,strpos(getcwd(),'wp-content')).'wp-load.php');

$nonce = (isset($_POST["_wpnonce"])) ? $_POST["_wpnonce"] : "" ;
$ajax = isset($_POST['ajax']);

if( ! wp_verify_nonce($nonce,'mailchimp-signup') ){
	echo "false";

	if(!$ajax){
		wp_redirect(home_url());
	}else {
		exit();
	}
}

$fname = (isset($_POST["mailchimp_fname"])) ? $_POST["mailchimp_fname"] : "" ;
$lname = (isset($_POST["mailchimp_lname"])) ? $_POST["mailchimp_lname"] : "" ;
$email = (isset($_POST["mailchimp_email"])) ? $_POST["mailchimp_email"] : "" ;

if(isset($wc_mailchimp_optin)){
	$result = $wc_mailchimp_optin->add_user_to_list(
		get_option($wc_mailchimp_optin->option_shortcode_api_key),
		get_option($wc_mailchimp_optin->option_shortcode_list_id),
		$email,
		$fname,
		$lname
	);

	if( !isset($result['status']) ) {
		if(!$ajax){
			wp_redirect(home_url('?action=subscribed'));
		}else {
			echo "true";
		}
	}elseif( $result['status'] == 'error' ) {
		if(!$ajax){
			wp_redirect(home_url('?action=failed'));
		}else {
			echo "false";
		}
	}

}

