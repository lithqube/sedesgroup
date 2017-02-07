<?php

// add the order field
add_action('pg_user_categories_add_form_fields','pg_ucat_fields', 10, 2 );
add_action('pg_user_categories_edit_form_fields' , "pg_ucat_fields", 10, 2);

function pg_ucat_fields($tax_data) {
   //check for existing taxonomy meta for term ID
   if(is_object($tax_data)) {
	  $term_id = $tax_data->term_id;
	  $redirect = (string)get_option("pg_ucat_".$term_id."_login_redirect");
	  $no_registration = get_option("pg_ucat_".$term_id."_no_registration");
	}
	else {
		$redirect = '';
		$no_registration = 0;
	}
	
	// creator layout
	if(!is_object($tax_data)) :
?>
		<div class="form-field">
            <label><?php _e('Custom redirect after login', 'pg_ml') ?></label>
           	<input type="text" name="pg_ucat_login_redirect" value="<?php echo trim($redirect) ?>" /> 
            <p><?php _e('Set a custom login redirect for users belonging to this category', 'pg_ml') ?></p>
        </div>
        <div class="form-field">
            <label><?php _e('Prevent this category to be used in registration form?', 'pg_ml') ?></label>
           	<input type="checkbox" name="pg_ucat_no_registration" value="1" <?php if($no_registration) echo 'checked="checked"' ?> /> 
            <p style="display: inline-block; padding-left: 5px;"><?php _e('If checked, hide the category from the registration form auto-selection dropdown', 'pg_ml') ?></p>
        </div>
	<?php
	else:
	?>
	 <tr class="form-field">
      <th scope="row" valign="top"><label><?php _e('Custom redirect after login', 'pg_ml') ?></label></th>
      <td>
        <input type="text" name="pg_ucat_login_redirect" value="<?php echo trim($redirect) ?>" /> 
        <p class="description"><?php _e('Set a custom login redirect for users belonging to this category', 'pg_ml') ?></p>
      </td>
    </tr>
    <tr class="form-field">
      <th scope="row" valign="top"><label><?php _e('Prevent this category to be used in registration form?', 'pg_ml') ?></label></th>
      <td>
        <input type="checkbox" name="pg_ucat_no_registration" value="1" <?php if($no_registration) echo 'checked="checked"' ?> /> 
        <p class="description" style="display: inline-block; padding-left: 5px;"><?php _e('If checked, hide the category from the registration form auto-selection dropdown', 'pg_ml') ?></p>
      </td>
    </tr>
<?php
	endif;
}


// save the fields
add_action('created_pg_user_categories', 'save_pg_ucat_fields', 10, 2);
add_action('edited_pg_user_categories', 'save_pg_ucat_fields', 10, 2);

function save_pg_ucat_fields( $term_id ) {
    if (isset($_POST['pg_ucat_login_redirect']) ) {
        update_option("pg_ucat_".$term_id."_login_redirect", $_POST['pg_ucat_login_redirect']); 
    }
	else {delete_option("pg_ucat_".$term_id."_login_redirect");}
	
	
	if (isset($_POST['pg_ucat_no_registration']) ) {
        update_option("pg_ucat_".$term_id."_no_registration", 1); 
    }
	else {delete_option("pg_ucat_".$term_id."_no_registration");}
}



/////////////////////////////
// manage taxonomy table
add_filter( 'manage_edit-pg_user_categories_columns', 'pg_cat_order_column_headers', 10, 1);
add_filter( 'manage_pg_user_categories_custom_column', 'pg_cat_order_column_row', 10, 3);


// add the table column
function pg_cat_order_column_headers($columns) {
	if(isset($columns['slug'])) {unset($columns['slug']);}
	
	$columns_local = array();
    $columns_local['login_redirect'] = __("Login Redirect", 'pg_ml');
	$columns_local['no_registration'] = __("No Registration", 'pg_ml');
	
    return array_merge($columns, $columns_local);
}


// fill the custom column row
function pg_cat_order_column_row( $row_content, $column_name, $term_id){
	
	if($column_name == 'login_redirect') {
		return get_option("pg_ucat_".$term_id."_login_redirect");
	}
	else if($column_name == 'no_registration') {
		return (get_option("pg_ucat_".$term_id."_no_registration")) ? '&radic;' : '';
	}
	else {return '&nbsp;';}
}