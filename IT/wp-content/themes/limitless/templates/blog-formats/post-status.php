<?php
/**
 * The template used for generating Post Format Link
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $helper,$ioa_meta_data,$super_options;

 ?>
      
      <li itemscope itemtype='http://schema.org/BlogPosting' id="post-<?php the_ID(); ?>" class="iso-item clearfix  <?php echo join(' ',get_post_class()); ?> <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
            
              <div class="desc ">
                  <h2 class="" itemprop="name"> <a itemprop="url" href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                
                <div class="status clearfix">
                   <?php the_content(); ?>
                </div>
              
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

