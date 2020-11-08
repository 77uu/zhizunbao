<?php
function wpjam_ajax_comment_digg(){
	$comment_id	= intval($_POST['comment_id']);
	$digg_type	= sanitize_key($_POST['digg_type']);

	if($comment_id){
		$result	= WPJAM_Comment::digg($comment_id, $digg_type);

		if(is_wp_error($result)){
			wpjam_send_json($result);
		}else{
			wpjam_send_json(['digg_count'=>get_comment_meta($comment_id, 'digg_count', true)]);
		}
	}
}

add_action('wp_ajax_comment_digg',			'wpjam_ajax_comment_digg');
add_action('wp_ajax_nopriv_comment_digg',	'wpjam_ajax_comment_digg');

function wpjam_get_post_action_button($post_id, $action='like', $show_label=true){
	$meta_key		= str_replace('un', '', $action).'s';
	$action_count	= get_post_meta($post_id, $meta_key, true); 

	if($action == 'like'){
		$dashicons	= 'heart';
		$class		= 'post-like ';
		$label		= $show_label ? '赞 ' : '';

		if(WPJAM_Comment::is_liked($post_id)){
			$action_type	= 'unlike';
			$class			.= 'is-liked';
		}else{
			if(isset($_COOKIE['liked_'.$post_id]) && $_COOKIE['liked_'.$post_id] == $post_id){
				$action_type	= 'unlike';
				$class			.= 'is-liked';
			}else{
				$action_type	= 'like';
				$class			.= 'is-unliked'; 
			}
		}
	}elseif($action == 'fav'){
		$class	= 'post-fav ';
		$label	= $show_label ?  '收藏 ' : '';	
		
		if(WPJAM_Comment::did_action($post_id, $action)){
			$action_type	= 'unfav';
			$class			.= 'is-faved';
			$dashicons		= 'star-filled'; 
		}else{
			$action_type	= 'fav';
			$class			.= 'is-unfaved';
			$dashicons		= 'star-empty'; 
		}
	}else{
		return '';
	}

	return '<a href="javascript:;" class="post-action '.$class.'" data-post_id="'.$post_id.'" data-action_type="'.$action_type.'"><span class="dashicons dashicons-'.$dashicons.'"></span> '.$label.'<span class="post-action-count">'.$action_count.'</span></a>';
}

function wpjam_ajax_post_action(){
	$post_id		= intval($_POST['post_id']);
	$action_type	= sanitize_key($_POST['action_type']);

	if($post_id){
		$result	= WPJAM_Comment::action($post_id, $action_type);

		if(is_wp_error($result)){
			if($action_type == 'like'){
				if(empty($_COOKIE['liked_'.$post_id]) || $_COOKIE['liked_'.$post_id] != $post_id){
					$action_count	= get_post_meta($post_id, 'likes', true) ?: 0;

					wpjam_set_cookie('liked_'.$post_id, $post_id);
					update_post_meta($post_id, 'likes', $action_count+1);
				}
			}elseif($action_type == 'unlike'){
				if(isset($_COOKIE['liked_'.$post_id]) && $_COOKIE['liked_'.$post_id] == $post_id){
					$action_count	= get_post_meta($post_id, 'likes', true) ?: 0;

					wpjam_clear_cookie('liked_'.$post_id);
					$action_count	= $action_count-1;
					$action_count	= $action_count > 0 ? $action_count : 0; 
					update_post_meta($post_id, 'likes', $action_count);
				}
			}else{
				wpjam_send_json($result);
			}
		}else{
			if($action_type == 'unlike'){
				wpjam_clear_cookie('liked_'.$post_id);
			}
		}

		$meta_key	= str_replace('un', '', $action_type).'s';
		$response	= ['action_count'=>get_post_meta($post_id, $meta_key, true)];

		if(in_array($action_type, ['like', 'unlike'])){
			$response['likes']	= WPJAM_Comment::get_likes($post_id);
		}

		wpjam_send_json($response);
	}
}
add_action('wp_ajax_post_action',			'wpjam_ajax_post_action');
add_action('wp_ajax_nopriv_post_action',	'wpjam_ajax_post_action');

add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style('dashicons');

	if(function_exists('wpjam_register_static')){
		wpjam_register_static('wpjam-action-style', [
			'type'		=> 'style',
			'source'	=> 'value',
			'value' 	=> '.comment .dashicons{line-height: inherit;}
	a.comment-digg{float: right; margin-left: 10px;}
	a.comment-digg.is-undigged{color:#666;}'
		]);

		wpjam_register_static('wpjam-comment-inline-script', [
			'type'		=> 'script',
			'source'	=> 'value',
			'value' 	=> 'if (typeof ajaxurl == "undefined")  var ajaxurl	= "'.admin_url('admin-ajax.php').'";'
		]);

		wpjam_register_static('wpjam-comment-script', [
			'type'		=> 'script',
			'source'	=> 'file',
			'file' 		=> WPJAM_COMMENT_PLUGIN_DIR.'static/action.js'
		]);
	}else{
		wp_add_inline_style('dashicons', '.comment .dashicons{line-height: inherit;}
	a.comment-digg{float: right; margin-left: 10px;}
	a.comment-digg.is-undigged{color:#666;}');
		wp_enqueue_script('wpjam-action', home_url(str_replace(ABSPATH, '/', WPJAM_COMMENT_PLUGIN_DIR).'static/action.js'), ['jquery']);
		wp_add_inline_script('wpjam-action', 'if (typeof ajaxurl == "undefined")  var ajaxurl	= "'.admin_url('admin-ajax.php').'";',	'before');
	}
});