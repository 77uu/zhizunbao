<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if ( ! class_exists( 'Database_Class' ) ) :
/**
 * Database Based Class
 */
class Database_Class {

            /**
           * Get Default Notification Bar Settings
           * */
          public static function get_bar_data(){
            $apexnb_bar_data = get_option('apexnb_lite_settings');
            return $apexnb_bar_data;
           }


}
$global['database_class'] = new Database_Class();
endif;