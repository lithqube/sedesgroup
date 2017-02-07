<?php 
/**
 * Post List Template
 */
global $helper,$ioa_meta_data;

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
          
          
        <li itemscope itemtype="http://schema.org/ARticle" class="clearfix <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
            
            
            	
           		
              <div class="desc">
           			<h2 itemprop="name" class="custom-font"> <a itemprop="url" href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
        	           <?php  if(isset($ioa_meta_data['meta_value']) && $ioa_meta_data['meta_value']!=""):  ?>   
                   <div class="extras clearfix"> 
                        <?php echo do_shortcode(stripslashes($ioa_meta_data['meta_value'])); ?> 
                    </div> 
                 <?php endif; ?> 

                  <?php if(isset($ioa_meta_data['excerpt']) && $ioa_meta_data['excerpt']!="no") : ?>
                  <div class="clearfix">
                    <p itemprop="description">
                      <?php
                       if(!isset($ioa_meta_data['excerpt_length'])) $ioa_meta_data['excerpt_length'] = 100;
                      $content = get_the_excerpt();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $helper->getShortenContent( $ioa_meta_data['excerpt_length'] ,   $content); ?>
                    </p>
                  </div>
                  <?php endif ?>
           		</div>
                 
               
        </li>
