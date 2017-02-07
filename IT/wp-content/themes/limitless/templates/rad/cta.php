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
$rad_attrs[] = 'class=" cta-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';
 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div  itemscope itemtype="http://schema.org/Thing" class="cta-inner-wrap clearfix  <?php if(isset($w['button_alignment'])) echo "cta-".$w['button_alignment'];  ?>" style='<?php if(isset($w['col_alignment'])) echo "text-align:".$w['col_alignment'] ?>'>
		
		<div class="text-title-wrap" style="">
			
			<div class="text-title-inner-wrap" >
				<h2 itemprop="name" class="text_title custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
			</div>	
			
		</div>
		
		<div class="button-area">
			<a class='cta_button' itemprop="url" <?php if(isset($w['button_animation']) && trim($w['button_animation'])!= "") echo 'data-icon_hover="animated '.$w['button_animation'].'"'; ?> href="<?php if(isset($w['button_link']) && $w['button_link']!="") echo $w['button_link'] ?>"> <?php if(isset($w['cta_button']) && $w['cta_button']!="") echo stripslashes($w['cta_button']) ?></a>
		</div>
		
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>