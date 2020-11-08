<?php
class WPJAM_Setting{
	protected static $option_settings	= [];

	public static function register($option_name, $args=[]){
		self::$option_settings[$option_name]	= $args;
	}

	public static function get_option_settings(){
		return self::$option_settings;
	}

	public static function get_option_setting($option_name){
		if(self::$option_settings && !empty(self::$option_settings[$option_name])){
			$option_setting	= self::$option_settings[$option_name];
		}else{
			$option_setting	= apply_filters(wpjam_get_filter_name($option_name, 'setting'), []);

			if(!$option_setting){
				$option_settings	= apply_filters('wpjam_settings', [], $option_name);

				if(!$option_settings || empty($option_settings[$option_name])) {
					return false;
				}

				$option_setting	= $option_settings[$option_name];
			}
		}

		if(is_callable($option_setting)){
			$option_setting	= call_user_func($option_setting, $option_name);
		}

		if(empty($option_setting['sections'])){	// 支持简写
			if(isset($option_setting['fields'])){
				$fields		= $option_setting['fields'];
				$title		= $option_setting['title'] ?? '';

				unset($option_setting['fields']);
				$option_setting['sections']	= [$option_name => compact('fields', 'title')];
			}else{
				$option_setting['sections']	= $option_setting;
			}
		}

		foreach ($option_setting['sections'] as $section_id => &$section) {
			if(is_callable($section['fields'])){
				$section['fields']	= call_user_func($section['fields'], $option_name, $section_id);
			}
		}

		return wp_parse_args($option_setting, [
			'option_group'	=> $option_name, 
			'option_page'	=> $option_name, 
			'option_type'	=> 'array', 	// array：设置页面所有的选项作为一个数组存到 options 表， single：每个选项单独存到 options 表。
			'capability'	=> 'manage_options',
			'ajax'			=> true,
			'sections'		=> []
		]);
	}

	public static function get_option($option_name, $blog_id=0){
		if(is_multisite()){
			if(is_network_admin()){
				return get_site_option($option_name) ?: [];
			}else{
				if($blog_id){
					$option	= get_blog_option($blog_id, $option_name) ?: [];
				}else{
					$option	= get_option($option_name) ?: [];	
				}

				if(apply_filters('wpjam_option_use_site_default', false, $option_name)){
					$site_option	= get_site_option($option_name) ?: [];
					$option			= $option + $site_option;
				}

				return $option;
			}
		}else{
			return get_option($option_name) ?: [];
		}
	}

	public static function update_option($option_name, $option_value, $blog_id=0){
		if(is_multisite()){
			if(is_network_admin()){
				return update_site_option($option_name, $option_value);
			}else{
				if($blog_id){
					return update_blog_option($blog_id, $option_name, $option_value);
				}else{
					return update_option($option_name, $option_value);	
				}
			}
		}else{
			return update_option($option_name, $option_value);
		}
	}

	public static function get_setting($option_name, $setting_name, $blog_id=0){
		$option_value	= is_string($option_name) ? self::get_option($option_name, $blog_id) : $option_name;

		if($option_value && isset($option_value[$setting_name])){
			$value	= $option_value[$setting_name];

			if($value && is_string($value)){
				return  str_replace("\r\n", "\n", trim($value));
			}else{
				return $value;
			}
		}else{
			return null;
		}
	}

	public static function update_setting($option_name, $setting_name, $setting_value, $blog_id=0){
		$option_value	= self::get_option($option_name, $blog_id);

		$option_value[$setting_name]	= $setting_value;

		return self::update_option($option_name, $option_value, $blog_id);
	}

	public static function delete_setting($option_name, $setting_name, $blog_id=0){
		$option_value	= self::get_option($option_name, $blog_id);

		if($option_value && isset($option_value[$setting_name])){
			unset($option_value[$setting_name]);
		}

		return self::update_option($option_name, $option_value, $blog_id);
	}
}

trait WPJAM_Setting_Trait{
	private static $instance	= null;

	private $settings		= [];
	private $option_name	= '';

	private function init($option_name){
		$this->option_name	= $option_name;
		$this->settings		= wpjam_get_option($option_name);
	}

	public static function get_instance(){
		if(is_null(self::$instance)){
			self::$instance	= new self();
		}

		return self::$instance;
	}

	public function get_settings(){
		return $this->settings;
	}

	public function get_setting($name){
		return $this->settings[$name] ?? '';
	}

	public function update_setting($name, $value){
		$this->settings[$name]	= $value;
		return $this->save();
	}

	public function delete_setting($name){
		unset($this->settings[$name]);
		return $this->save();
	}

	private function save(){
		return wpjam_update_option($this->option_name, $this->settings);
	}
}

class WPJAM_Post{
	public static function validate($post_id, $post_type='', $action=''){
		$post	= self::get_post($post_id);

		if(!$post){
			return new WP_Error('post_not_exists', '文章不存在');
		}

		if($post_type && $post_type != 'any' && $post_type != $post->post_type){
			return new WP_Error('invalid_post_type', '无效的文章类型');
		}

		return $post;
	}

	public static function get_views($post_id, $addon=false){
		$views	= intval(get_post_meta($post_id, 'views', true));

		if($addon){
			$views	= $views + apply_filters('wpjam_post_views_addon', 0, $post_id);
		}

		return intval($views);
	}

	public static function update_views($post_id){
		static $post_viewed;

		if(!empty($post_viewed)){
			return;
		}

		$post_viewed	= true;

		$views	= self::get_views($post_id);
		$views++;
		
		return update_post_meta($post_id, 'views', $views);
	}

	public static function get_content($post=null, $raw=false){
		$content	= get_the_content('', false, $post);

		if(!$raw){
			$content	= apply_filters('the_content', $content);
			$content	= str_replace(']]>', ']]&gt;', $content);
		}

		return $content;
	}

