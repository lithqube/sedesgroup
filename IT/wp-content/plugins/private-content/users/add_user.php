<?php 
include_once(PG_DIR . '/functions.php');
global $wpdb;
$error = false; // error to false on init
$wp_user_sync = get_option('pg_wp_user_sync');


// check if are updating
(isset($_REQUEST['user'])) ? $upd = true : $upd = false;	

// if update - get the user ID
if($upd) { $user_id = addslashes($_REQUEST['user']); }
else {
	// is adding - check minimum level	
	if(get_option('pg_min_role_tmu')) {$au_cap = get_option('pg_min_role_tmu');}
	else {
		$au_cap = (get_option('pg_min_role')) ? get_option('pg_min_role') : 'upload_files';	
	}
	
	if(!current_user_can($au_cap)) {
		die("<p>You've not the permission to manage this page</p>");	
	}
}


// SUBMIT HANDLE DATA
if(isset($_POST['pg_man_user_submit'])) { 
	if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], __FILE__)) {die('<p>Cheating?</p>');};
	
	include(PG_DIR . '/classes/simple_form_validator.php');		
	
	$form_structure = array(
		'include' => array('name', 'surname', 'username', 'tel'), 
		'require' => array('username')
	);	
	
	//////////////////////////////////////////////////////////////
	// CUSTOM ADMIN DATA VALIDATION - USER DATA ADD-ON
	$form_structure = apply_filters( 'pg_add_user_validation', $form_structure);
	//////////////////////////////////////////////////////////////

	$validator = new simple_fv;		
	$indexes = pg_validator_generator($form_structure);
	
	$indexes[] = array('index'=>'email', 'label'=>__("E-mail", 'pg_ml'), 'type'=>'email'); // use in this way to avoid mandatory behaviors
	$indexes[] = array('index'=>'psw', 'label'=> __('Password', 'pg_ml'), 'required'=>true, 'max_len'=>50);
	$indexes[] = array('index'=>'disable_pvt_page', 'label'=>__("Disable private page", 'pg_ml'));
	$indexes[] = array('index'=>'categories', 'label'=>__("Categories", 'pg_ml'), 'required'=>true, 'max_len'=>20);
	$indexes[] = array('index'=>'status', 'label'=>'status', 'type'=>'int');
	$indexes[] = array('index'=>'wp_user_id', 'label'=>'synced WP user ID', 'type'=>'int');

	$validator->formHandle($indexes);
	$fdata = $validator->form_val;
	
	// check username unicity
	$upd_q = ($upd) ? "AND ID != '".$user_id."'" : ''; // hack for update
	$wpdb->query("SELECT ID FROM ".PG_DB_TABLE." WHERE username = '".$fdata['username']."' ".$upd_q." AND status != 0");
	if($wpdb->num_rows > 0) {
		$validator->custom_error[__("Username" )] =  __("Another user already has this username", 'pg_ml');
	}
	
	if(isset($fdata['status'])) {$status = $fdata['status'];}
	$error = $validator->getErrors();
	
	//////////////////////////////////////////////////////////////
	// CHECK E-MAIL UNICITY - MAIL ACTIONS ADD-ON
	if($upd) { 
		$error = apply_filters('pcma_check_unique_mail', $error, $user_id, $fdata['email']);
	} else {
		$error = apply_filters('pcma_check_unique_mail', $error, 0, $fdata['email']);	
	}
	//////////////////////////////////////////////////////////////
	
	
	// password strength
	$error = pg_psw_strength($fdata['psw'], $error); 
	
	if($error) {echo '<div class="error"><p>'.$error.'</p></div>';}
	else {
		// clean data
		$fdata = pg_strip_opts($fdata);

		// encrypt the password
		$fdata['psw'] = base64_encode($fdata['psw']);
		
		// serialize categories
		$fdata['categories'] = serialize($fdata['categories']);
		
		// enable private page?
		($fdata['disable_pvt_page']) ? $pp_status = 1 : $pp_status = 0;
		
		// create array for the query
		$query_arr = array();
		$standard_fields = array('name', 'surname', 'username', 'psw', 'email', 'tel', 'categories');
		foreach($standard_fields as $sf) {
			if(isset($fdata[$sf])) {$query_arr[$sf] = $fdata[$sf];}
		}
		$query_arr['disable_pvt_page'] = $pp_status;

		if($upd) {
			// update WP sync and remove username and e-mail to be updated in pvtContent
			if(!empty($fdata['wp_user_id'])) {
				global $pg_wp_users;
				$pg_wp_users->sync_wp_user('//', base64_decode($fdata['psw']), '//', $fdata['name'], $fdata['surname'], $fdata['wp_user_id']);	
				
				unset($query_arr['username']);
				unset($query_arr['email']);
			}
			
			// update	
			$wpdb->update(PG_DB_TABLE, $query_arr,  array( 'id' => $user_id)); 
		}
		else {
			// create the user page
			global $current_user;
			
			$new_entry = array();
			$new_entry['post_author'] = $current_user->ID;
			$new_entry['post_content'] = get_option('pg_pvtpage_default_content');
			$new_entry['post_status'] = 'publish';
			$new_entry['post_title'] = $fdata['username'];
			$new_entry['post_type'] = 'pg_user_page';
			$pag_id = wp_insert_post( $new_entry, true );
			
			if(!$pag_id) {
				$error = __('Error during user page creation', 'pg_ml');
				echo '<div class="error"><p>'.$error.'</p></div>';	
			}
			else {
				//// add
				// if sync with WP user
				if($wp_user_sync && $fdata['email']) {
					global $pg_wp_users;
					$wp_sync = $pg_wp_users->sync_wp_user($fdata['username'], base64_decode($fdata['psw']), $fdata['email'], $fdata['name'], $fdata['surname'], 0, false);	
					
					if(is_int($wp_sync)) {
						$query_arr['wp_user_id'] = $wp_sync;	
						$fdata['wp_user_id'] = $wp_sync;
					} else {
						$pcwp_error = $wp_sync;	
					}
				}
				
				$query_arr['insert_date'] = current_time('mysql');
				$query_arr['page_id'] = $pag_id;
				$query_arr['status'] = 1;
				$wpdb->insert(PG_DB_TABLE, $query_arr);	
				
				$user_id = $wpdb->insert_id;
				$upd = true;
				$status = 1;

				//////////////////////////////////////////////////////////////
				// MAILCHIMP SYNC - MAIL ACTIONS ADD-ON
				do_action( 'pcma_mc_auto_sync');
				//////////////////////////////////////////////////////////////
			}
		}
		
		if(!$error) {
			//////////////////////////////////////////////////////////////
			// CUSTOM DATA SAVING - USER DATA ADD-ON
			do_action( 'pcud_save_custom_data', $fdata, $user_id, true);
			//////////////////////////////////////////////////////////////
			
			$pcwp_warn = (isset($pcwp_error)) ? ' <span style="font-weight: normal;">('.__('WP sync error', 'pg_ml').': '.$pcwp_error.')</span>' : '';
			echo '<div class="updated"><p><strong>'. __('User saved', 'pg_ml') .$pcwp_warn.'</strong></p></div>';	
		}
	}
}

