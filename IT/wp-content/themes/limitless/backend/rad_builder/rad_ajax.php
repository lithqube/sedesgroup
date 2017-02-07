<?php
/**
 * Listens for all Ajax Queries / Engines
 */


add_action('wp_ajax_nopriv_rad_query_listener', 'rad_query_listener');
add_action('wp_ajax_rad_query_listener', 'rad_query_listener');


/**
 * Query Maker Engine
 */

function rad_query_listener() {


global $post,$super_options,$helper,$ioa_meta_data;
$type = $_REQUEST["type"]; 
 

if($type=="rad-live-save") :

	if( ! isset($_POST['data']) ) return 0;
	$post_ID = $_POST['id'];
	
	$the_post = array(
	    'ID'           => $post_ID,
	      'post_content' =>  $_POST['data']
	  );

	// Update the post into the database
	 wp_update_post( $the_post );


	$ioa_options = get_post_meta($post_ID, 'ioa_options', true );
	$ioa_options['ioa_template_mode'] =  'rad-builder';
	update_post_meta( $post_ID, 'ioa_options',$ioa_options );
	 update_post_meta( $post_ID, '_style_keys',  $_POST['styles']  );
	    update_post_meta( $post_ID, 'rad_version',RAD_Version);
	 echo 1;
elseif($type=='rad-live-preview'):

global $radunits, $helper;

$widget = array();
$widget['data'] = $_POST['data'];
$widget['id'] = $_POST['id'];
$widget['type'] = $_POST['key'];
$widget['layout'] = 'full';

$widget['data']['id'] = $_POST['id'];
$widget['data']['type'] = $_POST['key'];

if(isset($widget['data']['inputs']))
	$widget['data'] = $widget['data']['inputs'];

$widget['data'] =  $helper->getAssocMap($widget['data'],'value');


$ioa_meta_data['widget'] = $widget;
$ioa_meta_data['widget_classes'] = ' w_layout_element ';
$ioa_meta_data['widget_classes'] .= ' w_full ';
$ioa_meta_data['rad_type'] = $widget['type'];

get_template_part("templates/rad/".$radunits[str_replace('-','_',$widget['type'])]->data['template']);

elseif($type=="rad-builder-data") :
global $radunits,$post,$ioa_portfolio_slug;

	$settings = array();  
	 foreach ($radunits as $key => $widget) {

	 	if( $widget->getCommonKey() !="" )
	 		$settings[$widget->getCommonKey()] = $widget->mapSettingsOverlay();	
	 	else 
	 		$settings[$key] = $widget->mapSettingsOverlay();	
	 }
	 
	array_unique($settings); 
	foreach ($settings as $key => $setting)  echo $setting;
	
elseif($type=="rad_wp_editor") :
	

	$settings =   array(
					    'wpautop' => true, // use wpautop?
					    'media_buttons' => true, // show insert/upload button(s)
					   'textarea_name' =>  'rad_wp_editor', // set the textarea name to something different, square brackets [] can be used here
					    'textarea_rows' => 15, // rows="..."
					    'textarea_columns' => 4,
					    'tinymce' => array(
					        'theme_advanced_buttons1' => 'bold,italic,underline,blockquote,|,bullist ,numlist  , link,unlink, ioabutton',
					        'theme_advanced_buttons2' => '',
					        'theme_advanced_buttons3' => '',
					        'theme_advanced_buttons4' => '',
					          'content_css' => get_stylesheet_directory_uri() . '/sprites/stylesheets/custom-editor-style.css' 
					    ),
					    'tabindex' => '',
					    'editor_class' =>" rad-editor", // add extra class(es) to the editor textarea
					    'teeny' => false, // output the minimal editor config used in Press This
					    'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
					    
					    'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
					);

	wp_editor( '','rad_wp_editor', $settings  );

	 if ( ! class_exists( '_WP_Editors' ) )
   {
     require( ABSPATH . WPINC . '/class-wp-editor.php' );
   }
    _WP_Editors::editor_js();


elseif($type=="RAD") :
	
	$data = array();

	if(isset($_POST['data']))
	$data = $_POST['data'];

	echo update_post_meta($_POST['id'],'rad_data', $data );
	

elseif($type=="RAD-Template-Export") :

	$tdata = array();
	if(isset($_POST['data']))
	$tdata = $_POST['data'];

	$title = 'Page_Template';
	if(isset($_POST['title']))
	$title = str_replace(' ', '_', $_POST['title']);
	
	echo set_transient('TEMP_RAD_TEMPLATE',$tdata,60*60);
	echo set_transient('TEMP_RAD_TEMPLATE_TITLE',$title,60*60);

elseif($type=="RAD-Template") :
	$data = array();
	if(get_option('RAD_TEMPLATES')) $data = get_option('RAD_TEMPLATES');

	$tdata = array();
	if(isset($_POST['data']))
	$tdata = $_POST['data'];
	
	$title = $_POST['title'];
	
	$id = 'RT'.uniqid();
	
	$data[$id] = array( 'post_id' => $_POST['id'] , 'data' => $tdata , 'title' => $title );

	update_option('RAD_TEMPLATES',$data);

elseif($type=="RAD-Template-Section") :
	$data = array();
	if(get_option('RAD_TEMPLATES_SECTION')) $data = get_option('RAD_TEMPLATES_SECTION');

	$tdata = array();
	if(isset($_POST['data']))
	$tdata = $_POST['data'];
	
	$title = $_POST['title'];
	
	$id = 'ST'.uniqid();
	
	$data[$id] = array( 'post_id' => $_POST['id'] , 'data' => $tdata , 'title' => $title );

	update_option('RAD_TEMPLATES_SECTION',$data);

elseif($type=='RAD-Revision-Import') :

	
$post_id = $_POST['post_id'];
$revisions = get_post_meta($post_id,'rad_revisions',true);

$revision = $revisions[$_POST['key']];

$template = $revision['data'];

foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = radAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];

		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}
	

