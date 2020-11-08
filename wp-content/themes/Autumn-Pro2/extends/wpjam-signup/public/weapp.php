<?php
if(wp_is_mobile() && !is_weixin() && !is_weapp()){
	return;
}

if(!defined('WEAPP_PLUGIN_DIR')){
	return;
}

include WPJAM_SIGNUP_PLUGIN_DIR . 'includes/class-weapp-signup.php';

if(!WEAPP_Signup::get_bind_page()){
	return;
}

$weapp_appid	= '';

if(is_multisite()){
	if($weapp_settings	= WEAPP_Setting::get_by('blog_id', get_current_blog_id())){
		$weapp_appid	= $weapp_settings[0]['appid'];

		WEAPP_Signup::set_appid($weapp_appid);
	}
}else{
	if($weapp_appid = weapp_get_appid()){
		WEAPP_Signup::set_appid($weapp_appid);
	}
}

if(empty($weapp_appid)){
	return;
}

wpjam_register_signup('weapp', [
	'title'			=>'微信小程序',	
	'model'			=>'WEAPP_Signup',
	'login_title'	=>'微信小程序扫码登录',
	'default'		=>false
]);

function weapp_signup($openid, $args=[]){
	return WEAPP_Signup::signup($openid, $args);
}

function weapp_ajax_qrcode_signup(){
	$result	= WEAPP_Signup::qrcode_signup($_POST['scene'], $_POST['code']);

	if(is_wp_error($result)){
		wpjam_send_json($result);
	}else{
		wpjam_send_json();
	}
}

add_action('wp_ajax_nopriv_weapp-qrcode-signup', 'weapp_ajax_qrcode_signup');
add_action('wp_ajax_weapp-qrcode-signup', 'weapp_ajax_qrcode_signup');

add_action('wp_ajax_weapp-qrcode-bind', function(){
	$openid		= WEAPP_Signup::verify_qrcode($_POST['scene'], $_POST['code']);	

	if(is_wp_error($openid)){
		wpjam_send_json($openid);
	}

	 $user_id = get_current_user_id();
	 $user    = WEAPP_Signup::bind($user_id, $openid);

	 if(is_wp_error($user)){
	 	wpjam_send_json($user);
	 }else{
	 	wpjam_send_json();
	 }
});

add_action('wp_ajax_weapp-unbind', function(){
	$user_id	= get_current_user_id();
	$openid		= WEAPP_Signup::get_user_openid($user_id);

	if(!$openid){
		$openid	= WEAPP_Signup::get_openid_by_user_id($user_id);
	}

	WEAPP_Signup::unbind($user_id, $openid);
	
	wpjam_send_json();
});

add_action('wpjam_api_template_redirect', function ($json){
	if(in_array($json, ['weapp.qrcode.bind', 'weapp.qrcode.code'])){
		include WPJAM_SIGNUP_PLUGIN_DIR . 'api/'.$json.'.php'; 
		exit;
	}
});