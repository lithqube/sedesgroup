<?php
 /**
 * The Template for displaying Single Posts / Single Portfolio / Single Custom Post.
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */

/**
 * Prepare Page Variables before HEADER Template.
 */

$helper->preparePage();

get_header(); 


/**
 * Condition To Check If Single Portfolio is there switch Template.
 * code for Single Portfolio can be found in content-single-portfolio.php
 * in templates folder.
 */


?>   



<div class="page-wrapper <?php echo $post->post_type ?>"> <!-- Parent Wrapper -->
	
	<?php  if(! post_password_required()) : 
		/**
		 * Full Width Featured Media Items will appear here. 
		 * Note the switches are for condition checking on featured media Full or Contained. 
		 */
		if($super_options[SN.'_featured_image']!="false")
	 	switch($ioa_meta_data['featured_media_type'])
	 	{
	 		case "slider-full" :
	 		case "slider-contained" :
	 		case "slideshow-contained" :
	 		case "none-full" :
	 		case 'image-parallex' : 
	 		case 'image-full' : get_template_part('templates/content-featured-media'); break;
	 	}
	 	endif;
	?>

	<div class="skeleton clearfix auto_align">

		
	
		<div class="mutual-content-wrap full">
      
				<div class="skeleton clearfix auto_align">
			<div class="single-image">
			<?php echo wp_get_attachment_image( get_the_ID(), array(1060,450) ); ?>
			</div>
			</div>
			
			<!-- Single Post Content Begins Here -->
			<?php  if(have_posts()): while(have_posts()) : the_post(); ?>
	
				

			
					<div class="clearfix">
						<?php $ioa_meta_data['rad_trigger'] = true; the_content(); ?>
					</div>
		
					
				
	
			<?php endwhile; endif; ?>
	
		</div>


		

	</div>

</div> <!-- .page-wrapper -->

<?php get_footer(); ?>
      