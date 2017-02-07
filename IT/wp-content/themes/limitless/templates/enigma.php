<?php
/**
 * This template intializes Enigma Frontend Engine.
 * @since IOA Framework V1
 * @version Enigma V2
 */


/**
 * Importing Required Files
 */
require_once(HPATH.'/classes/ui.php');
require_once(HPATH.'/rad_builder/class_radstyler.php');
require_once(HPATH.'/deprecated/class_enigma.php');
require_once(HPATH.'/deprecated/visual_settings.php');

/**
 * Initiating Objects
 */
$styler = new Enigma();


if( isset($_SESSION['rad_mode']) )
unset($_SESSION['rad_mode']);

/**
 * Exporting Alogrithm for Styles
 */

if(isset($_GET['export_en']))
{
	$id = $_GET['id'];
	
	$output = '';
	

	if($id=='default')
	{
		$table = get_option(SN.'_enigma_data');
		$name = 'default';

		header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename($name.'.txt'));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	   
	    $output = json_encode( array($name , $table ) );
		$output = base64_encode($output);

	}
	else
	{
		$table = get_option(SN.'enigma_hash');
		$name = str_replace(' ',"_",strtolower($table[$id]));

		header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename($name.'.txt'));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	   
	    $output = json_encode( array($name , get_option($id) ) );
		$output = base64_encode($output);
	}	

	
	echo $output;
    exit;
}

/**
 * Adding scripts
 */
 function addEnigmaScripts() {
	  
	
	wp_enqueue_script('jquery');
	wp_print_scripts('jquery-ui-tabs');
	wp_print_scripts('jquery-ui-draggable');
	wp_enqueue_script('jquery-minicolorpicker',HURL.'/js/jquery.minicolors.js');
	wp_enqueue_script('jquery-ext',HURL.'/js/ext.js');
	wp_enqueue_media();
}
	
	wp_dequeue_style('base');
	wp_dequeue_style('layout');	 
	wp_dequeue_style('widgets');	
	wp_dequeue_style('style');

	wp_dequeue_style('custom-font-0');
	wp_dequeue_style('custom-font-1');
	wp_dequeue_style('custom-font-2');

	add_action('enigma_head','addEnigmaScripts');

 	

?>

<!-- IFRAME for the Page -->


<!DOCTYPE html>

<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->

<html <?php language_attributes(); ?>>

<head> <!-- Start of head  -->

	<meta charset="utf-8">
    

	<title><?php _e('Styler MODE: ','ioa') ?></title>
	
    <link rel='tag' id='listener_link' href='<?php echo  admin_url( 'admin-ajax.php' ); ?>' />
    <link rel='tag' id='backend_link' href='<?php echo HURL; ?>' />

    <link rel="stylesheet" href="<?php echo URL."/sprites/stylesheets/enigma.css"; ?>">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700' rel='stylesheet' type='text/css'>

    <?php do_action('enigma_head'); ?>
    
    <script>
    	var ioa_listener_url = "<?php echo  admin_url( 'admin-ajax.php' ); ?>";
    	var enigma_source = "<?php echo home_url('/'); ?>";
    	
    </script>
  	
  	<script src="<?php echo HURL.'/js/global.js'; ?>"></script>    
  	<script src="<?php echo HURL.'/js/intro.min.js'; ?>"></script>    
  	<script src="<?php echo URL."/sprites/js/enigma-lib/codemirror-compressed.js"; ?>"></script> 
  	<script src="<?php echo URL."/sprites/js/enigma.js"; ?>"></script> 
	
</head> <!-- End of Head -->

 
<body> <!-- Start of body  -->
<?php 

?>
<span class="save-loader"></span>



