<?php 


/**
 * Twitter Shortcode using aouth
 */

function IOAgetTweets($count = 20, $username = false, $ioa_options = false) {
 global $super_options;	

  require_once(HPATH.'/lib/twitteroauth/twitteroauth.php');
 
  
  $settings = array(
    'oauth_access_token' => $super_options[SN.'_twitter_token'],
    'oauth_access_token_secret' => $super_options[SN.'_twitter_secret_token'],
    'consumer_key' => $super_options[SN.'_twitter_key'],
    'consumer_secret' => $super_options[SN.'_twitter_secret_key']
  );
  $data =array();

  if( get_transient(SN.'_ioa_tweets') ) 
  {
     $data = get_transient(SN.'_ioa_tweets');
  }
  else
  {
    $connection = new TwitterOAuth($super_options[SN.'_twitter_key'],  $super_options[SN.'_twitter_secret_key'], $super_options[SN.'_twitter_token'], $super_options[SN.'_twitter_secret_token']);
    $data = $connection->get('statuses/user_timeline');
    set_transient(SN.'_ioa_tweets',$data,60*60*3);
  }
 
    $i=0;
    $filter_array = array();
   if( ! isset($data->errors) )
    foreach($data as $d)
    {
     
     if($i>$count) break;
     $filter_array[] = array("text" => $d->text );
     $i++;
    }
   
    return $filter_array;
  }

  function ioa_twitter_shortcode($atts,$content)
{
	global $helper;
   	
   	extract(
	shortcode_atts(array(  
    "mode" => "list"  , 
		"count" => "5"
		
    ), $atts)); 

   	if($count <=0 ) $count  = 5; // Validation

    $tweets = IOAgetTweets($count);
    
     
    if(isset($tweets['error'])) return '<h4>'.$tweets['error'].'</h4>';
		$str = '<div class="tweets-wrapper '.$mode.'"><ul class="tweets clearfix ">';
		if(is_array($tweets))
		{
			foreach ($tweets as $key => $tweet) {

				$str .= "<li class='clearfix'><i class=\"twitter-1icon- ioa-front-icon\"></i>".preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>',$tweet['text'])."</li>";
			}
		}
		$str .= "</ul></div>";
   

   	return $str;
  }
  add_shortcode('tweets','ioa_twitter_shortcode');


// === Blog shortcodes ============================================================

function functionpost_author_posts_link($atts)
{
   global $post,$author;
   
   
   return "<a href='".get_author_posts_url(get_the_author_meta( 'ID' ))."'>".get_the_author()."</a>";
}


add_shortcode("post_author_posts_link","functionpost_author_posts_link");


function functionpost_date($atts)
{
   global $post,$author;
   extract(
   shortcode_atts(array( 
       "format"  => "l, F d S, Y"
      
    ), $atts)); 
   if($format == 'default') $format = get_option('date_format');
   return '<i class="calendar-2icon- ioa-front-icon"></i> '.get_the_time($format);
}


add_shortcode("post_date","functionpost_date");


function functionpost_time($atts)
{
   global $post,$author;
   extract(
   shortcode_atts(array( 
       "format"  => "g:i a"
      
    ), $atts)); 
   
   return '<i class=" clock-2icon- ioa-front-icon"></i> '.get_the_time($format);
}


add_shortcode("post_time","functionpost_time");


function functionpost_tags($atts)
{
   extract(
  shortcode_atts(array(  
        "icon" => '<i class="tags-1icon- ioa-front-icon"></i>',
    "sep" => ","
    
    ), $atts)); 

   global $post,$author;
   
   $posttags = get_the_tags($post->ID);

   $str = '';
      if ($posttags) {
         $i=0;
        foreach($posttags as $tag) {
         
         if($i==0)
         $str = $str. '<a rel="tag" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>'; 
         else
         $str = $str. ' '.$sep.' <a rel="tag" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>'; 
         
         $i++;
        }
      }

   
   return $icon.' '.$str ;
}


add_shortcode("post_tags","functionpost_tags");


function functionpost_comments($atts)
{
   global $post,$author;
   
   ob_start();
    comments_number( __('no Comments','ioa'), __('one Comment','ioa'), '%'.__(' Comments','ioa') );
    $temp = ob_get_contents();
    ob_end_clean();
   
return '<i class="chat-2icon- ioa-front-icon"></i> <a class="single-comment" href="'.get_permalink().'#comment" >'.$temp.'</a> ';
}


add_shortcode("post_comments","functionpost_comments");


function functionpost_comments_number($atts)
{
   global $post,$author;
   return '<a class="single-comment" href="'.get_permalink().'#comment" >'.get_comments_number( $post->ID ).'</a>';
}




add_shortcode("post_comments_number","functionpost_comments_number");

function functionpost_categories($atts)
{
   global $post,$author;
    extract(
  shortcode_atts(array(  
        "icon" => '<i class="flag-emptyicon- ioa-front-icon"></i>',
    "sep" => ","
    
    ), $atts)); 

   $cats = get_the_category( $post->ID );
 $str = '';
 $i =0;
  foreach($cats as $c)
  {
     if($i==count($cats)-1)
     $str = $str .' <a rel="tag" href="'.get_category_link($c->term_id ).'">'.$c->cat_name.'</a>'; 
     else
     $str =$str . ' <a rel="tag" href="'.get_category_link($c->term_id ).'">'.$c->cat_name.'</a> '.$sep; 
     
     $i++;
  }
 return $icon.' '.$str;
}


add_shortcode("post_categories","functionpost_categories");


function ioavideoShortcode($atts,$content)
{
  extract(
  shortcode_atts(array(  
        "width" => "300",
    "height" => "250"
    
    ), $atts)); 
  
  
  global $wp_embed;
   
   $temp = str_replace("webkitAllowFullScreen mozallowfullscreen",'', wp_oembed_get(strip_tags(trim($content)),array( "width" => $width , 'height' => $height) ) ); 
   $temp = str_replace('frameborder="0"','', $temp ); 

  
  
  return $temp;
}


add_shortcode("video","ioavideoShortcode");


function registerPricingTableShortcode($atts,$content)
{
  extract(
    shortcode_atts(array( ), $atts)
  );

  $str = filterShortcodesP("<div class='pricing-table itemscope itemtype='http://schema.org/Dataset' clearfix'>".do_shortcode($content)."</div>");


  return $str;
}
add_shortcode("pricing_table","registerPricingTableShortcode");


function registerPricingTableColumnShortcode($atts,$content)
{
  extract(
    shortcode_atts(array( 
      "plan_name" => "Plan Name" , 
      "plan_price" => "Free" , 
      "plan_price_info" => "Forever" , 
      "row_data" => "Option 1,Option 2,Option 3" , 
      "button_label" => "Sign Up",
      "button_link" => "#",
      "featured" => false
      ), $atts)
  );

  $f_cl = '';
  if($featured!="false") $f_cl = "featured-plan";
  
  $str = "<div class='plan clearfix {$f_cl} '>
              <h6 itemprop='name'> {$plan_name} </h6>

              <div class='pricing_area'>
                  <h2>{$plan_price}</h2>
                  <span class='suffix'>{$plan_price_info}</span>
              </div>
              <ul class='pricing-row'>
";
  
  $rows = explode(",",$row_data);
  foreach ($rows as $key => $row) {
    $str .= "<li>".$row."</li>";
  }

  $str .=" <li class='sign-up' ><a itemprop='url'  href='{$button_link}'>{$button_label}</a></li> </ul></div>";
  return $str;
}
add_shortcode("column","registerPricingTableColumnShortcode");



function registerPricingTableFeautureColumnShortcode($atts,$content)
{
  extract(
    shortcode_atts(array( 
      "title" => "This is Sparta !" , 
      "info" => "This is the feature list area." , 
      "row_data" => "Option 1,Option 2,Option 3" , 
      ), $atts)
  );

  $str = "<div class='feature-column clearfix  '>

              <div class='feature_area'>
                  <h2>{$title}</h2>
                  <span class='info' itemprop='description'>{$info}</span>
              </div>
              <ul class='pricing-row'>
";
  
  $rows = explode(",",$row_data);
  foreach ($rows as $key => $row) {
    $str .= "<li>".$row."</li>";
  }

  $str .=" </ul></div>";
  return $str;
}
add_shortcode("feature_column","registerPricingTableFeautureColumnShortcode");

