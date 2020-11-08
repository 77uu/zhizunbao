<?php 
class WPJAM_Posts_List_Table extends WPJAM_List_Table{
	private $post_type	= '';

	public function __construct($args = []){
		$current_screen	= get_current_screen();

		$screen_id	= $current_screen->id;
		$post_type	= $screen_id == 'upload' ? 'attachment' : $current_screen->post_type;
		$pt_obj		= get_post_type_object($post_type);

		$this->post_type	= $post_type;
		$args['title']		= $pt_obj->label;
		$args['capability']	= 'edit_post';
		$args['data_type']	= 'post_meta';
		$args['actions']	= apply_filters('wpjam_'.$post_type.'_posts_actions', WPJAM_List_Table_Action::get_all(), $post_type);

		if(isset($args['actions']['add']) && empty($args['actions']['add']['capability'])){
			$args['actions']['add']['capability']	= $pt_obj->cap->create_posts;
		}

		$this->_args	= $this->parse_args($args);

		if(wp_doing_ajax()){
			add_action('wp_ajax_wpjam-list-table-action',	[$this, 'ajax_response']);
		}else{
			add_action('admin_head',	[$this, 'admin_head']);
			add_action('admin_footer',	[$this, '_js_vars']);

			if(isset($args['actions']['add'])){
				add_action('wpjam_html',	[$this, 'html_replace']);
			}
		}

		add_action('pre_get_posts',	[$this, 'pre_get_posts']);

		add_filter('bulk_actions-'.$screen_id,	[$this, 'posts_bulk_actions']);
		
		if($post_type == 'attachment'){
			add_filter('media_row_actions',		[$this, 'post_row_actions'],1,2);

			add_filter('manage_media_columns',			[$this, 'manage_posts_columns']);
			add_filter('manage_media_custom_column',	[$this, 'manage_posts_custom_column', 10, 2]);
		}else{
			if(is_post_type_hierarchical($post_type)){
				add_filter('page_row_actions',	[$this, 'post_row_actions'],1,2);
			}else{
				add_filter('post_row_actions',	[$this, 'post_row_actions'],1,2);
			}

			add_filter('manage_'.$post_type.'_posts_columns',		[$this, 'manage_posts_columns']);
			add_action('manage_'.$post_type.'_posts_custom_column',	[$this, 'manage_posts_custom_column'], 10, 2);
		}

		add_filter('manage_'.$screen_id.'_sortable_columns',	[$this, 'manage_posts_sortable_columns']);
	}

	protected function get_nonce_action($key, $id=0){
		$nonce_action	= $key.'-'.$this->post_type.'-posts';
		
		return $id ? $nonce_action.'-'.$id : $nonce_action;
	}

	protected function get_items($ids){
		return WPJAM_Post::get_by_ids($ids);	
	}

	protected function get_item($id){
		return WPJAM_Post::get($id);
	}

	protected function filter_fileds($fields, $key, $id){
		$fields	= apply_filters('wpjam_'.$this->post_type.'_posts_fields', $fields, $key, $id, $this->post_type);

		if($key && $id && !is_array($id)){
			$fields	= array_merge(['title'=>['title'=>$this->_args['title'].'标题', 'type'=>'view', 'value'=>get_post($id)->post_title]], $fields);
		}

		return $fields;
	}

	protected function filter_list_action_result($result, $list_action, $id, $data){
		$hook	= 'wpjam_'.$this->post_type.'_posts_list_action';
		return apply_filters($hook, $result, $list_action, $id, $data, $this->post_type
		);
	}

	public function single_row($raw_item){
		global $post, $authordata;

		if(is_numeric($raw_item)){
			$post	= get_post($raw_item);
		}else{
			$post	= $raw_item;	
		}
		
		$authordata = get_userdata($post->post_author);
		$post_type	= $post->post_type;

		if($post_type == 'attachment'){
			$wp_list_table = _get_list_table('WP_Media_List_Table', ['screen'=>get_current_screen()]);

			$post_owner = ( get_current_user_id() == $post->post_author ) ? 'self' : 'other';
			?>
			<tr id="post-<?php echo $post->ID; ?>" class="<?php echo trim( ' author-' . $post_owner . ' status-' . $post->post_status ); ?>">
				<?php $wp_list_table->single_row_columns($post); ?>
			</tr>
			<?php
		}else{
			$wp_list_table = _get_list_table('WP_Posts_List_Table', ['screen'=>get_current_screen()]);
			$wp_list_table->single_row($post);
		}
	}

