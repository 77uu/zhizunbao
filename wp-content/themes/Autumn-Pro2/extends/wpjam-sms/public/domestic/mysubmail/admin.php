<?php
global $plugin_page;

add_filter(wpjam_get_filter_name($plugin_page, 'tabs'), function($tabs){
	$tabs['mysubmail']	= ['title'=>'赛邮·云通信',	'function'=>'option',	'option_name'=>'wpjam_mysubmail',	'tab_file'=>__DIR__.'/setting.php'];
	return $tabs;
});