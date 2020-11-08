<?php
if(!empty($_GET['p'])){
	$post_id	= $_GET['p'];
	$post_type	= get_post($post_id)->post_type;

	if($post_type == 'post'){
		wp_redirect(admin_url('edit.php?page='.$post_type.'-comments&post_id='.$post_id));
	}else{
		wp_redirect(admin_url('edit.php?post_type='.$post_type.'&page='.$post_type.'-comments&post_id='.$post_id));
	}

	exit;
}

add_filter('comment_email', function($email){
	if(strpos($email, '.weapp') || strpos($email, '.weixin')){
		return '';
	}

	return $email;
}, 9);

add_filter('comments_list_table_query_args', function($args){
	$args['type__not_in']	= ['fav', 'checkin', 'apply'];
	return $args;
});

add_filter('comment_row_actions',function($actions, $comment){
	$actions['comment_id'] = 'ID：'.$comment->comment_ID;

	return $actions;
}, 10, 2);

add_filter('comment_text', function($comment_text, $comment=null){
	if($comment){
		$comment_id	= $comment->comment_ID;

		$images	= get_comment_meta($comment_id, 'images', true);

		if($images && is_array($images)){
			$images_str	= '';

			foreach ($images as $image) {
				$images_str	.= '<a class="thickbox" rel="images-'.$comment_id.'" href="'.wpjam_get_thumbnail($image, 600).'"><img src="'.wpjam_get_thumbnail($image, 120, 120).'" width="60" /></a> ';
				}

				$comment_text	.= "\n\n".$images_str; 
		}

		$post		= get_post($comment->comment_post_ID);
		$post_type	= $post ? $post->post_type : '';

		if($post_type && post_type_supports($post_type, 'rating')){
			if($rating	= get_comment_meta($comment_id, 'rating', true)){
				$rating_text	= str_repeat('<span class="dashicons comment-rating dashicons-star-filled"></span>', intval($rating));

				if($rating - intval($rating) == 0.5){
					$rating_text	.= '<span class="dashicons comment-rating dashicons-star-half"></span>';
				}

				$comment_text	.= '<p>'.$rating_text.'</p>';
			}
		}
	}

	return $comment_text;	
}, 10, 2);

add_action('admin_enqueue_scripts', function(){
	wp_add_inline_style('list-tables', '.comment-rating{font-size:14px;}
		.column-response .post-com-count-pending{line-height: 17px !important;}');
});