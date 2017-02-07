<?php

/**
 *  Core Functions for Creating Input / Interactive Components for the framework
 *  Code Name : Glass
 *	Version : 1.1
 */


function getIOAInput($params = array() )
{
	$input_length = 'medium'; $color= ''; $d_str = ''; $d_c= ''; $class=''; $data = array(); $after_input = ''; $icon_button = '';

	if(!isset($params['type'])) $params['type'] = 'text';
	if(!isset($params['label'])) $params['label'] = '';
	if(!isset($params['name'])) $params['name'] = '';

	if(  $params['type']=="module") return getIOAModule($params);

	if(isset($params['length'])) $input_length = $params['length'];
	if(isset($params['after_input'])) $after_input = $params['after_input'];
	if(isset($params['data'])) $data = $params['data'];	
	if(isset($params['class'])) $class = $params['class'];		
	if(isset($params['color'])) $color = $params['color'];		
	if(isset($params['buttons'])) $icon_button =$params['buttons'];	

	if(is_array($data))
	foreach($data as $k => $v)
	{
		if(!is_array($v)) :
			$d_str .= ' data-'.$k." ='".$v."' ";
			$d_c .= "_".$v;
		endif;
	}


	if($params['type']=="hidden") return "<div class='ioa_input hidden-field clearfix $d_c $class' $d_str >".getIOAHiddenInput($params).$after_input."</div>";
	if($params['type']=="info") return '<div class="ioa-information-p">'.$params['default'].'</div>';
	
	$editor =''; $desc = '';
	if(isset($params['is_editor']) && $params['is_editor'] )  $editor =' editor ';
	
	if($params['type'] == 'upload') $class .= ' has-input-button ioa-image-upload-text ';	


	if(isset($params['description'])) $desc = $params['description'];			
	$str = " 
			<div class='ioa_input clearfix $d_c $class' $d_str data-label='".strtolower($params['label'])."' >
				<label style='color:{$color}'> ".$params['label']." $icon_button </label>
				<div class='ioa_input_holder clearfix ".$input_length." ".$editor." '>
				
				";

	

	switch($params['type'])
	{
		case 'text' : $str .= "<a class='input-val-delete cancel-1icon- ioa-front-icon' href=''></a> ".getIOATextInput($params); break;
		case 'textarea' : $str .= "<a class='input-val-delete cancel-1icon- ioa-front-icon' href=''></a> ".getIOATextAreaInput($params); break;
		case 'select' : $str .= getIOASelectInput($params); break;
		case 'checkbox' : $str .= getIOACheckboxInput($params); break;
		case 'radio' : $str .= getIOARadioInput($params); break; 
		case 'toggle' : $str .= getIOAToggleInput($params); break; 
		case 'colorpicker' : $str .= getIOAColorpickerInput($params); break;
		case 'slider' : $str .=getIOASliderInput($params); break;
		case 'upload' : $str .= getIOAUploadInput($params); break;
		case 'zipupload' : $str .= getIOAZipUploadInput($params); break;
		case 'video' : $str .= getIOAVideoInput($params); break;
		case 'hidden' : $str .= getIOAHiddenInput($params); break; 
		case 'module' : $str .= getIOAModule($params); break; 
		

	}			

	$markup = '';
	if(isset($params['addMarkup'])) $markup = $params['addMarkup'];

	$str .= "	".$markup."
				</div> $after_input
				".getIOATooltip($desc)."	
			</div> 

			";

	return $str;		
}

/**
 * Function to create Modules
 */

