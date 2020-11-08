<?php defined('ABSPATH') or die("No script kiddies please!");
$apexnb_lite_data = Database_Class::get_bar_data();
// APEXNBLite_Libary::displayArr($apexnb_lite_data);
$cp_type = (isset($apexnb_lite_data['edn_cp_type']) && $apexnb_lite_data['edn_cp_type'] != '')?esc_attr($apexnb_lite_data['edn_cp_type']):'';
?>
<div class="edn-wrap">
    <div class="edn-main-page-wrapper clearfix">
        <div class="edn-panel">
          <?php include_once(APEXNBL_LITE_PATH.'inc/backend/panel-head.php');?>
            <?php if(isset($_GET['message'])){ ?>
                    <div class="edn-message edn-message-success updated">
                        <p>
                           <?php _e('Settings Saved Successfully.',APEXNBL_TD);?>
                        </p>
                    </div>
                    <?php } ?>
          <?php if(isset($_GET['restore-message'])){ ?>
                         <div class="edn-message edn-message-success updated">
                        <p>
                           <?php _e('Default Settings Restored Successfully.',APEXNBL_TD);?>
                        </p> 
                     </div>
             <?php } ?>
                <?php if(isset($_GET['delete_message'])){ ?>
                         <div class="edn-message edn-message-success updated">
                        <p>
                           <?php _e('User Subscribers Deleted Successfully.',APEXNBL_TD);?>
                        </p> 
                     </div>
             <?php } ?>
                <?php if(isset($_GET['failed_message'])){ ?>
                         <div class="edn-error edn-message-error updated">
                        <p>
                           <?php _e('Fail to delete user. Try again later.',APEXNBL_TD);?>
                        </p> 
                     </div>
             <?php } ?>
                <?php if(isset($_GET['nodata'])){ ?>
                         <div class="edn-error edn-message-error updated">
                        <p>
                           <?php _e('No any data selected.',APEXNBL_TD);?>
                        </p> 
                     </div>
             <?php } ?>
            <div class="edn-panel-body apexnb-backend-setup apexnb-bar-lists">
                  <form method="post" action="<?php echo admin_url('admin-post.php');?>" class="edn-add-bar-form">
                     <input type="hidden" name="action" value="apexnb_lite_settings_action"/>
                     <?php $nonce = wp_create_nonce('restore-default-nonce');?> 
                      <div class="edn-backend-h-title nav-tab-wrapper">
                        <ul>
                          <li><a href="javascript:void(0);" class="nav-tab nav-tab-active apexnb-tabs-trigger" data-tab="general_settings"><?php _e('General Settings',APEXNBL_TD);?></a></li>
                          <li><a href="javascript:void(0);" class="nav-tab apexnb-tabs-trigger" data-tab="components_settings"><?php _e('Components Settings',APEXNBL_TD);?></a></li>
                          <li><a href="javascript:void(0);" class="nav-tab apexnb-tabs-trigger" data-tab="optin_settings"><?php _e('Opt In Settings',APEXNBL_TD);?></a></li>
                           <li><a href="javascript:void(0);" class="nav-tab apexnb-tabs-trigger" data-tab="how_to_use"><?php _e('How to Use',APEXNBL_TD);?></a></li>
                            <li><a href="javascript:void(0);" class="nav-tab apexnb-tabs-trigger" data-tab="about"><?php _e('More WordPress Stuff',APEXNBL_TD);?></a></li>
                        </ul>

                      </div>

                          <div class="apexnb-tbl-wrapper"> 
                              <div class="apexnb-lite-tab-content current" id="general_settings">
                               <?php include_once(APEXNBL_LITE_PATH.'inc/backend/notify-bar-setup/general_settings.php');?>
                              </div>
                              <div class="apexnb-lite-tab-content" id="components_settings">
                                 <?php include_once(APEXNBL_LITE_PATH.'inc/backend/notify-bar-setup/notification-bar.php');?>
                              </div>
                              <div class="apexnb-lite-tab-content" id="optin_settings">
                               <?php include_once(APEXNBL_LITE_PATH.'inc/backend/notify-bar-setup/optin_settings.php');?>
                              </div>
                              <div class="apexnb-lite-tab-content" id="how_to_use">
                               <?php include_once(APEXNBL_LITE_PATH.'inc/backend/notify-bar-setup/how_to_use.php');?>
                              </div>
                              <div class="apexnb-lite-tab-content" id="about">
                               <?php include_once(APEXNBL_LITE_PATH.'inc/backend/notify-bar-setup/about.php');?>
                              </div>

                            
                             <div class="edn-col-full edn-clear edn_submit_section">
                                  <div class="edn-well">
                                     <div class="edn-field-wrapper edn-form-field">
                                        <div class="edn-field clearfix"> 
                                           <?php wp_nonce_field('apexnb-lite-nonce','apexnb_lite_nonce_field');?>
                                           <div class="btn_submit_form">
                                              <input type="submit" class="button button-primary" id="edn-save-button" name="settings_submit_btn" value="<?php _e('Save',APEXNBL_TD);?>"/>
                                              <a class="edn-but" href="<?php echo admin_url().'admin-post.php?action=apexnb_lite_restore_default&_wpnonce='.$nonce;?>" onclick="return confirm('<?php _e('Are you sure you want to restore default settings?',APEXNBL_TD);?>')">
                                              <input type="button" value="Restore Default" class="button button-secondary" id="edn-reset-button"/>
                                              </a>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                                 <div class="edn-font-awesome-icons" style="display:none">
                                        <?php include(APEXNBL_LITE_PATH.'inc/backend/includes/components-settings/font-awesome-icons.php');?>
                                  </div>
                          </div>
                     </form>
            </div><!--edn-panel-body-->
          <div class="edn-rightbar">
          <div class="upgrade-banner">
                <img src="<?php echo APEXNBL_IMAGE_DIR;?>/apex-notification-bar-upgrade-to-pro.png" alt="upgrade-banner-top">
                <div class="apexlite-button-wrap-backend">
                  <a href="http://demo.accesspressthemes.com/wordpress-plugins/apex-notification-bar/" class="demo-btn" target="_blank">Demo</a>
                  <a href="https://accesspressthemes.com/wordpress-plugins/apex-notification-bar" target="_blank" class="upgrade-btn">Upgrade</a>
                  <a href="https://accesspressthemes.com/wordpress-plugins/apex-notification-bar/" target="_blank" class="upgrade-btn">Plugin Information</a>
                </div>
              <img src="<?php echo APEXNBL_IMAGE_DIR;?>/apex-notification-bar-upgrade-to-pro-features.png" alt="upgrade-banner-bottom">
          </div>
        </div>
        </div><!--edn-panel-->
    </div><!-- edn-add-bar-wrapper -->
</div><!-- edn-wrap -->

