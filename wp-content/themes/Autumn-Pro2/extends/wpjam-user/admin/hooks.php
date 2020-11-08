<?php
if(!get_option('wpjam-avatar')){
	update_option('wpjam-avatar', [
		'disable_personal'			=> 1,
		'nickname_as_display_name'	=> 1,
		'disable_first_last_name'	=> 1,
		'hide_user_login'			=> 1,
		'nicename_enable'			=> 1,
		'limit_login_attempts'		=> 1,
		'order_by_registered'		=> 1
	]);
}

add_action('admin_init', function(){
	if(current_user_can('publish_posts')){
		return; 
	}

	if(current_user_can('publish_posts')){
		return; 
	}
	
	if(!current_user_can('upload_files')){
		$current_user	= wp_get_current_user();

		if(isset($current_user->roles)){
			foreach ($current_user->roles as $role_name) {
				$role	= get_role($role_name);
				if(!$role->has_cap('upload_files')){
					$role->add_cap('upload_files');
				}
			}
		}
	}

	add_filter('upload_mimes', function($mimes, $user){
		$unfiltered	= $user ? user_can($user, 'unfiltered_html') : current_user_can('unfiltered_html');

		if(!$unfiltered){
			foreach ($mimes as $ext => $mime) {
				$mime = explode('/', $mime);
				if($mime[0] != 'image'){
					unset($mimes[$ext]);
				}
			}
		}

		return $mimes;
	}, 10, 2);

	add_action('pre_get_posts', function($wp_query){
		if(isset($wp_query->query['post_type']) && $wp_query->query['post_type'] === 'attachment'){
			$wp_query->set('author', get_current_user_id());
		}
	});
});

add_action('admin_print_footer_scripts', function(){
	if(get_current_screen()->base == 'options-discussion'){

	remove_action('admin_print_footer_scripts', 'options_discussion_add_js');
	?>
	<script type="text/javascript">
	(function($){
		$('.avatar-settings').remove();
	})(jQuery);
	</script>
	<?php }
},1);