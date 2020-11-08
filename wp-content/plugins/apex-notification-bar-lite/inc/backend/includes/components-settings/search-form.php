<?php defined('ABSPATH') or die("No script kiddies please!");
$sfdescription = (isset($apexnb_lite_data['edn_search_form']['description']) && $apexnb_lite_data['edn_search_form']['description'] != '')?$apexnb_lite_data['edn_search_form']['description']:'';
$input_placeholder = (isset($apexnb_lite_data['edn_search_form']['input_placeholder']) && $apexnb_lite_data['edn_search_form']['input_placeholder'] != '')?$apexnb_lite_data['edn_search_form']['input_placeholder']:'';
$button_name = (isset($apexnb_lite_data['edn_search_form']['button_name']) && $apexnb_lite_data['edn_search_form']['button_name'] != '')?$apexnb_lite_data['edn_search_form']['button_name']:'';
?>
<div class="header_section">
                    <?php _e('Search Form Preview',APEXNBL_TD);?>
</div>
<div class="preview-search">
<div id="search_layout1" class="preview_image_search">
 <img src="<?php echo APEXNBL_IMAGE_DIR;?>/preview/search-layout1.jpg"/>
</div>
</div>            
<div class="clear"></div>
          
<div class="edn-col-full">
<div class="edn-field-wrapper edn-form-field">
<div class="edn-field">
     <div class="edn-field-label">
        <label><?php _e('Description',APEXNBL_TD)?></label>
        <p class="edn-note"><?php _e('Fill description for search form.',APEXNBL_TD);?></p>
    </div>
      <div class="edn-field-input">
        <textarea name="edn_search_form[description]" col="5" rows="3" placeholder="Looking for something?"><?php echo esc_attr($sfdescription);?></textarea>
       </div>
</div>
</div><!--edn-field-wrapper-->
</div>  

<div class="edn-col-full">
<div class="edn-field-wrapper edn-form-field">
<div class="edn-field">
     <div class="edn-field-label">
    <label><?php _e('Search Input Field Placeholder',APEXNBL_TD)?></label>
    </div>
     <div class="edn-field-input">
        <input type="text" name="edn_search_form[input_placeholder]"
         value="<?php echo esc_attr($input_placeholder);?>" placeholder="<?php _e('Search Here',APEXNBL_TD);?>"/>
    </div>
</div>
</div><!--edn-field-wrapper-->
</div>   
<div class="edn-col-full">
<div class="edn-field-wrapper edn-form-field">
<div class="edn-field">
<div class="edn-field-label">
   <label><?php _e('Button Text',APEXNBL_TD)?></label>
</div>
<div class="edn-field-input">
  
    <input type="text" name="edn_search_form[button_name]"
     value="<?php echo esc_attr($button_name);?>" placeholder="<?php _e('Search',APEXNBL_TD);?>"/>
 
 </div>
  </div>
</div><!--edn-field-wrapper-->
</div>  
<div class="clear"></div>
