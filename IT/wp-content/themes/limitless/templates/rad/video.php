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
$rad_attrs[] = 'class=" video-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';

$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';
 ?>


<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="video-inner-wrap" >
		
		<div class="text-title-wrap"   itemscope itemtype="http://schema.org/Thing">
				<h2 itemprop="name" class="text_title custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
					<div class="ioa-video">	
						<?php 
						echo str_replace("webkitallowfullscreen mozallowfullscreen","",do_shortcode("[video width='".$w["width"]."' height='".$w["height"]."']".$w['v_id']."[/video]") );
					 	?>
				<?php if(isset($w['text_caption']) ) : ?><h4  class=" text_caption custom-font1"><?php echo $helper->format($w['text_caption'],true,false,false); ?></h4><?php endif; ?>
			</div>
			
		</div>
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>