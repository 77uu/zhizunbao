<?php


if(!defined('ABSPATH')){
    return;
}



class WP_Spider_Analyser
{

    public static $in_log = false;
    public static $debug = false;

    public static function init(){


        add_action( 'admin_menu', array(__CLASS__,'adminMenu') );


        register_shutdown_function( array( __CLASS__, 'handle' ) );

        add_filter('redirect_canonical',function($redirect_url, $requested_url ){
            if(!self::$in_log && $redirect_url){
                self::$in_log = true;
                self::log(302);
            }
            return $redirect_url;
        },10,2);


        //
        add_action('wp_wb_spider_analyser_cron',array(__CLASS__,'wp_wb_spider_analyser_cron'));

        if(!wp_next_scheduled('wp_wb_spider_analyser_cron')){
            wp_schedule_event(strtotime(current_time('Y-m-d H:00:00',1)), 'hourly', 'wp_wb_spider_analyser_cron');
        }

        register_activation_hook(WP_SPIDER_ANALYSER_BASE_FILE, array(__CLASS__,'plugin_activate'));
        register_deactivation_hook(WP_SPIDER_ANALYSER_BASE_FILE, array(__CLASS__,'plugin_deactivate'));



        WP_Spider_Analyser_Admin::init();

        add_action('wp_ajax_spider_analyser',array(__CLASS__,'spider_analyser_ajax'));

	    add_action('admin_enqueue_scripts',array(__CLASS__,'admin_enqueue_scripts'),1);

	    self::upgrade();
    }



	public static function admin_enqueue_scripts($hook){

		if(!preg_match('#wp_spider_analyser#',$hook)){
		    return;
        }

		wp_enqueue_style('wb-spa-log-style',WP_SPIDER_ANALYSER_URL.'assets/wbp_spa.css', array(), WP_SPIDER_ANALYSER_VERSION);
	}


	public static function match_type($url)
    {

        $type = 'other';
        do{
            //['index','post','page','category','tag','search','author','feed','sitemap','api','other'];
            if(preg_match('#/wp-admin/admin-ajax\.php#',$url)){
                $type = 'api';
                break;
            }
            $parse = parse_url($url);
            if(isset($parse['query']) && $parse['query']){
                 parse_str($parse['query'],$param);
                 if(isset($param['s'])){
                     $type = 'search';
                     break;
                 }
            }
            if(!$parse['path'] || $parse['path'] == '/'){
                $type = 'index';
                break;
            }
            //if(preg_match('#sitemap#'))
            $request_uri = $_SERVER['REQUEST_URI'];
            $php_self = $_SERVER['PHP_SELF'];
            $path = $parse['path'];
            if(preg_match('#/?$#',$parse['path'])){
                $path = trim($parse['path'],'/').'/index.php';
            }

            $wp = new WP();
            $_SERVER['REQUEST_URI'] = $url;
            $_SERVER['PHP_SELF'] = '/index.php';
            $old_page = isset($_GET['page'])?$_GET['page']:null;
            if($old_page === null){

            }else{
                unset($_GET['page']);
            }
            $wp->parse_request($url);
            $wp->build_query_string();

            $wp_query = new WP_Query();
            $wp_query->parse_query($wp->query_vars);
            if($wp_query->is_author){
                $type = 'author';
                break;
            }
            if($wp_query->is_tag){
                $type = 'tag';
                break;
            }
            if($wp_query->is_feed){
                $type = 'feed';
                break;
            }
            if($wp_query->is_archive){
                $type = 'category';
                break;
            }


            if($wp_query->is_singular){
                //$wp_query->query();
                //print_r($wp_query->get_posts());
                $posts = $wp_query->get_posts();
                if($posts){
                    if($posts[0]->post_type=='page'){
                        $type = 'page';
                        break;
                    }

                }

                $type = 'post';
                break;
            }


            if($old_page===null){

            }else{
                $_GET['page'] = $old_page;
            }
            //print_r($wp);
            //print_r($wp_query);
            $_SERVER['PHP_SELF'] = $php_self;
            $_SERVER['REQUEST_URI'] = $request_uri;

        }while(0);

        return $type;

    }

