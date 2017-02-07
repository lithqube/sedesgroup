<?php 
/**
 * Testimonails Template for RAD BUILDER
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
$rad_attrs[] = 'class="  clearfix page-rad-component rad-component-spacing  '.$way.'"';
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';

// Default Values 
// 
$ioa_meta_data['height'] = 50;
$ioa_meta_data['width'] = 50;


 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
<div class="testimonial_bubble-wrapper">
  <div class="testimonial_bubble-inner-wrap" >


    <div  itemscope itemtype="http://schema.org/review" class="testimonial-bubble  <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'way-animated'; ?>" <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'data-waycheck="'.$w['visibility'].'"'; ?>>
       <?php  if(isset($w['t_id'])) : $tpost = get_post($w['t_id']); $dbg = '' ; $dc = '';
 
     

$ioa_options = get_post_meta($w['t_id'], 'ioa_options', true );
if($ioa_options =="")  $ioa_options = array();

if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
          ?> 
           
           <div class="testimonial-bubble-content" itemprop='description' style='color:<?php echo $dc; ?>;background-color:<?php echo $dbg; ?>'>
              <?php echo $tpost->post_content  ?>
                 <i class="ioa-front-icon sort-downicon-" style="color:<?php echo $dbg; ?>;"></i>
           </div> 

           <div class="testimonial-bubble-meta clearfix">
             
                <?php   if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail($w['t_id'])))  : ?>   
              
                <div class="image">
                  
                  <?php
                  $id = get_post_thumbnail_id($w['t_id']);
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                  echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  ?>
              </div>

            <?php endif;
              ?>

              <div class="info">
                      <h2 class="name" itemprop="name"> <?php echo get_the_title($w['t_id']); ?></h2> 
                      <?php  if(get_post_meta($w['t_id'],'design',true)!="")  echo "<span class='designation'>".get_post_meta($w['t_id'],'design',true)."</span>" ?>
                    </div>
                    
              </div>

        <?php endif; ?>
    </div>
   

    
  </div>
</div>
</div>
<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>