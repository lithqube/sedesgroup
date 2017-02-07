<?php
// add visibility option to each menu block


// Saves new field to postmeta for navigation
add_action('wp_update_nav_menu_item', 'pg_custom_nav_update',10, 3);
function pg_custom_nav_update($menu_id, $menu_item_db_id, $args ) {
    
	if ( isset($_REQUEST['menu-item-pg-hide-'.$menu_item_db_id]) ) {
        $restr = $_REQUEST['menu-item-pg-hide-'.$menu_item_db_id];
		if(!is_array($restr)) {$restr = array();}
		
		if(in_array('all', $restr)) {$restr = array('all');} 
		if(in_array('unlogged', $restr)) {$restr= array('unlogged');} 
		
        update_post_meta( $menu_item_db_id, '_menu_item_pg_hide', $restr);
    }
	else {update_post_meta( $menu_item_db_id, '_menu_item_pg_hide', '');}
}


// Adds value of new field to $item object that will be passed to PG_Walker_Nav_Menu_Edit_Custom
add_filter( 'wp_setup_nav_menu_item','pg_custom_nav_item' );
function pg_custom_nav_item($menu_item) {
    $menu_item->pg_hide_item = get_post_meta( $menu_item->ID, '_menu_item_pg_hide', true );
    return $menu_item;
}


// initialize the custom Walker class
add_filter( 'wp_edit_nav_menu_walker', 'pg_custom_nav_edit_walker',10,2 );
function pg_custom_nav_edit_walker($walker,$menu_id) {
    return 'PG_Walker_Nav_Menu_Edit_Custom';
}



/** **************************************************************************************
 * Copied from Walker_Nav_Menu_Edit class in core
 * 
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class PG_Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {

/**
 * @see Walker_Nav_Menu::start_lvl()
 * @since 3.0.0
 *
 * @param string $output Passed by reference.
 */
function start_lvl(&$output, $depth = 0, $args = array()) {}

/**
 * @see Walker_Nav_Menu::end_lvl()
 * @since 3.0.0
 *
 * @param string $output Passed by reference.
 */
function end_lvl(&$output, $depth = 0, $args = array()) {
}

/**
 * @see Walker::start_el()
 * @since 3.0.0
 *
 * @param string $output Passed by reference. Used to append additional content.
 * @param object $item Menu item data object.
 * @param int $depth Depth of menu item. Used for padding.
 * @param object $args
 */
