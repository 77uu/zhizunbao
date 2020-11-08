<?php
function wpjam_user_admin_pages($wpjam_pages){
	$wpjam_pages['users']['subs']['wpjam-user-setting']	= [
		'menu_title'	=> '用户设置',
		'function'		=> 'option', 
		'option_name'	=> 'wpjam-avatar', 
		'page_file'		=> WPJAM_USER_PLUGIN_DIR.'admin/setting.php'
	];

	return $wpjam_pages;
}
add_filter('wpjam_pages', 'wpjam_user_admin_pages', 99);
add_filter('wpjam_network_pages', 'wpjam_user_admin_pages', 99);

add_action('admin_menu', function(){
	if(current_user_can('publish_posts')){
		return; 
	}
	
	remove_menu_page('upload.php');
});