    public static function chart_data($day,$type,$compare=0)
    {
        global $wpdb;

        $time = strtotime(current_time('mysql'));
        if($day){
            $time = $time - 86400 * $day;
        }

        if($compare) {
            $time = $time - 86400 * ($day > 0 ? $day : 1);
        }
        $ymd = date('Y-m-d',$time);
        $t = $wpdb->prefix.'wb_spider_log';

        if($day>2){
            //group by h
            $format = '%m-%d';
            $op = '>=';

            $xdata = [];
            for($i=0;$i<$day;$i++){
                $xdata[] = date('m-d',$time + $i * 86400);
            }
        }else{
            $format='%H';
            $op = '=';
            $xdata = [];

            for($i=0;$i<24;$i++){
                $xdata[] = $i<10?'0'.$i:''.$i;
            }
        }

        $sql = "SELECT COUNT(1) num,COUNT(DISTINCT spider) spider,DATE_FORMAT(visit_date,'$format') ymd FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d') $op '$ymd' GROUP BY ymd ORDER BY ymd";
        $list = $wpdb->get_results($sql);
        $tmp = [];
        foreach($list as $r){
            if($type==2){
                $tmp[$r->ymd] = $r->num;
            }else if($type == 3){
                $tmp[$r->ymd] = $r->spider > 0 ? ceil($r->num/$r->spider) : 0;
            }else{
                $tmp[$r->ymd] = $r->spider;
            }

        }

        $ydata = [];
        foreach ($xdata as $v){
            $ydata[] = isset($tmp[$v])?$tmp[$v]:0;
        }


        return [$xdata,$ydata];
    }


