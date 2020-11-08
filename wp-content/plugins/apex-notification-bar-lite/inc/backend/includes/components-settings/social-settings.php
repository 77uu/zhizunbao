<?php defined('ABSPATH') or die("No script kiddies please!");
$edn_social_heading_text = (isset($apexnb_lite_data['edn_social_heading_text']) && $apexnb_lite_data['edn_social_heading_text'] != '')?$apexnb_lite_data['edn_social_heading_text']:'';
//$edn_social_heading_color = (isset($apexnb_lite_data['edn_social_heading_color']) && $apexnb_lite_data['edn_social_heading_color'] != '')?$apexnb_lite_data['edn_social_heading_color']:'';
$icon_details = (isset($apexnb_lite_data['icon_details']) && $apexnb_lite_data['icon_details'] != '')?$apexnb_lite_data['icon_details']:array();
?>
<!-- social media start-->    
<div class="edn-social-icons-section">
 <div class="edn-col-half edn-social-panel-wrap">
 
<div class="header_section">
     <?php _e('Add Social Icons',APEXNBL_TD);?>
</div>
<div class="edn-col-full">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Social Heading Text',APEXNBL_TD)?></label>
        <div class="edn-field">
            <input type="text"id="edn-social-heading-text" name="edn_social_heading_text" placeholder="<?php _e('Follow Us On',APEXNBL_TD);?>"
            value="<?php if($edn_social_heading_text){echo esc_attr($edn_social_heading_text);}?>" placeholder="<?php _e('e.g: Stay with us',APEXNBL_TD);?>"  class="edn-sform-text required" data-error-msg="<?php _e('Please enter the icon title',APEXNBL_TD)?>" />
        </div>
        <div class="edn-error"></div>
    </div>
</div>
<div class="edn-col-full">
    <div class="edn-preview-holder-wrap">
        <div class="edn-preview-holder">
            <div class="edn-font-icon-preview" style="display: block">
                <?php _e('Icon Preview', APEXNBL_TD); ?><!--font-awesome selected icon-->
            </div>
        </div>
    </div>

    <div class="header_section"><?php _e('Icon Lists', APEXNBL_TD); ?>&nbsp;&nbsp;<img src="<?php echo APEXNBL_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-icon-loader"/></div>
    <div class="edn-expander-controls">
        <a href="javascript:void(0);" class="edn-icon-theme-expand button button-secondary button-small" style="display:<?php if(isset($edn_bar_setting['icon_details']) && count($edn_bar_setting['icon_details'])>0){echo 'block';}else{echo 'none';}?>"><?php _e('Expand All', APEXNBL_TD); ?></a>
    </div>
    <div class="edn-icon-list-wrapper">
        <p class="edn-empty-icon-note" style="display: none;">Empty List</p>
        <div class="edn-icon-note" style="display: none"><?php _e('Each Icon will only show up in the frontend if icon link is not empty', APEXNBL_TD); ?></div>
<ul class="edn-icon-list">
<?php
    $sn = 1;
    foreach ($icon_details as $icon_list){
        ?>
<li class="edn-sortable-icons <?php //echo $icon_main_class; ?>">
    <div class="edn-drag-icon"></div>
    <div class="edn-icon-head">
        <span class="edn-icon-name"><?php echo esc_attr($icon_list['title']);?></span>
        <span class="edn-icon-list-controls">
            <span class="edn-arrow-down edn-arrow button button-secondary">
                <i class="dashicons dashicons-arrow-down"></i>
            </span>&nbsp;&nbsp;
            <span class="edn-delete-icon button button-secondary" aria-label="delete icon">
                <i class="dashicons dashicons-trash"></i>
            </span>
        </span>
    </div>
    <div class="edn-icon-body" style="display: none;">
        <div class="edn-icon-preview">
            <label><?php _e('Icon Preview', APEXNBL_TD); ?></label>
            <i class="<?php echo esc_attr($icon_list['font_icon']); ?>"></i>
        </div>
        <div class="edn-row">
            <div class="edn-col-one-third">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Icon Title',APEXNBL_TD)?></label>
                    <div class="edn-field">
                        <input type="text" name="icons[<?php echo esc_attr($icon_list['title']);?>][title]" value="<?php echo esc_attr($icon_list['title']);?>" />
                    </div>
                    <div class="edn-error"></div>
                </div><!--edn-field-wrapper-->
            </div>           
                

<?php 
$icon_display = !(isset($icon_list['icon_type']) && $icon_list['icon_type'] == "available_font_icon")?'style="display:none"':'';
?>
<div class="edn-col-icons">
<div class="edn-col-one-third available-icons" <?php echo $icon_display;?>>

    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Font Awesome Icon', APEXNBL_TD); ?></label>
        <div class="edn-field">
            <input type="hidden" class="edn-edit-font-awesome-icon" id="edn-fa-socil_<?php echo $sn;?>" name="icons[<?php echo esc_attr($icon_list['title']);?>][font_icon]" value="<?php echo esc_attr($icon_list['font_icon']);?>" />
            <input type="button" id="edn-fa-icons-wrap_<?php echo $sn;?>" class="button button-secondary edn-edit-font-icon-chooser" value="<?php _e('Select Icon', APEXNBL_TD); ?>"/>
            <div class="edn-fa-icons-wrap" style="display:none">
                 <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/font-awesome-icons.php');?>
            </div>
        </div>
        <div class="edn-error"></div>
    </div><!--edn-field-wrapper-->
</div>

</div>

</div>
        
        <div class="edn-clear"></div>
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
                <label><?php _e('Icon Link', APEXNBL_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="icons[<?php echo esc_attr($icon_list['title']);?>][link]" value="<?php echo esc_url($icon_list['link']);?>" />
                </div>
            </div><!--edn-field-wrapper-->
        </div>
    </div>
</li>
        <?php
        $sn++;
    }
?>
</ul>
    </div>
    <!-- Social form panel/column -->
    <div class="edn-social-form-panel">
         <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/social-icons-add.php');?>
    </div>
    <!-- Social form panel/column -->
</div>
</div>  
</div>  

<!-- </div> -->
<!-- social media end-->