<?php 
////////////////////////////////////////////////////
/////////// IF IMPORING USERS //////////////////////
////////////////////////////////////////////////////

// security check
if(!isset($_POST['pg_import_users'])) {die('Nice try!');}
if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], 'lcwp_nonce')) {die('<p>Cheating?</p>');};

include_once(PG_DIR . '/functions.php');	
include_once(PG_DIR . '/classes/simple_form_validator.php');
global $wpdb;
	
$validator = new simple_fv;
$indexes = array();

//$indexes[] = array('index'=>'pg_imp_file', 'label'=>__('CSV file', 'pg_ml'), 'mime_type'=>array('application/vnd.ms-excel', 'application/octet-stream', 'application/csv', 'text/csv'), 'required'=>true);
$indexes[] = array('index'=>'pg_imp_separator', 'label'=>__("Field Delimiter", 'pg_ml'), 'required'=>true, 'max_len'=>1);
$indexes[] = array('index'=>'pg_imp_pvt_page', 'label'=>"Enable Pvt Page");
$indexes[] = array('index'=>'pg_imp_cat', 'label'=>__('Category', 'pg_ml'), 'required'=>true);
$indexes[] = array('index'=>'pg_imp_ignore_first', 'label'=>"Ignore first row");
$indexes[] = array('index'=>'pg_imp_error_stop', 'label'=>"Stop if errors found");
$indexes[] = array('index'=>'pg_imp_existing_stop', 'label'=>"Stop if duplicated found");
$indexes[] = array('index'=>'pg_wps_error_stop', 'label'=>"Stop if wp sync fails");

$validator->formHandle($indexes);
$fdata = $validator->form_val;

// more compatible upload validation
if(!isset($_FILES["pg_imp_file"]) || !isset($_FILES["pg_imp_file"]["tmp_name"]) || trim($_FILES["pg_imp_file"]["tmp_name"]) == '') {
	$validator->custom_error[__("CSV file", 'pg_ml')] =  __("is missing", 'pg_ml');
}
if( pg_stringToExt(strtolower($_FILES["pg_imp_file"]["name"])) != '.csv'){
	$validator->custom_error[__("CSV file", 'pg_ml')] =  __("invalid file uploaded", 'pg_ml');
}

