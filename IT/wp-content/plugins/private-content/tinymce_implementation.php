<?php
// implement tinymce button

add_action('init', 'pg_action_admin_init');	
function pg_action_admin_init() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	if ( get_user_option('rich_editing') == 'true') {
		add_filter( 'mce_external_plugins', 'pg_filter_mce_plugin');
		add_filter( 'mce_buttons', 'pg_filter_mce_button');
	}
}
	
function pg_filter_mce_button( $buttons ) {
	array_push( $buttons, '|', 'pg_btn' );
	return $buttons;
}

function pg_filter_mce_plugin( $plugins ) {
	if( (float)substr(get_bloginfo('version'), 0, 3) < 3.9) {
		$plugins['PrivateContent'] = PG_URL . '/js/tinymce_btn_old_wp.js';
	} else {
		$plugins['PrivateContent'] = PG_URL . '/js/tinymce_btn.js';	
	}
	return $plugins;
}




add_action('admin_footer', 'pg_editor_btn_content');
function pg_editor_btn_content() {
	global $current_screen;

	if(
		strpos($_SERVER['REQUEST_URI'], 'post.php') || 
		strpos($_SERVER['REQUEST_URI'], 'post-new.php') || 
		$current_screen->id == 'privatecontent_page_pcma_settings' ||
		$current_screen->id == 'privatecontent_page_pg_settings'
	) :
	?>
    
    <div id="privatecontent-form" style="display:none;">
    	<div id="pg_sc_tabs">
        	
			<?php if(is_plugin_active('private-content-user-data/pc_user_data.php')) : ?>
                <ul class="tabNavigation" id="pg_sc_tabs_wrap">
                    <li><a href="#pg_sc_main"><?php _e('PrivateContent', 'pg_ml') ?></a></li>
                    <li><a href="#pg_sc_ud"><?php _e('User Data add-on', 'pg_ml') ?></a></li>
                </ul> 
            <?php endif; ?>
        
            <div id="pg_sc_main" class="lcwp_form">
                <table class="form-table pg_tinymce_table">
                    <tr class="tbl_last">
                      <td style="width: 33.3%;">
                        <input type="button" id="pg-loginform-submit" class="button-primary" value="<?php _e('Insert Login Form', 'pg_ml') ?>" name="submit" />
                      </td>
                      <td style="width: 33.3%;">
                        <input type="button" id="pg-logoutbox-submit" class="button-primary" value="<?php _e('Insert Logout Box', 'pg_ml') ?>" name="submit" />
                      </td>
                      <td style="width: 33.3%;">
                        <input type="button" id="pg-regform-submit" class="button-primary" value="<?php _e('Insert Registration Form', 'pg_ml') ?>" name="submit" />
                      </td>
                    </tr>
                </table>
                
                <hr />
                
                <table id="pg_tinymce_table" class="form-table pg_tinymce_table">
                    <tr class="tbl_last">
                        <td colspan="2" style="padding-bottom: 0px; font-size: 14px;"><strong><?php _e('Private block', 'pg_ml') ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" id="pg-all-cats_wrap">
                        	<select name="pg_sc_type" id="pg_sc_type" class="lcweb-chosen" data-placeholder="<?php _e('Select an option', 'pg_ml') ?> .." tabindex="2" style="width: 508px;">
							  <option value="some"><?php _e('Content visible by one or more user categories', 'pg_ml') ?></option>
							  <option value="all"><?php _e('Content visible by all the categories', 'pg_ml') ?></option>
                              <option value="unlogged"><?php _e('Content visible by unlogged users', 'pg_ml') ?></option>
                            </select>
                        </td>
                    </tr>                
                    <tr id="pg_user_cats_row">
                        <td colspan="2" style="min-height: 100px;">
                            <label style="padding-bottom: 5px;"><?php _e('Choose the user categories allowed to view the content', 'pg_ml') ?></label><br/>
                            
                            <?php
							$user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
							if(!is_array($user_categories)) {echo '<span>'. __('No categories found', 'pg_ml') .' .. </span>';}
							?>
							
							<select name="pg_sc_cats" id="pg_sc_cats" multiple="multiple" class="lcweb-chosen" data-placeholder="<?php _e('Select categories', 'pg_ml') ?> .." tabindex="2">
							  <?php 
							  foreach ($user_categories as $ucat) {
								echo '<option value="'.$ucat->term_id.'">'.$ucat->name.'</option>';		
							  }	
							  ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="pg-hide-warning_wrap">
                            <label style="display: inline-block; width: 31%; position: relative; top: -3px;"><?php _e('Hide the warning box?', 'pg_ml') ?></label>
                            <input type="checkbox" id="pg-hide-warning" name="pg-hide-warning" value="1"  class="ip_checks"  />
                        </td>
                    </tr>
                    <tr class="tbl_last" id="pg-text_wrap">
                        <td colspan="2">
                        	<label for="pg-text"><?php _e('Custom message for not allowed users', 'pg_ml') ?></label> <br/>
                        	<textarea id="pg-text" name="pg-text" style="width: 100%; height: 28px;"></textarea>
                        </td>
                    </tr>
                    <tr class="tbl_last">
                        <td><input type="button" id="pg-pvt-content-submit" class="button-primary" value="<?php _e('Insert', 'pg_ml') ?>" name="submit" /></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            
            <?php 
			if(is_plugin_active('private-content-user-data/pc_user_data.php')) {
            	echo '<div id="pg_sc_ud" class="lcwp_form"></div>';
			}
            ?>
		</div>
    </div>    
    
    
    <?php // SCRIPTS ?>
    <script src="<?php echo PG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo PG_URL; ?>/js/iphone_checkbox/iphone-style-checkboxes.js" type="text/javascript"></script>
    
    <?php
	endif;
	return true;
}


