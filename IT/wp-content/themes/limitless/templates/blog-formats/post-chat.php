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
      
      <li  itemscope itemtype='http://schema.org/BlogPosting' id="post-<?php the_ID(); ?>" class="iso-item clearfix  <?php echo join(' ',get_post_class()); ?> <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
            
            
              <div class="desc" itemprop="description">
                
                <?php the_content(); ?>
              </div>
              <?php echo get_avatar(get_the_author_meta("ID"),40); ?>

                 
               <div class="datearea">
                  <small class='date'><?php echo get_the_date('d'); ?></small>
                  <small class='month'><?php echo get_the_date('M'); ?></small>

                  <div class="proxy-datearea" >
                    <small class='date' ><?php echo get_the_date('d'); ?></small>
                    <small class='month' ><?php echo get_the_date('M'); ?></small>
                  </div>



               </div>

               <span class="line"></span>

        </li>

