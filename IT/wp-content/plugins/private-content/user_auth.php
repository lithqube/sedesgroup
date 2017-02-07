<?php
// handle frontend AJAX requests to login/logout users


// load the auth form
add_action('init', 'pg_load_auth_form');
function pg_load_auth_form() {
	if(isset($_POST['type']) && $_POST['type'] == 'pg_get_auth_form') {
		echo pg_login_form();
		
		die();
	}
}


// handle the ajax form submit
add_action('init', 'pg_user_auth', 2);
function pg_user_auth() {
	global $wpdb;
	
	if(isset($_POST['type']) && $_POST['type'] == 'js_ajax_auth') {
		include_once(PG_DIR . '/classes/simple_form_validator.php');
		include_once(PG_DIR . '/functions.php');	
		
		$validator = new simple_fv;
		$indexes = array();
		
		$indexes[] = array('index'=>'pg_auth_username', 'label'=>'username', 'required'=>true);
		$indexes[] = array('index'=>'pg_auth_psw', 'label'=>'psw', 'required'=>true);
		$indexes[] = array('index'=>'pg_remember_me', 'label'=>'remember me');

		$validator->formHandle($indexes);
		$error = $validator->getErrors();
		$fdata = $validator->form_val;
		
		// honeypot check
		if(!pg_honeypot_validaton()) {
			echo json_encode(array( 
				'resp' => 'error',
				'mess' => "Antispam - we've got a bot here!"
			));
			die();
		}
		
		// error message
		$base_error = json_encode(array( 
			'resp' => 'error',
			'mess' => __('Username or password incorrect', 'pg_ml')
		));

		if($error) {die($base_error);}
		else {
			// db check
			$user_data = $wpdb->get_row( 
				$wpdb->prepare(
					"SELECT * FROM  ".PG_DB_TABLE." WHERE username = %s AND psw = %s AND status IN (1, 3)",
					trim(stripslashes($fdata['pg_auth_username'])),
					base64_encode($fdata['pg_auth_psw'])
				) 
			);
			
			if(!$user_data) {die($base_error);}
			else {
				
				// pending user message
				if(!get_option('pg_default_pu_mex')) {
					$is_pending_err = __("Sorry, your account has not been activated yet", 'pg_ml');
				}
				else {$is_pending_err = get_option('pg_default_pu_mex');}
				
				$is_pending_err = json_encode(array(
					'resp' => 'error',
					'mess' => $is_pending_err
				));
				
				
				//// success message
				// redirect logged user to pvt page
				if(get_option('pg_redirect_back_after_login') && isset($_SESSION['pg_last_restricted']) && filter_var($_SESSION['pg_last_restricted'], FILTER_VALIDATE_URL)) {
					$redirect_url = $_SESSION['pg_last_restricted'];
				}
				else {
					// check for custom categories redirects
					$custom_cat_redirect = pg_user_cats_login_redirect($user_data->categories);
					if($custom_cat_redirect) {
						$redirect_url = $custom_cat_redirect;	
					}
					else {
						if(get_option('pg_logged_user_redirect')) {
							$redirect_url = pg_man_redirects('pg_logged_user_redirect');
						}
						else {$redirect_url = '';}
					}
				}
				
				$success = json_encode(array(
					'resp' => 'success',
					'mess' => (get_option('pg_login_ok_mex')) ? get_option('pg_login_ok_mex') : __('Logged succesfully, welcome!', 'pg_ml'),
					'redirect' => $redirect_url
				));
				
				
				// check for bad status (0=>deleted, 3=>pending)
				if($user_data->status == 0) {die($base_error);}
				else if($user_data->status == 3) {die($is_pending_err);}
				
				// setup user session, cookie and global
				$_SESSION['pg_user_id'] = $user_data->id;
				$GLOBALS['pg_user_id'] = $user_data->id;
				
				// set cookie
				$cookie_time = (!empty($fdata['pg_remember_me'])) ? (3600 * 24 * 30 * 6) : (3600 * 6); // 6 month or 6 hours
				setcookie('pg_user', $user_data->id.'|||'.$user_data->psw, time() + $cookie_time, '/');
				
				// wp user sync 
				if(get_option('pg_wp_user_sync') && $user_data->wp_user_id) {
					// if an user is already logged - unlog
					if(is_user_logged_in()) {
						wp_destroy_current_session();
	        			wp_clear_auth_cookie();		
					}
					
					// wp signon
					$creds = array();
					$creds['user_login'] = $user_data->username;
					$creds['user_password'] = base64_decode($user_data->psw);
					$creds['remember'] = (!empty($fdata['pg_remember_me'])) ? true : false;
					
					$GLOBALS['pg_wps_standard_login'] = 1; // flag to avoid redirect after WP login by mirror user
					$user = wp_signon($creds, false);
				}
				
				//  reset the last restriction flag
				$_SESSION['pg_last_restricted'] = '';
				
				// update last login date
				$wpdb->update(PG_DB_TABLE, array('last_access' => current_time('mysql')), array('id' => $user_data->id)); 
				
				die($success);
			}
		}
		die(); // security block
	}
}



////////////////////////////////////////////////////////////////


// execute logout
add_action('init', 'pg_logout_user', 3); // IMPORTANT - execute as third to avoid interferences but let user data to be setup
function pg_logout_user() {
	if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'pg_logout') {
		include_once(PG_DIR . '/functions.php');
		pg_logout();	
	
		if(!isset($_POST['type'])) {return true;}
		
		// check if a redirect is needed
		if(get_option('pg_logout_user_redirect')) {
			$redirect_url = pg_man_redirects('pg_logout_user_redirect');
		}
		else {$redirect_url = '';}
		
		echo $redirect_url;
		die();
	}
}
