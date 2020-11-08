<?php
add_action('init', function(){
	if(!function_exists('wpjam_register_signup')){
		return;
	}

	if(!wpjam_sms_get_setting('sms_provider')){
		return;
	}

	include WPJAM_SMS_PLUGIN_DIR . 'includes/class-user-phone.php';
	include WPJAM_SMS_PLUGIN_DIR . 'includes/class-sms-signup.php';

	wpjam_register_signup('sms', [
		'title'			=>'手机号码',	
		'login_title'	=>'手机短信验证码登录',	
		'model'			=>'SMS_Signup',	
		'default'		=>false
	]);

	add_action('pre_update_option_wpjam-signup', function($value){
		WPJAM_UserPhone::create_table();
		return $value;
	});
});

function sms_signup($phone, $code, $args=[]){
	return SMS_Signup::code_signup($phone, $code, $args);
}

function wpjam_ajax_send_sms(){
	$result	= wpjam_send_sms($_POST['phone']);

	if(is_wp_error($result)){
		wpjam_send_json($result);
	}else{
		wpjam_send_json();
	}
}

function wpjam_ajax_sms_signup(){
	$user	= sms_signup($_POST['phone'], $_POST['code']);

	if(is_wp_error($user)){
		wpjam_send_json($user);
	}else{
		wpjam_send_json();
	}
}

add_action('wp_ajax_nopriv_send-sms', 'wpjam_ajax_send_sms');
add_action('wp_ajax_send-sms', 'wpjam_ajax_send_sms');

add_action('wp_ajax_nopriv_sms-signup', 'wpjam_ajax_sms_signup');
add_action('wp_ajax_sms-signup', 'wpjam_ajax_sms_signup');

add_action('wp_ajax_sms-bind', function(){
	$user_id	= get_current_user_id();

	$result		= wpjam_verify_sms($_POST['phone'], $_POST['code']);

	if(is_wp_error($result)){
		wpjam_send_json($result);
	}
			
	$user	= SMS_Signup::bind($user_id, $_POST['phone']);

	if(is_wp_error($result)){
		wpjam_send_json($user);
	}else{
		wpjam_send_json();
	}
});

add_action('wp_ajax_sms-unbind', function(){
	$user_id	= get_current_user_id();
	$openid		= SMS_Signup::get_user_openid($user_id);

	if(!$openid){
		$openid	= SMS_Signup::get_openid_by_user_id($user_id);
	}

	SMS_Signup::unbind($user_id, $openid);
	
	wpjam_send_json();
});



