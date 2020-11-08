<?php defined('ABSPATH') or die("No script kiddies please!");?>
        <div class="edn-col-full edn-add-mbutton">
            <div class="edn-well">
                <div class="edn-field-wrapper edn-form-field">
                    <div class="edn-field">
                        <input class="button button-secondary" id="edn-add-mcontent" type="button" value="Add Content" />
                    </div>
                </div>
            </div>
        </div>
        <div class="edn-add-multiple-content" style="display: none;">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <div class="edn-field">
                        <?php
                            $settings = array('textarea_name' => '','media_buttons' => false,);
                            wp_editor('','edn-multiple-text',$settings); 
                        ?>
                    </div>
                    <div class="edn-error"></div>
                </div>
            </div>
            <div class="edn-row">
                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field">
                          <div class="edn-field">
                            <div class="edn-field-label">
                              <label class="edn-label-inline" for="edn-show-mcall">
                                <?php _e('Show call to action', APEXNBL_TD); ?> 
                              </label>
                            </div>
                            <div class="edn-field-input">
                              <div class="apexnb-switch">
                                <input type="checkbox" id="edn-show-mcall" class="edn-show-m-call-button" value="1" />
                                <label for="edn-show-mcall"></label>
                              </div>
                            </div>
                       
                       </div>
                    </div>
                </div>
                <div class="edn-m-call-to-action-type" style="display: none;">
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <div class="header_section">
                            <label><?php _e('Call to Action Type', APEXNBL_TD); ?></label>
                            </div>
                            <div class="edn-field">
                                <label class="edn-label-inline">
                                    <input type="radio" name="edn_multi[action_button]" class="edn-call-action-type edn-m-call-action-type" value="custom" checked="checked" />
                                    <?php _e('Custom Button', APEXNBL_TD); ?>
                                </label>
                                <label class="edn-label-inline">
                                    <input type="radio" name="edn_multi[action_button]" class="edn-call-action-type edn-m-call-action-type" value="contact" />
                                    <?php _e('Contact Form', APEXNBL_TD); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="end-m-call-to-action-block" style="display: none;">
                <div id="edn-m-custom-button-block" class="edn-m-call-action">
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-field">
                             <div class="edn-field-label">
                              <label><?php _e('Link Button Text',APEXNBL_TD);?></label>
                            </div>
                            <div class="edn-field-input">
                                <input type="text" id="edn-link-but-text" value="" placeholder="<?php _e('e.g: READ MORE',APEXNBL_TD);?>"/>
                            </div>
                        </div>
                    </div>   
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-field">
                           <div class="edn-field-label">
                              <label><?php _e('Link Button URL',APEXNBL_TD);?></label>
                            </div>
                           <div class="edn-field-input">
                                <input type="text" id="edn-link-url" value="" placeholder="<?php _e('e.g: https://www.accesspressthemes.com',APEXNBL_TD);?>" />
                            </div>
                        </div>
                    </div>    
                      <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-field">
                           <div class="edn-field-label">
                              <label><?php _e('Link Target',APEXNBL_TD);?></label>
                            </div>
                            <div class="edn-field-input">
                                <select id="edn-link-target" class="apexnb-selection">
                                 <option value="_blank"><?php _e('_blank',APEXNBL_TD);?></option>
                                 <option value="_self"><?php _e('_self',APEXNBL_TD);?></option>
                                 <option value="_parent"><?php _e('_parent',APEXNBL_TD);?></option>
                                 <option value="_top"><?php _e('_top',APEXNBL_TD);?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><!-- #edn-m-custom-button-block -->
                <div id="edn-m-contact-button-block" class="edn-m-call-action" style="display: none;">
                    <div class="edn-row">
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Contact Form Type', APEXNBL_TD); ?></label>
                                <div class="edn-field">
                                    <label class="edn-label-inline">
                                        <input type="radio" name="edn_multi[choose]" class="edn-contact-choose edn-m-contact-choose" value="c-form" checked="checked"/>
                                        <?php _e('Default Form',APEXNBL_TD);?>
                                    </label>
                                    <label class="edn-label-inline">
                                        <input type="radio" name="edn_multi[choose]" class="edn-contact-choose edn-m-contact-choose" value="form-7" />
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
                    <input type="text" id="edn-cc-button-text" placeholder="<?php _e('e.g:Contact Us',APEXNBL_TD);?>"/>
                </div>
            </div>
        </div>
    </div>
