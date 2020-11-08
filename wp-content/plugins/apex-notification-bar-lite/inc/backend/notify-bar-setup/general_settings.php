<?php defined('ABSPATH') or die("No script kiddies please!");?>
<?php 
   $apexnb_lite_data = Database_Class::get_bar_data();
   $apexnblite_enable_bar = (isset($apexnb_lite_data['apexnblite_enable_bar']) && $apexnb_lite_data['apexnblite_enable_bar'] == 1)?'1':'0';
   $apexnblite_enable_mobile = (isset($apexnb_lite_data['apexnblite_enable_mobile']) && $apexnb_lite_data['apexnblite_enable_mobile'] == 1)?'1':'0';
   $edn_position = (isset($apexnb_lite_data['edn_position']) && $apexnb_lite_data['edn_position'] !=  '')?esc_attr($apexnb_lite_data['edn_position']):'top';
   $edn_notify_on_pages = (isset($apexnb_lite_data['edn_notify_on_pages']) && $apexnb_lite_data['edn_notify_on_pages'] !=  '')?esc_attr($apexnb_lite_data['edn_notify_on_pages']):'all_pages';
?>
<div class="edn-form-wrap"> 

		     <!-- General Settings Tab START-->

               <div class='ednnb-tab-contents ednnb-active-tab' id='tab-general-settings'>
                          <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label for="apexnblite_enable_bar">
                                          <?php _e('Enable/Disable', APEXNBL_TD); ?> 
                                          </label>
                                          <p class="edn-note"><?php _e('Note: Check to enable notification bar on your site.',APEXNBL_TD);?>
                                          </p>
                                       </div>
                                       <div class="apexnb-switch edn-field-input">
                                          <input type="checkbox" name="apexnblite_enable_bar" id="apexnblite_enable_bar" value="1" <?php if($apexnblite_enable_bar==1){echo 'checked="checked"';}?> />
                                          <label for="apexnblite_enable_bar"></label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label for="apexnblite_enable_mobile">
                                          <?php _e('Mobile Enable/Disable', APEXNBL_TD); ?>
                                          </label>
                                          <p class="edn-note"><?php _e('Note: Check to enable notification bar in mobile.',APEXNBL_TD);?>
                                          </p>
                                       </div>
                                       <div class="apexnb-switch edn-field-input">
                                          <input type="checkbox" name="apexnblite_enable_mobile" id="apexnblite_enable_mobile" value="1" <?php if($apexnblite_enable_mobile==1){echo 'checked="checked"';}?> />
                                          <label for="apexnblite_enable_mobile"></label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label>
                                          <?php _e('Choose Position', APEXNBL_TD) ?>
                                          </label>
                                          <p class="edn-note">
                                             <?php _e('Note: Choose any notification bar position to display.',APEXNBL_TD);?>
                                          </p>
                                       </div>
                                       <div class="edn-field-input">
                                          <select name="edn_position" class="edn-default-bar apexnb-selection">
                                             <option value="">Choose Position</option>
                                             <option value="top" <?php if($edn_position == "top") {echo 'selected="selected"';}?> >Top Fixed</option>
                                             <option value="top_absolute" <?php if($edn_position == "top_absolute") {echo 'selected="selected"';}?>>Top Absolute</option>
                                             <option value="bottom" <?php if($edn_position == "bottom") {echo 'selected="selected"';}?>>Bottom</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                      
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                          <?php _e('Show Notification Bar On', APEXNBL_TD); ?>
                                          </label>
                                          <p class="edn-note">
                                             <?php _e('Note: Show notification bar on all pages or only on  home page.',APEXNBL_TD);?>
                                          </p>
                                       </div>
                                       <div class="edn-field-input">
                                          <select name="edn_notify_on_pages" id="edn-notify-on-pages" class="edn_notify_on_pages apexnb-selection">
                                             <option value="all_pages" <?php if($edn_notify_on_pages =="all_pages"){echo 'selected="selected"';}?>><?php _e('All Pages', APEXNBL_TD); ?></option>
                                             <option value="only_home_page" <?php if($edn_notify_on_pages=="only_home_page"){echo 'selected="selected"';}?>><?php _e('Only On Home Page', APEXNBL_TD); ?></option>
                                             
                                          </select>
                                       </div>
                                    </div>
                               

                                 </div>
                              </div>
                           </div>
                        </div>
                <!-- General Settings Tab END-->

</div>