function getIOAModule($params)
{
	
	$value = '';
	
	$v = '';

	if(isset($params['value']))	$v = $params['value'];

	$processed_inp = '';
	$data_field = getIOAInput(array( "label" => "" , "name" => $params['name']."" , 'class' => ' mod_data' , "default" => "" , "type" => "hidden", "description" => "", "length" => 'medium', "value" => $v ) 
);			
	$values = array(); $setval = '';
	if(isset($params['value'])) $values = explode('[ioa_mod]',$params['value']);

	foreach ($values as $key => $value) {
		
		if($value!="")
		{
			$inpval = array();
			$mods = explode('[inp]', $value);	
			
			foreach($mods as $m)
			{

				if($m!="")
				{
					$te = (explode('[ioas]',$m)); 
					if(isset($te[1]))
					$inpval[$te[0]] = $te[1]; 
				}

				
			}

			$setval .= '<div class="ioa_module ">
							<div class="module_head">
							 '.$params['unit'].'  <a class="pencil-3icon- ioa-front-icon edit-mod" href=""></a> <a href="" class="docsicon- ioa-front-icon clone-mod"></a> <a class="delete-mod" href=""></a>
							</div>
							<div class="module_body">';

						foreach($params['inputs'] as $input) 
						{
							$input['value'] = '';

							if(isset($inpval[$input['name']]))
							$input['value'] = $inpval[$input['name']];

							$temp = $input;
							if(isset($temp['class'])) 
								$temp['class'] .= ' ioa_mod_input ';
							else
								$temp['class'] = ' ioa_mod_input ';
							
							$setval .= getIOAInput($temp);	
						}
								
			$setval .= '</div>  

						</div>	';

			//prettyPrint($inpval);
			
		}

	}

	foreach($params['inputs'] as $input) 
		{
			$temp = $input;
			if(isset($temp['class'])) 
				$temp['class'] .= ' ioa_mod_input ';
			else
				$temp['class'] = ' ioa_mod_input ';
							
			$processed_inp .= getIOAInput($temp);	
		}

	$class = '';
	$control = '';	
	if(isset($params['class']))	 $class = $params['class'];
	if(isset($params['control']))	 $control = $params['control'];


	$markup = '<div class="ioa_module_container '.$class.' clearfix"> 
					<div class="ioa_module_container_head clearfix"> <span>'.$params['label'].'</span> <div class="ioa_module_button_panel clearfix"><a data-restore="'.__('Update Changes','ioa').'" data-save="'.__('Saved','ioa').'" class="button-save save-ioa-module" href="">'.__('Update Changes','ioa').'</a> <a class="button-default add-ioa-module" href="">'.__('Add','ioa').$params['unit'].'</a> '.$control.' </div> </div>	
					<div class="ioa_module_container_body">
						<div class="module_list">
							'.$setval.'
						</div>

						<div class="ioa_module hide">
							<div class="module_head">
							 '.$params['unit'].'  <a class="edit-mod pencil-3icon- ioa-front-icon" href=""></a><a href="" class="docsicon- ioa-front-icon clone-mod"></a> <a class="delete-mod" href=""></a>
							</div>
							<div class="module_body">
								'.$processed_inp.'
							</div>  

						</div>	

						'.$data_field.'	
					</div>
			   </div>';
		
	return $markup;
}



/**
 * Function to create Text Fields
 */

function getIOATextInput($params)
{
	$value = '';
	$def = '';
	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = $params['value'];
	else if(isset($params['default']))
		$value = $params['default'];

	if(isset($params['default'])) $def = $params['default'];

	$value = stripslashes($value);

	$str = " <input type='text' data-default='".$def."' value=\"".$value."\" name='".$params['name']."' id='".$params['name']."' class='".$params['name']."'/> ";

	if(isset($params['clear_switch'])) $str .= "<i class='ioa-front-icon cancel-2icon- clear-switch'></i>";

	return $str;
}

/**
 * Function to create Hidden Fields
 */

function getIOAHiddenInput($params)
{
	$value = '';
	
	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = $params['value'];
	else
		$value = $params['default'];

	$str = " <input type='hidden'  data-default='".$params['default']."' value='".$value."' name='".$params['name']."' id='".$params['name']."' class='".$params['name']."'/> ";

	return $str;
}

/**
 * Function to create Upload Fields
 */

function getIOAUploadInput($params)
{
	$value = '';
	$label = __('Add','ioa');
	$title = __('Add Image','ioa');
	
	if( isset($params['button']) && trim($params['button']) != ""  )  $label = $params['button'];
	if( isset($params['title']) && trim($params['title']) != ""  )  $title = $params['title'];	

	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = $params['value'];
	else
		$value = $params['default'];

	$str = " <div class='image_upload_wrap clearfix'>
				<div class='clearfix'><a href='' data-title='$title' data-label='$label' class='image_upload button-default'> ".__('Upload','ioa')." </a> <input type='text' class=' ".$params['name']."'  data-default='".$params['default']."' value='".$value."' name='".$params['name']."' id='".$params['name']."' /></div>"; 

	$style ='';			
	if(trim($value)=="") $style ='style="display:none"';	
	
		$str .= "<div class='input-image-preview' $style>
					<img src='".$value."' alt='input image preview' />
					<span class='himage-remove'></span>
				 </div>";
					

	$str .= "</div>";

	return $str;
}

/**
 * Function to create Zip Upload Fields
 */

function getIOAZipUploadInput($params)
{
	$value = '';
	$label = __('Add','ioa');
	$title = __('Add Zip File','ioa');
	
	if( isset($params['button']) && trim($params['button']) != ""  )  $label = $params['button'];
	if( isset($params['title']) && trim($params['title']) != ""  )  $title = $params['title'];	

	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = $params['value'];
	else
		$value = $params['default'];

	$str = " <div class='image_upload_wrap clearfix'>
				<div class='clearfix'><a href='' data-title='$title' data-label='$label' class='zip_upload button-default'> ".__('Upload','ioa')." </a> <input type='text' class='".$params['name']."'  data-default='".$params['default']."' value='".$value."' name='".$params['name']."' id='".$params['name']."' /></div>"; 
	$str .= "</div>";

	return $str;
}


