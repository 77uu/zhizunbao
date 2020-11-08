<?php
/**
 * This was contained in an addon until version 1.0.0 when it was rolled into
 * core.
 *
 * @package    WBOLT
 * @author     WBOLT
 * @since      2.2.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2019, WBOLT
 */

class Smart_SEO_Tool_Admin
{
    public static $name = 'sseot_pack';
    public static $optionName = 'sseot_option';
    public $token = '';
    public static $seo_info = array();

    public static function opt(){

        $opt = get_option(self::$optionName,array());

        $default_broken = array('active'=>0,'test_rate'=>30,'post_type'=>array('post'),'post_status'=>array('publish','future','pending'),'exclude'=>array(),'auto_op'=>array());

        $change = false;

        if(!isset($opt['broken'])){
            $opt[] = array();
        }
        foreach($default_broken as $k=>$v){
            if(!isset($opt['broken'][$k])){
                $opt['broken'][$k] = $v;
            }
        }
        if($opt['broken']['exclude'])foreach($opt['broken']['exclude'] as $k=>$v){
            $v = trim($v);
            if(!$v){
                unset($opt['broken']['exclude'][$k]);
                continue;
            }
            $opt['broken']['exclude'][$k] = $v;

        }

        if(!isset($opt['img_seo']['content'])){
            $change = true;
            $opt['img_seo']['content'] = '%title插图%num';
        }
        if(!isset($opt['img_seo']['thumb'])){
            $change = true;
            $opt['img_seo']['thumb'] = '%title缩略图';
        }

        if(!isset($opt['url_seo'])){
            $change = true;
            $opt['url_seo'] = array('active'=>0,'hide_category'=>1,'reset_tag'=>1,'set_nofollow'=>1,'set_gopage'=>1,'exclude'=>array());
        }else{
            foreach(array('active'=>1,'hide_category'=>1,'reset_tag'=>1,'set_nofollow'=>1,'set_gopage'=>1,'exclude'=>array()) as $k=>$v){
                if(!isset($opt['url_seo'][$k])){
                    $opt['url_seo'][$k] = 0;
                    $change = true;
                }
            }
        }

        if(!isset($opt['robots_seo'])){
            $change = true;
            $opt['robots_seo'] = array(
                'active'=>1,
                'content'=>'',
            );
        }else{
            if(!isset($opt['robots_seo']['active'])){
                $change = true;
                $opt['robots_seo']['active'] = 0;
            }
        }



        if(!isset($opt['sitemap_seo'])){
            $change = true;
            $opt['sitemap_seo'] = array();
        }
        $sitemap_seo = $opt['sitemap_seo'];

        if(!isset($sitemap_seo['active'])){
            $change = true;
            $sitemap_seo['active'] = 0;
        }

        if(!isset($sitemap_seo['push_to'])){
            $change = true;
            $sitemap_seo['push_to'] = array('google'=>1,'bing'=>1,'baidu'=>0,'360'=>0,'robots'=>1);

        }else{

            foreach (array('google'=>1,'bing'=>1,'baidu'=>0,'360'=>0,'robots'=>1) as $k=>$v){
                if(!isset($sitemap_seo['push_to'][$k])){
                    $change = true;
                    $sitemap_seo['push_to'][$k] = 0;
                }
            }
        }



        //'index'=>'首页','post'=>'日志','category'=>'分类','post_tag'=>'Tag页面','page'=>'独立页面','archive'=>'存档页面','author'=>'作者页面'
        $sitemap_def = array(
            'index'=>array('weights'=>1,'frequency'=>'daily','switch'=>1),
            'post'=>array('weights'=>0.8,'frequency'=>'daily','switch'=>1),
            'category'=>array('weights'=>0.6,'frequency'=>'daily','switch'=>1),
            'post_tag'=>array('weights'=>0.3,'frequency'=>'weekly','switch'=>1),
            'page'=>array('weights'=>0.3,'frequency'=>'monthly','switch'=>0),
            'archive'=>array('weights'=>0.3,'frequency'=>'monthly','switch'=>0),
            'author'=>array('weights'=>0.3,'frequency'=>'weekly','switch'=>0)
        );
        foreach($sitemap_def as $k=>$v){

            if(!isset($sitemap_seo['content_item'])){
                $change = true;
                $sitemap_seo['content_item'] = array();
            }

            if(!isset($sitemap_seo['content_item'][$k])){
                $change = true;
                $sitemap_seo['content_item'][$k] = $v;
                continue;
            }

            if(!isset($sitemap_seo['content_item'][$k]['switch'])){
                $change = true;
                $sitemap_seo['content_item'][$k]['switch'] = 0;
            }

        }

        $opt['sitemap_seo'] = $sitemap_seo;


        if(!isset($opt['url_seo']['exclude']) || !is_array($opt['url_seo']['exclude'])){
            $change = true;
            $opt['url_seo']['exclude'] = array();
        }



        $exclude = array();

        //print_r($opt);exit();
        foreach($opt['url_seo']['exclude'] as $v){

            $v = trim($v);
            if(!$v){
                $change = true;
                continue;
            }
            $exclude[] = $v;
        }

        $opt['url_seo']['exclude'] = $exclude;

        if($change){
            update_option(self::$optionName,$opt);
        }

        //print_r($opt);exit();
        return $opt;

    }

    public static function cnf($key,$default=null){
        static $_push_cnf = array();
        if(!$_push_cnf){

            $_push_cnf = self::opt();
        }
        $keys = explode('.',$key);
        $cnf = $_push_cnf;
        $find = false;

        foreach ($keys as $_k){
            if(isset($cnf[$_k])){
                $cnf = $cnf[$_k];
                $find = true;
                continue;
            }
            $find = false;
        }
        if($find){
            return $cnf;
        }

        /*if(isset($_push_cnf[$key])){
            return $_push_cnf[$key];
        }*/

        return $default;

    }

