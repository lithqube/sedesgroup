

<?php

global $ioa_meta_data,$super_options,$post,$portfolio_taxonomy,$ioa_portfolio_slug;



$ioa_meta_data['layout'] = "full";

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );



if($ioa_options =="")

{

	$old_values  = get_post_custom(get_the_ID());

	$ioa_options = array();

	foreach ($old_values as $key => $value) {

		if($key!='rad_data' && $key!='rad_styler')

		{

			$ioa_options[$key] = $value[0];

		}

	}

}  





if(isset( $ioa_options['ioa_gallery_data'] )) $gallery_images =  $ioa_options['ioa_gallery_data'];

?>   







<div class="page-wrapper <?php echo $post->post_type ?>"  itemscope itemtype='http://schema.org/WebPage'>

	



	<?php  if(isset($gallery_images) && trim($gallery_images) != "" && count($gallery_images) > 0  ) :  ?>



		<div class="single-prop-screen-view-pane full-stretch" data-id="<?php echo get_the_ID() ?>">



		

		</div>	

         

	<?php else : 

		$ioa_meta_data['featured_media_type'] = 'image';

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



