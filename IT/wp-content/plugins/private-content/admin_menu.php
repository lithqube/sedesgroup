<?php
// setting up USER MANAGEMENT admin menu
function pg_users_admin_menu() {	
	$menu_img = PG_URL.'/img/users_icon.png'; 
	$capability = (get_option('pg_min_role')) ? get_option('pg_min_role') : 'upload_files';
	
	// add user cap
	if(get_option('pg_min_role_tmu')) {$au_cap = get_option('pg_min_role_tmu');}
	else {
		$au_cap = (get_option('pg_min_role')) ? get_option('pg_min_role') : 'upload_files';	
	}
	
	add_menu_page('PrivateContent', 'PrivateContent', $capability, 'pg_user_manage', 'pg_users_overview', $menu_img, 46);
	
	// submenus
	add_submenu_page('pg_user_manage', __('Users List', 'pg_ml'), __('Users List', 'pg_ml'), $capability, 'pg_user_manage', 'pg_users_overview');
	add_submenu_page('pg_user_manage', __('Add User', 'pg_ml'), __('Add User', 'pg_ml'), $capability, 'pg_add_user', 'pg_add_user');	
	add_submenu_page('pg_user_manage', __('User Categories', 'pg_ml'), __('User Categories', 'pg_ml'), $au_cap, 'edit-tags.php?taxonomy=pg_user_categories');
	add_submenu_page('pg_user_manage', __('Import & Export Users', 'pg_ml'), __('Import & Export Users', 'pg_ml'), $capability, 'pg_import_export', 'pg_import_export');
}
add_action('admin_menu', 'pg_users_admin_menu');

// settings item placed at the end
function pg_settings_menu_item() {	
	add_submenu_page('pg_user_manage', __('Settings', 'pg_ml'), __('Settings', 'pg_ml'), 'install_plugins', 'pg_settings', 'pg_settings');
}
add_action('admin_menu', 'pg_settings_menu_item', 999);


// fix to set the taxonomy and user pages as menu page sublevel
function user_cat_tax_menu_correction($parent_file) {
	global $current_screen;

	// hack for taxonomy
	if(isset($current_screen->taxonomy)) {
		$taxonomy = 'pg_user_categories';
		if($taxonomy == $current_screen->taxonomy) {
			$parent_file = 'pg_user_manage';
		}	
	}
	
	// hack for user pages
	if(isset($current_screen->base)) {
		$page_type = 'pg_user_page';
		if($current_screen->base == 'post' && $current_screen->id == $page_type) {
			$parent_file = 'pg_user_manage';
		}
	}
	
	return $parent_file;
}
add_action('parent_file', 'user_cat_tax_menu_correction');



////////////////////////////////////////////
// USER MANAGEMENT PAGES ///////////////////
////////////////////////////////////////////

// users list
function pg_users_overview() { include_once(PG_DIR . '/users/users_list.php'); }

// add user
function pg_add_user() {include_once(PG_DIR . '/users/add_user.php'); }

// import and export users
function pg_import_export() { include_once(PG_DIR . '/users/import_export.php'); }

// settings
function pg_settings() {  include_once(PG_DIR.'/settings.php'); }  



////////////////////////////////////////////
// USER CATEGORIES /////////////////////////
////////////////////////////////////////////

add_action( 'init', 'pg_user_cat_taxonomy' );
function pg_user_cat_taxonomy() {
    $labels = array( 
        'name' => __( 'User Categories', 'pg_ml' ),
        'singular_name' => __( 'User Category', 'pg_ml' ),
        'search_items' => __( 'Search User Categories', 'pg_ml' ),
        'popular_items' => __( 'Popular User Categories', 'pg_ml' ),
        'all_items' => __( 'All User Categories', 'pg_ml' ),
        'parent_item' => __( 'Parent User Category', 'pg_ml' ),
        'parent_item_colon' => __( 'Parent User Category:', 'pg_ml' ),
        'edit_item' => __( 'Edit User Category', 'pg_ml' ),
        'update_item' => __( 'Update User Category', 'pg_ml' ),
        'add_new_item' => __( 'Add New User Category', 'pg_ml' ),
        'new_item_name' => __( 'New User Category Name', 'pg_ml' ),
        'separate_items_with_commas' => __( 'Separate user categories with commas', 'pg_ml' ),
        'add_or_remove_items' => __( 'Add or remove user categories', 'pg_ml' ),
        'choose_from_most_used' => __( 'Choose from the most used user categories', 'pg_ml' ),
        'menu_name' => __( 'User Categories', 'pg_ml' ),
    );
	
	// min capability
	if(get_option('pg_min_role_tmu')) {$cap = get_option('pg_min_role_tmu');}
	else {
		$cap = (get_option('pg_min_role')) ? get_option('pg_min_role') : 'upload_files';	
	}

    $args = array( 
        'labels' => $labels,
        'public' => false,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => false,
        'rewrite' => false,
		'capabilities' => array($cap),
        'query_var' => true
    );

    register_taxonomy( 'pg_user_categories', '', $args );	
}


/////////////////////////////////////////////////////////////


// remove the "articles" column from the taxonomy table
add_filter( 'manage_edit-pg_user_categories_columns', 'pg_user_cat_colums', 10, 1);
function pg_user_cat_colums($columns) {
   if(isset($columns['posts'])) {
		unset($columns['posts']); 
   }

    return $columns;
}


////////////////////////////////////////////////////////////////


//if there are pending users, show them on the WP dashboard
function pg_pending_users_warning() {	
	global $total_pen_rows, $wpdb;

	// pending users only if they exists
	$wpdb->query("SELECT ID FROM ".PG_DB_TABLE." WHERE status = 3");
	$total_pen_rows = $wpdb->num_rows;
	
	if($total_pen_rows > 0) {
		// add submenu
		add_action('admin_menu', 'pg_pending_menu_warn', 1000);
	
		// add wp admin bar alert
		add_action('admin_bar_menu', 'pg_pending_bar_warn', 500);  
	}	
}
add_action('init', 'pg_pending_users_warning', 800);


// PC menu item
function pg_pending_menu_warn() {
	global $total_pen_rows;
	$au_cap = (get_option('pg_min_role')) ? get_option('pg_min_role') : 'upload_files'; // restrict to users allowed to manage customers
	
	add_submenu_page('pg_user_manage', __('Pending Users', 'pg_ml') .' ('.$total_pen_rows.')', __('Pending Users', 'pg_ml') .' ('.$total_pen_rows.')', $au_cap, 'admin.php?page=pg_user_manage&status=pending');	
}

// admin bar notice
function pg_pending_bar_warn() {
	global $wp_admin_bar, $total_pen_rows;
	
	// restrict to users allowed to manage customers
	$au_cap = (get_option('pg_min_role')) ? get_option('pg_min_role') : 'upload_files';
	if(current_user_can($au_cap)) {
	
		if(is_admin_bar_showing() && is_object($wp_admin_bar)) {
			$wp_admin_bar->add_menu( array( 
				'id' => 'pg_pending_users', 
				'title' => '<span>PrivateContent <span id="ab-updates">'.$total_pen_rows.' '. __('Pending Users', 'pg_ml') .'</span></span>', 
				'href' => get_admin_url() . 'admin.php?page=pg_user_manage&status=pending' 
			) );
		}
	}
}