<!-- custom form for multiple text content start-->
<div class="edn-m-cotnact-from" id="edn-m-contact-custom-form">
    <div class="edn-row">
         <div class="edn-col-half">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-col-one-fourth edn-default-form">
                 <label><?php _e('Name Label',APEXNBL_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-name-label" value="" placeholder="<?php _e('e.g:Name',APEXNBL_TD);?>"/>
                        </div>
               </div>
               <div class="edn-col-one-fourth edn-default-form">
                <label><?php _e('Email Label',APEXNBL_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-email-label" value="" placeholder="<?php _e('e.g:Email',APEXNBL_TD);?>"/>
                        </div>
                </div>
               <div class="edn-col-one-fourth edn-default-form">

                 <label><?php _e('Message Label',APEXNBL_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-msg-label" value="" placeholder="<?php _e('Message',APEXNBL_TD);?>"/>
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
                            <input type="text" id="edn-cc-name-placeholder" value="" 
                            placeholder="<?php _e('e.g:Your Name',APEXNBL_TD);?>"/>
                        </div>
               </div>
               <div class="edn-col-one-fourth edn-default-form">
                <label><?php _e('Email Placeholder',APEXNBL_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-email-placeholder" value="" 
                            placeholder="<?php _e('e.g:Your Email Address',APEXNBL_TD);?>"/>
                        </div>
                </div>
                <div class="edn-col-one-fourth edn-default-form">
                   <label><?php _e('Message Placeholder',APEXNBL_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-msg-placeholder" value="" placeholder="<?php _e('e.g.,Your Message.',APEXNBL_TD);?>"/>
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
                            <input type="text" id="edn-cc-name-error" value="" placeholder="<?php _e('e.g:Please enter your name.',APEXNBL_TD);?>"/>
                        </div>
               </div>
               <div class="edn-col-one-fourth edn-default-form">
                <label><?php _e('Email Error Message',APEXNBL_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-email-error" value="" placeholder="<?php _e('e.g: Please enter email address',APEXNBL_TD);?>"/>
                        </div>
                </div>
                <div class="edn-col-one-fourth edn-default-form">
                <label><?php _e('Valid Email Error Message',APEXNBL_TD);?></label>
                    <div class="edn-field">
                     <input type="text" id="edn-cc-email-valid-error"
                     placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNBL_TD);?>"/>
                    </div>
                  </div>
                   <div class="edn-col-one-fourth edn-default-form">
                            <label><?php _e('Message Error Message',APEXNBL_TD);?></label>
                            <div class="edn-field">
                                <input type="text" id="edn-cc-msg-error" value="" 
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
                                    <div class="edn-field-wrapper edn-field">
                                        <div class="edn-col-one-fourth edn-default-form">
                                        <div>
                                             <div class="edn-field-label">
                                                <label class="edn-label-inline" for="edn-cc-name-required">
                                                 <?php _e('Name Required',APEXNBL_TD);?>  
                                                </label> 
                                               </div> 
                                               <div class="edn-field-input">
                                                <div class="apexnb-switch">  
                                                 <input type="checkbox" id="edn-cc-name-required" value="1" />  
                                                 <label for="edn-cc-name-required"></label>                                                             
                                                </div>
                                                </div>
                                           
                                        </div>
                                        </div>
                                        <div class="edn-col-one-fourth edn-default-form">
                                        <div>
                                            <div class="edn-field-label">
                                            <label class="edn-label-inline" for="edn-cc-email-required">
                                                <?php _e('Email Required',APEXNBL_TD);?>   </label>
                                            </div>
                                             <div class="edn-field-input">
                                                <div class="apexnb-switch">  
                                                 <input type="checkbox" id="edn-cc-email-required" value="1" />   
                                              <label for="edn-cc-email-required"></label>                                                             
                                                </div>
                                                </div>
                                           
                                        </div>
                                        </div>
                                           <div class="edn-col-one-fourth edn-default-form">
                                            <div>
                                                <div class="edn-field-label">
                                                   <label class="edn-label-inline" for="edn-cc-msg-required">
                                                    <?php _e('Message Required',APEXNBL_TD);?>  </label>
                                                    </div>
                                                     <div class="edn-field-input">
                                                      <div class="apexnb-switch"> 
                                                    <input type="checkbox" id="edn-cc-msg-required"  value="1" />
                                                   <label for="edn-cc-msg-required"></label>                                                             
                                                </div>
                                                </div>
                                                
                                            </div>
                                    </div>
                                    </div>
          </div>
          <div class="edn_clear"></div>
     
            <div class="edn-row">
              
                <div class="edn-col-half">
                    <div class="edn-field-wrapper edn-field">
                        <div class="edn-field-label">
                        <label><?php _e('Send To Email',APEXNBL_TD);?></label>
                           <p class="edn-note"><?php _e('Note: If above field left empty,email will be send to admin email.',APEXNBL_TD);?></p>
                        </div>
                       <div class="edn-field-input">
                            <input type="text" id="edn-cc-send-mail" value="" placeholder="<?php _e('E.g:support@accesspressthemes.com',APEXNBL_TD);?>"/>
                        </div>
                    </div>
                </div>
                <div class="edn-col-half">
                    <div class="edn-field-wrapper edn-field">
                       <div class="edn-field-label">
                        <label><?php _e('Success Message',APEXNBL_TD);?></label>
                        </div>
                        <div class="edn-field-input">
                            <input type="text" id="edn-cc-success-message" value="" placeholder="e.g.,Your message has been successfully sent."/>
                        </div>
                    </div>
                </div>
                <div class="edn-col-half">
                    <div class="edn-field-wrapper edn-field">
                    <div class="edn-field-label">
                        <label><?php _e('Fail Email Message',APEXNBL_TD);?></label></div>
                        <div class="edn-field-input">
                            <input type="text" id="edn-cc-send-fail-msg" value="" placeholder="e.g.,Error sending message."/>
                                                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- custom form for multiple text content end-->
                            <div class="edn-m-cotnact-from" id="edn-m-contact-form-7" style="display: none;">
           <?php  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                     if ( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) { 
                        ?>
                            
                                <div class="edn-col-full">
                                    <div class="edn-field-wrapper edn-field">
                                        <div class="edn-field-label">
                                        <label><?php _e('Contact Form 7 Shortcode',APEXNBL_TD);?></label>
                                        </div>
                                         <div class="edn-field-input">
                                            <input type="text" id="edn-form-shortcode" value="" placeholder="<?php _e('Enter Shortcode generated using Contact form 7 plugin here.',APEXNBL_TD);?>"/>
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
           <div class="edn_clear"></div>
            <div class="edn-col-full edn-clear">
                <div class="edn-well">
                    <div class="edn-field-wrapper edn-form-field">
                        <div class="edn-field">
                            <input class="button button-primary" id="edn-add-mcontent-but" type="button" value="Add" />
                            <input type="hidden" class="edn-button-count" value="0" data-error-text-cont="<?php _e('Please enter some text.',APEXNBL_TD);?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end of edn-add-multiple-content -->