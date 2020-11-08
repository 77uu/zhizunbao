<?php
//移除 WPJAM 设置
add_filter('wpjam_basic_setting', function($wpjam_setting){
	global $plugin_page;

	if($plugin_page == 'wpjam-basic'){
		unset($wpjam_setting['sections']['speed']['fields']['excerpt_fieldset']);
	}elseif($plugin_page == 'wpjam-custom'){
		unset($wpjam_setting['sections']['admin-custom']);
		unset($wpjam_setting['sections']['login-custom']);

		$wpjam_setting['sections']['wpjam-custom']['title']	= '';
	}

	return $wpjam_setting;
}, 11);

add_filter('wpjam_cdn_setting', function($wpjam_setting){
	global $plugin_page;

	if($plugin_page == 'wpjam-thumbnail'){
		unset($wpjam_setting['sections']['thumb']['fields']['default']);
		unset($wpjam_setting['sections']['thumb']['fields']['term_thumbnail_set']);
	}

	return $wpjam_setting;
},11);

// 移除 WPJAM 扩展选择
add_filter('wpjam_extends_setting', function($wpjam_setting){
	unset($wpjam_setting['fields']['related-posts.php']);
	unset($wpjam_setting['fields']['wpjam-postviews.php']);
	unset($wpjam_setting['fields']['mobile-theme.php']);

	return $wpjam_setting;
}, 99);