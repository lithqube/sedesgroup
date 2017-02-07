

<?php

global $ioa_meta_data,$super_options,$post,$portfolio_taxonomy,$ioa_portfolio_slug;



$ioa_meta_data['layout'] = "full";



?>   







<div class="page-wrapper  <?php echo $post->post_type ?>"  itemscope itemtype='http://schema.org/WebPage'>

	

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

         



	<div class="skeleton clearfix auto_align">



		



		<div class="mutual-content-wrap <?php if($ioa_meta_data['layout']!="full" && $ioa_meta_data['layout']!="below-title" && $ioa_meta_data['layout']!="above-footer") echo 'has-'.$ioa_meta_data['layout'];  ?>">

         

			

			<div class="clearfix">

				<div class="one_half side-featured-media left">

					 <?php  

					 $ioa_meta_data['width'] = 520;

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

					<?php get_template_part( 'templates/single-portfolio-meta'); ?>

		

				</div>

			<?php  if(have_posts()): while(have_posts()) : the_post(); ?>

	

				<div class="single-portfolio-content page-content side-single-portfolio-content one_half left">

					



					<?php get_template_part( 'templates/content', get_post_format() ); ?>

					

					

				</div>

	

			<?php endwhile; endif; ?>



			</div>

				

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



