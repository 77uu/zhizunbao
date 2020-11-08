<?php defined('ABSPATH') or die("No script kiddies please!");
if(isset($disable_mobile_bar) && $disable_mobile_bar == '0'){?>
<style type="text/css">
  @media (max-width: 480px) {  .ednpro_main_wrapper{display:none; }   }
</style>
<?php } ?>
<div class="ednpro_main_wrapper ednpro_section">
<?php 
if($edn_bar_type == 1 && $fonts_final !="Default" && $fonts_final !="default"){ 
?>
<link rel='stylesheet' id='edn-google-fonts-style-css' href='//fonts.googleapis.com/css?family=<?php echo $fonts_final;?>' type='text/css' media='all' /> 
<?php
}
if($edn_close_button == "show-hide" || $edn_close_button == "user-can-close"){
   $addClass = "edn_close_button_show";
}else{
  $addClass = "edn_no_close_button";
}
$edn_text_display_mode = (isset($edn_bar_data['edn_text_display_mode']) && $edn_bar_data['edn_text_display_mode'] != '')?esc_attr($edn_bar_data['edn_text_display_mode']):'static';
$edn_text_display_mode = (isset($edn_bar_data['edn_text_display_mode']) && $edn_bar_data['edn_text_display_mode'] != '')?esc_attr($edn_bar_data['edn_text_display_mode']):'';
?>

<div class="edn-close-section" id="apex_cookie_<?php echo $nb_id;?>" <?php echo $dstyle;?>> 
  <div class="edn-notify-bar edn-position-<?php echo $position; ?> edn-visibility-<?php echo $visibility_type;?> <?php if(isset($edn_bartype)){ echo $edn_bartype;} ?> <?php echo $addClass;?>" id="<?php echo $pretemplate_classname;?>" data-barid="apexbar-<?php echo $nb_id;?>" data-postid="<?php echo $post->ID;?>">
    <input type="hidden" id='effect_type<?php echo $nb_id;?>' value="<?php echo $effect_id;?>"/>
	<input type="hidden" class='edn_social_optons' value="<?php echo $edn_social_optons;?>"/>
	<input type="hidden" class='edn_right_optons' value="<?php echo $edn_right_optons;?>"/>
  
      <div class="edn-container <?php echo 'apexnb-bartype'.$effect_id;?>">

		<?php if($edn_bar_type == 1){  
		   // custom template
            include('custom-css.php');
            include('custom_layout.php');
		 }else{
 			// pre avialable template
            if(!empty($edn_bar_template)){
                include('templates.php');
            }    
		 }
		?>

    </div><!-- edn-container end -->
 <!---------- Notification Controls ---------->
 <?php
$template_type = (isset($edn_bar_data['edn_bar_type']) && $edn_bar_data['edn_bar_type'] != '')?$edn_bar_data['edn_bar_type']:'2'; // cusotm or available as 1 or 2

