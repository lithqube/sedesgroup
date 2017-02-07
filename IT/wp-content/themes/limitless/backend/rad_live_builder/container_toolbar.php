<?php
/**
 * Show Container Area Toolbar
 */
global $ioa_meta_data;


if(!isset($ioa_meta_data['playout'])) $ioa_meta_data['playout'] = 'full';
?>
<div class="rad_container_toolbar clearfix">
 			<div class="rad_container_layout">
	 			<?php 
	 			echo getIOAInput(array(
	 				 "label" => "" , 
											"name" => "component_layout" , 
											"default" => "100%" , 
											"type" => "select",
											"description" => "" ,
											"options" => array("full" => "100%", "four_fifth" => "80%" , "three_fourth" => "75%", "two_third" => "66%","one_half" => "50%","one_third" => "33%", "one_fourth" => "25%", "one_fifth" => "20%"),
											"value" => $ioa_meta_data['playout'] , "data" => array("attr" => "component_layout_holder" ) 
									) );
	 			?>
	 		</div>
			<div class="rad_right_panel clearfix">
				<a href="" class="container-clone"><i class="ioa-front-icon  docsicon-"></i></a>
	 			<a href="" class="container-delete"><i class="ioa-front-icon cancel-2icon-"></i></a>
	 			<a href="" class="container-edit"><i class="ioa-front-icon  edit-1icon-"></i></a>
			</div>
</div>						 

<i class="container-sortable-handle move-2icon- ioa-front-icon"></i>