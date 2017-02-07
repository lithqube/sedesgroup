<?php 
/**
 * Single Related Posts Section
 */
global $helper,$super_options;


 // Related Posts logic
      $tags = wp_get_post_tags($post->ID); $args  = array();
    
      if ($tags) {
        $tag_ids = array();
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        $args=array(
        'tag__in' => $tag_ids,
        'post__not_in' => array($post->ID),
        'posts_per_page'=>4
        );

      }

      $rel = new WP_Query( $args );

 /**
       * Popular Posts logic
       */
      $args=array(
   
      'posts_per_page'=>4, "order" => "DESC" , "orderby" => "comment_count" , 'post__not_in' => array($post->ID), "tax_query" =>  array(
       
          array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                    'operator' => 'NOT IN'
                  )

        )
      );


    $pop = new WP_Query( $args );


     /**
       * Recent Posts logic
       */
      $args=array(
   
      'posts_per_page'=>4, "order" => "DESC" , "orderby" => "date" ,'post__not_in' => array($post->ID), "tax_query" =>  array(
        
          array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                    'operator' => 'NOT IN'
                  )
          
        )
      );


    $rec = new WP_Query( $args );
 
if( ! $rec->have_posts() &&  ! $rel->have_posts()  &&  ! $pop->have_posts()  ) return;
 ?>


  <!-- Filterable menu section -->
  <div class="related_posts clearfix">
          
     <div class="clearfix related_posts-title-area ">
            <div class="ioa-menu related-menu"> <span><?php _e('Sort','ioa') ?></span>
          <a href="" class="menu-button menuicon- ioa-front-icon"></a>
          <ul itemscope itemtype="http://schema.org/Thing">
           <?php if($rec->have_posts()) : ?> <li class='recent ' data-val="recent"><span itemprop="name" ><?php _e('Recent','ioa') ?></span> <div class="hoverdir-wrap"><span class="hoverdir"></span></div></li><?php endif; ?>
           <?php if($rel->have_posts()) : ?><li class='related  active' data-val="related"><span itemprop="name"><?php _e('Related','ioa'); ?></span> <div class="hoverdir-wrap"><span class="hoverdir"></span></div></li> <?php endif; ?>
           <?php if($pop->have_posts()) : ?> <li class='popular' data-val="popular"><span itemprop="name"><?php _e('Popular','ioa') ?></span> <div class="hoverdir-wrap"><span class="hoverdir"></span></div></li><?php endif; ?>
          </ul>
        </div>
        <h3 class="single-related-posts-title custom-title"><?php echo stripslashes($super_options[SN.'_related_posts_title']) ?></h3> 
    </div>


  <!-- Posts Area -->
<div class="related-posts-wrap clearfix">
    
    <?php if($rel->have_posts()) : ?>
    <ul class="clearfix single-related-posts related" itemscope itemtype="http://schema.org/ItemList">
    
    <?php 
     
      $i=0;
      while ($rel->have_posts()) : $rel->the_post();   $i++;
    $dbg = '' ; $dc = '';

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if($ioa_options =="")  $ioa_options = array();
if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];

       ?>

        <li class="clearfix <?php if($i==4) echo 'last'; ?>" itemscope itemtype="http://schema.org/Article" >
        
          <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>

          <div class="image">
            
             <a class="hover" href="<?php the_permalink() ?>" style='background-color:<?php echo $dbg ?>;color:<?php echo $dc ?>;'>
          <h3 itemprop="name" style='color:<?php echo $dc ?>;'><?php the_title(); ?></h3>
          <i style='color:<?php echo $dbg ?>;background-color:<?php echo $dc ?>;' class='link link-2icon- ioa-front-icon'></i>
        </a>
            
            <?php
              $id = get_post_thumbnail_id();
              $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
              echo $helper->imageDisplay( array( "src"=> $ar[0] ,"height" => 140 , "width" => 180 , "parent_wrap" => false, 'link' => get_permalink() ) );
              ?>
          </div> 
          <?php endif; ?>
        
        </li>

      <?php endwhile; ?>

<?php wp_reset_query(); ?>

</ul>
<?php endif; ?>

<?php if($pop->have_posts()) : ?>
<ul class="clearfix single-related-posts popular" itemscope itemtype="http://schema.org/ItemList">
    
    <?php 
  
     
    $i=0;
    while ($pop->have_posts()) : $pop->the_post();   $i++;
        $dbg = '' ; $dc = '';

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if($ioa_options =="")  $ioa_options = array();
if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
     ?>

    <li class="clearfix <?php if($i==4) echo 'last'; ?>" itemscope itemtype="http://schema.org/Article">
    
      <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>

      <div class="image">
            
            <a class="hover" href="<?php the_permalink() ?>" style='background-color:<?php echo $dbg ?>;color:<?php echo $dc ?>;'>
          <h3 itemprop="name" style='color:<?php echo $dc ?>;'><?php the_title(); ?></h3>
          <i style='color:<?php echo $dbg ?>;background-color:<?php echo $dc ?>;' class='link link-2icon- ioa-front-icon'></i>
        </a>
            
            <?php
              $id = get_post_thumbnail_id();
              $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
              echo $helper->imageDisplay( array( "src"=> $ar[0] ,"height" => 140 , "width" => 180 , "parent_wrap" => false, 'link' => get_permalink() ) );
              ?>
          </div> 
      <?php endif; ?>
    
    </li>

<?php endwhile; ?>

<?php wp_reset_query(); ?>

</ul>
<?php endif; ?>

<?php if($rec->have_posts()) : ?>
<ul class="clearfix single-related-posts recent" itemscope itemtype="http://schema.org/ItemList">
    
    <?php 
  
     
    $i=0;
    while ($rec->have_posts()) : $rec->the_post();   $i++; 
        $dbg = '' ; $dc = '';

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if($ioa_options =="")  $ioa_options = array();
if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
    ?>

    <li class="clearfix <?php if($i==4) echo 'last'; ?>" itemscope itemtype="http://schema.org/Article">
    
      <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>

       <div class="image">
            
             <a class="hover" href="<?php the_permalink() ?>" style='background-color:<?php echo $dbg ?>;color:<?php echo $dc ?>;'>
          <h3 itemprop="name" style='color:<?php echo $dc ?>;'><?php the_title(); ?></h3>
          <i style='color:<?php echo $dbg ?>;background-color:<?php echo $dc ?>;' class='link link-2icon- ioa-front-icon'></i>
        </a>
            
            <?php
              $id = get_post_thumbnail_id();
              $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
              echo $helper->imageDisplay( array( "src"=> $ar[0] ,"height" => 140 , "width" => 180 , "parent_wrap" => false, 'link' => get_permalink() ) );
              ?>
          </div> 
      <?php endif; ?>
    
    </li>

<?php endwhile; ?>

<?php wp_reset_query(); ?>

</ul>
<?php endif; ?>

</div>

</div>