// if updating - retrieve data
if($upd && !isset($validator)) {
	$fdata = $wpdb->get_row("SELECT * FROM ".PG_DB_TABLE." WHERE id = '".$user_id."' AND status != 0", ARRAY_A);
	if(!is_array($fdata)) {echo '<div class="error"><p>'. __('User does not exists', 'pg_ml') .'</p></div>'; exit;}
	
	$status = $fdata['status'];
}

// re-normalyze vars
if($upd && !isset($validator) || isset($validator) && !$error) {
	$fdata['psw'] = base64_decode($fdata['psw']);
	$fdata['categories'] = unserialize($fdata['categories']);
}
?>
    
    
<div class="wrap pg_form lcwp_form">  
	<div class="icon32" id="icon-pg_user_manage"><br></div>
    <?php 
	$fp_title = ($upd) ? 'PrivateContent - '. __('Edit', 'pg_ml').' '.$fdata['username'] : __('Add PrivateContent User', 'pg_ml');
	echo '<h2 class="pg_page_title">' .$fp_title. "</h2>"; 
	?>  
    <br/>
    <?php ($upd && !isset($_REQUEST['user'])) ? $endurl = '&user='.$user_id : $endurl = ''; ?>
    <form name="pg_user" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . $endurl; ?>" class="form-wrap">  
	
    <table class="widefat pg_table pg_add_user">
      <thead>
      <tr>  
        <th colspan="2" style="width: 48%;"><?php _e("User Data", 'pg_ml'); ?></th>
        <th colspan="2" style="width: 52%;">&nbsp;</th>
      </tr>  
      </thead>
      
      <tbody>
      <tr>
      	<td class="pg_label_td"><?php _e("Username", 'pg_ml'); ?> <span class="pg_req_field">*</span></td>
        <td class="pg_field_td">
        	<?php if($upd && $wp_user_sync && isset($fdata['wp_user_id']) && $fdata['wp_user_id']) :
            	echo $fdata['username'].' <small style="padding-left: 10px;">('.__('detach from WP sync to change username', 'pg_ml').')</small>
				<input type="hidden" name="username" value="'. pg_sanitize_input($fdata['username']) .'" />
				<input type="hidden" name="wp_user_id" value="'.$fdata['wp_user_id'].'" />';
           	else : ?>
            	<input type="text" name="username" value="<?php if($upd || $error) echo pg_sanitize_input($fdata['username']); ?>"  maxlength="150" autocomplete="off" />
            <?php endif; ?>
        </td>
        
        <td class="pg_label_td" style="border-left: 1px solid #DFDFDF;"><?php _e("E-mail", 'pg_ml'); ?></td>
        <td class="pg_field_td">
        	<?php if($upd && $wp_user_sync && isset($fdata['wp_user_id']) && $fdata['wp_user_id']) :
            	echo $fdata['email'].' <small style="padding-left: 10px;">('.__('detach from WP sync to change e-mail', 'pg_ml').')</small>';
				echo '<input type="hidden" name="email" value="'. pg_sanitize_input($fdata['email']) .'" />';
           	else : ?>
            	<input type="text" name="email" value="<?php if($upd || $error) echo pg_sanitize_input($fdata['email']); ?>" maxlength="255" autocomplete="off" />
            <?php endif; ?>
        </td>
      </tr>
      
      <tr>
      	<td class="pg_label_td"><?php _e("Name", 'pg_ml'); ?></td>
        <td class="pg_field_td">
        	<input type="text" name="name" value="<?php if($upd || $error) echo pg_sanitize_input($fdata['name']); ?>" maxlength="150" autocomplete="off" />
        </td>
        
        <td class="pg_label_td" style="border-left: 1px solid #DFDFDF;"><?php _e("Telephone", 'pg_ml'); ?></td>
        <td class="pg_field_td">
        	<input type="text" name="tel" value="<?php if($upd || $error) echo pg_sanitize_input($fdata['tel']); ?>" maxlength="20" autocomplete="off" />
        </td>
      </tr>
      <tr>
      	<td class="pg_label_td"><?php _e("Surname", 'pg_ml'); ?></td>
        <td class="pg_field_td">
        	<input type="text" name="surname" value="<?php if($upd || $error) echo pg_sanitize_input($fdata['surname']); ?>" maxlength="150" autocomplete="off" />
        </td>
        
        <td class="pg_label_td" style="border-left: 1px solid #DFDFDF;"><?php _e("Disable user private page", 'pg_ml'); ?></td>
        <td class="pg_field_td">
        	<input type="checkbox" name="disable_pvt_page" value="1" <?php if($upd && $fdata['disable_pvt_page'] == 1) echo 'checked="checked"' ?> class="ip_checks" />
        </td>
      </tr>
      <tr>
      	<td class="pg_label_td"><?php _e("Password", 'pg_ml'); ?> <span class="pg_req_field">*</span></td>
        <td class="pg_field_td">
        	<?php (get_option('pg_hide_psw')) ? $type = 'password' : $type = 'text'; ?>
        	<input type="<?php echo $type; ?>" name="psw" value="<?php if($upd || $error) echo pg_sanitize_input($fdata['psw']); ?>" maxlength="100" autocomplete="off" />
        </td>
        
        <td class="pg_label_td" rowspan="2" style="border-left: 1px solid #DFDFDF;"><?php _e("Categories", 'pg_ml'); ?> <span class="pg_req_field">*</span></td>
        <td class="pg_field_td" rowspan="2">
        	<?php
			$user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
			
			if(count($user_categories) == 0) {
				echo '<li><a href="edit-tags.php?taxonomy=pg_user_categories" style="color: red;">'. __('Create a user category', 'pg_ml') .'</a></li>';
			}
            else {
            	echo '
				<select name="categories[]" multiple="multiple" class="lcweb-chosen pg_menu_select" data-placeholder="'. __('Select categories', 'pg_ml').' .." tabindex="2">';

                  $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
                  foreach ($user_categories as $ucat) {
                      (isset($fdata['categories'][0]) && in_array($ucat->term_id, $fdata['categories'])) ? $selected = 'selected="selected"' : $selected = '';
                      
                      echo '<option value="'.$ucat->term_id.'" '.$selected.'>'.$ucat->name.'</option>';  
                  }

                echo '</select>';  
			}
			?>
        </td>
      </tr>
      <tr>
      	<td class="pg_label_td" style="paddin-top: 22px;">
			<?php ($upd) ? $btn_val = __('Update User', 'pg_ml') : $btn_val = __('Add User', 'pg_ml'); ?>
            <input type="submit" name="pg_man_user_submit" value="<?php echo $btn_val; ?>" class="button-primary" />  
        	
        	<?php if($upd) : ?> 
			<span class="alignright pg_eus_legend"><?php _e('status', 'pg_ml') ?></span>
			<?php endif; ?>
        </td>
        <td class="pg_field_td" style="paddin-top: 22px;">
        	<?php if($upd) : 
			switch($status) {
				case 1 : $txt = __('active', 'pg_ml'); break;
				case 2 : $txt = __('disabled', 'pg_ml'); break;
				case 3 : $txt = __('pending', 'pg_ml'); break;
				default: $txt = __('deleted', 'pg_ml'); break;	
			}
			?>
            <div class="pg_edit_user_status pg_eus_<?php echo $status; ?>"><?php echo $txt; ?></div>
            <?php endif; ?>
        </td>
      </tr>
      </tbody>  
    </table>  
    
    <?php 
	///////////////////////////////////////
	// WP USERS SYNC
	if($upd && $wp_user_sync && current_user_can(get_option('pg_min_role_tmu')) ) {
    	global $pg_wp_users;
		echo '<h3 style="border: none !important;">'. __('Wordpress user sync', 'pg_ml') .'</h3>';	
    	
        //if doesn't have mail
		if(empty($fdata['email'])) {
			echo '
			<div class="pg_warn pg_error">
				<p>'.__("User cannot be sinced, e-mail is required", 'pg_ml').'</p>
			</div>';
		}
		else {
			
			// if not synced
			if(empty($fdata['wp_user_id'])) {
				echo '
				<div class="pg_warn pg_wps_warn pg_warning">
					<p>'.__("User not synced", 'pg_ml').' - <a href="javascript:void(0)" id="pg_sync_with_wp">'.__('sync', 'pg_ml').'</a><span id="pg_wps_result" style="padding-left: 20px;"></span></p>
				</div>';
			}
			else {
				echo '
				<div class="pg_warn pg_wps_warn pg_success">
					<p><span title="WP user ID '.$fdata['wp_user_id'].'">'.__("User synced", 'pg_ml').'</span> - <a href="javascript:void(0)" id="pg_detach_from_wp">'.__('detach', 'pg_ml').'</a><span id="pg_wps_result" style="padding-left: 20px;"></span></p>
				</div>';
			}
		}
    }
    
	
	
	if($upd && $status != 3) {
		//////////////////////////////////////////////////////////////
		// E-MAIL VALIDATION - MAIL ACTIONS ADD-ON
		do_action('pcma_add_user_mail_verif', $user_id, $fdata['email']);
		//////////////////////////////////////////////////////////////
	}
	
	
    //////////////////////////////////////////////////////////////
    // CUSTOM DATA SAVING - USER DATA ADD-ON
	if(!isset($user_id) || !$upd && !$error) {$user_id = false;} 
	if(!isset($fdata) || isset($fdata) && !$error) {$fdata = false;}
    do_action( 'pcud_admin_user_fields', $user_id, $fdata);
    //////////////////////////////////////////////////////////////
    ?>
    
    <?php if($upd) : ?>
	<input type="hidden" name="status" value="<?php echo $status ?>" />  
    <?php endif; ?> 
  	<input type="hidden" name="pg_nonce" value="<?php echo wp_create_nonce(__FILE__) ?>" />  
  </form>
