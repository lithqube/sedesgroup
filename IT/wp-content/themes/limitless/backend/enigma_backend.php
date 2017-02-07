<?php
/**
 *  Name - Dummy panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Nobody
 */

if(!is_admin()) return;


class EnigmaBackend  {
	

	
	// init menu
	function __construct () {  }
	
	function advModule()
	{
		
		$data = get_option(SN.'_enigma_data');
		?>
		<div id="eni_boxed" class="clearifx">
							
			<div class="subpanel cleafix">
				
				<ul class='clearfix'>
							<li><a href="#eni_boxed_tab"><?php _e('Page Background Stylings','ioa') ?></a></li>
							<li><a href="#eni_block_tab"><?php _e('Top Area Background Stylings','ioa') ?></a></li>
							<li><a href="#eni_head_tab"><?php _e('Head Stylings','ioa') ?></a></li>
							<li><a href="#eni_title_tab"><?php _e('Title Stylings','ioa') ?></a></li>
				</ul>

				
				<div id="eni_boxed_tab" class="clearfix">
					<?php
						$boxed_vals = array();
						if(isset($data['boxed'])) $boxed_vals = $data['boxed'];

						$boxed_bg_keys = array(

			    array( 'name' => 'boxed_background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => '' , 'options' =>  array(''=>'None' , 'primary-color' => 'Set Primary Color' , 'secondary-color' => 'Set Secondary Color' ,'bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient','custom'=>'Custom') ),
			    
			    array( 'name' => 'boxed_background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' box-bg-listener bg-color '  ),
			    array( 'name' => 'boxed_background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' box-bg-listener bg-image bg-texture'  ),
			    array( 'name' => 'boxed_background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' box-bg-listener bg-texture'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
			    array( 'name' => 'boxed_background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' box-bg-listener bg-image' , "options" => array("", "auto","contain","cover") ),
			    array( 'name' => 'boxed_background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' box-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
			    array( 'name' => 'boxed_background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' box-bg-listener bg-texture ' , 'label' =>"Background Attachment" ),
			    array( 'name' => 'background_gradient_dir' ,'default'=>"" , 'class' => ' box-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
			    array( 'name' => 'boxed_start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' box-bg-listener  bg-gradient'   ),
			    array( 'name' => 'boxed_end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '' , 'class' => ' box-bg-listener  bg-gradient'  ),
					);

						?>

						<dib class="box-bg-vals">
							<?php 

							foreach ($boxed_bg_keys as $key => $value) {
								$value['value'] = '';
								if(isset($boxed_vals[$value['name']])) $value['value'] = $boxed_vals[$value['name']];
								echo $ui->getIOAInput($value);
							}

							 ?>
						</dib>	
				</div>
				<div id="eni_title_tab" class="clearfix">


						<?php
						$title_vals = array();
						if(isset($data['title_area'])) $title_vals = $data['title_area'];

						$title_bg_keys = array(

						
						array( 
									"label" => __("Select Title Alignment",'ioa') , 
									"name" => "title_align" , 
									"default" => "left" , 
									"type" => "select",
									"options" => array("left" => __("Left",'ioa') ,"right" => __("Right",'ioa') , "center" => __("Center",'ioa')  )  
							) ,
						array( 
								"label" => __("Select Title Top Spacing",'ioa') , 
								"name" => "title_tspace" , 
								"default" => "" , 
								"type" => "slider",
								"max" => "300",
								"suffix" => "px"
						),
						array( 
								"label" => __("Select Title Bottom Spacing",'ioa') , 
								"name" => "title_bspace" , 
								"default" => "" , 
								"type" => "slider",
								"max" => "300",
								"suffix" => "px"
						),
						
							array( 
									"label" => __("Select Title Font Size",'ioa') , 
									"name" => "title_font_size" , 
									"default" => "" , 
									"type" => "slider",
									"max" => "160",
									"suffix" => "px"
							),
							array( 
									"label" => __("Enter Font Weight",'ioa') , 
									"name" => "title_font_weight" , 
									"default" => "" , 
									"type" => "slider",
									"max" => "900",
									"steps" => 100,
									'suffix' => ''
							),

			    array( 'name' => 'title_background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => 'default' , 'options' =>  array('default'=>'Default' , "transparent" => "Transparent",  'primary-color' => 'Set Primary Color' , 'secondary-color' => 'Set Secondary Color' ,'bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient','custom'=>'Custom') ),
			    
			    array( 'name' => 'title_background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' title-bg-listener bg-color '  ),
			    array( 'name' => 'title_background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' title-bg-listener bg-image bg-texture'  ),
			    array( 'name' => 'title_background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' title-bg-listener bg-texture'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
			    array( 'name' => 'title_background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' title-bg-listener bg-image' , "options" => array("", "auto","contain","cover") ),
			    array( 'name' => 'title_background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' title-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
			    array( 'name' => 'title_background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' title-bg-listener bg-texture ' , 'label' =>"Background Attachment" ),
			    array( 'name' => 'title_background_gradient_dir' ,'default'=>"" , 'class' => ' title-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
			    array( 'name' => 'title_start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' title-bg-listener  bg-gradient'   ),
			    array( 'name' => 'title_end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '' , 'class' => ' title-bg-listener  bg-gradient'  ),
			    array( 'name' => 'title_color', 'type' => 'colorpicker' , 'label' => 'Title Color' , 'default' => '' , 'class' => ''  ),
					);

						?>

						<dib class="title-bg-vals">
							<?php 

							foreach ($title_bg_keys as $key => $value) {
								$value['value'] = '';
								if(isset($title_vals[$value['name']])) $value['value'] = $title_vals[$value['name']];
								echo $ui->getIOAInput($value);
							}

							 ?>
						</dib>	
				</div>
				<div id="eni_block_tab" class="clearfix">
					<?php
						$boxed_vals = array();
						if(isset($data['block'])) $block_vals = $data['block'];

						$block_bg_keys = array(
				 array( 'name' => 'block_height', 'type' => 'slider' , 'label' => 'Set Block Height' , 'default' => 500 , "suffix" => 'px' , 'max' => 1500  ),			
			    array( 'name' => 'block_background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => '' , 'options' =>  array(''=>'None' , 'primary-color' => 'Set Primary Color', 'secondary-color' => 'Set Secondary Color' ,'bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient','custom'=>'Custom') ),
			    
			    array( 'name' => 'block_background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' box-bg-listener bg-color '  ),
			    array( 'name' => 'block_background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' box-bg-listener bg-image bg-texture'  ),
			    array( 'name' => 'block_background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' box-bg-listener bg-texture bg-image'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
			    array( 'name' => 'block_background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' box-bg-listener bg-image' , "options" => array("", "auto","contain","cover") ),
			    array( 'name' => 'block_background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' box-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
			    array( 'name' => 'block_background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' box-bg-listener bg-texture bg-image' , 'label' =>"Background Attachment" ),
			    array( 'name' => 'background_gradient_dir' ,'default'=>"" , 'class' => ' box-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
			    array( 'name' => 'block_start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' box-bg-listener  bg-gradient'   ),
			    array( 'name' => 'block_end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '' , 'class' => ' box-bg-listener  bg-gradient'  ),
					);

						?>

						<dib class="block-bg-vals">
							<?php 

							foreach ($block_bg_keys as $key => $value) {
								$value['value'] = '';
								if(isset($block_vals[$value['name']])) $value['value'] = $block_vals[$value['name']];
								echo $ui->getIOAInput($value);
							}

							 ?>
						</dib>	
				</div>

				


			<div id="eni_head_tab" class="clearfix">
			<div class="ioa-information-p"> These Stylings <strong>Will Not</strong> applied to Full Width Head Layouts. Use Top Area Background Instead.   </div>

					<?php
						$boxed_vals = array();
						if(isset($data['head'])) $head_vals = $data['head'];

						$head_bg_keys = array(

				array( 'name' => 'head_overlay', 'type' => 'select' , 'label' => 'Select Head Behavior' , 'default' => '' , 'options' =>  array(''=>'Default Style' , 'overlay' => 'Overlap on Title or Teaser Area'  ) ),			

			    array( 'name' => 'head_background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => '' , 'options' =>  array(''=>'Default Style' , 'primary-color' => 'Set Primary Color', 'secondary-color' => 'Set Secondary Color' ,'bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient','custom'=>'Custom') ),
			    
			    array( 'name' => 'head_background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' head-bg-listener bg-color '  ),
			     array( 'name' => 'head_background_opacity', 'type' => 'text' , 'label' => 'Background opacity(between 0 and 1)' , 'default' => '1' , 'class' => ' head-bg-listener bg-color '  ),
			    array( 'name' => 'head_background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' head-bg-listener bg-image bg-texture'  ),
			    array( 'name' => 'head_background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' head-bg-listener bg-texture bg-image'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
			    array( 'name' => 'head_background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' head-bg-listener bg-image' , "options" => array("", "auto","contain","cover") ),
			    array( 'name' => 'head_background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' head-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
			    array( 'name' => 'head_background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' head-bg-listener bg-texture bg-image' , 'label' =>"Background Attachment" ),
			    array( 'name' => 'background_gradient_dir' ,'default'=>"" , 'class' => ' head-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
			    array( 'name' => 'head_start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' head-bg-listener  bg-gradient'   ),
			    array( 'name' => 'head_end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '' , 'class' => ' head-bg-listener  bg-gradient'  ),
					);

						?>

						<dib class="head-bg-vals">
							<?php 

							foreach ($head_bg_keys as $key => $value) {
								$value['value'] = '';
								if(isset($head_vals[$value['name']])) $value['value'] = $head_vals[$value['name']];
								echo $ui->getIOAInput($value);
							}

							 ?>
						</dib>	
				</div>

				

			</div>

		</div>
		<?php
}

function customCSS()
{
	
	?>
	<div id="custom-css">
					<?php 
						$concave_editor = '';

						if( get_option(SN.'_custom_css') )
							$concave_editor = get_option(SN.'_custom_css');


						echo $ui->getIOAInput(array( 
								"label" => "Custom CSS" , 
								"name" => "concave_editor",
								"length" => "small" , 
								"default" => '' , 
								"type" => "textarea",
								"description" => "" ,
								"value" => stripslashes($concave_editor),
								'class' => 'ceditor'
						) );
				 ?>	
				</div>
				<?php
}

function typography()
{
	
$data = get_option(SN.'_enigma_data');
?>


		<div id="eni_typo">
						<?php 
						global $ioa_typo_list;

						foreach ($ioa_typo_list as $key => $slab) {
							$value = array();
							if(isset($data['typography'][$slab['id']]))
								$value = $helper->getAssocMap($data['typography'][$slab['id']],'value');
							
							$this->createTypoSlab($slab,$value);
						};
							
						 ?>
		</div>			
		<?php
	}

	function fontDeckPanel()
	{
		
		$data = get_option(SN.'_enigma_data');
		?>
		<div id="eni_font_deck">

							<?php 



							$font_Deck_opts = array();

							$font_Deck_opts[]   = array( 
											  "label" => __("Project ID",'ioa'),
											  "name" => SN."_font_deck_project_id",
											  "type" => "text",
											   );

							$font_Deck_opts[]   = array( 
											  "label" => __("Font Name",'ioa'),
				  								"name" => SN."_font_deck_name",
											  "type" => "text",
											   );

							foreach ($font_Deck_opts as $key => $input) {
								$t = $input;
								$t['value'] = '';
								
								if(isset($data[$input['name']])) 
									$t['value'] = $data[$input['name']];
								
								echo $ui->getIOAInput($t);	

							}


							 ?>

						</div>
						<?php
	}
	
	function fontFacePanel()
	{
		
		?>
		<div id="eni_font_face" >

							<div class="ioa-information">
								Generating Fonts from zip file.
							</div>
							
							<?php 

							echo $ui->getIOAInput(array( 
												"label" => "Upload Fontface Zip" , 
												"name" => "eni_font_face_in",
												"default" => '' , 
												"type" => "zipupload",
										) );

							 ?>

							 <div class="fontface-list clearfix">
							 	<?php 

								$font_face_fonts = get_option(SN.'_fontface_fonts');
								if(!$font_face_fonts) $font_face_fonts = array();

								
								
								 foreach ($font_face_fonts as $key => $stack) {
								 	
								 	?>
								 	<div class="fontface-item ">
										<input type="hidden" class='fid' value="<?php echo $key; ?>" />
										<span><?php echo $stack['name'] ?></span>
										<a href="" class="ioa-front-icon cancel-3icon-"></a>
									</div>	
									<?php
								 }

							 	 ?>
							 </div>
							
							<div class="fontface-item hide">
								<input type="hidden" class='fid'>
								<span>Font</span>
								<a href="" class="ioa-front-icon cancel-3icon-"></a>
							</div>	

						</div>
						<?php
	}	
	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){	
		
		global  $super_options;
		
		?>
		
                	<div id="" class="clearfix visual_styler">
						
						<div id="eni_skins" class="clearifx">
							
							<div class="inbuilt-styles" style='display:none'>
								<h4>Select From Predefined Skin</h4>
								<?php 

										$data = get_option(SN.'_enigma_data');
										$dskin = 'default';
										$palette = $data['palette'];
										if(isset($data['skin'])) $dskin = 'default';

								 ?>
								<div class="inbuilt-styles-body clearfix">
									<div class="skin-item <?php if('default' == $dskin) echo 'active'; ?>" data-skin="default">
													
													<div class="preview-skin" >
														<i class="default-skin ioa-front-icon paper-planeicon-"></i>
														<div class="hover"> <i href="">Activate</i> </div>
														<a href="" class="skin-tick  checkicon- ioa-front-icon"></a>
													</div>	

													<span class="label">Default</span>

												</div>

										<?php 


										$stylePath =   get_template_directory()."/sprites/skins";
										$skins = scandir($stylePath);
										$skin_ar  = array("default");
										foreach ($skins as $key => $skin) {
											
											if($skin!='.' &&  $skin!='..')	
											{
												$skin_ar[] = $skin;
												?>
												<div class="skin-item <?php if($skin == $dskin) echo 'active'; ?>" data-skin="<?php echo $skin; ?>">
													
													<div class="preview-skin" >
														<img src="<?php echo URL.'/sprites/skins/'.$skin.'/preview.png'; ?>" alt="">
														<div class="hover"> <i href="">Activate</i> </div>
														<a href="" class="skin-tick  checkicon- ioa-front-icon"></a>
													</div>	

													<span class="label"><?php echo ucwords($skin); ?></span>

												</div>
												<?php
											}

										}


										 ?>
								</div>
							</div>
								

							<div class="predefined-schemes clearfix">
								<h4 class="clearfix"> 
									Available Color Scheme for <strong class="c-skin-label"><?php echo $dskin; ?></strong> skin
									 <a href="" class="adv-opts"><?php _e("[Advance Options]",'ioa') ?></a>
								</h4>
								<div class="scheme-override clearfix">
									<?php 
									$in_schemes = array();
									if(get_option(SN.'_pre_schemes'))
									{
										$in_schemes = get_option(SN.'_pre_schemes');
										$t_s = array(""=>"None");
										foreach ($in_schemes as $key => $scheme) {
											$s =  'default';
											if(isset($scheme['skin'])) $s = $scheme['skin'];
											$t_s[str_replace(' ','_',$key)] = $key."($s Skin)";
										}
										echo $ui->getIOAInput(array(
													"label" => __("Save Color Settings To Available Scheme",'ioa'),
													"name" => "scheme_s_override",
													"type" => "select" ,
													"options" => $t_s,
													"default" => "None",
													"value" =>"None",
													"length" => "small",
													"after_input" => '<a href="" class="button-default scheme-override-save">Save To Color Scheme</a>'
												));
									} 

									$toggle_scheme = 'no';
									if(get_option(SN.'_toggle_scheme')) $toggle_scheme = get_option(SN.'_toggle_scheme');

									echo $ui->getIOAInput(array(
													"label" => __("Disable Scheme System(If yes stylings will come from stylesheet)",'ioa'),
													"name" => "toggle_color_scheme",
													"type" => "select" ,
													"options" => array("no","yes"),
													"default" => "no",
													"value" => $toggle_scheme,
													"length" => "small"
												));

									 ?> 
									 
								</div>	

								<ul class="clearfix">

									<?php 
									global $ioa_visual_data,$color_schemes;
								
									$str = '';

									$pre_schemes =   get_template_directory()."/sprites/colors";
									$schemes = scandir($pre_schemes);

									foreach ($schemes as $key => $scheme) {	
									$str = '';
									if($scheme!='.' &&  $scheme!='..')	{

									$fh = fopen($pre_schemes.'/'.$scheme, 'r');
									$theData = fread($fh, filesize($pre_schemes.'/'.$scheme));
									fclose($fh);

									$sch = json_decode(base64_decode($theData),true);
									$title = $sch['title'];
									$sch = $helper->getAssocMap($sch['palette'],'value');

									$s = 'default';

									$p = "<span href='' class='pblock' style='background:".$sch['highlight_color']."'></span>";

									$str .= "<li class='clearfix sch-sk-".$s."'  data-masterskin='".$s."' id='".str_replace(' ','_',$key)."'>
										<p class='clearfix'>$p</p><small>$title</small> ";

										foreach ($sch as $key => $value) {
											$str .= "<input type='hidden' class='".$key."' value='".$value."' />";
										}

									}

									$str .= "</li>";
									echo $str;
								}


								
									
								foreach ($in_schemes as $key => $scheme) {
										$s = 'default';
										if(isset($scheme['skin'])) $s = $scheme['skin'];

										$p = "<span href='' class='pblock' style='background:".$scheme['primary_bg_color']."'></span>";

										$str = "<li class='clearfix sch-sk-".$s."' data-masterskin='".$s."' data-id='".$key."' id='".str_replace(' ','_',$key)."'>
										<p class='clearfix'>$p</p> <small>".$key."</small>";

										foreach ($scheme as $key => $value) {
											$str .= "<input type='hidden' class='".$key."' value='".$value."' />";
										}

										$str .= "<i class='cancel-3icon- ioa-front-icon delete-scheme'></i></li>";
										echo $str;
									}	
									
								 ?>
								</ul>	

							</div>

							<div class="customize-settings clearfix">
								<h4 class="clearfix">
									<span> Customize Color Scheme  </span>
								<div class="ioa-admin-menu-wrap clearfix">
			        					<a href="" class="ioa-admin-menu ioa-front-icon cog-2icon-"></a>
			        					<ul class="ioa-admin-submenu">
			        						<li><a href="" class="reset-skin">Reset</a></li>
			        						<li><a href="" class="export-scheme-toggle">Save as Scheme</a></li>
			        						<li><a href="" class="export-skin-toggle">Export</a></li>
			        						<li><a href="" class="import-skin-toggle">Import</a></li>
			        					</ul>
			        			</div>
			        			</h4>	
								
								<div class="export-skin-panel clearfix">
									<?php 
										echo $ui->getIOAInput(array( 
											 "label" => "Enter Title",
											 "name" => "skin_export_title",
											 "default" => "",
											 "type" => "text",
											 "after_input" => ""	
										  ));
										/*
										echo $ui->getIOAInput(array( 
											 "label" => "Select Skin",
											 "name" => "sk_ex_skin_v",
											 "default" => "default",
											 "options" => $skin_ar,
											 "type" => "select",
											 
										  ));
										  */
									 ?>	
									 <a href='<?php echo admin_url() ?>admin.php?page=ioaeni' class='export-skin button-default'>Export Skin</a>
								</div>
								<div class="export-scheme-panel clearfix">
									<?php 
										echo $ui->getIOAInput(array( 
											 "label" => "Enter Title",
											 "name" => "scheme_export_title",
											 "default" => "",
											 "type" => "text",
											 "after_input" => ""	
										  ));
										echo $ui->getIOAInput(array( 
											 "label" => "Select Skin",
											 "name" => "ex_skin_v",
											 "default" => "default",
											 "options" => $skin_ar,
											 "type" => "select",
											 
										  ));
									 ?>	
									 <a href='' class='save-as-scheme button-default'>Save</a>
								</div>

								<div class="import-skin-panel clearfix">
									<?php 
										echo $ui->getIOAInput(array( 
											 "label" => "Enter Import Code",
											 "name" => "skin_import_code",
											 "default" => "",
											 "type" => "textarea",
											 "after_input" => "<a href='".admin_url()."admin.php?page=ioaeni' class='import-skin button-default'>Import Skin</a>"	
										  ));
									 ?>	
								</div>

								<div class="customize-settings-body ">
										<ul class="clearfix">
										<?php 
											foreach ($ioa_visual_data as $key => $ar) {
													
												echo "<li class='clearfix'><a href='#".str_replace(' ','_',$key)."'>$key</a></li>";
											}
											
										?>
										</ul>
										

										<?php 

											foreach ($ioa_visual_data as $key => $ar) {
												
												echo "<div id='".str_replace(' ','_',$key)."' class='clearfix'><ul class='customize-list'>";

													foreach($ar as $k => $element)
													{
														$help = '';
														$v = '';
														$default = '';
														$break = false;

														if(isset($element['break'])) $break = true;

														if(isset($element['help'])) $help = $element['help'];
														if(isset($element['default']))
														{
															$default = $v = $element['default'];
														}
														if(isset($palette[$k])) $v = $palette[$k];
														
														$this->createSlab($v,$element['label'],$k,$help,$default,$break);

													}	

												echo "</ul></div>";	
												
											}
											

										 ?>


								</div>
							</div>	

						</div>
					</div>
					

						
						


						

		<?php
	

	    
	 }

	
	 function createTypoSlab($block,$values)
	 {
	 	global $super_options,$ioa_google_webfonts,$ioa_websafe_fonts;
	 	
	 	$google_webfonts = array();
	 	foreach ($ioa_google_webfonts as $key => $value) {
	 		$google_webfonts[] = $value['name'];
	 	}


	 	?>

	 	<div class="selection-panel enig-font-slab clearfix" data-id="<?php echo $block['id'] ?>" >
			<h4><?php echo $block['title']; ?></h4>	
				<div class="preview-font">
				  <iframe data-url='<?php echo HURL; ?>/adv_mods/gfont_input.php?font=' class="gfont-frame" src="<?php echo HURL; ?>/adv_mods/gfont_input.php?font=<?php echo $val; ?>" width="100%" height="130"</iframe>
				 </div>

			<?php 
			$val = 'google';
			if(isset($values[SN.'_'.$block['id']."_font_type"])) $val = $values[SN.'_'.$block['id']."_font_type"];

			

			echo $ui->getIOAInput(array(
							"label" => "Select Font Type",
							"name" => SN.'_'.$block['id']."_font_type",
							"type" => "select",
							"default" => 'default',
							"options" => array(  "google" => "Google Web Fonts", "fontface" => "Font Face" , "fontdeck" => "Font Deck" , "websafe" => "Websafe Fonts" ),
							"class" => "enig_font_selector",
							'value' => $val

						));
			?>

			<div class="google enig-typo-filter"> 	
			<?php 
			$val = 'Open Sans';
			if(isset($values[SN.'_'.$block['id']."_google_font"])) $val = $values[SN.'_'.$block['id']."_google_font"];
			echo $ui->getIOAInput(array(
				"label" => "Select Google Web Font",
				"name" => SN.'_'.$block['id']."_google_font",
				"type" => "select",
				"default" => 'Open Sans',
				"options" => $google_webfonts,
				'value' => $val,
				'class' => ' google-font-selector '

			));

			$fn_s = '';
			if(isset($values[SN.'_'.$block['id']."fn_s"])) $fn_s = $values[SN.'_'.$block['id']."fn_s"];

			echo $ui->getIOAInput(array( 
						"label" => __("Select Font Subsets",'ioa') , 
						"name" => SN.'_'.$block['id']."fn_s",
						"default" => '' , 
						"type" => "checkbox",
						"std" => "",
						"options" => array("Cyrillic","Cyrillic Extended","Greek","Greek Extended","Khmer","Latin","Latin Extended","Vietnamese"),
						'value' => $fn_s
					));

			?>
			</div>


			<div class="fontface enig-typo-filter">
				<?php 
				$ff = array();
				$font_face_fonts = get_option(SN.'_fontface_fonts');
				if(!$font_face_fonts) $font_face_fonts = array();

						 foreach ($font_face_fonts as $key => $stack) {
						 		$ff[$key] = $stack['name']; 
						 }

				$ffs = '';
				if(isset($values[SN.'_'.$block['id']."_fontface_font"])) $ffs = $values[SN.'_'.$block['id']."_fontface_font"];

				
				echo $ui->getIOAInput(array( 
										"label" => __("Select Font",'ioa') , 
										"name" => SN.'_'.$block['id']."_fontface_font",
										"default" => '' , 
										"type" => "select",
										"options" => $ff,
										"value" => $ffs
									));

				 ?>

			</div>

				<div class="fontdeck enig-typo-filter">
					
					<div class="ioa-information-p">
						Goto the tab <strong>"FONT DECK"</strong> and add your project settings there . 
					</div>			
			
				</div>

					<div class="websafe enig-typo-filter">
						<?php
						$wf = '';
						if(isset($values[SN.'_'.$block['id']."_websafe_font"])) $wf = $values[SN.'_'.$block['id']."_websafe_font"];

						

						echo $ui->getIOAInput(array( 
												"label" => __("Select Websafe Font",'ioa') , 
												"name" => SN.'_'.$block['id']."_websafe_font",
												"default" => 'default' , 
												"type" => "select",
												"options" => $ioa_websafe_fonts,
												"value" => $wf
											));
											?>
					</div>
					
					<?php if(isset($block['font_size'])) : ?>
					<div class="font-size">
						<?php 

						$wf = $block['font_size'];
						if(isset($values[SN.'_'.$block['id']."_font_size"])) $wf = $values[SN.'_'.$block['id']."_font_size"];

						echo $ui->getIOAInput(array( 
												"label" => __("Set Font Size ",'ioa') , 
												"name" => SN.'_'.$block['id']."_font_size",
												"default" => 0 , 
												"type" => "slider",
												"max" => 200,
												"suffix" => "px",
												"value" => $wf
											));
						 ?>
					</div>
					<?php endif; ?>


		</div>	
		<?php	

	 }

	  function createSlab($value,$label,$name,$help='',$d,$break)
	 {
	 	
	 	
	 	?>
	 		<li class="clearfix <?php if($break) echo 'ls-section-break' ?>">
				<div class="title-area">
					<span><?php echo $label; ?></span>
				</div>

				<?php 
					echo $ui->getIOAInput(array( 
						"label" => "" , 
						"name" => $name,
						"type" => "colorpicker",
						"value" => $value,
						"default" => $d
					));
				 ?>
				<?php if($help!="") : ?>	 <div class="help-icon">? <p><?php echo $help ?></p></div> <?php endif; ?>
			</li>
		<?php
	 }

	
	 

}

