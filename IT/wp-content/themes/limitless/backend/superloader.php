<?php
/**
 * Core Class That inits all backend functions.
 */

// Define Variables and constants common to the Framework

$themename = 'Limitless';
$shortname = "IOAR";
define('SN',$shortname);
define('THEMENAME',$themename);
define('RAD_Version',3.22);

$ioa_options = array();  // Options array
$super_options = array(); // precaching of get options variables.
$radunits = array(); // RAD Builder Registerd components stored here
$insta_units = array(); // RAD Builder Registerd components stored here
$ioa_sliders = array(); //  Registerd Sliders components stored here
$ioa_custom_posts = array(); $registered_posts = array(); // Custom Posts Vaules holder & Registered post types 
$IOA_templates = array(); // templates of the theme
$ioa_meta_data = array(); // Current posts framework values stored here.
$ioa_shortcodes_array = array(); // IOA Shortcodes
$ioa_sidebars = array("Blog Sidebar"); 
$rad_flag = false;
$enigma_runtime = null;
$ioa_portfolio_name = "Portfolio";
$ioa_portfolio_slug = 'portfolio';
$portfolio_taxonomy_label = 'Portfolio Categories' ;
$portfolio_taxonomy = 'portfoliocategories' ;
$IOAHeader = null;

$ioa_woo = false;

if ( class_exists( 'woocommerce' ) ) { $ioa_woo =  true; } 

define('IOA_WOO_EXISTS',$ioa_woo);

/**
 * Global variable for fonts list.
 * @var array
 */
$or_google_webfonts =  array("Abel","Abril Fatface","ABeeZee","Aclonica","Acme","Alice","Allan","Allerta","Allerta Stencil","Alike","Amaranth","Andada","Anonymous Pro","Anton","Antic","Antic Slab","Arimo","Artifika","Arvo","Averia Sans Libre","Aguafina Script","Bentham","Bevan","Belleza","Brawler","Bree Serif","Cabin","Cardo","Cousine","Cabin","Copse","Cinzel","Crimson Text","Capriola","Cuprum","Cantarell","Coustard","Courgette","Condiment","Dancing Script","Damion","Droid Serif","Droid Sans Mono","Droid Sans","Dosis","Dorsa","Domine","Engagement","Esteban","Exo","Englebert","Francois One","Fugaz One","Forum","Habibi","Karla","Kreon","Kaushan Script","Gruppo","Gochi Hand","Inconsolata","Imprima","Libre Baskerville", "Lobster","Lobster Two","Lato","Iceland","Inder","Josefin Slab","Julius Sans One","Josefin Sans","Kavoon","Marvel","Mate","Marck Script","Maiden Orange","Maven Pro","Monda","Merriweather","Merriweather Sans","Merienda One","Montez","News Cycle","Nixie One","Nova Round","Nova Script","Nova Slim","Nobile","Open Sans","Open Sans Condensed","Oleo Script","Oswald","Overlock","Old Standard TT","Oxygen","Orienta","Ovo","PT Sans Narrow","Playfair Display","Playball","PT Sans","PT Serif","Pacifico","Philosopher","Questrial","Quicksand","Russo One","Racing Sans One","Raleway","Rambla","Rosario","Rokkitt","Roboto","Romanesco","Sanchez","Satisfy","Shanti","Source Sans Pro","Petit Formal Script","Tangerine","Terminal Dosis Light","Terminal Dosis","Tenor Sans","Text Me One","Tienne","Tinos","Titillium Web","Trykker","Trocchi","Ubuntu","Ubuntu Condensed","Vollkorn","Wendy One","Yanone Kaffeesatz","Yellowtail");
$websafe_fonts = array("None", "Arial","Helvetica Neue","Helvetica",'Tahoma',"Verdana","Lucida Grande","Lucida Sans");
$google_webfonts = array_merge($websafe_fonts,$or_google_webfonts);

		
require_once('ioa_actions.php'); // This needs to be first

/**
 *  Base Class for creating Admin panels ~~ By Default Sub menus are added to Options Panel.
 */
require_once('classes/class_admin_panel_maker.php');   
require_once(HPATH.'/classes/class_options.php');
require_once(HPATH.'/classes/class_slider.php');
require_once(HPATH.'/classes/class_font_support.php');
require_once(HPATH.'/classes/class_custom_posts.php');
require_once(HPATH.'/classes/class_custom_posts_maker.php');
require_once(HPATH.'/classes/class_pagination.php');
require_once(HPATH.'/classes/hypermenu.php'); // Hyper Menu 



/**
 * Input Generator for Framework
 */

require_once('classes/ui.php');   	
require_once('classes/class_metabox.php');

/**
 *  Helper file
 */

require_once('runtime_css.php');
require_once('helper.php');

/**
 * Rad Unit Class needs to be after helper
 */
require_once(HPATH.'/classes/class_radunit.php');

/**
 *  Options & Options Panel
 */



require_once('options_panel.php'); 


/**
 *  Header Constructor Panel
 */


require_once('home_page_panel.php'); 


/**
 *  Media Manager
 */


require_once('media_manager.php'); 

/**
 *  User Manager
 */


require_once('user_roles.php'); 


/**
 *  Custom Posts Manager
 */


require_once('customposts_manager.php'); 

/**
 *  Installer Manager
 */

require_once('installer.php'); 


/**
 *  Update
 */
$ioa_upgrader = null;
if(get_option(SN.'_en_key')) :

	require_once(HPATH.'/lib/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php'); 
	require_once('auto_update.php'); 

	$ioa_upgrader  = new Envato_WordPress_Theme_Upgrader( get_option(SN.'_en_username'), get_option(SN.'_en_key') ); 

endif;

/**
 *  Widgets
 */


require_once('theme_widgets.php'); 


/**
 *  Shortcodes
 */


require_once('shortcodes.php'); 

/**
 * Ajax Listener
 */

require_once('listener.php');   
   



/**
 * RAD Builder Init
 */

require_once('rad_builder/rad_shortcodes.php');   
require_once('rad_init.php');   
require_once('rad_live_init.php');   


/**
 * BBPress Support
 */

if( function_exists('is_bbpress') ) :
require_once(PATH.'/config/config-bbpress.php'); 
require_once(PATH.'/bbpress/bbpress-functions.php');
endif;
