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



if($post->post_type==strtolower($ioa_portfolio_slug)) :
	 get_template_part('templates/content-single-portfolio');
else :

?>   

<div class="page-wrapper <?php echo $post->post_type ?>"> <!-- Parent Wrapper -->
	<?php 
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
	 	
	 ?>
		
	<?php  if(! post_password_required()) : 
		

	?>
	<div class="<?php if($ioa_meta_data['layout']!="full") echo 'skeleton'; ?> clearfix auto_align">
		<div class="mutual-content-wrap  dsf<?php if($ioa_meta_data['layout']!="full" && $ioa_meta_data['layout']!="below-title" && $ioa_meta_data['layout']!="above-footer") echo 'has-sidebar sidebar-layout has-'.$ioa_meta_data['layout'];  ?>">

			<?php  
				/**
				 * Featured Media Items contained by parent width will appear here. 
				 */

			if($super_options[SN.'_featured_image']!="false")
			 	switch($ioa_meta_data['featured_media_type'])
			 	{
			 		case 'slider' :
			 		case 'slideshow' :
			 		case 'video' :
			 		case 'proportional' :
			 		case 'none-contained' :
			 		case 'image' :
			 		case '' : get_template_part('templates/content-featured-media'); break;

			 	}

			?>

			<!-- Single Post Content Begins Here -->
				<div class="<?php if($ioa_meta_data['layout']=="full") echo 'skeleton' ?> clearfix auto_align">

				
					<?php if($super_options[SN."_social_share"]!="false") : ?>
					<div class="meta-info clearfix">
						<div class="clearfix inner-meta-info">
							<?php echo do_shortcode($super_options[SN.'_single_meta']); ?>
						</div>
						<?php
								$id = get_post_thumbnail_id(get_the_ID());
                   				$thumb = wp_get_attachment_image_src($id,'medium'); 
						  ?>

						<div class="social clearfix">

							<a href="https://twitter.com/share/?url=<?php echo urlencode(get_permalink());  ?>&amp;text=<?php echo $helper->getShortenContent(100,get_the_title()) ?>" target="_BLANK" class='twitter-1icon- twitter-icon ioa-front-icon'></a>

							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink());  ?>" target="_BLANK" class='ioa-front-icon facebook-1icon- facebook-icon'></a>

							<a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink());  ?>" target="_BLANK" class='ioa-front-icon gplus-1icon- google-plus-icon'></a>

							<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink());  ?>&amp;media=<?php echo urlencode($thumb[0]); ?>&amp;description=<?php echo $helper->getShortenContent(100,get_the_excerpt()) ?>" target="_BLANK" class=' pinterest-1icon- ioa-front-icon pinterest-icon'></a>

						</div>

					</div><?php endif ?>
				</div>

				<?php  if(have_posts()): while(have_posts()) : the_post(); ?>
			
					<div class="clearfix <?php if($post->post_type!='post') echo 'skeleton auto_align page-content' ?>">
						<?php if($post->post_type=='post')$ioa_meta_data['rad_trigger'] = true; the_content(); ?>
					</div>
					<div class="<?php if($ioa_meta_data['layout']=="full") echo 'skeleton' ?> clearfix auto_align">
						<?php wp_link_pages(); ?>
					</div>
		
			<?php endwhile; endif; ?>

			<div class="<?php if($ioa_meta_data['layout']=="full") echo 'skeleton'; ?> clearfix auto_align">


			<?php  $posttags = get_the_tags($post->ID);

			  if (isset($posttags) && !is_singular() ) { ?>
			<div class="post-tags clearfix">
				<?php echo do_shortcode('[post_tags sep="" icon="" /]'); ?>
			</div>
			<?php } ?>

			<?php if($super_options[SN."_author_bio"]!="false") : ?>
		    <div id="authorbox" class="clearfix " >  

		    </div>
		<?php endif; ?>
			<?php if($super_options[SN."_popular"]!="false")  get_template_part('templates/single-related-posts'); ?>

			<?php if($super_options[SN."_fb_comments"]!="false") : ?>
				<div class="fb_comments_template">
					<div id="fb-root"></div>
					<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=165111413574616";
					fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>

					<div class="fb-comments" data-href="<?php the_permalink();?>" data-num-posts="2" data-width="740" data-height="120" ></div>

				</div>
			<?php endif; ?>
			
			</div>
		</div>
		<?php get_sidebar(); ?>

<?php endif; ?>
</div>


</div> <!-- .page-wrapper -->

<?php endif; ?>



<?php get_footer(); ?>

      