<?php 
include_once(PG_DIR . '/classes/paginator.php'); 
global $wpdb;
$wp_user_sync = get_option('pg_wp_user_sync');

// minimum level to manage users
if(get_option('pg_min_role_tmu')) {$au_cap = get_option('pg_min_role_tmu');}
else {
	$au_cap = (get_option('pg_min_role')) ? get_option('pg_min_role') : 'upload_files';	
}
$cuc = current_user_can($au_cap);


// QUERY SETUP AND PAGINATOR
$p = new pg_paginator;

// USER MANAGEMENT ACTIONS (REMOVE - DISABLE - ENABLE)
if(isset($_GET['ucat_action']) && $_GET['ucat_action'] != '' && $cuc) {
	if(is_array($_GET['uca_bulk_act'])) {
		$user_involved = implode(',', $_GET['uca_bulk_act']);
	}
	else {$user_involved = $_GET['uca_bulk_act'];}
	
	if (!isset($_GET['pg_nonce']) || !wp_verify_nonce($_GET['pg_nonce'], __FILE__)) {die('<p>Cheating?</p>');};
	
	$action = $_GET['ucat_action'];
	switch($action) {
		case 'delete' : 
			$act_q = 0;
			$act_message = __('User deleted', 'pg_ml');
			
			// evehtually detach from WP users
			if($wp_user_sync) {
				global $pg_wp_users;
				foreach(explode(',', $user_involved) as $user_id) {
					$pg_wp_users->detach_wp_user($user_id, $save_in_db = false);	
				}
				$wps_q = ', wp_user_id = 0';
			}
			else {$wps_q = '';}
			
			break;
		case 'disable' : 
			$act_q = 2;
			$wps_q = '';
			$act_message = __('User disabled', 'pg_ml');
			break;
		default : 
			$act_q = 1;	
			$wps_q = '';
			$act_message = __('User enabled', 'pg_ml');
			break;
	}
	
	$user_data = $wpdb->query( 
		$wpdb->prepare( 
			"UPDATE ".PG_DB_TABLE." SET status = %d ".$wps_q." WHERE ID IN (".$user_involved.")",
			$act_q
		) 
	);
	
	// if activate pending users
	if($action == 'activate') {
		//////////////////////////////////////////////////////////////
		// E-MAIL VALIDATION - MAIL ACTIONS ADD-ON
		do_action('pcma_activ_user_notifier', $user_involved);
		//////////////////////////////////////////////////////////////	
	}
	
	//////////////////////////////////////////////////////////////
	// MAILCHIMP SYNC - MAIL ACTIONS ADD-ON
	do_action( 'pcma_mc_auto_sync');
	//////////////////////////////////////////////////////////////
}


/////////////////////////////////////////////////


// GET param 
$p->pag_param = 'pagenum';

// limit
$p->limit = 20;

// curr page
(isset($_GET['pagenum'])) ? $cur_page = $_GET['pagenum'] : $cur_page = 1;
$p->curr_pag = $cur_page;


////////////////////////////////
// if are filtering ////////////

// cat
if(!isset($_GET['cat']) || (isset($_GET['cat']) && $_GET['cat'] == '')) {$filter_cat = ''; $cat_filter_query = '';}
else {
	$filter_cat = addslashes($_GET['cat']); 
	$cat_filter_query = " AND categories LIKE '%\"$filter_cat\"%' ";
}

// username
if(!isset($_GET['username']) || isset($_GET['username']) && $_GET['username'] == '') {$filter_user = ''; $user_filter_query = '';}
else {
	$filter_user = addslashes($_GET['username']); 
	$user_filter_query = " AND (username LIKE '%$filter_user%' OR  name LIKE '%$filter_user%' OR surname LIKE '%$filter_user%' OR email LIKE '%$filter_user%')";
}

// status
if(!isset($_GET['status']) || isset($_GET['status']) && $_GET['status'] == 1) {$status = '1';}
elseif($_GET['status'] == 'disabled') {$status = '2';}
else {$status = '3';}

// sorting
$orderby = (isset($_GET['orderby']) && in_array($_GET['orderby'], array('id', 'username', 'surname', 'email', 'last_access', 'wp_user_id'))) ? $_GET['orderby'] : 'ID';
$order = (isset($_GET['order']) && in_array($_GET['order'], array('asc', 'desc'))) ? $_GET['order'] : 'asc';

