<?php
/**
 *  Core Class For Generating Theme Options
 */


/*
 * Currently using old pattern for storing options. Will be Upgraded in coming versions.



======================================================================================
== IOA Option Panel ================================================================
======================================================================================

Version 6.1 
Authors - 

Current Elements -
--------------------------------------------------------
  1.  Text Box            =  ( code => text ) Creates a text box. 
  2.  Text Area           =  ( code => textarea) Creates a textarea 
  3.  Checkboxes          =  ( code => checkbox) Creates checkboxes
  4.  Radio buttons       =  ( code => radio) Creates Radio buttons
  5.  Slider              =  ( code => slider) Creates a numeric slider
  6.  Color picker        =  ( code => colorpicker) Creates a color picker with a supporting textbox
  7.  Drop down lists     =  ( code => select) Creates a dropdown list
  8.  Toggle              =  ( code => toggle) Creates a Yes/No radio button set
  9.  Includes            =  ( code => include) Adds a way to include advance panels
  10. Upload              =  ( code => upload) Creates an upload box
  11. Help                =  ( code => help) Creates a inframe which can be link to pages.
======================================================================================

*/

	

$pmb ='';

$post_meta_shortcodes =  array(

					"post_author" => array(
							"name" =>  __("Post Author",'ioa'),
							"syntax" => '[post_author_posts_link/]',
							),	
					"post_date" => array(
							"name" =>  __("Post Date",'ioa'),
							"syntax" => '[post_date format=\'l, F d S, Y\'/]',
							),					
					"post_time" => array(
							"name" =>  __("Post Time",'ioa'),
							"syntax" => '[post_time format=\'g:i a\'/]',
							),	
					"post_tags" => array(
							"name" =>  __("Post Tags",'ioa'),
							"syntax" => '[post_tags sep=\',\' icon=\'\' /]',
							),	
					"post_categories" => array(
							"name" =>  __("Post Categories",'ioa'),
							"syntax" => '[post_categories sep=\',\' icon=\'\' /]',
							),
					"get" => array(
							"name" =>  __("Post Meta",'ioa'),
							"syntax" => '[get name=\'\' /]',
							),
					"post_comments" => array(
							"name" => __("Post Comments",'ioa'),
							"syntax" => "[post_comments /]"
							)

						);

foreach($post_meta_shortcodes as $sh) $pmb .= " <a  class='button-default' href=\"".$sh['syntax']."\">".$sh['name']."</a> ";

$osidebars = array("Blog Sidebar");
if( get_option(SN.'_custom_sidebars'))
{
	$dys = explode(',',get_option(SN.'_custom_sidebars'));
	foreach($dys as $s)
			{
				if($s!="")
				{
					$osidebars[] = $s;
				}
			} 
}

$font_faces = array();


$ffpath = PATH."/sprites/fontface";
if(file_exists($ffpath)) :

    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($ffpath), RecursiveIteratorIterator::SELF_FIRST);

    foreach($objects as $name => $object){
    	 if( $object->isDir() )
    					    {
    					    	 
    								$folder_info = pathinfo($name);
    								$current_dir = $folder_info['basename'];
    					    		if($current_dir!='.' && $current_dir!='..')
    					    		$font_faces[] = $current_dir;
    					    	
    					    }
    	}
    
endif;    
/* ====================================================================================== */
/* == General Settings Panel ============================================================ */
/* ====================================================================================== */
$ioa_options = array();
$ioa_options[]   = array( 
		           "name" => __("General Settings",'ioa'),
	  	           "type" => "section", "icon" => "pencil"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array(__("Basic Settings",'ioa'),__("Logo Settings",'ioa'),__("Head Area Settings",'ioa'),__("BreadCrumbs",'ioa'),__("Misc",'ioa'))  );

		  

	
	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Basic Settings",'ioa') , 
				   "type"=>"subtitle" , 
				  );



