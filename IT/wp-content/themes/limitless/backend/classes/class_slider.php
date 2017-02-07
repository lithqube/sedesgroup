<?php 
/**
 * Core Class For Creating Slider
 * @author Abhin Sharma 
 * @dependency none
 * @since  IOA V1
 */

if(!is_admin()) return;

 if(!class_exists('SliderItem'))
{
	class SliderItem
	{
		private $inputs;
		private $options;

		private $coordinates;
		
		function __construct($inputs,$options)
		{	
			$this->inputs = $inputs;
			$this->options = $options;
			$this->coordinates = $options['coordinates'];
			
		}

		function getOptions()
		{
			return $this->options;
		}

		function getInputKeys()
		{
			$keys = array();

			foreach($this->inputs as $k => $grouping)
			{
				foreach($grouping as $k => $input)
				{	
				
					if(isset($input['name']) )
					$keys[] =   $input['name'];
				}
				
			}

			return $keys;
		}

		function getMetaKeys()
		{
			$keys = array();

			foreach($this->inputs as $k => $grouping)
			{
				foreach($grouping as $k => $input)
				{	
				
					if(isset($input['meta']) )
					$keys[] =   $input['name'];
				}
				
			}

			return $keys;
		}

		public function getHTML($values = false)
		{
			
			
			$markup = ''; $dy = '';

			
			$markup .= "<div class='media-slide clearfix'> 

								<div class='media-slide-head clearfix'>
									<a href='' class='mslide-edit edit-icon ioa-front-icon pencil-3icon-'>   </a>
									<a href='' class='mslide-delete'> <i class='ioa-front-icon cancel-circled-2icon- cross'></i> </a> ";

			if(isset($values['thumbnail'])) $markup .= "<img src='".$values['thumbnail']."' />";

			$markup .= "</div> 
								<div class='slider-component-tab clearfix'><div class='inner-slide-body-wrap'><a href='' class='ioa-front-icon cancel-circled-2icon- cross close-media-body'></a><ul class='clearfix'>";
			foreach($this->inputs as $k => $group)
			{
				$markup.= "<li><a href='#".str_replace(" ","_",$k)."'>".$k."</a></li>";
			}
			$markup .= "</ul>";

			foreach($this->inputs as $k => $group)
			{


				$markup .= "
					
						<div id='".str_replace(" ","_",$k)."' class=\"slider-component-body clearfix\"><div class='clearfix inner-body-wrap'>
					";

				foreach($group as $k => $input)
				{	

					if(is_array($values))
					{

						if(isset($input['name']) && isset($values[ $input['name']]) )
						$input['value'] =  $values[ $input['name']];

						if(  isset($values[ $input['name'].'_data']) ) 
						{
							$input['value'] =  $values[ $input['name'].'_data'];
						}

					}	

					$markup .= getIOAInput($input);

				}
			
				$markup .= "</div></div>";

			}
			$markup .= "</div></div></div>";
			

			return $markup;
			
		}


		public function getOptionsHTML($values = false)
		{
			
			
			$markup = ''; $dy = '';

			
			$markup .= "<div class='slider-component-tab clearfix'><div class='inner-slide-body-wrap'><ul class='clearfix'>";
			foreach($this->options['inputs'] as $k => $group)
			{
				$markup.= "<li><a href='#".str_replace(" ","_",$k)."'>".$k."</a></li>";
			}
			$markup .= "</ul>";

			foreach($this->options['inputs'] as $k => $group)
			{


				$markup .= "
					
						<div id='".str_replace(" ","_",$k)."' class=\"slider-component-body clearfix\"><div class='clearfix inner-body-wrap'>
					";

				foreach($group as $k => $input)
				{	

					if(is_array($values))
					{

						if(isset($input['name']) && isset($values[ $input['name']]) )
						$input['value'] =  $values[ $input['name']];

						if(  isset($values[ $input['name'].'_data']) ) 
						{
							$input['value'] =  $values[ $input['name'].'_data'];
						}

					}	

					$markup .= getIOAInput($input);

				}
			
				$markup .= "</div></div>";

			}
			$markup .= "</div></div>";
			

			return $markup;
			
		}


		public function getUniq()
		{
			return str_replace(' ','_',$this->options['label']);
		}
											
		

	}
}