/**
 * Function to create Video Fields
 */

function getIOAVideoInput($params)
{
	$value = '';
	$label = __('Add','ioa');
	$title = __('Add Video','ioa');
	
	if( isset($params['button']) && trim($params['button']) != ""  )  $label = $params['button'];
	if( isset($params['title']) && trim($params['title']) != ""  )  $title = $params['title'];	

	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = $params['value'];
	else
		$value = $params['default'];

	$str = " <div class='image_upload_wrap clearfix'>
				<div class='clearfix'><a href='' data-title='$title' data-label='$label' class='video_upload button-default'> ".__('Upload Video','ioa')." </a> <input type='text' class='".$params['name']."'  data-default='".$params['default']."' value='".$value."' name='".$params['name']."' id='".$params['name']."' /></div>"; 
	$str .= "</div>";

	return $str;
}


/**
 * Function to create Slider Fields
 * @param  max_val maximum value for the slider
 * @param  suffix  the type of slider
 * @param  steps amount of increment on dragging
 */

function getIOASliderInput($params)
{
	$value = '';
	$max_val = 500;
	$suffix = '';
	$steps = 1;
	if(isset($params['max'])) $max_val = $params['max'];
	if(isset($params['steps'])) $steps = $params['steps'];
	if(isset($params['suffix'])) $suffix = $params['suffix'];
	if( isset($params['value']) ) 
		$value = $params['value'];
	else
		$value = $params['default'];

	$def = '0';
	if(isset($params['default'])) $def = $params['default'];


	$str = " <div class='ioa_slider'></div><input  data-default='".$def."' data-max='{$max_val}' data-steps='{$steps}' type='text' class='slider-input' value='".$value."' name='".$params['name']."' id='".$params['name']."' /><h6 class='slider-suffix'>".$suffix."</h6>". "<a class='input-val-delete slider-delete cancel-1icon- ioa-front-icon' href=''></a> ";

	return $str;
}


/**
 * Function to create Colorpicker Fields
 */

function getIOAColorpickerInput($params)
{
	$value = '';
	$opacity = '';
	$hasOpacity = 'false';
	$def = '';
	
	if( isset($params['value']) && trim($params['value']) != ""  ) 
		{
			
			$value = trim($params['value']);
			if(isset($params['default'])) $def = trim($params['default']);
			
		}
	else if(isset($params['default']))
		{
			$def =	$value = trim($params['default']);
		}
	

	$str = "<a class='picker-delete' href=''></a> <div class='colorpicker-wrap'>
				
				<input type='text'  data-default='".$def."'  value='".$value."' name='".$params['name']."' id='".$params['name']."' class='ioa-minicolors ".$params['name']. "' />";
			
	$str .="		 </div> ";

	return $str;
}

/**
 * Function to create Text Area
 */
function getIOATextAreaInput($params)
{
	$value = '';

	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = $params['value'];
	else
		$value = $params['default'];

	$value = stripslashes($value);

	if(isset($params['is_editor']) && $params['is_editor'] ) 
	{
		$settings =   array(
			    'wpautop' => false, // use wpautop?
			    'media_buttons' => true, // show insert/upload button(s)
			   'textarea_name' =>  $params['name'], // set the textarea name to something different, square brackets [] can be used here
			    'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
			    'textarea_columns' => 4,
			    'tinymce' => array(
			    	'convert_newlines_to_brs' => true,
			        'theme_advanced_buttons1' => 'bold,italic,underline,blockquote,|,bullist ,numlist  , link,unlink, ioabutton',
			        'theme_advanced_buttons2' => '',
			        'theme_advanced_buttons3' => '',
			        'theme_advanced_buttons4' => '',
			          'content_css' => get_stylesheet_directory_uri() . '/sprites/stylesheets/custom-editor-style.css' 
			    ),
			    'tabindex' => '',
			    'editor_class' => $params['name']." rad-editor", // add extra class(es) to the editor textarea
			    'teeny' => false, // output the minimal editor config used in Press This
			    'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
			    
			    'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
			);	
		
		ob_start();
		
		wp_editor( $value, $params['name'], $settings);
		$str = ob_get_contents();
		ob_end_clean();
	}
	else
	{
		$name = "name='".$params['name']."'";
		if(isset($params['noname'])) $name = '';
		
		$str = " <textarea  data-default='".$params['default']."' $name id='".$params['name']."'  class='".$params['name']."'>".$value."</textarea>";
	}
	return $str;
}

/**
 * Function to create Select Dropdown
 */
