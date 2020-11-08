<?php


/**
 * 插件工具类
 * Class WB_BSL_Utils
 */
class WB_BSL_Utils
{
    public static $debug = false;

    public static function txt_log($msg){

        if(!self::$debug){
            return;
        }
        $num = func_num_args();
        if($num>1){
            $msg = json_encode(func_get_args());
        }else if(is_array($msg)){
            $msg = json_encode($msg);
        }

        error_log('['.current_time('mysql').']'.$msg."\n",3,__DIR__.'/#log/'.date('Ym').'.log');
    }

    public static function run_log($msg,$mod='')
    {

        if(is_array($msg)){
            $msg = json_encode($msg);
        }

        if($mod){
            $msg = '['.$mod.'] '.$msg;
        }

        error_log('['.current_time('mysql').'] '.$msg."\n",3,__DIR__.'/#log/running.log');
    }


    public static function push_log($post_id,$type){

        global $wpdb;
        $t = $wpdb->prefix.'wb_bsl_log';

        $row = $wpdb->get_row($wpdb->prepare("SELECT a.* FROM $t a WHERE a.post_id=%d AND a.type=%d ORDER BY  create_date DESC LIMIT 1",$post_id,$type));

        return $row;
    }


    public static function add_push_log($type,$post_id,$url,$result){
       global $wpdb;
       $t = $wpdb->prefix.'wb_bsl_log';
       $push_status = 0;

       if(!$result['code']){
           $push_status = 1;
           if(isset($result['data']) && isset($result['data']['success']) && $result['data']['success'] < 1){
               $push_status = 0;
           }
       }

       $data = isset($result['data']) && $result['data']?json_encode($result['data']):$result['desc'];

       $d = array(
           'post_id'=>$post_id,
           'post_url'=>$url,
           'push_status'=>$push_status,
           'index_status'=>0,
           'create_date'=>current_time('mysql'),
           'type'=>$type,
           'result'=>$data,
       );

       $wpdb->insert($t,$d);

    }

    /**
     * 更新post meta
     * @param $post_id
     * @param $key
     * @param $value
     */
    public static function update_meta_row($post_id,$key,$value){
        global $wpdb;

        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->postmeta WHERE meta_key=%s AND post_id=%d ORDER BY meta_id DESC LIMIT 1",$key,$post_id));
        if($row){
            $wpdb->query($wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value=%s WHERE meta_id=%d",$value,$row->meta_id));
        }else{
            $wpdb->query($wpdb->prepare("INSERT INTO $wpdb->postmeta(`post_id`, `meta_key`, `meta_value`) VALUES(%d,%s,%s)",$post_id,$key,$value));
        }
    }

    public static function delete_post_meta($post_id,$key){
        global $wpdb;

        $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE meta_key=%s AND post_id=%d",$key,$post_id));

    }



    public static function create_wb_table($set_up,$sql){

        global $wpdb;


        if(empty($set_up)){
            return;
        }


        $charset_collate = $wpdb->get_charset_collate();



        $sql = str_replace('`wp_wb_','`'.$wpdb->prefix.'wb_',$sql);
        $sql = str_replace('ENGINE=InnoDB', $charset_collate , $sql);



        $sql_rows = explode('-- row split --',$sql);

        foreach($sql_rows as $row){

            if(preg_match('#`'.$wpdb->prefix.'(wb_bsl.*?)`\s+\(#',$row,$match)){
                if(in_array($match[1],$set_up)){
                    $wpdb->query($row);
                }
            }
        }
    }



}