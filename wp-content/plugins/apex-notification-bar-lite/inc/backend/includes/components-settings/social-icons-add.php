<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="edn-icon-adder" style="display: block;">
    <div class="edn-row">
        <div class="edn-add-social-icons">
            <input class="button button-secondary" type="button" value="Add Social Icons" id="edn-show-add-fields"/> 
        </div>
        <div class="edn-social-empty" style="display: none;">
            <div class="edn-row">
                <div class="edn-col-one-third">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Icon Title',APEXNBL_TD)?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-icon-title" placeholder="<?php _e('e.g: facebook',APEXNBL_TD);?>"  class="edn-sform-text required" data-error-msg="<?php _e('Please enter the icon title',APEXNBL_TD)?>" />
                        </div>
                        <div class="edn-error"></div>
                    </div><!--edn-field-wrapper-->
                </div>   

                  <div class="edn-col-one-third available-icons">
                    <div class="edn-field-wrapper form-field">
                        <label><?php _e('Font Awesome Icon', APEXNBL_TD); ?></label>
                        <div class="edn-field">
                            <input type="hidden" id="edn-font-awesome-icon" data-error-msg="<?php _e('Please choose any one font awesome social icon.', APEXNBL_TD) ?>"/>
                            <input type="button" class="button button-secondary edn-font-icon-chooser" value="<?php _e('Select Icon', APEXNBL_TD); ?>"/>
                        </div>
                        <div class="edn-error"></div>
                    </div><!--edn-field-wrapper-->
                </div>        
            </div>    

             <div class="edn-clear"></div>
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Icon Link', APEXNBL_TD); ?></label>
                    <div class="edn-field">
                        <input type="text" id="edn-icon-link" class="required" 
                         data-error-msg="<?php _e('Please enter the icon link', APEXNBL_TD); ?>" 
                         placeholder="<?php _e('e.g: https://www.facebook.com/accesspressthemes/',APEXNBL_TD);?>"/>
                    </div>
                    <div class="edn-error"></div>
                </div><!--edn-field-wrapper-->
            </div>
            <div class="edn-col-full">
                <div class="edn-well">
                    <div class="edn-field-wrapper edn-form-field">
                        <div class="edn-field">
                            <input class="button button-primary" type="button" value="Add Icons" id="edn-social-add"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--edn-row-->
</div>