    public function __construct(){


        register_activation_hook(SMART_SEO_TOOL_BASE_FILE, array(__CLASS__, 'activate_plugin'));
        register_deactivation_hook(SMART_SEO_TOOL_BASE_FILE, array(__CLASS__, 'deactivate_plugin'));

        //remove_action('wp_head', 'wpcom_seo');

        Smart_SEO_Tool_Rewrite::init();
        Smart_SEO_Tool_Sitemap::init();

        if(is_admin()){
            //插件设置连接
            add_filter( 'plugin_action_links', array($this,'actionLinks'), 10, 2 );

            add_action( 'admin_menu', array($this,'admin_menu') );

            add_action( 'admin_init', array($this,'admin_init') );

            add_action('admin_enqueue_scripts',array($this,'admin_enqueue_scripts'),1);

            add_filter('plugin_row_meta', array(__CLASS__, 'plugin_row_meta'), 10, 2);

            add_action('updated_option',array(__CLASS__,'updated_option'),10,3);


            add_action( 'add_meta_boxes', array(__CLASS__,'add_meta_box'));
            add_action( 'save_post', array(__CLASS__,'save_post_meta'));

            add_action('admin_head-post.php',array(__CLASS__,'admin_head'));
            add_action('admin_head-post-new.php',array(__CLASS__,'admin_head'));
        }else{


            $active = self::cnf('normal_seo_active',0);
            //print_r([$active]);
            if ($active) {

                add_action('template_redirect',array(__CLASS__,'template_redirect'));
            }

            if(self::cnf('img_seo.active',false)){
                new Smart_SEO_Tool_Images();
            }


        }

        Smart_SEO_Tool_Ajax::init();



        add_action('wb_smart_seo_tool_cron',array(__CLASS__,'wb_smart_seo_tool_cron'));

        if(!wp_next_scheduled('wb_smart_seo_tool_cron')){
            wp_schedule_event(strtotime(current_time('Y-m-d H:i:s',1)), 'hourly', 'wb_smart_seo_tool_cron');
        }


        add_action('edit_post',array(__CLASS__,'edit_post'),51,2);



        if(!get_option('wb_sst_db_ver')){
            self::setup_db();
        }

    }

    public static function edit_post($post_id,$post)
    {
        global $wpdb;

        $conf = self::cnf('broken');

        if(!$conf['active']){
            return;
        }
        if(!isset($conf['post_type'])){
            $conf['post_type'] = array('post');
        }
        if(!isset($conf['post_status'])){
            $conf['post_status'] = array('publish','future','pending');
        }
        if(!in_array($post->post_type,$conf['post_type'])){
            return;
        }
        if(!in_array($post->post_status,$conf['post_status'])){
            return;
        }
        $t = $wpdb->prefix.'wb_sst_broken_url';

        $list = $wpdb->get_results($wpdb->prepare("SELECT * FROM $t WHERE post_id=%d",$post->ID));

        if(empty($post->post_content) || !preg_match_all('#<a([^>]+)>(.+?)</a>#is',$post->post_content,$match)){
            if($list){
                $wpdb->query($wpdb->prepare("DELETE FROM $t WHERE post_id=%d AND url_md5 IS NULL",$post->ID));
            }else{
                $d = array(
                    'post_id'=>$post->ID,
                    'create_date'=>current_time('mysql'),
                    'memo'=>'log'
                );
                $wpdb->insert($t,$d);
            }
            return;
        }

        $exists_url = array();
        //empty log add marker
        if(empty($list)){
            $d = array(
                'post_id'=>$post->ID,
                'create_date'=>current_time('mysql'),
                'memo'=>'log'
            );
            $wpdb->insert($t,$d);
        }else{
            foreach($list as $k=>$v){
                if(!$v->url){
                    continue;
                }
                $exists_url[$v->url_md5] = $v->id;
            }
        }

        $host = parse_url(home_url(),PHP_URL_HOST);
        $host_match_rule = array(preg_quote($host));
        if($conf['exclude']){
            foreach ($conf['exclude'] as $v){
                $host_match_rule[] = preg_quote($v);
            }
        }
        if($host_match_rule){
            $host_match_rule = implode('|',$host_match_rule);
        }

        $same_url = array();
        foreach($match[1] as $k=>$a_html){
            if(!preg_match('#href=("|\')(.+?)("|\')#is',$a_html,$a_match)){
                continue;
            }
            $url = $a_match[2];
            if(!preg_match('#^https?://([^/]+)#is',$url,$host_match)){
                continue;
            }
            if($host_match_rule && preg_match('#('.$host_match_rule.')#i',$host_match[1])){
                continue;
            }


            $text = trim(strip_tags($match[2][$k]));
            if(!$text && preg_match('#<img#i',$match[1][$k])){
                $text = 'img';
            }

            $d = array(
                'post_id'=>$post->ID,
                'create_date'=>current_time('mysql'),
                'url'=>$url,
                'url_md5'=>md5($url),
                'url_text'=>$text
            );

            if(isset($same_url[$d['url_md5']])){
                continue;
            }
            $same_url[$d['url_md5']] = 1;


            if($exists_url && isset($exists_url[$d['url_md5']])){
                unset($exists_url[$d['url_md5']]);
                continue;
            }

            $wpdb->insert($t,$d);
        }
        if(!empty($exists_url)){
            $sid = implode(',',$exists_url);
            $wpdb->query("DELETE FROM $t WHERE id IN($sid)");
        }
    }

    public static function wb_smart_seo_tool_cron()
    {
        self::scan_post();

        self::detect_broken_url();
    }

    public static function clear_broken_url()
    {
        global $wpdb;
        $conf = self::cnf('broken');


        if(!$conf['active']){
            return false;
        }

        $t = $wpdb->prefix.'wb_sst_broken_url';

        $wpdb->query("TRUNCATE $t");
        return true;
    }
    public static function broken_url_count()
    {
        global $wpdb;
        $conf = self::cnf('broken');

        $sum = array('error'=>0,'redirect'=>0,'ok'=>0,'other'=>0);

        if(!$conf['active']){
            return $sum;
        }
        $t = $wpdb->prefix.'wb_sst_broken_url';
        $list = $wpdb->get_results("SELECT COUNT(1) num,`code` FROM $t WHERE `code` IS NOT NULL AND url_md5 IS NOT NULL GROUP BY `code` ");
        foreach($list as $r){
            if(preg_match('#^30#',$r->code)){
                $sum['redirect'] += $r->num;
            }else if(preg_match('#^(4|5|e)#',$r->code)) {
                $sum['error'] += $r->num;
            }else if(preg_match('#^2#',$r->code)){
                $sum['ok'] += $r->num;
            }else{
                $sum['other'] += $r->num;
            }
        }

        return $sum;

    }
    public static function mark_broken_url($id,$r = null){
        global $wpdb;
        $conf = self::cnf('broken');

        if(!$conf['active']){
            return null;
        }
        $t = $wpdb->prefix.'wb_sst_broken_url';
        if(!$r){
            $r = $wpdb->get_row($wpdb->prepare("SELECT * FROM $t WHERE id=%d",$id));
        }
        if(!$r){
            return null;
        }
        $wpdb->update($t,array('code'=>200,'check_date'=>'2023-10-01 10:00:00','memo'=>'mark as ok'),array('id'=>$r->id));
        return true;
    }
    public static function remove_broken_url($id,$r = null){
        global $wpdb;
        $conf = self::cnf('broken');

        if(!$conf['active']){
            return null;
        }
        $t = $wpdb->prefix.'wb_sst_broken_url';
        if(!$r){
            $r = $wpdb->get_row($wpdb->prepare("SELECT * FROM $t WHERE id=%d",$id));
        }
        if(!$r){
            return null;
        }
        $wpdb->delete($t,array('id'=>$r->id));
        $post = get_post($r->post_id);
        if(!$post){
            return null;
        }
        if(!preg_match_all('#<a[^>]+>(.+?)</a>#is',$post->post_content,$match)){
            return null;
        }
        $content = $post->post_content;
        $change = 0;
        foreach($match[0] as $k=>$a_html){
            if(!preg_match('#href=("|\')(.+?)("|\')#is',$a_html,$a_match)){
                continue;
            }
            $url = trim($a_match[2]);
            if($r->url_md5 == md5($url)){
                $content = str_replace($a_html,$match[1][$k],$content);
                $change = 1;
            }
        }
        if($change){
            wp_update_post(array('ID'=>$post->ID,'post_content'=>$content));
        }
        return true;
    }

