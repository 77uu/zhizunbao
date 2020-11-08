<?php
add_filter('wpjam_pages', function($wpjam_pages) {
	$post_types	= get_post_types(['show_ui'=>true], 'objects');

	foreach($post_types as $post_type=>$pt_obj){
		if(post_type_supports($post_type, 'comments')){
			$wpjam_pages[$post_type.'s']['subs'][$post_type.'-comments'] = [
				'menu_title'		=> $pt_obj->label.'评论',
				'function'			=> 'list',
				'list_table_name'	=> 'comments',
				'query_args'		=> ['post_type'],
				'page_file'			=> __DIR__ . '/comments.php',
			]; 
		}

		if(post_type_supports($post_type, 'favs')){
			$wpjam_pages[$post_type.'s']['subs'][$post_type.'-favs'] = [
				'menu_title'	=> $pt_obj->label.'收藏',
				'function'			=> 'list',
				'list_table_name'	=> 'comments',
				'query_args'		=> ['post_type'],
				'page_file'			=> __DIR__ . '/comments.php',
			];
		}

		if(post_type_supports($post_type, 'likes')){
			$wpjam_pages[$post_type.'s']['subs'][$post_type.'-likes'] = [
				'menu_title'	=> $pt_obj->label.'点赞',
				'function'			=> 'list',
				'list_table_name'	=> 'comments',
				'query_args'		=> ['post_type'],
				'page_file'			=> __DIR__ . '/comments.php',
			];
		}

		if(post_type_supports($post_type, 'checkins')){
			$wpjam_pages[$post_type.'s']['subs'][$post_type.'-checkins'] = [
				'menu_title'	=> $pt_obj->label.'签到',
				'function'			=> 'list',
				'list_table_name'	=> 'comments',
				'query_args'		=> ['post_type'],
				'page_file'			=> __DIR__ . '/comments.php',
			];
		}

		if(post_type_supports($post_type, 'applys')){
			$wpjam_pages[$post_type.'s']['subs'][$post_type.'-applys'] = [
				'menu_title'	=> $pt_obj->label.'预约',
				'function'			=> 'list',
				'list_table_name'	=> 'comments',
				'query_args'		=> ['post_type'],
				'page_file'			=> __DIR__ . '/comments.php',
			];
		}
			
		if(post_type_supports($post_type, 'comments')){
			$wpjam_pages[$post_type.'s']['subs'][$post_type.'-comments-setting'] = [
				'menu_title'	=> '评论设置',
				'function'		=> 'option',
				'option_name'	=> 'wpjam_comments',
				'query_args'	=> ['post_type'],
				'capability'	=> is_multisite() ? 'manage_sites' : 'manage_options',
				'page_file'		=> __DIR__ . '/settings.php',
			];
		}
	}

	return $wpjam_pages;
}, 999);