    public static function spider_analyser_ajax()
    {
        global $wpdb;

        switch($_POST['op'])
        {
            case 'chk_ver':
                $http = wp_remote_get('https://www.wbolt.com/wb-api/v1/themes/checkver?code=spider-analyser&ver='.WP_SPIDER_ANALYSER_VERSION.'&chk=1',array('sslverify' => false,'headers'=>array('referer'=>home_url()),));

                if(wp_remote_retrieve_response_code($http) == 200){
                    echo wp_remote_retrieve_body($http);
                }

                exit();
                break;
            case 'chart_data':

                $type = absint($_POST['type']);
                $day = absint($_POST['day']);

                $data = self::chart_data($day,$type);
                //$compare_day = $day>0?$day * 2 : 1;
                $compare = self::chart_data($day,$type,1);

                $ret = array(
                    //'sql'=>$sql,
                    'code'=>0,
                    'data'=>$data,
                    'compare'=>$compare,
                );
                header('content-type:text/json;');

                echo json_encode($ret);

                exit();
                break;
            case 'top_url':
                $day = absint($_POST['day']);

                $time = strtotime(current_time('mysql'));
                if($day){
                    $time = $time - 86400 * $day;
                }
                $ymd = date('Y-m-d',$time);
                $t = $wpdb->prefix.'wb_spider_log';
                $op = '=';
                if($day>1){
                    $op = '>=';
                }

                $total = $wpdb->get_var("SELECT COUNT(1) total FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d') $op '$ymd'");

                $sql = "SELECT COUNT(1) num,url FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d') $op '$ymd' GROUP BY url_md5 ORDER BY num DESC LIMIT 10";

                $list = $wpdb->get_results($sql);
                $data = [];

                foreach($list as $r){
                    $r->rate = round($r->num/$total * 100 ,2);
                    $data[] = $r;
                }

                $ret = array(
                    //'sql'=>$sql,
                    'code'=>0,
                    'data'=>$data,
                );
                header('content-type:text/json;');

                echo json_encode($ret);

                exit();
                break;

            case 'top_spider':
                $day = absint($_POST['day']);

                $time = strtotime(current_time('mysql'));
                if($day){
                    $time = $time - 86400 * $day;
                }
                $ymd = date('Y-m-d',$time);
                $t = $wpdb->prefix.'wb_spider_log';
                $op = '=';
                if($day>1){
                    $op = '>=';
                }
                $total = $wpdb->get_var("SELECT COUNT(1) total FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d') $op '$ymd'");

                $sql = "SELECT COUNT(1) num,spider FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d') $op '$ymd' GROUP BY spider ORDER BY num DESC LIMIT 10";

                $list = $wpdb->get_results($sql);
                $data = [];

                foreach($list as $r){
                    $r->rate = round($r->num/$total * 100 ,2);
                    $data[] = $r;
                }

                $ret = array(
                    //'sql'=>$sql,
                    'code'=>0,
                    'data'=>$data,
                );
                header('content-type:text/json;');

                echo json_encode($ret);

                exit();
                break;
            case 'summary':
                $ymd = current_time('Y-m-d');
                $t = $wpdb->prefix.'wb_spider_log';
                //蜘蛛数
                $data = [['spider'=>0,'url'=>0,'avg_url'=>0],['spider'=>0,'url'=>0,'avg_url'=>0],['spider'=>0,'url'=>0,'avg_url'=>0]];


                $row = $wpdb->get_row("SELECT COUNT(1) url,COUNT(DISTINCT spider) spider FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d')='$ymd' ");

                if($row){
                    $data[0]['spider'] = $row->spider;
                    $data[0]['url'] = $row->url;
                    $data[0]['avg_url'] = $row->spider>0?ceil($row->url/$row->spider):0;
                }
                $ymd = date('Y-m-d',strtotime(current_time('mysql')) - 86400);

                $row = $wpdb->get_row("SELECT COUNT(1) url,COUNT(DISTINCT spider) spider FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d')='$ymd' ");

                if($row){
                    $data[1]['spider'] = $row->spider;
                    $data[1]['url'] = $row->url;
                    $data[1]['avg_url'] = $row->spider>0?ceil($row->url/$row->spider):0;
                }

                $ymd = date('Y-m-d',strtotime(current_time('mysql')) - 86400 * 30);
                $row = $wpdb->get_row("SELECT COUNT(1) url FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d')>='$ymd' ");
                if($row){
                    $data[2]['url'] = ceil($row->url / 30);
                }
                $row2 = $wpdb->get_row("SELECT SUM(num) spider FROM (SELECT COUNT(DISTINCT  spider) num,DATE_FORMAT(visit_date,'%Y-%m-%d') ymd FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d')>='$ymd' GROUP BY ymd) as tmp ");
                if($row2){
                    $data[2]['spider'] = ceil($row2->spider / 30);
                }

                $data[2]['avg_url'] = $data[2]['spider'] > 0?ceil($data[2]['url'] / $data[2]['spider']):0;



                $ret = array(
                    //'sql'=>$sql,
                    'code'=>0,
                    'data'=>$data,
                );
                header('content-type:text/json;');

                echo json_encode($ret);

                exit();

                break;
            case 'list':
                $spider_info = self::spider_info();

                $q = isset($_POST['q'])?$_POST['q']:array();
                $day = isset($q['day']) ? intval($q['day']):-1;
                $t = $wpdb->prefix.'wb_spider_log';
                $where = array();
                if($day>-1){
                    $time = strtotime(current_time('mysql'));
                    if($day){
                        $time = $time - 86400 * $day;
                    }
                    $ymd = date('Y-m-d',$time);

                    $op = '=';
                    if($day>1){
                        $op = '>=';
                    }

                    $where[] = "DATE_FORMAT(visit_date,'%Y-%m-%d') $op '$ymd'";
                }

                /*if(isset($q['spider']) && $q['spider']){
                    $where[] = $wpdb->prepare("spider=%s",$q['spider']);
                }
                if(isset($q['code']) && $q['code']){
                    $where[] = $wpdb->prepare("code=%s",$q['code']);
                }*/

                if(isset($q['type']) && $q['type']){

                    $spider = self::spider_info();
                    $a = array();
                    foreach($spider as $sk=>$sy){
                        if($sy['bot_type'] == $q['type']){
                            $a[] = $wpdb->prepare('%s',$sk);
                        }

                    }
                    if($a){
                        $where[] = "spider IN (".implode(',',$a).")";
                    }


                }
                if(isset($q['name']) && $q['name']){
                    $where[] = $wpdb->prepare("spider REGEXP %s",preg_quote($q['name']));
                }
                $num = 100;
                if(isset($_POST['num'])){
                    $num = max(10,absint($_POST['num']));
                }
                if(isset($_POST['page'])){
                    $page = absint($_POST['page']);
                }

                $offset = max(0,($page-1) * $num);

                if($where){
                    $where = implode(' AND ',$where);
                }else{
                    $where = '1=1';
                }



                $total = $wpdb->get_var("SELECT COUNT(1) total FROM $t WHERE $where");

                $sql = "SELECT spider,COUNT(1) num,MAX(visit_date) last_visit FROM $t WHERE $where GROUP BY spider ORDER BY num DESC ";
                $list = $wpdb->get_results($sql);
                $not_found = array();
                foreach($list as $r){
                    $r->rate = round($r->num/$total * 100 ,2);
                    if(isset($spider_info[$r->spider])){
                        $info = $spider_info[$r->spider];
                        $r->type = $info['bot_type'];
                        $r->url = $info['bot_url'];
                    }else{
                        $r->type = '';
                        $r->url = '';
                        $not_found[] = $r->spider;
                    }

                    //$data[] = $r;
                }
                if($not_found){
                    self::update_spider($not_found);
                }

                $ret = array(
                    //'sql'=>$sql,
                    'num'=>$num,
                    'total'=>count($list),
                    'code'=>0,
                    'data'=>$list,
                );
                header('content-type:text/json;');

                echo json_encode($ret);

                exit();
                break;
            case 'log':

                $q = isset($_POST['q'])?$_POST['q']:array();
                $day = isset($q['day']) ? intval($q['day']):-1;
                $t = $wpdb->prefix.'wb_spider_log';
                $where = array();
                if($day>-1){
                    $time = strtotime(current_time('mysql'));
                    if($day){
                        $time = $time - 86400 * $day;
                    }
                    $ymd = date('Y-m-d',$time);

                    $op = '=';
                    if($day>1){
                        $op = '>=';
                    }

                    $where[] = "DATE_FORMAT(visit_date,'%Y-%m-%d') $op '$ymd'";
                }

                if(isset($q['spider']) && $q['spider']){
                    $where[] = $wpdb->prepare("spider=%s",$q['spider']);
                }
                if(isset($q['code']) && $q['code']){
                    $where[] = $wpdb->prepare("code=%s",$q['code']);
                }
                if(isset($q['url']) && $q['url']){
                    $where[] = $wpdb->prepare("url REGEXP %s",preg_quote($q['url']));
                }
                if(isset($q['ip']) && $q['ip']){
                    $where[] = $wpdb->prepare("visit_ip REGEXP %s",preg_quote($q['ip']));
                }
                $num = 50;
                if(isset($_POST['num'])){
                    $num = max(10,absint($_POST['num']));
                }
                if(isset($_POST['page'])){
                    $page = absint($_POST['page']);
                }

                $offset = max(0,($page-1) * $num);

                if($where){
                    $where = implode(' AND ',$where);
                }else{
                    $where = '1=1';
                }

                $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $t WHERE $where ORDER BY id DESC LIMIT $offset,$num";
                $list = $wpdb->get_results($sql);

                $total = $wpdb->get_var("SELECT FOUND_ROWS()");
                $ret = array(
                    //'sql'=>$sql,
                    'num'=>$num,
                    'total'=>$total,
                    'code'=>0,
                    'data'=>$list,
                );
                header('content-type:text/json;');

                echo json_encode($ret);

                exit();
                break;
            case 'path':

                $q = isset($_POST['q'])?$_POST['q']:array();
                $day = isset($q['day']) ? intval($q['day']):-1;
                $t = $wpdb->prefix.'wb_spider_log';
                $where = array();
                if($day>-1){
                    $time = strtotime(current_time('mysql'));
                    if($day){
                        $time = $time - 86400 * $day;
                    }
                    $ymd = date('Y-m-d',$time);

                    $op = '=';
                    if($day>1){
                        $op = '>=';
                    }

                    $where[] = "DATE_FORMAT(visit_date,'%Y-%m-%d') $op '$ymd'";
                }

                if(isset($q['spider']) && $q['spider']){
                    $where[] = $wpdb->prepare("spider=%s",$q['spider']);
                }
                if(isset($q['code']) && $q['code']){
                    $where[] = $wpdb->prepare("code=%s",$q['code']);
                }
                if(isset($q['url']) && $q['url']){
                    $where[] = $wpdb->prepare("url REGEXP %s",preg_quote($q['url']));
                }
                if(isset($q['ip']) && $q['ip']){
                    $where[] = $wpdb->prepare("visit_ip REGEXP %s",preg_quote($q['ip']));
                }
                if(isset($q['type']) && $q['type']){
                    $where[] = $wpdb->prepare("url_type=%s",$q['type']);
                }
                $num = 50;
                if(isset($_POST['num'])){
                    $num = max(10,absint($_POST['num']));
                }
                if(isset($_POST['page'])){
                    $page = absint($_POST['page']);
                }

                $offset = max(0,($page-1) * $num);

                if($where){
                    $where = implode(' AND ',$where);
                }else{
                    $where = '1=1';
                }

                $sum = $wpdb->get_var("SELECT COUNT(1) num FROM $t WHERE $where");

                $sql = "SELECT SQL_CALC_FOUND_ROWS COUNT(1) num,url,url_type,'' type,ROUND(COUNT(1)/$sum * 100,2) percent FROM $t WHERE $where GROUP BY url_md5 ORDER BY num DESC LIMIT $offset,$num";

                $list = $wpdb->get_results($sql);

                $total = $wpdb->get_var("SELECT FOUND_ROWS()");
                $ret = array(
                    //'sql'=>$sql,
                    'num'=>$num,
                    'total'=>$total,
                    'code'=>0,
                    'data'=>$list,
                );
                header('content-type:text/json;');

                echo json_encode($ret);

                exit();
                break;
        }

    }

