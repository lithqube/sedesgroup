<?php

global $helper, $ioa_meta_data,$post,$super_options;


$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['width'] = 1069;
$ioa_meta_data['height'] = $super_options[SN.'_bt1_height'];

if($ioa_meta_data['layout']!="full")
{
	$ioa_meta_data['width'] = 740;
}
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

<div class="page-wrapper blog-template <?php echo $post->post_type ?>" itemscope itemtype="http://schema.org/Blog" >
	<div class="skeleton clearfix auto_align">
		<div class="mutual-content-wrap iso-parent <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout'];  ?>">

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
			 	$opts = array_merge(array('posts_per_page' => $ioa_meta_data['posts_item_limit'] , 'paged' => $paged) , $ioa_meta_data['query_filter']);
				query_posts($opts); 
			?>

			<div class="clearfix">
				<?php if(have_posts()) get_template_part('templates/blog-filter') ?>
			</div>

			<div class="blog-format1-posts hoverable clearfix">
				<ul class="clearfix blog_posts isotope">
					 <?php 
				 		

					 		$ioa_meta_data['i']=0; 
					 		if(have_posts()) :

					 			while (have_posts()) : the_post(); 
   									get_template_part('templates/post-blog-classic');  
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
	

