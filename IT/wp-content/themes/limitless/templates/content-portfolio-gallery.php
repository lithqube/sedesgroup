<?php global $helper,$ioa_meta_data,$portfolio_taxonomy,$ioa_portfolio_slug;

if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
        <?php 

         $dbg = '' ; $dc = '';

          $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
 

if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
        
         ?>  
          
       	
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) :

               $id = get_post_thumbnail_id();
             $ar = wp_get_attachment_image_src( $id , array(9999,9999) );

               ?>   
              
               <div  itemscope itemtype='http://schema.org/Article' class="gallery-item <?php echo $ioa_meta_data['thumb_resize']; ?>" data-thumbnail="<?php $th = wp_get_attachment_image_src($id); echo $th[0]; ?>">

                <?php

                  switch ($ioa_meta_data['thumb_resize']) {
                    
                    case 'default': echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case 'proportional': echo $helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case 'none' : 
                    default: echo "<img src='". $ar[0]."' />"; break;
                  }
                   
             // 
          
        ?>

          
          <div class="gallery-desc" >
              <h4 itemprop='name' class="" <?php echo 'style="background-color:'.$dbg.'"' ?>> <a href="<?php the_permalink(); ?>" style='color:<?php echo $dc ?>'class="clearfix" ><?php the_title(); ?></a></h4>
              <div itemprop='description' class="caption" <?php echo 'style="color:'.$dc.';background-color:'.$dbg.'"' ?>>
          
          
                  <?php  if(  $ioa_meta_data['portfolio_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      
                      $content = get_the_excerpt();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $helper->getShortenContent( $ioa_meta_data['portfolio_excerpt_limit'] ,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>

                 
                  
                     <a href="<?php the_permalink(); ?>" itemprop='url' style='color:<?php echo $dbg; ?>;background:<?php echo $dc; ?>' class="hover-link ioa-front-icon link-2icon-"></a>  

              </div> 
              </div>
                
              
              </div>
              
             <?php endif; ?>