function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    global $_wp_nav_menu_max_depth;
    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    ob_start();
    $item_id = esc_attr( $item->ID );
    $removed_args = array(
        'action',
        'customlink-tab',
        'edit-menu-item',
        'menu-item',
        'page-tab',
        '_wpnonce',
    );

    $original_title = '';
    if ( 'taxonomy' == $item->type ) {
        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
        if ( is_wp_error( $original_title ) )
            $original_title = false;
    } elseif ( 'post_type' == $item->type ) {
        $original_object = get_post( $item->object_id );
        $original_title = $original_object->post_title;
    }

    $classes = array(
        'menu-item menu-item-depth-' . $depth,
        'menu-item-' . esc_attr( $item->object ),
        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
    );

    $title = $item->title;

    if ( ! empty( $item->_invalid ) ) {
        $classes[] = 'menu-item-invalid';
        /* translators: %s: title of menu item which is invalid */
        $title = sprintf( __( '%s (Invalid)' ), $item->title );
    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
        $classes[] = 'pending';
        /* translators: %s: title of menu item in draft status */
        $title = sprintf( __('%s (Pending)'), $item->title );
    }

    $title = empty( $item->label ) ? $title : $item->label;

    ?>
    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
        <dl class="menu-item-bar">
            <dt class="menu-item-handle">
                <span class="item-title"><?php echo esc_html( $title ); ?></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                    <span class="item-order hide-if-js">
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-up-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                        |
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-down-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                    ?>"><?php _e( 'Edit Menu Item' ); ?></a>
                </span>
            </dt>
        </dl>

        <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
            <?php if( 'custom' == $item->type ) : ?>
                <p class="field-url description description-wide">
                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                        <?php _e( 'URL' ); ?><br />
                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                    </label>
                </p>
            <?php endif; ?>
            <p class="description description-thin">
                <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                    <?php _e( 'Navigation Label' ); ?><br />
                    <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                </label>
            </p>
            <p class="description description-thin">
                <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                    <?php _e( 'Title Attribute' ); ?><br />
                    <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                </label>
            </p>
            <p class="field-link-target description">
                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                    <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                    <?php _e( 'Open link in a new window/tab' ); ?>
                </label>
            </p>
            <p class="field-css-classes description description-thin">
                <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                    <?php _e( 'CSS Classes (optional)' ); ?><br />
                    <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                </label>
            </p>
            <p class="field-xfn description description-thin">
                <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                    <?php _e( 'Link Relationship (XFN)' ); ?><br />
                    <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                </label>
            </p>
            <p class="field-description description description-wide">
                <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                    <?php _e( 'Description' ); ?><br />
                    <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                    <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
                </label>
            </p>        
            
            <?php
            /* ///////////////////////////////////////////////////////////////////////////////////////////////////////
			 ***** PRIVATECONTENT FIELD *******
			 * ///////////////////////////////////////////////////////////////////////////////////////////////////// */
            ?>   
               
            <p class="field-custom description description-wide pg_menu_restr_wrap">
                <label for="edit-menu-item-custom-<?php echo $item_id; ?>"><?php _e('Which PrivateContent user categories can see the page?', 'pg_ml') ?></label>
						
				<?php 
                #var_dump($item); // debug
                
                $menu_hide = $item->pg_hide_item;
                if(!is_array($menu_hide)) {$menu_hide = array('');}
                ?>
                
                <select name="menu-item-pg-hide-<?php echo $item_id; ?>[]" multiple="multiple" class="lcweb-chosen pg_menu_select" data-placeholder="<?php _e('Select categories', 'pg_ml') ?> ..">
                  <option value="all" class="pg_all_field" <?php if(isset($menu_hide[0]) && $menu_hide[0]=='all') echo 'selected="selected"'; ?>>
				  	<?php _e('All', 'pg_ml') ?>
                  </option>
                  <option value="unlogged" class="pg_unl_field" <?php if(isset($menu_hide[0]) && $menu_hide[0]=='unlogged') echo 'selected="selected"'; ?>>
				  	<?php _e('Unlogged Users', 'pg_ml') ?>
                  </option>
                  
                  <?php
                  $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
                  foreach ($user_categories as $ucat) {
                      (isset($menu_hide[0]) && in_array($ucat->term_id, $menu_hide)) ? $selected = 'selected="selected"' : $selected = '';
                      
                      echo '<option value="'.$ucat->term_id.'" '.$selected.'>'.$ucat->name.'</option>';  
                  }
                  ?>
                </select>   
            </p>
            
            <script src="<?php echo PG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
			<script type="text/javascript" charset="utf8">
            jQuery(document).ready(function($) {
                if(typeof(pg_menu_js_init) == 'undefined') {
					pg_menu_js_init = 1;
				
					jQuery('body').delegate('.pg_menu_select', 'change', function() {
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
				}
            });
            </script>
            
            <?php
            /* ///////////////////////////////////////////////////////////////////////////////////////////////////////
			 ***** PRIVATECONTENT FIELD END *******
			 * ///////////////////////////////////////////////////////////////////////////////////////////////////// */
            ?>
            
            
            <div class="menu-item-actions description-wide submitbox">
                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                    <p class="link-to-original">
                        <?php printf( __('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                    </p>
                <?php endif; ?>
                <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                echo wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'delete-menu-item',
                            'menu-item' => $item_id,
                        ),
                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                    ),
                    'delete-menu_item_' . $item_id
                ); ?>"><?php _e('Remove'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
            </div>

            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
        </div><!-- .menu-item-settings-->
        <ul class="menu-item-transport"></ul>
    <?php
    $output .= ob_get_clean();
    }
}

?>