<?php
/**
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */


/**
 *  Localization code
 */
load_theme_textdomain('ioa',get_template_directory() .'/language'); // Localization Support

$locale = get_locale();
$locale_file = get_template_directory() ."/language/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);

/**
 * Define Constants
 */
define('HPATH',get_template_directory() .'/backend');
define('HURL',get_template_directory_uri().'/backend');
define('PATH',get_template_directory() );
define('URL',get_template_directory_uri());
define('CHURL',get_stylesheet_directory_uri());

/**
 * Load the main file that initializes all core classes , panels and functions.
 */

require_once(HPATH.'/superloader.php');

