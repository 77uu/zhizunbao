<?php
add_action('media_buttons', function($editor_id){
	if(current_user_can('edit_posts')){
		wpjam_ajax_button([
			'action'		=> 'insert_content_template',
			'page_title'	=> '插入模板',
			'data'			=> ['editor_id'=>$editor_id],
			'tb_width'		=> 500,
			'tb_height'		=> 200,
			'button_text'	=> '<span class="dashicons dashicons-edit" style="margin:0 2px; width:18px; height:18px; vertical-align:text-bottom;"></span> 插入模板', 
			'class'			=> 'button'
		]);
	}
});

add_action('wpjam_page_action', function($action){
	if($action == 'insert_content_template' && current_user_can('edit_posts')){
		$editor_id	= wpjam_get_data_parameter('editor_id', ['sanitize_callback'=>'sanitize_key']);

		$fields	= [
			'template'		=> ['title'=>'',	'type'=>'fieldset',	'fields'=>[
				'template_id'	=> ['title'=>'选择模板',	'type'=>'text',	'data_type'=>'post_type',	'post_type'=>'template',	'class'=>'all-options'],
				'template_view'	=> ['title'=>' ',		'type'=>'view',	'value'=>'请点击选择或者输入关键字查询后选择...'],
			]],
		];
		
		$data   = wpjam_get_ajax_form([
			'fields'		=> $fields,
			'form_id'		=> 'template_form',
			'data'			=> ['editor_id'=>$editor_id],
			'submit_text'	=> '插入'
		]);
	
		wpjam_send_json(compact('data'));
	}
});

add_action('admin_head', function(){
	?>
	<script type="text/javascript">
	jQuery(function($){
		$('body').on('submit', "#template_form", function(e){
			e.preventDefault();	// 阻止事件默认行为。
			wp.media.editor.insert("\n"+'[template id="'+$('#template_id').val()+'"]'+"\n");
			tb_remove();
		});
	});
	</script>

	<?php
});