<div id="enigma_sidebar" class="clearfix" >
	<div class="help-menu">
		<a href="">?</a>
		<ul class="menu">
			<span class="tip"></span>
			<li><a href="http://support.artillegence.com/enigma-v2-documentation/" id="ioa-intro-trigger">Quick Tour</a></li>
			<li><a href="https://vimeo.com/73585615">Video</a></li>
			<li><a href="http://support.artillegence.com/enigma-v2-documentation/">Documentation</a></li>
		</ul>
	</div>

	<a href="" class="toggle-sidebar" data-step='4' data-intro='You can hide or show sidebar by clicking on this button.' data-position='right'></a>
	<div class="en_gloss"></div> 
	<div class="inner_enigma_sidebar clearfix" >
		
		<a class="refresh-enigma-frame icon icon-repeat" href=""></a>
		
		<div id="parent_enigma_tab">
		
	
			<div id="enigma_visual_mode">

				<div class="edit-page-panel clearfix">
							
							<img src='<?php echo URL.'/sprites/i/enigma_sprites/logo.png'; ?>' alt='logo' id="logo" />

							<div class="clearfix edit-page-button-wrap">
								<a href="" class="enigma-styles-menu" data-step='7' data-intro='To  Create , Load and Import/Export styles, Click on this menu a panel will open with all the options.' data-position='right'><?php _e('Styles','ioa') ?>
								
								<p class="tipper">
									<span class="tip"></span>
									<span class="inf"><?php _e('Open Styles Panel','ioa') ?></span>
								</p>
								</a>	
								<a href="" class="fonts-enigma-styler" data-step='8' data-intro='To Use Google Fonts or Fontface or Font deck click on this menu. You can add more font support to the theme from here.' data-position='right'><?php _e('Fonts','ioa') ?>
								<p class="tipper">
									<span class="tip"></span>
									<span class="inf"><?php echo _e('Add or Remove Fonts','ioa') ?></span>
								</p>
								</a>
								<a href="" class="reset-enigma-styler" data-step='9' data-intro='This will reset current style' data-position='right'><?php _e('Reset','ioa') ?>
								<p class="tipper">
									<span class="tip"></span>
									<span class="inf"><?php echo _e('Reset Current Style','ioa') ?></span>
								</p>
								</a>
								<a href="<?php echo admin_url(); ?>" class="close-enigma-styler"><?php _e('Close','ioa') ?></a>	
							</div>

							<div class="clearfix edit-page-button-wrap edit-last-menu">
								<a href="" class="refresh-icon-cl"><img src='<?php echo URL.'/sprites/i/enigma_sprites/refresh-icon.png'; ?>' alt='doc-icon'/>
								<p class="tipper">
									<span class="tip"></span>
									<span class="inf"><?php _e('Refresh Page on Right','ioa') ?></span>
								</p>
								</a>
							</div>

				</div>
				<div class="enigma-comps-wrap" data-step='1' data-intro='This is the Main Panel for Styling Site.' data-position='right'>
				
				

				<div class="style-select-area">
						
						<a href='' class='manage-enigma'><?php _e('Import/Export Styles','ioa') ?></a> 

						<div class="add-new-template clearfix">
							<label for=""><?php _e('Create a New Style','ioa') ?></label>
							<input type="text" class='new-enigma-template' placeholder='Enter Style Name' />
							 <a href='' class='new-enigma-container'><?php _e('Create','ioa') ?></a>
						</div>	

						<div class="container_layout_selector clearfix">
								<?php 
							$templates = array("default" => "Default");
							$table = get_option(SN.'enigma_hash');
							
							if($table && is_array($table) )
							$templates = array_merge($templates,$table);
							
							$default = get_option(SN.'_active_etemplate');
							if(!$default) $default = 'default';
							echo getIOAInput(array( 
									"label" => "Select Style" , 
									"name" => "enigma_container_layout",
									"length" => "small" , 
									"default" => $default , 
									"type" => "select",
									"description" => "" ,
									"options" => $templates,
									"value" => "",
									"after_input"   => ""
							) );
							 ?>
							 <a href='' class='load-enigma-container'><?php _e('Load','ioa') ?></a>
							 <a href='' class='delete-enigma-container'><?php _e('Delete','ioa') ?></a>
						</div>	
							 
				

				</div>

				<div class="sub-panel clearfix">
					<a href="" class="style-save-button" data-step='5' data-intro='To Save Changes of your current work, click on this button.' data-position='right'><?php _e('Save Styles','ioa') ?></a>
					<a href="" class="concave-editor-init clearfix" data-step='6' data-intro='To add custom css code click on this button, an editor will open. You can add code there.' data-position='right'> <img src='<?php echo URL.'/sprites/i/enigma_sprites/editor-icon.png'; ?>' alt='doc-icon'/>CSS Editor</a>
				</div>

			
				
				<div class="dominant-color clearfix" data-step='3' data-intro='To set a common color for color areas quickly, set color here. Click apply and hit Save Styles Button.' data-position='right'>
					<?php 
					    $link = appendableLink(home_url('/')); 
						$frontpage_id = get_option('page_on_front');
						if(get_option(SN.'_global_color')) $dominant_color = get_option(SN.'_global_color');

						echo getIOAInput(array( 
							"label" => __("Global Color",'ioa') , 
							"name" => "gcolor-field" , 
							"default" => "$dominant_color" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'small',
							"value" => "$dominant_color" ,
							"after_input" => "<a href='{$link}enigma=styler&amp;pid={$frontpage_id}' class='gcolor'>Apply</a>"
							));
					 ?>
				</div>

				<!--
				<div class="res-panel clearfix">
					<?php 
						echo getIOAInput(array( 
									"label" => __("Style For",'ioa') , 
									"name" => "res_selector",
									"length" => "small" , 
									"default" => '' , 
									"type" => "select",
									"description" => "" ,
									"options" => array( "Screen View","Tablet Landscape","Small Tablets","Mobile Landscape","Mobile Portrait" ),
									"value" => "",
									"after_input" => "<a href='' class='res-preview'>Preview</a>"
									
							) );
						 ?>
				</div>	
			-->

				<div class="panels" data-step='2' data-intro='Each Panel Here represents an area of the site, it has sub panels which contains stylers for each area.' data-position='right'>
					<div class="search-section clearfix">
						<input type="text" placeholder='Search for Item..' id='en_search'>
						<i class="ioa-front-icon search-3icon-"></i>
					</div>	
					<?php 

					

					echo $styler->createStyleMatrix($args);
					 ?>
				</div>
				</div>

			</div>
		
		</div>


	</div>	
