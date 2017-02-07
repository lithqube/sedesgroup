<?php 
/**
 * Text Template for RAD BUILDER
 */

global $helper, $super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];



$inner_wrap_classes = '';
$rad_attrs = array();

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none")  $rad_attrs[] = 'data-waycheck="'.$w['visibility'].'"';
if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

$way = '';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") $way = 'way-animated';
$rad_attrs[] = 'class=" radial_chart-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';

if(!isset($w['w'])) $w['w'] = '';
if(!isset($w['width'])) $w['width'] =350;
if(!isset($w['label'])) $w['label'] ="Label";

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="radial_chart-inner-wrap" >
		
		<?php if(isset($w['text_title'])) : ?>
		<div class="text-title-wrap">
			
			<div class="text-title-inner-wrap"  itemscope itemtype="http://schema.org/Thing">
				<h2 itemprop='name' class="text_title custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
				<span class="spacer"></span>
			</div>	
			
		</div>
		<?php endif; ?>
			
			<?php echo do_shortcode("[radialchart width='".$w['width']."'  font_size='".$w['font_size']."' line_width='".$w['line_width']."' percent='".$w['value']."' bar_color='".$w['bar_color']."' track_color='".$w['track_color']."'] ".stripslashes($w['label'])."[/radialchart] "); ?>
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>