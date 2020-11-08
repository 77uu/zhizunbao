<?php
$post_id	= wpjam_get_parameter('post_id', ['method'=>'POST', 'sanitize_callback'=>'intval', 'required'=>true]);
$args		= ['action'=>$module_action];

if($module_action == 'checkin'){
	$longitude	= wpjam_get_parameter('longitude',	['method'=>'POST', 'required'=>true]);
	$latitude	= wpjam_get_parameter('latitude',	['method'=>'POST', 'required'=>true]);

	$args['meta']	= compact('longitude', 'latitude');
}elseif($module_action == 'apply'){
	$datas	= wpjam_get_parameter('datas',	['method'=>'POST', 'required'=>true]);

	$args['comment']	= maybe_serialize($datas);

	// if($fields	= WPJAM_Comment::get_form_fields($post_id)){	// 之后再做检验
	// 	foreach ($fields as $field){
	// 		if(isset($field['required'])){
	// 			$required	= true;
	// 		}else{
	// 			$required	= false; 
	// 		}
	// 	}
	// }
}

$comment_id	= WPJAM_Comment::action($post_id, $args);

if(is_wp_error($comment_id)){
	wpjam_send_json($comment_id);
}
