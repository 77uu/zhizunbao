<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<style type="text/css">
<?php 
$edn_fonts = (isset($edn_bar_data['edn_fonts']) && $edn_bar_data['edn_fonts'] != '')?$edn_bar_data['edn_fonts']:'';
$edn_font_size = (isset($edn_bar_data['edn_font_size']) && $edn_bar_data['edn_font_size'] != '')?$edn_bar_data['edn_font_size']:'';
$edn_font_color = (isset($edn_bar_data['edn_font_color']) && $edn_bar_data['edn_font_color'] != '')?$edn_bar_data['edn_font_color']:'';
$edn_bg_color = (isset($edn_bar_data['edn_bg_color']) && $edn_bar_data['edn_bg_color'] != '')?$edn_bar_data['edn_bg_color']:'';  
$read_more_fcolor = (isset($edn_bar_data['read_more_fcolor']) && $edn_bar_data['read_more_fcolor'] != '')?$edn_bar_data['read_more_fcolor']:'';
$read_more_bgcolor = (isset($edn_bar_data['read_more_bgcolor']) && $edn_bar_data['read_more_bgcolor'] != '')?$edn_bar_data['read_more_bgcolor']:'';
$cf_hover_bg_color = (isset($edn_bar_data['cf_hover_bg_color']) && $edn_bar_data['cf_hover_bg_color'] != '') ? $edn_bar_data['cf_hover_bg_color'] : '';
$cf_hover_font_color = (isset($edn_bar_data['cf_hover_font_color']) && $edn_bar_data['cf_hover_font_color'] != '') ? $edn_bar_data['cf_hover_font_color'] : '';
$atag_bg_color = (isset($edn_bar_data['atag_bg_color']) && $edn_bar_data['atag_bg_color'] != '') ? $edn_bar_data['atag_bg_color'] : '';
$atag_font_color = (isset($edn_bar_data['atag_font_color']) && $edn_bar_data['atag_font_color'] != '') ? $edn_bar_data['atag_font_color'] : '';
$atag_hover_bg_color = (isset($edn_bar_data['atag_hover_bg_color']) && $edn_bar_data['atag_hover_bg_color'] != '') ? $edn_bar_data['atag_hover_bg_color'] : '';
$atag_hover_font_color = (isset($edn_bar_data['atag_hover_font_color']) && $edn_bar_data['atag_hover_font_color'] != '') ? $edn_bar_data['atag_hover_font_color'] : '';
 $cf_bg_color= (isset($edn_bar_data['cf_bg_color']) && $edn_bar_data['cf_bg_color'] != '') ? $edn_bar_data['cf_bg_color'] : '';
$cf_font_color = (isset($edn_bar_data['cf_font_color']) && $edn_bar_data['cf_font_color'] != '')?$edn_bar_data['cf_font_color']:'';
$button_fsize = (isset($edn_bar_data['button_fsize']) && $edn_bar_data['button_fsize'] != '')?$edn_bar_data['button_fsize']:'';
$button_fweight = (isset($edn_bar_data['button_fweight']) && $edn_bar_data['button_fweight'] != '')?$edn_bar_data['button_fweight']:'normal';
?>

