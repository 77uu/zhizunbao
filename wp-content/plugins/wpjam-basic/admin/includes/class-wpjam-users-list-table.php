<?php 
class WPJAM_Users_List_Table extends WPJAM_List_Table{
	public function __construct($args = []){
		$current_screen	= get_current_screen();

		$screen_id	= $current_screen->id;
		
		$args['data_type']	= 'user_meta';
		$args['title']		= '用户';
		$args['capability']	= 'edit_user';
		$args['actions']	= apply_filters('wpjam_users_actions', WPJAM_List_Table_Action::get_all());

		$this->_args	= $this->parse_args($args);

		if(wp_doing_ajax()){
			add_action('wp_ajax_wpjam-list-table-action', [$this, 'ajax_response']);
		}else{
			add_action('admin_footer',	[$this, '_js_vars']);
		}

		add_filter('user_row_actions',	[$this, 'user_row_actions'], 1, 2);
		
		add_filter('manage_users_columns',			[$this, 'manage_users_columns']);
		add_filter('manage_users_custom_column',	[$this, 'manage_users_custom_column'],10,3);
		add_filter('manage_users_sortable_columns',	[$this, 'manage_users_sortable_columns']);
	}

	protected function get_nonce_action($key, $id=0){
		$nonce_action	= $key.'-users';
		
		return $id ? $nonce_action.'-'.$id : $nonce_action;
	}

	protected function get_items($ids){
		// return WPJAM_User::get_by_ids($ids);	
	}

	protected function get_item($id){
		// return WPJAM_User::get($id);
	}

	protected function filter_fileds($fields, $key, $id){
		$fields		= apply_filters('wpjam_users_fields', $fields, $key, $id);

		if($key && $id && !is_array($id)){
			$fields	= array_merge(['name'=>['title'=>'用户', 'type'=>'view', 'value'=>get_userdata($id)->display_name]], $fields);
		}

		return $fields;
	}

	protected function filter_list_action_result($result, $list_action, $id, $data){
		$hook	= 'wpjam_users_list_action';
		return apply_filters($hook, $result, $list_action, $id, $data, 'user');
	}

	public function single_row($raw_item){
		$wp_list_table = _get_list_table('WP_Users_List_Table', ['screen'=>get_current_screen()]);

		echo $wp_list_table->single_row($raw_item);
	}

	public function user_row_actions($row_actions, $user){
		if($this->_args['actions']){
			$actions	= [];
			
			foreach($this->_args['actions'] as $key => $action){
				if(isset($action['roles'])){
					if(!array_intersect($item->roles, $action['roles'])){
						continue;
					}
				}

				$actions[$key]	= $action;
			}

			if($actions){
				$row_actions	= array_merge($row_actions, $this->get_row_actions($actions, $user->ID, $user));
			}
		}

		$row_actions['user_id'] = 'ID: '.$user->ID;	
		
		return $row_actions;
	}

	public function manage_users_columns($columns){
		if($this->_args['columns']){
			wpjam_array_push($columns, $this->_args['columns'], 'posts'); 
		}

		return $columns;
	}

	public function manage_users_custom_column($value, $column_name, $user_id){
		if(metadata_exists('user', $user_id, $column_name)){
			$column_value = get_user_meta($user_id, $column_name, true);
		}else{
			$column_value = null;
		}

		return $this->column_callback($column_value, $column_name, $user_id) ?? $value;
	}

	public function manage_users_sortable_columns($columns){
		return array_merge($columns, $this->_args['sortable_columns']);
	}
}