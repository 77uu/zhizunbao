<?php
function wpjam_is_taxonomy_sortable($taxonomies){
	if(empty($taxonomies) || (is_array($taxonomies) && count($taxonomies) > 1)){
		return false;
	}

	if(is_string($taxonomies)){
		$taxonomy	= $taxonomies;
	}else{
		$taxonomy	= current($taxonomies);
	}

	if($taxonomy){
		$tax_obj	= get_taxonomy($taxonomy);
		return $tax_obj->sortable ?? ($tax_obj->order ?? false);
	}else{
		return false;
	}
}