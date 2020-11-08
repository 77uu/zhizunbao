<?php
add_filter('wpjam_weapp_users_actions', function($actions){
	return array_merge($actions,[
		'bind_user'	=> ['title'=>'绑定用户',	'capability'=>is_multisite() ? 'manage_sites' : 'manage_options']
	]);
});

add_filter('wpjam_weapp_user_fields', function($fields, $action_key, $id){
	if($action_key == 'bind_user'){
		$genders	= [0=>'未知', 1=>'男', 2=>'女'];

		return [
			'nickname'	=> ['title'=>'用户',		'type'=>'view'],
			'user_id'	=> ['title'=>'用户ID',	'type'=>'text',	'class'=>'all-options',	'description'=>'请输入 WordPress 的用户']
		];
	}

	return $fields;
}, 10, 3);

add_filter('wpjam_weapp_user_list_action', function($result, $list_action, $id, $data){
	if($list_action == 'bind_user'){
		$user_id	= $data['user_id'] ?? 0;
		return	WEAPP_AdminUser::update($id, compact('user_id'));
	}

	return $result;
}, 10, 4);