function registerListShortcode($atts,$content)
{
   extract(
    shortcode_atts(array( 
      "icon" => "checkicon- ioa-front-icon" , 
      "color" => "green" , 
      "data" => "List 1;List 2;List 3"
      ), $atts)
  );

   $str = "<ul class='ioa-shortcode-list'  itemscope itemtype='http://schema.org/ItemList'>";

   $d = explode(";",$data);

  
   foreach ($d as $key => $value) {
    if($value!="")
     $str .= "<li><span class=' {$icon}' style='color:$color'></span> {$value} </li>";

        }
      
   return $str."</ul>";

}
add_shortcode("list","registerListShortcode");

function registerIOASlider($atts,$content)
{
  global $helper;
   extract(
    shortcode_atts(array( 
      "id" => ""
      ), $atts)
  );


   if($id== "") return "Invalid ID";

   $str = '';

   $slides = get_post_meta($id,'slides',true);
   $ioa_options = get_post_meta($id,'options',true);

   if(! is_array($slides)) $slides = array();
   if(! is_array($ioa_options)) $ioa_options = array();

   $do ='';
   
   $mo = $helper->getAssocMap($ioa_options,"value");

   if(isset($mo['effect_type']))
   if(  $mo['effect_type'] == "gallery" ) :

         foreach($ioa_options as $key => $o)
         {
           if($o['name'] =="bullets")
              $do .= " data-thumbnails='".$o['value']."'";
           else
            $do .= " data-".$o['name']."='".$o['value']."'";

          $do .= " data-effect_type='fade'";
         } 

         $str .= ' <div class="ioa-gallery seleneGallery" '.$do.' itemscope itemtype="http://schema.org/ImageGallery" > 
                      <div class="gallery-holder" style="height:'.$mo['height'].'px">';

         foreach ($slides as $key => $slide) {
           $w = $helper->getAssocMap($slide,'value'); 
          $str .= ' <div class="gallery-item" data-thumbnail="'.$w['thumbnail'].'">';
       
          if($w['image_resize'] == "no")
             $str .= ' <img src="'.$w['image'].'" alt="'.$w['alt_text'].'" itemprop="image" />';
          else 
            $str .= $helper->imageDisplay(array( "width" => $mo['width'] , "height" => $mo['height'] , 'imageAttr' =>  $w['alt_text'], "parent_wrap" => false , "src" => $w['image'] ));

          $str .= ' <div class="gallery-desc" itemprop="description">';
             if(trim($w['text_title'])!="")  $str .= '    <h4 >'.$w['text_title'].'</h4> ';
              if(trim($w['text_desc'])!="")  $str .= '    <div  s class="caption">'.$w['text_desc'].'</div> ';
           $str .= '    </div>  
          </div>';
         }
    else :
        
          foreach($ioa_options as $key => $o)
         {
            if($o['name'] =="captions")
              $do .= " data-caption='".$o['value']."'";
           else
            $do .= " data-".$o['name']."='".$o['value']."'";
         } 

          $ioa_options = $helper->getAssocMap($ioa_options,'value'); 


         $str .= ' <div class="ioaslider quartz" '.$do.' itemscope itemtype="http://schema.org/ImageGallery" > 
                      <div class="items-holder" style="height:'.$mo['height'].'px">';

         foreach ($slides as $key => $slide) {
           $w = $helper->getAssocMap($slide,'value'); 

          $str .= ' <div class="slider-item">';

           if($w['image_resize'] == "no" || $ioa_options['full_width'] == "true")
             $str .= ' <img src="'.$w['image'].'" alt="'.$w['alt_text'].'" itemprop="image" />';
          else 
            $str .= $helper->imageDisplay(array( "width" => $mo['width'] , "height" => $mo['height'] , 'imageAttr' =>  $w['alt_text'], "parent_wrap" => false , "src" => $w['image'] ));


             $str .= ' <div class="slider-desc" itemprop="description">';
             if(trim($w['text_title'])!="")  $str .= '    <h4 >'.$w['text_title'].'</h4> ';
              if(trim($w['text_desc'])!="")  $str .= '    <div  class="caption">'.$w['text_desc'].'</div> ';
           $str .= '    </div>  
          </div>';
         }

    endif;      

   $str .= '</div></div>';
   return $str;

}
add_shortcode("slider","registerIOASlider");

function registerClimaicon($atts)
{

  global $helper;
   extract(
    shortcode_atts(array( 
      "type" => "rain" ,
      "width" => "120",
      "height" => "120",
      "color" => "#333333"
      ), $atts)
  );

  return " <canvas class='climacon-shortcode' width='$width' height='$height' data-type='$type' data-color='$color' ></canvas>"; 
   
}
add_shortcode('climate_icon','registerClimaicon');


function registerGETMETA($atts)
{

  global $helper;
   extract(
    shortcode_atts(array( 
      "field" => "" ,
      ), $atts)
  );
  global $post;  

if($field=="") return '';
  $field = str_replace(" ","_",strtolower(trim($field)));

  return get_post_meta(get_the_ID(), $field,true); 
   
}
add_shortcode('get','registerGETMETA');


/* == Accordion Widget ============================= */

function registerAccordinShortcodesSection($atts,$content)
{
  global $helper;
  extract(
  shortcode_atts(array(  
    "title" => 'Your Title Here',
    'background' => '' , 
    'color' => ''
      ), $atts)); 
  
  $content = $helper->format($content);
   
  $bg =  ''; 

  if($background!="") $bg = "background:{$background};border-color:{$background};";

  $sec =  " <h3 style='color:{$color};$bg' itemprop='name' class='ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-accordion-icons' > <i class='down-diricon- ioa-front-icon'></i> ".stripslashes($title)."</h3> <div itemprop='description'  class='accordion-body ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom  clearfix'>$content</div>";
  return $sec;
}

add_shortcode("section","registerAccordinShortcodesSection");

function registerShortcodesAccordion($atts,$content)
{
  extract(
  shortcode_atts(array(  
       
    "width"=>"100%"
      ), $atts)); 
  global $helper; 
  
  $data = filterShortcodesP(do_shortcode($content));
  $data = "<div class='ioa_accordion  ui-accordion ui-widget ui-helper-reset' itemscope itemtype='http://schema.org/ItemList'> $data </div>";
  
  return $data;
}
add_shortcode("ioa_accordion","registerShortcodesAccordion");

/**
 * Power Grid
 */


function registerPowerAccordinShortcodesSection($atts,$content)
{
  global $helper;
  extract(
  shortcode_atts(array(  
    "title" => 'Your Title Here',
    'icon' => "",
    'background' => '' , 
    'color' => ''

      ), $atts)); 
  
  $content = $helper->format($content);
   
  $bg =  '';

  

  if($background!="") $bg = "background:{$background};border:none;";

  $sec =  " <div class='power-section' style='width:[power_wr]%' ><h3 itemprop='name' style='color:{$color};$bg' > <i class='$icon'></i>".stripslashes($title)."</h3> <div itemprop='description' class='accordion-body clearfix'>$content</div></div>";
  return $sec;
}

add_shortcode("psection","registerPowerAccordinShortcodesSection");

function registerShortcodesPowerAccordion($atts,$content)
{
  extract(
  shortcode_atts(array(  
       
    "width"=>"100%",
    "blocks" => 4
      ), $atts)); 
  global $helper; 
   
   if($blocks=="") $blocks = 4; 
  
  $w = 100/intval($blocks);  

  $data = filterShortcodesP(do_shortcode(stripslashes($content)));
  $data = "<div class='power_accordion clearfix' itemscope itemtype='http://schema.org/ItemList'> $data  </div>";
  $data = str_replace("[power_wr]",$w,$data);
  return $data;
}
add_shortcode("power_accordion","registerShortcodesPowerAccordion");


/**
 * Toggle
 */

