<?php
/*
Plugin Name: WPJAM 用户管理
Plugin URI: http://blog.wpjam.com/project/wpjam-user/
Description: 用户管理，支持自定义头像，屏蔽个人设置，屏蔽姓名设置，隐藏登录名，限制登陆失败次数，防止密码被暴力破解等功能。
Version: 2.1
Author: Denis
Author URI: http://blog.wpjam.com/
*/
add_action('plugins_loaded', function(){
	if(wp_installing() || !did_action('wpjam_loaded') || defined('WPJAM_USER_PLUGIN_DIR')){
		return;
	}

	define('WPJAM_USER_PLUGIN_DIR', plugin_dir_path(__FILE__));

	include WPJAM_USER_PLUGIN_DIR.'public/user.php';
	include WPJAM_USER_PLUGIN_DIR.'public/login.php';
	include WPJAM_USER_PLUGIN_DIR.'public/query.php';

	if(is_admin()){
		include WPJAM_USER_PLUGIN_DIR.'admin/hooks.php';
		include WPJAM_USER_PLUGIN_DIR.'admin/admin-menus.php';

		add_action('wpjam_builtin_page_load', function ($screen_base){
			if($screen_base == 'users'){
				include WPJAM_USER_PLUGIN_DIR.'admin/users.php';
			}elseif(in_array($screen_base, ['user-edit', 'profile'])){
				include WPJAM_USER_PLUGIN_DIR.'admin/user-edit.php';
			}
		});
	}
});
