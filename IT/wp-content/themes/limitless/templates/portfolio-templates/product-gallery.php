<?php
global $helper, $ioa_meta_data,$post,$super_options,$portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['width'] = 1060;
$ioa_meta_data['height'] = $super_options[SN.'_pgallery_height'];
if($ioa_meta_data['layout']!="full")
{
	$ioa_meta_data['width'] = 740;
}

?>   
<div class="page-wrapper portfolio-template portfolio-gallery <?php echo $post->post_type ?>" itemscope itemtype="http://schema.org/CollectionPage">
	<div class="skeleton clearfix auto_align">
		<div class="mutual-content-wrap <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout']." has-sidebar";  ?>">
			<?php	
			if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;
			$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug ,  'posts_per_page' => $ioa_meta_data['portfolio_item_limit'] , 'paged' => $paged) , $ioa_meta_data['portfolio_query_filter']);
					 		query_posts($opts); if(have_posts()) :?> 	
			<div class="product-gallery  clearfix">
		 	<span class="loader"></span>	
			<div  itemscope itemtype="http://schema.org/ImageGallery" class="ioa-gallery seleneGallery" data-effect_type="fade" data-width="<?php echo $ioa_meta_data['width'] ?>" data-height="<?php echo $ioa_meta_data['height'] ?>" data-duration="5" data-autoplay="true" data-captions="true" data-arrow_control="true" data-thumbnails="true" > 
                      <div class="gallery-holder"> 
                      	<?php
						while(have_posts()) : the_post(); 
							get_template_part('templates/content-portfolio-gallery');
						endwhile;
						?> 
					   </div>
			</div>
			</div>	
			<?php else : 
					echo ' <div class="no-posts-found"><h4>'.__('Sorry no posts found','ioa').'</h4></div> ';
				endif; ?>
		</div>
			<?php get_sidebar(); ?>
		</div>
		<?php  wp_reset_query(); ?>