	public static function get_excerpt($post=null, $excerpt_length=0, $excerpt_more=''){
		$post	= get_post($post);

		if(!($post instanceof WP_Post)){
			return '';
		}

		if($excerpt = $post->post_excerpt){
			return wp_strip_all_tags($excerpt, true);	
		}

		$excerpt	= get_the_content('', false, $post);
		
		$excerpt	= strip_shortcodes($excerpt);
		$excerpt	= function_exists('excerpt_remove_blocks') ? excerpt_remove_blocks($excerpt) : $excerpt;

		if(has_filter('the_content', 'wp_filter_content_tags')){
			remove_filter('the_content', 'wp_filter_content_tags');
			$filter_content_tags_readd	= true;
		}else{
			$filter_content_tags_readd	= false;
		}

		$excerpt	= apply_filters('the_content', $excerpt);
		$excerpt	= str_replace(']]>', ']]&gt;', $excerpt);

		if($filter_content_tags_readd){
			add_filter('the_content', 'wp_filter_content_tags');
		}
		
		$excerpt	= wp_strip_all_tags($excerpt, true);
		
		$excerpt_length	= $excerpt_length ?: apply_filters('excerpt_length', 200);
		$excerpt_more	= $excerpt_more ?: apply_filters('excerpt_more', ' '.'&hellip;');
		
		return mb_strimwidth($excerpt, 0, $excerpt_length, $excerpt_more, 'utf-8');
	}

	public static function get_thumbnail_url($post=null, $size='thumbnail', $crop=1){
		$post	= get_post($post);

		if(!($post instanceof WP_Post)){
			return '';
		}

		if(post_type_supports($post->post_type, 'thumbnail') && has_post_thumbnail($post)){
			$thumbnail_url	= wp_get_attachment_image_url(get_post_thumbnail_id($post), 'full');
		}else{
			$thumbnail_url	= apply_filters('wpjam_post_thumbnail_url', '', $post);
		}

		if($thumbnail_url && empty($size)){
			$pt_obj	= get_post_type_object($post->post_type);
			$size	= !empty($pt_obj->thumbnail_size) ? $pt_obj->thumbnail_size : 'thumbnail';
		}

		return $thumbnail_url ? wpjam_get_thumbnail($thumbnail_url, $size, $crop) : '';
	}

	public static function get_first_image_url($content=null, $size='full'){
		if(is_null($content) || is_object($content)){
			$post	= $content;
			
			if(post_password_required($post)){
				return '';
			}

			$content	= $post->post_content;
		}

		if($content){
			preg_match_all('/class=[\'"].*?wp-image-([\d]*)[\'"]/i', $content, $matches);
			if( $matches && isset($matches[1]) && isset($matches[1][0]) ){	
				$image_id = $matches[1][0];
				return wp_get_attachment_image_url($image_id, $size);
			}

			preg_match_all('/<img.*?src=[\'"](.*?)[\'"].*?>/i', $content, $matches);
			if( $matches && isset($matches[1]) && isset($matches[1][0]) ){	  
				return wpjam_get_thumbnail($matches[1][0], $size);
			}
		}
			
		return '';
	}

	public static function get_author($post=null, $size=96){
		$post	= get_post($post);
		
		if(!($post instanceof WP_Post)){
			return null;
		}

		$author_id	= $post->post_author;
		$author		= get_userdata($author_id);

		if($author){
			return [
				'id'		=> intval($author_id),
				'name'		=> $author->display_name,
				'avatar'	=> get_avatar_url($author_id, 200),
			];
		}else{
			return null;
		}
	}

	public static function get_related_query($post=null, $number=5, $post_type=null){
		$post	= get_post($post);

		if(!($post instanceof WP_Post)){
			return [];
		}

		$query_args	= [
			'cache_it'				=> true,
			'no_found_rows'			=> true,
			'ignore_sticky_posts'	=> true,
			'cache_results'			=> true,
			'related_query'			=> true,
			'post_status'			=> 'publish',
		];

		$query_args['post__not_in']		= [$post->ID];
		$query_args['post_type']		= $post_type ?: $post->post_type;
		$query_args['posts_per_page']	= $number ?: 5;

		$term_taxonomy_ids = [];

		if($taxonomies = get_object_taxonomies($post->post_type)){
			foreach ($taxonomies as $taxonomy) {
				if($terms	= get_the_terms($post->ID, $taxonomy)){
					$term_taxonomy_ids = array_merge($term_taxonomy_ids, array_column($terms, 'term_taxonomy_id'));
				}
			}

			$term_taxonomy_ids	= array_unique(array_filter($term_taxonomy_ids));
		}

		$query_args['term_taxonomy_ids']	= $term_taxonomy_ids;
		
		return new WP_Query($query_args);
	}

	public static function get_related($post_id=null, $args=[]){
		$post	= get_post($post_id);

		if(!($post instanceof WP_Post)){
			return [];
		}

		$post_type	= $args['post_type'] ?? null;
		$number		= $args['number'] ?? 5;

		$related_query	= self::get_related_query($post_id, $number, $post_type);

		return self::get_list($related_query, $args);
	}