    public static function detect_url($id,$r = null)
    {
        global $wpdb;
        $conf = self::cnf('broken');

        if(!$conf['active']){
            return null;
        }
        $t = $wpdb->prefix.'wb_sst_broken_url';
        if(!$r){
            $r = $wpdb->get_row($wpdb->prepare("SELECT * FROM $t WHERE id=%d",$id));
        }

        if(!$r){
            return null;
        }

        $d = array('check_date'=>current_time('mysql'));
        $http = wp_remote_head($r->url,array('timeout'=>30,'sslverify'=>false));
        if(is_wp_error($http)){
            $d['code'] = 'error';
            $d['memo'] = $http->get_error_message();
        }else{
            //$code = wp_remote_retrieve_header($http,'Location');
            $code = wp_remote_retrieve_response_code($http);
            $d['code'] = $code;
            $d['memo'] = null;
            $url_base = '';
            if(preg_match('#^https?://[^/]+#',$r->url,$base_match)){
                $url_base = $base_match[0];
            }
            if(preg_match('#^30#',$code)){

                $num = 0;
                do{
                    $redirect = wp_remote_retrieve_header($http,'location');
                    if(!$redirect){
                        break;
                    }
                    if(!preg_match('#^https?://#',$redirect) && preg_match('#^/#',$redirect)){
                        $redirect = $url_base.$redirect;
                    }
                    if(preg_match('#^https?://[^/]+#',$redirect,$base_match)){
                        $url_base = $base_match[0];
                    }
                    $http = wp_remote_head($redirect,array('timeout'=>30,'sslverify'=>false));
                    if(is_wp_error($http)){
                        $d['code'] = 'error';
                        $d['memo'] = $http->get_error_message();
                        break;
                    }
                    $code = wp_remote_retrieve_response_code($http);
                    if(!preg_match('#^30#',$code)){
                        if($code == 200){
                            $d['memo'] = $redirect;
                        }else if(preg_match('#^(4|5)#',$code)){
                            $d['code'] = $code;
                        }else{
                            $d['code'] = 'error';
                            $d['memo'] = $code;
                        }
                        //$d['code'] = $code;
                        break;
                    }
                    $num++;
                }while($num<6);
            }

        }

        $r->code = $d['code'];
        $r->memo = $d['memo'];
        $wpdb->update($t,$d,array('id'=>$r->id));

        return $r;

    }

    public static function detect_broken_url()
    {
        global $wpdb;
        $conf = self::cnf('broken');

        if(!$conf['active']){
            return;
        }
        $day = absint($conf['test_rate']);
        if(!$day){
            $day = 30;
        }
        $t = $wpdb->prefix.'wb_sst_broken_url';
        $list = $wpdb->get_results("SELECT * FROM $t WHERE url_md5 IS NOT NULL AND (check_date IS NULL OR DATE_ADD(check_date ,INTERVAL $day DAY) < NOW() ) LIMIT 10 ");

        foreach($list as $r){
            self::detect_url($r->id,$r);
        }
    }

    public static function scan_post()
    {
        global $wpdb;

        $conf = self::cnf('broken');

        if(!$conf['active']){
            return;
        }
        if(!isset($conf['post_type'])){
            $conf['post_type'] = array('post');
        }
        if(!isset($conf['post_status'])){
            $conf['post_status'] = array('publish','future','pending');
        }
        $host = parse_url(home_url(),PHP_URL_HOST);
        $host_match_rule = array(preg_quote($host));
        if($conf['exclude']){
            foreach ($conf['exclude'] as $v){
                $host_match_rule[] = preg_quote($v);
            }
        }
        if($host_match_rule){
            $host_match_rule = implode('|',$host_match_rule);
        }

        $t = $wpdb->prefix.'wb_sst_broken_url';
        $where = " AND NOT EXISTS(SELECT id FROM $t WHERE $t.post_id=$wpdb->posts.ID) ";
        $list = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type IN('".implode("','",$conf['post_type'])."') AND post_status IN('".implode("','",$conf['post_status'])."') $where ORDER BY post_date DESC LIMIT 100");

        foreach($list as $post){
            $d = array(
                'post_id'=>$post->ID,
                'create_date'=>current_time('mysql'),
                'memo'=>'log'
            );
            $wpdb->insert($t,$d);

            if(empty($post->post_content) || !preg_match_all('#<a([^>]+)>(.+?)</a>#is',$post->post_content,$match)){
                continue;
            }

            $exists_url = array();
            foreach($match[1] as $k=>$a_html){
                if(!preg_match('#href=("|\')(.+?)("|\')#is',$a_html,$a_match)){
                    continue;
                }
                $url = trim($a_match[2]);
                if(!preg_match('#^https?://([^/]+)#is',$url,$host_match)){
                    continue;
                }
                if($host_match_rule && preg_match('#('.$host_match_rule.')#i',$host_match[1])){
                    continue;
                }

                $text = trim(strip_tags($match[2][$k]));
                if(!$text && preg_match('#<img#i',$match[1][$k])){
                    $text = 'img';
                }


                $d = array(
                    'post_id'=>$post->ID,
                    'create_date'=>current_time('mysql'),
                    'url'=>$url,
                    'url_md5'=>md5($url),
                    'url_text'=>$text
                );
                if(isset($exists_url[$d['url_md5']])){
                    continue;
                }
                $exists_url[$d['url_md5']] = 1;


                $wpdb->insert($t,$d);
            }


        }

    }

    public static function admin_head(){



    }

