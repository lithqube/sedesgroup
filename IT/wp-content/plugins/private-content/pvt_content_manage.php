<?php
// MANAGE PRIVATE CONTENTS AND PRIVATE PAGE


// if isset a specific page as user global login manage the page to display a plugin page
add_filter('the_content', 'pg_manage_user_global_login' );
function pg_manage_user_global_login($the_content) {
	global $wpdb;
	global $post;

	$target_page = (int)get_option('pg_target_page');
	$curr_page_id = (int)get_the_ID();
	
	// WPML fix for pvt page wrapper
	if(function_exists('icl_object_id')) {
		$curr_page_id = icl_object_id($curr_page_id, 'page', true);	
	}
	
	if($target_page == $curr_page_id) {
		// preview check
		if(is_user_logged_in() && isset($_REQUEST['pg_pvtpag']) && isset($_REQUEST['pg_utok'])) {
			if(!wp_verify_nonce($_REQUEST['pg_utok'], 'lcwp_nonce')) {return 'Cheating?';}
			$GLOBALS['pg_user_id'] = (int)$_REQUEST['pg_pvtpag'];
		}

		
		// if logged
		$user_data = pg_user_logged();
		if($user_data) {
			
			// if not have a reserved area
			if($user_data->disable_pvt_page == 1) {
				if(!get_option('pg_default_nhpa_mex')) {
					$nhpa_message = __("You don't have a reserved area", 'pg_ml');
				}
				else {$nhpa_message = get_option('pg_default_nhpa_mex');}
				
				$content = '<p>'.$nhpa_message.'</p>';	
			}
			
			else {
				// get user page content
				$page_data = get_post( $user_data->page_id );
				$post = $page_data;
				$content = do_shortcode(wpautop($page_data->post_content));
				
				// disable page comments if not synced
				if(!get_option('pg_wp_user_sync') || !get_option('pg_pvtpage_wps_comments') || !$user_data->wp_user_id || $page_data->comment_status != 'open') {
					add_filter('comments_template', 'pg_comments_template');
				}
				
				// preset text
				if(get_option('pg_pvtpage_enable_preset')) {$preset = do_shortcode( wpautop(get_option('pg_pvtpage_preset_txt')));}
				else {$preset = '';}
				
				if(get_option('pg_pvtpage_preset_pos') == 'before') {$content = $preset . $content;}
				else {$content = $content . $preset;}
			}

			if(isset($content)) {$the_content = $content;}
		}
			
		// else return the original page content 
		else {
			// preparo il form
			$login_form = pg_login_form();
			$pvt_nl_content = get_option('pg_target_page_content');
			
			// orig content
			if(!$pvt_nl_content || $pvt_nl_content == 'original_content') {
				$the_content = $the_content;
			}
			
			// orig + form
			elseif($pvt_nl_content == 'original_plus_form') {
				$the_content = $the_content . $login_form;   
			}
			
			// form + orif
			elseif($pvt_nl_content == 'form_plus_original') {
				$the_content = $login_form . $the_content;   
			}
			
			// only form
			else {$the_content = $login_form;}
		}

		return $the_content;
	}	
	
	else {return $the_content;}
}

// hack to hide comments on pvt pages
function pg_comments_template($template){
	return PG_DIR . "/comment_hack.php";
}


/////////////////////////////////////////////////////////


// if the post category has a "PC hide", hide the content
function pg_manage_cat_limit_post($the_content) {
	global $post;
	if(isset($post->ID)) {	
		include_once(PG_DIR . '/functions.php');
	
		// check if term has PG limitations
		$terms = array();
		foreach(pg_affected_tax() as $tax) {
			$terms = array_merge((array)$terms, (array)wp_get_post_terms($post->ID, $tax));
		}
		
		$pg_limit = '';
		if(is_array($terms)) {
			foreach($terms as $post_term) {
				if(get_option('taxonomy_'.$post_term->term_id.'_pg_cats')) {
					$pg_limit = get_option('taxonomy_'.$post_term->term_id.'_pg_cats');
					break;
				}
			}
		}

		// executing and adding the shortcode to content
		if($pg_limit != '') {
			
			if(pg_user_check($pg_limit) == 1) { return $the_content; }
			else {
				add_filter('comments_template', 'pg_comments_template'); 	
				return '[pc-pvt-content allow="'.$pg_limit.'"]'. $the_content .'[/pc-pvt-content]';	
			}
		}
		else {return $the_content;}
	}
	else {return $the_content;}
}
add_filter('the_content', 'pg_manage_cat_limit_post');

///////////////////////////////////////////////////////////////


/* CHECK IF USER CAN SEE A REDIRECTED PAGE
 *
 * @param subj = subject to analyze (category or page)
 * @subj_data = data object of the subject
 */
