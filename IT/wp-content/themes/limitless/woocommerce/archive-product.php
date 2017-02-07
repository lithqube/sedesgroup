<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $ioa_meta_data,$helper;

$id = false;
if( is_shop() )
{
	$id =  get_option('woocommerce_shop_page_id'); 
	$ioa_meta_data['woo_id'] = $id;
}

$helper->preparePage($id);

if(!isset($ioa_meta_data['layout'])) $ioa_meta_data['layout'] = 'full';

$ioa_meta_data['woo_height'] = 200;
$ioa_meta_data['woo_width'] = 235;

get_header(); 

if(!isset($ioa_meta_data['featured_media_type'])) $ioa_meta_data['featured_media_type'] = 'none';

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


$page_wrapper_classes = array("page-wrapper woo-shop "   );

if(!isset($ioa_meta_data['hasbottom'])) $page_wrapper_classes[] = 'no-bottom-bar '; 
if(isset($ioa_meta_data['show_title']) && $ioa_meta_data['show_title']=="no" ) $page_wrapper_classes[] = 'no-title ';  
if($ioa_meta_data['featured_media_type']=="none" || ($ioa_meta_data['featured_media_type']=="image" && ! has_post_thumbnail($id)) ) $page_wrapper_classes[] = 'no-media ';  

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

	

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<div class="shop-controls clearfix">
				<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			</div>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
	
	</div>

		<?php  get_sidebar(); ?>
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