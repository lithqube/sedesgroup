<?php 
/**
 * Title Template
 */

global $helper, $super_options , $ioa_meta_data, $post ; 

/**
 * Styling Code ===============================
 */

$show_title = $tbgpositionc = $tc = $tc =$tco = $tbc = $stbc  = $tbco = $stc = $stco =$stbco = $ttbc = $ttbgimage = $ta = $ts = $ttbgposition = $ttbgrepeat = $title_font_size = $title_font_weight = $bg_cover = $code = '';
$title_icon = '';
$tbgposition = '';
$ie_tbc= '' ; $ie_stbc = '';
$dbg = '' ;
$ioa_options = array();

if(isset($post))
$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );


if(!isset($ioa_options['override_title_style'])) $ioa_options['override_title_style'] = 'no';
if(isset($ioa_options['show_title'])) $show_title =  $ioa_options['show_title'];

if( (is_page() || is_single()) && $ioa_options['override_title_style'] == 'yes' ) :

if(isset($ioa_options['title_icon'])) $title_icon =  $ioa_options['title_icon'];
if(isset($ioa_options['ioa_titlearea_bgimage'])) $ttbgimage =  $ioa_options['ioa_titlearea_bgimage'];

if(isset($ioa_options['ioa_custom_title_color'])) $tc =  $ioa_options['ioa_custom_title_color'];
if(isset($ioa_options['ioa_custom_title_bgcolor'])) $tbc =  $ioa_options['ioa_custom_title_bgcolor'];
if(isset($ioa_options['ioa_custom_title_bgcolor-opacity'])) $tbco =  $ioa_options['ioa_custom_title_bgcolor-opacity'];
if(isset($ioa_options['ioa_custom_subtitle_color'])) $stc =  $ioa_options['ioa_custom_subtitle_color'];
if(isset($ioa_options['ioa_custom_subtitle_bgcolor'])) $stbc =  $ioa_options['ioa_custom_subtitle_bgcolor'];
if(isset($ioa_options['ioa_custom_subtitle_bgcolor-opacity'])) $stbco =  $ioa_options['ioa_custom_subtitle_bgcolor-opacity'];
if(isset($ioa_options['ioa_titlearea_bgcolor'])) $ttbc =  $ioa_options['ioa_titlearea_bgcolor'];


if(isset($ioa_options['ioa_titlearea_bgimage'])) $tbgimage =  $ioa_options['ioa_titlearea_bgimage'];
if(isset($ioa_options['ioa_titlearea_bgposition'])) $tbgposition =  $ioa_options['ioa_titlearea_bgposition'];
if(isset($ioa_options['ioa_titlearea_bgrepeat'])) $ttbgrepeat =  $ioa_options['ioa_titlearea_bgrepeat'];
if(isset($ioa_options['ioa_titlearea_bgpositionc'])) $tbgpositionc =  $ioa_options['ioa_titlearea_bgpositionc'];


if($ttbgimage!="") $ttbgimage = "url(".$ttbgimage.")";


if( trim($tbgpositionc)!="")
$tbgposition =  $tbgpositionc;

	

$ie_tbc= $tbc ;
$tbc = hex2RGB($tbc);
$tbc = "rgba(".$tbc['red'].",".$tbc['green'].",".$tbc['blue'].",".$tbco.")";

$ie_stbc= $stbc ;

$stbc = hex2RGB($stbc);
$stbc = "rgba(".$stbc['red'].",".$stbc['green'].",".$stbc['blue'].",".$stbco.")";

$use_gr = '';
if(isset($ioa_options['titlearea_gradient'])) $use_gr =  $ioa_options['titlearea_gradient'];

if(isset($ioa_options['title_font_size']) && $ioa_options['title_font_size']!="36" && $ioa_options['title_font_size']!="0") $title_font_size =  'font-size:'.$ioa_options['title_font_size'].'px;';
if(isset($ioa_options['title_font_weight']) && $ioa_options['title_font_size']!="0") $title_font_weight =  'font-weight:'.$ioa_options['title_font_weight'].';';
if(isset($ioa_options['dominant_bg_color'])) $dbg =  $ioa_options['dominant_bg_color'];


$bg_cover ='';
if(isset($ioa_options['background_cover'])) $bg_cover =  $ioa_options['background_cover'];


if(  $bg_cover !== "" )
$bg_cover = "background-size:".$bg_cover.";";

$code ='';