function pg_redirect_check($subj, $subj_data, $taxonomy = false) {
	if($subj == 'page') {
		if(get_post_meta($subj_data->ID, 'pg_redirect', true)) {
			$allowed = trim(implode(',', get_post_meta($subj_data->ID, 'pg_redirect', true)));
			
			if($allowed == 'unlogged') {
				return (pg_user_check('unlogged') == 1) ? true : false;	
			}
			
			if($allowed != '' && pg_user_check($allowed) != 1) {return false;}
			else {return true;}
		}
		// check parents page
		else {
			if($subj_data->post_parent != 0) {
				$parent = get_post($subj_data->post_parent);
				// recursive
				return pg_redirect_check('page', $parent);	
			}
			else {return true;}
		}
	}
	
	// category
	else {
		if(get_option('taxonomy_'.$subj_data->term_id.'_pg_redirect')) {
			$allowed = trim(get_option('taxonomy_'.$subj_data->term_id.'_pg_redirect'));

			if($allowed != '' && pg_user_check($allowed) != 1) {return false;}
			else {return true;}
		}
		// parent
		else {
			if(isset($subj_data->category_parent) && $subj_data->category_parent != 0) {
				$parent = get_term_by('id', $subj_data->category_parent,  $taxonomy);
				
				// recursive
				return pg_redirect_check('category', $parent, $taxonomy);	
			}
			else {return true;}
		}
	}
}


// REDIRECT TO SPECIFIED PAGE 
function pg_pvt_redirect() {
	
	// only if redirect option is setted
	if(get_option('pg_redirect_page')) {
		include_once(PG_DIR . '/functions.php');
		
		// get redirect page url
		$orig_redirect_val = get_option('pg_redirect_page');
		$redirect_url = pg_man_redirects('pg_redirect_page');
		
		//////////////////////////////////////////////////////////////
		// complete website lock
		if(get_option('pg_complete_lock') && pg_user_check() != 1) {
			global $post;
			
			if(isset($post->ID)) {
				$is_login_page = ($post->ID != $orig_redirect_val) ? false : true;	
			} else {
				$is_login_page = false;	
			}
			
			// PCMA e-mail verification - remove landing page 
			if(isset($post->ID)) {
				$is_pcma_page = (get_option('pcma_mv_enable') && $post->ID == get_option('pcma_mv_pag')) ? true : false;	
			} else {
				$is_pcma_page = false;	
			}
			
			if(!$is_login_page && !$is_pcma_page) {
				// last restricted page redirect system
				if(get_option('pg_redirect_back_after_login') && pg_curr_url() != '') {
					$_SESSION['pg_last_restricted'] = pg_curr_url();
				}

				header('location: '.$redirect_url);
				die();	
			}	
		}
		
		//////////////////////////////////////////////////////////////
		// single page/post redirect
		if(is_page() || is_single()) {
			global $post;

			if($post->ID != $orig_redirect_val && !pg_redirect_check('page', $post)) {
				
				// last restricted page redirect system
				if(get_option('pg_redirect_back_after_login') && pg_curr_url() != '') {
					$_SESSION['pg_last_restricted'] = pg_curr_url();
				}
				
				header('location: '.$redirect_url);
				die();	
			}
		}
		
		//////////////////////////////////////////////////////////////
		// if is category or archive
		if(is_category() || is_archive()) {
			$cat_id = get_query_var('cat');

			// know which taxonomy is involved
			foreach(pg_affected_tax() as $tax) {
				$cat_data = get_term_by('id', $cat_id, $tax);
				
				if($cat_data != false) {
					if(!pg_redirect_check('category', $cat_data, $tax)) {
						if(get_option('pg_redirect_back_after_login') && pg_curr_url() != '') {
							$_SESSION['pg_last_restricted'] = pg_curr_url();	
						}
						
						header('location: '.$redirect_url);
						die();	
					}
					
					break;	
				}
			}
		}
		
		
		//////////////////////////////////////////////////////////////
		// WooCommerce category
		if(function_exists('is_product_category') && is_product_category()) {
			$cat_slug = get_query_var('product_cat');
			$cat_data = get_term_by('slug', $cat_slug, 'product_cat');
				
			if($cat_data != false) {
				if(!pg_redirect_check('category', $cat_data, 'product_cat')) {
					if(get_option('pg_redirect_back_after_login') && pg_curr_url() != '') {
						$_SESSION['pg_last_restricted'] = pg_curr_url();	
					}
					
					header('location: '.$redirect_url);
					die();	
				}
			}
		}
		
		
		//////////////////////////////////////////////////////////////
		// if is a single post (check category restriction)
		if(is_single()) {
			global $post;
			include_once(PG_DIR . '/functions.php');
			
			// search post terms in every involved taxonomy
			foreach(pg_affected_tax() as $tax) {
				$terms = wp_get_post_terms($post->ID, $tax);
				
				if(is_array($terms)) {
					foreach($terms as $term) {
						$cat_data = get_term_by('id', $term->term_id, $tax);
						
						if(!pg_redirect_check('category', $cat_data, $tax)) {
							if(get_option('pg_redirect_back_after_login') && pg_curr_url() != '') {
								$_SESSION['pg_last_restricted'] = pg_curr_url();
							}
							
							header('location: '.$redirect_url);
							die();	
						}	
					}		
				}
			}
		}
		
	}	
}
add_action('template_redirect', 'pg_pvt_redirect', 1);


