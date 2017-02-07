<?php
/**
 * Main Function For Initiating RAD Builders
 */

// Init Page Builder

require_once('rad_builder/class_rad_helper.php');
require_once('rad_builder/rad_ajax.php');
require_once('rad_builder/class_radmarkup.php');
require_once('rad_builder/class_radstyler.php');
require_once('rad_builder/class_radpagebuilder.php');


function registerRADPageBuilderScripts() {
			
			wp_enqueue_style('rad-page-builder-css',HURL.'/css/rad_page_builder.css');
			wp_enqueue_script('rad-page-builder-js',HURL.'/js/rad_page_builder.js');
		
		
}
add_action('admin_enqueue_scripts','registerRADPageBuilderScripts');	 



