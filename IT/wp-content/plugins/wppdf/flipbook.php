<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              http://www.wppdf.org
 * @since             1.0.0
 * @package           wppdf
 *
 * @wordpress-plugin
 * Plugin Name:       WP PDF
 * Plugin URI:        www.wppdf.org
 * Description:       Host your PDF Publications using this wordpress plugin
 * Version:           1.0.0
 * Author:            wppdf.org
 * Author URI:        http://www.wppdf.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wppdf
 * Domain Path:       /languages
 */




$Flipbook_minimalRequiredPhpVersion = '5.0';

/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function Flipbook_noticePhpVersionWrong() {
    global $Flipbook_minimalRequiredPhpVersion;
    echo '<div class="updated fade">' .
      __('Error: plugin "Flipbook" requires a newer version of PHP to be running.',  'flipbook').
            '<br/>' . __('Minimal version of PHP required: ', 'flipbook') . '<strong>' . $Flipbook_minimalRequiredPhpVersion . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'flipbook') . '<strong>' . phpversion() . '</strong>' .
         '</div>';
}


function Flipbook_PhpVersionCheck() {
    global $Flipbook_minimalRequiredPhpVersion;
    if (version_compare(phpversion(), $Flipbook_minimalRequiredPhpVersion) < 0) {
        add_action('admin_notices', 'Flipbook_noticePhpVersionWrong');
        return false;
    }
    return true;
}


/**
 * Initialize internationalization (i18n) for this plugin.
 * References:
 *      http://codex.wordpress.org/I18n_for_WordPress_Developers
 *      http://www.wdmac.com/how-to-create-a-po-language-translation#more-631
 * @return void
 */
function Flipbook_i18n_init() {
    $pluginDir = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('flipbook', false, $pluginDir . '/languages/');
}


//////////////////////////////////
// Run initialization
/////////////////////////////////

// First initialize i18n
Flipbook_i18n_init();


// Next, run the version check.
// If it is successful, continue with initialization for this plugin
if (Flipbook_PhpVersionCheck()) {
    // Only load and run the init function if we know PHP version can parse it
    include_once('flipbook_init.php');
    Flipbook_init(__FILE__);
}
