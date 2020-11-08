<?php defined('ABSPATH') or die("No script kiddies please!");?>
<div class="edn-row">
<div class="header_section">
              <input type="hidden" name="edn_recentposts[edn_choose_filter_posts]" value="recent-posts"/>
              <?php _e('Show Recent Posts',APEXNBL_TD);?>
</div>
<?php 
$posts_per_page = (isset($apexnb_lite_data['edn_recentposts']['posts_per_page']) && $apexnb_lite_data['edn_recentposts']['posts_per_page'] != '')?$apexnb_lite_data['edn_recentposts']['posts_per_page']:'3';
$edn_posttype_value = (isset($apexnb_lite_data['edn_recentposts']['edn_posttype_value']) && $apexnb_lite_data['edn_recentposts']['edn_posttype_value'] != '')?$apexnb_lite_data['edn_recentposts']['edn_posttype_value']:'post';
$edn_recentposts_orderby = (isset($apexnb_lite_data['edn_recentposts']['edn_recentposts_orderby']) && $apexnb_lite_data['edn_recentposts']['edn_recentposts_orderby'] != '')?$apexnb_lite_data['edn_recentposts']['edn_recentposts_orderby']:'date';
$edn_recentposts_order = (isset($apexnb_lite_data['edn_recentposts']['edn_recentposts_order']) && $apexnb_lite_data['edn_recentposts']['edn_recentposts_order'] != '')?$apexnb_lite_data['edn_recentposts']['edn_recentposts_order']:'desc';
$show_read_more_btn = (isset($apexnb_lite_data['edn_recentposts']['show_read_more_btn']) && $apexnb_lite_data['edn_recentposts']['show_read_more_btn'] == 1)?1:0;
$read_more_label = (isset($apexnb_lite_data['edn_recentposts']['read_more_label']) && $apexnb_lite_data['edn_recentposts']['read_more_label'] != '')?$apexnb_lite_data['edn_recentposts']['read_more_label']:'';
$read_more_target =  (isset($apexnb_lite_data['edn_recentposts']['read_more_target']))?esc_attr($apexnb_lite_data['edn_recentposts']['read_more_target']):'_self';
?>
<div class="apexnb-recentposts">
      <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
             <div class="edn-field">
             <div class="edn-field-label"><label><?php _e('Posts Per Page',APEXNBL_TD);?></label></div>
            <div class="edn-field-input">
                <input type="number" name="edn_recentposts[posts_per_page]" value="<?php echo esc_attr($posts_per_page);?>"/>
           </div>
            </div>
        </div>
        </div>
       <div class="edn-col-full">
          <div class="edn-field-wrapper edn-form-field">
               <div class="edn-field">
              <div class="edn-field-label"> <label><?php _e('Choose Posts Type',APEXNBL_TD);?></label> </div>
                 <div class="edn-field-input"><?php 
                 $post_types =  APEXNBLite_Libary::apexnb_get_registered_post_types();
                 ?>
                 <select name="edn_recentposts[edn_posttype_value]" class="widefat apexnb-selectbox apexnb-selection">                   
                   <?php if(isset($post_types) && !empty($post_types)){
                    foreach ($post_types as $key => $value) {
                      ?>
                       <option value="<?php echo $value;?>" <?php selected($value, $edn_posttype_value); ?>><?php echo ucfirst($value);?></option>
                      <?php 
                    }
                   } ?>

                 </select>
              </div>
              </div>
          </div>
         </div>
          <div class="edn-col-full">
              <div class="edn-field-wrapper edn-form-field">
                   <div class="edn-field">
                     <div class="edn-field-label">
                       <label><?php _e('Order By',APEXNBL_TD);?></label>
                     </div>
                      <div class="edn-field-input">
                         <select name="edn_recentposts[edn_recentposts_orderby]" class="widefat apexnb-selectbox apexnb-selection">
                                  <option value="none" <?php selected('none', $edn_recentposts_orderby); ?>>None</option>
                                  <option value="ID" <?php selected('ID', $edn_recentposts_orderby); ?>>ID</option>
                                  <option value="title" <?php selected('title', $edn_recentposts_orderby); ?>>Title</option>
                                  <option value="name" <?php selected('name', $edn_recentposts_orderby); ?>>Name</option>
                                  <option value="date" <?php selected('date', $edn_recentposts_orderby); ?>>Date</option>
                                  <option value="rand" <?php selected('rand', $edn_recentposts_orderby); ?>>Random Number</option>
                                  <option value="menu_order" <?php selected('menu_order', $edn_recentposts_orderby); ?>>Menu Order</option>
                                  <option value="author" <?php selected('author', $edn_recentposts_orderby); ?>>Author</option>
                          </select>
                          </div>
                 
                      
                  </div>
              </div>
          </div>
              <div class="edn-col-full">
              <div class="edn-field-wrapper edn-form-field">
                   <div class="edn-field">
                 <div class="edn-field-label"> <label><?php _e('Order',APEXNBL_TD);
                 ?></label></div>
                   <div class="edn-field-input">
                         <select name="edn_recentposts[edn_recentposts_order]" class="widefat apexnb-selectbox apexnb-selection">
                                  <option value="asc" <?php selected('asc', $edn_recentposts_order); ?>>Ascending Order</option>
                                  <option value="desc" <?php selected('desc', $edn_recentposts_order); ?>>Descending Order</option>  
                          </select>
                  </div>
                      
                  </div>
              </div>
          </div>
       <div class="edn-col-full">
          <div class="edn-field-wrapper edn-form-field">
               <div class="edn-field">
              <div class="edn-field-label">  
                  <label for="show_read_more_btn"><?php _e('Display Read More button',APEXNBL_TD); ?></label></div>
               <div class="edn-field-input">
                  <div class="apexnb-switch">
                 <input type="checkbox" id="show_read_more_btn" name="edn_recentposts[show_read_more_btn]" value="1" <?php if($show_read_more_btn ==1 ){echo 'checked';}?>/> 
                   <label for="show_read_more_btn"></label>
                 </div>
               </div>
              </div>
          </div>
      </div>
      <div class="edn-col-full">
          <div class="edn-field-wrapper edn-form-field">
               <div class="edn-field">
              <div class="edn-field-label">  <label><?php _e('Button Label',APEXNBL_TD); ?> </label></div>
                <div class="edn-field-input">
                <input type="text" name="edn_recentposts[read_more_label]" value="<?php echo esc_attr($read_more_label);?>" placeholder="<?php _e('Read More',APEXNBL_TD);?>"/>
             </div>
                  
              </div>
          </div>
      </div>
      <div class="edn-col-full">
          <div class="edn-field-wrapper edn-form-field">
               <div class="edn-field">
              <div class="edn-field-label">  <label><?php _e('Button Target',APEXNBL_TD); ?> </label></div>
                <div class="edn-field-input">
                 <select name="edn_recentposts[read_more_target]" class="widefat apexnb-selectbox apexnb-selection">
                           <option value="_blank"  <?php selected('_blank', $read_more_target); ?>><?php _e('_blank',APEXNBL_TD);?></option>
                           <option value="_self"  <?php selected('_self', $read_more_target); ?>><?php _e('_self',APEXNBL_TD);?></option>
                           <option value="_parent" <?php selected('_parent', $read_more_target); ?>><?php _e('_parent',APEXNBL_TD);?></option>
                           <option value="_top"  <?php selected('_top', $read_more_target); ?>><?php _e('_top',APEXNBL_TD);?></option>
                  </select>
               </div>    
              </div>
          </div>
      </div>
</div>
</div>