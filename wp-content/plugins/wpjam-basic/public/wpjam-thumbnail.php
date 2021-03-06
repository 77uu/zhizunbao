<?php
class WPJAM_Thumbnail{
	use WPJAM_Setting_Trait;

	private function __construct(){
		$this->init('wpjam-thumbnail');
	}

	public function get_setting($name){
		if(!is_null($this->settings)){
			return $this->settings[$name] ?? '';
		}else{
			return wpjam_cdn_get_setting($name);
		}
	}

	public static function migrate(){
		if(!wpjam_get_option('wpjam-thumbnail')){
			if($value	= wpjam_get_option('wpjam-cdn')){
				update_option('wpjam-thumbnail', $value);
			}
		}
	}

	public static function get_thumbnail($img_url, ...$args){
		$args_num	= count($args);

		if(strpos($img_url, '?') === false){
			$img_url	= str_replace(['%3A','%2F'], [':','/'], urlencode(urldecode($img_url)));	// 中文名
		}

		if($args_num == 0){	
			// 1. $img_url 简单替换一下 CDN 域名

			$thumb_args = [];
		}elseif($args_num == 1){		
			// 2. $img_url, ['width'=>100, 'height'=>100]	// 这个为最标准版本
			// 3. $img_url, [100,100]
			// 4. $img_url, 100x100
			// 5. $img_url, 100		

			$thumb_args = wpjam_parse_size($args[0]);
		}else{
			if(is_numeric($args[0])){
				// 6. $img_url, 100, 100, $crop=1, $retina=1

				$width	= $args[0] ?? 0;
				$height	= $args[1] ?? 0;
				$crop	= $args[2] ?? 1;
				// $retina	= $args[4] ?? 1;
			}else{
				// 7. $img_url, array(100,100), $crop=1, $retina=1

				$size	= wpjam_parse_size($args[0]);
				$width	= $size['width'];
				$height	= $size['height'];
				$crop	= $args[1] ?? 1;
				// $retina	= $args[3]??1;
			}

			// $width		= intval($width)*$retina;
			// $height		= intval($height)*$retina;

			$thumb_args = compact('width','height','crop');
		}

		$thumb_args	= apply_filters('wpjam_thumbnail_args', $thumb_args);

		return apply_filters('wpjam_thumbnail', $img_url, $thumb_args);
	}

	public static function parse_size($size, $retina=1){
		global $content_width;	

		$_wp_additional_image_sizes = wp_get_additional_image_sizes();

		if(is_array($size)){
			if(wpjam_is_assoc_array($size)){
				$size['width']	= $size['width'] ?? 0;
				$size['height']	= $size['height'] ?? 0;
				$size['width']	*= $retina;
				$size['height']	*= $retina;
				$size['crop']	= !empty($size['width']) && !empty($size['height']);
				return $size;
			}else{
				$width	= intval($size[0]??0);
				$height	= intval($size[1]??0);
				$crop	= $width && $height;
			}
		}else{
			if(strpos($size, 'x')){
				$size	= explode('x', $size);
				$width	= intval($size[0]);
				$height	= intval($size[1]);
				$crop	= $width && $height;
			}elseif(is_numeric($size)){
				$width	= $size;
				$height	= 0;
				$crop	= false;
			}elseif($size == 'thumb' || $size == 'thumbnail'){
				$width	= intval(get_option('thumbnail_size_w'));
				$height = intval(get_option('thumbnail_size_h'));
				$crop	= get_option('thumbnail_crop');

				if(!$width && !$height){
					$width	= 128;
					$height	= 96;
				}

			}elseif($size == 'medium'){

				$width	= intval(get_option('medium_size_w')) ?: 300;
				$height = intval(get_option('medium_size_h')) ?: 300;
				$crop	= get_option('medium_crop');

			}elseif( $size == 'medium_large' ) {

				$width	= intval(get_option('medium_large_size_w'));
				$height	= intval(get_option('medium_large_size_h'));
				$crop	= get_option('medium_large_crop');

				if(intval($content_width) > 0){
					$width	= min(intval($content_width), $width);
				}

			}elseif($size == 'large'){

				$width	= intval(get_option('large_size_w')) ?: 1024;
				$height	= intval(get_option('large_size_h')) ?: 1024;
				$crop	= get_option('large_crop');

				if (intval($content_width) > 0) {
					$width	= min(intval($content_width), $width);
				}
			}elseif(isset($_wp_additional_image_sizes) && isset($_wp_additional_image_sizes[$size])){
				$width	= intval($_wp_additional_image_sizes[$size]['width']);
				$height	= intval($_wp_additional_image_sizes[$size]['height']);
				$crop	= $_wp_additional_image_sizes[$size]['crop'];

				if(intval($content_width) > 0){
					$width	= min(intval($content_width), $width);
				}
			}else{
				$width	= 0;
				$height	= 0;
				$crop	= 0;
			}
		}

		$width	= $width * $retina;
		$height	= $height * $retina;

		return compact('width','height', 'crop');
	}

