<?php
/**
 *  Name - Dummy panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Nobody
 */
if(!is_admin()) return;

class IOAUserRoles extends IOA_PANEL_CORE {
	

	
	// init menu
	function __construct () { parent::__construct( __('User Roles','ioa'),'null','ioarols');  }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	  }	
	
	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){	
		
		
		

		?>
		<div class="ioa_panel_wrap" data-url="<?php echo admin_url()."admin.php?page=ioarols"; ?>"> <!-- Panel Wrapper -->
			<div class=" clearfix">  <!-- Panel -->

		<table class="ioa_user_roles">
			
		</table>
  <?php  $blogusers = get_users();
    foreach ($blogusers as $user) {
        echo '<li>' . $user->user_nicename . '</li>';
    } ?>
	
		</div>
	</div>
		<?php

	    
	 }
	 

}

new IOAUserRoles();