$ioa_options[]   =  array( 
				  "name" => __("Enable/Disable Live Editing",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_rad_live_edit",
				  "type" => "toggle",
				  "std" => "true"
					);	

$ioa_options[]   = array(
                  "name" => __("Favicon Upload",'ioa'),
				  "desc" => "upload your logo here.",
				  "id" => $shortname."_favicon",
				  "type" => "upload",
				  "title" => __("Use as Favicon",'ioa'),
				  "std" => "",
				  "button" => __("Add Favicon",'ioa'), "title" => __("Add Favicon",'ioa')	 
				  );				  


$ioa_options[]   = array(
                  "name"=>__("Number of search results in AJAX Search to show",'ioa'),
			      "desc"=>"",
			      "id" => $shortname."_ajax_nos",
				  "type"=>"slider",
				  "max"=>10,
				  "std"=>4,
				  "suffix"=>" posts"
					 );


$ioa_options[]   = array(
                 "name" => __("Javascript Code",'ioa'),
	             "desc" => "Add your javascript code here, this will be in head section inside <strong>script tags.</strong>.",
	             "id" => $shortname."_headjs_code",
	             "type" => "textarea",
	             "std" => ""	 
				  );	
				   
$ioa_options[]   = array(
                 "name" => __("Tracking Code",'ioa'),
	             "desc" => "Add your Google Analytics code or some other, this will be in footer inside <strong>script tags.</strong>.",
	             "id" => $shortname."_tracking_code",
	             "type" => "textarea",
	             "std" => ""	 
				  );	


$ioa_options[]   = array(
                 "name" => __("Custom Css Code",'ioa'),
	             "desc" => "Quick and Save way of adding css styles to your site.",
	             "id" => $shortname."_custom_css",
	             "type" => "textarea",
	             "std" => ""	 
				  );

				  			  				  				  				  				  				  			  				  
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$ioa_options[] = array(
				"name" => __("Logo Settings",'ioa'),
				"type" => "subtitle"	
				);

$ioa_options[]   = array(
                  "name" => __("Logo Upload",'ioa'),
				  "desc" => "upload your logo here.",
				  "id" => $shortname."_logo",
				  "type" => "upload",
				  "title" => __("Use as Logo",'ioa'),
				  "std" => URL."/sprites/i/logo.png",
				  "button" => __("Add Logo",'ioa'), "title" => __("Add Logo",'ioa')	 
				  );

$ioa_options[]   = array(
                  "name" => __("Retina Logo Upload",'ioa'),
				  "desc" => "upload your retina logo here.",
				  "id" => $shortname."_rlogo",
				  "type" => "upload",
				  "title" => __("Use as Logo",'ioa'),
				  "std" => "",
				  "button" => __("Add Logo",'ioa'), "title" => __("Add Logo",'ioa')	 
				  );



$ioa_options[]   = array(
                  "name" => __("Logo Upload for Compact Menu( max height 38px )",'ioa'),
				  "desc" => "upload your retina logo here.",
				  "id" => $shortname."_clogo",
				  "type" => "upload",
				  "title" => __("Use as Logo",'ioa'),
				  "std" => URL."/sprites/i/clogo.png",
				  "button" => __("Add Logo",'ioa'), "title" => __("Add Logo",'ioa')	 
				  );


$ioa_options[]   = array(
                  "name" => __("Mobile(57px by 57px) and Tables Touch Icon Upload",'ioa'),
				  "desc" => "upload your icon for apple iphone touch icon. Width and Height should be 57px x 57px",
				  "id" => $shortname."_generic_touch",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" => "",
				  "button" => __("Add Icon",'ioa') 
				  );


$ioa_options[]   = array(
                  "name" => __("iOS7 Retina(120px by 120px) Touch Icon Upload",'ioa'),
				  "desc" => "upload your icon for apple iPad touch icon. Width and Height should be 72px x 72px",
				  "id" => $shortname."_iphone7_retina_icon_logo",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" =>  "",
				  "button" => __("Add Icon",'ioa') 
				  );

$ioa_options[]   = array(
                  "name" => __("iOS6 Retina(114px by 114px) Touch Icon Upload",'ioa'),
				  "desc" => "upload your icon for apple iPad touch icon. Width and Height should be 114px x 114px",
				  "id" => $shortname."_iphone_retina_icon_logo",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" => "",
				  "button" => __("Add Icon",'ioa') 
				  );

$ioa_options[]   = array(
                  "name" => __("Retina(72px by 72px) Touch Icon Upload",'ioa'),
				  "desc" => "upload your icon for apple iPad touch icon. Width and Height should be 72px x 72px",
				  "id" => $shortname."_ipad_icon_logo",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" => "",
				  "button" => __("Add Icon",'ioa')
				  );

$ioa_options[]   = array(
                  "name" => __("Retina Touch(144px by 144px) Icon Upload",'ioa'),
				  "desc" => "upload your icon for apple iPad touch icon. Width and Height should be 144px x 144px",
				  "id" => $shortname."_ipad_retina_icon_logo",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" => "",
				  "button" => __("Add Icon",'ioa')
				  );


$ioa_options[]   = array(
                  "name" => __("Logo Width",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_logo_width",
				  "type" => "text",
				  "std" => ""
				  );


$ioa_options[]   = array(
                  "name" => __("Logo Height",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_logo_height",
				  "type" => "text",
				  "std" => ""
				  );

$ioa_options[] = array("type" => "close_subtitle");	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Head Area Settings",'ioa') , 
				   "type"=>"subtitle" , 
				  );

$ioa_options[]   =  array( 
				  "name" => __("Show/hide Theme Top Loader",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_top_loader",
				  "type" => "toggle",
				  "std" => "true"
					);	

$ioa_options[]   =  array( 
				  "name" => __("Show/hide Compact Sticky Menu",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_cmenu_enable",
				  "type" => "toggle",
				  "std" => "true"
					);	

$ioa_options[]   = array( 
				  "name" => __("Header Shadow Select",'ioa'),
				  "desc" => "select the bottom shadow for head.",
				  "id" => $shortname."_head_shadow",
				  "type" => "select",
				  "options" => array("None"=> __("None",'ioa'),"Type 1"=>__("Type 1",'ioa'),"Type 2"=>__("Type 2",'ioa'),"Type 3"=>__("Type 3",'ioa'),"Type 4"=>__("Type 4",'ioa'),"Type 5"=>__("Type 5",'ioa')),
				  "std" => "Type 1"
				 );

$ioa_options[]   = array( 
				  "name" => __("Menu Dropdown show style",'ioa'),
				  "desc" => "select the reveal style for dropdowns.",
				  "id" => $shortname."_submenu_effect",
				  "type" => "select",
				  "options" => array("None" => __("None",'ioa'),"Fade" => __("Fade",'ioa'),"Fade Shift Down" => __("Fade Shift Down",'ioa'),"Fade Shift Right" => __("Fade Shift Right",'ioa'),"Scale In Fade" => __("Scale In Fade",'ioa'),"Scale Out Fade" => __("Scale Out Fade",'ioa'),"Grow" => __("Grow",'ioa'),"Slide" => __("Slide",'ioa')),
				  "std" => "Type 1"
				 );			


$ioa_options[]   = array( 
				  "name" => __("Menu Layout",'ioa'),
				  "desc" => "select the reveal style for dropdowns.",
				  "id" => $shortname."_menu_layout",
				  "type" => "select",
				  "options" => array("default" => __("Boxed",'ioa'),"fluid" => __("Full Width",'ioa')),
				  "std" => "default"
				 );	

$ioa_options[]   = array( 
				  "name" => __("Responsive Menu style",'ioa'),
				  "desc" => "select the reveal style for dropdowns.",
				  "id" => $shortname."_res_menu",
				  "type" => "select",
				  "options" => array("side"=>__("Side",'ioa'),"dropdown"=>__("Dropdown",'ioa')),
				  "std" => "dropdown"
				 );		

$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("BreadCrumbs" ,'ioa'), 
				   "type"=>"subtitle" , 
				   "id"=>"BreadCrumbs"
					 );
					 	
$ioa_options[]   =  array( 
				  "name" => __("Show/Hide Breadcrumbs",'ioa'),
				  "desc" => "Enable/ Disable Breadcrumbs all over the theme.",
				  "id" => $shortname."_breadcrumbs_enable",
				  "type" => "toggle",
				  "std" => "true"
					);	

$ioa_options[]   = array(
                  "name" => __("Breadcrumb Delimiter",'ioa'),
	              "desc" => "Enter the symbol for separator words in breadcrumb.",
	              "id" => $shortname."_breadcrumb_delimiter",
	              "type" => "text",
	              "std" => "/"	 
				  );
				  
$ioa_options[]   = array(
                  "name" => __("Enter Home Label",'ioa'),
	              "desc" => "Enter the home label for breadcrumb.",
	              "id" => $shortname."_breadcrumb_home_label",
	              "type" => "text",
	              "std" => "Home"	 
				  );				
									  				  										 
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Misc",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"misc"
					 );

$ioa_options[]   = array( 
				  "name" => __("Show Pagination Dropdown",'ioa'),
				  "desc" => "select pagination style here.",
				  "id" => $shortname."_pagination_dropdown",
				 
				 "type" => "toggle",
				  "std" => "true",
				 );



$ioa_options[]   = array( 
				  "name" => __("Show Posts Comments",'ioa'),
				  "desc" => "show/hide posts comments.",
				  "id" => $shortname."_posts_comments",
				  "type" => "toggle",
				  "std" => "true",
				 );	


$ioa_options[]   = array( 
				  "name" => __("Show Page Comments",'ioa'),
				  "desc" => "show/hide posts comments.",
				  "id" => $shortname."_page_comments",
				  "type" => "toggle",
				  "std" => "false",
				 );	
				 				 				 		 				
				
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */




$ioa_options[]   = array("type"=>"close");




/* ====================================================================================== */
/* == Social Settings Panel Ends ======================================================= */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Social Settings",'ioa'),
	  	           "type" => "section", "icon" => "share"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array("Twitter Settings") );

		  

	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Twitter Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   
					 );