	public function post_row_actions($row_actions, $post){
		if($post->post_status == 'trash'){
			$row_actions['post_id'] = 'ID: '.$post->ID;
			return $row_actions;
		}

		if($this->_args['actions']){
			$actions	= [];

			foreach($this->_args['actions'] as $key => $action){
				if(isset($action['post_status'])){
					$post_statuses	= is_array($action['post_status']) ? $action['post_status'] : [$action['post_status']];
					
					if(!in_array($post->post_status, $post_statuses)){
						continue;
					}
				}

				$actions[$key]	= $action;
			}

			if($actions){
				$row_actions	= array_merge($row_actions, $this->get_row_actions($actions, $post->ID, $post));
			}
		}

		if(isset($row_actions['trash'])){
			$trash	= $row_actions['trash'];
			unset($row_actions['trash']);

			$row_actions['trash']	= $trash;
		}

		$row_actions['post_id'] = 'ID: '.$post->ID;

		return $row_actions;
	}

	public function posts_bulk_actions($bulk_actions=[]){
		return array_merge($bulk_actions, $this->_args['bulk_actions']);
	}

	public function manage_posts_columns($columns){
		if($this->_args['columns']){
			wpjam_array_push($columns, $this->_args['columns'], 'date'); 
		}

		return $columns;
	}

	public function manage_posts_custom_column($column_name, $post_id){
		if(metadata_exists('post', $post_id, $column_name)){
			$column_value	= get_post_meta($post_id, $column_name, true);	
		}else{
			$column_value	= null;
		}

		echo $this->column_callback($column_value, $column_name, $post_id) ?? '';
	}

	public function manage_posts_sortable_columns($columns){
		return array_merge($columns, $this->_args['sortable_columns']);
	}

	public function html_replace($html){
		$add_button	= $this->get_row_action('add', ['class'=>'page-title-action']);
		return preg_replace('/<a href=".*?" class="page-title-action">.*?<\/a>/i', $add_button, $html);
	}

	public function pre_get_posts($wp_query){
		if($sortable_columns = $this->_args['sortable_columns']){
			$orderby	= $wp_query->get('orderby');

			if($orderby && is_string($orderby) && isset($sortable_columns[$orderby])){
				$fields	= $this->get_fields();
				$field	= $fields[$orderby] ?? '';

				$orderby_type = $field['sortable_column'] ?? 'meta_value';

				if(in_array($orderby_type, ['meta_value_num', 'meta_value'])){
					$wp_query->set('meta_key', $orderby);
					$wp_query->set('orderby', $orderby_type);
				}else{
					$wp_query->set('orderby', $orderby);
				}
			}
		}
	}

	public function admin_head(){
		if($bulk_actions = $this->_args['bulk_actions']){
		?>

		<script type="text/javascript">
		jQuery(function($){
			<?php 
			foreach($bulk_actions as $action_key => $bulk_action) { 
				$bulk_action	= $this->_args['actions'][$action_key];

				$datas	= ['action'=>$action_key, 'bulk'=>true];

				$datas['page_title']	= $bulk_action['page_title']??$bulk_action['title']; 
				$datas['nonce']			= $this->create_nonce('bulk_'.$action_key); 

				if(!empty($bulk_action['direct'])){
					$datas['direct']	= true;
				}

				if(!empty($bulk_action['confirm'])){
					$datas['confirm']	= true;
				}

				echo '$(\'.bulkactions option[value='.$action_key.']\').data('.wpjam_json_encode($datas).')'."\n";
			} 
			?>
		});
		</script>

		<?php }
	}
}