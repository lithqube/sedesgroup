<?php 
/**
 * The Header for the theme.
 *
 * Displays all of the <head> section and everything up till container title.
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */ 
global $super_options, $rad_flag, $ioa_meta_data; 
/**
 * Enigma Conditional Check
 * Only works if user is logged in and has admin permissions.
 */

if( isset($_GET['enigma'])  &&  current_user_can('delete_pages') )
{

  get_template_part("templates/enigma");
  die(); // Don't worry, it's for Styler mode only.
}

/**
 * Maintaince Mode. Only Admin can view the website
 * when maintainence mode is activated from options panel.
 */

if(isset($super_options[SN.'_uc_mode']) && $super_options[SN.'_uc_mode']=="true" && ! current_user_can('delete_pages') )
{
  get_template_part("templates/under_construction");
  die(); 
}
 
if(!isset($ioa_meta_data['ioa_custom_template'])) $ioa_meta_data['ioa_custom_template'] = 'default';
$testDemoFlag = false; 


?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>
 

<head> <!-- Start of head  -->

  <meta charset="utf-8">

   <?php if($super_options[SN.'_mobile_view']!="false") : ?> 
         <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
   <?php else: ?>
         <meta name="viewport" content="width=1140"> 
   <?php endif; ?>
       
        

    
  <title><?php /* Custom Hook */ if($super_options[SN.'_seo']!="false") IOA_title(); else wp_title(); ?></title>
  
   
  <link rel="shortcut icon" href="<?php echo $super_options[SN."_favicon"]; ?>" />
  <link rel='tag' id='shortcode_link' href='<?php echo HURL ?>' />
<?php if($super_options[SN."_ipad_retina_icon_logo"]!="") : ?><link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $super_options[SN."_ipad_retina_icon_logo"]; ?>"> <?php endif; ?>
<?php if($super_options[SN."_iphone7_retina_icon_logo"]!="") : ?><link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $super_options[SN."_iphone7_retina_icon_logo"]; ?>"> <?php endif; ?>
<?php if($super_options[SN."_iphone_retina_icon_logo"]!="") : ?><link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $super_options[SN."_iphone_retina_icon_logo"]; ?>"> <?php endif; ?>
<?php if($super_options[SN."_ipad_icon_logo"]!="") : ?><link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $super_options[SN."_ipad_icon_logo"]; ?>"> <?php endif; ?>
<?php if($super_options[SN."_generic_touch"]!="") : ?><link rel="apple-touch-icon-precomposed" href="<?php echo $super_options[SN."_generic_touch"]; ?>"> <?php endif; ?>

  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" /><!-- Feed  -->
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  

  <?php if ( is_singular() && get_option( 'thread_comments' ) )  wp_enqueue_script( 'comment-reply' );    ?>
    

  <!--[if IE 9]>
      <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/sprites/stylesheets/ie9.css" />
  <![endif]-->  
  
  <!--[if IE 8]>
      <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/sprites/stylesheets/ie8.css" />
      <script type='text/javascript' src='<?php echo URL; ?>/sprites/js/excanvas.js'></script>
  <![endif]--> 

  <!--[if IE 7]>
      <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/sprites/fonts/font-awesome-ie7.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/sprites/stylesheets/ie7.css" />
      <script type='text/javascript' src='<?php echo URL; ?>/sprites/js/excanvas.js'></script>
  <![endif]--> 

  <script type="text/javascript">
    <?php  echo stripslashes($super_options[SN."_headjs_code"]);  ?>

  </script>
        <?php  
             IOA_head(); // Custom Hook  
              wp_head(); 
        ?>    
</head> <!-- End of Head -->

 
<body <?php  body_class( 'style-'.get_option(SN.'_active_etemplate')); ?> itemscope itemtype="http://schema.org/WebPage" > <!-- Start of body  -->




<?php IOA_body_start(); // Custom Hook ?>

<div class="super-wrapper  <?php if($super_options[SN.'_top_loader'] == 'false') echo 'no-np-loader'; ?>  clearfix">
  <div class="inner-super-wrapper <?php if( ( (isset($super_options[SN.'_boxed_layout']) && $super_options[SN.'_boxed_layout']=="true") || $ioa_meta_data['ioa_custom_template']=='ioa-template-blank-page' ) || $testDemoFlag ) echo 'ioa-boxed-layout' ?>" >  

<?php 

if($ioa_meta_data['ioa_custom_template']!='ioa-template-blank-page')
      get_template_part('templates/header-template');
?>

