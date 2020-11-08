<?php
add_filter('get_terms_defaults', function($defaults, $taxonomies){
	if(wpjam_is_taxonomy_sortable($taxonomies)){
		$defaults['orderby']	= 'order';
	}

	return $defaults;
}, 10, 2);

add_action('parse_term_query', function($query){
	if(wpjam_is_taxonomy_sortable($query->query_vars['taxonomy'])){

		$orderby	= $query->query_vars['orderby'];

		if(in_array($orderby, ['id', 'name'])){
			if(array_intersect(wp_list_pluck(debug_backtrace(), 'function'), ['wp_dropdown_categories', 'wp_list_categories', 'rest_api_loaded'])){
				$orderby	= 'order';
			}
		}

		if($orderby == 'order'){
			$query->query_vars['orderby']	= 'meta_value_num';
			$query->query_vars['order']		= 'DESC';
			$query->query_vars['meta_key']	= 'order';
		}
	}
		
}, 99);

add_filter('register_taxonomy_args', function($args, $taxonomy){
	$levels	= wpjam_get_setting('wpjam_taxonomy_levels', $taxonomy);

	if(!is_null($levels)){
		if(!isset($args['levels'])){
			$args['levels']	= intval($levels);
		}else{
			wpjam_delete_setting('wpjam_taxonomy_levels', $taxonomy);
		}
	}

	$order	= wpjam_get_setting('wpjam_taxonomy_order', $taxonomy);

	if(!is_null($order)){
		if(!isset($args['sortable']) && !isset($args['order'])){
			$args['order']	= boolval($order);
		}else{
			wpjam_delete_setting('wpjam_taxonomy_order', $taxonomy);
		}
	}

	if($taxonomy == 'post_tag'){
		if(wpjam_get_setting('wpjam_taxonomy_setting', 'post_tag_id_permalink')){
			$tag_base	= get_option('tag_base') ?: 'tag';
			$args['permastruct']	= $tag_base.'/%post_tag_id%';
			$args['supports']		= ['description', 'parent'];
		}
	}elseif($taxonomy == 'category'){
		if(wpjam_get_setting('wpjam_taxonomy_setting', 'category_id_permalink')){
			$category_base	= get_option('category_base') ?: 'category';
			$args['permastruct']	= $category_base.'/%category_id%';
			$args['supports']		= ['description', 'parent'];
		}
	}

	if(is_admin()){
		$filter	= wpjam_get_setting('wpjam_taxonomy_filter', $taxonomy);

		if(!is_null($filter)){
			if(!isset($args['filterable'])){
				$args['filterable']	= boolval($filter);
			}else{
				wpjam_delete_setting('wpjam_taxonomy_filter', $taxonomy);
			}
		}
	}

	return $args;
}, 10, 2);


add_action('init', function(){
	global $wp_rewrite;

	if(wpjam_get_setting('wpjam_taxonomy_setting', 'post_tag_id_permalink')){
		$tag_base	= get_option('tag_base') ?: 'tag';

		$wp_rewrite->extra_permastructs['post_tag']['struct']	= $tag_base.'/%post_tag_id%';

		// add_rewrite_tag('%post_tag_id%', '([0-9]+)', 'taxonomy=post_tag&term_id=');
		add_rewrite_tag('%post_tag_id%', '([^/]+)', 'taxonomy=post_tag&term_id=');
		remove_rewrite_tag('%post_tag%');
	}

	if(wpjam_get_setting('wpjam_taxonomy_setting', 'category_id_permalink')){
		$category_base	= get_option('category_base') ?: 'category';

		$wp_rewrite->extra_permastructs['category']['struct']	= $category_base.'/%category_id%';

		// add_rewrite_tag('%category_id%', '([0-9]+)', 'taxonomy=category&term_id=');
		add_rewrite_tag('%category_id%', '(.+?)', 'taxonomy=category&term_id=');
		remove_rewrite_tag('%category%');
	}
}, 12);

add_action('pre_get_posts', function($query){
	if($query->is_main_query() && $query->is_home){
		$platforms	= wpjam_get_setting('wpjam_home_categories', 'platforms');

		if(empty($platforms)){
			return;
		}

		if($platform = wpjam_get_current_platform($platforms)){
			$settings	= wpjam_get_setting('wpjam_home_categories', $platform);

			$type	= $settings['type'] ?? '';

			if(empty($type)){
				return;
			}
			
			$cats	= $settings['cats'] ?? [];
			$cats	= $cats ? array_filter(array_map('intval', $cats)): [];

			if(empty($cats)){
				return;
			}

			if($type == 'category__in'){
				$query->set('category__in', $cats);
			}elseif($type == 'category__not_in'){
				$query->set('category__not_in', $cats);
			}
		}	
	}
});