    public static function run_log($msg,$mod=null)
    {

        if(!self::$debug){
            return;
        }


        if(is_array($msg) || is_object($msg)){
            $msg = json_encode($msg);
        }

        if($mod){
            $msg = '['.$mod.'] '.$msg;
        }
        error_log('['.current_time('mysql').'] '.$msg."\n",3,__DIR__.'/#log/running.log');

    }

    public static function plugin_activate()
    {
        self::set_up();
    }
    public static function plugin_deactivate()
    {
        wp_clear_scheduled_hook('wb_wp_spider_trace_cron');
        wp_clear_scheduled_hook('wp_wb_spider_analyser_cron');
    }

    public static function wp_wb_spider_analyser_cron(){

        self::check_404();

        if(current_time('H') == '01'){
            self::calc_log(date('Y-m-d',strtotime(current_time('Y-m-d 00:00:00')-1)));
        }

        self::calc_log();

        self::del_old_log();

        self::set_url_type();
    }

    public static function set_url_type()
    {
        global $wpdb;

        $t = $wpdb->prefix.'wb_spider_log';

        $list = $wpdb->get_results("SELECT url,url_md5 FROM $t WHERE url_type IS NULL GROUP BY url_md5 LIMIT 100");

        if($list)foreach($list as $r){
            $type = self::match_type($r->url);
            if($type){
                $wpdb->query($wpdb->prepare("UPDATE $t SET url_type=%s WHERE url_md5=%s",$type,$r->url_md5));
            }
        }

    }

