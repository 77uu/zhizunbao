<?php
if(!wpjam_get_user_setting('hide_user_login')){
	return;
}

add_action('pre_get_posts',  function($wp_query) {
	if($wp_query->is_main_query() && $wp_query->is_author()){
		if($author_name = $wp_query->get('author_name')){
			$author_name	= sanitize_title_for_query($author_name);
			$author			= get_user_by('slug', $author_name);

			if($author){
				if(sanitize_title($author->user_login) == $author->user_nicename){
					$wp_query->set_404();
				}
			}else{
				if(is_numeric($author_name)){
					$wp_query->set('author_name', '');
					$wp_query->set('author', $author_name);
				}
			}
		}
	}
});

add_filter('author_link', function($link, $author_id, $author_nicename){
	$author	= get_userdata($author_id);
	
	if(sanitize_title($author->user_login) == $author_nicename){
		global $wp_rewrite;

		$link	= $wp_rewrite->get_author_permastruct();
		$link	= str_replace('%author%', $author_id, $link);
		$link	= home_url(user_trailingslashit($link));
	}
	
	return $link;
}, 10, 3);

add_filter('body_class', function($classes){
	if(is_author()){
		global $wp_query;

		$author	= $wp_query->get_queried_object();

		if(sanitize_title($author->user_login) == $author->user_nicename){
			$author_class	= 'author-'.sanitize_html_class($author->user_nicename, $author->ID);
			$classes		= array_diff($classes, [$author_class]);
		}
	}
	return $classes;
});

add_filter('comment_class', function ($classes){
	foreach($classes as $key => $class) {
		if(strstr($class, 'comment-author-')){
			unset($classes[$key]);
		}
	}
	return $classes;
});
