<?php

global $helper, $ioa_meta_data,$post,$super_options;

$ioa_meta_data['item_per_rows'] = 2;
$ioa_meta_data['width'] = 330;
$ioa_meta_data['height'] = $super_options[SN.'_bt8_height'];
$ioa_meta_data['post_extras'] = '';

?>   


<div class="page-wrapper blog-template <?php echo $post->post_type ?>" itemscope itemtype="http://schema.org/Blog">
	<div class="skeleton clearfix auto_align">

		<div class="mutual-content-wrap <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
			<div class="blog-format10-posts hoverable clearfix">
					 <?php 
					 	get_template_part('templates/post-blog-timeline');  
						?>

			</div>
		</div>
		<?php get_sidebar();  wp_reset_query(); ?>

	</div>
