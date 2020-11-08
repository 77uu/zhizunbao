<?php
class WPJAM_Terms_List_Table extends WPJAM_List_Table{
	private $taxonomy	= '';

	public function __construct($args = []){
		$current_screen	= get_current_screen();

		$screen_id	= $current_screen->id;
		$taxonomy	= $current_screen->taxonomy;
		$tax_obj	= get_taxonomy($taxonomy);

		$this->taxonomy		= $taxonomy;
		$args['title']		= $tax_obj->label;
		$args['capability']	= $tax_obj->cap->edit_terms;
		$args['data_type']	= 'term_meta';
		$args['actions']	= apply_filters('wpjam_'.$taxonomy.'_terms_actions', WPJAM_List_Table_Action::get_all(), $taxonomy);

		$this->_args	= $this->parse_args($args);

		if(wp_doing_ajax()){
			add_action('wp_ajax_wpjam-list-table-action', [$this, 'ajax_response']);
		}else{
			add_action('admin_head',	[$this, 'admin_head']);
			add_action('admin_footer',	[$this, '_js_vars']);
		}

		add_filter('bulk_actions'.$screen_id, 		[$this, 'terms_bulk_actions']);

		add_filter($taxonomy.'_row_actions',		[$this, 'term_row_actions'],1,2);

		add_action('parse_term_query',	[$this, 'parse_term_query']);
		
		add_filter('manage_'.$screen_id.'_columns',				[$this, 'manage_terms_columns']);
		add_filter('manage_'.$taxonomy.'_custom_column',		[$this, 'manage_terms_custom_column'],10,3);
		add_filter('manage_'.$screen_id.'_sortable_columns',	[$this, 'manage_terms_sortable_columns']);
	}

	protected function get_nonce_action($key, $id=0){
		$nonce_action	= $key.'-'.$this->taxonomy.'-terms';
		
		return $id ? $nonce_action.'-'.$id : $nonce_action;
	}

	protected function get_items($ids){
		return WPJAM_Term::get_by_ids($ids);
	}

	protected function get_item($id){
		return WPJAM_Term::get($id);
	}

	protected function filter_fileds($fields, $key, $id){
		$fields		= apply_filters('wpjam_'.$this->taxonomy.'_terms_fields', $fields, $key, $id, $this->taxonomy);

		if($key && $id && !is_array($id)){
			$fields	= array_merge(['title'=>['title'=>$this->_args['title'], 'type'=>'view', 'value'=>get_term($id)->name]], $fields);
		}

		return $fields;
	}

	protected function filter_list_action_result($result, $list_action, $id, $data){
		$hook	= 'wpjam_'.$this->taxonomy.'_terms_list_action';
		return apply_filters($hook, $result, $list_action, $id, $data, $this->taxonomy);
	}

	public function single_row($raw_item){
		if(is_numeric($raw_item)){
			$term	= get_term($raw_item);
		}else{
			$term	= $raw_item;
		}

		$level	= $term->parent ? count(get_ancestors($term->term_id, get_current_screen()->taxonomy, 'taxonomy')) : 0;

		$wp_list_table = _get_list_table('WP_Terms_List_Table', ['screen'=>get_current_screen()]);
		$wp_list_table->single_row($term, $level);
	}

	public function term_row_actions($row_actions, $term){
		if($this->_args['actions']){
			$actions	= [];

			foreach($this->_args['actions'] as $key => $action){
				if(isset($action['parent'])){
					if($term->parent != $action['parent']){
						continue;
					}
				}

				$actions[$key]	= $action;
			}

			if($actions){
				$row_actions	= array_merge($row_actions, $this->get_row_actions($actions, $term->term_id, $term));
			}
		}

		$tax_obj	= get_taxonomy($term->taxonomy);
		$supports	= $tax_obj->supports;

		if(!in_array('slug', $supports)){
			unset($row_actions['inline hide-if-no-js']);
		}

		$row_actions['term_id'] = 'ID：'.$term->term_id;
		
		return $row_actions;
	}

	public function manage_terms_columns($columns){
		$tax_obj	= get_taxonomy($this->taxonomy);
		$supports	= $tax_obj->supports;

		if(!in_array('slug', $supports)){
			unset($columns['slug']);
		}

		if(!in_array('description', $supports)){
			unset($columns['description']);
		}

		if($this->_args['columns']){
			wpjam_array_push($columns, $this->_args['columns'], 'posts'); 
		}

		return $columns;
	}

	public function manage_terms_custom_column($value, $column_name, $term_id){
		if(metadata_exists('term', $term_id, $column_name)){
			$column_value = get_term_meta($term_id, $column_name, true);
		}else{
			$column_value = null;
		}

		return $this->column_callback($column_value, $column_name, $term_id) ?? $value;
	}

	public function manage_terms_sortable_columns($columns){
		return array_merge($columns, $this->_args['sortable_columns']);
	}

	public function parse_term_query($term_query){
		if($sortable_columns	= $this->_args['sortable_columns']){
			$orderby	= $term_query->query_vars['orderby'];

			if($orderby && isset($sortable_columns[$orderby])){

				$fields	= $this->get_fields();
				$field	= $fields[$orderby] ?? '';

				$orderby_type = ($field['sortable_column'] == 'meta_value_num')?'meta_value_num':'meta_value';

				$term_query->query_vars['meta_key']	= $orderby;
				$term_query->query_vars['orderby']	= $orderby_type;
			}
		}
	}

	public function terms_bulk_actions($bulk_actions=[]){
		return array_merge($bulk_actions, $this->_args['bulk_actions']);
	}

	public function admin_head(){
		if($bulk_actions = $this->_args['bulk_actions']){ $actions = $this->_args['actions']; ?>

		<script type="text/javascript">
		jQuery(function($){
			<?php foreach($bulk_actions as $action_key => $bulk_action) { 
				$bulk_action	= $actions[$action_key];

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
			}?>
		});
		</script>

		<?php } 
	}
}