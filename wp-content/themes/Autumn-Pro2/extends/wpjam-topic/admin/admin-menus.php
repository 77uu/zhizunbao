<?php
add_filter('wpjam_pages', function ($wpjam_pages){
	if(!wpjam_get_topic_blog_id()){
		return $wpjam_pages;
	}
	
	$subs	= [];

	$subs['wpjam-topics']	= [
		'menu_title'	=> '讨论',
		'function'		=> 'list', 
		'capability'	=> 'read',
		'page_file'		=> WPJAM_TOPIC_PLUGIN_DIR.'admin/topics.php'
	];

	$subs['wpjam-groups']	= [
		'menu_title'	=> '分组',
		'function'		=> 'list', 
		'capability'	=> is_multisite() ? 'manage_sites' : 'manage_options',
		'page_file'		=> WPJAM_TOPIC_PLUGIN_DIR.'admin/groups.php'
	];

	$subs['wpjam-topic-messages']	= [
		'menu_title'	=> '消息',
		'capability'	=> 'read',
		'function'		=> 'wpjam_messages_page',
		'page_file'		=> WPJAM_BASIC_PLUGIN_DIR.'admin/pages/wpjam-messages.php'
	];

	if(wpjam_is_topic_blog()){
		$subs['wpjam-topic-setting']	= [
			'menu_title'	=> '设置',
			'page_file'		=> WPJAM_TOPIC_PLUGIN_DIR.'admin/setting.php'
		];
	}

	$wpjam_pages['wpjam-topics']	= [
		'menu_title'	=> '讨论组',
		'function'		=> 'list', 
		'icon'			=> 'dashicons-format-chat',
		'position'		=> '59.9999',
		'capability'	=> 'read',
		'subs'			=> $subs
	];

	return $wpjam_pages;
});
