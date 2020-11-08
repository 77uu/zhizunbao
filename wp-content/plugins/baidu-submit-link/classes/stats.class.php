<?php


/**
 * 统计
 * Class WB_BSL_Stats
 */

class WB_BSL_Stats
{




    public static function pc_stat_data($day=7){

        $ret = array();

        $data_1 = self::push_stat_data(4,$day);
        $data_2 = self::push_stat_data(1,$day);

        $ret[] = array_values($data_1);
        $ret[] = array_values($data_2);


        return $ret;
    }

    public static function day_push_data($day=7){
        $ret = array();
        $data_1 = self::push_stat_data(2,$day);
        $data = self::index_data($day);

        $ret[] = array_values($data['limited']);
        $ret[] = array_values($data_1);
        $ret[] = array_values($data['remain']);
        return $ret;
    }


    public static function daily_push_data($day=7){
        $ret = array();
        $data_1 = self::push_stat_data(5,$day);
        $data = self::index_data($day);

        $ret[] = array_values($data['limited']);
        $ret[] = array_values($data_1);
        $ret[] = array_values($data['remain']);
        return $ret;
    }

    public static function week_push_data($day=7){
        $ret = array();
        $data_1 = self::push_stat_data(3,$day);
        $ret[] = array_values($data_1);
        return $ret;
    }


    public static function push_stat_data($type,$day=7){
        global $wpdb;


        $t = $wpdb->prefix.'wb_bsl_log';

        $now = current_time('mysql');
        $timestamp = current_time('timestamp');

        $from_timestamp = strtotime((1-$day).' day',$timestamp);

        $from = gmdate('Y-m-d 00:00:00',$from_timestamp);


        $sql = "SELECT DATE_FORMAT(create_date,'%Y-%m-%d') ymd ,COUNT(1) num FROM $t WHERE push_status=1 AND `type`=$type AND create_date BETWEEN '$from' AND '$now' GROUP BY ymd ORDER BY ymd ASC";

        $ret = array();

        for($i=0;$i<$day;$i++){
            $ret[gmdate('Y-m-d',$from_timestamp + $i * 86400)] = 0;
        }

        $list = $wpdb->get_results($sql);

        foreach ($list as $r){
            $ret[$r->ymd] = $r->num;
        }

        return $ret;
    }

    public static function baidu_log($type,$num=10,$offset=0){
        global $wpdb;

        $post_types = WB_BSL_Conf::cnf('post_type',array('post'));
        if(empty($post_types))$post_types = array('post');

        $post_types = "'".implode("','",$post_types)."'";
        $limit = $offset.','.$num;




        if($type==1){
            $sql = "SELECT a.* FROM $wpdb->posts a WHERE a.post_type IN($post_types) AND a.post_status='publish'";
        }else if($type==2){
            $sql = "SELECT a.* FROM $wpdb->posts a,$wpdb->postmeta b WHERE a.ID=b.post_id AND b.meta_key='url_in_baidu' AND b.meta_value='1' AND a.post_type IN($post_types) AND a.post_status='publish'";
        }else if($type==3){
            $sql = "SELECT a.* FROM $wpdb->posts a WHERE a.post_type IN($post_types) AND a.post_status='publish'";
            $sql .= " AND NOT EXISTS(SELECT b.post_id FROM $wpdb->postmeta b WHERE b.post_id = a.ID AND b.meta_key='url_in_baidu' AND b.meta_value='1' )";
        }else{
            return array();
        }

        $sql .= " ORDER BY a.post_date DESC LIMIT $limit";


        //echo $sql;
        $list =  $wpdb->get_results($sql);

        $new_list = array();
        foreach($list as $r){
            $in_baidu = get_post_meta($r->ID,'url_in_baidu',true);
            $d = array(
                'post_id'=>$r->ID,
                'post_url'=>get_permalink($r),
                'post_title'=>$r->post_title,
                'post_date'=>$r->post_date,
                'in_baidu' =>$in_baidu,
                'last_date'=>get_post_meta($r->ID,'url_in_baidu_ymd',true),
            );
            $new_list[] = $d;
        }

        return $new_list;
    }
    public static function push_log($type,$num=10,$offset=0){
        global $wpdb;


        $t = $wpdb->prefix.'wb_bsl_log';

        $now = current_time('mysql');
        $timestamp = current_time('timestamp');

        $from_timestamp = strtotime('-6 day',$timestamp);
        $from = gmdate('Y-m-d 00:00:00',$from_timestamp);

        $limit = $offset.','.$num;

        $sql = "SELECT id,post_id,create_date AS `date`,`post_url` AS `url`,push_status AS `s_push`,index_status AS 's_record',`type`,IF(`result` IS NULL,1,0) is_old FROM $t WHERE `type`=$type AND create_date BETWEEN '$from' AND '$now' ORDER BY id DESC LIMIT $limit";

        $new_list = array();

        $list =  $wpdb->get_results($sql);
        $result = json_encode(array('remain'=>0,'success'=>1));
        foreach($list as $r){

            if($r->type < 4 && $r->is_old){
                $r->url = get_permalink($r->post_id);
                $wpdb->query($wpdb->prepare("UPDATE $t SET post_url = %s,`result`=%s WHERE id=%d",$r->url,$result,$r->id));
            }

            $new_list[] = $r;

        }

        return $new_list;


    }
    public static function day_index($ymd=null){

        global $wpdb;
        $t = $wpdb->prefix.'wb_bsl_day';


        if(!$ymd){

            $ymd = current_time('Y-m-d');
        }

        $fields = array('all_in','new_in','not_in','day_in','week_in','month_in','limited','remain');
        $sql = "SELECT ymd ,".(implode(',',$fields))." FROM $t WHERE  ymd = '$ymd' AND `type`=1 ORDER BY ymd,id DESC";

        $row = $wpdb->get_row($sql);

        if(!$row){
            $row = new stdClass();
            foreach ($fields as $field){
                $row->$field = 0;
            }
        }

        return $row;
    }

