<?php
global $helper, $ioa_meta_data,$post,$super_options,$portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['item_per_rows'] = 1;
?>   
<div class="page-wrapper portfolio-template portfolio-full-screen <?php echo $post->post_type ?>" itemscope itemtype="http://schema.org/CollectionPage">
		<div class="mutual-content-wrap ">
				<div class="full-screen-view-pane full-stretch" data-id="<?php echo get_the_ID() ?>" itemscope itemtype="http://schema.org/ImageGallery">
						<span class="loader"></span>
				</div>	
			<?php  wp_reset_query(); ?>
		</div>
