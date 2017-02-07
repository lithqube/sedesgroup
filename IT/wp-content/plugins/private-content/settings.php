<?php 
include_once(PG_DIR . '/functions.php'); 

// custom post type and taxonomies
$cpt = pg_get_cpt();
$ct = pg_get_ct();

// pages list
$pages = get_pages();  
?>

<style type="text/css">
#pg_pvtpage_default_content_ifr, #pg_pvtpage_preset_txt_ifr {
	background-color: #fff;	
}
</style>

<div class="wrap pg_form lcwp_form">  
	<div class="icon32" id="icon-pg_user_manage"><br></div>
    <?php    echo '<h2 class="pg_page_title">' . __( 'PrivateContent Settings', 'pg_ml') . "</h2>"; ?>  

    <?php
	// HANDLE DATA
	if(isset($_POST['pg_admin_submit'])) { 
		if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], __FILE__)) {die('<p>Cheating?</p>');};
		include_once(PG_DIR . '/classes/simple_form_validator.php');		
		
		$validator = new simple_fv;
		$indexes = array();
		
		$indexes[] = array('index'=>'pg_target_page', 'label'=>"User's Private Page");
		$indexes[] = array('index'=>'pg_target_page_content', 'label'=>'Target page content');
		$indexes[] = array('index'=>'pg_pvtpage_default_content', 'label'=>'Private page default content');
		$indexes[] = array('index'=>'pg_pvtpage_enable_preset', 'label'=>'Enable preset content');
		$indexes[] = array('index'=>'pg_pvtpage_preset_pos', 'label'=>'Preset content position');
		$indexes[] = array('index'=>'pg_pvtpage_preset_txt', 'label'=>'Preset content');
		$indexes[] = array('index'=>'pg_pvtpage_wps_comments', 'label'=>'Allow comments for WP synced users');
		
		$indexes[] = array('index'=>'pg_redirect_page', 'label'=>__( 'Redirect Page', 'pg_ml' ), 'required'=>true);
		$indexes[] = array('index'=>'pg_redirect_page_custom', 'label'=>__( 'Redirect Page - Custom URL', 'pg_ml' ));
		$indexes[] = array('index'=>'pg_logged_user_redirect', 'label'=>__( 'Logged Users Redirect', 'pg_ml' ));
		$indexes[] = array('index'=>'pg_logged_user_redirect_custom', 'label'=>__( 'Logged Users Redirect - Custom URL', 'pg_ml' ));
		$indexes[] = array('index'=>'pg_redirect_back_after_login', 'label'=>__( 'Move logged users to last restricted page', 'pg_ml' ));
		$indexes[] = array('index'=>'pg_logout_user_redirect', 'label'=>__( 'Users Redirect after logout', 'pg_ml' ));
		$indexes[] = array('index'=>'pg_logout_user_redirect_custom', 'label'=>__( 'Users Redirect after logout - Custom URL', 'pg_ml' ));
		
		$indexes[] = array('index'=>'pg_complete_lock', 'label'=>'Complete Lock');	
		$indexes[] = array('index'=>'pg_wp_user_sync', 'label'=>'WP user sync');	
		$indexes[] = array('index'=>'pg_require_wps_registration', 'label'=>'Require WP user sync in frontend registration');
		$indexes[] = array('index'=>'pg_extend_cpt', 'label'=>'Extend for CPT');
		$indexes[] = array('index'=>'pg_extend_ct', 'label'=>'Extend for CT');	
		$indexes[] = array('index'=>'pg_test_mode', 'label'=>'Testing Mode');
		$indexes[] = array('index'=>'pg_use_remember_me', 'label'=>'Use remember me cookies');
		$indexes[] = array('index'=>'pg_js_inline_login', 'label'=>'Login in inline restrictions');
		$indexes[] = array('index'=>'pg_min_role', 'label'=>'Minimum role');
		$indexes[] = array('index'=>'pg_min_role_tmu', 'label'=>'Minimum role to manage users');
		$indexes[] = array('index'=>'pg_hide_psw', 'label'=>'Hide passwords');	
		$indexes[] = array('index'=>'pg_force_inline_css', 'label'=>'Force inline css usage');
		
		$indexes[] = array('index'=>'pg_registration_cat', 'label'=>__( 'Registered Users Category', 'pg_ml' ));
		$indexes[] = array('index'=>'pg_antispam_sys', 'label'=>'Anti spam system');
		$indexes[] = array('index'=>'pg_registered_pending', 'label'=>'Pending Status registered');
		$indexes[] = array('index'=>'pg_registered_pvtpage', 'label'=>'Private page for registered');
		$indexes[] = array('index'=>'pg_registered_user_redirect', 'label'=>__( 'Registered Users Redirect', 'pg_ml' ));	
		$indexes[] = array('index'=>'pg_use_disclaimer', 'label'=>'Use disclaimer');
		$indexes[] = array('index'=>'pg_disclaimer_txt', 'label'=>__('Disclaimer text', 'pg_ml'), 'required'=>true);
		$indexes[] = array('index'=>'pg_psw_min_length', 'label'=>__('Minimum password length', 'pg_ml'), 'type'=>'int', 'required'=>true);
		$indexes[] = array('index'=>'pg_psw_strength', 'label'=>'Password strength');
		$indexes[] = array('index'=>'pg_field_order', 'label'=>__( 'Fields Order', 'pg_ml' ));		
		$indexes[] = array('index'=>'pg_use_field', 'label'=>__( 'Included Fields', 'pg_ml' ));
		$indexes[] = array('index'=>'pg_field_required', 'label'=>__( 'Required Fields', 'pg_ml' ));
		
		$indexes[] = array('index'=>'pg_reg_layout', 'label'=>'Form layout');
		$indexes[] = array('index'=>'pg_style', 'label'=>'Plugin style');
		$indexes[] = array('index'=>'pg_disable_front_css', 'label'=>'Disable Front CSS');
		
		$indexes[] = array('index'=>'pg_field_padding', 'label'=>__('Fields padding', 'pg_ml'), 'type'=>'int');
		$indexes[] = array('index'=>'pg_field_border_w', 'label'=>__('Fields border width', 'pg_ml'), 'type'=>'int');
		$indexes[] = array('index'=>'pg_form_border_radius', 'label'=>__('Forms border radius', 'pg_ml'), 'type'=>'int');
		$indexes[] = array('index'=>'pg_field_border_radius', 'label'=>__('Fields border radius', 'pg_ml'), 'type'=>'int');
		$indexes[] = array('index'=>'pg_btn_border_radius', 'label'=>__('Buttons border radius', 'pg_ml'), 'type'=>'int');
		$indexes[] = array('index'=>'pg_forms_bg_col', 'label'=>__('Forms background color', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_forms_border_col', 'label'=>__('Forms border color', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_label_col', 'label'=>__('Labels color', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_recaptcha_col', 'label'=>'Recaptcha icons color');
		$indexes[] = array('index'=>'pg_datepicker_col', 'label'=>'Datepicker theme');
		$indexes[] = array('index'=>'pg_fields_bg_col', 'label'=>__('Fields background color', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_fields_border_col', 'label'=>__('Fields border color', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_fields_txt_col', 'label'=>__('Fields text color', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_fields_bg_col_h', 'label'=>__('Fields background color - on hover', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_fields_border_col_h', 'label'=>__('Fields border color - on hover', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_fields_txt_col_h', 'label'=>__('Fields text color - on hover', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_btn_bg_col', 'label'=>__('Buttons background color', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_btn_border_col', 'label'=>__('Buttons border color', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_btn_txt_col', 'label'=>__('Buttons text color', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_btn_bg_col_h', 'label'=>__('Buttons background color - on hover', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_btn_border_col_h', 'label'=>__('Buttons border color - on hover', 'pg_ml'), 'type'=>'hex');
		$indexes[] = array('index'=>'pg_btn_txt_col_h', 'label'=>__('Buttons text color - on hover', 'pg_ml'), 'type'=>'hex');
		
		$indexes[] = array('index'=>'pg_custom_css', 'label'=>'Custom CSS');	
		
		$indexes[] = array('index'=>'pg_default_nl_mex', 'label'=>__( 'Message for not logged users', 'pg_ml' ), 'maxlen'=>255);
		$indexes[] = array('index'=>'pg_default_nhpa_mex', 'label'=>__( 'Message if haven\'t reserved area', 'pg_ml' ), 'maxlen'=>255);
		$indexes[] = array('index'=>'pg_login_ok_mex', 'label'=>__( 'Message for successful login', 'pg_ml' ), 'maxlen'=>170);
		$indexes[] = array('index'=>'pg_default_pu_mex', 'label'=>__( 'Message for pending users', 'pg_ml' ), 'maxlen'=>170);
		$indexes[] = array('index'=>'pg_default_uca_mex', 'label'=>__( 'Message for not right permissions', 'pg_ml' ), 'maxlen'=>170);
		$indexes[] = array('index'=>'pg_default_sr_mex', 'label'=>__( 'Message if registered', 'pg_ml' ), 'maxlen'=>170);
		
		$validator->formHandle($indexes);
		$fdata = $validator->form_val;
		
		
		// custom redirects error
		if($fdata['pg_redirect_page'] == 'custom' && !filter_var($fdata['pg_redirect_page_custom'], FILTER_VALIDATE_URL)) {
			$validator->custom_error[ __('Redirect Page / Custom URL', 'pg_ml') ] = __('Insert a valid URL', 'pg_ml'); 	
		}
		if($fdata['pg_logged_user_redirect'] == 'custom' && !filter_var($fdata['pg_logged_user_redirect_custom'], FILTER_VALIDATE_URL)) {
			$validator->custom_error[ __('Logged Users Redirect / Custom URL', 'pg_ml') ] = __('Insert a valid URL', 'pg_ml'); 	
		}
		if($fdata['pg_logout_user_redirect'] == 'custom' && !filter_var($fdata['pg_logout_user_redirect_custom'], FILTER_VALIDATE_URL)) {
			$validator->custom_error[ __('Logged Users Redirect / Custom URL', 'pg_ml') ] = __('Insert a valid URL', 'pg_ml'); 	
		}
		
		$error = $validator->getErrors();
		
		if($error) {echo '<div class="error"><p>'.$error.'</p></div>';}
		else {
			// clean data and save options
			foreach($fdata as $key=>$val) {
				if(!is_array($val)) {
					$fdata[$key] = stripslashes($val);
				} else {
					$fdata[$key] = array();
					foreach($val as $arr_val) {$fdata[$key][] = stripslashes($arr_val);}
				}
			
				if($fdata[$key] === false) {delete_option($key);}
				else {update_option($key, $fdata[$key]);}
			}
			
			// build registration form option
			$fdata['pg_registration_form'] = array('include'=>$fdata['pg_use_field'], 'require'=>$fdata['pg_field_required']);
			update_option('pg_registration_form', $fdata['pg_registration_form']);	
					
			// create custom style css file
			if(!get_option('pg_inline_css') && $fdata['pg_style'] == 'custom') {
				if(!pg_create_custom_style()) {
					update_option('pg_inline_css', 1);	
					echo '<div class="updated"><p>'. __('An error occurred during dynamic CSS creation. The code will be used inline anyway', 'pg_ml') .'</p></div>';
				}
				else {delete_option('pg_inline_css');}
			}
			
			echo '<div class="updated"><p><strong>'. __('Options saved', 'pg_ml') .'</strong></p></div>';
		}
	}
	
	else {  
		// Normal page display
		$fdata['pg_target_page'] = get_option('pg_target_page');  
		$fdata['pg_target_page_content'] = get_option('pg_target_page_content');
		$fdata['pg_pvtpage_default_content'] = get_option('pg_pvtpage_default_content');
		$fdata['pg_pvtpage_enable_preset'] = get_option('pg_pvtpage_enable_preset');
		$fdata['pg_pvtpage_preset_pos'] = get_option('pg_pvtpage_preset_pos');
		$fdata['pg_pvtpage_preset_txt'] = get_option('pg_pvtpage_preset_txt');
		$fdata['pg_pvtpage_wps_comments'] = get_option('pg_pvtpage_wps_comments');
		
		$fdata['pg_redirect_page'] = get_option('pg_redirect_page'); 
		$fdata['pg_redirect_page_custom'] = get_option('pg_redirect_page_custom'); 
		$fdata['pg_logged_user_redirect'] = get_option('pg_logged_user_redirect');
		$fdata['pg_logged_user_redirect_custom'] = get_option('pg_logged_user_redirect_custom');
		$fdata['pg_redirect_back_after_login'] = get_option('pg_redirect_back_after_login');
		$fdata['pg_logout_user_redirect'] = get_option('pg_logout_user_redirect');
		$fdata['pg_logout_user_redirect_custom'] = get_option('pg_logout_user_redirect_custom');		
		$fdata['pg_complete_lock'] = get_option('pg_complete_lock');
		$fdata['pg_wp_user_sync'] = get_option('pg_wp_user_sync');	
		$fdata['pg_require_wps_registration'] = get_option('pg_require_wps_registration');	
		$fdata['pg_extend_cpt'] = get_option('pg_extend_cpt');	
		$fdata['pg_extend_ct'] = get_option('pg_extend_ct');	
		$fdata['pg_test_mode'] = get_option('pg_test_mode'); 
		$fdata['pg_use_remember_me'] = get_option('pg_use_remember_me'); 
		$fdata['pg_js_inline_login'] = get_option('pg_js_inline_login'); 
		$fdata['pg_min_role'] = get_option('pg_min_role');
		$fdata['pg_min_role_tmu'] = get_option('pg_min_role_tmu');
		$fdata['pg_hide_psw'] = get_option('pg_hide_psw', 1); 	
		$fdata['pg_force_inline_css'] = get_option('pg_force_inline_css'); 	
				
		$fdata['pg_registration_cat'] = get_option('pg_registration_cat');
		$fdata['pg_antispam_sys'] = get_option('pg_antispam_sys');
		$fdata['pg_registered_pending'] = get_option('pg_registered_pending');
		$fdata['pg_registered_pvtpage'] = get_option('pg_registered_pvtpage');
		$fdata['pg_registered_user_redirect'] = get_option('pg_registered_user_redirect');
		$fdata['pg_use_disclaimer'] = get_option('pg_use_disclaimer');
		$fdata['pg_disclaimer_txt'] = get_option('pg_disclaimer_txt', 'By creating an account, you agree to the site <a href="#">Conditions of Use</a> and <a href="#">Privacy Notice</a>');
		$fdata['pg_psw_min_length'] = get_option('pg_psw_min_length', 4);
		$fdata['pg_psw_strength'] = get_option('pg_psw_strength', array()); if(!is_array($fdata['pg_psw_strength'])) {$fdata['pg_psw_strength'] = array();}
		$fdata['pg_field_order'] = get_option('pg_field_order');
		
		$fdata['pg_reg_layout'] = get_option('pg_reg_layout');
		$fdata['pg_style'] = get_option('pg_style', 'minimal');
		$fdata['pg_disable_front_css'] = get_option('pg_disable_front_css'); 
		
		$fdata['pg_field_padding'] = get_option('pg_field_padding', 3);
		$fdata['pg_field_border_w'] = get_option('pg_field_border_w', 1);
		$fdata['pg_form_border_radius'] = get_option('pg_form_border_radius', 3);
		$fdata['pg_field_border_radius'] = get_option('pg_field_border_radius', 1);
		$fdata['pg_btn_border_radius'] = get_option('pg_btn_border_radius', 2);
		$fdata['pg_forms_bg_col'] = get_option('pg_forms_bg_col', '#fefefe');
		$fdata['pg_forms_border_col'] = get_option('pg_forms_border_col', '#ebebeb');
		$fdata['pg_label_col'] = get_option('pg_label_col', '#333333');
		$fdata['pg_recaptcha_col'] = get_option('pg_recaptcha_col', 'l');
		$fdata['pg_datepicker_col'] = get_option('pg_datepicker_col', 'light');
		$fdata['pg_fields_bg_col'] = get_option('pg_fields_bg_col', '#fefefe');
		$fdata['pg_fields_border_col'] = get_option('pg_fields_border_col', '#cccccc');
		$fdata['pg_fields_txt_col'] = get_option('pg_fields_txt_col', '#808080');
		$fdata['pg_fields_bg_col_h'] = get_option('pg_fields_bg_col_h', '#ffffff');
		$fdata['pg_fields_border_col_h'] = get_option('pg_fields_border_col_h', '#aaaaaa');
		$fdata['pg_fields_txt_col_h'] = get_option('pg_fields_txt_col_h', '#444444');
		$fdata['pg_btn_bg_col'] = get_option('pg_btn_bg_col', '#f4f4f4');
		$fdata['pg_btn_border_col'] = get_option('pg_btn_border_col', '#cccccc');
		$fdata['pg_btn_txt_col'] = get_option('pg_btn_txt_col', '#444444');
		$fdata['pg_btn_bg_col_h'] = get_option('pg_btn_bg_col_h', '#efefef');
		$fdata['pg_btn_border_col_h'] = get_option('pg_btn_border_col_h', '#cacaca');
		$fdata['pg_btn_txt_col_h'] = get_option('pg_btn_txt_col_h', '#222222');
		
		$fdata['pg_custom_css'] = get_option('pg_custom_css'); 
		
		$fdata['pg_default_nl_mex'] = get_option('pg_default_nl_mex'); 
		$fdata['pg_default_nhpa_mex'] = get_option('pg_default_nhpa_mex');
		$fdata['pg_login_ok_mex'] = get_option('pg_login_ok_mex');
		$fdata['pg_default_pu_mex'] = get_option('pg_default_pu_mex');
		$fdata['pg_default_uca_mex'] = get_option('pg_default_uca_mex'); 
		$fdata['pg_default_sr_mex'] = get_option('pg_default_sr_mex');
	}  
	?>
    
    <br/>
    <div id="tabs">
    <form name="pg_admin" method="post" class="form-wrap" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
    
    <ul class="tabNavigation">
    	<li><a href="#main_opt"><?php _e('Main', 'pg_ml') ?></a></li>
        <li><a href="#form_opt"><?php _e('Registration Form', 'pg_ml') ?></a></li>
        <li><a href="#styling"><?php _e('Styling', 'pg_ml') ?></a></li>
        <li><a href="#mex_opt"><?php _e('Messages', 'pg_ml') ?></a></li>
    </ul>
        
    <div id="main_opt">
    	<h3><?php _e("Users Private Page", 'pg_ml'); ?></h3>
        <table class="widefat pg_table">
          <tr>
          	<td class="pg_label_td"><?php _e("Page to use as users private page container" ); ?></td>
            <td class="pg_field_td">
            	<select name="pg_target_page" class="lcweb-chosen" data-placeholder="<?php _e('Select a page', 'pg_ml') ?> .." tabindex="2">
                  <option value="">(<?php _e('no private page', 'pg_ml') ?>)</option>
                  <?php
                  foreach ( $pages as $pag ) {
                      ($fdata['pg_target_page'] == $pag->ID) ? $selected = 'selected="selected"' : $selected = '';
                      echo '<option value="'.$pag->ID.'" '.$selected.'>'.$pag->post_title.'</option>';
                  }
                  ?>
              </select>  
            </td>
            <td><span class="info"><?php _e("The chosen page's contengt will be <strong>overwritten</strong> once an user will log in", 'pg_ml') ?></span></td>
          </tr>
          <tr>
          	<td class="pg_label_td"><?php _e("Users private page content", 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<select name="pg_target_page_content" class="lcweb-chosen" data-placeholder="<?php _e('Select an option', 'pg_ml') ?> .." tabindex="2">
                  <option value="original_content"  <?php if(!$fdata['pg_target_page_content'] || $fdata['pg_target_page_content'] == 'original_content') {echo 'selected="selected"';} ?>>
                  	<?php _e("Original content", 'pg_ml') ?>
                  </option>
                  
                  <option value="original_plus_form" <?php if($fdata['pg_target_page_content'] == 'original_plus_form') {echo 'selected="selected"';} ?>>
                  	<?php _e("Original content + login form", 'pg_ml') ?>
                  </option>
                  
                  <option value="form_plus_original" <?php if($fdata['pg_target_page_content'] == 'form_plus_original') {echo 'selected="selected"';} ?>>
                  	<?php _e("Login form + original content", 'pg_ml') ?>
                  </option>
                  
                  <option value="only_form" <?php if($fdata['pg_target_page_content'] == 'only_form') {echo 'selected="selected"';} ?>>
                  	<?php _e("Only login form", 'pg_ml') ?>
                  </option>
                </select>  
            </td>
            <td><span class="info"><?php _e("Content that will see non logged users", 'pg_ml') ?></span></td>
          </tr>
          <tr>
           <td class="pg_label_td"><?php _e("Default private page content for new users", 'pg_ml'); ?></td>
           <td class="pg_field_td" colspan="2">
			  <?php 
			  $args = array('textarea_rows'=> 4);
			  echo wp_editor( $fdata['pg_pvtpage_default_content'], 'pg_pvtpage_default_content', $args); 
			  ?>
           </td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e("Enable preset content?", 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php ($fdata['pg_pvtpage_enable_preset']) ? $checked= 'checked="checked"' : $checked = ''; ?>
            <input type="checkbox" name="pg_pvtpage_enable_preset" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td><span class="info"><?php _e('If checked, display the preset content in pvt pages', 'pg_ml') ?></span></td>
         </tr>
         <tr>
          	<td class="pg_label_td"><?php _e("Preset content position" ); ?></td>
            <td class="pg_field_td">
            	<select name="pg_pvtpage_preset_pos" class="lcweb-chosen" data-placeholder="<?php _e('Select an option', 'pg_ml') ?> .." tabindex="2">
                  <option value="before" <?php if(!$fdata['pg_pvtpage_preset_pos'] || $fdata['pg_pvtpage_preset_pos'] == 'before') {echo 'selected="selected"';} ?>>
                  	<?php _e('Before the page content', 'pg_ml') ?>
                  </option>
                  <option value="after" <?php if($fdata['pg_pvtpage_preset_pos'] == 'after') {echo 'selected="selected"';} ?>>
                  	<?php _e('After the page content', 'pg_ml') ?>
                  </option>
                </select>  
            </td>
            <td><span class="info"><?php _e('Set the preset content position in the pvt page', 'pg_ml') ?></span></td>
          </tr>
          <tr>
           <td class="pg_label_td"><?php _e("Preset content", 'pg_ml'); ?></td>
           <td class="pg_field_td" colspan="2">
           	 <?php 
			 $args = array('textarea_rows'=> 4);
			 echo wp_editor( $fdata['pg_pvtpage_preset_txt'], 'pg_pvtpage_preset_txt', $args); 
			 ?>
           </td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e("Allow comments for WP synced users?", 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php $checked = ($fdata['pg_pvtpage_wps_comments']) ? 'checked="checked"' : ''; ?>
            <input type="checkbox" name="pg_pvtpage_wps_comments" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td><span class="info"><?php _e('Gives the ability to communicate with user through comments in his private page', 'pg_ml') ?><br/>
            <?php _e('<strong>Note</strong>: only users with WP sync will be able to do this', 'pg_ml') ?></span></td>
         </tr>
       </table> 
         
       <h3><?php _e("Redirects", 'pg_ml'); ?></h3>
       <table class="widefat pg_table">
        <tr>
          <td class="pg_label_td" rowspan="2"><?php _e("Restriction redirect target", 'pg_ml'); ?></td>
          <td class="pg_field_td">
              <select name="pg_redirect_page" id="pg_redirect_page" class="lcweb-chosen" data-placeholder="<?php _e('Select a page', 'pg_ml') ?> .." tabindex="2">
                  <option value="custom"><?php _e('Custom redirect', 'pg_ml') ?></option>
                  <?php
                  // list all wp pages
                  $a = 0;
				  foreach ( $pages as $pag ) {
                      ($fdata['pg_redirect_page'] == $pag->ID) ? $selected = 'selected="selected"' : $selected = '';
					 
					  if($a == 0 && !$fdata['pg_redirect_page']) {$selected = 'selected="selected"';}
					  $a++;
					  
					  echo '<option value="'.$pag->ID.'" '.$selected.'>'.$pag->post_title.'</option>';
                  }
                  ?>
              </select>   
          </td>
          <td><span class="info"><?php _e('Choose the page where users without permissions will be redirected', 'pg_ml') ?></span></td>
        </tr>
        <tr id="pg_redirect_page_cst_wrap">
        	<td colspan="2" <?php if($fdata['pg_redirect_page'] != 'custom') {echo 'style="display: none;"';} ?>>
            	<input type="text" name="pg_redirect_page_custom" value="<?php echo pg_sanitize_input($fdata['pg_redirect_page_custom']); ?>" style="width: 70%;" />
            </td>
        </tr>
        <tr>
          	<td class="pg_label_td" rowspan="2"><?php _e("Redirect page after user login", 'pg_ml'); ?></td>
            <td class="pg_field_td">
              <select name="pg_logged_user_redirect" id="pg_logged_user_redirect" class="lcweb-chosen" data-placeholder="Select a page .." tabindex="2">
                <option value=""><?php _e('Do not redirect users', 'pg_ml') ?></option>
                <option value="custom" <?php if($fdata['pg_logged_user_redirect'] == 'custom') echo 'selected="selected"'; ?>><?php _e('Custom redirect', 'pg_ml') ?></option>
                <?php
                // list all wp pages
                foreach ( $pages as $pag ) {
                    ($fdata['pg_logged_user_redirect'] == $pag->ID) ? $selected = 'selected="selected"' : $selected = '';
                    echo '<option value="'.$pag->ID.'" '.$selected.'>'.$pag->post_title.'</option>';
                }
                ?>
              </select>   
            </td>
            <td><span class="info"><?php _e('Select the page where users will be redirected after login', 'pg_ml') ?></span></td>
          </tr>
          <tr id="pg_logged_user_redirect_cst_wrap">
        	<td colspan="2" <?php if($fdata['pg_logged_user_redirect'] != 'custom') {echo 'style="display: none;"';} ?>>
            	<input type="text" name="pg_logged_user_redirect_custom" value="<?php echo pg_sanitize_input($fdata['pg_logged_user_redirect_custom']); ?>" style="width: 70%;" />
            </td>
          </tr>
          <tr>
             <td class="pg_label_td"><?php _e("Redirect users to the last restricted page?", 'pg_ml'); ?></td>
             <td class="pg_field_td">
              <?php ($fdata['pg_redirect_back_after_login']) ? $checked= 'checked="checked"' : $checked = ''; ?>
              <input type="checkbox" name="pg_redirect_back_after_login" value="1" <?php echo $checked; ?> class="ip_checks" />
             </td>
             <td><span class="info"><?php _e('If checked, move logged users back to the last restricted page they tried to see (if available)', 'pg_ml') ?></span></td>
          </tr>
          
          <tr>
          	<td class="pg_label_td" rowspan="2"><?php _e("Redirect page after user logout", 'pg_ml'); ?></td>
            <td class="pg_field_td">
              <select name="pg_logout_user_redirect" id="pg_logout_user_redirect" class="lcweb-chosen" data-placeholder="<?php _e('Select a page', 'pg_ml') ?> .." tabindex="2">
                <option value=""><?php _e('Do not redirect users', 'pg_ml') ?></option>
                <option value="custom" <?php if($fdata['pg_logout_user_redirect'] == 'custom') echo 'selected="selected"'; ?>><?php _e('Custom redirect', 'pg_ml') ?></option>
                <?php
                // list all wp pages
                foreach ( $pages as $pag ) {
                    ($fdata['pg_logout_user_redirect'] == $pag->ID) ? $selected = 'selected="selected"' : $selected = '';
                    echo '<option value="'.$pag->ID.'" '.$selected.'>'.$pag->post_title.'</option>';
                }
                ?>
              </select>   
            </td>
            <td><span class="info"><?php _e('Select the page where users will be redirected after logout', 'pg_ml') ?></span></td>
          </tr>
          <tr id="pg_logout_user_redirect_cst_wrap">
        	<td colspan="2" <?php if($fdata['pg_logout_user_redirect'] != 'custom') {echo 'style="display: none;"';} ?>>
            	<input type="text" name="pg_logout_user_redirect_custom" value="<?php echo pg_sanitize_input($fdata['pg_logout_user_redirect_custom']); ?>" style="width: 70%;" />
            </td>
          </tr>
       </table>   
       
       <h3><?php _e("Complete Site Lock", 'pg_ml') ?></h3>
       <table class="widefat pg_table">
         <tr>
           <td class="pg_label_td"><?php _e("Enable the lock?", 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php ($fdata['pg_complete_lock']) ? $checked= 'checked="checked"' : $checked = ''; ?>
            <input type="checkbox" name="pg_complete_lock" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td>
           	<span class="info" style="line-height: 23px;"><?php _e('If checked, the website will be completely hidden for non logged users', 'pg_ml') ?> <br/>
            <?php _e('<strong>Note</strong>: the "Restriction redirect target" will be visible to allow the users login. Be sure you are using a Wordpress page', 'pg_ml') ?></span>
           </td>
         </tr>
       </table>
       
       <div <?php if(!$cpt && !$ct) {echo 'style="display: none;"';} ?>>
         <h3><?php _e("Custom Post types and Taxonomies"); ?></h3>
         <table class="widefat pg_table">
           <?php if($cpt) : ?>
           <tr>
             <td class="pg_label_td"><?php _e("Enable restriction on these post types", 'pg_ml') ?></td>
             <td>
             <select name="pg_extend_cpt[]" multiple="multiple" class="lcweb-chosen" data-placeholder="<?php _e('Select the custom post types', 'pg_ml') ?> .." style="width: 50%;">
                <?php
                foreach($cpt as $id => $name) {
                    (is_array($fdata['pg_extend_cpt']) && in_array($id, $fdata['pg_extend_cpt'])) ? $selected = 'selected="selected"' : $selected = '';
                    echo '<option value="'.$id.'" '.$selected.'>'.$name.'</option>';
                }
                ?>
              </select> 
             </td>
           </tr>
           <?php 
		   endif;
		   
		   if($ct) : 
		   ?>
           <tr>
             <td class="pg_label_td"><?php _e("Enable restriction on these taxonomies", 'pg_ml'); ?></td>
             <td>
               <select name="pg_extend_ct[]" multiple="multiple" class="lcweb-chosen" data-placeholder="<?php _e("Select the custom taxonomies", 'pg_ml'); ?> .." tabindex="2" style="width: 50%;">
				<?php
                foreach($ct as $id => $name) {
                    (is_array($fdata['pg_extend_ct']) && in_array($id, $fdata['pg_extend_ct'])) ? $selected = 'selected="selected"' : $selected = '';
                    echo '<option value="'.$id.'" '.$selected.'>'.$name.'</option>';
                }
                ?>
              </select> 
             </td>
           </tr>
           <?php endif; ?>
         </table>
       </div>
       
       <h3><?php _e("Wordpress user system integration", 'pg_ml') ?></h3>
       <table class="widefat pg_table">
         <tr>
           <td class="pg_label_td"><?php _e("Enable integration?", 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php $checked = ($fdata['pg_wp_user_sync']) ? 'checked="checked"' : ''; ?>
            <input type="checkbox" name="pg_wp_user_sync" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td>
           	<span class="info" style="line-height: 23px;"><?php _e('If checked, privateContent users will be logged also with basic WP account', 'pg_ml') ?> <br/>
            <?php _e("<strong>What does this implies?</strong> For more details, please check the related documentation chapter", 'pg_ml') ?></span>
           </td>
         </tr>
         
         <?php if($fdata['pg_wp_user_sync']): ?>
         <tr>
           <td class="pg_label_td"><?php _e("Require sync during frontend registration?", 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php $checked = ($fdata['pg_require_wps_registration']) ? 'checked="checked"' : ''; ?>
            <input type="checkbox" name="pg_require_wps_registration" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td><span class="info"><?php _e('Allow new users only if WP user sync is successful (automatically adds e-mail field into registration form)', 'pg_ml') ?></span></td>
         </tr>
         <tr>
           <td colspan="2">
           	<input type="button" id="pg_do_wp_sync" class="button-secondary" value="<?php _e('Sync users', 'pg_ml') ?>" />
           	<span class="pg_gwps_result"></span>
           </td>
           <td><span class="info"><strong><?php _e('Only users with unique username and e-mail will be synced', 'pg_ml') ?></strong></span></td>
         </tr>
         
		 <?php // search existing pvtContent -> WP matches and sync 
		 if(isset($_GET['wps_existing_sync'])) : ?>
         <tr>
           <td colspan="2">
            <input type="button" id="pg_wps_matches_sync" class="button-secondary" value="<?php _e('Search existing matches and sync', 'pg_ml') ?>" />
            <span class="pg_gwps_result"></span>
           </td>
           <td><span class="info"><strong><?php _e('Search matches between existing PrivateContent and WP users, and sync them', 'pg_ml') ?></strong></span></td>
         </tr>
         <?php endif; ?>
           
         <tr>
           <td colspan="2">
           	<input type="button" id="pg_clean_wp_sync" class="button-secondary" value="<?php _e('Clear sync', 'pg_ml') ?>" />
           	<span class="pg_gwps_result"></span>
           </td>
           <td><span class="info"><?php _e('Detach previous sync and delete related WP users', 'pg_ml') ?></span></td>
         </tr>
         <?php endif; ?>
       </table>
       
       <h3><?php _e("Advanced", 'pg_ml'); ?></h3>
       <table class="widefat pg_table">
       	 <tr>
           <td class="pg_label_td"><?php _e('Enable "testing" mode?', 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php ($fdata['pg_test_mode']) ? $checked= 'checked="checked"' : $checked = ''; ?>
            <input type="checkbox" name="pg_test_mode" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td><span class="info"><?php _e("If checked, WP users won't be able to see private contents", 'pg_ml'); ?></span></td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e('Use "remember me" check in login form?', 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php ($fdata['pg_use_remember_me']) ? $checked= 'checked="checked"' : $checked = ''; ?>
            <input type="checkbox" name="pg_use_remember_me" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td><span class="info"><?php _e('If checked, allow users to keep logged into the website', 'pg_ml'); ?></span></td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e("Use the inline login with PvtContent shortcode?", 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php ($fdata['pg_js_inline_login']) ? $checked= 'checked="checked"' : $checked = ''; ?>
            <input type="checkbox" name="pg_js_inline_login" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td><span class="info"><?php _e('If checked, allow users to login from the warning box', 'pg_ml'); ?></span></td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e("Minimum role to use the plugin", 'pg_ml'); ?></td>
           <td class="pg_field_td">
           	  <select name="pg_min_role" class="lcweb-chosen" data-placeholder="<?php _e('Select a role', 'pg_ml'); ?>" tabindex="2">
				<?php
				if(!$fdata['pg_min_role']) {$fdata['pg_min_role'] = 'upload_files';}
                foreach(pg_wp_roles() as $capab => $name) {
                    ($fdata['pg_min_role'] == $capab) ? $selected = 'selected="selected"' : $selected = '';
                    echo '<option value="'.$capab.'" '.$selected.'>'.$name.'</option>';
                }
                ?>
              </select> 
           </td>
           <td><span class="info"><?php _e('Minimum WP role to use the plugin and see private contents', 'pg_ml'); ?></span></td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e("Minimum role to manage users", 'pg_ml'); ?></td>
           <td class="pg_field_td">
           	  <select name="pg_min_role_tmu" class="lcweb-chosen" data-placeholder="<?php _e('Select a role', 'pg_ml'); ?>" tabindex="2">
				<?php
				if(!$fdata['pg_min_role_tmu']) {$fdata['pg_min_role_tmu'] = 'upload_files';}
                foreach(pg_wp_roles() as $capab => $name) {
                    ($fdata['pg_min_role_tmu'] == $capab) ? $selected = 'selected="selected"' : $selected = '';
                    echo '<option value="'.$capab.'" '.$selected.'>'.$name.'</option>';
                }
                ?>
              </select> 
           </td>
           <td><span class="info"><?php _e('Minimum WP role to edit and manage users', 'pg_ml'); ?></span></td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e('Hide passwords in the admin panel?', 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php ($fdata['pg_hide_psw']) ? $checked= 'checked="checked"' : $checked = ''; ?>
            <input type="checkbox" name="pg_hide_psw" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td><span class="info"><?php _e('If checked, passwords will be unreadable in the admin panel', 'pg_ml'); ?></span></td>
         </tr>
         <tr>
            <td class="lcwp_label_td"><?php _e("Use custom CSS inline?", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <?php ($fdata['pg_force_inline_css'] == 1) ? $sel = 'checked="checked"' : $sel = ''; ?>
                <input type="checkbox" value="1" name="pg_force_inline_css" class="ip_checks" <?php echo $sel; ?> />
            </td>
            <td>
            	<span class="info"><?php _e('If checked, uses custom CSS inline (useful for multisite installations)', 'pg_ml') ?></span>
            </td>
          </tr>
       </table>
    </div>
    

    <div id="form_opt">
    	<h3><?php _e("General registration settings", 'pg_ml'); ?></h3>
    	<table class="widefat pg_table">
         <tr>
           <td class="pg_label_td"><?php _e("Default category for registered users", 'pg_ml'); ?></td>
           <td class="pg_field_td">
           	  <select name="pg_registration_cat" class="lcweb-chosen" data-placeholder="<?php _e("Select a category", 'pg_ml'); ?> .." tabindex="2">
                <option value=""></option>
				  <?php
				  // all user categories
				  $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
				  
				  foreach ($user_categories as $ucat) {
					($ucat->term_id == $fdata['pg_registration_cat']) ? $selected = 'selected="selected"' : $selected = '';
					  
					 echo '<option value="'.$ucat->term_id.'" '.$selected.'>'.$ucat->name.'</option>';
				  }
                  ?>
              </select> 
           </td>
           <td><span class="info"><?php _e("The user will be assigned automatically after the registration", 'pg_ml'); ?></span></td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e("Anti-spam system", 'pg_ml'); ?></td>
           <td class="pg_field_td">
           	  <select name="pg_antispam_sys" class="lcweb-chosen" data-placeholder="<?php _e("Select an option", 'pg_ml'); ?> .." tabindex="2">
                <option value="honeypot"><?php _e('Honey pot hidden system', 'pg_ml') ?></option>
				<option value="recaptcha" <?php if($fdata['pg_antispam_sys'] == 'recaptcha') echo'selected="selected"' ?>><?php _e('reCAPTCHA validation', 'pg_ml') ?></option>
              </select> 
           </td>
           <td><span class="info"><?php _e("Choose the anti-spam solution you prefer", 'pg_ml'); ?></span></td>
         </tr>
         <tr>
            <td class="pg_label_td"><?php _e("Set users status as pending after registration?", 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<?php ($fdata['pg_registered_pending']) ? $checked= 'checked="checked"' : $checked = ''; ?>
            	<input type="checkbox" name="pg_registered_pending" value="1" <?php echo $checked; ?> class="ip_checks" />
            </td>
            <td></td>
         </tr>
         <tr>
            <td class="pg_label_td"><?php _e("Enable the private page for new registered users?", 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<?php ($fdata['pg_registered_pvtpage']) ? $checked= 'checked="checked"' : $checked = ''; ?>
            	<input type="checkbox" name="pg_registered_pvtpage" value="1" <?php echo $checked; ?> class="ip_checks" />
            </td>
            <td></td>
         </tr>
         <tr>
          	<td class="pg_label_td"><?php _e("Redirect page after registration", 'pg_ml'); ?></td>
            <td class="pg_field_td">
              <select name="pg_registered_user_redirect" class="lcweb-chosen" data-placeholder="<?php _e("Select a page", 'pg_ml'); ?> .." tabindex="2">
                <option value=""><?php _e("Do not redirect users", 'pg_ml'); ?></option>
                <?php
                // list all wp pages
                foreach ( $pages as $pag ) {
                    ($fdata['pg_registered_user_redirect'] == $pag->ID) ? $selected = 'selected="selected"' : $selected = '';
                    echo '<option value="'.$pag->ID.'" '.$selected.'>'.$pag->post_title.'</option>';
                }
                ?>
              </select>   
            </td>
            <td><span class="info"><?php _e("Select the page where registered users will be redirected after registration", 'pg_ml'); ?></span></td>
          </tr>
      </table>
        
      <h3><?php _e("Disclaimer", 'pg_ml'); ?></h3>
      <table class="widefat pg_table">
        <tr>
           <td class="pg_label_td"><?php _e('Enable disclaimer?', 'pg_ml'); ?></td>
           <td class="pg_field_td">
            <?php ($fdata['pg_use_disclaimer']) ? $checked= 'checked="checked"' : $checked = ''; ?>
            <input type="checkbox" name="pg_use_disclaimer" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td><span class="info"><?php _e('If checked, append the disclaimer to the registration form', 'pg_ml'); ?></span></td>
        </tr>
        <tr>
          <td class="pg_label_td"><?php _e("Disclaimer text", 'pg_ml'); ?></td>
          <td class="pg_field_td" colspan="2">
			  <?php 
			  $args = array('textarea_rows'=> 2);
			  echo wp_editor( $fdata['pg_disclaimer_txt'], 'pg_disclaimer_txt', $args); 
			  ?>
          </td>
		</tr>
      </table>
       
      <h3><?php _e("Password security settings", 'pg_ml'); ?></h3>
      <table class="widefat pg_table">
        <tr>
           <td class="pg_label_td"><?php _e('Minimum password length', 'pg_ml'); ?></td>
           <td class="pg_field_td">
              <div class="lcwp_slider" step="1" max="10" min="4"></div>
              <input type="text" value="<?php echo (int)$fdata['pg_psw_min_length']; ?>" name="pg_psw_min_length" class="lcwp_slider_input" />
          </td>
          <td><span class="info"><?php _e('Set a minimum characters number for user passwords', 'pg_ml'); ?></span></td>
		</tr>
        <tr>
           <td class="pg_label_td"><?php _e("Password strength options", 'pg_ml') ?></td>
           <td>
           <select name="pg_psw_strength[]" multiple="multiple" class="lcweb-chosen" data-placeholder="<?php _e('select an option', 'pg_ml') ?> .."  style="width: 100%;">
              <option value="chars_digits" <?php if(in_array('chars_digits', $fdata['pg_psw_strength'])) echo'selected="selected"' ?>><?php _e('use characters and digits', 'pg_ml') ?></option>
              <option value="use_uppercase" <?php if(in_array('use_uppercase', $fdata['pg_psw_strength'])) echo'selected="selected"' ?>><?php _e('use uppercase characters', 'pg_ml')?></option>
              <option value="use_symbols" <?php if(in_array('use_symbols', $fdata['pg_psw_strength'])) echo'selected="selected"' ?>><?php _e('use symbols', 'pg_ml') ?></option>
            </select> 
           </td>
           <td><span class="info"><?php _e('Improve passwords strength with these options', 'pg_ml'); ?></span></td>
         </tr>
       </table> 
        
       <?php 
	   $form_fields = pg_reg_form_fields();
	   ?> 
    	<h3><?php _e("Registration form fields", 'pg_ml'); ?></h3>
    	<table id="pg_form_creator" class="widefat pg_table">
          <thead>
          <tr>
            <th style="width: 15px;"></th>
          	<th><?php _e('Field', 'pg_ml'); ?></th>
            <th style="text-align: center;"><?php _e('Use in the form', 'pg_ml'); ?></th>
            <th style="text-align: center;"><?php _e('Required Field', 'pg_ml'); ?></th>
          </tr>
          </thead>
          
          <tbody>
          <?php 
		  foreach($form_fields as $index => $field) {
			if(isset($field['sys_req']) && $field['sys_req']) {
				$use_td = '<span>&radic;</span><input type="hidden" name="pg_use_field[]" value="'.$index.'" />';
				$req_td = '<span>&radic;</span><input type="hidden" name="pg_field_required[]" value="'.$index.'" />';	
			}
			else {
				$use_td = '<input type="checkbox" name="pg_use_field[]" value="'.$index.'" '.pg_reg_form_check($index).' />';
				
				// pg cat - always required
				if($index == 'pg_cat') {
					$req_td = '<span>&radic;</span><input type="hidden" name="pg_field_required[]" value="'.$index.'" />';
				} else {
					$req_td = '<input type="checkbox" name="pg_field_required[]" value="'.$index.'" '.pg_reg_form_check($index, 'require').' />';	
				}
			}
			  
			echo '
			<tr>
		      <td><span class="pg_move_field"></span></td>
			  <td>
			  	'.$field['label'].'
				<input type="hidden" name="pg_field_order[]" value="'.$index.'" />
			  </td>
			  <td>'.$use_td.'</td>
			  <td>'.$req_td.'</td>
			</tr>
			';  
		  }
		  ?>
         
          </tbody>
        </table>
    </div>
    
    
    <div id="styling">
		<h3><?php _e("General settings", 'pg_ml') ?></h3>
		<table class="widefat pg_table">
          <tr>
           <td class="pg_label_td"><?php _e("Registration form layout", 'pg_ml'); ?></td>
           <td class="pg_field_td">
              <select name="pg_reg_layout" class="lcweb-chosen" data-placeholder="<?php _e('Select an option', 'pg_ml') ?> ..">
                <option value="one_col"><?php _e('Single column', 'pg_ml') ?></option>
                <option value="fluid" <?php if($fdata['pg_reg_layout'] == 'fluid') {echo 'selected="selected"';} ?>><?php _e('Fluid (multi column)', 'pg_ml') ?></option>
              </select>             
           </td>
           <td><span class="info"><?php _e('Select layout for registration and User Data add-on custom forms', 'pg_ml') ?></span></td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e("Frontend style", 'pg_ml'); ?></td>
           <td class="pg_field_td">
              <select name="pg_style" class="lcweb-chosen" data-placeholder="<?php _e('Select a style', 'pg_ml') ?> .." >
                <option value="minimal"><?php _e('Minimal', 'pg_ml') ?></option>
                <option value="light" <?php if($fdata['pg_style'] == 'light') {echo 'selected="selected"';} ?>><?php _e('Light', 'pg_ml') ?></option>
                <option value="dark" <?php if($fdata['pg_style'] == 'dark') {echo 'selected="selected"';} ?>><?php _e('Dark', 'pg_ml') ?></option>
                <option value="custom" <?php if($fdata['pg_style'] == 'custom') {echo 'selected="selected"';} ?>><?php _e('Custom', 'pg_ml') ?></option>
              </select>             
           </td>
           <td><span class="info"><?php _e('Select the style that will be used for the frontend forms and boxes', 'pg_ml') ?></span></td>
         </tr>
         <tr>
           <td class="pg_label_td"><?php _e("Disable the default frontend CSS?", 'pg_ml'); ?></td>
           <td class="pg_field_td">
           	 <?php ($fdata['pg_disable_front_css']) ? $checked= 'checked="checked"' : $checked = ''; ?>
             <input type="checkbox" name="pg_disable_front_css" value="1" <?php echo $checked; ?> class="ip_checks" />
           </td>
           <td><span class="info"><?php _e("If checked, prevent the default CSS to be used", 'pg_ml'); ?></span></td>
         </tr>
		</table>
    	
		<h3><?php _e("Elements layout", 'pg_ml') ?></h3>
		<table class="widefat pg_table">
          <tr>
            <td class="pg_label_td"><?php _e('Fields padding', 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<div class="lcwp_slider" step="1" max="15" min="0"></div>
            	<input type="text" value="<?php echo (int)$fdata['pg_field_padding']; ?>" name="pg_field_padding" class="lcwp_slider_input" />
                <span>px</span>
            </td>
            <td><span class="info"></span></td>
          </tr>
          <tr>
            <td class="pg_label_td"><?php _e('Fields border width', 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<div class="lcwp_slider" step="1" max="5" min="0"></div>
            	<input type="text" value="<?php echo (int)$fdata['pg_field_border_w']; ?>" name="pg_field_border_w" class="lcwp_slider_input" />
                <span>px</span>
            </td>
            <td><span class="info"></span></td>
          </tr>
          <tr>
            <td class="pg_label_td"><?php _e('Forms border radius', 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<div class="lcwp_slider" step="1" max="40" min="0"></div>
            	<input type="text" value="<?php echo (int)$fdata['pg_form_border_radius']; ?>" name="pg_form_border_radius" class="lcwp_slider_input" />
                <span>px</span>
            </td>
            <td><span class="info"></span></td>
          </tr>
          <tr>
            <td class="pg_label_td"><?php _e('Fields border radius', 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<div class="lcwp_slider" step="1" max="20" min="0"></div>
            	<input type="text" value="<?php echo (int)$fdata['pg_field_border_radius']; ?>" name="pg_field_border_radius" class="lcwp_slider_input" />
                <span>px</span>
            </td>
            <td><span class="info"></span></td>
          </tr>
          <tr>
            <td class="pg_label_td"><?php _e('Buttons border radius', 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<div class="lcwp_slider" step="1" max="20" min="0"></div>
            	<input type="text" value="<?php echo (int)$fdata['pg_btn_border_radius']; ?>" name="pg_btn_border_radius" class="lcwp_slider_input" />
                <span>px</span>
            </td>
            <td><span class="info"></span></td>
          </tr>
        </table>
        
        <h3><?php _e("Colors", 'pg_ml') ?></h3>
		<table class="widefat pg_table">
          <tr>
            <td class="lcwp_label_td"><?php _e("Forms background color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_forms_bg_col']; ?>;"></span>
                	<input type="text" name="pg_forms_bg_col" value="<?php echo $fdata['pg_forms_bg_col']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Forms border color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_forms_border_col']; ?>;"></span>
                	<input type="text" name="pg_forms_border_col" value="<?php echo $fdata['pg_forms_border_col']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Labels color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_label_col']; ?>;"></span>
                	<input type="text" name="pg_label_col" value="<?php echo $fdata['pg_label_col']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("reCAPTCHA icons color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <select name="pg_recaptcha_col" class="lcweb-chosen" data-placeholder="<?php _e('Select an option', 'pg_ml') ?> ..">
                  <option value="l"><?php _e('Dark', 'pg_ml') ?></option>
                  <option value="d" <?php if($fdata['pg_recaptcha_col'] == 'd') {echo 'selected="selected"';} ?>><?php _e('Light', 'pg_ml') ?></option>
                </select>  
            </td>
            <td><span class="info"></span></td>
          </tr>
          
          <?php if(defined('PCUD_URL')): ?>
          <tr>
            <td class="lcwp_label_td"><?php _e("Datepicker theme", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <select name="pg_datepicker_col" class="lcweb-chosen" data-placeholder="<?php _e('Select an option', 'pg_ml') ?> ..">
                  <option value="light"><?php _e('Light', 'pg_ml') ?></option>
                  <option value="dark" <?php if($fdata['pg_datepicker_col'] == 'dark') {echo 'selected="selected"';} ?>><?php _e('Dark', 'pg_ml') ?></option>
                </select>  
            </td>
            <td><span class="info"></span></td>
          </tr>
          <?php endif; ?>
          
          <tr><td colspan="3"></td></tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Fields background color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_fields_bg_col']; ?>;"></span>
                	<input type="text" name="pg_fields_bg_col" value="<?php echo $fdata['pg_fields_bg_col']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Fields background color - default status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Fields border color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_fields_border_col']; ?>;"></span>
                	<input type="text" name="pg_fields_border_col" value="<?php echo $fdata['pg_fields_border_col']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Fields border color - default status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Fields text color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_fields_txt_col']; ?>;"></span>
                	<input type="text" name="pg_fields_txt_col" value="<?php echo $fdata['pg_fields_txt_col']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Fields text color - default status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Fields background color - on hover", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_fields_bg_col_h']; ?>;"></span>
                	<input type="text" name="pg_fields_bg_col_h" value="<?php echo $fdata['pg_fields_bg_col_h']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Fields background color - hover status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Fields border color - on hover", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_fields_border_col_h']; ?>;"></span>
                	<input type="text" name="pg_fields_border_col_h" value="<?php echo $fdata['pg_fields_border_col_h']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Fields border color - hover status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Fields text color - on hover", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_fields_txt_col_h']; ?>;"></span>
                	<input type="text" name="pg_fields_txt_col_h" value="<?php echo $fdata['pg_fields_txt_col_h']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Fields text color - hover status', 'pg_ml') ?></span></td>
          </tr>
          <tr><td colspan="3"></td></tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Buttons background color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_btn_bg_col']; ?>;"></span>
                	<input type="text" name="pg_btn_bg_col" value="<?php echo $fdata['pg_btn_bg_col']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Buttons background color - default status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Buttons border color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_btn_border_col']; ?>;"></span>
                	<input type="text" name="pg_btn_border_col" value="<?php echo $fdata['pg_btn_border_col']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Buttons border color - default status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Buttons text color", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_btn_txt_col']; ?>;"></span>
                	<input type="text" name="pg_btn_txt_col" value="<?php echo $fdata['pg_btn_txt_col']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Buttons text color - default status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Buttons background color - on hover", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_btn_bg_col_h']; ?>;"></span>
                	<input type="text" name="pg_btn_bg_col_h" value="<?php echo $fdata['pg_btn_bg_col_h']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Buttons background color - hover status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Buttons border color - on hover", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_btn_border_col_h']; ?>;"></span>
                	<input type="text" name="pg_btn_border_col_h" value="<?php echo $fdata['pg_btn_border_col_h']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Buttons border color - hover status', 'pg_ml') ?></span></td>
          </tr>
          <tr>
            <td class="lcwp_label_td"><?php _e("Buttons text color - on hover", 'pg_ml'); ?></td>
            <td class="lcwp_field_td">
                <div class="lcwp_colpick">
                	<span class="lcwp_colblock" style="background-color: <?php echo $fdata['pg_btn_txt_col_h']; ?>;"></span>
                	<input type="text" name="pg_btn_txt_col_h" value="<?php echo $fdata['pg_btn_txt_col_h']; ?>" maxlength="7" autocomplete="off" />
                </div>
            </td>
            <td><span class="info"><?php _e('Buttons text color - hover status', 'pg_ml') ?></span></td>
          </tr>
        </table>
        
        <h3><?php _e("Custom CSS", 'pg_ml'); ?></h3>
        <table class="widefat lcwp_table">
          <tr>
            <td class="lcwp_field_td">
            	<textarea name="pg_custom_css" style="width: 100%" rows="6"><?php echo $fdata['pg_custom_css']; ?></textarea>
            </td>
          </tr>
        </table>
    </div>
    
    
    <div id="mex_opt">
    	<h3><?php _e("Restricted Content Message", 'pg_ml'); ?></h3>
        <table class="widefat pg_table">
          <tr>
            <td class="pg_label_td"><?php _e("Default message for not logged users", 'pg_ml'); ?></td>
            <td class="pg_field_td">
               <input type="text" name="pg_default_nl_mex" value="<?php echo pg_sanitize_input($fdata['pg_default_nl_mex']); ?>" maxlength="255" /> 
               <p class="info"><?php _e('By default is "You must be logged in to view this content"', 'pg_ml'); ?></p>
            </td>
         </tr>
        </table> 
        
        <h3><?php _e("Private Page Messages", 'pg_ml'); ?></h3>
        <table class="widefat pg_table">
         <tr>
            <td class="pg_label_td"><?php _e("Default message if a user not have the reserved area", 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<input type="text" name="pg_default_nhpa_mex" value="<?php echo pg_sanitize_input($fdata['pg_default_nhpa_mex']); ?>" maxlength="255" />
              	<p class="info"><?php _e('By default is "You don\'t have a reserved area"', 'pg_ml'); ?></p>
            </td>
         </tr>
        </table> 
    
		<h3><?php _e("Login Form Messages", 'pg_ml'); ?></h3>
        <table class="widefat pg_table">
         <tr>
            <td class="pg_label_td"><?php _e("Default message for successful login", 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<input type="text" name="pg_login_ok_mex" value="<?php echo pg_sanitize_input($fdata['pg_login_ok_mex']); ?>" maxlength="170" />
              	<p class="info"><?php _e('By default is "Logged succesfully, welcome!"', 'pg_ml'); ?></p>
            </td>
         </tr>
         <tr>
            <td class="pg_label_td"><?php _e("Default message for pending users", 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<input type="text" name="pg_default_pu_mex" value="<?php echo pg_sanitize_input($fdata['pg_default_pu_mex']); ?>" maxlength="170" />
              	<p class="info"><?php _e('By default is "Sorry, your account has not been activated yet"', 'pg_ml'); ?></p>
            </td>
         </tr>
         <tr>
            <td class="pg_label_td"><?php _e("Default message if a user not have the right permissions", 'pg_ml'); ?></td>
            <td class="pg_field_td">
            	<input type="text" name="pg_default_uca_mex" value="<?php echo pg_sanitize_input($fdata['pg_default_uca_mex']); ?>" maxlength="170" />
              	<p class="info"><?php _e('By default is "Sorry, you don\'t have the right permissions to view this content"', 'pg_ml'); ?></p>
            </td>
         </tr>
        </table>  
         
        <h3><?php _e("Registration Form Message" ); ?></h3>
        <table class="widefat pg_table">
          <tr>
            <td class="pg_label_td"><?php _e("Default message for succesfully registered users", 'pg_ml'); ?></td>
            <td class="pg_field_td">
               <input type="text" name="pg_default_sr_mex" value="<?php echo pg_sanitize_input($fdata['pg_default_sr_mex']); ?>" maxlength="170" /> 
               <p class="info"><?php _e('By default is "Registration was succesful. Welcome!"', 'pg_ml'); ?></p>
            </td>
         </tr>
       </table> 
        
    </div>
     
    <input type="hidden" name="pg_nonce" value="<?php echo wp_create_nonce(__FILE__) ?>" /> 
    <input type="submit" name="pg_admin_submit" value="<?php _e('Update Options', 'pg_ml') ?>" class="button-primary" />  
    
   </form>
</div>  

<?php // SCRIPTS ?>
<script src="<?php echo PG_URL; ?>/js/iphone_checkbox/iphone-style-checkboxes.js" type="text/javascript"></script>
<script src="<?php echo PG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
<script src="<?php echo PG_URL; ?>/js/colpick/js/colpick.min.js" type="text/javascript"></script>


<script type="text/javascript" charset="utf8">
jQuery(document).ready(function($) {
	var wps_is_acting = false; // WP user sync flag 
	
	// sync WP users sync
	jQuery('body').delegate('#pg_do_wp_sync', 'click', function() {
		if(!wps_is_acting && confirm("<?php _e('Mirror wordpress users will be created. Continue?', 'pg_ml') ?>")) {
			
			wps_is_acting = true;
			var $result_wrap = jQuery(this).next('span');
			$result_wrap.html('<div class="pg_loading" style="margin-bottom: -7px;"></div>');
			
			var data = {
				action: 'pg_wp_global_sync',
				pg_nonce: '<?php echo wp_create_nonce('lcwp_ajax') ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				$result_wrap.html(response);
				wps_is_acting = false;
			});
		}
	});
	
	// clean WP users sync
	jQuery('body').delegate('#pg_clean_wp_sync', 'click', function() {
		if(!wps_is_acting && confirm("<?php _e('WARNING: this will delete connected wordpress users and any related content will be lost. Continue?', 'pg_ml') ?>")) {
			
			wps_is_acting = true;
			var $result_wrap = jQuery(this).next('span');
			$result_wrap.html('<div class="pg_loading" style="margin-bottom: -7px;"></div>');
			
			var data = {
				action: 'pg_wp_global_detach',
				pg_nonce: '<?php echo wp_create_nonce('lcwp_ajax') ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				$result_wrap.html(response);
				wps_is_acting = false;
			});
		}
	});
	
	// search existing matches and sync
	jQuery('body').delegate('#pg_wps_matches_sync', 'click', function() {
		if(!wps_is_acting && confirm("<?php _e('WARNING: this will turn matched WP userse into PrivateContent mirrors. Continue?', 'pg_ml') ?>")) {
			
			wps_is_acting = true;
			var $result_wrap = jQuery(this).next('span');
			$result_wrap.html('<div class="pg_loading" style="margin-bottom: -7px;"></div>');
			
			var data = {
				action: 'pg_wps_search_and_sync_matches',
				pg_nonce: '<?php echo wp_create_nonce('lcwp_ajax') ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				$result_wrap.html(response);
				wps_is_acting = false;
			});
		}
	});
	
	//////////////////////////////////////
	
	
	//// redirects toggle
	// redirect target
	jQuery('body').delegate('#pg_redirect_page', 'change', function(){
		var red_val = jQuery(this).val();
		
		if(red_val == 'custom') {jQuery('#pg_redirect_page_cst_wrap td').fadeIn();}
		else {jQuery('#pg_redirect_page_cst_wrap td').fadeOut();}
	});
	
	// login redirect 
	jQuery('body').delegate('#pg_logged_user_redirect', 'change', function(){
		var red_val = jQuery(this).val();
		
		if(red_val == 'custom') {jQuery('#pg_logged_user_redirect_cst_wrap td').fadeIn();}
		else {jQuery('#pg_logged_user_redirect_cst_wrap td').fadeOut();}
	});
	
	// logout redirect 
	jQuery('body').delegate('#pg_logout_user_redirect', 'change', function(){
		var red_val = jQuery(this).val();
		
		if(red_val == 'custom') {jQuery('#pg_logout_user_redirect_cst_wrap td').fadeIn();}
		else {jQuery('#pg_logout_user_redirect_cst_wrap td').fadeOut();}
	});
	///////////////////////////////
	
	// sliders
	pg_slider_opt = function() {
		var a = 0; 
		$('.lcwp_slider').each(function(idx, elm) {
			var sid = 'slider'+a;
			jQuery(this).attr('id', sid);	
		
			svalue = parseInt(jQuery("#"+sid).next('input').val());
			minv = parseInt(jQuery("#"+sid).attr('min'));
			maxv = parseInt(jQuery("#"+sid).attr('max'));
			stepv = parseInt(jQuery("#"+sid).attr('step'));
			
			jQuery('#' + sid).slider({
				range: "min",
				value: svalue,
				min: minv,
				max: maxv,
				step: stepv,
				slide: function(event, ui) {
					jQuery('#' + sid).next().val(ui.value);
				}
			});
			jQuery('#'+sid).next('input').change(function() {
				var val = parseInt(jQuery(this).val());
				var minv = parseInt(jQuery("#"+sid).attr('min'));
				var maxv = parseInt(jQuery("#"+sid).attr('max'));
				
				if(val <= maxv && val >= minv) {
					jQuery('#'+sid).slider('option', 'value', val);
				}
				else {
					if(val <= maxv) {jQuery('#'+sid).next('input').val(minv);}
					else {jQuery('#'+sid).next('input').val(maxv);}
				}
			});
			
			a = a + 1;
		});
	}
	pg_slider_opt();
	
	
	// colorpicker
	pg_colpick = function () {
		jQuery('.lcwp_colpick input').each(function() {
			var curr_col = jQuery(this).val().replace('#', '');
			jQuery(this).colpick({
				layout:'rgbhex',
				submit:0,
				color: curr_col,
				onChange:function(hsb,hex,rgb, el, fromSetColor) {
					if(!fromSetColor){ 
						jQuery(el).val('#' + hex);
						jQuery(el).parents('.lcwp_colpick').find('.lcwp_colblock').css('background-color','#'+hex);
					}
				}
			}).keyup(function(){
				jQuery(this).colpickSetColor(this.value);
				jQuery(this).parents('.lcwp_colpick').find('.lcwp_colblock').css('background-color', this.value);
			});  
		});
	}
	pg_colpick();
	
	
	// iphone checks
	jQuery('.ip_checks').iphoneStyle({
	  checkedLabel: 'YES',
	  uncheckedLabel: 'NO'
	});
	
	// chosen
	jQuery('.lcweb-chosen').each(function() {
		var w = jQuery(this).css('width');
		jQuery(this).chosen({width: w}); 
	});
	jQuery(".lcweb-chosen-deselect").chosen({allow_single_deselect:true});
	
	// tabs
	jQuery("#tabs").tabs();
	
	
	/*** sort formbuilder rows ***/
	jQuery( "#pg_form_creator tbody" ).sortable({ handle: '.pg_move_field' });
	jQuery( "#pg_form_creator tbody td .pg_move_field" ).disableSelection();
	
});
</script>
