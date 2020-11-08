<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * Common Library Class
 * Class with all the necessary functions
 */
if ( !class_exists( 'APEXNBLite_Libary' ) ) {
   class APEXNBLite_Libary {
        /**
         * @param array $array
         */
        public static function displayArr( $array ) {
                echo "<pre>";
                print_r( $array );
                echo "</pre>";
        }

         /**
         * Get current categories  
         * */
         public static function get_bar_category_lists(){
            wp_reset_postdata();
            $categories = get_categories(array('hide_empty' => 0));
            // print_r($categories);
            $category_lists = array();
            if(count($categories) > 0){
                foreach($categories as $category) :
                    $category_lists[$category->cat_ID] = $category->name;
                endforeach;
                return $category_lists;
            }
         }
         
         /**
         * Get current taxonomy  
         * */
         public static function get_bar_taxonomy_lists(){
            wp_reset_postdata();
            $args = array('public'   => true,'_builtin' => false); 
            $output = 'objects';  //or objects
            $operator = 'and';  //'and' or 'or'
            $taxonomies = get_taxonomies($args,$output,$operator);
            $taxanomy_lists = array();
            if(count($taxonomies) > 0){
                  foreach($taxonomies as $taxonomy => $vlue) :
                   //  $taxanomy_lists[] = $vlue->labels->singular_name;
                   $taxanomy_lists[] = $taxonomy;
                endforeach;
                return $taxanomy_lists;
            }
         }
         
         /**
         * Get current post types  
         * */
         public static function get_bar_post_types(){
            wp_reset_postdata();
            $args = array('public'   => true,'_builtin' => false);
            $output = 'objects'; // names or objects, note names is the default
            $operator = 'and'; // 'and' or 'or'
            $post_types = get_post_types( $args, $output, $operator );
            $post_type_lists = array();
            if(count($post_types) > 0){
                foreach($post_types as $post_type) :
                    $post_type_lists[] = $post_type->labels->name;
                endforeach;
                return $post_type_lists;
            }
         }

       //returns all the registered post types only
        public static function apexnb_get_registered_post_types() {
           $post_types = get_post_types();
           unset($post_types['attachment']);
          // unset($post_types['product']);
           unset($post_types['product_variation']);
           unset($post_types['shop_order']);
           unset($post_types['shop_order_refund']);
           unset($post_types['shop_coupon']);
           unset($post_types['shop_webhook']);
           unset($post_types['wp1slider']);
           unset($post_types['revision']);
           unset($post_types['nav_menu_item']);
           unset($post_types['wp-types-group']);
           unset($post_types['wp-types-user-group']);
           unset($post_types['customize_changeset']);
           unset($post_types['wpcf7_contact_form']);
           unset($post_types['custom_css']);
           unset($post_types['page']);
            unset($post_types['post_tag']);
           return $post_types;
       }


	}

	//class termination
}//class exists check