//////////////////////////////////////////


// total rows for active users
$wpdb->query("SELECT ID FROM ".PG_DB_TABLE." WHERE status = 1 ".$cat_filter_query." ".$user_filter_query."");
$total_act_rows = $wpdb->num_rows;

// total rows for disabled users
$wpdb->query("SELECT ID FROM ".PG_DB_TABLE." WHERE status = 2 ".$cat_filter_query." ".$user_filter_query."");
$total_dis_rows = $wpdb->num_rows;

// total rows for pending users
$wpdb->query("SELECT ID FROM ".PG_DB_TABLE." WHERE status = 3 ".$cat_filter_query." ".$user_filter_query."");
$total_pen_rows = $wpdb->num_rows;

if ($status == 1) 		{$total_rows = $total_act_rows;}
elseif ($status == 2) 	{$total_rows = $total_dis_rows;}
else 					{$total_rows = $total_pen_rows;}
	
$p->total_rows = $total_rows;


// offset
$offset = $p->get_offset();

// users query
$user_query = $wpdb->get_results("
	SELECT * FROM ".PG_DB_TABLE." 
	WHERE status = '".$status."' ".$cat_filter_query." ".$user_filter_query." 
	ORDER BY ".$orderby." ".strtoupper($order)."
	LIMIT ".$offset.", ".$p->limit
, ARRAY_A);

///////////////////////////

// WP date/time formats
$date_format = get_option('date_format');
$time_format = get_option('time_format');


//////////////////////////////////////////////////////////////
// CUSTOM FIELDS (TH) - USER DATA ADD-ON
$pcud_cf_th = apply_filters('pcud_user_list_custom_fields_th', '');
//////////////////////////////////////////////////////////////
?>

