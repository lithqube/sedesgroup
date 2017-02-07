<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

	<li class="bbp-topic-title">
	 <div>
		<?php if ( bbp_is_user_home() ) : ?>

			<?php if ( bbp_is_favorites() ) : ?>

				<span class="bbp-row-actions">
				
					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php bbp_topic_favorite_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</span>

			<?php elseif ( bbp_is_subscriptions() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php bbp_topic_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</span>

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_topic_title' ); ?>

		<div class="topic-title-area clearfix">
			<h4> <a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a></h4>
		</div>
		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		<?php bbp_topic_pagination(); ?>

		

		<?php bbp_topic_row_actions(); ?>
	</div>
	</li>

	<li class="bbp-topic-voice-count"><div><?php bbp_topic_voice_count(); ?></div></li>

	<li class="bbp-topic-reply-count"><div><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></div></li>

	<li class="bbp-topic-freshness"><div>

		<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>

		<?php bbp_topic_freshness_link(); ?>

		<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>

		<p class="bbp-topic-meta">

			<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>

			<span class="bbp-topic-freshness-author"> <?php if( bbp_get_topic_last_active_id() > 0) echo 'by'; ?> <?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'type' => 'name' ) ); ?></span>

			<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>

		</p></div>
	</li>

</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