function add_slider_component($inputs,$options)
{
	global $ioa_sliders;
	$ioa_sliders[str_replace(' ','_',$options['label'])] = new SliderItem($inputs,$options);

}
// Fade Slider
add_slider_component(array(
							"General Fields" => array(

							array(  "label" => __("Upload Image",'ioa') , "name" => "image" ,"default" => "" ,"type" => "upload","description" => "","length" => 'medium')  ,
							
							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Alt Attribute Text",'ioa') , "name" => "alt_text" ,"default" => "Image" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array( "label" => __("Image Resizing",'ioa') , "name" => "image_resize" , "default" => "yes" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) )  ,


							array( "label" => __("Text",'ioa') , "name" => "text_desc" , "default" => "Your text here." , "type" => "textarea", "description" => "", "length" => 'medium') ,
							
							array(  "label" => __("Image Thumbnail",'ioa') , "name" => "thumbnail" ,"default" => "" ,"type" => "hidden","description" => "","length" => 'medium')  ,
								

							),
							/*
							"Coordinates" => array(

							array(  "label" => __("Title X",'ioa') , "name" => "text_title_x" ,"default" => "0" ,"type" => "text", "description" => "", "length" => 'small') ,
							array(  "label" => __("Title Y",'ioa') , "name" => "text_title_y" ,"default" => "150" ,"type" => "text", "description" => "", "length" => 'small') ,
							
							array( "label" => __("Text X",'ioa') , "name" => "text_data_x" , "default" => "0" , "type" => "text", "description" => "", "length" => 'small') ,
							array( "label" => __("Text Y",'ioa') , "name" => "text_data_y" , "default" => "180" , "type" => "text", "description" => "", "length" => 'small') 
								

							),
							"Caption Style" => array(

							array( "alpha"=>false, "label" => __("Color",'ioa') , "name" => "text_title_color" ,"default" => "#666666 << " ,"type" => "colorpicker", "description" => "", "length" => 'small') ,
							array( "alpha"=>false, "label" => __("Background Color",'ioa') , "name" => "text_title_bgcolor" ,"default" => "#ffffff << " ,"type" => "colorpicker", "description" => "", "length" => 'small') ,
							
							array(  "alpha"=>false,"label" => __("Color",'ioa') , "name" => "text_desc_color" ,"default" => "#888888 << " ,"type" => "colorpicker", "description" => "", "length" => 'small') ,
							array( "alpha"=>false, "label" => __("Background Color",'ioa') , "name" => "text_desc_bgcolor" ,"default" => "#ffffff << " ,"type" => "colorpicker", "description" => "", "length" => 'small') ,


							)
							 */

							 ),

						array(  "label" => __("Slider",'ioa')  ,"coordinates" => true , 
							 	"inputs" => array(
								
								"Slider Settings" => array(

							array( "label" => __("Width(in px)",'ioa') , "name" => "width" , "default" => "500" , "type" => "text", "description" => "", "length" => 'small') ,
							array( "label" => __("Height(in px)",'ioa') , "name" => "height" , "default" => "350" , "type" => "text", "description" => "", "length" => 'small') ,
							array( "label" => __("Full Width(Only for sliders)",'ioa') , "name" => "full_width" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							array( "label" => __("Adaptive height(Only for sliders)",'ioa') , "name" => "adaptive" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							
							array( "label" => __("Media Type",'ioa') , "name" => "effect_type" , "default" => "fade" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("fade" => __("Slider Fade",'ioa'),"overlap-left" => __("Overlap Left",'ioa'),"overlap-right" => __("Overlap Right",'ioa'),"overlap-top" => __("Overlap Top",'ioa'),"overlap-bottom" => __("Overlap Bottom",'ioa'),"scroll" => __("Scroll",'ioa'),"scroll-persepctive" => __("Scroll Perspective",'ioa'),"gallery" => __("Gallery",'ioa') ) )  ,


							array( "label" => __("Slide Show Time(in secs)",'ioa') , "name" => "duration" , "default" => "4" , "type" => "text", "description" => "", "length" => 'small') ,
							array( "label" => __("Autoplay",'ioa') , "name" => "autoplay" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							array( "label" => __("Captions",'ioa') , "name" => "captions" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							array( "label" => __("Controls",'ioa') , "name" => "arrow_control" , "default" => "true" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							array( "label" => __("Bullets / Thumbnail",'ioa') , "name" => "bullets" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							

							)

							 	)
							 )

					);	

