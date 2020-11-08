<?php
function wpjam_topic_setting_page($force=false){
	global $wpdb;
	
	$table	= $wpdb->posts;

	if(!$wpdb->query("SHOW COLUMNS FROM `{$table}` WHERE field='last_comment_time'")){
		$wpdb->query("ALTER TABLE `{$table}` ADD COLUMN last_comment_time int(10) NULL");
		$wpdb->query("ALTER TABLE `{$table}` ADD COLUMN last_comment_user bigint(20) NULL");
		$wpdb->query("ALTER TABLE `{$table}` ADD KEY `last_comment_time_idx` (`last_comment_time`);");
	}

	?>
	<h2>讨论组设置</h2>
	<p>讨论组目前暂无设置，点击该页面简单升级一下数据库。</p>
	<?php
}