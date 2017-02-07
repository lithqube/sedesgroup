<?php
// script to handle AJAX request and register the user


// HANDLE THE AJAX FORM SUBMIT
add_action('wp_loaded', 'pg_register_user', 1);
function pg_register_user() {
	global $wpdb;
		
	if(isset($_POST['type']) && $_POST['type'] == 'js_ajax_registration') {
		include_once(PG_DIR.'/functions.php');
		require_once(PG_DIR . '/classes/simple_form_validator.php');
		require_once(PG_DIR.'/classes/recaptchalib.php');

		////////// VALIDATION ////////////////////////////////////
		
		$form_structure = get_option('pg_registration_form');	

		$validator = new simple_fv;		
		$indexes = pg_validator_generator($form_structure);
				
		// re-captcha catch
		if(!get_option('pg_disable_recaptcha')) {
			$indexes[] = array('index'=>'recaptcha_challenge_field', 'label'=>'reCAPTCHA');
			$indexes[] = array('index'=>'recaptcha_response_field', 'label'=>'reCAPTCHA');
		}


		$validator->formHandle($indexes);
		$error = $validator->getErrors();
		$fdata = $validator->form_val;
		
		$antispam = get_option('pg_antispam_sys', 'honeypot');
		if($antispam == 'honeypot') {
			if(!pg_honeypot_validaton()) {
				$validator->custom_error["Antispam"] = "we've got a bot here!";	
			}
		}
		else {
			$privatekey = "6LfQas0SAAAAAIzpthJ7UC89nV9THR9DxFXg3nVL";
			$resp = pg_recaptcha_check_answer ($privatekey,
											$_SERVER["REMOTE_ADDR"],
											$fdata['recaptcha_challenge_field'],
											$fdata['recaptcha_response_field']);
											
			//var_dump($resp->is_valid);
		   if (!$resp->is_valid) {
			   $validator->custom_error["reCAPTCHA"] = __("wasn't entered correctly", 'pg_ml');
		   } 
		}
		
		
		// check disclaimer
		if(get_option('pg_use_disclaimer') && !isset($_POST['pg_disclaimer'])) {
			$validator->custom_error[__("Disclaimer", 'pg_ml')] =  __("must be accepted to proceed with registration", 'pg_ml');
		}
		
		// check username unicity
		if(trim($fdata['username']) != '') {
			$wpdb->query("SELECT ID FROM ".PG_DB_TABLE." WHERE username = '".$fdata['username']."' AND status != 0");
			if($wpdb->num_rows > 0) {$validator->custom_error[__("Username", 'pg_ml')] =  __("Another user already has this username", 'pg_ml');}
		}

		// if is using the pg_cat field - check the value
		if(isset($fdata['pg_cat'])) {
			$user_cat = (int)$fdata['pg_cat'];
			$wp_check = get_term($user_cat, 'pg_user_categories');
			
			if(!$wp_check) {$validator->custom_error[__("Username", 'pg_ml')] =  __("Invalid Category", 'pg_ml');}
		}
		else {
			// check forced category
			if(isset($_POST['pg_cc']) && term_exists((int)$_POST['pg_cc'], 'pg_user_categories')) {
				$user_cat = $_POST['pg_cc'];
			} else {
				$user_cat = get_option('pg_registration_cat');
			}
		}

		$error = $validator->getErrors();
		
		//////////////////////////////////////////////////////////////
		// CHECK E-MAIL UNICITY - MAIL ACTIONS ADD-ON
		if(isset($fdata['email'])) {
			$error = apply_filters('pcma_check_unique_mail', $error, 0, $fdata['email']);
		}
		//////////////////////////////////////////////////////////////
		
		
		/** password strength **/
		$error = pg_psw_strength($fdata['psw'], $error); 

		/** if WP user sync is active **/
		if(!$error && get_option('pg_wp_user_sync')) {
			global $pg_wp_users;
			$name = (isset($fdata['name'])) ? $fdata['name'] : ''; 
			$surname = (isset($fdata['surname'])) ? $fdata['surname'] : '';
			
			$wp_user_id = $pg_wp_users->sync_wp_user($fdata['username'], $fdata['psw'], $fdata['email'], $name, $surname, $existing_id = 0, $save_in_db = false);	
			
			if(get_option('pg_require_wps_registration') && !is_int($wp_user_id)) { // if sync is required
				$error = $wp_user_id;	
			}
		}
		
		
		if($error) {
			$mess = json_encode(array( 
				'resp' => 'error',
				'mess' => $error
			));
			die($mess);
		}
		else {
			//// REGISTRATION /////////////////////////

			// create array for the query
			foreach($fdata as $fkey => $fval) {
				// index to avoid
				$avoid = array('check_psw', 'recaptcha_challenge_field', 'recaptcha_response_field');
				
				if(!in_array($fkey, $avoid)) {$query_arr[$fkey] = $fval;}
			}
			
			// create the user page
			$new_entry = array();
			$new_entry['post_author'] = 1;
			$new_entry['post_content'] = get_option('pg_pvtpage_default_content');
			$new_entry['post_status'] = 'publish';
			$new_entry['post_title'] = $fdata['username'];
			$new_entry['post_type'] = 'pg_user_page';
			$entry_id = wp_insert_post( $new_entry, true );
			
			if(!$entry_id) {
				$mess = json_encode(array( 
					'resp' => 'error',
					'mess' => __('Error during user registration, contact the website administrator', 'pg_ml')
				));
				die($mess);
			}
			else {
				$fdata = pg_strip_opts($fdata);

				// set automatically to status 1?
				$status = (get_option('pg_registered_pending')) ? 3 : 1;
				
				// enable private page?
				$pp_status = (get_option('pg_registered_pvtpage ')) ? 0 : 1;
				
				// add
				$query_arr = array();
				
				$standard_fields = array('name', 'surname', 'username', 'email', 'tel');
				foreach($standard_fields as $sf) {
					if(isset($fdata[$sf])) {$query_arr[$sf] = trim($fdata[$sf]);}	
				}
				
				$query_arr['insert_date'] = current_time('mysql');
				$query_arr['page_id'] = $entry_id;
				$query_arr['psw'] = base64_encode($fdata['psw']);
				$query_arr['categories'] = serialize(array((string)$user_cat));
				$query_arr['status'] = $status;
				$query_arr['disable_pvt_page'] = $pp_status;
				
				if(isset($wp_user_id)) {
					$query_arr['wp_user_id'] = $wp_user_id;	
				}
				
				$wpdb->insert(PG_DB_TABLE, $query_arr);	
				$user_id = $wpdb->insert_id;

				//////////////////////////////////////////////////////////////
				// CUSTOM DATA SAVING - USER DATA ADD-ON
				do_action( 'pcud_save_custom_data', $fdata, $user_id);
				//////////////////////////////////////////////////////////////
				
				
				//////////////////////////////////////////////////////////////
				// ADMIN NOTIFIER - MAIL ACTIONS ADD-ON
				do_action( 'pcma_admin_notifier', $user_id);
				//////////////////////////////////////////////////////////////
				
				
				if($status == 3) {
					//////////////////////////////////////////////////////////////
					// USER VERIFICATION- MAIL ACTIONS ADD-ON
					do_action( 'pcma_send_mail_verif', $user_id, $entry_id, $fdata);
					//////////////////////////////////////////////////////////////
				}
				
				
				if($status == 1) {
					//////////////////////////////////////////////////////////////
					// MAILCHIMP SYNC - MAIL ACTIONS ADD-ON
					do_action( 'pcma_mc_auto_sync');
					//////////////////////////////////////////////////////////////
				}
					
				
				// success message
				if(get_option('pg_default_sr_mex')) { $mex = get_option('pg_default_sr_mex'); }
				else {$mex = __('Registration was succesful. Welcome!', 'pg_ml');}
				
				// registered user redirect
				$target = (int)get_option('pg_registered_user_redirect');
				($target != 0) ? $redirect_url = get_permalink($target): $redirect_url = '';
				
				$mess = json_encode(array( 
					'resp' 		=> 'success',
					'mess' 		=> $mex,
					'redirect'	=> $redirect_url
				));
				die($mess);
			}
		}
		die(); // security block
	}
}
