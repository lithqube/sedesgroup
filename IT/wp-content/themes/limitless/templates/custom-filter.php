<?php global $super_options,$ioa_meta_data, $registered_posts,$post; 

if($registered_posts[$ioa_meta_data['post_type']] == "") return;

$tax = $registered_posts[$ioa_meta_data['post_type']]->getTax();

        
?>

<?php if($super_options[SN.'_blog_fitler_style'] !="open") : ?>
<div class="ioa-menu portfolio-ioa-menu">
	<span><?php _e('Sort','ioa') ?></span>
	<a href="" class="menu-button ioa-front-icon portfolio-filter-menu portfolio-filter-menu "></a>
	<ul  itemscope itemtype="http://schema.org/ItemList" >
		<li class='active' data-cat='all'><?php _e('All','ioa') ?></li>	
		<?php 
 		
 		 $tax = $registered_posts[$ioa_meta_data['post_type']]->getTax();
         $categories = get_terms(  strtolower(str_replace(' ','',$tax[0])) );
      
 		if( isset($ioa_meta_data['tax_filter']) && $ioa_meta_data['tax_filter'] )
		{
			$categories=  get_terms(strtolower(str_replace(' ','',$tax[0])) ,array( "include" => $ioa_meta_data['tax_filter']['terms'] )); 
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