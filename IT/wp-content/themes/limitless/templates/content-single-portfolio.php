<?php

/**
 * Single Portfolio 
 */

global $ioa_meta_data,$super_options,$post,$portfolio_taxonomy,$ioa_portfolio_slug;



/**
 * Single Portfolio Template
 */

switch ($ioa_meta_data['ioa_custom_template']) {

	case 'full-screen': get_template_part('templates/content-single-portfolio-full-screen'); break;

	case 'full-screen-porportional': get_template_part('templates/content-single-portfolio-prop-screen'); break;

	case 'model': get_template_part('templates/content-single-portfolio-model'); break;

	case 'side': get_template_part('templates/content-single-portfolio-side'); break;

	case 'default' :

	default:

		



?>   



 <?php  

	 	switch($ioa_meta_data['featured_media_type'])

	 	{

	 		case "slider-full" :
	 		case "slider-contained" :
	 		case "slideshow-contained" :
	 		case "none-full" :
	 		case 'image-parallex' : 
	 		case 'image-full' : get_template_part('templates/content-featured-media'); break;

	 	}



	?>



<div class="page-wrapper <?php echo $post->post_type ?>"  itemscope itemtype='http://schema.org/WebPage'>
	<div class="<?php if($ioa_meta_data['layout']!="full") echo 'skeleton'; ?> clearfix auto_align">
		<div class="mutual-content-wrap <?php if($ioa_meta_data['layout']!="full" && $ioa_meta_data['layout']!="below-title" && $ioa_meta_data['layout']!="above-footer") echo 'has-sidebar sidebar-layout  has-'.$ioa_meta_data['layout']; ?>">

  

			<?php  if(have_posts()): while(have_posts()) : the_post(); ?>
       <?php  

			 	switch($ioa_meta_data['featured_media_type'])
			 	{

			 		case 'slider' :
			 		case 'slideshow' :
			 		case 'video' :
			 		case 'proportional' :
			 		case 'none-contained' :
			 		case 'image' : get_template_part('templates/content-featured-media'); break;

			 	}

		?>
				<div class="single-portfolio-content <?php if($ioa_meta_data['layout']=="full") echo 'skeleton' ?> clearfix auto_align">

					<?php $ioa_meta_data['rad_trigger'] = true; the_content(); ?>

				</div>

			<?php endwhile; endif; ?>

			<?php if( $super_options[SN.'_single_portfolio_nav']!="false" ) : ?>

			<div class="portfolio-navigation clearfix auto_align <?php if($ioa_meta_data['layout']=="full") echo 'skeleton'; ?>"  itemscope itemtype='http://schema.org/SiteNavigationElement'>
				<?php wp_reset_query(); next_post_link('<span class="next" itemprop="url"> %link &rarr; </span>'); ?>
				<?php previous_post_link('<span class="previous" itemprop="url"> &larr; %link </span>'); ?>  

			</div>

			<?php endif; ?>
				
			<div class="clearfix auto_align <?php if($ioa_meta_data['layout']=="full") echo 'skeleton'; ?>"  itemscope itemtype='http://schema.org/SiteNavigationElement'>
				<?php get_template_part('templates/single-related-portfolio'); ?>
			</div>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>
      <?php
		break;

}

?>