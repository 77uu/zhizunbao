<?php
add_action('wpjam_api_template_redirect', function ($json){
	$post_types	= get_post_types(['_builtin'=>false]);

	$post_types['post']	= 'post';
	$post_types['page']	= 'page';

	foreach($post_types as $post_type){
		if(strpos($json, $post_type.'.') !== 0){
			continue;
		}

		if(post_type_supports($post_type, 'comments')){
			wpjam_register_api($post_type.'.comment', [
				'title'		=> '评论',
				'auth'		=> true,
				'modules'	=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'comment']
					]
				]
			]);

			wpjam_register_api($post_type.'.comment.list', [
				'title'			=> '我的评论',
				'page_title'	=> '我的评论',
				'auth'			=> true,
				'modules'		=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'comment.list']
					]
				]
			]);

			if(post_type_supports($post_type, 'comment_digg')){
				wpjam_register_api($post_type.'.comment.digg', [
					'title'		=> '评论点赞',
					'auth'		=> true,
					'modules'	=> [
						[
							'type'	=> 'post_type',
							'args'	=> ['post_type'=>$post_type,	'action'=>'comment.digg']
						]
					]
				]);

				wpjam_register_api($post_type.'.comment.undigg', [
					'title'		=> '评论取消点赞',
					'auth'		=> true,
					'modules'	=> [
						[
							'type'	=> 'post_type',
							'args'	=> ['post_type'=>$post_type,	'action'=>'comment.undigg']
						]
					]
				]);
			}
		}

		if(post_type_supports($post_type, 'likes')){
			wpjam_register_api($post_type.'.like', [
				'title'		=> '点赞',
				'auth'		=> true,
				'modules'	=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'like']
					]
				]
			]);

			wpjam_register_api($post_type.'.unlike', [
				'title'		=> '取消点赞',
				'auth'		=> true,
				'modules'	=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'unlike']
					]
				]
			]);
		}

		if(post_type_supports($post_type, 'favs')){
			wpjam_register_api($post_type.'.fav', [
				'title'		=> '收藏',
				'auth'		=> true,
				'modules'	=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'fav']
					]
				]
			]);

			wpjam_register_api($post_type.'.unfav', [
				'title'		=> '取消收藏',
				'auth'		=> true,
				'modules'	=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'unfav']
					]
				]
			]);

			wpjam_register_api($post_type.'.fav.list', [
				'title'			=> '我的收藏',
				'page_title'	=> '我的收藏',
				'auth'			=> true,
				'modules'		=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'fav.list']
					]
				]
			]);
		}

		if(post_type_supports($post_type, 'applys')){
			wpjam_register_api($post_type.'.apply', [
				'title'		=> '申请',
				'auth'		=> true,
				'modules'	=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'apply']
					]
				]
			]);

			wpjam_register_api($post_type.'.apply.list', [
				'title'			=> '我的申请',
				'page_title'	=> '我的申请',
				'auth'			=> true,
				'modules'		=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'apply.list']
					]
				]
			]);
		}

		if(post_type_supports($post_type, 'checkins')){
			wpjam_register_api($post_type.'.checkin', [
				'title'		=> '签到',
				'auth'		=> true,
				'modules'	=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'checkin']
					]
				]
			]);

			wpjam_register_api($post_type.'.checkin.list', [
				'title'			=> '我的签到',
				'page_title'	=> '我的签到',
				'auth'			=> true,
				'modules'		=> [
					[
						'type'	=> 'post_type',
						'args'	=> ['post_type'=>$post_type,	'action'=>'checkin.list']
					]
				]
			]);
		}

		break;
	}
});

add_action('wpjam_api_post_template', function($post_template, $module_action, $post_type){
	if(in_array($module_action, ['comment', 'review'])){
		return WPJAM_COMMENT_PLUGIN_DIR.'api/comment.php';
	}elseif(in_array($module_action, ['like', 'fav', 'unlike', 'unfav', 'checkin', 'apply'])){
		return WPJAM_COMMENT_PLUGIN_DIR.'api/action.php';
	}elseif(in_array($module_action, ['comment.list', 'fav.list', 'checkin.list', 'apply.list'])){
		return WPJAM_COMMENT_PLUGIN_DIR.'api/action.list.php';
	}elseif(in_array($module_action, ['comment.digg', 'comment.undigg'])){
		return WPJAM_COMMENT_PLUGIN_DIR.'/api/comment.digg.php';
	}

	return $post_template;
}, 10, 3);

