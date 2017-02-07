<?php 

// get the current URL
function pg_curr_url() {
	$pageURL = 'http';
	
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://" . $_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];

	return $pageURL;
}


// get file extension from a filename
function pg_stringToExt($string) {
	$pos = strrpos($string, '.');
	$ext = strtolower(substr($string,$pos));
	return $ext;	
}


// get filename without extension
function pg_stringToFilename($string, $raw_name = false) {
	$pos = strrpos($string, '.');
	$name = substr($string,0 ,$pos);
	if(!$raw_name) {$name = ucwords(str_replace('_', ' ', $name));}
	return $name;	
}


// string to url format
function pg_stringToUrl($string){
	$trans = array("à" => "a", "è" => "e", "é" => "e", "ò" => "o", "ì" => "i", "ù" => "u");
	$string = trim(strtr($string, $trans));
	$string = preg_replace('/[^a-zA-Z0-9-.]/', '_', $string);
	$string = preg_replace('/-+/', "_", $string);
	return $string;
}


// normalize a url string
function pg_urlToName($string) {
	$string = ucwords(str_replace('_', ' ', $string));
	return $string;	
}


// sanitize input field values
function pg_sanitize_input($val) {
	return trim(
		str_replace(array('\'', '"', '<', '>'), array('&apos;', '&quot;', '&lt;', '&gt;'), (string)$val)
	);	
}


// calculate elapsed time
function pg_elapsed_time($date) {
    // PHP <5.3 fix
	if(!method_exists('DateTime','getTimestamp')) {
		include_once(PG_DIR . '/classes/datetime_getimestamp_fix.php');
		
		$dt = new pg_DateTime($date);
		$timestamp = $dt->getTimestamp();	
	}
	else {	
		$dt = new DateTime($date);
		$timestamp = $dt->getTimestamp();
	}
	
	// calculate difference between server time and given timestamp
    $timestamp = current_time('timestamp') - $timestamp;

    //if no time was passed return 0 seconds
    if ($timestamp < 1){
        return '1 '. __('second', 'pg_ml');
    }

    //create multi-array with seconds and define values
    $values = array(
		12*30*24*60*60  =>  'year',
		30*24*60*60     =>  'month',
		24*60*60        =>  'day',
		60*60           =>  'hour',
		60              =>  'minute',
		1               =>  'second'
	);

    //loop over the array
    foreach ($values as $secs => $point){
        
		//check if timestamp is equal or bigger the array value
        $divRes = $timestamp / $secs;
        if ($divRes >= 1){
            
			//if timestamp is bigger, round the divided value and return it
            $res = round($divRes);
			
			// translatable strings
			switch($point) {
				case 'year' : $txt = ($res > 1) ? __('years', 'pg_ml') : __('year', 'pg_ml'); break; 
				case 'month': $txt = ($res > 1) ? __('months', 'pg_ml') : __('month', 'pg_ml'); break;
				case 'day'  : $txt = ($res > 1) ? __('days', 'pg_ml') : __('day', 'pg_ml'); break;	
				case 'hour' : $txt = ($res > 1) ? __('hours', 'pg_ml') : __('hour', 'pg_ml'); break;	
				case'minute': $txt = ($res > 1) ? __('minutes', 'pg_ml') : __('minute', 'pg_ml'); break;	
				case'second': $txt = ($res > 1) ? __('seconds', 'pg_ml') : __('second', 'pg_ml'); break;	
			}
            return $res. ' ' .$txt;
        }
    }
}


// get all the custom post types
function pg_get_cpt() {
	$args = array(
		'public'   => true,
		'publicly_queryable' => true,
		'_builtin' => false
	);
	$cpt_obj = get_post_types($args, 'objects');
	
	if(count($cpt_obj) == 0) { return false;}
	else {
		$cpt = array();
		foreach($cpt_obj as $id => $obj) {
			$cpt[$id] = $obj->labels->name;	
		}
		
		return $cpt;
	}	
}


// get all the custom taxonomies
function pg_get_ct() {
	$args = array(
		'public' => true,
		'_builtin' => false
	);
	$ct_obj = get_taxonomies($args, 'objects');
	
	if(count($ct_obj) == 0) { return false;}
	else {
		$ct = array();
		foreach($ct_obj as $id => $obj) {
			$ct[$id] = $obj->labels->name;	
		}
		
		return $ct;
	}	
}


