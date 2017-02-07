<?php
/**
 * The Content Header Template 
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */
global $super_options , $helper, $ioa_meta_data;

$d = get_option(SN.'_header_construction_data');
$data = $d;

//if( ! is_home() &&! is_404() && ! is_archive()  && get_post_meta(get_the_ID(),'ioaheader_data',true)!=""   ) 
 // $data = get_post_meta($post->ID,'ioaheader_data',true);

$widgets = $data[1];

$default_filler_left = array( "val" => "logo" , "align" => "default" , "margin" => "0:0:0:0" , "name" => "Logo"  );
$default_filler_right = array( "val" => "main-menu" , "align" => "default" , "margin" => "0:0:0:0" , "name" => "Menu 1"  );
$default_filler_right1 = array( "val" => "search" , "align" => "default" , "margin" => "6:0:0:0" , "name" => "Search Bar"  );
$default_widgets = array(
      "menu-area" =>  array('eye' => 'on', 'height' => "" , "position" =>"static","container" => "menu-area" , 'data' => array( array('align' => 'left', 'elements' => array( $default_filler_left) ),  array('align' => 'center', 'elements' => array() ) ,  array('align' => 'right', 'elements' => array( $default_filler_right1 , $default_filler_right) )) ),
  );

if(!isset($widgets) || count($widgets)==0)   
    $widgets =  $default_widgets ;
else
   {
    if(is_array($widgets))
     foreach ($widgets as $w) {
        $temp_w[$w['container']] = $w;
      } 
   }

$ioa_meta_data['main_menu'] = '';
ob_start();
 if(function_exists("wp_nav_menu"))
  {
      wp_nav_menu(array(
                  'theme_location'=>'top_menu1_nav',
                  'container'=>'',
                  'depth' => 3,
                  'menu_class' => 'menu clearfix',
                  'fallback_cb' => false,
                  'walker' => new ioa_Menu_Frontend()
                   )
                  );
  } 
$ioa_meta_data['main_menu']= ob_get_contents();
ob_end_clean();

?>

<?php if($super_options[SN.'_cmenu_enable']!="false"    ) : ?>
 <div class="compact-bar theme-header clearfix">
    <div class="skeleton auto_align clearfix" itemscope itemtype='http://schema.org/SiteNavigationElement'>

      <a href="<?php echo home_url('/'); ?>" id="clogo" >
            <img src="<?php echo $super_options[SN."_clogo"]; ?>" alt="compact logo" />
      </a> 


      <div class="menu-wrapper" data-effect="<?php echo $super_options[SN.'_submenu_effect']; ?>" > 
             <div class="menu-bar">
               <div class="clearfix ">
                     <?php echo $ioa_meta_data['main_menu']; ?>
               </div>
          </div>
      </div>


    </div>  
 </div>
<?php endif; ?>

<div class="mobile-head">
    
    <a href="" class=" ioa-front-icon menuicon- mobile-menu"></a>
    <a href="<?php echo home_url('/'); ?>" id="mobile-logo" class='center' style='max-width:<?php echo $super_options[SN.'_logo_width'] ?>px'>
                <img src="<?php echo $super_options[SN."_clogo"]; ?>" alt="logo" />
    </a> 
   <a href="" class="majax-search-trigger search-3icon- ioa-front-icon" ></a>
</div>


<div data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" class='majax-search ' >
                                      
                <div class="majax-search-pane">
                   <a href="" class="majax-search-close ioa-front-icon cancel-2icon-"></a>
                    
                    <div class="form">
                       <form role="search" method="get"  action="<?php echo home_url('/' ); ?>">
                          <div>
                              <input type="text"  autocomplete="off" name="s" class='live_search' value="<?php _e('Type something..','ioa') ?>" />
                              <input type="submit"  value="Search" />
                              <span class="msearch-loader"></span>
                          </div>
                      </form>
                    </div>
                    <div class="msearch-results clearfix">
                      <ul>
                       
                      </ul>
                    </div>
                </div>

       </div> 
<?php  
   if($super_options[SN.'_res_menu']!="side")
    {      if(function_exists("wp_nav_menu"))
          {
              wp_nav_menu(array(
                          'theme_location'=>'top_menu1_nav',
                          'container'=>'',
                          'depth' => 3,
                          'menu_class' => 'menu clearfix',
                          'menu_id' => 'mobile-menu',
                          'fallback_cb' => false
                           )
                          );
          }
     }
     else
     {
        ?> <div class="mobile-side-wrap"> <?php
        if(function_exists("wp_nav_menu"))
          {
              wp_nav_menu(array(
                          'theme_location'=>'top_menu1_nav',
                          'container'=>'',
                          'depth' => 3,
                          'menu_class' => 'menu clearfix',
                          'menu_id' => 'mobile-side-menu',
                          'fallback_cb' => false
                           )
                          );
          }
          ?> </div> <?php   
      } 
