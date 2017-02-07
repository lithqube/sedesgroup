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
$rad_attrs[] = 'class=" clearfix page-rad-component rad-component-spacing  '.$way.'"';

$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';

?> 


<div <?php echo join(" ",$rad_attrs) ?>>
	
	
	<div class="text-inner-wrap <?php echo $inner_wrap_classes; ?>  "  style='<?php if(isset($w['col_alignment'])) echo "text-align:".$w['col_alignment'] ?>' >
		
		<div class="text-title-wrap clearfix"   itemscope itemtype="http://schema.org/Thing">
			
			<?php  if(isset($w['icon']) && $w['icon']!="") :  ?>
			<div style="margin-top:<?php if(isset($w['icon_margin'])) echo $w['icon_margin']."px" ?>"   class="icon  <?php echo "float-".$w['icon_alignment']." "; ?> " >
					<?php echo stripslashes($w['icon']); ?>
			</div>
			<?php endif; ?>
			
			<div class="text-title-inner-wrap">
				<?php if(isset($w['text_title']) && $w['text_title']!="") : ?><h2 itemprop="name" class="text_title custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2><?php endif; ?>
				<?php if(isset($w['text_subtitle'])  && $w['text_subtitle']!="") : ?><h4  class=" text_subtitle  custom-font1"><?php echo $helper->format($w['text_subtitle'],true,false,false); ?></h4><?php endif; ?>
			</div>	
			
		</div>
		
		<div itemprop="description" class="text text_data ">
			<?php echo stripslashes(do_shortcode($w['text_data'])); ?>
		</div>
	</div>
	

</div>

