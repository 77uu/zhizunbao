<?php
add_filter('wpjam_thumbnail','wpjam_get_qcloud_cos_thumbnail',10,2);

function wpjam_get_qcloud_cos_thumbnail($img_url, $args=[]){
	if($img_url && (!wpjam_is_image($img_url) || wpjam_is_remote_image($img_url))){
		return $img_url;
	}

	extract(wp_parse_args($args, array(
		'crop'		=> 1,
		'width'		=> 0,
		'height'	=> 0,
		'mode'		=> null,
		'format'	=> '',
		'interlace'	=> 0,
		'quality'	=> 0,
	)));

	if($height > 10000){
		$height = 0;
	}

	if($width > 10000){
		$height = 0;
	}

	if($mode === null){
		$crop	= $crop && ($width && $height);	// 只有都设置了宽度和高度才裁剪
		$mode	= $mode?:($crop?1:2);
	}

	$quality	= $quality?:(wpjam_cdn_get_setting('quality'));

	// if($width || $height || $format || $interlace || $quality){
	if($width || $height){
		$arg	= 'imageView2/'.$mode;

		if($width)		$arg .= '/w/'.$width;
		if($height) 	$arg .= '/h/'.$height;
		if($quality)	$arg .= '/q/'.$quality;

		if(strpos($img_url, 'imageView2')){
			$img_url	= preg_replace('/imageView2\/(.*?)#/', '', $img_url);
		}

		$img_url	= add_query_arg( array($arg => ''), $img_url );
		$img_url	= $img_url.'#';
	}

	return $img_url;
}