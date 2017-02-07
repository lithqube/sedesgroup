<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product,$helper;

if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
	return;
?>

	<?php if ( $rating_count = $product->get_average_rating()  ) : ?>

	
	<?php  
		
		echo $helper->getRating($rating_count);

	?>	

<?php endif; ?>