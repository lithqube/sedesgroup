<?php
global $helper, $ioa_meta_data,$post,$super_options,$portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['item_per_rows'] = 4;
$ioa_meta_data['width'] = 500;
$ioa_meta_data['height'] = $super_options[SN.'_pmasonry_height'];
$ioa_meta_data['column'] =  '';
$ioa_meta_data['layout'] =  'full';
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

<div class="page-wrapper portfolio-template portfolio-masonry-template <?php echo $post->post_type ?>" itemscope itemtype="http://schema.org/CollectionPage">
	<div class="clearfix auto_align">
		<div class="mutual-content-wrap">
			<div class="rad-holder clearfix" data-id="<?php echo get_the_ID(); ?>">
				<?php get_template_part('templates/rad/construct'); ?>
			</div>
			<div class="portfolio-masonry   clearfix">
				<ul class="clearfix portfolio_posts isotope"  itemscope itemtype="http://schema.org/ItemList">
					 <?php 
					 		if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;
					 		$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $ioa_meta_data['portfolio_item_limit'] , 'paged' => $paged) , $ioa_meta_data['portfolio_query_filter']);
					 		query_posts($opts); 
					 		$ioa_meta_data['i']=0; 
					 		if(have_posts()) :
					 		while (have_posts()) : the_post(); 
   							get_template_part('templates/portfolio-masonry'); 
   							endwhile; 
   							else : 
				echo '<li class="no-posts-found "><h4>'.__('Sorry no posts found','ioa').'</h4></li>';
				endif; ?>
				</ul>	
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
