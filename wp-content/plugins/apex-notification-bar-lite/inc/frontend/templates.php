<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="edn-template-wrap edn-template-<?php echo $edn_bar_template; ?> clearfix">
    <?php
    if (isset($edn_bar_data['edn_right_optons']) && $edn_bar_data['edn_right_optons'] == 1) {
        if (isset($cptype) && $cptype == 'email-subs') {
            if (isset($edn_bar_data['edn_subs_choose'])) {
                $subsc_choose = $edn_bar_data['edn_subs_choose'];
                switch ($subsc_choose) {
                    case 'subs-c-form':
                        $show_mail_icon = 'edn_subsc_show_icon';
                        $show_new_class = 'edn_csubscribe_form';
                        break;
                    default:
                        $show_mail_icon = '';
                        $show_new_class = '';
                        break;
                }
            }
        } else {
            $show_mail_icon = '';
            $show_new_class = '';
        }
    } else {
        $show_mail_icon = '';
        $show_new_class = '';
    }
    ?>

    <div class="edn-temp-design-wrapper edn-temp<?php echo $edn_bar_template; ?>-design-wrapper">
        <div class="edn_middle_content <?php echo $effect_id; ?>_template_wrapper">
            <div class="edn-temp<?php echo $edn_bar_template; ?>-main-content-wrap">

                <?php if ($cptype == 'text') { ?>
                    <div class="edn-temp<?php echo $edn_bar_template; ?>-text-content-wrap">


                        <?php if (isset($edn_bar_data['edn_text_display_mode']) && $edn_bar_data['edn_text_display_mode'] == 'static') { ?>
                            <div class="edn_static_text">
                                <?php
                                if (isset($edn_bar_data['edn_static']['text']) && $edn_bar_data['edn_static']['text'] != '') {
                                    echo '<div class="edn-text-link">' . $edn_bar_data['edn_static']['text'] . '</div>';
                                }
                                ?>
                                <?php if (isset($edn_bar_data['edn_static']['call-to-action']) && $edn_bar_data['edn_static']['call-to-action'] == 1) { ?>

                                    <span class="edn-temp<?php echo $edn_bar_template; ?>-call-action-button">
                                        <?php
                                        //check for custom form
                                        if (isset($edn_bar_data['edn_static']['call_action_button']) && $edn_bar_data['edn_static']['call_action_button'] == 'custom') {

                                            if ($edn_bar_data['edn_static']['but_url'] == '' || $edn_bar_data['edn_static']['but_url'] == '#') {
                                                $target = "target='_self'";
                                                $url = '#';
                                            } else {
                                                if (isset($edn_bar_data['edn_static']['link_target'])) {
                                                    $t = $edn_bar_data['edn_static']['link_target'];
                                                    $target = "target='" . $t . "'";
                                                    $url = esc_url($edn_bar_data['edn_static']['but_url']);
                                                } else {
                                                    $t = '_self';
                                                    $target = "target='" . $t . "'";
                                                    $url = esc_url($edn_bar_data['edn_static']['but_url']);
                                                }
                                            }
                                            $but_text = ((isset($edn_bar_data['edn_static']['but_text']) && $edn_bar_data['edn_static']['but_text'] != '') ? esc_attr($edn_bar_data['edn_static']['but_text']) : 'READ MORE');
                                            ?>
                                            <span class="edn-temp<?php echo $edn_bar_template; ?>-ca-custom">
                                                <a class="edn-temp<?php echo $edn_bar_template; ?>-static-button edn-static-buttons" href="<?php echo $url; ?>" <?php echo $target; ?>>
                                                    <span class="edn-temp<?php echo $edn_bar_template; ?>-ca-static-button"><?php echo $but_text; ?></span>
                                                </a>
                                            </span>

                                            <?php
                                            //contact form 7 or default form
                                        } else if (isset($edn_bar_data['edn_static']['call_action_button']) && $edn_bar_data['edn_static']['call_action_button'] == 'contact') {
                                            ?>
                                            <span class="edn-temp<?php echo $edn_bar_template; ?>-ca-contact-form">
                                                <?php
                                                if (isset($edn_bar_data['edn_static']['contact_btn_text']) && $edn_bar_data['edn_static']['contact_btn_text'] != '') {
                                                    ?>
                                                    <a href="javascript:void(0);" class="edn-custom-contact-link">
                                                        <span class="edn-temp<?php echo $edn_bar_template; ?>-contact-button edn-contact-form-button" data-id="edn-static-cf-btn-<?php echo $nb_id; ?>"><?php echo esc_attr($edn_bar_data['edn_static']['contact_btn_text']); ?></span>
                                                    </a>
                                                <?php } else {
                                                    ?>
                                                    <a href="javascript:void(0);" class="edn-custom-contact-link">
                                                        <span class="edn-temp<?php echo $edn_bar_template; ?>-contact-button edn-contact-form-button" data-id="edn-static-cf-btn-<?php echo $nb_id; ?>"><?php _e('Contact', APEXNBL_TD); ?></span>
                                                    </a>

                                                <?php }
                                                ?>

                                            </span><!-- edn of edn-ca-contact-form -->
                                            <?php
                                        } else { //shortcode  
                                            $popuptxt = ((isset($edn_bar_data['edn_static']['popup_text']) && $edn_bar_data['edn_static']['popup_text'] != '') ? $edn_bar_data['edn_static']['popup_text'] : 'CUSTOM BUTTON');
                                            ?>
                                            <span class="edn-temp<?php echo $edn_bar_template; ?>-ca-contact-form">

                                                <a href="javascript:void(0);" class="edn-custom-contact-link">
                                                    <span class="edn-temp<?php echo $edn_bar_template; ?>-contact-button edn-contact-form-button" data-id="edn-static-cf-btn-<?php echo $nb_id; ?>">
                                                        <?php echo esc_attr($popuptxt); ?></span>
                                                </a>

                                            </span><!-- edn of edn-ca-contact-form -->

                                        <?php }
                                        ?>
                                    </span>


                                <?php } ?>
                            </div>


                        <?php } else if ($edn_bar_data['edn_text_display_mode'] == 'multiple') { ?>

                            <div class="edn_multiple_text">
                                <ul class="edn-multiple-content" id="edn-effect-<?php echo $effect_id; ?>-<?php echo $nb_id; ?>" data-barid="<?php echo $nb_id; ?>">
                                    <?php
                                    if (!empty($edn_bar_data['edn_multiple']['text_content'])) {
                                        foreach ($edn_bar_data['edn_multiple']['text_content'] as $key => $content) {

                                            if (isset($edn_bar_data['edn_multiple']['link_but_text'][$key])) {
                                                $linktext = esc_attr($edn_bar_data['edn_multiple']['link_but_text'][$key]);
                                                $settickerclass = "apexnb_tickercontent_cta";
                                            } else {
                                                $linktext = '';
                                                $settickerclass = "";
                                            }
                                            ?>
                                            <li <?php echo ($effect_id == "slider") ? 'class="clearfix"' : ''; ?>>
                                                <?php if ($effect_id == "ticker") { ?>
                                                    <div class="<?php echo $settickerclass; ?>">
                                                        <div class="edn-mulitple-text-content">
                                                            <?php
                                                            if (isset($edn_bar_data['edn_multiple']['text_content'][$key]) && $edn_bar_data['edn_multiple']['text_content'][$key] != '') {
                                                                echo $edn_bar_data['edn_multiple']['text_content'][$key];
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                        if (isset($edn_bar_data['edn_multiple']['call_to_action'][$key]) && $edn_bar_data['edn_multiple']['call_to_action'][$key] == 1) {
                                                            if (isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$key]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$key] == 'custom') {

                                                                if (isset($linktext) && $linktext != '') {
                                                                    if ($edn_bar_data['edn_multiple']['link_url'][$key] != '#' && $edn_bar_data['edn_multiple']['link_url'][$key] != '') {
                                                                        $target1 = !(isset($edn_bar_data['edn_multiple']['link_target'][$key])) ? '_self' : $edn_bar_data['edn_multiple']['link_target'][$key];
                                                                        $target = "target='" . $target1 . "'";
                                                                        $link_url = esc_url($edn_bar_data['edn_multiple']['link_url'][$key]);
                                                                    } else {
                                                                        $link_url = '#';
                                                                        $target = "target='_self'";
                                                                    }
                                                                } else {
                                                                    $link_url = '';
                                                                    $target = "";
                                                                }
                                                                ?>
                                                                <?php if (isset($linktext) && $linktext != '') { ?>
                                                                    <span class="edn-temp<?php echo $edn_bar_template; ?>-ca-custom">
                                                                        <a class="edn-temp<?php echo $edn_bar_template; ?>-static-button edn-multiple-button edn-temp<?php echo $edn_bar_template; ?>-multiple-btn-<?php echo $key; ?> edn-custom-contact-link" href="<?php echo esc_url($link_url); ?>" <?php echo $target; ?>>
                                                                            <span class="edn-temp<?php echo $edn_bar_template; ?>-ca-static-button edn-temp<?php echo $edn_bar_template; ?>-ca-multiple-button edn-temp<?php echo $edn_bar_template; ?>-ca-multiple-btn-<?php echo $key; ?>"><?php echo esc_attr($linktext); ?></span>
                                                                        </a>
                                                                    </span>
                                                                <?php } ?>
                                                            <?php } else if (isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$key]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$key] == 'shortcode-popup') {
                                                                ?>
                                                                <span class="edn-ca-contact-form">
                                                                    <a href="javascript:void(0);" class="edn-custom-contact-link">
                                                                        <span class="edn-temp<?php echo $edn_bar_template; ?>-contact-button edn-contact-form-button edn-multiple-cf-btn"
                                                                              data-id="edn-multiple-cf-btn_<?php echo $key; ?>">
                                                                                  <?php
                                                                                  if (isset($edn_bar_data['edn_multiple']['popup_text'][$key]) && $edn_bar_data['edn_multiple']['popup_text'][$key] != '') {
                                                                                      echo esc_attr($edn_bar_data['edn_multiple']['popup_text'][$key]);
                                                                                  } else {
                                                                                      _e('CLICK ME', APEXNBL_TD);
                                                                                  }
                                                                                  ?>
                                                                        </span>
                                                                    </a>

                                                                </span><!-- edn of edn-ca-contact-form -->

                                                            <?php } else {
                                                                ?>
                                                                <span class="edn-ca-contact-form">
                                                                    <a href="javascript:void(0);" class="edn-custom-contact-link">
                                                                        <span class="edn-temp<?php echo $edn_bar_template; ?>-contact-button edn-contact-form-button edn-multiple-cf-btn"
                                                                              data-id="edn-multiple-cf-btn_<?php echo $key; ?>">
                                                                                  <?php
                                                                                  if (isset($edn_bar_data['edn_multiple']['contact_btn_text'][$key]) && $edn_bar_data['edn_multiple']['contact_btn_text'][$key] != '') {
                                                                                      echo esc_attr($edn_bar_data['edn_multiple']['contact_btn_text'][$key]);
                                                                                  } else {
                                                                                      _e('Contact', APEXNBL_TD);
                                                                                  }
                                                                                  ?>
                                                                        </span>
                                                                    </a>

                                                                </span><!-- edn of edn-ca-contact-form -->


                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>


                                                <?php } else if ($effect_id == "scroller") { ?>

                                                    <div class="<?php echo $settickerclass; ?>">

                                                        <div class="edn-mulitple-text-content">
                                                            <?php
                                                            if (isset($edn_bar_data['edn_multiple']['text_content'][$key]) && $edn_bar_data['edn_multiple']['text_content'][$key] != '') {
                                                                echo $edn_bar_data['edn_multiple']['text_content'][$key];
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                        if (isset($edn_bar_data['edn_multiple']['call_to_action'][$key]) && $edn_bar_data['edn_multiple']['call_to_action'][$key] == 1) {
                                                            if (isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$key]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$key] == 'custom') {

                                                                if (isset($linktext) && $linktext != '') {
                                                                    if ($edn_bar_data['edn_multiple']['link_url'][$key] != '#' && $edn_bar_data['edn_multiple']['link_url'][$key] != '') {
                                                                        $target1 = !(isset($edn_bar_data['edn_multiple']['link_target'][$key])) ? '_self' : $edn_bar_data['edn_multiple']['link_target'][$key];
                                                                        $target = "target='" . $target1 . "'";
                                                                        $link_url = esc_url($edn_bar_data['edn_multiple']['link_url'][$key]);
                                                                    } else {
                                                                        $link_url = '#';
                                                                        $target = "target='_self'";
                                                                    }
                                                                } else {
                                                                    $link_url = '';
                                                                    $target = "";
                                                                }
                                                                ?>
                                                                <?php if (isset($linktext) && $linktext != '') { ?>
                                                                    <span class="edn-temp<?php echo $edn_bar_template; ?>-ca-custom">
                                                                        <a class="edn-temp<?php echo $edn_bar_template; ?>-static-button edn-multiple-button edn-temp<?php echo $edn_bar_template; ?>-multiple-btn-<?php echo $key; ?> edn-custom-contact-link" href="<?php echo esc_attr($link_url); ?>" <?php echo $target; ?>>
                                                                            <span class="edn-temp<?php echo $edn_bar_template; ?>-ca-static-button edn-temp<?php echo $edn_bar_template; ?>-ca-multiple-button edn-temp<?php echo $edn_bar_template; ?>-ca-multiple-btn-<?php echo $key; ?>"><?php echo esc_attr($linktext); ?></span>
                                                                        </a>
                                                                    </span>
                                                                <?php } ?>

                                                            <?php } else if (isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$key]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$key] == 'shortcode-popup') {
                                                                ?>
                                                                <span class="edn-ca-contact-form">
                                                                    <a href="javascript:void(0);" class="edn-custom-contact-link">
                                                                        <span class="edn-temp<?php echo $edn_bar_template; ?>-contact-button edn-contact-form-button edn-multiple-cf-btn" data-id="edn-multiple-cf-btn_<?php echo $key; ?>">
                                                                            <?php
                                                                            if (isset($edn_bar_data['edn_multiple']['popup_text'][$key]) && $edn_bar_data['edn_multiple']['popup_text'][$key] != '') {
                                                                                echo esc_attr($edn_bar_data['edn_multiple']['popup_text'][$key]);
                                                                            } else {
                                                                                _e('CLICK ME', APEXNBL_TD);
                                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </a>

                                                                </span><!-- edn of edn-ca-contact-form -->

                                                            <?php } else { ?>
                                                                <span class="edn-ca-contact-form">
                                                                    <a href="javascript:void(0);" class="edn-custom-contact-link">
                                                                        <span class="edn-temp<?php echo $edn_bar_template; ?>-contact-button edn-contact-form-button edn-multiple-cf-btn" data-id="edn-multiple-cf-btn_<?php echo $key; ?>">
                                                                            <?php
                                                                            if (isset($edn_bar_data['edn_multiple']['contact_btn_text'][$key]) && $edn_bar_data['edn_multiple']['contact_btn_text'][$key] != '') {
                                                                                echo esc_attr($edn_bar_data['edn_multiple']['contact_btn_text'][$key]);
                                                                            } else {
                                                                                _e('Contact', APEXNBL_TD);
                                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </a>

                                                                </span><!-- edn of edn-ca-contact-form -->


                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>

                                                <?php } else if ($effect_id == "slider") { ?>

                                                    <?php
                                                    if (isset($edn_bar_data['edn_multiple']['call_to_action'][$key]) && $edn_bar_data['edn_multiple']['call_to_action'][$key] == 1) {

                                                        if (isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$key]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$key] == 'custom') {
                                                            //custom link 
                                                            if (isset($edn_bar_data['edn_multiple']['link_but_text'][$key])) {
                                                                $linktext = esc_attr($edn_bar_data['edn_multiple']['link_but_text'][$key]);
                                                            } else {
                                                                $linktext = 'View Link';
                                                            }
                                                            if (isset($linktext) && $edn_bar_data['edn_multiple']['link_url'][$key] != '#' && $edn_bar_data['edn_multiple']['link_url'][$key] != '') {
                                                                $target1 = !(isset($edn_bar_data['edn_multiple']['link_target'][$key])) ? '_self' : $edn_bar_data['edn_multiple']['link_target'][$key];

                                                                $target = "target='" . $target1 . "'";
                                                                $link_url = esc_url($edn_bar_data['edn_multiple']['link_url'][$key]);
                                                            } else {
                                                                $link_url = '#';
                                                                $target = "target='_self'";
                                                            }
                                                            ?>
                                                            <div class="edn-mulitple-text-content">
                                                                <?php echo $edn_bar_data['edn_multiple']['text_content'][$key]; ?>
                                                            </div>
                                                            <a href="<?php echo $link_url; ?>" <?php echo $target; ?> class="edn-custom-contact-link">
                                                                <span class="edn-temp<?php echo $edn_bar_template; ?>-ca-custom"><?php echo $linktext; ?></span>
                                                            </a>

                                                        <?php } else if (isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$key]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$key] == 'shortcode-popup') {
                                                            ?>
                                                            <div class="edn-mulitple-text-content">
                                                                <?php echo $edn_bar_data['edn_multiple']['text_content'][$key]; ?>
                                                            </div>
                                                            <span class="edn-ca-contact-form">
                                                                <a href="javascript:void(0);" class="edn-custom-contact-link">
                                                                    <span class="edn-temp<?php echo $edn_bar_template; ?>-contact-button edn-contact-form-button edn-multiple-cf-btn" data-id="edn-multiple-cf-btn_<?php echo $key; ?>">
                                                                        <?php
                                                                        if (isset($edn_bar_data['edn_multiple']['popup_text'][$key]) && $edn_bar_data['edn_multiple']['popup_text'][$key] != '') {
                                                                            echo esc_attr($edn_bar_data['edn_multiple']['popup_text'][$key]);
                                                                        } else {
                                                                            _e('CLICK ME', APEXNBL_TD);
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </a>

                                                            </span><!-- edn of edn-ca-contact-form -->

                                                        <?php } else { ?>

                                                            <div class="edn-mulitple-text-content">
                                                                <?php echo $edn_bar_data['edn_multiple']['text_content'][$key]; ?>
                                                            </div>
                                                            <span class="edn-ca-contact-form">
                                                                <a href="javascript:void(0);" class="edn-custom-contact-link">
                                                                    <span class="edn-temp<?php echo $edn_bar_template; ?>-contact-button edn-contact-form-button edn-multiple-cf-btn"
                                                                          data-id="edn-multiple-cf-btn_<?php echo $key; ?>">
                                                                              <?php
                                                                              if (isset($edn_bar_data['edn_multiple']['contact_btn_text'][$key]) && $edn_bar_data['edn_multiple']['contact_btn_text'][$key] != '') {
                                                                                  echo esc_attr($edn_bar_data['edn_multiple']['contact_btn_text'][$key]);
                                                                              } else {
                                                                                  _e('Contact', APEXNBL_TD);
                                                                              }
                                                                              ?>
                                                                    </span>
                                                                </a>

                                                            </span><!-- edn of edn-ca-contact-form -->

                                                        <?php } //contact form popup  ?>

                                                    <?php } else { ?>
                                                        <div class="edn-mulitple-text-content">
                                                            <?php echo $edn_bar_data['edn_multiple']['text_content'][$key]; ?>
                                                        </div>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>




                        <?php } ?>
                    </div>  <!--edn-temp-text-content-wrap end -->  

                <?php } elseif ($cptype == 'email-subs') { ?>
                    <div class="edn-type-newsletter-wrap">
                        <?php if ($edn_bar_data['edn_subs_choose'] == 'subs-c-form') { ?>
                            <div class="edn-subscribe-form">
                                <div class="edn-form-field">
                                    <div class="edn-front-title">
                                        <div class="show_icon">
                                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        </div>
                                        <h3><?php
                                            $head_txt = ((isset($edn_bar_data['edn_subs_custom']['head_text']) && $edn_bar_data['edn_subs_custom']['head_text'] != '') ? $edn_bar_data['edn_subs_custom']['head_text'] : 'SUBSCRIBE NEWSLETTER');
                                            echo esc_attr($head_txt);
                                            ?>
                                            <?php if (isset($edn_bar_data['edn_subs_custom']['description'])) { ?>
                                                <span>
                                                    <?php echo esc_attr($edn_bar_data['edn_subs_custom']['description']); ?>
                                                </span>
                                            <?php } ?></h3>
                                    </div>
                                    <div class="edn-left-subscribe-content">

                                        <input type="email" name="edn_email" placeholder="<?php
                                        if (isset($edn_bar_data['edn_subs_custom']['but_email_placeholder']) && $edn_bar_data['edn_subs_custom']['but_email_placeholder'] != '') {
                                            echo esc_attr($edn_bar_data['edn_subs_custom']['but_email_placeholder']);
                                        } else {
                                            _e('Email Address', APEXNBL_TD);
                                        }
                                        ?>" class="edn_subs_email_r" />

                                        <button type="button" class="edn_subs_submit_ajax" id="edn_subs_submit_ajax-<?php echo $nb_id; ?>" ><?php
                                            if (isset($edn_bar_data['edn_subs_custom']['but_text']) && $edn_bar_data['edn_subs_custom']['but_text'] != '') {
                                                echo esc_attr($edn_bar_data['edn_subs_custom']['but_text']);
                                            } 
                                                else(_e('Go', APEXNBL_TD))
                                                ?></button>
                                        <div class="edn-error">
                                            <?php
                                            if (isset($edn_bar_data['edn_subs_custom']['thank_text'])) {
                                                $success = $edn_bar_data['edn_subs_custom']['thank_text'];
                                            } else {
                                                $success = __('Thank you for subscribing us.', APEXNBL_TD);
                                            }
                                            $error_msg = __('Email ID Is Invalid.', APEXNBL_TD);
                                            $subscribed_msg = __('You have already subscribed.', APEXNBL_TD);

                                            if (isset($_GET['mpage'])) {
                                                if ($_GET['mpage'] == "success") {
                                                    if ($_GET['message'] == "1") {
                                                        echo $subscribed_msg;
                                                    } else if ($_GET['message'] == "2") {
                                                        echo $success;
                                                    } else {
                                                        echo $error_msg;
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="edn-subs-success edn-success"></div>                   
                                        <div class="loader_view">
                                            <img src="<?php echo APEXNBL_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-ajax-loader"/>
                                        </div>
                                    </div>
                                </div>


                                <input type="hidden" class="edn-subs-email-confirm" value="<?php
                                if (isset($edn_bar_data['edn_subs_custom']['confirm'])) {
                                    echo esc_attr($edn_bar_data['edn_subs_custom']['confirm']);
                                }
                                ?>" />
                                <input type="hidden" class="edn-page-id" value="<?php the_ID(); ?>" />

                                <input type="hidden" class="edn-success-note" value="<?php
                                if (isset($edn_bar_data['edn_subs_custom']['thank_text'])) {
                                    echo esc_attr($edn_bar_data['edn_subs_custom']['thank_text']);
                                }
                                ?>" />
                                <input type="hidden" class="edn-subs-email-error-msg" value="<?php
                                if (isset($edn_bar_data['edn_subs_custom']['but_email_error_message'])) {
                                    echo esc_attr($edn_bar_data['edn_subs_custom']['but_email_error_message']);
                                }
                                ?>" />
                                <input type="hidden" class="edn-subs-already-subscribed" value="<?php
                                if (isset($edn_bar_data['edn_subs_custom']['but_already_subs'])) {
                                    echo esc_attr($edn_bar_data['edn_subs_custom']['but_already_subs']);
                                }
                                ?>" />
                                <input type="hidden" class="edn-subs-sending-fail" value="<?php
                                if (isset($edn_bar_data['edn_subs_custom']['but_sending_fail'])) {
                                    echo esc_attr($edn_bar_data['edn_subs_custom']['but_sending_fail']);
                                }
                                ?>" />
                                <input type="hidden" class="edn-subs-checktoconfirmmsg" value="<?php
                                if (isset($edn_bar_data['edn_subs_custom']['but_check_to_conform'])) {
                                    echo esc_attr($edn_bar_data['edn_subs_custom']['but_check_to_conform']);
                                }
                                ?>" />
                                <input type="hidden" class="apexnb-bar-id" value="<?php echo $nb_id; ?>" />

                            </div>
                        <?php } ?>
                    </div>
                    <?php
                } else if ($cptype == 'post-title') {
                    if (isset($edn_bar_data['edn_recentposts']['edn_choose_filter_posts']) && $edn_bar_data['edn_recentposts']['edn_choose_filter_posts'] == "recent-posts") {
                        ?>

                        <div class="edn-post-title-wrap">
                            <?php
                            if (isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option'] == 1) {
                                ;
                                ?><div class="edn-ticker-wrapper"><?php } ?>
                            <?php
                            $posts_per_page = (isset($edn_bar_data['edn_recentposts']['posts_per_page']) && $edn_bar_data['edn_recentposts']['posts_per_page'] != '') ? $edn_bar_data['edn_recentposts']['posts_per_page'] : '3';
                            $edn_posttype_value = (isset($edn_bar_data['edn_recentposts']['edn_posttype_value']) && $edn_bar_data['edn_recentposts']['edn_posttype_value'] != '') ? $edn_bar_data['edn_recentposts']['edn_posttype_value'] : 'post';
                            $edn_recentposts_orderby = (isset($edn_bar_data['edn_recentposts']['edn_recentposts_orderby']) && $edn_bar_data['edn_recentposts']['edn_recentposts_orderby'] != '') ? $edn_bar_data['edn_recentposts']['edn_recentposts_orderby'] : 'date';
                            $edn_recentposts_order = (isset($edn_bar_data['edn_recentposts']['edn_recentposts_order']) && $edn_bar_data['edn_recentposts']['edn_recentposts_order'] != '') ? $edn_bar_data['edn_recentposts']['edn_recentposts_order'] : 'desc';
                            $show_read_more_btn = (isset($edn_bar_data['edn_recentposts']['show_read_more_btn']) && $edn_bar_data['edn_recentposts']['show_read_more_btn'] == 1) ? 1 : 0;
                            $read_more_label = (isset($edn_bar_data['edn_recentposts']['read_more_label']) && $edn_bar_data['edn_recentposts']['read_more_label'] != '') ? $edn_bar_data['edn_recentposts']['read_more_label'] : '';
                            $read_more_target = (isset($edn_bar_data['edn_recentposts']['read_more_target'])) ? $edn_bar_data['edn_recentposts']['read_more_target'] : '_self';
                            $args = array('numberposts' => $posts_per_page,
                                'orderby' => $edn_recentposts_orderby,
                                'order' => $edn_recentposts_order,
                                'post_type' => $edn_posttype_value,
                                'post_status' => 'publish');
                            $recent_posts = wp_get_recent_posts($args);
                            ?>
                                <ul class="edn-post-title" id="edn-post-effect-<?php echo $effect_id; ?>-<?php echo $nb_id; ?>" data-barid="<?php echo $nb_id; ?>">
                                    <?php
                                    foreach ($recent_posts as $recent) {
                                        ?>
                                        <li <?php echo ($effect_id == "slider") ? 'class="clearfix"' : ''; ?>>
                                            <?php echo $recent["post_title"]; ?>
                                            <?php if ($show_read_more_btn == 1) { ?>
                                                <a class="edn-post-title-readmore" href="<?php echo get_permalink($recent["ID"]); ?>" target="<?php echo $read_more_target; ?>"><?php echo esc_attr($read_more_label); ?></a>
                                            <?php } ?>
                                        </li>
                                        <?php
                                    }
                                    wp_reset_query();
                                    ?>
                                </ul>
                                <?php
                                if (isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option'] == 1) {
                                    ;
                                    ?></div><?php } ?>
                        </div>

                        <?php
                    }
                } else if ($cptype == 'search-form') {
                    $btnname = __('Search', APEXNBL_TD);
                    $search_layout_type = ((isset($edn_bar_data['edn_search_form']['layout_type']) && $edn_bar_data['edn_search_form']['layout_type'] != '') ? $edn_bar_data['edn_search_form']['layout_type'] : 'layout1');
                    $description = ((isset($edn_bar_data['edn_search_form']['description']) && $edn_bar_data['edn_search_form']['description'] != '') ? $edn_bar_data['edn_search_form']['description'] : __('Looking for something?',APEXNBL_TD));
                    $input_placeholder = ((isset($edn_bar_data['edn_search_form']['input_placeholder']) && $edn_bar_data['edn_search_form']['input_placeholder'] != '') ? $edn_bar_data['edn_search_form']['input_placeholder'] : '');
                    $hide_button_text = (isset($edn_bar_data['edn_search_form']['hide_button_text']) && $edn_bar_data['edn_search_form']['hide_button_text'] == 1) ? 1 : 0;
                    $hide_icon = (isset($edn_bar_data['edn_search_form']['hide_icon']) && $edn_bar_data['edn_search_form']['hide_icon'] == 1) ? 1 : 0;
                    $button_name = ((isset($edn_bar_data['edn_search_form']['button_name']) && $edn_bar_data['edn_search_form']['button_name'] != '') ? esc_attr($edn_bar_data['edn_search_form']['button_name']) :$btnname);
                    $font_icon = ((isset($edn_bar_data['edn_search_form']['font_icon']) && $edn_bar_data['edn_search_form']['font_icon'] != '') ? $edn_bar_data['edn_search_form']['font_icon'] : '');
                    if ($hide_button_text == 1 && $hide_icon != 1) {
                        $addclasss = "apexnb_show_icononly";
                    } else if ($hide_button_text != 1 && $hide_icon == 1) {
                        $addclasss = "apexnb_show_btnonly";
                    } else if ($hide_button_text == 1 && $hide_icon == 1) {
                        $addclasss = "apexnb_hideallbutton";
                    } else {
                        $addclasss = "apexnb_show_both_sbtn";
                    }
                    ?>

                    <div class="apexnb-searchwrapper <?php echo 'apexnb-search-' . $search_layout_type; ?>">
                        <form role="search" method="get" class="searchform" action="<?php echo home_url('/'); ?>">
                            <p class="apex-onscreen-description"><?php echo _x($description, APEXNBL_TD) ?></p>
                            <div class="apex-search-right-section <?php echo $addclasss; ?> clearfix">
                                <label>
                                 
                                    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x($input_placeholder, APEXNBL_TD) ?>" 
                                           value="<?php echo get_search_query() ?>" name="s" />
                                </label>

                                <button type='submit' class="btn-search-now">
                                    <?php 
                                        echo esc_attr_x($button_name, APEXNBL_TD);
                                    ?>
                                </button>
                            </div>
                        </form>
                    </div>
                    <?php
                } else if ($cptype == "social-icons") {
                    if (isset($edn_bar_data['edn_social_optons']) && $edn_bar_data['edn_social_optons'] == 1) {
                        ?>
                        <div class="edn-temp<?php echo $edn_bar_template; ?>-social-wrap">
                            <?php if (isset($edn_bar_data['edn_social_heading_text']) && !empty($edn_bar_data['edn_social_heading_text'])) { ?>
                                <div class="edn-temp<?php echo $edn_bar_template; ?>-social-heading-title edn_pro-social-title"><?php echo esc_attr($edn_bar_data['edn_social_heading_text']); ?></div>
                            <?php } ?>
                            <div class="ednpro_bar_icons <?php echo $show_mail_icon; ?>">
                                <?php
                                if (isset($edn_bar_data['icon_details']) && $edn_bar_data['icon_details']) {
                                    foreach ($edn_bar_data['icon_details'] as $icon_list) {
                                        $array_name = explode(' ', esc_attr($icon_list['title']));
                                        $class = implode('-', $array_name);
                                        $social_class = strtolower($class);
                                        ?>
                                        <div class="edn-social-icons edn-temp<?php echo $edn_bar_template; ?>-social-icon-buttons edn-temp<?php echo $edn_bar_template; ?>-<?php echo $social_class; ?>-button" style="<?php ?>">
                                            <a href="<?php echo esc_url($icon_list['link']); ?>" target="_blank" class="edn-social-icons-bg edn-temp<?php echo $edn_bar_template; ?>-aclass-<?php echo $social_class; ?>">
                                                <span class="edn-temp<?php echo $edn_bar_template; ?>-<?php echo $social_class; ?> edn-hover-icons" style="display:none;"><i class="<?php echo esc_attr($icon_list['font_icon']); ?> edn-temp<?php echo $edn_bar_template; ?>-iclass-<?php echo $social_class; ?>"></i></span>
                                                <i class="<?php echo esc_attr($icon_list['font_icon']); ?> edn-icons-set edn-temp<?php echo $edn_bar_template; ?>-iclass-<?php echo $social_class; ?>"></i>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            <?php } ?>

      </div>  <!--edn-temp-main-content-wrap end -->  
    </div><!-- edn_middle_content end -->
</div><!-- edn-temp-design-wrapper end -->
</div><!-- edn-template-wrap end -->