	public static function get_default_thumbnail_url($size='full', $crop=1){
		$thumbnail_url	= apply_filters('wpjam_default_thumbnail_url', self::get_instance()->get_setting('default'));
			
		return $thumbnail_url ? self::get_thumbnail($thumbnail_url, $size, $crop) : '';
	}

	public static function filter_post_thumbnail_url($thumbnail_url, $post){
		$thumbnail_url		= $thumbnail_url ?: wpjam_get_default_thumbnail_url();
		$thumbnail_orders	= self::get_instance()->get_setting('post_thumbnail_orders') ?: [];

		if(empty($thumbnail_orders)){
			return $thumbnail_url;
		}

		foreach ($thumbnail_orders as $thumbnail_order) {
			if($thumbnail_order['type'] == 'first'){
				if($post_first_image = wpjam_get_post_first_image_url($post)){
					return $post_first_image;
				}
			}elseif($thumbnail_order['type'] == 'post_meta'){
				if($post_meta 	= $thumbnail_order['post_meta']){
					if($post_meta_url = get_post_meta($post->ID, $post_meta, true)){
						return $post_meta_url;
					}
				}
			}elseif($thumbnail_order['type'] == 'term'){
				if(!self::get_instance()->get_setting('term_thumbnail_type')){
					continue;
				}

				$taxonomy	= $thumbnail_order['taxonomy'];

				if(empty($taxonomy)){
					continue;
				}

				$thumbnail_taxonomies	= $thumbnail_taxonomies ?? self::get_instance()->get_setting('term_thumbnail_taxonomies');

				if(empty($thumbnail_taxonomies) || !in_array($taxonomy, $thumbnail_taxonomies)){
					continue;
				}

				$post_taxonomies	= $post_taxonomies ?? get_post_taxonomies($post);

				if(empty($post_taxonomies) || !in_array($taxonomy, $post_taxonomies)){
					continue;
				}
				
				if($terms = get_the_terms($post, $taxonomy)){
					foreach ($terms as $term) {
						if($term_thumbnail = wpjam_get_term_thumbnail_url($term)){
							return $term_thumbnail;
						}
					}
				}
			}
		}

		return $thumbnail_url;
	}

	public static function filter_term_thumbnail_url($thumbnail_url, $term){
		if(!self::get_instance()->get_setting('term_thumbnail_type')){
			return $thumbnail_url;
		}

		$thumbnail_taxonomies	= self::get_instance()->get_setting('term_thumbnail_taxonomies');

		if(empty($thumbnail_taxonomies) || !in_array($term->taxonomy, $thumbnail_taxonomies)){
			return $thumbnail_url;
		}

		return get_term_meta($term->term_id, 'thumbnail', true);
	}

