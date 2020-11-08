<?php
wp_cache_add_global_groups(['wpjam_signup']);

if(is_multisite()){
	add_filter('pre_option_users_can_register', 'users_can_register_signup_filter');
}

add_action('wpjam_api_template_redirect', function ($json){
	if(in_array($json, ['user.signup', 'user.logout'])){
		include WPJAM_SIGNUP_PLUGIN_DIR . 'api/'.$json.'.php'; 
		exit;
	}
});

add_filter('weixin_bind_blog_id', function($blog_id){
	if(is_null($blog_id)){
		$signup_setting	= get_site_option('wpjam-signup');

		if($signup_setting && !empty($signup_setting['blog_id'])){
			return $signup_setting['blog_id'];
		}
	}

	return $blog_id;
}, 999);

add_filter('weapp_query_unionid', function($status){
	return wpjam_signup_get_setting('weapp_unionid');
});