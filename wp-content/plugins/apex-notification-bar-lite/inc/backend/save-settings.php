<?php defined('ABSPATH') or die("No script kiddies please!");
/**
 * Posted Data
 * 
 */

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
$apexnb_lite_settings =  $this->apexnb_lite_settings;
$_POST = array_map( 'stripslashes_deep', $_POST );
foreach($_POST as $key=>$val)
{
    if($key=='icons' || $key=='edn_multiple'  || $key=='edn_static' || $key=='edn_subs_custom' 
    || $key=='edn_recentposts'   || $key == 'edn_search_form' || $key=='edn_ticker' || $key=='edn_slider' || $key=='edn_multi' || $key=='edn_scroll')
    {
         $$key = $val;  
    }
    else
    {
        $$key = sanitize_text_field($val);              
    }

}


if(isset($icons)){
    foreach($icons as $key=>$val)
    {
        $icon_detail_array = array();
        foreach($val as $k=>$v)
        {
            if($k=='image' || $k=='link')
            {
                $icon_detail_array[$k] = esc_url($v);
            }
            else
            {
                $icon_detail_array[$k] = sanitize_text_field($v);
            }
        }
    $icons[$key] = $icon_detail_array;
    }
}else{
    $icons = array();
}


$apexnb_lite_settings['apexnblite_enable_bar']  = (isset($_POST['apexnblite_enable_bar']) && $_POST['apexnblite_enable_bar'] == 1)?'1':'0';
$apexnb_lite_settings['apexnblite_enable_mobile']  = (isset($_POST['apexnblite_enable_mobile']) && $_POST['apexnblite_enable_mobile'] == 1)?'1':'0';
$apexnb_lite_settings['edn_position']  = (isset($_POST['edn_position']) && $_POST['edn_position'] != '')?sanitize_text_field($_POST['edn_position']):'top';
$apexnb_lite_settings['edn_notify_on_pages']  = (isset($_POST['edn_notify_on_pages']) && $_POST['edn_notify_on_pages'] != '')?sanitize_text_field($_POST['edn_notify_on_pages']):'all_pages';

$apexnb_lite_settings['edn_cp_type']  = (isset($_POST['edn_cp_type']) && $_POST['edn_cp_type'] != '')?sanitize_text_field($_POST['edn_cp_type']):'text';

$apexnb_lite_settings['edn_text_display_mode']  = (isset($_POST['edn_text_display_mode']) && $_POST['edn_text_display_mode'] != '')?sanitize_text_field($_POST['edn_text_display_mode']):'static';

$edn_bar_type  = (isset($_POST['edn_bar_type']) && $_POST['edn_bar_type'] == '1')?'1':'2'; //pre available:2 and custom :1

if(isset($edn_bar_template)){
    $apexnb_lite_settings['edn_bar_template'] = sanitize_text_field($edn_bar_template);
}else{
    $apexnb_lite_settings['edn_bar_template'] = '1';
}


if($edn_bar_type  == 1){
    //custom design
    $apexnb_lite_settings['edn_bar_type'] = 1;
    $apexnb_lite_settings['edn_bar_design'] = 'custom';
}else{
    //pre avilable
     $apexnb_lite_settings['edn_bar_type'] = 2;
     $apexnb_lite_settings['edn_bar_design'] = 'preavailable';
}


if($apexnb_lite_settings['edn_cp_type'] == "social-icons"){
    $apexnb_lite_settings['edn_social_optons'] = 1;
    $apexnb_lite_settings['edn_right_optons'] = 0;
}else{
    $apexnb_lite_settings['edn_right_optons']  = 1;
    $apexnb_lite_settings['edn_social_optons'] = 0;
}