    public static function check_404()
    {
        global $wpdb;
        $max_id = get_option('sp_an_max_id',0);

        $t = $wpdb->prefix.'wb_spider_log';
        $list = $wpdb->get_results("SELECT max(id) max_id,url,url_md5 FROM $t WHERE `code`='404' AND id>$max_id GROUP BY url_md5 ORDER BY max_id ASC LIMIT 500");


        foreach($list as $r){
            $url = home_url($r->url);
            $http = wp_remote_head($url);
            $code = wp_remote_retrieve_response_code($http);
            if($code){
                $wpdb->query($wpdb->prepare("UPDATE $t SET `code`=%s WHERE url_md5 =%s ",$code,$r->url_md5));
                $max_id = $r->max_id;
            }
        }
        update_option('sp_an_max_id',$max_id,false);


    }
    public static function del_old_log()
    {
        global $wpdb;


        $t = $wpdb->prefix.'wb_spider_log';

        $ymd = date('Y-m-d',strtotime('-2 month'));

        $wpdb->query("DELETE FROM $t WHERE DATE_FORMAT(visit_date,'%Y-%m-%d') < '$ymd' ");

    }

    public static function calc_all_log()
    {
        global $wpdb;


        $t = $wpdb->prefix.'wb_spider_log';

        $cols = $wpdb->get_col("SELECT DISTINCT DATE_FORMAT(visit_date,'%Y-%m-%d') FROM $t ");


        if($cols)foreach($cols as $ymd){
            self::calc_log($ymd);
        }

    }


