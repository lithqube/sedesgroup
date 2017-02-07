<?php

/* 
 * CHECK IF A USER IS LOGGED  
 * return object containing user data
 */
function pg_user_logged() {
	// check if Mail Actions add-on is using User Data shortcodes
	if(isset($GLOBALS['pcma_do_pcud_sc'])) {
		$obj = new stdClass();
   		$obj->id = $GLOBALS['pcma_do_pcud_sc'];
		return $obj;
	}
	/////////////////////////////////////////////////////////////
	
	if(!isset($_SESSION['pg_user_id']) && !isset($GLOBALS['pg_user_id'])) {return false;}
	else {
		global $wpdb;
		$user_id = (isset($_SESSION['pg_user_id'])) ? $_SESSION['pg_user_id'] : $GLOBALS['pg_user_id'];

		$user_data = $wpdb->get_row( 
			$wpdb->prepare( 
				"SELECT * FROM  ".PG_DB_TABLE." WHERE id = %d AND status = 1",
				$user_id 
			) 
		);
		
		return $user_data;	
	}
}



/* CHECK IF CURRENT USER CAN ACCESS TO AN AREA
 *  given the allowed param, check if the user have the right permissions
 *
 * @param allowed = allowed user categories	
 *		all 	= all categories
 *		unlogged = only non logged users
 * 		string of cat id: NUM,NUM,NUM
 *
 * @param blocked = speficy pvtContent categories blocked
 *		string of cat id: NUM,NUM,NUM	
 *
 * return
 *	false = non logged
 * 	2 = user have no permissions
 *  1 = right access
 */
function pg_user_check($allowed = 'all', $blocked = '') {
	global $wpdb;

	if(empty($allowed)) {return false;}
	$allowed_cat_arr = explode(',', $allowed);
	
	// check for logged user
	$curr_user = pg_user_logged();

	/*****/
	
	// UNLOGGED case
	if($allowed == 'unlogged') {
		// check for wp users
		if(is_user_logged_in() && !current_user_can('pvtcontent')) {
			if(get_option('pg_test_mode') && !$curr_user) {return 1;}
			elseif(!get_option('pg_test_mode') && !current_user_can(get_option('pg_min_role')) ) {return 1;}	
			else {return false;}
		}
		else {
			return (!$curr_user) ? 1 : false;	
		}
	}
	
	// if is a logged wordpress user return the content
	if (!get_option('pg_test_mode') && (is_user_logged_in() && current_user_can(get_option('pg_min_role')) )) {return 1;}
	else {
		// try to retrieve the current user ID
		if(!$curr_user) {return false;}
		else {	
		
			// if the allow parameter is set to ALL, return content
			if($allowed_cat_arr[0] == 'all') {return 1;}
			else {
				$cat_array = unserialize($curr_user->categories);
				
				if(!is_array($cat_array)) {return false;}
				else {
					
					// search if the user categories are in the shortcode's allowed
					$has_the_pass = false;
					foreach($cat_array as $u_cat) {
						if(in_array($u_cat, $allowed_cat_arr)) {$has_the_pass = true; break;}	
					}
					
					// match if there are blocked categories
					if($has_the_pass && !empty($blocked)) {
						$blocked_cat = explode(',', $blocked);
						
						foreach($cat_array as $u_cat) {
							if(in_array($u_cat, $blocked_cat)) {$has_the_pass = false; break;}	
						}
					}	
					
					return ($has_the_pass) ? 1 : 2;	
				}	
			}
		}
	}
}



/* GET THE MESSSAGE FOR NON LOGGED USERS 
 * @param mess = override the default message with a custom one
 */
function get_nl_message($mess = '') {
	if($mess == '') {
		if(!get_option('pg_default_nl_mex')) {$message = __('You must be logged in to view this content', 'pg_ml');}
		else {$message = get_option('pg_default_nl_mex');}	
		
		return $message;
	}
	else {return $mess;}
}



/* GET THE MESSSAGE FOR USER THAT HAVEN'T THE RIGT PERMISSIONS
 * @param mess = override the default message with a custom one
 */
function get_uca_message($mess = '') {
	if($mess == '') {
		if(!get_option('pg_default_uca_mex')) {
			$message = __("Sorry, you don't have the right permissions to view this content", 'pg_ml');
		}
		else {$message = get_option('pg_default_uca_mex');}
		
		return $message;
	}
	else {return $mess;}
}