	public static function get_list($wpjam_query, $args=[]){
		$parse_for_json	= $args['parse_for_json'] ?? true;

		if($parse_for_json){
			$args	= wp_parse_args($args, [
				'size'		=> '',
				'filter'	=> 'wpjam_related_post_json'
			]);

			$posts_json	= [];
		}else{
			$args	= wp_parse_args($args, [
				'title'			=> '',
				'div_id'		=> '',
				'class'			=> '', 
				'thumb'			=> true,	
				'excerpt'		=> false, 
				'size'			=> 'thumbnail', 
				'crop'			=> true, 
				'thumb_class'	=> 'wp-post-image'
			]);

			$output = '';
		}

		if($wpjam_query->have_posts()){

			while($wpjam_query->have_posts()){
				$wpjam_query->the_post();

				if($parse_for_json){
					global $post;
					
					$post_json	= [];

					$post_json['id']		= $post->ID;
					$post_json['timestamp']	= intval(strtotime(get_gmt_from_date($post->post_date)));
					$post_json['time']		= wpjam_human_time_diff($post_json['timestamp']);
					
					$post_json['title']		= html_entity_decode(get_the_title($post));

					if(is_post_type_viewable($post->post_type)){
						$post_json['name']		= urldecode($post->post_name);
						$post_json['post_url']	= str_replace(home_url(), '', get_permalink($post->ID));
					}

					if(post_type_supports($post->post_type, 'author')){
						$post_json['author']	= self::get_author($post);
					}

					if(post_type_supports($post->post_type, 'excerpt')){
						$post_json['excerpt']	= html_entity_decode(get_the_excerpt($post));
					}

					$post_json['thumbnail']		= self::get_thumbnail_url($post, $args['size']);

					$post_json		= apply_filters($args['filter'], $post_json, $post->ID, $args);

					$posts_json[]	= $post_json;
				}else{
					$li = get_the_title();

					if($args['thumb'] || $args['excerpt']){
						$li = '<h4>'.$li.'</h4>';

						if($args['thumb']){
							$li = wpjam_get_post_thumbnail(null, $args['size'], $args['crop'], $args['thumb_class'])."\n".$li;
						}

						if($args['excerpt']){
							$li .= "\n".wpautop(get_the_excerpt());
						}
					}

					if(!is_singular() || (is_singular() && get_queried_object_id() != get_the_ID())) {
						$li = '<a href="'.get_permalink().'" title="'.the_title_attribute(['echo'=>false]).'">'.$li.'</a>';
					}

					$output .=	'<li>'.$li.'</li>'."\n";
				}
			}
		}

		wp_reset_postdata();

		if($parse_for_json){
			return $posts_json;
		}else{
			if($args['thumb']){
				$args['class']	= $args['class'].' has-thumb';
			}
			
			$class	= $args['class'] ? ' class="'.$args['class'].'"' : '';
			$output = '<ul'.$class.'>'."\n".$output.'</ul>'."\n";

			if($args['title']){
				$output	= '<h3>'.$args['title'].'</h3>'."\n".$output;
			}

			if($args['div_id']){
				$output	= '<div id="'.$args['div_id'].'">'."\n".$output.'</div>'."\n";
			}

			return $output;	
		}
	}

	public static function get($post_id){
		$args	= ['content_required'=>true];

		if(is_admin()){
			$args['raw_content']	= true;
		}

		return self::parse_for_json($post_id, $args);
	}

	public static function insert($data){
		$data['post_status']	= $data['post_status']	?? 'publish';
		$data['post_author']	= $data['post_author']	?? get_current_user_id();
		$data['post_date']		= $data['post_date']	?? get_date_from_gmt(date('Y-m-d H:i:s', time()));

		return wp_insert_post(wp_slash($data), true);
	}

	public static function update($post_id, $data){
		$data['ID'] = $post_id;

		return wp_update_post(wp_slash($data), true);
	}

	public static function delete($post_id){
		if(!get_post($post_id)){
			return new WP_Error('post_not_exists', '文章不存在');
		}

		$result		= wp_delete_post($post_id, true);

		if(!$result){
			return new WP_Error('delete_failed', '删除失败');
		}else{
			return true;
		}
	}

	public static function update_meta($post_id, $meta_key, $meta_value){
		if($meta_value){
			return update_post_meta($post_id, $meta_key, wp_slash($meta_value));
		}else{
			return delete_post_meta($post_id, $meta_key);
		}
	}

	public static function duplicate($post_id){
		$post_arr	= get_post($post_id, ARRAY_A);

		unset($post_arr['ID']);
		unset($post_arr['post_date_gmt']);
		unset($post_arr['post_modified_gmt']);
		unset($post_arr['post_name']);

		$post_arr['post_status']	= 'draft';
		$post_arr['post_author']	= get_current_user_id();
		$post_arr['post_date_gmt']	= $post_arr['post_modified_gmt']	= date('Y-m-d H:i:s', time());
		$post_arr['post_date']		= $post_arr['post_modified']		= get_date_from_gmt($post_arr['post_date_gmt']);

		$tax_input	= [];

		foreach(get_object_taxonomies($post_arr['post_type']) as $taxonomy){
			$tax_input[$taxonomy]	= wp_get_object_terms($post_id, $taxonomy, ['fields' => 'ids']);
		}

		$post_arr['tax_input']	= $tax_input;

		$new_post_id	= wp_insert_post(wp_slash($post_arr), true);

		if(is_wp_error($new_post_id)){
			return $new_post_id;
		}

		$meta_keys	= get_post_custom_keys($post_id);

		foreach ($meta_keys as $meta_key) {
			if(in_array($meta_key, ['views', 'likes', 'favs']) || is_protected_meta($meta_key, 'post')){
				continue;
			}

			$meta_values	= get_post_meta($post_id, $meta_key);
			foreach ($meta_values as $meta_value){
				add_post_meta($new_post_id, $meta_key, $meta_value, false);
			}
		}

		return $new_post_id;
	}