elseif($type=="RAD-Revision") :
	
	$tdata = $_POST['data'];
	
	$title = $_POST['title'];
	$rev_id = 'RT'.uniqid();
	$post_id = $_POST['id'];
	
	$length = 5;

	$revisions =  get_post_meta($post_id,'rad_revisions',true);


	if($revisions == "") $revisions = array();


	$revisions[$rev_id] = array( 'title' => $title , 'post_id' => $post_id  , 'data' =>  json_decode(stripslashes($tdata),true)  );

	if(count($revisions) > $length ) array_shift($revisions);

	echo update_post_meta($post_id,'rad_revisions',$revisions);


elseif($type=="RAD-Template-Delete") :
	

	$data = array();
	if(get_option('RAD_TEMPLATES')) $data = get_option('RAD_TEMPLATES');

	$id = $_POST['key'];
	unset($data[$id] );

	update_option('RAD_TEMPLATES',$data);
	
elseif($type=="RAD-Section-Delete") :
	

	$data = array();
	if(get_option('RAD_TEMPLATES_SECTION')) $data = get_option('RAD_TEMPLATES_SECTION');

	$id = $_POST['key'];
	unset($data[$id] );

	update_option('RAD_TEMPLATES_SECTION',$data);

elseif($type=="RAD-Page-Import") :
	
	$data = array();

	$data = base64_decode($_POST['data']);	
	$template = json_decode(stripslashes($data),true);

	
	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = radAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];



		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}
elseif($type == 'RAD-OldBackup') :

	$data = array();
	$pid = $_POST['pid'];

	$old_backup = get_post_meta($pid,'rad_data',true);

	if(!is_array($old_backup))
	$old_backup = json_decode(stripslashes(base64_decode($old_backup)),true);


	foreach ($old_backup as $key => $section) {
					$d = array();

					if(isset($section['data']))	
						$d = $section['data'];

					$containers = array();

					if(isset($section['containers']))
					$containers = $section['containers'];

					foreach ($containers as  $container) {

						$data = array();

						if( gettype($container['data']) == "string") $container['data'] = json_decode($container['data'],true);

							foreach ($container['data'] as $key => $value) {
							 	if($key!='id' && $key!='layout' && $key!='first' && $key!='top' && $key!='last')
							 	$data[] = array("name" => $key,"value" => $value ); 
							 }

						 if(  isset($data[0]['value']) &&  is_array( $data[0]['value'] )  )
							 {
							 	$data = $container['data'];
							 	$data[] =  array("name" => 'id',"value" => $container['id'] ); 
							 }

						if(isset($container['id']))
					     		$container['data']['id'] = $container['id'];		 

					     

						 $widgets = array();
						 if(isset($container['widgets'])) $widgets = $container['widgets'];
						 foreach ($widgets as $key => $w) {
						 	$data = array();



							foreach ($w as $key => $value) {
							 	if($key!='id' && $key!='layout' && $key!='first' && $key!='top' && $key!='last')
							 	{
							 		$v = $value;
							 		if($key=='text_data')
							 		{
							 			$v = str_replace('\\','',$v); // remove unecessary text data slashes
							 		}
							 		$v = str_replace(array( '&amp;squot;','&amp;quot;','&amp;sqstart;','&amp;sqend;','&lt;' ), array('\'','"','[',']','<'), $v);
							 		$data[] = array("name" => $key,"value" => $v ); 
							 	}

							 

							 }

							 if(isset($w['data']))
							 {
							 	if( gettype($w['data']) == "string") $data = json_decode($w['data'],true);

							 }

							 if(isset($w['type']))
							 	$data[] = array( "name" => "type" ,  "value" => str_replace('-','_',$w['type']) );

							  if(isset($w['id']))
							 	$data[] = array( "name" => "id" ,  "value" => str_replace('-','_',$w['id']) );


							 if(  isset($data[0]['value']) && is_array( $data[0]['value'] )  )
							 {

							 	$type =   $data[1];
							 	$data = $data[0]['value'];
							 	$data[]  =  $type;
							 	$new_data = array();	
							 	foreach ($data as $key => $r) {
							 		$new_data[] = array( "name" => $r['name'] , "value" => stripslashes($r['value'])  );
							 	}
							 	$data = $new_data;

							 }

							

						 	
						 }
					}

					$id = 'rps'.uniqid();
					if(isset($d['id'])) $id = $d['id'];
					

					
					 $data = array();

					 
					if( gettype($section['data']) == "string") $section['data'] = json_decode($section['data'],true);


					 foreach ($section['data'] as $key => $value) {
					 	if($key!='id' && $key!='first' && $key!='top' && $key!='last')
					 	$data[] = array("name" => $key,"value" => $value ); 

					 	if(isset($section['id']))
					     		$section['data']['id'] = $section['id']; 
					     
					 }


					  if(  isset($section['data'][0]['name']) )
					 {
					 	$data = array();
						 foreach ($section['data'] as $key => $value) {
						 	if($key!="id")
					 		$data[] = array("name" => $value['name'],"value" => $value['value'] ); 
						 }
						 if(isset($section['id']))
					     		$data[] =  array("name" => "id","value" => $section['id'] ); 
					     	$id =  $section['id'];
					 }
					 RADMarkup::generateRADSection($data,$id,$containers,false,$data);
					

				}