function registerSingleToggle($atts,$content)
{
  global $helper;
  extract(
  shortcode_atts(array(  
        "title" => 'Your Question',
    'collapse' => "true"
      ), $atts)); 
  $content = $helper->format($content);
  
  $id =  uniqid('acc');
  $icon = "plus-1icon-";
  if($collapse=="true")
  {
     $collapse = 'collapse';
  } else 
  {
    $collapse= 'open';  $icon = "minusicon-";
  }
    
  $tab =  " <div class='toggle' itemscope itemtype='http://schema.org/Thing'><a href=\"#{$id}\" class='toggle-title' itemprop='name'  > <i class='ioa-front-icon $icon'></i> ".stripslashes($title)."</a><div id='{$id}' itemprop='description' class='toggle-body $collapse'> $content</div> </div>";
  return $tab;
}

add_shortcode("toggle","registerSingleToggle");

/**
 * Boxes
 */


function registerBoxes($atts,$content)
{
  extract(
  shortcode_atts(array(  
    "close" => "",     
    "color"=>"#777",
    "icon" => "ok-circled-1icon- ioa-front-icon",
   
      ), $atts)); 
  global $helper; 
  
  $data = filterShortcodesP(do_shortcode($content));
  $close_icon = '';
  
  if($close!="false") $close_icon = "<a href='' class='cancel-2icon- ioa-front-icon close'></a>";
  
  $sh ='';


  $data = "<div class='ioa_box_wrapper $sh' itemscope itemtype='http://schema.org/Thing'><div class='ioa_box clearfix' itemprop='description' style='background:$color'> <i class='{$icon}'></i> $data $close_icon </div></div>";
  
  return $data;
}
add_shortcode("box","registerBoxes");

/**
 * Counter
 */

function registerCounter($atts,$content)
{
  extract(
  shortcode_atts(array(  
    "start" => 0,
    "end" => 100,
    "effect_type" => "slide",
    "speed" => 60,
    "color" => "#ffffff",
    "background" => "#555555",
      ), $atts)); 
  
 
 $data = "<div class='ioa_counter' itemscope itemtype='http://schema.org/Dataset' style='color:{$color};background-color:{$background};' data-start='{$start}' data-end='{$end}' data-effect_type='{$effect_type}' data-speed='{$speed}' ></div>";

  return "<div style='background-color:{$background};' class='ioa_counter_wrap'>".$data."</div>";
}
add_shortcode("counter","registerCounter");

/**
 * Radial Progress Counter
 */

function registerRadialChart($atts,$content)
{
  extract(
  shortcode_atts(array(  
    "width" => 100,     
    "font_size"=> 72,
    "line_width" => 20,
    "percent" => 60,
    "bar_color" => "#555555",
    "track_color" => "#eeeeee",
      ), $atts)); 
  
 
  $data = "<div class='radial-chart' style='font-size:{$font_size}px' data-bar_color='{$bar_color}' data-track_color='{$track_color}' data-start_percent='{$percent}' data-percent='0' data-line_width='{$line_width}' data-width='$width' itemscope itemtype='http://schema.org/Dataset'  >{$content}</div>"; 
 

  return $data;
}
add_shortcode("radialchart","registerRadialChart");


/**
 * Progress Bars
 */

function registerProgressBar($atts,$content)
{
  extract(
  shortcode_atts(array(  
    "unit" => "%",
    "percent" => 60,
    "color" => "#0dd7cb",
 
      ), $atts)); 
  
   $end_gr = $color;
   $start_gr = adjustBrightness($color,80);

  $code = "background:$color;background: -webkit-gradient(left, 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(left, ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(left, ".$start_gr.", ".$end_gr."); background: -ms-linear-gradient(left, ".$start_gr.", ".$end_gr."); background: -o-linear-gradient(left, ".$start_gr.", ".$end_gr."); ";
   
   $data = filterShortcodesP("<div class='progress-bar'><h6 class='progress-bar-title' itemprop='name'>{$content}</h6><div class='filler' style='$code' data-fill='{$percent}'><span> <i class='down-dir-1icon- ioa-front-icon'></i> {$percent} {$unit}</span></div></div>");

 
 

  return $data;
}
add_shortcode("progress_bar","registerProgressBar");

function registerProgressGroup($atts,$content)
{

  return "<div class='progress-bar-group' itemscope itemtype='http://schema.org/Dataset'>".do_shortcode($content)."</div>";
}
add_shortcode("progress_set","registerProgressGroup");
/**
 * Stacked Circles
 */


function registerSingleCircle($atts,$content)
{
  extract(
  shortcode_atts(array(  
    "unit" => "%",
    "percent" => 60,
    "color" => "#ffffff",
    "background" => "#444444"
 
      ), $atts)); 
  
 
  $data = "<div class='circle' style='background-color:$background' data-fill='$percent'><h6 style='color:{$color}' itemprop='name'>$content <span>{$percent}{$unit}</span><i class='down-dir-1icon- ioa-front-icon'></i></h6></div>"; 
 

  return $data;
}
add_shortcode("single_circle","registerSingleCircle");

function registerStackedCircle($atts,$content)
{
  extract(
  shortcode_atts(array(  
    "width" => 300,
    "height" => 300,
  
 
      ), $atts)); 
  
 
  $data = "<div class='circles-group' itemscope itemtype='http://schema.org/Dataset' style='width:{$width}px;height:{$height}px;'>".do_shortcode($content)."</div>"; 
  return $data;
}
add_shortcode("stacked_circle_group","registerStackedCircle");

/**
 * Button
 */

function registerButton($atts,$content)
{
  extract(
  shortcode_atts(array(  
    
    "size"=> 'normal',
    "color" => "#ffffff",
    "background" => "#1acad0",
    "radius" => "3px" ,
    "type" => "flat",
    "link" => "#",
    "newwindow" => "true",
    "icon" => ""
      ), $atts)); 
  
  $darker_side = adjustBrightness($background,-30);

  $t = '';

  if($newwindow == "true") $t = "target='_BLANK'";

  $query = '';

  switch ($type) {
    case 'classic': $query = "background-color:{$background};color:{$color};border-radius:{$radius};border-color:{$darker_side}"; break;  
    case 'gradient': $query = "background-color:{$background};color:{$color};border-radius:{$radius};border-color:{$darker_side}"; break; 
    case 'gloss': $query = "background-color:{$background};color:{$color};border-radius:{$radius};border-color:{$darker_side}"; break; 
    default:
    case 'flat': $query = "background-color:{$background};color:{$color};border-radius:{$radius}"; break;
  
  }

  

  if($icon!="") $icon = "<i class='{$icon}'></i>";

  $button= "<a href='{$link}' $t class='ioa-button button-{$size}  button-shader-{$type}' style='$query'><span> $icon ".$content."</span><span class='underlay' style='background:{$darker_side};border-radius:{$radius}'></span></a>";

  return $button;
}
add_shortcode("button","registerButton");

/**
 * Icon
 */

function registerIcon($atts,$content)
{
  extract(
  shortcode_atts(array(  
    
    "size"=> '14px',
    "color" => "#ffffff",
    "background" => "",
    "radius" => "3px" ,
    "spacing" => "10px",
    "type" => "blank"
      ), $atts)); 
  
  
  $ic = '';
  $ic = "<i style='padding:$spacing;font-size:$size;color:$color;background:$background;border-radius:$radius' class=' shortcode-icon {$type}'></i>";
  return $ic;
}
add_shortcode("icon","registerIcon");

/**
 * Divider
 */

function registerDivider($atts,$content)
{
  extract(
  shortcode_atts(array(  
    
    "vspace"=> '10px',
    "hspace" => "0px",
    "type" => "default",
    
     ), $atts)); 
  


  $button= "<div class='separator sep-{$type}' style='margin:{$vspace} {$hspace}'></div>";

  return $button;
}
add_shortcode("divider","registerDivider");

/**
 * Social Icons
 */


