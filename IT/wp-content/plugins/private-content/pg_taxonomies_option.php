<?php
include_once(PG_DIR . '/functions.php');
// add visibility option to all the public taxonomies


// add the fields to the affected taxonomies
foreach(pg_affected_tax() as $tax) {
	add_action($tax.'_add_form_fields','pg_taxonomy_pvt_content', 10, 2 );
	add_action($tax."_edit_form_fields" , "pg_taxonomy_pvt_content", 10, 2);
	add_action($tax.'_add_form_fields','pg_taxonomy_redirect', 10, 2 );
	add_action($tax."_edit_form_fields" , "pg_taxonomy_redirect", 10, 2);
}


// ALLOW CONTENT OPTION
function pg_taxonomy_pvt_content($tax_data) {
   //check for existing taxonomy meta for term ID
   if(is_object($tax_data)) {
	  $term_id = $tax_data->term_id;
	  $tax_pg_cat = get_option("taxonomy_".$term_id."_pg_cats");
	  $tax_pg_cat = explode(',', $tax_pg_cat);
	}
	else {$tax_pg_cat = array();}
	
	// creator layout
	if(!is_object($tax_data)) :
?>
		<div class="form-field pg_tax_opt">
            <label style="padding-bottom: 2px;"><strong><?php _e('PrivateContent Hide Post Contents', 'pg_ml'); ?></strong><br/>
            <?php _e('Which user categories can see post contents?', 'pg_ml'); ?></label>
            
            <select name="pg_pvt_categories[]" multiple="multiple" class="lcweb-chosen" data-placeholder="<?php _e('Select categories', 'pg_ml') ?> .." tabindex="2">
              <option value="all" class="pg_all_field"><?php _e('All', 'pg_ml') ?></option>
              <?php
              $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
              foreach ($user_categories as $ucat) {
                  echo '<option value="'.$ucat->term_id.'" '.$selected.'>'.$ucat->name.'</option>';  
              }
              ?>
            </select> 
        </div>
	
	<?php else: ?>
    
	 <tr class="form-field">
      <th scope="row" valign="top"><label><?php _e('<strong>PrivateContent Hide Post Contents', 'pg_ml'); ?></strong><br/>
	  <?php _e('Which user categories can see post contents?', 'pg_ml'); ?></label></th>
      <td class="pg_tax_opt">
    	<select name="pg_pvt_categories[]" multiple="multiple" class="lcweb-chosen" data-placeholder="<?php _e('Select categories', 'pg_ml') ?> .." tabindex="2">
          <option value="all" class="pg_all_field" <?php if(isset($tax_pg_cat[0]) && $tax_pg_cat[0]=='all') echo 'selected="selected"'; ?>><?php _e('All', 'pg_ml') ?></option>
          <?php
          $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
          foreach ($user_categories as $ucat) {
			  (is_array($tax_pg_cat) && in_array($ucat->term_id, $tax_pg_cat)) ? $selected = 'selected="selected"' : $selected = '';
              
              echo '<option value="'.$ucat->term_id.'" '.$selected.'>'.$ucat->name.'</option>';  
          }
          ?>
        </select> 
      </td>
    </tr>
<?php
	endif;
}


