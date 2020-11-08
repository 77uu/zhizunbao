<?php

if(!defined('ABSPATH')){
    return;
}

class WP_Spider_Analyser_Admin
{





    public static function init(){
        //add_action( 'admin_menu', array(__CLASS__,'adminMenu') );
    }

    public static function adminMenu(){
        add_submenu_page('wp_spider_analyser','爬虫统计', '爬虫统计', 'administrator','wp_spider_analyser_stats' , array(__CLASS__,'wp_spider_analyser_stats'));


    }



    public static function wp_spider_analyser_stats(){

        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        global $wpdb;

        $cur_page_url = admin_url().'admin.php?page='.$_REQUEST['page'];

        $spider_list = $wpdb->get_col("SELECT DISTINCT spider FROM wp_wb_spider_log");

        $get = $_GET;
        if(!isset($get['spider'])){
            $get['spider'] = '';
        }

        $where = array();
        if(isset($get['fromdate']) && $get['fromdate']){
            $date = str_replace('-','',$get['fromdate']);
            $where[] = "DATE_FORMAT(visit_date,'%Y%m%d')>='$date'";
        }
        if(isset($get['todate']) && $get['todate']){
            $date = str_replace('-','',$get['todate']);
            $where[] = "DATE_FORMAT(visit_date,'%Y%m%d')<='$date'";
        }
        if($get['spider']){
            $where[] = $wpdb->prepare("spider=%s",$get['spider']);
        }

        $swhere = '';

        if($where){
           $swhere = 'WHERE '.implode(' AND ',$where);
        }

        if($get['spider']){
            $visit_sum = $wpdb->get_results("SELECT COUNT(1) num ,DATE_FORMAT(visit_date,'%H:00') h FROM wp_wb_spider_log $swhere GROUP BY h ORDER BY h ASC");
        }else{

            $visit_sum = $wpdb->get_results("SELECT COUNT(1) num ,spider FROM wp_wb_spider_log $swhere GROUP BY spider ORDER BY num DESC");



        }

        $top_url_list = $wpdb->get_results("SELECT COUNT(1) num ,url FROM wp_wb_spider_log $swhere GROUP BY md5(url) ORDER BY num DESC LIMIT 50");


        $sum_visit = 0;
        foreach($visit_sum as $r){
            $sum_visit += $r->num;
        }


        include __DIR__.'/stats.php';
    }
}