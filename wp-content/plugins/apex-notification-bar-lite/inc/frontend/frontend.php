<?php defined('ABSPATH') or die("No script kiddies please!");
 $random_num = rand(10000,99999);
 global $post, $wpdb;

 $edn_bar_data = Database_Class::get_bar_data();

 //APEXNBLite_Libary::displayArr( $edn_bar_data);

// check if bar is enable or not
$edn_enable = (isset($edn_bar_data['apexnblite_enable_bar']) && $edn_bar_data['apexnblite_enable_bar'] == 0)?'0':'1';
$disable_mobile_bar = (isset($edn_bar_data['apexnblite_enable_mobile']) && $edn_bar_data['apexnblite_enable_mobile'] == 0)?'0':'1';
$edn_notify_on_pages = (isset($edn_bar_data['edn_notify_on_pages']) && $edn_bar_data['edn_notify_on_pages'] != '')?esc_attr($edn_bar_data['edn_notify_on_pages']):'all_pages';// restriction show bar on all pages or specific pages or only home page.


if($edn_enable == 1){
	    if(!is_feed()){

$position = (isset($edn_bar_data['edn_position']) && $edn_bar_data['edn_position'] != '')?esc_attr($edn_bar_data['edn_position']):'top_absolute';
$visibility_type = (isset($edn_bar_data['edn_visibility']) && $edn_bar_data['edn_visibility'] != '')?esc_attr($edn_bar_data['edn_visibility']):'sticky';
$edn_close_button = (isset($edn_bar_data['edn_close_button']) && $edn_bar_data['edn_close_button'] != '')?esc_attr($edn_bar_data['edn_close_button']):'show-hide';
$cptype = (isset($edn_bar_data['edn_cp_type']) && $edn_bar_data['edn_cp_type'] != '')?esc_attr($edn_bar_data['edn_cp_type']):'';
$edn_bar_type = (isset($edn_bar_data['edn_bar_type']) && $edn_bar_data['edn_bar_type'] == 1)?'1':'2';
$edn_bar_template = (isset($edn_bar_data['edn_bar_template']) && $edn_bar_data['edn_bar_template'] != '')?esc_attr($edn_bar_data['edn_bar_template']):'1';
//custom design 
$edn_fonts = (isset($edn_bar_data['edn_fonts']) && $edn_bar_data['edn_fonts'] != '')?esc_attr($edn_bar_data['edn_fonts']):'Roboto';
$edn_social_optons = (isset($edn_bar_data['edn_social_optons']) && $edn_bar_data['edn_social_optons'] == 1)?'1':'0';
$edn_right_optons = (isset($edn_bar_data['edn_right_optons']) && $edn_bar_data['edn_right_optons'] == 1)?'1':'0';

     switch($cptype){
           case 'email-subs':
           $effect_id2 ="ednpro_opt_settings";
           $effect_id = 'ednpro_opt_settings';
           break;
             case 'search-form':
           $effect_id2 ="ednpro_searchform_settings";
           $effect_id = 'ednpro_searchform_settings';
           break;
           case 'text':
           if($edn_bar_data['edn_text_display_mode'] == 'static'){
             $effect_id2 ="ednpro_static";
             $effect_id = 'edn_pro_static';
           }else{
              if($edn_bar_data['edn_bar_effect_option']==1){
                $effect_id2 = 'ticker';
                $effect_id = 'ticker';
              }else if($edn_bar_data['edn_bar_effect_option']==2){
                $effect_id2 = 'slider';
                $effect_id = 'slider';
             }else{
                $effect_id2 = 'scroller';
                $effect_id = 'scroller';
             }
           }    
           break;
           case 'post-title':
               if($edn_bar_data['edn_bar_effect_option']==1){
                    $effect_id2 = 'ticker';
                    $effect_id = 'ticker';
                  }else if($edn_bar_data['edn_bar_effect_option']==2){
                    $effect_id2 = 'slider';
                     $effect_id = 'slider';
                 }else{
                    $effect_id2 = 'scroller';
                    $effect_id = 'scroller';
                 }
           break;
           default:
           $effect_id2 ="ednpro";
           $effect_id = 'ednpro';
           break;

        }

     if($edn_bar_type == 1){
     	//custom template
         $edn_bartype  = 'edn-custom-template';
         $pretemplate_classname = 'edn_custom_template';
     }else{
     	//pre available template
        $edn_bartype  = 'edn-pre-template';
        $pretemplate_classname = "edn_main_template".$edn_bar_template;
     }
     $nb_id = 0;
     $fonts =  esc_attr($edn_fonts);
     $fonts_final = str_replace(' ', '+', $fonts);
	 
	 $dstyle= !(isset($_COOKIE["cookie_set_time_".$nb_id]))?'':'style="display:none;"';

if($cptype != ''){
if($edn_notify_on_pages =="all_pages"){
	 $display_settings = "edn_display_bar";
     include( 'frontend-display.php' );
}else{
	 if(is_front_page()) {
	 	 $display_settings = "edn_display_bar";
         include( 'frontend-display.php' );
	 }
}
}

  } //is feed check
}//check if notification bar is enabled?