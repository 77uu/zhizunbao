<?php defined('ABSPATH') or die("No script kiddies please!");?>
<p class="description"><?php _e('Altogether 5 Available Components for notification bar.', APEXNBL_TD); ?></p>
<div class="edn-col-full">
        <div class="edn-field-wrapper edn-field  edn-form-field">

             <div class="edn-field-label">
                <label><h3><?php _e('Choose Notification Components', APEXNBL_TD); ?></h3></label>
               </div>

            <div class="edn-field-input">
                 <select name="edn_cp_type" class="edn-label-inline apexnb-selection">
                 <option value=""><?php _e('Choose Components',APEXNBL_TD);?></option>
                  <option value="text" <?php if($cp_type == "text") echo "selected='selected';";?>><?php _e('Text (Custom html codes)',APEXNBL_TD);?></option>
                  <option value="email-subs" <?php if($cp_type == "email-subs") echo "selected='selected';";?>><?php _e('Opt-in form',APEXNBL_TD);?></option>
                  <option value="post-title" <?php if($cp_type == "post-title") echo "selected='selected';";?>><?php _e('Post Title',APEXNBL_TD);?></option>
                  <option value="search-form" <?php if($cp_type == "search-form") echo "selected='selected';";?>><?php _e('Search Form',APEXNBL_TD);?></option>
                  <option value="social-icons" <?php if($cp_type == "social-icons") echo "selected='selected';";?>><?php _e('Social Icons',APEXNBL_TD);?></option>
                 </select>

            </div>
        </div>
</div> 


<div class="edn-cp-block" id="edn-cp-text" style="display: block;">
<?php 
$edn_text_display_mode = (isset($apexnb_lite_data['edn_text_display_mode']) && $apexnb_lite_data['edn_text_display_mode'] != '')?$apexnb_lite_data['edn_text_display_mode']:'static';
?>
<div class="edn-row">
<div class="edn-col-full edn-contentdisply-mode">
    <div class="edn-field-wrapper edn-form-field">
        <div class="header_section"><label><?php _e('Content Display Mode', APEXNBL_TD); ?></label></div>
        <div class="edn-field">
            <label class="edn-label-inline">
                <input type="radio" name="edn_text_display_mode" class="edn-text-mode" value="static" <?php if($edn_text_display_mode=='static'){echo 'checked="checked"';}?> />
                <?php _e('Static Content', APEXNBL_TD); ?>
            </label>
            <label class="edn-label-inline">
                <input type="radio" name="edn_text_display_mode" class="edn-text-mode" value="multiple" <?php if($edn_text_display_mode=='multiple'){echo 'checked="checked"';}?> />
                <?php _e('Multiple Content', APEXNBL_TD); ?>
            </label>
        </div>
    </div>
</div>
</div>
<div class="edn-text-content-wrap">

<div class="edn-static-content-wrap">
  <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/static-text-settings.php');?>
</div> <!-- static content end -->


<div class="edn-multiple-content-wrap" style="display: none;">
 <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/multiple_text/edit-multiple-text.php');?>
 
 <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/multiple_text/add-multiple-content.php');?>
</div>


</div>

</div>


<!------------------------------------------Subscribe FORM------------------------------------------>
<div class="edn-cp-block" id="edn-cp-subscribe" style="display: none;">
 <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/sub-custom.php');?>     
</div>
<!------------------------------------------Subscribe FORM END------------------------------------------>

<!------------------------------------------POST TITLE Start------------------------------------------>    
<div class="edn-cp-block" id="edn-post-title" style="display: none;">        
        <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/recent-posts.php');?>                            
</div>
<!------------------------------------------POST TITLE END------------------------------------------>  

<!-- social icons settings start-->
<div class="edn-cp-block" id="edn-cp-social-icons" style="display: none;">
 <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/social-settings.php');?>
</div>

<!-- social icons settings start-->
<div class="edn-cp-block" id="edn-search-form-content" style="display: none;">
         <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/search-form.php');?> 
</div>

 <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/bar-effects.php');?> 