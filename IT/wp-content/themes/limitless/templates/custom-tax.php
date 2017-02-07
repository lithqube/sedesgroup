<?php

global $helper, $ioa_meta_data,$super_options;
$ioa_meta_data['item_per_rows'] = 4;
$ioa_meta_data['width'] = 264;
$ioa_meta_data['height'] = $super_options[SN.'_p4_height'];
$ioa_meta_data['column'] =  'one_fourth left';

$cl = "portfolio-columns  four-column";

$ioa_meta_data['layout'] = "full";
?>   


<div class="page-wrapper portfolio-template" itemscope itemtype='http://schema.org/WebPage'>
	
	<div class="skeleton clearfix auto_align">

		

		<div class="mutual-content-wrap <?php if($ioa_meta_data['layout']!="full") echo 'has-'.$ioa_meta_data['layout'];  ?> custom-tax-template" >
       		
			
			<div class=" <?php echo $cl ?> hoverable  clearfix">
				<ul class="clearfix portfolio_posts" itemscope itemtype='http://schema.org/ItemList'>
					 <?php 
					 
					 		
					 		$ioa_meta_data['i']=0; 

					 		
					 		while (have_posts()) : the_post(); 	
					 			get_template_part('templates/portfolio-cols');
					 		endwhile; ?>
				</ul>	
			</div>

			
				<div class="pagination_wrap clearfix">
					<?php wp_paginate(); ?>
					<?php wp_paginate_dropdown(); ?>
				</div>
			
		

		</div>


		
		<?php get_sidebar(); ?>

	</div>

</div>

