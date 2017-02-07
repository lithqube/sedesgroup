<?php 
/**
 * Text Template for RAD BUILDER
 */

global $helper, $super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['inputs']; 

$hidden_data = $helper->getAssocMap($w,'hidden');
 // $helper->prettyPrint($w);



$col =$ioa_meta_data['widget']['layout'];

$layout_type = '';

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

// Get keys ==== 
// $helper->prettyPrint( $ioa_meta_data['widget']);

$keys = implode(',',$radunits[$ioa_meta_data['widget']['type']]->getInputKeys());

$joint = strtolower( str_replace(" ","_",trim($ioa_meta_data['widget']['type']) ) );
if(!isset($w['w'])) $w['w'] = '';
if(!isset($w['width'])) $w['width'] =350;
if(!isset($w['height'])) $w['height'] =350;
if(!isset($w['labels'])) $w['labels'] ="Field 1,Field 2";


$testable = get_transient('rad_session');
$titlecheck = true;
if(!$testable)
{
  if(trim($w['text_title'])=="") $titlecheck = false;
}  
$rad_attrs = array();

if(isset($ioa_meta_data['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['id'].'"';
//if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none")  $rad_attrs[] = 'data-waycheck="'.$w['visibility'].'"';
if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

if($testable) {
$rad_attrs[] = 'data-type="'.$ioa_meta_data['widget']['type'].'"';
$rad_attrs[] = 'data-fields="'.$keys.'"';
}

$way = '';
//if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") $way = 'way-animated';
$rad_attrs[] = 'class="'.$joint.'-wrapper clearfix page-rad-component rad-component-spacing '.$layout_type.' '.$way.'"';
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';
 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="<?php echo $joint ?>-inner-wrap" style='<?php if(isset($w['col_alignment'])) echo "text-align:".$w['col_alignment'] ?>'>
		
		<?php if(isset($w['text_title']) && $titlecheck) : ?>
		<div class="text-title-wrap">
			
			<div class="text-title-inner-wrap"  itemscope itemtype="http://schema.org/Thing">
				<h2 itemprop="name" class="text_title <?php if($hidden_data['text_title']) echo $hidden_data['text_title']; ?> custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
				<span class="spacer"></span>
			</div>	
			
		</div>
		<?php endif; ?>
			
		<div class="graph" data-type="area" data-unit="<?php echo $w['unit'] ?>" data-width="<?php echo $w['width'] ?>" data-height="<?php echo $w['height'] ?>" data-labels="<?php echo $w['labels'] ?>" data-values="<?php echo $w['values'] ?>"></div>	
		
	</div>

	<?php  if(get_transient('rad_session')) : ?>
	<div class="curtain <?php  if(isset($ioa_meta_data['state']) && $ioa_meta_data['state'] == "live" ) echo 'hide'; ?>"> <h4><?php echo str_replace("_"," ",$ioa_meta_data['widget']['type']) ?>  <span><?php _e('(Drag to Arrange)','ioa') ?></span> </h4> </div> 
	
	<div class="meta-data">
		
		<input type="hidden" class='component_layout' value="<?php echo $col ?>" />	
		<?php foreach ($radunits[$ioa_meta_data['widget']['type']]->getMetaKeys() as $key) : ?>
			<input type="hidden" class='<?php echo $key; ?>' value="<?php if(isset($w[$key])) echo $w[$key] ?>" />	
		<?php endforeach; ?>
	
	</div>
	<?php endif; ?>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>