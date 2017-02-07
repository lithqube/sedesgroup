<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(bbp_get_forum_id(), array( 'clearfix' )); ?>>

	<li class="bbp-forum-info">
	<div>
		

		<?php do_action( 'bbp_theme_before_forum_title' ); ?>

		<h4><a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></h4>

		<?php do_action( 'bbp_theme_after_forum_title' ); ?>
		
		<div class="clearfix sub-forums-tree">
			<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>
				<?php bbp_list_forums(array (
        'before'              => '<ul class="bbp-forums-list clearfix">',
        'after'               => '</ul>',
        'link_before'         => '<li class="bbp-forum"><i class="ioa-front-icon right-circled2icon-"></i>',
        'link_after'          => '</li>',
        'count_before'        => ' (',
        'count_after'         => ')',
        'count_sep'           => ', ',
        'separator'           => ', ',
        'forum_id'            => '',
        'show_topic_count'    => true,
        'show_reply_count'    => true,
        )); ?>
			<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>
		</div>	

		<?php do_action( 'bbp_theme_before_forum_description' ); ?>

		<div class="bbp-forum-content"><?php bbp_forum_content(); ?></div>

		<?php do_action( 'bbp_theme_after_forum_description' ); ?>

		<?php bbp_forum_row_actions(); ?>
		</div>
	</li>

	<li class="bbp-forum-topic-count"><div><?php bbp_forum_topic_count(); ?></div></li>

	<li class="bbp-forum-reply-count"><div><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></div></li>

	<li class="bbp-forum-freshness">
		<div>
		<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>

		<?php bbp_forum_freshness_link(); ?>

		<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>

		<p class="bbp-topic-meta">

			<?php do_action( 'bbp_theme_before_topic_author' ); ?>
			
			<span class="bbp-topic-freshness-author">
				<?php if( bbp_get_forum_last_active_id() > 0) echo "by"; ?> 
				<?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'type' => 'name' ) ); ?>
			</span>

			<?php do_action( 'bbp_theme_after_topic_author' ); ?>

		</p>
		</div>
	</li>

</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
