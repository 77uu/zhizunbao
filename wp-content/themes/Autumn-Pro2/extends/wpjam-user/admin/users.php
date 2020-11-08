<?php
// 后台可以根据显示的名字来搜索用户 
add_filter('user_search_columns',function($search_columns){
	return ['ID', 'user_login', 'user_email', 'user_url', 'user_nicename', 'display_name'];
});

if(wpjam_get_user_setting('login_as')){
	add_filter('wpjam_users_actions', function($actions){
		return array_merge($actions, [
			'login_as'		=>['title'=>'以此身份登陆'],
		]);
	});

	add_filter('user_row_actions',	function ($actions, $user){
		$capability	= is_multisite() ? 'manage_site' : 'manage_options';
		if(current_user_can($capability)){
			$actions['login_as']	= '<a title="以此身份登陆" href="'.wp_nonce_url("users.php?action=login_as&amp;users=$user->ID", 'login-users').'">以此身份登陆</a>';
		}else{
			unset($actions['login_as']);
		}
		
		return $actions;
	}, 10, 2);

	add_filter('handle_bulk_actions-users', function($sendback, $action, $user_ids){
		if($action == 'login_as'){
			check_admin_referer('login-users');

			$capability	= is_multisite() ? 'manage_site' : 'manage_options';
			if(current_user_can($capability)){
				wp_set_auth_cookie($user_ids, true);
				wp_set_current_user($user_ids);
			}
		}
		return admin_url();
	},10,3);
}

add_filter('manage_users_columns', function($columns){
	if(wpjam_get_user_setting('order_by_registered')){
		$columns['registered']	= '注册时间';	
	}

	if(wpjam_get_user_setting('last_login')){
		$columns['last_login']	= '最后登录';	
	}

	if(wpjam_get_user_setting('disable_first_last_name')){
		unset($columns['name']);
		wpjam_array_push($columns, ['display_name'=>'显示名称'], 'role');	
	}
		
	return $columns;
});

add_filter('wpmu_users_columns', function($columns){
	if(wpjam_get_user_setting('order_by_registered')){
		$columns['registered']	= '注册时间';	
	}

	if(wpjam_get_user_setting('last_login')){
		$columns['last_login']	= '最后登录';	
	}

	if(wpjam_get_user_setting('disable_first_last_name')){
		unset($columns['name']);
		wpjam_array_push($columns, ['display_name'=>'显示名称'], 'role');	
	}
		
	return $columns;
});

add_filter('manage_users_custom_column', function ($value, $column, $user_id){
	if($column == 'display_name'){
		$avatar			= is_network_admin() ? get_avatar($user_id, 32) : '';
		$display_name	= get_userdata($user_id)->display_name;
		return $avatar.$display_name;
	}elseif($column == 'registered'){
		$user = get_userdata($user_id);
		return get_date_from_gmt($user->user_registered);
	}elseif($column == 'last_login'){
		$last_login = get_user_meta($user_id, 'last_login', true);
		return $last_login ? get_date_from_gmt(date('Y-m-d H:i:s', $last_login)) : '';
	}else{
		return $value;
	}
}, 11, 3);

add_filter( "manage_users_sortable_columns", function($sortable_columns){
	if(wpjam_get_user_setting('order_by_registered')){
		$sortable_columns['registered'] = ['registered',true];
	}

	if(wpjam_get_user_setting('last_login')){
		$sortable_columns['last_login'] = ['last_login',true];
	}

	return $sortable_columns;
});

add_action('pre_get_users', function($query){
	if(wpjam_get_user_setting('order_by_registered')){
		if(!isset($_REQUEST['orderby'])){
			$query->query_vars['orderby']	= 'registered';
		}

		if(!isset($_REQUEST['order'])){
			$query->query_vars['order']		= 'desc';
		}
	}

	if(isset($_REQUEST['orderby'])){
		if($_REQUEST['orderby'] == 'last_login'){
			$query->query_vars['meta_key']	= 'last_login';
			$query->query_vars['orderby']	= 'meta_value';
		}
	}
});

// add_action('personal_options', 'use_ssl_preference');

add_action('admin_head', function(){
	?>
	<style type="text/css">

	.fixed th.column-role{width: 84px;}
	.fixed th.column-registered, .fixed th.column-last_login{width: 100px;}

	<?php if(is_network_admin()){ ?>
	.fixed th.column-blogs{width: 224px;}
	.column-username img{display: none;}
	.column-detail img{float: left; margin-right: 10px; margin-top: 1px; }
	<?php } ?>

 	</style>
	<?php
});
