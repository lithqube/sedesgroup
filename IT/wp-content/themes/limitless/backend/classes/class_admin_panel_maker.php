<?php
/**
 *  Base Class for creating admin panels.
 *  Version : 3.1
 *  Dependency : None
 */

$ioa_page_get = '';

if(isset($_GET['page']))
$ioa_page_get =  $_GET['page']; // In class scope it points to Inherited class


if(!class_exists('IOA_PANEL_CORE')) {

// == Class defination begins	=====================================================
  
  class IOA_PANEL_CORE {
	  
	  private $name;
	  private $panelName;
	  private $type;
	  private $icon;
	  private $role;

	  private $tabs;

	  private $topBar = true;
	  private $isCustom = false;
	 /**
	  *  Constrtuctor For Admin Maker 
	  *  @param string $name The Name of the Panel that will Appear in WP ADMIN side menu
	  *  @param string $type Type of Menu Defautl Page(Separate Menu) , supported values are page and submenu
	  *  @param string $panel_name	unique key name for panel( ex : admin.php?page=ULT ). Defaults to first 5 letters in capital.
	  *  @param string $icon The link to icon , set to false to use wp default icon. 
	  *  @param string $role The role/level required to access the panel. 
	  */
	 
      function __construct($name,$type='page',$panel_name=false, $icon = false,$role = 'edit_theme_options') { 
	  
		$this->name = $name;
		$this->tabs = array();
		if(!$panel_name)
			$this->panelName = strtolower(substr($name,0,5));
		else
			$this->panelName = 	$panel_name;
		
		$this->type = $type;
		
		if(!$icon)
			$this->icon  = HURL."/css/i/icon.png";
		else
			$this->icon = $icon;
		
		$this->role= $role;

		add_action('admin_menu',array(&$this,'manager_admin_menu'));
        add_action('admin_init',array(&$this,'manager_admin_init'));
		
	  }

	  function disableTopBar()
	  {
	  	$this->topBar = false;
	  }
	  
	  function isCustomPanel($bool)
	  {
	  	$this->isCustom = $bool;
	  }
	  function manager_admin_menu(){
		
		  
	   	switch($this->type)
	   	{
		   case 'page' : add_menu_page( $this->name,  $this->name , $this->role, $this->panelName ,array($this,'manager_admin_wrap'),  $this->icon);  break;
		   case 'submenu':  add_submenu_page("ioa", $this->name, $this->name, $this->role, $this->panelName ,array($this,'manager_admin_wrap')); break;
		   case 'null':  add_submenu_page(null, $this->name, $this->name, $this->role, $this->panelName ,array($this,'manager_admin_wrap')); break;
	   	}
		  
				  
	  }
		  
	  function manager_admin_init(){	
	 	 
	  
	    }	
	  
	  function panelmarkup() { }

	  function manager_admin_wrap(){	
            global $ioa_page_get,$super_options;
            ?>
			
            <div class="ioa_wrap">
            
            <div class="panel-top-bar clearfix">
	  				<ul class="main-menu clearfix">
	  					<li class="clearfix <?php if($ioa_page_get=="ioa") echo 'active'; ?>"><a class="" href="<?php echo admin_url()."admin.php?page=ioa"; ?>"><?php _e('Theme Admin','ioa') ?></a> </li>
	  					<li class="clearfix <?php if($ioa_page_get=="hcons") echo 'active'; ?>"><a class="" href="<?php echo admin_url()."admin.php?page=hcons"; ?>"><?php _e('Head Builder','ioa') ?></a></li>
	  					<li class="clearfix <?php if($ioa_page_get=="ioamed") echo 'active'; ?>"><a class="" href="<?php echo admin_url()."admin.php?page=ioamed"; ?>"> <?php _e('Slider Manager','ioa') ?></a></li>
	  					<li class="clearfix <?php if($ioa_page_get=="ioapty") echo 'active'; ?>"><a class="" href="<?php echo admin_url()."admin.php?page=ioapty"; ?>"><?php _e('Custom Post Types','ioa') ?></a></li>
	  					
						<?php    if($super_options[SN.'_hide_installer']!='Yes') : ?>
	  					<li class="clearfix <?php if($ioa_page_get=="instl") echo 'active'; ?>"><a class="" href="<?php echo admin_url()."admin.php?page=instl"; ?>"><?php _e('Installer','ioa') ?></a></li>
						<?php endif; ?>
						
	  				</ul>
			
	  			</div> <!-- End of Top bar-->

				<div class="clearfix <?php if(!$this->isCustom) echo 'ioa_admin_panel'; ?>"> 
            		<?php $this->panelmarkup() ; ?>
            	</div>
			</div> <!-- End of Framework Panel -->
            <?php

	   }	  
	  
	 
 	} // == End of Class ==========================
     
	 
	
}
