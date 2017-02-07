<?php

global $helper, $ioa_meta_data,$post,$super_options;

$ioa_meta_data['item_per_rows'] = 2;
$ioa_meta_data['height'] = $super_options[SN.'_bt6_height'];
$ioa_meta_data['width'] = 600;

?>   

<div class="page-wrapper blog-template <?php echo $post->post_type ?>">
	<div class=" clearfix auto_align">
		<div class="">
			<div class="blog-format6-posts hoverable clearfix" itemscope itemtype="http://schema.org/Blog">
				<ul class="clearfix blog_posts">
					 <?php 
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
					 		$ioa_meta_data['i']=0; 

					 		if(have_posts()) : 
					 		while (have_posts()) : the_post(); 

   							 get_template_part('templates/post-blog-format6');  
   							endwhile;
   							else : 
   								echo ' <li class="auto_align skeleton no-posts-found"><h4>'.__('Sorry no posts found','ioa').'</h4></li> ';
   							endif;

   							 ?>

				</ul>	
			</div>

			<?php if(have_posts()) : ?>

				<div class="pagination_wrap clearfix">

					<div class="skeleton auto_align">

						<?php wp_paginate(); ?>

						<?php wp_paginate_dropdown(); ?>
					</div>
				</div>
			<?php endif; ?>	
		</div>
	</div>
