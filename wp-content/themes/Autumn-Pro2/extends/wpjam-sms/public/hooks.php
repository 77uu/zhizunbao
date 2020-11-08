<?php
add_action('wpjam_api_template_redirect', function ($json){
	if(strpos($json, 'sms.') === 0) {
		include WPJAM_SMS_PLUGIN_DIR.'api/'.$json.'.php';
		exit;
	}
});

wpjam_register_sms_provider('aliyun', [
	'title'		=> '阿里云短信服务', 
	'file'		=> WPJAM_SMS_PLUGIN_DIR.'public/aliyun/aliyun.php',
	'admin'		=> WPJAM_SMS_PLUGIN_DIR.'public/aliyun/admin.php',
	'sender'	=> 'wpjam_aliyun_send_sms',
]);

wpjam_register_sms_provider('aliyun', [
	'title'		=> '阿里云国际短信服务', 
	'file'		=> WPJAM_SMS_PLUGIN_DIR.'public/aliyun/aliyun.php',
	'admin'		=> WPJAM_SMS_PLUGIN_DIR.'public/aliyun/admin.php',
	'sender'	=> 'wpjam_aliyun_send_sms',
],'international');

wpjam_register_sms_provider('mysubmail', [
	'title'		=> '赛邮·云通信', 
	'file'		=> WPJAM_SMS_PLUGIN_DIR.'public/domestic/mysubmail/mysubmail.php',
	'admin'		=> WPJAM_SMS_PLUGIN_DIR.'public/domestic/mysubmail/admin.php',
	'sender'	=>'wpjam_mysubmail_send_sms',
]);

wpjam_register_sms_provider('mysubmail', [
	'title'		=> '国际赛邮·云通信', 
	'file'		=> WPJAM_SMS_PLUGIN_DIR.'public/international/mysubmail/mysubmail.php',
	'admin'		=> WPJAM_SMS_PLUGIN_DIR.'public/international/mysubmail/admin.php',
	'sender'	=> 'wpjam_international_submail_send_sms'
],'international');