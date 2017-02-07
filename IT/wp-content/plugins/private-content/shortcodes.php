<?php
////////// LIST OF SHORCODES

// [pc-login-form] 
// get the login form
function pg_login_form_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'redirect' 	=> ''
	), $atts ));
	
	return str_replace(array("\r", "\n", "\t", "\v"), '', pg_login_form($redirect));
}
add_shortcode('pc-login-form', 'pg_login_form_shortcode');



// [pc-logout-box] 
// get the logout box
function pg_logout_box_shortcode( $atts, $content = null ) {	
	extract( shortcode_atts( array(
		'redirect' 	=> ''
	), $atts ));
	
	return str_replace(array("\r", "\n", "\t", "\v"), '', pg_logout_btn($redirect));
}
add_shortcode('pc-logout-box', 'pg_logout_box_shortcode');



// [pc-registration-form] 
// get the registration form
function pg_registration_form_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'custom_category' => ''
	), $atts ));
	
	return str_replace(array("\r", "\n", "\t", "\v"), '', pg_registration_form($custom_category));	
}
add_shortcode('pc-registration-form', 'pg_registration_form_shortcode');



// [pc-pvt-content] 
// hide shortcode content if user is not logged and is not of the specified category or also if is logged
function pg_pvt_content_shortcode( $atts, $content = null ) {
	global $wpdb;
	$table_name = $wpdb->prefix . "pg_users";
	
	extract( shortcode_atts( array(
		'allow' 	=> 'all',
		'block'		=> '',
		'warning'	=> '1',
		'message'	=> ''
	), $atts ) );
	
	
	// if nothing is specified, return the content
	if(trim($allow) == '') {return do_shortcode($content);}
	else {
		include_once(PG_DIR.'/functions.php');	
	}

	// print something only if warning is active
	if($warning == '1') {
		
		// switch for js login system
		if(!get_option('pg_js_inline_login')) {$js_login = '';}
		else {$js_login = ' - <span class="pg_login_trig pg_trigger">'. __('login', 'pg_ml') .'</span>';}
		
		// prepare the message if user is not logged
		if($message == '') {
			if(!get_option('pg_default_nl_mex')) {$message = __('You must be logged in to view this content', 'pg_ml');}
			else {$message = get_option('pg_default_nl_mex');}
		}
		$message = '<div class="pg_login_block" id="'.$allow.'"><p>'.$message.$js_login.'</p></div>';
	
		// prepare message if user has not the right category
		if(!get_option('pg_default_uca_mex')) {
			$not_has_level_err = __("Sorry, you don't have the right permissions to view this content", 'pg_ml');
		} else {
			$not_has_level_err = get_option('pg_default_uca_mex');
		}
		$not_has_level_err = '<div class="pg_login_block" id="'.$allow.'"><p>'.$not_has_level_err.'</p></div>';
	} 
	else {
		$message = '';	
		$not_has_level_err = '';
	}
	
	
	// if has to be show to unlogged users
	if($allow == 'unlogged') {
		if(pg_user_check('unlogged') == 1) {return do_shortcode($content);}	
		else {return '';}
	}
	
	// if all/some categories are allowed 
	else {
		$response = pg_user_check($allow, $block);
		
		if($response == 1) {return do_shortcode($content);}
		elseif($response == 2) {return $not_has_level_err;}
		else {
			$login_form = (!get_option('pg_js_inline_login')) ? '' : '<div class="pg_inl_login_wrap" style="display: none;">'. pg_login_form() .'</div>'; 
			return $message . $login_form;
		}
	}
}
add_shortcode('pc-pvt-content', 'pg_pvt_content_shortcode');