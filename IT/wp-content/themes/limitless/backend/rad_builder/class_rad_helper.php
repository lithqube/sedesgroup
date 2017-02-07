<?php
/**
 * RAD Helper Functions
 */

// Converst an array with pairs into assoctive array

function radAssocMap($inputs,$key,$noempty=false)
 {
 	$arr = array();
 	if(is_array($inputs))
 	{
 		foreach($inputs as $input)
		{
			if(isset( $input[$key]))
				{
					if( $noempty)
						{
							if(trim( $input[$key])!="")
							$arr[$input['name']] =   stripslashes($input[$key]);
						}
					else
					{
						if(isset($input['name'])) $arr[$input['name']] =    stripslashes($input[$key]);
					}	
				}
			else
				$arr[$input['name']] =   false;	
		}
 	}
	return $arr;	
 }	



function radexport_session()
		{
  		  
  		  if(isset($_GET['rad_export']))
  		  {

				$data = get_transient('TEMP_RAD_TEMPLATE');

				$name = get_transient('TEMP_RAD_TEMPLATE_TITLE');

				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($name.'.txt'));
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');

				
				$output = base64_encode($data);
				echo $output;

				die();	
  		  }
		  
		}

		if(is_admin())
		add_action('init', 'radexport_session', 1);

