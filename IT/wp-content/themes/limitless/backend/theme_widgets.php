<?php 
/**
 * @description : This File contains all theme's widgets
 * @dependency : none
 * @author Abhin Sharma <abhin_sh@yahoo.com>
 */

/*
   == Index ==========================================================

   1. Twitter Widget
   2. Google Map
   3. Custom Box Widget
   4. Facebook Like
   5. Posts

*/


/* == Twitter Widget ================================================= */

class Twitter_Widget extends WP_Widget {
    function __construct() {
        $params = array(
	    'description' => __('Display and cache recent tweets to your readers.','ioa'),
	    'name' => __('Twitter Widgets','ioa')
        );
        
        // id, name, params
        parent::__construct(__('Twitter_Widget','ioa'), '', $params);
    }
    
    public function form($instance) {
        extract($instance);
        ?>
        
        <p>
	    <label for="<?php echo $this->get_field_id('title');?>"><?php _e('Title:','ioa') ?> </label>
	    <input type="text"
		class="widefat"
		id="<?php echo $this->get_field_id('title'); ?>"
		name="<?php echo $this->get_field_name('title'); ?>"
		value="<?php if ( isset($title) ) echo esc_attr($title); ?>" />
        </p>
        
       
        <p>
	    <label for="<?php echo $this->get_field_id('tweet_count'); ?>">
		<?php _e('Number of Tweets to Retrieve:','ioa'); ?>
	    </label>
	     
	    <input
		type="number"
		class="widefat"
		style="width: 40px;"
		id="<?php echo $this->get_field_id('tweet_count');?>"
		name="<?php echo $this->get_field_name('tweet_count');?>"
		min="1"
		max="10"
		value="<?php echo !empty($tweet_count) ? $tweet_count : 5; ?>" />
        </p>
        <?php
    }
    
    // What the visitor sees...
    public function widget($args, $instance) {
		extract($instance);
        extract( $args );
        
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $before_widget;
		
			echo $before_title;
			    echo $title;
			echo $after_title;

			echo do_shortcode("[tweets  count='".$tweet_count."']");

        echo $after_widget;
        
    }
   

    
}

add_action('widgets_init', 'register_Twitter_Widget');
function register_Twitter_Widget()
{
    register_widget('Twitter_Widget');
}


/* == Google Map ========================================================== */


// == Google Map =====================

class GoogleMap extends WP_Widget {
	
