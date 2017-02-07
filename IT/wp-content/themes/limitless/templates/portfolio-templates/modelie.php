<?php
global $helper, $ioa_meta_data,$post,$super_options,$portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['item_per_rows'] = 1;
?>

<div class="page-wrapper portfolio-template portfolio-modelie <?php echo $post->post_type ?>" itemscope itemtype="http://schema.org/CollectionPage">
		<div class="mutual-content-wrap ">
			<div class=" view-pane clearfix" data-id='<?php echo get_the_ID(); ?>'>
				<span class="loader"></span>
				<div class="inner-view-pane">
					<ul class="clearfix"  itemscope itemtype="http://schema.org/ItemList">
					</ul>
				</div>	
			</div>	
		</div>
		<?php  wp_reset_query(); ?>