	public static function parse_for_json($post_id, $args=[]){
		$args	= wp_parse_args($args, array(
			'thumbnail_size'	=> '',
			'content_required'	=> false,
			'raw_content'		=> false,
			'sticky_posts'		=> []
		));

		if(empty($post_id))	{
			return null;
		}

		$GLOBALS['post']	= $post	= self::get_post($post_id);

		if(empty($post)){
			return null;
		}

		setup_postdata($post);

		$post_id	= intval($post->ID);
		$post_type	= $post->post_type;

		if(!post_type_exists($post_type)){
			return [];
		}

		$post_json	= [];

		$post_json['id']		= $post_id;
		$post_json['post_type']	= $post_type;
		$post_json['status']	= $post->post_status;

		if($args['sticky_posts'] && is_array($args['sticky_posts']) && in_array($post_id, $args['sticky_posts'])){
			$post_json['is_sticky']	= true;
		}

		if($post->post_password){
			$post_json['password_protected']	= true;
			if(post_password_required($post)){
				$post_json['passed']	= false;
			}else{
				$post_json['passed']	= true;
			}
		}else{
			$post_json['password_protected']	= false;
		}

		$post_json['timestamp']			= intval(strtotime(get_gmt_from_date($post->post_date)));
		$post_json['time']				= wpjam_human_time_diff($post_json['timestamp']);
		$post_json['modified_timestamp']= intval(strtotime($post->post_modified_gmt));
		$post_json['modified']			= wpjam_human_time_diff($post_json['modified_timestamp']);

		if(is_post_type_viewable($post_type)){
			$post_json['name']		= urldecode($post->post_name);
			$post_json['post_url']	= str_replace(home_url(), '', get_permalink($post_id));
		}

		$post_json['title']		= '';
		if(post_type_supports($post_type, 'title')){
			$post_json['title']		= html_entity_decode(get_the_title($post));

			if(is_singular($post_type)){
				$post_json['page_title']	= $post_json['title'];
				$post_json['share_title']	= $post_json['title'];
			}
		}

		$post_json['thumbnail']		= self::get_thumbnail_url($post, $args['thumbnail_size']);

		if(post_type_supports($post_type, 'author')){
			$post_json['author']	= self::get_author($post);
		}
		
		if(post_type_supports($post_type, 'excerpt')){
			$post_json['excerpt']	= html_entity_decode(get_the_excerpt($post));
		}

		if(post_type_supports($post_type, 'page-attributes')){
			$post_json['menu_order']	= intval($post->menu_order);
		}

		if(post_type_supports($post_type, 'post-formats')){
			$post_json['format']	= get_post_format($post) ?: '';
		}

		if($taxonomies = get_object_taxonomies($post_type)){
			foreach ($taxonomies as $taxonomy) {
				if($taxonomy != 'post_format'){
					if($terms	= get_the_terms($post_id, $taxonomy)){
						array_walk($terms, function(&$term) use ($taxonomy){ $term 	= wpjam_get_term($term, $taxonomy);});
						$post_json[$taxonomy]	= $terms;
					}else{
						$post_json[$taxonomy]	= [];
					}		
				}
			}
		}

		if(is_singular($post_type) || $args['content_required']){
			if(post_type_supports($post_type, 'editor')){
				if($args['raw_content']){
					$post_json['raw_content']	= self::get_content($post, true);
				}

				$post_json['content']	= self::get_content($post);	

				global $page, $numpages, $multipage;

				$post_json['multipage']	= boolval($multipage);

				if($multipage){
					$post_json['numpages']	= $numpages;
					$post_json['page']		= $page;
				}
			}

			if(is_singular($post_type)){
				self::update_views($post_id);
			}
		}
		
		$post_json['views']	= self::get_views($post_id);

		return apply_filters('wpjam_post_json', $post_json, $post_id, $args);
	}

	public static function get_by_ids($post_ids){
		return self::update_caches($post_ids);
	}
	
	public static function update_caches($post_ids, $args=[]){
		if($post_ids){
			$post_ids 	= array_filter($post_ids);
			$post_ids 	= array_unique($post_ids);
		}

		if(empty($post_ids)) {
			return [];
		}

		$update_term_cache	= $args['update_post_term_cache'] ?? true;
		$update_meta_cache	= $args['update_post_meta_cache'] ?? true;

		_prime_post_caches($post_ids, $update_term_cache, $update_meta_cache);

		if(function_exists('wp_cache_get_multiple')){
			$cache_values	= wp_cache_get_multiple($post_ids, 'posts');

			foreach ($post_ids as $post_id) {
				if(empty($cache_values[$post_id])){
					wp_cache_add($post_id, false, 'posts', 10);	// 防止大量 SQL 查询。
				}
			}

			return $cache_values;
		}else{
			$cache_values	= [];

			foreach ($post_ids as $post_id) {
				$cache	= wp_cache_get($post_id, 'posts');

				if($cache !== false){
					$cache_values[$post_id]	= $cache;
				}
			}

			return $cache_values;
		}
	}

	public static function get_post($post, $output=OBJECT, $filter='raw'){
		if($post && is_numeric($post)){
			$found	= false;
			$cache	= wp_cache_get($post, 'posts', false, $found);

			if($found){
				if(is_wp_error($cache)){
					return $cache;
				}elseif(!$cache){
					return null;
				}
			}
		}

		return get_post($post, $output, $filter);
	}
}

class WPJAM_Post_Type{
	protected static $post_types	= [];
	
	public static function register($name, $args=[]){
		$args	= wp_parse_args($args, [
			'public'			=> true,
			'show_ui'			=> true,
			'hierarchical'		=> false,
			'rewrite'			=> true,
			'permastruct'		=> false,
			'thumbnail_size'	=> '',
			// 'capability_type'	=> $post_type,
			// 'map_meta_cap'		=> true,
			'supports'			=> ['title'],
			'taxonomies'		=> [],
		]);

		if(empty($args['taxonomies'])){
			unset($args['taxonomies']);
		}

		$permastruct	= $args['permastruct'];

		if($args['hierarchical']){
			$args['supports'][]	= 'page-attributes';

			if($permastruct && (strpos($permastruct, '%post_id%') || strpos($permastruct, '%'.$name.'_id%'))){
				$args['permastruct']	= $permastruct	= false;
			}
		}else{
			if($permastruct && (strpos($permastruct, '%post_id%') || strpos($permastruct, '%'.$name.'_id%'))){
				$args['query_var']	= false;
			}
		}

		if($permastruct){
			if(empty($args['rewrite'])){
				$args['rewrite']	= true;
			}
		}

		if($args['rewrite']){
			if(is_array($args['rewrite'])){
				$args['rewrite']	= wp_parse_args($args['rewrite'], ['with_front'=>false, 'feeds'=>false]);
			}else{
				$args['rewrite']	= ['with_front'=>false, 'feeds'=>false];
			}
		}

		self::$post_types[$name]	= $args;
	}