if($template_type == '1'){
   $template1 = '';
   $template_class = "custom_template";
}else{
    $template1 = $edn_bar_data['edn_bar_template'];
    $template_class = "pre_template_".$template1;
}?>
    <?php if($edn_close_button == "show-hide" || $edn_close_button == "user-can-close"){?>
    <div class="edn-cntrol-wrap edn-controls-<?php echo esc_attr($edn_bar_data['edn_position']);?> 
    ednpro_<?php echo $edn_bar_data['edn_close_button'];?> visibility_<?php echo esc_attr($visibility_type);?> <?php echo $template_class;?>">
        <?php 
            if($edn_close_button == 'show-hide'){
                if($edn_bar_data['edn_position']=='top' || $edn_bar_data['edn_position']=='top_absolute'){
                ?>  
                    <a href="javascript:void(0)" class="edn-controls edn-controls-dismiss">
                        <div class="edn-single-top-arrow">
                        <div class="edn-top-up-arrow toggle-arrow">
                        </div>
                          </div> 
                    </a>
                <?php
                }else if($edn_bar_data['edn_position']=='left'){ ?>
                   <a href="javascript:void(0)" class="edn-controls edn-controls-dismiss">
                       <div class="edn-single-left-arrow">
                            <div class="edn-left-arrow toggle-arrow"> </div>
                        </div> 
                         
                    </a>
                <?php }else if($edn_bar_data['edn_position']=='right'){ ?>
                   <a href="javascript:void(0)" class="edn-controls edn-controls-dismiss">
                        <div class="edn-single-right-arrow">
                        <div class="edn-right-arrow toggle-arrow">
                        </div>
                         </div>
                    </a>
             <?php   }

                else{
                    ?>
                        <a href="javascript:void(0)" class="edn-controls edn-controls-dismiss">
                            <div class="edn-single-bottom-arrow">
                            <div class="edn-bottom-down-arrow toggle-arrow">
                            </div>
                        
                        </div> 
                        </a>
                    <?php
                }
            }else{
                ?>
                    <a href="javascript:void(0)" class="edn-controls edn-controls-close">
                    <i class="fa fa-close"></i>
                    </a>     
                <?php
            }
        ?>
    </div><!-- End of Notification Controls -->  
    <?php }?>
  <!-- close if no any components found-->

   <input type="hidden" class="edn-ticker-option" id="apexnb-ticker-<?php echo $nb_id;?>"
    data-ticker-speed="<?php if(isset($edn_bar_data['edn_ticker']['speed'])){echo esc_attr($edn_bar_data['edn_ticker']['speed']);}?>"
    data-ticker-direction="<?php if(isset($edn_bar_data['edn_ticker']['direction'])){echo esc_attr($edn_bar_data['edn_ticker']['direction']);}?>"
    data-ticker-title="<?php if(isset($edn_bar_data['edn_ticker']['title_text'])){echo esc_attr($edn_bar_data['edn_ticker']['title_text']);}?>"
    data-ticker-hover="<?php if(isset($edn_bar_data['edn_ticker']['hover'])){echo esc_attr($edn_bar_data['edn_ticker']['hover']);}?>"
    data-slider-controls="<?php if(isset($edn_bar_data['edn_slider']['controls'])){echo esc_attr($edn_bar_data['edn_slider']['controls']);}?>"
    data-slider-animation="<?php if(isset($edn_bar_data['edn_slider']['animation'])){echo esc_attr($edn_bar_data['edn_slider']['animation']);}?>"
    data-slider-duration="<?php if(isset($edn_bar_data['edn_slider']['duration'])){echo esc_attr($edn_bar_data['edn_slider']['duration']);}?>"
    data-slider-auto="<?php if(isset($edn_bar_data['edn_slider']['auto'])){echo esc_attr($edn_bar_data['edn_slider']['auto']);}?>"
    data-slider-transition="<?php if(isset($edn_bar_data['edn_slider']['speed'])){echo esc_attr($edn_bar_data['edn_slider']['speed']);}?>"
    data-slider-adaptive-height="<?php if(isset($edn_bar_data['edn_slider']['adaptive_height'])){echo esc_attr($edn_bar_data['edn_slider']['adaptive_height']);}?>"
    data-scroll-controls="<?php if(isset($edn_bar_data['edn_scroll']['controls'])){echo esc_attr($edn_bar_data['edn_scroll']['controls']);}?>"
    data-scroll-direction="<?php if(isset($edn_bar_data['edn_scroll']['direction'])){echo esc_attr($edn_bar_data['edn_scroll']['direction']);}?>"
    data-scroll-animation="<?php if(isset($edn_bar_data['edn_scroll']['animation'])){echo esc_attr($edn_bar_data['edn_scroll']['animation']);}?>"
    data-scroll-speed="<?php if(isset($edn_bar_data['edn_scroll']['speed'])){echo esc_attr($edn_bar_data['edn_scroll']['speed']);}?>"
    data-scroll-title="<?php if(isset($edn_bar_data['edn_scroll']['title_text'])){echo esc_attr($edn_bar_data['edn_scroll']['title_text']);}?>"
/>
<input type="hidden" class="edn-visibility-bar-options edn-visibility-option-<?php echo $nb_id;?>" id="apexnb-<?php echo $nb_id;?>"
    data-show-time-duration="<?php if(isset($edn_bar_data['edn_show_duration'])){echo esc_attr($edn_bar_data['edn_show_duration']);}?>"
    data-hide-time-duration="<?php if(isset($edn_bar_data['edn_hide_duration'])){echo esc_attr($edn_bar_data['edn_hide_duration']);}?>"
    data-visibility-type = "<?php echo esc_attr($visibility_type);?>"
    data-close-type = "<?php if(isset($edn_close_button)){echo esc_attr($edn_close_button);}?>"
    data-close-once = "<?php if(isset($edn_bar_data['show_once'])){echo esc_attr($edn_bar_data['show_once']);}?>"
    data-duration-close = "<?php if(isset($edn_bar_data['duration_show_once'])){echo esc_attr($edn_bar_data['duration_show_once']);}?>"  
    data-show_once_hideshow = "<?php if(isset($edn_bar_data['show_once_hideshow'])){echo esc_attr($edn_bar_data['show_once_hideshow']);}?>"
    data-notification_bar_id = "<?php echo $nb_id;?>"
/>
<?php 
include('custom-contact-form.php');
include('multiple-custom-cform.php');
?>
    </div><!-- edn-notify-bar end -->
       
  </div> <!-- edn close section end -->
</div>