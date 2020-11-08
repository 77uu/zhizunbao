<?php defined('ABSPATH') or die("No script kiddies please!");?>
    <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
                <?php
                    $content = (isset($apexnb_lite_data['edn_static']['text']) && $apexnb_lite_data['edn_static']['text'] != '')?$apexnb_lite_data['edn_static']['text']:'';
                    $settings = array('textarea_name' => 'edn_static[text]','media_buttons' => false,);
                    wp_editor($content,'edn-static-text',$settings); 
                ?>
            </div>
            <div class="edn-error"></div>
        </div>
    </div>
    <?php 
$call_action_button = (isset($apexnb_lite_data['edn_static']['call_action_button']) && $apexnb_lite_data['edn_static']['call_action_button'] != "")?$apexnb_lite_data['edn_static']['call_action_button']:'custom';
    ?>
    <div class="edn-row">
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-field">
                         <div class="edn-field-label-wrap"><label class="edn-label-inline" for="edn_static_cta">
                           <?php _e('Show Call to Action', APEXNBL_TD); ?> </label>
                         </div>
                    <div class="edn-field-input-wrap">
                        <div class="apexnb-switch">
                        <input type="checkbox" name="edn_static[call-to-action]" class="edn-show-call-button"
                         id="edn_static_cta" value="1" <?php if(isset($apexnb_lite_data['edn_static']['call-to-action']) && $apexnb_lite_data['edn_static']['call-to-action']==1){echo 'checked="checked"';}?> />
                     <label for="edn_static_cta"></label>
                     </div>
                     </div>
                </div>
            </div>
        </div>
        <div class="edn-call-to-action-type" style="display: none;">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Call to Action Type', APEXNBL_TD); ?></label>
                    <div class="edn-field">
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_static[call_action_button]" class="edn-call-action-type" value="custom" <?php if($call_action_button=='custom'){echo 'checked="checked"';}?> />
                            <?php _e('Custom Button', APEXNBL_TD); ?>
                        </label>
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_static[call_action_button]" class="edn-call-action-type" value="contact" <?php if($call_action_button=='contact'){echo 'checked="checked"';}?> />
                            <?php _e('Contact Form', APEXNBL_TD); ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="end-call-to-action-block" style="display: none;">
        <div id="edn-custom-button-block" class="edn-call-action">
            <div class="edn-col-full">
                     <div class="edn-field-wrapper edn-field">
                         <div class="edn-field-label">
                            <label><?php _e('Link Button Text',APEXNBL_TD);?></label>
                            <p class="edn-note"><?php _e('If link title Left empty,then default value will be set as READ MORE.',APEXNBL_TD);?></p>
                         </div>
                        <div class="edn-field-input">
                                <input type="text" name="edn_static[but_text]" placeholder="<?php _e('e.g: READ MORE',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_static']['but_text'])) echo esc_attr($apexnb_lite_data['edn_static']['but_text'])?>" />
                       </div>
                    </div>
            </div>   
            <div class="edn-col-full">
                  <div class="edn-field-wrapper edn-field">
                      <div class="edn-field-label"><label><?php _e('Link Button URL',APEXNBL_TD);?></label></div>
                      <div class="edn-field-input">
                           <input type="text" name="edn_static[but_url]" placeholder="<?php _e('e.g: https://www.accesspressthemes.com',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_static']['but_url'])) echo esc_url($apexnb_lite_data['edn_static']['but_url'])?>" />
                        </div>
                    </div>
            </div>    
             <div class="edn-col-full">
                <div class="edn-field-wrapper edn-field">
                       <div class="edn-field-label"><label><?php _e('Link Target',APEXNBL_TD);?></label></div>
                         <div class="edn-field-input">
                             <select name="edn_static[link_target]" class="apexnb-selection">
                               <option value="_blank" <?php if(isset($apexnb_lite_data['edn_static']['link_target']) && $apexnb_lite_data['edn_static']['link_target']=='_blank'){echo 'selected="selected"';}?>><?php _e('_blank',APEXNBL_TD);?></option>
                               <option value="_self" <?php if(isset($apexnb_lite_data['edn_static']['link_target']) && $apexnb_lite_data['edn_static']['link_target']=='_self'){echo 'selected="selected"';}?>><?php _e('_self',APEXNBL_TD);?></option>
                               <option value="_parent" <?php if(isset($apexnb_lite_data['edn_static']['link_target']) && $apexnb_lite_data['edn_static']['link_target']=='_parent'){echo 'selected="selected"';}?>><?php _e('_parent',APEXNBL_TD);?></option>
                               <option value="_top" <?php if(isset($apexnb_lite_data['edn_static']['link_target']) && $apexnb_lite_data['edn_static']['link_target']=='_top'){echo 'selected="selected"';}?>><?php _e('_top',APEXNBL_TD);?></option>
                              </select>

                        </div>
                </div>
            </div>
      
        </div><!-- #edn-custom-button-block -->
        <?php 
