<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_topics_loop' ); ?>

<div class="bbp-pagination-count">

		<?php bbp_forum_pagination_count(); ?>
		<div class="title_line"></div>	
</div>
	
<ul id="bbp-forum-<?php bbp_forum_id(); ?>" class="bbp-topics clearfix">

	<li class="bbp-header">

		<ul class="forum-titles clearfix">
			<li class="bbp-topic-title"> <span><i class='ioa-ti ti-comments '></i> <?php _e( 'Topic', 'ioa' ); ?></span></li>
			<li class="bbp-topic-voice-count"><span><?php _e( 'Voices', 'ioa' ); ?></span></li>
			<li class="bbp-topic-reply-count"><span><?php bbp_show_lead_topic() ? _e( 'Replies', 'ioa' ) : _e( 'Posts', 'ioa' ); ?></span></li>
			<li class="bbp-topic-freshness"><span><?php _e( 'Freshness', 'ioa' ); ?></span></li>
		</ul>

	</li>

	<li class="bbp-body clearfix">

		<?php while ( bbp_topics() ) : bbp_the_topic(); ?>

			<?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

		<?php endwhile; ?>

	</li>

</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->

<?php do_action( 'bbp_template_after_topics_loop' ); ?>
