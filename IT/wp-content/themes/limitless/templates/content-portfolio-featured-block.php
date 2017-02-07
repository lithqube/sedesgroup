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
          
        <div  itemscope itemtype='http://schema.org/Article' data-dbg='<?php echo $dbg; ?>' data-dc='<?php echo $dc; ?>' class=" clearfix <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
          <div class="inner-item-wrap">
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
            	
              <div class="image-wrap">
             	 <div class="image" >
                <?php
					  	      $id = get_post_thumbnail_id();
	          		    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
					          
                      echo $helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
				       
                ?>

				      <div class="overlay" <?php echo 'style="background-color:'.$dbg.';color:'.$dc.'"' ?>>
                   <h2 class="" itemprop='name'> <a style='color:<?php echo $dc; ?>' itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                 
              <span class="spacer" style='border-color:<?php echo $dc; ?>'></span>
                 <div class="clearfix excerpt" itemprop='description' style='color:<?php echo $dc; ?>'>
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
              </div>
              
             <?php endif; ?>
          </div>  
        </div>
  
  <span class="spacer"></span>