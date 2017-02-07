<?php 
/**
 * Core Class For Creating Custom Posts
 * @author Abhin Sharma 
 * @dependency none
 * @since  IOA V1
 */

 if(!class_exists('IOACustomPostType'))
{
	class IOACustomPostType
	{
		private $inputs;
		private $ioa_options;

		
		function __construct($inputs,$ioa_options)
		{	
			$this->inputs = $inputs;
			$this->options = $ioa_options;
			
 				
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

			
			$markup .= "<div class='cp-slide clearfix'> 

								<div class='cp-slide-head clearfix'>
									<a href='' class='mcp-edit '><i class='edit-icon pencil-3icon- ioa-front-icon'></i>  </a>
									<a href='' class='mcp-delete cancel-circled-2icon- ioa-front-icon'>  </a>
									";

			if(isset($values['meta_name'])) $markup .= "<span>".$values['meta_name']."</span><span class='use'> To use this field , use this shortcode <strong>[get field='".$values['meta_name']."'/]</strong></span>";
			else $markup .= "<span></span>";
			$markup .= "</div> 
								<div class='CP-component-tab clearfix'><div class='inner-slide-body-wrap'>";

			foreach($this->inputs as $k => $group)
			{


				$markup .= "
					
						<div id='".str_replace(" ","_",$k)."' class=\"CP-component-body clearfix\"><div class='clearfix inner-body-wrap'>
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


		public function getOptionsHTML($values = false,$post_name='')
		{
			
			
			$markup = ''; $dy = '';

			
			$markup .= "<div class='CP-component-tab clearfix'><div class='inner-slide-body-wrap'>";

			foreach($this->options['inputs'] as $k => $group)
			{


				$markup .= "
					
						<div id='".str_replace(" ","_",$k)."' class=\"CP-component-body clearfix\"><div class='clearfix inner-body-wrap'>
					";

				foreach($group as $k => $input)
				{	

					if(is_array($values))
					{
						
						if(isset($input['name']) && isset($values[ $input['name']]) )
						$input['value'] =  $values[ $input['name']];

						if(  isset($values[ $input['name']]) ) 
						{
							$input['value'] =  $values[ $input['name']];
						}
						else
							$input['value'] = str_replace("[OBJ]",ucwords($post_name),$input['default']);


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

function add_custompost_component($inputs,$ioa_options)
{
	global $custom_posts;
	$custom_posts['default'] = new IOACustomPostType($inputs,$ioa_options);

}

add_custompost_component(array(
							"General Fields" => array(

							array( "alpha"=>false, "label" => __("Label Color",'ioa') , "name" => "title_color" ,"default" => "#666666 << " ,"type" => "colorpicker", "description" => "", "length" => 'small') ,
							array(  "label" => __("Input Name",'ioa') , "name" => "meta_name" ,"default" => "" ,"type" => "text","description" => "","length" => 'medium')  ,
							array(  "label" => __("Input Type",'ioa') , "name" => "type" ,"default" => "text" ,"type" => "select", "description" => "", "length" => 'medium' , "options" => array("text" => "Text Field" , "textarea" => "Textarea Field" , "upload" => "Upload Field"  ) ) ,
							array(  "label" => __("Default Value",'ioa') , "name" => "default" ,"default" => "" ,"type" => "text","description" => "","length" => 'medium')  ,
								

							),
							
						 ),

						array(  "label" => "Default"  ,
							 	"inputs" => array(
								
								"Default Settings" => array(
							
							array( "label" => __("Set Post Icon",'ioa') , "name" => "post_icon" , "default" => "" , "type" => "upload", "description" => "", "length" => 'medium') ,
									
							array( "label" => __("Enter Singular Name",'ioa') , "name" => "singular_name" , "default" => "[OBJ]" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Label for New",'ioa') , "name" => "add_new" , "default" => "Add New [OBJ]" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Label for Add New Item",'ioa') , "name" => "add_new_item" , "default" => "Add New [OBJ]" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Label for Edit New Item",'ioa') , "name" => "edit_item" , "default" => "Edit [OBJ]" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" =>  __("Label for New Item",'ioa') , "name" => "new_item" , "default" => "New [OBJ]" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" =>  __("Label for All Items",'ioa') , "name" => "all_items" , "default" => "All [OBJ]" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" =>  __("Label for View Items",'ioa') , "name" => "view_item" , "default" => "View [OBJ]" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" =>  __("Label for Search Items",'ioa') , "name" => "search_items" , "default" => "Search [OBJ]" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" =>  __("Label for Not Found" ,'ioa'), "name" => "not_found" , "default" => "[OBJ] Not Found" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" =>  __("Label for Not Found in Trash",'ioa') , "name" => "not_found_in_trash" , "default" => "[OBJ] Not found in trash" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" =>  __("Parent Item Color",'ioa') , "name" => "parent_item_colon" , "default" => "" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" =>  __("Menu Name",'ioa') , "name" => "menu_name" , "default" => "[OBJ]" , "type" => "text", "description" => "", "length" => 'medium') ,
							
							array( "label" => __("Enter Categories(Taxonomies)",'ioa') , "name" => "taxonomies" , "default" => "[OBJ] Categories" , "type" => "text", "description" => "", "length" => 'medium') ,


							 	)
							 )
							
							)


					);	