if($use_gr=="yes")
{
	if(isset($ioa_options['ioa_titlearea_grstart'])) $start_gr =  $ioa_options['ioa_titlearea_grstart'];
	if(isset($ioa_options['ioa_titlearea_grend'])) $end_gr =  $ioa_options['ioa_titlearea_grend'];
	if(isset($ioa_options['titlearea_gradient_dir'])) $dir_gr =  $ioa_options['titlearea_gradient_dir'];

	$iefix = 0;
	if( $dir_gr != "radial" ) :

	switch($dir_gr)
	{
		case "vertical" : $dir_gr = "top"; break;
		case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
		case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
		case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
	}	
			
	$code = "background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

	endif;
}
else
{

	
	if($ttbc!="")
	$code .= "background-color:".$ttbc.';';

	if($ttbgimage!="")
	$code .= "background-image:".$ttbgimage.';'.$bg_cover ;

	if($tbgposition!="")
	$code .= "background-position:".$tbgposition.';';

	if($ttbgrepeat!="")
	$code .= "background-repeat:".$ttbgrepeat.';';

}



/**
 * End of Styling Code
 */


/**
 * Title General Settings
 */
$tv = '';
if(isset($ioa_options['title_vspace'])) $tv =  $ioa_options['title_vspace'];
if(isset($ioa_options['title_align'])) $ta =  $ioa_options['title_align'];
$ts = '';



if( $tv !="" && $tv !="0" )
{
	$code .=  "padding:".$tv."px 0;";
}

endif;
?>
<?php 

$background_animate_time = $background_animate_position = $titlearea_effect = $effect_delay = $title_effect = $subtitle_effect =  '';
if(isset($ioa_options['background_animate_time'])) $background_animate_time =  $ioa_options['background_animate_time'];
if(isset($ioa_options['background_animate_position'])) $background_animate_position =  $ioa_options['background_animate_position'];
if(isset($ioa_options['titlearea_effect'])) $titlearea_effect =  $ioa_options['titlearea_effect'];
if(isset($ioa_options['effect_delay'])) $effect_delay =  $ioa_options['effect_delay'];

if(isset($ioa_options['title_effect'])) $title_effect =  $ioa_options['title_effect'];
if(isset($ioa_options['subtitle_effect'])) $subtitle_effect =  $ioa_options['subtitle_effect'];


 ?>
<?php if($show_title !="no" && !is_home() && ! is_404() ) : ?>

	

<div class="supper-title-wrapper" >
	<div data-dbg='<?php echo $dbg; ?>' data-duration="<?php echo $background_animate_time ?>" data-position="<?php echo $background_animate_position ?>" class="title-wrap <?php echo $titlearea_effect ?> <?php echo "title-text-algin-".$ta; ?>" data-effect="<?php echo $titlearea_effect ?>"  style="<?php echo $code;  ?>" data-delay="<?php echo $effect_delay ?>" >
  	<div class="page-highlight"></div>
  	<div class="wrap">
		<?php if(!is_front_page() && $super_options[SN.'_breadcrumbs_enable']!="false" ) $helper->breadcrumbs(); ?>
    	<div class="skeleton auto_align clearfix"> 
        		<div class="title-block <?php echo $title_effect; if($title_effect!="none") echo " animate-block"; ?>" data-effect="<?php echo $title_effect ?>" style='background:<?php echo $ie_tbc; ?>;background:<?php echo $tbc; ?>;'>
        			<h1 class="custom-title " style='<?php if($tc!="")echo 'color:'.$tc.';'; echo $title_font_size; echo $title_font_weight ?>' >  <?php if(isset($title_icon) && $title_icon!="") echo "<i class='icon $title_icon'></i>";   echo $ioa_meta_data['title']; ?></h1>
        		</div>
                <?php if($ioa_meta_data['subtitle']!="") :?>
				<div class="subtitle-block <?php echo $subtitle_effect; if($subtitle_effect!="none") echo " animate-block"; ?>"  data-effect="<?php echo $subtitle_effect ?>" style='background:<?php echo $ie_stbc; ?>;background:<?php echo $stbc; ?>;'>
					<h3 class="page-subtitle" style='color:<?php echo $stc; ?>;'><?php echo $ioa_meta_data['subtitle']; ?></h3>
				</div>	
            	<?php endif; ?>
            	
         </div>
     </div>
	</div>
	
	
</div>



<?php endif; ?>

