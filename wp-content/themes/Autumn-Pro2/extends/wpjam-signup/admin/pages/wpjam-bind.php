<?php
global $plugin_page;

add_filter(wpjam_get_filter_name($plugin_page, 'tabs'), function($tabs){
	$bind_actions	= wpjam_get_bind_actions();

	foreach ($bind_actions as $bind_key => $bind_action) {
		$tabs[$bind_key]	= ['title'=>$bind_action['title'],	'function'=>'wpjam_bind_tab_page'];
	}

	return $tabs;
});

function wpjam_bind_tab_page(){
	global $current_tab;

	$bind_actions	= wpjam_get_bind_actions();
	$bind_action	= $bind_actions[$current_tab];
	$signup_model	= $bind_action['model'];

	echo '<div class="card">';

	$signup_model::bind_form();	

	// wpjam_print_r(WPJAM_UserPhone::get_all());

	echo '</div>';
}

add_action('wpjam_page_action', function($action){
	global $current_tab;

	$bind_actions	= wpjam_get_bind_actions();
	$bind_action	= $bind_actions[$current_tab];
	$signup_model	= $bind_action['model'];

	$user_id	= get_current_user_id();
	
	if($action == 'bind'){
		if($current_tab == 'sms'){
			$phone	= wpjam_get_data_parameter('phone');
			$code	= wpjam_get_data_parameter('code');

			$result	= wpjam_verify_sms($phone, $code);

			if(is_wp_error($result)){
				wpjam_send_json($result);
			}
			
			$user	= SMS_Signup::bind($user_id, $phone);

			if(is_wp_error($result)){
				wpjam_send_json($user);
			}
		}
		
		$openid = $signup_model::get_user_openid($user_id);		

		if(!$openid){
			wpjam_send_json([
				'errcode'	=> 'scan_fail',
				'errmsg'	=> '请先扫描，再点击刷新。'
			]);
		}

		$form	= $signup_model::bind_form($echo=false);

		if(is_wp_error($form)){
			wpjam_send_json($form);
		}else{
			wpjam_send_json(compact('form'));	
		}
	}elseif($action == 'unbind'){
		$openid		= $signup_model::get_user_openid($user_id);

		if(!$openid){
			$openid	= $signup_model::get_openid_by_user_id($user_id);
		}

		$signup_model::unbind($user_id, $openid);

		$form	= $signup_model::bind_form($echo=false);

		if(is_wp_error($form)){
			wpjam_send_json($form);
		}else{
			wpjam_send_json(compact('form'));	
		}
	}
});

add_action('admin_head', function(){
	?>

	<style type="text/css">
	.form-table th{width: 80px;}
	</style>

	<script type="text/javascript">
	jQuery(function($){
		$('body').on('page_action_success', function(e, response){
			$('div.card').html(response.form);
		});
	});
	</script>

	<?php
});