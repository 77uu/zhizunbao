<?php defined('ABSPATH') or die("No script kiddies please!");?>
<style id="edn-label-font-style"></style>
 <div class="edn-row edn-customzie-layout"> 
    <div class="edn-design-content apexnb-main-wrapper-toggle">
            <div class="edn-row">
                      <div class="edn-col-full">
                         <div class="edn-field-wrapper edn-form-field">
                            <div class="edn-field clearfix">
                               <div class="edn-field-label">
                                  <label for="edn_bar_type">
                                  <?php _e('Enable/Disable Custom Settings', APEXNBL_TD); ?> 
                                  </label>
                                  <p class="edn-note"><?php _e('Note: Check to enable custom template.',APEXNBL_TD);?>
                                  </p>
                               </div>
                               <div class="apexnb-switch edn-field-input">
                                  <input type="checkbox" name="edn_bar_type" id="edn_bar_type" value="1" <?php if(isset($apexnb_lite_data['edn_bar_type']) && $apexnb_lite_data['edn_bar_type']==1){echo 'checked="checked"';}?> />
                                  <label for="edn_bar_type"></label>
                               </div>
                            </div>
                         </div>
                      </div>
         </div>
         <div class="clear"></div>
         <div class="header_section"><?php _e('Custom Bar Design',APEXNBL_TD);?></div> 
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Background color', APEXNBL_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="edn_bg_color" id="edn_bg_color" class="edn-color-picker" data-alpha="true" value="<?php if(isset($apexnb_lite_data['edn_bg_color'])){echo esc_attr($apexnb_lite_data['edn_bg_color']);}?>" />
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Font color', APEXNBL_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="edn_font_color" id="edn_font_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['edn_font_color'])){echo esc_attr($apexnb_lite_data['edn_font_color']);}?>" />
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Notification bar font', APEXNBL_TD); ?></label>
                <div class="edn-field">
                    <select name="edn_fonts" id="edn-fonts" class="ednfont">
                        <option value="default"><?php _e('Default',APEXNBL_TD)?></option>
                        <?php 
                              $edn_fonts = get_option('apexnb_fonts');
                            foreach ($edn_fonts as $fonts) {
                                ?>
                                    <option value="<?php echo $fonts;?>" <?php if(isset($apexnb_lite_data['edn_fonts']) && $apexnb_lite_data['edn_fonts']==$fonts){echo 'selected="selected"'; }?>><?php echo $fonts;?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth edn-font-wrap">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Content Font Size', APEXNBL_TD); ?></label>
                <div class="edn-field">
                    <span class="edn-fz-wrap">
                        <select class="edn-select-font" id="ednsize" onchange="document.getElementById('edn-displayValue').value=this.options[this.selectedIndex].value;">
                    		<?php
                                $sizes = array('10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26');
                                foreach($sizes as $size){
                                    ?>
                                        <option value="<?php echo $size;?>"<?php if(isset($apexnb_lite_data['edn_font_size']) && $apexnb_lite_data['edn_font_size']==$size){echo 'selected="selected"';}?>><?php echo $size;?></option>
                                    <?php
                                }
                            ?>
                    	</select>
                    	<input type="hidden" name="edn_font_size" value="<?php if(isset($apexnb_lite_data['edn_font_size'])){echo esc_attr($apexnb_lite_data['edn_font_size']);}?>" id="edn-displayValue" class="edn-dis-value" onfocus="this.select()" />
                     </span>
                </div>
            </div>
        </div>
    <div class="clear"></div>
    <span><?php _e('Custom Bar Preview ',APEXNBL_TD);?>:</span>
    <div class="edn-font-demo-wrap" id="edn-label-font-text">
        The Quick Brown Fox Jumps Over The Lazy Dog. 1234567890
        <div class="btn_preview">Click Me</div>
     </div>
     <div class="clear"></div>

     <div class="header_section"><?php _e('Button Custom Design',APEXNBL_TD);?></div> 
        <p class="description"><?php _e('Set all type of button font color,hover font color, background color, background hover color such as for search button, read more button for static, multiple text components.
        Similarly, other remaining custom option is for hyperlink i.e a tag added usign static or multiple wp editor text for which you can set its background color/hover bg color, font color/hover font color. ',APEXNBL_TD);?></p>
          <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Background color', APEXNBL_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="cf_bg_color" id="cf_bg_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['cf_bg_color'])){
                        echo esc_attr($apexnb_lite_data['cf_bg_color']);}?>" />
                </div>
            </div>
        </div>
          <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Font Color', APEXNBL_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="cf_font_color" id="cf_font_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['cf_font_color'])){
                        echo esc_attr($apexnb_lite_data['cf_font_color']);}?>" />
                </div>
            </div>
        </div>

         <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Background Hover Color', APEXNBL_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="cf_hover_bg_color" id="cf_hover_bg_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['cf_hover_bg_color'])){
                        echo esc_attr($apexnb_lite_data['cf_hover_bg_color']);}?>" />
                </div>
            </div>
        </div>

        <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Font Hover Color', APEXNBL_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="cf_hover_font_color" id="cf_hover_font_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['cf_hover_font_color'])){
                        echo esc_attr($apexnb_lite_data['cf_hover_font_color']);}?>" />
                </div>
            </div>
        </div>

       <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Button Font Size', APEXNBL_TD) ?></label>
                <div class="edn-field">
                    <input type="number" name="button_fsize" id="button_fsize"
                    value="<?php if(isset($apexnb_lite_data['button_fsize'])){
                        echo esc_attr($apexnb_lite_data['button_fsize']);}?>" />
                         <p class="description"><?php _e('Set Font size for button element.',APEXNBL_TD);?></p>
                </div>
            </div>
        </div>

        <?php 