	public static function get_term_thumbnail_field($taxonomy){
		$thumbnail_taxonomies	= self::get_instance()->get_setting('term_thumbnail_taxonomies');

		if(empty($thumbnail_taxonomies) || !in_array($taxonomy, $thumbnail_taxonomies)){
			return [];
		}

		$field	= ['title'=>'缩略图'];

		if(self::get_instance()->get_setting('term_thumbnail_type') == 'img'){
			$field['type']		= 'img';
			$field['item_type']	= 'url';

			$width	= self::get_instance()->get_setting('term_thumbnail_width') ?: 200;
			$height	= self::get_instance()->get_setting('term_thumbnail_height') ?: 200;

			if($width || $height){
				$field['size']			= $width.'x'.$height;
				$field['description']	= '尺寸：'.$width.'x'.$height;
			}
		}else{
			$field['type']	= 'image';
			$field['style']	= 'width:calc(100% - 100px);';
		}

		return $field;
	}

	public static function set_term_thumbnail($term_id, $data){
		if($thumbnail	= $data['thumbnail'] ?? ''){
			return update_term_meta($term_id, 'thumbnail', $thumbnail);
		}else{
			return delete_term_meta($term_id, 'thumbnail');
		}
	}

	public static function term_single_row_replace($html){
		if(preg_match_all('/<tr id="tag-(\d+)" class=".*?">.*?<\/tr>/is', $html, $matches)){
			$search	= $replace = $matches[0];

			foreach ($matches[1] as $i => $term_id){
				$thumbnail	= wpjam_get_term_thumbnail($term_id, [50,50]);
				$taxonomy	= get_term($term_id)->taxonomy;
				$capability	= get_taxonomy($taxonomy)->cap->edit_terms;

				if(current_user_can($capability)){
					$thumbnail = wpjam_get_list_table_row_action('set_thumbnail',[
						'id'	=> $term_id,
						'title'	=> $thumbnail ?: '<span class="no-thumbnail">暂无图片</span>',
					]);
				}

				$replace[$i]	= str_replace('<a class="row-title"', $thumbnail.'<a class="row-title"', $replace[$i]);
			}

			$html	= str_replace($search, $replace, $html);
		}

		return $html;
	}

	public static function filter_term_single_row_html($html){
		if(!wp_doing_ajax() || (wp_doing_ajax() && in_array($_POST['action'], ['inline-save-tax', 'add-tag']))){
			return self::term_single_row_replace($html);
		}elseif(wp_doing_ajax() && $_POST['action'] == 'wpjam-list-table-action'){
			$response	= wpjam_json_decode($html);

			if(isset($response['data'])){
				if(is_array($response['data'])){
					$response['data']	= array_map(['WPJAM_Thumbnail', 'term_single_row_replace'], $response['data']);
				}else{
					$response['data']	= self::term_single_row_replace($response['data']);
				}

				return wpjam_json_encode($response);
			}
		}

		return $html;
	}

