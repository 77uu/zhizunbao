<?php
if(isset($_GET['reset'])){
	delete_option('wpjam-signup');
}

add_filter('wpjam_signup_setting', function(){
	$fields = [];

	if(!is_multisite() || !is_network_admin()){
		foreach (['domestic'=>'国内', 'international'=>'国际/港台'] as $region_key=>$region_name) {
			$sms_providers			= WPJAM_SMS::get_providers($region_key);
			$sms_provider_options	= array_map(function($provider){return $provider['title'];}, $sms_providers);
			$sms_provider_options	= array_merge([''=>'不启用'], $sms_provider_options);

			$field_key	= $region_key == 'domestic' ? 'sms_provider' : $region_key.'_sms_provider';

			$fields[$field_key]	= ['title'=>$region_name.'短信服务提供商',	'type'=>'select',	'options'=>$sms_provider_options];
		}
	}

	$ajax = false;

	return compact('fields', 'ajax');
});