$error = $validator->getErrors();
if($error) {$error = '<div class="error"><p>'.$error.'</p></div>';}
else {
	mb_internal_encoding('utf-8');
	$tmp_file = $_FILES["pg_imp_file"]["tmp_name"];

	// manage CSV and save data
	$imp_err = array();
	$imp_username_exist = array();
	$imp_mail_exist = array();
	$img_wps_exists = array();
	$imp_data = array();
	
	if (($handle = fopen($tmp_file, "r")) !== FALSE) {
		
		$row = 1;
		$fields = 6; // mandatory number of fields (name, surname, username, psw, mail, tel)
		
		while (($data = fgetcsv($handle, 0, $fdata['pg_imp_separator'])) !== FALSE) {
			if(!$fdata['pg_imp_ignore_first'] || ($fdata['pg_imp_ignore_first'] && $row > 1)) {
			
				$pcud_additional_f = (isset($_POST['pcud_import'])) ? count($_POST['pcud_import']) : 0;
				if(count($data) != ($fields + $pcud_additional_f)) {  
					$error = __('Row '.$row.' has a wrong number of values', 'pg_ml');
					break;
				}

				// validate data
				if(trim($data[2]) == '' || trim($data[3]) == '' || (trim($data[4]) != '' && !filter_var(trim($data[4]), FILTER_VALIDATE_EMAIL))) {
					$imp_err[] = $row;
				}
				else {
					
					//// check username and eventually mail unicity
					// mail check
					$mail_ck_query = (trim($data[4]) && $fdata['pg_imp_existing_stop'] && defined(PCMA_DIR) && get_option('pcma_mv_duplicates')) ? "OR email = '".addslashes(trim($data[4]))."'" : '';  
					$existing_user = $wpdb->get_row( 
						"SELECT username, email FROM ".PG_DB_TABLE." WHERE (username = '".addslashes(trim($data[2]))."' ".$mail_ck_query.") AND status != 0 LIMIT 1" 
					);
					if($existing_user) {
						if(trim($data[2]) == $existing_user->username) {$imp_username_exist[] = $row;}
						if(trim($data[4] && defined(PCMA_DIR) && get_option('pcma_mv_duplicates')) == $existing_user->email) {$imp_mail_exist[] = $row;}
					}

					// add user to list
					else {
			
						// WP user sync check
						if($fdata['pg_wps_error_stop'] && (username_exists(trim($data[2])) || email_exists(trim($data[4])) || empty($data[4])) ) {
							$img_wps_exists[] = $row;
						}
						
						// clean data
						$data = pg_strip_opts($data);
			
						$imp_data[$row]['name'] = trim($data[0]);
						$imp_data[$row]['surname'] = trim($data[1]);
						$imp_data[$row]['username'] = trim($data[2]);
						$imp_data[$row]['psw'] = base64_encode($data[3]);
						$imp_data[$row]['email'] = trim($data[4]);
						$imp_data[$row]['tel'] = trim($data[5]);
						$imp_data[$row]['categories'] = serialize(array($fdata['pg_imp_cat']));
						
						// user data add-on - index with all custom data 
						if(isset($_POST['pcud_import'])) {
							for($a=0; $a<6; $a++) {unset($data[$a]);} // remove first 6 columns
							$imp_data[$row]['pcud_fields'] = $data;	
						}
					}
				}
			}
			$row++;
		}
		fclose($handle);
		
		// if CSV file management is ok
		if(!$error) {

			//////////////////////////////////////////////////////////////
			// VALIDATE CUSTOM FIELDS IMPORT - USER DATA ADD-ON
			if(isset($_POST['pcud_import'])) {
				$pcud_error = apply_filters('pcud_import_validation', $_POST['pcud_import'], $imp_data);
			}
			//////////////////////////////////////////////////////////////
			
			
			// if there are errors and abort import 
			if($fdata['pg_imp_error_stop'] && count($imp_err) > 0) {
				$error = __('Missing values have been found in rows','pg_ml').': ' . implode(', ', $imp_err);	
			}
			elseif($fdata['pg_imp_existing_stop'] && (count($imp_username_exist) > 0)) {
				$error = __('Users with existing username have been found at rows','pg_ml').': ' . implode(', ', $imp_username_exist);	
			}
			elseif($fdata['pg_imp_existing_stop'] && (count($imp_mail_exist) > 0)) {
				$error = __('Users with existing e-mail have been found at rows','pg_ml').': ' . implode(', ', $imp_mail_exist);	
			}
			elseif($fdata['pg_wps_error_stop'] && (count($img_wps_exists) > 0)) {
				$error = __('Wordpress mirror users already existat rows','pg_ml').': ' . implode(', ', $img_wps_exists);	
			}
			elseif(isset($pcud_error) && $pcud_error != false) {
				$error = $pcud_error;
			}

			// import
			else {
				$imported_list = array(); // users ID array for e-mail add-on
				
				foreach($imp_data as $udata) {
					// enable private page?
					(!$fdata['pg_imp_pvt_page']) ? $pp_status = 1 : $pp_status = 0;
					
					// create array for the query
					$query_arr = array();
					$standard_fields = array('name', 'surname', 'username', 'psw', 'email', 'tel', 'categories');
					foreach($standard_fields as $sf) {
						if(isset($udata[$sf])) {$query_arr[$sf] = $udata[$sf];}	
					}
					
					$query_arr['disable_pvt_page'] = $pp_status;
					
					
					// create the user page
					global $current_user;
					
					$new_entry = array();
					$new_entry['post_author'] = $current_user->ID;
					$new_entry['post_content'] = get_option('pg_pvtpage_default_content');
					$new_entry['post_status'] = 'publish';
					$new_entry['post_title'] = $udata['username'];
					$new_entry['post_type'] = 'pg_user_page';
					$entry_id = wp_insert_post( $new_entry, true );
					
					if(!$entry_id) {
						$error = __('Error during user pages creation', 'pg_ml');
						break;	
					}
					else {
						// wp users sync
						if(get_option('pg_wp_user_sync') && !empty($query_arr['email'])) {
							global $pg_wp_users;
							$name = (isset($query_arr['name'])) ? $query_arr['name'] : ''; 
							$surname = (isset($query_arr['surname'])) ? $query_arr['surname'] : '';
							
							$wp_user_id = $pg_wp_users->sync_wp_user($query_arr['username'], base64_decode($query_arr['psw']), $query_arr['email'], $name, $surname, $existing_id = 0, $save_in_db = false);	
						}	
						
						// add
						$query_arr['insert_date'] = current_time('mysql');
						$query_arr['page_id'] = $entry_id;
						$query_arr['status'] = 1;
						
						if(isset($wp_user_id) && is_int($wp_user_id)) {
							$query_arr['wp_user_id'] = $wp_user_id;	
						}
						
						$wpdb->insert(PG_DB_TABLE, $query_arr);	
						$user_id = $wpdb->insert_id;
						
						//////////////////////////////////////////////////////////////
						// SAVE CUSTOM FIELDS - USER DATA ADD-ON
						if(isset($_POST['pcud_import'])) {
							do_action('pcud_import_save', $user_id, $_POST['pcud_import'], $udata['pcud_fields']);
						}
						//////////////////////////////////////////////////////////////
						
						if(trim($udata['email']) != '') {
							$imported_list[$user_id] = $udata;
						}
					}	
				}
			}
			
			////////////////////////////////////////
			// success message
			if(!$error) {
				$success = '
				<div class="updated"><p><strong>'. __('Import completed succesfully', 'pg_ml') .'</strong><br/><br/>
					Users added: '.count($imp_data);

					if(count($imp_err) > 0)	{ 
						$success .= '<br/>'. __('Missing values', 'pg_ml') .': '.count($imp_err).' ('. __('at rows', 'pg_ml') .': '.implode(',', $imp_err).')';
					}
					
					if(count($imp_username_exist) > 0)	{ 
						$success .= '<br/>'.count($imp_username_exist).' '. __('existing users', 'pg_ml').' ('. __('at rows', 'pg_ml') .': '.implode(',', $imp_username_exist).')';
					}
					
					if(count($imp_mail_exist) > 0)	{ 
						$success .= '<br/>'.count($imp_mail_exist).' '. __('duplicated e-mails', 'pg_ml').' ('. __('at rows', 'pg_ml') .': '.implode(',', $imp_mail_exist).')';
					}
					
					if(count($img_wps_exists) > 0)	{ 
						$success .= '<br/>'.count($img_wps_exists).' '. __('existing WP mirror users', 'pg_ml').' ('. __('at rows', 'pg_ml') .': '.implode(',', $img_wps_exists).')';
					}

				$success .= '</p></div>';	
				
				
				//////////////////////////////////////////////////////////////
				// MAIL IMPORTED USERS - MAIL ACTIONS ADD-ON
				if(isset($_POST['pg_mail_imported'])) {
					do_action('pcma_mail_imported', $imported_list);
				}
				//////////////////////////////////////////////////////////////
			}
		}
		
	} 
	else {$error = __('Temporary file cannot be read', 'pg_ml');}
	
	
	if($error) {$error = '<div class="error"><p>'.$error.'</p></div>';}
}