// get affected post types
function pg_affected_pt() {
	$basic = array('post','page');	
	$cpt = get_option('pg_extend_cpt'); 

	if(is_array($cpt)) {
		$pt = array_merge((array)$basic, (array)$cpt);	
	}
	else {$pt = $basic;}

	return $pt;
}


// get affected  taxonomies
function pg_affected_tax() {
	$basic = array('category');	
	$ct = get_option('pg_extend_ct'); 
	
	if(is_array($ct)) {
		$tax = array_merge((array)$basic, (array)$ct);	
	}
	else {$tax = $basic;}
	
	return $tax;
}


// WP capabilities
function pg_wp_roles($role = false) {
	$roles = array(
		'read' 				=> __('Subscriber', 'pg_ml'),
		'edit_posts'		=> __('Contributor', 'pg_ml'),
		'upload_files'		=> __('Author', 'pg_ml'),
		'edit_pages'		=> __('Editor', 'pg_ml'),
		'install_plugins' 	=> __('Administrator', 'pg_ml')
	);
	
	if($role) {return $roles[$role];}
	else {return $roles;}
}


// stripslashes for options inserted
function pg_strip_opts($fdata) {
	if(!is_array($fdata)) {return false;}
	
	foreach($fdata as $key=>$val) {
		if(!is_array($val)) {
			$fdata[$key] = stripslashes($val);
		}
		else {
			$fdata[$key] = array();
			foreach($val as $arr_val) {$fdata[$key][] = stripslashes($arr_val);}
		}
	}
	
	return $fdata;
}


// manage redirects URL (for custom redirects)
function pg_man_redirects($key) {
	$baseval = get_option($key);
	if($baseval == '') {return '';}
	
	if($baseval == 'custom') {return get_option($key.'_custom');}
	else {
		// WPML integration
		if(function_exists('icl_link_to_element')) {
			$trans_val = icl_object_id($baseval, 'page', true);
			if($trans_val && get_post_status($trans_val) == 'publish') {
				return get_permalink($trans_val);
			}
		} 
		
		return get_permalink($baseval);
	}
}


// given user categories - return first category custom login redirect
function pg_user_cats_login_redirect($cats) {
	$cats = unserialize($cats);
	if(!is_array($cats)) {return '';}
	
	foreach($cats as $term_id) {
		$redirect = get_option("pg_ucat_".$term_id."_login_redirect");
		if($redirect) {
			return $redirect;
			break;	
		}
	}
}


// associative array of pg categories
function pg_cats_array() {
	$user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');	
	$cats = array();

	if (!is_wp_error($user_categories)) {
		foreach ($user_categories as $ucat) {
			if(!get_option("pg_ucat_".$ucat->term_id."_no_registration")) {
				$cats[$ucat->term_id] = $ucat->name;	
			}
		}
	}
	
	return $cats;
}


// create the frontend css and js
function pg_create_custom_style() {	
	ob_start();
	require(PG_DIR.'/custom_style.php');
	
	$css = ob_get_clean();
	if(trim($css) != '') {
		if(!@file_put_contents(PG_DIR.'/css/custom.css', $css, LOCK_EX)) {$error = true;}
	} else {
		if(file_exists(PG_DIR.'/css/custom.css'))	{ unlink(PG_DIR.'/css/custom.css'); }
	}
	
	if(isset($error)) {return false;}
	else {return true;}
}