	public static function filter_post_type_labels($labels){
		$post_type	= str_replace('post_type_labels_', '', current_filter());
		$args		= self::$post_types[$post_type];
		$_labels	= $args['labels'] ?? [];

		$labels		= (array)$labels;
		$name		= $labels['name'];
		
		$search		= empty($args['hierarchical']) ? ['文章', 'post', 'Post', '撰写新', '写'] : ['页面', 'page', 'Page', '撰写新', '写'];
		$replace	= [$name, $name, ucfirst($name), '新建', '新建'];

		foreach ($labels as $key => &$label) {
			if($label && empty($_labels[$key])){
				if($key == 'all_items'){
					$label	= '所有'.$name;
				}elseif($label != $name){
					$label	= str_replace($search, $replace, $label);
				}
			}
		}

		return $labels;
	}

	public static function init(){
		foreach (apply_filters('wpjam_post_types', self::$post_types) as $name=>$args) {
			if(is_admin() && !empty($args['show_ui']) && isset(self::$post_types[$name])){
				add_filter('post_type_labels_'.$name, ['WPJAM_Post_Type', 'filter_post_type_labels']);
			}

			register_post_type($name, $args);
		}
	}

	public static function on_registered_post_type($post_type, $post_type_object){
		$permastruct	= $post_type_object->permastruct ?? '';

		if($permastruct){
			if(strpos($permastruct, '%post_id%') || strpos($permastruct, '%'.$post_type.'_id%')){
				$GLOBALS['wp_rewrite']->extra_permastructs[$post_type]['struct']	= str_replace('%post_id%', '%'.$post_type.'_id%', $permastruct);

				add_rewrite_tag('%'.$post_type.'_id%', '([0-9]+)', 'post_type='.$post_type.'&p=');

				remove_rewrite_tag('%'.$post_type.'%');
			}elseif(strpos($permastruct, '%postname%')){
				$GLOBALS['wp_rewrite']->extra_permastructs[$post_type]['struct'] = $permastruct;
			}
		}
	}

	public static function filter_post_type_link($post_link, $post){
		$post_type	= $post->post_type;

		if(array_search('%'.$post_type.'_id%', $GLOBALS['wp_rewrite']->rewritecode, true)){
			$post_link	= str_replace('%'.$post_type.'_id%', $post->ID, $post_link);
		}

		if(strpos($post_link, '%') !== false && ($taxonomies = get_object_taxonomies($post_type, 'objects'))){
			foreach ($taxonomies as $taxonomy=>$taxonomy_object) {
				if($taxonomy_rewrite = $taxonomy_object->rewrite){

					if(strpos($post_link, '%'.$taxonomy_rewrite['slug'].'%') === false){
						continue;
					}

					if($terms = get_the_terms($post->ID, $taxonomy)){
						$post_link	= str_replace('%'.$taxonomy_rewrite['slug'].'%', current($terms)->slug, $post_link);
					}else{
						$post_link	= str_replace('%'.$taxonomy_rewrite['slug'].'%', $taxonomy, $post_link);
					}
				}
			}
		}

		return $post_link;
	}

	public static function filter_post_password_required($required, $post){
		if(!$required){
			return $required;
		}

		$hash	= wpjam_get_parameter('post_password', ['method'=>'REQUEST']);

		if(empty($hash) || 0 !== strpos($hash, '$P$B')){
			return true;
		}

		require_once ABSPATH . WPINC . '/class-phpass.php';

		$hasher	= new PasswordHash(8, true);

		return !$hasher->CheckPassword($post->post_password, $hash);
	}

	public static function filter_posts_clauses($clauses, $wp_query){
		global $wpdb;

		if($wp_query->get('related_query')){
			if($term_taxonomy_ids	= $wp_query->get('term_taxonomy_ids')){
				$clauses['fields']	.= ", count(tr.object_id) as cnt";
				$clauses['join']	.= "INNER JOIN {$wpdb->term_relationships} AS tr ON {$wpdb->posts}.ID = tr.object_id";
				$clauses['where']	.= " AND tr.term_taxonomy_id IN (".implode(",",$term_taxonomy_ids).")";
				$clauses['groupby']	.= " tr.object_id";
				$clauses['orderby']	= " cnt DESC, {$wpdb->posts}.post_date_gmt DESC";	
			}
		}elseif($wp_query->get('orderby') && in_array($wp_query->get('orderby'), ['views', 'favs', 'likes'])){
			$orderby	= $wp_query->get('orderby');
			$order		= $wp_query->get('order') ?: 'DESC';

			$clauses['fields']	.= ", (COALESCE(jam_pm.meta_value, 0)+0) as {$orderby}";
			$clauses['join']	.= "LEFT JOIN {$wpdb->postmeta} jam_pm ON {$wpdb->posts}.ID = jam_pm.post_id AND jam_pm.meta_key = '{$orderby}' ";
			$clauses['orderby']	= "{$orderby} {$order}, " . $clauses['orderby'];
		}

		return $clauses;
	}
}

class WPJAM_Post_Option{
	protected static $post_options	= [];

	public static function register($meta_box, $args=[]){
		self::$post_options[$meta_box]	= $args;
	}