	function GoogleMap() {
		 /* Widget settings. */
		 $widget_ops = array( 'classname' => 'GoogleMap', 'description' => __( 'Add google map.' ,'ioa'));

		 /* Widget control settings. */
		 $control_ops = array( "width"=>200);
		 parent::__construct(false,__( "Google map" ,'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['map_width']= strip_tags($new_instance['map_width']); 
			$instance['map_height']= strip_tags($new_instance['map_height']); 
			$instance['address']= strip_tags($new_instance['address']); 
			return $instance;
	}
	function form($instance) {
		 $title = $width = $height = $address = '';

		if(isset($instance['title'])) $title = esc_attr($instance['title']);
		if(isset($instance['map_width'])) $width = esc_attr($instance['map_width']);
		if(isset($instance['map_height'])) $height = esc_attr($instance['map_height']);
		if(isset($instance['address'])) $address = esc_attr($instance['address']);
		
		if($width=="") $width = 300;
		if($height=="") $height = 250;
		?>
        
       
		<p> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        <p> 
        <label for="<?php echo $this->get_field_id('map_width'); ?>"> <?php _e('Map Width','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('map_width'); ?>" name="<?php echo $this->get_field_name('map_width'); ?>" type="text" value="<?php echo $width; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('map_height'); ?>"> <?php _e('Map Height','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('map_height'); ?>" name="<?php echo $this->get_field_name('map_height'); ?>" type="text" value="<?php echo $height; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('address'); ?>"> <?php _e('Enter Address','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo $address; ?>" />
		</p>
        
     
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$title = esc_attr($instance['title']);
	$width = esc_attr($instance['map_width']);
	$height = esc_attr($instance['map_height']);
	$address = esc_attr($instance['address']);
	
	if($width!="") $width = 250;
	if($height!="") $height = 250;	

	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

	echo $before_widget;
		
	if($title!="")
	echo $before_title." ".$title.$after_title;
	
	echo '<div class="google-map" style="width:'.$width.'px;height:'.($height).'px;">
	          <iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.in/maps?q='.$address.'&amp;ie=UTF8&amp;hq=&amp;hnear='.$address.'&amp;gl=in&amp;z=11&amp;vpsrc=0&amp;output=embed">              </iframe>
		    </div>';
			
	echo $after_widget; 
		
		}
	
	

	}

add_action('widgets_init', create_function('', 'return register_widget("GoogleMap");'));

/* == Custom Box Widget ================================================================ */



class CustomBoxWidget extends WP_Widget {
	
	function CustomBoxWidget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'CustomBox', 'description' => __(' Create a custom text box with read more link and image.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::__construct(false,__("CustomBox",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['link']= $new_instance['link']; 
			$instance['label']= $new_instance['label']; 
			$instance['description']= $new_instance['description'];
			$instance['title']= strip_tags($new_instance['title']);
			$instance['intro_image_link']= strip_tags($new_instance['intro_image_link']);
			return $instance;
	}
	function form($instance) {
		$link = $label = $description = $title = $intro_image_link = '';

		if(isset($instance['link'])) $link = esc_attr($instance['link']);
		if(isset($instance['label'])) $label = esc_attr($instance['label']);
		if(isset($instance['description'])) $description = $instance['description'];
		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		if(isset($instance['intro_image_link'])) $intro_image_link = esc_attr($instance['intro_image_link']); 
		
		if(trim($label)=="") $label = __('more','ioa');
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
         <div class="ioa-upload-field ">
			<label for="<?php echo $this->get_field_id( 'intro_image_link' ); ?>"><?php _e('Intro Image Link: ( if empty image not will appear )', 'ioa') ?></label>
            	<div class="clearfix">
    	        	<a href="#" class="button image_upload" data-title="Add To Widget" data-label="Add To Widget"> <?php _e('Upload','ioa') ?> </a>
					<input class="widefat widget_text" id="<?php echo $this->get_field_id( 'intro_image_link' ); ?>" name="<?php echo $this->get_field_name( 'intro_image_link' ); ?>" value="<?php echo $intro_image_link; ?>" type="text" /> 
	            </div>
		</div>

		
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Text', 'ioa') ?></label>
			<textarea  class="widefat" style="height:200px;" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo  $description; ?></textarea>
		</p>
		
		 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Link:( if empty link will not appear )', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $link; ?>" type="text" />
		</p>
        
        <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e('Label for button', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" value="<?php echo $label; ?>" type="text" />
		</p>
		
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$link = esc_attr($instance['link']);
	$label = esc_attr($instance['label']);
	$description = $instance['description'];
	$title = esc_attr($instance['title']); 
	$intro_image_link = esc_attr($instance['intro_image_link']); 
	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
		
	if(trim($intro_image_link)=="")
	$img = '';
	else
	$img = "<img src='{$intro_image_link}' alt='custom-box-image' />";
		
	echo " <div class='clearfix custom-box-content' itemscope itemtype='http://schema.org/Text'> $img  ".do_shortcode(wpautop($description))." </div>  ";
		
	if(trim($link)!="")
	echo "<a href='{$link}' class='more custom-font thunder_button' itemprop='url'> $label </a>";
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("CustomBoxWidget");'));

// == Facebook Like ==========================================================


class FBLike extends WP_Widget {
	
	function FBLike() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'FBLike', 'description' => __('Add facebook Like box to your sidebar.','ioa') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200);
		 parent::__construct(false,__("Facebook Like Box",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['fb_link']= strip_tags($new_instance['fb_link']); 
			$instance['width']= strip_tags($new_instance['width']);
			$instance['title']= strip_tags($new_instance['title']);
			$instance['show_friends']= $new_instance['show_friends'];
			$instance['fb_header']= $new_instance['fb_header'];
			$instance['fb_stream']= $new_instance['fb_stream'];
			
			 
			return $instance;
	}
	function form($instance) {
		 $fb = $title = $width = $friends = $header = $stream = '';

		if(isset($instance['fb_link'])) $fb = esc_attr($instance['fb_link']);
		if(isset($instance['title'])) $title = esc_attr($instance['title']);
		if(isset($instance['width'])) $width = $instance['width'];
		if(isset($instance['show_friends'])) $friends = $instance['show_friends'];
		if(isset($instance['fb_header'])) $header = $instance['fb_header'];
		if(isset($instance['fb_stream'])) $stream = $instance['fb_stream'];
		
		if($fb==""&&get_option("ami_fb_id"))
		$fb = get_option("ami_fb_id");
		
		
		 ?>
        
        
		<p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        <p> 
        <label for="<?php echo $this->get_field_id('fb_link'); ?>"> <?php _e('Add facebook page link','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('fb_link'); ?>" name="<?php echo $this->get_field_name('fb_link'); ?>" type="text" value="<?php echo $fb; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('width'); ?>"> <?php _e('Width','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('show_friends'); ?>"> <?php _e('Show friends','ioa'); ?> </label>
		<input id="<?php echo $this->get_field_id('show_friends'); ?>" name="<?php echo $this->get_field_name('show_friends'); ?>" type="checkbox" value="true" <?php if($friends) echo "checked='checked'"; ?> />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('fb_header'); ?>"> <?php _e('Show Head','ioa'); ?> </label>
		<input id="<?php echo $this->get_field_id('fb_header'); ?>" name="<?php echo $this->get_field_name('fb_header'); ?>" type="checkbox" value="true" <?php if($header) echo "checked='checked'"; ?> />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('fb_stream'); ?>"> <?php _e('Show Stream','ioa'); ?> </label>
		<input id="<?php echo $this->get_field_id('fb_stream'); ?>" name="<?php echo $this->get_field_name('fb_stream'); ?>" type="checkbox" value="true" <?php if($stream) echo "checked='checked'"; ?> />
		</p>
        
        
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
		$fb = esc_attr($instance['fb_link']);
		$title = esc_attr($instance['title']);
		$width = $instance['width'];
		$friends = $instance['show_friends'];
		$header= $instance['fb_header'];
		$stream= $instance['fb_stream'];
	    
	    $height = 100;
	    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

	    if($friends=="true") $height +=200;
	    if($stream=="true") $height +=300;

		echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
		?>
		
       <div class="facebookOuter">
		<div class="facebookInner">
       		 <div class="fb-widget">
				<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $fb; ?>&amp;width=<?php echo $width; ?>&amp;height=<?php echo $height; ?>&amp;show_faces=<?php if($friends) echo $friends; else echo 'false'; ?>&amp;colorscheme=light&amp;stream=<?php if($stream) echo $stream; else echo 'false'; ?>&amp;border_color&amp;header=<?php if($header) echo $header; else echo 'false'; ?>&amp;appId=165111413574616"  style="border:none; overflow:hidden; width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;" ></iframe>
        	</div>
       </div> </div>
        
		<?php
			echo $after_widget; 
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("FBLike");'));

/* == Posts ================================================= */



class IOACustomPostW extends WP_Widget {
	
	function IOACustomPostW() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOACustomPostW', 'description' => __('Create and show custom posts or any filtered variation.','ioa') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200);
		 parent::__construct(false,__("Custom Posts",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['count']= strip_tags($new_instance['count']); 
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['post_type']= strip_tags($new_instance['post_type']); 
			$instance['post_filter']= strip_tags($new_instance['post_filter']); 
			$instance['excerpt']= strip_tags($new_instance['excerpt']); 
			return $instance;
	}
	function form($instance) {
		global $registered_posts;
		 $count = $title = $post_type = $post_filter = $excerpt = '';

		if(isset($instance['count'])) $count = esc_attr($instance['count']);
		if(isset($instance['title'])) $title = $instance['title'];
		if(isset($instance['post_type'])) $post_type = $instance['post_type'];	
		if(isset($instance['post_filter'])) $post_filter = $instance['post_filter'];	
		if(isset($instance['excerpt'])) $excerpt = $instance['excerpt'];	
	    $excerpt = trim($excerpt=="") ? 90 : $excerpt ;
		 ?>
        
        <div class="ioa-query-box clearfix"> 

        <p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('post_type'); ?>"> <?php _e('Post Type','ioa'); ?> </label>
		<select name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>" class='post_type'>
		 <?php 
		 $array = array("post");
		 foreach ($registered_posts as $cp) {
		 	if( $cp->getPostType()!="slider" &&  $cp->getPostType()!="custompost")
		 	$array[] = $cp->getPostType();
		 }
		 foreach($array as $val){
		 
		 if($val==$post_type)
		 echo "<option value='$val' selected>$val</option>";
		 else
		 echo "<option value='$val'>$val</option>";
		 
		 }
		 ?>
        </select>
		</p>
        
		 
        <label for="<?php echo $this->get_field_id('post_filter'); ?>"> <?php _e('Posts Filter','ioa'); ?> </label>
		
		<p class="clearfix">
			<input class="widefat" id="<?php echo $this->get_field_id('post_filter'); ?>" name="<?php echo $this->get_field_name('post_filter'); ?>" type="text" value="<?php echo $post_filter; ?>" />
			<a href="" class="query-maker button-default">Add Filter</a>
		</p>
		
		</div>
		
        
        
        <p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        
		<p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('count'); ?>"> <?php _e('Number of posts to display','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
		</p>
        
        <p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('excerpt'); ?>"> <?php _e('Enter excerpt Words Limit','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="text" value="<?php echo $excerpt; ?>" />
		</p>
		
           
       
        
        
<?php
		
		 }
	function widget($args, $instance) { 
	global $helper;
	global $more;
	extract($args); 
	$post_type = $instance['post_type'];	
	$post_filter = $instance['post_filter'];
	$excerpt = $instance['excerpt'];	
	$count = esc_attr($instance['count']);
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
	echo $before_widget;
	if($title!="")
	echo $before_title." ".$title.$after_title;
		
		?>

   <ul class="widget-posts clearfix" >
                          
    <?php 
   
    $qr = explode('&',$post_filter);
    $custom_tax = array(
                 array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                    'operator' => 'NOT IN'
                  ),

             );
     $filter = array();

     foreach($qr as $q)
     {
      if(trim($q)!="")
      {
        $temp = explode("=",$q);
        $filter[$temp[0]] = $temp[1];
        if($temp[0]=="tax_query")
        {
        	$vals = explode("|",$temp[1]); 	
        	$custom_tax[] = array(
        			'taxonomy' => $vals[0],
					'field' => 'id',
					'terms' => explode(",", $vals[1])

        		);
        }
      }
     }


		
    $ioa_options = array(
			
			'post_type' => $post_type, 
			'posts_per_page' => $count
			);
    $filter['tax_query'] = $custom_tax;
		
	
	$popPosts = new WP_Query(array_merge($ioa_options,$filter ));
	
	
	
	
    while ($popPosts->have_posts()) : $popPosts->the_post();  $more = 0; ?>
    
    <li class="clearfix <?php echo join(' ',get_post_class('', get_the_ID())); ?>" itemscope itemtype="http://schema.org/Article" >
    
     
      <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
      <div class="image">
      <?php 
            $id = get_post_thumbnail_id();
            $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
            echo $helper->imageDisplay( array( "src" => $ar[0]  , "width" => 50 , "height" => 38 , "link"=> get_permalink() , "lightbox" => false , "imgclass" => "thunder_image" , 'imageAttr' => 'alt="'.get_the_title().'"')  ); 
      ?>
      </div><!--image-->
      <?php endif; ?>
    
      <div class="description <?php if ( ! has_post_thumbnail() ) echo 'full-desc'; ?>">
          <h5 itemprop="title"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
         <p class='clearfix' itemprop="description"> <?php echo  $helper->getShortenContent($excerpt, strip_shortcodes(get_the_content())); ?></p>
         
      </div><!--details-->
    </li>
    
    <?php endwhile; ?>
    
    

    </ul>
					
					
		<?php
			echo $after_widget; 
		
		}
		
	
	
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOACustomPostW");'));



// == Dribbble =============================================


class Dribbbble extends WP_Widget {
	
	function Dribbbble() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Dribbbble', 'description' => __( 'Dribbble Widget.','ioa') );

		/* Widget control settings. */
		$control_ops = array( "width"=>200);
		 parent::__construct(false,__( "Dribbble Widget" ,'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['username']= strip_tags($new_instance['username']); 
		
			$instance['nos']= strip_tags($new_instance['nos']); 
			return $instance;
	}
	function form($instance) {
		 $title = $username = $nos = '';

		if(isset($instance['title'])) $title = esc_attr($instance['title']);
		if(isset($instance['username'])) $username = esc_attr($instance['username']);
	  
		if(isset($instance['nos'])) $nos = esc_attr($instance['nos']);
		 ?>
        
       
		<p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        <p> 
        <label for="<?php echo $this->get_field_id('username'); ?>"> <?php _e('Username','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" />
		</p>
     
        <p> 
        <label for="<?php echo $this->get_field_id('nos'); ?>"> <?php _e('Number of Photos','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('nos'); ?>" name="<?php echo $this->get_field_name('nos'); ?>" type="text" value="<?php echo $nos; ?>" />
		</p>
     
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$username = esc_attr($instance['username']);
	 
	$count = esc_attr($instance['nos']);
	
	
	
		echo $before_widget; 
		
			if($title!="")
		echo $before_title." ".$title.$after_title;
		
		$data = wp_remote_get('http://api.dribbble.com/players/'.$username.'/shots');
		
		$data = json_decode($data['body'],true);

	if(isset($data['message']) && $data['message'] =="Not found" )
	{
		_e("Something's Wrong",'ioa');
	}
	else {
	$shots = "<div class='dribble_widget_media clearfix' itemscope itemtype='http://schema.org/ImageGallery'>";
	$i=0;

	if(isset($data['shots']) && is_array($data['shots']) )
	foreach($data['shots'] as $shot)
	{
		if($i>=$count) break;
		$shots = $shots . "<a itemprop='url' href='".$shot['url']."' title='".$shot['title']."'><img src='".$shot['image_url']."' /></a>";
		$i++;
	}
	
	echo $shots."</div>";
	}
		echo $after_widget; 
		
		}
	
	


	}

add_action('widgets_init', create_function('', 'return
register_widget("Dribbbble");'));

// == Social Set ========================================================

class SocialSet extends WP_Widget {
	
	function SocialSet() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'SocialSet', 'description' => __('Creates a list with popular social sites.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::__construct(false,__("SocialSet",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['title']= $new_instance['title']; 
		    
			$instance['f500px']= $new_instance['f500px']; 
			$instance['aim']= $new_instance['aim']; 
			$instance['android']= $new_instance['android']; 
			$instance['badoo']= $new_instance['badoo']; 
			
			$instance['dailybooth']= $new_instance['dailybooth']; 
			$instance['dribbble']= $new_instance['dribbble']; 
			$instance['email']= $new_instance['email']; 
			$instance['foursquare']= $new_instance['foursquare']; 
			
			$instance['github']= $new_instance['github']; 
			$instance['google']= $new_instance['google']; 
			$instance['Hipstamatic']= $new_instance['Hipstamatic']; 
			$instance['icq']= $new_instance['icq']; 
			
			$instance['instagram']= $new_instance['instagram']; 
			$instance['lastfm']= $new_instance['lastfm']; 
			$instance['linkedin']= $new_instance['linkedin']; 
			$instance['path']= $new_instance['path']; 
			
			$instance['picasa']= $new_instance['picasa']; 
			$instance['pininterest']= $new_instance['pininterest']; 
			$instance['quora']= $new_instance['quora']; 
			$instance['rdio']= $new_instance['rdio']; 
			
			$instance['rss']= $new_instance['rss']; 
			$instance['skype']= $new_instance['skype']; 
			$instance['reddit']= $new_instance['reddit']; 
			$instance['spotify']= $new_instance['spotify']; 
			
			$instance['thefancy']= $new_instance['thefancy']; 
			$instance['tumblr']= $new_instance['tumblr']; 
			$instance['twitter']= $new_instance['twitter']; 
			$instance['vimeo']= $new_instance['vimeo']; 
			
			$instance['zerply']= $new_instance['zerply']; 
			$instance['YouTube']= $new_instance['YouTube']; 
			$instance['Xbox']= $new_instance['Xbox']; 
			$instance['facebook']= $new_instance['facebook']; 
	
			
			
			return $instance;
	}
	function form($instance) {
	
	$title = $f500px = $aim = $android = $badoo = $dailybooth = $dribbble = $email  = $foursquare = $github = $google = $Hipstamatic = $icq = $instagram = $lastfm = $linkedin = $path = $picasa = $pininterest = $quora = $rdio = $rss = $skype = $reddit = $spotify = $thefancy = $tumblr = $twitter = $vimeo = $Xbox = $YouTube = $zerply = $facebook = '';

	
	if(isset($instance['title'])) $title = esc_attr($instance['title']);
		
	if(isset($instance['f500px'])) $f500px = esc_attr($instance['f500px']);
	if(isset($instance['aim'])) $aim = esc_attr($instance['aim']);
	if(isset($instance['android'])) $android = esc_attr($instance['android']);
	if(isset($instance['badoo'])) $badoo = esc_attr($instance['badoo']);
	
	if(isset($instance['dailybooth'])) $dailybooth = esc_attr($instance['dailybooth']);
	if(isset($instance['dribbble'])) $dribbble = esc_attr($instance['dribbble']);
	if(isset($instance['email'])) $email = esc_attr($instance['email']);
	if(isset($instance['foursquare'])) $foursquare = esc_attr($instance['foursquare']);
	
	if(isset($instance['github'])) $github = esc_attr($instance['github']);
	if(isset($instance['google'])) $google = esc_attr($instance['google']);
	if(isset($instance['Hipstamatic'])) $Hipstamatic = esc_attr($instance['Hipstamatic']);
	if(isset($instance['icq'])) $icq = esc_attr($instance['icq']);
	
	if(isset($instance['instagram'])) $instagram = esc_attr($instance['instagram']);
	if(isset($instance['lastfm'])) $lastfm = esc_attr($instance['lastfm']);
	if(isset($instance['linkedin'])) $linkedin = esc_attr($instance['linkedin']);
	if(isset($instance['path'])) $path = esc_attr($instance['path']);
	
	if(isset($instance['picasa'])) $picasa = esc_attr($instance['picasa']);
	if(isset($instance['pininterest']))  $pininterest = esc_attr($instance['pininterest']);
	if(isset($instance['quora'])) $quora = esc_attr($instance['quora']);
	if(isset($instance['rdio'])) $rdio = esc_attr($instance['rdio']);
	
	if(isset($instance['rss'])) $rss = esc_attr($instance['rss']);
	if(isset($instance['skype'])) $skype = esc_attr($instance['skype']);
	if(isset($instance['reddit'])) $reddit = esc_attr($instance['reddit']);
	if(isset($instance['spotify'])) $spotify = esc_attr($instance['spotify']);
	
	if(isset($instance['thefancy'])) $thefancy = esc_attr($instance['thefancy']);
	if(isset($instance['tumblr'])) $tumblr = esc_attr($instance['tumblr']);
	if(isset($instance['twitter'])) $twitter = esc_attr($instance['twitter']);
	if(isset($instance['vimeo'])) $vimeo = esc_attr($instance['vimeo']);
	
	if(isset($instance['Xbox'])) $Xbox = esc_attr($instance['Xbox']);
	if(isset($instance['YouTube'])) $YouTube = esc_attr($instance['YouTube']);
	if(isset($instance['zerply'])) $zerply = esc_attr($instance['zerply']);
	if(isset($instance['facebook'])) 	$facebook = esc_attr($instance['facebook']);
			
		?>
    
       
       	 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" />
		</p>
        
 
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'f500px' ); ?>"><?php _e('Enter your 500px Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'f500px' ); ?>" name="<?php echo $this->get_field_name( 'f500px' ); ?>" value="<?php echo $f500px; ?>" />
		</p>
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'aim' ); ?>"><?php _e('Enter your aim Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'aim' ); ?>" name="<?php echo $this->get_field_name( 'aim' ); ?>" value="<?php echo $aim; ?>" />
		</p>
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'android' ); ?>"><?php _e('Enter your android Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'android' ); ?>" name="<?php echo $this->get_field_name( 'android' ); ?>" value="<?php echo $android; ?>" />
		</p>
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'badoo' ); ?>"><?php _e('Enter your badoo Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'badoo' ); ?>" name="<?php echo $this->get_field_name( 'badoo' ); ?>" value="<?php echo $badoo; ?>" />
		</p>
        
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'dailybooth' ); ?>"><?php _e('Enter your dailybooth Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'dailybooth' ); ?>" name="<?php echo $this->get_field_name( 'dailybooth' ); ?>" value="<?php echo $dailybooth; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'dribbble' ); ?>"><?php _e('Enter your dribbble Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo $dribbble; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Enter your email Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $email; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'foursquare' ); ?>"><?php _e('Enter your foursquare Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'foursquare' ); ?>" name="<?php echo $this->get_field_name( 'foursquare' ); ?>" value="<?php echo $foursquare; ?>" />
    </p>
      <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'github' ); ?>"><?php _e('Enter your github Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" value="<?php echo $github; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'google' ); ?>"><?php _e('Enter your google Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'google' ); ?>" name="<?php echo $this->get_field_name( 'google' ); ?>" value="<?php echo $google; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'Hipstamatic' ); ?>"><?php _e('Enter your Hipstamatic Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'Hipstamatic' ); ?>" name="<?php echo $this->get_field_name( 'Hipstamatic' ); ?>" value="<?php echo $Hipstamatic; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'icq' ); ?>"><?php _e('Enter your icq Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'icq' ); ?>" name="<?php echo $this->get_field_name( 'icq' ); ?>" value="<?php echo $icq; ?>" />
    </p>
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e('Enter your instagram Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" value="<?php echo $instagram; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'lastfm' ); ?>"><?php _e('Enter your lastfm Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'lastfm' ); ?>" name="<?php echo $this->get_field_name( 'lastfm' ); ?>" value="<?php echo $lastfm; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('Enter your linkedin Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $linkedin; ?>" />
    </p>
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'path' ); ?>"><?php _e('Enter your path Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'path' ); ?>" name="<?php echo $this->get_field_name( 'path' ); ?>" value="<?php echo $path; ?>" />
    </p>
     
     
     <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'picasa' ); ?>"><?php _e('Enter your picasa Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'picasa' ); ?>" name="<?php echo $this->get_field_name( 'picasa' ); ?>" value="<?php echo $picasa; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'pininterest' ); ?>"><?php _e('Enter your pininterest Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'pininterest' ); ?>" name="<?php echo $this->get_field_name( 'pininterest' ); ?>" value="<?php echo $pininterest; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'quora' ); ?>"><?php _e('Enter your quora Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'quora' ); ?>" name="<?php echo $this->get_field_name( 'quora' ); ?>" value="<?php echo $quora; ?>" />
    </p>
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'rdio' ); ?>"><?php _e('Enter your rdio Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rdio' ); ?>" name="<?php echo $this->get_field_name( 'rdio' ); ?>" value="<?php echo $rdio; ?>" />
    </p>
    
     
     
      <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e('Enter your rss Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="<?php echo $rss; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e('Enter your skype Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" value="<?php echo $skype; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'reddit' ); ?>"><?php _e('Enter your reddit Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'reddit' ); ?>" name="<?php echo $this->get_field_name( 'reddit' ); ?>" value="<?php echo $reddit; ?>" />
    </p>
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'spotify' ); ?>"><?php _e('Enter your spotify Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'spotify' ); ?>" name="<?php echo $this->get_field_name( 'spotify' ); ?>" value="<?php echo $spotify; ?>" />
    </p>
    
     <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'thefancy' ); ?>"><?php _e('Enter your thefancy Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'thefancy' ); ?>" name="<?php echo $this->get_field_name( 'thefancy' ); ?>" value="<?php echo $thefancy; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'tumblr' ); ?>"><?php _e('Enter your tumblr Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" value="<?php echo $tumblr; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Enter your twitter Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $twitter; ?>" />
    </p>
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e('Enter your vimeo Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" value="<?php echo $vimeo; ?>" />
    </p>  
    
    
     <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'Xbox' ); ?>"><?php _e('Enter your Xbox Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'Xbox' ); ?>" name="<?php echo $this->get_field_name( 'Xbox' ); ?>" value="<?php echo $Xbox; ?>" />
    </p>
    
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'YouTube' ); ?>"><?php _e('Enter your YouTube Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'YouTube' ); ?>" name="<?php echo $this->get_field_name( 'YouTube' ); ?>" value="<?php echo $YouTube; ?>" />
    </p>
    <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'zerply' ); ?>"><?php _e('Enter your zerply Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'zerply' ); ?>" name="<?php echo $this->get_field_name( 'zerply' ); ?>" value="<?php echo $zerply; ?>" />
    </p> 
     <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Enter your facebook Profile link:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $facebook; ?>" />
    </p> 
        <?php
 
 
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$title = esc_attr($instance['title']);

	$f500px = esc_attr($instance['f500px']);
	$aim = esc_attr($instance['aim']);
	$android = esc_attr($instance['android']);
	$badoo = esc_attr($instance['badoo']);
	
	$dailybooth = esc_attr($instance['dailybooth']);
	$dribbble = esc_attr($instance['dribbble']);
	$email = esc_attr($instance['email']);
	$foursquare = esc_attr($instance['foursquare']);
	
	$github = esc_attr($instance['github']);
	$google = esc_attr($instance['google']);
	$Hipstamatic = esc_attr($instance['Hipstamatic']);
	$icq = esc_attr($instance['icq']);
	
	$instagram = esc_attr($instance['instagram']);
	$lastfm = esc_attr($instance['lastfm']);
	$linkedin = esc_attr($instance['linkedin']);
	$path = esc_attr($instance['path']);
	
	$picasa = esc_attr($instance['picasa']);
	$pininterest = esc_attr($instance['pininterest']);
	$quora = esc_attr($instance['quora']);
	$rdio = esc_attr($instance['rdio']);
	
	$rss = esc_attr($instance['rss']);
	$skype = esc_attr($instance['skype']);
	$reddit = esc_attr($instance['reddit']);
	$spotify = esc_attr($instance['spotify']);
	
	$thefancy = esc_attr($instance['thefancy']);
	$tumblr = esc_attr($instance['tumblr']);
	$twitter = esc_attr($instance['twitter']);
	$vimeo = esc_attr($instance['vimeo']);
	
	$Xbox = esc_attr($instance['Xbox']);
	$YouTube = esc_attr($instance['YouTube']);
	$zerply = esc_attr($instance['zerply']);
	$facebook = esc_attr($instance['facebook']);
	
	
	echo $before_widget;
	if($title!="")
		echo $before_title." ".$title .$after_title;
	?>
	
    
    <div class="social-set clearfix">
        <ul class="social-icons clearfix">
        	
			<?php if($f500px!="") : ?><li><a href="<?php echo $f500px ?>" ><img src="<?php echo URL."/sprites/i/si/500px-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($aim!="") : ?><li><a href="<?php echo $aim ?>" ><img src="<?php echo URL."/sprites/i/si/aim-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($android!="") : ?><li><a href="<?php echo $android ?>" ><img src="<?php echo URL."/sprites/i/si/android-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($badoo!="") : ?><li><a href="<?php echo $badoo ?>" ><img src="<?php echo URL."/sprites/i/si/badoo-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            
            
            <?php if($dailybooth!="") : ?><li><a href="<?php echo $dailybooth ?>" ><img src="<?php echo URL."/sprites/i/si/dailybooth-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($dribbble!="") : ?><li><a href="<?php echo $dribbble ?>" ><img src="<?php echo URL."/sprites/i/si/dribbble-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($email!="") : ?><li><a href="<?php echo $email ?>" ><img src="<?php echo URL."/sprites/i/si/email-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($foursquare!="") : ?><li><a href="<?php echo $foursquare ?>" ><img src="<?php echo URL."/sprites/i/si/foursquare-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            
            
            <?php if($github!="") : ?><li><a href="<?php echo $github ?>" ><img src="<?php echo URL."/sprites/i/si/github-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($google!="") : ?><li><a href="<?php echo $google ?>" ><img src="<?php echo URL."/sprites/i/si/google+-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($Hipstamatic!="") : ?><li><a href="<?php echo $Hipstamatic ?>" ><img src="<?php echo URL."/sprites/i/si/Hipstamatic-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($icq!="") : ?><li><a href="<?php echo $icq ?>" ><img src="<?php echo URL."/sprites/i/si/icq-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            
            
            <?php if($instagram!="") : ?><li><a href="<?php echo $instagram ?>" ><img src="<?php echo URL."/sprites/i/si/instagram-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($lastfm!="") : ?><li><a href="<?php echo $lastfm ?>" ><img src="<?php echo URL."/sprites/i/si/lastfm-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($linkedin!="") : ?><li><a href="<?php echo $linkedin ?>" ><img src="<?php echo URL."/sprites/i/si/linkedin-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($path!="") : ?><li><a href="<?php echo $path ?>" ><img src="<?php echo URL."/sprites/i/si/path-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            
            <?php if($picasa!="") : ?><li><a href="<?php echo $picasa ?>" ><img src="<?php echo URL."/sprites/i/si/picasa-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($pininterest!="") : ?><li><a href="<?php echo $pininterest ?>" ><img src="<?php echo URL."/sprites/i/si/pinterest-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($quora!="") : ?><li><a href="<?php echo $quora ?>" ><img src="<?php echo URL."/sprites/i/si/quora-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($rdio!="") : ?><li><a href="<?php echo $rdio ?>" ><img src="<?php echo URL."/sprites/i/si/rdio-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            
            <?php if($rss!="") : ?><li><a href="<?php echo $rss ?>" ><img src="<?php echo URL."/sprites/i/si/rss-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($skype!="") : ?><li><a href="<?php echo $skype ?>" ><img src="<?php echo URL."/sprites/i/si/skype-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($reddit!="") : ?><li><a href="<?php echo $reddit ?>" ><img src="<?php echo URL."/sprites/i/si/reddit-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($spotify!="") : ?><li><a href="<?php echo $spotify ?>" ><img src="<?php echo URL."/sprites/i/si/spotify-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            
            <?php if($thefancy!="") : ?><li><a href="<?php echo $thefancy ?>" ><img src="<?php echo URL."/sprites/i/si/thefancy-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($tumblr!="") : ?><li><a href="<?php echo $tumblr ?>" ><img src="<?php echo URL."/sprites/i/si/tumblr-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($twitter!="") : ?><li><a href="<?php echo $twitter ?>" ><img src="<?php echo URL."/sprites/i/si/twitter-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($vimeo!="") : ?><li><a href="<?php echo $vimeo ?>" ><img src="<?php echo URL."/sprites/i/si/vimeo-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            
            <?php if($Xbox!="") : ?><li><a href="<?php echo $Xbox ?>" ><img src="<?php echo URL."/sprites/i/si/Xbox-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($YouTube!="") : ?><li><a href="<?php echo $YouTube ?>" ><img src="<?php echo URL."/sprites/i/si/YouTube-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($zerply!="") : ?><li><a href="<?php echo $zerply ?>" ><img src="<?php echo URL."/sprites/i/si/zerply-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            <?php if($facebook!="") : ?><li><a href="<?php echo $facebook ?>" ><img src="<?php echo URL."/sprites/i/si/facebook-32.png"; ?>" alt='social icon' /></a></li><?php endif; ?>
            
            
        
        </ul>
    </div>
	
	<?php
	
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("SocialSet");'));


// == Video Box ============================

class VideoBox extends WP_Widget {
	
	function VideoBox() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Video', 'description' => __(' Add youtube/vimeo/html5 to widget areas.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::__construct(false,__("VideoBox",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['link']= $new_instance['link']; 
			$instance['description']= $new_instance['description'];
			$instance['title']= strip_tags($new_instance['title']);
			$instance['type']= strip_tags($new_instance['type']);
			$instance['intro_image_link']= strip_tags($new_instance['intro_image_link']);
			return $instance;
	}
	function form($instance) {
		$link = $label = $description = $title = $intro_image_link = '';

		if(isset($instance['link'])) $link = esc_attr($instance['link']);
		if(isset($instance['description'])) $description = $instance['description'];
		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		if(isset($instance['type'])) $type = esc_attr($instance['type']); 
		
		if(trim($label)=="") $label = 'more &rarr;';
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
         <p class="">
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('type:', 'ioa') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" >
				<?php $opts = array("YouTube","Vimeo"); 
				$str = '';
				foreach($opts as $o)
				{
					if($type==$o)
						$str .= "<option selected='selected' value='{$o}'>$o</option>";
					else
						$str .= "<option value='{$o}'>$o</option>";
				}
				echo $str;
				?>
			</select>
		</p>

		
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Text', 'ioa') ?></label>
			<textarea  class="widefat" style="height:200px;" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo  $description; ?></textarea>
		</p>
		
		 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Video Link', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $link; ?>" type="text" />
		</p>
     
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$link = esc_attr($instance['link']);
	$description = $instance['description'];
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$type = esc_attr($instance['type']); 
	
	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title."<div class='video-wrap' itemscope itemtype='http://schema.org/VideoObject'>";
		
	switch($type)
	{
		case "YouTube" :
		case "Vimeo" : echo do_shortcode("[video width='250' height='250']{$link}[/video]");
	}	
	echo " <p class='clearfix caption' itemprop='description'>   ".stripslashes($description)." </p> </div> ";
		
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("VideoBox");'));


// == Image Box ============================

class ImageBox extends WP_Widget {
	
	function ImageBox() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ImageBox', 'description' => __(' Add images to widget areas.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::__construct(false,__("ImageBox",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['link']= $new_instance['link']; 
			$instance['description']= $new_instance['description'];
			$instance['resize']= $new_instance['resize'];
			$instance['title']= strip_tags($new_instance['title']);
			$instance['intro_image_link']= strip_tags($new_instance['intro_image_link']);
			return $instance;
	}
	function form($instance) {
		$link = $label = $description = $title = $intro_image_link = '';

		if(isset($instance['link'])) $link = esc_attr($instance['link']);
		if(isset($instance['description'])) $description = $instance['description'];
		if(isset($instance['resize'])) $resize = $instance['resize'];
		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		if(isset($instance['intro_image_link'])) $intro_image_link = esc_attr($instance['intro_image_link']); 
		
		if(trim($label)=="") $label = 'more &rarr;';
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
       

		<p class="">
			<label for="<?php echo $this->get_field_id( 'resize' ); ?>"><?php _e('resize:', 'ioa') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'resize' ); ?>" name="<?php echo $this->get_field_name( 'resize' ); ?>" >
				<?php $opts = array("Yes","No"); 
				$str = '';
				foreach($opts as $o)
				{
					if($resize==$o)
						$str .= "<option selected='selected' value='{$o}'>$o</option>";
					else
						$str .= "<option value='{$o}'>$o</option>";
				}
				echo $str;
				?>
			</select>
		</p>
		
		<div class="ioa-upload-field ">
			<label for="<?php echo $this->get_field_id( 'intro_image_link' ); ?>"><?php _e(' Image URL: ( Ideal size 250 x 300 px )', 'ioa') ?></label>
            	<div class="clearfix">
    	        	<a href="#" class="button image_upload" data-title="Add To Widget" data-label="Add To Widget"> <?php _e('Upload','ioa') ?> </a>
					<input class="widefat widget_text" id="<?php echo $this->get_field_id( 'intro_image_link' ); ?>" name="<?php echo $this->get_field_name( 'intro_image_link' ); ?>" value="<?php echo $intro_image_link; ?>" type="text" /> 
	            </div>
		</div>

		
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Text', 'ioa') ?></label>
			<textarea  class="widefat" style="height:200px;" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo  $description; ?></textarea>
		</p>
		
		 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e(' Link', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $link; ?>" type="text" />
		</p>
     
<?php
		
		 }
	function widget($args, $instance) { 
	global $helper;
	extract($args); 
	
	$link = esc_attr($instance['link']);
	$description = $instance['description'];
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$resize = $instance['resize'];
	$intro_image_link = esc_attr($instance['intro_image_link']); 
	$pw  = true;
	if($link=="") $pw = false;

	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;

	echo "<div class='ioa-image-wrap' itemscope itemtype='http://schema.org/ImageObject'>";
	
	$str = '';

	switch($resize)
	{
		case "Yes" : echo $helper->imageDisplay( array( "width" =>270 , "height" => 270 , "link" => $link , "parent_wrap" => $pw , "src" => $intro_image_link ) ); break;
		case "No" :  $str = "<img src='".$intro_image_link."' alt='sidebar image' itemprop='image' />"; 
					 if($pw) echo "<a href='".$link."'>".$str."</a>";
					 else echo $str;
	}	
	echo " <p class='clearfix caption' itemprop='description'>   ".stripslashes($description)." </p> </div> ";
		
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("ImageBox");'));


// == Testimonial Box ============================

class Testimonial extends WP_Widget {
	
	function Testimonial() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Testimonial', 'description' => __(' Add Single Testimonial Here.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::__construct(false,__("Testimonial",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['title']= strip_tags($new_instance['title']);
			$instance['tid']= strip_tags($new_instance['tid']);
			return $instance;
	}
	function form($instance) {
		 $title = $tid = '';

		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		if(isset($instance['tid'])) $tid = esc_attr($instance['tid']); 
		

		$query = new WP_Query("post_type=testimonial&posts_per_page=-1&post_status=publish");  
		$testi = array();
		while ($query->have_posts()) : $query->the_post(); 
				$testi[get_the_ID()] = get_the_title();
		endwhile; 


		
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
       

		
		 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'tid' ); ?>"><?php _e('Testimonial ID', 'ioa') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'tid' ); ?>" name="<?php echo $this->get_field_name( 'tid' ); ?>">
				<?php 
				foreach($testi as $key => $val){
		 
					 if($key==$tid)
					 echo "<option value='$key' selected>$val</option>";
					 else
					 echo "<option value='$key'>$val</option>";
					 
					 }
				 ?>
			</select>	
		</p>
     
<?php
		
		 }
	function widget($args, $instance) { 
	global $helper;
	extract($args); 
	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$tid = esc_attr($instance['tid']); 
	

	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
	
	?>

	  <div class="testimonial-bubble" itemscope itemtype='http://schema.org/Review'>
       <?php  if(isset($tid)) : $tpost = get_post($tid);
         $dbg = '' ; $dc = '';

         $ioa_options = get_post_meta( $tid, 'ioa_options', true );
		if($ioa_options =="")  $ioa_options = array();


         if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
			if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];

			if( $tpost) :
          ?> 
           
           <div class="testimonial-bubble-content" itemprop='review' style='color:<?php echo $dc; ?>;background-color:<?php echo $dbg; ?>'>
              <?php echo $tpost->post_content  ?>
                 <i class="icon icon-caret-down" style='color:<?php echo $dbg; ?>'></i>
           </div> 

           <div class="testimonial-bubble-meta clearfix">
             
                <?php   if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail($tid)))  : ?>   
              
                <div class="image">
                  
                  <?php
                  $id = get_post_thumbnail_id($tid);
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                  echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>50 , "width" =>50 , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  ?>
              </div>

            <?php endif;
              ?>

              <div class="info">
                      <h2 class="name" itemprop="author"> <?php echo get_the_title($tid); ?></h2> 
                      <?php  if(get_post_meta($tid,'design',true)!="")  echo "<span class='designation'>".get_post_meta($tid,'design',true)."</span>" ?>
                    </div>
                    
              </div>

        <?php endif; endif; ?>
    </div>

    <?php
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("Testimonial");'));


class Testimonial_Slider extends WP_Widget {
	
	function Testimonial_Slider() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Testimonial Slider', 'description' => __(' Add Testimonials Slider Here.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::__construct(false,__("Testimonial Slider",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['title']= strip_tags($new_instance['title']);
			return $instance;
	}
	function form($instance) {
		 $title = $tid = '';

		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
     

     
<?php
		
		 }
	function widget($args, $instance) { 
	global $helper;
	extract($args); 
	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	

	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
	
	$opts = array('posts_per_page' => -1,'post_type'=>'testimonial', 'order' => "DESC" , 'orderby' => 'date');
	?>
	 <div class="testimonials-wrapper">	
	 <ul class="rad-testimonials-list clearfix"   itemscope itemtype="http://schema.org/Review">          
        <?php $query = new WP_Query($opts); $ioa_meta_data['i']=0;   $i=0;while ($query->have_posts()) : $query->the_post(); 
       $dbg = '' ; $dc = '';

         $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
		if($ioa_options =="")  $ioa_options = array();


         if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
			if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
          ?> 
       <?php  
      
     	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
          
        <li class="clearfix <?php if($i==0) echo 'active'; ?>" style="border:none">
				<div class="desc">
        	        <div class="content clearfix" itemprop="description" style='color:<?php echo $dc; ?>;background-color:<?php echo $dbg; ?>'>
 					      	<i class="icon icon-sort-down" style='color:<?php echo $dbg; ?>'></i>
                      		<?php the_content() ?>
                  	</div>
           		</div>
           		
                <div class="clearfix">
                <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
               	 <div class="image">
                  
                  <?php
                  $id = get_post_thumbnail_id();
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                  echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>50 , "width" => 50 , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  ?>
                </div>

           	     <?php endif;   ?>

               <div class="info">
                      <h2 class="name" itemprop="name"> <?php the_title(); ?></h2> 
                      <?php  if(get_post_meta(get_the_ID(),'design',true)!="")  echo "<span class='designation'>".get_post_meta(get_the_ID(),'design',true)."</span>" ?>
                    </div>
                    
              </div>
              
                 
               
        </li>

        <?php $i++; endwhile; ?>
    </ul>
	</div> 
    <?php
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("Testimonial_Slider");'));

/**
 * Adsense Widget
 */



class IOAAdsense extends WP_Widget {
	
	function IOAAdsense() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOAAdsense', 'description' => __(' Create a adsense code area.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::__construct(false,__("Ad Adsense",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['google_ad_client']= $new_instance['google_ad_client'];
			$instance['google_ad_slot']= $new_instance['google_ad_slot'];
			$instance['width']= $new_instance['width'];
			$instance['height']= $new_instance['height'];
			$instance['title']= strip_tags($new_instance['title']);
			
			return $instance;
	}
	function form($instance) {
		$google_ad_slot = $google_ad_client = $title = '';

		if(isset($instance['google_ad_client'])) $google_ad_client = $instance['google_ad_client'];
		if(isset($instance['google_ad_slot'])) $google_ad_slot = $instance['google_ad_slot'];
		if(isset($instance['width'])) $width = $instance['width'];
		if(isset($instance['height'])) $height = $instance['height'];
		if(isset($instance['title'])) $title = esc_attr($instance['title']); 

		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
    

		
		<p>
			<label for="<?php echo $this->get_field_id( 'google_ad_client' ); ?>"><?php _e('Enter Google Ad Client', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'google_ad_client' ); ?>" name="<?php echo $this->get_field_name( 'google_ad_client' ); ?>" value="<?php echo $google_ad_client; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'google_ad_slot' ); ?>"><?php _e('Enter Google Ad Slot', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'google_ad_slot' ); ?>" name="<?php echo $this->get_field_name( 'google_ad_slot' ); ?>" value="<?php echo $google_ad_slot; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Enter Ad Width', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $width; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Enter Ad Height', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $height; ?>" type="text" />
		</p>
		
		
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$google_ad_client = $instance['google_ad_client'];
	$google_ad_slot = $instance['google_ad_slot'];
	$height = $instance['height'];
	$width = $instance['width'];
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	
	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
		
		
	echo " <div class='clearfix custom-box-content' itemscope itemtype='http://schema.org/Text'>  "
	?>
	<script type="text/javascript"><!--
	google_ad_client = "<?php echo $google_ad_client; ?>"; 
	google_ad_slot = "<?php echo $google_ad_slot; ?>"; 
	google_ad_width = <?php echo $width; ?>;
	google_ad_height = <?php echo $height; ?>;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	<?php

	echo " </div>  ";
		

		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOAAdsense");'));




class Flickr extends WP_Widget {

	function Flickr() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Flickr', 'description' => __( 'Flickr Widget.','h-framework') );

		/* Widget control settings. */
		$control_ops = array( "width"=>200);
		 parent::__construct(false,__( "Flickr Widget" ,'h-framework'),$widget_ops,$control_ops); }

	function update($new_instance, $old_instance) {
			$instance = $old_instance;

			$instance['title']= strip_tags($new_instance['title']);
			$instance['username']= strip_tags($new_instance['username']);
			$instance['api_key']= strip_tags($new_instance['api_key']);
			$instance['nos']= strip_tags($new_instance['nos']);
			return $instance;
	}
	function form($instance) {
		 $title = $username = $api_key = $nos= '';

		if(isset($instance['title'])) $title = esc_attr($instance['title']);
		if(isset($instance['username'])) $username = esc_attr($instance['username']);
	    if(isset($instance['api_key'])) $api_key = esc_attr($instance['api_key']);
		if(isset($instance['nos'])) $nos = esc_attr($instance['nos']);
		 ?>


		<p class="hades-custom">
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

        <p>
        <label for="<?php echo $this->get_field_id('username'); ?>"> <?php _e('Username','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" />
		</p>

         <p>
        <label for="<?php echo $this->get_field_id('api_key'); ?>"> <?php _e('API KEY(get your key at <strong>http://www.flickr.com/services/api/misc.api_keys.html</strong>)','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('api_key'); ?>" name="<?php echo $this->get_field_name('api_key'); ?>" type="text" value="<?php echo $api_key; ?>" />
		</p>

        <p>
        <label for="<?php echo $this->get_field_id('nos'); ?>"> <?php _e('Number of Photos','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('nos'); ?>" name="<?php echo $this->get_field_name('nos'); ?>" type="text" value="<?php echo $nos; ?>" />
		</p>

<?php

		 }
	function widget($args, $instance) {

	extract($args);

	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$username = esc_attr($instance['username']);
	    $api_key = esc_attr($instance['api_key']);
	$nos = esc_attr($instance['nos']);



		echo $before_widget;
		 include(HPATH."/lib/phpFlickr.php");
			if($title!="")
		echo $before_title." ".$title.$after_title;


	 if(!$api_key) { echo '<h4> No API KEY ADDED </h4>'; } else {

  $f = new phpFlickr($api_key);
  $person = $f->people_findByUsername($username);
  $photos_url = $f->urls_getUserPhotos($person['id']);
  $photos = $f->people_getPublicPhotos($person['id'], NULL, NULL, 16);
		?>
        <div class="flickr-pictures clearfix">
        <?php
		$i=0;
         foreach ((array)$photos['photos']['photo'] as $photo) {

		  if($i>=$nos) break;

		  $theImageSrc = $f->buildPhotoURL($photo, "thumbnail");
		  $lb = $f->buildPhotoURL($photo, "large");

    	  echo "<a href='".($lb)."' class='lightbox' rel='prettyPhoto[pp_gal]' title='$photo[title]' ><img src='".($theImageSrc)."' alt=\"".$photos_url.$photo["id"]."\" title='' /></a>";
		  $i++;
  		}

  ?>
        </div>



        <?php
	 }

		echo $after_widget;

		}




	}

add_action('widgets_init', create_function('', 'return
register_widget("Flickr");'));