// check inherited page parents /post categories restrictions
//// if category $param == term ID
//// if page $param == $post object
function pg_restrictions_helper($subj, $param, $tax = false) {
	$restr = array();
	
	// post types
	if($subj == 'post') {
		
		// search in the taxonomy term
		$term = get_term_by('id', $param, $tax);
		$allowed = trim( (string)get_option('taxonomy_'. $term->term_id .'_pg_redirect')); 
					
		if($allowed != '') {
			$restr[$term->name] = array();
			
			if($allowed ==  'all') {$restr[$term->name] = __('any logged user', 'pg_ml');}
			else {
				$allowed = explode(',', $allowed);
				$allowed_names = array(); 
				
				if(count($allowed) > 0) {
					foreach($allowed as $user_cat) {
						$uc_data = get_term_by('id', $user_cat, 'pg_user_categories');
						$allowed_names[] = $uc_data->name;
					}
					
					$restr[$term->name] = implode(', ', $allowed_names);
				}
			}
		}
		
		// check parent categories
		if(isset($term->category_parent) && $term->category_parent != 0) {
			$parent = get_term_by('id', $term->category_parent,  $tax);
			
			// recursive
			$rec_restr = pg_restrictions_helper('post', $parent->term_id, $tax);
			if($rec_restr) {
				$restr = array_merge($restr, $rec_restr);	
			}	
		}	
		
	}
	
	// page types
	else {
		
		// check parents page
		if($param->post_parent != 0) {
			$parent = get_post($param->post_parent);
		
			$allowed = get_post_meta($parent->ID, 'pg_redirect', true);
			
			if($allowed && is_array($allowed) && count($allowed) > 0) {
				if($allowed[0] ==  'all') 			{$restr[$parent->post_title] = __('any logged user', 'pg_ml');}
				elseif($allowed[0] == 'unlogged')	{$restr[$parent->post_title] = __('unlogged users', 'pg_ml');}
				else {
					$allowed_names = array(); 

					foreach($allowed as $user_cat) {
						$uc_data = get_term_by('id', $user_cat, 'pg_user_categories');
						$allowed_names[] = $uc_data->name;
					}
					
					$restr[$parent->post_title] = implode(', ', $allowed_names);
				}
			}
			
			// check deeper in parents
			if($param->post_parent != 0) {
				$post_obj = get_post($param->post_parent);
				
				// recursive
				$rec_restr = pg_restrictions_helper('page', $post_obj);
				if($rec_restr) {
					$restr = array_merge($restr, $rec_restr);	
				}	
			}
		}
		
	}
	
	return (empty($restr)) ? false : $restr;
}


// honeypot antispam code generator
function pg_honeypot_generator() {
	$calculation = mt_rand(0, 100) + mt_rand(0, 100);
	$hash = md5(sha1($calculation));
	
	return '
	<div class="pg_hnpt_code" style="display: none; visibility: hidden; position: fixed; left: -9999px;">
		<label for="pg_hnpt_1">Antispam 1</label>
		<input type="text" name="pg_hnpt_1" value="" autocomplete="off" />
		
		<label for="pg_hnpt_2">Antispam 2</label>
		<input type="text" name="pg_hnpt_2" value="'.$calculation.'" autocomplete="off" />
		
		<label for="pg_hnpt_3">Antispam 3</label>
		<input type="text" name="pg_hnpt_3" value="'.$hash.'" autocomplete="off" />
	</div>'; 
}


// honeypot antispam validator
function pg_honeypot_validaton() {
	// three fields must be valid
	if(!isset($_POST['pg_hnpt_1']) || !isset($_POST['pg_hnpt_2']) || !isset($_POST['pg_hnpt_3'])) {return false;}
	
	// first field must be empty
	if(!empty($_POST['pg_hnpt_1'])) {return false;}
	
	// hash of second must be equal to third
	if(md5(sha1($_POST['pg_hnpt_2'])) != $_POST['pg_hnpt_3']) {return false;}
	
	return true;
}


/////////////////////////////////////////////////////

// manage the form creator checks
function pg_reg_form_check($index, $type = 'include') {
	$reg_form_data = get_option('pg_registration_form');
	
	if($reg_form_data) {
		if(in_array($index, $reg_form_data[$type])) {return 'checked="checked"';}
		else {return false;}
	}
	else {return false;}	
}