function registerShortcodesoscialicons($atts)
{
  global $post;
  extract(
  shortcode_atts(array( 
    "url" => get_permalink() , "type" => "twitter"
    
    ), $atts)); 
  
   
  $sp ='';
  
  switch($type)
  {
        case "f500px" : $sp =  URL."/sprites/i/si/500px-32.png"; break;
        case "aim" : $sp = URL."/sprites/i/si/aim-32.png";  break;
        case "android" : $sp = URL."/sprites/i/si/android-32.png";  break;
        case "badoo" : $sp = URL."/sprites/i/si/badoo-32.png";  break;
            
        case "dailybooth" : $sp =  URL."/sprites/i/si/dailybooth-32.png";  break;
        case "dribbble" : $sp =  URL."/sprites/i/si/dribbble-32.png";  break;
        case "email" : $sp =  URL."/sprites/i/si/email-32.png";  break;
        case "foursquare" : $sp =  URL."/sprites/i/si/foursquare-32.png";  break;
            
            
        case "github" : $sp =  URL."/sprites/i/si/github-32.png";  break;
        case "google" : $sp =  URL."/sprites/i/si/google+-32.png";  break;
        case "hipstamatic" : $sp =  URL."/sprites/i/si/Hipstamatic-32.png";  break;
        case "icq" : $sp = URL."/sprites/i/si/icq-32.png";  break;
            
            
        case "instagram" : $sp =   URL."/sprites/i/si/instagram-32.png";  break;
        case "lastfm" : $sp =  URL."/sprites/i/si/lastfm-32.png";  break;
        case "linkedin" : $sp =  URL."/sprites/i/si/linkedin-32.png";  break;
        case "path" : $sp =  URL."/sprites/i/si/path-32.png";  break;
            
         case "picasa" : $sp =  URL."/sprites/i/si/picasa-32.png";  break;
        case "pininterest" : $sp =  URL."/sprites/i/si/pinterest-32.png";  break;
       case "quora" : $sp =  URL."/sprites/i/si/quora-32.png";  break;
        case "rdio" : $sp =  URL."/sprites/i/si/rdio-32.png";  break;
            
        case "rss" : $sp =  URL."/sprites/i/si/rss-32.png";  break;
        case "skype" : $sp =   URL."/sprites/i/si/skype-32.png";  break;
        case "reddit" : $sp =  URL."/sprites/i/si/reddit-32.png";  break;
        case "spotify" : $sp =  URL."/sprites/i/si/spotify-32.png";  break;
            
       case "thefancy" : $sp =  URL."/sprites/i/si/thefancy-32.png";  break;
       case "tumblr" : $sp =  URL."/sprites/i/si/tumblr-32.png";  break;
       case "twitter" : $sp =  URL."/sprites/i/si/twitter-32.png";  break;
       case "vimeo" : $sp =  URL."/sprites/i/si/vimeo-32.png";  break;
            
       case "xbox" : $sp =  URL."/sprites/i/si/Xbox-32.png";  break;
        case "youtube" : $sp =  URL."/sprites/i/si/YouTube-32.png";  break;
        case "zerply" : $sp =  URL."/sprites/i/si/zerply-32.png";  break;
         case "facebook" : $sp =  URL."/sprites/i/si/facebook-32.png";  break;
  }
   $i = '<a href="'.$url.'"class="shortcode-social-icon"  ><img src="'.$sp.'" alt="social icon" /></a>';
  return $i;
}


add_shortcode("social_icon","registerShortcodesoscialicons");

// == Google Map =======================================

function registerGoogleshortcodeMap($atts)
{
  extract(
    shortcode_atts(array(  
      "width"=>"300",
      "height"=>"300",
      "address" => '',
      "view" => "m"
  ), $atts)); 
  
  $address = str_replace(" ","+",$address);
  
  return '<div class="google-map" style="width:'.$width.'px;height:'.($height).'px;">
            <iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.in/maps?q='.$address.'&amp;ie=UTF8&amp;hq=&amp;hnear='.$address.'&amp;gl=in&amp;z=11&amp;vpsrc=0&amp;output=embed&amp;t='.$view.'">              </iframe>
        </div>';
  
}

add_shortcode("map","registerGoogleshortcodeMap");

// == Image =======================================

function registerImageFrame($atts)
{
  extract(
    shortcode_atts(array(  
      "src" => '',
      "resize" => "none",
      "frame" => "none",
      "align" => "none",
      "width" => '100%' ,
      "height" => 250,
      "link" => "",
      "hoverbg" => "#1ed8ee",
      "hoverc" => "#ffffff",
      "effect" => '',
      "effect_delay" => 0,
      "lightbox" => "false",
      "title" => ''
  ), $atts)); 
  
  global $helper;

 $test = true; $hover= "<a class='hover' style='background:{$hoverbg}' href='$link' ><i style='color:{$hoverbg};background-color:{$hoverc}' class='ioa-front-icon  link-2icon-'></i></a>"; 
 if($link=="") 
 {
   $test = false;
   $hover = "";
 }

 if($lightbox == "true")
 {
    $test = false; 
    $hover= "<a class='hover'title='{$title}' style='background:{$hoverbg}' href='$src' rel='prettyPhoto[pp_gal]'><i style='color:{$hoverbg};background-color:{$hoverc}' class='ioa-front-icon resize-full-2icon- lightbox'></i></a>"; 
 }

  $frame = str_replace(" ","-",strtolower(trim($frame))) ; 
  $image = '';
  $listener = '';

  if($effect!="" && strtolower($effect)!="none") $listener = 'way-animated';

  
  
  switch($resize)
  {
     case 'hard' : $image = $helper->imageDisplay(array( "width" => $width , "height" => $height , "src" => $src , "parent_wrap" => $test , "link" => $link )); break;
     case 'proportional' :   $image = $helper->imageDisplay(array( "crop" => "proportional" , "width" => $width , "height" => $height , "src" => $src , "parent_wrap" => $test , "link" => $link )); break;
     case 'wproportional' : $image = $helper->imageDisplay(array( "crop" => "wproportional" ,"width" => $width , "height" => $height , "src" => $src , "parent_wrap" => $test , "link" => $link )); break;
     case 'hproportional' : $image = $helper->imageDisplay(array( "crop" => "hproportional" ,"width" => $width , "height" => $height , "src" => $src , "parent_wrap" => $test , "link" => $link )); break;
     default : $image = "<img src='{$src}' itemprop='url' alt='shortcode image' />";
  }

  return "<div style='width:{$width}px' data-waycheck='$effect' data-delay='$effect_delay' class='$listener  image-frame  image-align-{$align}' itemscope itemprop='http://schema.org/ImageObject'> $image $hover</div>";
  
}

add_shortcode("image","registerImageFrame");




function registerPerson($atts)
{
  extract(
    shortcode_atts(array(  
      "photo" => '',
      "name" => "Tony Stark",
      "designation" => "CEO",
      "info" => 'Some information about person' ,
      "twitter" => '',
      "facebook" => '',
      "youtube" => '',
      "google" => '',
      "linkedin" => '',
      "dribbble" => '',
     
      "label_color" => "",
      "width" => 300
  ), $atts)); 
  
  global $helper;
 
  $sc = array();
  if($twitter!='') $sc[]= "<a class='twitter' href='{$twitter}'  itemprop='url' >".__("Twitter",'ioa')."</a>";
  if($facebook!='') $sc[]= " <a class='facebook' href='{$facebook}'   itemprop='url'>".__("Facebook",'ioa')."</a>";
  if($google!='') $sc[]= " <a class='google' href='{$google}'   itemprop='url'>".__("Google+",'ioa')."</a>";
  if($linkedin!='') $sc[]= " <a class='linkedin' href='{$linkedin}'  itemprop='url' >".__("LinkedIn",'ioa')."</a>";
  if($dribbble!='') $sc[]= " <a class='dribbble' href='{$dribbble}'  itemprop='url' >".__("Dribbble",'ioa')."</a>";
  if($youtube!='') $sc[]= " <a class='youtube' href='{$youtube}'  itemprop='url' >".__("Youtube",'ioa')."</a>";

  $p = "<div class='person' style='max-width:{$width}'  itemscope itemtype='http://data-vocabulary.org/Person'> 
            <div class='image fn'><img src='{$photo}'> <i class='person-info-toggle info-2icon- ioa-front-icon'></i>    <p style='background-color:{$label_color}' class='desc'  itemprop='description' >$info</p> </div> 
            <div class='info clearfix'> 
                <div class='person-top-area' style='background-color:{$label_color}'>
                  <h4  itemprop='name'>$name</h4> 
                 ";
  if($designation!="") $p .= " <span class='desig' itemprop='affiliation'>$designation</span>";                 
    
  if(count($sc)>0)  
  $p .="<span class='spacer'></span> <div class='social'> ".implode("/",$sc)." </div>";


  $p .="              </div>
             </div> 
            
          </div>";

  return $p;
  
}

add_shortcode("person","registerPerson");


