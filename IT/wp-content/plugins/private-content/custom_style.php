<?php
////////////////////////////////////
// DYNAMICALLY CREATE THE CSS //////
////////////////////////////////////
include_once(PG_DIR . '/functions.php');

// remove the HTTP/HTTPS for SSL compatibility
$safe_baseurl = str_replace(array('http:', 'https:', 'HTTP:', 'HTTPS:'), '', PG_URL);
?>
/*BASIC STYLES */
@import url("<?php echo $safe_baseurl; ?>/css/frontend.css");


/***********************************
    GLOBAL ELEMENTS
 ***********************************/
  
/* containers style */
.pg_registration_form,
.pg_login_form,
.pg_custom_form {
	background-color: <?php echo get_option('pg_forms_bg_col', '#fefefe') ?>;
    border: 1px solid <?php echo get_option('pg_forms_border_col', '#ebebeb') ?>;
    border-radius: <?php echo get_option('pg_form_border_radius', 3) ?>px;
	color: <?php echo get_option('pg_label_col', '#333') ?>;	
}


/* fields style */
.pg_rf_field input, .pg_rf_field select, .pg_rf_field textarea,
.pg_login_row input, .pcma_psw_username,
.pg_rf_recaptcha #recaptcha_response_field {
	background: <?php echo get_option('pg_fields_bg_col', '#fefefe') ?>;
    border: <?php echo get_option('pg_field_border_w', 1) ?>px solid <?php echo get_option('pg_fields_border_col', '#ccc') ?>;
    color: <?php echo get_option('pg_fields_txt_col', '#808080') ?>;	
	padding: <?php echo get_option('pg_field_padding', 3) ?>px !important;
	border-radius: <?php echo get_option('pg_field_border_radius', 1) ?>px !important;
}
.pg_rf_field input:hover, .pg_rf_field select:hover, .pg_rf_field textarea:hover,
.pg_rf_field input:active, .pg_rf_field select:active, .pg_rf_field textarea:active,
.pg_rf_field input:focus, .pg_rf_field select:focus, .pg_rf_field textarea:focus,
.pg_login_row input:hover, .pcma_psw_username:hover,
.pg_login_row input:active, .pcma_psw_username:active,
.pg_login_row input:focus, .pcma_psw_username:focus,
.pg_rf_recaptcha #recaptcha_response_field:focus {
	background: <?php echo get_option('pg_fields_bg_col_h', '#fff') ?>;
    border: <?php echo get_option('pg_field_border_w', 1) ?>px solid <?php echo get_option('pg_fields_border_col_h', '#aaa') ?>;
    color: <?php echo get_option('pg_fields_txt_col_h', '#444') ?>;	
	box-shadow: none;	
}
.pg_login_form label, .pg_form_flist, .pg_form_flist label {
	color: <?php echo get_option('pg_label_col', '#333') ?>;
}


/* submit buttons */
.pg_login_form input[type="button"], 
.pg_registration_form input[type="button"],
.pg_custom_form input[type="button"],
.pg_logout_btn {
	background: <?php echo get_option('pg_btn_bg_col', '#f4f4f4') ?> !important;
	border: 1px solid <?php echo get_option('pg_btn_border_col', '#cccccc') ?> !important;
	border-radius: <?php echo get_option('pg_btn_border_radius', 1) ?>px !important;
	box-shadow: none;
	color: <?php echo get_option('pg_btn_txt_col', '#444444') ?> !important;	
}
.pg_login_form input[type="button"]:hover, .pg_login_form input[type="button"]:active, .pg_login_form input[type="button"]:focus,  
.pg_registration_form input[type="button"]:hover, .pg_registration_form input[type="button"]:active, .pg_registration_form input[type="button"]:focus,
.pg_custom_form input[type="button"]:hover, .pg_custom_form input[type="button"]:active, .pg_custom_form input[type="button"]:focus,
.pg_logout_btn:hover, .pg_logout_btn:active, .pg_logout_btn:focus,
.pg_loading_btn:hover, .pg_loading_btn:active, .pg_loading_btn:focus {
	background: <?php echo get_option('pg_btn_bg_col_h', '#efefef') ?> !important;
	border-color: <?php echo get_option('pg_btn_border_col_h', '#cacaca') ?> !important;
	color: <?php echo get_option('pg_btn_txt_col_h', '#222222') ?> !important;
}

.pg_rf_disclaimer_sep {
	border-bottom: 1px solid <?php echo get_option('pg_forms_border_col', '#ebebeb') ?>;	
}


/* recaptcha */
.pg_rf_recaptcha #recaptcha_table {
	border-color: <?php echo get_option('pg_fields_border_col', '#ccc') ?> !important;
}	
.pg_rf_recaptcha #recaptcha_response_field {
	background: <?php echo get_option('pg_fields_bg_col', '#fefefe') ?> !important;
	border-color: <?php echo get_option('pg_fields_border_col', '#ccc') ?> !important;	
	color: <?php echo get_option('pg_fields_txt_col', '#ccc') ?> !important;
}
.pg_rf_recaptcha #recaptcha_response_field:focus {
	border-color: <?php echo get_option('pg_fields_border_col_h', '#aaa') ?> !important;	
	color: <?php echo get_option('pg_fields_txt_col_h', '#fff') ?> !important;
    background: <?php echo get_option('pg_fields_bg_col_h', '#fff') ?> !important;
}
.pg_rf_recaptcha #recaptcha_reload_btn {
	background: url('<?php echo $safe_baseurl; ?>/img/recaptcha_icons/refresh_<?php echo get_option('pg_recaptcha_col', 'l') ?>.png') no-repeat center center transparent !important;
}
.pg_rf_recaptcha #recaptcha_switch_audio_btn {
	background: url('<?php echo $safe_baseurl; ?>/img/recaptcha_icons/sound_<?php echo get_option('pg_recaptcha_col', 'l') ?>.png') no-repeat center center transparent !important;
}
.pg_rf_recaptcha #recaptcha_switch_img_btn {
	background: url('<?php echo $safe_baseurl; ?>/img/recaptcha_icons/text_<?php echo get_option('pg_recaptcha_col', 'l') ?>.png') no-repeat center center transparent !important;
}
.pg_rf_recaptcha #recaptcha_whatsthis_btn {
	background: url('<?php echo $safe_baseurl; ?>/img/recaptcha_icons/question_<?php echo get_option('pg_recaptcha_col', 'l') ?>.png') no-repeat center center transparent !important;
}


  
/*********************************
   STANDARD LOGIN FORM ELEMENTS
 ********************************/
  
/* container message */
.pg_login_block p {
    border-radius: <?php echo get_option('pg_field_border_radius', 1) ?>px;
}
 

/*****************************
   SUCCESS AND ERROR MESSAGES
 *****************************/
 
/* standard form messages / widget form messages  */
.pg_error_mess,
.pg_success_mess,
.widget .pg_error_mess,
.widget .pg_success_mess {
    border-radius: <?php echo get_option('pg_field_border_radius', 1) ?>px;
}


/* login form smalls */
.pg_login_smalls small {
	color: <?php echo get_option('pg_label_col', '#333') ?>;	
    opacity: 0.8;
    filter: alpha(opacity=70);
}

/* show and hide recovery form trigger */
.pg_rm_login .pcma_psw_recovery_trigger {
	border-left-color: <?php echo get_option('pg_forms_border_col', '#ebebeb') ?>;	
}

è