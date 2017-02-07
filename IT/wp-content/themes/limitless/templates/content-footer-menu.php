<?php
/**
 * The template used for generating ending markup for framework
 *
 * @package WordPress
 * @subpackage Titan Themes
 * @since Hades Framework V5
 */

// == ~~ To use native variables global is required ================================
global $super_options,$helper;     

?>

 <?php  if( $super_options[SN."_footer_menu"]=="Yes") : ?>
<div id="footer-menu">
    <div  class=" clearfix  skeleton auto_align "  itemscope itemtype='http://schema.org/SiteNavigationElement'>
   
             <p class="footer-text">  <?php echo $helper->format($super_options[SN."_footer_text"],false,false,false); ?> </p> 
              
              <?php
                      if(function_exists("wp_nav_menu"))
                      {
                          wp_nav_menu(array(
                                      'theme_location'=>'footer_nav',
                                      'container'=>'ul',
                                      'depth' => 1,
									                    'fallback_cb' => false
                                      )
                                      );
                      }
					  
               ?>
      </div>  
   </div>
  <?php endif; ?> 
  