$ioa_options[] = array(

				  "type" => "custom",
				  "std" => "<div class='ioa-information-p'> You can create it here <a href='https://dev.twitter.com/apps/new' style='color:#fff'>https://dev.twitter.com/apps/new</a> </div>"	

				);

$ioa_options[]   = array(
                  "name" => __("Consumner key",'ioa'),
	              "desc" => "You can create it here https://dev.twitter.com/apps/new.",
	              "id" => $shortname."_twitter_key",
	              "type" => "text",
	              "std" => ""	 
				  );


$ioa_options[]   = array(
                  "name" => __("Consumner Secret key",'ioa'),
	              "desc" => "You can create it here https://dev.twitter.com/apps/new.",
	              "id" => $shortname."_twitter_secret_key",
	              "type" => "text",
	              "std" => ""	 
				  );

$ioa_options[]   = array(
                  "name" => __("Access Token",'ioa'),
	              "desc" => "You can create it here https://dev.twitter.com/apps/new.",
	              "id" => $shortname."_twitter_token",
	              "type" => "text",
	              "std" => ""	 
				  );

$ioa_options[]   = array(
                  "name" => __("Access Secret Token",'ioa'),
	              "desc" => "You can create it here https://dev.twitter.com/apps/new.",
	              "id" => $shortname."_twitter_secret_token",
	              "type" => "text",
	              "std" => ""	 
				  );
				  					
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ==================================================================== */

	
$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Social Panel Ends =---================================================================ */
/* ====================================================================================== */




/* ====================================================================================== */
/* == General Settings Panel Ends ======================================================= */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("SEO",'ioa'),
	  	           "type" => "section", "icon" => "line-graph"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array(__("Head Related Settings",'ioa')) );

		  

	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Head Related Settings" ,'ioa'), 
				   "type"=>"subtitle" , 
				   
					 );

$ioa_options[]   =  array( 
				  "name" => __("Use Theme's SEO",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_seo",
				  "type" => "toggle",
				  "std" => "true"
					);
					
$ioa_options[]   = array(
                  "name" => __("Title For Site",'ioa'),
	              "desc" => "It will appear in title tag.",
	              "id" => $shortname."_title",
	              "type" => "text",
	              "std" => ""	 
				  );
				  
$ioa_options[]   = array(
                  "name" => __("Meta keywords For Site",'ioa'),
	              "desc" => "It will appear in head section.",
	              "id" => $shortname."_meta_keywords",
	              "type" => "text",
	              "std" => ""	 
				  );

$ioa_options[]   = array(
                  "name" => __("Meta description For Site",'ioa'),
	              "desc" => "It will appear in head section.",
	              "id" => $shortname."_meta_description",
	              "type" => "text",
	              "std" => ""	 
				  );


				  
				  					
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ==================================================================== */



$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == SEO Panel Ends =---================================================================ */
/* ====================================================================================== */


/* ====================================================================================== */
/* == General Settings Panel Ends ======================================================= */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Sidebars",'ioa'),
	  	           "type" => "section" ,"icon" => "numbered-list"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array(__("Sidebar Settings",'ioa'),__("Misc Pages Sidebars",'ioa')) );

		  

	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Sidebar Settings" ,'ioa'), 
				   "type"=>"subtitle" , 
				   
					 );

					  
$ioa_options[]   = array(
						"name" => __("Visual File",'ioa'), 
						"type"=>"include", 
						"std"=> HPATH."/adv_mods/sidebar.php"
					  );	

				  
				  					
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ==================================================================== */

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Misc Pages Sidebars",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"pagesmisc"
					 );



