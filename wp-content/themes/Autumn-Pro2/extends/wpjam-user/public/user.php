<?php
add_filter('wpjam_option_use_site_default', function($status, $option_name){
	if($option_name == 'wpjam-avatar'){
		return true;
	}

	return $status;
}, 10, 2);

function wpjam_get_user_setting($setting_name){
	return wpjam_get_setting('wpjam-avatar', $setting_name);
}

add_filter('wpjam_default_avatar_data', function($args, $user_id){
	if($args['found_avatar']){
		return $args;
	}

	$defaults	= wpjam_get_user_setting('defaults');

	if($defaults){
		$i	= $user_id  % count($defaults);

		$priority	= wpjam_get_user_setting('priority');

		if($priority == 'gravatar'){
			$args['default']		= wpjam_get_thumbnail($defaults[$i]);
		}else{
			$args['found_avatar']	= true;	
			$args['url']			= wpjam_get_thumbnail($defaults[$i], [$args['width'],$args['height']]);
		}
	}
	
	return $args;
}, 10, 3);

if(wpjam_get_user_setting('last_login')){
	add_action('wp_login', function($user_login, $user){
		update_user_meta($user->ID, 'last_login', time());
	}, 10, 2);
}
 

function wpjam_get_user_personal_meta(){
	return ['syntax_highlighting', 'comment_shortcuts', 'rich_editing', 'use_ssl', 'show_admin_bar_front', 'admin_color', 'locale'];
}

add_filter('insert_user_meta', function($meta, $user, $update){
	if(wpjam_get_user_setting('disable_personal')){
		foreach(wpjam_get_user_personal_meta() as $key){
			$meta[$key]	= '';
		}
	}

	if(wpjam_get_user_setting('nickname_as_display_name')){
		$meta['nickname']	= '';
	}

	if(wpjam_get_user_setting('disable_first_last_name')){
		$meta['first_name']	= $meta['last_name'] = '';
	}
	
	foreach ($meta as $key => $value) {
		if(!$value){
			unset($meta[$key]);
			delete_user_meta($user->ID, $key);
		}
	}

	return $meta;
}, 10, 3);

add_filter('update_user_metadata', function($check, $user_id, $meta_key, $meta_value){
	if($meta_key == 'nickname'){
		if(wpjam_get_user_setting('nickname_as_display_name')){
			if($user = get_userdata($user_id)){
				if($user->display_name != $meta_value){
					add_filter('insert_user_meta', '__return_empty_array');
					return wp_update_user(['ID'=>$user_id, 'display_name'=>$meta_value]);
				}
			}

			return true;
		}
	}elseif(in_array($meta_key, wpjam_get_user_personal_meta())){
		if(wpjam_get_user_setting('disable_personal')){
			return true;
		}
	}

	return $check;
}, 1, 4);

add_filter('get_user_metadata', function($pre, $user_id, $meta_key){
	if($meta_key == 'nickname'){
		if(wpjam_get_user_setting('nickname_as_display_name')){

			if($user = get_userdata($user_id)){
				return [$user->display_name];
			}

			return [''];
		}
	}elseif(in_array($meta_key, wpjam_get_user_personal_meta())){
		if(wpjam_get_user_setting('disable_personal')){
			if($meta_key == 'syntax_highlighting'){
				if(user_can($user_id, 'edit_theme_options') || user_can($user_id, 'edit_plugins') || user_can($user_id, 'edit_themes')){
					return ['true'];
				}else{
					return ['false'];
				}
			}elseif(in_array($meta_key, ['comment_shortcuts', 'rich_editing'])){
				if(user_can($user_id, 'edit_posts') || user_can($user_id, 'edit_pages')){
					return ['true'];	
				}else{
					return ['false'];
				}
			}elseif($meta_key == 'use_ssl'){
				return [force_ssl_admin()];
			}elseif($meta_key == 'locale'){
				return get_option('WPLANG');
			}elseif($meta_key == 'admin_color'){
				return ['fresh'];
			}elseif($meta_key == 'show_admin_bar_front'){
				return [false];
			}
		}
	}

	return $pre;
}, 1, 3);