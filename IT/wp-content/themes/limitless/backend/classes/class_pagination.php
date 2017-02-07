<?php
/**
 * Pagination Class For IOA Framework 
 */


if (!class_exists('WPPaginate')) {
	class WPPaginate {
		/**
		 * @var string The plugin version
		 */
		var $version = '1.2.4';

		
		/**
		 * @var string $localizationDomain Domain used for localization
		 */
		var $localizationDomain = 'ioa';

		/**
		 * @var array $options Stores the options for this plugin
		 */
		var $options = array();

		var $type = 'posts';

		

		/**
		 * Pagination based on options/args
		 */
		function paginate($args = false) {
			if ($this->type === 'comments' && !get_option('page_comments'))
				return;
			$before = '<div class="pagination" itemscope itemtype="http://schema.org/SiteNavigationElement">';
			$after = '</div>';
			$empty = ' ';
			
			$range = 1;
			$anchor = 1;
			$gap =0;

			$r = wp_parse_args($args, $this->options);
			extract($r, EXTR_SKIP);

			if (!isset($page) && !isset($pages)) {
				global $wp_query;

				if ($this->type === 'posts') {
					$page = get_query_var('paged');
					$posts_per_page = intval(get_query_var('posts_per_page'));
					$pages = intval(ceil($wp_query->found_posts / $posts_per_page));
				}
				else {
					$page = get_query_var('cpage');
					$comments_per_page = get_option('comments_per_page');
					$pages = get_comment_pages_count();
				}
				$page = !empty($page) ? intval($page) : 1;
			}

			$prevlink = ($this->type === 'posts')
				? esc_url(get_pagenum_link($page - 1))
				: get_comments_pagenum_link($page - 1);
			$nextlink = ($this->type === 'posts')
				? esc_url(get_pagenum_link($page + 1))
				: get_comments_pagenum_link($page + 1);

			$output = stripslashes($before);

			if ($pages > 1) {
				$output .= sprintf('<ul class="clearfix %s">', ($this->type === 'posts') ? '' : ' wp-paginate-comments');
				
				$ellipsis = "<li><span class='gap'>...</span></li>";

				if ($page > 1 && !empty($previouspage)) {
					$output .= sprintf('<li><a href="%s" class="prev" itemprop="url" >%s</a></li>', $prevlink, stripslashes($previouspage));
				}

				$min_links = $range * 2 + 1;
				$block_min = min($page - $range, $pages - $min_links);
				$block_high = max($page + $range, $min_links);
				$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
				$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;

				if ($left_gap && !$right_gap) {
					$output .= sprintf('%s%s%s',
						$this->paginate_loop(1, $anchor),
						$ellipsis,
						$this->paginate_loop($block_min, $pages, $page)
					);
				}
				else if ($left_gap && $right_gap) {
					$output .= sprintf('%s%s%s%s%s',
						$this->paginate_loop(1, $anchor),
						$ellipsis,
						$this->paginate_loop($block_min, $block_high, $page),
						$ellipsis,
						$this->paginate_loop(($pages - $anchor + 1), $pages)
					);
				}
				else if ($right_gap && !$left_gap) {
					$output .= sprintf('%s%s%s',
						$this->paginate_loop(1, $block_high, $page),
						$ellipsis,
						$this->paginate_loop(($pages - $anchor + 1), $pages)
					);
				}
				else {
					$output .= $this->paginate_loop(1, $pages, $page);
				}

				if ($page < $pages && !empty($nextpage)) {
					$output .= sprintf('<li><a href="%s"  itemprop="url"class="next">%s</a></li>', $nextlink, stripslashes($nextpage));
				}
				$output .= "</ul>";
			}
			$output .= stripslashes($after);

			if ($pages > 1 || $empty) {
				echo $output;
			}
		}

		/**
		 * Helper function for pagination which builds the page links.
		 */
		function paginate_loop($start, $max, $page = 0) {
			$output = "";
			for ($i = $start; $i <= $max; $i++) {
				$p = ($this->type === 'posts') ? esc_url(get_pagenum_link($i)) : get_comments_pagenum_link($i);
				$output .= ($page == intval($i))
					? "<li><span class='page current'>$i</span></li>"
					: "<li><a href='$p' title='$i'  itemprop=\"url\" class='page'>$i</a></li>";
			}
			return $output;
		}

		function paginate_loop_dropdown($start, $max, $page = 0) {
			$output = "";
			for ($i = $start; $i <= $max; $i++) {
				$p = ($this->type === 'posts') ? esc_url(get_pagenum_link($i)) : get_comments_pagenum_link($i);
				$output .= ($page == intval($i))
					? "<option selected='selected' value='$p'>$i</option>"
					: "<option value='$p'>$i</option>";
			}
			return $output;
		}

	function paginate_dropdown($args = array())
	{
		if ($this->type === 'comments' && !get_option('page_comments'))
				return;
			$before = '';
			$after = '';
			$empty = ' ';
			$ellipsis = "<li><span class='gap'>...</span></li>";
			$range = 8;
			$anchor = 1;
			$gap =0;

			$r = wp_parse_args($args, $this->options);
			extract($r, EXTR_SKIP);

			if (!isset($page) && !isset($pages)) {
				global $wp_query;

				if ($this->type === 'posts') {
					$page = get_query_var('paged');
					$posts_per_page = intval(get_query_var('posts_per_page'));
					$pages = intval(ceil($wp_query->found_posts / $posts_per_page));
				}
				else {
					$page = get_query_var('cpage');
					$comments_per_page = get_option('comments_per_page');
					$pages = get_comment_pages_count();
				}
				$page = !empty($page) ? intval($page) : 1;
			}

			$prevlink = ($this->type === 'posts')
				? esc_url(get_pagenum_link($page - 1))
				: get_comments_pagenum_link($page - 1);
			$nextlink = ($this->type === 'posts')
				? esc_url(get_pagenum_link($page + 1))
				: get_comments_pagenum_link($page + 1);

			$output = stripslashes($before);

			if ($pages > 1) {
				$output .= '<div class="pagination-dropdown"><span>Goto :</span><div class="select-wrap"><i class="angle-downicon- ioa-front-icon"></i><select class="clearfix">';
				
				

				if ($page > 1 && !empty($previouspage)) {
					$output .= sprintf('<option value="%s">%s</option>', $prevlink, stripslashes($previouspage));
				}

				$min_links = $range * 2 + 1;
				$block_min = min($page - $range, $pages - $min_links);
				$block_high = max($page + $range, $min_links);
				$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
				$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;

				if ($left_gap && !$right_gap) {
					$output .= sprintf('%s%s%s',
						$this->paginate_loop_dropdown(1, $anchor),
						$ellipsis,
						$this->paginate_loop_dropdown($block_min, $pages, $page)
					);
				}
				else if ($left_gap && $right_gap) {
					$output .= sprintf('%s%s%s%s%s',
						$this->paginate_loop_dropdown(1, $anchor),
						$ellipsis,
						$this->paginate_loop_dropdown($block_min, $block_high, $page),
						$ellipsis,
						$this->paginate_loop_dropdown(($pages - $anchor + 1), $pages)
					);
				}
				else if ($right_gap && !$left_gap) {
					$output .= sprintf('%s%s%s',
						$this->paginate_loop_dropdown(1, $block_high, $page),
						$ellipsis,
						$this->paginate_loop_dropdown(($pages - $anchor + 1), $pages)
					);
				}
				else {
					$output .= $this->paginate_loop_dropdown(1, $pages, $page);
				}

				if ($page < $pages && !empty($nextpage)) {
					$output .= sprintf('<option value="%s" class="next">%s</option>', $nextlink, stripslashes($nextpage));
				}
				$output .= "</select></div></div>";
			}
			$output .= stripslashes($after);

			if ($pages > 1 || $empty) {
				echo $output;
			}
	}	
		
	}
}

//instantiate the class
if (class_exists('WPPaginate')) {
	$wp_paginate = new WPPaginate();
}

/**
 * Pagination function to use for posts
 */
function wp_paginate($args = false) {
	global $wp_paginate;
	$wp_paginate->type = 'posts';
	return $wp_paginate->paginate($args);
}


/**
 * Pagination function to use for posts
 */
function wp_paginate_dropdown($args = false) {
	global $wp_paginate;
	$wp_paginate->type = 'posts';
	return $wp_paginate->paginate_dropdown();
}

/**
 * Pagination function to use for post comments
 */
function wp_paginate_comments($args = false) {
	global $wp_paginate;
	$wp_paginate->type = 'comments';
	return $wp_paginate->paginate($args);
}


?>