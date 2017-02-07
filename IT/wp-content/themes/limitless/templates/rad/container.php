<?php 
global $ioa_meta_data;
			
	$container = $ioa_meta_data['rad_container_data'];
	$c = $container['data'];
	$ioa_meta_data['playout'] = $c['layout'];
	
	$isfirst = '';
	$istop = '';
	$islast = '';
	
	if(isset($c['first']) && $c['first'])
	{
			$isfirst = " first ";
	}
		
	if(isset($c['top']) && $c['top'])
	{
		$istop = ' top ';
	}
	else
		$c['top']  = false;

	if(isset($c['last']) && $c['last'])
	{
		//echo $depth;
		$islast = ' last'; 
		$ioa_meta_data['depth']++;
	}

	$float = '';
	if( isset($c['float']) && $c['float']!="" && $c['float']!="left" ) $float = $c['float'];

	$depth  = $ioa_meta_data['depth'];

	?>
	
	<div class="rad-container  layout_element <?php echo $float.' '.$c['layout'].$islast.$isfirst.$istop; if($c['background_opts']!='' && trim($c['background_color'])!="") echo ' senseBGModel '; if($c['border_top_width']!="" && $c['border_top_width']!="0") echo ' senseTopBorderModel '; if($c['border_bottom_width']!="" && $c['border_bottom_width']!="0") echo ' senseBottomBorderModel '; ?> clearfix" id="<?php echo $c['id'] ?>">
		<?php 
		

		$an_style=  "style='-webkit-transition-delay:".($depth*450)."ms;transition-delay:".($depth*350)."ms;'";

				if(!$c['top']) echo '<span class="vline" '.$an_style.'></span>';
				if(isset($ioa_meta_data['blocked']) && $islast == '' ) echo '<span class="hline" '.$an_style.'></span>';
		 ?>
		<div class="rad-inner-container nested clearfix">
		<?php 
			echo do_shortcode($ioa_meta_data['rad_container_data']['widgets']);
		 ?>		
		</div>
	</div>

	