$contact_choose = (isset($apexnb_lite_data['edn_static']['contact_choose']) && $apexnb_lite_data['edn_static']['contact_choose'] != "")?esc_attr($apexnb_lite_data['edn_static']['contact_choose']):'c-form';
        ?>
        <div id="edn-contact-button-block" class="edn-call-action" style="display: none;">
            <div class="edn-row">
                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Choose Contact Form type', APEXNBL_TD); ?></label>
                        <div class="edn-field">
                            <label class="edn-label-inline">
                                <input type="radio" name="edn_static[contact_choose]" class="edn-contact-choose" value="c-form" <?php if($contact_choose=='c-form'){echo 'checked="checked"';}?> />
                                <?php _e('Default Form',APEXNBL_TD);?>
                            </label>
                            <label class="edn-label-inline">
                                <input type="radio" name="edn_static[contact_choose]" class="edn-contact-choose" value="form-7" <?php if($contact_choose=='form-7'){echo 'checked="checked"';}?> />
                                <?php _e('Contact Form 7',APEXNBL_TD);?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="edn-row">
                <div class="edn-contact-form-wrap">
                    <div class="edn-row">
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-field">
                                <div class="edn-field-label">
                                <label><?php _e('Contact Button Text',APEXNBL_TD);?></label>
                                </div>
                                <div class="edn-field-input">
                                    <input type="text" name="edn_static[contact_btn_text]" placeholder="<?php _e('e.g:Contact Us',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_static']['contact_btn_text'])){echo esc_attr($apexnb_lite_data['edn_static']['contact_btn_text']);}?>" />
                              
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="edn-cotnact-from" id="edn-contact-custom-form">
                        <div class="edn-row">
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Name Label',APEXNBL_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[name_label]" placeholder="<?php _e('e.g:Name',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_static']['name_label'])) echo esc_attr($apexnb_lite_data['edn_static']['name_label'])?>" />
                                    </div>
                                   </div>
                                   <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Name Placeholder',APEXNBL_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[name_placeholder]" placeholder="<?php _e('e.g:Your Name',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_static']['name_placeholder'])) echo esc_attr($apexnb_lite_data['edn_static']['name_placeholder'])?>" />
                                    </div>
                                    </div>
                                   <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Name Error Message',APEXNBL_TD);?></label>
                                    <div class="edn-field">
                                     <input type="text" name="edn_static[name_error_msg]" 
                                     placeholder="<?php _e('e.g:Please enter your name.',APEXNBL_TD);?>" 
                                     value="<?php if(isset($apexnb_lite_data['edn_static']['name_error_msg'])) echo esc_attr($apexnb_lite_data['edn_static']['name_error_msg'])?>"/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-form-field">
                                <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Email Label',APEXNBL_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[email_label]" value="<?php if(isset($apexnb_lite_data['edn_static']['email_label'])) echo esc_attr($apexnb_lite_data['edn_static']['email_label'])?>" placeholder="<?php _e('e.g:Email',APEXNBL_TD);?>"/>
                                    </div>
                                    </div>
                                <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Email Placeholder',APEXNBL_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[email_placeholder]" value="<?php if(isset($apexnb_lite_data['edn_static']['email_placeholder'])) echo esc_attr($apexnb_lite_data['edn_static']['email_placeholder'])?>"  placeholder="<?php _e('e.g:Your Email Address',APEXNBL_TD);?>"/>
                                    </div>
                                     </div>
                                <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Email Error Message',APEXNBL_TD);?></label>
                                    <div class="edn-field">
                                     <input type="text" name="edn_static[email_error_msg]" 
                                     placeholder="<?php _e('e.g: Please enter valid email address',APEXNBL_TD);?>"
                                     value="<?php if(isset($apexnb_lite_data['edn_static']['email_error_msg'])) echo esc_attr($apexnb_lite_data['edn_static']['email_error_msg'])?>"/>
                                    </div>
                                </div>
                                </div>
                            </div>
                        
                        
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-col-one-fourth edn-default-form">
                                    <div class="edn-field">
                                         <div class="edn-field-label-wrap">
                                            <label class="edn-label-inline" for="edn_static_name_req">
                                            <?php _e('Name Required',APEXNBL_TD);?></label>
                                            </div>
                                              <div class="edn-field-input-wrap">
                                               <div class="apexnb-switch">  
                                                <input type="checkbox" id="edn_static_name_req"  name="edn_static[name_required]" value="1" <?php if(isset($apexnb_lite_data['edn_static']['name_required'])&&$apexnb_lite_data['edn_static']['name_required']==1){echo 'checked="checked"';}?> />
                                                <label for="edn_static_name_req"></label>
                                               </div>
                                              </div>
                                    </div>
                                    </div>
                                    <div class="edn-col-one-fourth edn-default-form">
                                    <div class="edn-field">
                                        <div class="edn-field-label-wrap">
                                        <label class="edn-label-inline" for="edn_static_email_req">
                                            <?php _e('Email Required',APEXNBL_TD);?></label>
                                        </div> 
                                    <div class="edn-field-input-wrap">
                                        <div class="apexnb-switch">  
                                            <input type="checkbox" id="edn_static_email_req" name="edn_static[email_required]" value="1" <?php if(isset($apexnb_lite_data['edn_static']['email_required'])&&$apexnb_lite_data['edn_static']['email_required']==1){echo 'checked="checked"';}?> />
                                        <label for="edn_static_email_req"></label>
                                           </div>
                                     </div>

                                    </div>
                                    </div>
                                     <div class="edn-col-one-fourth edn-default-form">
                                    <div class="edn-field">
                                      <div class="edn-field-label-wrap">
                                        <label class="edn-label-inline" for="edn_static_message_req">
                                            <?php _e('Message Required',APEXNBL_TD);?> </label>
                                      </div>
                                     <div class="edn-field-input-wrap">
                                        <div class="apexnb-switch">  
                                        <input type="checkbox"  id="edn_static_message_req" name="edn_static[msg_required]" value="1" <?php if(isset($apexnb_lite_data['edn_static']['msg_required'])&&$apexnb_lite_data['edn_static']['msg_required']==1){echo 'checked="checked"';}?> />
                                         <label for="edn_static_message_req"></label>
                                           </div>
                                     </div>
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                      
                         <div class="edn_clear"></div>
                            <div class="edn-col-half edn-clear">
                                <div class="edn-field-wrapper edn-form-field">
                                 <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Message Label',APEXNBL_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[msg_label]" value="<?php if(isset($apexnb_lite_data['edn_static']['msg_label'])) echo esc_attr($apexnb_lite_data['edn_static']['msg_label'])?>" placeholder="<?php _e('Message',APEXNBL_TD);?>"/>
                                    </div>
                                  </div>
                                 <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Message Placeholder',APEXNBL_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[msg_placeholder]"  placeholder="<?php _e('Your Message',APEXNBL_TD);?>"
                                        value="<?php if(isset($apexnb_lite_data['edn_static']['msg_placeholder'])) echo esc_attr($apexnb_lite_data['edn_static']['msg_placeholder'])?>" />
                                    </div>
                                    </div>
                                     <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Message Error Message',APEXNBL_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[msg_error]" value="<?php if(isset($apexnb_lite_data['edn_static']['msg_error'])) echo esc_attr($apexnb_lite_data['edn_static']['msg_error'])?>" 
                                        placeholder="<?php _e('Please enter message.',APEXNBL_TD);?>"/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="edn_clear"></div>
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-field">
                                    <div class="edn-field-label">
                                      <label><?php _e('Send To Email',APEXNBL_TD);?></label>
                                      <p class="edn-note"><?php _e('Note: If left empty, email will be send to admin email.',APEXNBL_TD);?></p>
                                    </div>
                                    <div class="edn-field-input">
                                        <input type="text" name="edn_static[send_to_mail]" id="edn-send-mail-field" 
                                        value="<?php if(isset($apexnb_lite_data['edn_static']['send_to_mail'])) echo esc_attr($apexnb_lite_data['edn_static']['send_to_mail'])?>" placeholder="<?php _e('E.g:support@accesspressthemes.com',APEXNBL_TD);?>"/>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-field">
                                     <div class="edn-field-label">
                                       <label><?php _e('Success Message',APEXNBL_TD);?></label>
                                     </div>
                                    <div class="edn-field-input">
                                    <input type="text" id="edn-success-message"name="edn_static[success_message]"
                                                 value="<?php if(isset($apexnb_lite_data['edn_static']['success_message'])) 
                                                 echo esc_attr($apexnb_lite_data['edn_static']['success_message']);?>"
                                                 placeholder="<?php _e('e.g:Your message has been successfully sent.',APEXNBL_TD);?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-field">
                                    <div class="edn-field-label">
                                     <label><?php _e('Fail Email Message',APEXNBL_TD);?></label>
                                     </div>
                                     <div class="edn-field-input">
                                        <input type="text" id="edn-cc-send-fail-msg" name="edn_static[sendfail_msg]"
                                                 value="<?php if(isset($apexnb_lite_data['edn_static']['sendfail_msg']))
                                                  echo esc_attr($apexnb_lite_data['edn_static']['sendfail_msg']);?>" 
                                                  placeholder="<?php _e('e.g:Error sending message.',APEXNBL_TD);?>"/>
                                                          
                                        </div>
                                </div>
                            </div>
                       
                        </div>
                    </div>
                     <div class="edn-cotnact-from" id="edn-contact-form-7" style="display: none;">
                     <?php  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                     if ( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) { 
                        ?>
                   
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                            <div class="edn-field">
                                <div class="edn-field-label"> <label><?php _e('Contact Form 7 Shortcode',APEXNBL_TD);?></label>
                                  <p class="edn-note"><?php _e('Enter Shortcode generated using Contact form 7 plugin here.',APEXNBL_TD);?></p>
                               </div>
                                 <div class="edn-field-input">
                                    <?php
                                    if(isset($apexnb_lite_data['edn_static']['form_shortcode']) && $apexnb_lite_data['edn_static']['form_shortcode'] != ''){
                                       $short_code = $apexnb_lite_data['edn_static']['form_shortcode'];
                                        $final_shortcode = str_replace('\"','"',$short_code);
                                      }else{
                                          $final_shortcode = "";
                                       }
                                    ?>
                                    <input type="text" name="edn_static[form_shortcode]" value="<?php echo esc_attr($final_shortcode)?>" 
                                    />
                                    </div>
                                    
                                </div>
                            </div>
                        </div> 
                   
                    <?php }else{ ?>
                         <p class="edn-note">
                       <?php  _e('Note: Please activate Contact Form 7 Plugin to integrate your shortcode.',APEXNBL_TD); ?>
                        </p>
                        <?php } ?>
                         </div>
                </div>
            </div>
        </div><!-- #edn-contact-button-block -->
</div>
