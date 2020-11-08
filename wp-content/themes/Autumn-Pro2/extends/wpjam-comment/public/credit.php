<?php
$post_types	= get_post_types(['_builtin'=>false]);

$post_types['post']	= 'post';
$post_types['page']	= 'page';

foreach($post_types as $post_type){
	$pt_obj	= get_post_type_object($post_type);

	if(post_type_supports($post_type, 'comments')){
		wpjam_register_credit_type($post_type.'_'.'comment',	['title'=>$pt_obj->label.'评论',	'default'=>4, 'order'=>9]);
	}

	if(post_type_supports($post_type, 'favs')){
		wpjam_register_credit_type($post_type.'_'.'fav',		['title'=>$pt_obj->label.'收藏',	'default'=>2, 'order'=>8]);
	}

	if(post_type_supports($post_type, 'likes')){
		wpjam_register_credit_type($post_type.'_'.'like',		['title'=>$pt_obj->label.'点赞',	'default'=>2, 'order'=>7]);
	}

	if(post_type_supports($post_type, 'checkins')){
		wpjam_register_credit_type($post_type.'_'.'checkin',	['title'=>$pt_obj->label.'签到',	'default'=>2]);
	}
}

add_action('comment_post', function($comment_id, $comment_approved, $comment_data){
	$wpjam_user		= wpjam_get_current_user();

	if(is_wp_error($wpjam_user) || empty($wpjam_user['account_id'])){
		return;
	}

	$comment_type	= $comment_data['comment_type'] ?: 'comment';
	$post_id		= WPJAM_Comment::get_post_id($comment_id);
	$post_type		= get_post_type($post_id);

	$data['related_id']	= $comment_id;
	$data['account_id']	= $wpjam_user['account_id'];
	$data['user_email']	= $wpjam_user['user_email'];
	$data['type']		= $post_type.'_'.$comment_type;

	return WPJAM_Credit::insert($data);

}, 10, 3);