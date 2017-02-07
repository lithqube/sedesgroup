<?php 
/**
 * gallery Template for RAD BUILDER
 */

global $helper, $super_options , $ioa_meta_data , $wpdb,$radunits,$ioa_portfolio_slug;

$w = $ioa_meta_data['widget']['data'];



$inner_wrap_classes = '';
$rad_attrs = array();

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none")  $rad_attrs[] = 'data-waycheck="'.$w['visibility'].'"';
if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

$way = '';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") $way = 'way-animated';
$rad_attrs[] = 'class=" post_grid-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';

// Default Values 
// 
$ioa_meta_data['height'] = 90;
$ioa_meta_data['width'] = 90;
$ioa_meta_data['hasFeaturedImage'] = false; 
$ioa_meta_data['item_per_rows'] = 4;
$ioa_meta_data['excerpt'] = "yes";
$ioa_meta_data['meta_value'] = "";
$post_structure_class = 'post-list';

$ioa_meta_data['tax_filter'] = false; 

$opts = array('posts_per_page' => 3,'post_type'=>'post');
  $filter = array();
$custom_tax = array();

  if(isset($w['meta_value'])) $ioa_meta_data['meta_value'] = $w['meta_value']; 
  if(isset($w['excerpt'])) $ioa_meta_data['excerpt'] = $w['excerpt']; 
  if(isset($w['no_of_posts'])) $opts['posts_per_page'] = $w['no_of_posts']; 
  if(isset($w['post_type'])) $opts['post_type'] = $w['post_type']; 

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
     
    

      if(isset($custom_tax[0]))
        $ioa_meta_data['tax_filter'] = $custom_tax[0];

      if($w['post_type'] == 'post' && isset($filter['category_name']) ) $ioa_meta_data['tax_filter'] = $filter['category_name'];

  }

$ioa_meta_data['post_type'] = $w['post_type'];
 $custom_tax[] = array(
                      'taxonomy' => 'post_format',
                      'field' => 'slug',
                      'terms' => array('post-format-quote','post-format-aside','post-format-video','post-format-gallery','post-format-link','post-format-status','post-format-chat'),
                      'operator' => 'NOT IN'
                    );

if( ! isset($w['excerpt_length']) ) $w['excerpt_length'] = 150;
  $opts = array_merge($opts,$filter);
  $opts['tax_query'] = $custom_tax;
$ioa_meta_data['content_limit'] = $w['excerpt_length'];

switch($w['post_structure'])
      {
        case '1-col' : 
                      $ioa_meta_data['height'] = 500;
                      $ioa_meta_data['width'] = 1060;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 1;
                      $post_structure_class = 'post-grid-1cols'; 
                      break;
        case '2-col' : 
                      $ioa_meta_data['height'] = 300;
                      $ioa_meta_data['width'] = 505;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 2;
                      $post_structure_class = 'post-grid-2cols';
                      break;
        case '3-col' : $ioa_meta_data['height'] = 220;
                      $ioa_meta_data['width'] = 322;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 3;
                      $post_structure_class = 'post-grid-3cols';
                      break;
        default :              
        case '4-col' : $ioa_meta_data['height'] = 180;
                      $ioa_meta_data['width'] = 250;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 4;
                      $post_structure_class = 'post-grid-4cols';
                      break;
        case '5-col' : $ioa_meta_data['height'] = 120;
                      $ioa_meta_data['width'] = 184;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 5;
                      $post_structure_class = 'post-grid-5cols';
                      break;
        case '6-col' : $ioa_meta_data['height'] = 90;
                      $ioa_meta_data['width'] = 150;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 6;
                      $post_structure_class = 'post-grid-6cols';
                      break;                            
      }

global $paged;
if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;
if($w['w_pagination']=="yes") $opts['paged'] = $paged;

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="post_grid-inner-wrap  iso-parent">

    
    <div class="text-title-wrap clearfix"  itemscope itemtype="http://schema.org/Thing">
        <h2 itemprop="name" class="text_title custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
       <?php
        if(isset($w['filter_menu']) && $w['filter_menu'] != "no") :
            if($w['post_type']=="post") get_template_part('templates/blog-filter');
            elseif($w['post_type']==$ioa_portfolio_slug) get_template_part('templates/portfolio-filter');
            else get_template_part('templates/custom-filter');
        endif;  
       ?>
    </div>
    
    
    <div class="updatable hoverable">
        <ul itemscope itemtype="http://schema.org/ItemList" class="isotope posts-grid posts  <?php echo $post_structure_class; ?>  <?php echo $post_structure_class; ?> clearfix <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'way-animated'; ?> <?php if(isset($w['chainability']) && trim($w['chainability'])!= "" && trim($w['chainability'])!= "none") echo 'chain-animated'; ?>" <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'data-waycheck="'.$w['visibility'].'"'; ?> <?php if(isset($w['chainability']) && trim($w['chainability'])!= "" && trim($w['chainability'])!= "none") echo 'data-chain="'.$w['chainability'].'"'; ?> >          
        <?php query_posts($opts); $ioa_meta_data['i']=0; while (have_posts()) : the_post();  
             get_template_part('templates/post-grid-cols'); 
         endwhile; ?>
    </ul>
  
    <?php  if($w['w_pagination']=="yes")  wp_paginate(); wp_reset_query(); ?>

    </div>
   

    
  </div>

</div>
<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>