/* GET LOGIN FORM
 * @param redirect = forces a specific redirect after login
 */
function pg_login_form($redirect = '') {
	include_once(PG_DIR.'/functions.php');
	
	$custom_redirect = (!empty($redirect)) ?  'pg_redirect="'.$redirect.'"' : '';
	$remember_me = get_option('pg_use_remember_me');
	$rm_class = ($remember_me) ? 'pg_rm_login' : '';
	
	$form = '
	<form class="pg_login_form '.$rm_class.'" '.$custom_redirect.'>
		<div class="pg_login_row">
			<label for="pg_auth_username">'. __('Username', 'pg_ml') .'</label>
			<input type="text" name="pg_auth_username" value="" autocapitalize="off" autocomplete="off" autocorrect="off" maxlength="150" />
			<hr class="pg_clear" />
		</div>
		<div class="pg_login_row">
			<label>'. __('Password', 'pg_ml') .'</label>
			<input type="password" name="pg_auth_psw" value="" autocapitalize="off" autocomplete="off" autocorrect="off" />
			<hr class="pg_clear" />
		</div>
		'.pg_honeypot_generator().'
		
		<div id="pg_auth_message"></div>
		
		<div class="pg_login_smalls">';
		
		  if($remember_me) {
			$form .= '
			<div class="pg_login_remember_me">
				<input type="checkbox" name="pg_remember_me" value="1" autocomplete="off" />
				<small>'. __('remember me', 'pg_ml') .'</small>
			</div>';
		  }
			
			//////////////////////////////////////////////////////////////
			// PSW RECOVERY TRIGGER - MAIL ACTIONS ADD-ON
			$form = apply_filters('pcma_psw_recovery_trigger', $form);	
			//////////////////////////////////////////////////////////////
		
		$form .= '
		</div>
		<input type="button" class="pg_auth_btn" value="'. __('Login', 'pg_ml') .'" />';
		
		//////////////////////////////////////////////////////////////
		// PSW RECOVERY CODE - MAIL ACTIONS ADD-ON
		$form = apply_filters('pcma_psw_recovery_code', $form);	
		//////////////////////////////////////////////////////////////
	
	$form .= '
		<hr class="pg_clear" />
	</form>';
	
	if(pg_user_logged()) {return false;}
	else {return $form;}
}


/* GET LOGOUT BUTTON
 * @param redirect = forces a specific redirect after logout
 */
function pg_logout_btn($redirect = '') {
	$custom_redirect = (!empty($redirect)) ?  'pg_redirect="'.$redirect.'"' : '';
	
	$logout = '
	<form class="pg_logout_box">
		<input type="button" value="'. __('Logout', 'pg_ml') .'" class="pg_logout_btn" '.$custom_redirect.' />
	</form>';
	
	if(!pg_user_logged()) {return false;}
	else {
		return $logout;
	}
}