    public static function add_meta_box()
    {
        $active = self::cnf('normal_seo_active',0);
        if(!$active){
            return;
        }
        add_meta_box(
            'wbolt_meta_box_bsl',
            'SEO信息设置',
            array(__CLASS__,'render_meta_box'),
            null,
            'advanced','high'
        );



    }
    public static function render_meta_box($post)
    {

	    wp_enqueue_style('wbp-admin-style-sst', plugin_dir_url(SMART_SEO_TOOL_BASE_FILE) . 'assets/wbp_admin.css', array(), SMART_SEO_TOOL_VERSION);
	    wp_enqueue_script('wbui-js', plugin_dir_url(SMART_SEO_TOOL_BASE_FILE) . 'assets/wbui/wbui.js', array(), SMART_SEO_TOOL_VERSION,true);
	    wp_enqueue_script('vue-js', plugin_dir_url(SMART_SEO_TOOL_BASE_FILE) . 'assets/vue.min.js', array(), SMART_SEO_TOOL_VERSION,true);
	    wp_enqueue_script('wbp-admin-js-sst', plugin_dir_url(SMART_SEO_TOOL_BASE_FILE) . 'assets/wb_admin_sst.js', array(), SMART_SEO_TOOL_VERSION,true);

        $meta_val = get_post_meta($post->ID,'wb_sst_seo',true);
        if(!$meta_val || !is_array($meta_val)){
            $meta_val = array(0=>'',1=>'',2=>'');
        }
        $sst_opt = array();
	    $sst_opt['title'] = $meta_val[0];
	    $sst_opt['keywords'] = $meta_val[1];
	    $sst_opt['description'] = $meta_val[2];

        $inline_js = 'var sst_opt='.json_encode($sst_opt).';';
        wp_add_inline_script('wbp-admin-js-sst', $inline_js, 'before');

	    include SMART_SEO_TOOL_PATH.'/tpl/meta_box.php';
    }

    public static function save_post_meta($post_id)
    {
        if(isset($_POST['wb_sst_seo'])){
            update_post_meta($post_id,'wb_sst_seo',$_POST['wb_sst_seo']);
        }
    }


    public static function updated_option($option, $old_value, $value ){
        if($option == self::$optionName){


            //self::flush_rewrite();

            $update_rewrite = 0;

            do{
                $v1 = isset($value['url_seo'])?$value['url_seo']:array('active'=>0,'hide_category'=>1,'reset_tag'=>1,'set_nofollow'=>1,'set_gopage'=>1);
                $v2 = isset($old_value['url_seo'])?$old_value['url_seo']:array('active'=>0,'hide_category'=>1,'reset_tag'=>1,'set_nofollow'=>1,'set_gopage'=>1);

                foreach(array('active'=>0,'hide_category'=>1,'reset_tag'=>1,'set_nofollow'=>1,'set_gopage'=>1) as $k=>$v){

                    if(!isset($v1[$k])){
                        $v1[$k] = 0;
                    }else{
                        $v1[$k] = $v1[$k]?1:0;
                    }
                    if(!isset($v2[$k])){
                        $v2[$k] = 0;
                    }else{
                        $v2[$k] = $v2[$k]?1:0;
                    }
                }

                if(md5((json_encode($v1))) != md5(json_encode($v2))){
                    $update_rewrite = 1;
                    break;
                }

                $v1 = isset($value['sitemap_seo'])?$value['sitemap_seo']:array();
                $v1 = isset($v1['active']) && $v1['active']?1:0;

                $v2 = isset($old_value['sitemap_seo'])?$old_value['sitemap_seo']:array();
                $v2 = isset($v2['active']) && $v2['active']?1:0;

                if($v1 != $v2){
                    $update_rewrite = 1;
                    break;
                }

            }while(false);

            update_option(self::$optionName.'_rewrite',$update_rewrite,false);
        }
    }

    public static function flush_rewrite(){
        global $wp_rewrite;

        $wp_rewrite->flush_rules();

    }

    public function admin_enqueue_scripts($hook){
        global $wb_settings_page_hook_bwbs;
        if($wb_settings_page_hook_bwbs != $hook) return;

        wp_enqueue_style('wbs-style-bdsl', plugin_dir_url(SMART_SEO_TOOL_BASE_FILE) . 'assets/wbp_setting.css', array(),SMART_SEO_TOOL_VERSION);
    }

    public static function render_title_tag()
    {
        /*if ( ! current_theme_supports( 'title-tag' ) ) {
            return;
        }*/
        echo '<title>' . str_replace('&#8211;','-',wp_get_document_title()) . '</title>' . "\n";
    }


    public static function wp_title($title, $sep, $seplocation){

        return str_replace('&#8211;','-',wp_get_document_title());

    }
    public static function wp_title_parts($part){

        //print_r($part);
        return $part;
    }
    public static function document_title_parts($part){
        //print_r($part);
        //print_r(self::$seo_info);
        if(isset(self::$seo_info['title']) && self::$seo_info['title']){
            $part['title'] = self::$seo_info['title'];
        }
        if((is_home()||is_front_page()) && isset($part['tagline'])){
            unset($part['tagline']);
        }

        return $part;
    }

    public static function wp_head_seo(){
        if(isset(self::$seo_info['kw']) && self::$seo_info['kw']){
            echo sprintf('<meta name="keywords" content="%s" />'."\n",self::$seo_info['kw']);
        }
        if(isset(self::$seo_info['desc']) && self::$seo_info['desc']){
            echo sprintf('<meta name="description" content="%s" />'."\n",self::$seo_info['desc']);
        }

    }

    public static function theme_has_title()
    {
        $dir = get_template_directory();

        $key = 'wb_sst_'.md5($dir);
        $val = get_option($key,null);
        if(null !== $val){
            return $val;
        }
        $val = 0;
        $header_file = $dir.'/header.php';
        if(file_exists($header_file)){
            $content = file_get_contents($header_file);
            if(preg_match('#<title>.+?</title>#is',$content)){
                $val = 1;
            }
        }
        update_option($key,$val,true);

        return $val;
    }

    public static function template_redirect(){

        $info = self::seo_info();
        self::$seo_info = $info;
        //print_r($info);

        //7b2
        if(function_exists('zrz_seo_head_meta')){
            remove_action('wp_head','zrz_seo_head_meta');
            remove_filter("document_title_parts", "zrz_seo_document_title");
        }

        if($info['title']){

            add_filter('document_title_parts',array(__CLASS__,'document_title_parts'));
            if(self::theme_has_title()){
                add_filter('wp_title',array(__CLASS__,'wp_title'),100,3);
                //dux
                if(defined('THEME_VERSION') && function_exists('_title')){
                    $GLOBALS['new_title'] = str_replace('&#8211;','-',wp_get_document_title());
                }
            }else if(current_theme_supports( 'title-tag' )){
                remove_action('wp_head','_wp_render_title_tag',1);
                add_action('wp_head',array(__CLASS__,'render_title_tag'),1);
            } else {
                add_action('wp_head',array(__CLASS__,'render_title_tag'),1);
            }

        }

        if($info['kw'] || $info['desc']){
            add_action('wp_head',array(__CLASS__,'wp_head_seo') , 1);
        }


    }



