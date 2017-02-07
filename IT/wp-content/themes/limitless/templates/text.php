<?php 
/**
 * Text Template for RAD BUILDER
 */

global $helper, $super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['inputs']; 

$hidden_data = $helper->getAssocMap($w,'hidden');
 // $helper->prettyPrint($w);

print_r($w);

return;

$col =$ioa_meta_data['widget']['layout'];

$layout_type = 'full_width left';

if(isset($ioa_meta_data['rad_layout'])) 
{
	switch($col)
	{
		case '100%' : $layout_type = 'full_width left' ; break;
		case '75%' : $layout_type = 'three_fourth left' ; break;
		case '66%' : $layout_type = 'two_third left' ; break;
		case '50%' : $layout_type = 'one_half left' ; break;
		case '33%' : $layout_type = 'one_third left' ; break;
		case '25%' : $layout_type = 'one_fourth left' ; break;

	}


}


$inner_wrap_classes = '';


// Get keys ==== 
$keys = implode(',',$radunits[$ioa_meta_data['widget']['type']]->getInputKeys());
$h = '';

$joint = strtolower( str_replace(" ","_",trim($ioa_meta_data['widget']['type']) ) );


$inner_wrap_classes .= ' subtitle-state-'.$hidden_data['text_subtitle'];
 ?>


<div data-type="<?php echo $ioa_meta_data['widget']['type']; ?>" id="<?php if(isset($ioa_meta_data['id'])) echo $ioa_meta_data['id']; ?>" data-fields="<?php echo $keys; ?>" class="<?php echo $joint ?>-wrapper page-rad-component rad-component-spacing  <?php echo $layout_type.' '; ?> clearfix">
	
	<div class="curtain <?php  if(isset($ioa_meta_data['state']) && $ioa_meta_data['state'] == "live" ) echo 'hide'; ?>"> <h4><?php echo str_replace("_"," ",$ioa_meta_data['widget']['type']) ?>  <span><?php _e('(Drag to Arrange)','ioa') ?></span> </h4> </div> 
	
	<div class="<?php echo $joint ?>-inner-wrap <?php echo $inner_wrap_classes; ?>  <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'way-animated'; ?>" <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'data-waycheck="'.$w['visibility'].'"'; ?> style='<?php if(isset($w['col_alignment'])) echo "text-align:".$w['col_alignment'] ?>' data-delay="<?php if(isset($w['delay'])) echo $w['delay'] ?>">
		
		<div class="text-title-wrap clearfix">
			
			<div style="margin-top:<?php if(isset($w['icon_margin'])) echo $w['icon_margin']."px" ?>" <?php if(isset($w['icon_animation']) && trim($w['icon_animation'])!= "") echo 'data-icon_hover="animated '.$w['icon_animation'].'"'; ?>  class="icon  <?php echo "float-".$w['icon_alignment']." "; if(isset($hidden_data['icon'])) echo $hidden_data['icon']; else $h =  ' hide '; if($w['icon']=="") $h =  ' hide '; echo $h; ?> " >
					<?php if(isset($w['icon'])) echo stripslashes($w['icon']); ?>
			</div>
			
			<div class="text-title-inner-wrap">
				<?php if(isset($w['text_title'])) : ?><h2  class="text_title <?php if($hidden_data['text_title']) echo $hidden_data['text_title']; ?> custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2><?php endif; ?>
				<?php if(isset($w['text_subtitle']) ) : ?><h4  class=" text_subtitle <?php if($hidden_data['text_subtitle']) echo $hidden_data['text_subtitle']; ?> custom-font1"><?php echo $helper->format($w['text_subtitle'],true,false,false); ?></h4><?php endif; ?>
			</div>	
			
		</div>
		
		<div class="text text_data <?php if(isset($hidden_data['text_data'])) echo $hidden_data['text_data']; ?>">
			
			<?php echo $helper->format($w['text_data'],false,true); ?>
		</div>
	</div>

	<div class="meta-data">
		
		<input type="hidden" class='component_layout' value="<?php echo $col ?>" />	
		<?php foreach ($radunits[$ioa_meta_data['widget']['type']]->getMetaKeys() as $key) : ?>
			<input type="hidden" class='<?php echo $key; ?>' value="<?php if(isset($w[$key])) echo $w[$key] ?>" />	
		<?php endforeach; ?>
		<textarea name="" id="" cols="30" rows="10" class="text_data <?php if(isset($hidden_data['text_data'])) echo $hidden_data['text_data']; ?>"><?php if(isset($w['text_data'])) echo stripslashes($w['text_data']); ?></textarea>
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>