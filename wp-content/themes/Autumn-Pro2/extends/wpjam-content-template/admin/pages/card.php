<?php
add_filter('wpjam_card_tabs', function(){
	$tabs	= [
		'setting'	=> ['title'=>'新建卡片',	'function'=>'wpjam_card_setting_page'],
		'content'	=> ['title'=>'卡片内容',	'function'=>'wpjam_card_content_page'],
	];

	if($post_id	= wpjam_get_data_parameter('post_id')){
		$tabs['setting']['title']	= '卡片设置';
	}

	return $tabs;
});

function wpjam_card_setting_page(){
	$card_types	= [
		1=>'小图模式：图片显示在左侧，尺寸为200x200。',
		2=>'大图模式：图片全屏显示，高度自适应。'
	];

	$fields = [
		'post_title'	=> ['title'=>'名称',	'type'=>'text'],
		'card_type'		=> ['title'=>'样式',	'type'=>'radio',	'options'=>$card_types,	'sep'=>'<br /><br />'],
		'post_id'		=> ['title'=>'',	'type'=>'hidden'],
	];

	$post_id		= wpjam_get_data_parameter('post_id') ?: 0;

	if($post_id){
		$post			= get_post($post_id);
		$post_title		= $post->post_title;
		$post_content	= $post->post_content;
		$content		= maybe_unserialize($post_content);
		$card_type		= $content['card_type'] ?? 1;
	}else{
		$post_title		= '';
		$card_type		= 1;
	}

	$data			= compact('post_title', 'card_type', 'post_id');
	$submit_text	= $post_id ? '编辑' : '新建';

	wpjam_ajax_form([
		'fields'		=> $fields, 
		'data'			=> $data, 
		'submit_text'	=> $submit_text,
		'action'		=> 'save',
	]);	
}

function wpjam_card_content_page(){
	$post_id	= wpjam_get_data_parameter('post_id');

	$post			= get_post($post_id);
	$post_excerpt	= $post->post_excerpt;
	$post_content	= $post->post_content;
	$content		= $post_content ? maybe_unserialize($post_content) : [];

	$card_type		= $content['card_type'] ?? 1;
	$thumbnail		= $content['thumbnail'] ?? '';
	$price			= $content['price'] ?? '';
	$item			= $content['item'] ?? [];
	
	$fields		= [
		'thumbnail'		=> ['title'=>'图片',	'type'=>'img',	'item_type'=>'url',	'size'=>'200x200'],
		'post_excerpt'	=> ['title'=>'简介',	'type'=>'text',	'placeholder'=>'一句话简介...',	'value'=>$post_excerpt],
		'price'			=> ['title'=>'价格',	'type'=>'text',	'class'=>'',	'description'=>'输入价格会显示「去选购」按钮'],
		'post_id'		=> ['title'=>'',	'type'=>'hidden'],
	];

	$data	= compact('post_excerpt', 'thumbnail', 'price', 'post_id', 'item');

	if($card_type == 2){
		$fields['thumbnail']['size']	= '1200x0';
		unset($fields['post_excerpt']);
		unset($fields['price']);
	}

	$platforms	= ['template'];

	if(defined('WEAPP_PLUGIN_DIR')){
		$platforms[]	= 'weapp';
	}

	foreach (wpjam_get_path_fields($platforms) as $path_key => $path_field) {
		if($path_field['type'] == 'fieldset'){
			foreach ($path_field['fields'] as $sub_key => &$field){
				$field['name']	= 'item['.$sub_key.']';
			}
		}else{
			$path_field['name']	= 'item['.$path_key.']';
		}

		$fields[$path_key]	= $path_field;
	}

	unset($fields['page_key_fieldset']['fields']['page_key']['options']['contact']);

	wpjam_ajax_form([
		'fields'		=> $fields, 
		'data'			=> $data,
		'action'		=> 'set',
		'submit_text'	=> '保存'
	]);
}

add_action('wpjam_page_action', function($action){
	if($action == 'save'){
		$post_id		= wpjam_get_data_parameter('post_id');
		$post_title		= wpjam_get_data_parameter('post_title');
		$post_status	= 'publish';
 
		$card_type		= wpjam_get_data_parameter('card_type', ['sanitize_callback'=>'intval',	'default'=>1]);
		$meta_input		= ['_template_type'=>'card'];

		if($post_id){
			$post_content	= get_post($post_id)->post_content;
			$content		= maybe_unserialize($post_content);
			$content		= array_merge($content, compact('card_type'));
			$post_content	= maybe_serialize($content);

			$post_id		= WPJAM_Post::update($post_id, compact('post_title', 'post_content', 'post_status', 'meta_input'));
			$is_add			= false;
		}else{
			$post_type		= 'template';
			$post_content	= maybe_serialize(compact('card_type'));
			$post_id		= WPJAM_Post::insert(compact('post_type', 'post_title', 'post_content', 'post_status', 'meta_input'));
			$is_add			= true;
		}

		if(is_wp_error($post_id)){
			wpjam_send_json($post_id);
		}else{
			wpjam_send_json(compact('post_id', 'is_add'));
		}
	}elseif($action == 'set'){
		$post_id	= wpjam_get_data_parameter('post_id');

		$content	= maybe_unserialize(get_post($post_id)->post_content);

		$content['thumbnail']	= wpjam_get_data_parameter('thumbnail', ['default'=>'']);
		$content['price']		= wpjam_get_data_parameter('price', ['default'=>'']);
		$content['item']		= wpjam_get_data_parameter('item');

		$post_content	= maybe_serialize($content);
		$post_excerpt	= wpjam_get_data_parameter('post_excerpt', ['default'=>'']);
		
		$post_id		= WPJAM_Post::update($post_id, compact('post_excerpt', 'post_content'));
		
		if(is_wp_error($post_id)){
			wpjam_send_json($post_id);
		}else{
			wpjam_send_json(compact('post_id'));
		}
	}
});