.edn-notify-bar .edn-custom-design-wrapper .ticker-wrapper .ticker, .edn-notify-bar .ticker-wrapper .ticker{
<?php if($edn_fonts != ''){ ?>
        font-family: <?php echo esc_attr($edn_fonts); ?>;
        <?php } ?>
         <?php if($edn_font_size != ''){ ?>
        font-size: <?php echo esc_attr($edn_font_size); ?>px;
        <?php } ?>
        <?php if($edn_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
          <?php if($edn_bg_color != ''){ ?>
        background-color: <?php echo esc_attr($edn_bg_color); ?>;
        <?php } ?>
    }
    /*added custom css*/
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-custom-design-wrapper,
     .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>],
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-contact-lightbox .edn-contact-lightbox-inner-wrap,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-contact-close,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-contact-lightbox-inner-wrap{
        <?php if($edn_fonts != ''){ ?>
        font-family: <?php echo esc_attr($edn_fonts); ?>;
        <?php } ?>
         <?php if($edn_font_size != ''){ ?>
        font-size: <?php echo esc_attr($edn_font_size); ?>px;
        <?php } ?>
        <?php if($edn_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
          <?php if($edn_bg_color != ''){ ?>
        background-color: <?php echo esc_attr($edn_bg_color); ?>;
        <?php } ?>

    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-contact-lightbox-inner-wrap label{
         <?php if($edn_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-mulitple-text-content,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn_static_text, 
    .slider_template_wrapper .edn-tweet-content, .edn-post-title-wrap .edn-post-title li,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn_static_text, 
    .slider_template_wrapper .edn-tweet-content, .edn-post-title-wrap .edn-post-title li,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-tweet-content,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-tweet-content a,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .ticker-content,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] a,
     .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .ticker-wrapper .ticker-content a, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .ticker-wrapper .ticker-content .edn-tweet-content, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .ticker-wrapper .edn-mulitple-text-content{
         <?php if($edn_fonts != ''){ ?>
        font-family: <?php echo esc_attr($edn_fonts); ?>;
        <?php } ?>
        <?php if($edn_font_size != ''){ ?>
        font-size: <?php echo esc_attr($edn_font_size); ?>px;
        <?php } ?>
         <?php if($edn_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-contact-form-wrap .edn-contact-close{
        <?php if($edn_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
          <?php if($edn_bg_color != ''){ ?>
          background-color: <?php echo esc_attr($edn_bg_color); ?>;
        <?php } ?>
    }
    /*tweets*/

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .ticker-wrapper .edn-post-title-readmore{
        <?php if($edn_fonts != ''){ ?>
        font-family: <?php echo esc_attr($edn_fonts); ?>;
        <?php } ?>
          <?php if($edn_font_size != ''){ ?>
        font-size: <?php echo esc_attr($edn_font_size); ?>px;
        <?php } ?>
          <?php if($read_more_fcolor != ''){ ?>
        color: <?php echo esc_attr($read_more_fcolor); ?> !important;
        <?php } ?>
         <?php if($read_more_bgcolor != ''){ ?>
        background-color: <?php echo esc_attr($read_more_bgcolor); ?> !important;
          <?php } ?>
    }
    /*ticker custom design start*/

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .ticker-wrapper .ticker-content a{
        margin-left: 8px;
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .ticker_pattern .edn-ticker-wrapper  .ticker-wrapper  .ticker-swipe{
        <?php if($edn_bg_color != ''){ ?>
          background-color: <?php echo esc_attr($edn_bg_color); ?>;
        <?php } ?>
    }

    /*ticker custom design end*/
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-contact-close,input[type="button"].edn-contact-submit{
         <?php if($edn_bg_color != ''){ ?>
          background-color: <?php echo esc_attr($edn_bg_color); ?>;
        <?php } ?>
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] a.edn-controls-close{
       <?php if($cf_font_color != ''){ ?>
        color: <?php echo esc_attr($cf_font_color); ?>;
         <?php } ?>
    }

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-social-heading-title{
           <?php if($edn_font_size != ''){ ?>
        font-size: <?php echo esc_attr($edn_font_size); ?>px;
        <?php } ?>
    }
    /*Custom Subscribe Form CSS ADDED*/
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] h1,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] h2,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] h3,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] h4,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] h5,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] h6,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-subscribe-form .edn-front-title h3{
        <?php if($edn_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
       <?php if($edn_font_size != ''){ ?>
        font-size: <?php echo esc_attr($edn_font_size); ?>px;
        <?php } ?>
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-subscribe-form .edn-front-title h3 span{
            <?php if($edn_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-subscribe-form .edn-front-title .show_icon i{
           <?php if($edn_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
    }
    

    /*Constant Contact Subscribe Form CSS END*/
    /* For all  CUstom buttons start */
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-form-field .constant_subscribe, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-subscribe-form .edn-form-field .edn_subs_submit_ajax,   
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-custom-contact-link, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-temp1-static-button,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .apexnb-search-layout1 .apex-search-right-section .btn-search-now,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn_static_text .edn-call-action-button a, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-call-action-button a,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-contact-lightbox .edn-form-field .edn-field input.edn-contact-submit{
       <?php if($cf_bg_color != ''){ ?>
        background: <?php echo esc_attr($cf_bg_color); ?>;
         <?php } ?><?php if($cf_font_color != ''){ ?>
        color: <?php echo esc_attr($cf_font_color); ?>;
        <?php } ?> <?php if($edn_fonts != ''){ ?>
        font-family: <?php echo esc_attr($edn_fonts); ?>;
        <?php } ?>
    }
   
 <?php
  
    if ($cf_hover_font_color != '' || $cf_hover_bg_color != '') {
        ?>
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn_static_text .edn-call-action-button a:hover,
        .edn-custom-template.edn-notify-bar .edn-custom-contact-link:hover,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .apexnb-search-layout1 .apex-search-right-section .btn-search-now:hover,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-subscribe-form .edn-form-field .edn_subs_submit_ajax:hover,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-form-field .edn_mailchimp_submit_ajax:hover,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-form-field .constant_subscribe:hover 
        {
            color: <?php echo esc_attr($cf_hover_font_color); ?>;
            background: <?php echo esc_attr($cf_hover_bg_color); ?>;
        }

        <?php
    }

    if ($atag_font_color != '' || $atag_bg_color != '') {
        ?>

        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn_static_text .edn-text-link a, 
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn_multiple_text .edn-mulitple-text-content a,
        edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-multiple-content .edn-mulitple-text-content a,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-post-title-wrap .edn-post-title li a{
            color: <?php echo esc_attr($atag_font_color); ?>;
            background: <?php echo esc_attr($atag_bg_color); ?>;
        }
        <?php
    }
    if ($atag_hover_font_color != '' || $atag_hover_bg_color != '') {
        ?>

        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn_static_text .edn-text-link a:hover, 
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn_multiple_text .edn-mulitple-text-content a:hover{
            color: <?php echo esc_attr($atag_hover_font_color); ?>;
            background: <?php echo esc_attr($atag_hover_bg_color); ?>;
        }
        <?php
    } ?>

    /* close button custom css */
   <?php 
$close_bg_color = (isset($edn_bar_data['close_bg_color']) && $edn_bar_data['close_bg_color'] != '') ? $edn_bar_data['close_bg_color'] : '';
$close_font_color = (isset($edn_bar_data['close_font_color']) && $edn_bar_data['close_font_color'] != '') ? $edn_bar_data['close_font_color'] : '';
   ?>
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>]  .edn-top-up-arrow.open,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>]  .edn-bottom-down-arrow.open,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>]  .edn-bottom-down-arrow.open,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-left-arrow,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-right-arrow,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-cntrol-wrap.ednpro_user-can-close {
       <?php if($close_bg_color != ''){ ?>
        background-color: <?php echo esc_attr($close_bg_color); ?>; 
       <?php } ?>
        background-image:  url("../../images/showhidetoggledown.png") no-repeat scroll 0 0;

    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-cntrol-wrap.ednpro_user-can-close .fa-close{
       <?php if($close_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_bar_data['close_font_color']); ?>;      
         <?php } ?>
    }

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-top-up-arrow {
        <?php if($close_bg_color != ''){ ?>
        background-color: <?php echo esc_attr($close_bg_color); ?>; 
       <?php } ?>
        background-image: url("../../images/showhidetoggletop.png") no-repeat scroll 0 0;
        border-radius: 14px;
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-bottom-down-arrow{
          <?php if($close_bg_color != ''){ ?>
        background-color: <?php echo esc_attr($close_bg_color); ?>; 
       <?php } ?>
        border-radius: 14px;
        background-image: url("../../images/showhidetoggledown.png") no-repeat scroll 0 0;
    }
    /* close button custom css */


    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn_error,.edn-error,
    .edn-constant-error
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-success,
    .edn-constant-success{
       <?php if($edn_fonts != ''){ ?>
        font-family: <?php echo esc_attr($edn_fonts); ?>;
        <?php } ?>
       <?php if($edn_font_color != ''){ ?>
        color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
    }


    /*social icons custom design start*/
    <?php
    /* social icons custom design end */
    if (isset($edn_bar_data['edn_static']['call_action_button']) && $edn_bar_data['edn_static']['call_action_button'] == 'custom' && $edn_bar_data['edn_text_display_mode'] != "multiple") {
        ?>

        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-post-title-wrap .edn-post-title li{
          <?php if($edn_font_color != ''){ ?>
          color: <?php echo esc_attr($edn_font_color); ?>;
        <?php } ?>
        }

        <?php
    } else {
        if (isset($edn_bar_data['edn_multiple']['text_content'])) {
            $total_data = count($edn_bar_data['edn_multiple']['text_content']);
            for ($i = 0; $i < $total_data; $i++) {
                ?>
                .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-multiple-btn-<?php echo $i; ?>{
                    background: <?php echo esc_attr($cf_bg_color); ?>;
                    color: <?php echo esc_attr($cf_font_color); ?>;
                    padding: 5px 10px 5px 10px;
                }
                .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .edn-multiple-btn-<?php echo $i; ?>:hover
                {                 
                    background-color: <?php echo esc_attr($cf_hover_bg_color); ?>;
                    color: <?php echo esc_attr($cf_hover_font_color); ?>;                 
                }      
                <?php
            }
        }
    }
    ?>

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>].edn-visibility-show-time{
        display: none;
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id; ?>] .visibility_show-time{
        display: none;
    }
       <?php if ($cf_font_color != '' || $cf_bg_color != '' || $button_fsize != '' || $button_fweight != '') {?>
        .edn-notify-bar .edn-custom-design-wrapper .edn-post-title-readmore{
            color: <?php echo esc_attr($cf_font_color); ?> !important;
            background: <?php echo esc_attr($cf_bg_color); ?> !important;
            padding: 2px 8px;
           <?php if($button_fsize != ''){ ?> font-size: <?php echo $button_fsize;?>px !important; <?php } ?>
           <?php if($button_fweight != ''){ ?> font-weight: <?php echo $button_fweight;?> !important; <?php } ?>
        }
    <?php } if ($cf_hover_font_color != '' || $cf_hover_bg_color != '') { ?>
        .edn-notify-bar .edn-custom-design-wrapper .edn-post-title-readmore:hover{
            color: <?php echo esc_attr($cf_hover_font_color); ?> !important;
            background: <?php echo esc_attr($cf_hover_bg_color); ?> !important;
        }
    <?php } ?>
</style>