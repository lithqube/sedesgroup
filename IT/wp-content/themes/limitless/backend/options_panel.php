<?php
/**
 *  Name - Options Panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 */

if(!is_admin()) return;

class IOAOptionsPanel extends IOA_PANEL_CORE {
	

	
	// init menu
	function __construct () { parent::__construct( __('Theme Admin','ioa'),'page','ioa');  }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	
	   global $ioa_options , $super_options;
	   
	   wp_enqueue_script('jquery-ui-tabs');

	   if(isset($_GET['ioa_reset']))
	   	{
	   		setDemoOptions();
	   		
	   	}

		if(isset($_GET['ioa_export']))
		{
			

		   	$itheme = wp_get_theme();
			$name = strtolower($itheme->get('Name'))."_settings_".date('d_m_Y');

			header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($name.'.txt'));
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		   	

		    global $wpdb;
			$output = $wpdb->get_results("SELECT option_name,option_value FROM $wpdb->options WHERE option_name like '".SN."%'",ARRAY_A );
			$output = json_encode($output);
			$output = base64_encode($output);	
			echo $output;
		    exit;
		}

	   
	}
	
	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){	
		

		global $themename,  $ioa_options , $super_options;
		
		
	?>
    
	
    
    <div class="ioa_panel_wrap"> <!-- Panel Wrapper -->
		
		<span class="waiting"></span>
        <div class=" clearfix">  <!-- Panel -->
        	<div class="option-panel-top-bar clearfix">
        			<div class="ioa_branding_text">
						<?php 
							if(trim($super_options[SN.'_cbrand_text'])!="") 
								echo "<p id='cbrand_text'>".$super_options[SN.'_cbrand_text']."</p>"; 
								else echo "<p id='cbrand_text'>".'Theme Admin'."</p>";  ?>
        			</div>
        			<div class="option-panel-right-area clearfix">
				
	                	<div class="options-search-bar clearfix">
	        				<input type="text" id="options-search" placeholder="<?php _e('Search Option...') ?>" />
	        				<i class="ioa-front-icon ioa-search-icon search-2icon-"></i>
	        			</div>
	        			<div class="search-close-wrap clearfix">
	        				<a href="" class="close-options-search ioa-front-icon cancel-3icon-"></a>
	        			</div>
	        			
	        			<div class="button-panel clearfix">
	        				<input name='save' type='submit' value='<?php _e('Save Changes','ioa') ?>' class='button-save options-panel-save' />
	        				<div class="ioa-admin-menu-wrap clearfix">
	        					<a href="" class="ioa-admin-menu ioa-front-icon cog-2icon-"></a>
	        					<ul class="ioa-admin-submenu">
	        						<li><a href="<?php echo admin_url().'admin.php?page=ioa&ioa_reset=true' ?>"><?php _e('Reset','ioa') ?></a></li>
	        						<li><a href="" class='ioa-import-lightbox-trigger'><?php _e('Import Settings','ioa') ?></a></li>
	        						<li><a href="<?php echo admin_url()."admin.php?page=ioa"; ?>" class="export-options-panel-settings"><?php _e('Export Settings','ioa') ?></a></li>
	        					</ul>
	        				</div>
	        			</div>

	        		</div>		

        	</div>
        	<div id="option-panel-tabs" class="clearfix option-panel-tabs fullscreen"  data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
        		
        			


        		
                <div class="ioa_sidenav_wrap">
				<?php if($super_options[SN.'_cbrand_toggle'] == "true") : ?>
				
				<?php if($super_options[SN.'_cbrand_logo']!="") echo "<img id='cbrand_logo' src='".$super_options[SN.'_cbrand_logo']."' alt='admin-branding'/>" ?>		
				
				<?php endif; ?>
					
                <ul id="" class="ioa_sidenav clearfix">  <!-- Side Menu -->
                <?php
                
                foreach ($ioa_options as $value)
                {
               	 if($value['type']=="section") { ?>
               		 <li>
             		   <a class='clearfix' href="#<?php echo str_replace(" ","",$value['name']); ?>" id="menu_<?php echo str_replace(" ","",$value['name']); ?>"> 
             		  		 <i class="entypo <?php if(isset( $value['icon'] )) echo $value['icon']; else echo 'cd' ?>"></i>
             		  		 <span><?php echo $value['name']; ?></span>
             		   </a>
             		 </li>
                <?php  }  
                }
                ?>
                  
                </ul>  <!-- End of Side Menu -->
       			
       			</div>
                
                <div id="panel-wrapper" class="clearfix">
                <h2>Search Results</h2>
                <form method="post"  enctype="multipart/form-data" action="<?php echo admin_url().'admin.php?page=ioa'; ?>" class="clearfix" id="ioa_option_form" >
                
                  
                  
                <?php 
                	
               		 $newoptions  = $ioa_options; // php 4.4 fix
                	 $sidemenu_Flag = true; 
              	     foreach ($newoptions as $value) {
              			if(!isset($value['desc'])) $value['desc'] ='';
 			  		 switch ( $value['type'] ) {
               			   
			   			 case "open":$sidemenu_Flag = true;   
			   			 			$str = "<ul class='clearfix'>";
			   			 			foreach( $value['tabs']  as $tab)
								  	{
								  		$key = str_replace(" ","_",trim($tab));
								  		$str .= "<li><a href='#{$key}'>".$tab."</a><span class='tip'></span></li>";
								  	}
								  	$str .= "</ul> ";
								  	echo $str;
			   			            break; 
                		 case "close": $description = ''; ?> </div></div></div> <?php break;
						 case 'include' : include($value['std']); break;		 
                		 case 'custom' : echo ($value['std']);   break;	
                         case 'text':	echo getIOAInput( 
																array( 
																		"label" => $value['name'] , 
																		"name" => $value['id'], 
																		"default" => '', 
																		"type" => "text",
																		"description" => $value['desc'],
																		"length" => 'medium',
																		"value" => $super_options[$value['id']]  
																) 
															);
						break;
                
					 	case 'header_module' : $h = new IOAHeaderConstructor(); $h->getHeadBuilder(); break;
					 	case 'installer_module' : $i = new IOAInstaller(); $i->panelmarkup(); break;
                		case 'upload' :echo getIOAInput( 
																array( 
																		"label" => $value['name'] , 
																		"name" => $value['id'], 
																		"default" => '', 
																		"type" => "upload",
																		"description" => $value['desc'],
																		"length" => 'medium',
																		"value" => $super_options[$value['id']] , 
																		"button" => $value['button'] , 
																		"title" => $value['title'] , 
																		"class" => "has-input-button"
																) 
															); break;		 
                
				
						case 'colorpicker' : if(!isset($value['default']) ) $value['default'] = '';echo getIOAInput( 
																array( 
																		"label" => $value['name'] , 
																		"name" => $value['id'], 
																		"default" => $value['default'], 
																		"type" => "colorpicker",
																		"description" => $value['desc'],
																		"length" => 'medium',
																		"value" => $super_options[$value['id']]  
																) 
															); break;	
							 
               		   case 'slider': echo getIOAInput( 
															array( 
																	"label" => $value['name'] , 
																	"name" => $value['id'],
																	"value" => $super_options[$value['id']] ,
																	"max" => $value['max'] , 
																	"suffix" => $value['suffix'] , 
																	"default" =>  $value['std'] ,
																	"type" => "slider",
																	"steps" => 1,
																	"description" => $value['desc'],
																	"length" => 'medium'  
															) 
														); break;
                
					  case 'textarea':  
					  				$buttons = '';  $after_input = '';
					  				if(isset($value['after_input'])) $after_input = $value['after_input'];
					  				if(isset($value['buttons'])) $buttons = $value['buttons'];
					  					echo getIOAInput( 
																array( 
																		"label" => $value['name'] , 
																		"name" => $value['id'], 
																		"default" => '', 
																		"type" => "textarea",
																		"description" => $value['desc'],
																		"length" => 'medium',
																		"value" => $super_options[$value['id']] ,
																		"buttons" => $buttons,
																		"after_input" => $after_input 
																) 
															); break;
                
					  case 'select': 
					  				$opts = array( 
																	"label" => $value['name'] , 
																	"name" => $value['id'],
																	"default" => $value['std'] , 
																	"type" => "select",
																	"description" => $value['desc'],
																	"options" => $value['options']  ,
																	"value" =>  $super_options[$value['id']]  
															) ;
					  				if(isset($value['optgroup'])) $opts['optgroup'] = true;
					  				echo getIOAInput( $opts);
					  	 break;
                
				  
					  case "radio": 
                                echo getIOAInput( 
                                array( 
                                    "label" => $value['name'] , 
                                    "name" => $value['id'],
                                    "default" => $value['std'] , 
                                    "type" => "radio",
                                    "description" => $value['desc'],
                                    "options" => $value['options']  ,
                                    "value" =>  $super_options[$value['id']]  
                                ) 
                              );break; 
               
			   
					case "toggle":  echo getIOAInput( 
                                array( 
                                    "label" => $value['name'] , 
                                    "name" => $value['id'],
                                    "default" => $value['std'] , 
                                    "type" => "toggle",
                                    "description" => $value['desc'] ,
                                    "value" =>  $super_options[$value['id']]  
                                ) 
                              );break; 
                
                
                case "section":  ?>
              	  <div class="ioa_section" id="<?php echo str_replace(" ","",$value['name']); $section_name = str_replace(" ","",$value['name']); ?>" ><!-- Start of the section  -->
                  <div class="ioa_options"> <!-- Start of ioa option  --> <?php
                  
                   break;
               
			    case "information" : echo "<div class='subpanel clearfix'>"; ?>
                
                <?php
                break; 
                case "subtitle" : 		 
               		
               		 echo "<div class='ioa_subpanel' id=".trim(str_replace(" ","_",$value['name']))." ><div> "; 
                
				break;
                case "close_subtitle" :$sidemenu_Flag = false; ?> 
                
                <span class="ioa-top-panel clearfix">
               		 <input name="save" type="submit" value="<?php _e('Save changes','ioa'); ?>" class="button-save options-panel-save" />  
               		   <span class="ajax_icon"></span>
                </span> 
                
                <?php echo "</div></div>"; break;					
               	 }
                }
                ?>
               		 <input type="hidden" name="action" value="save" />
                      <input type="hidden" name="verfication" id="verficiation" value="<?php echo md5(THEMENAME); ?>" />
                </form>
                <form method="post" class="reset-form">
                	<input type="hidden" name="action" value="reset" />
                </form>
                
                </div>
       
        
   	    	</div>  <!-- End of Options Panel -->
        </div>  <!-- End of Panel -->
         
         
         
	</div> <!-- End of Panel Wrapper -->
		
		<div class="ioa-import-lightbox clearfix">
       	<div class="rad-l-body">	<?php 
       	// Import Lightbox
       	require_once HPATH."/adv_mods/importex.php";
       	 ?>
       	 </div>
       		 <a href="" class="button-save close-ioa-import-lightbox"><?php _e('Close','ioa') ?></a>
        </div>
    
	
	<?php

	    
	 }
	 

}

new IOAOptionsPanel();