	public static function get_options($post_type, $post_id=null){
		$pt_options	= [];
		
		if($post_options = apply_filters('wpjam_post_options', self::$post_options, $post_type, $post_id)){
			foreach($post_options as $meta_box => $post_option){
				$post_option = wp_parse_args($post_option, [
					'fields'		=> [],
					'post_types'	=> 'all',
					'post_type'		=> ''
				]);

				if($post_option['post_type'] && $post_option['post_types'] == 'all'){
					$post_option['post_types'] = [$post_option['post_type']];
				}

				if($post_option['post_types'] == 'all' || in_array($post_type, $post_option['post_types'])){
					if(is_callable($post_option['fields'])){
						if(isset($post_id)){
							$post_option['fields'] = call_user_func($post_option['fields'], $post_id, $meta_box);
						}else{
							continue;
						}
					}

					$pt_options[$meta_box] = $post_option;
				}
			}
		}

		return apply_filters('wpjam_'.$post_type.'_post_options', $pt_options, $post_type, $post_id);
	}

	public static function get_fields($post_type, $post_id=null){
		$fields	= [];

		if($post_options = self::get_options($post_type, $post_id)) {
			foreach ($post_options as $meta_box => $post_option) {
				if(!empty($post_option['update_callback'])){
					continue;
				}

				$fields	= array_merge($fields, $post_option['fields']);
			}
		}

		return $fields;
	}
}

class WPJAM_Term{
	public static function get_thumbnail_url($term=null, $size='full', $crop=1){
		$term	= $term ?: get_queried_object();
		$term	= get_term($term);

		if(!$term) {
			return '';
		}

		$thumbnail_url	= apply_filters('wpjam_term_thumbnail_url', '', $term);

		return $thumbnail_url ? wpjam_get_thumbnail($thumbnail_url, $size, $crop) : '';
	}

	public static function get_children($term, $children_terms=[], $max_depth=-1, $depth=0){
		$term	= self::parse_for_json($term);

		if(is_wp_error($term)){
			return $term;
		}

		$term['children'] = [];

		if($children_terms){
			$term_id	= $term['id'];

			if(($max_depth == 0 || $max_depth > $depth+1) && isset($children_terms[$term_id])){
				foreach($children_terms[$term_id] as $child){
					$term['children'][]	= self::get_children($child, $children_terms, $max_depth, $depth + 1);
				}
			} 
		}

		return $term;
	}

	/**
	* $max_depth = -1 means flatly display every element.
	* $max_depth = 0 means display all levels.
	* $max_depth > 0 specifies the number of display levels.
	*
	*/
	public static function get_terms($args, $max_depth=-1){
		$taxonomy	= $args['taxonomy'];
		$parent		= 0;

		$raw_args	= $args;

		if(isset($args['parent']) && ($max_depth != -1 && $max_depth != 1)){
			$parent		= $args['parent'];
			unset($args['parent']);
		}

		$terms = get_terms($args) ?: [];

		if(is_wp_error($terms) || empty($terms)){
			return $terms;
		}

		if($max_depth == -1){
			foreach ($terms as &$term) {
				$term = self::parse_for_json($term, $taxonomy); 

				if(is_wp_error($term)){
					return $term;
				}
			}
		}else{
			$top_level_terms	= [];
			$children_terms		= [];

			foreach($terms as $term){
				if($parent){
					if($term->term_id == $parent){
						$top_level_terms[] = $term;
					}elseif($term->parent){
						$children_terms[$term->parent][] = $term;
					}
				}else{
					if(empty($term->parent)){
						$top_level_terms[] = $term;
					}else{
						$children_terms[$term->parent][] = $term;
					}
				}
			}

			if($terms = $top_level_terms){
				foreach ($terms as &$term) {
					if($max_depth == 1){
						$term = self::parse_for_json($term, $taxonomy);
					}else{
						$term = self::get_children($term, $children_terms, $max_depth, 0);	
					}

					if(is_wp_error($term)){
						return $term;
					}
				}
			}
		}
	
		return apply_filters('wpjam_terms', $terms, $raw_args, $max_depth);
	}

	public static function flatten($terms, $depth=0){
		$terms_flat	= [];

		if($terms){
			foreach ($terms as $term){
				$term['name']	= str_repeat('&nbsp;', $depth*3).$term['name'];
				$terms_flat[]	= $term;

				if(!empty($term['children'])){
					$depth++;

					$terms_flat	= array_merge($terms_flat, self::flatten($term['children'], $depth));

					$depth--;
				}
			}
		}

		return $terms_flat;
	}

	public static function get($term_id){
		$term	= get_term($term_id);

		if(is_wp_error($term) || empty($term)){
			return [];
		}else{
			return self::parse_for_json($term, $term->taxonomy);
		}
	}

	public static function insert($data){
		$taxonomy		= $data['taxonomy']		?? '';

		if(empty($taxonomy)){
			return new WP_Error('empty_taxonomy', '分类模式不能为空');
		}

		$name			= $data['name']			?? '';
		$parent			= $data['parent']		?? 0;
		$slug			= $data['slug']			?? '';
		$description	= $data['description']	?? '';

		if(term_exists($name, $taxonomy)){
			return new WP_Error('term_exists', '相同名称的'.get_taxonomy($taxonomy)->label.'已存在。');
		}

		$term	= wp_insert_term(wp_slash($name), $taxonomy, wp_slash(compact('parent','slug','description')));

		if(is_wp_error($term)){
			return $term;
		}

		$term_id	= $term['term_id'];

		$meta_input	= $data['meta_input']	?? [];

		if($meta_input){
			foreach($meta_input as $meta_key => $meta_value) {
				update_term_meta($term_id, $meta_key, $meta_value);
			}
		}

		return $term_id;
	}