	public static function get_option_setting(){
		$taxonomies			= get_taxonomies(['show_ui'=>true, 'public'=>true], 'objects');
		$taxonomy_options	= wp_list_pluck($taxonomies, 'label', 'name');

		$term_thumbnail_taxonomies	= self::get_instance()->get_setting('term_thumbnail_taxonomies') ?: [];
		$term_taxonomy_options		= wp_array_slice_assoc($taxonomy_options, $term_thumbnail_taxonomies);

		$post_thumbnail_orders_options	= [''=>'请选择来源', 'first'=>'第一张图','post_meta'=>'自定义字段'];

		if(self::get_instance()->get_setting('term_thumbnail_type')){
			$post_thumbnail_orders_options += ['term'=>'分类缩略图'];
		}

		$thumb_fields	= [
			'default'	=> ['title'=>'默认缩略图',	'type'=>'image',	'description'=>'各种情况都找不到缩略图之后默认的缩略图，可以填本地或者云存储的地址！'],
			'width'		=> ['title'=>'图片最大宽度',	'type'=>'number',	'class'=>'small-text',	'description'=>'文章内容中图片的最大宽度，如设置图片将会被缩放到对应宽度。']
		];

		$term_fields	= [
			'term_thumbnail_type'		=> ['title'=>'分类缩略图',	'type'=>'select',	'options'=>[''=>'关闭分类缩略图', 'img'=>'本地媒体模式','image'=>'输入图片链接模式']],
			'term_thumbnail_taxonomies'	=> ['title'=>'支持的分类模式','type'=>'checkbox', 'show_if'=>['key'=>'term_thumbnail_type', 'compare'=>'!=', 'value'=>''],	'options'=>$taxonomy_options],
			'term_thumbnail_size'		=> ['title'=>'缩略图尺寸',	'type'=>'fieldset', 'show_if'=>['key'=>'term_thumbnail_type', 'compare'=>'!=', 'value'=>''],	'fields'=>[
				'term_thumbnail_width'		=> ['title'=>'',	'type'=>'number',	'class'=>'small-text'],
				'term_thumbnail_height'		=> ['title'=>'x',	'type'=>'number',	'class'=>'small-text',	'description'=>'px']
			]]
		];

		$post_fields	= [
			'post_thumbnail_orders'	=> ['title'=>'获取顺序',	'type'=>'mu-fields',	'max_items'=>5,	'fields'=>[
				'type'		=> ['title'=>'',	'type'=>'select',	'class'=>'post_thumbnail_order_type',	'options'=>$post_thumbnail_orders_options],
				'taxonomy'	=> ['title'=>'',	'type'=>'select',	'class'=>'post_thumbnail_order_taxonomy',	'show_if'=>['key'=>'type', 'value'=>'term'],	'options'=>[''=>'请选择分类模式']+$term_taxonomy_options],
				'post_meta'	=> ['title'=>'',	'type'=>'text',		'class'=>'post_thumbnail_order_post_meta all-options',	'show_if'=>['key'=>'type', 'value'=>'post_meta'],	'placeholder'=>'请输入自定义字段的 meta_key'],
			]]
		];

		return [
			'thumb'	=> ['title'=>'缩略图',	'fields'=>$thumb_fields],
			'term'	=> ['title'=>'分类缩略图','fields'=>$term_fields],
			'post'	=> ['title'=>'文章缩略图','fields'=>$post_fields, 'summary'=>'首先使用文章特色图片，如果没有设置文章特色图片，将按照下面的顺序获取：']
		];
	}

	public static function on_admin_head(){
		$taxonomies			= get_taxonomies(['show_ui'=>true, 'public'=>true],'objects');
		$taxonomy_options	= wp_list_pluck($taxonomies, 'label', 'name');

		?>
		<style type="text/css">
			#tr_post_thumbnail_orders .sub-field,
			#div_term_thumbnail_width, 
			#div_term_thumbnail_height{
				display: inline-block; margin: 0;
			}

			#div_term_thumbnail_width label.sub-field-label, 
			#div_term_thumbnail_height label.sub-field-label{
				min-width: inherit; margin: 0 3px; font-weight: normal;
			}

			#tr_post_thumbnail_orders .sub-field.hidden{
				display: none;
			}

			#tr_post_thumbnail_orders div.mu-fields > div.mu-item > a{
				margin: 0 0 10px 10px
			}
		</style>
		<script type="text/javascript">
		jQuery(function ($){
			$('body').on('change', '#term_thumbnail_type', function (){
				if($(this).val()){
					if($('body .post_thumbnail_order_type option[value="term"]').length == 0){
						var opt = $("<option></option>").text('分类缩略图').val('term');
						$('body .post_thumbnail_order_type').append(opt);
					}
				}else{
					$('body .post_thumbnail_order_type option[value="term"]').remove();
					$('body .post_thumbnail_order_type').change();
				}
			});
			
			var taxonomy_options 	= <?php echo wpjam_json_encode($taxonomy_options); ?>;

			$('body').on('change', '#div_term_thumbnail_taxonomies input', function(){
				var taxonomy = $(this).val();

				if($(this).is(":checked")){
					var opt = $("<option></option>").text(taxonomy_options[taxonomy]).val(taxonomy);
					$('body .post_thumbnail_order_taxonomy').append(opt);
				}else{
					$('body .post_thumbnail_order_taxonomy option[value="'+taxonomy+'"]').remove();
				}
			});

			$('body #term_thumbnail_type').change();
		});
		</script>
		<?php
	}
}

