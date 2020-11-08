<?php defined('ABSPATH') or die("No script kiddies please!");?>
<div class="edn-row edn-template-chooser">
   
    <div class="edn-col-full">
        <div class="edn-field-wrapper">
            <div class="edn-png-template">
               <div class="edn-field-label">
                <label><h3><?php _e('Choose Notification Bar Layout', APEXNBL_TD); ?></h3>
                <p class="description"><?php _e('Note: Altogether 5 Beautifully Designed Pre Available Templates with preview images.', APEXNBL_TD); ?></p>
                </label>
               </div>
                <div class="edn-well  edn-field edn-field-input">
                     <label>
                            <select name="edn_bar_template" id="edn_bar_template" class="apexnb-selection">
                        <?php
                         for ($i = 1; $i <= 5; $i++) {
                        if($i == 1){
                          $template_name = "Shades of Arsenic Black";
                          }else if($i == 2){
                           $template_name = "Orange Shades";
                          }else if($i == 3){
                             $template_name = "Whisper Grey";
                            }else if($i == 4){
                              $template_name = "Prussian Blue & White";
                            }else if($i == 5){
                              $template_name = "Mountain Meadow";
                            } ?>
                       <option value="<?php echo $i;?>" <?php if (isset($apexnb_lite_data['edn_bar_template']) && $apexnb_lite_data['edn_bar_template'] == $i) { ?>selected="selected"<?php } ?>><?php echo $template_name;?></option>
                       <?php
                        }
                        ?>
                      </select>
                </div>
                  <div class="edn-backend-inner-title"><?php _e('Template Preview', APEXNBL_TD); ?></div>
                      <?php  for ($i = 1; $i <= 5; $i++) { 
                        if (isset($apexnb_lite_data['edn_bar_template']) && $apexnb_lite_data['edn_bar_template'] == $i) {
                               $style="style='display:block'";
                        }else{
                               $style="style='display:none'";
                            }?>
                            <div class="edn-template-preview edn-template-previewbox-<?php echo $i;?>" <?php echo $style;?>>
                                <img src="<?php echo APEXNBL_IMAGE_DIR . '/preview/templates/preview'.$i.'.jpg' ?>" alt="template preview" />
                            </div>

                     <?php } ?>

            </div>
        </div>
    </div>
</div>