//////////////////////////////////////////
// REDIRECT OPTION
function pg_taxonomy_redirect($tax_data) {
   //check for existing taxonomy meta for term ID
   if(is_object($tax_data)) {
	  $term_id = $tax_data->term_id;
	  $tax_pg_red = get_option("taxonomy_".$term_id."_pg_redirect");
	  $tax_pg_red = explode(',', $tax_pg_red);
	}
	else {$tax_pg_red = array();}
	
	// creator layout
	if(!is_object($tax_data)) :
?>
		<div class="form-field pg_tax_opt">
            <label style="padding-bottom: 2px;"><strong><?php _e('PrivateContent Redirect', 'pg_ml') ?></strong><br/> 
       		<?php _e('Which user categories can see the contents?', 'pg_ml') ?></label>

            <select name="pg_red_categories[]" multiple="multiple" class="lcweb-chosen" data-placeholder="<?php _e('Select categories', 'pg_ml') ?> .." tabindex="2">
              <option value="all" class="pg_all_field"><?php _e('All', 'pg_ml') ?></option>
              <?php
              $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
              foreach ($user_categories as $ucat) {
                  echo '<option value="'.$ucat->term_id.'" '.$selected.'>'.$ucat->name.'</option>';  
              }
              ?>
            </select> 
        </div>

        <script src="<?php echo PG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">
        jQuery(document).ready(function($) {
            // all/unlogged toggles
            jQuery('body').delegate('.pg_tax_opt select', 'change', function() {
                var pg_sel = jQuery(this).val();
                if(!pg_sel) {pg_sel = [];}
                
                // if ALL is selected, discard the rest
                if(jQuery.inArray("all", pg_sel) >= 0) {
                    jQuery(this).children('option').prop('selected', false);
                    jQuery(this).children('.pg_all_field').prop('selected', true);
                    
                    jQuery(this).trigger("liszt:updated");
                }		
            });
            
            // chosen
            jQuery('.lcweb-chosen').each(function() {
				var w = jQuery(this).css('width');
				jQuery(this).chosen({width: w}); 
			});
			jQuery(".lcweb-chosen-deselect").chosen({allow_single_deselect:true});
        });
        </script>
	
	<?php else: ?>
    
	 <tr class="form-field">
      <th scope="row" valign="top">
      	<label><strong><?php _e('PrivateContent Redirect', 'pg_ml') ?></strong><br/> 
        <?php _e('Which user categories can see the contents?', 'pg_ml') ?></label>
      </th>
      <td class="pg_tax_opt">
      	<select name="pg_red_categories[]" multiple="multiple" class="lcweb-chosen" data-placeholder="<?php _e('Select categories', 'pg_ml') ?> .." tabindex="2">
          <option value="all" class="pg_all_field" <?php if(isset($tax_pg_red[0]) && $tax_pg_red[0]=='all') echo 'selected="selected"'; ?>><?php _e('All', 'pg_ml') ?></option>
          <?php
          $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
          foreach ($user_categories as $ucat) {
			  (is_array($tax_pg_red) && in_array($ucat->term_id, $tax_pg_red)) ? $selected = 'selected="selected"' : $selected = '';
              
              echo '<option value="'.$ucat->term_id.'" '.$selected.'>'.$ucat->name.'</option>';  
          }
          ?>
        </select> 

        <?php // USE CHOSEN IN TD TO AVOID ISSUES WITH SELECTED ITEMS ?>
        <script src="<?php echo PG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">
        jQuery(document).ready(function($) {
            // all/unlogged toggles
            jQuery('body').delegate('.pg_tax_opt select', 'change', function() {
                var pg_sel = jQuery(this).val();
                if(!pg_sel) {pg_sel = [];}
                
                // if ALL is selected, discard the rest
                if(jQuery.inArray("all", pg_sel) >= 0) {
                    jQuery(this).children('option').prop('selected', false);
                    jQuery(this).children('.pg_all_field').prop('selected', true);
                    
                    jQuery(this).trigger("liszt:updated");
                }		
            });
            
            // chosen
            jQuery('.lcweb-chosen').each(function() {
				var w = jQuery(this).css('width');
				jQuery(this).chosen({width: w}); 
			});
			jQuery(".lcweb-chosen-deselect").chosen({allow_single_deselect:true});
        });
        </script>
      </td>
    </tr>

<?php endif;
}



// save the fields
foreach(pg_affected_tax() as $tax) {
	add_action('created_'.$tax, 'save_pg_cat_taxonomy', 10, 2);
	add_action('edited_'.$tax, 'save_pg_cat_taxonomy', 10, 2);
	add_action('created_'.$tax, 'save_pg_red_taxonomy', 10, 2);
	add_action('edited_'.$tax, 'save_pg_red_taxonomy', 10, 2);
}


