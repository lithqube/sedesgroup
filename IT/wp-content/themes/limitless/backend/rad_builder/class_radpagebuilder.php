<?php
/**
 * WOHOHO
 */
class RADPageBuilder
	{
		private  static  $values = array();

		static function getValues()
		{
			 return self::$values;
		}

		static function canvasArea()
		{
			global $radunits,$post,$ioa_meta_data;

			
			?>
			<div class="rad-builder-area" data-id='<?php echo $post->ID; ?>'>

				<?php 
				$ioa_meta_data['rad_editable'] = true;
				$ioa_meta_data['rad_reconstruct'] = array();
				$data =  $post->post_content;

				$rad_flag = false;
				if(has_shortcode($data,'rad_page_section')) 
					$rad_flag = true;

				$data = do_shortcode($data);
				$data = $ioa_meta_data['rad_reconstruct'];
				
				$check_data = get_post_meta($post->ID,"rad_data",true);



			
				if($check_data!="" && ! is_array($check_data) && !$rad_flag   )
				{
					$data = json_decode(stripslashes(base64_decode($check_data)),true);	// Backend Compatible 
				}
				else if(is_array($check_data) && !$rad_flag )
				{
					$data = $check_data;
				}	


				foreach ($data as $key => $section) {
					$d = array();

					if(isset($section['data']))	
						$d = $section['data'];

					$containers = array();

					if(isset($section['containers']))
					$containers = $section['containers'];

					foreach ($containers as  $container) {

						$data = array();

						if( gettype($container['data']) == "string") $container['data'] = json_decode($container['data'],true);

							foreach ($container['data'] as $key => $value) {
							 	if($key!='id' && $key!='layout' && $key!='first' && $key!='top' && $key!='last')
							 	$data[] = array("name" => $key,"value" => $value ); 
							 }

						 if(  isset($data[0]['value']) &&  is_array( $data[0]['value'] )  )
							 {
							 	$data = $container['data'];
							 	$data[] =  array("name" => 'id',"value" => $container['id'] ); 
							 }

						if(isset($container['id']))
					     		$container['data']['id'] = $container['id'];		 

					     
						 self::$values[] = $container['data']['id']." : ".json_encode($data);

						 $widgets = array();
						 if(isset($container['widgets'])) $widgets = $container['widgets'];
						 foreach ($widgets as $key => $w) {
						 	$data = array();



							foreach ($w as $key => $value) {

							

							 	if($key!='id' && $key!='layout' && $key!='first' && $key!='top' && $key!='last')
							 	{
							 		$v = $value;
							 		if($key=='text_data')
							 		{
							 			$v = str_replace('\\','',$v); // remove unecessary text data slashes
							 		}
							 		$v = str_replace(array( '&amp;squot;','&amp;quot;','&amp;sqstart;','&amp;sqend;','&lt;','&#091;','&#093;' ), array('\'','"','\[',']','<','[',']'), $v);
							 		$data[] = array("name" => $key,"value" => $v ); 
							 	}

							 

							 }

							 if(isset($w['data']))
							 {
							 	if( gettype($w['data']) == "string") $data = json_decode($w['data'],true);

							 }

							 if(isset($w['type']))
							 	$data[] = array( "name" => "type" ,  "value" => str_replace('-','_',$w['type']) );

							  if(isset($w['id']))
							 	$data[] = array( "name" => "id" ,  "value" => str_replace('-','_',$w['id']) );


							 if(  isset($data[0]['value']) && is_array( $data[0]['value'] )  )
							 {

							 	$type =   $data[1];
							 	$data = $data[0]['value'];
							 	$data[]  =  $type;
							 	$new_data = array();	
							 	foreach ($data as $key => $r) {
							 		$new_data[] = array( "name" => $r['name'] , "value" => stripslashes($r['value'])  );
							 	}
							 	$data = $new_data;

							 }

								

						 	 self::$values[] = $w['id']." : ".json_encode($data);
						 }
					}

					$id = 'rps'.uniqid();
					if(isset($d['id'])) $id = $d['id'];
					

					
					 $data = array();

					 
					if( gettype($section['data']) == "string") $section['data'] = json_decode($section['data'],true);


					 foreach ($section['data'] as $key => $value) {
					 	if($key!='id' && $key!='first' && $key!='top' && $key!='last')
					 	$data[] = array("name" => $key,"value" => $value ); 

					 	if(isset($section['id']))
					     		$section['data']['id'] = $section['id']; 
					     
					 }


					  if(  isset($section['data'][0]['name']) )
					 {
					 	$data = array();
						 foreach ($section['data'] as $key => $value) {
						 	if($key!="id")
					 		$data[] = array("name" => $value['name'],"value" => $value['value'] ); 
						 }
						 if(isset($section['id']))
					     		$data[] =  array("name" => "id","value" => $section['id'] ); 
					     	$id =  $section['id'];
					 }
					 RADMarkup::generateRADSection($data,$id,$containers);
					self::$values[] = " $id : ".json_encode($data);

				}

				?>	
			
			<?php if(count($data) ==0 ) :
					get_template_part('templates/rad/help');
			 endif; ?>	

			</div> <?php
		}
		
		static function widgetArea()
		{
			global $radunits,$post,$super_options;
			
			
			?>
			<div id="rad_sidebar" class="clearfix">
				<div id="top-rad-bar" class='clearfix'>
					
					
					<div class="skeleton rad-tabs-holder">
						<a href="" class="rad-publish-button">Publish</a>
						<h2 class="rad-title"><?php _e('Page Builder','ioa') ?></h2> 
						
						<div class="rad-panel-toolbar clearfix">
							<a href="" class="toggle-rad-state maximize-builder ioa-front-icon resize-full-2icon- parent_tip"><small class="rad_tooltip rtop">Toggle Fullscreen mode</small></a>
						</div>	

						<div class="ioa-admin-menu-wrap clearfix">
	        					<a href="" class="ioa-admin-menu ioa-front-icon cog-2icon-"></a>
	        					<ul class="ioa-admin-submenu">
	        						<li><a href="" class="rad-clear-all"><?php _e('Clear All !','ioa') ?></a></li>
	        						<li><a href="" class="import-old-backup"><?php _e('Import Old Back','ioa') ?></a></li>
	        						<li><a href="" class="rad-css-section-toggle"><?php _e('Custom CSS For Page','ioa') ?></a></li>
	        						<li><a href="" class="save-template"><?php _e('Save As Template','ioa') ?></a></li>
	        						<!-- <li><a href="" class="toolbar-button save-revision"><?php _e('Save As Revision','ioa') ?></a></li> -->
						 	<li><a href="<?php echo get_edit_post_link($post->ID) ?>" class="toolbar-button export-templates "><?php _e('Export Page','ioa') ?></a></li>
						 	<li><a href="" class="toolbar-button import-page-templates"><?php _e('Import','ioa') ?></a></li>
						 	<li><a href="" class="rad-undo"><?php _e('Undo','ioa') ?></a></li>
						 	<li><a href="" class="rad-redo"><?php _e('Redo','ioa') ?></a></li>
	        					</ul>
	        			</div>

						
						<div class="save-menu">

							<div class="save-template-lightbox">
								<h4><?php _e('Enter Template Title','ioa') ?></h4>
								<a href="" class="close-icon ioa-front-icon cancel-circled-2icon-"></a>
								<div class="template-panel clearfix">
									<input type="text" id="rad-template-title">
									<a href="" class="button-save save-rad-template"><?php _e('Save Template','ioa') ?></a>
								</div>
							</div>
							

						</div>
						

					</div>



				</div>
				<div class='page-import-area clearfix'>
								<?php 
									echo getIOAInput(array(
												'noname' => true,
								 				"label" => __("Copy and Paste Contents of the RAD Export File",'ioa') , 
												"name" => "import_rad_page" , 
												"default" => "" , 
												"type" => "textarea",
												"description" => "" ,
												"length" => "long",
												) );

								 ?>	
								 <a href="" class="button-default import-rad-page"><?php _e('Import Page','ioa') ?></a>
				</div>	

				<div class='rad-custom-css clearfix'>
								<?php 
									$page_css = get_post_meta($post->ID,'rad_custom_css',true);
									echo getIOAInput(array(
												
								 				"label" => __("Add Custom CSS for the Page here.",'ioa') , 
												"name" => "rad_custom_css" , 
												"default" => "" , 
												"type" => "textarea",
												"description" => "" ,
												"length" => "long",
												"value" => $page_css
												) );

								 ?>	
								 <a href="" class="button-default rad-css-section-toggle"><?php _e('Done','ioa') ?></a>
				</div> 
				

				

			</div>
			<?php
		}

		


	}



	add_action( 'edit_form_after_editor', 'ioa_page_builder' , 99);
	global $pagenow;
	
	if( ($pagenow == 'post.php' || $pagenow == 'post-new.php')  )
	add_action( 'admin_footer', 'ioa_page_builder_lg' );

