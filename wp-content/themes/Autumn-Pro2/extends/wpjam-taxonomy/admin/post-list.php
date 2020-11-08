<?php
add_filter('request', function($query_vars){
	if($post_type	= $query_vars['post_type']){
		$tax_query	= [];

		if($taxonomy_objs	= get_object_taxonomies($post_type, 'objects')){
			foreach ($taxonomy_objs as $taxonomy=>$t) {
				if(!$t->show_ui){
					continue;
				}

				$tax	= $taxonomy == 'post_tag' ? 'tag' : $taxonomy;
				
				if($tax != 'category'){
					if(!empty($_REQUEST[$tax.'_id'])){
						$query_vars[$tax.'_id']	= intval($_REQUEST[$tax.'_id']);
					}
				}

				if(!empty($_REQUEST[$tax.'__and'])){
					$tax__and	= wp_parse_id_list($_REQUEST[$tax.'__and']);

					if(count($tax__and) == 1){
						if (!isset($_REQUEST[$tax.'__in'])){
							$_REQUEST[$tax.'__in']	= [];
						}

						$_REQUEST[$tax.'__in'][]	= absint(reset($tax__and));
					}else{
						$tax__and		= array_map('absint', array_unique($tax__and));
						$tax_query[]	= [
							'taxonomy'			=> $taxonomy,
							'terms'				=> $tax__and,
							'field'				=> 'term_id',
							'operator'			=> 'AND',
							// 'include_children'	=> false,
						];
					}
				}

				if(!empty($_REQUEST[$tax.'__in'])){
					$tax__in		= wp_parse_id_list($_REQUEST[$tax.'__in']);
					$tax__in		= array_map('absint', array_unique($tax__in));

					$tax_query[]	= [
						'taxonomy'			=> $taxonomy,
						'terms'				=> $tax__in,
						'field'				=> 'term_id',
						// 'include_children'	=> false,
					];
				}

				if(!empty($_REQUEST[$tax.'__not_in'])){
					$tax__not_in	= wp_parse_id_list($_REQUEST[$tax.'__not_in']);
					$tax__not_in	= array_map('absint', array_unique($tax__not_in));

					$tax_query[]	= [
						'taxonomy'			=> $taxonomy,
						'terms'				=> $tax__not_in,
						'field'				=> 'term_id',
						'operator'			=> 'NOT IN',
						// 'include_children'	=> false,
					];
				}
			}
		}

		if($tax_query){
			$tax_query['relation']		= $_REQUEST['tax_query_relation'] ?? 'and'; 
			$query_vars['tax_query']	= $tax_query;
		}
	}

	return $query_vars;
});