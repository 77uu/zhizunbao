<?php
if(!wpjam_get_user_setting('limit_login_attempts')){
	return;
}

wp_cache_add_global_groups(['wpjam_login_limit']);

class WPJAM_LoginLimit{
	public static function incresement($key=''){
		$key	= $key ?: wpjam_get_ip();
		$times	= self::get_times($key);

		wp_cache_set($key, $times+1, 'wpjam_login_limit', MINUTE_IN_SECONDS*15);
	}

	public static function get_times($key=''){
		$key	= $key ?: wpjam_get_ip();
		$times	= wp_cache_get($key, 'wpjam_login_limit');
		
		return $times ?: 0;
	}

	public static function is_over($key=''){
		$max	= $key ? 3 : 10;
		$times	= self::get_times($key);

		if($times > $max){
			return new WP_Error('too_many_retries', '你已尝试多次失败登录，请15分钟后重试！');
		}

		if($key){
			return self::is_over();
		}else{
			return false;
		}
	}
}

add_filter('shake_error_codes', function ($error_codes){
	return array_merge($error_codes, ['too_many_retries']);
});

add_filter('wp_login_errors', function($errors){
	$error_code	= $errors->get_error_code();

	if($error_code){
		if(in_array($error_code, ['invalid_username', 'invalid_email', 'incorrect_password'])){
			$errors->remove($error_code);
			$errors->add($error_code, '用户名或者密码错误。');
		}
	}else{
		$over_limit	= WPJAM_LoginLimit::is_over();

		if($over_limit && is_wp_error($over_limit)){
			$errors	= $over_limit;
		}
	}

	return $errors;
});

function wpjam_pre_user_signup($user, $key){
	$over_limit	= WPJAM_LoginLimit::is_over($key);

	if($over_limit && is_wp_error($over_limit)){
		remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);
		remove_filter('authenticate', 'wp_authenticate_email_password', 20, 3);
		return $over_limit;
	}

	return $user;
}

add_filter('wpjam_qrcode_signup',	'wpjam_pre_user_signup', 10, 2);
add_filter('wpjam_sms_signup', 		'wpjam_pre_user_signup', 10, 2);
add_filter('authenticate', 			'wpjam_pre_user_signup', 1, 2);

add_filter('authenticate', function($user, $username){
	if(is_wp_error($user) && $user->get_error_code() == 'incorrect_password'){
		WPJAM_LoginLimit::incresement($username);
	}

	return $user;
}, 99999, 2);

add_action('wp_login_failed', function($username){
	WPJAM_LoginLimit::incresement();
});

add_action('wpjam_sms_signup_failed', function($phone){
	WPJAM_LoginLimit::incresement();
});

add_action('wpjam_qrcode_signup_failed', function($scene){
	WPJAM_LoginLimit::incresement($scene);
	WPJAM_LoginLimit::incresement();
});





