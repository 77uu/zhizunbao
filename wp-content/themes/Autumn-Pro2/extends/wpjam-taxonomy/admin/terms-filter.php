<?php
function wpjam_terms_filter_page(){
	$post_type	= wpjam_get_data_parameter('post_type') ?: 'post';
	$fields		= [];

	foreach(get_object_taxonomies($post_type, 'objects') as $taxonomy => $tax_obj){
		if(!$tax_obj->show_ui){
			continue;
		}

		$label	= $tax_obj->label;
		$tax	= $taxonomy == 'post_tag' ? 'tag' : $taxonomy;

		$fields[$taxonomy]	= ['title'=>$tax_obj->label,	'type'=>'fieldset',	'fields'=>[
			$taxonomy.'s'		=> ['title'=>'','type'=>'mu-text',	'class'=>'all-options',	'placeholder'=>'请输入'.$label,	'data_type'=>'taxonomy',	'taxonomy'=>$taxonomy],
			$taxonomy.'_filter'	=> ['title'=>'','type'=>'select',	'options'=>[$tax.'__and'=>'所有'.$label.'都使用', $tax.'__in'=>'至少使用其中一个', $tax.'__not_in'=>'所有'.$label.'都不使用']]
		]];
	}

	if(count($fields) > 1){
		$fields['relation']	= ['title'=>'关系',	'type'=>'select',	'options'=>['and'=>'AND','or'=>'OR']];
	}

	$fields['post_type']	= ['title'=>'',	'type'=>'hidden',	'value'=>$post_type];

	wpjam_ajax_form([
		'fields'		=> $fields, 
		'action'		=> 'terms_filter', 
		'submit_text'	=> '筛选'
	]);
}

add_action('wpjam_page_action', function($action){
	if($action == 'terms_filter'){
		$post_type		= wpjam_get_data_parameter('post_type') ?: 'post';
		$taxonomies		= get_object_taxonomies($post_type, 'objects');

		$filter_args	= '';

		foreach(get_object_taxonomies($post_type, 'objects') as $taxonomy => $tax_obj){
			if(!$tax_obj->show_ui){
				continue;
			}

			if($terms = array_filter(wpjam_get_data_parameter($taxonomy.'s'))){
				$filter_args	.= '&'.wpjam_get_data_parameter($taxonomy.'_filter').'='.implode(',', $terms);
			}
		}

		if(empty($filter_args)){
			return new WP_error('empty_terms', '你至少要选择一个分类或者标签或者其他分类模式');
		}

		$relation	= wpjam_get_data_parameter('relation') ?? 'and';

		$filter_url	= admin_url('edit.php?post_type='.$post_type.$filter_args.'&tax_query_relation='.$relation);

		wpjam_send_json(compact('filter_url'));
	}
});


add_action('admin_head', function(){
	?>
	<script type="text/javascript">
	jQuery(function($){
		$('body').on('page_action_success', function(e, response){
			var action	= response.page_action;

			if(action == 'terms_filter'){
				window.location.href	= response.filter_url;		
			}
		});
	});
	</script>
	<?php
});