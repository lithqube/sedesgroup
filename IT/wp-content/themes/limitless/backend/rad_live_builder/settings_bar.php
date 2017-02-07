<?php 
/**
 * Panel Builder
 */
global $radunits;
 ?>

 <div id="rad_live_panel" class='clearfix'>
 		<div class="skeleton auto_align">
 			<a href="" id="rad_page_save" class='rad_button_primary r_left'><?php _e('Save','ioa') ?></a>
 			<!--
 			<a href="" id="rad_page_import" class='rad_button_secondary r_left'><?php _e('Page Library','ioa') ?></a>
 			<a href="" id="rad_page_section_import" class='rad_button_secondary r_left'><?php _e('Sections Library','ioa') ?></a>
 			-->

			<a href="" class="persist-editor rad_button_secondary r_left">Start Automatically</a>
 			<a href="" id="rad_page_section_clearall" class='rad_button_error r_right'><?php _e('Clear All','ioa') ?></a>


 			<div class="rad_file_menu_wrap clearfix r_right">
 			     <ul class="rad_file_sub_menu">
 			     	<!-- <li><a href="" class='import-page-templates'>Import</a></li> -->
 			     	<li><a href="" class='export-templates'>Export</a></li>
 			     	<li><a href="" class='save-template'>Save as Template</a></li>
 			     </ul>
 				<a href="" id="rad_page_section_import" class='rad_button_menu r_left'><i class="ioa-front-icon cog-2icon-"></i><?php _e('Menu','ioa') ?></a>
 			</div>
			 <?php RADLiveBuilder::widgetArea() ?>	
 		</div>
 </div>
 

