<?php
add_action('admin_head', function(){
	?>
	<script type="text/javascript">
	jQuery(function($){
		$('body').on('click', 'a.wpjam-new-template', function(e){
			e.preventDefault();

			tb_show('选择类型', '#TB_inline?inlineId=select_template_type&width=400&height=200');
			tb_position();

			return false;
		});

		$('body').on('submit', "#template_type_form", function(e){
			e.preventDefault();
			window.location.assign($("input[name='template_type']:checked").parent().data('url'));
			return false;
		});
	});
	</script>

	<?php
	global $plugin_page;

	if(empty($plugin_page)){
		return;
	}

	$post_id		= wpjam_get_data_parameter('post_id');
	$template_types	= wpjam_get_content_template_types();
	$current_type	= str_replace('wpjam-', '', $plugin_page);
	$current_title	= $template_types[$current_type]['title'] ?? '';

	if(empty($current_title)){
		return;
	}

	$current_title	= str_replace('模板', '', $current_title);
	
	?>

	<script type="text/javascript">
	jQuery(function($){
		$('body').on('page_action_success', function(e, response){
			if(response.is_add && response.page_action == 'save'){
				window.history.replaceState(null, null, window.location.href + '&post_id=' + response.post_id);
				$('nav.nav-tab-wrapper').show();

				$('nav.nav-tab-wrapper a').first().text('<?php echo $current_title; ?>设置');
				$('nav.nav-tab-wrapper a').each(function(){
					$(this).attr('href', $(this).attr('href')+'&post_id='+response.post_id);
				});

				$('title').text($('title').text().replace('新建', '编辑'));
				$('h1.wp-heading-inline').text($('h1.wp-heading-inline').text().replace('新建', '编辑'));

				$('div.wrap h2').text('<?php echo $current_title; ?>设置').show();
				
				$('input[type="submit"]').val('编辑');
				$('input#post_id').val(response.post_id);

				$('li#menu-posts-template ul li').removeClass('current');
				$('li#menu-posts-template ul li.wp-first-item').addClass('current');
			}
		});

		$('body').on('change', '#appid', function(){
			if($(this).val() == 'webview'){
				$('#div_path').hide();
			}else{
				$('#div_path').show();
			}
		});

		$('body').on('list_table_action_success', function(e, response){
			$('#appid').change();
		});

		$('#appid').change();
	});
	</script>
	
	<style type="text/css">
		<?php if(empty($post_id)){ ?>nav.nav-tab-wrapper, div.wrap h2{display: none;} <?php } ?>
		div#div_width, div#div_height{display: inline-block;}
		div#div_width span.dashicons{margin:0 4px;}
		div#div_width .sub-field-detail span.dashicons{height: 28px; line-height: 28px;}
	</style>

	<?php
});

add_action('admin_footer', function(){
	echo '<div id="select_template_type" style="display:none;">';

	$template_types	= wpjam_get_content_template_types();

	foreach ($template_types as $type=>&$tt) {
		$tt['title']	= ' <span class="dashicons dashicons-'.$tt['dashicon'].'"></span> '.$tt['title'];
		if($type == 'content'){
			$tt['url']	= admin_url('post-new.php?post_type=template&template_type=content');	
		}else{
			$tt['url']	= admin_url('edit.php?post_type=template&page=wpjam-'.$type);
		}
	}
	
	$fields	=[
		'template_type'	=> ['title'=>'',	'type'=>'radio',	'options'=>$template_types,	'sep'=>'<br /><br />']
	];

	wpjam_ajax_form([
		'fields'		=> $fields,
		'action'		=> 'select_template_type',
		'form_id'		=> 'template_type_form',
		'submit_text'	=> '新建'
	]);

	echo '</div>';
});