	public static function update($term_id, $data){
		$taxonomy		= $data['taxonomy']	?? '';

		if(empty($taxonomy)){
			return new WP_Error('empty_taxonomy', '分类模式不能为空');
		}

		$term	= self::get_term($term_id, $taxonomy);

		if(is_wp_error($term)){
			return $term;
		}

		if(isset($data['name'])){
			$exist	= term_exists($data['name'], $taxonomy);

			if($exist){
				$exist_term_id	= $exist['term_id'];

				if($exist_term_id != $term_id){
					return new WP_Error('term_name_duplicate', '相同名称的'.get_taxonomy($taxonomy)->label.'已存在。');
				}
			}
		}

		$term_args = [];

		$term_keys = ['name', 'parent', 'slug', 'description'];

		foreach($term_keys as $key) {
			$value = $data[$key] ?? null;
			if (is_null($value)) {
				continue;
			}

			$term_args[$key] = $value;
		}

		if(!empty($term_args)){
			$term =	wp_update_term($term_id, $taxonomy, wp_slash($term_args));
			if(is_wp_error($term)){
				return $term;	
			}
		}

		$meta_input		= $data['meta_input']	?? [];

		if($meta_input){
			foreach($meta_input as $meta_key => $meta_value) {
				update_term_meta($term['term_id'], $meta_key, $meta_value);
			}
		}

		return true;
	}

	public static function delete($term_id){
		$term	= get_term($term_id);

		if(is_wp_error($term) || empty($term)){
			return $term;
		}

		return wp_delete_term($term_id, $term->taxonomy);
	}

	public static function update_meta($term_id, $meta_key, $meta_value){
		if($meta_value){
			return update_term_meta($term_id, $meta_key, wp_slash($meta_value));
		}else{
			return delete_term_meta($term_id, $meta_key);
		}
	}

	public static function merge($term_id, $merge_to, $delete=true){
		$term	= get_term($term_id);

		if(is_wp_error($term) || empty($term)){
			return $term;
		}

		$merge_to_term	= get_term($merge_to);

		if(is_wp_error($merge_to_term) || empty($merge_to_term)){
			return $merge_to_term;
		}

		$taxonomy_obj	= get_taxonomy($term->taxonomy);
		$post_types		= $taxonomy_obj->object_type;

		$query	= new WP_Query([
			'post_type'		=> $post_types,
			'post_status'	=> 'all',
			'fields'		=> 'ids',
			'posts_per_page'=> -1,
			'tax_query'		=> [
				['taxonomy'=>$term->taxonomy, 'terms'=>[$term_id], 'field'=>'id']
			]
		]);

		if($query->posts){
			foreach($query->posts as $post_id) {
				wp_set_post_terms($post_id, $merge_to, $merge_to_term->taxonomy, true);
			}
		}

		if($delete){
			return self::delete($term_id);
		}else{
			return true;
		}
	}
	
	public static function parse_for_json($term, $taxonomy=null){
		$term	= self::get_term($term, $taxonomy);
		
		if(is_wp_error($term) || empty($term) || ($taxonomy && $taxonomy != $term->taxonomy)){
			if($taxonomy){
				return new WP_Error('illegal_'.$taxonomy.'_id', $taxonomy.'_id 无效');	
			}else{
				return new WP_Error('illegal_term_id', 'term_id 无效');
			}
		}

		$term_json	= [];

		$term_json['id']		= $term_id	= $term->term_id;
		$term_json['taxonomy']	= $taxonomy	= $term->taxonomy;
		$term_json['name']		= $term->name;

		if(get_queried_object_id() == $term_id){
			$term_json['page_title']	= $term->name;
			$term_json['share_title']	= $term->name;
		}

		$taxonomy_obj	= get_taxonomy($taxonomy);

		if($taxonomy_obj->public || $taxonomy_obj->publicly_queryable || $taxonomy_obj->query_var){
			$term_json['slug']		= $term->slug;
		}
		
		$term_json['count']			= intval($term->count);
		$term_json['description']	= $term->description;
		$term_json['parent']		= $term->parent;
		
		return apply_filters('wpjam_term_json', $term_json, $term_id);
	}

	public static function get_by_ids($post_ids){
		return self::update_caches($post_ids);
	}

	public static function update_caches($term_ids, $args=[]){
		if($term_ids){
			$term_ids 	= array_filter($term_ids);
			$term_ids 	= array_unique($term_ids);
		}

		if(empty($term_ids)) {
			return [];
		}

		$update_meta_cache	= $args['update_meta_cache'] ?? true;

		_prime_term_caches($term_ids, $update_meta_cache);

		if(function_exists('wp_cache_get_multiple')){
			$cache_values	= wp_cache_get_multiple($post_ids, 'terms');

			foreach ($term_ids as $term_id) {
				if(empty($cache_values[$term_id])){
					wp_cache_add($term_id, false, 'terms', 10);	// 防止大量 SQL 查询。
				}
			}

			return $cache_values;
		}else{
			$cache_values	= [];

			foreach ($term_ids as $term_id) {
				$cache	= wp_cache_get($term_id, 'terms');

				if($cache !== false){
					$cache_values[$term_id]	= $cache;
				}
			}

			return $cache_values;
		}	
	}

	public static function get_term($term, $taxonomy='', $output=OBJECT, $filter='raw'){
		if($term && is_numeric($term)){
			$found	= false;
			$cache	= wp_cache_get($term, 'terms', false, $found);

			if($found){
				if(is_wp_error($cache)){
					return $cache;
				}elseif(!$cache){
					return null;
				}
			}
		}

		return get_term($term, $taxonomy, $output, $filter);
	}
}

class WPJAM_Taxonomy extends WPJAM_Term{
	protected static $taxonomies	= [];
	
