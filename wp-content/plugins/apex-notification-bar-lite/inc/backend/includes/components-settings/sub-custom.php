<?php defined('ABSPATH') or die("No script kiddies please!");
$head_text = (isset($apexnb_lite_data['edn_subs_custom']['head_text']) && $apexnb_lite_data['edn_subs_custom']['head_text'] != '')?$apexnb_lite_data['edn_subs_custom']['head_text']:'';
$description = (isset($apexnb_lite_data['edn_subs_custom']['description']) && $apexnb_lite_data['edn_subs_custom']['description'] != '')?$apexnb_lite_data['edn_subs_custom']['description']:'';
$but_text = (isset($apexnb_lite_data['edn_subs_custom']['but_text']) && $apexnb_lite_data['edn_subs_custom']['but_text'] != '')?$apexnb_lite_data['edn_subs_custom']['but_text']:'';
$but_email_placeholder = (isset($apexnb_lite_data['edn_subs_custom']['but_email_placeholder']) && $apexnb_lite_data['edn_subs_custom']['but_email_placeholder'] != '')?$apexnb_lite_data['edn_subs_custom']['but_email_placeholder']:'';
$but_email_err = (isset($apexnb_lite_data['edn_subs_custom']['but_email_error_message']) && $apexnb_lite_data['edn_subs_custom']['but_email_error_message'] != '')?$apexnb_lite_data['edn_subs_custom']['but_email_error_message']:'';
$but_already_subs = (isset($apexnb_lite_data['edn_subs_custom']['but_already_subs']) && $apexnb_lite_data['edn_subs_custom']['but_already_subs'] != '')?$apexnb_lite_data['edn_subs_custom']['but_already_subs']:'';
$but_check_to_conform = (isset($apexnb_lite_data['edn_subs_custom']['but_check_to_conform']) && $apexnb_lite_data['edn_subs_custom']['but_check_to_conform'] != '')?$apexnb_lite_data['edn_subs_custom']['but_check_to_conform']:'';
$but_check_to_conform = (isset($apexnb_lite_data['edn_subs_custom']['but_check_to_conform']) && $apexnb_lite_data['edn_subs_custom']['but_check_to_conform'] != '')?$apexnb_lite_data['edn_subs_custom']['but_check_to_conform']:'';
$but_sending_fail = (isset($apexnb_lite_data['edn_subs_custom']['but_sending_fail']) && $apexnb_lite_data['edn_subs_custom']['but_sending_fail'] != '')?$apexnb_lite_data['edn_subs_custom']['but_sending_fail']:'';
$thank_text = (isset($apexnb_lite_data['edn_subs_custom']['thank_text']) && $apexnb_lite_data['edn_subs_custom']['thank_text'] != '')?$apexnb_lite_data['edn_subs_custom']['thank_text']:'';
$from_name = (isset($apexnb_lite_data['edn_subs_custom']['from_name']) && $apexnb_lite_data['edn_subs_custom']['from_name'] != '')?$apexnb_lite_data['edn_subs_custom']['from_name']:'';
$from_email = (isset($apexnb_lite_data['edn_subs_custom']['from_email']) && $apexnb_lite_data['edn_subs_custom']['from_email'] != '')?$apexnb_lite_data['edn_subs_custom']['from_email']:'';
//$email_subject = (isset($apexnb_lite_data['edn_subs_custom']['email_subject']) && $apexnb_lite_data['edn_subs_custom']['email_subject'] != '')?$apexnb_lite_data['edn_subs_custom']['email_subject']:'';
//$message = (isset($apexnb_lite_data['edn_subs_custom']['message']) && $apexnb_lite_data['edn_subs_custom']['message'] != '')?$apexnb_lite_data['edn_subs_custom']['message']:'';
$confirm = (isset($apexnb_lite_data['edn_subs_custom']['confirm']) && $apexnb_lite_data['edn_subs_custom']['confirm'] == 1)?'1':'0';

