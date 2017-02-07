<?php 
$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];

require_once( $wp_url.'/wp-load.php' );
require_once(HPATH.'/classes/ui.php');

global $google_webfonts;




global $fonts;

$f = $fonts->getFonts();
?>

<div class="preview-font">
  <iframe id="gfont-frame" src="<?php echo HURL; ?>/adv_mods/gfont_input.php?font=" width="100%" height="130">
 
  </iframe>
 </div>

<div class="font_listener">
<?php
foreach($f as $font)
{
	$val = $font['default_font'];

	if( isset($super_options[SN.$font['default_class']] ) ) $val = $super_options[SN.$font['default_class']] ;
	
	
	echo getIOAInput( 
															array( 
																	"label" => $font['label'] , 
																	"name" => SN.$font['default_class'], 
																	"default" => SN.$font['default_font'], 
																	"type" => "select",
																	"description" => "",
																	"options" => $google_webfonts  ,
																	"value" =>  $val 
															) 
														);

	if( isset($font['fontWeight']) &&  $font['fontWeight'] )
	{
		$w = '';
		if(isset($super_options[SN.$font['default_class'].'_w'])) $w = $super_options[SN.$font['default_class'].'_w'];
		echo getIOAInput( 
															array( 
																	"label" => str_replace('Font','Font Weight values separated by comma(ex 100,200)',$font['label']) , 
																	"name" => SN.$font['default_class'].'_w', 
																	"default" => '', 
																	"type" => "text",
																	"description" => "" ,
																	"value" => $w 
															) 
														);
	}

	if( isset($font['subset']) &&  $font['subset'] )
	{
		$s = '';
		if(isset($super_options[SN.$font['default_class'].'_s'])) $s = $super_options[SN.$font['default_class'].'_s'];
		echo getIOAInput( 
															array( 
																	"label" => str_replace('Font','Font Subsets separated by comma(ex latin,greek-ext,greek,vietnamese,latin-ext,cyrillic)',$font['label']) , 
																	"name" => SN.$font['default_class'].'_s', 
																	"default" => '', 
																	"type" => "text",
																	"description" => "" ,
																	"value" => $s 
															) 
														);
	}

}


?>
</div>