</div>

<iframe src="" frameborder="0" height="100%" width="80%" id="enigma_edit_frame" ></iframe>


<div class="sticky-save-message">
	<?php _e('Changes Saved !','ioa'); ?>
</div>

<div class="enigma-lightbox">
			<div class="enigma-l-head">
				<h4><?php _e('Import/Export Style Templates','ioa') ?></h4>
			</div>
			<div class="enigma-l-body clearfix">
				<div class="component-opts">
					
					<h4><?php _e('Export','ioa') ?></h4>	
					<?php 
							
							echo getIOAInput(array( 
									"label" => __("Select Template to export",'ioa') , 
									"name" => "enigma_export",
									"length" => "small" , 
									"default" => $default , 
									"type" => "select",
									"description" => "" ,
									"options" => $templates,
									"value" => "",
									"after_input"   => "<a href='".home_url('/')."/?enigma=styler&pid=".$_GET['pid']."&export_en=true"."' class='export-style button-hprimary'> Export </a>"
							) );
					 ?>	

					<h4><?php _e('Import','ioa') ?></h4>	
					<?php 
							
							echo getIOAInput(array( 
									"label" => __("Add Text from Template to import",'ioa') , 
									"name" => "enigma_import",
									"length" => "small" , 
									"default" => '' , 
									"type" => "textarea",
									"description" => "" ,
									"value" => "",
									"after_input"   => "<a href='' class='import-style button-hprimary'> ".__('Import','ioa')." </a>"
							) );
					 ?>	
				</div>
				
			</div>
			
			<div class="enigma-l-footer clearfix">
				<a href="" class="button-close" id="close-l" ><?php _e('Close','ioa') ?></a>
			</div>
		</div>


<?php wp_footer(); ?>


