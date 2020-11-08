<?php
/*
Plugin Name: WPJAM 内容模板
Plugin URI: http://blog.wpjam.com/project/wpjam-content-template/
Description: WordPress 内容模板，通过 shortcode 在内容中插入一段共用的内容模板，支持内容和表格模板。
Version: 2.1
Author: Denis
Author URI: http://blog.wpjam.com/
*/
add_action('plugins_loaded', function(){
	if(wp_installing() || !did_action('wpjam_loaded') || defined('WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR')){
		return;
	}

	define('WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR',	plugin_dir_path(__FILE__));
	
	include WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR . 'public/utils.php';
	include WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR . 'public/hooks.php';
	include WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR . 'public/post-password.php';

	if(is_admin()){
		include WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR . 'admin/hooks/admin-menus.php';

		add_action('wpjam_builtin_page_load', function ($screen_base, $current_screen){
			if($screen_base == 'edit'){
				if($current_screen->post_type == 'template'){
					include WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR .'admin/hooks/template-type.php';
					include WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR .'admin/hooks/template-list.php';
				}
			}elseif($screen_base == 'post'){
				$post_type	= $current_screen->post_type;

				if($post_type == 'template'){
					include WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR .'admin/hooks/template-type.php';
					include WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR .'admin/hooks/template.php';
				}elseif($post_type != 'attachment'){
					include WPJAM_CONTENT_TEMPLATE_PLUGIN_DIR .'admin/hooks/button.php';
				}
			}
		}, 1, 2);
	}
});
