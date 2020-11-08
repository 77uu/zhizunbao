<?php
add_filter('wpjam_basic_sub_pages', function($subs){
	if(!is_multisite() || !is_network_admin()){
		$subs['wpjam-taxonomy']	=[
			'menu_title'	=> '分类设置',
			'summary'		=> '分类设置插件支持层式管理分类，设置分类层级，分类拖动排序和文章分类筛选过滤功能，详细介绍请点击：<a href="https://blog.wpjam.com/project/wpjam-taxonomy/" target="_blank">分类设置插件</a>。', 
			'page_file'		=> WPJAM_TAXONOMY_PLUGIN_DIR.'admin/settings.php',
			'function'		=> 'tab',
			'tabs'			=> [
				'levels'	=> ['title'=>'分类层级',	'function'=>'option', 'option_name'=>'wpjam_taxonomy_levels'],
				'order'		=> ['title'=>'分类排序',	'function'=>'option', 'option_name'=>'wpjam_taxonomy_order'],
				'permalink'	=> ['title'=>'固定链接',	'function'=>'option', 'option_name'=>'wpjam_taxonomy_setting'],
				'filter'	=> ['title'=>'文章过滤',	'function'=>'option', 'option_name'=>'wpjam_taxonomy_filter'],
				'home'		=> ['title'=>'首页分类',	'function'=>'option', 'option_name'=>'wpjam_home_categories'],
			]
		];
	}

	return $subs;
},9);

add_filter('wpjam_pages', function($wpjam_pages) {
	foreach(get_post_types(['show_ui'=>true], 'objects') as $post_type=>$pt_obj){
		$taxonomies	= get_object_taxonomies($post_type, 'objects');

		$taxonomies	= wp_filter_object_list($taxonomies, ['show_ui'=>true]);

		if($taxonomies){
			$wpjam_pages[$post_type.'s']['subs'][$post_type.'-terms-filter'] = [
				'menu_title'	=> '多重筛选',
				'query_args'	=> ['post_type'],
				'function'		=> 'wpjam_terms_filter_page',
				'page_file'		=> WPJAM_TAXONOMY_PLUGIN_DIR . 'admin/terms-filter.php',
				'summary'		=> '多重筛选支持筛选出同时用多个标签的文章列表，详细介绍：<a href="https://blog.wpjam.com/project/wpjam-taxonomy/" target="_blank">分类设置插件</a>。'
			];
		}
	}

	return $wpjam_pages;
});

add_action('wpjam_builtin_page_load', function ($screen_base, $current_screen){
	if($screen_base == 'edit-tags'){
		if(is_taxonomy_hierarchical($current_screen->taxonomy)){
			$taxonomy	= $current_screen->taxonomy;
			require WPJAM_TAXONOMY_PLUGIN_DIR .'admin/term-list.php';	
		}
	}elseif($screen_base == 'edit'){
		include WPJAM_TAXONOMY_PLUGIN_DIR.'admin/post-list.php';
	}
}, 9, 2);

$wpjam_taxonomy_levels	= get_option('wpjam_taxonomy_levels', null);
if(is_null($wpjam_taxonomy_levels)){
	$wpjam_taxonomy_levels	= ['category'=>'0'];
	update_option('wpjam_taxonomy_levels', $wpjam_taxonomy_levels);
}

$wpjam_taxonomy_order	= get_option('wpjam_taxonomy_order',null);
if(is_null($wpjam_taxonomy_order)){
	$wpjam_taxonomy_order	= ['category'=>false];
	update_option('wpjam_taxonomy_order', $wpjam_taxonomy_order);
}

$wpjam_home_categories	= get_option('wpjam_home_categories',null);
if(is_null($wpjam_home_categories)){
	$wpjam_home_categories	= ['platforms'=>[]];
	update_option('wpjam_home_categories', $wpjam_home_categories);
}

// add_filter('rest_prepare_taxonomy', function($response, $taxonomy, $request){

// 	// wpjam_print_R($taxonomy);
// 	// wpjam_print_R($request);
// 	// wpjam_print_R($response);

// 	trigger_error(var_export($request, true));

// 	return $response;
// },10,3);

// add_filter('rest_pre_dispatch', function($result, $aa, $request){

// 	// wpjam_print_R($taxonomy);
// 	// wpjam_print_R($request);
// 	// wpjam_print_R($response);

// 	// trigger_error('123');
// 	trigger_error(var_export($request, true));

// 	return $result;
// },10,3);

// add_filter('block_editor_preload_paths', function($preload_paths, $post){

// 	wpjam_print_R($preload_paths);
// 	// wpjam_print_R($post);

// 	return $preload_paths;
// },10,2);


