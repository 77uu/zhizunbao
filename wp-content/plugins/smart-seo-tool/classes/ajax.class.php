<?php

class Smart_SEO_Tool_Ajax
{

    public static function init()
    {
        add_action('wp_ajax_wb_smart_seo_tool', array(__CLASS__, 'wp_ajax_wb_smart_seo_tool'));
    }

    public static function wp_ajax_wb_smart_seo_tool()
    {
        global $wpdb;
        $ret = array('code'=>0,'desc'=>'success');

        switch ($_REQUEST['do']) {
            case 'chk_ver':
                if( !current_user_can('manage_options')) {
                    exit();
                }
                $api = 'https://www.wbolt.com/wb-api/v1/themes/checkver?code=' . SMART_SEO_TOOL_CODE . '&ver=' . SMART_SEO_TOOL_VERSION . '&chk=1';
                $http = wp_remote_get($api, array('sslverify' => false, 'headers' => array('referer' => home_url()),));
                if (wp_remote_retrieve_response_code($http) == 200) {
                    echo wp_remote_retrieve_body($http);
                }
                exit();
                break;
            case '404_url':
                if( !current_user_can('manage_options')) {
                    $ret['success'] = 1;
                    $ret['data'] = [];
                    break;
                }
                $offset = isset($_GET['offset'])?intval($_GET['offset']):0;
                $offset = max(0,$offset);
                $num = 30;
                $url_log = $wpdb->prefix.'wb_spider_log';
                $list = $wpdb->get_results("SELECT * FROM $url_log WHERE `code`=404 ORDER BY id DESC LIMIT $offset,$num");

                $ret['success'] = 1;
                $ret['data'] = $list;


                break;
            case 'remove_404':
                if( !current_user_can('manage_options')) {
                    $ret['data'] = 'error';
                    break;
                }
                $id = isset($_POST['id'])?absint($_POST['id']):0;
                if(!$id){
                    $ret['data'] = 'error';
                    break;
                }
                $t = $wpdb->prefix.'wb_spider_log';
                $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $t WHERE id=%d",$id));
                if(!$row){
                    $ret['data'] = 'error';
                    break;
                }
                $ret['d'] = array('code'=>404,'url_md5'=>$row->url_md5);
                $wpdb->delete($t,array('code'=>404,'url_md5'=>$row->url_md5));
                $ret['data'] = 'success';//$ret?'success':'fail';

                break;
            case 'refresh_404':
                $ret['success'] = 0;
                if( !current_user_can('manage_options')) {
                    $ret['data'] = 'error';
                    break;
                }
                $id = isset($_POST['id'])?absint($_POST['id']):0;
                if(!$id){
                    $ret['data'] = 'error';
                    break;
                }
                $t = $wpdb->prefix.'wb_spider_log';
                $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $t WHERE id=%d",$id));
                if(!$row){
                    $ret['data'] = 'error';
                    break;
                }

                $req_url = home_url($row->url);
                $http = wp_remote_head($req_url);
                if(is_wp_error($http)){
                    $ret['data'] = $http->get_error_message();
                    break;
                }
                $http_code = wp_remote_retrieve_response_code($http);
                $ret['data'] = $http_code;
                if($http_code && $row->code != $http_code){
                    $wpdb->update($wpdb->prefix.'wb_spider_log',['visit_date'=>current_time('mysql'),'code'=>$http_code],['id'=>$row->id]);
                    $wpdb->update($wpdb->prefix.'wb_spider_log',['code'=>$http_code],['url_md5'=>$row->url_md5]);
                }
                $ret['success'] = 1;
                break;
            case 'mark_broken_url':
                if( !current_user_can('manage_options')) {
                    $ret['data'] = 'error';
                    break;
                }
                $id = isset($_POST['id'])?absint($_POST['id']):0;
                if(!$id){
                    $ret['data'] = 'error';
                    break;
                }
                Smart_SEO_Tool_Admin::mark_broken_url($id);
                $ret['data'] = 'success';
                break;
            case 'remove_broken':
                if( !current_user_can('manage_options')) {
                    $ret['data'] = 'error';
                    break;
                }
                $id = isset($_POST['id'])?absint($_POST['id']):0;
                if(!$id){
                    $ret['data'] = 'error';
                    break;
                }
                Smart_SEO_Tool_Admin::remove_broken_url($id);
                $ret['data'] = 'success';//$ret?'success':'fail';

                break;
            case 'check_broken':
                if( !current_user_can('manage_options')) {
                    $ret['data'] = 'error';
                    break;
                }
                $id = isset($_POST['id'])?absint($_POST['id']):0;
                if(!$id){
                    $ret['data'] = 'error';
                    break;
                }
                $row = Smart_SEO_Tool_Admin::detect_url($id);
                if(!$row){
                    $ret['data'] = 'error';
                    break;
                }
                $ret['row'] = $row;
                $ret['data'] = $row->code;
                break;
            case 'clear_broken_url':
                if( !current_user_can('manage_options')) {
                    $ret['data'] = 'error';
                    break;
                }
                Smart_SEO_Tool_Admin::clear_broken_url();
                break;
            case 'broken_url_batch':
                if( !current_user_can('manage_options')) {
                    $ret['data'] = 'error';
                    break;
                }
                $ret['success'] = 0;
                $ids = isset($_POST['ids'])?trim($_POST['ids']):'';
                $op = isset($_POST['op'])?trim($_POST['op']):'';
                if(!$ids || !$op){
                    $ret['data'] = 'error';
                    break;
                }
                $t = $wpdb->prefix.'wb_sst_broken_url';
                $ids = preg_replace('#[^\d,]#','',$ids);
                if($op == 'update'){
                    $wpdb->query("UPDATE $t SET check_date = null,code= null WHERE id IN($ids)");
                    $ret['success'] = 1;
                }else if($op == 'ok'){
                    $wpdb->query("UPDATE $t SET check_date = '2023-10-01 10:00:00',code= 200,memo='mark as ok' WHERE id IN($ids)");
                    $ret['success'] = 1;
                }else if($op == 'cancel'){
                    $id_list = explode(',',$ids);
                    foreach($id_list as $id){
                        if(!$id){
                            continue;
                        }
                        Smart_SEO_Tool_Admin::remove_broken_url($id);
                    }
                    $ret['success'] = 1;
                }

                break;
            case 'broken_url':
                if( !current_user_can('manage_options')) {
                    $ret['success'] = 1;
                    $ret['data'] = [];
                    break;
                }
                $offset = isset($_GET['offset'])?intval($_GET['offset']):0;
                $type = isset($_GET['type'])?intval($_GET['type']):0;
                $offset = max(0,$offset);
                $num = 30;
                $url_log = $wpdb->prefix.'wb_sst_broken_url';
                $where = '';
                if($type==2){
                    $where = " AND CODE REGEXP '^30'";
                }else if($type == 1){
                    $where = " AND CODE REGEXP '^(5|4|error)'";
                }else if($type == 3){
                    $where = " AND CODE REGEXP '^2'";
                }
                $list = $wpdb->get_results("SELECT * FROM $url_log WHERE url_md5 IS NOT NULL $where ORDER BY id DESC LIMIT $offset,$num");

                if($list)foreach($list as $r){
                    if(!$r->code){
                        $r->code = '待检测';
                    }
                    $post = get_post($r->post_id);
                    $r->post_title = $post->post_title;
                    $r->post_url = get_permalink($post);
                    $r->edit_url = get_edit_post_link($post);
                }

                $ret['success'] = 1;
                $ret['data'] = $list;

                break;





        }

        header('content-type:text/json;charset=utf-8');
        echo json_encode($ret);
        exit();

    }
}