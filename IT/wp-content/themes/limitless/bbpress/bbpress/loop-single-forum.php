<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */
global $helper;
$image = get_post_meta(bbp_get_forum_id(),'image',true);
$depth = count(get_post_ancestors(bbp_get_forum_id())); 
?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(bbp_get_forum_id(), array( 'clearfix' )); ?>>
	

	<li class="bbp-forum-info">
	
	<div class="title-bar">
		<?php do_action( 'bbp_theme_before_forum_title' ); ?>
		<h4><a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></h4>
		<?php do_action( 'bbp_theme_after_forum_title' ); ?>
	</div>
	


	<div class='bb-meta-data clearfix'>
			<?php if($image!="") : ?>
			<div class="image-area">
			<?php

			if($image!="") :

					echo $helper->imageDisplay(array( "src" =>$image , 'imageAttr' =>  '', "parent_wrap" => false , "width" => 75 , "height" => 75 )); 

			endif;	

			 ?>
			</div>
		<?php endif; ?>

			<div class="bb-forum-info <?php if($image!="") echo 'has-image'; ?>">
				
				

				<div class="bb-forum-meta clearfix">
					<span class="bbp-forum-topic-count"><?php bbp_forum_topic_count(); ?> <span class="topic-count">topics</span></span>
					<span class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?><span class="reply-count"> replies</span></span>
					<?php if( bbp_get_forum_last_active_id() > 0): ?>
							<span class="bbp-forum-freshness">
								<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>
									<?php bbp_forum_freshness_link(); ?>
								<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
							</span>
					<?php endif; ?>	
				</div>

				<?php do_action( 'bbp_theme_before_forum_description' ); ?>

				<div class="bbp-forum-content"><?php bbp_forum_content(); ?></div>

				<?php do_action( 'bbp_theme_after_forum_description' ); ?>
				
				
				<div class="clearfix sub-forums-tree">
					<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>
						<?php bbp_list_forums(array (
		        'before'              => '<ul class="bbp-forums-list clearfix">',
		        'after'               => '</ul>',
		        'link_before'         => '<li class="bbp-forum"><i class="ioa-front-icon right-circled2icon-"></i>',
		        'link_after'          => '</li>',
		        'count_before'        => ' (',
		        'count_after'         => ')',
		        'count_sep'           => ' / ',
		        'separator'           => ' - ',
		        'forum_id'            => '',
		        'show_topic_count'    => true,
		        'show_reply_count'    => true,
		        )); ?>
					<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>
				</div>	

			

				<?php bbp_forum_row_actions(); ?>
			</div>	
		
	
	

	</div>

	</li>

	

</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
