<?php
add_action('wp_loaded', function(){	// 内部的 hook 使用 优先级 9，因为内嵌的 hook 优先级要低
	if($GLOBALS['pagenow'] == 'options.php'){
		// 为了实现多个页面使用通过 option 存储。
		// 注册设置选项，选用的是：'admin_action_' . $_REQUEST['action'] hook，
		// 因为在这之前的 admin_init 检测 $plugin_page 的合法性
		add_action('admin_action_update', function(){
			$referer_origin	= parse_url(wpjam_get_referer());

			if(!empty($referer_origin['query'])){
				$referer_args	= wp_parse_args($referer_origin['query']);

				if(!empty($referer_args['page'])){
					$GLOBALS['plugin_page']	= $referer_args['page'];	// 为了实现多个页面使用通过 option 存储。

					WPJAM_Menu_Page::rendering(false);
					WPJAM_Menu_Page::init();

					set_current_screen($_POST['screen_id']);
				}
			}
		}, 9);
	}elseif(wp_doing_ajax()){
		add_action('admin_init', function(){
			if(isset($_POST['plugin_page'])){
				$GLOBALS['plugin_page']	= $_POST['plugin_page'];

				WPJAM_Menu_Page::rendering(false);
				WPJAM_Menu_Page::init();
			}

			if(isset($_POST['screen_id'])){
				set_current_screen($_POST['screen_id']);
			}elseif(isset($_POST['screen'])){
				set_current_screen($_POST['screen']);	
			}else{
				$ajax_action	= $_POST['action'] ?? '';

				if($ajax_action == 'inline-save-tax'){
					set_current_screen('edit-'.sanitize_key($_POST['taxonomy']));
				}elseif($ajax_action == 'get-comments'){
					set_current_screen('edit-comments');
				}
			}
			
			add_action('wp_ajax_wpjam-page-action',	['WPJAM_Page_Action', 'ajax_response']);
			add_action('wp_ajax_wpjam-query', 		['WPJAM_Page_Action', 'ajax_query']);
		}, 9);
	}else{
		if(is_multisite() && is_network_admin()){
			add_action('network_admin_menu',	['WPJAM_Menu_Page', 'init'], 9);	
		}else{
			add_action('admin_menu',			['WPJAM_Menu_Page', 'init'], 9);	
		}

		add_action('admin_enqueue_scripts', ['WPJAM_Plugin_Page',	'admin_enqueue_scripts'], 9);

		// 如果插件页面
		add_filter('set-screen-option', function($status, $option, $value){
			return isset($_GET['page']) ? $value : $status;
		}, 9, 3);

		//模板 JS
		add_action('print_media_templates', function(){
			echo '<div id="tb_modal" style="display:none; background: #f1f1f1;"></div>';
			echo WPJAM_Field::get_field_tmpls();
		});
	}
			
	add_action('current_screen', function($current_screen=null){	
		if($page_setting = wpjam_get_plugin_page_setting()){
			WPJAM_Plugin_Page::load($page_setting);
		}else{
			WPJAM_Builtin_Page::load();
		}
	}, 9);
});

function wpjam_get_plugin_page_setting($key=''){
	return WPJAM_Plugin_Page::get_page_setting($key);
}

function wpjam_get_current_tab_setting($key=''){
	return WPJAM_Plugin_Page::get_page_setting($key, true);
}

function wpjam_get_plugin_page_query_data(){
	return WPJAM_Plugin_Page::get_query_data();
}

function wpjam_admin_tooltip($text, $tooltip){
	return '<span class="wpjam-tooltip">'.$text.'<span class="wpjam-tooltip-text">'.$tooltip.'</span></span>';
}

function wpjam_get_referer(){
	$referer	= wp_get_original_referer();
	$referer	= $referer?:wp_get_referer();

	$removable_query_args	= array_merge(wp_removable_query_args(), ['_wp_http_referer', 'action', 'action2', '_wpnonce']);

	return remove_query_arg($removable_query_args, $referer);	
}

