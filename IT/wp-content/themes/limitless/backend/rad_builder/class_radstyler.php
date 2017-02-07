<?php 
/**
 * Core Class To Style RAD Builder Components
 * @author Abhin Sharma 
 * @dependency none
 * @since  IOA Framework V1
 */

 if(!class_exists('RADStyler'))
{
	class RADStyler
	{
		

		
		function registerbgColor($key='' ,$target='')
		{
			
			$code ='<h5 class="sub-styler-title">'.__('Set Background Color','ioa').'<i class="angle-downicon- ioa-front-icon"></i></h5><div class="sub-styler-section clearfix">';

			$code .= getIOAInput(array( 
							"label" => __("Background Color",'ioa') , 
							"name" => $key."_bg_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'small',
							"value" => "" ,
							 "data" => array(

							 			"target" => $target ,
							 			"property" => "background-color" 

							 			)  
							));

						

			return $code.'</div>';
		}

		function registerBorder($key='' ,$target='')
		{
			
			$code ='<h5 class="sub-styler-title">'.__('Set Border','ioa').'<i class="angle-downicon- ioa-front-icon"></i></h5><div class="sub-styler-section clearfix">';

			$code .= getIOAInput(array( 
							"label" => __("Top Border Color",'ioa') , 
							"name" => $key."_tbr_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'small',
							"value" => "" ,
							 "data" => array(

							 			"target" => $target ,
							 			"property" => "border-top-color" 

							 			)  
							));

			$code .= getIOAInput(array( 
							"label" => __("Top Border Size(ex : 1px)",'ioa') , 
							"name" => $key."_tbr_width" , 
							"default" => "" , 
							"type" => "text",
							"description" => "",
							"length" => 'small',
							"class" => ' rad_style_property ',
							"value" => "0px" ,
							 "data" => array(

							 			"target" => $target ,
							 			"property" => "border-top-width" 

							 			)  
							));
			
			$code .= getIOAInput(array( 
							"label" => __("Bottom Border Color",'ioa') , 
							"name" => $key."_bbr_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'small',
							"value" => "" ,
							 "data" => array(

							 			"target" => $target ,
							 			"property" => "border-bottom-color" 

							 			)  
							));

			$code .= getIOAInput(array( 
							"label" => __("Bottom Border Size(ex : 1px)",'ioa') , 
							"name" => $key."_bbr_width" , 
							"default" => "" , 
							"type" => "text",
							"description" => "",
							"length" => 'small',
							"class" => ' rad_style_property ',
							"value" => "0px" ,
							 "data" => array(

							 			"target" => $target ,
							 			"property" => "border-bottom-width" 

							 			)  
							));			

			return $code.'</div>';

		}


		function registerbgImage($key ,$target)
		{
			
			$code ='<h5 class="sub-styler-title">'.__('Set Background Image','ioa').'<i class="angle-downicon- ioa-front-icon"></i></h5><div class="sub-styler-section clearfix">';
			

			$code .=  getIOAInput(array( 
									"label" => __("Add Background Image",'ioa') , 
									"name" => $key."_bg_image" , 
									"default" => "" , 
									"type" => "upload",
									"description" => "" ,
									"length" => 'small'  ,
									"title" => __("Use as Background Image",'ioa'),
				  					"std" => "",
				 					"button" => __("Add Image",'ioa'),
				 					"class" => ' rad_style_property ',
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-image" 

							 			) 

							) );
			$code .= getIOAInput(array( 
									"label" => __("Background Position",'ioa') , 
									"name" => $key."_bgposition" , 
									"default" => "top left" , 
									"type" => "select",
									"class" => ' rad_style_property ',
									"description" => "" ,
									"length" => 'medium'  ,
									"options" => array("top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right"),
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-position" 

							 			)  			 
							) );

			$code .= getIOAInput(array( 
									"label" => __("Background Cover",'ioa') , 
									"name" => $key."_bgcover" , 
									"default" => "auto" , 
									"type" => "select",
									"class" => ' rad_style_property ',
									"description" => "" ,
									"length" => 'medium'  ,
									"options" => array("auto","contain","cover"),
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-size" 

							 			)  			 
							) );

			$code .= getIOAInput(array( 
									"label" => __("Background Repeat",'ioa') , 
									"name" => $key."_bgrepeat" , 
									"default" => "repeat" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"options" => array("repeat","repeat-x","repeat-y","no-repeat"),
									"class" => ' rad_style_property ',
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-repeat" 

							 			) 
												 
							) );
			
			$code .= getIOAInput(array( 
									"label" => __("Background Scroll",'ioa') , 
									"name" => $key."_bgscroll" , 
									"default" => "" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"options" => array("scroll","fixed"),
									"class" => ' rad_style_property ',
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-attachment" 

							 			) 
												 
							) );				

			return $code.'</div>';
		}

		function registerbgGradient($key ,$target)
		{
			
			$code ='<h5 class="sub-styler-title">'.__('Set Background Gradient','ioa').'<i class="angle-downicon- ioa-front-icon"></i></h5><div class="sub-styler-section clearfix"><a class="set-rad-gradient button-default" href="">'.__('Apply','ioa').'</a> ';
			
			$code .= getIOAInput(array( 
									"label" => __("Use Background Gradient",'ioa') , 
									"name" =>  $key."_gradient_dir" , 
									"default" => "no" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'small'  ,
									"options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ),
									"class" => '  hasGradient dir ',
									"data" => array(

							 			"target" => $target ,
							 			"property" => "removable" 

							 			) 
												 
							) );

			$code .= getIOAInput(array( 
									"label" => __("Select Start Background Color for title area",'ioa') , 
									"name" =>  $key."_grstart" , 
									"default" => " << " , 
									"type" => "colorpicker",
									"description" => "  " ,
									"length" => 'small'  ,
									"alpha" => false,
									"class" => ' hasGradient grstart no_listen ',
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-image" 

							 			) 
							) );

			$code .= getIOAInput(array( 
									"label" => __("Select Start Background Color for title area",'ioa') , 
									"name" =>  $key."_grend" , 
									"default" => " << " , 
									"type" => "colorpicker",
									"description" => "  " ,
									"length" => 'small'  ,
									"alpha" => false,
									"class" => ' hasGradient grend no_listen ',
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-image" 

							 			) 
							) );
			return $code.'</div>';		
		}

		

	}
}



