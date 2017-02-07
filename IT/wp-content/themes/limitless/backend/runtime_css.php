<?php 
/**
 * Creates a runtime css file for Enigma Styler, if folder is not writable it prints inline css.
 * @version 1.0
 */

if(!class_exists('EnigmaDynamic'))
{
	class EnigmaDynamic
	{
		private $dynamic_status = 'inline';
		private $filename = 'runtime.css';

		/**
		 * By Default Set Ouput to Inline
		 */	
		function __construct()
		{	
			$flag = get_option(SN.'_dynamic_css_status');
			if($flag) $this->dynamic_status = $flag;
		}

		/**
		 * Get Runtime Mode - inline / file
		 */

		function runtimeMode()
		{
			$upload_dir = wp_upload_dir();
			if(!file_exists($upload_dir['path'].'/'.$this->filename))
			{
				$this->dynamic_status = 'inline';
				update_option(SN.'_dynamic_css_status',$this->dynamic_status);
			}

			return $this->dynamic_status;
		}

		/**
		 * Runtime File name
		 */
		function getFileName()
		{
			$upload_dir = wp_upload_dir();
			return  $upload_dir['url'].'/'.$this->filename;
		}

		/**
		 * This function creates the file
		 */
		function createCSSFile()
		{
			$upload_dir = wp_upload_dir();

			$cssFile = $upload_dir['path'].'/'.$this->filename;
			$flag = 'inline';
			$fh = fopen($cssFile, 'w');

			if( is_writable($cssFile) )
			{
				
				$code = $this->getRuntimeCode();
				fwrite($fh, $code);
				
				$flag = 'file';
			}

			fclose($fh);
			
			update_option(SN.'_dynamic_css_status',$flag);
			update_option(SN.'_compiled_css',$code);

		}

		/**
		 * This Function Generates CSS Code
		 */

		function getRuntimeCode(){
		
		$data = array();

			$template = get_option(SN.'_active_etemplate');
			if(!$template)
			{
				$data =get_option(SN.'_enigma_data');
			}
			else
			{
				if($template=="default")
					$data =get_option(SN.'_enigma_data');
				else
					$data =get_option($template);

			}

			$styles = '';

			if(!$data) $data = array();

			if(is_array($data))
			foreach ($data as $key => $code) {

				if(isset($code['value']) && isset($code['name']))
				{
					switch($code['name'])
					{
						case "background-image" : $styles .= $code['target']."{ ".$code['name']." : url(".$code['value']."); } "; break;
						case "font-family" : $styles .= $code['target']."{ ".$code['name']." : '".$code['value']."','Helvetica','Arial'; } "; break;
						default : $styles .= $code['target']."{ ".$code['name']." : ".$code['value']."; } "; break;
					}

				}
			}	


		return $styles;
		}	  


	}
}

$enigma_runtime = new EnigmaDynamic();

//$enigma_runtime->createCSSFile();


 ?>