// return all the fields available to use
function pg_form_fields($field = false, $order = true) {
	$fields = array(
		'name' => array(
			'label' 	=> __('Name', 'pg_ml'),
			'type' 		=> 'text',
			'subtype' 	=> '',
			'maxlen' 	=> 150,
			'opt'		=> '',
			'placeh'	=> '',
			'note' 		=> __('User name', 'pg_ml')
		),
		'surname' => array(
			'label' 	=> __('Surname', 'pg_ml'),
			'type' 		=> 'text',
			'subtype' 	=> '',
			'maxlen' 	=> 150,
			'opt'		=> '',
			'placeh'	=> '',
			'note'		=> __('User Surname', 'pg_ml')
		),
		'username' => array(
			'label' 	=> __('Username', 'pg_ml'),
			'type' 		=> 'text',
			'subtype' 	=> '',
			'maxlen' 	=> 150,
			'opt'		=> '',
			'placeh'	=> '',
			'note' 		=> __('Username used for the login', 'pg_ml'),
			'sys_req' 	=> true,
		),
		'psw' => array(
			'label' 	=> __('Password', 'pg_ml'),
			'type' 		=> 'password',
			'subtype' 	=> '',
			'minlen' 	=> get_option('pg_psw_min_length', 4),
			'maxlen' 	=> 100,
			'opt'		=> '',
			'note' 		=> __('Password used for the login', 'pg_ml'),
			'sys_req' 	=> true
		),
		'pg_cat' => array(
			'label' 	=> __('Category', 'pg_ml'),
			'type' 		=> 'assoc_select',
			'subtype' 	=> '',
			'maxlen' 	=> 20,
			'opt'		=> pg_cats_array(),
			'note' 		=> 'PrivateContent '. __('Categories', 'pg_ml')
		),
		'email' => array(
			'label' 	=> __('E-Mail', 'pg_ml'),
			'type' 		=> 'text',
			'subtype' 	=> 'email',
			'maxlen' 	=> 255,
			'opt'		=> '',
			'placeh'	=> '',
			'note' 		=> __('User E-mail', 'pg_ml'),
			'sys_req' 	=> // check if WP user sync is required - otherwise use PCMA mail verifier filter
			(get_option('pg_wp_user_sync') && get_option('pg_require_wps_registration')) ? true : apply_filters('pcma_set_mail_required', false) 
		),  
		'tel' => array(
			'label' 	=> __('Telephone', 'pg_ml'),
			'type' 		=> 'text',
			'subtype' 	=> '',
			'maxlen' 	=> 20,
			'opt'		=> '',
			'placeh'	=> '',
			'note' 		=> __('User Telephone', 'pg_ml')
		)
	);	
	
	// ADD FIELDS - WP FILTER
	$fields = apply_filters('pg_form_fields_filter', $fields);


	if(!$field) { return $fields; }
	else {
		return (isset($fields[$field])) ? $fields[$field] : false;
	}
}


// return the registration form fields - already orderd
function pg_reg_form_fields($field = false, $order = true) {
	$fields = pg_form_fields();
	
	if(!$field) {
		// order the fields and move at the end the un-odered indexes
		if(get_option('pg_field_order')) {
			foreach(get_option('pg_field_order') as $ord_field) {
				if(isset($fields[$ord_field])) {
					$ord_fields[$ord_field] = $fields[$ord_field];
					unset($fields[$ord_field]);	
				}
			}
			
			if(is_array($fields)) {
				foreach($fields as $index => $val) { $ord_fields[$index] = $val; }
			}
			
			return $ord_fields;
		}
		else {return $fields;}
	}
	else {
		return (isset($fields[$field])) ? $fields[$field] : false;
	}
}


/////////////////////////////////////////////////////

// easy validator - field array generator
//// $fields = ('(array)include', '(array)require')
function pg_validator_generator($fields) {
	$included = $fields['include'];
	$required = $fields['require'];
	
	if(!is_array($included)) {return false;}
	
	$indexes = array();
	$a = 0;
	foreach($included as $index) {
		$fval = pg_form_fields($index);
		
		// index
		$indexes[$a]['index'] = $index;
		
		// label
		$indexes[$a]['label'] = urldecode($fval['label']);
		
		// required
		if(in_array($index, $required) || (isset($fval['sys_req']) && $fval['sys_req'])) {$indexes[$a]['required'] = true;}
		
		// minlenght
		if($fval['type'] == 'password' || ($fval['type'] == 'text' && $fval['subtype'] == '')) {
			if(isset($fval['minlen'])) {$indexes[$a]['min_len'] = $fval['minlen'];}
		}
		
		// maxlenght
		if($fval['type'] == 'text' && ($fval['subtype'] == '' || $fval['subtype'] == 'int')) {$indexes[$a]['max_len'] = $fval['maxlen'];}
		
		// specific types
		if($fval['type'] == 'text' && $fval['subtype'] != '') {$indexes[$a]['type'] = $fval['subtype'];}

		// allowed values
		if($fval['type'] == 'select' || $fval['type'] == 'checkbox') {$indexes[$a]['allowed'] = explode(',', $fval['opt']);}

		////////////////////////////
		// password check validation
		if($index == 'psw') {
			// add fields check
			$indexes[$a]['equal'] = 'check_psw';
			
			// check psw validation
			$a++;
			$indexes[$a]['index'] = 'check_psw';
			$indexes[$a]['label'] = __('Repeat', 'pg_ml') .' '.$fval['label'];
			$indexes[$a]['maxlen'] = $fval['maxlen'];
		}

		$a++;	
	}
	
	return $indexes;
}


