<?php
/**
 *  Name - Header Construction panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Anthena
 */

if(!is_admin()) return;






class IOAUpdate extends IOA_PANEL_CORE {
	
	private $attach_ids = array();	

	
	// init menu
	function __construct () { parent::__construct( __('Updates','ioa'),'null','ioautoup');  }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	 

		

			
	}
	
	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){
		global $super_options,$ioa_upgrader;	
		
		$flag= false;
		


		?>

		 <div class="ioa_panel_wrap"> <!-- Panel Wrapper -->
		

        <div class=" clearfix">  <!-- Panel -->
        	<div id="option-panel-tabs" class="clearfix" data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
        
                <ul id="" class="ioa_sidenav clearfix">  <!-- Side Menu -->
                 
				 <li>
             		   <a href="#header_constructor" id="menu_header_constructor"> 
             		  		 <i class="entypo pencil"></i>
             		  		 <span><?php _e('Updates','ioa') ?></span>
             		   </a>
             		 </li>
                  
                </ul>  <!-- End of Side Menu -->
       			
                
                <div id="panel-wrapper" class="clearfix">
					
					<?php 

		    	if( isset($_GET['page']) && $_GET['page'] == "ioautoup" && isset($_GET['ioaupate']) )
				{
					
					$feedback = $ioa_upgrader->upgrade_theme();

					if(isset($feedback->success))
					{
						?><div class="installer-info">
									<?php _e('Update Successfully Installed','ioa') ?>
						</div><?php
						$flag = true;
					}

				}
				   

				    /*
				     *  Uncomment to check if the current theme has been updated
				     */
				    	$checker  =  $ioa_upgrader->check_for_theme_update();
					    if($checker->updated_themes_count > 0 && !$flag )
					    {
					    	?>
								<div class="installer-info">
									<?php _e('An update is available','ioa') ?>
								</div>

								<div class="pad-20">
									<h4>Backup Information</h4>
									<p>This will automatically save your theme as a ZIP archive before it does an upgrade. The directory those backups get saved to is <strong>wp-content/envato-backups</strong>. However, if you're experiencing problems while attempting to upgrade, it's likely to be a permissions issue and you may want to manually backup your theme before upgrading.
</p>								<a href="<?php echo admin_url()."admin.php?page=ioautoup&ioaupate=true"; ?>" class="button-save"> <?php _e("Click Here to Update",'ioa') ?></a>
								</div>

					    	<?php
					    } 
					    else
					    {
					    	?>
					    	<div class="installer-info">
									<?php _e('Your Theme is upto to date.','ioa') ?>
							</div>
					    	<?php
					    }

					?>	

					


					
   				</div>

   			</div>

   		</div>
	    <?php
	 }

	}
	
$i = new IOAUpdate();
