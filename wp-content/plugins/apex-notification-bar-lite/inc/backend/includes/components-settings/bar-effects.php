<?php defined('ABSPATH') or die("No script kiddies please!");
$effect_option = (isset($apexnb_lite_data['edn_bar_effect_option']) && $apexnb_lite_data['edn_bar_effect_option'] != '')?$apexnb_lite_data['edn_bar_effect_option']:'1';

$title_text = (isset($apexnb_lite_data['edn_ticker']['title_text']) && $apexnb_lite_data['edn_ticker']['title_text'] != '')?$apexnb_lite_data['edn_ticker']['title_text']:'';
$speed = (isset($apexnb_lite_data['edn_ticker']['speed']) && $apexnb_lite_data['edn_ticker']['speed'] != '')?$apexnb_lite_data['edn_ticker']['speed']:'';
$tdirection = (isset($apexnb_lite_data['edn_ticker']['direction']) && $apexnb_lite_data['edn_ticker']['direction'] == 'horizontal')?'horizontal':'vertical';
//slider
$slider_duration = (isset($apexnb_lite_data['edn_slider']['duration']) && $apexnb_lite_data['edn_slider']['duration'] != '')?$apexnb_lite_data['edn_slider']['duration']:'';
$slider_speed = (isset($apexnb_lite_data['edn_slider']['speed']) && $apexnb_lite_data['edn_slider']['speed'] != '')?$apexnb_lite_data['edn_slider']['speed']:'';
$auto = (isset($apexnb_lite_data['edn_slider']['auto']) && $apexnb_lite_data['edn_slider']['auto'] != '')?$apexnb_lite_data['edn_slider']['auto']:'';
$animation = (isset($apexnb_lite_data['edn_slider']['animation']) && $apexnb_lite_data['edn_slider']['animation'] != '')?$apexnb_lite_data['edn_slider']['animation']:'';
$adaptive_height = (isset($apexnb_lite_data['edn_slider']['adaptive_height']) && $apexnb_lite_data['edn_slider']['adaptive_height'] != '')?$apexnb_lite_data['edn_slider']['adaptive_height']:'';
$controls = (isset($apexnb_lite_data['edn_slider']['controls']) && $apexnb_lite_data['edn_slider']['controls'] == '1')?'1':'0';
//scroller
$sc_title_text = (isset($apexnb_lite_data['edn_scroll']['title_text']) && $apexnb_lite_data['edn_scroll']['title_text'] != '')?$apexnb_lite_data['edn_scroll']['title_text']:'';
$sc_speed = (isset($apexnb_lite_data['edn_scroll']['speed']) && $apexnb_lite_data['edn_scroll']['speed'] != '')?$apexnb_lite_data['edn_scroll']['speed']:'';
$sc_direction = (isset($apexnb_lite_data['edn_scroll']['direction']) && $apexnb_lite_data['edn_scroll']['direction'] != '')?$apexnb_lite_data['edn_scroll']['direction']:'';
$sc_animation = (isset($apexnb_lite_data['edn_scroll']['animation']) && $apexnb_lite_data['edn_scroll']['animation'] != '')?$apexnb_lite_data['edn_scroll']['animation']:'';
?>
<div class="edn-bar-effects" style="display: none;">
          <div class="edn-row">
              <div class="edn-col-full">
                  <div class="edn-group-chooser">
                      <div class="edn-field-wrapper edn-form-field">
                          <div class="header_section">
                          <label><?php _e('Notification Bar Effects', APEXNBL_TD); ?></label>
                          </div>
                          <div class="edn-field">
                              <label class="edn-label-inline">
                                  <input type="radio" name="edn_bar_effect_option" value="1" <?php if($effect_option==1){echo 'checked="checked"';}?> />
                                  <?php _e('Ticker', APEXNBL_TD); ?>
                              </label>
                              <label class="edn-label-inline">
                                  <input type="radio" name="edn_bar_effect_option" value="2" <?php if($effect_option==2){echo 'checked="checked"';}?> />
                                  <?php _e('Slider', APEXNBL_TD); ?>
                              </label>
                              <label class="edn-label-inline">
                                  <input type="radio" name="edn_bar_effect_option" value="3" <?php if($effect_option==3){echo 'checked="checked"';}?> />
                                  <?php _e('Scroller', APEXNBL_TD); ?>
                              </label>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        <div class="edn-efect-block-wrap">
            <div class="edn-bar-efect-block" id="edn-bar-ticker" style="display: none;">
                <div class="edn-row">
                  
                     <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Title Text', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_ticker[title_text]" placeholder="<?php _e('E.g: Latest', APEXNBL_TD); ?>"
                                 value="<?php echo esc_attr($title_text);?>"/>
                                  <p class="edn-note"><?php _e('Ticker Title text on left side of ticker content',APEXNBL_TD);?></p>
                            </div>
                        </div>
                    </div> 
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Speed', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_ticker[speed]" value="<?php echo esc_attr($speed);?>" placeholder="0.10"/>
                                <p class="edn-note">
                                <?php _e('Note: Speed of ticker slide should be in point such as 0.10,0.20.Other number will not be used for ticker. Min Speed:0.10 , Max Speed:0.9.Default speed if left empty:0.10', APEXNBL_TD); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Direction', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_ticker[direction]" class="edn-ticker-direction apexnb-selection">
                                    <option value="horizontal" <?php if($tdirection=='horizontal'){echo 'selected="selected"';}?>><?php _e('Horizontal',APEXNBL_TD)?></option>
                                    <option value="vertical" <?php if($tdirection=='vertical'){echo 'selected="selected"';}?>><?php _e('Vertical',APEXNBL_TD)?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!---------------------------->
               <div class="edn-clear"></div>  
            <div class="edn-bar-efect-block" id="edn-bar-slider" style="display: none;">
                <div class="edn-row">
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Duration', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_slider[duration]" value="<?php echo esc_attr($slider_duration);?>" />
                                <p class="edn-note"><?php _e('Note: Duration between each slide in milliseconds(pause).E.g 10000',APEXNBL_TD);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Transition', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_slider[speed]" value="<?php echo esc_attr($slider_speed);?>" />
                                <p class="edn-note"><?php _e('Note: Duration of each slide in milliseconds(speed). E.g 10000',APEXNBL_TD);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Auto', APEXNBL_TD) ?></label>
                             <div class="edn-field">
                                <select name="edn_slider[auto]" class="apexnb-selection">
                                    <option value="true" <?php if($auto=='true'){echo 'selected="selected"';}?>><?php _e('True',APEXNBL_TD)?></option>
                                    <option value="false" <?php if($auto=='false'){echo 'selected="selected"';}?>><?php _e('False',APEXNBL_TD)?></option>     
                                </select>
                           <p class="edn-note"><?php _e('Note:If Choose true, slides will automatically transition.Default Value:true',APEXNBL_TD);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Animation type', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_slider[animation]" class="edn-ticker-direction apexnb-selection">
                                    <option value="horizontal" <?php if($animation=='horizontal'){echo 'selected="selected"';}?>><?php _e('Slide',APEXNBL_TD)?></option>
                                    <option value="fade" <?php if($animation=='fade'){echo 'selected="selected"';}?>><?php _e('Fade',APEXNBL_TD)?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Adaptive Height', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_slider[adaptive_height]" class="edn-adaptive_height apexnb-selection">
                                    <option value="true" <?php if($adaptive_height=='true'){echo 'selected="selected"';}?>><?php _e('True',APEXNBL_TD)?></option>
                                  
                                    <option value="false" <?php if($adaptive_height=='false'){echo 'selected="selected"';}?>><?php _e('False',APEXNBL_TD)?></option>
                                </select>
                                <p class="edn-note"><?php _e('Dynamically adjust slider height based on each slider height.Default is set as true',APEXNBL_TD);?></p>
                            </div>
                        </div>
                    </div>
                     <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Slider Controls', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                              <div class="apexnb-switch">
                                  <input type="checkbox" id="ednslidercontrols"  name="edn_slider[controls]" 
                                  value="1" <?php if($controls==1){echo 'checked="checked"';}?> />
                                 <label for="ednslidercontrols"></label>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