/**
 * Posts Slider
 */


function registerPostsSlider($atts)
{
  extract(
    shortcode_atts(array(  
      "post_type" => 'post',
      "no" => 5,
      "category" => "",
      "tag" => "",
      "order" => "DESC",
      "orderby" => "date",
      "width" => 380,
      "height" => 250
  ), $atts)); 
  
  global $helper;
  
   $opts = array(
    "order" => $order,
    "orderby" => $orderby,
    "posts_per_page" => $no ,
    "post_type" => $post_type,
    "category_name" => $category,
    "tag" => $tag,
     'tax_query' =>  array(
                 array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-quote','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                    'operator' => 'NOT IN'
                  )
              )
    ); 

  $data = "<div class=\"scrollable posts_slider\">";
   
    $query = new WP_Query($opts); 
    while ($query->have_posts()) : $query->the_post();  
  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())):

    $dbg = '' ; $dc = '';

         $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
    if($ioa_options =="")  $ioa_options = array();


         if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
      if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];


      $data .= " <div class=\"clearfix ".implode(' ',get_post_class())." slide\"  style='width:{$width}px;' itemscope itemtype='article'>";

    
        $data .=  '  <div class="image">';

        $id = get_post_thumbnail_id();
        $ar = wp_get_attachment_image_src( $id , array(9999,9999) );

        $data .=  $helper->imageDisplay(array( "src" => $ar[0] , "height" => $height, "width" => $width , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
        $data .= "  </div>";
     

     $data .="<div class=\"desc\" style='background:$dbg;color:$dc'>
                <h2 itemprop='name' class=\"custom-font\"> <a href='".get_permalink()."' class=\"clearfix\" >".get_the_title()."</a></h2> 
                <a itemprop='url' href='".get_permalink()."' class=\"read-more\">".__('More','ioa')."</a>
              </div>";           
      $data .= "</div>";         
         endif;  
        endwhile; 
   
     $data .= "</div>";         
  

  return $data;
  
}

add_shortcode("post_slider","registerPostsSlider");



/**
 * Register Column
 */

function registerCol($atts,$content)
{
  global $helper;
  extract(
    shortcode_atts(array(  
      "width" => "full" ,
      "last" => ""
  ), $atts)); 

$after ='';
  if($last!="false") 
  {
    $last = "last";
    $after ='<div class="clearfix"></div>';
  }

  return "<div class='$width $last col clearfix'>".do_shortcode($content)."</div>".$after;
}

add_shortcode("col","registerCol");

/**
 * Single Testimonial
 */

function registerSingleTestimonial($atts,$content)
{
  global $helper;
  extract(
    shortcode_atts(array(  
      "id" => "" 
  ), $atts)); 

  $test = '';

  if($id!="")
  {

    $tpost = get_post($id);
     $dbg = '' ; $dc = '';
 
          if(get_post_meta($id,'dominant_bg_color',true)!="") $dbg =  get_post_meta($id,'dominant_bg_color',true);
          if(get_post_meta($id,'dominant_color',true)!="") $dc =  get_post_meta($id,'dominant_color',true);



   $test .=  '<div class="testimonial_bubble-wrapper"><div class="testimonial-bubble" itemscope itemtype="http://schema.org/Review">
           <div class="testimonial-bubble-content" itemprop="description" style="color:'.$dc.';background-color:'.$dbg.';">
              '.$tpost->post_content.'
              <i class="ioa-front-icon sort-downicon-" style="color:'.$dbg.';"></i>
           </div> 

           <div class="testimonial-bubble-meta clearfix">
              <div class="image">';
                 
             $tid = get_post_thumbnail_id($id);
             $ar = wp_get_attachment_image_src( $tid , array(9999,9999) );
           
             $test .= $helper->imageDisplay(array( "src" => $ar[0] , "height" =>75 , "width" => 75 , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
               
       $test .= '   </div>
                <div class="info">
                      <h2 class="name" itemprop="name">'.get_the_title($id).'</h2> 
                      <span class="designation">'.get_post_meta($id,'design',true).'</span>
                    </div>
           </div>
    </div> </div>';

  }

  return $test;
}

add_shortcode("testimonial","registerSingleTestimonial");


/**
 * Posts List
 */


function registerPostsList($atts)
{
  extract(
    shortcode_atts(array(  
      "post_type" => 'post',
      "no" => 5,
      "category" => "",
      "tag" => "",
      "order" => "DESC",
      "orderby" => "date",
      "ioa_query" => "",
      "excerpt_length" => 80
  ), $atts));  
  
  global $helper,$ioa_meta_data;
  
  $opts = array();

  if($ioa_query=="") :

     $opts = array(
      "order" => $order,
      "orderby" => $orderby,
      "posts_per_page" => $no ,
      "post_type" => $post_type,
      "category_name" => $category,
      "tag" => $tag,
      'tax_query' =>  array(
                   array(
                      'taxonomy' => 'post_format',
                      'field' => 'slug',
                      'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                      'operator' => 'NOT IN'
                    )
                )
      ); 
  else :
    $filter = $helper->ioaquery($ioa_query);
    $opts = array(
      
      'post_type' => $post_type, 
      'posts_per_page' => $no
      );

    $opts = array_merge($opts,$filter);
    
  endif;
    
    $ioa_meta_data['height'] = 50;
    $ioa_meta_data['width'] = 50;
    $ioa_meta_data['hasFeaturedImage'] = false; 
    $ioa_meta_data['item_per_rows'] = 1;
    $ioa_meta_data['excerpt'] = "yes";
    $ioa_meta_data['excerpt_length'] = $excerpt_length;
    $ioa_meta_data['meta_value'] = "";
     $ioa_meta_data['i'] = 0;
    $data = '<ul class="thumb-list posts clearfix">   ';
    $query = new WP_Query($opts); 
    while ($query->have_posts()) : $query->the_post();  
      
      ob_start();

          get_template_part('templates/post-thumbs');
      $data .= ob_get_contents();

      ob_end_clean();

    endwhile; 
   
          
  

  return $data."</ul>";
  
}

add_shortcode("post_list","registerPostsList");

/**
 * Grid
 */

function registerPostsGrid($atts)
{
   extract(
    shortcode_atts(array(  
      "post_type" => 'post',
      "no" => 5,
      "category" => "",
      "tag" => "",
      "order" => "DESC",
      "orderby" => "date",
      "ioa_query" => "",
      "excerpt_length" => 80,
      "post_filter" => "false"
  ), $atts));
  
 global $helper,$ioa_meta_data,$ioa_portfolio_slug;
  
  $opts = array();

 if($ioa_query=="") :

     $opts = array(
      "order" => $order,
      "orderby" => $orderby,
      "posts_per_page" => $no ,
      "post_type" => $post_type,
      "category_name" => $category,
      "tag" => $tag,
      'tax_query' =>  array(
                   array(
                      'taxonomy' => 'post_format',
                      'field' => 'slug',
                      'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                      'operator' => 'NOT IN'
                    )
                )
      ); 
  else :
    $filter = $helper->ioaquery($ioa_query);
  
    $opts = array(
      
      'post_type' => $post_type, 
      'posts_per_page' => $no
      );

    $opts = array_merge($opts,$filter);
    
  endif;

    $ioa_meta_data['post_type'] = $post_type;
    $ioa_meta_data['content_limit'] = $excerpt_length;

    $ioa_meta_data['height'] = 150;
    $ioa_meta_data['width'] = 244;
    $ioa_meta_data['hasFeaturedImage'] = false; 
    $ioa_meta_data['item_per_rows'] = 4;
    $post_structure_class = 'post-grid-4cols';
     $ioa_meta_data['i'] = 0;

    $data = '<div class="grid-area hoverable iso-parent clearfix" itemscope itemtype="http://schema.org/Article">';

    if($post_filter=="true")
    {
            $data .= "<div class='clearfix shortcode-filter'>";      

          if($post_type=="post") 
          {
             ob_start();
              get_template_part('templates/blog-filter');
              $data .= ob_get_contents();
             ob_end_clean();
          }
          else if($post_type == $ioa_portfolio_slug) 
           {
             ob_start();
              get_template_part('templates/portfolio-filter');
              $data .= ob_get_contents();
             ob_end_clean();
           }
            $data .= "</div>";      
    }

    $data .= '<ul class="posts-grid  posts isotope '. $post_structure_class.' clearfix">   ';
    $query = new WP_Query($opts); 
    while ($query->have_posts()) : $query->the_post();  
      
      ob_start();

          get_template_part('templates/post-grid-cols');
      $data .= ob_get_contents();

      ob_end_clean();

    endwhile; 
   
  return $data."</ul></div>";
  
}

add_shortcode("post_grid","registerPostsGrid");

/**
 * Scrollable
 */

function registerPostsScrollable($atts)
{
   extract(
    shortcode_atts(array(  
      "post_type" => 'post',
      "no" => 5,
      "category" => "",
      "tag" => "",
      "order" => "DESC",
      "orderby" => "date",
      "ioa_query" => "",
      "width" => 250,
      "height" => 180
  ), $atts));
  
 global $helper,$ioa_meta_data,$ioa_portfolio_slug;
  
  $opts = array();

  if($ioa_query=="") :

     $opts = array(
      "order" => $order,
      "orderby" => $orderby,
      "posts_per_page" => $no ,
      "post_type" => $post_type,
      "category_name" => $category,
      "tag" => $tag,
      'tax_query' =>  array(
                   array(
                      'taxonomy' => 'post_format',
                      'field' => 'slug',
                      'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                      'operator' => 'NOT IN'
                    )
                )
      ); 
  else :
    $filter = $helper->ioaquery($ioa_query);


    $opts = array(
      
      'post_type' => $post_type, 
      'posts_per_page' => $no
      );

    $opts = array_merge($opts,$filter);
    
  endif;

    $ioa_meta_data['post_type'] = $post_type;
    $ioa_meta_data['height'] = 180;
    $ioa_meta_data['width'] = 250;
    $ioa_meta_data['hasFeaturedImage'] = false; 
    $ioa_meta_data['i'] = 0;

    $data = '<div class="shortcode-scrollable"><div class="scrollable hoverable clearfix" itemscope itemtype="http://schema.org/ItemList">';

    $query = new WP_Query($opts); 
    while ($query->have_posts()) : $query->the_post();  
      
         $dbg = '' ; $dc = '';

         $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
       if($ioa_options =="")  $ioa_options = array();


         if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
      if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];

       if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true;           
          
        $data .= '<div class="clearfix slide" style="width:'.$width.'px" itemscope itemtype="http://schema.org/Article">';
            
             $ar = ''; 
             if($ioa_meta_data['hasFeaturedImage']) :
              
                $data .='<div class="image">';
               
                $id = get_post_thumbnail_id();
                $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
            
                  $data .= $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$height , "width" => $width , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                
              $data .=  '<a class="hover"  href="'.get_permalink().'"  style="background-color:'.$dbg.'">
                     <i class="hover-link ioa-front-icon link-2icon-" style="color:'.$dc.'"></i>  
               </a>
              </div>';
              endif;  

              
              $data .= '<div class="desc">
                <h2 class="custom-font" itemprop="name"> <a href="'.get_permalink().'" class="clearfix" >'.get_the_title().'</a></h2> 
                   <a href="'.get_permalink().'" itemprop="url" class="read-more">'.__('More','ioa').'</a>';

                   if($ioa_meta_data['hasFeaturedImage']) : 
                      $data .= ' <a href="'.$ar[0].'" class="lightbox">'.__('Show','ioa').'</a>'; 
                   endif; 
             
              $data .= ' </div>
          </div> ';
     
    endwhile; 
   
  return $data."</div></div>";
  
}

add_shortcode("post_scrollable","registerPostsScrollable");
/**
 * Tabs
 */


function registerShortcodesTabs($atts,$content)
{
   extract(
    shortcode_atts(array(  
      "align" => 'top'
  ), $atts)); 


 $content = do_shortcode($content); 
 $data = explode("<tabend>",$content);
 array_pop($data);
$i =0;

$titles = array();
$contents = array();
$bgs = array();
$c = array();
 $ids = array();
for($i=0;$i<count($data);$i++)
{
      $id =  uniqid('acc'); 
    $ids[] = $id;
    $temp = explode("<ioa>",$data[$i]);
    $titles[$i] = $temp[0]; 
    $contents[$i] = $temp[1];
    $bgs[$i] = $temp[2];
    $c[$i] = $temp[3];

  
}



     $tab = "<div class=' clearfix tabs-align-{$align}'><div class='ioa_tabs ui-tabs ui-widget ui-widget-content ui-corner-all clearfix' itemscope  itemtype='http://schema.org/ItemList'> ";
  

   if($align != "bottom")
   {
      $tab .= "<ul class=\"clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all\">"; 
      for($i=0;$i<count($titles);$i++)
      {

      $id =  $ids[$i]; 

      if($i==0)
       $tab = $tab."<li class='active  ui-state-default ui-corner-top'><a href='#shortcodetabs-{$id}'  style='background-color:{$bgs[$i]};color:{$c[$i]}' itemprop='name'> $titles[$i] </a></li>";
      else
        $tab = $tab."<li class='ui-state-default ui-corner-top'><a href='#shortcodetabs-{$id}' style='background-color:{$bgs[$i]};color:{$c[$i]}' > $titles[$i] </a></li>";
      }
      $tab = $tab."</ul>";
   }
  
  $tab .= "<div class='tab-content'>";
  for($i=0;$i<count($contents);$i++)
  {
    
    if($i==0)
    $tab = $tab."<div id='shortcodetabs-{$ids[$i]}' itemprop='description' class='ui-tabs-panel ui-widget-content ui-corner-bottom' > ".wpautop($contents[$i])." </div> ";
    else
    $tab = $tab."<div id='shortcodetabs-{$ids[$i]}' itemprop='description'  class='ui-tabs-panel ui-widget-content ui-corner-bottom' >".wpautop($contents[$i])."</div>  ";
  }
    
   $tab = $tab."</div>";

   if($align == "bottom")
   {
      $tab .= "<ul class=\"clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all\">"; 
      for($i=0;$i<count($titles);$i++)
      {

      $id =  $ids[$i]; 

      if($i==0)
       $tab = $tab."<li class='active ui-state-default ui-corner-top'><a href='#shortcodetabs-{$id}' itemprop='name'  style='background-color:{$bgs[$i]};color:{$c[$i]}'> $titles[$i] </a></li>";
      else
        $tab = $tab."<li class='ui-state-default ui-corner-top'><a href='#shortcodetabs-{$id}' itemprop='name' style='background-color:{$bgs[$i]};color:{$c[$i]}' > $titles[$i] </a></li>";
      }
      $tab = $tab."</ul>";
   }


   $tab .= "</div></div>";
  
 return $tab;

}


add_shortcode("tabs","registerShortcodesTabs");


function registerShortcodesTab($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "title"  => "",
     "background" => "", "color" => "" , "icon" => ""
    ), $atts)); 

  $icon = "<i class='$icon'></i>"; 


 $content = $helper->format($content);  
 $tab = "$icon ".$title." <ioa> ".wpautop($content) ." <ioa> $background <ioa> $color <tabend>";  
 return $tab;

}


