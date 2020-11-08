<?php
/*
Plugin Name: 相关文章
Plugin URI: http://blog.wpjam.com/project/wpjam-basic/
Description: 根据文章的标签和分类，自动生成相关文章，并在文章末尾显示。
Version: 1.0
*/
class WPJAM_Related_Posts{
	public static function get_args(){
		$args	= wpjam_get_option('wpjam-related-posts') ?: [];

		if(empty($args)){
			foreach (['number', 'excerpt',	'post_types', 'class', 'div_id', 'title', 'thumb', 'width', 'height', 'auto'] as $setting_name){
				if($setting_value	= wpjam_basic_get_setting('related_posts_'.$setting_name)){
					$args[$setting_name]	= $setting_value;
				}
			}
		}

		if(!empty($args['thumb'])){
			$args['size']	= [
				'width'		=> !empty($args['width']) ? intval($args['width'])*2 : 0,
				'height'	=> !empty($args['height']) ? intval($args['height'])*2 : 0
			];
		}

		if(!empty($args['post_types'])){
			$args['post_type']	= $args['post_types'];
		}

		return $args;
	}

	public static function get_option_setting(){
		$post_type_options	= wp_list_pluck(get_post_types(['show_ui'=>true,'public'=>true], 'objects'), 'label', 'name');

		unset($post_type_options['attachment']);

		$fields	= [
			'title'			=> ['title'=>'标题',		'type'=>'text',		'value'=>'相关文章',	'class'=>'all-options',	'description'=>'相关文章列表标题。'],
			'number'		=> ['title'=>'数量',		'type'=>'number',	'value'=>5,			'class'=>'all-options',	'description'=>'默认为5。'],
			'post_types'	=> ['title'=>'文章类型',	'type'=>'checkbox',	'options'=>$post_type_options,	'description'=>'相关文章列表包含哪些文章类型的文章，默认则为当前文章的类型。'],
			'_excerpt'		=> ['title'=>'摘要',		'type'=>'checkbox',	'name'=>'excerpt',	'description'=>'显示文章摘要。'],
			'thumb_set'		=> ['title'=>'缩略图',	'type'=>'fieldset',	'fields'=>[
				'thumb'		=> ['title'=>'',	'type'=>'checkbox',	'value'=>1,		'description'=>'显示缩略图。'],
				'width'		=> ['title'=>'宽度',	'type'=>'number',	'value'=>100,	'class'=>'small-text',	'show_if'=>['key'=>'thumb', 'value'=>1],	'description'=>'px'],
				'height'	=> ['title'=>'高度',	'type'=>'number',	'value'=>100,	'class'=>'small-text',	'show_if'=>['key'=>'thumb', 'value'=>1],	'description'=>'px']
			]],
			'style'			=> ['title'=>'样式',		'type'=>'fieldset',	'fields'=>[
				'div_id'	=> ['title'=>'',	'type'=>'text',	'value'=>'related_posts',	'class'=>'all-options',	'description'=>'外层 div id，不填则外层不添加 div。'],
				'class'		=> ['title'=>'',	'type'=>'text',	'value'=>'',				'class'=>'all-options',	'description'=>'相关文章列表 ul 的 class。'],
			]],
			'auto'			=> ['title'=>'自动',		'type'=>'checkbox',	'value'=>1,	'description'=>'自动附加到文章末尾。'],
		];

		$summary	= '相关文章扩展会在文章详情页生成一个相关文章的列表，详细介绍请点击：<a href="https://blog.wpjam.com/m/wpjam-related-posts/">相关文章扩展</a>。';

		return compact('fields', 'summary');
	}

	public static function shortcode($atts, $content=''){
		extract(shortcode_atts(['tag'=>''], $atts));

		$tags	= $tag ? explode(",", $tag) : '';

		if(empty($tags)){
			return '';
		}
		
		$related_query	= wpjam_query(array( 
			'post_type'		=>'any', 
			'no_found_rows'	=>true,
			'post_status'	=>'publish', 
			'post__not_in'	=>[get_the_ID()],
			'tax_query'		=>[
				[
					'taxonomy'	=> 'post_tag',
					'terms'		=> $tags,
					'operator'	=> 'AND',
					'field'		=> 'name'
				]
			]
		));

		return  wpjam_get_post_list($related_query, ['thumb'=>false,'class'=>'related-posts']);
	}

	public static function filter_the_content($content){
		$args	= self::get_args();

		if(empty($args['auto']) || doing_filter('get_the_excerpt') || !is_singular() || wpjam_get_json() || get_the_ID() != get_queried_object_id()){
			return $content;
		}

		if(!empty($args['post_types']) && !in_array(get_post_type(), $args['post_types'])){
			return $content;
		}
		
		return $content.wpjam_get_related_posts($args);
	}

	public static function filter_post_json($post_json){
		if(is_singular() && get_the_ID() == get_queried_object_id()){
			$args	= self::get_args();
			
			if(empty($args['post_types']) || (in_array(get_post_type(), $args['post_types']))){
				$post_json['related']	= WPJAM_Post::get_related(get_the_ID(), $args);
			}
		}

		return $post_json;
	}
}

add_shortcode('related', ['WPJAM_Related_Posts', 'shortcode']);

if(!is_admin()){
	add_filter('the_content',		['WPJAM_Related_Posts', 'filter_the_content'], 11);
	add_filter('wpjam_post_json',	['WPJAM_Related_Posts', 'filter_post_json'], 10, 2);
}else{
	add_action('wpjam_plugin_page_load', function($plugin_page, $current_tab){
		if($plugin_page != 'wpjam-posts'){
			return;
		}

		wpjam_register_plugin_page_tab('related-posts', ['title'=>'相关文章',	'function'=>'option',	'option_name'=>'wpjam-related-posts']);

		if($current_tab == 'related-posts'){
			wpjam_register_option('wpjam-related-posts', ['WPJAM_Related_Posts','get_option_setting']);
		}
	}, 10, 2);
}


