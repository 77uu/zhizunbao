<?php
global $taxonomy_levels, $term_parent, $taxonomy_sortable, $term_orderby;

$taxonomy_obj		= get_taxonomy($taxonomy);
$taxonomy_sortable	= $taxonomy_obj->sortable ?? ($taxonomy_obj->order ?? false);
$taxonomy_levels	= $taxonomy_obj->levels ?? 0;
$term_parent		= wpjam_get_data_parameter('parent');

// $term_orderby		= $_REQUEST['orderby'] ?? '';
// unset($_REQUEST['orderby']);

if(is_null($term_parent) && $taxonomy_levels == 1){
	$term_parent	= 0;
}elseif(!is_null($term_parent)){
	$term_parent	= intval($term_parent);
}

if($taxonomy_sortable){
	add_filter('manage_'.get_current_screen()->id.'_columns',function($columns){
		wpjam_array_push($columns, ['sort'=>'排序'], 'posts'); 
		return $columns;
	});

	add_filter('manage_'.$taxonomy.'_custom_column',function ($value, $column_name, $term_id){
		if($column_name == 'sort'){
			global $term_parent;
			
			$value	= '';

			if(empty($_GET['orderby'])){
				$term	= get_term($term_id);

				if($term->parent === $term_parent){
					$value	.= '<span class="move">'.wpjam_get_list_table_row_action('move',	['id'=>$term_id, 'title'=>'<span class="dashicons dashicons-move"></span>']).'</span>';
					$value	.= '<span class="up"> | '.wpjam_get_list_table_row_action('up',		['id'=>$term_id, 'title'=>'<span class="dashicons dashicons-arrow-up-alt"></span>']).'</span>';
					$value	.= '<span class="down"> | '.wpjam_get_list_table_row_action('down',	['id'=>$term_id, 'title'=>'<span class="dashicons dashicons-arrow-down-alt"></span>']).'</span>';

					$value	= '<div class="row-actions">'.$value.'</div>';
				}
			}

			if(!$term_parent){
				$value	= $value ?: wpjam_admin_tooltip('<span class="dashicons dashicons-editor-help"></span>', '如要进行排序，请先点击「只显示第一级」按钮。');	
			}
		}
		
		return $value;
	},10,3);

	$transient_key	= 'wpjam_'.$taxonomy.'_taxonomy_order_checked';

	if(false === get_transient($transient_key)){
		$terms	= get_terms(['taxonomy'=>$taxonomy, 'orderby'=>'name', 'hide_empty'=>false]);
				
		foreach ($terms as $term) {
			if(!metadata_exists('term', $term->term_id, 'order')){
				update_term_meta($term->term_id, 'order', 1);
			}
		}

		// wpjam_print_r($terms);
		// _pad_term_counts($terms, $taxonomy);
		// wpjam_print_r($terms);
		
		set_transient($transient_key, true, DAY_IN_SECONDS);
	}	
}

add_filter('pre_insert_term', function($term, $taxonomy){
	global $taxonomy_levels;

	if($taxonomy_levels && !empty($_POST['parent']) && $_POST['parent']!=-1){
		$ancestors	= get_ancestors($_POST['parent'], $taxonomy);
		
		if(count($ancestors) >= $taxonomy_levels-1){
			return new WP_Error('invalid_parent', '不能超过'.$taxonomy_levels.'级');
		}
	}

	return $term;
}, 10, 2);

add_filter($taxonomy.'_row_actions', function($actions, $term){
	global $post_type, $term_parent, $taxonomy_sortable;

	if(isset($actions['children'])){
		if((empty($term_parent) || $term_parent != $term->term_id) && get_term_children($term->term_id, $term->taxonomy)){
			$actions['children']	= '<a href="'.admin_url('edit-tags.php?taxonomy='.$term->taxonomy.'&post_type='.$post_type.'&parent='.$term->term_id).'">下一级</a>';
		}else{
			unset($actions['children']);
		}
	}

	unset($actions['move']);
	unset($actions['up']);
	unset($actions['down']);

	return $actions;
},10,2);

add_action('wpjam_'.$taxonomy.'_terms_actions', function($actions, $taxonomy){

	global $term_parent, $taxonomy_sortable;

	$capability	= get_taxonomy($taxonomy)->cap->edit_terms;

	$actions['children']	= ['direct'=>true,	'title'=>'下一级',	'capability'=>$capability];

	if(empty($_GET['orderby']) && isset($term_parent)){
		if($taxonomy_sortable){
			$data	= ['parent'=>$term_parent];

			$actions['move']	= ['title'=>'拖动',		'page_title'=>'拖动',	'capability'=>$capability,'direct'=>true, 'data'=>$data];
			$actions['up']		= ['title'=>'向上移动',	'page_title'=>'向上移动',	'capability'=>$capability,'direct'=>true, 'data'=>$data];
			$actions['down']	= ['title'=>'向下移动',	'page_title'=>'向下移动',	'capability'=>$capability,'direct'=>true, 'data'=>$data];
		}
	}

	return $actions;
}, 10, 2);