add_shortcode("tab","registerShortcodesTab");

/**
 * CTA
 */

function registerCTA($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "label"  => "Click Me",
     "link" => "", "background" => "#3e606f" , "effect" => "" , "shadow" => ""
    ), $atts)); 

   $content = $helper->format($content);    

$animation = '';

if($effect!="") $animation = 'animated '.$effect;

$button = '';

if($link!="")
$button = '<div class="button-area">
               <a class="cta_button '.$animation.'" itemprop="url"  href="'.$link.'">'.$label.'</a>
          </div>'; 

$cta = '<div class="cta-wrap"><div class="cta clearfix" itemscope itemtype="http://schema.org/Thing" style="background:'.$background.'">
          <div class="text-title-wrap">
            <div class="text-title-inner-wrap" itemprop="description"> '.$content.' </div>  
          </div>
          '.$button.'
        </div></div>';

 return filterShortcodesP($cta);

}


add_shortcode("cta","registerCTA");

/**
 * Charts
 */

/**
 * Line Graph
 */

function registerLineChart($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "width"  => 400,
     "height"  => 400,
     "xlabels" => "A,B,C,D,E,F",

    ), $atts)); 

$lines = do_shortcode($content);

$line = '<div class="line-chart-wrap" itemscope itemtype="http://schema.org/Dataset" data-max="'.$width.'" data-labels="'.$xlabels.'"><canvas width="'.$width.'" height="'.$height.'"></canvas> '.$lines.'</div>';

 return filterShortcodesP($line);

}


