<?php
/*
Plugin Name: WPJAM 评论增强
Plugin URI: http://blog.wpjam.com/project/wpjam-comment/
Description: 1. 评论点赞，2. 评论置顶，3. 评论点赞排序。
Version: 2.0
Author: Denis
Author URI: http://blog.wpjam.com/
*/

add_action('plugins_loaded', function(){
	if(wp_installing() || !did_action('wpjam_loaded') || defined('WPJAM_COMMENT_PLUGIN_DIR')){
		return;
	}

	define('WPJAM_COMMENT_PLUGIN_DIR', plugin_dir_path(__FILE__));

	include WPJAM_COMMENT_PLUGIN_DIR . '/public/class.php';
	include WPJAM_COMMENT_PLUGIN_DIR . '/public/hooks.php';
	include WPJAM_COMMENT_PLUGIN_DIR . '/public/apis.php';
	include WPJAM_COMMENT_PLUGIN_DIR . '/public/ajax.php';

	add_action('wpjam_credit_loaded', function(){
		include WPJAM_COMMENT_PLUGIN_DIR . '/public/credit.php';
	});

	if(is_admin()){
		include WPJAM_COMMENT_PLUGIN_DIR . '/admin/admin-menus.php';
		include WPJAM_COMMENT_PLUGIN_DIR . '/admin/hooks.php';

		add_action('wpjam_builtin_page_load', function ($screen_base){
			if($screen_base == 'edit-comments'){
				include WPJAM_COMMENT_PLUGIN_DIR . '/admin/comment.list.php';
			}
		});
	}
});

		