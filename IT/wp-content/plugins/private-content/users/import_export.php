<?php
include_once(PG_DIR . '/functions.php');	

//////////////////////////////////////// 
// IMPORT SCRIPT
if(isset($_POST['pg_import_users'])) {
	require_once(PG_DIR . '/users/import_script.php');
}

//////////////////////////////////////
// EXPORT SCRIPT
if(isset($_POST['pg_export_user_data'])) {
	require_once(PG_DIR . '/users/export_script.php');	
}
?>

<div class="wrap pg_form lcwp_form">  
	<div class="icon32" id="icon-pg_user_manage"><br></div>
    <?php echo '<h2 class="pg_page_title">' . __( 'Import & Export Users', 'pg_ml' ) . "</h2>"; ?>  
    <?php if(isset($error)) {echo $error;} ?>
    <?php if(isset($success)) {echo $success;} ?>
    
    
    <h3><?php _e('Import Users', 'pg_ml') ?></h3>
    <?php
	if(!ini_get('allow_url_fopen')) :
		echo '<div class="error"><p>' . __("Your server doesn't give the permissions to manage files. Please enable the fopen() function", 'pg_ml') .'</p></div>';
	else :
	?>
    <form method="post" class="form-wrap" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">
    	<table class="widefat pg_table" style="margin-bottom: 15px;">
          <thead>
            <tr>  
              <th colspan="3"><?php _e('Import Options', 'pg_ml') ?></th>
            </tr>  
          </thead>
          <tbody>
            <tr>
               <td class="pg_label_td"><?php _e('CSV file', 'pg_ml'); ?></td>
               <td class="pg_field_td"><input type="file" name="pg_imp_file" value="" /></td>
               <td><span class="info"><?php _e('Select a valid CSV file containing the users', 'pg_ml'); ?></span></td>
            </tr>
            <tr>
               <td class="pg_label_td"><?php _e("Fields Delimiter", 'pg_ml'); ?></td>
               <td class="pg_field_td">
                <?php (isset($fdata['pg_imp_separator']) && $fdata['pg_imp_separator']) ? $val = $fdata['pg_imp_separator'] : $val = ';'; ?>
                <input type="text" name="pg_imp_separator" value="<?php echo pg_sanitize_input($val); ?>" maxlength="1" style="text-align: center; width: 30px;" />
               </td>
               <td><span class="info"><?php _e('The fields delimiter of the CSV file (normally is ";")', 'pg_ml'); ?></span></td>
            </tr>
            <tr>
               <td class="pg_label_td"><?php _e("Enable private page?", 'pg_ml'); ?></td>
               <td class="pg_field_td">
                <?php (isset($fdata['pg_imp_pvt_page']) && $fdata['pg_imp_pvt_page']) ? $checked= 'checked="checked"' : $checked = ''; ?>
                <input type="checkbox" name="pg_imp_pvt_page" value="1" <?php echo $checked; ?> class="ip_checks" />
               </td>
               <td><span class="info"><?php _e('If checked, enable private page for imported users', 'pg_ml'); ?></span></td>
            </tr>
            <tr>
               <td class="pg_label_td"><?php _e("Default category for imported users", 'pg_ml'); ?></td>
               <td class="pg_field_td">
                  <select name="pg_imp_cat" class="lcweb-chosen" data-placeholder="<?php _e("Select a category", 'pg_ml'); ?> .." tabindex="2">
                      <?php
                      // all user categories
                      $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
                      
                      foreach ($user_categories as $ucat) {
                        (isset($fdata['pg_imp_cat']) && $ucat->term_id == $fdata['pg_imp_cat']) ? $sel = 'selected="selected"' : $sel = '';
                         echo '<option value="'.$ucat->term_id.'" '.$sel.'>'.$ucat->name.'</option>';
                      }
                      ?>
                  </select> 
               </td>
               <td><span class="info"><?php _e("Choose the category that will be assigned to imported users", 'pg_ml'); ?></span></td>
             </tr>
             <tr>
               <td class="pg_label_td"><?php _e("Ignore first row?", 'pg_ml'); ?></td>
               <td class="pg_field_td">
                <?php (isset($fdata['pg_imp_ignore_first']) && $fdata['pg_imp_ignore_first']) ? $checked= 'checked="checked"' : $checked = ''; ?>
                <input type="checkbox" name="pg_imp_ignore_first" value="1" <?php echo $checked; ?> class="ip_checks" />
               </td>
               <td><span class="info"><?php _e("If checked, ignore the first row of the CSV (normally used for headings)", 'pg_ml'); ?></span></td>
             </tr>
             <tr>
               <td class="pg_label_td"><?php _e("Abort if errors are found?", 'pg_ml'); ?></td>
               <td class="pg_field_td">
                <?php (isset($fdata['pg_imp_error_stop']) && $fdata['pg_imp_error_stop']) ? $checked= 'checked="checked"' : $checked = ''; ?>
                <input type="checkbox" name="pg_imp_error_stop" value="1" <?php echo $checked; ?> class="ip_checks" />
               </td>
               <td><span class="info"><?php _e("If checked, abort import process whether an error is found", 'pg_ml'); ?></span></td>
            </tr>
            <tr>
               <td class="pg_label_td"><?php _e("Abort if duplicated are found?", 'pg_ml'); ?></td>
               <td class="pg_field_td">
                <?php (isset($fdata['pg_imp_existing_stop']) && $fdata['pg_imp_existing_stop']) ? $checked= 'checked="checked"' : $checked = ''; ?>
                <input type="checkbox" name="pg_imp_existing_stop" value="1" <?php echo $checked; ?> class="ip_checks" />
               </td>
               <td><span class="info">
               		<?php $masm = (defined(PCMA_DIR) && get_option('pcma_mv_duplicates')) ? ' '.__('or e-mail', 'pg_ml') : ''; ?>
			   		<?php echo __('If checked, abort import process whether a duplicated username', 'pg_ml') .$masm.' '. __('is found', 'pg_ml'); ?>
               </span></td>
            </tr>
            
            <?php
			// WP user sync - if is active add option to abort in case of no sync
			if(get_option('pg_wp_user_sync')) :
			?>
			<tr>
               <td class="pg_label_td"><?php _e("Abort if wordpress sync fails?", 'pg_ml'); ?></td>
               <td class="pg_field_td">
                <?php $checked = (isset($fdata['pg_wps_error_stop']) && $fdata['pg_wps_error_stop']) ? 'checked="checked"' : ''; ?>
                <input type="checkbox" name="pg_wps_error_stop" value="1" <?php echo $checked; ?> class="ip_checks" />
               </td>
               <td><span class="info"><?php _e("If checked, abort import process whether a mirrored user already exists", 'pg_ml'); ?></span></td>
            </tr>
			<?php
			endif;

			// MAIL ACTIONS INTEGRATION - MAIL IMPORED USERS //
			if(defined(PCMA_DIR) && get_option('pcma_niu_subj')) :
			?>
			<tr>
               <td class="pg_label_td"><?php _e("E-mail imported users?", 'pg_ml'); ?></td>
               <td class="pg_field_td">
                <?php (isset($_POST['pg_mail_imported']) && $_POST['pg_mail_imported']) ? $checked= 'checked="checked"' : $checked = ''; ?>
                <input type="checkbox" name="pg_mail_imported" value="1" <?php echo $checked; ?> class="ip_checks" />
               </td>
               <td><span class="info"><?php _e("If checked, send an e-mail to imported users", 'pg_ml'); ?></span></td>
            </tr>	
			<?php
			endif;
			///////////////////////////////////////////////////
			?>
          </tbody>
        </table>
       	
        <?php
		//////////////////////////////////////////////////////////////
		// CUSTOM FIELDS IMPOR - USER DATA ADD-ON
		do_action('pcud_import_form');
		//////////////////////////////////////////////////////////////
		?>
        
        <input type="hidden" name="pg_nonce" value="<?php echo wp_create_nonce('lcwp_nonce') ?>" /> 
      	<input type="submit" name="pg_import_users" value="<?php _e('Import', 'pg_ml') ?>" class="button-primary" />  
    </form>
    <br />
    <?php endif; ?>
    
    <!-- *********************************** -->
    
    <h3><?php _e('Export Users', 'pg_ml') ?></h3>
    <form method="post" class="form-wrap" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" target="_blank">
    	<table class="widefat pg_table" style="margin-bottom: 15px;">
          <thead>
            <tr>  
              <th colspan="2"><?php _e('Choose what to export', 'pg_ml') ?></th>
            </tr>  
          </thead>
          <tbody>
          <tr>
            <td class="pg_label_td"><?php _e("Users type" ); ?></td>
            <td class="pg_field_td">
            	<select name="users_type" class="lcweb-chosen" data-placeholder="<?php _e('Select an option', 'pg_ml') ?> .." tabindex="2">
                  <option value="all"><?php _e('All', 'pg_ml') ?></option>
                  <option value="actives"><?php _e('Only actives', 'pg_ml') ?></option>
                  <option value="disabled"><?php _e('Only disabled', 'pg_ml') ?></option>
                </select>
            </td>
          </tr>
          <tr>
            <td class="pg_label_td"><?php _e("Export as", 'pg_ml') ?></td>
            <td class="pg_field_td">
            	<select name="export_type" class="lcweb-chosen" data-placeholder="<?php _e('Select an option', 'pg_ml') ?> .." tabindex="2">
                  <option value="excel"><?php _e('Excel', 'pg_ml') ?> (.xls)</option>
                  <option value="csv">CSV</option>
                </select>
            </td>
          </tr>
          <tr>
            <td class="pg_label_td"><?php _e("Categories", 'pg_ml'); ?></td>
            <td class="pg_field_td">
              <ul class="pg_checkbox_list">
                <li>
                    <input type="checkbox" name="pg_categories[]" id="pg_export_all_cat" value="all" class="ip_checks" />
                    <label style="display:inline; padding-right:30px;"><?php _e('All') ?></label>
                </li>
              
                <?php
                $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
                foreach ($user_categories as $ucat) {
                    echo '
                    <li class="pg_cat_lists">
                      <input type="checkbox" name="pg_categories[]" value="'.$ucat->term_id.'" class="ip_checks" />
                      <label style="display:inline; padding-right:30px;">'.$ucat->name.'</label> 
                    </li>
                    ';  
                }
                ?>
              </ul>
            </td>
          </tr>
          </tbody>
        </table>
      
       <input type="hidden" name="pg_nonce" value="<?php echo wp_create_nonce('lcwp_nonce') ?>" /> 
       <input type="submit" name="pg_export_user_data" value="<?php _e('Export', 'pg_ml') ?>" class="button-primary" />  
    </form>
</div>  

<?php // SCRIPTS ?>
<script src="<?php echo PG_URL; ?>/js/iphone_checkbox/iphone-style-checkboxes.js" type="text/javascript"></script>
<script src="<?php echo PG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" >
jQuery(document).ready(function($) {
	
	// select/deselect all
	jQuery('#pg_export_all_cat').iphoneStyle({
        onChange: function(elem, value) {
			if(value == true) {
				jQuery('.pg_cat_lists').slideUp();	
			}
			else {jQuery('.pg_cat_lists').slideDown();}
        }
    });
	
	
	// iphone checks
	jQuery('.ip_checks').iphoneStyle({
	  checkedLabel: 'YES',
	  uncheckedLabel: 'NO'
	});
	

	// chosen
	pg_live_chosen = function() {
		jQuery('.lcweb-chosen').each(function() {
			var w = jQuery(this).css('width');
			jQuery(this).chosen({width: w}); 
		});
		jQuery(".lcweb-chosen-deselect").chosen({allow_single_deselect:true});
	}
	pg_live_chosen();
});
</script>


