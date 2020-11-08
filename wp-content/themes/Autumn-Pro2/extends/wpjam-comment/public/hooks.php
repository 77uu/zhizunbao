<?php
add_filter('pre_option_comment_whitelist',	'__return_zero');
add_filter('pre_option_thread_comments',	'__return_true');
add_filter('pre_option_thread_comments_depth',	function(){return 2;});

add_action('registered_post_type', function($post_type){
	if(wpjam_get_setting('wpjam_comments', $post_type.'_comment_digg')){
		add_post_type_support($post_type, 'comment_digg');
	}

	if(post_type_supports($post_type, 'comments')){
		$reply_type	= wpjam_get_setting('wpjam_comments', $post_type.'_reply_type') ?: 'all';

		add_post_type_support($post_type, 'reply_type', $reply_type);
	}
});

add_filter('comments_template_query_args', function($comment_args){
	$post_id	= $comment_args['post_id'] ?? '';

	if($post_id && ($post_type	= get_post($post_id)->post_type)){
		if(in_array(get_post_type_support_value($post_type, 'reply_type'), ['admin_reply', 'all'])){
			$comment_args['hierarchical']		= 'threaded';
			$comment_args['sticky_comments']	= get_post_meta($post_id, 'sticky_comments', true) ?: [];
		}

		if(post_type_supports($post_type, 'comment_digg')){
			$comment_args['orderby']	= 'digg_count';
		}
	}

	return $comment_args;
});

add_filter('the_comments', function($comments, $query){
	if($query->query_vars['offset'] == 0 
		&& $query->query_vars['paged'] == 1 
		&& $query->query_vars['post_id'] 
		&& in_array($query->query_vars['type'], ['comment', '']) 
		&& !empty($query->query_vars['sticky_comments'])
		&& empty($query->query_vars['parent__in'])
	){
		$post_id	= $query->query_vars['post_id'];
		$post_type	= get_post($post_id)->post_type;

		if(get_post_type_support_value($post_type, 'reply_type') == 'disabled'){
			return $comments;
		}

		$sticky_comments	= $query->query_vars['sticky_comments'];

		if(is_array($sticky_comments) && !empty($sticky_comments)){

			$sticky_comments	= array_reverse($sticky_comments);
			$comments			= array_combine(array_column($comments, 'comment_ID'), $comments);

			foreach($sticky_comments as $i=>$sticky_comment_id){
				if(isset($comments[$sticky_comment_id])){
					$sticky_comment	= $comments[$sticky_comment_id];

					$comments		= [$sticky_comment_id=>$sticky_comment]+$comments;

					unset($sticky_comments[$i]);
				}else{
					$comments	= [$sticky_comment_id=>null]+$comments;
				}
			}

			if (!empty($sticky_comments)){
				$args	= [
					'comment__in'	=> $sticky_comments,
					'orderby'		=> 'comment__in',
					'type'   		=> 'comment',
					'post_type'		=> $post_type
				];

				$stickies	= get_comments($args);

				if($stickies){
					foreach ($stickies as $sticky) {
						$comments[$sticky->comment_ID]	= $sticky;
					}
				}
			}

			return array_filter($comments);
		}
	}

	return $comments;
}, 10, 2);

add_filter('comments_clauses',	function($clauses, $query){
	$orderby	= $query->query_vars['orderby'];
	$order		= $query->query_vars['order'] ?: 'desc';
	$type		= $query->query_vars['type'];

	if(in_array($type,['comment','']) && empty($query->query_vars['parent__in']) && $orderby == 'digg_count'){
		global $wpdb;

		$clauses['fields']	.= ", (COALESCE(jam_cm.meta_value, 0)+0) as digg_count";
		$clauses['join']	.= " LEFT JOIN {$wpdb->commentmeta} jam_cm ON {$wpdb->comments}.comment_ID = jam_cm.comment_id AND jam_cm.meta_key = 'digg_count' ";
		$clauses['orderby']	= "digg_count DESC, " . $clauses['orderby'];
	}

	return $clauses;
}, 10, 2);