add_shortcode("line_chart","registerLineChart");


function registerLineValue($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 

      "background" => "rgba(220,220,220,0.5)",
      "strokecolor" => "rgba(220,220,220,1)",
      "pointcolor" => "rgba(220,220,220,1)",
      "pointstrokecolor" => "#ffffff",
      "data" => "65,59,90,81,56,55"

    ), $atts)); 

  
$lines = do_shortcode($content);
 
$b = hex2RGB($background);  

$line = "<div class='line-val' data-fillcolor='rgba(".$b['red'].",".$b['green'].",".$b['blue'].",0.75)' data-strokecolor='$strokecolor' data-pointcolor='$pointcolor' data-pointstrokecolor='$pointstrokecolor' data-values='$data' itemprop='spatial'>$data</div>";

return filterShortcodesP($line);

}


add_shortcode("line","registerLineValue");

/**
 * Bar Graph
 */


function registerBarChart($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "width"  => 400,
     "height"  => 400,
     "xlabels" => "A,B,C,D,E,F",

    ), $atts)); 

  $bars = do_shortcode($content);
  $bar_graph = '<div class="bar-chart-wrap" data-labels="'.$xlabels.'" itemscope itemtype="http://schema.org/Dataset" data-max="'.$width.'"><canvas width="'.$width.'" height="'.$height.'"></canvas> '.$bars.'</div>';
   return filterShortcodesP($bar_graph);

}

add_shortcode("bar_chart","registerBarChart");


function registerBarValue($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 

      "background" => "rgba(220,220,220,0.5)",
      "strokecolor" => "rgba(220,220,220,1)",
      "data" => "65,59,90,81,56,55"

    ), $atts)); 

$bar = "<div class='bar-val' data-fillcolor='$background' data-strokecolor='$strokecolor'  data-values='$data' itemprop='spatial'>$data</div>";

return filterShortcodesP($bar);

}


add_shortcode("bar_set","registerBarValue");

/**
 * Radar Graph
 */

function registerRadarChart($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "width"  => 400,
     "height"  => 400,
     "xlabels" => "A,B,C,D,E,F",

    ), $atts)); 

$radars = do_shortcode($content);

$chart = '<div class="radar-chart-wrap" data-labels="'.$xlabels.'" data-max="'.$width.'" itemscope itemtype="http://schema.org/Dataset"><canvas width="'.$width.'" height="'.$height.'"></canvas> '.$radars.'</div>';

 return filterShortcodesP($chart);

}


add_shortcode("radar_chart","registerRadarChart");


function registerRadarValue($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 

      "background" => "rgba(220,220,220,0.5)",
      "strokecolor" => "rgba(220,220,220,1)",
      "pointcolor" => "rgba(220,220,220,1)",
      "pointstrokecolor" => "#ffffff",
      "data" => "65,59,90,81,56,55"

    ), $atts)); 


$radar = "<div class='radar-val' data-fillcolor='$background' data-strokecolor='$strokecolor' data-pointcolor='$pointcolor' data-pointstrokecolor='$pointstrokecolor' data-values='$data' itemprop='spatial'>$data</div>";

return filterShortcodesP($radar);

}


add_shortcode("radar","registerRadarValue");

/**
 * Polar Chart
 */


function registePolarChart($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "width"  => 400,
     "height"  => 400

    ), $atts)); 

$poles = do_shortcode($content);

$chart = '<div class="polar-chart-wrap" data-max="'.$width.'" itemscope itemtype="http://schema.org/Dataset"><i class="graph-info-toggle ioa-front-icon info-2icon-"></i><canvas width="'.$width.'" height="'.$height.'"></canvas>  <div class="info-area clearfix">'.$poles.'</div></div>';

 return filterShortcodesP($chart);

}


add_shortcode("polar_chart","registePolarChart");


function registerPolarValue($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 

      "background" => "rgba(220,220,220,0.5)",
      "value" => "65",
      "label" => ""

    ), $atts)); 


$pole = "<div class='polar-val clearfix' data-fillcolor='$background'  data-value='$value'><span class='label' itemprop='name'>$label</span><span class='block' style='background-color:{$background}'></span></div>";

return filterShortcodesP($pole);

}


add_shortcode("pole","registerPolarValue");


/**
 * Pie Chart
 */


function registePieChart($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "width"  => 400,
     "height"  => 400

    ), $atts)); 

$pie = do_shortcode($content);

$chart = '<div class="pie-chart-wrap " itemscope itemtype="http://schema.org/Dataset" data-max="'.$width.'" ><i class="graph-info-toggle ioa-front-icon info-2icon-"></i> <canvas width="'.$width.'" height="'.$height.'"></canvas> <div class="info-area clearfix">'.$pie.'</div></div>';

 return filterShortcodesP($chart);

}


add_shortcode("pie_chart","registePieChart");


function registerPieValue($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 

      "background" => "rgba(220,220,220,0.5)",
      "value" => "65",
      "label" => ''

    ), $atts)); 


$pie = "<div class='pie-val clearfix' data-fillcolor='$background'  data-value='$value'><span class='label' itemprop='name'>$label</span><span class='block' style='background-color:{$background}'></span></div>";

return filterShortcodesP($pie);

}


add_shortcode("pie","registerPieValue");

/**
 * Pie Chart
 */


function registeDonutChart($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "width"  => 400,
     "height"  => 400

    ), $atts)); 

$donut = do_shortcode($content);

$chart = '<div class="donut-chart-wrap" data-max="'.$width.'" itemscope itemtype="http://schema.org/Dataset" > <i class="graph-info-toggle ioa-front-icon info-2icon-"></i> <canvas width="'.$width.'" height="'.$height.'"></canvas>  <div class="info-area clearfix">'.$donut.'</div></div>';

 return filterShortcodesP($chart);

}


add_shortcode("doughnut_chart","registeDonutChart");


function registerDonutValue($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 

      "background" => "rgba(220,220,220,0.5)",
      "value" => "65",
      'label' => ''

    ), $atts)); 


$donut = "<div class='donut-val clearfix' data-fillcolor='$background'  data-value='$value'><span class='label' itemprop='name'>$label</span><span class='block' style='background-color:{$background}'></span></div>";

return filterShortcodesP($donut);

}


add_shortcode("doughnut","registerDonutValue");




function registerWordDrop($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
      "color" => "#fff",
      "background" => "#11d8d1",
      "effect" => "fade",
      

    ), $atts)); 

 
$content = "<span style='background-color:$background;color:$color;' class='way-animated word_drop' data-waycheck='$effect'> $content </span>";

return filterShortcodesP($content);

}


add_shortcode("word_drop","registerWordDrop");

/**
 * Power Title
 */

function registerPowerTitle($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
      "color" => "#11d8d1"
    ), $atts)); 

 
$content = "<div class='power-title'><h3 style='color:$color;'> $content </h3><span class='spacer'></span></div>";

return filterShortcodesP($content);

}


add_shortcode("power_title","registerPowerTitle");

/**
 * Prop Shortcode
 */

function registerPropWrap($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
      "width" => "500px",
      "height" => "500px"
    ), $atts)); 

 
$content = "<div class='prop-wrapper' style='width:{$width}px;height:{$height}px;'>".do_shortcode($content)."</div>";

return filterShortcodesP($content);

}

add_shortcode("props","registerPropWrap");

function registerProp($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
      "top" => "0px",
      "left" => "0px",
      "effect" => "fade",
      "delay" => "0",
      "image" => "",
      "link" => ""
    ), $atts)); 

 
$content = "<div class='prop' style='left:{$left}px;top:{$top}px;' data-left='{$left}' data-top='{$top}' data-effect='{$effect}' data-delay='{$delay}' ><img src='".$image."' alt='Prop Image' /></div>";

if($link!="") $content = "<a href='$link'>".$content."</a>";

return $content;

}

add_shortcode("prop","registerProp");

/**
 * Full Width
 */

