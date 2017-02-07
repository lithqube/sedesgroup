<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_replies_loop' ); ?>


<div class="bbp-pagination-count">
		<?php bbp_topic_pagination_count(); ?>
		<div class="title_line"></div>	

		<div class="clearfix topic-top-nav">
	<?php bbp_topic_subscription_link(); ?>
	<?php bbp_user_favorites_link(); ?>
</div>


	</div>


<ul id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies clearfix">

	
	<li class="bbp-body clearfix">

		<?php if ( bbp_thread_replies() ) : ?>

			<?php bbp_list_replies(); ?>

		<?php else : ?>

			<?php while ( bbp_replies() ) : bbp_the_reply(); ?>

				<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</li><!-- .bbp-body -->

	

</ul><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_replies_loop' ); ?>