    public static function term_category()
    {
        global $wp_query,$wp_taxonomies;


        if(!$wp_taxonomies){
            return array();
        }
        $ret = array();
        //print_r($wp_taxonomies);
        foreach($wp_taxonomies as $taxonomy){

            if(!$taxonomy->public || !$taxonomy->hierarchical || !preg_match('#categor#',$taxonomy->meta_box_cb) ){//
                continue;
            }
            //print_r($taxonomy);
            $ret[] = $taxonomy;
        }
        return $ret;
    }
    public static function is_tag()
    {
        global $wp_query,$wp_taxonomies;
        if(is_tag()){
            return true;
        }
        $object = get_queried_object();

        if(!$object || !($object instanceof WP_Term)){
            return false;
        }
        if(!$wp_taxonomies || !isset($wp_taxonomies[$object->taxonomy])){
            return false;
        }
        $taxonomy = $wp_taxonomies[$object->taxonomy];
        if(!$taxonomy->hierarchical && preg_match('#tag#',$taxonomy->meta_box_cb)){
            return true;
        }
        return false;
    }
    public static function seo_info(){

        $title = '';//wp_get_document_title();
        $kw = $desc = '';
        //$tpls = array('<title>%s</title>', '%s', '%s');
        if (is_home() || is_front_page()) {

            $mata = self::cnf('index',array('','',''));
            //print_r($mata);
            if (isset($mata[0]) && $mata[0]) {
                //$title = self::formatTitle($mata[0]);
                $title = $mata[0];
            }
            if (isset($mata[1]) && $mata[1]) {
                //$tpls[1] = '<meta name="keywords" content="%s" />';
                $kw = $mata[1];
            }
            if (isset($mata[2]) && $mata[2]) {
                //$tpls[2] = '<meta name="description" content="%s" />';
                $desc = $mata[2];
            }

        } else if(is_author()){

            /* 标题: 「{author_name}」作者主页 - {sitename}
               关键词: 读取该作者所有文章Top5热门关键词，以英文逗号分隔
               描述:  「{author_name}」作者主页， 「{author_name}」主要负责{该作者所有文章Top5热门关键词（以顿号分割）}等内容发布。
               注：{author_name}指作者昵称
             */

            global $authordata,$wpdb;

            //$sep = apply_filters('document_title_separator', '-');
            //$title = implode($sep, array('「'.get_the_author().'」作者主页', get_bloginfo('name', 'display')));
            //$title = self::formatTitle($title);
            $title = '「'.get_the_author().'」作者主页';

            if(is_object($authordata)){

                $top_words = get_user_meta($authordata->ID,'seo_top_keywords',true);
                $time = current_time('timestamp');
                if(!$top_words || $top_words['time']<$time){

                    $sql = "SELECT c.`term_taxonomy_id`,c.term_id,COUNT(1) num FROM $wpdb->posts a,$wpdb->term_relationships r,$wpdb->term_taxonomy c ";
                    $sql .= " WHERE a.post_author=%d AND a.post_status='publish' AND a.post_type='post' AND a.ID=r.object_id AND r.term_taxonomy_id=c.term_taxonomy_id AND c.taxonomy='post_tag'";
                    $sql .= " GROUP BY c.`term_taxonomy_id` ORDER by num DESC LIMIT 5";

                    $sql = "SELECT t.name from $wpdb->terms t,($sql) tt WHERE t.term_id=tt.term_id";

                    $sql = $wpdb->prepare($sql,$authordata->ID);

                    $col = $wpdb->get_col($sql);

                    $top_words = array('time'=>$time + WEEK_IN_SECONDS,'keywords'=>$col);
                    update_user_meta($authordata->ID,'seo_top_keywords',$top_words);
                }

                if($top_words['keywords']){
                    //$tpls[1] = '<meta name="keywords" content="%s" />';
                    $kw = implode(',',$top_words['keywords']);
                    //$tpls[2] = '<meta name="description" content="%s" />';
                    $desc = '「'.get_the_author().'」作者主页，主要负责'.implode('、',$top_words['keywords']).'等内容发布。';
                }

            }




        } else if(is_search()){

            //$q = get_queried_object();
            //print_r($q);
            global $wp_query,$wpdb;
            /*
            标题: 与「{search_keyword}」匹配搜索结果 - {sitename}
            关键词: {search_keyword}, {search_keyword}相关, {search_keyword}内容, 搜索结果所有文章Top5热门关键词
            描述: 当前页面展示所有与「{search_keyword}」相关的匹配结果，包括搜索结果文章Top5关键词（以顿号分割）等内容。
            注：{search_keyword}指访客搜索关键词
            */
            //$sep = apply_filters('document_title_separator', '-');
            $q_kw = get_search_query(false);
            //$title = implode($sep, array('与「'.$q_kw.'」匹配的搜索结果', get_bloginfo('name', 'display')));
            //$title = self::formatTitle($title);
            $title = '与「'.$q_kw.'」匹配的搜索结果';

            $kws = array($q_kw,$q_kw.'相关',$q_kw.'内容');//array_merge(,$top_words['keywords']);
            //$tpls[1] = '<meta name="keywords" content="%s" />';
            $kw = implode(',',$kws);
            //$tpls[2] = '<meta name="description" content="%s" />';
            $desc = '当前页面展示所有与「'.$q_kw.'」搜索词相匹配的结果';//.implode('、',$top_words['keywords']);

            if($wp_query->found_posts){
                $post_ids = array();
                foreach ($wp_query->posts as $p){
                    $post_ids[] = $p->ID;
                }
                //print_r($wp_query);

                $post_ids = implode(',',$post_ids);

                $sql = "SELECT tt.term_id,tt.term_taxonomy_id,count(1) num FROM $wpdb->term_relationships r , $wpdb->term_taxonomy tt,$wpdb->terms t where r.object_id IN($post_ids) AND r.term_taxonomy_id=tt.term_taxonomy_id AND tt.taxonomy<>'category' group by tt.term_taxonomy_id order by num DESC LIMIT 5";

                $sql = "SELECT t.name FROM $wpdb->terms t ,($sql) tmp where  tmp.term_id=t.term_id ";


                //echo $sql;
                $col = $wpdb->get_col($sql);
                if($col){

                    $kw .= ','.implode(',',$col);
                    $desc .= ',包括'.implode('、',$col).'等内容。';
                }

            }




        } else if(self::is_tag()){

            $tag = get_queried_object();
            //print_r($tag);
            global $wpdb;
            //print_r($tag);
            /* 标题: 「{tag}」相关文章列表 - 站点名称
             关键词: {tag}, {tag}相关, {tag}内容及标签结果文章Top5关键词
             描述: 关于「{tag}」相关内容全站索引列表，包括标签列表页所有结果Top5关键词（以顿号分割）。
             注：{tag}指文章编辑时输入的标签词语*/


            //$sep = apply_filters('document_title_separator', '-');
            //$title = implode($sep, array('「'.$tag->name.'」相关文章列表', get_bloginfo('name', 'display')));
            //$title = self::formatTitle($title);

            $title = '「'.$tag->name.'」相关文章列表';

            $top_words = get_term_meta($tag->term_id,'seo_top_keywords',true);
            $time = current_time('timestamp');
            if(!$top_words || $top_words['time']<$time){


                //tag 下的所有文章
                $sql = "SELECT p.ID  FROM $wpdb->term_relationships r ,$wpdb->posts p WHERE r.term_taxonomy_id = %d and  r.object_id=p.ID AND p.post_status='publish'";

                //所有文章下的tag，取数量前五
                $sql = "SELECT tt.term_taxonomy_id,tt.term_id,COUNT(1) FROM $wpdb->term_taxonomy tt ,$wpdb->term_relationships rr ,$wpdb->posts pp WHERE tt.term_taxonomy_id=rr.term_taxonomy_id  AND tt.taxonomy<>'category' AND rr.object_id=pp.ID AND pp.ID IN($sql)";
                $sql .= " GROUP BY tt.term_taxonomy_id ORDER BY tt.count DESC LIMIT 5";


                $sql = "SELECT t.name FROM $wpdb->terms t,($sql) tmp WHERE t.term_id=tmp.term_id";

                $sql = $wpdb->prepare($sql,$tag->term_taxonomy_id);

                //echo $sql;exit();
                $col = $wpdb->get_col($sql);

                $top_words = array('time'=>$time + WEEK_IN_SECONDS,'keywords'=>$col);
                update_term_meta($tag->term_id,'seo_top_keywords',$top_words);
            }

            if($top_words['keywords']){
                $kws = array_merge(array($tag->name,$tag->name.'相关',$tag->name.'内容'),$top_words['keywords']);
                //$tpls[1] = '<meta name="keywords" content="%s" />';
                $kw = implode(',',$kws);
                //$tpls[2] = '<meta name="description" content="%s" />';
                $desc = '关于「'.$tag->name.'」相关内容全站索引列表，包括'.implode('、',$top_words['keywords']).'。';
            }

        } else if (is_category() || is_archive()) {
            $term = get_queried_object();
            //print_r($term);
            $mata = array('', '', '');
            if($term instanceof WP_Post_Type){
                global $wp_taxonomies;
                foreach($wp_taxonomies as $taxonomy){
                    //print_r($taxonomy);
                    if($taxonomy->public && $taxonomy->hierarchical && preg_match('#categor#',$taxonomy->meta_box_cb)){
                        if($taxonomy->object_type && in_array($term->name,$taxonomy->object_type)){
                            $mata = self::cnf($taxonomy->name.'_index', array('', '', ''));
                            break;
                        }
                    }
                }

            }else if($term instanceof WP_Term){
                $cid = $term->term_id;
                $mata = self::cnf($cid, array('', '', ''));
            }else if($term instanceof WP_Taxonomy){
                $mata = self::cnf($term->name.'_index', array('', '', ''));
            }
            //print_r($mata);


            if (isset($mata[0]) && $mata[0]) {
                //$sep = apply_filters('document_title_separator', '-');
                //$title = implode($sep, array($mata[0], get_bloginfo('name', 'display')));
                //$title = self::formatTitle($title);
                $title = $mata[0];
            }
            if (isset($mata[1]) && $mata[1]) {
                //$tpls[1] = '<meta name="keywords" content="%s" />';
                $kw = $mata[1];
            }
            if (isset($mata[2]) && $mata[2]) {
                //$tpls[2] = '<meta name="description" content="%s" />';
                $desc = $mata[2];
            }
        } else if (is_single() || is_page() || is_singular()) {

            do{
                //$title = get_the_title();
                $post = get_queried_object();
                if(!($post instanceof WP_Post)){
                    break;
                }

                $seo_meta = get_post_meta($post->ID,'wb_sst_seo',true);
                if(!$seo_meta || !is_array($seo_meta)){
                    $seo_meta = array(0=>'',1=>'',2=>'');
                }


                if($seo_meta[0]){
                    $title = $seo_meta[0];
                }else{
                    $title = $post->post_title;
                }

                if($seo_meta[1]){
                    $kw = $seo_meta[1];
                }else{
                    //print_r(get_taxonomy( 'category' ));
                    //$post = get_post( $post );

                    //print_r([$post->post_type]);
                    //global $wp_taxonomies;
                    //print_r($wp_taxonomies);
                    $posttags = array();
                    if($post->post_type == 'post'){
                        $posttags = get_the_terms( $post->ID, 'post_tag' );
                    }else if($post->post_type == 'page'){
                        $posttags = array();
                    }else{
                        $taxonomies = get_object_taxonomies($post->post_type,'object');
                        //print_r($taxonomies);
                        foreach($taxonomies as $object){
                            if(!$object->hierarchical && $object->public && preg_match('#tag#',$object->meta_box_cb)){
                                $posttags = get_the_terms($post->ID,$object->name);
                                break;
                            }
                        }
                    }

                    //kw
                    if ($posttags) {
                        $tags = array();
                        foreach ($posttags as $tag) {
                            $tags[] = $tag->name;
                        }
                        $stags = implode(',', $tags);
                        $kw = $stags;
                        //$tpls[1] = '<meta name="keywords" content="%s" />';
                    }
                }



                if($seo_meta[2]){
                    $desc = $seo_meta[2];
                }else{
                    //desc
                    $excerpt = self::excerpt($post);
                    if ($excerpt) {
                        $desc = $excerpt;
                        //$tpls[2] = '<meta name="description" content="%s" />';
                    }
                }


            }while(0);


        }

        return array('title'=>$title,'kw'=>$kw,'desc'=>$desc);
        //echo sprintf(implode("\n", $tpls), $title, $kw, $desc);
    }
    //seo title, keywords, description
    public static function seoTitle()
    {
        $title = wp_get_document_title();
        $kw = $desc = '';
        $tpls = array('<title>%s</title>', '%s', '%s');
        //$seo = $this->opt('seo');
        if (is_home()) {
            $mata = self::cnf('index',array('','',''));
            if (isset($mata[0]) && $mata[0]) {
                $title = self::formatTitle($mata[0]);
            }
            if (isset($mata[1]) && $mata[1]) {
                $tpls[1] = '<meta name="keywords" content="%s" />';
                $kw = $mata[1];
            }
            if (isset($mata[2]) && $mata[2]) {
                $tpls[2] = '<meta name="description" content="%s" />';
                $desc = $mata[2];
            }

        } else if(is_author()){

           /* 标题: 「{author_name}」作者主页 - {sitename}
              关键词: 读取该作者所有文章Top5热门关键词，以英文逗号分隔
              描述:  「{author_name}」作者主页， 「{author_name}」主要负责{该作者所有文章Top5热门关键词（以顿号分割）}等内容发布。
			  注：{author_name}指作者昵称
            */

            global $authordata,$wpdb;

            $sep = apply_filters('document_title_separator', '-');
            $title = implode($sep, array('「'.get_the_author().'」作者主页', get_bloginfo('name', 'display')));
            //$title = self::formatTitle($title);

            if(is_object($authordata)){

                $top_words = get_user_meta($authordata->ID,'seo_top_keywords',true);
                $time = current_time('timestamp');
                if(!$top_words || $top_words['time']<$time){

                    $sql = "SELECT c.`term_taxonomy_id`,c.term_id,COUNT(1) num FROM $wpdb->posts a,$wpdb->term_relationships r,$wpdb->term_taxonomy c ";
                    $sql .= " WHERE a.post_author=%d AND a.post_status='publish' AND a.post_type='post' AND a.ID=r.object_id AND r.term_taxonomy_id=c.term_taxonomy_id AND c.taxonomy='post_tag'";
                    $sql .= " GROUP BY c.`term_taxonomy_id` ORDER by num DESC LIMIT 5";

                    $sql = "SELECT t.name from $wpdb->terms t,($sql) tt WHERE t.term_id=tt.term_id";

                    $sql = $wpdb->prepare($sql,$authordata->ID);

                    $col = $wpdb->get_col($sql);

                    $top_words = array('time'=>$time + WEEK_IN_SECONDS,'keywords'=>$col);
                    update_user_meta($authordata->ID,'seo_top_keywords',$top_words);
                }

                if($top_words['keywords']){
                    $tpls[1] = '<meta name="keywords" content="%s" />';
                    $kw = implode(',',$top_words['keywords']);
                    $tpls[2] = '<meta name="description" content="%s" />';
                    $desc = '「'.get_the_author().'」作者主页，主要负责'.implode('、',$top_words['keywords']).'等内容发布。';
                }

            }




        } else if(is_search()){

            //$q = get_queried_object();
            //print_r($q);
            global $wp_query,$wpdb;
            /*
            标题: 与「{search_keyword}」匹配搜索结果 - {sitename}
            关键词: {search_keyword}, {search_keyword}相关, {search_keyword}内容, 搜索结果所有文章Top5热门关键词
            描述: 当前页面展示所有与「{search_keyword}」相关的匹配结果，包括搜索结果文章Top5关键词（以顿号分割）等内容。
            注：{search_keyword}指访客搜索关键词
            */
            $sep = apply_filters('document_title_separator', '-');
            $q_kw = get_search_query(false);
            $title = implode($sep, array('与「'.$q_kw.'」匹配的搜索结果', get_bloginfo('name', 'display')));
            //$title = self::formatTitle($title);

            $kws = array($q_kw,$q_kw.'相关',$q_kw.'内容');//array_merge(,$top_words['keywords']);
            $tpls[1] = '<meta name="keywords" content="%s" />';
            $kw = implode(',',$kws);
            $tpls[2] = '<meta name="description" content="%s" />';
            $desc = '当前页面展示所有与「'.$q_kw.'」搜索词相匹配的结果';//.implode('、',$top_words['keywords']);

            if($wp_query->found_posts){
                $post_ids = array();
                foreach ($wp_query->posts as $p){
                    $post_ids[] = $p->ID;
                }
                //print_r($wp_query);

                $post_ids = implode(',',$post_ids);

                $sql = "SELECT tt.term_id,tt.term_taxonomy_id,count(1) num FROM $wpdb->term_relationships r , $wpdb->term_taxonomy tt,$wpdb->terms t where r.object_id IN($post_ids) AND r.term_taxonomy_id=tt.term_taxonomy_id AND tt.taxonomy<>'category' group by tt.term_taxonomy_id order by num DESC LIMIT 5";

                $sql = "SELECT t.name FROM $wpdb->terms t ,($sql) tmp where  tmp.term_id=t.term_id ";


                //echo $sql;
                $col = $wpdb->get_col($sql);
                if($col){

                    $kw .= ','.implode(',',$col);
                    $desc .= ',包括'.implode('、',$col).'等内容。';
                }

            }




        } else if(is_tag()){

            $tag = get_queried_object();

            global $wpdb;
            //print_r($tag);
           /* 标题: 「{tag}」相关文章列表 - 站点名称
            关键词: {tag}, {tag}相关, {tag}内容及标签结果文章Top5关键词
            描述: 关于「{tag}」相关内容全站索引列表，包括标签列表页所有结果Top5关键词（以顿号分割）。
            注：{tag}指文章编辑时输入的标签词语*/


            $sep = apply_filters('document_title_separator', '-');
            $title = implode($sep, array('「'.$tag->name.'」相关文章列表', get_bloginfo('name', 'display')));
            //$title = self::formatTitle($title);

            $top_words = get_term_meta($tag->term_id,'seo_top_keywords',true);
            $time = current_time('timestamp');
            if(!$top_words || $top_words['time']<$time){


                //tag 下的所有文章
                $sql = "SELECT p.ID  FROM $wpdb->term_relationships r ,$wpdb->posts p WHERE r.term_taxonomy_id = %d and  r.object_id=p.ID AND p.post_status='publish'";

                //所有文章下的tag，取数量前五
                $sql = "SELECT tt.term_taxonomy_id,tt.term_id,COUNT(1) FROM $wpdb->term_taxonomy tt ,$wpdb->term_relationships rr ,$wpdb->posts pp WHERE tt.term_taxonomy_id=rr.term_taxonomy_id  AND tt.taxonomy<>'category' AND rr.object_id=pp.ID AND pp.ID IN($sql)";
                $sql .= " GROUP BY tt.term_taxonomy_id ORDER BY tt.count DESC LIMIT 5";


                $sql = "SELECT t.name FROM $wpdb->terms t,($sql) tmp WHERE t.term_id=tmp.term_id";

                $sql = $wpdb->prepare($sql,$tag->term_taxonomy_id);

                //echo $sql;exit();
                $col = $wpdb->get_col($sql);

                $top_words = array('time'=>$time + WEEK_IN_SECONDS,'keywords'=>$col);
                update_term_meta($tag->term_id,'seo_top_keywords',$top_words);
            }

            if($top_words['keywords']){
                $kws = array_merge(array($tag->name,$tag->name.'相关',$tag->name.'内容'),$top_words['keywords']);
                $tpls[1] = '<meta name="keywords" content="%s" />';
                $kw = implode(',',$kws);
                $tpls[2] = '<meta name="description" content="%s" />';
                $desc = '关于「'.$tag->name.'」相关内容全站索引列表，包括'.implode('、',$top_words['keywords']).'。';
            }

        } else if (is_category()) {
            $term = get_queried_object();
            $cid = $term->term_id;
            $mata = self::cnf($cid, array('', '', ''));
            if (isset($mata[0]) && $mata[0]) {
                $sep = apply_filters('document_title_separator', '-');
                $title = implode($sep, array($mata[0], get_bloginfo('name', 'display')));
                $title = self::formatTitle($title);
            }
            if (isset($mata[1]) && $mata[1]) {
                $tpls[1] = '<meta name="keywords" content="%s" />';
                $kw = $mata[1];
            }
            if (isset($mata[2]) && $mata[2]) {
                $tpls[2] = '<meta name="description" content="%s" />';
                $desc = $mata[2];
            }
        } else if (is_single() || is_page()) {


            //kw
            $posttags = get_the_tags();

            if ($posttags) {
                $tags = array();
                foreach ($posttags as $tag) {
                    $tags[] = $tag->name;
                }
                $stags = implode(',', $tags);
                $kw = $stags;
                $tpls[1] = '<meta name="keywords" content="%s" />';
            }
            //desc
	        $excerpt = self::excerpt();

            if ($excerpt) {
                $desc = $excerpt;
                $tpls[2] = '<meta name="description" content="%s" />';
            }

        }
        echo sprintf(implode("\n", $tpls), $title, $kw, $desc);
    }