	public static function register($name, $args=[]){
		if(empty($args['object_type'])){
			return;
		}

		$object_type	= $args['object_type'];

		$args	= $args['args'] ?? $args;
		$args	= wp_parse_args($args, [
			'object_type'		=> $object_type,
			'show_ui'			=> true,
			'show_in_nav_menus'	=> false,
			'show_admin_column'	=> true,
			'hierarchical'		=> true,
			'rewrite'			=> true,
			'permastruct'		=> false,
			'supports'			=> ['slug', 'description', 'parent']
		]);

		$permastruct	= $args['permastruct'];

		if($permastruct){
			$args['rewrite']	= true;

			if(strpos($permastruct, '%term_id%') || strpos($permastruct, '%'.$name.'_id%')){	
				$args['query_var']	= false;
				$args['supports']	= array_diff($args['supports'], ['slug']);
			}
		}

		if($args['rewrite']){
			if(is_array($args['rewrite'])){
				$args['rewrite']	= wp_parse_args($args['rewrite'], ['with_front'=>false, 'feed'=>false, 'hierarchical'=>false]);
			}else{
				$args['rewrite']	= ['with_front'=>false, 'feed'=>false, 'hierarchical'=>false];
			}
		}

		self::$taxonomies[$name]	= $args;
	}

	public static function init(){
		foreach (apply_filters('wpjam_taxonomies', self::$taxonomies) as $name => $args) {
			if(is_admin() && !empty($args['show_ui'])){
				add_filter('taxonomy_labels_'.$name,	['WPJAM_Taxonomy', 'filter_taxonomy_labels']);
			}

			register_taxonomy($name, $args['object_type'], $args);
		}
	}

	public static function on_registered_taxonomy($name, $object_type, $args){
		$permastruct	= $args['permastruct'] ?? '';

		if($permastruct){
			if(strpos($permastruct, '%term_id%') || strpos($permastruct, '%'.$name.'_id%')){
				$GLOBALS['wp_rewrite']->extra_permastructs[$name]['struct']	= str_replace('%term_id%', '%'.$name.'_id%', $permastruct);

				add_rewrite_tag('%'.$name.'_id%', '([^/]+)', 'taxonomy='.$name.'&term_id=');
				remove_rewrite_tag('%'.$name.'%');
			}elseif(strpos($permastruct, '%'.get_taxonomy($name)->rewrite['slug'].'%')){
				$GLOBALS['wp_rewrite']->extra_permastructs[$name]['struct']	= $permastruct;
			}
		}
	}

	public static function filter_taxonomy_labels($labels){
		$taxonomy	= str_replace('taxonomy_labels_', '', current_filter());
		$args		= self::$taxonomies[$taxonomy];
		$_labels	= $args['labels'] ?? [];

		$labels		= (array)$labels;
		$name		= $labels['name'];

		if(empty($args['hierarchical'])){
			$search		= ['标签', 'Tag', 'tag'];
			$replace	= [$name, ucfirst($name), $name];
		}else{
			$search		= ['目录', '分类', 'categories', 'Categories', 'Category'];
			$replace	= ['', $name, $name, $name.'s', ucfirst($name).'s', ucfirst($name)];
		}

		foreach ($labels as $key => &$label) {
			if($label && empty($_labels[$key]) && $label != $name){
				$label	= str_replace($search, $replace, $label);
			}
		}

		return $labels;
	}

	public static function filter_pre_term_link($term_link, $term){
		$taxonomy	= $term->taxonomy;

		if(array_search('%'.$taxonomy.'_id%', $GLOBALS['wp_rewrite']->rewritecode, true)){
			$term_link	= str_replace('%'.$taxonomy.'_id%', $term->term_id, $term_link);
		}

		return $term_link;
	}
}

class WPJAM_Term_Option{
	protected static $term_options	= [];

	public static function register($key, $args=[]){
		self::$term_options[$key]	= $args;
	}

	public static function get_options($taxonomy){
		$taxonomy_options	= [];

		if($term_options = apply_filters('wpjam_term_options', self::$term_options, $taxonomy)){
			foreach ($term_options as $key => $term_option) {
				$term_option	= wp_parse_args( $term_option, [
					'taxonomies'	=> 'all',
					'taxonomy'		=> ''
				]);

				if($term_option['taxonomy'] && $term_option['taxonomies'] == 'all'){
					$term_option['taxonomies'] = [$term_option['taxonomy']];
				}

				if($term_option['taxonomies'] == 'all' || in_array($taxonomy, $term_option['taxonomies'])){
					$taxonomy_options[$key]	= $term_option;
				}
			}
		}

		return apply_filters('wpjam_'.$taxonomy.'_term_options', $taxonomy_options);
	}
}

class WPJAM_User{
	public static function insert($data){
		return wp_insert_user(wp_slash($data));
	}

	public static function update($user_id, $data){
		$data['ID'] = $user_id;

		return wp_update_user(wp_slash($data));
	}

	public static function get_current_user(){
		return apply_filters('wpjam_current_user', null);
	}

	public static function get_current_commenter(){
		$commenter	= wp_get_current_commenter();

		if(!is_wp_error($commenter) && empty($commenter['comment_author_email'])){
			return new WP_Error('empty_comment_author', '登录之后才能操作');
		}
		
		return $commenter;
	}

	public static function update_meta($user_id, $meta_key, $meta_value){
		if($meta_value){
			return update_user_meta($user_id, $meta_key, wp_slash($meta_value));
		}else{
			return delete_user_meta($user_id, $meta_key);
		}
	}

	public static function filter_current_user($user_id){
		if(empty($user_id)){
			$wpjam_user	= self::get_current_user();

			if($wpjam_user && !is_wp_error($wpjam_user) && !empty($wpjam_user['user_id'])){
				return $wpjam_user['user_id'];
			}
		}

		return $user_id;
	}

	public static function filter_current_commenter($commenter){
		if(empty($commenter['comment_author_email'])){
			$wpjam_user	= self::get_current_user();

			if(is_wp_error($wpjam_user)){
				return $wpjam_user;
			}elseif(empty($wpjam_user) || empty($wpjam_user['user_email'])){
				return new WP_Error('bad_authentication', '无权限');
			}else{
				$commenter['comment_author_email']	= $wpjam_user['user_email'];
				$commenter['comment_author']		= $wpjam_user['nickname'];
			}	
		}

		return $commenter;
	}
}