function registerFullWidth($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
      "background" => "",
      "height" => "auto",
    ), $atts)); 

 
$content = "</div></div></div> <div class='page-content full-width-layout clearfix' style='height:{$height}px;background-image:url($background)' > ".do_shortcode($content)." </div> <div class='skeleton clearfix auto_align'><div class'mutual-content-wrap'><div class='page-content'> ";

return $content;

}

add_shortcode("full_width","registerFullWidth");

/**
 * Magic List
 */


function registerShortcodesMagicList($atts,$content)
{
   extract(
    shortcode_atts(array(  
      "animation" => ''

  ), $atts)); 


 $content = do_shortcode($content); 

    
 $tab = "<div class='magic-list-wrapper'><ul class='clearfix magic-list' itemscope itemtype='http://schema.org/ItemList'>".$content."</ul></div>";
  
 return $tab;

}


add_shortcode("magic_list","registerShortcodesMagicList");


function registerShortcodesMagicItem($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "title"  => "",
      "color" => "" , "icon" => "" , "image" => ""
    ), $atts)); 

 if($icon!="") :
     $icon = "<i style='color:$color;' class='$icon'></i>"; 
endif;

 if($image!="") $icon = "<img src='{$image}' alt='magic-image-item' />";
 $content = $helper->format($content);  

 $tab = "<li class='clearfix chain-link' itemscope itemtype='http://schema.org/Thing'>
            <div class='icon-area' data-color='$color'> <div class='inner-icon-area'>$icon</div> </div>
            <div class='desc-area'>
                  <h4 itemprop='name'>".stripslashes($title)." </h4>
                  <div itemprop='description' class='clearfix desc'>".$content."</div>
            </div>
         </li>";
 
 return $tab;

}


add_shortcode("magic_item","registerShortcodesMagicItem");

function registerIOAWPMLSelector($atts,$content)
{

ob_start();
   do_action('icl_language_selector');
    $temp = ob_get_contents();
 ob_end_clean();


 
 return filterShortcodesP($temp);

}


add_shortcode("wpml_selector","registerIOAWPMLSelector");


function registerIOAImgeWrapp($atts,$content)
{

 extract(
  shortcode_atts(array( 
     "src"  => "" , 'texture' => ''
    ), $atts)); 


 return "<div class='ioa-image-wrap' style='background:url($texture)'><img src='$src' alt='image' /></div>";

}


add_shortcode("image_wrapper","registerIOAImgeWrapp");

 function add_IOAbutton() {  
    
   add_filter('mce_external_plugins', 'registerIOAButtonPlugin');  
   add_filter('mce_buttons', 'registerIOAButton');  
    
}  

function registerIOAButton($buttons) {
   array_push($buttons, "ioabutton");
   return $buttons;
}
function registerIOAButtonPlugin($plugin_array) {
   $plugin_array['button'] = HURL.'/js/ioa_menu.js';
   return $plugin_array;
}

add_action('init', 'add_IOAbutton'); 



// Self Hosted Video

function registerSelfVideo($atts,$content)
{
 global $helper;
  extract(
  shortcode_atts(array( 
     "url"  => "",
     "video_fallback" => ""
    ), $atts)); 

 $code = '<div class="video-player" >
          <video poster="'.$video_fallback.'"  id="'.uniqid('vs').'" >
            <!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
          <source type="video/mp4" src="'.$url.'" />
            <!-- Flash fallback for non-HTML5 browsers without JavaScript -->
            <object width="1800" height="600" type="application/x-shockwave-flash" data="'.includes_url().'js/mediaelement/flashmediaelement.swf">
                <param name="movie" value="'.includes_url().'js/mediaelement/flashmediaelement.swf" />
                <param name="flashvars" value="controls=false&amp;file='.$url.'" />
                <!-- Image as a last resort -->
                <img src="'.$video_fallback.'" width="1800" height="600" title="No video playback capabilities"   alt="No video playback capabilities" />
            </object>
           
      </video>

    </div>';
 
 return $code;

}


add_shortcode("self_video","registerSelfVideo");


/**
 * Soundcloud Support
 */

/* Register oEmbed provider
   -------------------------------------------------------------------------- */

wp_oembed_add_provider('#https?://(?:api\.)?soundcloud\.com/.*#i', 'http://soundcloud.com/oembed', true);


/* Register SoundCloud shortcode
   -------------------------------------------------------------------------- */

add_shortcode("soundcloud", "ioasoundcloud_shortcode");


/**
 * SoundCloud shortcode handler
 * @param  {string|array}  $atts     The attributes passed to the shortcode like [soundcloud attr1="value" /].
 *                                   Is an empty string when no arguments are given.
 * @param  {string}        $content  The content between non-self closing [soundcloud]…[/soundcloud] tags.
 * @return {string}                  Widget embed code HTML
 */
function ioasoundcloud_shortcode($atts, $content = null) {

  // Custom shortcode options
  $shortcode_options = array_merge(array('url' => trim($content)), is_array($atts) ? $atts : array());

  // Turn shortcode option "param" (param=value&param2=value) into array
  $shortcode_params = array();
  if (isset($shortcode_options['params'])) {
    parse_str(html_entity_decode($shortcode_options['params']), $shortcode_params);
  }
  $shortcode_options['params'] = $shortcode_params;

  // User preference options
  $plugin_options = array_filter(array(
    'iframe' => true,
    'width'  => "100%",
    'height' =>  "166",
    'params' => array(),
  ));
  // Needs to be an array
  if (!isset($plugin_options['params'])) { $plugin_options['params'] = array(); }

  // plugin options < shortcode options
  $options = array_merge(
    $plugin_options,
    $shortcode_options
  );

  // plugin params < shortcode params
  $options['params'] = array_merge(
    $plugin_options['params'],
    $shortcode_options['params']
  );

  // The "url" option is required
  if (!isset($options['url'])) {
    return '';
  } else {
    $options['url'] = trim($options['url']);
  }

  // Both "width" and "height" need to be integers
  if (isset($options['width']) && !preg_match('/^\d+$/', $options['width'])) {
    // set to 0 so oEmbed will use the default 100% and WordPress themes will leave it alone
    $options['width'] = 0;
  }
  if (isset($options['height']) && !preg_match('/^\d+$/', $options['height'])) { unset($options['height']); }

  // The "iframe" option must be true to load the iframe widget
  $iframe = true;

  // Return html embed code
  if ($iframe) {
    return ioasoundcloud_iframe_widget($options);
  } else {
    return ioasoundcloud_flash_widget($options);
  }

}


function ioasoundcloud_url_has_tracklist($url) {
  return preg_match('/^(.+?)\/(sets|groups|playlists)\/(.+?)$/', $url);
}


function ioasoundcloud_iframe_widget($options) {

  // Merge in "url" value
  $options['params'] = array_merge(array(
    'url' => $options['url']
  ), $options['params']);

  // Build URL
  $url = 'http://w.soundcloud.com/player?' . http_build_query($options['params']);
  // Set default width if not defined
  $width = '100%';
  // Set default height if not defined
  $height = isset($options['height']) && $options['height'] !== 0 ? $options['height'] : (ioasoundcloud_url_has_tracklist($options['url']) ? '450' : '166');

  return sprintf('<iframe width="%s" height="%s" scrolling="no" frameborder="no" src="%s"></iframe>', $width, $height, $url);
}


function ioasoundcloud_flash_widget($options) {

  // Merge in "url" value
  $options['params'] = array_merge(array(
    'url' => $options['url']
  ), $options['params']);

  // Build URL
  $url = 'http://player.soundcloud.com/player.swf?' . http_build_query($options['params']);
  // Set default width if not defined
  $width = isset($options['width']) && $options['width'] !== 0 ? $options['width'] : '100%';
  // Set default height if not defined
  $height = isset($options['height']) && $options['height'] !== 0 ? $options['height'] : (soundcloud_url_has_tracklist($options['url']) ? '255' : '81');

  return preg_replace('/\s\s+/', "", sprintf('<object width="%s" height="%s">
                                <param name="movie" value="%s"></param>
                                <param name="allowscriptaccess" value="always"></param>
                                <embed width="%s" height="%s" src="%s" allowscriptaccess="always" type="application/x-shockwave-flash"></embed>
                              </object>', $width, $height, $url, $width, $height, $url));
}