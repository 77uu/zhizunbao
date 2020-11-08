<?php
function wpjam_invite_page(){
	$role_options	= [];
	$roles			= get_editable_roles();

	foreach ($roles as $role_key=> $role_details ) {
		$role_name					= translate_user_role($role_details['name'] );
		$role_options[$role_key]	= $role_name;
	}

	$fields = [
		'role'	=> ['title'=>'邀请用户角色',	'type'=>'select',	'options'=>$role_options]
	];

	?>
	<div class="card">
	<p><strong>操作流程：</strong>
		<br />
		<br />1. 选择角色并点击生成邀请链接。
		<br />2. 复制链接发给相关用户。
		<br />3. 每个链接只能使用一次。
		<br />4. 支持微信端及电脑端邀请，6小时内有效。
	</p>
	<style type="text/css">
	table.form-table th {width:90px;}
	div.response pre {background: #eaeaea; white-space: pre-wrap; word-wrap: break-word; padding:10px;}
	div.response pre code {background: none; margin:0; padding: 0;}
	</style>
	<?php

	wpjam_ajax_form([
		'action'		=> 'invite',
		'fields'		=> $fields,
		'submit_text'	=> '生成邀请链接'
	]);

	echo '</div>';
}

add_action('wpjam_page_action', function($action){
	if($action == 'invite'){
		$role	= wpjam_get_data_parameter('role', ['sanitize_callback'=>'sanitize_key']);
		$key	= wpjam_invite_user($role);

		if(is_wp_error($key)){
			wpjam_send_json($key);
		}

		$result	= '<div>
			<h2>邀请链接</h2>
			<p><pre><code>'.home_url('wp-login.php?invite_key='.$key).'</code></pre></p>
			<p>链接只能使用一次，请复制链接发给相关用户，支持微信端及电脑端邀请，6小时内有效。</p>
		</div>';

		wpjam_send_json(['data'=>$result, 'type'=>'append']);
	}
});