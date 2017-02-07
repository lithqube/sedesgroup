<?php

global $helper, $ioa_meta_data,$post,$super_options;

$ioa_meta_data['item_per_rows'] = 2;
$ioa_meta_data['height'] = $super_options[SN.'_bt5_height'];
$ioa_meta_data['width'] = 350;
					

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


<div class="page-wrapper blog-template <?php echo $post->post_type ?>" itemscope itemtype="http://schema.org/Blog">
	<div class="skeleton clearfix auto_align">
		<div class="mutual-content-wrap iso-parent <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout']; else echo 'full-width-layout';  ?>">
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

				if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;

			 	$opts = array_merge(array('posts_per_page' => $ioa_meta_data['posts_item_limit'] , 'paged' => $paged ,  'tax_query' =>  array(
                 array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                    'operator' => 'NOT IN'
                  )
            	  )) , $ioa_meta_data['query_filter']);

				query_posts($opts); 

			?>
			<div class="clearfix">
				<?php if(have_posts()) get_template_part('templates/blog-filter') ?>
			</div>

			<div class="blog-format5-posts hoverable clearfix">
				<ul class="clearfix blog_posts ">
				 <?php 
					 		$ioa_meta_data['i']=0; 
					 		$ioa_meta_data['j']=0; 

					 		if(have_posts()) :
					 		while (have_posts()) : the_post(); 
   							 get_template_part('templates/post-blog-format5');  
   							endwhile;

   							else : 
   								echo ' <li class="no-posts-found">'.__('Sorry no posts found','ioa').'</li> ';
   							endif;

   							 ?>

				</ul>	
			</div>

			<?php if(have_posts()) : ?>
				<div class="pagination_wrap clearfix">
					<?php wp_paginate(); ?>
					<?php wp_paginate_dropdown(); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php get_sidebar();  wp_reset_query(); ?>
	</div>
