<?php
/**
 * The template used for generating blog template Format 1 List
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $helper,$ioa_meta_data,$super_options;

$ioa_meta_data['hasFeaturedImage'] = false; 

$format_type = get_post_format();

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	

 $dbg = '' ; $dc = '';

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
 

  switch ($format_type) {
    case 'image':  get_template_part("templates/blog-formats/post-image"); break;
    case 'gallery':get_template_part("templates/blog-formats/post-gallery"); break;  
    case 'link':get_template_part("templates/blog-formats/post-link"); break;
    case 'video':get_template_part("templates/blog-formats/post-video"); break;  
    case 'audio':get_template_part("templates/blog-formats/post-audio"); break;  
    case 'chat':get_template_part("templates/blog-formats/post-chat"); break;  
    case 'status':get_template_part("templates/blog-formats/post-status"); break;  
    case 'quote':get_template_part("templates/blog-formats/post-quote"); break;  
    default: ?>
      
      <li itemscope itemtype="http://schema.org/Article"  id="post-<?php the_ID(); ?>"  class="iso-item clearfix <?php echo join(' ',get_post_class()); ?>  <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
            
            <?php 

             if(is_sticky()) echo '<i class="pin-2icon- ioa-front-icon sticky-icon post-icon"></i>';

             ?>

              
              <?php 

              $mt =  'image';

              switch($mt)
              {

                case "video" : ?>   
                               <div class="video">
                                   <?php $video =  $ioa_meta_data["featured_video"];  echo fixwmode_omembed(wp_oembed_get(trim($video),array( "width" => $ioa_meta_data['width'] , 'height' => $ioa_meta_data['height']) )) ; ?>
                               </div>
                              <?php break;
                case "gallery" : get_template_part("templates/post-featured-gallery"); break;
                case "slider" :get_template_part("templates/post-featured-slider"); break;
                case "image" : 
                default : ?>
      
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
             <div class="image-wrap">
               <div class="image" >
               <?php


              $id = get_post_thumbnail_id();
                    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
              echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
            ?>
                 <?php if($ioa_meta_data['enable_thumbnail']!="true"): 
                          $helper->getHover( array('format' => 'link' , 'link' => get_permalink() , 'bg' => $dbg , 'c' => $dc )  ); 
                       else:  
                          $helper->getHover( array('format' => 'image' , 'image' => $ar[0] , 'bg' => $dbg , 'c' => $dc )   );  
                       endif; ?>  
              
                
              </div>
             </div>
              
              <?php
              endif;
              ?>
            

            <?php
              }
               ?>
              
              <div class="desc">
                <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                  
                  <?php if(isset($ioa_meta_data['blogmeta_enable']) && $ioa_meta_data['blogmeta_enable']!="false") : ?>
                  <div class="extra clearfix">
                    <?php echo do_shortcode($ioa_meta_data['post_extras']); ?>
                  </div>        
                  <?php endif; ?>

                  <div class="clearfix excerpt" itemprop='description'>
                  <?php  if(  $ioa_meta_data['blog_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      
                      $content = get_the_excerpt();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $helper->getShortenContent( $ioa_meta_data['posts_excerpt_limit'] ,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>

                  </div>
                  
                  <a href="<?php the_permalink(); ?>" itemprop='url' class="read-more"><?php echo stripslashes($ioa_meta_data['more_label']) ?></a>  
              </div>
                 
               <div class="datearea">
                  <small class='date'><?php echo get_the_date('d'); ?></small>
                  <small class='month'><?php echo get_the_date('M'); ?></small>

                  <div class="proxy-datearea" style='background:<?php echo $dbg; ?>;color:<?php echo $dc; ?>'>
                    <small class='date' ><?php echo get_the_date('d'); ?></small>
                    <small class='month' ><?php echo get_the_date('M'); ?></small>
                  </div>



               </div>

               <span class="line"></span>

        </li>


      <?php break;
  }
 ?>  
          
        