?>

<div class="theme-header "  itemscope itemtype="http://schema.org/WPHeader" >
  <div class="header-cons-area">
<?php 
$testable = array(); $lock = false;

if(is_array($widgets))
foreach($widgets as $widget)
{
  if(isset($widget['eye']) && $widget['eye']!="off")
  $testable[] = $widget['container'];
}


if(is_array($widgets))
foreach($widgets as $widget)
        {
          $w = 'static'; if(isset( $widget['position'])) $w =  $widget['position']; 
          
         
          if(isset($widget['eye']) && $widget['eye']!="off")
          switch($widget['container'])
          {

            case 'top-area' : ?>
                
                <div id="top-bar" style="<?php  if($widget['height']!="0" && $widget['height']!="") echo 'padding:'.$widget['height'].'px 0px;' ?>"  class="clearfix  <?php  echo 'header-cons-'.$w; ?> header-construtor">

                  <div class="<?php if($super_options[SN.'_menu_layout']!="fluid") echo 'skeleton'; else echo 'fluid-layout' ?> auto_align clearfix" itemscope itemtype='http://schema.org/SiteNavigationElement'>

                       <?php 
                            foreach($widget['data'] as $holder) 
                            {
                               $def = ' top_layers ';
                              if($holder['align']=="full") $def = 'full-area';
                              if($holder['align'] == "full" || $holder['align'] == "center") $def .= ' menu-centered';
                              
                                if(isset($holder['elements']) && count($holder['elements']) > 0 ) :
                              ?>

                              <div class="<?php echo $def.' '.$holder['align'] ?> clearfix">
                                <?php
                                  
                                    foreach($holder['elements'] as $el)
                                    {
                                      getComponent($el);
                                    }
                                     ?>
                              </div>

                              <?php
                                endif;
                            }
                             ?> 
                    </div>
                    <span class="border"></span>
                </div>

            <?php    break;
            case 'menu-area' :  ?>
               <div  data-offset-top="0"  class="top-area-wrapper  <?php  echo 'header-cons-'.$w; ?>"  >
                <div class="top-area  header-construtor" style="<?php  if($widget['height']!="0" && $widget['height']!="") echo 'padding:'.$widget['height'].'px 0px;' ?>" >
                   <div class="clearfix <?php if($super_options[SN.'_menu_layout']!="fluid") echo 'skeleton'; else echo ' fluid-menu '; ?>  auto_align" itemscope itemtype='http://schema.org/SiteNavigationElement'>
                     <?php 
                            foreach($widget['data'] as $holder) 
                            {
                              $def = ' menu_layers ';
                              if($holder['align']=="full") $def = 'full-area';
                              if($holder['align'] == "full" || $holder['align'] == "center") $def .= ' menu-centered';
                              
                                if(isset($holder['elements']) && count($holder['elements']) > 0 ) :
                              ?>
                              <div class="<?php echo $def.' '.$holder['align'] ?> clearfix">
                                <?php
                                    foreach($holder['elements'] as $el)
                                    {
                                       getComponent($el);
                                    }
                                     ?>
                              </div>

                              <?php
                                endif;

                            }
                             ?> 


                  </div>
                
                  </div>  
                


                </div>

            <?php   break;
            case 'top-full-area' : ?>
               <div  data-offset-top="0"  class=" bottom-area <?php  echo 'header-cons-'.$w; ?>"  >
                <div class="top-area  header-construtor" style="<?php  if($widget['height']!="0" && $widget['height']!="") echo 'padding:'.$widget['height'].'px 0px;' ?>" >
                   <div class="clearfix <?php if($super_options[SN.'_menu_layout']!="fluid") echo 'skeleton'; ?>  auto_align" itemscope itemtype='http://schema.org/SiteNavigationElement'>
                     <?php 
                            foreach($widget['data'] as $holder) 
                            {
                              $def = ' menu_layers ';
                              if($holder['align']=="full") $def = 'full-area';
                              if($holder['align'] == "full" || $holder['align'] == "center") $def .= ' menu-centered';
                              
                                if(isset($holder['elements']) && count($holder['elements']) > 0 ) :
                              ?>
                              <div class="<?php echo $def.' '.$holder['align'] ?> clearfix">
                                <?php
                                    foreach($holder['elements'] as $el)
                                    {
                                       getComponent($el);
                                    }
                                     ?>
                              </div>

                              <?php
                                endif;
                              
                            }
                             ?> 


                  </div>
                
                  </div>  
                


                </div>

            <?php   break;
          }
              
         
        }
        

      function getComponent($el)
      {
        global $helper,$super_options,$ioa_meta_data;
        $val = $el['val'];
        $m = $el['margin']; 
       
        if($m!="0:0:0:0")
         {
           $m = str_replace(":","px ",$m);
          $m .= "px;";
          $m = 'padding:'.$m;
         }
         else
          $m = '';

      
        
        switch($val)
              {
                case 'logo' : $logo = $super_options[SN."_logo"]; 
                $rlogo = "";

                if($super_options[SN."_rlogo"]!="")   $rlogo = $super_options[SN."_rlogo"];
              ?>
                                  <a href="<?php echo home_url('/'); ?>" id="logo" class='<?php echo $el['align'] ?>' style='<?php echo $m ?>;max-width:<?php echo $super_options[SN.'_logo_width'] ?>px'>
                                      <img src="<?php echo $logo; ?>" alt="logo" data-retina="<?php echo $rlogo; ?>" />
                                  </a> 
                              <?php break;
                case 'text' : if(isset($el['text'])) : ?>
                               <div class="top-text <?php echo $el['align'] ?>" style='<?php echo $m ?>'> <?php  echo stripslashes(do_shortcode($el['text'])); ?> </div>
                              
                              <?php endif; break;  
               case 'wpml' : if(function_exists('icl_get_languages') ) : ?>
                               <div class="wpml-selector <?php echo $el['align'] ?>" style='<?php echo $m ?>'> 
                                    <a href="" class="wpml-lang-selector clearfix"> <i class="ioa-front-icon globe-3icon-"></i><span><?php _e('Select Language','ioa'); ?></span> </a>
                                    <ul>
                                      <i class="ioa-front-icon up-dir-1icon-"></i>
                                    <?php 
                                    $languages =icl_get_languages('skip_missing=0&orderby=KEY&order=DIR');
                                    $i=0; $cl = '';
                                    $langs = array();

                                      foreach($languages as $l){
                                       
                                          $cl = '';
                                            if($i==0) $cl = 'first-c';
                                            else if($i == count($languages)-1) $cl = 'last';
                                              $langs[] = '<li  class="'.$cl.'"><a href="'.$l['url'].'">  '.$l['translated_name'].'</a></li>';

                                     
                                        $i++; 
                                        
                                      }
                                      echo join('', $langs);
                                   
                                     ?>
                                     </ul>
                               </div>
                              
                              <?php endif; break;                
                case 'top-menu' : 
                                ?>  <div class="menu-wrapper <?php echo $el['align'] ?>" style='<?php echo $m ?>' data-effect="<?php echo $super_options[SN.'_submenu_effect']; ?>"  > 
                                       <div class="menu-bar">
                                         <div class="clearfix ">
                                               <?php  
                                              
                                                        if(function_exists("wp_nav_menu"))
                                                        {
                                                            wp_nav_menu(array(
                                                                        'theme_location'=>'top_menu2_nav',
                                                                        'container'=>'',
                                                                        'depth' => 3,
                                                                        'menu_class' => 'menu clearfix',
                                                                        'menu_id' => 'menu2',
                                                                        'fallback_cb' => false,
                                                                        'walker' => new ioa_Menu_Frontend()
                                                                         )
                                                                        );
                                                        }
                                               ?>
                                        
                                       </div>
                                    </div>
                                    </div>
                                 <?php break; 
                case 'main-menu' : ?>
            
                                   <div class="menu-wrapper <?php echo $el['align'] ?>" data-effect="<?php echo $super_options[SN.'_submenu_effect']; ?>" style='<?php echo $m ?>'> 
                                       <div class="menu-bar">
                                         <div class="clearfix ">
                                              <?php echo $ioa_meta_data['main_menu']; ?>
                                       </div>
                                    </div>
                                    </div>
                                 <?php break;   
                case 'social' : ?>
                                
                                    <ul class="top-area-social-list clearfix <?php echo $el['align'] ?>" style='<?php echo $m ?>'>
                                      <?php  
                                      $new_blank = '';

                                      if(isset($el['link'])  && $el['link'] == 'true' )  $new_blank = 'target="_BLANK"';

                                      if(isset($el['text'])) :

                                          $ls = explode( "<sc>" , stripslashes($el['text']) );
                                          foreach($ls as $item)
                                          {
                                            $te = explode("<vc>",$item);
                                            if($item!="")
                                            echo "<li><a  $new_blank  class='".$te[0]."' href='".$te[1]."'> <span class='proxy-color'><img src='".URL.'/sprites/i/sc/'.$te[0].".png' alt='social icon'/></span> <img src='".URL.'/sprites/i/sc/inv/'.$te[0].".png' alt='social icon'/></a></li>";
                                          } 
                                      endif;
                                      ?>
                                    </ul>
                                 
                                 
                                  <?php break;
                case 'search' :  ?>
                                  <div style='<?php echo $m ?>' data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" class='ajax-search <?php echo $el['align'] ?>' >
                                      
                                      <a href="" class="ajax-search-trigger ioa-front-icon search-3icon-" ></a>
                                      <div class="ajax-search-pane">
                                         <a href="" class="ajax-search-close ioa-front-icon cancel-2icon-"></a>
                                         <span href="" class="up-dir-1icon- ioa-front-icon tip"></span>
                                          
                                          <div class="form">
                                             <form role="search" method="get"  action="<?php echo home_url('/' ); ?>">
                                                <div>
                                                    <input type="text"  autocomplete="off" name="s" class='live_search' value="<?php _e('Type something..','ioa') ?>" />
                                                    <input type="submit"  value="Search" />
                                                    <span class="search-loader"></span>
                                                </div>
                                            </form>
                                          </div>
                                          <div class="search-results clearfix">
                                            <ul>
                                             
                                            </ul>
                                          </div>
                                      </div>

                                  </div> 
                                  <?php break; 
                case 'tagline' : ?>
                                  <h6 class="custom-font tagline <?php echo $el['align'] ?>" style='<?php echo $m ?>'><?php echo get_bloginfo('description'); ?></h6>
                                  <?php break;                                               
                                                                       
              }
      }  
 ?>