?>
<div class="edn-row">
     <div class="edn-subscribe-form-wrap">
             <!-- SUB custom-form -->
              <div class="edn-subs-from" id="edn-subs-custom-form">   
                <div class="header_section">
                    <input type="hidden" name="edn_subs_choose" value="subs-c-form"/>
                    <?php _e('Custom Form',APEXNBL_TD);?>
                </div>


              <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                         <div class="edn-field">
                      <div class="edn-field-label"><label><?php _e('Form Header Text',APEXNBL_TD);?></label></div>
                    <div class="edn-field-input">
                        <input type="text" name="edn_subs_custom[head_text]" 
                        placeholder="<?php _e('E.g: Subscribe Newsletter',APEXNBL_TD);?>" 
                        value="<?php echo esc_attr($head_text);?>" />
                    </div>
                    </div>
                </div>
            </div>
             <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label"> <label><?php _e('Description',APEXNBL_TD);?></label></div>
                        <div class="edn-field-input">
                          <textarea  name="edn_subs_custom[description]" placeholder="<?php _e('E.g:Get Latest Deal, Offers & Product Updates via Email',APEXNBL_TD);?>"><?php echo esc_attr($description);?></textarea>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label"><label><?php _e('Button Text',APEXNBL_TD);?></label></div>
                        <div class="edn-field-input">
                           <input type="text" name="edn_subs_custom[but_text]" 
                           placeholder="<?php _e('E.g: Subscribe',APEXNBL_TD);?>" value="<?php echo esc_attr($but_text); ?>" />
                        </div>
                        </div>
                    </div>
                </div>

                 <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label"><label><?php _e('Email Placeholder',APEXNBL_TD);?></label></div>
                        <div class="edn-field-input">
                        <input type="text" name="edn_subs_custom[but_email_placeholder]" 
                        placeholder="<?php _e('e.g.,Email Address',APEXNBL_TD);?>" 
                        value="<?php echo esc_attr($but_email_placeholder);?>"  />
                        </div>
                        </div>
                    </div>
                </div>

                 <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label"> <label><?php _e('Email Error Message',APEXNBL_TD);?></label></div>
                        <div class="edn-field-input">
                           <input type="text" name="edn_subs_custom[but_email_err]" 
                           placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNBL_TD);?>" 
                           value="<?php echo esc_attr($but_email_err);?>" />
                        </div>
                        </div>
                    </div>
                </div>
                 <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label"><label><?php _e('Already Subscibed Error Message',APEXNBL_TD);?></label>
                        <p class="edn-note"><?php _e('Success message to users if email address provided is already subscibed one.',APEXNBL_TD);?></p></div>
                        <div class="edn-field-input">
                          <input type="text" name="edn_subs_custom[but_already_subs]" 
                          placeholder="<?php _e('e.g.,You have already subscribed.',APEXNBL_TD);?>" 
                          value="<?php echo esc_attr($but_already_subs);?>" />
                        </div>
                        </div>
                    </div>
                </div>
                 <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label"> 
                          <label><?php _e('Mail Confirmation Success Message',APEXNBL_TD);?></label>
                          <p class="edn-note"><?php _e('Success message to users for confirmation to check mail.',APEXNBL_TD);?></p>
                        </div>
                        <div class="edn-field-input">
                         <input type="text" name="edn_subs_custom[but_check_to_conform]" 
                         placeholder="<?php _e('e.g.,Please check your mail to confirm.',APEXNBL_TD);?>" 
                         value="<?php echo esc_attr($but_check_to_conform );?>"  />
                        </div>
                        </div>
                    </div>
                </div>
                    <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label"> 
                          <label><?php _e('Sending Fail Error Message',APEXNBL_TD);?></label>
                        </div>
                        <div class="edn-field-input">
                         <input type="text" name="edn_subs_custom[but_sending_fail]" 
                         placeholder="<?php _e('e.g.,Confirmation sending fail.',APEXNBL_TD);?>" 
                         value="<?php echo esc_attr($but_sending_fail);?>" />
                        </div>
                        </div>
                    </div>
                </div>
              
                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field">
                    <div class="edn-field">
                        <div class="edn-field-label">
                        <label><?php _e('Thank You Note',APEXNBL_TD);?></label>
                         <p class="edn-note"><?php _e('Note: If above fields left empty, default value set will be placeholder value.',APEXNBL_TD);?></p>
                         </div>
                            <div class="edn-field-input">
                            <input type="text" placeholder="<?php _e('e.g.,Thank you for subscribe us.',APEXNBL_TD);?>" 
                            name="edn_subs_custom[thank_text]" value="<?php echo esc_attr($thank_text);?>">   
                       
                        </div>
                        </div>
                    </div>
                </div>     



                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field">
                        <div class="edn-field">
                               <div class="edn-field-label">
                                <label class="edn-label-inline" for="custom_confirm">
                                <?php _e('Enable Check Confirmation', APEXNBL_TD); ?>
                                 </label>
                                  <p class="edn-note"><?php _e('Check if you want users to send confirmation email.',APEXNBL_TD);?></p>
                                </div>
                              <div class="edn-field-input">
                        <div class="apexnb-switch">
                                <input type="checkbox" class="edn_subs_confirm" id="custom_confirm" name="edn_subs_custom[confirm]"
                                 value="1" <?php if(isset($confirm) && $confirm == 1){echo 'checked="checked"';}?> />
                                 <label for="custom_confirm"></label>
                              
                           </div>
                           </div>
                        </div>
                    </div>
                         <div class="edn-subs-confirm-fields" id="edn-subs-confirm-fields" style="display: none;"> 
                                <div class="edn-field">
                                    <div class="edn-field-label">
                                       <label class="edn-label-inline"><?php _e('From Name', APEXNBL_TD); ?></label>
                                        <p class="edn-note"><?php _e('Fill the site name you want to display in confirmation email.If left empty, default value will be set as your site name.',APEXNBL_TD);?></p>
                                    </div>
                                    <div class="edn-field-input">
                                        <input type="text" class="edn_subs_confirm_name" name="edn_subs_custom[from_name]" 
                                        value="<?php echo esc_attr($from_name);?>" placeholder="<?php echo get_bloginfo( 'name' ); ?>"/>
                                       
                                    </div>
                                </div>
                
                                <div class="edn-field">
                                <div class="edn-field-label">
                                    <label class="edn-label-inline"><?php _e('From Email', APEXNBL_TD); ?> </label>
                                     <p class="edn-note"><?php _e('Fill email you want to display in confirmation email.',APEXNBL_TD);?></p>
                                   </div>
                                    <div class="edn-field-input">
                                     <input type="text" class="edn_subs_confirm_email" name="edn_subs_custom[from_email]" value="<?php echo esc_attr($from_email);?>" placeholder="noreply@siteurl.com"/>
                                       
                                   </div>
                               </div>
                 </div>
                </div>


                
            </div>
            <!-- SUB custom-form -->
 
        </div><!-- .edn-subscribe-form-wrap -->
  

</div>



             