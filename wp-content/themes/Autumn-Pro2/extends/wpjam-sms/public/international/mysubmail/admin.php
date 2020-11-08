<?php
global $plugin_page;

add_filter(wpjam_get_filter_name($plugin_page, 'tabs'), function($tabs){
	$tabs['international-submail']	= ['title'=>'国际赛邮·云通信',	'function'=>'option',	'option_name'=>'wpjam_international_submail',	'tab_file'=>__DIR__.'/setting.php'];
	return $tabs;
});