/* LOGGING OUT USER */
function pg_logout() {
	$pg_user = pg_user_logged();
	if($pg_user) {
		if(isset($_SESSION['pg_user_id'])) unset($_SESSION['pg_user_id']);
		if(isset($GLOBALS['pg_user_id'])) unset($GLOBALS['pg_user_id']);
		
		setcookie('pg_user', '', time() - (3600 * 25), '/');

		// wp user sync - unlog if WP logged is the one synced
		if(get_option('pg_wp_user_sync')) {
			$current_user = wp_get_current_user();
			if($current_user->ID != 0 && $pg_user->wp_user_id == $current_user->ID) {
				wp_destroy_current_session();
	
				setcookie( AUTH_COOKIE,        ' ', time() - YEAR_IN_SECONDS, ADMIN_COOKIE_PATH,   COOKIE_DOMAIN );
				setcookie( SECURE_AUTH_COOKIE, ' ', time() - YEAR_IN_SECONDS, ADMIN_COOKIE_PATH,   COOKIE_DOMAIN );
				setcookie( AUTH_COOKIE,        ' ', time() - YEAR_IN_SECONDS, PLUGINS_COOKIE_PATH, COOKIE_DOMAIN );
				setcookie( SECURE_AUTH_COOKIE, ' ', time() - YEAR_IN_SECONDS, PLUGINS_COOKIE_PATH, COOKIE_DOMAIN );
				setcookie( LOGGED_IN_COOKIE,   ' ', time() - YEAR_IN_SECONDS, COOKIEPATH,          COOKIE_DOMAIN );
				setcookie( LOGGED_IN_COOKIE,   ' ', time() - YEAR_IN_SECONDS, SITECOOKIEPATH,      COOKIE_DOMAIN );
			
				// Old cookies
				setcookie( AUTH_COOKIE,        ' ', time() - YEAR_IN_SECONDS, COOKIEPATH,     COOKIE_DOMAIN );
				setcookie( AUTH_COOKIE,        ' ', time() - YEAR_IN_SECONDS, SITECOOKIEPATH, COOKIE_DOMAIN );
				setcookie( SECURE_AUTH_COOKIE, ' ', time() - YEAR_IN_SECONDS, COOKIEPATH,     COOKIE_DOMAIN );
				setcookie( SECURE_AUTH_COOKIE, ' ', time() - YEAR_IN_SECONDS, SITECOOKIEPATH, COOKIE_DOMAIN );
			
				// Even older cookies
				setcookie( USER_COOKIE, ' ', time() - YEAR_IN_SECONDS, COOKIEPATH,     COOKIE_DOMAIN );
				setcookie( PASS_COOKIE, ' ', time() - YEAR_IN_SECONDS, COOKIEPATH,     COOKIE_DOMAIN );
				setcookie( USER_COOKIE, ' ', time() - YEAR_IN_SECONDS, SITECOOKIEPATH, COOKIE_DOMAIN );
				setcookie( PASS_COOKIE, ' ', time() - YEAR_IN_SECONDS, SITECOOKIEPATH, COOKIE_DOMAIN );
				
				//wp_clear_auth_cookie(); // don't use the function to avoid interferences with do_action( 'clear_auth_cookie' );	
			}
		}
	}
	
	return true;	
}



/* REGISTRATION FORM 
 * @param forced_cat = assign a specific category for registered users
 */
function pg_registration_form($forced_cat = false) {
	include_once(PG_DIR.'/functions.php');
	include_once(PG_DIR.'/classes/recaptchalib.php');
	
	// if is not set the target user category, return an error
	if(!get_option('pg_registration_cat') || !get_option('pg_registration_form')) {
		return __('You have to set the default category for registered users', 'pg_ml');
	}
	else {
		$form_structure = get_option('pg_registration_form');	
		$layout_class = 'pg_'.get_option('pg_reg_layout', 'one_col').'_form';
		
		// custom category parameter
		if(isset($form_structure['include']) && !in_array("pg_cat", $form_structure['include']) && term_exists((int)$forced_cat, 'pg_user_categories')) {
			$cat_attr = 'pg_cc="'.$forced_cat.'"'; 	
		}
		else {$cat_attr = '';}
		
		
		$form = '<form class="pg_registration_form '.$layout_class.'" '.$cat_attr.'>';
		$custom_fields = '';
		
		//// anti-spam system
		$antispam = get_option('pg_antispam_sys', 'honeypot');
		if($antispam == 'honeypot') {
			$custom_fields .= pg_honeypot_generator();
		}
		else {
			$publickey = "6LfQas0SAAAAAIdKJ6Y7MT17o37GJArsvcZv-p5K";
			$custom_fields .= '
			<script type="text/javascript">
		    var RecaptchaOptions = {theme : "clean"};
		    </script>

			<li class="pg_rf_recaptcha">' . pg_recaptcha_get_html($publickey) . '</li>';
		}
		
		
		//// disclaimer
		if(get_option('pg_use_disclaimer')) {
			$custom_fields .= '
			<li class="pg_rf_disclaimer_sep"></li>
			<li class="pg_rf_disclaimer">
				<div class="pg_disclaimer_check"><input type="checkbox" name="pg_disclaimer" value="1" /></div>
				<div class="pg_disclaimer_txt">'.strip_tags((string)get_option('pg_disclaimer_txt'), '<br><a><strong><em>').'</div>
			</li>';
		}
		
		$form .= pg_form_generator($form_structure, $custom_fields);
		$form .= '
		<div id="pg_reg_message"></div>

		<input type="button" class="pg_reg_btn" value="'. __('Submit', 'pg_ml') .'" />
		</form>';
		
		return $form;
	}
}