function wpjam_thumbnail_get_setting($name){
	return WPJAM_Thumbnail::get_instance()->get_setting($name);
}

// 1. $img_url 
// 2. $img_url, array('width'=>100, 'height'=>100)	// 这个为最标准版本
// 3. $img_url, 100x100
// 4. $img_url, 100
// 5. $img_url, array(100,100)
// 6. $img_url, array(100,100), $crop=1, $retina=1
// 7. $img_url, 100, 100, $crop=1, $retina=1
function wpjam_get_thumbnail($img_url, ...$args){
	return WPJAM_Thumbnail::get_thumbnail($img_url, ...$args);
}

function wpjam_parse_size($size, $retina=1){
	return WPJAM_Thumbnail::parse_size($size, $retina);
}

function wpjam_get_default_thumbnail_url($size='full', $crop=1){	// 默认缩略图
	return WPJAM_Thumbnail::get_default_thumbnail_url($size, $crop);
}

add_filter('wpjam_post_thumbnail_url', ['WPJAM_Thumbnail', 'filter_post_thumbnail_url'], 1, 2);	// 文章缩略图
add_filter('wpjam_term_thumbnail_url', ['WPJAM_Thumbnail', 'filter_term_thumbnail_url'], 1, 2);	// 分类缩略图

if(is_admin()){
	wpjam_add_basic_sub_page('wpjam-thumbnail', [
		'menu_title'	=> '缩略图设置',		
		'function'		=> 'option',
		'order'			=> 20,
		'summary'		=> '详细介绍请点击：<a href="https://blog.wpjam.com/m/wpjam-basic-thumbnail/" target="_blank">缩略图设置</a>，启用之后，请使用 <a href="https://blog.wpjam.com/m/wpjam-basic-thumbnail-functions/" target="_blank">WPJAM 的相关缩略图</a>函数代替 WordPress 自带的缩略图函数。'
	]);

	add_action('wpjam_builtin_page_load', function($screen_base, $current_screen){
		if(!in_array($screen_base, ['term', 'edit-tags'])){
			return;
		}

		if($thumbnail_field	= WPJAM_Thumbnail::get_term_thumbnail_field($current_screen->taxonomy)){
			wpjam_register_term_option('thumbnail', $thumbnail_field);

			wpjam_register_list_table_action('set_thumbnail', [
				'title'			=> '设置',	
				'page_title'	=> '设置缩略图',
				'tb_width'		=> '500',	
				'tb_height'		=> '400',
				'row_action'	=> false,
				'fields'		=> ['thumbnail'=>$thumbnail_field],
				'callback'		=> ['WPJAM_Thumbnail', 'set_term_thumbnail']
			]);

			add_filter('wpjam_html', ['WPJAM_Thumbnail', 'filter_term_single_row_html']);
		}
	}, 99, 2);

	add_action('wpjam_plugin_page_load', function($plugin_page){
		if($plugin_page != 'wpjam-thumbnail'){
			return;
		}

		WPJAM_Thumbnail::migrate();

		wpjam_register_option('wpjam-thumbnail', ['WPJAM_Thumbnail','get_option_setting']);

		add_action('admin_head', ['WPJAM_Thumbnail', 'on_admin_head']);
	});
}