<?php defined('ABSPATH') or die("No script kiddies please!");
global $wpdb; ?>
<div class="edn-form-wrap">
     <div class="ednpro-subscribe_list ednpro-panel-body">
        <input type="submit" name="remove_subs" id="ednpro-remove-sub" class="button button-primary edn_subs_remove_button apexnb-btn" 
        value="Remove Subscriber" onclick="return confirm('<?php _e('Are you sure you want to delete?', APEXNBL_TD); ?>')" />
        <input type="submit" name="export_subs" id="ednpro-export-sub"  class="button button-primary edn_subs_export_button apexnb-btn"  value="Export as CSV"/>
       <table class="widefat">
            <thead>
                <tr>
                    <th scope="col" id="sub_cbx" class="manage-column column-title sortable asc" style="width: 40px;">
                        <span><input type="checkbox" name="checkall_sub" value="1" id="ednpro-subs-checkall" /></span>
                    </th>
                    <th scope="col" id="sub_email" class="manage-column column-title sortable asc" style="">
                        <span><?php _e('Email', APEXNBL_TD); ?></span> 
                    </th>
                    <th scope="col" id="sub_date" class="manage-column column-shortcode" style="">
                        <span><?php _e('Subscribtion Date', APEXNBL_TD); ?></span> 
                    </th>
                     <th scope="col" id="sub_date" class="manage-column column-shortcode" style="">
                        <span><?php _e('Send Email Reply', APEXNBL_TD); ?></span> 
                    </th>
                </tr>
            </thead>
            
            <tbody id="the-list" data-wp-lists="list:post">
                <?php
                $table_name = $wpdb->prefix . 'apexnb_subscriber';
                $subs_datas = $wpdb->get_results( "SELECT * FROM $table_name WHERE email IS NOT NULL AND TRIM(email) <> ''");
                
                if (count($subs_datas) > 0) {
                
                foreach ($subs_datas as $subs_data) { ?>
                <tr>
                    <td class="shortcode column-shortcode"><tr>
                        <th class="check-column" style="padding:5px 0 2px 0;width: 40px;"><?php echo '<input type="checkbox" name="rem[]" class="edn-select-all-subs" value="'.esc_js(esc_html($subs_data->id)).'">'; ?>
                    </td>
                    <td class="shortcode column-shortcode"><?php echo $subs_data->email; ?></td>
                    <td class="shortcode column-shortcode"><?php echo $subs_data->date; ?></td>
                    <td class="shortcode column-shortcode"><a href= "mailto:<?php echo $subs_data->email;?>"><?php _e('Send Email',APEXNBL_TD);?></a></td>
                </tr>
                <?php }
                }
                else{ ?>
                <tr>
                    <td colspan="2">
                        <div class="edn-noresult"><?php _e('No Subscribers Found', APEXNBL_TD); ?></div>
                    </td>
                </tr>
                <?php } ?>
        
        
        </table> 
    </div>
</div>
           