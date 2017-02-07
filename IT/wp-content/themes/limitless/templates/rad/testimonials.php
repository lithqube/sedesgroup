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
$ioa_meta_data['hasFeaturedImage'] = false; 

$opts = array('posts_per_page' => 3,'post_type'=>'testimonial');
  $filter = array();


  if(isset($w['no_of_posts'])) $opts['posts_per_page'] = $w['no_of_posts']; 

  if(isset($w['sort_by']) && $w['sort_by'] !="" )
  {
   
        $filter['orderby '] =  $w['sort_by'];
     
  }
  if(isset($w['order']) && $w['order'] !="" )
  {
   
        $filter['order '] =  $w['order'];
     
  }

  $opts = array_merge($opts,$filter);


 ?>


<div <?php echo join(" ",$rad_attrs) ?>>
 <div class='testimonials-wrapper'>
  <div class="testimonials-inner-wrap" >

    
  

    <div class="updatable">
        <ul class="rad-testimonials-list clearfix"   itemscope itemtype="http://schema.org/Review">          
        <?php $query = new WP_Query($opts); $ioa_meta_data['i']=0;   $i=0;while ($query->have_posts()) : $query->the_post(); 
      $dbg = '' ; $dc = '';

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if($ioa_options =="")  $ioa_options = array();

if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
          ?> 
       <?php  
      
     	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
          
          
        <li class="clearfix <?php if($i==0) echo 'active'; ?>">
            
            
            	
           		
              
             	
				<div class="desc">
           			  
        	        <div class="content clearfix" itemprop="description" style='color:<?php echo $dc; ?>;background-color:<?php echo $dbg; ?>'>
 					      	 <i class="ioa-front-icon sort-downicon-" style="color:<?php echo $dbg; ?>;"></i>
                      <?php
						          
                     the_content() ?>
                   
                  	</div>

                   
                  
               
           		</div>
           		
              <div class="clearfix">
                <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
                <div class="image">
                  
                  <?php
                  $id = get_post_thumbnail_id();
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                  echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  ?>
              </div>

            <?php endif;
              ?>

              <div class="info">
                      <h2 class="name" itemprop="name"> <?php the_title(); ?></h2> 
                      <?php  if(get_post_meta(get_the_ID(),'design',true)!="")  echo "<span class='designation'>".get_post_meta(get_the_ID(),'design',true)."</span>" ?>
                    </div>
                    
              </div>
              
                 
               
        </li>

        <?php $i++; endwhile; ?>
    </ul>
    </div>
   

    
  </div>
</div></div>
<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>