<?php
global $plugin_page;

add_filter(wpjam_get_filter_name($plugin_page, 'tabs'), function($tabs){
	$tabs['aliyun']	= ['title'=>'阿里云短信通知',	'function'=>'option',	'option_name'=>'wpjam_aliyun_sms',	'tab_file'=>__DIR__.'/setting.php'];
	return $tabs;
});