// password strength validator
function pg_psw_strength($psw, $errors) {
	$options = get_option('pg_psw_strength', array());
	if(!is_array($options) || count($options) == 0) {return $errors;}
	
	// regex validation
	$new_error = array();
	foreach($options as $opt) {
		if($opt == 'chars_digits') {
			if(!preg_match("((?=.*\d)(?=.*[a-zA-Z]))", $psw)) {$new_error[] = __('characters and digits', 'pg_ml');}	
		}
		elseif($opt == 'use_uppercase') {
			if(!preg_match("(.*[A-Z])", $psw)) {$new_error[] = __('an uppercase character', 'pg_ml');}	
		}
		elseif($opt == 'use_symbols') {
			if(!preg_match("(.*[^A-Za-z0-9])", $psw)) {$new_error[] = __('a symbol', 'pg_ml');}	
		}
	}
	if(count($new_error) > 0) {
		$regex_err = __('must contain at least ', 'pg_ml') .' '. implode(', ', $new_error);	
	}
	
	$br = (empty($errors)) ? '' : '<br/>';
	return (!isset($regex_err)) ? $errors : $errors .= $br. __('Password', 'pg_ml').' - '.$regex_err;
}


/////////////////////////////////////////////////////

// form generator
//// $fields = ('(array)include', '(array)require')
function pg_form_generator($fields, $manual_fields = false, $user_id = false) {
	$included = $fields['include'];
	$required = $fields['require'];
	
	if(!is_array($included)) {return false;}
	
	// if is specified the user id get the data to fill the field
	$ud = ($user_id) ? pg_get_user_full_data($user_id) : false;

	$form = '<ul class="pg_form_flist">';
	foreach($included as $field) {
		$fdata = pg_form_fields($field);		
		if($fdata) {
			// required message
			$req = (in_array($field, $required) || (isset($fdata['sys_req']) && $fdata['sys_req'])) ? '<span class="pg_req_field">*</span>' : '';
			
			// field classes
			$field_class = sanitize_title(urldecode($field));
			if($fdata['type'] == 'text' && ($fdata['subtype'] == 'eu_date' || $fdata['subtype'] == 'us_date')) {$field_class .= ' pcud_datepicker pcud_dp_'.$fdata['subtype'];}
			$type_class = 'class="'. $field_class .'"';
			
			// options for specific types
			if($fdata['type'] != 'assoc_select') {$opts = pg_form_get_options($fdata['opt']);}
			
			// field class - for field wrapper
			$f_class = 'class="pg_rf_field pg_rf_'. sanitize_title(urldecode($field)) .'"';
			
			// placeholder
			$placeh = (isset($fdata['placeh']) && !empty($fdata['placeh'])) ? 'placeholder="'.$fdata['placeh'].'"' : '';
			
			
			// text types
			if($fdata['type'] == 'text') {
				$val = ($ud) ? $ud[$field] : false;
				$form .= '
				<li '.$f_class.'>
					<label>'. __($fdata['label'], 'pg_ml') .' '.$req.'</label>
					<input type="'.$fdata['type'].'" name="'.$field.'" value="'.pg_sanitize_input($val).'" maxlength="'.$fdata['maxlen'].'" '.$placeh.' autocomplete="off" '.$type_class.'  />
					<hr class="pg_clear" />
				</li>';		
			}
			
			// password type
			elseif($fdata['type'] == 'password') {					
				$form .= '
				<li '.$f_class.'>
					<label>'. __($fdata['label'], 'pg_ml') .' '.$req.'</label>
					<input type="'.$fdata['type'].'" name="'.$field.'" value="" maxlength="' . $fdata['maxlen'] . '" '.$type_class.' autocomplete="off" />
					<hr class="pg_clear" />
				</li>
				<li class="pg_rf_field pg_rf_psw_confirm">	
					<label>'. __('Repeat', 'pg_ml') .' '. __($fdata['label'], 'pg_ml') .' '.$req.'</label>
					<input type="'.$fdata['type'].'" name="check_'.$field.'" value="" maxlength="' . $fdata['maxlen'] . '" autocomplete="off" '.$type_class.' />
					<hr class="pg_clear" />
				</li>';			
			}
			
			// textarea
			elseif($fdata['type'] == 'textarea') {
				($ud) ? $val = $ud[$field] : $val = false;
				$form .= '
				<li '.$f_class.'>
					<label class="pg_textarea_label">'. __($fdata['label'], 'pg_ml') .' '.$req.'</label>
					<textarea name="'.$field.'" class="pg_textarea '.$field_class.'" '.$placeh.'>'.$val.'</textarea>
					<hr class="pg_clear" />
				</li>';		
			}
			
			// select
			elseif($fdata['type'] == 'select') {	
				$form .= '
				<li '.$f_class.'>
					<label>'. __($fdata['label'], 'pg_ml') .' '.$req.'</label>
					<select name="'.$field.'" '.$type_class.'>';
				
				foreach($opts as $opt) { 
					($ud && $ud[$field] == $opt) ? $sel = 'selected="selected"' : $sel = false;
					$form .= '<option value="'.$opt.'" '.$sel.'>'.$opt.'</option>'; 
				}
				
				$form .= '
					</select>
					<hr class="pg_clear" />
				</li>';			
			}
			
			// associative select (for pg categories)
			elseif($fdata['type'] == 'assoc_select') {	
				$form .= '
				<li '.$f_class.'>
					<label>'. __($fdata['label'], 'pg_ml') .' '.$req.'</label>
					<select name="'.$field.'">';
				
				foreach($fdata['opt'] as $key => $val) { 
					$sel = ($ud && $ud[$field] == $key) ? 'selected="selected"' : false;
					$form .= '<option value="'.$key.'" '.$sel.'>'.$val.'</option>'; 
				}
				
				$form .= '
					</select>
					<hr class="pg_clear" />
				</li>';			
			}
			
			// checkbox
			elseif($fdata['type'] == 'checkbox') {	
				$form .= '
				<li '.$f_class.'>
					<label class="pg_cb_block_label">'. __($fdata['label'], 'pg_ml') .' '.$req.'</label>
					<div class="pg_check_wrap">';
					
					foreach($opts as $opt) { 
						$sel = ($ud && is_array($ud[$field]) && in_array($opt, $ud[$field])) ? 'checked="checked"' : false;
						$form .= '<input type="checkbox" name="'.$field.'[]" value="'.$opt.'" '.$sel.' /> <label class="pg_check_label">'.$opt.'</label>'; 
					}
				$form .= '
					</div>
					<hr class="pg_clear" />
				</li>';
			}
		}
	}
	
	if($manual_fields) { $form = $form . $manual_fields;}
	return $form . '</ul>';
}


