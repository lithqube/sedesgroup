

<?php

global $ioa_meta_data,$super_options,$post,$portfolio_taxonomy,$ioa_portfolio_slug;

$ioa_meta_data['layout'] = "full";
$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if(isset( $ioa_options['ioa_gallery_data'] )) $gallery_images =  $ioa_options['ioa_gallery_data'];

?>   



<div class="page-wrapper <?php echo $post->post_type ?>"  itemscope itemtype='http://schema.org/WebPage'>

	<?php  if(isset($gallery_images) && trim($gallery_images) != "" && count($gallery_images) > 0  ) :  ?>

		<div class="single-full-screen-view-pane full-stretch" data-id="<?php echo get_the_ID() ?>">

			<div class="spfs-gallery seleneGallery"  > 

                     <div class="gallery-holder">

					<?php 

					$ar = explode(";",stripslashes($gallery_images));

						

						foreach( $ar as $image) :

							if($image!="") :

								$g_opts = explode("<gl>",$image);



							

						 ?>

						 <div class="gallery-item" data-thumbnail="<?php echo $g_opts[1]; ?>">

                      		<?php echo "<img src='".$g_opts[0]."'/>"; ?> 

                     		 <div class="gallery-desc">

                         	 	<h4><?php echo $g_opts[3] ?></h4>

                         	 	<?php if(trim($g_opts[4])!="") echo '<div class="caption">'.$g_opts[4].'</div>'; ?>

                         	 </div>  

                  		 </div>	

					<?php 

						endif;

					endforeach; ?>

				</div></div> 



		

		</div>	

	<?php else : 

	$ioa_meta_data['featured_media_type'] = 'image-full';

	$ioa_meta_data['adaptive_height'] = 'true';

	 get_template_part('templates/content-featured-media');



	 endif; ?>


	<div class="skeleton clearfix auto_align">
	<div class="mutual-content-wrap <?php if($ioa_meta_data['layout']!="full" && $ioa_meta_data['layout']!="below-title" && $ioa_meta_data['layout']!="above-footer")  echo 'has-sidebar sidebar-layout  has-'.$ioa_meta_data['layout']; ?>">


			<?php  if(have_posts()): while(have_posts()) : the_post(); ?>

				<div class="single-portfolio-content page-content">
					<?php get_template_part( 'templates/single-portfolio-meta'); ?>
					<?php get_template_part( 'templates/content', get_post_format() ); ?>
				</div>

			<?php endwhile; endif; ?>
			
			<?php if( $super_options[SN.'_single_portfolio_nav']!="false" ) : ?>
			<div class="portfolio-navigation clearfix"  itemscope itemtype='http://schema.org/SiteNavigationElement'>
				<?php wp_reset_query(); next_post_link('<span class="next" itemprop="url"> %link &rarr; </span>'); ?>
				<?php previous_post_link('<span class="previous" itemprop="url"> &larr; %link </span>'); ?>  

			</div>

			<?php endif; ?>

			<?php get_template_part('templates/single-related-portfolio'); ?>

		</div>
	</div>
</div>

