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

         $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
          

          if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
          if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
        
         ?>  
          
        <li  itemscope itemtype='http://schema.org/Article' data-dbg='<?php echo $dbg; ?>' data-dc='<?php echo $dc; ?>' class=" clearfix <?php echo $ioa_meta_data['column']; ?> <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
          <div class="inner-item-wrap">
            
              <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
            	<?php
                  $terms = get_the_terms( $post->ID, $portfolio_taxonomy );
                    
                   if ( $terms && ! is_wp_error( $terms ) ) : 

                   $links = array();
                   foreach ( $terms as $term ) { $links[] = '<a href="' .get_term_link($term->slug, $portfolio_taxonomy) .'">'.$term->name.'</a>'; }
                   $terms = join( ", ", $links );
                  ?>

                  <p class="tags">
                     <?php echo $terms; ?>
                  </p>

              <?php endif; ?>


              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
            	
              <div class="image-wrap">
             	 <div class="image" >
                <?php
					  	      $id = get_post_thumbnail_id();
	          		    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
					          
                    switch($ioa_meta_data['thumb_resize'])
                    {

                    case 'proportional' :   echo $helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    default :   echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;

                    } 
				       
                ?>
 <?php if($ioa_meta_data['portfolio_enable_thumbnail']!="true"): 
                          $helper->getHover( array('format' => 'link' , 'link' => get_permalink() , 'bg' => $dbg , 'c' => $dc )  ); 
                       else:  
                          $helper->getHover( array('format' => 'image' , 'image' => $ar[0] , 'bg' => $dbg , 'c' => $dc )   );  
                       endif; ?>  
                
               </div>
              </div>
              
             <?php endif; ?>
          </div>  
        </li>