    //格式化标题
    public static function formatTitle($title)
    {
        $title = wptexturize($title);
        $title = convert_chars($title);
        $title = esc_html($title);
        $title = capital_P_dangit($title);
        return $title;
    }

    //文章摘要
    public static function excerpt($post = null)
    {
        if(!$post){
            $post = get_post();
        }
        if (empty($post)) {
            return '';
        }

	    $excerpt = $post->post_excerpt ? $post->post_excerpt : self::trimContent($post->post_content);
        if (!$excerpt) return $excerpt;
        return apply_filters('get_the_excerpt', $excerpt, $post);
    }

    //格式化文章内容
    public static function trimContent($text)
    {
        $text = strip_shortcodes($text);
        $excerpt_length = 120;//apply_filters('excerpt_length', 120);
        $text = wp_trim_words($text, $excerpt_length, '');
        return $text;
    }



    public static function plugin_row_meta($links,$file){

        $base = plugin_basename(SMART_SEO_TOOL_BASE_FILE);
        if($file == $base) {
            $links[] = '<a href="https://www.wbolt.com/plugins/sst">插件主页</a>';
            $links[] = '<a href="https://www.wbolt.com/sst-plugin-documentation.html">FAQ</a>';
            $links[] = '<a href="https://wordpress.org/support/plugin/smart-seo-tool/">反馈</a>';
        }
        return $links;
    }

