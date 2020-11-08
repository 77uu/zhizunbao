<?php
wp_cache_add_global_groups(['wpjam_user_phones']);

class WPJAM_UserPhone extends WPJAM_Model {
	public static function insert($data){
		if(empty($data['phone'])){
			return new WP_Error('empty_phone', '手机号码不能为空');
		}

		$data['country_code']	= 86;
		$data['time']			= time();

		trigger_error(var_export($data, true));
		
		return parent::insert($data);
	}

	public static function update($phone, $data){
		if(empty($phone)){
			return new WP_Error('empty_phone', '手机号码不能为空');
		}

		if(isset($data['phone']) || isset($data['country_code'])){
			return new WP_Error('phone_modification_not_allow', '手机号码不能修改');
		}

		return parent::update($phone, $data);
	}

	private static 	$handler;

	public static function get_handler(){
		global $wpdb;
		if(is_null(self::$handler)){
			self::$handler = new WPJAM_DB(self::get_table(), array(
				'primary_key'		=> 'phone',
				'cache_group'		=> 'wpjam_user_phones',
				'searchable_fields'	=> ['phone','user_id']
			));
		}
		return self::$handler;
	}

	public static function get_table(){
		global $wpdb;
		return $wpdb->base_prefix . 'user_phones';
	}

	public static function create_table($appid=''){

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		global $wpdb;

		$table	= self::get_table();

		if($wpdb->get_var("show tables like '{$table}'") != $table) {
			$sql = "
			CREATE TABLE IF NOT EXISTS `{$table}` (
				`phone` bigint(15) NOT NULL,
				`country_code` int(4) NOT NULL DEFAULT 86,
				`user_id` bigint(20) NOT NULL DEFAULT 0,
				`status` int(1) NOT NULL DEFAULT 1,
				`time` int(10) NOT NULL,
				PRIMARY KEY	(`phone`),
				KEY `user_id` (`user_id`),
				KEY `country_code` (`country_code`)
			) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
			";
	 
			dbDelta($sql);
		}
	}
}