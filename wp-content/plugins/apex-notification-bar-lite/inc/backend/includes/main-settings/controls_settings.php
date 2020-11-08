<?php defined('ABSPATH') or die("No script kiddies please!");?>
<div class="apexnb-control-settings">
<div class="edn-row">
<?php 
$edn_visibility = (isset($apexnb_lite_data['edn_visibility']) && $apexnb_lite_data['edn_visibility'] != '')?esc_attr($apexnb_lite_data['edn_visibility']):'sticky';
$edn_show_duration = (isset($apexnb_lite_data['edn_show_duration']) && $apexnb_lite_data['edn_show_duration'] != '')?esc_attr($apexnb_lite_data['edn_show_duration']):'';
$edn_hide_duration = (isset($apexnb_lite_data['edn_hide_duration']) && $apexnb_lite_data['edn_hide_duration'] != '')?esc_attr($apexnb_lite_data['edn_hide_duration']):'';
$edn_close_button = (isset($apexnb_lite_data['edn_close_button']) && $apexnb_lite_data['edn_close_button'] != '')?esc_attr($apexnb_lite_data['edn_close_button']):'user-can-close';
$show_once = (isset($apexnb_lite_data['show_once']) && $apexnb_lite_data['show_once'] == 1)?'1':'0';
$duration_show_once = (isset($apexnb_lite_data['duration_show_once']) && $apexnb_lite_data['duration_show_once'] != '')?esc_attr($apexnb_lite_data['duration_show_once']):'';
$show_once_hideshow = (isset($apexnb_lite_data['show_once_hideshow']) && $apexnb_lite_data['show_once_hideshow'] == 1)?'1':'0';
?>
      <div class="edn-col-full">
         <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field clearfix">
               <div class="edn-field-label">
                  <label for="apexnblite_visibility">
                  <?php _e('Notification bar visibility', APEXNBL_TD) ?>
                  </label>
               </div>
               <div class="apexnb-switch edn-field-input">
                 <select name="edn_visibility" id="apexnblite_visibility" class="edn-visibility apexnb-selection">
                    <option value="sticky" <?php if($edn_visibility=='sticky'){echo 'selected="selected"';}?>><?php _e('Always Show',APEXNBL_TD)?></option>
                    <option value="show-time" <?php if($edn_visibility=='show-time'){echo 'selected="selected"';}?>><?php _e('Show After some time',APEXNBL_TD)?></option>
                    <option value="hide-time" <?php if($edn_visibility=='hide-time'){echo 'selected="selected"';}?>><?php _e('Hide after some time',APEXNBL_TD)?></option>
                </select> 
               </div>
            </div>
         </div>
      </div>
</div>
<div class="edn-row">    
      <div class="edn-col-full edn-time">
        <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field edn-visibility-showtime clearfix">
             
                          <div class="edn-field-label">
                              <label for="apexnblite_visibility_showtime">
                                          <?php _e('Show Time Duration', APEXNBL_TD) ?>
                                          <p class="edn-note"><?php _e('Time Duration In milliseconds',APEXNBL_TD);?></p>
                              </label>           
                            </div>
                           <div class="edn-field-input">
			                  <input type="number" id="apexnblite_visibility_showtime" name="edn_visibility_show_duration" value="<?php if(isset($edn_show_duration)){ echo esc_attr($edn_show_duration); } ?>"/>
			                     
			               </div>

			  </div>
        </div>
      </div>
</div>
<div class="edn-row">
      <div class="edn-col-full edn-time-hide">
        <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field edn-visibility-hidetime clearfix" <?php if(isset($edn_show_duration) && $edn_visibility=='hide-time') { echo 'style="display:inline-block;"';}else{echo 'style="display:none;"';} ?>>
             
                          <div class="edn-field-label">
                              <label for="apexnblite_visibility_hidetime">
                                          <?php _e('Hide Time Duration', APEXNBL_TD) ?>
                                          <p class="edn-note"><?php _e('Time Duration In milliseconds',APEXNBL_TD);?></p>
                              </label>           
                            </div>
                           <div class="edn-field-input">
			                 <input type="number" id="apexnblite_visibility_hidetime" name="edn_visibility_hide_duration" value="<?php if(isset($edn_hide_duration)){ echo esc_attr($edn_hide_duration); } ?>"/>
			                     
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
                  <label for="apexnblite_enable_bar">
                  <?php _e('Notification bar Close Button', APEXNBL_TD) ?>
                  </label>
               </div>
               <div class="apexnb-switch edn-field-input">
                    <select name="edn_close_button" id="edn-close-button" class="edn-close-button apexnb-selection">           
                        <option value="disable" <?php if($edn_close_button=='disable'){echo 'selected="selected"';}?>><?php _e('Disable',APEXNBL_TD)?></option>
                        <option value="show-hide" <?php if($edn_close_button=='show-hide'){echo 'selected="selected"';}?>><?php _e('Show/Hide',APEXNBL_TD)?></option>
                        <option value="user-can-close" <?php if($edn_close_button=='user-can-close'){echo 'selected="selected"';}?>><?php _e('User Can Close',APEXNBL_TD)?></option>
                    </select>
               </div>
            </div>
         </div>
      </div>
</div>
<div class="edn-row">
        <div class="edn-col-full edn_close_once" style="display:none;">
         <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field clearfix">
               <div class="edn-field-label">
                  <label for="show_once">
                  <?php _e('Show only Once?', APEXNBL_TD) ?>
                    <p class="edn-note"><?php _e('Note: Check to enable to display only once after user close.',APEXNBL_TD);?></p>
                  </label>
               </div>
               <div class="apexnb-switch edn-field-input">
                   <input type="checkbox" name="show_once" id="show_once" value="1" <?php if($show_once==1){echo 'checked';}?>/>
                   <label for="show_once"></label>
               </div>
            </div>
         </div>
      </div>
</div>
<div class="edn-row">
         <div class="edn-col-full duration_time" style="display:none;">
         <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field clearfix">
               <div class="edn-field-label">
                  <label>
                  <?php _e('Duration Time', APEXNBL_TD) ?>
                     <p class="edn-note"><?php _e('Note:Duration to hide in second.Minimum time required is 10 seconds.',APEXNBL_TD);?></p>
                  </label>
               </div>
               <div class="apexnb-switch edn-field-input">
                    <input type="number" min="1" name="duration_show_once" id="duration_show_once" value="<?php echo esc_attr($duration_show_once);?>" />
                     
                   
               </div>
            </div>
         </div>
      </div>
</div>
<div class="edn-row">
    <!-- Show/ hide toggle options -->
       <div class="edn-col-full edn_show_hide" style="display:none;">
         <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field clearfix">
               <div class="edn-field-label">
                  <label for="show_once_hideshow">
                  <?php _e('Show only Once?', APEXNBL_TD) ?>
                     <p class="edn-note"><?php _e('Note: Check to enable to display only once after user show hide but but toggle function works.',APEXNBL_TD);?></p>
                  </label>
               </div>
               <div class="apexnb-switch edn-field-input">
                    <input type="checkbox" name="show_once_hideshow" id="show_once_hideshow" value="1" <?php if($show_once_hideshow==1){echo 'checked';}?>/>
                 <label for="show_once_hideshow"></label>
                </div>
            </div>
         </div>
      </div>
 </div>
 </div>