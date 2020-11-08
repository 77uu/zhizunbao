<?php
add_filter('wpjam_comments_setting', function(){
	if(wp_doing_ajax()){
		$referer_origin	= parse_url(wpjam_get_referer());
		$referer_args	= wp_parse_args($referer_origin['query']);
		$post_type		= $referer_args['post_type'] ?? 'post';
	}else{
		$post_type		= wpjam_get_data_parameter('post_type') ?: 'post';
	}

	$fields		= [];

	if(get_option('comment_moderation') == 1){
		$fields[$post_type.'_comment_moderation']	= ['title'=>'人工审核',	'type'=>'view',		'value'=>'全局设置评论必须经人工批准'];
	}else{
		$fields[$post_type.'_comment_moderation']	= ['title'=>'人工审核',	'type'=>'checkbox',	'description'=>'评论必须经人工批准'];
	}
	
	if(post_type_supports($post_type, 'comments')){
		$fields[$post_type.'_comment_digg']	= ['title'=>'评论点赞',	'type'=>'checkbox',	'description'=>'开启评论点赞功能'];
		$fields[$post_type.'_reply_type']	= ['title'=>'回复方式',	'type'=>'select',	'options'=>[''=>'谁都可回复',	'admin_reply'=>'仅管理员可回复',	'disabled'=>'不支持回复']];
	}
	
	return compact('fields');
});