add_filter('pre_comment_approved', function($approved, $commentdata){
	if(is_wp_error($approved) || $approved == 0 || $commentdata['comment_type'] != 'comment'){
		return $approved;
	}

	$post_id	= $commentdata['comment_post_ID'];

	if($post = get_post($post_id)){
		$user_id	= $commentdata['user_id'] ?? '';

		if($user_id && user_can($user_id, 'edit_post', $post_id)){
			return $approved;
		}

		if(wpjam_get_setting('wpjam_comments', $post->post_type.'_comment_moderation')){
			return 0;
		}
	}

	if($commentdata['comment_parent']){
		$post_type	= get_post($post_id)->post_type;

		if(in_array(get_post_type_support_value($post_type, 'reply_type'), ['admin_reply', 'disabled'])){
			return new WP_Error('comment_reply_disabled', '评论不支持回复！');
		}
	}

	return $approved;
}, 99, 2);

add_filter('comment_text', function($comment_text, $comment){
	if($comment){
		static $top_comment_id;

		if($comment->comment_parent){
			if(isset($top_comment_id) && $comment->comment_parent != $top_comment_id){
				$parent			= get_comment($comment->comment_parent);
				$comment_text	= '<a href="'.esc_url(get_comment_link($parent)).'">@'.$parent->comment_author.'</a> '.$comment_text;
			}
		}else{
			$top_comment_id	= $comment->comment_ID;
		}

		if(!is_admin()){
			$post_id	= $comment->comment_post_ID;
			$post_type	= get_post($post_id)->post_type;

			if(post_type_supports($post_type, 'comment_digg')){
				$comment_id	= $comment->comment_ID;
				$digg_count	= get_comment_meta($comment_id, 'digg_count', true) ?: ''; 
				$class		= WPJAM_Comment::is_digged($comment_id) ? 'is-digged' : 'is-undigged';

				$comment_text	= '<a href="javascript:;" class="comment-digg '.$class.'" data-comment_id="'.$comment_id.'"><span class="comment-digg-count">'.$digg_count.'</span> <span class="dashicons dashicons-thumbs-up"></span></a>'.$comment_text;
			}
		}
	}

	return $comment_text;
}, 1, 2);

add_filter('get_comment_author', function($author, $comment_id, $comment){
	$post_id	= $comment->comment_post_ID;

	if(is_single($post_id)){
		$post_type	= get_post($post_id)->post_type;

		if(post_type_supports($post_type, 'comment_digg')){
			$sticky_comments	= get_post_meta($post_id, 'sticky_comments', true) ?: [];
			if($sticky_comments && in_array($comment_id, $sticky_comments)){
				$author	= '<span class="dashicons dashicons-sticky"></span> '.$author;
			}
		}

	}

	return $author;
}, 10, 3);

add_filter('comment_reply_link', function($comment_reply_link, $args, $comment, $post){
	if(in_array(get_post_type_support_value($post->post_type, 'reply_type'), ['admin_reply', 'disabled'])){
		return '';
	}else{
		return $comment_reply_link;
	}
}, 10, 4);

remove_action('check_comment_flood', 'check_comment_flood_db', 10, 4);
add_filter('wp_is_comment_flood', function($is_flood, $ip, $email, $date, $avoid_die=false){
	global $wpdb;
	
	if(current_user_can('manage_options') || current_user_can('moderate_comments')){
		return false;
	}
	
	$lasttime	= gmdate('Y-m-d H:i:s', time() - 15);

	if(is_user_logged_in()){
		$check_value	= get_current_user_id();
		$check_column	= '`user_id`';
	}else{
		$check_value	= $ip;
		$check_column	= '`comment_author_IP`';
	}

	$sql	= $wpdb->prepare("SELECT `comment_date_gmt` FROM `$wpdb->comments` WHERE `comment_type` = 'comment' AND `comment_date_gmt` >= %s AND ( $check_column = %s OR `comment_author_email` = %s ) ORDER BY `comment_date_gmt` DESC LIMIT 1", $lasttime, $check_value, $email);

	if($wpdb->get_var($sql)){
		$time_lastcomment	= mysql2date('U', $lasttime, false);
		$time_newcomment	= mysql2date('U', $date, false);

		do_action( 'comment_flood_trigger', $time_lastcomment, $time_newcomment );
		
		if ( true === $avoid_die ) {
			return true;
		} else {
			$comment_flood_message = apply_filters( 'comment_flood_message', __( 'You are posting comments too quickly. Slow down.' ) );

			if ( wp_doing_ajax() ) {
				die( $comment_flood_message );
			}

			wp_die( $comment_flood_message, 429 );
		}
	}

	return false;
}, 10, 5);

add_filter('pre_wp_update_comment_count_now', function($count, $old, $post_id){
	global $wpdb;
	return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved = '1' AND comment_type = 'comment'", $post_id));
}, 10, 3);