    function actionLinks( $links, $file ) {

        if ( $file != plugin_basename(SMART_SEO_TOOL_BASE_FILE) )
            return $links;

        $settings_link = '<a href="'.menu_page_url( self::$name, false ).'">设置</a>';

        array_unshift( $links, $settings_link );

        return $links;
    }

    function admin_menu(){
        global $wb_settings_page_hook_bwbs;
        $wb_settings_page_hook_bwbs = add_options_page(
            'Smart SEO Tool',
            'Smart SEO Tool',
            'manage_options',
            self::$name,
            array($this,'admin_settings')
        );
    }

    function admin_settings(){


        global $wpdb;

        $setting_field = self::$optionName;
        $opt = self::opt();

        if(defined('WB_CORE_ASSETS_LOAD') && class_exists('WB_Core_Asset_Load')){
            WB_Core_Asset_Load::load('setting-03');
        }else{
            wp_enqueue_script('wbp-js', plugin_dir_url(SMART_SEO_TOOL_BASE_FILE) . 'assets/wbp_setting.js', array(), SMART_SEO_TOOL_VERSION, true);
        }

        $software = $_SERVER['SERVER_SOFTWARE'];
        if(preg_match('#apache#i',$software)){
            $software = 'Apache';
        }else{
            $software = 'Nginx';
        }

        global $wp_rewrite;
        $is_rewrite = false;
        if($wp_rewrite && is_object($wp_rewrite)){
            $is_rewrite = $wp_rewrite->using_permalinks();
        }


        include_once( SMART_SEO_TOOL_PATH.'/settings.php' );
    }


