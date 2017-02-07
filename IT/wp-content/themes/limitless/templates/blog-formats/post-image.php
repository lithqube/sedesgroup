<?php
/**
 * The template used for generating Post Format Image
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $helper,$ioa_meta_data,$super_options;

 ?>
      
      <li itemscope itemtype='http://schema.org/BlogPosting' id="post-<?php the_ID(); ?>" class="iso-item clearfix <?php echo join(' ',get_post_class()); ?>  <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
            
            
             <div class="image-wrap">
               <div class="image" itemprop="description" >

                 <?php the_content() ?>

                
              </div>
             </div>
              
            
              
              <div class="desc">
                <h2 class=""> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                  
                  <?php if(isset($ioa_meta_data['blogmeta_enable']) && $ioa_meta_data['blogmeta_enable']!="false") : ?>
                  <div class="extra clearfix">
                    <?php echo do_shortcode($ioa_meta_data['post_extras']); ?>
                  </div>        
                  <?php endif; ?>

                  <a href="<?php the_permalink(); ?>" class="read-more"><?php echo stripslashes($ioa_meta_data['more_label']) ?></a>  
              </div>
                 
               <div class="datearea">
                  <small class='date'><?php echo get_the_date('d'); ?></small>
                  <small class='month'><?php echo get_the_date('M'); ?></small>

                  <div class="proxy-datearea">
                    <small class='date' ><?php echo get_the_date('d'); ?></small>
                    <small class='month' ><?php echo get_the_date('M'); ?></small>
                  </div>



               </div>

               <span class="line"></span>

        </li>

