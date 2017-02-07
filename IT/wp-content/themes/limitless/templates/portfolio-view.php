<?php 

$link = get_permalink(); 

 if(strpos($link,'?'))
 {
 	$link .= "&";
 }
 else
 	$link .= "?";

/**
 * Portfolio View Seletor
 */
?>
	<div class="portfolio-view clearfix" itemscope itemtype="http://schema.org/SiteNavigationElement" >
			<a itemprop='url' href='<?php echo $link ?>view=grid' class="ioa-front-icon th-large-1icon- grid-view <?php if((isset($_GET['view']) && $_GET['view'] == "grid" ) || !isset($_GET['view']) ) echo 'active'; ?>"></a>
			<a itemprop='url' href='<?php echo $link ?>view=list' class="ioa-front-icon th-list-1icon- list-view <?php if(isset($_GET['view']) && $_GET['view'] == "list" ) echo 'active'; ?>"></a>
	</div>