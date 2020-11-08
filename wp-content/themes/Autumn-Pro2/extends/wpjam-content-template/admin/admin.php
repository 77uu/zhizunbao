<?php
add_filter('wpjam_pages', function ($wpjam_pages){
	global $plugin_page;

	$post_id	= wpjam_get_data_parameter('post_id');

	$template_types	= wpjam_get_content_template_types();
	unset($template_types['content']);

	$page_title_prefix	= $post_id ? '编辑' : '新建';

	foreach ($template_types as $type=>$tt){

		$wpjam_pages['templates']['subs']['wpjam-'.$type] =[
			'menu_title'	=> '新建'.$tt['title'],
			'page_title'	=> $page_title_prefix.$tt['title'],
			'function'		=> $tt['function'] ?? '',
			'query_args' 	=> ['post_id'],
			'page_file'		=> __DIR__ .'/pages/'.$type.'.php'
		];
	}

	$post_types = get_post_types(['show_ui'=>true,'public'=>true], 'objects');
	unset($post_types['attachment']);

	foreach($post_types as $post_type => $pt_obj ){
		$wpjam_pages[$post_type.'s']['subs']['wpjam-'.$post_type.'-template-setting'] =[
			'menu_title'	=> '内容模板',
			'page_title'	=> '详情页设置',
			'function'		=> 'option',
			'option_name'	=> 'wpjam-content-template',
			'page_file'		=> __DIR__ .'/pages/singular.php'
		];
	}

	$wpjam_pages['templates']['subs']['wpjam-template-setting'] =[
		'menu_title'	=> '内容模板设置',
		'function'		=> 'option',
		'option_name'	=> 'wpjam-content-template',
		'page_file'		=> __DIR__ .'/pages/settings.php'
	];

	return $wpjam_pages;
});

add_filter('submenu_file', function($submenu_file, $parent_file){
	global $plugin_page;

	$template_types	= array_keys(wpjam_get_content_template_types());
	unset($template_types['content']);

	if(in_array(str_replace('wpjam-', '', $plugin_page), $template_types)){
		if(!empty($_GET['post_id'])){
			$submenu_file	= $parent_file;
		}
	}

	return $submenu_file;
},10,2); 


add_action('wpjam_builtin_page_load', function ($screen_base, $current_screen){
	if($screen_base == 'edit'){
		if($current_screen->post_type == 'template'){
			$post_type	= $current_screen->post_type;
			include __DIR__ .'/hooks/template-type.php';
			include __DIR__ .'/hooks/template-list.php';
		}
	}elseif($screen_base == 'post'){
		$post_type	= $current_screen->post_type;

		if($post_type == 'template'){
			include __DIR__ .'/hooks/template-type.php';
			include __DIR__ .'/hooks/template.php';
		}elseif($post_type != 'attachment'){
			include __DIR__ .'/hooks/button.php';
		}
	}
}, 1, 2);

add_action('init', function(){
	if(wp_installing()){
		return;
	}

	$current	= 2;
	$version	= wpjam_get_setting('wpjam-content-template', 'version') ?: 0;

	if($version >= $current){
		return;
	}
	
	wpjam_update_setting('wpjam-content-template', 'version', $current);
	
	if($version < 2){
		// $_query = new WP_Query([
		// 	'posts_per_page'	=> -1,
		// 	'post_type'			=> 'template',
		// 	'post_status'		=> ['publish', 'pending', 'draft', 'future', 'trash'],
		// ]);

		// if($_query->posts){
		// 	foreach($_query->posts as $post){
		// 		$post_id		= $post->ID;
		// 		$template_type	= get_post_meta($post_id, '_template_type', true);
		// 		if($template_type == 'table' && metadata_exists('post', $post_id, 'post_id')){
		// 			$table_content	= get_post_meta($post_id, 'post_id', true);
		// 			$post_content	= $post->post_content;

		// 			$post_attr	= [
		// 				'ID'			=> $post_id,
		// 				'post_excerpt'	=> $post_content,
		// 				'post_content'	=> $table_content ? maybe_serialize($table_content) : '',
		// 			];

		// 			wp_update_post($post_attr);
		// 		}
		// 	}
		// }

		// wp_reset_postdata();
	}
});


