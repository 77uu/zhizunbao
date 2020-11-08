<?php defined('ABSPATH') or die("No script kiddies please!");
if(isset($edn_bar_data['edn_text_display_mode']) && $edn_bar_data['edn_text_display_mode']=='static'){
if(isset($edn_bar_data['edn_static']['call_action_button'])){
  if($edn_bar_data['edn_static']['call_action_button'] == "contact"){
   
      if(isset($edn_bar_data['edn_static']['contact_choose']) && $edn_bar_data['edn_static']['contact_choose'] =='c-form'){
         $cctype = "apexnb-ccustomform-wrapper";
      }else{
        $cctype = "apexnb-ccform7-wrapper";
      }

  }
}
$template_types = (isset($edn_bar_data['edn_bar_type']) && $edn_bar_data['edn_bar_type'] != '')?$edn_bar_data['edn_bar_type']:'2'; // cusotm or available as 1 or 2
$templatess = (isset($edn_bar_data['edn_bar_template']) && $edn_bar_data['edn_bar_template'] != '')?$edn_bar_data['edn_bar_template']:'1'; // cusotm or available as 1 or 2
?>
<div class="apexnb-ccform <?php if($template_types == '') echo 'custom-template edn-popup-form'; else echo 'edn-template-'.$templatess;?> edn-popup-form" data-formtype="apexnb-static-custom" data-barid="<?php echo $nb_id;?>">
 <div class="edn-contact-lightbox" id="edn-static-cf-btn-<?php echo $nb_id;?>-lightbox" style="display: none;">
  <div class="ednpro_overlay"></div>
    <div class="edn-contact-lightbox-inner-wrap <?php echo $cctype;?>" id="edn-contact-lightbox-inner-wrap-<?php echo $nb_id;?>">
        <div class="edn-contact-lightbox-inner-content edn-contact-lightbox-inner-wrap apexnb-ccustomform-wrapper <?php echo $cctype;?>">
            <?php if(isset($edn_bar_data['edn_static']['call_action_button']) && $edn_bar_data['edn_static']['call_action_button']=='contact'){?>
            <div class="edn-contact-form-wrap">
               <a href="javascript:void(0)" class="edn-contact-close" aria-label="font close button"><i class="fa fa-close"></i></a>
               <?php // case for default form
                    if($edn_bar_data['edn_static']['contact_choose']=='c-form'){
                      if(isset($edn_bar_data['edn_static']['name_label'])  && $edn_bar_data['edn_static']['name_label'] != ''){
                           $name_label = $edn_bar_data['edn_static']['name_label'];
                      }else{
                          $name_label = "Name";
                      }
                      if(isset($edn_bar_data['edn_static']['email_label'])  && $edn_bar_data['edn_static']['email_label'] != ''){
                           $email_label = $edn_bar_data['edn_static']['email_label'];
                      }else{
                          $email_label = "Email";
                      }
                      if(isset($edn_bar_data['edn_static']['msg_label']) && $edn_bar_data['edn_static']['msg_label'] != ''){
                           $msg_label = $edn_bar_data['edn_static']['msg_label'];
                      }else{
                          $msg_label = "Message";
                      }
                      if(isset($edn_bar_data['edn_static']['name_placeholder']) && $edn_bar_data['edn_static']['name_placeholder'] != ''){
                           $name_placeholder = $edn_bar_data['edn_static']['name_placeholder'];
                      }else{
                          $name_placeholder = "Your Name";
                      }
                      if(isset($edn_bar_data['edn_static']['name_error_msg']) && $edn_bar_data['edn_static']['name_error_msg'] != ''){
                           $name_error = $edn_bar_data['edn_static']['name_error_msg'];
                      }else{
                          $name_error = "Please enter your name.";
                      }
                      if(isset($edn_bar_data['edn_static']['email_placeholder']) && $edn_bar_data['edn_static']['email_placeholder'] != ''){
                           $email_placeholder = $edn_bar_data['edn_static']['email_placeholder'];
                      }else{
                          $email_placeholder = "Your Email Address";
                      }
                      if(isset($edn_bar_data['edn_static']['email_error_msg']) && $edn_bar_data['edn_static']['email_error_msg'] != ''){
                           $email_error = $edn_bar_data['edn_static']['email_error_msg'];
                      }else{
                          $email_error = "Please enter valid email address.";
                      }
                      if(isset($edn_bar_data['edn_static']['msg_placeholder']) && $edn_bar_data['edn_static']['msg_placeholder'] != ''){
                           $msg_placeholder = $edn_bar_data['edn_static']['msg_placeholder'];
                      }else{
                          $msg_placeholder = "Your Message";
                      }
                      if(isset($edn_bar_data['edn_static']['msg_error']) && $edn_bar_data['edn_static']['msg_error'] != ''){
                           $msg_error = $edn_bar_data['edn_static']['msg_error'];
                      }else{
                           $msg_error = "Please enter message.";
                      }
                  
                      if(isset($edn_bar_data['edn_static']['success_message']) && $edn_bar_data['edn_static']['success_message']!=''){
                        $success_msg = $edn_bar_data['edn_static']['success_message'];
                        }else{
                        $success_msg = 'Your message has been successfully sent.';
                        }
                        if(isset($edn_bar_data['edn_static']['sendfail_msg']) && $edn_bar_data['edn_static']['sendfail_msg']!=''){
                        $sendfail_msg = $edn_bar_data['edn_static']['sendfail_msg'];
                        }else{
                        $sendfail_msg = 'Error sending message.';
                        }
                                    
                        ?>
                         <div class="edn-default-form-popup">
                            <div class="edn-row">
                                <div class="edn-col-full">
                                    <div class="edn-field-wrapper edn-form-field">
                                     <div class="clearfix">
                                        <label><?php echo esc_attr($name_label);?></label>
                                        <div class="edn-field">
                                            <input type="text" name="edn_contact_us_name" placeholder="<?php  _e(esc_attr($name_placeholder),APEXNBL_TD);?>" 
                                            data-name-error-msg="<?php _e(esc_attr($name_error),APEXNBL_TD);?>" />
                                        </div>
                                         </div>
                                        <div class="edn_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="edn-row">
                                <div class="edn-col-full">
                                    <div class="edn-field-wrapper edn-form-field">
                                    <div class="clearfix">
                                        <label><?php echo esc_attr($email_label);?></label>
                                        <div class="edn-field">
                                            <input type="text" name="edn_contact_us_email" placeholder="<?php _e(esc_attr($email_placeholder),APEXNBL_TD);?>" 
                                            data-email-error-msg="<?php _e(esc_attr($email_error),APEXNBL_TD);?>"
                                            data-email-valid-msg="<?php _e(esc_attr($email_error),APEXNBL_TD);?>" />
                                        </div>
                                        </div>
                                        <div class="edn_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="edn-row">
                                <div class="edn-col-full">
                                    <div class="edn-field-wrapper edn-form-field">
                                    <div class="clearfix">
                                    <div class="clearfix">
                                        <label><?php echo esc_attr($msg_label);?></label>
                                        <div class="edn-field">
                                            <textarea name="edn_contact_us_message" id="edn_contact_us_<?php echo $nb_id;?>_message" placeholder="<?php _e(esc_attr($msg_placeholder),APEXNBL_TD);?>"
                                             data-message-error="<?php _e(esc_attr($msg_error),APEXNBL_TD);?>"></textarea>
                                             <input type="hidden" name="edn_required_message" id="edn_required_message-<?php echo $nb_id;?>" 
                                                    value="<?php if(isset($edn_bar_data['edn_static']['msg_required'])) echo esc_attr($edn_bar_data['edn_static']['msg_required']);?>"/>
                                        </div>
                                        </div>
                                          <div class="edn_error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <div class="edn-col-full edn-static-button">
                              <div class="edn-well">
                                  <div class="edn-field-wrapper edn-form-field">
                                      <div class="edn-field">
                                          
                                          <?php 
                                          /**
                                           * Creating a nonce field
                                           * */
                                           wp_nonce_field('edn-contact-us-nonce','edn_contact_us_nonce_field');
                                          ?>
                                          <?php
                                              if(isset($edn_bar_data['edn_static']['name_required']) && isset($edn_bar_data['edn_static']['email_required'])){
                                                  ?>
                                                      <input type="button" id="edn-both-required-submit-<?php echo $nb_id;?>" class="edn-contact-submit" value="<?php _e('Send',APEXNBL_TD);?>" />
                                                      
                                                  <?php
                                              }elseif(isset($edn_bar_data['edn_static']['name_required'])){
                                                  ?>
                                                      <input type="button" id="edn-name-required-submit-<?php echo $nb_id;?>" class="edn-contact-submit" value="<?php _e('Send',APEXNBL_TD);?>" />
                                                  <?php
                                              }elseif(isset($edn_bar_data['edn_static']['email_required'])){
                                                  ?>
                                                      <input type="button" id="edn-email-required-submit-<?php echo $nb_id;?>" class="edn-contact-submit" value="<?php _e('Send',APEXNBL_TD);?>" />
                                                  <?php
                                              }else{
                                                  ?>
                                                      <input type="button" id="edn-contact-us-submit-<?php echo $nb_id;?>" class="edn-contact-submit" value="<?php _e('Send',APEXNBL_TD);?>" />
                                                  <?php
                                              }
                                          ?>
                                        <div class="edn-loader">
                                         <img src="<?php echo APEXNBL_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-ajax-loader"/>
                                        </div>
                                      </div>
                                      <div class="edn-success" style="display: none;"><?php _e(esc_attr($success_msg),APEXNBL_TD);?></div>
                                      <div class="edn-error" style="display: none;"><?php _e(esc_attr($sendfail_msg),APEXNBL_TD);?></div>
                                  </div><!--aps-field-wrapper-->
                              </div>
                          </div>
                    </div>
                <?php
                }else{
                    ?>
                     <div class="contactform-7-popup">
                        <div class="edn-row">
                            <div class="edn-col-full">
                                <div class="edn-field-wrapper edn-form-field">
                                    <?php
                                    if(isset($edn_bar_data['edn_static']['form_shortcode']) && $edn_bar_data['edn_static']['form_shortcode'] != ''){
                                        $short_code = $edn_bar_data['edn_static']['form_shortcode'];
                                        $final_shortcode = str_replace('\"','"',$short_code);
                                       
                                    }else{
                                           $final_shortcode = "";
                                    }
                                       echo do_shortcode($final_shortcode);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
        <?php } ?>
            </div>  
        </div>
       </div><!-- end of edn-contact-lightbox -->  
       </div>
<?php } ?>