<div class="concave-lightbox">
			<div class="concave-l-head">
				<h4><?php _e('Custom CSS Editor','ioa') ?></h4>
			</div>
			<div class="concave-l-body clearfix">
	

				<div class="concave-toolbox clearfix">
					<?php 
					function array_unique_key($array) { 
					    $result = array(); 
					    foreach (array_unique(array_keys($array)) as $tvalue) { 
					        $result[$tvalue] = $array[$tvalue]; 
					    } 
					    return $result; 
					}
						
						$concave_selectors = array();

						foreach($args as $panels)
						{
							foreach ($panels as $key => $areas) {
								$temp = array();
								foreach ($areas['matrix'] as $k => $selectors) {
										$filv = str_replace(array('Background','Border Bottom','Color','Border Left','Border Right','Border Top','Border'),'',$selectors['label']);
										$temp[str_replace(' ','',$k)] = array( 'selector' => $k , 'label' => $filv );

									}	
								$concave_selectors[$areas['label']] = $temp;	
							}
						}

						$fcs = array();
						foreach ($concave_selectors as $key => $value) {
						 	$fcs[$key] =  array_unique_key($value);
						 } 
						
						$str = '';

						foreach ($fcs as $key => $value) {
						 	$str .= '<optgroup label="'.str_replace('Stylings','Elements',$key).'">';
						 		foreach ($value as $k => $style) {
						 			$str .= '<option value="'.$style['selector'].'">'.$style['label'].'</option>';
						 		}
						 	$str .= '</optgroup>';
						 } 
						
							
					 ?>
					<div class="ioa_input clearfix">
						 <div class="ioa_input_holder clearfix medium  ">
					 		 <div class="ioa_select_wrap">
					 		 		<select class="concave_selectors" id="concave_selectors" name="concave_selectors" data-default="">
					 		 			<?php echo $str; ?>
					 		 		</select>
					 		 </div>	
					 </div>
					</div>
					<a href="" class="insert-concave-element "><?php _e('Insert Element','ioa') ?></a>	
					<a href="" class="preview-concave"><?php _e('Preview','ioa') ?></a>	
					<a href="" class="erase-concave"><?php _e('Erase All','ioa') ?></a>	

				</div>
				
				<div class="component-opts">

					
					<?php 
							$vals = '';
							if(get_option(SN.'concave_value')) $vals = get_option(SN.'concave_value');	
							echo getIOAInput(array( 
									"label" => "" , 
									"name" => "concave_editor",
									"length" => "small" , 
									"default" => '' , 
									"type" => "textarea",
									"description" => "" ,
									"value" => stripslashes($vals)
							) );
					 ?>	
				</div>
				
			</div>
			
			<div class="concave-l-footer clearfix">
				<a href="" class="button-hprimary" id="close-c" ><?php _e('Close','ioa') ?></a>
			</div>
		</div>

 <div class="safe-font-opts ">
 	<?php 
		$websafe_fonts = array("Arial","Helvetica Neue","Helvetica",'Tahoma',"Verdana","Lucida Grande","Lucida Sans");
		$str = '';	
		foreach ($websafe_fonts as $key => $value) {
			$str .= "<option value='$value'>$value</option>";
		}
		echo $str;
 	 ?>
 </div>


