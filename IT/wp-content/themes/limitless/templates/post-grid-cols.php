<?php 
/**
 * Grid Generation for RAD Builder
 */
global $helper,$ioa_meta_data,$portfolio_taxonomy,$ioa_portfolio_slug,$registered_posts;
$ioa_meta_data['hasFeaturedImage'] = false;
  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true;  ?>
          
           <?php 

          /**
           * Get Dominant background and color
           */
          $dbg = '' ; $dc = ''; $cl = array();

          $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
 

if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];

          /**
           * Generate Terms for Portfolio
           */
          if($ioa_meta_data['post_type']==$ioa_portfolio_slug)  :
           $terms = get_the_terms( get_the_ID(), $portfolio_taxonomy );
                   $cl = array();
                   $links = array();
                     
                   if ( $terms && ! is_wp_error( $terms ) ) : 
                   
                   foreach ( $terms as $term ) { 
                      $links[] = '<a href="' .get_term_link($term->slug, $portfolio_taxonomy) .'">'.$term->name.'</a>'; 
                      $cl[] = "category-".$term->slug;
                    }
                   $terms = join( ", ", $links );
                   endif; 

           elseif($ioa_meta_data['post_type']!="post" && is_object($ioa_meta_data['post_type'])) :
             $tax = $registered_posts[$ioa_meta_data['post_type']]->getTax();
              $terms = get_the_terms( get_the_ID(), strtolower(str_replace(' ','',$tax[0])) );
                   $cl = array();
                   $links = array();
                   if ( $terms && ! is_wp_error( $terms ) ) : 
                   
                   foreach ( $terms as $term ) { 
                      $links[] = '<a href="' .get_term_link($term->slug, strtolower(str_replace(' ','',$tax[0])) ) .'">'.$term->name.'</a>'; 
                      $cl[] = "category-".$term->slug;
                    }
                   $terms = join( ", ", $links );
                   endif; 

           endif;

         ?>  

        <li itemscope itemtype="http://schema.org/Article" class="iso-item clearfix hoverable <?php if($ioa_meta_data['post_type']=="post") echo join(' ',get_post_class());  elseif($cl!="") echo join(' ',$cl); ?>  <?php $ioa_meta_data['i']++;  ?> ">
            
               <div class="inner-item-wrap chain-link">
                  

              <?php  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  : ?>   
              
              <div class="image" >
               
                <?php
                $id = get_post_thumbnail_id();
                $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                ?>

               <?php  $helper->getHover( array('format' => 'link' , 'link' => get_permalink(), 'bg' => $dbg , 'c' => $dc  )  );  ?>
               


              </div>
              
              <?php
              endif;
              ?>
              
              <div class="desc">
                    <h2 itemprop="name" class="custom-font"> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                    
                    <?php if(isset($ioa_meta_data['meta_value']) && $ioa_meta_data['meta_value']!="")  : ?>
                    <div class="extras clearfix"> 
                        <?php  echo do_shortcode(stripslashes($ioa_meta_data['meta_value'])); ?> 
                    </div> 
                    <?php endif; ?>

                   <?php if(isset($ioa_meta_data['excerpt']) && $ioa_meta_data['excerpt']!="no") : ?>
                      
                  <div class="clearfix">
                    <p itemprop="description">
                      <?php
                      if(! isset( $ioa_meta_data['content_limit']) || trim($ioa_meta_data['content_limit'])=="")  $ioa_meta_data['content_limit'] = 100;

                      $content = get_the_content();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $helper->getShortenContent( $ioa_meta_data['content_limit'] ,   $content); ?>
                    </p>
                  </div>
                  <?php endif ?>
                 
              </div>
               </div>
                 
               
        </li>
