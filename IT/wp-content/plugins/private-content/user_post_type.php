<?php
// add custom post type to add user pages

add_action( 'init', 'register_pg_user_page' );
function register_pg_user_page() {

	////////////////////////////////////////////////
	// WP roles control if level under "editor"
	$cap = get_option('pg_min_role', 'upload_files');
	$capability_type = 'pg_user_page';
	
	switch($cap) {
		case 'read' 		: 
			$add = array('subscriber', 'contributor', 'author', 'editor', 'administrator');
			$remove = array(); 
			break;
			
		case 'edit_posts' 	: 
			$add = array('contributor', 'author', 'editor', 'administrator');
			$remove = array('subscriber');  
			break;
			
		case 'upload_files' : 
			$add = array('author', 'editor', 'administrator');
			$remove = array('subscriber', 'contributor'); 
			break;	
			
		case 'edit_pages' :
			$add = array('editor', 'administrator');
			$remove = array('subscriber', 'contributor', 'author'); 
			break;
			
		case 'install_plugins' :
			$add = array('administrator');
			$remove = array('subscriber', 'contributor', 'author', 'editor'); 
			break;	
	}
	
	foreach($add as $subj) {
		$role = get_role($subj);
		
		if(is_object($role)) {
			$role->add_cap( "edit_{$capability_type}" );
			$role->add_cap( "read_{$capability_type}" );
			$role->add_cap( "delete_{$capability_type}" );
			$role->add_cap( "edit_{$capability_type}s" );
			$role->add_cap( "edit_others_{$capability_type}s" );
			$role->add_cap( "publish_{$capability_type}s" );
			$role->add_cap( "read_private_{$capability_type}s" );
			$role->add_cap( "delete_{$capability_type}s" );
			$role->add_cap( "delete_private_{$capability_type}s" );
			$role->add_cap( "delete_published_{$capability_type}s" );
			$role->add_cap( "delete_others_{$capability_type}s" );
			$role->add_cap( "edit_private_{$capability_type}s" );
			$role->add_cap( "edit_published_{$capability_type}s" );
		}
	}
	foreach($remove as $subj) {
		$role = get_role($subj);
		
		if(is_object($role)) {
			$role->remove_cap( "edit_{$capability_type}" );
			$role->remove_cap( "read_{$capability_type}" );
			$role->remove_cap( "delete_{$capability_type}" );
			$role->remove_cap( "edit_{$capability_type}s" );
			$role->remove_cap( "edit_others_{$capability_type}s" );
			$role->remove_cap( "publish_{$capability_type}s" );
			$role->remove_cap( "read_private_{$capability_type}s" );
			$role->remove_cap( "delete_{$capability_type}s" );
			$role->remove_cap( "delete_private_{$capability_type}s" );
			$role->remove_cap( "delete_published_{$capability_type}s" );
			$role->remove_cap( "delete_others_{$capability_type}s" );
			$role->remove_cap( "edit_private_{$capability_type}s" );
			$role->remove_cap( "edit_published_{$capability_type}s" );
		}
	}

	///////////////////////////////////////////
	// add
    $labels = array( 
        'name' => __('User Pages', 'pg_ml'),
        'singular_name' => __('User Page', 'pg_ml'),
        'add_new' => __('Add New', 'pg_ml'),
        'add_new_item' => __('Add New User Page', 'pg_ml'),
        'edit_item' => __('Edit User Page', 'pg_ml'),
        'new_item' => __('New User Page', 'pg_ml'),
        'view_item' => __('View User Page', 'pg_ml'),
        'search_items' => __('Search User Pages', 'pg_ml'),
        'not_found' => __('No user pages found', 'pg_ml'),
        'not_found_in_trash' => __('No user pages found in Trash', 'pg_ml'),
        'parent_item_colon' => __('Parent User Page:', 'pg_ml'),
        'menu_name' => __('User Pages', 'pg_ml'),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Private pages of private content users',
        'supports' => array( 'editor', 'thumbnail', 'revisions', 'comments'),
        
        'public' => false,
        'show_ui' => false,
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'pg_user_page',
		'map_meta_cap' => true
    );

    register_post_type( 'pg_user_page', $args );
}


////////////////////////////////////////
// Edit custom post type edit page /////
//////////////////////////////////////// 

// FIX FOR QTRANSLATE - to avoid qtranslate JS error i have to add title support to post type
// but I've hidden them with the CSS

// edit submitbox - hide minor submit minor-publishing and delete page

add_action( 'admin_head-post-new.php', 'user_page_admin_script', 15 );
add_action( 'admin_head-post.php', 'user_page_admin_script', 15 );

function user_page_admin_script() {
    global $post_type;
	global $wpdb;

    if('pg_user_page' == $post_type) {
		
		// hide ADD PAGE
		?>
		<style type="text/css">
			.add-new-h2,
			#titlediv,
			#slugdiv.postbox,
			.qtrans_title_wrap,
			.qtrans_title {
				display: none;	
			}
			
			#submitpost .misc-pub-post-status,
			#submitpost #visibility,
			#submitpost .misc-pub-curtime,
			#minor-publishing-actions,
			#delete-action {
				display: none;	
			}
		</style>
		<?php
		
		
		// append username to the edit-page title 
		$user_data = $wpdb->get_row( $wpdb->prepare( 
			"SELECT id, username FROM  ".PG_DB_TABLE." WHERE page_id = %d",
			$_REQUEST['post']
		) );
		$username = $user_data->username;
		
		?>
		<script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery(".wrap h2").append(" - <?php echo addslashes($username) ?>");
        });
        </script>
		<?php
		
		
		// add preview link
		$container_id = get_option('pg_target_page');
		if(!empty($container_id)) {
			$link = get_permalink($container_id);
			$conj = (strpos($link, '?') === false) ? '?' : '&'; 
			
			$preview_link = $link.$conj. 'pg_pvtpag='.$user_data->id. '&pg_utok='.wp_create_nonce('lcwp_nonce');
			
			?>
			<script type="text/javascript">
            jQuery(document).ready(function(){
                var pg_live_preview = 
				'<a href="<?php echo $preview_link ?>" target="_blank" id="pg_pp_preview_link"><?php echo pg_sanitize_input( __("Live preview", 'pg_ml')) ?> &raquo;</a>';
			
				jQuery('#major-publishing-actions').prepend(pg_live_preview);
            });
            </script>
            <?php
		} // if pvt pag container exists - end
	}
}


/////////////////////////////////////////////////////////////////////////

// comments reply fix on pvt pages - always redirect to container
function pg_pvtpag_comment_redirect_fix() {
	$pvt_pag_id = get_option('pg_target_page');
	
	if(isset($_REQUEST['pg_user_page']) && !empty($pvt_pag_id)) {
		header('Location: '. get_permalink($pvt_pag_id));	
	}
}
add_action('template_redirect', 'pg_pvtpag_comment_redirect_fix', 1);
