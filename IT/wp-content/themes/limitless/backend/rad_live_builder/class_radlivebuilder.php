<?php


class RADLiveBuilder
	{
		private  static  $values = array();

		static function getValues()
		{
			 return self::$values;
		}

		static function initJS()
		{
			global $post,$ioa_meta_data;	
			
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
							 		$v = str_replace(array( '&amp;squot;','&amp;quot;','&amp;sqstart;','&amp;sqend;','&lt;' ), array('\'','"','[',']','<'), $v);
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
					self::$values[] = " $id : ".json_encode($data);

				}

		}

		static function widgetArea()
		{
			global $radunits;
			
			?>
			<div id="rad_live_widgets"  class='clearfix'>
				<a href="" class="rad_widgets_trigger">Widgets</a>
				<div class="rad_live_widgets_container">
					<div class="rad_inner_widgets_wrap clearfix">
					<?php  
				 foreach ($radunits as $key => $widget) {
				 		
				 	if($widget->data['group']!="structure" && $widget->data['group']!="section")
				 	echo $widget->getThumb(false);	
				 	 
				 }
				
				?>	
				</div>
				</div>
			</div>	
			<?php
		}

	}

function add_rad_scripts()
{

}

function registerRADLiveBuilderScripts() {

		if( is_rad_editable() ) :	
			wp_enqueue_script('underscore');
			wp_enqueue_script('wplink');
			wp_enqueue_script('editor');
			wp_enqueue_script('quicktags');

			//wp_print_scripts(array( 'media-views','media-editor','word-count','editor','quicktags','wplink', 'wpdialogs-popup') );

			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script('jquery-ui-resizable');


			wp_enqueue_script('minicolors',HURL.'/js/jquery.minicolors.js');

			wp_enqueue_media();	
			
			wp_enqueue_style('rad-page-builder-css',HURL.'/rad_live_builder/css/live_builder.css');
			wp_enqueue_script('scrollbar',HURL.'/rad_live_builder/js/scrollbar.js');
			wp_enqueue_script('rad-page-builder-js',HURL.'/rad_live_builder/js/live_builder.js',array('backbone', 'underscore'));
		endif;	
}
add_action('wp_enqueue_scripts','registerRADLiveBuilderScripts');	 



	add_action( 'wp_footer', 'ioa_live_builder_data' );

function ioa_live_builder_data()
{
	if( !is_rad_editable() ) return;
	wp_reset_query();
	global $radunits,$post;
    
	?>
	

	<div class="ioa-message">
		        
          <div class="ioa-message-body clearfix">
               <div class="ioa-icon-area">
               		<i class="ioa-front-icon checkicon-"></i>
               </div>
               <div class="ioa-info-area">
               		<h3 class='msg-title'>Settings Saved !</h3>
               		<p class='msg-text'>Options Panel Settings were saved at 11 PM</p>
               </div>
              
          </div>
    </div>

    <div class="save-template-lightbox">
		<h4><?php _e('Enter Template Title','ioa') ?></h4>
		<a href="" class="close-icon ioa-front-icon cancel-circled-2icon-"></a>
		<div class="template-panel clearfix">
			<input type="text" id="rad-template-title">
			<a href="" class="button-save save-rad-template"><?php _e('Save Template','ioa') ?></a>
		</div>
	</div>

	<div class='page-import-area clearfix'>
								<?php 
									echo getIOAInput(array(
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

    <div class="rad-lightbox">
			<div class="rad-l-head">
				<h4><?php _e('Text Widget[Edit mode]','ioa') ?></h4>
			</div>
			<div class="rad-l-body clearfix">
				<div class="component-opts">
					
				</div>
				
			</div>
			
			<div class="rad-l-footer clearfix">
				<a href="" class="button-hprimary" id="save-l-data" ><?php _e('Save Changes','ioa') ?></a><a href="" class="button-hprimary" id="close-l" ><?php _e('Close','ioa') ?></a>
			</div>
		</div>

    <div class="rad-w-editor">
    	<div class="rad-w-editor-body">
    		<div class="r-w-editor-area clearfix">
    			<?php 
    			$settings =   array(
					    'wpautop' => true, // use wpautop?
					    'media_buttons' => true, // show insert/upload button(s)
					   'textarea_name' =>  'rad_wp_editor', // set the textarea name to something different, square brackets [] can be used here
					    'textarea_rows' => 15, // rows="..."
					    'textarea_columns' => 4,
					    'tinymce' => array(
					        'theme_advanced_buttons1' => 'bold,italic,underline,blockquote,|,bullist ,numlist  , link,unlink, ioabutton',
					        'theme_advanced_buttons2' => '',
					        'theme_advanced_buttons3' => '',
					        'theme_advanced_buttons4' => '',
					          'content_css' => get_stylesheet_directory_uri() . '/sprites/stylesheets/custom-editor-style.css' 
					    ),
					    'tabindex' => '',
					    'editor_class' =>" rad-editor", // add extra class(es) to the editor textarea
					    'teeny' => false, // output the minimal editor config used in Press This
					    'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
					    
					    'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
					);

	wp_editor( '','rad_wp_editor', $settings  );

    			 ?>

    		</div>
    	</div>
    	<div class="rad-w-editor-footer clearfix">
    		<a href="" class="button set-rad-w-editor">Done</a>
    		<a href="" class="button cancel-rad-w-editor">Cancel</a>
    	</div>
    </div>

    <a href="" class="trigger-live-editor flash-2icon- ioa-front-icon"></a>

	<?php 
		RADLiveMarkup::generateRADSection(array(),'',array(),true);
		RADLiveMarkup::generateRADContainer(array(),'','full',array(),true);
		RADLiveMarkup::generateRADWidget();
		RADLiveMarkup::generateRADSectionDrop();
		RADLiveMarkup::generateRADContainerDrop();

		RADLiveBuilder::initJS();
	?>

	<script type='text/javascript'>
	
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
	var rad_sections = {<?php echo join(",",RADLiveBuilder::getValues()) ?>};
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	var RAD_Live_Version = 1.53;
	</script>
<?php

}

