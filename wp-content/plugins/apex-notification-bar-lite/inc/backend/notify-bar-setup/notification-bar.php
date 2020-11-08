<?php defined('ABSPATH') or die("No script kiddies please!");?>
<div class="edn-form-wrap clearfix"> 
		<div id="apexnb_lite_tabs">
		    <ul>
		        <li>
		            <a href="#bar_layout"><?php _e('Bar Layout',APEXNBL_TD);?></a>
		        </li>
		         <li>
		            <a href="#customize_layout"><?php _e('Custom Settings',APEXNBL_TD);?></a>
		        </li>
		        <li>
		            <a href="#components"><?php _e('Components Setup',APEXNBL_TD);?></a>
		        </li>
		        <li>
		            <a href="#bar_controls"><?php _e('Visibility/Controls',APEXNBL_TD);?></a>
		        </li>

		    </ul>
		    <div id="bar_layout">	
				<?php include_once(APEXNBL_LITE_PATH.'inc/backend/includes/main-settings/bar-template.php');?>
		    </div>
		     <div id="customize_layout">	
				<?php include_once(APEXNBL_LITE_PATH.'inc/backend/includes/main-settings/customize_layout.php');?>
		    </div>
		    <div id="components">
		       <?php include_once(APEXNBL_LITE_PATH.'inc/backend/includes/main-settings/components.php');?>
		    </div>
		    <div id="bar_controls">
		       <?php include_once(APEXNBL_LITE_PATH.'inc/backend/includes/main-settings/controls_settings.php');?>
		    </div>
		</div>
</div>