    function admin_init(){
        if(get_option(self::$optionName.'_rewrite',0)){
            self::flush_rewrite();
            update_option(self::$optionName.'_rewrite',0);
        }
        register_setting(  self::$optionName,self::$optionName );
    }


    public static function activate_plugin(){

        self::flush_rewrite();

        self::setup_db();
    }

    public static function deactivate_plugin(){

        //delete_option(self::$optionName.'_rewrite');
        //delete_option(self::$optionName);
        Smart_SEO_Tool_Rewrite::remove_rewrite();
        Smart_SEO_Tool_Sitemap::remove_rewrite();

        self::flush_rewrite();
    }


    public static function setup_db(){

        global $wpdb;

        $db_ver = '1.0';
        $wb_tables = array('wb_sst_broken_url');

        //数据表
        $tables = $wpdb->get_col("SHOW TABLES LIKE '".$wpdb->prefix."wb_sst_%'");


        $set_up = array();
        foreach ($wb_tables as $table){
            if(in_array($wpdb->prefix.$table,$tables)){
                continue;
            }

            $set_up[] = $table;
        }

        if(empty($set_up)){
            if(!get_option('wb_sst_db_ver')){
                update_option('wb_sst_db_ver',$db_ver);
            }
            return;
        }

        $sql = file_get_contents(SMART_SEO_TOOL_PATH.'/install/init.sql');

        $charset_collate = $wpdb->get_charset_collate();



        $sql = str_replace('`wp_wb_','`'.$wpdb->prefix.'wb_',$sql);
        $sql = str_replace('ENGINE=InnoDB', $charset_collate , $sql);



        $sql_rows = explode('-- row split --',$sql);

        foreach($sql_rows as $row){

            if(preg_match('#`'.$wpdb->prefix.'(wb_sst_.*?)`\s+\(#',$row,$match)){
                if(in_array($match[1],$set_up)){
                    $wpdb->query($row);
                }
            }
            //print_r($row);exit();
        }

        update_option('wb_sst_db_ver',$db_ver);
    }

}