/////////////////////////////////////////////////////////////////////

// SINGLE MENU ITEM CHECK
function pg_single_menu_check($items, $item_id) {
	foreach($items as $item) {
		if($item->ID == $item_id) {
			
			if($item->menu_item_parent) {
				$parent_check = pg_single_menu_check($items, $item->menu_item_parent);	
				if(!$parent_check) {return false;}
			}

			// if allowed users array exist 
			if(isset($item->pg_hide_item) && is_array($item->pg_hide_item)) {
				$allowed = implode(',', $item->pg_hide_item);
				
				if(pg_user_check($allowed) == 1) {return true;}	
				else {return false;}
			}	
		}		
	}
	
	return true;
}


// HIDE MENU ITEMS IF USER HAS NO PERMISSIONS
function pg_menu_filter($items) {	
	$new_items = array();
	
	// full website lock 
	if(get_option('pg_complete_lock') && pg_user_check() != 1) {
		return $new_items;	
	}
	
	foreach($items as $item) {
		
		if(isset($item->menu_item_parent) && $item->menu_item_parent) {
			$parent_check = pg_single_menu_check($items, $item->menu_item_parent);	
		}
		else {$parent_check = true;}
		
		if($parent_check) {
			
			// if allowed users array exist 
			if(isset($item->pg_hide_item) && is_array($item->pg_hide_item)) {
				$allowed = implode(',', $item->pg_hide_item);
				if(pg_user_check($allowed) == 1) {$new_items[] = $item;}	
			}
			else {$new_items[] = $item;}
		}
	}
	
	return $new_items;
}
add_action( 'wp_nav_menu_objects', 'pg_menu_filter' );


//////////////////////////////////////////////////////////////////


// REMOVE RESTRICTED TERMS / POSTS FROM WP_QUERY
// search filter
function pg_query_filter($query) {
	
	if(!$query->is_admin && !$query->is_single && !$query->is_page) {	
		include_once(PG_DIR . '/functions.php');
		global $pg_query_filter_post_array;
		
		// remove restricted terms
		$exclude_cats = pg_query_filter_cat_array(); 
		if(count($exclude_cats) > 0) {
			$exclude_cat_string = str_replace('-', '', implode(',', $exclude_cats));
			$query->set('category__not_in', explode(',', $exclude_cat_string)); // terms ID array
		}
		
		// remove restricted posts
		$exclude_posts = $pg_query_filter_post_array;
		if(is_array($exclude_posts) && count($exclude_posts) > 0) {
			$query->set('post__not_in', $exclude_posts ); //Post ID array
		}
	}

	return $query;
}
add_filter('pre_get_posts', 'pg_query_filter', 999);


// REMOVE TERMS FROM CATEGORIES WIDGET
function pg_widget_categories_args_filter($cat_args) {
	include_once(PG_DIR . '/functions.php');
	global $pg_query_filter_post_array;
	
	// remove restricted terms
	$exclude_cats = pg_query_filter_cat_array(); 
	if(count($exclude_cats) > 0) {
		if ($cat_args['exclude']) {
			$cat_args['exclude'] = $cat_args['exclude'] . ',' . implode(',', $exclude_cats);
		} else {
			$cat_args['exclude'] = implode(',', $exclude_cats);
		}
	}
	   
	return $cat_args;
}
add_filter( 'widget_categories_args', 'pg_widget_categories_args_filter', 10, 1 );


// create an array of restricted terms
function pg_query_filter_cat_array() {
	$exclude_array = array();
	
	$args = array( 'hide_empty' => 0);
	$categories = get_terms( pg_affected_tax(), $args );
	
	foreach( $categories as $category ) { 
		if(!pg_redirect_check('category', $category)) {
			$exclude_array[] = '-'.$category->term_id;
		}	
	}
	
	return $exclude_array;	
}


// create an array of restricted posts and pages 
// triggers on INIT and set GLOBALS to avoid incompatibilities with pre_get_posts
function pg_query_filter_post_array() {
	
	if(!is_admin() && !is_single() && !is_page()) {	
		$exclude_array = array();
	
		$args = array(
			'post_type' => pg_affected_pt(),
			'posts_per_page' => -1,
			'post_status' => 'publish'
		);
		$posts = get_posts( $args );
	
		foreach( $posts as $post ) { 
			if(!pg_redirect_check('page', $post)) {
				$exclude_array[] = $post->ID;
			}	
		}
		
		$GLOBALS['pg_query_filter_post_array'] = $exclude_array;
	}
}
add_action('init', 'pg_query_filter_post_array', 1);
