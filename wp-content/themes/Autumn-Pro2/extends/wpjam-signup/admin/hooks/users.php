<?php
function wpjam_add_openid_users_columns($columns){
	unset($columns['email']);
	$columns['openid']	= '绑定账号';
	return $columns;
}

add_filter('manage_users_columns',	'wpjam_add_openid_users_columns');
add_filter('wpmu_users_columns',	'wpjam_add_openid_users_columns');

add_filter('manage_users_custom_column', function ($value, $column, $user_id){
	if($column == 'openid'){
		$values = [];

		$signups	= wpjam_get_signups();

		foreach ($signups as $signup) {
			$openid		= $signup['model']::get_user_openid($user_id);
			$values[]	= $openid ? $signup['title'].'：<br />'.$openid : '';
		}

		$value	= $values ? '<p>'.implode('</p><p>', $values).'</p>' : '';
	}

	return $value;
}, 11, 3);