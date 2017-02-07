<?php
/* 
Plugin Name: PrivateContent
Plugin URI: http://codecanyon.net/item/privatecontent-multilevel-content-plugin/1467885?ref=LCweb
Description: Create unlimited lists of users and chose which of them can view page or post contents or entire areas of your website. Plus, each user have a private page.
Author: Luca Montanari
Version: 4.03
Author URI: http://codecanyon.net/user/LCweb?ref=LCweb
*/  


/////////////////////////////////////////////
/////// MAIN DEFINES ////////////////////////
/////////////////////////////////////////////

// plugin path
$wp_plugin_dir = substr(plugin_dir_path(__FILE__), 0, -1);
define( 'PG_DIR', $wp_plugin_dir );

// plugin url
$wp_plugin_url = substr(plugin_dir_url(__FILE__), 0, -1);
define( 'PG_URL', $wp_plugin_url );


/////////////////////////////////////////////
/////// MULTILANGUAGE SUPPORT ///////////////
/////////////////////////////////////////////

function pg_multilanguage() {
  $param_array = explode(DIRECTORY_SEPARATOR, PG_DIR);
  $folder_name = end($param_array);
  
  if(is_admin()) {
	 load_plugin_textdomain('pg_ml', false, $folder_name . '/lang_admin');  
  }
  load_plugin_textdomain('pg_ml', false, $folder_name . '/languages');  
}
add_action('init', 'pg_multilanguage', 1);




/////////////////////////////////////////////
/////// SESSIONS AND COOKIES MANAGEMENT /////
/////////////////////////////////////////////

// setting up the session for the frontend - define database table constant
function pg_init_session() {
	global $wpdb;
	define('PG_DB_TABLE', $wpdb->prefix . "pg_users"); // database table
	
	if (!session_id()) {
		ob_start();
		ob_clean();
		session_start();
	}
}
add_action('init', 'pg_init_session', 1);


// setup logged user id - check for login cookie if session doesn't exists
function pg_cookie_check() {
	if(isset($_COOKIE['pg_user'])) {
		global $wpdb;

		// get user ID and password
		$c_data = explode('|||', $_COOKIE['pg_user']);
		if(count($c_data) < 2) {return false;}
		
		$wpdb->query("SELECT ID FROM ".PG_DB_TABLE." WHERE status = 1 AND ID = ".(int)$c_data[0]." AND psw = '".addslashes($c_data[1])."' LIMIT 1");
		$tot = $wpdb->num_rows;
		
		if($tot == 1) {
			$_SESSION['pg_user_id'] = (int)$c_data[0];
			$GLOBALS['pg_user_id'] = (int)$c_data[0];
		} else {
			setcookie('pg_user', '', time() - (3600 * 25), '/');	
		}
	}
	
	elseif(isset($_SESSION['pg_user_id'])) {
		$GLOBALS['pg_user_id'] = (int)$_SESSION['pg_user_id'];
	}
}
add_action('init', 'pg_cookie_check', 2);

// export users security trick - avoid issues related to php warnings
function pg_export_buffer() {
	ob_start();
}
add_action('admin_init', 'pg_export_buffer', 1);



/////////////////////////////////////////////
/////// WP USERS SYNC INITIALIZATION ////////
/////////////////////////////////////////////

function pg_wp_users_sync_init() {
	if(get_option('pg_wp_user_sync')) {
		include_once(PG_DIR . '/wp_user_tricks.php');
		include_once(PG_DIR . '/classes/wp_users_sync.php');
		
		add_role('pvtcontent', 'PrivateContent',
			array(
				'read'         => false,
				'edit_posts'   => false,
				'delete_posts' => false
			)
		);
	}else {
		remove_role('pvtcontent');
	}
}
add_action('init', 'pg_wp_users_sync_init', 1);



/////////////////////////////////////////////
/////// MAIN SCRIPT & CSS INCLUDES //////////
/////////////////////////////////////////////

// global script enqueuing
function pg_global_scripts() { 
	wp_enqueue_script("jquery"); 
	
	// admin css
	if (is_admin()) {  
		wp_enqueue_style('pg_admin', PG_URL . '/css/admin.css', 999);	
		
		// add tabs scripts
		wp_enqueue_style( 'pg-ui-theme', PG_URL.'/css/ui-wp-theme/jquery-ui-1.8.17.custom.css', 999);
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-slider');
		
		// iphone checks
		wp_enqueue_style( 'lcwp-ip-checks', PG_URL.'/js/iphone_checkbox/style.css', 999);

		// colorpicker
		wp_enqueue_style( 'lcwp-colpick', PG_URL.'/js/colpick/css/colpick.css', 999);

		// chosen
		wp_enqueue_style( 'lcwp-chosen-style', PG_URL.'/js/chosen/chosen.css', 999);
	}
	
	// login, registering and logout JS file
	if (!is_admin()) {
		wp_enqueue_script('pg_frontend_js', PG_URL . '/js/private-content.js', 99, '4.03');	
	}
	
	// custom frontend style - only if is not disabled by settings
	if (!is_admin() && !get_option('pg_disable_front_css')) {  
		$style = get_option('pg_style', 'minimal');
		
		if((!get_option('pg_inline_css') && !get_option('pg_force_inline_css')) || $style != 'custom') {
			wp_enqueue_style('pg_frontend', PG_URL . '/css/'.$style.'.css', 999, '4.03');		
		}
		else {add_action('wp_head', 'pg_inline_css', 989);}
	}
}
add_action( 'init', 'pg_global_scripts');

