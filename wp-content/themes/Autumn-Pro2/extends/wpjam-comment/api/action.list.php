<?php
$comment_type	= str_replace('.list', '', $module_action);

$comment_args	= $args;

$comment_args['type']	= $comment_type;

$post_id	= wpjam_get_parameter('post_id',	['sanitize_callback'=>'intval']);

if($post_id){
	$output	= $output ?: $comment_type.'s';
	$comment_args['post_id']	= $post_id;

	$response[$output]	= WPJAM_Comment::get_comments($comment_args);
}else{
	$comment_args['number']	= $args['number'] ?? 20;
	$comment_args['order']	= $args['order'] ?? 'DESC';

	$post_type	= $args['post_type'] ?? wpjam_get_parameter('post_type');

	if(!is_null($post_type)){
		$comment_args['post_type']	= $post_type;
	}

	$use_cursor	= true;

	$paged		= wpjam_get_parameter('paged',	['default'=>0,	'sanitize_callback'=>'intval']);

	if($paged){
		$comment_args['paged']	= $paged;
		$use_cursor	= false;
	}

	if($use_cursor){
		$cursor	= wpjam_get_parameter('cursor',	['default'=>0,	'sanitize_callback'=>'intval']);

		if($cursor){
			$comment_args['date_query']	= [
				['before'=>get_date_from_gmt(date('Y-m-d H:i:s',$cursor))]
			];
		}
	}

	$comment_query	= WPJAM_Comment::get_query($comment_args);

	if(is_wp_error($comment_query)){
		wpjam_send_json($comment_query);
	}

	$posts_json	= [];

	if($comment_query->comments){
		foreach ($comment_query->comments as $comment){
			$post_json	= wpjam_get_post($comment->comment_post_ID, $args);

			if($post_json){
				$posts_json[]	= array_merge($post_json, [$comment_type=>WPJAM_Comment::parse_for_json($comment, $comment_args)]);
			}
		}
	}
	
	$response['total']			= intval($comment_query->found_comments);
	$response['total_pages']	= intval($comment_query->max_num_pages);
	$response['current_page']	= intval($comment_query->query_vars['paged'] ?: 1);

	if($use_cursor){
		if($comment_query->max_num_pages > 1 && $posts_json){
			$response['next_cursor']	= end($posts_json)[$comment_type]['timestamp'];
		}else{
			$response['next_cursor']	= 0;
		}
	}

	$output	= $output ?: ($post_type ? $post_type.'s' : 'posts');

	$response[$output]	= $posts_json;
}

