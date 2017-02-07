<?php
/**
 *  Name - Header Construction panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Anthena
 */

if(!is_admin()) return;

class IOAHeaderConstructor extends IOA_PANEL_CORE {
	

	
	// init menu
	function __construct () { parent::__construct( __('Head Constructor','ioa'),'submenu','hcons');  }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	 

		wp_enqueue_script('jquery-ui-draggble');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-droppable');
		
		if(isset($_GET['page']) && $_GET['page']=='hcons')
		{
			if(isset($_GET['resetheader']))
			{
				$header_data = "W1t7Im5hbWUiOiJUYWdsaW5lPGEgaHJlZj1cXFwiXFxcIiBjbGFzcz1cXFwiaGNvbi1lZGl0IGVudHlwbyBwZW5jaWxcXFwiPjxcL2E+IiwidmFsdWUiOiJ0YWdsaW5lIiwiYWxpZ24iOiJkZWZhdWx0IiwibWFyZ2luIjoiMDowOjA6MCJ9XSxbeyJjb250YWluZXIiOiJ0b3AtYXJlYSIsImV5ZSI6Im9uIiwicG9zaXRpb24iOiJzdGF0aWMiLCJoZWlnaHQiOiIwIiwiZGF0YSI6W3siYWxpZ24iOiJsZWZ0IiwiZWxlbWVudHMiOlt7InZhbCI6IndwbWwiLCJhbGlnbiI6ImRlZmF1bHQiLCJ0ZXh0IjoiIiwibWFyZ2luIjoiMDowOjA6MCIsIm5hbWUiOiJXUE1MIFNlbGVjdG9yIn0seyJ2YWwiOiJzb2NpYWwiLCJhbGlnbiI6ImRlZmF1bHQiLCJ0ZXh0IjoidHdpdHRlcjx2Yz5odHRwczpcL1wvdHdpdHRlci5jb21cL2FydGlsbGVnZW5jZTxzYz5mYWNlYm9vazx2Yz5odHRwczpcL1wvd3d3LmZhY2Vib29rLmNvbVwvYXJ0aWxsZWdlbmNlPHNjPmZsaWNrcjx2Yz5odHRwOlwvXC9mbGlja3IuY29tXC88c2M+dmltZW88dmM+aHR0cHM6XC9cL3ZpbWVvLmNvbVwvdXNlcjIwMDIyMDg5PHNjPnBpbnRlcmVzdDx2Yz5odHRwczpcL1wvcGludGVyZXN0LmNvbVwvPHNjPmRyaWJiYmxlPHZjPmh0dHA6XC9cL2RyaWJiYmxlLmNvbVwvYXJ0aWxsZWdlbmNlPHNjPnNreXBlPHZjPmNhbGw6YWJoaW4uc2hhcm1hPHNjPiIsIm1hcmdpbiI6IjA6MDowOjAiLCJuYW1lIjoiU29jaWFsIEljb25zIn0seyJ2YWwiOiJ0ZXh0IiwiYWxpZ24iOiJkZWZhdWx0IiwidGV4dCI6IkhlbHBsaW5lICsxIDM0MzMzMzMzMyIsIm1hcmdpbiI6IjEwOjA6MDoxNyIsIm5hbWUiOiJUZXh0ICJ9XX0seyJhbGlnbiI6ImNlbnRlciJ9LHsiYWxpZ24iOiJyaWdodCIsImVsZW1lbnRzIjpbeyJ2YWwiOiJ0b3AtbWVudSIsImFsaWduIjoiZGVmYXVsdCIsInRleHQiOiIwIiwibWFyZ2luIjoiMDowOjA6MCIsIm5hbWUiOiJNZW51IDIifV19XX0seyJjb250YWluZXIiOiJtZW51LWFyZWEiLCJleWUiOiJvbiIsInBvc2l0aW9uIjoic3RhdGljIiwiaGVpZ2h0IjoiMCIsImRhdGEiOlt7ImFsaWduIjoibGVmdCIsImVsZW1lbnRzIjpbeyJ2YWwiOiJsb2dvIiwiYWxpZ24iOiJkZWZhdWx0IiwidGV4dCI6IjAiLCJtYXJnaW4iOiIwOjA6MDowIiwibmFtZSI6IkxvZ28ifV19LHsiYWxpZ24iOiJjZW50ZXIifSx7ImFsaWduIjoicmlnaHQiLCJlbGVtZW50cyI6W3sidmFsIjoic2VhcmNoIiwiYWxpZ24iOiJkZWZhdWx0IiwidGV4dCI6IjAiLCJtYXJnaW4iOiI2OjA6MDowIiwibmFtZSI6IlNlYXJjaCBCYXIifSx7InZhbCI6Im1haW4tbWVudSIsImFsaWduIjoiZGVmYXVsdCIsInRleHQiOiIwIiwibWFyZ2luIjoiMDowOjA6MCIsIm5hbWUiOiJNZW51IDEifV19XX0seyJjb250YWluZXIiOiJ0b3AtZnVsbC1hcmVhIiwiZXllIjoib2ZmIiwicG9zaXRpb24iOiJzdGF0aWMiLCJoZWlnaHQiOiIiLCJkYXRhIjpbeyJhbGlnbiI6ImxlZnQifSx7ImFsaWduIjoiY2VudGVyIn0seyJhbGlnbiI6InJpZ2h0In1dfV1d";
						$header_data = base64_decode($header_data);	
						$header_data = json_decode($header_data,true);
				update_option(SN.'_header_construction_data',$header_data);
			}
			if(isset($_POST['save_data']))
			{
				$list = $_POST['unused_list'];
				$data = $_POST['layout'];

				$form_array = array($list , $data);
				echo update_option(SN.'_header_construction_data',$form_array);
				die();
			}
		}
	

	 }	
	
	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){
		global $super_options;	
		
		$hl = array();
		$d = get_option(SN.'_header_construction_data');
		$data = $d;
		

	/*	$output = json_encode($widgets);
				$output = base64_encode($output);	

				echo "<textarea> $output </textarea>"; 
		*/

		?>

		 <div class="ioa_panel_wrap"> <!-- Panel Wrapper -->
		

        <div class=" clearfix">  <!-- Panel -->
        	<div id="option-panel-tabs" class="clearfix" data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
        	
                
                <div id="panel-wapper" class="clearfix hcon-wrapper">
				
				<?php $this->getHeadBuilder($data); ?>	
	
   				</div></div></div>
	    <?php
	 }

	 public function getHeadBuilder($data)
	 {
	 	global $super_options,$post;	
		
		$hl = array();
		
	 	?>
		

		<!-- PREFFIX - hcon -->
		
		<div class="ioahead-delete-message">
			<p><?php _e('Are you sure you want to Reset ','ioa'); ?></p>
			<a href="yes" class="button-save"><?php _e('Yes','ioa') ?></a>
			<a href="no" class="button-save"><?php _e('No','ioa') ?></a>
		</div>	

		<div class="hcon-toolbar clearfix">

		<a href="" class="save-header-data"><?php _e('Save','ioa') ?></a>	
		
		<a href="<?php echo admin_url()."/admin.php?page=hcons&resetheader=true"; ?>" class="delete-header-data"><?php _e('Reset','ioa') ?></a>	
		<?php if(isset($_GET['page']) && $_GET['page'] == "hcons" ) : ?>
			<a href="" class='button-save ioa-quick-tour' id="ioa-intro-trigger"><?php _e('Quick Tour','ioa') ?></a>
		<?php endif; ?>
		</div>


		<div  id="header_constructor" data-url="<?php echo admin_url()."/admin.php?page=hcons"; ?>">



		<div class="hcon-head clearfix">
			<div class="sidebar-head">
				<h6><?php _e('Available Components','ioa') ?></h6>
			</div>
			<div class="main-head">
				
				
			</div>
		</div>

		<div class="hcon-body clearfix">
			<div class="hcon-sidebar">
				
				
				<div class="components-area">

					<?php 
					$widgets = $data[1];
					$wc = array();
					if(isset($widgets))
					foreach($widgets as $widget)
						foreach($widget['data'] as $holder) 
						{
							if(isset($holder['elements']))
									foreach($holder['elements'] as $el)
									{
									$wc[$el['val']] = $el['name']  ;
									
									}
									
						}

						
						
						 ?>	

					<ul id="hcon-comps" class='clearfix' <?php if(isset($_GET['page']) && $_GET['page'] == 'hcons') echo "data-step='1'"; ?> <?php  if(isset($_GET['page']) && $_GET['page'] == 'hcons') echo "data-intro='".__("All Head Components are available here, to use drop them in the area you want to show. If components are not showing make sure that area eye button is active",'ioa')."'"; ?> data-position='top' >
						<?php 
						$list = $data[0]; ?>
						<li data-val="text" class="text" data-align="default" data-margin="0:0:0:0"><?php _e('Text','ioa') ?> <a href="" class="hcon-edit ioa-front-icon pencil-2icon-"></a><i class="ioa-front-icon cancel-2icon- delete-hcon"></i></li>
						<li data-val="top-menu" class="top-menu"  data-align="default" data-margin="0:0:0:0"><?php _e('Menu 2','ioa') ?><a href="" class="hcon-edit ioa-front-icon pencil-2icon-"></a><i class="ioa-front-icon cancel-2icon- delete-hcon"></i></li>
						<li data-val="tagline" class="tagline"  data-align="default" data-margin="0:0:0:0"><?php _e('Tagline','ioa') ?><a href="" class="hcon-edit ioa-front-icon pencil-2icon-"></a><i class="ioa-front-icon cancel-2icon- delete-hcon"></i></li>
						<li data-val="social" class="social"  data-align="default" data-margin="0:0:0:0"  data-link="false"><?php _e('Social Icons','ioa') ?><a href="" class="hcon-edit ioa-front-icon pencil-2icon-"></a><i class="ioa-front-icon cancel-2icon- delete-hcon"></i></li> 
						<li data-val="wpml" class="wpml"  data-align="default" data-margin="0:0:0:0"><?php _e('WPML Selector','ioa') ?><a href="" class="hcon-edit ioa-front-icon pencil-2icon-"></a><i class="ioa-front-icon cancel-2icon- delete-hcon"></i></li> 
						
						
								<li data-val="main-menu" class="main-menu" data-align="default" data-margin="0:0:0:0"><?php _e('Menu 1','ioa') ?><a href="" class="hcon-edit ioa-front-icon pencil-2icon-"></a><i class="ioa-front-icon cancel-2icon- delete-hcon"></i></li>
								<li data-val="logo" class="logo" data-align="default" data-margin="0:0:0:0"><?php _e('Logo','ioa') ?> <a href="" class="hcon-edit ioa-front-icon pencil-2icon-"></a><i class="ioa-front-icon cancel-2icon- delete-hcon"></i></li>
								<li data-val="search" class="search"  data-align="default" data-margin="0:0:0:0"><?php _e('Search Bar','ioa') ?><a href="" class="hcon-edit ioa-front-icon pencil-2icon-"></a><i class="ioa-front-icon cancel-2icon- delete-hcon"></i></li>
						
						
					</ul>
				</div>

			</div>
			<div class="hcon-main-body" <?php if(isset($_GET['page']) && $_GET['page'] == 'hcons') echo "data-step='5'"; ?> <?php  if(isset($_GET['page']) && $_GET['page'] == 'hcons') echo "data-intro='".__('To Hide a area click on eye button , to remove a component drag it back to components holder. Vertical Space adds padding to areas.','ioa').'"'; ?> data-position='top'>
				<?php

				$default_filler_left = array( "val" => "logo" , "align" => "default" , "margin" => "0:0:0:0" , "name" => "Logo"  );
				$default_filler_right = array( "val" => "main-menu" , "align" => "default" , "margin" => "0:0:0:0" , "name" => "Menu 1"  );
				$default_filler_right1 = array( "val" => "search" , "align" => "default" , "margin" => "6:0:0:0" , "name" => "Search Bar"  );

				$temp_w = array();
				if(!isset($widgets) || count($widgets)==0)   
						$widgets = array();
				else
						foreach ($widgets as $w) {
								$temp_w[$w['container']] = $w;
							}	
					$default_widgets = array(

							"top-area" =>	array("position" =>"static","container" => "top-area" , 'data' => array( array('align' => 'left', 'elements' => array( ) ),  array('align' => 'center', 'elements' => array() ) ,  array('align' => 'right', 'elements' => array() )) ),
							"menu-area" =>	array( "height" => "" , "position" =>"static","container" => "menu-area" , 'data' => array( array('align' => 'left', 'elements' => array( $default_filler_left) ),  array('align' => 'center', 'elements' => array() ) ,  array('align' => 'right', 'elements' => array( $default_filler_right1 , $default_filler_right) )) ),
							"top-full-area" => 	array("position" =>"static","container" => "top-full-area" , 'data' => array( array('align' => 'left', 'elements' => array() ),  array('align' => 'center', 'elements' => array() ) ,  array('align' => 'right', 'elements' => array() )) )

								);


				$widgets = array_merge($default_widgets,$temp_w);
				$index = 2; $msg = '';

				


				foreach($widgets as $widget)
				{
					$w = 'static'; if(isset( $widget['position'])) $w =  $widget['position'];
					$e = 'on'; if(isset( $widget['eye'])) $e =  $widget['eye'];

					switch($widget['container'])
					{
						case 'top-area' : $msg = __("This area represents the top bar, The area has dark background and compact styling that other areas. ",'ioa'); $index = 2; break;
						case 'menu-area' : $msg = __("This area represents the main menu area, By default this area shows in front end and usually this is the most active one. ",'ioa'); $index = 3; break;
						case 'top-full-area' : $msg = __("This area represents the bottom header area , it is separarted by a border. It is useful when you want to add divider between logo and menu areas. ",'ioa'); $index = 4; break;
					}
					?>
					
				<div class="hcon-widget clearfix" data-val="<?php echo $widget['container'];  ?>"  data-eye="<?php echo $e;  ?>"data-position="<?php echo $widget['position'];  ?>">
					<div class="clearfix">
						<span class="label"><?php echo $widget['container'];  ?></span>
						<span class="height"> <?php _e('Vertical Space','ioa') ?> <input type="text" value="<?php if(isset($widget['height'])) echo $widget['height'];  ?>" class="container_height">px</span>
					</div>
					<div class="hcon-widget-body clearfix" <?php if(isset($_GET['page']) && $_GET['page'] == 'hcons') echo "data-step='$index'"; ?> <?php if(isset($_GET['page']) && $_GET['page'] == 'hcons') echo "data-intro='".$msg."'"; ?> data-position='top'>
						<a href="" class=" ioa-front-icon eye-3icon-  eye <?php if($e=="on") echo 'active'; ?>"></a>
						<?php 
						foreach($widget['data'] as $holder) 
						{
							$def = 'one_third';
							if($holder['align']=="full") $def = 'full-area';
							?>
							<div class="<?php echo $def ?>" data-align='<?php echo $holder['align'] ?>'>
								<div class="visual-ui"><?php echo strtoupper(str_replace("_"," ",$holder['align'])) ?></div>
								<div class="container">
									<?php
									if(isset($holder['elements']))
									foreach($holder['elements'] as $el)
									{
										
										?><div class="hcon-block" class="<?php echo $el['val'] ?>"  data-link="<?php if(isset($el['link'])) echo $el['link'] ?>"  data-text='<?php if(isset($el['text'])) echo stripslashes($el['text']) ?>' data-align='<?php echo $el['align'] ?>' data-margin='<?php echo $el['margin'] ?>' data-val='<?php echo $el['val'] ?>'><?php echo stripslashes($el['name']) ?><a class="hcon-edit ioa-front-icon pencil-2icon-" href=""></a> <i class="ioa-front-icon cancel-2icon- delete-hcon"></i>  </div><?php
									}
									 ?>
								</div>
							</div>

							<?php
						}
						 ?>	
						
						
					</div>
				</div>

					<?php
				}

				 ?>	
				

			</div>
		</div>
		</div>
		
		
		

		<div class="hide">
				<div class="honc-widgets-settings">

					<div class="text-block hide">
						<?php 
						echo getIOAInput(array( 
									"label" => __("Enter Text",'ioa') , 
									"name" => "hcon_w_txt" , 
									"default" => "0" , 
									"type" => "textarea",
									"description" => "This will appear in text widget" ,
									"length" => 'medium' 
							) ); ?>
					</div>
					
					<div class="social-block hide">
						<?php 
						echo getIOAInput(array( 
									"label" => __("Open Social Icons in new Window",'ioa') , 
									"name" => "hcon_s_w" , 
									"default" => "false" , 
									"type" => "select",
									"options" => array("false" => "No" ,"true" => "Yes"),
									"description" => "This will appear in text widget" ,
									"length" => 'medium' 
							) ); 
						echo getIOAInput(array( 
									"label" => __("Tick Social Icons to show",'ioa') , 
									"name" => "hcon_w_twitter" , 
									"default" => "" , 
									"type" => "checkbox",
									"description" => "This will appear in text widget" ,
									"length" => 'medium',
									"options" => array(  "linkedin" => "Linkedin"  , "blogger" => "Blogger" ,"facebook" => "Facebook", "twitter" => "Twitter","github" => "Github" , "flickr" => "Flickr" , "vimeo" => "Vimeo", "youtube" => "Youtube", "google-plus" => "Google+","pinterest" => "Pinterest", "tumblr" => "Tumblr" , "dribbble" => "Dribbble" , "stumbleupon" => "Stumbleupon" , "lastfm" => "Lastfm" , "rdio" => "Rdio" , "spotify" => "Spotify", "instagram"=>"Instagram", "dropbox" => "Dropbox", "evernote" => "Evernote", "flattr" => "Flattr", "skype" => "Skype", "soundcloud" => "Soundcloud", "picasa" => "Picasa","behance" => "Behance" , "smashing" => "Smashing")   
							) );
							?>
						<div class="social-links">
						<?php

						echo getIOAInput(array( 
									"label" => __("Enter Blogger link",'ioa') , 
									"name" => "hcon_blogger" , 
									"default" => "#" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) ); 
						
						echo getIOAInput(array( 
									"label" => __("Enter linkedin  link",'ioa') , 
									"name" => "hcon_linkedin" , 
									"default" => "https://www.linkedin.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
								
						echo getIOAInput(array( 
									"label" => __("Enter Twitter link",'ioa') , 
									"name" => "hcon_twitter" , 
									"default" => "https://twitter.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) ); 
 
						
						echo getIOAInput(array( 
									"label" => __("Enter facebook link",'ioa') , 
									"name" => "hcon_facebook" , 
									"default" => "https://facebook.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter github link",'ioa') , 
									"name" => "hcon_github" , 
									"default" => "https://www.github.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter flickr link",'ioa') , 
									"name" => "hcon_flickr" , 
									"default" => "http://flickr.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter vimeo link",'ioa') , 
									"name" => "hcon_vimeo" , 
									"default" => "https://vimeo.com" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
						
							echo getIOAInput(array( 
									"label" => __("Enter youtube link",'ioa') , 
									"name" => "hcon_youtube" , 
									"default" => "https://youtube.com" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter google+  link",'ioa') , 
									"name" => "hcon_google-plus" , 
									"default" => "https://plus.google.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter pinterest  link",'ioa') , 
									"name" => "hcon_pinterest" , 
									"default" => "https://pinterest.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter tumblr  link",'ioa') , 
									"name" => "hcon_tumblr" , 
									"default" => "https://tumblr.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
   
						

						echo getIOAInput(array( 
									"label" => __("Enter dribbble link",'ioa') , 
									"name" => "hcon_dribbble" , 
									"default" => "http://dribbble.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter stumbleupon link",'ioa') , 
									"name" => "hcon_stumbleupon" , 
									"default" => "http://www.stumbleupon.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter lastfm link",'ioa') , 
									"name" => "hcon_lastfm" , 
									"default" => "http://www.last.fm/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
    
						echo getIOAInput(array( 
									"label" => __("Enter rdio link",'ioa') , 
									"name" => "hcon_rdio" , 
									"default" => "http://www.rdio.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter spotify link",'ioa') , 
									"name" => "hcon_spotify" , 
									"default" => "https://www.spotify.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter instagram link",'ioa') , 
									"name" => "hcon_instagram" , 
									"default" => "http://instagram.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
 

						echo getIOAInput(array( 
									"label" => __("Enter dropbox link",'ioa') , 
									"name" => "hcon_dropbox" , 
									"default" => "https://www.dropbox.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
						echo getIOAInput(array( 
									"label" => __("Enter evernote link",'ioa') , 
									"name" => "hcon_evernote" , 
									"default" => "https://evernote.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
						echo getIOAInput(array( 
									"label" => __("Enter flattr link",'ioa') , 
									"name" => "hcon_flattr" , 
									"default" => "http://flattr.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
						echo getIOAInput(array( 
									"label" => __("Enter skype link",'ioa') , 
									"name" => "hcon_skype" , 
									"default" => "skype:your.user.name?call" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
						

						echo getIOAInput(array( 
									"label" => __("Enter soundcloud link",'ioa') , 
									"name" => "hcon_soundcloud" , 
									"default" => "https://soundcloud.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter picasa link",'ioa') , 
									"name" => "hcon_picasa" , 
									"default" => "http://picasa.google.co.in/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter behance link",'ioa') , 
									"name" => "hcon_behance" , 
									"default" => "http://www.behance.net/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );

						echo getIOAInput(array( 
									"label" => __("Enter smashing link",'ioa') , 
									"name" => "hcon_smashing" , 
									"default" => "http://www.smashingmagazine.com/" , 
									"type" => "text",
									"description" => "This will appear in text widget" ,
									"length" => 'medium'   
							) );
						 ?>
					</div></div>

					<?php 

						

						echo getIOAInput(array( 
									"label" => __("Alignment",'ioa') , 
									"name" => "hcon_w_align" , 
									"default" => "default" , 
									"type" => "select",
									"description" => "This is the tooltip" ,
									"options" => array("default" => __("Default",'ioa'),"lb" => __("New Line",'ioa'),"forceleft" =>__("New Line Left",'ioa'),"forceright" => __("New Line Right",'ioa'),"left" =>__("Left",'ioa'),"right" => __("Right",'ioa'))  ,
									"value" => "default",
									"length" => 'medium'   
							) );

					  	echo getIOAInput(array( 
									"label" => __("Top Margin",'ioa') , 
									"name" => "hcon_w_tm" , 
									"default" => "0" , 
									"type" => "text",
									"description" => "This is the tooltip" ,
									"value" => "0",
									"length" => 'medium'   
							) );

					  	echo getIOAInput(array( 
									"label" => __("Right Margin",'ioa') , 
									"name" => "hcon_w_rm" , 
									"default" => "0" , 
									"type" => "text",
									"description" => "This is the tooltip" ,
									"value" => "0",
									"length" => 'medium'   
							) );

					  	echo getIOAInput(array( 
									"label" => __("Bottom Margin",'ioa') , 
									"name" => "hcon_w_bm" , 
									"default" => "0" , 
									"type" => "text",
									"description" => "This is the tooltip" ,
									"value" => "0",
									"length" => 'medium'   
							) );

					  	echo getIOAInput(array( 
									"label" => __("Left Margin",'ioa') , 
									"name" => "hcon_w_lm" , 
									"default" => "0" , 
									"type" => "text",
									"description" => "This is the tooltip" ,
									"value" => "0",
									"length" => 'medium'   
							) );



				 ?>
				</div>
			<div class="hcon-block"></div>

		</div>
	 	<?php
	 }
	 

}

$IOAHeader = new IOAHeaderConstructor();