<?php
/**
 * The template used for generating Portfolio 4 Columns
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $helper,$ioa_meta_data,$portfolio_taxonomy,$ioa_portfolio_slug;

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
        <?php 

         $dbg = '' ; $dc = '';
            $cl = array();
                   $links = array();
                   
         $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
 

if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
        
              $terms = get_the_terms( get_the_ID(), $portfolio_taxonomy );
                    
                   if ( $terms && ! is_wp_error( $terms ) ) : 
                 
                   foreach ( $terms as $term ) { 
                      $links[] = '<a href="' .get_term_link($term->slug, $portfolio_taxonomy) .'">'.$term->name.'</a>'; 
                      $cl[] = "category-".$term->slug;
                    }
                   $terms = join( ", ", $links );
                  endif; ?>  
          
        <li itemscope itemtype="http://schema.org/Article" data-dbg='<?php echo $dbg; ?>' data-dc='<?php echo $dc; ?>' id="post-<?php the_ID(); ?>"  class="iso-item clearfix <?php echo join(' ',$cl); ?>  <?php $ioa_meta_data['i']++;  ?>">
          <span class="loader"></span>
          <div class="inner-item-wrap">
            
            

            


              <?php 

              $mt =  'image';

              switch($mt)
              {

                /*
                 * case "video" : ?>   
                               <div class="video">
                                   <?php $video =  get_post_meta( get_the_ID(),"featured_video",true);  echo wp_oembed_get(trim($video),array( "width" => $ioa_meta_data['width'] , 'height' => $ioa_meta_data['height']) ) ; ?>
                               </div>
                              <?php break;
                 
                case "gallery" : get_template_part("templates/post-featured-gallery"); break;
                case "slider" :get_template_part("templates/post-featured-slider"); break; */
                case "image" : 
                default : ?>
      
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
             <div class="image-wrap">
               <div class="image" >
               <?php



              $id = get_post_thumbnail_id();
                    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );

              switch($ioa_meta_data['thumb_resize'])
              {
                  case "none" : echo "<img src='".$ar[0]."' alt='".get_the_title()."' />";  break;
                  case "proportional" :  echo $helper->imageDisplay(array( "crop" => "wproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                  case "default" :
                  default :   echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                 
              }
                    
            
            ?>

            <div class="hoverdir-wrap">
              <div class="hoverdir" <?php echo 'style="background-color:'.$dbg.'"' ?>>


                <div class="desc" <?php echo 'style="color:'.$dc.';"' ?>>
                 <h2 itemprop='name' class=""> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                  <p class="tags">
                     <?php if( !is_wp_error($terms) ) echo $terms; ?>
                  </p>

                   <?php if($ioa_meta_data['portfolio_enable_thumbnail']!="true"): 
                          $helper->getHover( array('format' => 'link' , 'link' => get_permalink() , 'bg' => $dbg , 'c' => $dc )  ); 
                       else:  
                          $helper->getHover( array('format' => 'image' , 'image' => $ar[0] , 'bg' => $dbg , 'c' => $dc )   );  
                       endif; ?>  
               </div>
                </div>

                
             </div>   

              </div>
             </div>
              
              <?php
              endif;
              ?>
            

            <?php
              }
               ?>
          </div>  
        </li>