<div class="font-select-area">
				<div class="top-bar clearfix">
					<a href="" class="font-save-button"><?php _e('Apply Changes','ioa') ?></a>
					<a href="" class="font-close-button"><?php _e('Close','ioa') ?></a>
				</div>
				<div class="inner-font-select-area">
				


				<div class="font-usage-type">
					<?php 
					$fts = "google";
					if( get_option(SN.'font_selector') ) $fts = get_option(SN.'font_selector');

					echo getIOAInput(array( 
									"label" => "Import Fonts Using " , 
									"name" => "font_type_selector",
									"length" => "small" , 
									"default" => 'google' , 
									"type" => "select",
									"description" => "" ,
									"options" => array("google" =>"Google Web Fonts","fontface" =>"Font Face","fontdeck" => "Font Deck"),
									"value" => $fts
							) );

					 ?>
				</div>

				<div class="google hide clearfix">
					<h5>Google Fonts</h5>

					<div class="preview-font">
					  <iframe id="gfont-frame" src="<?php echo HURL; ?>/adv_mods/gfont_input.php?font=" width="100%" height="130">
					   </iframe>
					 </div>


					<?php 
				global $or_google_webfonts;


				echo getIOAInput(array( 
									"label" => "Select Font" , 
									"name" => "font_selector",
									"length" => "small" , 
									"default" => '' , 
									"type" => "select",
									"description" => "" ,
									"options" => $or_google_webfonts,
									"value" => "",
									"after_input"   => "<a href='' class='font-adder'>Add Font Support</a>"
							) );
				?>
					
					<div class="font-stack">
						<?php $font_stack = get_option(SN.'font_stacks'); 

						if($font_stack!="" && is_array($font_stack))
						{
							foreach ($font_stack as $key => $font) {
								$font_br = explode(';',$font);
								?>
								<div class="font-s-block ">
									<div class="font-s-head"> Font : <strong><?php echo $font_br[0]; ?></strong> <a href="" class="edit-s-font">Edit</a> <a href="" class="delete-s-font">Delete</a> </div>
									<div class="font-s-body">
										<div class="info"> To check supported Font Weights and Subsets goto <a target="_BLANK" href="http://www.google.com/fonts/">http://www.google.com/fonts/</a>. Find the font and click on quick use. </div>
										
										<div class="font-weight-wrap">
											<?php 

											echo getIOAInput(array( 
												"label" => __("Select Font Weights",'ioa') , 
												"name" => "fn_w",
												"length" => "small" , 
												"default" => '' , 
												"type" => "checkbox",
												"description" => "" ,
												"std" => "400",
												"options" => array("100","100 Italic", "200","200 Italic","300","300 Italic","400","400 Italic","500","500 Italic","600","600 Italic","700","700 Italic","800","800 Italic"),
												"value" => $font_br[1]
											));

											?>
										</div>


										<div class="font-subset-wrap">
											<?php 

											echo getIOAInput(array( 
												"label" => __("Select Font Subsets",'ioa') , 
												"name" => "fn_s",
												"length" => "small" , 
												"default" => '' , 
												"type" => "checkbox",
												"description" => "" ,
												"std" => "",
												"options" => array("Cyrillic","Cyrillic Extended","Greek","Greek Extended","Khmer","Latin","Latin Extended","Vietnamese"),
												"value" => $font_br[2]
											));

											?>
										</div>


									</div>
								</div>

								<?php
							}
						}

						?>
					</div>	

					<div class="font-s-block clonable">
						<div class="font-s-head"> Font : <strong>Open Sans</strong> <a href="" class="edit-s-font">Edit</a> <a href="" class="delete-s-font">Delete</a> </div>
						<div class="font-s-body">
							<div class="info"> To check supported Font Weights and Subsets goto <a target="_BLANK" href="http://www.google.com/fonts/">http://www.google.com/fonts/</a>. Find the font and click on quick use. </div>
							
							<div class="font-weight-wrap">
								<?php 

								echo getIOAInput(array( 
									"label" => __("Select Font Weights",'ioa') , 
									"name" => "fn_w",
									"length" => "small" , 
									"default" => '' , 
									"type" => "checkbox",
									"description" => "" ,
									"std" => "400",
									"options" => array("100","100 Italic", "200","200 Italic","300","300 Italic","400","400 Italic","500","500 Italic","600","600 Italic","700","700 Italic","800","800 Italic"),
									"value" => ""
								));

								?>
							</div>


							<div class="font-subset-wrap">
								<?php 

								echo getIOAInput(array( 
									"label" => __("Select Font Subsets",'ioa') , 
									"name" => "fn_s",
									"length" => "small" , 
									"default" => '' , 
									"type" => "checkbox",
									"description" => "" ,
									"std" => "",
									"options" => array("Cyrillic","Cyrillic Extended","Greek","Greek Extended","Khmer","Latin","Latin Extended","Vietnamese"),
									"value" => ""
								));

								?>
							</div>


						</div>
					</div>
				</div>

				<div class="fontface hide clearfix">
					<h5>Fontface Fonts</h5>
					<?php

					$font_faces = array();
					$ffpath = PATH."/sprites/fontface";
					$ffs = scandir($ffpath);

					foreach ($ffs as $key => $value) {
						if(is_dir($ffpath.'/'.$value) && $value!='..' && $value!='.')
						{
							$font_faces[] = $value;
						}
					}
					$ffont = ''; global $super_options;
					if(get_option(SN.'_font_face_font'))
						$ffont = get_option(SN.'_font_face_font');
				
					echo getIOAInput(array( 
									"label" => "Select the Font To Support " , 
									"name" => "font_face_name",
									"length" => "small" , 
									"default" => '' , 
									"type" => "select",
									"description" => "" ,
									"options" => $font_faces,
									"value" => $ffont
							) ); 
							?>
				</div>
				<div class="fontdeck hide clearfix">
					<h5>Font Deck Fonts</h5>
					<?php  

					$font_deck_project_id = '';

					if(get_option(SN.'_font_deck_project_id'))
					$font_deck_project_id = get_option(SN.'_font_deck_project_id');

					$font_deck_name = '';

					if(get_option(SN.'_font_deck_name'))
					$font_deck_name = get_option(SN.'_font_deck_name');


						echo getIOAInput(array( 
									"label" => "Project ID" , 
									"name" => "font_deck_id",
									"length" => "small" , 
									"default" => '' , 
									"type" => "text",
									"description" => "" ,
									"value" => $font_deck_project_id
							) ); 

						echo getIOAInput(array( 
									"label" => "Font Name" , 
									"name" => "font_deck_name",
									"length" => "small" , 
									"default" => '' , 
									"type" => "text",
									"description" => ""  ,
									"value" => $font_deck_name
							) );

					?>
				</div>
			</div>
				</div>	
</body>
</html>