if(isset($edn_static)){
    $allowed_html = wp_kses_allowed_html( 'post' );
    $apexnb_lite_settings['edn_static'] = $edn_static;
    $apexnb_lite_settings['edn_static']['text']   = wp_kses($edn_static['text'],$allowed_html);
    $apexnb_lite_settings['edn_static']['but_url']   = sanitize_text_field($edn_static['but_url']);
    $apexnb_lite_settings['edn_static']['form_shortcode']   = sanitize_text_field($edn_static['form_shortcode']);
}else{
    $apexnb_lite_settings['edn_static'] = array();
}


 if ( isset( $_POST[ 'edn_multiple' ] ) ) {
               $edn_multiple = ( array ) $_POST[ 'edn_multiple' ];
               $val = APEXNBL_Class::sanitize_array( $edn_multiple );
               $apexnb_lite_settings['edn_multiple'] = $val;
}


/* update data for custom form */
$apexnb_lite_settings['edn_subs_choose']  = (isset($_POST['edn_subs_choose']) && $_POST['edn_subs_choose'] != '')?sanitize_text_field($_POST['edn_subs_choose']):'';

$confirmation_name = get_bloginfo('name');
$confirmation_name1 = sanitize_text_field($edn_subs_custom['from_name']);
$custom_confirmation_name = (isset($edn_subs_custom['from_name']) && $edn_subs_custom['from_name'] != '')?sanitize_text_field($confirmation_name1):$confirmation_name;

//$confirmation_email = $noreply;
$confirmation_email1 = sanitize_text_field($edn_subs_custom['from_email']);
$custom_confirmation_email = (isset($edn_subs_custom['from_email']) && $edn_subs_custom['from_email'] != '')?sanitize_text_field($confirmation_email1):'';

$confirmation = 0;
$confirmation1 = (isset($edn_subs_custom['confirm']))?sanitize_text_field($edn_subs_custom['confirm']):'';
$custom_confirm = (isset($edn_subs_custom['confirm']) && $edn_subs_custom['confirm'] != '')?$confirmation1:$confirmation;

//$email_subject1 = '';
//$email_subject = (isset($edn_subs_custom['email_subject']))?sanitize_text_field($edn_subs_custom['email_subject']):'';
//$custom_email_subject = (isset($edn_subs_custom['email_subject']) && $edn_subs_custom['email_subject'] != '')?sanitize_text_field($email_subject):sanitize_text_field($email_subject1);

//$email_message1 = '';
//$email_message = (isset($edn_subs_custom['message']))?wp_kses_post($edn_subs_custom['message']):'';
//$custom_email_message = (isset($edn_subs_custom['message']) && $edn_subs_custom['message'] != '')?stripcslashes(sanitize_text_field($email_message)):stripcslashes(sanitize_text_field($email_message1));

$edn_subs_custom = array(
            'head_text'                     => sanitize_text_field($edn_subs_custom['head_text']),
            'but_text'                      => sanitize_text_field($edn_subs_custom['but_text']),
            'description'                   => sanitize_text_field($edn_subs_custom['description']),
            'but_email_placeholder'         => sanitize_text_field($edn_subs_custom['but_email_placeholder']),
            'but_email_error_message'       => sanitize_text_field($edn_subs_custom['but_email_err']),
            'but_already_subs'              => sanitize_text_field($edn_subs_custom['but_already_subs']),
            'but_check_to_conform'          => sanitize_text_field($edn_subs_custom['but_check_to_conform']),
            'but_sending_fail'              => sanitize_text_field($edn_subs_custom['but_sending_fail']),
            'email_subject'                 => sanitize_text_field($edn_subs_custom['thank_text']),
            'confirm'                       => $custom_confirm,
            'thank_text'                    => ((isset($edn_subs_custom['thank_text']) && $edn_subs_custom['thank_text'] != '')?sanitize_text_field($edn_subs_custom['thank_text']):''),
            'from_name'                     => $custom_confirmation_name,
            'from_email'                    => $custom_confirmation_email,
            //'email_subject'                 => $custom_email_subject,
            //'message'                       => $custom_email_message
            );
$apexnb_lite_settings['edn_subs_custom'] = $edn_subs_custom;
/* update data for custom form */

$apexnb_lite_settings['edn_recentposts']       = $edn_recentposts;
$apexnb_lite_settings['edn_search_form']       = $edn_search_form;