    public static function calc_log($ymd=null)
    {

        global $wpdb;

        $t = $wpdb->prefix.'wb_spider';
        $t_log = $t.'_log';
        $t_sum = $t.'_sum';
        $t_visit = $t.'_visit';
        if(!$ymd){
            $ymd = current_time('Y-m-d');
        }

        //new spider
        $wpdb->query("INSERT INTO $t(name) SELECT DISTINCT spider FROM $t_log a WHERE NOT EXISTS(SELECT id FROM $t b WHERE a.spider=b.name)");


        $list = $wpdb->get_results("SELECT id,name FROM $t ");
        $spiders = [];
        foreach($list as $r){
            $spiders[$r->name] = $r->id;
        }

        //spider

        $sql = "SELECT COUNT(1) num,DATE_FORMAT(a.visit_date,'%Y%m%d%H') ymdh,MIN(a.visit_date) visit_date,a.spider,b.id AS spider_id FROM $t_log a,$t b WHERE a.spider=b.name AND DATE_FORMAT(a.visit_date,'%Y-%m-%d')='$ymd' GROUP BY a.spider,ymdh ";

        $list = $wpdb->get_results($sql);

        //foreach($list as $r->r);

        //删除旧数据
        $wpdb->query("DELETE FROM $t_sum WHERE FROM_UNIXTIME(created,'%Y-%m-%d')='$ymd'");

        foreach ($list as $r){
            $d = array(
                'ymdh'=>$r->ymdh,
                'created'=>strtotime($r->visit_date),
                'spider'=>$r->spider_id,
                'visit_times'=>$r->num
            );
            $wpdb->insert($t_sum,$d);
        }



        return;

        //spider url

        $sql = "SELECT COUNT(1) num,DATE_FORMAT(visit_date,'%Y%m%d') ymdh,MIN(visit_date) visit_date,spider,url FROM $t_log WHERE DATE_FORMAT(visit_date,'%Y-%m-%d')='$ymd' GROUP BY spider,ymdh,url_md5 ";

        $list = $wpdb->get_results($sql);

        //foreach($list as $r->r);

        //删除旧数据
        $wpdb->query("DELETE FROM $t_visit WHERE FROM_UNIXTIME(created,'%Y-%m-%d')='$ymd'");

        foreach ($list as $r){
            $d = array(
                'ymdh'=>$r->ymdh,
                'created'=>strtotime($r->visit_date),
                'spider'=>$spiders[$r->spider],
                'visit_times'=>$r->num,
                'url_md5'=>$r->url_md5,
                'url'=>$r->url
            );
            $wpdb->insert($t_visit,$d);
        }
    }


    public static function handle(){
        if(self::$in_log){
            return;
        }


        self::$in_log = true;

        $has_error = error_get_last();

        global $wp,$wp_query;

        if($has_error && self::should_handle_error($has_error)){
            $code = '500';
        }else if(is_404()){
            $code = '404';
        }else {
            $code = '200';
        }
        self::log($code);

    }

    protected static function should_handle_error( $error ) {
        $error_types_to_handle = array(
            E_ERROR,
            E_PARSE,
            E_USER_ERROR,
            E_COMPILE_ERROR,
            E_RECOVERABLE_ERROR,
        );

        if ( isset( $error['type'] ) && in_array( $error['type'], $error_types_to_handle, true ) ) {
            return true;
        }

        return (bool) apply_filters( 'wp_should_handle_php_error', false, $error );
    }


    public static function log($status=''){
        global $wp_the_query;
        try{
            if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] != 'GET'){
                return;
            }
            if(!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT'])){
                return;
            }
            $agent = $_SERVER['HTTP_USER_AGENT'];

            do{
                if(preg_match('#spider#i',$agent)){
                    break;
                }
                if(preg_match('#bot#i',$agent)){
                    break;
                }
                if(preg_match('#crawler#i',$agent)){
                    break;
                }
                if(preg_match('#(Daumoa|Yahoo!|Qwantify|Seeker|Elefent|13TABS|iqdb|TinEye|Plukkie|PDFDriveCrawler)#i',$agent)){
                    break;
                }
                return;
            }while(0);

            /*$log_dir = __DIR__.'/#log/'.current_time('Ym').'/';
            if(!is_dir($log_dir)){
                mkdir($log_dir,0755,true);
            }

            $log_file = $log_dir.current_time('d').'.log';*/


            //$msg = json_encode(array($status,$_SERVER['REQUEST_URI'],$_SERVER['REMOTE_ADDR'],$agent));

            //error_log('['.current_time('mysql').']'.$msg."\n",3,$log_file);
            //, ``, ``, ``, ``, `url_md5`


            global $wpdb;

            $spider = 'other';

            if(preg_match('#[a-z0-9\.-]+ spider#',$agent,$spider_match)){
                $spider = $spider_match[0];
            }else if(preg_match('#[a-z0-9\.-]+ bot#i',$agent,$spider_match)){
                $spider = $spider_match[0];
            }else if(preg_match('#[a-z0-9\.-]*spider[a-z0-9]*#i',$agent,$spider_match)){
                $spider = $spider_match[0];
            }else if(preg_match('#[a-z0-9\.-]*bot[a-z0-9]*#i',$agent,$spider_match)){
                $spider = $spider_match[0];
            }else if(preg_match('#[a-z0-9\.-]+ crawler#',$agent,$spider_match)){
                $spider = $spider_match[0];
            }else if(preg_match('#[a-z0-9\.-]*crawler[a-z0-9]*#i',$agent,$spider_match)){
                $spider = $spider_match[0];
            }else if(preg_match('#(Daumoa|Yahoo!|Qwantify|Seeker|Elefent|13TABS|iqdb|TinEye|Plukkie|PDFDriveCrawler)#i',$agent,$spider_match)){
                $spider = $spider_match[0];
            }