<?php 
       
      // Title for Posts/Pages  
    
    

                switch($super_options[SN.'_head_shadow'])
                {
                   case "Type 1" : ?> <div class="skeleton  header-shadow-area  auto_align"><span class="menu_shadow_type1"></span>  </div><?php break;
                   case "Type 2" : ?> <div class="skeleton  header-shadow-area auto_align"><span class="menu_shadow_type2"></span> </div> <?php break;
                   case "Type 3" : ?> <div class="skeleton  header-shadow-area auto_align"><span class="sh_left_wing"></span> </div> <?php break;
                   case "Type 4" : ?> <div class="skeleton  header-shadow-area auto_align"><span class="sh_right_wing"></span> </div> <?php break;
                   case "Type 5" : ?> <div class="skeleton  header-shadow-area auto_align"><span class="sh_left_wing"></span><span class="sh_right_wing"></span> </div> <?php break;
                }

                ?>

 
</div> 
<?php get_template_part('templates/content-title'); 
 
 ?>

</div> <!-- END OF THEME HEADER ~~ Top Bar + Menu + Title -->


<!--
 Below Title Layout Sidebar
-->

<?php  if(isset($ioa_meta_data['layout']) && $ioa_meta_data['layout']=="below-title") : ?>

 <div itemscope itemtype='http://schema.org/WPSideBar' class="sidebar <?php echo $ioa_meta_data['layout']; ?>" id="sidebar"><!-- start of one-third column -->
  
 <div class="skeleton auto_align clearfix">
    <?php 
   
  
    if ($ioa_meta_data['layout']!="none" && trim($ioa_meta_data['layout'])!=""  ) {
      dynamic_sidebar ($ioa_meta_data['sidebar']); 
    }
    else  {
      dynamic_sidebar ("Blog Sidebar"); 
    }

  
  ?>  
 </div>
</div>


<?php  endif; ?>

<?php 

$ioa_options = "";

if( is_single() || is_page() ) $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );

if($ioa_options =="" && ( is_page() || is_single() ))
{
  $old_values  = get_post_custom(get_the_ID());
  $ioa_options = array();
  
  foreach ($old_values as $key => $value) {
    if($key!='rad_data' && $key!='rad_styler')
    {
      $ioa_options[$key] = $value[0];
    }
  }
}  

$show_title= '';
if(isset($ioa_options['show_title'])) $show_title =  $ioa_options['show_title'];


if( !is_home() && ! is_404() && $show_title !="no" ) : ?>
<div class="mobile-title">
    <h2 class="custom-title" ><?php echo $ioa_meta_data['title']; ?></h2>
</div>
<?php endif; ?>