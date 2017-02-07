<?php
// TOOLSET TO SYNC PVTCONTENT UESRES WITH WP ONES

class pg_wp_users {
	
	/* Global sync */
	public function global_sync() {
		global $wpdb;
		
		$user_query = $wpdb->get_results("SELECT username, psw, email, name, surname FROM ".PG_DB_TABLE." WHERE status != 0 AND wp_user_id = 0");
		if(!is_array($user_query) || count($user_query) == 0) {return __('All users already synced', 'pg_ml');}
		
		$not_synced = 0;
		$synced = 0;
		foreach($user_query as $ud) {
			if(empty($ud->email)) {$not_synced++;}
			else {
				$result	= $this->sync_wp_user($ud->username, base64_decode($ud->psw), $ud->email, $ud->name, $ud->surname); 
				if(!is_int($result)) {$not_synced++;}
				else {$synced++;}
			}
		}	
		
		$ns_mess = ($not_synced > 0) ? ' <em>('.$not_synced.' '.__("can't be synced because of their username or e-mail", 'pg_ml').')</em>' : '';
		return $synced.' '. __('Users synced successfully!', 'pg_ml') . $ns_mess;
	}
	
	
	/* 
	 * Sync a pvtContent user with a WP one (add or update)
	 * (int) $existing_id = WP user id to be updated
	 * (bool) $save_in_db = whether save the created user id in pvtContent database 
	 */
	public function sync_wp_user($username, $psw, $email, $name='', $surname='', $existing_id = 0, $save_in_db = true) {
		if(empty($email)) {return 'e-mail is mandatory to sync with WP user';}
		
		$userdata = array(
			'user_login'	=> $username,
			'user_email'	=> $email,
			'user_pass'		=> $psw,
			'first_name'	=> $name,
			'last_name'		=> $surname,
			'role'			=> 'pvtcontent'
		);
		
		// update user
		if(!empty($existing_id)) {
			$userdata['ID'] = $existing_id;
			unset($userdata['user_login']);
			unset($userdata['user_email']);
			
			// nicename 
			$nicename = $name .' '.$surname;
			if(empty($nicename)) {$nicename = $username;}
			$userdata['user_nicename'] = $nicename;
			$userdata['display_name'] = $nicename;
				
			$user_id = wp_update_user($userdata);
		}
		else {
			$user_id = wp_insert_user($userdata) ;
		}

		
		if(is_wp_error($user_id) ) {
			return $user_id->get_error_message(); // return wp error message
		}
		else {
			// if not updating - add record in pvtcontent DB
			if(!$existing_id && $save_in_db) {
				global $wpdb;
				$wpdb->query( 
					$wpdb->prepare( 
						"UPDATE ".PG_DB_TABLE." SET wp_user_id = %d WHERE username = %s AND status != 0",
						$user_id,
						$username
					) 
				);	
			}
					
			return $user_id;
		}	
	}
	
	
	
	/* Search existing pvtContent -> WP matches and sync */
	public function search_and_sync_matches() {
		global $wpdb;
		
		$user_query = $wpdb->get_results("
			SELECT username, psw, email, name, surname FROM ".PG_DB_TABLE." 
			WHERE status != 0 AND wp_user_id = 0 AND email != ''");
		if(!is_array($user_query) || count($user_query) == 0) {return __('All users already synced', 'pg_ml');}
		
		$synced = 0;
		foreach($user_query as $ud) {
			$existing_username = username_exists($ud->username);
			$existing_mail = email_exists($ud->email);
				
			if($existing_username && $existing_username == $existing_mail) {
				$userdata = array(
					'ID' 			=> $existing_username,
					'user_pass'		=> base64_decode($ud->psw),
					'first_name'	=> $ud->name,
					'last_name'		=> $ud->surname,
					'role'			=> 'pvtcontent'
				);	
				$user_id = wp_update_user($userdata);
				
				if(is_int($user_id)) {
					$synced++;
					
					global $wpdb;
					$wpdb->query( 
						$wpdb->prepare( 
							"UPDATE ".PG_DB_TABLE." SET wp_user_id = %d WHERE username = %s AND status != 0",
							$user_id,
							$ud->username
						) 
					);	
				}
			}
		}	
		
		return $synced .' '. __('matches found and syncs performed', 'pg_ml');
	}
	
	
	
	/* Global detach */
	public function global_detach() {
		global $wpdb;
		
		$user_query = $wpdb->get_results("SELECT id FROM ".PG_DB_TABLE." WHERE wp_user_id != 0 AND status != 0");
		if(!is_array($user_query) || count($user_query) == 0) {return __('All users already detached', 'pg_ml');}
		
		foreach($user_query as $ud) {
			$result	= $this->detach_wp_user($ud->id);
		}	
		
		return __('Users detached successfully!', 'pg_ml');
	}
	
	
	/* 
	 * Detach a pvtContent user with related WP one and delete it
	 * (int) $user_id = privatecontent user id
	 * (bool) $save_in_db = whether update sync record in pvtContent database 
	 */
	public function detach_wp_user($user_id, $save_in_db = true) {
		include_once(PG_DIR . '/functions.php');
		$ud = pg_get_user_full_data($user_id, array('wp_user_id'));
		if(empty($ud)) {die('user does not exist');}
		
		$wp_user_id = $ud->wp_user_id;
		if(!$wp_user_id) {return true;}
		wp_delete_user($wp_user_id);
		
		if($save_in_db) {
			global $wpdb;
			$wpdb->query( 
				$wpdb->prepare( 
					"UPDATE ".PG_DB_TABLE." SET wp_user_id = 0 WHERE id = %d AND status != 0",
					$user_id
				) 
			);			
		}
		return true;
	}
	
	
	
	/* 
	 * Check if a wp user is linked to a pvtcontent user
	 * (int) $user_id = wordpress user id
	 */
	public function wp_user_is_linked($user_id) {
		global $wpdb;
		if(empty($user_id)) {return false;}
		
		$user_data = $wpdb->get_row( 
			$wpdb->prepare(
				"SELECT id, psw, status, categories FROM ".PG_DB_TABLE." WHERE wp_user_id = %d LIMIT 1",
				$user_id
			) 
		);
		return $user_data;
	}
	
	
	
	/* 
	 * Check whether a pvtcontent user is synced 
	 * (int) $user_id = privatecontent user id
	 */
	public function pvtc_is_synced($user_id) {
		global $wpdb;
		if(empty($user_id)) {return false;}
		
		$user = $wpdb->get_row( 
			$wpdb->prepare(
				"SELECT id FROM ".PG_DB_TABLE." WHERE id = %d AND status != 0 LIMIT 1",
				$user_id
			) 
		);
		
		$exists = get_userdata($user->id);
		return ($exists == false) ? false : true;	
	}
	
	
	/* Update WP user nicename */
	public function update_nicename($user_id) {
		$ud = get_userdata($user_id);
		
		$nicename = $ud->user_firstname .' '. $ud->user_lastname;
		if(empty($nicename)) {$nicename = $ud->user_login;}
		
		wp_update_user(array(
			'ID'=>$user_id, 
			'user_nicename' => $nicename, 
			'display_name' => $nicename
		));
	}
}

$GLOBALS['pg_wp_users'] = new pg_wp_users;