if(isset($edn_social_heading_text)){
    $apexnb_lite_settings['edn_social_heading_text'] = sanitize_text_field($edn_social_heading_text);
}else{
    $apexnb_lite_settings['edn_social_heading_text'] = '';
}
$apexnb_lite_settings['icon_details']               = $icons;

//bar effect type as slider, scroller or ticker
$apexnb_lite_settings['edn_bar_effect_option'] = $edn_bar_effect_option;
$edn_ticker = array(
            'title_text'                     => sanitize_text_field($_POST['edn_ticker']['title_text']),
            'speed'                      => sanitize_text_field($_POST['edn_ticker']['speed']),
            'direction'                   => sanitize_text_field($_POST['edn_ticker']['direction'])
            );

$apexnb_lite_settings['edn_ticker']            = $edn_ticker;
$apexnb_lite_settings['edn_slider']            = $edn_slider;
$apexnb_lite_settings['edn_scroll']            = $edn_scroll;

//visibility type data
$apexnb_lite_settings['edn_visibility'] = sanitize_text_field($edn_visibility); // Always show , Show After some time, Hide after some time
$apexnb_lite_settings['edn_show_duration'] = sanitize_text_field($edn_visibility_show_duration); // show time duration
$apexnb_lite_settings['edn_hide_duration'] = sanitize_text_field($edn_visibility_hide_duration); //hide time duration
$apexnb_lite_settings['edn_close_button'] = sanitize_text_field($edn_close_button);  //disable,show-hide,user-can-close

$apexnb_lite_settings['show_once']              = (isset($show_once))?sanitize_text_field($show_once):'';
$apexnb_lite_settings['duration_show_once']     = sanitize_text_field($duration_show_once); 

$apexnb_lite_settings['show_once_hideshow']     = (isset($show_once_hideshow))?sanitize_text_field($show_once_hideshow):''; 

//custom desgin
//bar bg color
$apexnb_lite_settings['edn_bg_color']          = sanitize_text_field($edn_bg_color);
$apexnb_lite_settings['edn_font_color']        = sanitize_text_field($edn_font_color);
$apexnb_lite_settings['edn_fonts']             = sanitize_text_field($edn_fonts);
$apexnb_lite_settings['edn_font_size']         = sanitize_text_field($edn_font_size);
//bar button bg color
$apexnb_lite_settings['cf_bg_color']           = sanitize_text_field($cf_bg_color);
$apexnb_lite_settings['cf_font_color']         = sanitize_text_field($cf_font_color);
$apexnb_lite_settings['cf_hover_bg_color']     = sanitize_text_field($cf_hover_bg_color);
$apexnb_lite_settings['cf_hover_font_color']   = sanitize_text_field($cf_hover_font_color);

$apexnb_lite_settings['button_fsize']   = (isset($button_fsize) && $button_fsize !='')?intval($button_fsize):'';
$apexnb_lite_settings['button_fweight']   = (isset($button_fweight) && $button_fweight !='')?$button_fweight:'normal';

// a hyperlink settigs
$apexnb_lite_settings['atag_bg_color']                = sanitize_text_field($atag_bg_color);
$apexnb_lite_settings['atag_font_color']              = sanitize_text_field($atag_font_color);
$apexnb_lite_settings['atag_hover_bg_color']          = sanitize_text_field($atag_hover_bg_color);
$apexnb_lite_settings['atag_hover_font_color']        = sanitize_text_field($atag_hover_font_color);
//close button
$apexnb_lite_settings['close_bg_color']        = sanitize_text_field($close_bg_color);
$apexnb_lite_settings['close_font_color']      = sanitize_text_field($close_font_color);


// echo "<pre>";print_r($apexnb_lite_settings);
// echo "</pre>";
// exit();
update_option('apexnb_lite_settings', $apexnb_lite_settings);

//error_log( print_r( $check, true ), 0);
wp_redirect(admin_url('admin.php?page=apexnb-lite&message=1'));
exit();