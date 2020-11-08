<?php
add_filter('wpjam_pages', function ($wpjam_pages){
	if(wpjam_get_signups()){
		if(wpjam_get_bind_actions()){
			$wpjam_pages['users']['subs']['wpjam-bind']	= [
				'menu_title'	=> '账号绑定',			
				'capability'	=> 'read',
				'function'		=> 'tab',
				'page_file'		=> WPJAM_SIGNUP_PLUGIN_DIR.'admin/pages/wpjam-bind.php'
			];
		}

		if(wpjam_get_invite_actions()){
			$wpjam_pages['users']['subs']['wpjam-invite']	= [
				'menu_title'	=> '邀请用户',
				'page_file'		=> WPJAM_SIGNUP_PLUGIN_DIR.'admin/pages/wpjam-invite.php'
			];
		}

		if(isset($_GET['check'])){
			$wpjam_pages['users']['subs']['wpjam-signup']	= [
				'menu_title'	=> '绑定检查',
				'function'		=> 'tab',
				'capability'	=> is_multisite() ? 'manage_sites' : 'manage_options',
				'page_file'		=> WPJAM_SIGNUP_PLUGIN_DIR.'admin/pages/wpjam-check.php'
			];
		}else{
			$wpjam_pages['users']['subs']['wpjam-signup']	= [
				'menu_title'	=> '登录设置',
				'function'		=> 'option', 
				'option_name'	=> 'wpjam-signup', 
				'page_file'		=> WPJAM_SIGNUP_PLUGIN_DIR.'admin/pages/wpjam-signup.php'
			];
		}
	}

	return $wpjam_pages;
},11);

add_filter('wpjam_network_pages', function ($wpjam_pages){
	$wpjam_pages['users']['subs']['wpjam-signup']	= [
		'menu_title'	=> '登录设置',
		'function'		=> 'option', 
		'option_name'	=> 'wpjam-signup', 
		'page_file'		=> WPJAM_SIGNUP_PLUGIN_DIR.'admin/pages/wpjam-signup.php'
	];

	return $wpjam_pages;
});

add_action('load-user-new.php', function (){
	if(wpjam_get_invite_actions() && !current_user_can('manage_sites')){
		wp_redirect(admin_url('users.php?page=wpjam-invite'));
		exit;
	}
});

add_action('admin_menu',function (){
	if(wpjam_get_invite_actions()){
		if(is_multisite() && !current_user_can('manage_sites')){
			remove_submenu_page('users.php', 'user-new.php');
		}
	}
});

add_action('wpjam_plugin_page_load', function($plugin_page){
	if($plugin_page == 'weapp-users'){
		$wpjam_signups	= wpjam_get_signups();

		if(isset($wpjam_signups['weapp'])){
			include WPJAM_SIGNUP_PLUGIN_DIR.'admin/hooks/weapp-users.php';
		}
	}elseif($plugin_page == 'weixin-users'){
		$wpjam_signups	= wpjam_get_signups();

		if(isset($wpjam_signups['weixin'])){
			include WPJAM_SIGNUP_PLUGIN_DIR.'admin/hooks/weixin-users.php';
		}
	}
});

add_action('wpjam_builtin_page_load', function ($screen_base){
	if(wpjam_get_signups() && $screen_base == 'users'){
		include WPJAM_SIGNUP_PLUGIN_DIR.'admin/hooks/users.php';
	}
});