add_filter('wpjam_'.$taxonomy.'_terms_list_action', function($result, $list_action, $term_id, $data){
	if($list_action != 'move'){
		return $result;
	}

	$term_ids	= get_terms([
		'parent'	=> $data['parent'],
		'orderby'	=> 'name',
		'taxonomy'	=> get_term($term_id)->taxonomy,
		'hide_empty'=> false,
		'fields'	=> 'ids'
	]);

	if(empty($term_ids) || !in_array($term_id, $term_ids)){
		return new WP_Error('key_not_exists', $term_id.'的值不存在');
	}

	$terms	= array_map(function($term_id){
		return ['id'=>$term_id, 'order'=>get_term_meta($term_id, 'order', true) ?: 0];
	}, $term_ids);

	$terms	= wp_list_sort($terms, 'order', 'DESC');
	$terms	= wp_list_pluck($terms, 'order', 'id');

	$next	= $data['next'] ?? false;
	$prev	= $data['prev'] ?? false;

	if(!$next && !$prev){
		return new WP_Error('invalid_move', '无效移动位置');
	}

	unset($terms[$term_id]);

	if($next){
		if(!isset($terms[$next])){
			return new WP_Error('key_not_exists', $next.'的值不存在');
		}

		$offset	= array_search($next, array_keys($terms));

		if($offset){
			$terms	= array_slice($terms, 0, $offset, true) +  [$term_id => 0] + array_slice($terms, $offset, null, true);	
		}else{
			$terms	= [$term_id => 0] + $terms;	
		}
	}else{
		if(!isset($terms[$prev])){
			return new WP_Error('key_not_exists', $prev.'的值不存在');
		}

		$offset	= array_search($prev, array_keys($terms));
		$offset ++;

		if($offset){
			$terms	= array_slice($terms, 0, $offset, true) +  [$term_id => 0] + array_slice($terms, $offset, null, true);	
		}else{
			$terms	= [$term_id => 0] + $terms;	
		}
	}

	$count	= count($terms);
	foreach ($terms as $term_id => $order) {
		if($order != $count){
			update_term_meta( $term_id, 'order', $count);
		}

		$count-- ;
	}
	
	return true;
}, 10, 4);

add_action('created_term', function($term_id, $tt_id, $taxonomy){
	global $taxonomy_sortable;

	if(!$taxonomy_sortable){
		return;
	}

	if(metadata_exists('term', $term_id, 'order')){
		return;
	}

	$term_ids	= get_terms([
		'parent'	=> get_term($term_id)->parent,
		'orderby'	=> 'name',
		'taxonomy'	=> $taxonomy,
		'hide_empty'=> false,
		'fields'	=> 'ids'
	]);

	update_term_meta($term_id, 'order', count($term_ids));
}, 10, 3);

add_action('parse_term_query', function($query){
	global $taxonomy, $term_parent, $term_orderby;

	if($taxonomy != current($query->query_vars['taxonomy'])){
		return;
	}

	if(in_array('_get_term_hierarchy', wp_list_pluck(debug_backtrace(), 'function'))){
		return;
	}

	if(isset($term_parent)){
		if($term_parent){
			// $taxonomy	= current($query->query_vars['taxonomy']);
			$hierarchy	= _get_term_hierarchy($taxonomy);
			$term_ids	= $hierarchy[$term_parent] ?? [];
			$term_ids[]	= $term_parent;
			if($ancestors = get_ancestors($term_parent, $taxonomy)){
				$term_ids	= array_merge($term_ids, $ancestors);
			}
			$query->query_vars['include']	= $term_ids;
			// $query->query_vars['pad_counts']	= true;
		}else{
			$query->query_vars['parent']	= $term_parent;
		}
	}

	// if($term_orderby){
	// 	$query->query_vars['orderby']	= $term_orderby;
	// }
});

add_filter('edit_'.$taxonomy.'_per_page', function($per_page){
	$parent	= wpjam_get_data_parameter('parent');
	return $parent ? 9999 : $per_page;
});

add_action('admin_head',function(){
	global $taxonomy, $post_type, $taxonomy_levels, $term_parent, $taxonomy_sortable;

	$term_link	= admin_url('edit-tags.php?taxonomy='.$taxonomy.'&post_type='.$post_type);

	if(!isset($term_parent)){
		$term_nav	= '<a href="'.$term_link.'&parent=0'.'" class="button button-primary">只显示第一级</a>';
	}elseif($term_parent > 0){
		$term_nav	= '<a href="'.$term_link.'&parent=0'.'" class="button button-primary">返回第一级</a>';
	}else{
		if($taxonomy_levels == 1){
			$term_nav	= '';
		}else{
			$term_nav	= '<a href="'.$term_link.'" class="button button-primary">显示所有</a>';
		}
	}

	$orderby	= $_GET['orderby'] ?? '';
	?>
	
	<script type="text/javascript">
	jQuery(function($){
		$('#doaction').after('<?php echo $term_nav; ?>');

		<?php if($taxonomy_sortable && isset($term_parent) && empty($orderby)){ ?>

		var parent	= <?php echo $term_parent; ?>;

		if(parent == 0){
			var level	= '0';
		}else{
			var level	= parseInt($('#tag-'+parent).attr('class').match(/\d+/)) + 1;
		}

		$.wpjam_list_table_sortable(' > tr.level-'+level);

		<?php } ?>
	});
	</script>
	<?php
});

add_action('admin_enqueue_scripts', function(){
	wp_add_inline_style('list-tables', 'th.column-sort{width: 80px;}
td.column-sort div.row-actions{left: 0;}');
});
