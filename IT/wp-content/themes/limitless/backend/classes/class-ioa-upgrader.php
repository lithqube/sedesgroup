<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * IOA Framework Auto Upgrader.
 *
 * Class that handles auto updates for IOA Framework
 *
 * @class    IOA_Upgrader
 * @version  1.0.0
 * @package  Framework/Classes
 * @category Class
 * @author   Artillegence
 * @since    V6
 */


if(! class_exists('IOA_Upgrader')) {

    class IOA_Upgrader  {

        var $license = null;
        var $theme = '';
        var $version = '';
        var $endpoint = 'http://artillegence.com/apicheck';

        function __construct() {

         set_site_transient('update_themes', null);
         $current_theme  = wp_get_theme();
         $this->theme = strtolower($current_theme->get('Name'));
         $this->version = strtolower($current_theme->get('Version'));
         
         $params = array( 
                            'type' => 'web', 
                            'url' => $this->endpoint, 
                            'theme' => $this->theme, 
                            'title' => $this->theme );

         add_filter( 'pre_set_site_transient_update_themes', array(&$this, 'check_for_update') );
         add_filter( 'upgrader_pre_install', array(&$this, 'create_backup') );

         $this->addDashboardCheck();

        }

        function create_backup($theme) {
            global $wp_filesystem;
            $folder = get_template_directory();
            
            if( $this->initialize_wpfilesystem() ) {

                $wp_filesystem->mkdir(ABSPATH . '/wp-content/ioa-backups/');
                $this->recurse_copy($folder,ABSPATH . '/wp-content/ioa-backups/limitless-v-'.$this->version);
            }
            

        }

        function recurse_copy($src,$dst) { 
                global $wp_filesystem;
                $dir = opendir($src); 
                $wp_filesystem->mkdir($dst); 
                while(false !== ( $file = readdir($dir)) ) { 
                    if (( $file != '.' ) && ( $file != '..' )) { 
                        if ( is_dir($src . '/' . $file) ) { 
                            $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
                        } 
                        else { 
                            copy($src . '/' . $file,$dst . '/' . $file); 
                        } 
                    } 
                } 
                closedir($dir); 
            } 

        function check_for_update( $transient ) {
           
           if (empty($transient->checked)) return $transient;
            
          
            $raw_response = wp_remote_post( $this->endpoint, $this->prepare_request( array('theme' => $this->theme) ) );
            $response = null;
            
         

             if( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) ) {
                  $response = json_decode($raw_response['body'],true);
             }
              
            
            if( !empty($response) ) // Feed the update data into WP updater
                $transient->response[$this->theme] = $response;

          
            
            return $transient;
        }

        function prepare_request(  $args ) {
            global $wp_version;
            
            return array(
                'body' => array(
                    'request' => serialize($args),
                ),
                'user-agent' => 'WordPress/'. $wp_version .'; '. esc_url(home_url('/'))
            );  
        }

        function initialize_wpfilesystem() {

                 global $wp_filesystem;

                   $access_type = get_filesystem_method();
                 
                   if($access_type=="direct") {

                    $creds = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, array());

                    /* initialize the API */
                    if ( ! WP_Filesystem($creds) ) {
                            /* any problems and we exit */
                            return false;
                        } else
                        {
                            return true;
                        }
                        

                   }

            }
        
        function addDashboardCheck() {

               add_action('wp_dashboard_setup', 'IOA_addAutoUpdateWidget' );

                function IOA_addAutoUpdateWidget() {
                    add_meta_box('ioa_wpauto_widget', esc_html__('Auto Update','wakana'), 'ioa_wpauto_widget', 'dashboard', 'side', 'high');
                }
                function ioa_wpauto_widget() {
                   
                   $val = '';

                   if(isset($_POST['ioa_theme_license'])) {
                        update_option('ioa_theme_license',$_POST['ioa_theme_license']);
                   }

                   if(get_option('ioa_theme_license'))
                    $val = get_option('ioa_theme_license');
                  ?>
                  <div class="full ioa-ajax-save clearfix" data-type='save-ajax'>
                     <form action="" method="post">
                         <?php if(get_option('ioa_enable_auto_update')) : ?> <p class='ioa-information-p'> <i class="material-icons">&#xE877;</i> <?php esc_html_e('Auto Update is enabled on the site','wakana') ?></p> <?php endif; ?>
                        
                        <div class="ioa_input">
                            <label for="ioa_theme_license">Enter Theme Purchase Code
                                <span>To enable auto updates, enter your theme purchase code here.</span>
                            </label>
                            <input type="text" name="ioa_theme_license" id="ioa_theme_license" value="<?php echo $val; ?>" placeholder="">
                        </div>

                       <div class="clearfix" style="padding:20px">
                            <input type="submit" class="ioa-auto-update-save ioa-ajax-trigger button-save" value="Save" name="ioa_update_action">  
                       </div>

                     </form>
                  </div>
                  <?php
                }


        }

    }


}

$theme = new IOA_Upgrader();


 ?>