<?php
/**
 * The template used for generating blog template
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $helper,$ioa_meta_data,$paged,$super_options;

$ioa_meta_data['hasFeaturedImage'] = false; 


// Special Condition

if($ioa_meta_data['j']==0 && $paged==0 ) 
{
   $ioa_meta_data['height'] = 350; $ioa_meta_data['width'] = 750; 
   if($ioa_meta_data['layout']=="full") 
   {
     $ioa_meta_data['height'] = 450; $ioa_meta_data['width'] = 1060; 
   }
}
else
{
  $ioa_meta_data['height'] = $super_options[SN.'_bt5_height'];
  $ioa_meta_data['width'] = 350; 

  if($ioa_meta_data['layout']=="full") 
   {
      $ioa_meta_data['width'] = 512; 
   } 

}

$format_type = get_post_format();

  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true;  

 

         $dbg = '' ; $dc = '';

        $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
 

if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];

   switch ($format_type) {
    case 'image':  get_template_part("templates/blog-formats/post-image"); break;
    case 'gallery':get_template_part("templates/blog-formats/post-gallery"); break;  
    case 'link':get_template_part("templates/blog-formats/post-link"); break;
    case 'video':get_template_part("templates/blog-formats/post-video"); break;  
    case 'audio':get_template_part("templates/blog-formats/post-audio"); break;  
    case 'chat':get_template_part("templates/blog-formats/post-chat"); break;  
    case 'status':get_template_part("templates/blog-formats/post-status"); break;  
    case 'quote':get_template_part("templates/blog-formats/post-quote"); break;  
    default: ?>

       
          
        <li itemscope itemtype="http://schema.org/Article"  data-dbg='<?php echo $dbg; ?>' data-dc='<?php echo $dc; ?>'  id="post-<?php the_ID(); ?>"  class="iso-item <?php if($ioa_meta_data['j']==0 && $paged==0 ) echo "featured" ?> clearfix <?php echo join(' ',get_post_class()); ?> <?php  if( ! ($ioa_meta_data['j']==0 && $paged==0 ))  $ioa_meta_data['i']++; if($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) {  $ioa_meta_data['i']=0; } ?>">
            
            
             <?php 

               $mt = 'image';
            if(isset($ioa_options['featured_media_type'] ))
              $mt = $ioa_options['featured_media_type'] ;
                
echo $ioa_meta_data["featured_video"];
              switch($mt)
              {

                case "video" : ?>   
                               <div class="video">
                                   <?php $video =  $ioa_options["featured_video"];  echo fixwmode_omembed(wp_oembed_get(trim($video),array( "width" => $ioa_meta_data['width'] , 'height' => $ioa_meta_data['height'])) ) ; ?>
                               </div>
                              <?php break;
                case "gallery" : get_template_part("templates/post-featured-gallery"); break;
                case "slider" :get_template_part("templates/post-featured-slider"); break;
                case "image" : 
                default : ?>
      
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
             <div class="image-wrap">
               <div class="image" >
               <?php


              $id = get_post_thumbnail_id();
                    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
              echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
            ?>

                <?php if($ioa_meta_data['enable_thumbnail']!="true"): 
                          $helper->getHover( array('format' => 'link' , 'link' => get_permalink() , 'bg' => $dbg , 'c' => $dc )  ); 
                       else:  
                          $helper->getHover( array('format' => 'image' , 'image' => $ar[0], 'bg' => $dbg , 'c' => $dc  )  );  
                       endif; ?>  
                
              </div>
             </div>
              
              <?php
              endif;
              ?>
            

            <?php
              }
               ?>
              
              <div class="desc">
                <h2 class="" itemprop='name'> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
        
           <?php if(isset($ioa_meta_data['blogmeta_enable']) && $ioa_meta_data['blogmeta_enable']!="false") : ?>
                  <div class="extra clearfix">
                    <?php echo do_shortcode($ioa_meta_data['post_extras']); ?>
                  </div>        
            <?php endif; ?>
       
                  <div class="clearfix excerpt" itemprop='description'>
                  <?php  if(  $ioa_meta_data['blog_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      
                      $content = get_the_excerpt();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $helper->getShortenContent( $ioa_meta_data['posts_excerpt_limit'] ,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>

                  </div>
                       <a href="<?php the_permalink(); ?>" class="read-more"><?php echo stripslashes($ioa_meta_data['more_label']) ?></a>  
                  
                  
                 
              </div>
            
              

        </li>
 <?php break;
  }
  if($ioa_meta_data['j']==0 && $paged==0 ) echo "<li class='spacer'></li></ul><ul itemscope itemtype=\"http://schema.org/Article\"  class='isotope clearfix blog_posts filterable'>";
  $ioa_meta_data['j']++;
 ?>  
        