$button_fweight = (isset($apexnb_lite_data['button_fweight']) && $apexnb_lite_data['button_fweight'] != '')?esc_attr($apexnb_lite_data['button_fweight']):'normal';
        ?>

           <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Button Font Weight', APEXNBL_TD) ?></label>
                <div class="edn-field">
                    <select name="button_fweight">
                        <option value="normal" <?php if($button_fweight == "normal") echo 'selected';?>>Normal</option>
                        <option value="bold" <?php if($button_fweight == "bold") echo 'selected';?>>Bold</option>
                        <option value="500" <?php if($button_fweight == "500") echo 'selected';?>>Bold(500)</option>
                        <option value="bolder" <?php if($button_fweight == "bolder") echo 'selected';?>>Bolder</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="clear"></div>
         <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Hyperlink Background color', APEXNBL_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="atag_bg_color" id="atag_bg_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['atag_bg_color'])){
                        echo esc_attr($apexnb_lite_data['atag_bg_color']);}?>" />
                        <p class="description"><?php _e('Set Background color for a tag html element.',APEXNBL_TD);?></p>
                </div>
            </div>
        </div>
          <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Hyperlink Font Color', APEXNBL_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="atag_font_color" id="atag_font_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['atag_font_color'])){
                        echo esc_attr($apexnb_lite_data['atag_font_color']);}?>" />
                         <p class="description"><?php _e('Set Font color for a tag html element.',APEXNBL_TD);?></p>
                </div>
            </div>
        </div>

         <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Hyperlink Hover Background Color', APEXNBL_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="atag_hover_bg_color" id="atag_hover_bg_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['atag_hover_bg_color'])){
                        echo esc_attr($apexnb_lite_data['atag_hover_bg_color']);}?>" />
                          <p class="description"><?php _e('Set Hover Background color for a tag html element.',APEXNBL_TD);?></p>
                </div>
            </div>
        </div>

        <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Hyperlink Hover Font Color', APEXNBL_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="atag_hover_font_color" id="atag_hover_font_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['atag_hover_font_color'])){
                        echo esc_attr($apexnb_lite_data['atag_hover_font_color']);}?>" />
                          <p class="description"><?php _e('Set Hover font color for a tag html element.',APEXNBL_TD);?></p>
                </div>
            </div>
        </div>

     <div class="clear"></div>

     <div class="header_section"><?php _e('Controls Button Custom Design',APEXNBL_TD);?></div> 
      <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Close Button Background Color', APEXNBL_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="close_bg_color" id="close_bg_color" class="edn-color-picker"
                     value="<?php if(isset($apexnb_lite_data['close_bg_color'])){
                        echo esc_attr($apexnb_lite_data['close_bg_color']);}?>"/>
                </div>
            </div>
        </div>
        <div class="edn-col-one-third">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Close Button Font Color', APEXNBL_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="close_font_color" id="close_font_color" class="edn-color-picker" 
                    value="<?php if(isset($apexnb_lite_data['close_font_color'])){
                        echo esc_attr($apexnb_lite_data['close_font_color']);}?>" />
                </div>
            </div>
        </div>
    
     <div class="clear"></div>
</div>
</div>