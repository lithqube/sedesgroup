<?php 
/**
 * The Template for Under Construction. This is an
 * independent template. Complete structure is inside
 * the template only.
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */


global $super_options;

function uc_footer_scripts()
{
	
   	
   	wp_enqueue_script('ext', URL.'/sprites/js/ext.js','jquery');
   	wp_enqueue_script('jquery-uc', URL.'/sprites/js/uc.js','jquery');

   	wp_dequeue_script('custom');	
	
	wp_dequeue_style('widgets');	
	wp_dequeue_style('style');
	wp_dequeue_style('video');

	wp_dequeue_script('jquery-ui-tabs');
	wp_dequeue_script('jquery-ui-accordion');
	wp_dequeue_script('jquery-ui-sortable');
	
	wp_dequeue_script('bootstrap');
	wp_dequeue_script('jquery-selene');
	wp_dequeue_script('jquery-quartz');
	wp_dequeue_script('jquery-bxslider');
	wp_dequeue_script('jquery-video');
	wp_dequeue_script('jquery-isotope');
	wp_dequeue_script('jquery-color');

	wp_enqueue_style('uc',URL.'/sprites/stylesheets/uc.css');

}
add_action('wp_footer','uc_footer_scripts');
 ?>
<!DOCTYPE html>

<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->

<html <?php language_attributes(); ?>>

<?php global $super_options; ?>
<head> <!-- Start of head  -->

	<meta charset="utf-8">
    

	<title>Under Construction</title>
	<link rel="shortcut icon" href="<?php echo $super_options[SN."_favicon"]; ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" /><!-- Feed  -->
  	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
   	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,800' rel='stylesheet' type='text/css'>
	<style type="text/css">
	 <?php 
	 	if($super_options[SN.'_uc_bg']!="")
	 	{
	 		echo " div.main-uc-area { background-image:url(".$super_options[SN.'_uc_bg']."); background-position:top center; background-size:cover; } ";
	 	}	
	  ?>
	</style>
	<?php 
	 wp_print_scripts('jquery');
	 ?>			

</head> <!-- End of Head -->

 
<body itemscope itemtype="http://schema.org/WebPage"> <!-- Start of body  -->

<img src="<?php echo $super_options[SN."_logo"]; ?>" alt="logo" id="logo"/>

<div class="main-uc-area clearfix <?php if($super_options[SN.'_uc_bg_animate']!="false") echo 'animate-uc-area' ?>">
	<div class="uc-content-area ">
		<h1 class="title"><?php echo stripslashes($super_options[SN."_uc_title"]); ?></h1>
	 	<div class="uc-text clearfix"> <?php echo do_shortcode(stripslashes($super_options[SN."_uc_text"])); ?> </div>
		<div class="radial-chart" data-bar_color="<?php echo $super_options[SN.'_uc_barcolor'] ?>"  data-percent="<?php echo $super_options[SN.'_uc_progress'] ?>"  data-line_width="40" data-width="<?php echo $w['width'] ?>"  ><?php echo $super_options[SN.'_uc_progress']."%" ?></div>	
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>