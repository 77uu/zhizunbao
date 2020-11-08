<?php
add_filter('wpjam_pages', function ($wpjam_pages){
	$wpjam_pages['users']['subs']['wpjam-sms']	= [
		'menu_title'	=> '短信设置',
		'function'		=> 'tab', 
		'tabs'			=> ['sms'=>['title'=>'短信设置',	'function'=>'option',	'option_name'=>'wpjam-signup',	'tab_file'=>__DIR__.'/setting.php']],
		'page_file'		=> __DIR__.'/sms.php'
	];

	return $wpjam_pages;
},12);