function ioa_page_builder_lg()
{
	global $radunits,$post,$ioa_portfolio_slug;


	?>


	<div class="rad_toolbox clearfix">
			<a href="" class='ioa-front-icon left-open-bigicon- toggle-rad_toolbox parent_tip'><small class="rad_tooltip rleft">Toggle Widgets Sidebar</small></a>
			<ul  class="rad-swift-menu clearfix">
				<li class='rad_elements rad_image_prop'><a href="#rad_elements" class=""><img src='<?php echo HURL.'/css/i/builder_icon.png' ?>' /><span>Elements</span><i class="ioa-front-icon left-dir-1icon-"></i></a></li>
				<li class='rad_pages rad_image_prop parent_tip'><a href="#rad_pages" class=""><img src='<?php echo HURL.'/css/i/page_icon.png' ?>' /><span>Pages</span><i class="ioa-front-icon left-dir-1icon-"></i> <small class="rad_tooltip rleft">Import Inbuilt Pages</small></a></li>
			
			</ul>
		 	 <div id="rad_elements" class="clearfix rad-widget-area">
					<div class="rad-content-area">
									
						<div id="rad_builder_items">
							
							<div class="rad-widgets clearfix">
								
									
										
								<h3><a href="#rad-widgets"><?php _e('Widgets','ioa') ?> </a><i class="ioa-front-icon angle-downicon-"></i></h3>
								<div id="rad-widgets"  class='rad-w-tab-content clearfix'>
								 	<div class="rad-w-scroll-area clearfix">
										<div class="clearfix">
											<?php  
										 foreach ($radunits as $key => $widget) {
										 		
										 	if($widget->data['group']=="widgets" )
										 	echo $widget->getThumb();	
										 	 
										 }
										 foreach ($radunits as $key => $widget) {
											 		
											 	if($widget->data['group']=="plugins" )
											 	echo $widget->getThumb();	
											 	 
											 }
										?>	
										</div>									
									</div>
								</div>

								<h3><a href="#rad-media"><?php _e('Media Widgets','ioa') ?> </a><i class="ioa-front-icon angle-downicon-"></i></h3>
								<div id="rad-media"  class='rad-w-tab-content clearfix'>
								 	<div class="rad-w-scroll-area clearfix">
								 	<?php  
										 foreach ($radunits as $key => $widget) {
										 		
										 	if($widget->data['group']=="media" )
										 	echo $widget->getThumb();	
										 	 
										 }
										
										?>
									</div>
								</div>


								<h3><a href="#rad-advance"><?php _e('Post Widgets','ioa') ?> </a><i class="ioa-front-icon angle-downicon-"></i></h3>
								<div id="rad-advance"  class='rad-w-tab-content clearfix'>
								 	<div class="rad-w-scroll-area clearfix">
								 	<?php  
										 foreach ($radunits as $key => $widget) {
										 		
										 	if($widget->data['group']=="advance" )
										 	echo $widget->getThumb();	
										 	 
										 }
										?>
									</div>
								</div>

								<h3><a href="#rad-advance"><?php _e('Infographics Widgets','ioa') ?> </a><i class="ioa-front-icon angle-downicon-"></i></h3>
								<div id="rad-advance"  class='rad-w-tab-content clearfix'>
								 	<div class="rad-w-scroll-area clearfix">
								 	<?php  
										 foreach ($radunits as $key => $widget) {
										 		
										 	if($widget->data['group']=="infographic" )
										 	echo $widget->getThumb();	
										 	 
										 }
										?>
									</div>
								</div>

	
							</div>	
						</div>	
					</div>

		 	 </div>
		 	 <div id="rad_pages" class="clearfix rad-widget-area">

		 	 	<div class="rad-widgets clearfix">
					<ul class='clearfix'>
						<li><a href="#rad_inbuilt_pages">Inbuilt Pages</a></li>
						<li><a href="#rad_save_templates">Save Templates</a></li>
					</ul>
					<div class="ioa-information-p">
						<?php _e('Click on the Template to import it','ioa'); ?>
					</div>
					<div id="rad_inbuilt_pages" class="rad-w-tab-content rad_tab_scroll clearfix">
						<div class="clearfix">
						<div class="rad-search-file clearfix">
							 <input type="text" class='rad-file-input' placeholder="<?php _e('Enter Page to Search','ioa') ?>" />
							 <i class="ioa-front-icon search-2icon-"></i>
						</div>
							<?php 
								$ins_path =   get_template_directory()."/sprites/templates";
								if(file_exists($ins_path)) :

								$insta_templates = scandir($ins_path);
										$i = 0;
										$depth = 0;
										foreach ($insta_templates as $key => $template) {
											
											if($template!='.' &&  $template!='..')	
											{	
												$id =  str_replace('.txt','', $template);

												$name = str_replace("_"," ", $id);
												?>
												<div class="rad-template-icon insta-template insta-template-trigger <?php if($i%3==0) {  echo 'first '; $depth++; } echo ' level-'.$depth;  ?>" data-source="<?php echo $template; ?>"> 
													<i class="ioa-front-icon doc-alt-1icon- file-icon"></i>
													<span class="label"><?php echo $name; ?></span> 
												</div>
												<?php
												$i++;
											}

											
										}

								endif;		
							 ?>
						</div>
					</div>	
					
					
					<div id="rad_save_templates" class=" rad-w-tab-content rad_tab_scroll clearfix">
					<?php 

					$data = array();
					if(get_option('RAD_TEMPLATES')) $data = get_option('RAD_TEMPLATES');
					$i =0;
					$depth = 0;
					foreach ($data as $key => $template) {

					  	?>
					  	<div class="import-p-template rad-template-icon <?php if($i%3==0) {  echo 'first '; $depth++; } echo ' level-'.$depth;  ?>" data-key="<?php echo $key; ?>" data-source="<?php echo $template['title']; ?>"> 
										<i class="ioa-front-icon doc-alt-1icon- file-icon"></i>
										<i class="ioa-front-icon cancel-3icon- delete-icon"></i>
										<span class="label"><?php echo $template['title']; ?></span> 
						</div>
						<?php $i++;
					}


					 ?>
					 </div>
				</div>	 

		 	 </div>
		 	 
	</div>
	

	<span class="initializer-msg"><?php _e('Intializing Builder','ioa') ?></span>
	
	<div class="ioa-wp-editor">
		<div class="ioa-wp-editor-area">
			<?php 
				echo getIOAInput(array( "label" => __("Enter Text",'ioa') , "name" => "ioa_wp_editor" , "default" => "" ,"is_editor" => true, "type" => "textarea",  "length" => 'medium'));	
			 ?>
		</div>
		<div class="ioa-wp-editor-footer clearfix">
			<a href="" class="button-save ioa-save-wp-editor"><?php _e('Save Changes','ioa') ?></a>
			<a href="" class="button-default ioa-close-wp-editor"><?php _e('Close','ioa') ?></a>
		</div>
	</div>	


			<div class="rad-catcher"></div>


			<div class="settings-overlay">
					
				</div>
				<div class="settings-lightbox" data-version='1.0'>
					<div class="settings-body">
						<div class="inner-settings-body clearfix">
						

					</div>
					</div>
					<div class="bottom-bar clearfix">
						<a href="" class="cancel-settings button-default"><?php _e('Cancel','ioa') ?></a>
						<a href="" class="save-settings button-save"><?php _e('Save','ioa') ?></a>
						<a href="" class="insert-rad-shortcode button-save"><?php _e('Insert Widget','ioa') ?></a>
					</div>
				</div>
			
					<?php 
						RADMarkup::generateRADSection(array(),'',array(),true);
						RADMarkup::generateRADContainer(array(),'','full',array(),true);
						RADMarkup::generateRADWidget(array('id' => '','label' => ''),array(),'','full',true)
					?>

			<script type='text/javascript'>
			var RAD_BUILDER_VERSION = 3.22;
			var rad_builder_data = {

				<?php
						$settings = array();  
						 foreach ($radunits as $key => $widget) {

						 	if($key=='rad_page_container_80') $key = 'rad_page_container';

						 	if( $widget->getCommonKey() !="" )
						 		$settings[$widget->getCommonKey()] =  $key.' :{ inputs : [ '.$widget->createWidgetIOAInputs().'], styles:['.$widget->createWidgetIOAStyles().'] }';	
						 	else 
						 		$settings[$key] =  $key.' : { inputs : [ '.$widget->createWidgetIOAInputs().'] , styles:['.$widget->createWidgetIOAStyles().'] }';	
						 }
						 
						array_unique($settings); 
						
						echo join(',',$settings)

			?>


			}
			var rad_rich_fields = ['text_data','meta_value','rad_tab','gallery_images'];
			var rad_sections = {

				<?php echo join(",",RADPageBuilder::getValues()) ?>

			};

			</script>
		<?php

}

function ioa_page_builder(  ) {
			global $radunits,$post,$ioa_portfolio_slug;

			?> 
			
			<div id="rad_backend_builder">
			<div class="rad-loading-state"><span></span></div>			
			
			<div class="builder-area">
			<?php 
				RADPageBuilder::widgetArea();
			 ?>
			</div>

			<div class="ioa-canvas">
				<?php RADPageBuilder::canvasArea(); ?>	
			</div>
			
			<div class="rad-footer-area clearfix">
					 <a href="" class="button-save add-rad-row"><?php _e('Add Row','ioa') ?></a>
			</div>
				
			</div>
			<textarea id="style_keys" name="style_keys"></textarea>

			<?php
		}