</div>  

<?php // SCRIPTS ?>
<script src="<?php echo PG_URL; ?>/js/iphone_checkbox/iphone-style-checkboxes.js" type="text/javascript"></script>
<script src="<?php echo PG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" >
jQuery(document).ready(function($) {
	<?php if($upd && $wp_user_sync && current_user_can(get_option('pg_min_role_tmu')) ) : ?>
	var redirect_param = <?php echo ($upd && !isset($_REQUEST['user'])) ? $user_id : ''; ?>
	
	// WP user sync
	jQuery('body').delegate('#pg_sync_with_wp', 'click', function(e) {
		e.preventDefault();
		
		if(confirm('<?php _e('A mirror wordpress user will be created. Continue?', 'pcma') ?>')) {
			jQuery('#pg_wps_result').html('<div class="pg_loading" style="margin-bottom: -7px;"></div>');
			
			var data = {
				action: 'pg_wp_sync_single_user',
				pg_user_id: <?php echo $user_id; ?>,
				pg_nonce: '<?php echo wp_create_nonce('lcwp_ajax') ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				if(jQuery.trim(response) == 'success') {
					jQuery('.pg_wps_warn').removeClass('pg_warning').addClass('pg_success');
					jQuery('.pg_wps_warn p').html("<?php _e('User synced successfully!', 'pg_ml') ?>");
					setTimeout(function() {
						window.location.href = window.location.href + redirect_param; // redirect to block username and e-mail edit
					}, 1000);
				}
				else { jQuery('#pg_wps_result').html(response); }
			});
		}	
	});
	
	// WP user detach
	jQuery('body').delegate('#pg_detach_from_wp', 'click', function(e) {
		e.preventDefault();
		
		if(confirm('<?php _e('WARNING: this will delete connected wordpres user and any related content will be lost. Continue?', 'pg_ml') ?>')) {
			jQuery('#pg_wps_result').html('<div class="pg_loading" style="margin-bottom: -7px;"></div>');
			
			var data = {
				action: 'pg_wp_detach_single_user',
				pg_user_id: <?php echo $user_id; ?>,
				pg_nonce: '<?php echo wp_create_nonce('lcwp_ajax') ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				if(jQuery.trim(response) == 'success') {
					jQuery('.pg_wps_warn').removeClass('pg_success').addClass('pg_warning');
					jQuery('.pg_wps_warn p').html("<?php _e('User detached successfully!', 'pg_ml') ?>");
					setTimeout(function() {
						window.location.href = window.location.href + redirect_param; // redirect to block username and e-mail edit
					}, 1000);
				}
				else { jQuery('#pg_wps_result').html(response); }
			});
		}	
	});
	<?php endif; ?>
	
	///////////////////////////////////////////
	
	<?php if((isset($status) && $status == '3') || (get_option('pg_min_role_tmu') && !current_user_can( get_option('pg_min_role_tmu') ))) : ?>
	// if is in pending status - disable all the fields and remove buttons
	jQuery('.pg_form').find('input, textarea, button, select').attr('disabled','disabled');
	jQuery('#pcma_mv_validate, .pg_form input[type=submit]').remove();
	<?php endif; ?>
	
	///////////////////////////
	
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
});
</script>