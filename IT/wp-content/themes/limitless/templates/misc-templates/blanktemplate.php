<?php

 /**
 * The Template for displaying Pages and registered Custom Templates.
 * Theme uses concept of Flexi Templates not dependent on custom type
 * slug to select template.
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */

global $helper, $ioa_meta_data,$post,$super_options;
$helper->preparePage();
?>   



<div class="page-wrapper landing-template skeleton auto_align <?php echo get_post_type() ?>">
	<div class="skeleton clearfix auto_align">

		<div class="mutual-content-wrap <?php if($ioa_meta_data['layout']!="full" && $ioa_meta_data['layout']!="below-title" && $ioa_meta_data['layout']!="above-footer") echo 'sidebar-layout has-sidebar has-'.$ioa_meta_data['layout'];  ?>">

			<?php  if(have_posts()): while(have_posts()) : the_post(); ?>
				<?php if(get_the_content()!="") : ?>
					<div class="page-content clearfix">
						<?php  the_content(); ?>
					</div>

				<?php endif; ?>

			<?php endwhile; endif; ?>
			<?php if( $super_options[SN.'_page_comments'] =="true" ) comments_template(); ?>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>