<?php
$post_id	= wpjam_get_parameter('post_id', ['method'=>'POST', 'required'=>true, 'sanitize_callback'=>'intval']);
$data		= ['post_id'=>$post_id];

if($text = wpjam_get_parameter('text',	['method'=>'POST'])){
	$data['comment']	= $text;
}else{
	$data['comment']	= wpjam_get_parameter('comment',	['method'=>'POST', 'required'=>true]);
}

if($reply_to = wpjam_get_parameter('reply_to',	['method'=>'POST'])){
	$data['parent']		= intval($reply_to);
}else{
	$data['parent']		= wpjam_get_parameter('parent',		['method'=>'POST', 'default'=>0]);
}

$meta	= [];

if($images = wpjam_get_parameter('images', ['method'=>'POST'])){
	if(!is_array($images)){
		$images	= wpjam_json_decode(wp_unslash($images));
	}

	$meta['images']	= $images;
}

if($rating = wpjam_get_parameter('rating', ['method'=>'POST'])){
	$meta['rating']	= $rating;
}

$data['meta']	= $meta;

$comment_id	= WPJAM_Comment::insert($data);

if(is_wp_error($comment_id)){
	wpjam_send_json($comment_id);
}

$response['comment']	= WPJAM_Comment::parse_for_json($comment_id);