    public static function bing_data($day=7)
    {
        global $wpdb;

        $t = $wpdb->prefix.'wb_bsl_day';


        $now = current_time('Y-m-d');
        $timestamp = current_time('timestamp');

        $from_timestamp = strtotime((1-$day).' day',$timestamp);

        $from = gmdate('Y-m-d',$from_timestamp);


        $fields = array('all_in','new_in','not_in','day_in','week_in','month_in','limited','remain');
        $sql = "SELECT ymd ,".(implode(',',$fields))." FROM $t WHERE `type`=2 AND ymd BETWEEN '$from' AND '$now' ORDER BY ymd ASC";

        //echo $sql;
        $ret = array();

        for($i=0;$i<$day;$i++){
            $ret[gmdate('Y-m-d',$from_timestamp + $i * 86400)] = 0;
        }

        $result = array();

        foreach ($fields as $field){
            $result[$field] = $ret;
        }
        $result['auto'] = $ret;
        $result['manual'] = $ret;

        $list = $wpdb->get_results($sql);

        foreach ($list as $r){
            //$ret[$r->ymd] = $r->num;
            foreach ($fields as $field){
                $result[$field][$r->ymd] = $r->$field;
            }
        }

        $log = $wpdb->prefix.'wb_bsl_log';
        $log_list = $wpdb->get_results("SELECT COUNT(1) num,DATE_FORMAT(create_date,'%Y-%m-%d') AS ymd FROM $log WHERE `type`=10 AND DATE_FORMAT(create_date,'%Y-%m-%d') BETWEEN '$from' AND '$now' GROUP BY ymd ORDER BY ymd ASC");

        if($log_list)foreach ($log_list as $r){
            $result['auto'][$r->ymd] = $r->num;
        }
        $log_list = $wpdb->get_results("SELECT COUNT(1) num,DATE_FORMAT(create_date,'%Y-%m-%d') AS ymd FROM $log WHERE `type`=11 AND DATE_FORMAT(create_date,'%Y-%m-%d') BETWEEN '$from' AND '$now' GROUP BY ymd ORDER BY ymd ASC");

        if($log_list)foreach ($log_list as $r){
            $result['manual'][$r->ymd] = $r->num;
        }



        //print_r($result);
        return $result;
    }
    public static function index_data($day=7){
        global $wpdb;

        $t = $wpdb->prefix.'wb_bsl_day';


        $now = current_time('Y-m-d');
        $timestamp = current_time('timestamp');

        $from_timestamp = strtotime((1-$day).' day',$timestamp);

        $from = gmdate('Y-m-d',$from_timestamp);


        $fields = array('all_in','new_in','not_in','day_in','week_in','month_in','limited','remain');
        $sql = "SELECT ymd ,".(implode(',',$fields))." FROM $t WHERE `type`=1 AND ymd BETWEEN '$from' AND '$now' ORDER BY ymd ASC";

        //echo $sql;
        $ret = array();

        for($i=0;$i<$day;$i++){
            $ret[gmdate('Y-m-d',$from_timestamp + $i * 86400)] = 0;
        }

        $result = array();

        foreach ($fields as $field){
            $result[$field] = $ret;
        }

        $list = $wpdb->get_results($sql);

        foreach ($list as $r){
            //$ret[$r->ymd] = $r->num;
            foreach ($fields as $field){
                $result[$field][$r->ymd] = $r->$field;
            }
        }


        //print_r($result);
        return $result;


    }


    public static function url_spider($url_md5,$num,$offset=0)
    {
        global $wpdb;
        $limit = '';
        if($num>0){
            $limit = ' LIMIT '.$offset.','.$num;
        }

        $sql = "SELECT `spider`, `visit_date`, `visit_ip` FROM `{$wpdb->prefix}wb_spider_log` WHERE `url_md5`=%s  ORDER BY visit_date DESC $limit";

        $list = $wpdb->get_results($wpdb->prepare($sql,$url_md5));

        return $list;
    }

    public static function spider_404($num=10,$offset=0)
    {

        global $wpdb;
        $limit = '';
        if($num>0){
            $limit = ' LIMIT '.$offset.','.$num;
        }

        $sql = "SELECT MAX(id) id,MAX(visit_date) visit_date, url,`code` FROM `{$wpdb->prefix}wb_spider_log` WHERE `code`=404 AND spider='Baiduspider' GROUP by url_md5 ORDER BY visit_date DESC $limit";

        $list = $wpdb->get_results($sql);

        return $list;
    }

}