<div class="wrap pg_form">  
	<div class="icon32" id="icon-pg_user_manage"><br></div>
    <?php echo '<h2 class="pg_page_title">' . 
	__( 'PrivateContent Users', 'pg_ml' ) . 
	' <a class="add-new-h2" href="admin.php?page=pg_add_user">'. __( 'Add New', 'pg_ml') .'</a>
	</h2>'; ?>  
	
    <?php
    if(isset($_GET['ucat_action']) && $_GET['ucat_action'] != '') { 
    	echo '<div class="updated"><p><strong>'. $act_message .'</strong></p></div>';	
	}
	?>
    
    <ul class="subsubsub">
            <li id="pg_active_users">
                <a href="admin.php?page=pg_user_manage&status=1" <?php if($status == 1) echo 'class="current"'; ?>>
					<?php _e('actives', 'pg_ml') ?> (<span><?php echo $total_act_rows; ?></span>)
                </a>
            </li> | 
            <li id="pg_disabled_users">
                <a href="admin.php?page=pg_user_manage&status=disabled" <?php if($status == 2) echo 'class="current"'; ?>>
					<?php _e('disabled', 'pg_ml') ?> (<span><?php echo $total_dis_rows; ?></span>)
                </a>
            </li> | 
            <li id="pg_pending_users">
                <a href="admin.php?page=pg_user_manage&status=pending" <?php if($status == 3) echo 'class="current"'; ?>>
					<?php _e('pending', 'pg_ml') ?> (<span><?php echo $total_pen_rows; ?></span>)
                </a>
            </li>
        </ul>
    
    
    <form method="get" id="pg_user_list_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <div class="tablenav pg_users_list_navbar">
            <?php
            echo $p->get_pagination('<div class="tablenav-pages">', '</div>');
            ?>
        
        	<input type="hidden" name="pg_nonce" value="<?php echo wp_create_nonce(__FILE__) ?>" />
        	<input type="hidden" name="page" value="pg_user_manage"  />
            <input type="hidden" name="pagenum" value="1"  />
            <input type="hidden" name="status" value="<?php 
				if($status == 1) 	{echo 1;}
				elseif($status == 2){echo 'disabled';}
				else 				{echo 'pending';}
				?>" 
            />
            
            <?php if($cuc) { ?>
            <select name="ucat_action" id="pg_ulist_action">
                    <option value=""><?php _e('Bulk Actions') ?></option>
                    
                     <?php if(isset($_GET['status']) && ($_GET['status'] == 'disabled' || $_GET['status'] == 'pending')): ?>
                        <option value="enable"><?php echo __('Enable', 'pg_ml').' '.__('Users', 'pg_ml'); ?></option>
                    <?php else : ?>
                        <option value="disable"><?php echo __('Disable', 'pg_ml').' '.__('Users', 'pg_ml'); ?></option>
                    <?php endif; ?>
                    
                    <option value="delete"><?php echo __('Delete', 'pg_ml').' '.__('Users', 'pg_ml'); ?></option>
                </select>
                <input type="button" value="<?php _e('Apply', 'pg_ml'); ?>" class="button-secondary pg_submit" name="ucat_action" style="margin-right: 15px;">
            <?php } ?>
        
        	<label for="username"><?php _e('Search', 'pg_ml') ?></label>
        	<input type="text" name="username" value="<?php echo stripslashes($filter_user); ?>" size="25" class="pg_ulist_search_field" placeholder="<?php _e('username, name, surname, e-mail', 'pg_ml') ?>" />
            
        	<select name="cat" id="pg_ulist_filter" style="margin-left: 15px;">
            	<option value=""><?php _e('All Categories', 'pg_ml') ?></option>
                <?php
                $user_categories = get_terms('pg_user_categories', 'orderby=name&hide_empty=0');
				foreach ($user_categories as $ucat) {
					
					($filter_cat == $ucat->term_id) ? $ucat_sel = 'selected="selected"' : $ucat_sel = '';
					echo '<option value="'.$ucat->term_id.'" '.$ucat_sel.'>'.$ucat->name.'</selected>';	
				}
				?>
            </select>
            
            <input type="submit" value="<?php _e('Filter', 'pg_ml'); ?>" class="button-secondary pg_submit" name="ucat_filter">
    	</div>
    
    
    	<table class="widefat pg_table pg_users_list">
        <thead>
            <tr>
              <th id="cb" class="manage-column column-cb check-column" scope="col">
                <?php if($cuc) : ?><input type="checkbox" /><?php endif; ?>
              </th>
              <th style="width: 100px;">&nbsp;</th>
              <th style="width: 45px;"><a class="pg_filter_th" rel="id">ID</a></th>
              <th><a class="pg_filter_th" rel="username"><?php _e('Username', 'pg_ml') ?></a></th>
              <th><?php _e('Name', 'pg_ml') ?></th>
              <th><a class="pg_filter_th" rel="surname"><?php _e('Surname', 'pg_ml') ?></a></th>
              <th><a class="pg_filter_th" rel="email"><?php _e('E-mail', 'pg_ml') ?></a></th>
              <th style="width: 120px;"><?php _e('Telephone', 'pg_ml') ?></th>
              <th><?php _e('Categories', 'pg_ml') ?></th>
              <th style="width: 152px;"><?php _e('Registration', 'pg_ml') ?></th>
              <th style="width: 110px;"><a class="pg_filter_th" rel="last_access"><?php _e('Last Login', 'pg_ml') ?></a></th>
              <?php echo $pcud_cf_th; ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th><a class="pg_filter_th" rel="id">ID</a></th>
              <th><a class="pg_filter_th" rel="username"><?php _e('Username', 'pg_ml') ?></a></th>
              <th><?php _e('Name', 'pg_ml') ?></th>
              <th><a class="pg_filter_th" rel="surname"><?php _e('Surname', 'pg_ml') ?></a></th>
              <th><a class="pg_filter_th" rel="email"><?php _e('E-mail', 'pg_ml') ?></a></th>
              <th><?php _e('Telephone', 'pg_ml') ?></th>
              <th><?php _e('Categories', 'pg_ml') ?></th>
              <th><?php _e('Registration', 'pg_ml') ?></th>
              <th><a class="pg_filter_th" rel="last_access"><?php _e('Last Login', 'pg_ml') ?></a></th>
              <?php echo $pcud_cf_th; ?>
            </tr>
        </tfoot>
        <tbody>
		  <?php 
		  foreach($user_query as $user) : 
		  
		  	// get category name and paginate it
		  	$user_cats = unserialize($user['categories']);
			
			$user_cat_name_arr = array();
			if(is_array($user_cats)) {
				foreach($user_cats as $u_cat) {
					$cat_obj = get_term_by('id', $u_cat, 'pg_user_categories');
					if(is_object($cat_obj)) {
						$user_cat_name_arr[] = $cat_obj->name;
					}
				}
			}
			$user_cat_string = implode(', ', $user_cat_name_arr);
		  ?>
          <tr class="content_row">
          	 <td class="uca_bulk_input_wrap">
                <input type="checkbox" name="uca_bulk_act[]" value="<?php echo $user['id'] ?>" />
             </td>
            
             <td class="pg_ulist_icons">
                <div style="width: 100px;">
				<?php if($cuc) { ?>
                	<?php // DELETE USER ?>
                    <span class="pg_trigger del_pg_user" id="dpgu_<?php echo $user['id'] ?>">
                        <img src="<?php echo PG_URL; ?>/img/delete_user.png" alt="del_user" title="<?php _e('Delete', 'pg_ml'); ?>" />
                    </span>
                    <span class="v_divider">|</span> 
                     
                    <?php // ENABLE / ACTIVATE / DISABLE USER ?>
                    <?php if(isset($_GET['status']) && $_GET['status'] == 'disabled') : // enable ?>
                        <a href="<?php echo $p->getManager('ucat_action=enable&pg_nonce='.wp_create_nonce(__FILE__).'&uca_bulk_act[]='.$user['id']) ?>">
                            <img src="<?php echo PG_URL; ?>/img/enable_user.png" alt="ena_user" title="<?php _e('Enable', 'pg_ml'); ?>" />
                        </a>
                    
                    <?php elseif(isset($_GET['status']) && $_GET['status'] == 'pending') : // activate ?>
                        <a href="<?php echo $p->getManager('ucat_action=activate&pg_nonce='.wp_create_nonce(__FILE__).'&uca_bulk_act[]='.$user['id']) ?>">
                            <img src="<?php echo PG_URL; ?>/img/enable_user.png" alt="act_user" title="<?php _e('Activate', 'pg_ml'); ?>" />
                        </a>
                        
                    <?php else: // disable ?>
                        <a href="<?php echo $p->getManager('ucat_action=disable&pg_nonce='.wp_create_nonce(__FILE__).'&uca_bulk_act[]='.$user['id']) ?>">
                            <img src="<?php echo PG_URL; ?>/img/disable_user.png" alt="dis_user" title="<?php _e('Disable', 'pg_ml'); ?>" />
                        </a>
                    <?php endif; ?>
             	<?php } // end cuc (curr user can) ?>
                
                <?php // EDIT USER PAGE ?>
             	<?php if($cuc && $user['disable_pvt_page'] == 0 && (!isset($_GET['status']) || $_GET['status'] != 'pending') ) : ?>
                <span class="v_divider">|</span>
				<a href="<?php echo get_admin_url(); ?>post.php?post=<?php echo $user['page_id'] ?>&action=edit">
					<img src="<?php echo PG_URL; ?>/img/user_page.png" alt="user_page" title="<?php _e('Edit user page', 'pg_ml'); ?>" />
                </a>
				<?php endif; ?>  
                </div>     
             </td>
             
             <td><?php echo $user['id'] ?></td>
             <td id="pguu_<?php echo $user['id'] ?>">
			 	<a href="<?php echo get_admin_url(); ?>admin.php?page=pg_add_user&user=<?php echo $user['id'] ?>" class="pg_edit_user_link" title="<?php _e('edit user', 'pg_ml') ?>">
					<strong><?php echo $user['username'] ?></strong>

                    <?php if($wp_user_sync && !empty($user['wp_user_id'])): ?>
                     <img class="pg_wps_icon" src="<?php echo PG_URL.'/img/wp_synced.png' ?>" title="<?php _e('Synced with WP user', 'pg_ml') ?> - ID <?php echo $user['wp_user_id'] ?>" />
					<?php endif; ?>
                </a>
             </td>
             <td><?php echo $user['name'] ?></td>
             <td><?php echo $user['surname'] ?></td>
             <td>
             	&nbsp;<?php echo $user['email'] ?>
                <?php
                //////////////////////////////////////////////////////////////
				// E-MAIL VALIDATION - MAIL ACTIONS ADD-ON
				do_action('pcma_user_list_flag', $user['page_id'], 'page_id');
				//////////////////////////////////////////////////////////////
				?>
             </td>
             <td>&nbsp;<?php echo $user['tel'] ?></td>
             <td><?php echo $user_cat_string ?></td>
             <td title="<?php echo  date_i18n($date_format.' - '.$time_format ,strtotime($user['insert_date'])); ?>">
			 	<?php echo date_i18n($date_format ,strtotime($user['insert_date'])); ?>
             </td>
             <td title="<?php echo (strtotime($user['last_access']) < 0) ? '' : date_i18n($date_format.' - '.$time_format ,strtotime($user['last_access'])); ?>">
				<?php echo (strtotime($user['last_access']) < 0) ? '<small>'.__('no access', 'pg_ml').'</small></em>' : pg_elapsed_time($user['last_access']).' '.__('ago', 'pg_ml'); ?>
             </td>
             
             <?php
			 //////////////////////////////////////////////////////////////
			 // CUSTOM FIELDS (DATA) - USER DATA ADD-ON
			 echo do_action('pcud_user_list_custom_fields_data', $user['id']);
			 //////////////////////////////////////////////////////////////	
			 ?>
           </tr>
          <?php endforeach; ?>
        </tbody>
        </table>
	</form>
    
    <?php
	echo $p->get_pagination('<div class="tablenav pg_users_list_navbar pg_bottom_navbar"><div class="tablenav-pages">', '</div></div>');
	?>
	
    <div id="pg_users_table"></div>    
