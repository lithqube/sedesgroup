<?php global $super_options,$ioa_meta_data; 


if( isset($ioa_meta_data['tax_filter']) && $ioa_meta_data['tax_filter'] )
						{
							
							$slugs = explode(",",$ioa_meta_data['tax_filter']);
							$ids = array();

							foreach ($slugs as $key => $slug) {
								if($slug!="")
								{
									$idObj = get_category_by_slug($slug); 
 									$ids[] = $idObj->term_id;	
								}
							}

						}
 ?>


<?php if($super_options[SN.'_blog_fitler_style'] !="open") : ?>

<div class="ioa-menu blog-ioa-menu"  itemscope itemtype='http://schema.org/ItemList'>
	<span><?php _e('Sort','ioa') ?></span>
					<a href="" class="menu-button menuicon- ioa-front-icon"></a>
					<ul>
						<li data-cat="all" class='active all'><?php _e('All','ioa') ?></li>	
						<?php 
				 		$categories=  get_categories(); 
				 		if( isset($ioa_meta_data['tax_filter']) && $ioa_meta_data['tax_filter'] )
				 		{
				 			$categories=  get_categories(array( "include" => $ids )); 
				 		}
				 		foreach ($categories as $category) {
				  			$option = '<li data-cat="'.$category->category_nicename.'" class="'.$category->category_nicename.'"><span itemprop="name">';
							$option .= $category->cat_name;
							$option .= '</span>';
							$option .= '<div class="hoverdir-wrap"><span class="hoverdir"></span></div></li>';
							echo $option;
				  		}
						?>
					</ul>
				</div>

<?php else: ?>

<div class="ioa-menu blog-ioa-menu ioa-menu-open"  itemscope itemtype='http://schema.org/ItemList'>
					<ul class="clearfix">
						<li data-cat="all" class='active all'><?php _e('All','ioa') ?></li>	
						<?php 
				 		$categories=  get_categories(); 
				 		foreach ($categories as $category) {
				  			$option = '<li data-cat="'.$category->category_nicename.'" class="'.$category->category_nicename.'"><span itemprop="name">';
							$option .= $category->cat_name;
							$option .= '</span>';
							$option .= '<div class="hoverdir-wrap"><span class="hoverdir"></span></div></li>';
							echo $option;
				  		}
						?>
					</ul>
				</div>

<?php endif; ?>				