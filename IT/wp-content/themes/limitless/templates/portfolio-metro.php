<?php
/**
 * The template used for generating Portfolio Metro
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $helper,$ioa_meta_data,$portfolio_taxonomy,$ioa_portfolio_slug;

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
        <?php 

         $dbg = '' ; $dc = '';

          $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
 

if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
        
         ?>  
          
        <li itemscope itemtype="http://schema.org/Article" class=" clearfix hoverable <?php $ioa_meta_data['i']++;  ?>">
          <div class="inner-item-wrap" style='background-color:<?php echo $dbg; ?>;color:<?php echo $dc; ?>;' >
            
            


              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
            	
              <div class="image-wrap clearfix">
             	 <div class="image" >
                <?php
					  	      $id = get_post_thumbnail_id();
	          		    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
					          
                    echo $helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                    
				       
                ?>

				      <?php if($ioa_meta_data['portfolio_enable_thumbnail']!="true"): 
                          $helper->getHover( array('format' => 'link' , 'link' => get_permalink() , 'bg' => $dbg , 'c' => $dc )  ); 
                       else:  
                          $helper->getHover( array('format' => 'image' , 'image' => $ar[0] , 'bg' => $dbg , 'c' => $dc )   );  
                       endif; ?>  
                
                
               </div>
              </div>
              
             <?php endif; ?>
              
              <div class="desc clearfix">
                  <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
              <?php
                  $terms = get_the_terms( $post->ID, $portfolio_taxonomy );
                    
                   if ( $terms && ! is_wp_error( $terms ) ) : 

                   $links = array();
                   foreach ( $terms as $term ) { $links[] = '<a href="' .get_term_link($term->slug, $portfolio_taxonomy) .'">'.$term->name.'</a>'; }
                   $terms = join( ", ", $links );
                  ?>

                  <p class="tags" style='color:<?php echo $dbg; ?>;background-color:<?php echo $dc; ?>' >
                     <?php echo $terms; ?>
                  </p>

              <?php endif; ?>

             
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
                  
                  


              </div>

          </div>  
        </li>

  <?php if( ceil($ioa_meta_data['portfolio_item_limit']/2) == $ioa_meta_data['i'] ) echo "</ul><ul class='clearfix'>"; ?>