            $url = $_SERVER['REQUEST_URI'];

            $d = array(
                'spider'=>$spider,
                'visit_date'=>current_time('mysql'),
                'code'=>$status,
                'visit_ip'=>$_SERVER['REMOTE_ADDR'],
                'url'=>$url,
                'url_md5'=>md5($url),
            );

            $type = null;
            //['index','post','page','category','tag','search','author','feed','sitemap','api','other'];
            if($wp_the_query && $wp_the_query instanceof WP_Query){
                if($wp_the_query->is_search()){
                    $type = 'search';
                }else if($wp_the_query->is_feed()){
                    $type = 'feed';
                }else if($wp_the_query->is_tag()){
                    $type = 'tag';
                }else if($wp_the_query->is_author()){
                    $type = 'author';
                }else if($wp_the_query->is_category() || $wp_the_query->is_archive()){
                    $type = 'category';
                }else if($wp_the_query->is_singular(array('page'))){
                    $type = 'page';
                }else if($wp_the_query->is_singular()){
                    $type = 'post';
                }else if($wp_the_query->is_home() || $wp_the_query->is_front_page()){
                    $type = 'index';

                }
            }
            if(!$type && preg_match('#wp-admin/admin-ajax\.php#',$d['url'])){
                $type = 'api';
            }
            if($type){
                $d['url_type'] = $type;
            }

