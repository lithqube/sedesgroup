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
$rad_attrs[] = 'class=" intro_title-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';

$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';
 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="intro_title-inner-wrap" style='<?php if(isset($w['col_alignment'])) echo "text-align:".$w['col_alignment'] ?>'>
		
	
			
			<div class="intro_title-title-inner-wrap"  itemscope itemtype="http://schema.org/Thing">
				<?php if(isset($w['text_subtitle']) && $w['text_subtitle']!="") : ?><h4 itemprop="name" class=" text_subtitle  custom-font1"><?php echo $helper->format($w['text_subtitle'],true,false,false); ?></h4><?php endif; ?>
				<?php if(isset($w['text_title']) && $w['text_title']!="" ) : ?><h2 itemprop="description" class="text_title  custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2><?php endif; ?>
			</div>	

			<?php if(isset($w['show_bottom_line']) && $w['show_bottom_line']!="no" ) : ?>
				<span class="spacer sp-align-<?php echo $w['col_alignment']; ?> <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'way-animated'; ?>" <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'data-waycheck="'.$w['visibility'].'"'; ?> ></span>
			<?php endif; ?>
		
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>