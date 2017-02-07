<?php 
////////////////////////////////////////////////////
/////////// IF EXPORTING USERS DATA ////////////////
////////////////////////////////////////////////////

// security check
if(!isset($_POST['pg_export_user_data'])) {die('<p>Nice try!</p>');}
if (!isset($_POST['pg_nonce']) || !wp_verify_nonce($_POST['pg_nonce'], 'lcwp_nonce')) {die('<p>Cheating?</p>');};

global $wpdb;
include_once(PG_DIR . '/classes/simple_form_validator.php');		
		
$validator = new simple_fv;
$indexes = array();

$indexes[] = array('index'=>'users_type', 'label'=>__( 'Users type', 'pg_ml' ), 'required'=>true);
$indexes[] = array('index'=>'export_type', 'label'=>__( 'Export type', 'pg_ml' ), 'required'=>true);
$indexes[] = array('index'=>'pg_categories', 'label'=>__( 'Categories'), 'required'=>true);


$validator->formHandle($indexes);
$error = $validator->getErrors();
$fdata = $validator->form_val;

if($error) {$error = '<div class="error"><p>'.$error.'</p></div>';}
else {
	require_once(PG_DIR . '/functions.php');
	
	// clean buffer to avoid php warnings and start again to catch data 
	ob_end_clean();
	ob_start();
	
	// status to export
	switch($fdata['users_type']) {
		case 'disabled' : $status = '2'; break;
		case 'actives'	: $status = '1'; break;	
		default 		: $status = '1,2'; break;
	}
	$human_cols = array('ID', 'Insert Date', 'Name', 'Surname', 'Username', 'E-mail', 'Telephone');
	
	//////////////////////////////////////////////////////////////
	// CUSTOM FIELDS LABELS - USER DATA ADD-ON
	$human_cols = apply_filters( 'pg_export_fields_label', $human_cols);
	//////////////////////////////////////////////////////////////
	
	
	// category filter
	if($fdata['pg_categories'][0] != 'all') {
		foreach($fdata['pg_categories'] as $u_cat) {
			$cat_filter_q[] = " categories LIKE '%\"$u_cat\"%' ";	
		}
		
		$cat_filter_q = ' AND (' . implode(' OR ',$cat_filter_q) . ')';
	}
	else {$cat_filter_q = "";}


	// CSV ////////////////////////////////
	if($fdata['export_type'] == 'csv') {
		$exp_query = $wpdb->get_results("SELECT id FROM ".PG_DB_TABLE." WHERE status IN (".$status.") ".$cat_filter_q." ORDER BY id ", ARRAY_A);
		
		// headings
		if(is_array($exp_query) && count($exp_query) > 0) {
			foreach($human_cols as $hc) {
				if($hc == 'ID') {$hc = 'User ID';}
				$sanitized_headers[] = mb_convert_encoding($hc, 'HTML-ENTITIES','utf-8');	
			}

			$data = implode(';', $sanitized_headers);  
			print "$data\n";	
		}
		
		// print the results for each user
		foreach($exp_query as $exp_data) {
			$user_data = pg_get_user_full_data($exp_data['id']);
			$sanitized_user_data = array();

			foreach($user_data as $ud) {
				if(is_array($ud)) {$ud = implode(', ', $ud);}
				$sanitized_user_data[] = mb_convert_encoding($ud,'HTML-ENTITIES','utf-8');	
			}
			
			$data = implode(';', $sanitized_user_data); 
			print "$data\n";	
		}

	
	  // catch the CSV contents
	  $contents = ob_get_contents();
	  ob_end_clean();
	 
	  header("Content-type: application/csv");
	  header("Content-Disposition: attachment; filename=pg_users_data_".date('Y_m_d').".csv");
	  header("Pragma: no-cache");
	  header("Expires: 0");

	  print html_entity_decode($contents, ENT_QUOTES, 'UTF-8');
	  die();
	}
	
	
	
	
	////////////////////////////////////////////////
	// EXCEL //////////////////////////////
	elseif($fdata['export_type'] == 'excel') {

		echo '
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head></head>
		<body>
		';

		// headings
		print '
		<table border="1" cellspacing="0" cellpadding="3">
		  <tr>
			';
			
			foreach($human_cols as $colname) {
				print '<th scope="col">'.mb_convert_encoding($colname, 'HTML-ENTITIES', 'utf-8').'</th>';	
			}
		  
		  print '</tr>';
		 
		 
		  // body
		  $exp_query = $wpdb->get_results("SELECT id FROM ".PG_DB_TABLE." WHERE status IN (".$status.") ".$cat_filter_q." ORDER BY id ", ARRAY_A);
		 
		  foreach($exp_query as $exp_data) {
			  print '<tr>';
			  
			  $user_data = pg_get_user_full_data($exp_data['id']);
			  $sanitized_user_data = array();
			  
			  foreach($user_data as $ud) {
				  if(is_array($ud)) {$ud = implode(', ', $ud);}
				  $sanitized_user_data[] = mb_convert_encoding($ud,'HTML-ENTITIES','utf-8');	
			  }


			  foreach($sanitized_user_data as  $val) {
				  print '<td>'.$val.'</td>';
			  }
			  
			  print '</tr>'; 
		 }
		  
		  
		  print '
		  </table>
		  </body>
		  </html>
		  ';
		  
		  $contents = ob_get_contents();
		  ob_end_clean();
		  
		  header ("Content-Type: application/vnd.ms-excel; charset=UTF-8");
		  header ("Content-Disposition: inline; filename=pg_users_data_".date('Y_m_d').".xls");
		  
		  print $contents;
			
		die();		
	}
	
}	

?>