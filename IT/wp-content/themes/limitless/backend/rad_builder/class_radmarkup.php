<?php
class RADMarkup
	{
		
		static function generateRADSection($values=array(),$id='',$containers = array(),$clone = false,$force_value=false)
		{
			global $radunits;
			
			if($clone) {  $id = '{ID}'; echo '<script type="text/template" id="RADSectionView">'; }
			?>
			<div class="rad_page_section clearfix" id='<?php echo $id ?>' data-type='rad_page_section'  >
				<div class="section-options-follower">
					<a href="" class="append-rad-row"><i class='ioa-front-icon plus-1icon-'></i></a>
					<span class="rad-line"></span>
				</div>
				<div class="export-section-panel clearfix">
					 		<input type="text" class='section-temp-title' placeholder='<?php _e('Enter Name','ioa') ?>' />
					 		<a href="" class="section-export button-default"><?php _e('Export','ioa') ?></a>
					 		<i class="close-ex-panel ioa-front-icon cancel-1icon-"></i>
					 	</div>	
				<div class="section-toolbar clearfix">

					 <div class="section-buttons clearfix">
					 	<a href="" class="section-move"><i class="ioa-front-icon resize-vertical-1icon-"></i> <span class="s-tip"> <small class='ioa-front-icon right-dir-1icon-'></small><?php _e('Drag to Sort the Row.','ioa') ?></span> </a>
					 	<a href="" class="section-edit"><i class='ioa-front-icon pencil-2icon-'></i> <span class="s-tip"> <small class='ioa-front-icon right-dir-1icon-'></small><?php _e('Edit Row Settings.','ioa') ?></span></a>
						<a href="" class="section-clone"><i class='ioa-front-icon docsicon-'></i> <span class="s-tip"> <small class='ioa-front-icon right-dir-1icon-'></small><?php _e(' Duplicate Row.','ioa') ?></span></a>
						<a href="" class="section-delete"><i class='ioa-front-icon cancel-1icon-'></i> <span class="s-tip"> <small class='ioa-front-icon right-dir-1icon-'></small><?php _e(' Delete this Row. ','ioa') ?></span></a>
						<a href="" class="section-export-trigger"><i class='ioa-front-icon download-2icon-'></i> <span class="s-tip"> <small class='ioa-front-icon right-dir-1icon-'></small><?php _e(' Export Row as Text File. ','ioa') ?></span></a>
					 </div>
				</div>

				<div class="rad_section-notifier">
					<span><?php _e('Row name is ','ioa') ?> <strong class='section-name'><?php if(isset($values['section_name'])) echo $values['section_name'] ?></strong> and <?php _e(' is hidden on ','ioa') ?><strong  class='section-visibility'><?php  if(isset($values['visibility']))  echo $values['visibility'] ?></strong></span>
				</div>
				<div class="skeleton section-content clearfix">
				
				<?php 

					foreach ($containers as $key => $container) {
						$container_data = $container['data'];
						$widgets = array();
						
						$f = false;
						
						if(is_array($force_value)) $f = $container['data'];

						if(isset($container['widgets'])) $widgets = $container['widgets'];
						
						if(isset($container['layout'])) $container_data['layout'] = $container['layout'];
						if(isset($container['id'])) $container_data['id'] = $container['id'];
					
						RADMarkup::generateRADContainer($container_data,$container_data['id'],$container_data['layout'],$widgets,$clone,$f);
					}

				 ?>	
							
			
					
				</div>
				<?php if(is_array($force_value)) : 
				 		echo '<div class="save-data">';
						foreach ($force_value as $key => $value) {
							 echo '<textarea name="'.$value['name'].'">'.stripslashes($value['value']).'</textarea>';
						}
						echo '</div>';
				 endif; ?>
			</div>
			<?php
			if($clone) echo "</script>";
		}

		

		static function generateRADContainer($values = array(),$id ='',$layout='full',$widgets = array(),$clone = false,$force_value=false)
		{
			global $radunits;
			

			if($clone) {  $id = '{ID}'; echo '<script type="text/template" id="RADContainerView">'; }
			?>

			<div id="<?php echo $id ?>" class="rad_page_container <?php echo $layout ?> clearfix" data-type='rad_page_container'>
									<div class="container-toolbar clearfix">
											<a href="" class="container-move"><i class="ioa-front-icon resize-full-alt-1icon-"></i> <span class="c-tip"> <small class='ioa-front-icon up-dir-1icon-'></small><?php _e('Drag to Sort the Column or drop it in another row.','ioa') ?></span></a>
										 	<div class="container-layout">
										 			<?php 
										 			echo getIOAInput(array(
										 				 "label" => "" , 
																				"name" => "component_layout" , 
																				"default" => "100%" , 
																				"type" => "select",
																				"description" => "" ,
																				"options" => array("full" => "100%", "four_fifth" => "80%" , "three_fourth" => "75%", "two_third" => "66%","one_half" => "50%","one_third" => "33%", "one_fourth" => "25%", "one_fifth" => "20%"),
																				"value" => $layout , "data" => array("attr" => "component_layout_holder" ) 
																		) );
										 			?>
										 			<span class="c-tip"> <small class='ioa-front-icon up-dir-1icon-'></small><?php _e('Select the Column Width','ioa') ?></span>
										 		</div>
												<a href="" class="container-clone"><i class='ioa-front-icon docsicon-'></i> <span class="c-tip"> <small class='ioa-front-icon up-dir-1icon-'></small><?php _e('Duplicate Column','ioa') ?></span></a>
										 		<a href="" class="container-delete"><i class='ioa-front-icon cancel-1icon-'></i><span class="c-tip"> <small class='ioa-front-icon up-dir-1icon-'></small><?php _e('Delete Column','ioa') ?></span></a>
										 		<a href="" class="container-edit"><i class='ioa-front-icon pencil-2icon-'></i><span class="c-tip"> <small class='ioa-front-icon up-dir-1icon-'></small><?php _e('Edit Column settings','ioa') ?></span></a>
									</div>
									<div class="container-content clearfix">
										<?php 
											foreach ($widgets as $key => $widget) {
												

												
												$widget_data = $widget;
												
												$f = false;
												if(is_array($force_value)) $f = $widget['data'];
												
												$l = 'full';
												if(isset($widget['layout'])) $l = $widget['layout'];

												$widget['type'] = str_replace('-','_',$widget['type']);

												$unit = $radunits['rad_text_widget'];
												if(isset($radunits[$widget['type']])) $unit = $radunits[$widget['type']];

												if(isset($widget['id'])) $widget_data['id'] = $widget['id'];

												RADMarkup::generateRADWidget($unit->data,$widget_data,$widget_data['id'],$l,false,$f);
											}
											
										 ?>
									</div>
									<?php if(is_array($force_value)) : 
								 		echo '<div class="save-data">';
										foreach ($force_value as $key => $value) {
											 echo '<textarea name="'.$value['name'].'">'.stripslashes($value['value']).'</textarea>';
										}
										echo '</div>';
								 endif; ?>
									
			</div>
			<?php
			if($clone) echo "</script>";
			
		}

		static function generateRADWidget($data,$values=array(),$id='',$layout='full',$clone=false,$force_value=false)
		{
			global $radunits, $helper;
			
			

			if($clone) {  $id = '{ID}'; echo '<script type="text/template" id="RADWidgetView">'; $data['label'] = '{label}'; }
			?>
			<div class="rad_page_widget <?php echo $layout ?> <?php echo $data['id']; if(isset($data['group']) && $data['group']=="templates") echo ' rad-template' ?> ui-state-default" data-key="<?php echo $data['id']; ?>"  id="<?php echo $id ?>" >
				
					
				<div class="widget-toolbar clearfix">
				 		<a href="" class="widget-move"><i class="ioa-front-icon resize-full-alt-1icon-"></i><span class="c-tip"> <small class='ioa-front-icon up-dir-1icon-'></small><?php _e('Sort Widget or drop into another column','ioa') ?></span></a>
				 		<a href="" class="widget-edit"><i class='ioa-front-icon pencil-2icon-'></i><span class="c-tip"> <small class='ioa-front-icon up-dir-1icon-'></small><?php _e('Edit Widget Inputs','ioa') ?></span></a>	
						<a href="" class="widget-delete"><i class='ioa-front-icon cancel-1icon-'></i><span class="c-tip"> <small class='ioa-front-icon up-dir-1icon-'></small><?php _e('Delete Widget','ioa') ?></span></a>
				</div>
				<div class="widget-content">
					<?php 
						$t = $values;



						if(isset($values['data'][0]['value']))	
							 $t =  $helper->getAssocMap($values['data'],'value'); 

						if(isset($values['data']) && gettype($values['data']) == "string" )	
							 $t =  $helper->getAssocMap(json_decode($values['data'],true),'value'); 	

					 if(!$clone) echo $radunits[$data['id']]->getVisualFeedback($t); 
					?>
				</div>
				<?php if(is_array($force_value)) : 
				 		echo '<div class="save-data">';
						foreach ($force_value as $key => $value) {
							 echo '<textarea name="'.$value['name'].'">'.stripslashes($value['value']).'</textarea>';
						}
						echo '</div>';
				 endif; ?>
			</div>
			<?php
			if($clone) echo "</script>";

		}


	}