// SAVE ALLOW CONTENT OPTION
function save_pg_cat_taxonomy( $term_id ) {
	
    if ( isset($_POST['pg_pvt_categories']) ) {
		
		// check if ALL is selected
		if(in_array('all', $_POST['pg_pvt_categories'])) {
			$tax_pg_cat = 'all';	
		}
		else {
			$tax_pg_cat = implode(',', $_POST['pg_pvt_categories']);
		}
		
		//save the option array
        update_option("taxonomy_".$term_id."_pg_cats", $tax_pg_cat); 
    }
	else {delete_option("taxonomy_".$term_id."_pg_cats");}
}


// SAVE REDIRECT CONTENTS OPTION
function save_pg_red_taxonomy( $term_id ) {
	
    if ( isset($_POST['pg_red_categories']) ) {
		
		// check if ALL is selected
		if(in_array('all', $_POST['pg_red_categories'])) {
			$tax_pg_red = 'all';	
		}
		else {
			$tax_pg_red = implode(',', $_POST['pg_red_categories']);
		}
		
		//save the option array
        update_option("taxonomy_".$term_id."_pg_redirect", $tax_pg_red); 
    }
	else {delete_option("taxonomy_".$term_id."_pg_redirect");}
}




/////////////////////////////////////////////////////////////////////////


// manage category taxonomy table
foreach(pg_affected_tax() as $tax) {
	add_filter( 'manage_edit-'.$tax.'_columns', 'pg_category_column_headers', 10, 1);
	add_filter( 'manage_'.$tax.'_custom_column', 'pg_category_column_row', 10, 3);
}


// ALLOW CONTENT - add the table column
// REDIRECT CONTENTS - add the table column
function pg_category_column_headers($columns) {
    $columns_local = array();
	
    if (!isset($columns_local['pg_hide'])) { 
        $columns_local['pg_hide'] = __("PC Hide", 'pg_ml');
	}
	
    if (!isset($columns_local['pg_redirect'])) { 
        $columns_local['pg_redirect'] = __("PC Redirect", 'pg_ml');
	}

    return array_merge($columns, $columns_local);
}


// ALLOW CONTENT - fill the custom column rows
// REDIRECT CONTENTS - fill the custom column rows
function pg_category_column_row( $row_content, $column_name, $term_id){
	
	if($column_name == 'pg_hide') {
		if(get_option('taxonomy_'.$term_id.'_pg_cats')) {	
			$cat_allowed = get_option('taxonomy_'.$term_id.'_pg_cats');
			
			if($cat_allowed == 'all') {return __('All', 'pg_ml');}
			else {
				$allow_array = explode(',', $cat_allowed);
				$allow_string = '<ul style="margin: 0;">';
				
				foreach($allow_array as $allow) {
					$term_data = get_term( $allow, 'pg_user_categories'); 
					
					if(is_object($term_data)) {
						$allow_string .= '<li>'.$term_data->name.'</li>'; 	
					}
				}
				
				return $allow_string . '</ul>';
			}
		}
		
		else {return '&nbsp;';}
	}
	
	else if($column_name == 'pg_redirect') {
		if(get_option('taxonomy_'.$term_id.'_pg_redirect')) {	
			$cat_allowed = get_option('taxonomy_'.$term_id.'_pg_redirect');
			
			if($cat_allowed == 'all') {return __('All', 'pg_ml');}
			else {
				$allow_array = explode(',', $cat_allowed);
				$allow_string = '<ul style="margin: 0;">';
				
				foreach($allow_array as $allow) {
					$term_data = get_term( $allow, 'pg_user_categories'); 
					
					if(is_object($term_data)) {
						$allow_string .= '<li>'.$term_data->name.'</li>'; 	
					}
				}
				return $allow_string . '</ul>';
			}
		}
		else {return '&nbsp;';}
	}
	
	else {return '&nbsp;';}
}

