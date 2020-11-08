<?php
/*
Plugin Name: 文章快速复制
Plugin URI: http://blog.wpjam.com/project/wpjam-basic/
Description: 在后台文章列表，添加一个快速复制按钮，点击可快复制一篇草稿用于新建。
Version: 1.0
*/
if(is_admin()){
	add_action('wpjam_builtin_page_load', function($screen_base){
		if($screen_base != 'edit'){
			return;
		}

		wpjam_register_list_table_action('quick_duplicate', [
			'title'		=> '快速复制',	
			'response'	=> 'add',
			'direct'	=> true,
			'callback'	=> ['WPJAM_Post', 'duplicate']
		]);
	});
}