<?php 
/**
 * Featured Media for Posts
 */
global $helper, $super_options , $ioa_meta_data ,$post; 

$ioa_options =  array();

if( isset($post) )
{
	$post_ID = get_the_ID();
$merger ='';
$ioa_options = get_post_meta( $post_ID, 'ioa_options', true ); 


if($ioa_options =="")
{
	$old_values  = get_post_custom($post_ID);
	$ioa_options = array();
	foreach ($old_values as $key => $value) {
		if($key!='rad_data' && $key!='rad_styler')
		{
			$ioa_options[$key] = $value[0];
		}
	}
}  

}


if( IOA_WOO_EXISTS && is_woocommerce() )
{
	if( is_shop() ) 
	{
		$post_ID = $ioa_meta_data['woo_id'];
		$ioa_options = get_post_meta($ioa_meta_data['woo_id'], 'ioa_options', true ); 
		
	}

}



if(isset($ioa_options['show_title']) && $ioa_options['show_title'] == 'no') 
$merger = 'merge-trans';	

$fl = get_post_meta($post_ID,'featured_link',true);

if($fl!="") echo '<a href="'.$fl.'">';
if(function_exists('rev_slider_shortcode') && $ioa_meta_data['layered_media_type']!="none"  && $ioa_meta_data['layered_media_type']!="")
	{
		?> <div class='top-layered-slider <?php echo $merger ?>'> <?php
		putRevSlider($ioa_meta_data['layered_media_type']);
		?> </div> <?php 	
		 return;
	}


if(function_exists('lsSliders') && $ioa_meta_data['klayered_media_type']!="none"  && $ioa_meta_data['klayered_media_type']!="")
	{
		?> <div class='top-layered-slider <?php echo $merger ?>'> <?php
		echo do_shortcode('[layerslider id="'.$ioa_meta_data['klayered_media_type'].'"]');
		?> </div> <?php 	
		 return;
	}


 switch($ioa_meta_data['featured_media_type'])
		    {
		    	
		    	case 'image' : ?> 
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) : ?>
							
							<div class="single-image clearfix">
								<?php

								$id = get_post_thumbnail_id();
							    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );

								echo $helper->imageDisplay( array( "src"=> $ar[0] ,"height" =>  $ioa_meta_data['height'] , "width" =>  $ioa_meta_data['width'] , "parent_wrap" => false ) );   
							 	?> 
							</div>
					 		
						<?php  endif;  ?>		
		


		    	<?php break;

		    	case 'image-full' : 
		    	   if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) :
		    	   	$pr ='';
		    		if($ioa_meta_data['adaptive_height']=='true') 
		    			{
		    				$ioa_meta_data['height'] = "auto";
		    				$pr ='adaptive_height'; 
		    			}
		    		else $ioa_meta_data['height'] = $ioa_meta_data['height'].'px;';
					$id = get_post_thumbnail_id();
				    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );

				    if($ioa_meta_data['background_image']!="")
				    {
				    	$ioa_meta_data['background_image'] = 'background-image:url('.$ioa_meta_data['background_image'].')';
				    }

		    		echo "<div class='full-width-image-wrap $pr $merger' style='".$ioa_meta_data['background_image'].";max-height:".$ioa_meta_data['height']."'  itemscope itemtype='http://schema.org/ImageObject'><img itemprop='url' src='".$ar[0]."' alt='featured image' /></div>";
		    		endif;
		    	   break;

		    	case 'image-parallex' :  
		    		if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) :
		    		$id = get_post_thumbnail_id();
				    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    		echo "<div class='full-width-image-wrap image-parallex $merger' style='height:".$ioa_meta_data['height']."px;background:url(".$ar[0].") left top no-repeat;background-attachment:fixed;background-size:cover'></div>";
		    		endif;
		    		break;	  
		    	
		    	case 'none-contained' :
		    		if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) :
					$id = get_post_thumbnail_id();
				    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    		echo "<div class='contained-image-wrap' itemscope itemtype='http://schema.org/ImageObject'><img itemprop='image' src='".$ar[0]."' alt='featured image' /></div>";  
		    		endif;
					 break;

				case 'proportional' :	 ?> 
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) : ?>
							
							<div class="single-image clearfix">
								<?php

								$id = get_post_thumbnail_id();
							    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
								echo $helper->imageDisplay( array( "crop" => "wproportional", "src"=> $ar[0] ,"height" =>  $ioa_meta_data['height'] , "width" =>  $ioa_meta_data['width'] , "parent_wrap" => false ) );   
							 	?> 
							</div>
					 		
						<?php  endif;  		
		 
						break;
		    	case  "none-full" : 
					
		    	    if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) :
					$id = get_post_thumbnail_id();
				    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    		echo "<div class='top-image-wrap $merger' style='background-image:url(".$ioa_meta_data['background_image'].");' itemscope itemtype='http://schema.org/ImageObject'><img itemprop='image' src='".$ar[0]."' alt='featured image' /></div>";  
					endif;	
					 break;

				case  "slideshow" : ?> <div class="featured-gallery"> <?php  get_template_part("templates/post-featured-gallery"); ?> </div> <?php break;
				case  "slideshow-contained" : ?> <div class="featured-gallery featured-gallery-contained"> <?php $ioa_meta_data['width'] = 1060;  get_template_part("templates/post-featured-gallery"); ?> </div> <?php break;

				case  "slider" : ?> <div class="featured-slider"> <?php  get_template_part("templates/post-featured-slider"); ?> </div> <?php break;
				case  "slider-contained" : ?> <div class="featured-slider featured-slider-contained"> <?php $ioa_meta_data['width'] = 1060;  get_template_part("templates/post-featured-slider"); ?> </div> <?php break;
				case  "slider-full" : ?> <div class="featured-slider featured-slider-full <?php echo $merger ?>"  style='background-image:url(<?php echo $ioa_meta_data['background_image'] ?>);'> <?php $ioa_meta_data['full_width'] = true;  get_template_part("templates/post-featured-slider"); ?> </div> <?php break;


				case  "video" : ?>
					  <div class="video">
                                   <?php $video =   $ioa_meta_data['featured_video'];  

                                   echo fixwmode_omembed(wp_oembed_get(trim($video),array( "width" => $ioa_meta_data['width'] , 'height' => $ioa_meta_data['height']) ) ); ?>
                               </div>  
					 <?php break;	 

		    
		    }
		    

if($fl!="") echo '</a>';

?>
