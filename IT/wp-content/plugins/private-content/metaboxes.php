<?php
// post and page metabox  + custom column

add_action('admin_init','pg_redirect_meta_init'); 
function pg_redirect_meta_init() {
   
    // add a meta box for affected post types
    foreach(pg_affected_pt() as $type){
        add_meta_box('pg_redirect_meta', __('PrivateContent Redirect', 'pg_ml'), 'pg_redirect_meta_setup', $type, 'side', 'default');
    }  
}

function pg_redirect_meta_setup() {
    include_once(PG_DIR . '/functions.php');
	global $post;
 	
	// check for existing values
    $pg_redirect = get_post_meta($post->ID, 'pg_redirect', true);
	if(!$pg_redirect) {$pg_redirect = array();}
   ?>
    <p><?php _e('Which user categories can see the page?', 'pg_ml') ?></p>
    
    <div id="tax_cat_list">
        <select name="pg_redirect[]" multiple="multiple" class="lcweb-chosen" data-placeholder="<?php _e('Select categories', 'pg_ml') ?> .." tabindex="2">
          <option value="all" class="pg_all_field" <?php if(isset($pg_redirect[0]) && $pg_redirect[0]=='all') echo 'selected="selected"'; ?>><?php _e('All', 'pg_ml') ?></option>
          <option value="unlogged" class="pg_unl_field" <?php if(isset($pg_redirect[0]) && $pg_redirect[0]=='unlogged') echo 'selected="selected"'; ?>><?php _e('Unlogged Users', 'pg_ml') ?></option>
          <?php
          $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
          foreach ($user_categories as $ucat) {
              (isset($pg_redirect[0]) && in_array($ucat->term_id, $pg_redirect)) ? $selected = 'selected="selected"' : $selected = '';
              
              echo '<option value="'.$ucat->term_id.'" '.$selected.'>'.$ucat->name.'</option>';  
          }
          ?>
        </select>   
    </div>    
	
    
    <?php
	//// check the parent restrictions and print a reminder
	global $current_screen;
	$restr = array(); 

	// post types
	if($current_screen->id == 'post') {

		// search in every involved taxonomy
		foreach(pg_affected_tax() as $tax) {
			$terms = wp_get_post_terms($post->ID, $tax);
			
			if(is_array($terms)) {
				foreach($terms as $term) {
					$response = pg_restrictions_helper('post', $term->term_id, $tax);
					if($response) {$restr = array_merge($restr, $response);}
				}
			}
		}	
		
		$sing_plur = (count($restr) == 1) ? __('this category', 'pg_ml') : __('these categories', 'pg_ml');
	}
	
	// page types
	else {
		$response = pg_restrictions_helper('page', $post);
		if($response) {$restr = array_merge($restr, $response);}
		
		$sing_plur = (count($restr) == 1) ? __('this parent', 'pg_ml') : __('these parents', 'pg_ml');
	}
	
	// print helper
	if(is_array($restr) && count($restr) > 0) {
		echo '<div id="pg_page_rest_helper">
			<strong>'. __('Page already restricted by', 'pg_ml') .' '.$sing_plur.':</strong>
			<dl>';
		
		foreach ($restr as $index => $rs) {
			echo '<dt>'.$index.'</dt>
				<dd><em>'. __('visible by', 'pg_ml') .' '.$rs.'</em></dd>';	
		}
		
		echo '</dl></div>';	
	}
	?>
    
    
    <?php
    // create a custom nonce for submit verification later
    echo '<input type="hidden" name="pg_redirect_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
	?>
    
	<script src="<?php echo PG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf8">
	jQuery(document).ready(function($) {
		
		// all/unlogged toggles
		jQuery('body').delegate('#tax_cat_list select', 'change', function() {
			var pg_sel = jQuery(this).val();
			if(!pg_sel) {pg_sel = [];}
			
			// if ALL is selected, discard the rest
			if(jQuery.inArray("all", pg_sel) >= 0) {
				jQuery(this).children('option').prop('selected', false);
				jQuery(this).children('.pg_all_field').prop('selected', true);
				
				jQuery(this).trigger("liszt:updated");
			}
			
			// if UNLOGGED is selected, discard the rest
			else if(jQuery.inArray("unlogged", pg_sel) >= 0) {
				jQuery(this).children('option').prop('selected', false);
				jQuery(this).children('.pg_unl_field').prop('selected', true);
				
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
    
    <?php
}
 
 
// save restrictions
function pg_redirect_meta_save($post_id) {
	if(isset($_POST['pg_redirect_noncename'])) {
		// authentication checks
		if (!wp_verify_nonce($_POST['pg_redirect_noncename'], __FILE__)) return $post_id;

		// check user permissions
		if ($_POST['post_type'] == 'page') {
			if (!current_user_can('edit_page', $post_id)) return $post_id;
		}
		else {
			if (!current_user_can('edit_post', $post_id)) return $post_id;
		}

		// take the passed data
		// sanitize - if all is selected, discard the rest
		if(!isset($_POST['pg_redirect'])) {$pg_redirect = array();}
		else {
			$pg_redirect = $_POST['pg_redirect'];
			
			if($pg_redirect[0] == 'all') {$pg_redirect = array('all');}	
			if($pg_redirect[0] == 'unlogged') {$pg_redirect = array('unlogged');}	
		}
		
		delete_post_meta($post_id, 'pg_redirect');
		add_post_meta($post_id, 'pg_redirect', $pg_redirect, true);
	}
}
add_action('save_post', 'pg_redirect_meta_save');


/////////////////////////////////////////////////////////////////////


// add column in post type table
add_action('admin_init', 'pg_custom_cols_init'); 
function pg_custom_cols_init() { 
	include_once(PG_DIR . '/functions.php');
	
	foreach(pg_affected_pt() as $type){ 
		add_filter('manage_edit-'.$type.'_columns', 'pg_redirect_table_col', 999); 
		add_action('manage_'.$type.'_posts_custom_column', 'show_pg_redirect_table_col', 10, 2);
	}
}

function pg_redirect_table_col($columns) {
    $columns['pg_redirect'] = __('PC Redirect', 'pg_ml');
    return $columns;
}

function show_pg_redirect_table_col($column, $post_id){
  if($column == 'pg_redirect') {	
	  if(get_post_meta($post_id, 'pg_redirect', true) && count(get_post_meta($post_id, 'pg_redirect', true)) > 0) {	
	  
		  $cat_allowed = get_post_meta($post_id, 'pg_redirect', true);
		  
		  if($cat_allowed[0] == 'all') { _e('All', 'pg_ml'); }
		  else if($cat_allowed[0] == 'unlogged') { _e('Unlogged', 'pg_ml'); }
		  else {
			  $allow_string = '<ul style="margin: 0;">';
			  
			  foreach($cat_allowed as $allow) {
				  $term_data = get_term( $allow, 'pg_user_categories'); 
				  
				  if(is_object($term_data)) {
					  $allow_string .= '<li>'.$term_data->name.'</li>'; 	
				  }
			  }
			  
			  echo $allow_string . '</ul>';
		  }  
	  }
	  else {echo'&nbsp;';}
  }
}

?>