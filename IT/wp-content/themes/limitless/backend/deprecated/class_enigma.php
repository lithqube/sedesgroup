<?php 
/**
 * Enigma Styler -- Official Styler for IOA Framework
 * @author Abhin Sharma 
 * @dependency none
 * @since  IOA Framework V1
 */





 if(!class_exists('Enigma'))
{
	class Enigma extends RADStyler
	{
		private $data;
		function __construct()
		{
			$en_data  = array();
			$data = array();
			$template = get_option(SN.'_active_etemplate');
			
			if(!$template)
			{
				$data = get_option(SN.'_enigma_data');
			}
			else
			{
				if($template=="default")
					$data =get_option(SN.'_enigma_data');
				else
					$data =get_option($template);

				
				
			}

			if($data) :
			foreach ($data as $key => $v) {
				if(isset($v['target']))	
				$en_data[trim($v['target']).''.trim($v['name'])] = $v['value']; 
				
			}
			endif;


			$this->data = $en_data;
		}
		public function getBackgroundImage($label , $prop , $target)
		{
			
			
			$code ='';
			$defimage = ''; $defposition = "top left"; $defsize = "auto"; $defrepeat = "repeat"; $defattachment = "scroll";

			if(isset($this->data[trim($target).''.trim($prop)])) $defimage = $this->data[trim($target).''.trim($prop)];


			$code .=  getIOAInput(array( 
									"label" => __("Background Image",'ioa') , 
									"name" => "_bg_image" , 
									"default" => $defimage , 
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

			if(isset($this->data[$target."background-position"])) $defposition = $this->data[$target."background-position"];


			$code .= getIOAInput(array( 
									"label" => __("Background Position",'ioa') , 
									"name" => "_bgposition" , 
									"default" => $defposition , 
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

			if(isset($this->data[$target."background-size"])) $defsize = $this->data[$target."background-size"];


			$code .= getIOAInput(array( 
									"label" => __("Background Cover",'ioa') , 
									"name" => "_bgcover" , 
									"default" => $defsize , 
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

			if(isset($this->data[$target."background-repeat"])) $defrepeat = $this->data[$target."background-repeat"];


			$code .= getIOAInput(array( 
									"label" => __("Background Repeat",'ioa') , 
									"name" => "_bgrepeat" , 
									"default" => $defrepeat , 
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
			if(isset($this->data[$target."background-attachment"])) $defattachment = $this->data[$target."background-attachment"];
				
			$code .= getIOAInput(array( 
									"label" => __("Background Scroll",'ioa') , 
									"name" => "_bgscroll" , 
									"default" => $defattachment , 
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
			return $code;
		}
		
		public function createStyleMatrix($args)
		{
			global $super_options;
			
			$code = '';

			$websafe_fonts = array("Arial","Helvetica Neue","Helvetica",'Tahoma',"Verdana","Lucida Grande","Lucida Sans");
			$font_stack = get_option(SN.'font_stacks'); 
			$registered_fonts = array();

			if($font_stack!="" && is_array($font_stack))
			{
				foreach ($font_stack as $key => $font) {
					$font_br = explode(';',$font);
					$registered_fonts[] = $font_br[0];
				}
			}
  			
  			$fn_fonts = array_merge( array("None"), $registered_fonts, $websafe_fonts);

  			$fts = "google";
			if( get_option(SN.'font_selector') ) $fts = get_option(SN.'font_selector');

			if($fts=="fontface") 
			{
				$fontfaces = array("None");
				$font = $super_options[SN.'_font_face_font'];
				if(isset($font) && $font!="") $fontfaces[] = $font;
				$fn_fonts = array_merge( $fontfaces, $websafe_fonts);
			}

			if($fts=="fontdeck") 
			{
				$fontdeck = array("None");
				$font = $super_options[SN.'_font_deck_name'];
				if(isset($font) && $font!="") $fontdeck[] = $font;
				$fn_fonts = array_merge( $fontdeck, $websafe_fonts);
			}

				

			foreach ($args as $key => $section) {
			$code .='<div class="en-sub-sec" data-search="'.strtolower($key).'" ><h4 class="engima-styler-title">'.$key.'<a href="" class="en-section-reset">'.__('Reset','ioa').'</a> </h4><div class="enigma-styler-section clearfix">';

			foreach ($section as  $key => $arg) {
					
			$code .='<div class="en-sub-sec" data-search="'.strtolower($arg['label']).'"><h5 class="sub-styler-title">'.$arg['label'].'<a href="" class="en-comp-reset">'.__('Reset','ioa').'</a> </h5><div class="sub-styler-section clearfix">';

			$i =0;
			
				
				
					foreach($arg['matrix'] as $key => $value)
					{
						$props = explode(',',$value['prop']);
						$defaults = array();
						if(isset($value['default']))
							$defaults = explode(',',$value['default']);
						$j=0;
						foreach ($props  as $prop) {
							
							$def = 	''; $d = '';
							if(isset($defaults[$j])) {
								 $def = $defaults[$j]; $d =  $defaults[$j];
							}
							$cls = '';

							if(isset($value['sync'])) $cls = ' sync ';
							if(isset($value['dark'])) $cls = ' sync-dark ';

							
							

							//div.inner-super-wrapperfont-family
							//div.inner-super-wrapperfont-family
							
							if(isset($this->data[trim($key).''.trim($prop)])) $def = $this->data[trim($key).''.trim($prop)];

							switch($prop)
							{
								case 'background-image' : $code .= $this->getBackgroundImage($value['label'],$prop,$key); break;
								case 'font-size' :

								$code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => $d , 
													"type" => "text",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => "font-size"

													 			)  
													)); break;
								case 'line-height' :

								$code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => $d , 
													"type" => "text",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => "line-height"

													 			)  
													));
								break;
								case 'border-width' :
								case 'border-bottom-width' :

								$code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => '1px' , 
													"type" => "text",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => $prop

													 			)  
													));
								break;
								case 'left' :
								case 'right' :
								case 'top' :
								case 'bottom' : $code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => '0px' , 
													"type" => "text",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => $prop

													 			)  
													));
								break;
								case 'border-style' :
								case 'border-bottom-style' :
								$code .= getIOAInput( 
															array( 
																	"label" => $value['label'] , 
																	"name" => "styler".$i , 
																	"default" => $d , 
																	"type" => "select",
																	"description" => "",
																	"length" => 'small',
																	"value" => $def ,
																	"options" => array('solid','dashed','dotted'),
																	"class" => $cls,
																	 "data" => array(

																	 			"target" => $key ,
																	 			"property" => $prop

																	 			)  
													));
								break;
								case 'font-family' :
								
								$code .= "<div class='info'> To add More Fonts, Click on Fonts on <strong>Top Menu</strong>. </div>".getIOAInput( 
															array( 
																	"label" => $value['label'] , 
																	"name" => "styler".$i , 
																	"default" => $d , 
																	"type" => "select",
																	"description" => "",
																	"length" => 'small',
																	"value" => $def ,
																	"options" => $fn_fonts,
																	"class" => $cls.' font-family-sel ',
																	 "data" => array(

																	 			"target" => $key ,
																	 			"property" => "font-family"

																	 			)  
													));
								break;
								case 'font-weight' :
								$code .= getIOAInput( 
															array( 
																	"label" => $value['label'] , 
																	"name" => "styler".$i , 
																	"default" => $d , 
																	"type" => "text",
																	"description" => "",
																	"length" => 'small',
																	"value" => $def ,
																	"class" => $cls,
																	 "data" => array(

																	 			"target" => $key ,
																	 			"property" => "font-weight"

																	 			)  
													));
								break;
								case 'parent-background-color' : 
								if(isset($this->data[$key.'background-color'])) $def = $this->data[$key.'background-color'];

								$code .= getIOAInput(array( 
													"label" => "Background Color" , 
													"name" => "styler".$i , 
													"default" => $d , 
													"type" => "colorpicker",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => "background-color"

													 			)  
													)); break;
								default : $code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => $d , 
													"type" => "colorpicker",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => $prop

													 			)  
													));
							}
							$j++;

						}
						$i++;
					}
					$code .= '</div></div>';
			}	
					$code .= '</div></div>';

		}

			return $code;
		}

		

	}
}