$ioa_options[]   = array( 
				  "name" => __("Search Sidebar",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_search_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );
				 				 				 		 				
$ioa_options[]   = array( 
				  "name" => __("Archive Sidebar",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_archive_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );


$ioa_options[]   = array( 
				  "name" => __("Tags Sidebar",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_tag_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );

$ioa_options[]   = array( 
				  "name" => __("Author Sidebar",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_author_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );

$ioa_options[]   = array( 
				  "name" => __("Category Sidebar",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_category_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );

$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */



$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == SEO Panel Ends =---================================================================ */
/* ====================================================================================== */


/* ====================================================================================== */
/* == Menu Settings Panel Ends ======================================================= */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Layout Settings",'ioa'),
	  	           "type" => "section", "icon" => "browser"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array(__("Default Settings",'ioa'),__("Misc Pages Layout",'ioa')) );

		  

	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Default Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   
					 );

$ioa_options[]   = 	array( 
						"name" => __("Switch On Boxed Layout",'ioa'),
						"desc" => "",
						"id" => $shortname."_boxed_layout",
						"type" => "toggle",
						"std" => "false"
					  );	

$ioa_options[]   =  array( 
				  "name" => "Enable/ Disable Responsive View",
				  "desc" => "Enable/ Disable Mobile View all over the theme. The site will look at it looks on a standard screen",
				  "id" => $shortname."_mobile_view",
				  "type" => "toggle",
				  "std" => "true"
					);	
				
				
$ioa_options[]   = array(
                  "name"=>__("Set Container Width for Mobile Devices",'ioa'),
			      "desc"=>"",
			      "id" => $shortname."_res_width",
				  "type"=>"slider",
				  "max"=>100,
				  "std"=>70,
				  "suffix"=>"%"
					 );
$ioa_options[]   = array(
						"name" => __(" Panel File",'ioa'), 
						"type"=>"include", 
						"std"=> HPATH."/adv_mods/layout.php"
					  );

				  					
$ioa_options[]   = array("type"=>"close_subtitle");
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Misc Pages Layout",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"pagesmisc"
					 );


$ioa_options[]   = array( 
				  "name" => __("Search Page Post Layout",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_search_blog_layout",
				  "type" => "select",
				  "options" => array("classic" =>"Classic" ,'full-width'=> "Full Posts" , 'grid'=>"Grid Layout", 'single-column' => "Single Column" , 'thumb-list'=> "Thumb List"),
				  "std" => "classic"
				 );

$ioa_options[]   = array( 
				  "name" => __("Archive Page Post Layout",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_archive_blog_layout",
				  "type" => "select",
				  "options" => array("classic" =>"Classic" ,'full-width'=> "Full Posts" , 'grid'=>"Grid Layout", 'single-column' => "Single Column" , 'thumb-list'=> "Thumb List"),
				  "std" => "classic"
				 );

$ioa_options[]   = array( 
				  "name" => __("Category Page Post Layout",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_category_blog_layout",
				  "type" => "select",
				  "options" => array("classic" =>"Classic" ,'full-width'=> "Full Posts" , 'grid'=>"Grid Layout", 'single-column' => "Single Column" , 'thumb-list'=> "Thumb List"),
				  "std" => "classic"
				 );

$ioa_options[]   = array( 
				  "name" => __("Tags Page Post Layout",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_tags_blog_layout",
				  "type" => "select",
				  "options" => array("classic" =>"Classic" ,'full-width'=> "Full Posts" , 'grid'=>"Grid Layout", 'single-column' => "Single Column" , 'thumb-list'=> "Thumb List"),
				  "std" => "classic"
				 );

$ioa_options[]   = array( 
				  "name" => __("Author Page Post Layout",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_author_blog_layout",
				  "type" => "select",
				  "options" => array("classic" =>"Classic" ,'full-width'=> "Full Posts" , 'grid'=>"Grid Layout", 'single-column' => "Single Column" , 'thumb-list'=> "Thumb List"),
				  "std" => "classic"
				 );

$ioa_options[]   = array("type"=>"close_subtitle");
/* == Sub Panel Ends ==================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Menu Panel Ends =---================================================================ */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Footer Panel ====================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Footer",'ioa'),
	  	           "type" => "section" , "icon" => "text-doc"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array("Footer Settings"));

		  

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Footer Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"fsettings"
					 );

$ioa_options[]   = 	array( 
						"name" => __("Show Footer Bar",'ioa'),
						"desc" => "",
						"id" => $shortname."_footer_bar",
						"type" => "toggle",
						"std" => "true"
					  );	
				   
$ioa_options[]   = array( 
				  "name" => __("Show Footer Widgets column area",'ioa'),
				  "desc" => "toogle display of footer widgets.",
				  "id" => $shortname."_footer_widgets",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "Yes"
				   );
				   

$ioa_options[]   = array(
						"name" => __("Footer Panel File",'ioa'), 
						"type"=>"include", 
						"std"=> HPATH."/adv_mods/footer.php"
					  );

$ioa_options[]   = array( 
				  "name" => __("Show Bottom Footer Area",'ioa'),
				  "desc" => "toogle display of footer menu.",
				  "id" => $shortname."_footer_menu",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "Yes"
				   );

$ioa_options[]   = array( 
				  "name" => __("Footer Text",'ioa'),
				  "desc" => "footer text.",
				  "id" => $shortname."_footer_text",
				  "type" => "textarea",
				  "std" => ""
				   );
				   				   										
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Footer Panel Ends ================================================================= */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Portfolio Panel =================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Portfolio",'ioa'),
	  	           "type" => "section" , "icon" => "monitor"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open","tabs" => array(__("Portfolio Options",'ioa'), __("Single Portfolio Options",'ioa'), __("Portfolio Post Type",'ioa')));

		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Portfolio Options",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"portfoliooption"
					 );

	

$ioa_options[]   = 	array( 
						"name" => __("Use Wordpress Excerpt",'ioa'),
						"desc" => "",
						"id" => $shortname."_portfolio_excerpt",
						"type" => "toggle",
						"std" => "true"
					  );	


$ioa_options[]   = 	array( 
						"name" => __("Portfolio Parent Link for Breadcrumb",'ioa'),
						"desc" => "",
						"id" => $shortname."_portfolio_parent_link",
						"type" => "text",
						"std" => ""
					  );

$ioa_options[]   = 	array( 
						"name" => __("Portfolio Parent label for Breadcrumb",'ioa'),
						"desc" => "",
						"id" => $shortname."_portfolio_blabel",
						"type" => "text",
						"std" => "Portfolio"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Show/Hide Portfolio View Switch",'ioa'),
						"desc" => "",
						"id" => $shortname."_portfolio_switch",
						"type" => "toggle",
						"std" => "true"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Show/Hide Portfolio Animated Filter",'ioa'),
						"desc" => "",
						"id" => $shortname."_portfolio_filter",
						"type" => "toggle",
						"std" => "true"
					  );


$ioa_options[]   = array( 
				  "name" => __("Portfolio Filter Style",'ioa'),
				  "desc" => "select the reveal style for dropdowns.",
				  "id" => $shortname."_portfolio_fitler_style",
				  "type" => "select",
				  "options" => array("open"=>__("Open",'ioa'),"dropdown"=>__("Dropdown",'ioa')),
				  "std" => "dropdown"
				 );		

$ioa_options[]   = 	array( 
						"name" => __("Show Lightbox on posts thumbnail",'ioa'),
						"desc" => "Show lightbox on posts thumbnail, if no it will point to the post.",
						"id" => $shortname."_portfolio_enable_thumbnail",
						"type" => "toggle",
						"std" => "true"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Continue Button Label",'ioa'),
						"desc" => "Enter the label for continue button.",
						"id" => $shortname."_portfolio_more_label",
						"type" => "text",
						"std" => "more"
					  );
					  
$ioa_options[] = array(
                  "name"=> __("Portfolio Items Limit",'ioa'),
			      "desc"=>"set your items per page limit here",
				   "id" => $shortname."_portfolio_item_limit",
				   "type"=>"slider",
				   "max"=>50,
				   "std"=>6,
				   "suffix"=>"Items");						  					  

										   
				   
$ioa_options[] = array(
                  "name"=>__("Excerpt text Limit",'ioa'),
			      "desc"=>"set your no of characters for excerpt here. Works Only When wordpress excerpt is disabled",
				   "id" => $shortname."_portfolio_excerpt_limit",
				   "type"=>"slider",
				   "max"=>500,
				   "std"=>300,
				   "suffix"=>"letters");


$ioa_options[] = array(
                  "name"=>__("Portfolio Column 1 Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_p1_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>450,
				   "suffix"=>"px");						  					  
			   
$ioa_options[] = array(
                  "name"=>__("Portfolio Column 2 Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_p2_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>320,
				   "suffix"=>"px");		

$ioa_options[] = array(
                  "name"=>__("Portfolio Column 3 Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_p3_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>220,
				   "suffix"=>"px");		

$ioa_options[] = array(
                  "name"=>__("Portfolio Column 4 Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_p4_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>180,
				   "suffix"=>"px");		

$ioa_options[] = array(
                  "name"=>__("Portfolio Column 5 Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_p5_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>150,
				   "suffix"=>"px");						   				   				   			   					  

$ioa_options[] = array(
                  "name"=>__("Portfolio Featured Image Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_ff_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>450,
				   "suffix"=>"px");	

$ioa_options[] = array(
                  "name"=>__("Portfolio Featured Template Images Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_ffa_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>350,
				   "suffix"=>"px");	

$ioa_options[] = array(
                  "name"=>__("Portfolio Gallery Images Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_pgallery_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>500,
				   "suffix"=>"px");	

$ioa_options[] = array(
                  "name"=>__("Portfolio Masonry Images Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_pmasonry_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>300,
				   "suffix"=>"px");	

$ioa_options[] = array(
                  "name"=>__("Portfolio Metro Images Width",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_pmetro_width",
				   "type"=>"slider",
				   "max"=>1200,
				   "std"=>864,
				   "suffix"=>"px");	

$ioa_options[]   = array("type"=>"close_subtitle");


/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Single Portfolio Options",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"singleportfoliooption"
					 );


$ioa_options[]   = 	array( 
						"name" => __("Enter Portfolio Extra Fields Separated by <strong>;</strong>",'ioa'),
						"desc" => "Enter the label for continue button.",
						"id" => $shortname."_single_portfolio_meta",
						"type" => "text",
						"std" => "Time ; Live Site"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Related Posts Title",'ioa'),
						"desc" => "",
						"id" => $shortname."_single_portfolio_related_title",
						"type" => "text",
						"std" => "More Similar Projects"
					  );


$ioa_options[]   = 	array( 
						"name" => __("Show Related Area",'ioa'),
						"desc" => "",
						"id" => $shortname."_single_portfolio_related_enable",
						"type" => "toggle",
						"std" => "true"
					  );	

$ioa_options[]   = 	array( 
						"name" => __("Show Portfolio Bottom Navigation",'ioa'),
						"desc" => "",
						"id" => $shortname."_single_portfolio_nav",
						"type" => "toggle",
						"std" => "true"
					  );	

$ioa_options[]   = array("type"=>"close_subtitle");


/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Portfolio Post Type",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"ppostype"
					 );


$ioa_options[]   = 	array( 
						"name" => __("Enter Portfolio Post Name",'ioa'),
						"desc" => "",
						"id" => $shortname."_portfolio_label",
						"type" => "text",
						"std" => "Portfolio"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Enter Portfolio Post Slug( ex : www.yoursite/<strong>portfolio</strong>/item , only letters and numbers allowed )",'ioa'),
						"desc" => "",
						"id" => $shortname."_portfolio_slug",
						"type" => "text",
						"std" => "portfolio"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Enter Portfolio Post Category(Taxonomy)",'ioa'),
						"desc" => "",
						"id" => $shortname."_portfolio_taxonomy",
						"type" => "text",
						"std" => "Portfolio Categories"
					  );

$ioa_options[]   = array("type"=>"close_subtitle");
$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Portfolio Panel Ends ============================================================== */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Blog & Posts Panel ================================================================ */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Blog Posts",'ioa'),
	  	           "type" => "section" , "icon" => "newspaper"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open", "tabs" => array(__("Blog Template Settings",'ioa'),__("Single Post Settings",'ioa'),__("Blog Templates Post Height",'ioa')));

		  

	
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Blog Template Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"bloglayout"
					 );


$ioa_options[]   = 	array( 
						"name" => __("Blog Parent Link for Breadcrumb",'ioa'),
						"desc" => "",
						"id" => $shortname."_blog_parent_link",
						"type" => "text",
						"std" => ""
					  );

$ioa_options[]   = 	array( 
						"name" => __("Blog Parent label for Breadcrumb",'ioa'),
						"desc" => "",
						"id" => $shortname."_blog_label",
						"type" => "text",
						"std" => "Blog"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Use Wordpress Excerpt",'ioa'),
						"desc" => "Enable/Disable excerpt for blog posts, by default it uses framework's content limiter.",
						"id" => $shortname."_blog_excerpt",
						"type" => "toggle",
						"std" => "true"
					  );	


$ioa_options[]   = 	array( 
						"name" => __("Use Lightbox on posts thumbnail",'ioa'),
						"desc" => "Enable/Disable lightbox on posts thumbnail, if false it will point to the post.",
						"id" => $shortname."_enable_thumbnail",
						"type" => "toggle",
						"std" => "true"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Continue Button Label",'ioa'),
						"desc" => "Enter the label for continue button.",
						"id" => $shortname."_more_label",
						"type" => "text",
						"std" => "more"
					  );
					  
$ioa_options[] = array(
                  "name"=>__("Blog Posts Items Limit",'ioa'),
			      "desc"=>"set your items per page limit here",
				   "id" => $shortname."_posts_item_limit",
				   "type"=>"slider",
				   "max"=>50,
				   "std"=>6,
				   "suffix"=>"Items");						  					  

$ioa_options[]   = array( 
				  "name" => __("Blog Filter Style",'ioa'),
				  "desc" => "select the reveal style for dropdowns.",
				  "id" => $shortname."_blog_fitler_style",
				  "type" => "select",
				  "options" => array("open"=>__("Open",'ioa'),"dropdown"=>__("Dropdown",'ioa')),
				  "std" => "dropdown"
				 );												   
				   
$ioa_options[] = array(
                  "name"=>__("Excerpt text Limit",'ioa'),
			      "desc"=>"set your no of characters for excerpt here. Works Only When wordpress excerpt is disabled",
				   "id" => $shortname."_posts_excerpt_limit",
				   "type"=>"slider",
				   "max"=>500,
				   "std"=>300,
				   "suffix"=>"letters");


$ioa_options[]   = 	array( 
						"name" => __("Show/Hide posts extra information",'ioa'),
						"desc" => "Enable/Disable lightbox on posts thumbnail, if false it will point to the post.",
						"id" => $shortname."_blog_meta_enable",
						"type" => "toggle",
						"std" => "true"
					  );

					  
					  					  
$ioa_options[]   = 	array( 
						"name" => __("Post Metabar ( Extra information that appears below title)",'ioa'),
						"desc" => "You can set the extra infor for posts in blog template here. Available shortcodes <br/><strong>[post_categories]</strong> - List of categories
<strong>[post_tags]</strong> - List of post tags</br>
<strong>[post_comments]</strong> - Link to post comments</br>
<strong>[post_author_posts_link]</strong> - Author and link to archive</br>
<strong>[post_time]</strong> - Time of post</br>
<strong>[post_date]</strong> - Date of post</br>",
						"id" => $shortname."_blog_meta",
						"type" => "textarea",
						"std" => "By [post_author_posts_link] On [post_date] &middot; [post_comments] &middot; In [post_categories] ",
						"after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", 
						"buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>"
					  );


$ioa_options[]   = 	  array("type"=>"close_subtitle");

$ioa_options[]   = array(
				   "name" => __("Blog Templates Post Height",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"bloglayout"
					 );

$ioa_options[] = array(
                  "name"=>__("Blog Posts Classic Images/Video Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_bt1_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>360,
				   "suffix"=>"px");						  					  


$ioa_options[] = array(
                  "name"=>__("Blog Posts Thumbnail List Images/Video Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_bt2_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>220,
				   "suffix"=>"px");	

$ioa_options[] = array(
                  "name"=>__("Blog Posts Grid Images/Video Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_bt3_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>280,
				   "suffix"=>"px");	

$ioa_options[] = array(
                  "name"=>__("Blog Posts Grid Images/Video Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_bt4_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>360,
				   "suffix"=>"px");	

$ioa_options[] = array(
                  "name"=>__("Blog Posts Featured Posts Images/Video Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_bt5_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>360,
				   "suffix"=>"px");

$ioa_options[] = array(
                  "name"=>__("Blog Posts Full Posts Images/Video Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_bt6_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>360,
				   "suffix"=>"px");

$ioa_options[] = array(
                  "name"=>__("Blog Posts Full Posts 2 Images/Video Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_bt7_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>450,
				   "suffix"=>"px");

$ioa_options[] = array(
                  "name"=>__("Blog Posts Timeline Images/Video Height",'ioa'),
			      "desc"=>"",
				   "id" => $shortname."_bt8_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>230,
				   "suffix"=>"px");

$ioa_options[]   = 	  array("type"=>"close_subtitle");
/* == Sub Panel Ends =================================================================== */
	
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Single Post Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"postlayout"
					 );

$ioa_options[]   = 	array( 
						"name" => __("Show Featured Image",'ioa'),
						"desc" => "",
						"id" => $shortname."_featured_image",
						"type" => "toggle",
						"std" => "true"
					  );
					  
$ioa_options[]   = 	array( 
						"name" => __("Social Share Area",'ioa'),
						"desc" => "",
						"id" => $shortname."_social_share",
						"type" => "toggle",
						"std" => "true"
					  );	

$ioa_options[]   = 	array( 
						"name" => __("Face Book Comments",'ioa'),
						"desc" => "Show/Hide facebook comment .",
						"id" => $shortname."_fb_comments",
						"type" => "toggle",
						"std" => "true"
					  );					  					  	
$ioa_options[]   = 	array( 
						"name" => __("Show Author BIO",'ioa'),
						"desc" => "Don't you need an Author Bio then just disbale it here.",
						"id" => $shortname."_author_bio",
						"type" => "toggle",
						"std" => "true"
					  );

$ioa_options[]   = array( 
				  "name" => __("Enter Related Posts Title",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_related_posts_title",
				  "type" => "text",
				  "std" => ""
				  
				   );
				   					
$ioa_options[]   = 	array( 
						"name" => __("Show Related Posts",'ioa'),
						"desc" => "Want to show your related posts? Then enable them here.",
						"id" => $shortname."_popular",
						"type" => "toggle",
						"std" => "true"
					  );

					  
$ioa_options[]   = 	array( 
						"name" => __("Single Post Metabar ( Extra information that appears below title)",'ioa'),
						"desc" => "You can set the extra infor for posts in blog template here. Available shortcodes <br/><strong>[post_categories]</strong> - List of categories
<strong>[post_tags]</strong> - List of post tags</br>
<strong>[post_comments]</strong> - Link to post comments</br>
<strong>[post_author_posts_link]</strong> - Author and link to archive</br>
<strong>[post_time]</strong> - Time of post</br>
<strong>[post_date]</strong> - Date of post</br>",
						"id" => $shortname."_single_meta",
						"type" => "textarea",
						"std" => "By [post_author_posts_link] On [post_date] &middot; [post_comments] &middot; In [post_categories] ",
						"after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", 
						"buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>"
					  );	
					  								  	
$ioa_options[]   = 	  array("type"=>"close_subtitle");

/* == Sub Panel Ends =================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Blog & Posts Panel Ends =========================================================== */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Contact =========================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Contact",'ioa'), "icon" => "mail",
	  	           "type" => "section"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open", "tabs" => array(__("Google Map",'ioa'),__("Sticky Contact",'ioa')));

		  
		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Google Map",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"cnt"
					 );

$ioa_options[]   =  array( 
				  "name" => __("Use Address or Coorinates for Google Map",'ioa'),
				  "desc" => "Enable/ Disable",
				  "id" => $shortname."_google_track",
				  "type" => "select",
				  "std" => "addr",
				  "options" => array(  "addr" => "Address" , "coor" => "Coordinates" )
					);	



$ioa_options[]   =	array( 
						"name" => __("Enter Address to show in Google Map",'ioa'),
						"desc" => "enter your address here it will appear on google map.",
						"id" => $shortname."_address",
						"type" => "textarea",
						"std" => ""
						);	

$ioa_options[]   =	array( 
						"name" => __("Enter Address for Contact Template Address Area(html supported)",'ioa'),
						"desc" => "enter your address here it will appear on google map.",
						"id" => $shortname."_prop_address",
						"type" => "textarea",
						"std" => ""
						);													


$ioa_options[]   =	array( 
						"name" => __("Enter Latitude(1st coordinate)",'ioa'),
						"desc" => "enter your address here it will appear on google map.",
						"id" => $shortname."_glat",
						"type" => "text",
						"std" => ""
						);	
$ioa_options[]   =	array( 
						"name" => __("Enter Longitude(2nd coordinate)",'ioa'),
						"desc" => "enter your address here it will appear on google map.",
						"id" => $shortname."_glong",
						"type" => "text",
						"std" => ""
						);	


$ioa_options[]   = array(
                  "name"=> __("Set Zoom Level",'ioa'),
			      "desc"=>"Zoom in/out google map. 0 minimum zoom and  16 maximum zoom",
			      "id" => $shortname."_map_zoom",
				  "type"=>"slider",
				  "max"=>16,
				  "std"=>2,
				  "suffix"=>""
					 );


$ioa_options[]   = array(
                  "name"=> __("Set Map Hue",'ioa'),
			      "desc"=>"",
			      "id" => $shortname."_map_color",
				  "type"=>"colorpicker",
				  "alpha" => false ,
				  "value"=>"#444444 <<", 
					 );

				  										
$ioa_options[]   = array("type"=>"close_subtitle");


/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Sticky Contact",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"cnt"
					 );



$ioa_options[]   =  array( 
				  "name" => __("Show/Hide Sticky Contact",'ioa'),
				  "desc" => "Enable/ Disable",
				  "id" => $shortname."_sc_enable",
				  "type" => "toggle",
				  "std" => "true"
					);	
											 

$ioa_options[]   =	array( 
						"name" => __("Enter Text for top area of contact form ",'ioa'),
						"desc" => "enter your address here it will appear on google map.",
						"id" => $shortname."_sc_message",
						"type" => "textarea",
						"std" => " We usually reply with 24 hours except for weekends. All emails are kept confidential and we do not spam in any ways. "
						);	
										

$ioa_options[]   =	array( 
						"name" => __("Enter Text on successful message sent.",'ioa'),
						"desc" => "enter your address here it will appear on google map.",
						"id" => $shortname."_sc_sucess_message",
						"type" => "textarea",
						"std" => " Thank you for contacting us :)"
						);	

$ioa_options[]   =	array( 
						"name" => __("Enter email where messages should be sent.",'ioa'),
						"desc" => "enter your address here it will appear on google map.",
						"id" => $shortname."_sc_nemail",
						"type" => "text",
						"std" => ""
						);			  										
$ioa_options[]   = array("type"=>"close_subtitle");

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Contact Panel Ends ================================================================ */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Forums Panel ====================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("BBPress",'ioa'),
	  	           "type" => "section" , "icon" => "text-doc"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array(   __("Sidebars",'ioa')  ));

	

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Sidebars",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 

$ioa_options[]   = array( 
				  "name" => __("BBPress Forums Sidebar",'ioa'),
				  "desc" => __("Select Sidebar for forums page",'ioa'),
				  "id" => SN."_bbpress_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Default Sidebar"
				 );



$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */


$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Forums Ends ================================================================= */
/* ====================================================================================== */

/* ====================================================================================== */
/* == Woo Commerce ========================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("WOO Commerce",'ioa'),
	  	           "type" => "section" 
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" ,"tabs" => array(__("General",'ioa')) );


		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("General",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 

$ioa_options[]   = array( 
				  "name" => __("Product Category Sidebar",'ioa'),
				  "desc" => "",
				  "id" => SN."_woo_category_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );


$ioa_options[]   = array( 
				  "name" => __("Product Category Page Layout",'ioa'),
				  "desc" => "",
				  "id" => SN."_woo_category_layout",
				  "type" => "select",
				  "options" => array("right-sidebar" => "Right Sidebar" , "left-sidebar" => "Left Sidebar" ),
				  "std" => "right-sidebar"
				 );


$ioa_options[]   = array( 
				  "name" => __("Product Tag Sidebar",'ioa'),
				  "desc" => "",
				  "id" => SN."_woo_tag_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );


$ioa_options[]   = array( 
				  "name" => __("Product Tag Page Layout",'ioa'),
				  "desc" => "",
				  "id" => SN."_woo_tag_layout",
				  "type" => "select",
				  "options" => array("right-sidebar" => "Right Sidebar" , "left-sidebar" => "Left Sidebar" ),
				  "std" => "right-sidebar"
				  );

$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Personalize Panel Ends =============================================================== */
/* ====================================================================================== */

/* ====================================================================================== */
/* == Advanced ========================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Advanced",'ioa'),
	  	           "type" => "section" , "icon" => "rocket"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" ,"tabs" => array(__("Auto Update",'ioa'),__("Admin Settings",'ioa'),__("404 Not Found",'ioa'),__("Under Construction",'ioa'),__("Misc",'ioa')) );


		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Auto Update",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 

$ioa_options[]   =	array( 
						"name" => __("Enter Your Themeforest Username",'ioa'),
						"desc" => "Add your 404 text here.",
						"id" => $shortname."_en_username",
						"type" => "text",
						"std" => ""
						);		

$ioa_options[]   =	array( 
						"name" => __("Enter Your API Key, you can find that by going to settings page on your themeforest account. Click on API keys from bottom left.",'ioa'),
						"desc" => "Add your 404 text here.",
						"id" => $shortname."_en_key",
						"type" => "text",
						"std" => ""
						);		
				  										
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Admin Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );

$ioa_options[]   = array( 
				  "name" => __("Hide Demo Install Panel and Top Menu",'ioa'),
				  "desc" => __("Setting to Yes will hide the installer.",'ioa'),
				  "id" => SN."_hide_installer",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "No"
				   );	

					 
$ioa_options[]   = array( 
				  "name" => __("Admin Login Logo Enable",'ioa'),
				  "desc" => "Show/Hide admin logo .",
				  "id" => $shortname."_enable_admin_logo",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "No"
				   );	

												
$ioa_options[]   = array(
                  "name" => __("Admin Login Logo Upload",'ioa'),
				  "desc" => "upload your wp admin logo here.",
				  "id" => $shortname."_admin_logo",
				  "type" => "upload",
				  "std" => ""	,
				  "button" => "Add Logo", 
				  "title" => "Add Logo"	  
				  );

$ioa_options[]   =	array( 
						"name" => __("Google Page Speed API KEY",'ioa'),
						"desc" => "",
						"id" => $shortname."_page_speed_key",
						"type" => "text",
						"std" => ""
						);		


$ioa_options[]   =	array( 
						"name" => __("Show Default Dashboard Widgets",'ioa'),
						"desc" => "",
						"id" => $shortname."_def_dbwidgets",
						"type" => "toggle",
				  		"std" => "true"
						);	
				  										
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */
	
$ioa_options[]   =  array(
						"name" => __("404 Not Found",'ioa') , 
						"type"=>"subtitle" , 
						"id"=>"notfound"
						);	
$ioa_options[]   =	array( 
						"name" => __("404 page title here",'ioa'),
						"desc" => "Add your 404 text here.",
						"id" => $shortname."_notfound_title",
						"type" => "text",
						"std" => ""
						);		

$ioa_options[]   = array(
                  "name"=> __("Set Animating Clouds Color",'ioa'),
			      "desc"=>"",
			      "id" => $shortname."_uc_cloudscolor",
				  "type"=>"colorpicker",
				  "alpha" => false ,
				  "value"=>"#50abbe", 
					 );


					
$ioa_options[]   =	array( 
						"name" => __("404 image URL",'ioa'),
						"desc" => "Upload your 404 image.  ",
						"id" => $shortname."_notfound_logo",
						"type" => "upload",
						"std" => URL."/sprites/i/notfound.png",
						"button" => "Add" , "label" => "Add Image" ,"title" => "Add"
					);	
				
	
$ioa_options[]   =	array( 
						"name" => __("404 page text here",'ioa'),
						"desc" => "Add your 404 text here.",
						"id" => $shortname."_notfound_text",
						"type" => "textarea",
						"std" => ""
						);		
                
$ioa_options[]   =	array("type"=>"close_subtitle");
/* == Sub Panel Ends ===================================================================== */



/* == Sub Panel Ends ===================================================================== */
	
$ioa_options[]   =  array(
						"name" => __("Under Construction",'ioa') , 
						"type"=>"subtitle" , 
						"id"=>"ucm"
						);	
$ioa_options[]   =	array( 
						"name" => __("Title here",'ioa'),
						"desc" => "Add your text here.",
						"id" => $shortname."_uc_title",
						"type" => "text",
						"std" => ""
						);		
		
$ioa_options[]   = array(
                  "name"=> __("Set Radial Bar Color",'ioa'),
			      "desc"=>"",
			      "id" => $shortname."_uc_barcolor",
				  "type"=>"colorpicker",
				  "alpha" => false ,
				  "value"=>"#444444", 
					 );

		


$ioa_options[]   =  array( 
				  "name" => __("Under Construction Mode",'ioa'),
				  "desc" => "Enable/ Disable",
				  "id" => $shortname."_uc_mode",
				  "type" => "toggle",
				  "std" => "false"
					);	

$ioa_options[]   =  array( 
				  "name" => __("Animate Background",'ioa'),
				  "desc" => "",
				  "id" => $shortname."_uc_bg_animate",
				  "type" => "toggle",
				  "std" => "true"
					);	

$ioa_options[]   =	array( 
						"name" => __("Text here",'ioa'),
						"desc" => "Add your text here.",
						"id" => $shortname."_uc_text",
						"type" => "textarea",
						"std" => ""
						);		

$ioa_options[]   =	array( 
						"name" => __("Background Image",'ioa'),
						"desc" => "",
						"id" => $shortname."_uc_bg",
						"type" => "upload",
						"std" => "",
						"button" => "Add" , "label" => "Add Background Image" ,"title" => "Add Background Image"
					);	

$ioa_options[]   = array(
                  "name"=> __("Set Progress",'ioa'),
			      "desc"=>".",
			      "id" => $shortname."_uc_progress",
				  "type"=>"slider",
				  "max"=>100,
				  "std"=>60,
				  "suffix"=>"%"
					 );
                
$ioa_options[]   =	array("type"=>"close_subtitle");
/* == Sub Panel Ends ===================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Advanced Panel Ends =============================================================== */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Personalize ========================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Personalize",'ioa'),
	  	           "type" => "section" 
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" ,"tabs" => array(__("General",'ioa')) );


		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("General",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 


$ioa_options[]   = 	array( 
						"name" => __("Show Company Branding",'ioa'),
						"desc" => "",
						"id" => $shortname."_cbrand_toggle",
						"type" => "toggle",
						"std" => "false"
					  );	

$ioa_options[]   =	array( 
						"name" => __("Set Company Logo",'ioa'),
						"id" => $shortname."_cbrand_logo",
						"type" => "upload",
						"std" => URL."/sprites/i/logo.png",
						"button" => "Add Logo" , "title" => "Add"
						);	

$ioa_options[]   =	array( 
						"name" => __("Set Text",'ioa'),
						"id" => $shortname."_cbrand_text",
						"type" => "text",
						"std" => " Theme Admin "
						);	

$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Personalize Panel Ends =============================================================== */
/* ====================================================================================== */

