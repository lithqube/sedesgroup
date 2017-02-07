<?php
global $helper, $ioa_meta_data,$post,$super_options,$portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['width'] = 800;
$ioa_meta_data['height'] = 470;
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
<div class="page-wrapper portfolio-template portfolio-maerya <?php echo $post->post_type.' '.$ioa_meta_data['thumb_resize'].'-resize'; ?>" itemscope itemtype="http://schema.org/CollectionPage">
	<div class="skeleton clearfix auto_align">
		<div class="mutual-content-wrap ">
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


			<div class="clearfix portfolio-maerya-wrap">
				<?php while(have_posts()) : the_post();  ?>
				<div class="one_fourth  left ">
					<div class="portfolio-content clearfix"> <?php the_content(); ?></div>	
					<div class="dynamic-content"></div>
				</div>
				<?php endwhile; ?>

				<div class="three_fourth clearfix left ">
					<a href="" class="close-section cancel-2icon- ioa-front-icon"></a>
					<ul class="portfolio-maerya-list clearfix"  itemscope itemtype="http://schema.org/ItemList">

						 <?php 
						 	if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;
					 		$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => 4 , 'paged' => $paged) , $ioa_meta_data['portfolio_query_filter']);
					 		query_posts($opts); 
					 		$ioa_meta_data['i']=0; 

					 		if(have_posts()) :
					 		while (have_posts()) : the_post(); 
   							 get_template_part('templates/content-portfolio-maerya');  
   							endwhile; 
   							else : 
								echo '<li class="no-posts-found "><h4>'.__('Sorry no posts found','ioa').'</h4></li>';
							endif; ?>
					</ul>
				</div>	
			</div>	

			<?php if(have_posts()) : ?>
			<div class="pagination_wrap clearfix">
					<?php wp_paginate(); ?>
					<?php wp_paginate_dropdown(); ?>
			</div>	
		<?php endif; ?>
		</div>
</div>
<?php  wp_reset_query(); ?>