add_filter('wpjam_post_json', function($post_json, $post_id){
	$post_type	= $post_json['post_type'];
	$post		= get_post($post_id);

	$post_json['comment_count']		= intval($post->comment_count);

	if(post_type_supports($post_type, 'comments')){
		$post_json['comment_status']	= $post->comment_status;
	}else{
		$post_json['comment_status']	= 'closed';
	}

	if(post_type_supports($post_type, 'likes')){
		$post_json['like_status']	= 'open';
		$post_json['like_count']	= intval(get_post_meta($post_id, 'likes', true));
	}else{
		$post_json['like_status']	= 'closed';
	}

	if(post_type_supports($post_type, 'favs')){
		$post_json['fav_status']	= 'open';
		$post_json['fav_count']		= intval(get_post_meta($post_id, 'favs', true));
	}else{
		$post_json['fav_status']	= 'closed';
	}

	if(post_type_supports($post_type, 'favs')){
		$post_json['fav_status']	= 'open';
		$post_json['fav_count']		= intval(get_post_meta($post_id, 'favs', true));
	}else{
		$post_json['fav_status']	= 'closed';
	}

	if(post_type_supports($post_type, 'checkins')){
		$post_json['checkin_status']	= 'open';
		$post_json['checkin_count']		= intval(get_post_meta($post_id, 'checkins', true));
	}else{
		$post_json['checkin_status']	= 'closed';
	}

	if(post_type_supports($post_type, 'applys')){
		$post_json['apply_status']	= 'open';
		$post_json['apply_count']	= intval(get_post_meta($post_id, 'checkins', true));
	}else{
		$post_json['apply_status']	= 'closed';
	}

	if(post_type_supports($post_type, 'rating')){
		$post_json['rating_status']	= 'open';
	}else{
		$post_json['rating_status']	= 'closed';
	}

	if(is_singular($post_type)){
		if($post_json['comment_status']	== 'closed'){
			$post_json['comment_digg']	= false;
			$post_json['reply_type']	= 'disabled';
		}else{
			$post_json['comment_digg']	= post_type_supports($post_type, 'comment_digg');
			$post_json['reply_type']	= get_post_type_support_value($post_type, 'reply_type') ?: 'disabled';
		}

		if(post_type_supports($post_type, 'comments')){
			$post_json['comments']	= WPJAM_Comment::get_comments(compact('post_id'));
		}else{
			// $post_json['comments']	= [];
		}

		if(post_type_supports($post_type, 'favs')){
			$is_faved	= WPJAM_Comment::did_action($post_id, 'fav');

			$post_json['is_faved']	= $is_faved && !is_wp_error($is_faved);
		}

		if(post_type_supports($post_type, 'likes')){
			$is_liked	= WPJAM_Comment::is_liked($post_id);

			$post_json['is_liked']	= $is_liked && !is_wp_error($is_liked);
			$post_json['likes']		= WPJAM_Comment::get_likes($post_id);
		}

		if(post_type_supports($post_type, 'checkins')){
			$is_checkined	= WPJAM_Comment::did_action($post_id, 'checkin');

			$post_json['is_checkined']	= $is_checkined && !is_wp_error($is_checkined);
			$post_json['checkins']		= WPJAM_Comment::get_comments(['post_id'=>$post_id,	'type'=>'checkin']);;
		}

		if(post_type_supports($post_type, 'applies')){
			$is_applied	= WPJAM_Comment::did_action($post_id, 'apply');

			$post_json['is_applied']	= $is_applied && !is_wp_error($is_applied);
			$post_json['applies']		= WPJAM_Comment::get_comments(['post_id'=>$post_id,	'type'=>'apply']);;
		}
	}

	return $post_json;
}, 1, 2);



	