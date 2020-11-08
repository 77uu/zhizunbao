<?php
add_filter('wpjam_taxonomy_levels_setting', function(){
	$fields	= [];

	$taxonomies = get_taxonomies(['hierarchical'=>true,'show_ui'=>true],'objects');

	foreach ($taxonomies as $taxonomy=>$taxonomy_obj) {
		$taxonomy_levels	= wpjam_get_setting('wpjam_taxonomy_levels', $taxonomy);

		if(isset($taxonomy_obj->levels) && is_null($taxonomy_levels)){
			$fields[$taxonomy]	= ['title'=>$taxonomy_obj->label,	'type'=>'view',		'value'=>'代码设置为：'.$taxonomy_obj->levels.'层'];
		}else{
			$fields[$taxonomy]	= ['title'=>$taxonomy_obj->label,	'type'=>'number',	'name'=>$taxonomy,	'value'=>0,	'class'=>'small-text',	'description'=>'层'];
		}
	}

	$summary	= '请设置分类的层级，层级为0则不限制层级。';

	return compact('fields', 'summary');	
});

add_filter('wpjam_taxonomy_order_setting', function(){
	$fields	= [];

	$taxonomies = get_taxonomies(['hierarchical'=>true,'show_ui'=>true],'objects');

	foreach ($taxonomies as $taxonomy=>$taxonomy_obj) {

		$taxonomy_order	= wpjam_get_setting('wpjam_taxonomy_order', $taxonomy);

		if((isset($taxonomy_obj->order) || isset($taxonomy_obj->sortable)) && is_null($taxonomy_order)){
			$fields[$taxonomy]	= ['title'=>$taxonomy_obj->label,	'type'=>'view',	'value'=>'代码设置为：支持'];
		}else{
			$fields[$taxonomy]	= ['title'=>$taxonomy_obj->label,	'type'=>'checkbox',	'name'=>$taxonomy,	'value'=>0,	'description'=>'支持拖动排序'];
		}
	}

	return compact('fields');	
});

add_filter('wpjam_taxonomy_filter_setting', function(){
	$fields	= [];

	$taxonomies = get_taxonomies(['show_admin_column'=>true,'show_ui'=>true],'objects');

	foreach ($taxonomies as $taxonomy=>$taxonomy_obj) {

		$taxonomy_filter	= wpjam_get_setting('wpjam_taxonomy_filter', $taxonomy);

		if(isset($taxonomy_obj->filterable) && is_null($taxonomy_filter)){
			$fields[$taxonomy]	= ['title'=>$taxonomy_obj->label,	'type'=>'view',	'value'=>'代码设置为：支持'];
		}else{
			$fields[$taxonomy]	= ['title'=>$taxonomy_obj->label,	'type'=>'checkbox',	'name'=>$taxonomy,	'value'=>0,	'description'=>'支持后台文章列表页使用'.$taxonomy_obj->label.'过滤',	'value'=>1];
		}
	}

	return compact('fields');	
});

add_filter('wpjam_taxonomy_setting_setting', function(){

	flush_rewrite_rules();

	$fields		= [];

	$category_base	= get_option('category_base') ?: 'category';
	$tag_base		= get_option('tag_base') ?: 'tag';

	$category_link	= user_trailingslashit(home_url($category_base.'/123'));
	$post_tag_link	= user_trailingslashit(home_url($tag_base.'/123'));

	$fields['post_tag_id_permalink']	= ['title'=>'标签',		'type'=>'checkbox',	'description'=>'使用数字固定链接：<code>'.$post_tag_link.'</code>'];
	$fields['category_id_permalink']	= ['title'=>'分类目录',	'type'=>'checkbox',	'description'=>'使用数字固定链接：<code>'.$category_link.'</code>'];

	return compact('fields');
});

add_filter('wpjam_home_categories_setting', function(){
	$levels		= get_taxonomy('category')->levels ?? 0;
	$cats		= wpjam_get_terms(['taxonomy'=>'category',	'hide_empty'=>0], $levels);
	$cats		= wpjam_flatten_terms($cats);
	$options	= $cats ? wp_list_pluck($cats, 'name', 'id') : [];

	$fields		= [];

	$platform_options		= WPJAM_Platform::get_options('key');
	$fields['platforms']	= ['title'=>'设置的平台',	'type'=>'checkbox',	'options'=>$platform_options];

	$sub_fields	= [
		'type'	=> ['title'=>'',	'type'=>'select',	'options'=>[''=>'显示所有分类下的文章','category__in'=>'仅显示设置分类下的文章','category__not_in'=>'不显示设置分类下的文章']],
		'cats'	=> ['title'=>'',	'type'=>'mu-text',	'item_type'=>'select',	'options'=>[''=>'']+$options]
	];

	foreach ($platform_options as $platform => $platform_title) {
		$sub_fields['cats']['show_if']	= ['key'=>$platform.'_type', 'compare'=>'!=', 'value'=>''];

		$fields[$platform]	= ['title'=>$platform_title,	'type'=>'fieldset',	'fieldset_type'=>'array',	'show_if'=>['key'=>'platforms', 'value'=>$platform],	'fields'=>$sub_fields];
	}

	return compact('fields');
});