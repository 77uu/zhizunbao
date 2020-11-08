<?php
/*
Plugin Name: WPJAM 分类管理
Plugin URI: https://blog.wpjam.com/project/wpjam-taxonomy-levels/
Description: 层式管理分类和分类拖动排序，支持设置分类的层级，并且在 WordPress 后台分类管理界面可以按层级显示和拖动排序。
Version: 3.1
Author: Denis
Author URI: http://blog.wpjam.com/
*/
add_action('plugins_loaded', function(){
	if(wp_installing() || !did_action('wpjam_loaded') || defined('WPJAM_TAXONOMY_PLUGIN_DIR')){
		return;
	}

	define('WPJAM_TAXONOMY_PLUGIN_DIR', plugin_dir_path(__FILE__));
	define('WPJAM_TAXONOMY_LEVELS_PLUGIN_DIR', WPJAM_TAXONOMY_PLUGIN_DIR);

	include WPJAM_TAXONOMY_PLUGIN_DIR.'public/utils.php';
	include WPJAM_TAXONOMY_PLUGIN_DIR.'public/hooks.php';

	if(is_admin()){
		include WPJAM_TAXONOMY_PLUGIN_DIR.'admin/admin.php';
	}
});