<div class="clear"></div>
            </div><!---------------------------->
            
            <div class="edn-bar-efect-block" id="edn-bar-scroll" style="display: none;">
                <div class="edn-row">
                    <div class="edn-col-one-fourth">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Title Text', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_scroll[title_text]" 
                                placeholder="<?php _e('E.g: Latest', APEXNBL_TD); ?>" 
                                value="<?php echo esc_attr($sc_title_text);?>" />
                             <p class="edn-note">
                                <?php _e('Scroller Title text on left side of scroller content',APEXNBL_TD);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-fourth">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Speed', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_scroll[speed]" placeholder="0.10" 
                                value="<?php echo esc_attr($sc_speed);?>" />
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-fourth">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Direction', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_scroll[direction]" class="apexnb-selection">
                                    <option value="ltr" <?php if($sc_direction =='ltr'){echo 'selected="selected"';}?>><?php _e('Left To Right',APEXNBL_TD);?></option>
                                    <option value="rtl" <?php if($sc_direction=='rtl'){echo 'selected="selected"';}?>><?php _e('Right To Left',APEXNBL_TD);?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-fourth">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Animation type', APEXNBL_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_scroll[animation]" class="apexnb-selection">
                                    <option value="reveal" <?php if($sc_animation=='reveal'){echo 'selected="selected"';}?>><?php _e('Reveal',APEXNBL_TD)?></option>
                                    <option value="fade" <?php if($sc_animation=='fade'){echo 'selected="selected"';}?>><?php _e('Fade',APEXNBL_TD)?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="edn-clear"></div>
            </div>
        </div><!-- .edn-efect-block-wrap -->
    </div><!-------- .edn-bar-effects -->