// use custom style inline
function pg_inline_css(){
	echo '<style type="text/css">';
	include_once(PG_DIR.'/custom_style.php');
	echo '</style>';
}

// custom css
function pg_custom_css(){
	$code = trim(get_option('pg_custom_css', ''));
	
	if($code) {
		echo '
<!-- privateContent custom CSS -->
<style type="text/css">'. $code .'</style>
';
	}
}
add_action('wp_head', 'pg_custom_css', 999);




//////////////////////////////////////////////////
/////////// ADMIN AREA ///////////////////////////
//////////////////////////////////////////////////


// MENU AND TOPBAR PENDING USERS 
include_once(PG_DIR . '/admin_menu.php');

// USER CAT - CUSTOM FIELDS
include_once(PG_DIR . '/user_cat_options.php');

// PUBLIC API
include_once(PG_DIR . '/public_api.php');

// GLOBAL AJAX
include_once(PG_DIR . '/admin_ajax.php');

// USER POST TYPE - PVT PAGE
include_once(PG_DIR . '/user_post_type.php');

// METABOX 
include_once(PG_DIR . '/metaboxes.php');

// TAXONOMIES OPTION
include_once(PG_DIR . '/pg_taxonomies_option.php');

// NAV MENU OPTION
include_once(PG_DIR . '/pg_nav_menu_option.php');

// TINYMCE BUTTON
include_once(PG_DIR . '/tinymce_implementation.php');

// SHORTCODES
include_once(PG_DIR . '/shortcodes.php');

// USER AUTH SYSTEM - FRONT AJAX
include_once(PG_DIR . '/user_auth.php');

// USER REGISTRATION SYSTEM
include_once(PG_DIR . '/user_registration.php');

// MANAGE PRIVATE CONTENT
include_once(PG_DIR . '/pvt_content_manage.php');

// LOGIN WIDGET
include_once(PG_DIR . '/login_widget.php');


////////////
// UPDATE NOTIFIER
if(!class_exists('lc_update_notifier')) {
	include_once(PG_DIR . '/lc_update_notifier.php');
}
$lcun = new lc_update_notifier(__FILE__, 'http://projects.lcweb.it/envato_update/pg.php');
////////////



//////////////////////////////////////////////////
// ACTIONS ON PLUGIN ACTIVATION //////////////////
//////////////////////////////////////////////////

// add/update user table - setup initial min role 
function pg_on_activation() {
	include_once(PG_DIR . '/functions.php');
	global $wpdb;

	$db_version = 4.01;
	$curr_vers = get_option('pg_db_version');
	
	// add or update DB table
	if(!$curr_vers || (float)$curr_vers < $db_version) {
		$sql = "CREATE TABLE ".$wpdb->prefix . "pg_users (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			insert_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			name VARCHAR(150) DEFAULT '' NOT NULL,
			surname VARCHAR(150) DEFAULT '' NOT NULL,
			username VARCHAR(150) NOT NULL,
			psw text NOT NULL,
			categories text NOT NULL,
			email VARCHAR(255) NOT NULL,
			tel VARCHAR(20) NOT NULL,
			page_id int(11) NOT NULL,
			wp_user_id mediumint(9) NOT NULL,
			disable_pvt_page smallint(1) NOT NULL,
			last_access datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			status smallint(1) NOT NULL,
			UNIQUE KEY (id, page_id, wp_user_id)
		) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
		update_option('pg_db_version', $db_version);
	}


	// create custom form style
	if(get_option('pg_style') == 'custom') {
		if(!pg_create_custom_style()) {update_option('pg_inline_css', 1);}
		else {delete_option('pg_inline_css');}
	}

	// minimum role to use plugin
	if(!get_option('pg_min_role')) { update_option('pg_min_role', 'upload_files');}
}
register_activation_hook(__FILE__, 'pg_on_activation');



//////////////////////////////////////////////////
// REMOVE WP HELPER FROM PLUGIN PAGES

function pg_remove_wp_helper() {
	$cs = get_current_screen();
	$hooked = array('toplevel_page_pg_user_manage', 'privatecontent_page_pg_add_user', 'privatecontent_page_pg_import_export', 'privatecontent_page_pg_settings');
	
	if(in_array($cs->base, $hooked)) {
		echo '
		<style type="text/css">
		#screen-meta-links {display: none;}
		</style>';	
	}
	
	//var_dump(get_current_screen()); // debug
}
add_action('admin_head', 'pg_remove_wp_helper', 999);
