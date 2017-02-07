<?php 
/**
 * Text Template for RAD BUILDER
 */

global $helper, $super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];



$inner_wrap_classes = '';
$rad_attrs = array();

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none")  $rad_attrs[] = 'data-waycheck="'.$w['visibility'].'"';
if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

$way = '';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") $way = 'way-animated';
$rad_attrs[] = 'class=" sidebar-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';
 ?>

<div <?php echo join(" ",$rad_attrs) ?>>	
  <div class="sidebar-inner-wrap" style='<?php if(isset($w['col_alignment'])) echo "text-align:".$w['col_alignment'] ?>'>
	
	
	<div class="sidebar <?php if(isset($w['sidebar_behavior'])) echo $w['sidebar_behavior']; ?>"  itemscope itemtype="http://schema.org/WPSideBar">
		<?php 
   
	 	if ( isset($w['sidebar_v']) && trim($w['sidebar_v'])!=""  ) {
			dynamic_sidebar ($w['sidebar_v']); 
		}
		else  {
		 	dynamic_sidebar ("Blog Sidebar"); 
		}
	
	?>  
	</div>
	</div>
	
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>