elseif($type=="RAD-Live-Page-Import") :
	global $ioa_meta_data;
	$data = array();

	$data = base64_decode($_POST['data']);	
	$template = json_decode(stripslashes($data),true);

	$ioa_meta_data['rad_data'] = $template;
	get_template_part('templates/rad/construct');


elseif($type=="RAD-Import") :
	
	$data = array();
	if(get_option('RAD_TEMPLATES')) $data = get_option('RAD_TEMPLATES');

	$tkey = $_POST['key'];
	$template = json_decode(stripslashes($data[$tkey]['data']),true);
	
	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = radAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];



		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}

elseif($type=="RAD-Import-Section") :
	
	$data = array();
	if(get_option('RAD_TEMPLATES_SECTION')) $data = get_option('RAD_TEMPLATES_SECTION');

	$tkey = $_POST['key'];
	$template = json_decode(stripslashes($data[$tkey]['data']),true);
	
	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = radAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];



		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}

elseif($type=='RAD-Sidebar') :

global $radunits;
?>
 <div class="settings-bar">
	<div class="top-bar clearfix">
		<a href="" class="save-settings"><?php _e('Save','ioa') ?></a>
		<a href="" class="preview-trigger"><?php _e('Preview','ioa') ?><span></span></a>
		<a href="" class="cancel-settings"><i class="ioa-front-icon cancel-2icon-"></i></a>
	</div>
	<div class="settings-body">
		<div class="inner-settings-body clearfix">
		<?php
		$settings = array();  
		 foreach ($radunits as $key => $widget) {

		 	

		 	if( $widget->getCommonKey() !="" )
		 		$settings[$widget->getCommonKey()] = $widget->mapSettingsOverlay(array('noeditor' => false , 'switcher' => true ));	
		 	else 
		 		$settings[$key] = $widget->mapSettingsOverlay(array('noeditor' => false , 'switcher' => true ));	
		 }
		 
		array_unique($settings); 
		foreach ($settings as $key => $setting)  
		{
			echo $setting;
		}	
		?>

	</div>
	</div>
	
</div>	
<?php

elseif($type=="RAD-InstaImport") :
	
	

	$ins_path =   get_template_directory()."/sprites/templates/".$_POST['key'];
	$fh = fopen($ins_path, 'r');
	$super_query = fread($fh, filesize($ins_path));

	$data = base64_decode($super_query);	
	$template = json_decode(stripslashes($data),true);


	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = radAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];



		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}

elseif($type=="RAD-InstaImport-Section") :
	
	

	$ins_path =   get_template_directory()."/sprites/rad_sections/".$_POST['key'];
	$fh = fopen($ins_path, 'r');
	$super_query = fread($fh, filesize($ins_path));

	$data = base64_decode($super_query);	
	$template = json_decode(stripslashes($data),true);


	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = radAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];

		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}
endif;	

die();
}	