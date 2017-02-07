<?php 
/**
 * Post Slider Template for RAD BUILDER
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
$rad_attrs[] = 'class=" post_slider-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';

// Default Values 
 
$ioa_meta_data['height'] = $w['height'];
$ioa_meta_data['width'] = $w['width'];
$ioa_meta_data['excerpt_length'] = $w['excerpt_length'];
$ioa_meta_data['hasFeaturedImage'] = false; 

$opts = array('posts_per_page' => 3,'post_type'=>'post');
$filter = array();
$custom_tax = array();

if(isset($w['no_of_posts'])) $opts['posts_per_page'] = $w['no_of_posts']; 
if(isset($w['post_type']) && trim($w['post_type'])!="") $opts['post_type'] = $w['post_type']; 



  if(isset($w['posts_query']) && $w['posts_query'] !="" )
  {
     $qr = explode('&',$w['posts_query']);


     foreach($qr as $q)
     {
      if(trim($q)!="")
      {
        $temp = explode("=",$q);
        $filter[$temp[0]] = $temp[1];
        if($temp[0]=="tax_query")
        {
          $vals = explode("|",$temp[1]);  
          $custom_tax[] = array(
              'taxonomy' => $vals[0],
          'field' => 'id',
          'terms' => explode(",", $vals[1])

            );
        }
      }
     }


  }
  $custom_tax[] = array(
                      'taxonomy' => 'post_format',
                      'field' => 'slug',
                      'terms' => array('post-format-quote','post-format-aside','post-format-video','post-format-gallery','post-format-link','post-format-status','post-format-chat'),
                      'operator' => 'NOT IN'
                    );

  $opts = array_merge($opts,$filter);
  $opts['tax_query'] = $custom_tax;


if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

?>
<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="post_slider-inner-wrap" >

    <div class="text-title-wrap"  itemscope itemtype="http://schema.org/Thing">
      <h2 itemprop="name" class="text_title  custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
    </div>

  
    <div data-arrow_control="true" data-autoplay="<?php if($w['autoplay']=="yes") echo 'true'; ?>" data-duration="<?php echo $w['duration'] ?>" data-caption="true" data-width="<?php echo $w['width'] ?>" data-effect_type="scroll" data-height="<?php echo $w['height'] ?>" class="ioaslider quartz rad-slider clearfix <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'way-animated'; ?>" <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'data-waycheck="'.$w['visibility'].'"'; ?>> 
           <div class="items-holder">
        <?php $query = new WP_Query($opts); $ioa_meta_data['i']=0; while ($query->have_posts()) : $query->the_post();  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : ?> 

        <div class="slider-item"  itemscope itemtype="http://schema.org/ItemList"> <?php
            $dbg = '' ; $dc = ''; $cl = '';

          if(get_post_meta(get_the_ID(),'dominant_bg_color',true)!="") $dbg =  get_post_meta(get_the_ID(),'dominant_bg_color',true);
          if(get_post_meta(get_the_ID(),'dominant_color',true)!="") $dc =  get_post_meta(get_the_ID(),'dominant_color',true);


          $id = get_post_thumbnail_id();
          $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
          echo $helper->imageDisplay(array( "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] , "link" => get_permalink() , "src" => $ar[0] )); ?>
        
          <div class="slider-desc">
                   <h4 itemprop="name" style="color:<?php echo $dc?>;background-color:<?php echo $dbg ?>"><?php the_title(); ?></h4>
                 
                 <?php if($ioa_meta_data['excerpt_length']>0) :  ?>
                  <div  style="color:<?php echo $dc?>;background-color:<?php echo $dbg ?>" class="caption"> 
                      <p itemprop="description">
                      <?php
                      if(!isset($ioa_meta_data['excerpt_length'])) $ioa_meta_data['excerpt_length'] = 100;
                      $content = get_the_excerpt();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $helper->getShortenContent( $ioa_meta_data['excerpt_length'] ,   $content); ?>
                    </p>
                     <a itemprop="url" href="<?php the_permalink(); ?>" style="background-color:<?php echo $dc?>;color:<?php echo $dbg ?>" class='read-more'><?php if(isset($w['more_label'])) echo $w['more_label']; else _e('More','ioa'); ?></a>
                  </div> 
                  <?php endif; ?>

          </div> 

       </div> 
        <?php endif; endwhile; ?>
      
 
        </div>
    </div>
   


    
  </div>

</div>
<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>