<?php 
/**
 * Testimonails Template for RAD BUILDER
 */

global $helper, $super_options , $ioa_meta_data;

$w = $ioa_meta_data['widget']['data'];


$inner_wrap_classes = '';
$rad_attrs = array();

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none")  $rad_attrs[] = 'data-waycheck="'.$w['visibility'].'"';
if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

$way = '';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") $way = 'way-animated';
$rad_attrs[] = 'class=" person-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';

if(!isset($w['youtube_v'])) $w['youtube_v'] = '';

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="person-inner-wrap <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'way-animated'; ?>" <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'data-waycheck="'.$w['visibility'].'"'; ?> >

     
 
   <?php  $code ="[person photo='".$w['photo']."' name='".$w['mem_name']."' designation='".$w['mem_desig']."' info='".$w['mem_information']."' twitter='".$w['twitter_v']."' facebook='".$w['facebook_v']."' youtube='".$w['youtube_v']."' google='".$w['google_v']."' linkedin='".$w['linkedin_v']."' dribbble='".$w['dribbble_v']."' label_color='".$w['mem_color']."' width='100%' /]";
    echo do_shortcode($code);
     ?>

    
  </div>
</div>
<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>