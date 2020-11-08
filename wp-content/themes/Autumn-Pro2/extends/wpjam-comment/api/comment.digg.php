<?php
$comment_id	= wpjam_get_parameter('comment_id', ['method'=>'POST', 'sanitize_callback'=>'intval', 'required'=>true]);

if($module_action == 'comment.digg'){
	$result	= WPJAM_Comment::digg($comment_id, 'digg');			
}else{
	$result	= WPJAM_Comment::digg($comment_id, 'undigg');
}

if(is_wp_error($result)){
	wpjam_send_json($result);
}

$response['comment']	= WPJAM_Comment::parse_for_json($comment_id);