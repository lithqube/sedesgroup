<?php
/**
 * Show Container Area Toolbar
 */
global $ioa_meta_data;

$layout = 'auto';
?>
<div class="widget-toolbar clearfix">
 		<!--
 		<div class="rad_widget_layout">
 			<?php 
 			echo getIOAInput(array(
 				 "label" => "" , 
										"name" => "widget_layout" , 
										"default" => "100%" , 
										"type" => "select",
										"description" => "" ,
										"options" => array("full" => "100%" , "three_fourth" => "75%", "two_third" => "66%","one_half" => "50%","one_third" => "33%", "one_fourth" => "25%" , "auto" => "Auto"),
										"value" => $layout , "data" => array("attr" => "component_layout_holder" ) 
								) );
 			?>
		</div>
		-->
		<div class="rad_w_right_panel clearfix">
			<a href="" class="widget-clone"><i class="ioa-front-icon  docsicon-"></i></a>
			<a href="" class="widget-delete"><i class="ioa-front-icon cancel-2icon-"></i></a>
 			<a href="" class="widget-edit"><i class="ioa-front-icon  edit-1icon-"></i></a>	
 			<i class="ioa-front-icon move-2icon- rad-widget-handle"></i>
		</div>		
</div>