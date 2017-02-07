<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$helper->preparePage();
get_header('shop');

$ioa_meta_data['woo_height'] = 200;
$ioa_meta_data['woo_width'] = 235;
/**
 * Full Width Featured Media Items will appear here. 
 * Note the switches are for condition checking on featured media Full or Contained. 
 */
if(! post_password_required())  // Check if Page is password protected

	switch($ioa_meta_data['featured_media_type'])
	{
		case "slider-full" :
		case "slider-contained" :
		case "slideshow-contained" :
		case "none-full" :
		case 'image-parallex' : 
		case 'slider-manager' :
		case 'rev_slider' :
		case 'image-full' : $ioa_meta_data['gr'] = true; get_template_part('templates/content-featured-media'); break;
	}


$page_wrapper_classes = array("page-wrapper woo-single-product "   );

if(!isset($ioa_meta_data['hasbottom'])) $page_wrapper_classes[] = 'no-bottom-bar '; 
if(isset($ioa_meta_data['show_title']) && $ioa_meta_data['show_title']=="no" ) $page_wrapper_classes[] = 'no-title ';  
if($ioa_meta_data['featured_media_type']=="none" || ($ioa_meta_data['featured_media_type']=="image" && ! has_post_thumbnail()) ) $page_wrapper_classes[] = 'no-media ';  
if( ! in_array('no-media',$page_wrapper_classes) )  $page_wrapper_classes[] = $ioa_meta_data['featured_media_type'].'-media';

if(isset($ioa_meta_data['full_media'] )) $page_wrapper_classes[] = 'has-full-media';


	?>


	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
	?>


	<div class="<?php echo implode(' ',$page_wrapper_classes); ?>">
		
		<div class="skeleton clearfix auto_align">
		<div class="mutual-content-wrap <?php  if($ioa_meta_data['layout']!="full") echo 'sidebar-layout has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
			<?php  
				/**
				 * Featured Media Items contained by parent width will appear here. 
				 */
				if(! post_password_required()) // Check if Page is password protected
			 	switch($ioa_meta_data['featured_media_type'])
			 	{
			 		case 'slider' :
			 		case 'slideshow' :
			 		case 'video' :
			 		case 'proportional' :
			 		case 'none-contained' :
			 		case 'image' : get_template_part('templates/content-featured-media'); break;
			 	}
			?>


		<?php while ( have_posts() ) : the_post(); ?>

			<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>
	
		</div>

		<?php get_sidebar(); ?>
	</div>


	</div>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>

<?php get_footer('shop'); ?>