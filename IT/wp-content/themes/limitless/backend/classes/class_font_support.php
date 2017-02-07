<?php 
/**
 * Core Class to enable hooks and actions for Fonts
 * @version 1.0
 */

if(!class_exists('IOAFont'))
{
	class IOAFont
	{
		private $fonts;

		function __construct()
		{	
			$fonts =  array( );

		}

		/**
		 * Retrives all registered fonts.
		 */
		public function getFonts()
		{
			return $this->fonts;
		}

		public function setFont($font,$key)
		{
			global $super_options;
			
			$this->fonts[$key] = $font;
			if(!isset($super_options[SN.$key])) $super_options[SN.$key] = $font['default_font'];
		}

	}
}

$fonts = new IOAFont();

function register_font_class($default='',$defined='',$default_font,$label,$addWeight,$subset)
{
	global $fonts;
	$fonts->setFont(array(
						'default_class' => $default ,
						'defined_class' => $defined ,
						'default_font'  => $default_font,
						'label' => $label,
						'fontWeight' => $addWeight,
						'subset' => $subset

							),trim(str_replace(' ','',$default)));

}


 ?>