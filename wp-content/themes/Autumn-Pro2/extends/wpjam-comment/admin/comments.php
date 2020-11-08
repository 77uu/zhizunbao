<?php
add_filter('wpjam_comments_list_table', function(){
	global $plugin_page;

	$comment_type_options	= WPJAM_AdminComment::get_comment_type_options();

	$post_type		= wpjam_get_data_parameter('post_type') ?: 'post';
	$reply_type		= get_post_type_support_value($post_type, 'reply_type');
	$comment_type	= str_replace([$post_type.'-', 's'], '', $plugin_page);

	WPJAM_AdminComment::set_comment_type($comment_type);
	WPJAM_AdminComment::set_reply_type($reply_type);
	WPJAM_AdminComment::set_post_type($post_type);
	
	return [
		'title'		=>get_post_type_object($post_type)->label.$comment_type_options[$comment_type],
		'plural'	=>$comment_type.'s',
		'singular'	=>$comment_type,
		'model'		=>'WPJAM_AdminComment',
		'layout'	=>2,
		'left_keys'	=>['post_id'],
		'per_page'	=>$comment_type == 'like' ? 9999 : 20,
		'fixed'		=>false,
		'ajax'		=>true
	];
});

add_action('admin_head', function(){
	?>
	<style type="text/css">
	th.column-author{min-width: 210px;}
	th.column-rating{width: 110px;}
	th.column-comment_date{width: 100px;}
	th.column-digg_count{width: 64px;}
	td div.admin_reply{background: #ffe; padding:1px 4px;}

	#col-left{width: 30%;}
	#col-right{width: 70%}

	@media screen and (max-width: 782px) {
		#col-left,#col-right{width: auto;}
	}

	div#col-left h2{margin-top:18px;}
	div#col-left td{padding-left: 14px; padding-right: 20px;}
	div#col-left td a:focus{box-shadow: inherit;}
	span.post-time{font-size:smaller;}
	span.comment-count{font-size:smaller;float:right; padding:2px 4px;}
	span.comment-count a{color:inherit;}
	span.comment-sticky{margin-right: 4px;}
	.comment-rating{font-size: 14px;}

	p span.apply-key{display: inline-block; width: 80px;}
	</style>
	<script type="text/javascript">
	jQuery(function($){
		$('body').on('click', 'a.reply_to', function(event){
			var parent	= $(this).data('parent');
			var top		= $('#comment-'+parent).offset().top-40;

			$('html').animate({scrollTop: top}, 500, function(){
				$('#comment-'+parent).animate({opacity: 0.1}, 500).animate({opacity: 1}, 500);
			});

		    event.preventDefault();
		});

		$('body').on('list_table_action_success', function(event, response){
			if(response.list_action_type == 'list'){
				if(wpjam_page_setting.params.post_id){
					$('#col-left tr td').removeClass('highlight');
					$('#col-left tr#post_'+wpjam_page_setting.params.post_id+' td').addClass('highlight');
				}
			}
		});

	});
	</script>
	<?php
});

class WPJAM_AdminComment extends WPJAM_Comment{
	protected static $comment_type	= 'comment';
	protected static $reply_type	= '';
	protected static $post_type		= 'post';

	public static function reply($id, $data){
		$reply_id	= $data['reply_id'] ?? 0;
		$reply_text	= $data['reply_text'] ?? '';

		if(empty($reply_text)){
			return new WP_Error('empty_reply', '回复的文本不能为空');
		}

		if($reply_id){
			return self::update($reply_id, ['comment'=>$reply_text]);
		}else{
			return self::insert([
				'user_id'	=> get_current_user_id(),
				'post_id'	=> get_comment($id)->comment_post_ID,
				'comment'	=> $reply_text,
				'parent'	=> $id,
			]);
		}	
	}

	public static function delete($id, $force_delete=true){
		$post_id	= parent::get_post_id($id);
		$result		= parent::delete($id, $force_delete);

		if($result && !is_wp_error($result)){
			self::update_count($post_id, self::get_comment_type());
		}

		return $result;
	}

	public static function get_comment_type(){
		return static::$comment_type;
	}

	public static function set_comment_type($comment_type){
		static::$comment_type	= $comment_type;
	}

	public static function set_reply_type($reply_type){
		static::$reply_type	= $reply_type;
	}

	public static function get_reply_type(){
		return static::$reply_type;
	}

	public static function get_post_type(){
		return static::$post_type;
	}

	public static function set_post_type($post_type){
		static::$post_type	= $post_type;
	}

	public static function get_wp_query(){
		static $wp_query;

		$left_paged	= wpjam_get_data_parameter('left_paged') ?: 1;

		if(!isset($wp_query)){
			$wp_query	= new WP_Query([
				'post_type'			=> self::get_post_type(),
				'post_status'		=> '',
				'posts_per_page'	=> 10,
				'paged'				=> $left_paged
			]);
		}

		return $wp_query;
	}

	public static function query_items($limit, $offset){
		$post_id	= wpjam_get_data_parameter('post_id',	['sanitize_callback'=>'intval']);
		
		if(empty($post_id)){
			$wp_query	= self::get_wp_query();
			$posts		= $wp_query->posts;

			if(empty($posts)){
				return ['items'=>[], 'total'=>0];
			}

			$post_id	= $posts[0]->ID;
		}

		$comment_type	= self::get_comment_type();

		if($comment_type == 'like'){
			$items	= self::get_likes($post_id);
			$total	= count($items);
		}else{
			$args	= [
				'number'	=> $limit,
				'offset'	=> $offset,
				'type'		=> $comment_type,
				'post_id'	=> $post_id,
				// 'post_type'	=> self::get_post_type(),
				'no_found_rows'	=> false,
				'update_comment_meta_cache'	=> true,
				'update_comment_post_cache'	=> true,
			];

			// $author_email	= wpjam_get_data_parameter('author_email',	['sanitize_callback'=>'is_email']);
			// $user_id		= wpjam_get_data_parameter('user_id',		['sanitize_callback'=>'intval']);
			// if($author_email){
			// 	$args['author_email']	= $author_email;
			// }elseif($user_id){
			// 	$args['user_id']		= $user_id;
			// }

			$post_type	= self::get_post_type();
			$orderby	= wpjam_get_data_parameter('orderby',	['sanitize_callback'=>'sanitize_key']);
			$order		= wpjam_get_data_parameter('order',		['sanitize_callback'=>'sanitize_key']);

			$args['orderby']	= $orderby ?: (post_type_supports($post_type, 'comment_digg') ? 'digg_count' : 'comment_date');
			$args['order']		= $order == 'desc' ? 'desc': 'asc';

			if($comment_type == 'comment'){
				$args['sticky_comments']	= self::get_sticky_comments($post_id);

				$reply_type	= self::get_reply_type();
			}

			if($comment_type == 'comment' && $reply_type != 'disabled'){
				$args['hierarchical']	= 'threaded';

				$query		= new WP_Comment_Query($args);
				$total		= $query->found_comments;
				$comments	= $query->comments;
				$comments	= array_values($comments);

				$items	= [];

				if($comments){
					foreach($comments as $_comment){
						$comment_children	= $_comment->get_children([
							'format'  => 'flat',
						]);

						if($reply_type == 'admin_reply'){
							foreach($comment_children as $comment_child){
								if($comment_child->user_id && user_can($comment_child->user_id, 'manage_options')){
									$_comment->admin_reply	= $comment_child;
									break;
								}
							}
							
							$items[]	= $_comment;
						}else{
							$items[]	= $_comment;

							foreach($comment_children as $comment_child){
								$items[] = $comment_child;
							}
						}	
					}
				}
			}else{
				$query	= new WP_Comment_Query($args);
				$total	= $query->found_comments;
				$items	= $query->comments;
			}
		}

		return compact('items', 'total');
	}

	public static function item_callback($item){
		$comment_id 	= $item['comment_ID'];
		$comment		= get_comment($comment_id);
		$post_id		= $item['comment_post_ID'];
		$left_paged		= wpjam_get_data_parameter('left_paged') ?: 1;

		$comment_type	= self::get_comment_type();
		
		if($item['comment_parent']){
			$pad	= '<span style="float:left; margin-right:10px;">'.str_repeat('&emsp; ', 1).'</span>';

			$item['author']	= '<img src="'.get_avatar_url($comment).'" width="24">'.$item['comment_author'];
			$item['author']	= $pad.$item['author'];

			unset($item['row_actions']['stick']);
			unset($item['row_actions']['unstick']);
		}else{
			if($comment_type == 'like'){
				$item['author']	= '<img src="'.$item['avatar'].'" width="32">'.$item['nickname'];
			}else{
				$item['author']	= '<img src="'.get_avatar_url($comment).'" width="32">'.$item['comment_author'];
			}

			if($comment_type == 'comment'){
				if($item['comment_approved']){
					if($item['comment_sticky']){
						$item['author']	= '<span class="comment-sticky">🔝</span>'.$item['author'];
						unset($item['row_actions']['stick']);
					}else{
						unset($item['row_actions']['unstick']);
					}
				}else{
					unset($item['row_actions']['stick']);
					unset($item['row_actions']['unstick']);
				}
			}elseif($comment_type == 'apply'){
				// $datas 	= maybe_unserialize($item['comment']);

				$item['datas']	= '';

				$datas	= $item['comment_content'] ? maybe_unserialize($item['comment_content']) : [];

				if($datas){
					foreach($datas as $key => $value){
						if(is_array($value)){
							$value	= implode("&emsp;", $value);
						}
						
						$item['datas']	.= '<p><span class="apply-key">'.wp_strip_all_tags($key).'</span><span class="apply-value">'.wp_strip_all_tags($value).'</span></p>';
					}
				}
			}
			// if($item['user_id']){
			// 	$item['author']	= wpjam_get_list_table_filter_link(['left_paged'=>$left_paged, 'post_id'=>$post_id, 'user_id'=>$item['user_id']], $item['author']);
			// }else{
			// 	$item['author']	= wpjam_get_list_table_filter_link(['left_paged'=>$left_paged, 'post_id'=>$post_id, 'author_email'=>$item['comment_author_email']], $item['author']);
			// }
			
		}

		$fields	= self::get_fields();

		if(isset($fields['rating'])){
			if($rating	= get_comment_meta($comment_id, 'rating', true)){
				$item['rating']	= str_repeat('<span class="dashicons comment-rating dashicons-star-filled"></span>', intval($rating));

				if($rating - intval($rating) == 0.5){
					$item['rating']	.= '<span class="dashicons comment-rating dashicons-star-half"></span>';
				}
			}
		}

		if(isset($fields['comment'])){
			$item['class']		= $item['comment_approved'] ? 'approved' : 'unapproved';

			$item['comment']	= $item['comment_content'];

			$images	= get_comment_meta($comment_id, 'images', true);

			if($images && is_array($images)){
				$images_str	= '';

				foreach ($images as $image) {
					$images_str	.= '<a title="'.esc_attr($item['comment_content']).'" class="thickbox" rel="images-'.$comment_id.'" href="'.wpjam_get_thumbnail($image, 600).'"><img src="'.wpjam_get_thumbnail($image, 120, 120).'" width="60" /></a> ';
 				}

 				$item['comment']	.= "\n\n".$images_str; 
			}

			$reply_type	= self::get_reply_type();

			if($reply_type == 'admin_reply'){
				if(isset($item['admin_reply'])){
					$admin_reply	= $item['admin_reply'];
				}else{
					$admin_reply	= null;
					$comment_children	= $comment->get_children(['format'=>'flat']);
					foreach($comment_children as $comment_child){
						if($comment_child->user_id && user_can($comment_child->user_id, 'manage_options')){
							$admin_reply	= $comment_child;
							break;
						}
					}
				}

				if($admin_reply){
					$reply_action	= wpjam_get_list_table_row_action('reply',[
						'id'	=> $comment_id,
						'data'	=> ['reply_id'=>$admin_reply->comment_ID],
						'title'	=> '修改',
					]);

					$item['comment']	.= '<div class="admin_reply">'.wpautop('管理员回复（'.$reply_action."）：".$admin_reply->comment_content).'</div>'; 

					unset($item['row_actions']['reply']);
				}
			}elseif($reply_type == 'all'){
				static $top_comment_id;

				if($item['comment_parent']){
					if(isset($top_comment_id) && $top_comment_id != $item['comment_parent']){
						if($parent_comment	= get_comment($item['comment_parent'])){
							$item['comment']	=  '<a class="reply_to" data-parent="'.$item['comment_parent'].'" href="#comment-'.$item['comment_parent'].'">@'.$parent_comment->comment_author.'</a> '.$item['comment'];	
						}
					}
				}else{
					$top_comment_id	= $comment_id;
				}
			}

			$item['comment']	= wpautop($item['comment']);
		}

		return $item;
	}

	public static function get_primary_key(){
		return 'comment_ID';
	}

	public static function get_actions(){
		$comment_type	= self::get_comment_type();

		if($comment_type == 'comment'){
			return [
				'approve'	=> ['title'=>'批准',		'direct'=>true],
				'unapprove'	=> ['title'=>'驳回',		'direct'=>true],
				'stick'		=> ['title'=>'置顶',		'direct'=>true, 'confirm'=>true],
				'unstick'	=> ['title'=>'取消置顶',	'direct'=>true, 'confirm'=>true],
				'reply'		=> ['title'=>'回复'],
				'delete'	=> ['title'=>'删除',		'direct'=>true, 'confirm'=>true, 'bulk'=>true],
			];
		}elseif($comment_type == 'like'){
			return [];
		}else{
			return [
				'delete'	=> ['title'=>'删除',		'direct'=>true, 'confirm'=>true, 'bulk'=>true],
			];
		}
	}

	public static function get_fields($action_key='', $id=0){
		if($action_key == 'reply'){
			
			$reply_id	= wpjam_get_data_parameter('reply_id') ?? '';
			$reply_text	= $reply_id ? get_comment($reply_id)->comment_content: '';

			return	[
				'reply_id'		=>['title'=>'',	'type'=>'hidden',	'value'=>$reply_id],
				'reply_text'	=>['title'=>'',	'type'=>'textarea',	'value'=>$reply_text]
			];
		}else{
			$fields	= [];

			$fields['author']	= ['title'=>'用户',		'type'=>'text',		'show_admin_column'=>'only'];

			$comment_type		= self::get_comment_type();

			if($comment_type == 'comment'){
				$fields['comment']		= ['title'=>'评论',		'type'=>'textarea',	'show_admin_column'=>'only'];

				$post_type	= self::get_post_type();

				if(post_type_supports($post_type, 'rating')){
					$fields['rating']	= ['title'=>'评分',		'type'=>'number',	'show_admin_column'=>'only'];
				}

				if(post_type_supports($post_type, 'comment_digg')){
					$fields['digg_count']		= ['title'=>'点赞',		'type'=>'number',	'show_admin_column'=>'only'];
				}
			}elseif($comment_type == 'checkin'){
				$fields['longitude']	= ['title'=>'经度',	'type'=>'text',		'show_admin_column'=>'only'];
				$fields['latitude']		= ['title'=>'纬度',	'type'=>'text',		'show_admin_column'=>'only'];
			}elseif($comment_type == 'apply'){
				$fields['datas']		= ['title'=>'数据',	'type'=>'text',		'show_admin_column'=>'only'];
			}

			if($comment_type != 'like'){
				$fields['comment_date']	= ['title'=>'提交于',	'type'=>'text',		'show_admin_column'=>'only',	'sortable_column'=>true];
			}

			return $fields;
		}
	}

	public static function get_comment_type_options(){
		return [
			'comment'	=> '评论',
			'fav'		=> '收藏',
			'like'		=> '点赞',
			'checkin'	=> '签到',
			'apply'		=> '申请',
		];
	}

	public static function col_left(){
		$post_type	= self::get_post_type();
		$wp_query	= self::get_wp_query();
		$left_paged	= wpjam_get_data_parameter('left_paged') ?: 1;
		$post_id	= wpjam_get_data_parameter('post_id');

		$pt_label	= get_post_type_object($post_type)->label;
		
		echo '<h2>'.$pt_label.'列表</h2>';

		?>

		<table class="widefat striped">
			<thead>
				<tr><th><?php echo $pt_label; ?></th></tr>
			</thead>
			<tbody>
			<?php 

			if($wp_query->have_posts()){

			$posts	= $wp_query->posts;

			if($post_id){
				$post_ids	= wp_list_pluck($posts, 'ID');

				if(!in_array($post_id, $post_ids)){ 
					array_unshift($posts, get_post($post_id));
				}
			}else{
				$post_id	= $posts[0]->ID;
			}
			?>
			<?php foreach ($posts as $post) { ?>
				<tr data-id="<?php echo $post->ID;;?>" id="post_<?php echo $post->ID;;?>">
					<td<?php if($post_id == $post->ID){ echo ' class="highlight"'; } ?>>
						<?php 

						$post_card	= '<p class="row-title"><span class="post-title">'.get_the_title($post).'</span>'._post_states($post, false).'</p>';

						$post_card	.= '<p>';

						$post_card	.= '<span class="post-time">'. get_the_time('Y-m-d H:i:s', $post). '</span>';

						if(self::get_comment_type() == 'comment'){
							$post_card	.= '<span class="comment-count wp-ui-highlight">'. (get_comments_number($post) ? get_comments_number($post).'条评论': (comments_open($post) ? '暂无评论' : '评论未开启')).'</span>';	
						}else{
							$number		= intval(get_post_meta($post->ID, self::get_comment_type().'s', true));
							$label		= self::get_comment_type_options()[self::get_comment_type()];
							$post_card	.= '<span class="comment-count wp-ui-highlight">'. ($number ? $number.' '.$label : '暂无'.$label).'</span>';
						}

						$post_card	.= '</p>'; 

						echo wpjam_get_list_table_filter_link(['post_id'=>$post->ID, 'left_paged'=>$left_paged], $post_card);?>
					</td>
				</tr>
			<?php } }else{ ?>
				<tr class="no-items"><td class="colspanchange">找不到<?php echo $pt_label;?>。</td></tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr><th><?php echo $pt_label; ?></th></tr>
			</tfoot>
		</table>

		<?php
		$total_items	= $wp_query->found_posts;
		$per_page		= 10;

		global $wpjam_list_table;

		$wpjam_list_table->set_left_pagination_args(compact('total_items', 'per_page'));
	}
}