<?php
////////////////////////////////////////////////
////// USER LIST - REMOVE //////////////////////
////////////////////////////////////////////////

function delete_pg_user_php() {
	if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], 'lcwp_ajax')) {die('Cheating?');};
	
	global $wpdb;
	$user_id = trim(addslashes($_POST['pg_user_id'])); 
	if (!filter_var($user_id, FILTER_VALIDATE_INT)) {die( __('Error processing the action', 'pg_ml') );}
	
	// if WP user sync is active
	if(get_option('pg_wp_user_sync')) {
		global $pg_wp_users;
		$pg_wp_users->detach_wp_user($user_id, $save_in_db = false);	
		
		$wps_q = ', wp_user_id = 0';
	}
	else {$wps_q = '';}
	
	$wpdb->query("UPDATE ".PG_DB_TABLE." SET status = 0 ".$wps_q." WHERE ID = '".$user_id."' ");
	
	//////////////////////////////////////////////////////////////
	// MAILCHIMP SYNC - MAIL ACTIONS ADD-ON
	do_action( 'pcma_mc_auto_sync');
	//////////////////////////////////////////////////////////////
	
	echo 'success';
	die();	
}
add_action('wp_ajax_delete_pg_user', 'delete_pg_user_php');


/*******************************************************************************************************************/


////////////////////////////////////////////////
/// WP USER SYNC - MANUALLY SYNC SINGLE USER ///
////////////////////////////////////////////////

function pg_wp_sync_single_user() {
	if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], 'lcwp_ajax')) {die('Cheating?');};
	include_once(PG_DIR . '/functions.php');
	
	global $pg_wp_users;
	$user_id = (int)$_POST['pg_user_id']; 
	
	$ud = pg_get_user_full_data($user_id, array('username', 'psw', 'email', 'name', 'surname'));
	if(empty($ud)) {die('user does not exist');}	
	
	$result = $pg_wp_users->sync_wp_user($ud->username, base64_decode($ud->psw), $ud->email, $ud->name, $ud->surname);	
	
	echo (is_int($result)) ? 'success' : $result;
	die();	
}
add_action('wp_ajax_pg_wp_sync_single_user', 'pg_wp_sync_single_user');



//////////////////////////////////////////////////
/// WP USER SYNC - MANUALLY DETACH SINGLE USER ///
//////////////////////////////////////////////////

function pg_wp_detach_single_user() {
	if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], 'lcwp_ajax')) {die('Cheating?');};
	include_once(PG_DIR . '/functions.php');
	
	global $pg_wp_users;
	$user_id = (int)$_POST['pg_user_id']; 
	
	$result = $pg_wp_users->detach_wp_user($user_id);
	
	echo ($result === true) ? 'success' : $result;
	die();	
}
add_action('wp_ajax_pg_wp_detach_single_user', 'pg_wp_detach_single_user');



////////////////////////////////////////////////
/// WP USER SYNC - GLOBAL SYNC /////////////////
////////////////////////////////////////////////

function pg_wp_global_sync() {
	if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], 'lcwp_ajax')) {die('Cheating?');};
	global $pg_wp_users;
	
	echo $pg_wp_users->global_sync();
	die();	
}
add_action('wp_ajax_pg_wp_global_sync', 'pg_wp_global_sync');



////////////////////////////////////////////////
/// WP USER SYNC - GLOBAL DETACH ///////////////
////////////////////////////////////////////////

function pg_wp_global_detach() {
	if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], 'lcwp_ajax')) {die('Cheating?');};
	global $pg_wp_users;
	
	echo $pg_wp_users->global_detach();
	die();	
}
add_action('wp_ajax_pg_wp_global_detach', 'pg_wp_global_detach');



////////////////////////////////////////////////////
/// WP USER SYNC - SERACH & SYNC EXISTING MATCHES //
////////////////////////////////////////////////////

function pg_wps_search_and_sync_matches() {
	if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], 'lcwp_ajax')) {die('Cheating?');};
	global $pg_wp_users;
	
	echo $pg_wp_users->search_and_sync_matches();
	die();	
}
add_action('wp_ajax_pg_wps_search_and_sync_matches', 'pg_wps_search_and_sync_matches');