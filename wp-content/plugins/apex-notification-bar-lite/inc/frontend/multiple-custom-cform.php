<?php defined('ABSPATH') or die("No script kiddies please!");
if(isset($edn_bar_data['edn_text_display_mode']) && $edn_bar_data['edn_text_display_mode']=='multiple'){ ?>
<?php  if(isset($edn_bar_data['edn_multiple']['text_content'])){

$template_types = (isset($edn_bar_data['edn_bar_type']) && $edn_bar_data['edn_bar_type'] != '')?$edn_bar_data['edn_bar_type']:'2'; // cusotm or available as 1 or 2
$templatess = (isset($edn_bar_data['edn_bar_template']) && $edn_bar_data['edn_bar_template'] != '')?$edn_bar_data['edn_bar_template']:'1'; // cusotm or available as 1 or 2

    ?>
<div class="apexnb-ccform <?php if($template_types == '') echo 'custom-template edn-popup-form'; else echo 'edn-template-'.$templatess;?> ednpro-contact-template ednpro-<?php echo $edn_bartype;?>" id="<?php echo $template_class;?>" data-formtype="apexnb-multiple-custom" data-barid="<?php echo $nb_id;?>">
<?php $total_data = count($edn_bar_data['edn_multiple']['text_content']);
    for($i=0; $i<$total_data; $i++){ 
if(isset($edn_bar_data['edn_multiple']['call_to_action'][$i]) && $edn_bar_data['edn_multiple']['call_to_action'][$i] == "1"){
  if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i] == 'contact'){
   
      if(isset($edn_bar_data['edn_multiple']['contact_form_type'][$i]) && $edn_bar_data['edn_multiple']['contact_form_type'][$i] =='c-form'){
         $cctype = "apexnb-ccustomform-wrapper";
      }else{
        $cctype = "apexnb-ccform7-wrapper";
      }

  }
}

 if(isset($edn_bar_data['edn_multiple']['call_to_action'][$i]) && $edn_bar_data['edn_multiple']['call_to_action'][$i] == "1" && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i] == 'contact'){?>
  <div class="edn-contact-lightbox edn-multiple-<?php echo $i;?>" style="display: none;">
  <div class="ednpro_overlay"></div
    <div class="edn-contact-lightbox-inner-wrap <?php echo $cctype;?>" id="edn-contact-lightbox-inner-wrap-<?php echo $nb_id;?>">
    <div class="edn-contact-lightbox-inner-content edn-contact-lightbox-inner-wrap apexnb-ccustomform-wrapper <?php echo $cctype;?>">
    <div class="edn-contact-form-wrap">

    <a href="javascript:void(0)" class="edn-contact-close" aria-label="font close button">

     <i class="fa fa-close"></i>
    </a>
    <?php
    if($edn_bar_data['edn_multiple']['contact_form_type'][$i]=='c-form'){
      if(isset($edn_bar_data['edn_multiple']['name_label'][$i]) && $edn_bar_data['edn_multiple']['name_label'][$i]!=''){
        $name_label = $edn_bar_data['edn_multiple']['name_label'][$i];
        }else{
        $name_label = 'Name';
        }
        if(isset($edn_bar_data['edn_multiple']['email_label'][$i]) && $edn_bar_data['edn_multiple']['email_label'][$i]!=''){
        $email_label = $edn_bar_data['edn_multiple']['email_label'][$i];
        }else{
        $email_label = 'Email';
        }
        if(isset($edn_bar_data['edn_multiple']['msg_label'][$i]) && $edn_bar_data['edn_multiple']['msg_label'][$i]!=''){
        $msg_label = $edn_bar_data['edn_multiple']['msg_label'][$i];
        }else{
        $msg_label = 'Message';
        }
        if(isset($edn_bar_data['edn_multiple']['name_placeholder'][$i]) && $edn_bar_data['edn_multiple']['name_placeholder'][$i]!=''){
        $name_placeholder = $edn_bar_data['edn_multiple']['name_placeholder'][$i];
        }else{
        $name_placeholder = 'Enter FullName';
        }
        if(isset($edn_bar_data['edn_multiple']['email_placeholder'][$i]) && $edn_bar_data['edn_multiple']['email_placeholder'][$i]!=''){
        $email_placeholder = $edn_bar_data['edn_multiple']['email_placeholder'][$i];
        }else{
        $email_placeholder = 'Enter Email Address';
        }
        if(isset($edn_bar_data['edn_multiple']['message_placeholder'][$i]) && $edn_bar_data['edn_multiple']['message_placeholder'][$i]!=''){
        $message_placeholder = $edn_bar_data['edn_multiple']['message_placeholder'][$i];
        }else{
        $message_placeholder = 'Your Message';
        }
        //error message
        if(isset($edn_bar_data['edn_multiple']['name_error_message'][$i]) && $edn_bar_data['edn_multiple']['name_error_message'][$i]!=''){
        $name_error_message = $edn_bar_data['edn_multiple']['name_error_message'][$i];
        }else{
        $name_error_message = 'Name field is empty.';
        }
        if(isset($edn_bar_data['edn_multiple']['email_error_message'][$i]) && $edn_bar_data['edn_multiple']['email_error_message'][$i]!=''){
        $email_error_message = $edn_bar_data['edn_multiple']['email_error_message'][$i];
        }else{
        $email_error_message = 'Email field is empty.';
        }
        if(isset($edn_bar_data['edn_multiple']['email_valid_error_message'][$i]) && $edn_bar_data['edn_multiple']['email_valid_error_message'][$i]!=''){
        $email_valid_error_message = $edn_bar_data['edn_multiple']['email_valid_error_message'][$i];
        }else{
        $email_valid_error_message = 'Please enter valid email address.';
        }
        if(isset($edn_bar_data['edn_multiple']['success_message'][$i]) && $edn_bar_data['edn_multiple']['success_message'][$i]!=''){
        $success_message = $edn_bar_data['edn_multiple']['success_message'][$i];
        }else{
        $success_message = 'Your message has been successfully sent.';
        }
        if(isset($edn_bar_data['edn_multiple']['sendfail_msg'][$i]) && $edn_bar_data['edn_multiple']['sendfail_msg'][$i]!=''){
        $sendfail_msg = $edn_bar_data['edn_multiple']['sendfail_msg'][$i];
        }else{
        $sendfail_msg = 'Error sending message.';
        }
         if(isset($edn_bar_data['edn_multiple']['msg_error'][$i]) && $edn_bar_data['edn_multiple']['msg_error'][$i] != ''){
             $msg_errors = $edn_bar_data['edn_multiple']['msg_error'][$i];
        }else{
             $msg_errors = "Please enter message.";
        }
                  
    ?>
    <div class="edn-default-form-popup">
        <div class="edn-row">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php echo esc_attr($name_label);?></label>
                    <div class="edn-field">
                        <input type="text" name="edn_contact_us_name" id="edn-multi-name-<?php echo $i;?>" 
                        placeholder="<?php _e(esc_attr($name_placeholder),APEXNBL_TD);?>" 
                        data-name-error-msg="<?php _e(esc_attr($name_error_message),APEXNBL_TD);?>" />
                    </div>
                    <div class="edn_error-<?php echo $i;?> edn-error"></div>
                </div>
            </div>
        </div>
        <div class="edn-row">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php echo esc_attr($email_label);?></label>
                    <div class="edn-field">
                        <input type="text" name="edn_contact_us_email" id="edn-multi-email-<?php echo $i;?>" 
                        placeholder="<?php _e(esc_attr($email_placeholder),APEXNBL_TD);?>" 
                        data-email-error-msg="<?php _e(esc_attr($email_error_message),APEXNBL_TD);?>" 
                        data-email-valid-msg="<?php _e(esc_attr($email_valid_error_message),APEXNBL_TD);?>" />
                    </div>
                    <div class="edn_error-<?php echo $i;?> edn-error"></div>
                </div>
            </div>
        </div>
        <div class="edn-row">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php echo esc_attr($msg_label);?></label>
                    <div class="edn-field">
                        <textarea name="edn_contact_us_message" id="edn_contact_us_<?php echo $nb_id;?>_message<?php echo $i;?>" 
                        data-message-error="<?php _e(esc_attr($msg_errors),APEXNBL_TD);?>"
                        placeholder="<?php _e(esc_attr($message_placeholder),APEXNBL_TD);?>"></textarea>
                     <input type="hidden" name="edn_required_message" id="edn_required_message-<?php echo $nb_id;?>-<?php echo $i;?>" 
                          value="<?php if(isset($edn_bar_data['edn_multiple']['msg_required'][$i])) echo esc_attr($edn_bar_data['edn_multiple']['msg_required'][$i]);?>"/>
                    </div>
                    <div class="edn_error-<?php echo $i;?> edn-error"></div>
                </div>
            </div>
        </div>
        <div class="edn-col-full">esc_attr(
            <div class="edn-well">
                <div class="edn-field-wrapper edn-form-field">
                    <div class="edn-field">
                        <input type="hidden" name="edn_contact_us_send_to" value="<?php echo esc_attr($edn_bar_data['edn_multiple']['send_to_email'][$i]);?>" />
                        <?php
                            if(isset($edn_bar_data['edn_multiple']['name_required'][$i]) && isset($edn_bar_data['edn_multiple']['email_required'][$i])){
                                ?>
                                    <input type="button" id="edn-both-required-submit_<?php echo $i;?>_<?php echo $nb_id;?>" class="edn-contact-submit edn-multiple" value="<?php _e('Send',APEXNBL_TD);?>" />
                                    
                                <?php
                            }elseif(isset($edn_bar_data['edn_multiple']['name_required'][$i])){
                                ?>
                                    <input type="button" id="edn-name-required-submit_<?php echo $i;?>_<?php echo $nb_id;?>" class="edn-contact-submit edn-multiple" value="<?php _e('Send',APEXNBL_TD);?>" />
                                <?php
                            }elseif(isset($edn_bar_data['edn_multiple']['email_required'][$i])){
                                ?>
                                    <input type="button" id="edn-email-required-submit_<?php echo $i;?>_<?php echo $nb_id;?>" class="edn-contact-submit edn-multiple" value="<?php _e('Send',APEXNBL_TD);?>" />
                                <?php
                            }else{
                                ?>
                                    <input type="button" id="edn-contact-us-submit_<?php echo $i;?>_<?php echo $nb_id;?>" class="edn-contact-submit edn-multiple" value="<?php _e('Send',APEXNBL_TD);?>" />
                                <?php
                            }
                        ?>
                     <div class="edn-loader">
                       <img src="<?php echo APEXNBL_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-ajax-loader"/>
                      </div>
                    </div>
                    <div class="edn-success" style="display: none;"><?php _e(esc_attr($success_message),APEXNBL_TD);?></div>
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
                     if(isset($edn_bar_data['edn_multiple']['form_shortcode'][$i]) && $edn_bar_data['edn_multiple']['form_shortcode'][$i] != ''){
                         $short_code = $edn_bar_data['edn_multiple']['form_shortcode'][$i];
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
    </div>
    </div>
    <!-- </div> -->
    <!-- end of edn-contact-lightbox -->  
<?php }
    } ?>
</div>
<?php }
} ?>
