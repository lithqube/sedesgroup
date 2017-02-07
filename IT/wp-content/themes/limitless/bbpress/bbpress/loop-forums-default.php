<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>

<ul id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-forums">

	<li class="bbp-header">

		<ul class="forum-titles clearfix">
			<li class="bbp-forum-info"><span><?php _e( 'Forum', 'bbpress' ); ?></span></li>
			<li class="bbp-forum-topic-count"><span><?php _e( 'Topics', 'bbpress' ); ?></span></li>
			<li class="bbp-forum-reply-count"><span><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></span></li>
			<li class="bbp-forum-freshness"><span><?php _e( 'Freshness', 'bbpress' ); ?></span></li>
		</ul>

	</li><!-- .bbp-header -->

	<li class="bbp-body clearfix">

		<?php while ( bbp_forums() ) : bbp_the_forum(); ?>

			<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>

		<?php endwhile; ?>

	</li><!-- .bbp-body -->

	<li class="bbp-footer">

		<div class="tr">
			<p class="td colspan4">&nbsp;</p>
		</div><!-- .tr -->

	</li><!-- .bbp-footer -->

</ul><!-- .forums-directory -->

<?php do_action( 'bbp_template_after_forums_loop' ); ?>