function getIOASelectInput($params)
{
	$value = '';
	$def = '';

	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = $params['value'];
	else
		$value = $params['default'];

	if(  isset($params['default'])) $def = $params['default'];

	$opts ='';

	$useKey = true;
	if( ! isAssoc($params['options']) ) $useKey = false;

	if( isset($params['optgroup']) ) :
		foreach($params['options'] as $key => $optgroup)
		{
			$opts .= "<optgroup label='$key'>";

			foreach ($optgroup as $k => $option) {
				
				$v = $option;
				if($useKey) $v = $k;

				if($value == $v)
				$opts .= "<option selected='selected' value='".$v."'> ".$option."</option>";
				else	
				$opts .= "<option value='".$v."'> ".$option."</option>";

			}

			$opts .= "</optgroup>";

		}

	else : 

	foreach($params['options'] as $key => $option)
	{
		$v = $option;
		if($useKey) $v = $key;

		if($value == $v)
		$opts .= "<option selected='selected' value='".$v."'> ".$option."</option>";
		else	
		$opts .= "<option value='".$v."'> ".$option."</option>";
	}
	endif;

	$str = " <div class='ioa_select_wrap'><select  data-default='".$def."' name='".$params['name']."' id='".$params['name']."' class='".$params['name']."'>".$opts."</select></div>";

	return $str;
}

/**
 * Function to create Checkboxes
 */
function getIOACheckboxInput($params)
{
	$value = array();
	
	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = explode(",",$params['value']);
	else
		{
			if(!is_array($params['default']))
				$value = explode(",",$params['default']);
			else 
				$value = $params['default'];
		}

	$opts ='';
	$i=0;	

	$useKey = true;
	if( ! isAssoc($params['options']) ) $useKey = false;

	foreach($params['options'] as $key => $option)
	{
		$v = $option;
		if($useKey) $v = $key;
		
		if( in_array($v,$value))
		$opts .= "<div class='groud-check-wrap clearfix'><input type='checkbox' name='".$params['name']."' id='".$params['name'].$i."' checked='checked' value='".$v."' /><label for='".$params['name'].$i."'> ".$option."</label></div>";
		else	
		$opts .= "<div class='groud-check-wrap clearfix'><input type='checkbox' name='".$params['name']."' id='".$params['name'].$i."' value='".$v."' /><label for='".$params['name'].$i."'> ".$option."</label></div>";
		$i++;
	}

	$str = " <div class='ioa_checkbox_wrap'> ".$opts." </div>";

	return $str;
}


/**
 * Function to create Radio
 */
function getIOARadioInput($params)
{
	$value = array();
	
	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = explode(",",$params['value']);
	else
		$value = explode(",",$params['default']);

	$opts ='';
	$i=0;	

	$useKey = true;
	if( ! isAssoc($params['options']) ) $useKey = false;

	foreach($params['options'] as $key => $option)
	{
		$v = $option;
		if($useKey) $v = $key;

		if( in_array($v,$value))
		$opts .= "<input type='radio' name='".$params['name']."' id='".$params['name'].$i."' checked='checked' value='".$v."' /><label for='".$params['name'].$i."'> ".$option."</label>";
		else	
		$opts .= "<input type='radio' name='".$params['name']."' id='".$params['name'].$i."' value='".$v."' /><label for='".$params['name'].$i."'> ".$option."</label>";
		$i++;
	}

	$str = " <div class='ioa_radio_wrap'> ".$opts." </div>";

	return $str;
}

/**
 * Function to create Toggles
 */
function getIOAToggleInput($params)
{
	$value = array();
	$option = array("true" => __("Yes",'ioa'),"false" => __("No",'ioa'));
	if( isset($params['value']) && trim($params['value']) != ""  ) 
		$value = explode(",",$params['value']);
	else
		$value = explode(",",$params['default']);

	$opts ='';
	$i=0;	
	foreach($option as $key => $option)
	{
		if( in_array($key,$value))
		$opts .= "<input type='radio' name='".$params['name']."' id='".$params['name'].$i."' checked='checked' value='".$key."' /><label for='".$params['name'].$i."'> ".$option."</label>";
		else	
		$opts .= "<input type='radio' name='".$params['name']."' id='".$params['name'].$i."' value='".$key."' /><label for='".$params['name'].$i."'> ".$option."</label>";
		$i++;
	}

	$str = " <div class='ioatoggle_wrap clearfix'> ".$opts." </div>";

	return $str;
}


/**
 * Create Helper Tooltip
 */

function getIOATooltip($description)
{
	if($description=="") return '';

	$str = "<div class='ioa-desc-tooltip'><span class='ioa-front-icon help-2icon-'></span> <div>".$description."</div></div>";
	return $str;		
}

function isAssoc($arr)
{
		return array_keys($arr) !== range(0, count($arr) - 1);
} 

	