            $wpdb->insert($wpdb->prefix.'wb_spider_log',$d);



        }catch(Exception $ex){

        }
    }



    public static function adminMenu(){

	    add_menu_page(
		    '蜘蛛分析',
		    '蜘蛛分析',
		    'administrator',
		    'wp_spider_analyser' ,
		    array(__CLASS__,'spider_summary'),
		    WP_SPIDER_ANALYSER_URL . 'assets/ico.svg'
	    );
	    //add_submenu_page('wp_spider_analyser','蜘蛛概况', '蜘蛛概况', 'administrator','wp_spider_analyser' , array(__CLASS__,'spider_summary'));
	    add_submenu_page('wp_spider_analyser','蜘蛛日志', '蜘蛛日志', 'administrator','wp_spider_analyser_log' , array(__CLASS__,'spider_log'));
	    add_submenu_page('wp_spider_analyser','蜘蛛列表', '蜘蛛列表', 'administrator','wp_spider_analyser_list' , array(__CLASS__,'spider_list'));
        add_submenu_page('wp_spider_analyser','访问路径', '访问路径', 'administrator','wp_spider_analyser_path' , array(__CLASS__,'spider_path'));
    }

    public static function update_spider($spider)
    {
        $api = 'https://www.wbolt.com/wb-api/v1/spider/info';
        $arg = array(
            'timeout'   => 1,
            'blocking'  => false,
            'sslverify' => false,
            'body'=>array('spider'=>json_encode($spider)),
            'headers'=>array('referer'=>home_url()),
        );
        wp_remote_post($api,$arg);
    }

    public static function spider_path()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        if(defined('WB_CORE_ASSETS_LOAD') && class_exists('WB_Core_Asset_Load')){
            WB_Core_Asset_Load::load('path-17');
        }else{
            wp_enqueue_script('spider-analyser-path-js', WP_SPIDER_ANALYSER_URL . 'assets/spider-path.js', array(), WP_SPIDER_ANALYSER_VERSION, true);
        }

        global $wpdb;
        $t = $wpdb->prefix.'wb_spider_log';
        $spider = $wpdb->get_col("SELECT DISTINCT spider FROM $t");
        $code = $wpdb->get_col("SELECT DISTINCT code FROM $t");

        include __DIR__.'/path.php';
    }
    public static function spider_info()
    {
        global $wpdb;

        $time = current_time('U',1);
        $info = get_option('wb_spider_info',array());
        if($info && isset($info['expired']) &&  $info['expired']>$time && isset($info['data'])){
            return $info['data'];
        }
        $info = array('expired'=>$time + 1 * HOUR_IN_SECONDS,'data'=>array());
        $api = 'https://www.wbolt.com/wb-api/v1/spider/info';
        $http = wp_remote_get($api,array('headers'=>array('referer'=>home_url()),));
        do{
            if(is_wp_error($http)){
                break;
            }
            $body = wp_remote_retrieve_body($http);
            if(!$body){
                break;
            }
            $data = json_decode($body,true);
            if(!$data){
                break;
            }
            if(!is_array($data)){
                break;
            }
            $t = $wpdb->prefix.'wb_spider_log';
            $spider = $wpdb->get_col("SELECT DISTINCT spider FROM $t WHERE 1");
            $spider_data = array();
            foreach($data['data'] as $k=>$r){
                if(!in_array($k,$spider))continue;
                $spider_data[$k] = $r;
            }
            $info['data'] = $spider_data;

        }while(0);
        update_option('wb_spider_info',$info,false);
        return $info['data'];
    }

    public static function spider_list()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        if(defined('WB_CORE_ASSETS_LOAD') && class_exists('WB_Core_Asset_Load')){
            WB_Core_Asset_Load::load('list-17');
        }else{
            wp_enqueue_script('spider-analyser-list-js', WP_SPIDER_ANALYSER_URL . 'assets/spider-list.js', array(), WP_SPIDER_ANALYSER_VERSION, true);
        }



        global $wpdb;
        $t = $wpdb->prefix.'wb_spider_log';

        $spider = self::spider_info();
        $types = array();
        foreach($spider as $r){
            $types[] = $r['bot_type'];
        }
        $types = array_unique($types);

        include __DIR__.'/spider.php';
    }

    public static function spider_log()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

	    if(defined('WB_CORE_ASSETS_LOAD') && class_exists('WB_Core_Asset_Load')){
		    WB_Core_Asset_Load::load('log-17');
	    }else{
		    wp_enqueue_script('spider-analyser-log-js', WP_SPIDER_ANALYSER_URL . 'assets/spider-log.js', array(), WP_SPIDER_ANALYSER_VERSION, true);
	    }

	    global $wpdb;
        $t = $wpdb->prefix.'wb_spider_log';
	    $spider = $wpdb->get_col("SELECT DISTINCT spider FROM $t");
	    $code = $wpdb->get_col("SELECT DISTINCT code FROM $t");

        include __DIR__.'/log.php';
    }

    public static function spider_summary()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

	    if(defined('WB_CORE_ASSETS_LOAD') && class_exists('WB_Core_Asset_Load')){
		    WB_Core_Asset_Load::load('admin-17');
	    }else{
		    wp_enqueue_script('spider-analyser-js', WP_SPIDER_ANALYSER_URL . 'assets/spider.js', array(), WP_SPIDER_ANALYSER_VERSION, true);
	    }

        include __DIR__.'/summary.php';
    }




    public static function set_up(){
        self::setup_db();
    }
    public static function setup_db(){

        global $wpdb;

        $wb_tables = explode(',','wb_spider_visit,wb_spider_sum,wb_spider_log,wb_spider');

        //数据表
        $tables = $wpdb->get_col("SHOW TABLES LIKE '".$wpdb->prefix."wb_spider%'");


        $set_up = array();
        foreach ($wb_tables as $table){
            if(in_array($wpdb->prefix.$table,$tables)){
                continue;
            }

            $set_up[] = $table;
        }

        if(empty($set_up)){
            return;
        }

        $sql = file_get_contents(__DIR__.'/install/init.sql');

        $charset_collate = $wpdb->get_charset_collate();



        $sql = str_replace('`wp_wb_','`'.$wpdb->prefix.'wb_',$sql);
        $sql = str_replace('ENGINE=InnoDB', $charset_collate , $sql);



        $sql_rows = explode('-- row split --',$sql);

        foreach($sql_rows as $row){

            if(preg_match('#`'.$wpdb->prefix.'(wb_spider.*?)`\s+\(#',$row,$match)){
                if(in_array($match[1],$set_up)){
                    $wpdb->query($row);
                }
            }
            //print_r($row);exit();
        }

        update_option('wb_spider_analyser_db_ver','1.2');
    }

    public static function upgrade()
    {
        global $wpdb;
        $t = $wpdb->prefix.'wb_spider_log';
        if(version_compare('1.1.2',WP_SPIDER_ANALYSER_VERSION)>-1){
            $db_ver = get_option('wb_spider_analyser_db_ver','1.0');
            if(version_compare($db_ver,'1.2')<0){
                $sql = $wpdb->get_var('SHOW CREATE TABLE `'.$t.'`',1);
                if(!preg_match('#`url_type`#is',$sql)){
                    $wpdb->query("ALTER TABLE $t ADD `url_type` varchar(32) DEFAULT NULL");
                    $wpdb->query("ALTER TABLE $t ADD INDEX(`url_type`)");
                }
                update_option('wb_spider_analyser_db_ver','1.2');
            }

        }
    }

}