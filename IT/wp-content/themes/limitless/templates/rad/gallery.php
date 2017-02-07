<?php 
/**
 * gallery Template for RAD BUILDER
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

	<div class="gallery-inner-wrap inner-common <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'way-animated'; ?>"  <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'data-waycheck="'.$w['visibility'].'"'; ?>>
		
		<?php if(isset($w['text_title'])) : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="text_title custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
	
		
		<div class="gallery-data "  itemscope itemtype="http://schema.org/ImageGallery" >

			<div class="ioa-gallery seleneGallery " data-effect_type="fade" data-thumbnails="<?php echo $w['bullets'] ?>" data-autoplay="<?php echo $w['autoplay'] ?>" data-caption="<?php echo $w['captions'] ?>" data-arrow_control="<?php echo $w['arrow_control'] ?>" data-duration="<?php echo $w['duration'] ?>" data-height="<?php if(isset($w['height'])) echo $w['height']; else '300'; ?>"  data-width="<?php if(isset($w['width'])) echo $w['width']; else '450'; ?>" > 
                <div class="gallery-holder">
					<?php if(isset($w['gallery_images']) && trim($w['gallery_images']) != "" ) :
					$w['gallery_images'] = str_replace('<<','[ioas]', $w['gallery_images']);
					 $ar = explode(";",stripslashes($w['gallery_images']));
						

						
						foreach( $ar as $image) :
							if($image!="") :

								$g_opts = explode("[ioas]",$image);
                           

                            if($g_opts[0]!='' && strpos($g_opts[0],'.')!==false) :
						 ?>
						 <div class="gallery-item" data-thumbnail="<?php echo $g_opts[1]; ?>"><a href="<?php echo $g_opts[0] ?>" rel="prettyphoto['<?php echo $ioa_meta_data['widget']['id'] ?>']" class='lightbox'>
                      		<?php echo $helper->imageDisplay(array( "src" =>$g_opts[0] , 'imageAttr' =>  $g_opts[2], "parent_wrap" => false , "width" => $w['width'] , "height" => $w['height'] )); ?> 
                     		 <div class="gallery-desc">
                         	 	<h2 itemprop="name"><?php echo $g_opts[3] ?></h2>
                         	 	<div class="caption" itemprop="description"><?php echo $g_opts[4] ?></div>
                         	 </div>  
                         	 	</a>
                  		 </div>	
					<?php endif;
						endif;
					endforeach; endif; ?>
				</div>
			</div>

		</div>	
		
	</div>
</div>

