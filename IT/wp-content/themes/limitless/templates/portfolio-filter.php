<?php global $portfolio_taxonomy,$super_options,$ioa_meta_data; 


?>

<?php if($super_options[SN.'_portfolio_fitler_style'] !="open") : ?>
<div class="ioa-menu portfolio-ioa-menu">
	<span><?php _e('Sort','ioa') ?></span>
	<a href="" class="menu-button menuicon- ioa-front-icon portfolio-filter-menu"></a>
	<ul  itemscope itemtype="http://schema.org/ItemList" >
		<li class='active' data-cat='all'><?php _e('All','ioa') ?></li>	
		<?php 
 		$categories=  get_terms($portfolio_taxonomy); 
 		if( isset($ioa_meta_data['tax_filter']) && $ioa_meta_data['tax_filter'] )
		{
			$categories=  get_terms($portfolio_taxonomy ,array( "include" => $ioa_meta_data['tax_filter']['terms'] )); 
		}
 		foreach ($categories as $category) {
  			$option = '<li data-cat="'.$category->slug.'" class="'.$category->slug.'"><span itemProp="name">';
			$option .= $category->name;
			$option .= '</span><div class="hoverdir-wrap"><span class="hoverdir"></span></div></li>';
			echo $option;
  		}
		?>
	</ul>
</div>
<?php else: ?>
<div class="ioa-menu portfolio-ioa-menu ioa-menu-open">
	<ul  itemscope itemtype="http://schema.org/ItemList" class="clearfix">
		<li class='active' data-cat='all'><?php _e('All','ioa') ?></li>	
		<?php 
 		$categories=  get_terms($portfolio_taxonomy); 
 		if( isset($ioa_meta_data['tax_filter']) && $ioa_meta_data['tax_filter'] )
		{
			$categories=  get_terms($portfolio_taxonomy ,array( "include" => $ioa_meta_data['tax_filter']['terms'] )); 
		}
 		foreach ($categories as $category) {
  			$option = '<li data-cat="'.$category->slug.'" class="'.$category->slug.'"><span itemProp="name">';
			$option .= $category->name;
			$option .= '</span><div class="hoverdir-wrap"><span class="hoverdir"></span></div></li>';
			echo $option;
  		}
		?>
	</ul>
</div>
<?php endif; ?>