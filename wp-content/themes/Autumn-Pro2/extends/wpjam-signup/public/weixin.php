<?php
if(wp_is_mobile() && !is_weixin() && !is_weapp()){
	return;
}

if(is_multisite()){
	if(!defined('WEIXIN_ROBOT_PLUGIN_DIR') && is_dir(WP_PLUGIN_DIR.'/weixin-robot-advanced/')){
		define('WEIXIN_ROBOT_PLUGIN_DIR',	WP_PLUGIN_DIR . '/weixin-robot-advanced/');

		include WEIXIN_ROBOT_PLUGIN_DIR . 'public/utils.php';
		include WEIXIN_ROBOT_PLUGIN_DIR . 'includes/class-weixin-setting.php';
		include WEIXIN_ROBOT_PLUGIN_DIR . 'includes/class-weixin.php';
		include WEIXIN_ROBOT_PLUGIN_DIR . 'includes/trait-weixin.php';
		include WEIXIN_ROBOT_PLUGIN_DIR . 'includes/class-weixin-user.php';
	}
}

if(!defined('WEIXIN_ROBOT_PLUGIN_DIR')){
	return;
}

include WPJAM_SIGNUP_PLUGIN_DIR . 'includes/class-weixin-signup.php';

$weixin_appid	= '';

if(is_multisite()){
	$bind_blog_id	= WEIXIN_Signup::get_bind_blog_id();

	if(!$bind_blog_id){
		return;
	}

	if($weixin_settings	= WEIXIN_Setting::get_by('blog_id', $bind_blog_id)){
		$weixin_appid	= $weixin_settings[0]['appid'];

		WEIXIN_Signup::set_appid($weixin_appid);
	}
}else{
	if($weixin_appid = weixin_get_appid()){
		WEIXIN_Signup::set_appid($weixin_appid);
	}
}

if(empty($weixin_appid)){
	return;
}

if(weixin_get_type($weixin_appid) < 4){
	return;
}

wpjam_register_signup('weixin', [
	'title'			=>'微信公众号',
	'model'			=>'WEIXIN_Signup',
	'login_title'	=>'微信公众号扫码登录',
	'default'		=>true
]);

function weixin_signup($openid, $args=[]){
	return WEIXIN_Signup::signup($openid, $args);
}

function wexin_ajax_qrcode_signup(){
	$args	= [];

	if(wpjam_get_invite_actions()){
		$invite_key	= $_REQUEST['invite_key'] ?? '';

		if($invite_key){
			$invite	= WPJAM_Invite::validate($invite_key);

			if(is_wp_error($invite)){
				wpjam_send_json($invite);
			}elseif($invite){
				$args['invite']				= $invite_key;
				$args['role']				= $invite['role'];
				$args['blog_id']			= $invite['blog_id'] ?? 0;
				$args['users_can_register']	= true;
			}
		}
	}

	$result	= WEIXIN_Signup::qrcode_signup($_POST['scene'], $_POST['code'], $args);

	if(is_wp_error($result)){
		wpjam_send_json($result);
	}else{
		wpjam_send_json();
	}
}

add_action('wp_ajax_nopriv_weixin-qrcode-signup', 'wexin_ajax_qrcode_signup');
add_action('wp_ajax_weixin-qrcode-signup', 'wexin_ajax_qrcode_signup');

add_action('wp_ajax_weixin-qrcode-bind', function(){
	$openid		= WEIXIN_Signup::verify_qrcode($_POST['scene'], $_POST['code']);	

	if(is_wp_error($openid)){
		wpjam_send_json($openid);
	}

	$user_id = get_current_user_id();
	$user    = WEIXIN_Signup::bind($user_id, $openid);

	if(is_wp_error($user)){
		wpjam_send_json($user);
	}else{
		wpjam_send_json();
	}
});

add_action('wp_ajax_weixin-unbind', function(){
	$user_id	= get_current_user_id();
	$openid		= WEIXIN_Signup::get_user_openid($user_id);

	if(!$openid){
		$openid	= WEIXIN_Signup::get_openid_by_user_id($user_id);
	}

	WEIXIN_Signup::unbind($user_id, $openid);
	
	wpjam_send_json();
});

if(WEIXIN_Signup::is_bind_blog()){
	add_action('wpjam_api_template_redirect', function ($json){
		if(in_array($json, [ 'weixin.qrcode.create', 'weixin.qrcode.verify'])){
			include WPJAM_SIGNUP_PLUGIN_DIR . 'api/'.$json.'.php'; 
			exit;
		}
	});

	add_filter('weixin_builtin_reply', function ($builtin_replies){
		$builtin_replies['subscribe']	= ['type'=>'full',	'reply'=>'未关注扫码回复',	'function'=>['WEIXIN_Signup','subscribe_reply']];
		$builtin_replies['scan']		= ['type'=>'full',	'reply'=>'已关注扫码回复',	'function'=>['WEIXIN_Signup','scan_reply']];
		
		return $builtin_replies;
	});
}

// add_action('wpjam_message', function($data){

// 	if($weixin_openid	= get_user_meta($data['receiver'], WEIXIN_BIND_META_KEY, true)){
// 		$send_user = get_userdata($data['sender']);

// 		include_once(WPJAM_BASIC_PLUGIN_DIR.'include/class-weixin.php');
// 		weixin()->send_custom_message($weixin_openid, $send_user->display_name."给你发送了一条消息：\n\n".$data['content']);
// 	}
// });