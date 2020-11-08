<?php
function wpjam_register_signup($key, $args){
	WPJAM_Signup::register_signup($key, $args);
}

function wpjam_get_signups(){
	return WPJAM_Signup::get_signups();
}

function wpjam_signup_get_setting($setting_name){
	return wpjam_get_setting('wpjam-signup', $setting_name);
}

function wpjam_signup_update_setting($setting, $value){
	return wpjam_update_setting('wpjam-signup', $setting, $value);
}

function wpjam_invite_user($role, $args=[]){
	return WPJAM_Invite::create($role, $args);
}

function wpjam_get_user_openid($user_id=0, $type='weixin'){
	if($type == 'weixin'){
		return WEIXIN_Signup::get_user_openid($user_id);	
	}elseif($type == 'weapp'){
		return WEAPP_Signup::get_user_openid($user_id);	
	}
}

function wpjam_get_user_by_openid($openid, $type='weixin'){
	if($type == 'weixin'){
		return WEIXIN_Signup::get_user_by_openid($openid);	
	}elseif($type == 'weapp'){
		return WEAPP_Signup::get_user_by_openid($openid);	
	}
}

function wpjam_get_login_actions($type='login'){
	$login_actions = wpjam_get_signups();

	if(empty($login_actions)){
		return [];
	}

	if($type == 'login' || $type == 'bind'){
		foreach ($login_actions as $login_key => $login_action){
			$enable	= wpjam_signup_get_setting($login_key.'_'.$type) ?? $login_action['default'];

			if(!$enable){
				unset($login_actions[$login_key]);
			}
		}
	}elseif($type == 'invite'){
		$login_actions	= wpjam_get_login_actions();
		if(isset($login_actions['weixin'])){
			$login_actions	= wp_array_slice_assoc($login_actions, ['weixin']);
		}else{
			$login_actions	= [];
		}
	}

	return $login_actions;
}

function wpjam_get_bind_actions(){
	return wpjam_get_login_actions('bind');
}

function wpjam_get_invite_actions(){
	return wpjam_get_login_actions('invite');
}

