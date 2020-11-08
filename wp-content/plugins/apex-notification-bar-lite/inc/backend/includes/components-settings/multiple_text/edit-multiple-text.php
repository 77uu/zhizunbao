<?php defined('ABSPATH') or die("No script kiddies please!");?>
<ul class="edn-append-mcontent-prev">
            <?php 
            // echo "<pre>";
            // print_r($apexnb_lite_data['edn_multiple']);
                if(!empty($apexnb_lite_data['edn_multiple'])){
                if(isset($apexnb_lite_data['edn_multiple']['text_content']) && $apexnb_lite_data['edn_multiple']['text_content']){
                    foreach($apexnb_lite_data['edn_multiple']['text_content'] as $key => $content)
                    {
                        $substr_content = substr(strip_tags($content),0,8);
                        ?>
                        <li class="edn-sortable-content">
                            <div class="edn-content-head" id="edn-c-head_<?php echo $key;?>">
                                <span class="edn-content-title"><?php echo $substr_content.'...';?> </span>
                                <span class="edn-content-list-controls"><span class="edn-arrow-down edn-arrow button button-secondary"><i class="dashicons dashicons-arrow-down"></i></span>&nbsp;&nbsp;<span class="edn-delete-content button button-secondary" aria-label="delete content"><i class="dashicons dashicons-trash"></i></span></span>
                            </div>
                            <div class="edn-multiple-slide-down" style="display: none;">
                                <div class="edn-row">
                                    <div class="edn-col-full">
                                        <div class="edn-field-wrapper edn-form-field">
                                            <div class="edn-field">
                                                <?php
                                                    $settings = array('textarea_name' => 'edn_multiple[text_content]['.$key.']','media_buttons' => false,);
                                                    wp_editor($content,'edn-edit-multiple-text'.$key,$settings); 
                                                ?>
                                            </div>
                                            <div class="edn-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="edn-row">
                                    <div class="edn-col-full">
                                        <div class="edn-field-wrapper edn-form-field">
                                            <div>
                                                <label class="edn-label-inline">
                                                    <?php _e('Show Call to Action', APEXNBL_TD); ?>
                                                    <input type="checkbox" name="edn_multiple[call_to_action][<?php echo $key?>]" class="edn-show-slide-call-button" id="edn-sscb_<?php echo $key?>" value="1" <?php if(isset($apexnb_lite_data['edn_multiple']['call_to_action'][$key])&&$apexnb_lite_data['edn_multiple']['call_to_action'][$key]==1){echo 'checked="checked"';}?> />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="edn-slide-call-to-action-type edn-sctat_<?php echo $key;?>" style="display: none;">
                                        <div class="edn-col-full">
                                            <div class="edn-field-wrapper edn-form-field">
                                               <div class="header_section">
                                                <label><?php _e('Call to Action Type', APEXNBL_TD); ?></label>
                                                </div>
                                                <div class="edn-field">
                                                    <label class="edn-label-inline">
                                                        <input type="radio" name="edn_multiple[call_to_acction_type][<?php echo $key;?>]" class="edn-slide-call-action-type" id="edn-ca-cu_<?php echo $key?>" value="custom" <?php if($apexnb_lite_data['edn_multiple']['call_to_acction_type'][$key]=='custom'){echo 'checked="checked"';}?> />
                                                        <?php _e('Custom Button', APEXNBL_TD);?>
                                                    </label>
                                                    <label class="edn-label-inline">
                                                        <input type="radio" name="edn_multiple[call_to_acction_type][<?php echo $key;?>]" class="edn-slide-call-action-type" id="edn-ca-co_<?php echo $key?>" value="contact" <?php if($apexnb_lite_data['edn_multiple']['call_to_acction_type'][$key]=='contact'){ echo 'checked="checked"';}?> />
                                                        <?php _e('Contact Form', APEXNBL_TD); ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    // echo "<pre>";
                                    // print_r($apexnb_lite_data['edn_multiple']);
                                    ?>
                                    <div class="end-slide-call-to-action-block edn-sctat_<?php echo $key;?>" style="display: none;">
                                        <div id="edn-slide-custom-button-block" class="edn-slide-call-action edn-slide-call-action-<?php echo $key?> edn-custom-but-block-<?php echo $key?>">
                                            <div class="edn-col-full">
                                                <div class="edn-field-wrapper edn-form-field">
                                                    <label><?php _e('Link Button Text',APEXNBL_TD);?></label>
                                                    <div class="edn-field">
                                                        <input type="text" name="edn_multiple[link_but_text][<?php echo $key?>]" placeholder="<?php _e('e.g: READ MORE',APEXNBL_TD);?>"
                                                         value="<?php if(isset($apexnb_lite_data['edn_multiple']['link_but_text'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['link_but_text'][$key])?>" />
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class="edn-col-full">
                                                <div class="edn-field-wrapper edn-form-field">
                                                    <label><?php _e('Link Button URL',APEXNBL_TD);?></label>
                                                    <div class="edn-field">
                                                        <input type="text" name="edn_multiple[link_url][<?php echo $key?>]" value="<?php if(isset($apexnb_lite_data['edn_multiple']['link_url'][$key])) echo esc_url($apexnb_lite_data['edn_multiple']['link_url'][$key])?>" placeholder="<?php _e('e.g: https://www.accesspressthemes.com',APEXNBL_TD);?>"/>
                                                    </div>
                                                </div>
                                            </div>   
                                               <div class="edn-col-full">
                                            <div class="edn-field-wrapper edn-form-field">
                                                <label><?php _e('Link Target',APEXNBL_TD);?></label>
                                                <div class="edn-field">
                                                    <select id="edn-link-target" name="edn_multiple[link_target][<?php echo $key?>]">
                                                     <option value="_blank" <?php if(isset($apexnb_lite_data['edn_multiple']['link_target'][$key]) && $apexnb_lite_data['edn_multiple']['link_target'][$key] == "_blank") echo "selected='selected'";?>><?php _e('_blank',APEXNBL_TD);?></option>
                                                     <option value="_self" <?php if(isset($apexnb_lite_data['edn_multiple']['link_target'][$key]) && $apexnb_lite_data['edn_multiple']['link_target'][$key] == "_self") echo "selected='selected'";?>><?php _e('_self',APEXNBL_TD);?></option>
                                                     <option value="_parent" <?php if(isset($apexnb_lite_data['edn_multiple']['link_target'][$key]) && $apexnb_lite_data['edn_multiple']['link_target'][$key] == "_parent") echo "selected='selected'";?>><?php _e('_parent',APEXNBL_TD);?></option>
                                                     <option value="_top" <?php if(isset($apexnb_lite_data['edn_multiple']['link_target'][$key]) && $apexnb_lite_data['edn_multiple']['link_target'][$key] == "_top") echo "selected='selected'";?>><?php _e('_top',APEXNBL_TD);?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>  

    </div><!-- #edn-slide-custom-button-block -->

    <div id="edn-slide-contact-button-block" class="edn-slide-call-action edn-slide-call-action-<?php echo $key?> edn-contact-but-block-<?php echo $key?>" style="display: none;">
        <div class="edn-row">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Contact Form Type', APEXNBL_TD); ?></label>
                    <div class="edn-field">
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_multiple[contact_form_type][<?php echo $key?>]" class="edn-slide-contact-choose" id="edn-cf_<?php echo $key?>" value="c-form" <?php if(isset($apexnb_lite_data['edn_multiple']['contact_form_type'][$key]) && $apexnb_lite_data['edn_multiple']['contact_form_type'][$key]=='c-form'){echo 'checked="checked"';}?> />
                            <?php _e('Default Form',APEXNBL_TD);?>
                        </label>
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_multiple[contact_form_type][<?php echo $key?>]" class="edn-slide-contact-choose" id="edn-cf7_<?php echo $key?>" value="form-7" <?php if(isset($apexnb_lite_data['edn_multiple']['contact_form_type'][$key]) && $apexnb_lite_data['edn_multiple']['contact_form_type'][$key]=='form-7'){echo 'checked="checked"';}?> />
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
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Contact Button Text',APEXNBL_TD);?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_multiple[contact_btn_text][<?php echo $key?>]" placeholder="<?php _e('e.g:Contact Us',APEXNBL_TD);?>"
                                value="<?php if(isset($apexnb_lite_data['edn_multiple']['contact_btn_text'][$key])){echo esc_attr($apexnb_lite_data['edn_multiple']['contact_btn_text'][$key]);}?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="edn-slide-cotnact-from edn-slide-cotnact-from-<?php echo $key?> edn-slide-cc-form-<?php echo $key?>" id="edn-slide-contact-custom-form">

<!-- added code for prev button click edit multiple form-->
<div class="edn-row">                 
    <div class="edn-col-half">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-col-one-fourth edn-default-form">
                    <label><?php _e('Name Label',APEXNBL_TD);?></label>
                    <div class="edn-field">
                    <input type="text" id="edn-cc-name-label" name="edn_multiple[name_label][<?php echo $key?>]"
                     value="<?php if(isset($apexnb_lite_data['edn_multiple']['name_label'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['name_label'][$key]);?>" placeholder="<?php _e('e.g:Name',APEXNBL_TD);?>"/>

                    </div>
                </div>
                <div class="edn-col-one-fourth edn-default-form">
                    <label><?php _e('Email Label',APEXNBL_TD);?></label>
                    <div class="edn-field">
                    <input type="text" id="edn-cc-email-label" name="edn_multiple[email_label][<?php echo $key?>]"
                     value="<?php if(isset($apexnb_lite_data['edn_multiple']['email_label'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['email_label'][$key]);?>" placeholder="<?php _e('e.g:Email',APEXNBL_TD);?>"/>
                    </div>
                </div>
                <div class="edn-col-one-fourth edn-default-form">

                    <label><?php _e('Message Label',APEXNBL_TD);?></label>
                    <div class="edn-field">
                    <input type="text" id="edn-cc-msg-label" name="edn_multiple[msg_label][<?php echo $key?>]"
                     value="<?php if(isset($apexnb_lite_data['edn_multiple']['msg_label'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['msg_label'][$key]);?>" placeholder="<?php _e('Message',APEXNBL_TD);?>"/>
                    </div>


                </div>
        </div>
  </div>
<div class="edn_clear"></div>
<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Name Placeholder',APEXNBL_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-name-placeholder" name="edn_multiple[name_placeholder][<?php echo $key?>]"
                   placeholder="<?php _e('e.g:Your Name',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_multiple']['name_placeholder'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['name_placeholder'][$key]);?>" 
            placeholder="<?php _e('e.g.,Enter FullName',APEXNBL_TD);?>"/>
        </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Email Placeholder',APEXNBL_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-email-placeholder" name="edn_multiple[email_placeholder][<?php echo $key?>]" placeholder="<?php _e('e.g:Your Email Address',APEXNBL_TD);?>"
                     value="<?php if(isset($apexnb_lite_data['edn_multiple']['email_placeholder'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['email_placeholder'][$key]);?>"
           placeholder="<?php _e('e.g.,Enter Email Address.',APEXNBL_TD);?>"/>
        </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Message Placeholder',APEXNBL_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-msg-placeholder" name="edn_multiple[message_placeholder][<?php echo $key?>]"
                   placeholder="<?php _e('e.g.,Your Message.',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_multiple']['message_placeholder'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['message_placeholder'][$key]);?>" placeholder="<?php _e('e.g.,Your Message.',APEXNBL_TD);?>"/>
        </div>

        </div>
    </div>
</div>
<div class="edn_clear"></div>
<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Name Error Message',APEXNBL_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-name-error"name="edn_multiple[name_error_message][<?php echo $key?>]"
                    placeholder="<?php _e('e.g:Please enter your name.',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_multiple']['name_error_message'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['name_error_message'][$key]);?>" placeholder="<?php _e('e.g.,Name field is empty.',APEXNBL_TD);?>"/>
        </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Email Error Message',APEXNBL_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-email-error" name="edn_multiple[email_error_message][<?php echo $key?>]"
                    placeholder="<?php _e('e.g: Please enter valid email address',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_multiple']['email_error_message'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['email_error_message'][$key]);?>" placeholder="<?php _e('e.g.,Email Field is empty.',APEXNBL_TD);?>"/>
        </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Valid Email Error Message',APEXNBL_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-email-valid-error" name="edn_multiple[email_valid_error_message][<?php echo $key?>]"
                    placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNBL_TD);?>" value="<?php if(isset($apexnb_lite_data['edn_multiple']['email_valid_error_message'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['email_valid_error_message'][$key]);?>"
            placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNBL_TD);?>"/>
        </div>
     </div>
     <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Message Error Message',APEXNBL_TD);?></label>
            <div class="edn-field">
                <input type="text" id="edn-cc-msg-error" value="<?php if(isset($apexnb_lite_data['edn_multiple']['msg_error'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['msg_error'][$key]);?>" name="edn_multiple[msg_error][<?php echo $key?>]"
                placeholder="<?php _e('Please enter message.',APEXNBL_TD);?>"/>
            </div>
            </div>
    </div>
</div>
<div class="edn_clear"></div>

</div>
<!--class=edn-hide-in-pre-tpl-->
<div class="edn_clear"></div>

<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <div class="edn-col-one-fourth edn-default-form">
            <div>
                <label class="edn-label-inline">
                <?php _e('Name Required',APEXNBL_TD);?>  
                <input type="checkbox" name="edn_multiple[name_required][<?php echo $key?>]" value="1" <?php if(isset($apexnb_lite_data['edn_multiple']['name_required'][$key])&&$apexnb_lite_data['edn_multiple']['name_required'][$key]==1){echo 'checked="checked"';}?> />                                                            

                 </label>
            </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <div>
                <label class="edn-label-inline">
                <?php _e('Email Required',APEXNBL_TD);?> 
                <input type="checkbox" name="edn_multiple[email_required][<?php echo $key?>]" value="1" <?php if(isset($apexnb_lite_data['edn_multiple']['email_required'][$key])&&$apexnb_lite_data['edn_multiple']['email_required'][$key]==1){echo 'checked="checked"';}?> />
                </label>

            </div>
        </div>
         <div class="edn-col-one-fourth edn-default-form">
            <div>
                  <label class="edn-label-inline" for="edn_multiple_message_req">
                   <?php _e('Message Required',APEXNBL_TD);?> 
                    <input type="checkbox" id="edn_multiple_message_req" name="edn_multiple[msg_required][<?php echo $key?>]" value="1" <?php if(isset($apexnb_lite_data['edn_multiple']['msg_required'][$key])&&$apexnb_lite_data['edn_multiple']['msg_required'][$key]==1){echo 'checked="checked"';}?> />                                                            
                 </label>
            </div>
        </div>
    </div>
</div>
<div class="edn_clear"></div>
<div class="edn-row">

<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Send To Email',APEXNBL_TD);?></label>
        <div class="edn-field">
        <input type="text" id="edn-cc-send-mail" name="edn_multiple[send_to_email][<?php echo $key?>]" placeholder="<?php _e('E.g:support@accesspressthemes.com',APEXNBL_TD);?>"
                     value="<?php if(isset($apexnb_lite_data['edn_multiple']['send_to_email'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['send_to_email'][$key]);?>"/>
        <p class="edn-note"><?php _e('Note: If above field left empty,email will be send to admin email.',APEXNBL_TD);?></p>
        </div>
    </div>
</div>
<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Success Message',APEXNBL_TD);?></label>
        <div class="edn-field">
        <input type="text" id="edn-cc-success-message"name="edn_multiple[success_message][<?php echo $key?>]"
                    placeholder="e.g.,Your message has been successfully sent." value="<?php if(isset($apexnb_lite_data['edn_multiple']['success_message'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['success_message'][$key]);?>"placeholder="e.g.,Your message has been successfully sent."/>
        </div>
    </div>
</div>
<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Fail Email Message',APEXNBL_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-send-fail-msg" name="edn_multiple[sendfail_msg][<?php echo $key?>]"
                   placeholder="e.g.,Error sending message." value="<?php if(isset($apexnb_lite_data['edn_multiple']['sendfail_msg'][$key])) echo esc_attr($apexnb_lite_data['edn_multiple']['sendfail_msg'][$key]);?>" placeholder="e.g.,Error sending message."/>
                              
            </div>
    </div>
</div>
</div>

</div>

     <?php  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                         if ( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) { 
                            ?>
     <div class="edn-slide-cotnact-from edn-slide-cotnact-from-<?php echo $key?> edn-slide-cf7-<?php echo $key?>" id="edn-slide-contact-form-7<?php echo $key?>" style="display: none;">
       
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Contact Form 7 Shortcode',APEXNBL_TD);?></label>
                    <div class="edn-field">
                        <?php
                        if(isset($apexnb_lite_data['edn_multiple']['form_shortcode'][$key])){
                            $short_code = $apexnb_lite_data['edn_multiple']['form_shortcode'][$key];
                            $final_shortcode =  str_replace('\"','"',$short_code);
                        }else{
                            $final_shortcode = '';
                        }
                        ?>
                        <input type="text" placeholder="<?php _e('Enter Shortcode generated using Contact form 7 plugin here.',APEXNBL_TD);?>" 
                        name="edn_multiple[form_shortcode][<?php echo $key?>]" value="<?php if(isset($apexnb_lite_data['edn_multiple']['form_shortcode'][$key]) && $apexnb_lite_data['edn_multiple']['form_shortcode'][$key] != ''){echo esc_attr($final_shortcode);}?>" />
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
</div><!-- #edn-contact-button-block -->
                                                              

        </div>
    </div>
</div><!-- .edn-multiple-slide-down -->




</li>
<?php
}
}
}
?>

</ul>