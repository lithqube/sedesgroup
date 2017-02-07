<?php
/**
 * The template used for generating Portfolio 4 Columns
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $helper,$ioa_meta_data,$paged,$super_options,$portfolio_taxonomy,$ioa_portfolio_slug;


if($ioa_meta_data['j']==0 && $paged == 0 ) : ?>

<li class="featured-block clearfix"  itemscope itemtype="http://schema.org/Article">
          
             <?php 
              
              $ioa_meta_data['width'] = 1060;
              $ioa_meta_data['height'] = $super_options[SN.'_ff_height'];

              get_template_part('templates/content-portfolio-featured-block');  ?>
             
          
        </li>


<?php $ioa_meta_data['j']++; else : 
  
  $ioa_meta_data['width'] = 530;
  $ioa_meta_data['height'] = $super_options[SN.'_ffa_height'];
 


	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
        <?php 

         $dbg = '' ; $dc = '';

         $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
 

if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
        
         ?>  
          
        <li  itemscope itemtype="http://schema.org/Article" data-dc='<?php echo $dc; ?>' data-dbg='<?php echo $dbg; ?>'  class=" clearfix <?php if( $ioa_meta_data['j']%2==0) echo 'align-left'; else echo 'align-right'; ?> <?php echo $ioa_meta_data['column']; ?> <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
          
          
          <div class="inner-item-wrap clearfix">
            
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
                  case "proportional" :  echo $helper->imageDisplay(array( "crop" => "hproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                  case "default" :
                  default :   echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                 
              }
                    
            
            ?>

               <?php if($ioa_meta_data['portfolio_enable_thumbnail']!="true"): 
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
              
             <div class="desc clearfix">
                 
                  <div class="title-area clearfix">
              <span class="date"><small class='no'><?php echo get_the_date('d'); ?></small> <small class='rest'><?php echo get_the_date('M y'); ?></small></span>
              <div class="title-meta-info clearfix">
                   <h2 class="" itemprop='name'> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                 <?php
                    $terms = get_the_terms( $post->ID, $portfolio_taxonomy );
                    
                    if ( $terms && ! is_wp_error( $terms ) ) : 

                    $links = array();
                    foreach ( $terms as $term ) { $links[] = '<a href="' .get_term_link($term->slug, $portfolio_taxonomy) .'">'.$term->name.'</a>'; }
                    $terms = join( ", ", $links );
                    ?>

                    <p class="tags">
                     <?php echo 'in '. $terms; ?>
                    </p>

                 <?php endif; ?>
              </div>

          </div>
                
                <div class="clearfix excerpt" itemprop='description'>
                  <?php  if(  $ioa_meta_data['portfolio_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      
                      $content = get_the_excerpt();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $helper->getShortenContent( $ioa_meta_data['portfolio_excerpt_limit'] ,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>

                  </div>
                  
                  <a href="<?php the_permalink(); ?>" itemprop='url' class="read-more"><?php echo stripslashes($ioa_meta_data['portfolio_more_label']) ?></a>   

             </div> 

          </div>  
        </li>
        <?php $ioa_meta_data['j']++;  endif;   ?>