function wpjam_register_page_action($action, $args){
	WPJAM_Page_Action::register($action, $args);
}

function wpjam_get_page_action($action){
	$instance	= WPJAM_Page_Action::get_instance($action);
	return $instance ?: new WP_Error('page_action_unregistered', 'Page Action 「'.$action.'」 未注册');
}

function wpjam_get_page_form($action, $args=[]){
	$instance	= wpjam_get_page_action($action);
	return is_wp_error($instance) ? $instance : $instance->get_form($args);
}

function wpjam_get_page_button($action, $args=[]){
	$instance	= wpjam_get_page_action($action);
	return is_wp_error($instance) ? $instance : $instance->get_button($args);
}

function wpjam_get_ajax_button($args){
	return WPJAM_Page_Action::ajax_button($args);
}

function wpjam_get_ajax_form($args){
	return WPJAM_Page_Action::ajax_form($args);
}

function wpjam_ajax_button($args){
	echo wpjam_get_ajax_button($args);
}

function wpjam_ajax_form($args){
	echo wpjam_get_ajax_form($args);
}

function wpjam_register_list_table($name, $args=[]){
	WPJAM_List_Table::register($name, $args);
}

function wpjam_register_list_table_action($key, $args){
	WPJAM_List_Table_Action::register($key, $args);
}

function wpjam_unregister_list_table_action($key){
	WPJAM_List_Table_Action::unregister($key);
}

function wpjam_register_list_table_column($key, $field){
	WPJAM_List_Table_Column::register($key, $field);
}

function wpjam_unregister_list_table_column($key){
	WPJAM_List_Table_Column::unregister($key);
}

function wpjam_register_plugin_page_tab($key, $args){
	WPJAM_Plugin_Page::register_tab($key, $args);
}

function wpjam_get_list_table_filter_link($filters, $title, $class=''){
	return $GLOBALS['wpjam_list_table']->get_filter_link($filters, $title, $class);
}

function wpjam_get_list_table_row_action($action, $args=[]){
	return $GLOBALS['wpjam_list_table']->get_row_action($action, $args);
}

function wpjam_line_chart($counts_array, $labels, $args=[], $type = 'Line'){
	WPJAM_Chart::line($counts_array, $labels, $args, $type);
}

function wpjam_bar_chart($counts_array, $labels, $args=[]){
	wpjam_line_chart($counts_array, $labels, $args, 'Bar');
}

function wpjam_donut_chart($counts, $args=[]){
	WPJAM_Chart::donut($counts, $args);
}

function wpjam_get_chart_parameter($key){
	return WPJAM_Chart::get_parameter($key);
}

function wpjam_get_admin_post_id(){
	return WPJAM_Post_Page::get_post_id();
}

// 自定义主题更新
/* 数据格式：
{
	theme: "Autumn",
	new_version: "2.0.1",
	url: "http://www.xintheme.com/theme/4893.html",
	package: "http://www.xintheme.com/download/Autumn.zip"
}
*/
function wpjam_register_theme_upgrader($upgrader_url){
	add_filter('site_transient_update_themes',  function($transient) use($upgrader_url){
		$theme	= get_template();

		if(empty($transient->checked[$theme])){
			return $transient;
		}
		
		$remote	= get_transient('wpjam_theme_upgrade_'.$theme);

		if(false == $remote){
			$remote = wpjam_remote_request($upgrader_url);
	 
			if(!is_wp_error($remote)){
				set_transient( 'wpjam_theme_upgrade_'.$theme, $remote, HOUR_IN_SECONDS*12 );
			}
		}

		if($remote && !is_wp_error($remote)){
			if(version_compare( $transient->checked[$theme], $remote['new_version'], '<' )){
				$transient->response[$theme]	= $remote;
			}
		}

		return $transient;
	});
}