// create the options for the select, checkbox and radio
function pg_form_get_options($opts) {
	if(trim($opts) == '') {return false;}
	
	$opts_arr = explode(',', $opts);
	foreach($opts_arr as $opt) {
		$right_opts[] = trim($opt);	
	}
	return $right_opts;
}


// get user data to fill the fields in the form generator
function pg_get_user_full_data($user_id, $db_col = false) {
	global $wpdb;
	$user_data = array();
	
	// standard data
	if(!$db_col) {
		$standard_fields = array('id', 'insert_date', 'name', 'surname', 'username', 'email', 'tel');
	} else {
		$standard_fields = $db_col;
	}
	
	$standard_data = $wpdb->get_row( 
		$wpdb->prepare(
			"SELECT ".implode(',', $standard_fields)." FROM  ".PG_DB_TABLE." WHERE id = %d AND status != 0",
			$user_id
		) 
	);
	
	if(!$standard_data) {return false;}
	if($db_col) {return $standard_data;}
	
	foreach($standard_fields as $standard_field) {
		$user_data[$standard_field] = $standard_data->$standard_field;	
	}
	
	///////////////////////////////////////////////////////////////////
	// CUSTOM DATA - USER DATA ADD-ON
	$user_data = apply_filters( 'pcud_get_user_custom_data', $user_data, $user_id);
	///////////////////////////////////////////////////////////////////	
	
	return $user_data;
}

