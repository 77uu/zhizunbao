<?php
if(is_admin()){
	include __DIR__.'/admin/admin.php';
}
 
//关掉一些WPJAM插件的扩展功能
$wpjam_extends	= get_option('wpjam-extends');
if($wpjam_extends){
	$wpjam_extends_updated	= false;

	//相关文章
	if(!empty($wpjam_extends['related-posts.php'])){
		unset($wpjam_extends['related-posts.php']);
		$wpjam_extends_updated	= true;
	}
	
	if(empty($wpjam_extends['wpjam-postviews.php'])){
		$wpjam_extends['wpjam-postviews.php']	= true;
		$wpjam_extends_updated	= true;
	}

	if($wpjam_extends_updated){
		update_option('wpjam-extends', $wpjam_extends);
	}
}

add_filter('option_wpjam-basic', function ($value){
	$value	= $value ?: [];
	$value['admin_footer']	= 'Powered by <a href="http://www.xintheme.com" target="_blank">新主题 XinTheme</a> + <a href="https://blog.wpjam.com/" target="_blank">WordPress 果酱</a>';
	$value['excerpt_optimization']	= 1;
	$value['excerpt_length']		= 115;

	return $value;
});

add_filter('wpjam_post_thumbnail_url', function($post_thumbnail_url, $post){
	if(get_post_meta($post->ID, 'header_img', true)){
		return get_post_meta($post->ID, 'header_img', true);
	}elseif($post_thumbnail_url){
		return $post_thumbnail_url;
	}else{
		return wpjam_get_post_first_image($post->post_content);
	}
},10,2);

add_filter('wpjam_default_thumbnail_url',function ($default_thumbnail){
	$default_thumbnails	= wpjam_get_setting('wpjam_theme', 'thumbnails');

	if($default_thumbnails){
		shuffle($default_thumbnails);
		return $default_thumbnails[0];
	}else{
		return $default_thumbnail;
	}
},99);