</div>

<script type="text/javascript" >
jQuery(document).ready(function($) {
	
	/* sorting system */
	var order = '<?php echo (isset($_GET['order'])) ? $_GET['order'] : 'asc'; ?>';
	var orderby = '<?php echo (isset($_GET['orderby'])) ? $_GET['orderby'] : 'id'; ?>';
	
	jQuery('.pg_filter_th[rel='+orderby+']').addClass('active_'+order);
	
	jQuery('body').delegate('.pg_filter_th', 'click', function() {
		var new_orderby = jQuery(this).attr('rel');
		
		if(new_orderby == orderby) {
			var new_order = (order == 'asc') ? 'desc' : 'asc';	
		} else {
			var new_order = 'asc';	
		}

		var sort_url = window.location.href;
		
		if(sort_url.indexOf('orderby='+orderby) != -1) {
			sort_url = sort_url.replace('orderby='+orderby, 'orderby='+new_orderby).replace('order='+order, 'order='+new_order);
		} else {
			sort_url = sort_url + '&orderby='+ new_orderby +'&order='+ new_order;	
		}
		
		<?php if(isset($_GET['pagenum'])) : ?>
		sort_url = sort_url.replace('pagenum=<?php echo $_GET['pagenum'] ?>', 'pagenum=1'); // back to page 1
		<?php endif; ?>
		
		window.location.href = sort_url;
	});
	
	
	/********************************************/
	
	// select/deselect all
	jQuery('#cb input').click(function() {
		if(jQuery(this).is(':checked')) {
			jQuery('.uca_bulk_input_wrap input').attr('checked', 'checked');	
		}
		else {jQuery('.uca_bulk_input_wrap input').removeAttr('checked');}
	});
	
	
	// group deleting confirm
	jQuery('#pg_user_list_form .pg_submit').click(function() {
		var e = true;
		
		if( jQuery('#pg_ulist_action').val() == 'delete') {
			if(confirm("<?php _e('Do you really want to delete these users?', 'pg_ml'); ?> ")) {
				e = true;	
			}
			else {e = false;}
		}
		
		if(e == true) {jQuery('#pg_user_list_form').submit();}
	});
	
	
	// ajax delete
	<?php if($cuc) : ?>
	jQuery('body').delegate('.del_pg_user', 'click', function() {
		var user_id = jQuery(this).attr('id').substr(5);
		var user_username = jQuery.trim( jQuery('#pguu_' + user_id).text());
		
		if(confirm('<?php _e('Do you really want to delete ', 'pg_ml') ?> ' + user_username + '?')) {
			jQuery(this).parents('tr').fadeTo(200, 0.45);

			var data = {
				action: 'delete_pg_user',
				pg_user_id: user_id,
				pg_nonce: '<?php echo wp_create_nonce('lcwp_ajax') ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				if(jQuery.trim(response) != 'success'){
					alert(response);
					return false;	
				}
				
				jQuery('#pguu_' + user_id).parent().slideUp(function() {
					jQuery(this).remove();
					
					// decrease number in header
					jQuery('.subsubsub a').each(function() {
						if(jQuery(this).hasClass('current')) {
							var curr_num = jQuery(this).children('span').html();
							var new_num = parseInt(curr_num) - 1;	
							jQuery(this).children('span').html(new_num);
						}
					});
				});
			});	
		}
	});
	<?php endif; ?>
});
</script>
