<?php 
/**
 * Core Class For Create RAD Builder Components
 * @author Abhin Sharma 
 * @dependency none
 * @since  IOA Framework V1
 */

global $radunits;


 if(!class_exists('RADUnit'))
{
	class RADUnit
	{
		public $data;
		
		function __construct($data)
		{	
			$this->data = $data;
			$def_style = array();
			
		}


		function getThumb($opts = false)
		{
			$data = $this->data;

			$d ='';

			if(isset($data['data']) )
			{
				foreach ($data['data'] as $key => $v) {
					$d = " data-$key = '$v' ";
				}
			}
			$icon = '';

			if($data['icon']!="") 
				$icon = '<span id="rad-icon-'.$data['id'].'" class="rad-icon ioa-front-icon '.$data['icon'].' " ></span>'; 
			else 
				$icon = '<span id="rad-icon-'.$data['id'].'" class="rad-icon" ></span>';

			if( is_array($opts) && isset($opts['alt']) )
			{
				$de_i = 'C';
				if(isset($data['alt-icon'])) 
					$de_i = $data['alt-icon'];
				$icon = '<span id="rad-icon-'.$data['id'].'" class="rad-icon alt-mode" >'.$de_i.'</span>';
			}

			if(!isset($data['feedback'])) $data['feedback'] = '';

			return '<div class="rad-thumb  cl-'.$data['id'].' cl-'.$data['group'].'" '.$d.' data-group="'.$data['group'].'" data-label="'.$data['label'].'" data-id="'.$data['id'].'" id="thumb-'.$data['id'].'"> '.$icon.' <span class="label">'.$data['label'].'</span> <div class="v-f-d">'.$this->getVisualFeedback($this->getDefaults()).'</div> </div>';
		}
		function mapSettingsOverlay()
		{
			global $rad_defaults;
			$data = $this->data;

			if($data['id']=='rad_page_container_80') $data['id'] = 'rad_page_container';

			$markup = '<div class="settings-pane '.$data['id'].'" data-id="'.$data['id'].'"><div class="rad-widget-settings">';
			$markup .= '<h4> '.$data['heading'].' <span class="custom-id"></span>  </h4><div class="input-section-tabs"><ul class="clearfix">';

			foreach ($data['inputs'] as $key => $values) {
				$markup .= '<li><a href="#'.str_replace(' ','_',$key).'" class=""> '.$key.' </a></li>';
			}

			if(isset($data['styles']))
				$markup .= '<li><a href="#rad_style_'.$data['id'].'">'.__('Widget Custom Style','ioa').'</a></li>';
			
			$markup .= "</ul>";

			foreach ($data['inputs'] as $key => $values) {
				$markup .= '<div id="'.str_replace(' ','_',$key).'">';

					
						if(is_array($values))
						{

							foreach ($values as $key => $input) {

								if( $key === 'supports' )
								{
									if(is_array($input))
									{
										foreach ($input as $subinput) {

											if(isset($rad_defaults[$subinput]['set']))
											{
												foreach ($rad_defaults[$subinput]['inputs'] as  $inp) {
													$markup .= getIOAInput($inp);
												}
											}
											else
												$markup .= getIOAInput($rad_defaults[$subinput]);
										}
									}
									else
										$markup .= getIOAInput($rad_defaults[$input]);	
								}
								else
									{
										$markup .= getIOAInput($input);
									}
							}

						}	

						


				$markup .='</div>';	
			}

			if(isset($data['styles']))
				$markup .=''.$this->getVisualSettings().'';

			$markup .='</div></div>';

			

			$markup .= '</div>';	

			return $markup;
		}

		function getVisualFeedback($values = array())
		{
			$data = $this->data;
			if( isset($data['feedback']) )
			{
				$identifier = ' <div class="rad-identifier"><i class="ioa-front-icon '.$this->data['icon'].'"></i> <span>'.$this->data['label'].'</span></div> ';	
				$feedback = $data['feedback'];

				$cv = '';
						
						 if(isset($values['gallery_images']) && trim($values['gallery_images']) != "" ) : $ar = explode(";",stripslashes($values['gallery_images']));
								$values['gallery_images'] = str_replace('<<','[ioas]', $values['gallery_images']);
									foreach( $ar as $image) :
										if($image!="") :
											$g_opts = explode("[ioas]",$image);
										if(trim($g_opts[0])!="") :
			 						
										$cv .=  "<img src='".$g_opts[0]."' />";
									endif; endif;
								endforeach; 
								endif; 
								$feedback =  str_replace('{gallery_images}', $cv,$feedback);
								

					
				if( isset($values) && is_array($values) )
					foreach ($values as $key => $value) {

						if(!is_array($value))
						$value =  str_replace(array( '&amp;squot;','&amp;quot;','&amp;sqstart;','&amp;sqend;','&lt;' ), array('\'','"','[',']','<'), stripslashes($value)); 
						$value = strip_tags($value);	
						if($key == 'icon' && $value!== "") 
						{
							
							$value = do_shortcode($value);

						}
						
						$feedback = str_replace('{'.$key.'}', $value,$feedback);

					}

				if($this->data['id'] == 'rad_logo_widget')
				{
					$feedback = '<h2>'.__('Showing Logos ').'</h2>';
					if( isset($values['rad_tab']) && $values['rad_tab']!="" ) :
						$tab_data = $values['rad_tab'];
						$tab_data = explode('[ioa_mod]',$tab_data);
						
					  $len = count($tab_data) - 1;


						foreach ($tab_data as $key => $value) {
									
									if($value!="")
									{
										$inpval = array();
										$mods = explode('[inp]', $value);	
										foreach($mods as $m)
										{
											if($m!="")
											{
												$te = (explode('[ioas]',$m));  

												if( count($te) == 1 ) $te = (explode(';',$m));  
												if($te[0] == 'logo_icon')
												{
													$feedback .= '<img src="'.$te[1].'" />';
												}
												
											}
										}
									
									}	
							}
					endif;

				}	
				
				

				return "<div class='v-feedback clearfix'>".$feedback."</div>".$identifier;
			}
			else return '';
		}

		function getStyleKeys()
		{
			$data = $this->data;
			$keys = array();

			if(isset($data['styles']) && is_array($data['styles']))
			foreach ($data['styles'] as $key => $group) {
				
				if(is_array($group))
				foreach ($group as $key => $style) {

					if($style['type']=='slider')
						$keys[] = array( 'name' => $style['name']  , 'data' => $style['data'] , 'type' => $style['type'] , 'suffix' => $style['suffix'] );
					else	
						$keys[] = array( 'name' => $style['name']  , 'data' => $style['data'] , 'type' => $style['type'] );
				}
			}

			return $keys;
		}

		function getVisualSettings()
		{
			
			$data = $this->data;

			if(count($data['styles'])==0) return '';

			$markup = '<div class="rad-styler" id="rad_style_'.$data['id'].'"><div class="visual-settings-pane">';
			
			$markup .= '<div class="inner-visual-settings-panel">';


			if(isset($data['styles']))
			foreach($data['styles'] as $k => $group)
			{

				$markup .= "
						<h3 class='sub-styler-title'>".$k." <a href='' class='style-reset'>Reset</a></h3>
						<div  class=\"rad-styler-section clearfix\">
					";
				if(is_array($group))
				foreach($group as $key => $input)
				{	
					$input['noname'] = true;
					$markup .= getIOAInput($input);
					
				}

			
				$markup .= "</div>";

			}

			$markup .='</div>';	


			$markup .= '</div></div>';	

			return $markup;

		}
		
		// Functions to Generate JSON Values for Builder
		 
		function createWidgetIOAStyles($values = array())
		{
			$data = $this->data;
			
			$markup = array();
			if(isset($data['styles']))
			foreach ($data['styles'] as $key => $v) {
						if(is_array($v))
						{
							
							foreach ($v as $key => $input) {
								$markup[] = "'".$input['name']."'";
							}

						}	
			}
			return join(',',$markup);
		}
		function createWidgetIOAInputs($values = array())
		{
			global $rad_defaults;
			$markup = '';
			$data = $this->data;
			
			$markup = array();

			foreach ($data['inputs'] as $key => $v) {
						if(is_array($v))
						{
							
							foreach ($v as $key => $input) {
								$t = ''; 

								if( $key === 'supports' )
								{
									if(is_array($input))
									{

										foreach ($input as $subinput) {
											$tinput = $rad_defaults[$subinput];
												
											if(isset($tinput['set']))
											{
												foreach ($tinput['inputs'] as  $inp) {
													if(isset($inp['default'])) $t = $inp['default'];
													if(isset($values[$inp['name']])) $t = $values[$inp['name']];
													$markup[] = " { value : '".addslashes($t)."' , name : '".$inp['name']."' }  ";
												}
											}
											else
											{

												if(isset($tinput['default'])) $t = $tinput['default'];
												if(isset($values[$tinput['name']])) $t = $values[$tinput['name']];
												$markup[] = " { value : '".addslashes($t)."' , name : '".$tinput['name']."' }  ";
											}

										}
									}
									else
										{
											$tinput = $rad_defaults[$input];
											if(isset($tinput['default'])) $t = $tinput['default'];
											if(isset($values[$tinput['name']])) $t = $values[$tinput['name']];
											$markup[] = " { value : '".addslashes($t)."' , name : '".$tinput['name']."' }  ";
										}
								}
								else
								{
									if(isset($input['default'])) $t = $input['default'];
									if(isset($values[$input['name']])) $t = $values[$input['name']];
									$markup[] = " { value : '".addslashes($t)."' , name : '".$input['name']."' }  ";
								}
							}

						}	
			}

			if(isset($data['styles']))
			foreach ($data['styles'] as $key => $v) {
						if(is_array($v))
						{
							
							foreach ($v as $key => $input) {
								$t = ''; 
								if(isset($input['default'])) $t = '';
								if(isset($values[$input['name']])) $t = $values[$input['name']];

								$markup[] = " { value : '".($t)."' , name : '".$input['name']."' }  ";
							}

						}	
			}
			return join(',',$markup);
		}

		function getDefaults()
		{
			global $rad_defaults;
			$values = array();
			$data = $this->data;

			foreach ($data['inputs'] as $key => $group) {
				
				foreach ($group as $key => $input) {

					if( $key === 'supports' )
					{
						if(is_array($input))
						{
							foreach ($input as $subinput) {
								$tinput = $rad_defaults[$subinput];

								if(isset($tinput['set']))
											{
												foreach ($tinput['inputs'] as  $inp) {
													if(isset($tinput['default']))
														$values[$inp['name']] = $inp['default'];
													else
														$values[$inp['name']] = '';
												}
											}
								else{

									if(isset($tinput['default']))
										$values[$tinput['name']] = $tinput['default'];
									else
										$values[$tinput['name']] = '';

								}			
								
							}
						}
						else
							{
								$tinput = $rad_defaults[$input];
								if(isset($tinput['default']))
									$values[$tinput['name']] = $tinput['default'];
								else
									$values[$tinput['name']] = '';
							}
					}
					else
					{
						if(isset($input['default']))
							$values[$input['name']] = $input['default'];
						else
							$values[$input['name']] = '';
					}
				}	

			}
			
			return $values;
		}

		function getCommonKey()
		{
			if(isset($this->data['common_key'])) return $this->data['common_key'];
			else return '';
		}

		
	}

}


add_action('after_setup_theme','setupRADUnits');

function setupRADUnits()
{

global $radunits,$ioa_portfolio_slug,$ioa_portfolio_name, $helper;	

/**
 * Widget Defaults & Variables
 */

$demo_imgs = array(
		URL."/sprites/i/demos/d1.JPG",
		URL."/sprites/i/demos/d2.JPG",
		URL."/sprites/i/demos/d3.JPG"
	);

$demo_thumbs = array(
		URL."/sprites/i/demos/d1.JPG",
		URL."/sprites/i/demos/d2.JPG",
		URL."/sprites/i/demos/d3.JPG"
	);

$pmb ='';

$osidebars = array("Blog Sidebar");
if( get_option(SN.'_custom_sidebars'))
{
	$dys = explode(',',get_option(SN.'_custom_sidebars'));
	foreach($dys as $s)
			{
				if($s!="")
				{
					$osidebars[] = $s;
				}
			} 
}

$post_meta_shortcodes =  array(

					"post_author" => array(
							"name" =>  __("Post Author",'ioa'),
							"syntax" => '[post_author_posts_link/]',
							),	
					"post_date" => array(
							"name" =>  __("Post Date",'ioa'),
							"syntax" => '[post_date format=\'l, F d S, Y\'/]',
							),					
					"post_time" => array(
							"name" =>  __("Post Time",'ioa'),
							"syntax" => '[post_time format=\'g:i a\'/]',
							),	
					"post_tags" => array(
							"name" =>  __("Post Tags",'ioa'),
							"syntax" => '[post_tags sep=\',\' icon=\'\' /]',
							),	
					"post_categories" => array(
							"name" =>  __("Post Categories",'ioa'),
							"syntax" => '[post_categories sep=\',\' icon=\'\' /]',
							),
					"get" => array(
							"name" =>  __("Post Meta",'ioa'),
							"syntax" => '[get name=\'\' /]',
							),
					"post_comments" => array(
							"name" => __("Post Comments",'ioa'),
							"syntax" => "[post_comments /]"
							)

						);

foreach($post_meta_shortcodes as $sh) $pmb .= " <a class='button-default' href=\"".$sh['syntax']."\">".$sh['name']."</a> ";
$post_type_array = array("post" => __("Post",'ioa') , $ioa_portfolio_slug => $ioa_portfolio_name);
$query = new WP_Query(array( "post_status" => "publish" , "post_type" => "custompost" , "posts_per_page" => -1 ,'cache_results' => false,'no_found_rows' => true));  

while ($query->have_posts()) : $query->the_post(); 
		$coptions = get_post_meta(get_the_ID(),'options',true);
		$w = $helper->getAssocMap($coptions,'value');
		$post_type_array[$w['post_type']] = get_the_title();
endwhile; 



// Structure Widgets

$radunits['rad_page_section'] = new RADUnit(array(

		'label' => __('Page Section','ioa'),
		'id' => 'rad_page_section',
		'group'	=> 'section',
		'icon' => '',
		'heading' => 'Section Settings',
		'inputs' => array(

				'Layout Settings' => array(
						array( 'name' => 'section_name' , 'type' => 'text' , 'label' => 'Enter Section Name(will be used in export section)' , 'default' => 'Section' ),
						array( 'name' => 'v_padding', 'type' => 'slider', 'max' => 100 , "suffix" => "px" , 'label' => 'Vertical Padding' , 'default' => '' ),
						array( 'name' => 'classes' , 'type' => 'text' , 'label' => 'Enter Custom Classes' , 'default' => '' ),
						array( 'name' => 'visibility' , 'type' => 'checkbox' , 'label' => 'Hide on Devices' , 'default' => 'None' , 'options' => array('None','Screen','iPad Horizontal','iPad Vertical & Small Tablets','Mobile Landscape','Mobile Potrait') ),


					),
				'Background Settings' => array(

					    array( 'name' => 'background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => '' , 'options' =>  array(''=>'','bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient',/*'bg-video'=>'Background Video',*/'custom'=>'Custom') ),
					    array( 'name' => 'background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' sec-bg-listener bg-color '  ),
					    array( 'name' => 'background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' has-input-button sec-bg-listener bg-image bg-texture'  ),
					    array( 'name' => 'background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' sec-bg-listener bg-texture'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
					    array( 'name' => 'background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' sec-bg-listener ' , "options" => array("", "auto","contain","cover") ),
					    array( 'name' => 'background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' sec-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
					    array( 'name' => 'background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' sec-bg-listener bg-texture bg-image' , 'label' =>"Background Attachment" ),
					    array( 'name' => 'background_gradient_dir' ,'default'=>"" , 'class' => ' sec-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
					    array( 'name' => 'start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' sec-bg-listener  bg-gradient'   ),
					    array( 'name' => 'end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '#eeeeee' , 'class' => ' sec-bg-listener  bg-gradient'  ),
						array( 'name' => 'video_url', 'type' => 'video' , 'label' => 'Enter Video Link(MP4 Only) ' , 'default' => '', 'class' => ' sec-bg-listener bg-video'  ),

					),
				'Border Settings' => array(

						array( 'name' => 'border_top_width' , 'type' => 'slider', 'max'=>40 , 'suffix' => 'px' , 'label' => 'Border Top Width' , 'default' => '0' ),
						array( 'name' => 'border_top_color' , 'type' => 'colorpicker' , 'label' => 'Border Top Color' , 'default' => '' ),
						array( 'name' => 'border_top_type' , 'type' => 'select' , 'label' => 'Border Top Type' , 'default' => '' , 'options' => array('','solid','dashed','dotted') ),

						array( 'name' => 'border_bottom_width' , 'type' => 'slider', 'max'=>40 , 'suffix' => 'px' , 'label' => 'Border Bottom Width' , 'default' => '0' ),
						array( 'name' => 'border_bottom_color' , 'type' => 'colorpicker' , 'label' => 'Border Bottom Color' , 'default' => '' ),
						array( 'name' => 'border_bottom_type' , 'type' => 'select' , 'label' => 'Border Bottom Type' , 'default' => '' , 'options' => array('','solid','dashed','dotted') ),


					)

			) 

	));

$container_settings  = array(
		'common_key' => 'c',
		'label' => __('Column','ioa'),
		'id' => 'rad_page_container',
		'group'	=> 'structure',
		'icon' => '',
		'heading' => 'Container Settings',
		'data' => array('default' => 'full'),
		'inputs' => array(

				'Layout Settings' => array(

						array( 'name' => 'classes' , 'type' => 'text' , 'label' => 'Enter Custom Classes' , 'default' => '' ),
						array( 'name' => 'visibility' , 'type' => 'checkbox' , 'label' => 'Hide on Devices' , 'default' => 'None' , 'options' => array('None','Screen','iPad Horizontal','iPad Vertical & Small Tablets','Mobile Landscape','Mobile Potrait') ),
						array( "label" => __("Column Alignment",'ioa') , "name" => "float" , "default" => "left" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("left" => __("Left",'ioa'),"right" => __("Right",'ioa'),"auto_align" => __("Center",'ioa')) , "data" => array("attr" => "float-test" )  )  ,

					),
				'Background Settings' => array(

					    array( 'name' => 'background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => '' , 'options' =>  array(''=>'none','bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient','custom'=>'Custom') ),
					    array( 'name' => 'background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' sec-bg-listener bg-color '  ),
					    array( 'name' => 'background_opacity', 'type' => 'text' , 'label' => 'Background Opacity' , 'default' => '' , 'class' => ' sec-bg-listener bg-color '  ),
					    array( 'name' => 'background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' sec-bg-listener bg-image bg-texture has-input-button'  ),
					    array( 'name' => 'background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' sec-bg-listener bg-texture'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
					    array( 'name' => 'background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' sec-bg-listener ' , "options" => array("", "auto","contain","cover") ),
					    array( 'name' => 'background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' sec-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
					    array( 'name' => 'background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' sec-bg-listener bg-texture bg-image' , 'label' =>"Background Attachment" ),
					    array( 'name' => 'background_gradient_dir' ,'default'=>"" , 'class' => ' sec-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
					    array( 'name' => 'start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' sec-bg-listener  bg-gradient'   ),
					    array( 'name' => 'end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '#eeeeee' , 'class' => ' sec-bg-listener  bg-gradient'  ),

					),
				'Border Settings' => array(

						array( 'name' => 'border_top_width' ,  'type' => 'slider', 'max'=>40 , 'suffix' => 'px', 'label' => 'Border Top Width' , 'default' => '0' ),
						array( 'name' => 'border_top_color' , 'type' => 'colorpicker' , 'label' => 'Border Top Color' , 'default' => '' ),
						array( 'name' => 'border_top_type' , 'type' => 'select' , 'label' => 'Border Top Type' , 'default' => '' , 'options' => array('','solid','dashed','dotted') ),

						array( 'name' => 'border_bottom_width' ,  'type' => 'slider', 'max'=>40 , 'suffix' => 'px', 'label' => 'Border Bottom Width' , 'default' => '0' ),
						array( 'name' => 'border_bottom_color' , 'type' => 'colorpicker' , 'label' => 'Border Bottom Color' , 'default' => '' ),
						array( 'name' => 'border_bottom_type' , 'type' => 'select' , 'label' => 'Border Bottom Type' , 'default' => '' , 'options' => array('','solid','dashed','dotted') ),


					)

			) 

	);

$variants = array(

	'rad_page_container' =>	array( "data" => array('default'=>'full') , "label" => 'Column'   ),
	'rad_page_container_50' =>	array( "id"=>"rad_page_container_50","data" => array('default'=>'one_half') , "label" => '1/2 Column'  ),
	'rad_page_container_33' =>	array( "id"=>"rad_page_container_33","data" => array('default'=>'one_third') , "label" => '1/3 Column'  ),
	'rad_page_container_25' =>	array( "id"=>"rad_page_container_25","data" => array('default'=>'one_fourth') , "label" => '1/4 Column'  ),
	'rad_page_container_20' =>	array( "id"=>"rad_page_container_20","data" => array('default'=>'one_fifth') , "label" => '1/5 Column'  ),
	'rad_page_container_66' =>	array( "id"=>"rad_page_container_66","data" => array('default'=>'two_third') , "label" => '2/3 Column'  ),
	'rad_page_container_75' =>	array( "id"=>"rad_page_container_75","data" => array('default'=>'three_fourth') , "label" => '3/4 Column'  ),
	'rad_page_container_80' =>	array( "id"=>"rad_page_container_80","data" => array('default'=>'four_fifth') , "label" => '4/5 Column'  ),

	);

foreach ($variants as $key => $col) {
	$temp = array_merge($container_settings,$col);
	$radunits[$key] = new RADUnit($temp);
}


$radunits['rad_text_widget'] = new RADUnit(array(
	'label' => __('Text','ioa'),
	'id' => 'rad_text_widget',
	'template' => 'text',
	'group'	=> 'widgets',
	'icon' => 'text-widthicon-',
	'heading' => 'Text Settings',
	'feedback' => " <div class='text-icon vf-icon'>{icon}</div> <div class='text-info'> <h2 class='vf-text_title'>{text_title}</h2><h4 class='vf-text_subtitle'>{text_subtitle}</h4> <div class='vtext vf-text_data'>{text_data}</div> </div> ",
	'inputs' => array(
			__("General Fields",'ioa') => array(

			array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
			array(  "label" => __("Subtitle",'ioa') , "name" => "text_subtitle" ,"default" => "Sub Title" ,"type" => "text","description" => "","length" => 'medium')  ,
			array( "label" => __("Text",'ioa') , "name" => "text_data" , "default" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultrices, nisl ac lobortis ultrices, enim dolor malesuada risus, id lacinia sapien metus scelerisque mauris. Aliquam elementum a libero nec euismod. Nunc ut sapien et augue faucibus aliquam. " , "type" => "textarea", "description" => "", "length" => 'medium' , 'addMarkup' => '<a href="" class="button-default ioa-editor-trigger">'.__('Use WP Editor','ioa').'</a>' ) 
			),

			__("Layout Fields",'ioa') => array(
			array( "label" => __("Text Alignment",'ioa') , "name" => "col_alignment" , "default" => "left" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("left" => "Left","right" => "Right","center" =>"Center","justify" => "Justify") , "data" => array("attr" => "text-align" , "el" => ".text-inner-wrap")  )  ,
			array(  "label" => __("Column Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
			array(  "label" => __("Column Animation Delay in milli seconds",'ioa') , "name" => "delay" , "default" => "" , "type" => "text", "description" => "", "length" => 'medium'  ),
			array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => "No","yes" => "Yes") , "data" => array("attr" => "clear-float" )  )  ,
			
			),

			__("Icon Fields",'ioa') => array(  
			array(  "label" => __("Set Icon",'ioa') , "name" => "icon" ,"default" => "" ,"type" => "text","after_input" => "<a href='' class='scrouge add-rad-icon button'>".__('Set Icon','ioa')."</a>" ,"description" => "","length" => 'medium' , "class" => 'has-input-button')  ,
			array(  "label" => __("Icon Top Margin Correction" ,'ioa') ,  "name" => "icon_margin" ,"default" => "5" ,"type" => "text","description" => "","length" => 'medium', "data" => array("attr" => "top-margin" , "el" => "div.icon"))  ,
			array(  "label" => __("Icon Alignment",'ioa') , "name" => "icon_alignment" ,  "default" => "left" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("left" => __("Left",'ioa'),"right" => __("Right",'ioa'),"none" => __("Top Center",'ioa')  ) , "data" => array("attr" => "icon-align" , "el" => ".icon")  )  ,
			array(  "label" => __("Icon Animation on Hover",'ioa') , "name" => "icon_animation" ,"meta" => true, "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "flash" => __("Flash",'ioa') , "bounce" => __("Bounce",'ioa') , "shake" => __("Shake",'ioa') , "tada" => __("Tada",'ioa') ,"swing" => __("Swing",'ioa') , "wobble" => __("Wobble",'ioa') , "wiggle" => __("Wiggle",'ioa') , "pulse" => __("Pulse",'ioa'))  )

			)

		),

	'styles' => array(
			__("Columns Styling",'ioa') => array(
					array( 
						"label" => __("Title Color",'ioa') , "name" => "title_color" , "default" => "" ,"type" => "colorpicker","description" => "","value" => "",
						 "data" => array( "target" => " div.text-inner-wrap h2.text_title " ,"property" => "color" )     
					),
					array( 
						"label" => __("Subtitle Color",'ioa') , "name" => "subtitle_color" , "default" => "" , "type" => "colorpicker","description" => "","value" => "",
						 "data" => array("target" => " div.text-inner-wrap h4.text_subtitle " ,"property" => "color" )     
					),
					array( 
						"label" => __("Text Color",'ioa') , 
						"name" => "text_color" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"value" => "",
						 "data" => array(

					 			"target" => " div.text-inner-wrap div.text " ,
					 			"property" => "color" 

		 					)     
					)

				),

			__("Font Size Settings",'ioa') => array(

					array( 
						"label" => __("Title Size",'ioa') , 
						"name" => "title_size" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"max" => 100,
						"value" => 0 ,
						"suffix" => "px",
						 "data" => array(

					 			"target" => " div.text-inner-wrap h2.text_title " ,
					 			"property" => "font-size" 

		 				)     
					),
					array( 
						"label" => __("Title Font Weight",'ioa') , 
						"name" => "title_w" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h2.text_title " ,
					 			"property" => "font-weight" 

		 				)     
					),
					array( 
						"label" => __("Subtitle Size",'ioa') , 
						"name" => "subtitle_size" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h4.text_subtitle " ,
					 			"property" => "font-size" 

		 				)     
				),
					array( 
						"label" => __("Subtitle Font Weight",'ioa') , 
						"name" => "subtitle_w" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h4.text_subtitle " ,
					 			"property" => "font-weight" 

		 				)     
					),
					array( 
						"label" => __("Text Size",'ioa') , 
						"name" => "text_size" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap div.text " ,
					 			"property" => "font-size" 

		 					)     
					)

				),

			
			__("Margin Settings",'ioa') => array(

					array( 
						"label" => __("Column Bottom Margin",'ioa') , 
						"name" => "cb_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap " ,
					 			"property" => "margin-bottom" 

		 				)     
					),

					array( 
						"label" => __("Column Top Margin",'ioa') , 
						"name" => "ct_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap " ,
					 			"property" => "margin-top" 

		 				)     
					),
					array( 
						"label" => __("Title Top Margin",'ioa') , 
						"name" => "tt_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h2.text_title " ,
					 			"property" => "margin-top" 

		 				)     
				),
					array( 
						"label" => __("Subtitle Top Margin",'ioa') , 
						"name" => "st_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h4.text_subtitle " ,
					 			"property" => "margin-top" 

		 				)     
				),
				
					array( 
						"label" => __("Text Top Margin",'ioa') , 
						"name" => "tet_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap div.text " ,
					 			"property" => "margin-top" 

		 					)     
					)

				)

		)		

	));

/**
 * RAW HTML Widget
 */

$radunits['rad_html_widget'] = new RADUnit(array(
	'label' => __('HTML Text','ioa'),
	'id' => 'rad_html_widget',
	'template' => 'html',
	'group'	=> 'widgets',
	'icon' => 'html5-1icon-',
	'heading' => 'HTML Text Settings',
	'feedback' => " <div class='text-info'> <h2 class='vf-text_title'>{text_title}</h2><h4 class='vf-text_subtitle'>{text_subtitle}</h4> <div class='vtext vf-text_data'>{text_data}</div> </div> ",
	'inputs' => array(
			__("General Fields",'ioa') => array(

			array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
			array(  "label" => __("Subtitle",'ioa') , "name" => "text_subtitle" ,"default" => "Sub Title" ,"type" => "text","description" => "","length" => 'medium')  ,
			array( "label" => __("Text",'ioa') , "name" => "text_data" , "default" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultrices, nisl ac lobortis ultrices, enim dolor malesuada risus, id lacinia sapien metus scelerisque mauris. Aliquam elementum a libero nec euismod. Nunc ut sapien et augue faucibus aliquam. " , "type" => "textarea", "description" => "", "length" => 'medium') 
			),

			__("Layout Fields",'ioa') => array(
			array( "label" => __("Text Alignment",'ioa') , "name" => "col_alignment" , "default" => "left" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("left" => "Left","right" => "Right","center" =>"Center","justify" => "Justify") , "data" => array("attr" => "text-align" , "el" => ".text-inner-wrap")  )  ,
			array(  "label" => __("Column Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
			array(  "label" => __("Column Animation Delay in milli seconds",'ioa') , "name" => "delay" , "default" => "" , "type" => "text", "description" => "", "length" => 'medium'  ),
			array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => "No","yes" => "Yes") , "data" => array("attr" => "clear-float" )  )  ,
			
			),


		),

	'styles' => array(
			__("Columns Styling",'ioa') => array(
					array( 
						"label" => __("Title Color",'ioa') , "name" => "title_color" , "default" => "" ,"type" => "colorpicker","description" => "","value" => "",
						 "data" => array( "target" => " div.text-inner-wrap h2.text_title " ,"property" => "color" )     
					),
					array( 
						"label" => __("Subtitle Color",'ioa') , "name" => "subtitle_color" , "default" => "" , "type" => "colorpicker","description" => "","value" => "",
						 "data" => array("target" => " div.text-inner-wrap h4.text_subtitle " ,"property" => "color" )     
					),
					array( 
						"label" => __("Text Color",'ioa') , 
						"name" => "text_color" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"value" => "",
						 "data" => array(

					 			"target" => " div.text-inner-wrap div.text " ,
					 			"property" => "color" 

		 					)     
					)

				),

			__("Font Size Settings",'ioa') => array(

					array( 
						"label" => __("Title Size",'ioa') , 
						"name" => "title_size" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"max" => 100,
						"value" => 0 ,
						"suffix" => "px",
						 "data" => array(

					 			"target" => " div.text-inner-wrap h2.text_title " ,
					 			"property" => "font-size" 

		 				)     
					),
					array( 
						"label" => __("Title Font Weight",'ioa') , 
						"name" => "title_w" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h2.text_title " ,
					 			"property" => "font-weight" 

		 				)     
					),
					array( 
						"label" => __("Subtitle Size",'ioa') , 
						"name" => "subtitle_size" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h4.text_subtitle " ,
					 			"property" => "font-size" 

		 				)     
				),
					array( 
						"label" => __("Subtitle Font Weight",'ioa') , 
						"name" => "subtitle_w" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h4.text_subtitle " ,
					 			"property" => "font-weight" 

		 				)     
					),
					array( 
						"label" => __("Text Size",'ioa') , 
						"name" => "text_size" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap div.text " ,
					 			"property" => "font-size" 

		 					)     
					)

				),

			
			__("Margin Settings",'ioa') => array(

					array( 
						"label" => __("Column Bottom Margin",'ioa') , 
						"name" => "cb_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap " ,
					 			"property" => "margin-bottom" 

		 				)     
					),

					array( 
						"label" => __("Column Top Margin",'ioa') , 
						"name" => "ct_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap " ,
					 			"property" => "margin-top" 

		 				)     
					),
					array( 
						"label" => __("Title Top Margin",'ioa') , 
						"name" => "tt_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h2.text_title " ,
					 			"property" => "margin-top" 

		 				)     
				),
					array( 
						"label" => __("Subtitle Top Margin",'ioa') , 
						"name" => "st_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap h4.text_subtitle " ,
					 			"property" => "margin-top" 

		 				)     
				),
				
					array( 
						"label" => __("Text Top Margin",'ioa') , 
						"name" => "tet_margin" , 
						"default" => "" , 
						"type" => "slider",
						"description" => "",
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.text-inner-wrap div.text " ,
					 			"property" => "margin-top" 

		 					)     
					)

				)

		)		

	));


/**
 * Sidebar
 */

$radunits['rad_sidebar_widget'] = new RADUnit(array(
	'label' => __('Sidebar','ioa'),
	'id' => 'rad_sidebar_widget',
	'template' => 'sidebar',
	'group'	=> 'widgets',
	'icon' => 'columnsicon- ',
	'heading' => 'Sidebar Settings',
	'feedback' => "  <div class='text-info'> ".__('This  Area will show widgets from ','ioa')." - <strong class='vf-sidebar_v'>{sidebar_v}</strong> </div> ",
	'inputs' => array(
			__("General Fields",'ioa') => array(

							array( "label" => __("Select Sidebar",'ioa') , "name" => "sidebar_v" , "default" => "Blog Sidebar" ,"meta" => true, "type" => "select", "description" => "", "length" => 'medium'  , "options" => $osidebars )  ,
							array( "label" => __("Set Sidebar Behavior",'ioa') , "name" => "sidebar_behavior" , "default" => "right-sidebar" ,"meta" => true, "type" => "select", "description" => "", "length" => 'medium'  , "options" => array( "right-sidebar" => "Right Sidebar" , "left-sidebar" => "Left Sidebar" ) )  ,
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" ,"meta" => true, "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => "No","yes" => "Yes") , "data" => array("attr" => "clear-float" )  )  ,
							
							)

		),

	'styles' => array( 

		__("Basic Styling",'ioa') => array(

										array( 
											"label" => __("Widget Title Color",'ioa') , 
											"name" => "swtc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#444444",
											 "data" => array(

										 			"target" => " .sidebar-wrap h3.heading " ,
										 			"property" => "color" 

							 				)     
										),	
										array( 
											"label" => __("Below Title Border Color",'ioa') , 
											"name" => "swbtbc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#dddddd",
											 "data" => array(

										 			"target" => " .sidebar-wrap span.spacer " ,
										 			"property" => "border-color" 

							 				)     
										),	
										array( 
											"label" => __("Below Sidebar Border Color",'ioa') , 
											"name" => "swbsbc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#eeeeee",
											 "data" => array(

										 			"target" => " .sidebar .widget-tail " ,
										 			"property" => "border-color" 

							 				)     
										),	
										array( 
											"label" => __("List Border Color",'ioa') , 
											"name" => "swlbc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#aaaaaa",
											 "data" => array(

										 			"target" => " .sidebar-wrap ul li " ,
										 			"property" => "border-color" 

							 				)     
										),
										array( 
											"label" => __("List Text Color",'ioa') , 
											"name" => "swltc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#aaaaaa",
											 "data" => array(

										 			"target" => " .sidebar-wrap ul li " ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Text Color",'ioa') , 
											"name" => "swtcs" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#aaaaaa",
											 "data" => array(

										 			"target" => " .sidebar-wrap " ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Link Color",'ioa') , 
											"name" => "swlc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#647A7A",
											 "data" => array(

										 			"target" => " .sidebar-wrap ul li a" ,
										 			"property" => "color" 

							 				)     
										),		
									),
								__("Inputs Styling",'ioa') => array( 

									
									array( 
											"label" => __("Text Field Color",'ioa') , 
											"name" => "swtfc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#777777",
											 "data" => array(

										 			"target" => " div.sidebar-inner-wrap .sidebar div.sidebar-wrap input[type=text] " ,
										 			"property" => "color" 

							 				)     
										),
									array( 
											"label" => __("Text Field Background Color",'ioa') , 
											"name" => "swtfbc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => " div.sidebar-inner-wrap .sidebar div.sidebar-wrap input[type=text] " ,
										 			"property" => "background-color" 

							 				)     
										),
									array( 
											"label" => __("Text Field Border Color",'ioa') , 
											"name" => "swrfbrc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#dddddd",
											 "data" => array(

										 			"target" => " div.sidebar-inner-wrap .sidebar div.sidebar-wrap input[type=text] " ,
										 			"property" => "border-color" 

							 				)     
										),
									array( 
											"label" => __("Submit Background Color",'ioa') , 
											"name" => "swsbgc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#0DD7CB",
											 "data" => array(

										 			"target" => " div.sidebar-wrap input[type=submit]" ,
										 			"property" => "background-color" 

							 				)     
										),
									array( 
											"label" => __("Submit Text Color",'ioa') , 
											"name" => "swstexc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#fff",
											 "data" => array(

										 			"target" => " div.sidebar-wrap input[type=submit]" ,
										 			"property" => "color" 

							 				)     
										),			

									)

		)

	));

/**
 * Gallery
 */


$radunits['rad_gallery_widget'] = new RADUnit(array(
	'label' => __('Gallery','ioa'),
	'id' => 'rad_gallery_widget',
	'template' => 'gallery',
	'group'	=> 'media',
	'icon' => 'laptopicon-',
	'heading' => 'Gallery Settings',
	'feedback' => "  <div class='rad-gallery-info clearfix'> {gallery_images} </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "400" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array(  "label" => __("Width",'ioa') , "name" => "width" ,"default" => "400" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
					array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
					
					),

					__("Images",'ioa') => array(

					array( "label" => __("Set Images",'ioa') , "name" => "gallery_images" , "default" =>  "" , "type" => "hidden", "description" => "", "length" => 'medium' , "after_input" => "<a href='' data-title='Add to Gallery' data-label='Add' class='rad_gallery_upload button-default'> ".__("Add Images",'ioa')." </a>  <ul class='clearfix rad_gallery_thumbs'>  </ul> "  )  ,
					 
					),
					__("Settings",'ioa') =>  array( 

					array( "label" => __("Slide Show Time(in secs)",'ioa') , "name" => "duration" , "default" => "4" , "value" => 0 , "max" =>300 , "suffix" => '', "type" => "slider", "description" => "", "length" => 'small') ,
					array( "label" => __("Autoplay",'ioa') , "name" => "autoplay" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
					array( "label" => __("Captions",'ioa') , "name" => "captions" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
					array( "label" => __("Controls",'ioa') , "name" => "arrow_control" , "default" => "true" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
					array( "label" => __("Thumbnail",'ioa') , "name" => "bullets" , "default" => "true" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
					array(  "label" =>__( "Gallery Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
					
					)


					 ),

	'styles' => array(

					__("General Styling",'ioa') => array(

										array( 
											"label" => __("Widget Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#596A67",
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "color" 

							 				)     
										),
										
										array( 
											"label" => __("Thumbnail Border Color",'ioa') , 
											"name" => "sth_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#f4f4f4",
											 "data" => array(

										 			"target" => " .seleneGallery ul.selene-thumbnails li " ,
										 			"property" => "border-color" 

							 				)     
										),

									),
								__("Gallery Controls",'ioa') => array(

										array( 
											"label" => __("Arrow Color",'ioa') , 
											"name" => "ar_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#888888",
											 "data" => array(

										 			"target" => " .seleneGallery div.selene-controls-wrap a" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Arrow Background Color",'ioa') , 
											"name" => "ar_bgcolor" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => " .seleneGallery div.selene-controls-wrap a" ,
										 			"property" => "background-color" 

							 				)     
										),

								)
		)		

	));


/**
 * Posts List
 */

$radunits['rad_post_list_widget'] = new RADUnit(array(
	'label' => __('Posts List','ioa'),
	'id' => 'rad_post_list_widget',
	'template' => 'post_list',
	'group'	=> 'advance',
	'icon' => 'list-bulleticon- ',
	'heading' => 'Posts List Settings',
	'feedback' => " <div class='rad-post-list-info clearfix'> <i class='list-bulleticon- ioa-front-icon'></i> <h2 class='vf-text_title'>{text_title}</h2> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items in <strong class='vf-post_structure'>{post_structure}</strong> format. </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array( "label" => __("Post Structure",'ioa') , "name" => "post_structure" , "default" => "post-thumbs" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("post-list" => __("Plain Lists",'ioa'),"post-thumbs" => __("Lists with Thumbnails",'ioa'))   )  ,
					array(  "label" => __("Numbe of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array(  "label" => __("Extra Information",'ioa') , "name" => "meta_value" ,"default" => "[post_comments/]" ,"type" => "textarea", "description" => "", "length" => 'medium', "after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", "buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>") ,
					),

					__("Post Filter",'ioa') => array(
					array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "post" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => $post_type_array   )  ,
					array( "label" => __("Show Small Summary(Excerpt)",'ioa') , "name" => "excerpt" , "default" => "yes" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,
					array( "label" => __("Show Pagination",'ioa') , "name" => "w_pagination" , "default" => "no" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,
					
					array(  "label" => __("Summary Content limit",'ioa') , "name" => "excerpt_length" ,"default" => "150" ,"type" => "text", "description" => "", "length" => 'medium') ,
					
					array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
					array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>' , "class" => 'has-input-button' ) ,
					),

					__("Animation",'ioa') => array(

					array(  "label" => __("Posts Animation Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
					array(  "label" => __("Posts Items Animation Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					)

			),

	'styles' => array(

			__("Columns Styling",'ioa') => array(

										array( 
											"label" => __("Widget Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#596A67",
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "color" 

							 				)     
										),
										

									),

								__("Font Size Settings",'ioa') => array(

										array( 
											"label" => __("Widget Title Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "16" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 16,
											"max" => 100,
											"suffix" => 'px',
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Widget Title Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											'steps' => 100,
											"suffix" => '',
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "font-weight" 

							 				)     
										) 
								

									),

								
								__("Post Stylings",'ioa') => array(

										
										array( 
											"label" => __("Post Heading Color",'ioa') , 
											"name" => "phc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333333",
											 "data" => array(

										 			"target" => " ul.posts li h2 a " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Post Extras Color",'ioa') , 
											"name" => "pec" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#999999",
											 "data" => array(

										 			"target" => " ul.posts div.extras " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Post Extras Link Color",'ioa') , 
											"name" => "pelc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#999999",
											 "data" => array(

										 			"target" => " ul.posts div.extras a " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Post Extras Icon Color",'ioa') , 
											"name" => "peic" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#4BC1A9",
											 "data" => array(

										 			"target" => " ul.posts div.extras i.icon " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Post Excerpt Color",'ioa') , 
											"name" => "pexc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#757575",
											 "data" => array(

										 			"target" => " ul.posts div.desc p " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Image Border Color",'ioa') , 
											"name" => "ibc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#f4f4f4",
											 "data" => array(

										 			"target" => " div.post_list-inner-wrap div.image " ,
										 			"property" => "border-color" 

							 					)     
										)
										
										

									),
								__('Pagination','ioa') => array(

									array( 
											"label" => __("Pagination Current Page Color",'ioa') , 
											"name" => "pcpcp" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => " div.pagination ul li span.current " ,
										 			"property" => "color" 

							 					)     
										),
									array( 
											"label" => __("Pagination Current Page Background Color",'ioa') , 
											"name" => "pcpbc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#1F2323",
											 "data" => array(

										 			"target" => " div.pagination ul li span.current " ,
										 			"property" => "background-color" 

							 					)     
										),
									array( 
											"label" => __("Pagination Buttons Text Color",'ioa') , 
											"name" => "pbtc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => " div.pagination ul li a " ,
										 			"property" => "color" 

							 					)     
										),
									array( 
											"label" => __("Pagination Buttons Text Background Color",'ioa') , 
											"name" => "pbtbc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#1F2323",
											 "data" => array(

										 			"target" => " div.pagination ul li a " ,
										 			"property" => "background-color" 

							 					)     
										),


									)

	 )
	));


/**
 * Posts Slider
 */

$radunits['rad_post_slider_widget'] = new RADUnit(array(
	'label' => __('Posts Slider','ioa'),
	'id' => 'rad_post_slider_widget',
	'template' => 'post_slider',
	'group'	=> 'advance',
	'icon' => 'picture-2icon- ',
	'heading' => 'Posts Slider Settings',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-text_title'>{text_title}</h4> Slider has <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items . </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array(  "label" => __("More Button Label",'ioa') , "name" => "more_label" ,"default" => "More" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "post" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => $post_type_array   )  ,
					array(  "label" => __("Summary Content limit",'ioa') , "name" => "excerpt_length" ,"default" => "150" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
					array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>' , "class" => 'has-input-button') ,
					
		
					),
					__('Slider Settings','ioa') => array(

					array(  "label" => __("Slider Width",'ioa') , "name" => "width" ,"default" => "500" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
					array(  "label" => __("Slider Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array( "label" => __("Slide Show Time(in secs)",'ioa') , "name" => "duration" , "default" => "0" , "type" => "text", "description" => "", "length" => 'small') ,
					array( "label" => __("Autoplay",'ioa') , "name" => "autoplay" , "default" => "true" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) )  ,
					

						),

					__("Animation",'ioa') => array(

					array(  "label" => __("Posts Animation Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					)

			),

	'styles' => array(

			__("Columns Styling",'ioa') => array(

					array( 
						"label" => __("Widget Title Color",'ioa') , 
						"name" => "title_color" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "#596A67",
						 "data" => array(

					 			"target" => " div.text-title-wrap h2.text_title " ,
					 			"property" => "color" 

		 				)     
					),

				),

			__("Font Size Settings",'ioa') => array(

					array( 
											"label" => __("Widget Title Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "16" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 16,
											"max" => 100,
											"suffix" => 'px',
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Widget Title Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											'steps' => 100,
											"suffix" => '',
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "font-weight" 

							 				)     
										) 
			

				),

			__("Slider Controls Stylings",'ioa') => array(

				array( 
						"label" => __("Controls Color",'ioa') , 
						"name" => "coc" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "#0DD7CB",
						 "data" => array(

					 			"target" => " div.quartz-controls-wrap > a " ,
					 			"property" => "color" 

		 					)     
					),
				array( 
						"label" => __("Controls Background Color",'ioa') , 
						"name" => "cobc" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "",
						 "data" => array(

					 			"target" => " div.quartz-controls-wrap > a " ,
					 			"property" => "background-color" 

		 					)     
					),
				array( 
						"label" => __("Progress bar Background Color",'ioa') , 
						"name" => "pcoc" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "#4FB8E3",
						 "data" => array(

					 			"target" => ".quartz span.progress-bar " ,
					 			"property" => "background-color" 

		 					)     
					)
				

				)

	 )
	));


/**
 * Posts Grid
 */

$radunits['rad_post_grid_widget'] = new RADUnit(array(
	'label' => __('Posts Grid','ioa'),
	'id' => 'rad_post_grid_widget',
	'template' => 'post_grid',
	'group'	=> 'advance',
	'icon' => 'th-1icon-',
	'feedback' => " <div class='rad-post-list-info clearfix'> <i class='th-1icon- ioa-front-icon'></i> <h2 class='vf-text_title'>{text_title}</h2> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items in <strong class='vf-post_structure'>{post_structure}</strong> format. </div> ",
	'heading' => 'Posts Grid Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

						array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Recent Work" ,"type" => "text", "description" => "", "length" => 'medium') ,
						array( "label" => __("Post Structure",'ioa') , "name" => "post_structure" , "default" => "4-col" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("1-col" => __("Featured Column",'ioa'),"2-col" => __("Two Columns",'ioa'),"3-col" => __("Three Columns",'ioa'),"4-col" => __("Four Columns",'ioa'),"5-col" => __("Five Columns",'ioa'),"6-col" => __("Six Columns",'ioa'))   )  ,
						array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text", "description" => "", "length" => 'medium') ,
						array(  "label" => __("Extra Information",'ioa') , "name" => "meta_value" ,"default" => "[post_comments/]" ,"type" => "textarea", "description" => "", "length" => 'medium', "after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", "buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>") ,

					),
					__("Post Filter",'ioa') => array(

						array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "portfolio" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => $post_type_array   )  ,
						array( "label" => __("Show Small Summary(Excerpt)",'ioa') , "name" => "excerpt" , "default" => "yes" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa') )   )  ,
						array(  "label" => __("Summary Content limit",'ioa') , "name" => "excerpt_length" ,"default" => "150" ,"type" => "text", "description" => "", "length" => 'medium') ,
						array( "label" => __("Show Pagination",'ioa') , "name" => "w_pagination" , "default" => "no" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,
						
						array( "label" => __("Show Filter",'ioa') , "name" => "filter_menu" , "default" => "no" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa') )  )  ,
						
						array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa') ) , "data" => array("attr" => "clear-float" )  )  ,
						array(  "label" => __("WP Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>' , "class" => 'has-input-button'  ) ,

					),
					__("Animation",'ioa') => array(

						array(  "label" => __("Posts Animation Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
						array(  "label" => __("Posts Items Animation Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					)

			),

	'styles' => array(

			__("Columns Styling",'ioa') => array(

										array( 
											"label" => __("Widget Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#596A67",
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "color" 

							 				)     
										),
									),

								__("Font Size Settings",'ioa') => array(

										array( 
											"label" => __("Widget Title Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "16" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 16,
											"max" => 100,
											"suffix" => 'px',
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Widget Title Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											'steps' => 100,
											"suffix" => '',
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "font-weight" 

							 				)     
										) 
								

									),

								
								__("Post Stylings",'ioa') => array(

										
										
										array( 
											"label" => __("Post Heading Color",'ioa') , 
											"name" => "phc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333333",
											 "data" => array(

										 			"target" => " ul.posts li h2 a " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Post Extras Color",'ioa') , 
											"name" => "pec" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#999999",
											 "data" => array(

										 			"target" => " ul.posts div.extras " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Post Extras Link Color",'ioa') , 
											"name" => "pelc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#999999",
											 "data" => array(

										 			"target" => " ul.posts div.extras a " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Post Extras Icon Color",'ioa') , 
											"name" => "peic" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#4BC1A9",
											 "data" => array(

										 			"target" => " ul.posts div.extras i.icon " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Post Excerpt Color",'ioa') , 
											"name" => "pecx" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#757575",
											 "data" => array(

										 			"target" => " ul.posts div.desc p " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Image Border Color",'ioa') , 
											"name" => "ibc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#f4f4f4",
											 "data" => array(

										 			"target" => " div.post_grid-inner-wrap div.image " ,
										 			"property" => "border-color" 

							 					)     
										)
										
										

									),
								__('Pagination','ioa') => array(

									array( 
											"label" => __("Pagination Current Page Color",'ioa') , 
											"name" => "pcpc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => " div.pagination ul li span.current " ,
										 			"property" => "color" 

							 					)     
										),
									array( 
											"label" => __("Pagination Current Page Background Color",'ioa') , 
											"name" => "pcpbc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#1F2323",
											 "data" => array(

										 			"target" => " div.pagination ul li span.current " ,
										 			"property" => "background-color" 

							 					)     
										),
									array( 
											"label" => __("Pagination Buttons Text Color",'ioa') , 
											"name" => "pbtc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => " div.pagination ul li a " ,
										 			"property" => "color" 

							 					)     
										),
									array( 
											"label" => __("Pagination Buttons Text Background Color",'ioa') , 
											"name" => "pbtevc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#1F2323",
											 "data" => array(

										 			"target" => " div.pagination ul li a " ,
										 			"property" => "background-color" 

							 					)     
										),


									)	

	 )

	));


/**
 * Intro Widget
 */

$radunits['rad_intro_widget'] = new RADUnit(array(
	'label' => __('Intro Title','ioa'),
	'id' => 'rad_intro_widget',
	'template' => 'intro_title',
	'group'	=> 'widgets',
	'feedback' => '<div class="rad-intro-info"><h2 class="vf-text_title">{text_title}</h2><h4 class="vf-text_subtitle">{text_subtitle}</h4></div>',
	'icon' => 'align-lefticon- ',
	'heading' => 'Intro Title Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array(  "label" => __("First Text",'ioa') , "name" => "text_subtitle" ,"default" => "Sub Title Here" ,"type" => "text","description" => "","length" => 'medium')  ,
							array(  "label" => __("Hero Title",'ioa') , "name" => "text_title" ,"default" => "Main Title Here" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Show Bottom Line",'ioa') , "name" => "show_bottom_line" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa') )  )  ,
							
							array(  "label" => __("Bottom Line on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
							
							),

							__("Layout Fields",'ioa') => array(
							array( "label" => __("Column Alignment",'ioa') , "name" => "col_alignment" , "default" => "left" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("left" => __("Left",'ioa'),"right" => __("Right",'ioa'),"center" =>__("Center",'ioa'),"justify" => __("Justify",'ioa')) , "data" => array("attr" => "text-align" , "el" => ".intro_title-title-inner-wrap")  )  ,
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa') ) , "data" => array("attr" => "clear-float" )  )  ,
							)

			),

	'styles' => array( 

				__("Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#444444",
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap h2.text_title " ,
										 			"property" => "color" 

							 				)     
									),
										array( 
											"label" => __("Subtitle Color",'ioa') , 
											"name" => "subtitle_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#7E7E7E",
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap h4.text_subtitle " ,
										 			"property" => "color" 

							 				)     
									),

									array( 
										"label" => __("Bottom Line Color",'ioa') , 
										"name" => "spacer_color" , 
										"default" => "" , 
										"type" => "colorpicker",
										"description" => "",
										"length" => 'small',
										"value" => "#eeeeee",
										 "data" => array(

									 			"target" => " div.intro_title-inner-wrap span.spacer " ,
									 			"property" => "border-bottom-color" 

						 					)     
										)

									),

								__("Font Size Settings",'ioa') => array(

										array( 
											"label" => __("Title Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "" , 
											"type" => "slider",
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											"description" => "",
											"length" => 'small',
											"value" => "28px",
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap h2.text_title " ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Title Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "" , 
											"type" => "slider",
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap h2.text_title " ,
										 			"property" => "font-weight" 

							 				)     
										),
										array( 
											"label" => __("First Text Size",'ioa') , 
											"name" => "subtitle_size" , 
											"default" => "" , 
											"type" => "slider",
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap h4.text_subtitle " ,
										 			"property" => "font-size" 

							 				)     
									),
										array( 
											"label" => __("First Text Font Weight",'ioa') , 
											"name" => "subtitle_w" , 
											"type" => "slider",
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap h4.text_subtitle " ,
										 			"property" => "font-weight" 

							 				)     
										)

									),

								
								__("Margin Settings",'ioa') => array(

										
										array( 
											"label" => __("Main Title Top Margin",'ioa') , 
											"name" => "subtitle_mt" , 
											"default" => "" , 
											"type" => "text",
											"description" => "",
											"length" => 'small',
											"class" => ' rad_style_property ',
											"value" => "0px",
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap h2.text_title " ,
										 			"property" => "margin-top" 

							 				) ,
							 				    
										),

										array( 
											"label" => __("Main Title Bottom Margin",'ioa') , 
											"name" => "subtitle_mb" , 
											"default" => "" , 
											"type" => "text",
											"description" => "",
											"length" => 'small',
											"class" => ' rad_style_property ',
											"value" => "10px",
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap h2.text_title " ,
										 			"property" => "margin-bottom" 

							 				) ,
							 				    
										),

										array( 
											"label" => __("Intro Title Area Bottom Margin",'ioa') , 
											"name" => "title_mb" , 
											"default" => "" , 
											"type" => "text",
											"description" => "",
											"length" => 'small',
											"class" => ' rad_style_property ',
											"value" => "0px",
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap" ,
										 			"property" => "margin-bottom" 

							 				) ,
							 				    
										)								
										

								)

			)

	));


/**
 * CTA Widget
 */

$radunits['rad_cta_widget'] = new RADUnit(array(
	'label' => __('CTA','ioa'),
	'id' => 'rad_cta_widget',
	'template' => 'cta',
	'group'	=> 'widgets',
	'feedback' => '<div class="rad-intro-info"><h2 class="vf-text_title">{text_title}</h2> <a class="vf-cta_button" href="{button_link}">{cta_button}</a> </div>',
	'icon' => 'blankicon-',
	'heading' => 'CTA Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Welcome To our awesome site !" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array( "label" => __("Button Label",'ioa') , "name" => "cta_button" , "default" => "Learn More !" , "type" => "text", "description" => "", "length" => 'medium') ,
					array( "label" => __("Button Link",'ioa') , "name" => "button_link" , "meta" => true, "default" => "#" , "type" => "text", "description" => "", "length" => 'medium', "data" => array("attr" => "button-link" , "el" => "cta_button") ) ,
					array( "label" => __("Column Alignment",'ioa') , "name" => "col_alignment" , "meta" => true,"default" => "left" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("left" => __("Left",'ioa'),"right" => __("Right",'ioa'),"center" =>__("Center",'ioa'),"justify" => __("Justify",'ioa') )  , "data" => array("attr" => "text-align" , "el" => ".cta-inner-wrap")  )  ,
					array( "label" => __("Button Alignment",'ioa') , "name" => "button_alignment" , "meta" => true,"default" => "left" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("left" => __("Left",'ioa'),"right" => __("Right",'ioa'), "center" => __("Center","ioa") )  , "data" => array("attr" => "button-align" , "el" => ".cta-inner-wrap")  )  ,
					array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => "No","yes" => "Yes") , "data" => array("attr" => "clear-float" )  )  ,
					),

					
					__("Animation Fields",'ioa') => array(      
					array(  "label" => __("Button Animation on Hover" ,'ioa'), "name" => "button_animation" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "flash" => __("Flash",'ioa') , "bounce" => __("Bounce",'ioa') , "shake" => __("Shake",'ioa') , "tada" => __("Tada",'ioa') ,"swing" => __("Swing",'ioa') , "wobble" => __("Wobble",'ioa') , "wiggle" => __("Wiggle",'ioa') , "pulse" => __("Pulse",'ioa')) )  ,
					)
					 

			),

	'styles' => array(

			__(" CTA Styling",'ioa') => array(

										array( 
											"label" => __("Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#fffff",
											 "data" => array(

										 			"target" => " div.cta-inner-wrap h2.text_title " ,
										 			"property" => "color" 

							 				)     
										),

										array( 
											"label" => __("CTA Background",'ioa') , 
											"name" => "cta_bgcolor" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#16A4C2",
											 "data" => array(

										 			"target" => " div.cta-inner-wrap  " ,
										 			"property" => "background-color" 

							 				)     
										),

										array( 
											"label" => __("Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "16px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.cta-inner-wrap h2.text_title " ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.cta-inner-wrap h2.text_title " ,
										 			"property" => "font-weight" 

							 				)     
										)
										

									),

								__("Border Settings",'ioa') => array(
									array( 
											"label" => __("Border Radius",'ioa') , 
											"name" => "brr" , 
											"default" => "0px" , 
											"type" => "text",
											"description" => "",
											"length" => 'small',
											"value" => "0px",
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " div.cta-inner-wrap a.cta_button " ,
										 			"property" => "border-radius" 

							 				)     
										),
										array( 
											"label" => __("CTA Border Top Color",'ioa') , 
											"name" => "cta_tcolor" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "transparent",
											 "data" => array(

										 			"target" => " div.cta-inner-wrap " ,
										 			"property" => "border-top-color" 

							 				)     
										),

										array( 
											"label" => __("CTA Border Top Width",'ioa') , 
											"name" => "cta_tw" , 
											"default" => "" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 10,
											"suffix" => 'px',
											"class" => ' rad_style_property ',
											"data" => array(

										 			"target" => " div.cta-inner-wrap " ,
										 			"property" => "border-top-width" 

							 				)     
										),


										array( 
											"label" => __("CTA Border Bottom Color",'ioa') , 
											"name" => "cta_bbvc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "transparent",
											 "data" => array(

										 			"target" => " div.cta-inner-wrap " ,
										 			"property" => "border-bottom-color" 

							 				)     
										),

										array( 
											"label" => __("CTA Border Bottom Width",'ioa') , 
											"name" => "cta_cbbw" , 
											"default" => "" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 10,
											"suffix" => 'px',
											"class" => ' rad_style_property ',
											"data" => array(

										 			"target" => " div.cta-inner-wrap " ,
										 			"property" => "border-bottom-width" 

							 				)     
										),

									    array( 
											"label" => __("CTA Border Left Color",'ioa') , 
											"name" => "cta_blc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "transparent",
											 "data" => array(

										 			"target" => " div.cta-inner-wrap " ,
										 			"property" => "border-left-color" 

							 				)     
										),

										array( 
											"label" => __("CTA Border Left Width",'ioa') , 
											"name" => "cta_bll" , 
											"default" => "" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 10,
											"suffix" => 'px',
											"data" => array(

										 			"target" => " div.cta-inner-wrap " ,
										 			"property" => "border-left-width" 

							 				)     
										),

										array( 
											"label" => __("CTA Border Right Color",'ioa') , 
											"name" => "cta_brvcf" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "transparent",
											 "data" => array(

										 			"target" => " div.cta-inner-wrap " ,
										 			"property" => "border-right-color" 

							 				)     
										),

										array( 
											"label" => __("CTA Border Right Width",'ioa') , 
											"name" => "cta_brw" , 
											"default" => "" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 10,
											"suffix" => 'px',
											"data" => array(

										 			"target" => " div.cta-inner-wrap " ,
										 			"property" => "border-right-width" 

							 				)     
										),

	

									),
								__("Button Settings",'ioa') => array(

										array( 
											"label" => __("Button Color",'ioa') , 
											"name" => "button_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#1099BB",
											 "data" => array(

										 			"target" => " div.cta-inner-wrap a.cta_button " ,
										 			"property" => "color" 

							 				)     
										),
										
										array( 
											"label" => __("Button Background Color",'ioa') , 
											"name" => "button_bgcolor" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => " div.cta-inner-wrap a.cta_button " ,
										 			"property" => "background-color" 

							 				)     
										)


								)

	 )

	));


/**
 * Tabs Widget
 */

$inputs = array(
					array( 
							"label" => __("Title",'ioa') , 
							"name" => "tab_title" , 
							"default" => "Title" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Set Icon",'ioa') , 
							"name" => "tab_icon" , 
							"default" => "" , 
							"type" => "text",
							"description" => "",
							"class" => "has-input-button",
							"length" => 'medium',
							"value" => ""  ,
							'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>'  
					) ,
					array( 
							"label" => __("Tab Color",'ioa') , 
							"name" => "tab_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Tab Background Color",'ioa') , 
							"name" => "tab_bgcolor" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					
					array( 
							"label" => __("Text",'ioa') , 
							"name" => "tab_text" , 
							"default" => "Tab text goes here.." , 
							'addMarkup' => '<a href="" class="button-default ioa-editor-trigger">'.__('Use WP Editor','ioa').'</a>'  ,
							"type" => "textarea",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) 	
						

			);


/**
 * CTA Widget
 */

$radunits['rad_tabs_widget'] = new RADUnit(array(
	'label' => __('Tabs','ioa'),
	'id' => 'rad_tabs_widget',
	'template' => 'tabs',
	'group'	=> 'widgets',
	'icon' => 'tableicon-',
	'feedback' => "<div class='min-rad-highlight'>".__('Showing Tabs','ioa')."</div>",
	'heading' => 'Tabs Settings',
	'inputs' => array(
					 __("General Fields",'ioa') => array(

						array(  "label" =>  __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
						array( "label" =>  __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa') ) , "data" => array("attr" => "clear-float" )  )  ,
						array( "label" =>  __("Tab Layout",'ioa') , "name" => "tab_orientation" , "default" => "top" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("bottom" => __("Bottom",'ioa'),"top" => __("Top",'ioa'),"left" => __("Left",'ioa'),"right" => __("Right",'ioa')  )  )  ,
						
						),
						
						 __("Add Tabs",'ioa') => array(
							array( 'inputs' => $inputs, 'label' => __('Tabs' ,'ioa') , 	'name' => 'rad_tab','type'=>'module','unit' => __(' Tab','ioa') )
						
						)

			),

	'styles' => array( 

			__(" Text Styling",'ioa') => array(

					array( 
						"label" => __("Widget Title Color",'ioa') , 
						"name" => "title_color" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "#333D3D",
						 "data" => array(

					 			"target" => "div.tabs-inner-wrap h2.text_title" ,
					 			"property" => "color" 

		 				)     
					),
					array( 
						"label" => __("Widget Title Size",'ioa') , 
						"name" => "title_size" , 
						"type" => "slider",
						"description" => "",
						"length" => 'small',
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " div.tabs-inner-wrap h2.text_title" ,
					 			"property" => "font-size" 

		 				)     
					),
					array( 
						"label" => __("Widget Title Font Weight",'ioa') , 
						"name" => "title_w" , 
						"default" => "600" , 
						"type" => "slider",
						"description" => "",
						"length" => 'small',
						"value" => 0,
						"max" => 900,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " div.tabs-inner-wrap h2.text_title" ,
					 			"property" => "font-weight" 

		 				)     
					),

				),
			__(" Tabs Styling",'ioa') => array(

					array( 
						"label" => __("Active Tab Background Color",'ioa') , 
						"name" => "title_actab" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "#0DD7CB",
						 "data" => array(

					 			"target" => " .ui-tabs .ui-tabs-nav li.ui-tabs-active a " ,
					 			"property" => "background-color" 

		 				)     
					),
					array( 
						"label" => __("Active Tab Color",'ioa') , 
						"name" => "title_actabvc" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "",
						 "data" => array(

					 			"target" => " .ui-tabs .ui-tabs-nav li.ui-tabs-active a " ,
					 			"property" => "color" 

		 				)     
					),

					array( 
						"label" => __("Default Tab Background Color",'ioa') , 
						"name" => "title_tacbgc" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "#18B0E8",
						 "data" => array(

					 			"target" => " .ui-tabs .ui-tabs-nav li a " ,
					 			"property" => "background-color" 

		 				)     
					),
					array( 
						"label" => __("Default Tab Color",'ioa') , 
						"name" => "title_deftacb" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "",
						 "data" => array(

					 			"target" => " .ui-tabs .ui-tabs-nav li a " ,
					 			"property" => "color" 

		 				)     
					),
					

				)

	 )

	));

/**
 * Accordion Widget
 */

$ainputs = array(
					array( 
							"label" => __("Title",'ioa') , 
							"name" => "tab_title" , 
							"default" => "Title" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) ,

					array( 
							"label" => __("Section Text Color",'ioa') , 
							"name" => "tab_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Section Background Color",'ioa') , 
							"name" => "tab_bgcolor" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,


					array( 
							"label" => __("Text",'ioa') , 
							"name" => "tab_text" , 
							"default" => "Tab text goes here.." , 
							'addMarkup' => '<a href="" class="button-default ioa-editor-trigger">'.__('Use WP Editor','ioa').'</a>'  ,
							"type" => "textarea",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) 		

			);


$radunits['rad_accordion_widget'] = new RADUnit(array(
	'label' => __('Accordion','ioa'),
	'id' => 'rad_accordion_widget',
	'feedback' => "<div class='min-rad-highlight'>".__('Showing Accordion','ioa')."</div>",
	'template' => 'accordion',
	'group'	=> 'widgets',
	'icon' => 'align-justifyicon-',
	'heading' => 'Accordion Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
					array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa') ), "data" => array("attr" => "clear-float" )  )  ,
					
					),

					
					__("Add Accordion Sections",'ioa') => array(
						array( 'inputs' => $ainputs, 'label' => __('Accordion','ioa'), 	'name' => 'rad_tab','type'=>'module','unit' => __(' Section','ioa') )
					
					)

			),

	'styles' => array(

		__(" Sections Styling",'ioa') => array(

										array( 
											"label" => __("Active Section Background Color",'ioa') , 
											"name" => "title_asecbg" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#0DD7CB",
											 "data" => array(

										 			"target" => ".ioa_accordion .ui-accordion-header.ui-state-active " ,
										 			"property" => "background-color" 

							 				)     
										),
										array( 
											"label" => __("Active Section Color",'ioa') , 
											"name" => "title_asecc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => ".ioa_accordion .ui-accordion-header.ui-state-active " ,
										 			"property" => "color" 

							 				)     
										),

										array( 
											"label" => __("Default Section Background Color",'ioa') , 
											"name" => "title_defsebgc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => " .ioa_accordion .ui-accordion-header " ,
										 			"property" => "background-color" 

							 				)     
										),
										array( 
											"label" => __("Default Section Color",'ioa') , 
											"name" => "title_degsecv" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#888888",
											 "data" => array(

										 			"target" => " .ioa_accordion .ui-accordion-header " ,
										 			"property" => "color" 

							 				)     
										),

										
										
										

									)

		)


	));


// Prop

$ainputs = array(
					array( 
							"label" => __("Upload Image",'ioa') , 
							"name" => "p_upload" , 
							"default" => "" , 
							"type" => "upload",
							"description" => "",
							"length" => 'medium',
							"value" => "",
							"class" => 'has-input-button'   
					) ,	
					array( 
							"label" => __("Position from Left",'ioa') , 
							"name" => "p_left" , 
							"default" => "0" , 
							"type" => "text",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,

					array( 
							"label" => __("Position from Top",'ioa') , 
							"name" => "p_top" , 
							"default" => "0" , 
							"type" => "text",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,	

					array( 
							"label" => __("Animation delay ",'ioa') , 
							"name" => "p_delay" , 
							"default" => "0" , 
							"type" => "text",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,

					array( 
							"label" => __("Link ",'ioa') , 
							"name" => "p_link" , 
							"default" => "" , 
							"type" => "text",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,

					array( 
							"label" => __("Animation Type",'ioa') , 
							"name" => "p_animation" , 
							"default" => "" , 
							"type" => "select",
							"options" => array(

												"none" => __("None",'ioa'), 
												"fade" => __("Fade In" ,'ioa'), 
												"fade-left" => __("Fade from Left",'ioa') , 
												"fade-top" => __("Fade from Top",'ioa') , 
												"fade-bottom" => __("Fade from Bottom",'ioa') ,
												"fade-right" => __("Fade from Right",'ioa') , 
												"scale-in" => __("Scale In",'ioa') ,
												"scale-out" => __("Scale Out",'ioa') , 
												"big-fade-left" => __("Long Fade from Left",'ioa') , 
												"big-fade-right" => __("Long Fade from Right",'ioa'), 
												"big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , 
												"big-fade-top" => __("Long Fade from Top",'ioa')    

										),
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,	



			);

$radunits['rad_prop_widget'] = new RADUnit(array(
	'label' => __('Prop','ioa'),
	'id' => 'rad_prop_widget',
	'feedback' => "<div class='rad-module-info'> </div>",
	'template' => 'props',
	'group'	=> 'widgets',
	'icon' => 'lampicon-',
	'heading' => 'Prop Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(
							array(  "label" => __("Width",'ioa') , "name" => "width" ,"default" => "500"  ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
							array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "500"  ,"type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa') ), "data" => array("attr" => "clear-float" )  )  ,
							),
							__("Add Props",'ioa') => array(
								array( 'inputs' => $ainputs, 'label' => __('Prop','ioa'), 	'name' => 'rad_tab','type'=>'module','unit' => __('Section','ioa') )
							
							)
			),

	'styles' => array()

	));

/**
 * Image
 */

$radunits['rad_image_widget'] = new RADUnit(array(
	'label' => __('Image','ioa'),
	'id' => 'rad_image_widget',
	'template' => 'image',
	'group'	=> 'media',
	'icon' => 'picture-1icon-',
	'feedback' => "<div class='rad-image-info'> <h2 class='vf-text_title'>{text_title}</h2> <img src='{image}' /> </div>",
	'heading' => 'Image Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array( "label" => __("Image",'ioa') , "name" => "image" , "default" => $demo_imgs[0] , "type" => "upload", "description" => "", "length" => 'medium', 'class' => 'has-input-button'	) ,
							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Image" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Link",'ioa') , "name" => "link" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Use lightbox to show full image",'ioa') , "name" => "lightbox" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa'))  )  ,
							array(  "label" => __("Caption",'ioa') , "name" => "text_caption" ,"default" => "Caption For the Image" ,"type" => "text","description" => "","length" => 'medium')  ,
							
							array(  "label" => __("Width",'ioa') , 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>', "meta" => "true", "name" => "width" ,"default" => "" ,"type" => "text","description" => "","length" => 'medium')  ,
							array(  "label" => __("Height",'ioa') , "meta" => "true", "name" => "height" ,"default" => "" ,"type" => "text","description" => "","length" => 'medium')  ,


							),

							__("Visual Fields",'ioa') => array(
							array( "label" => __("Hover Color",'ioa') , "name" => "hoverc" , "default" => "" , "type" => "colorpicker", "description" => "", "length" => 'medium'    )  ,
							array( "label" => __("Hover Background Color",'ioa') , "name" => "hoverbg" , "default" => "" , "type" => "colorpicker", "description" => "", "length" => 'medium'    )  ,
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							array( "label" => __("Image Resizing",'ioa') , "name" => "resizing" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("No",'ioa'),"hard" => __("Hard Resize",'ioa') , "proportional" => __("Proportional",'ioa') , "wproportional" => __("Width Proportional",'ioa'), "hproportional" => __("Height Proportional",'ioa') )  )  ,
							

							),

							__("Animation Fields",'ioa') => array(      
							array(  "label" => __("Image Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
							array(  "label" => __("Animation Delay",'ioa') , "meta" => "true", "name" => "delay" ,"default" => "0" ,"type" => "text","description" => "","length" => 'medium')  ,
							
							)
			),

	'styles' => array(

			__(" General Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.image-inner-wrap h2.text_title" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "24px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => 'px',
											 "data" => array(

										 			"target" => " div.image-inner-wrap h2.text_title" ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"suffix" => '',
											 "data" => array(

										 			"target" => " div.image-inner-wrap h2.text_title" ,
										 			"property" => "font-weight" 

							 				)     
										),
										array( 
											"label" => __("Caption Color",'ioa') , 
											"name" => "text_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.image-inner-wrap h4.text_caption" ,
										 			"property" => "color" 

							 				)     
										),


									)

		)

	));

/**
 * Divider
 */

$radunits['rad_divider_widget'] = new RADUnit(array(
	'label' => __('Divider','ioa'),
	'id' => 'rad_divider_widget',
	'template' => 'divider',
	'group'	=> 'widgets',
	'icon' => 'minus-2icon-',
	'feedback' => "<div class='rad-divider'> </div>",
	'heading' => 'Divider Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array( "label" => __("Select Style",'ioa') , "name" => "divider_style" , "default" => "line" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("Empty Space",'ioa'),"line" => __("Line",'ioa'),"double"=>__("Double Stroke",'ioa'),"dotted"=>__("Dotted",'ioa'),"dashed"=>__("Dashed",'ioa')) , "data" => array("attr" => "divider" )  )  ,
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							array(  "label" => __("Vertical Spacing",'ioa') , "name" => "vspace" ,"default" => "20px" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Horizontal Spacing",'ioa') , "name" => "hspace" ,"default" => "0px" ,"type" => "text", "description" => "", "length" => 'medium') ,
							  
							)
			),

	'styles' => array(

			__(" Divider Styling",'ioa') => array(

										array( 
											"label" => __("Divider Color",'ioa') , 
											"name" => "divder_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#eeeeee",
											 "data" => array(

										 			"target" => " div.divider" ,
										 			"property" => "border-color" 

							 				)     
										),

									)

		)

	));


/**
 * Post Scrollable
 */

$radunits['rad_scrollable_widget'] = new RADUnit(array(
	'label' => __('Scrollable','ioa'),
	'id' => 'rad_scrollable_widget',
	'template' => 'scrollable',
	'group'	=> 'advance',
	'icon' => 'resize-horizontal-1icon-',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-text_title'>{text_title}</h4> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items . </div> ",
	'heading' => 'Scrollable Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "6" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array(  "label" => __("Item Width",'ioa') , "name" => "width" ,"default" => "250"  ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Item Height",'ioa') , "name" => "height" ,"default" => "180"  ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							
							array( "label" => __("Post Type" ,'ioa'), "name" => "post_type" , "default" => "post" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => $post_type_array   )  ,
							
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>', 'class' => 'has-input-button' ) ,
							
							)
			),

	'styles' => array(

			__("Columns Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#596A67",
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "color" 

							 				)     
										),
										
									),

								__("Font Size Settings",'ioa') => array(

										array( 
											"label" => __("Title Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "16px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Title Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											 "data" => array(

										 			"target" => " div.text-title-wrap h2.text_title " ,
										 			"property" => "font-weight" 

							 				)     
										) 
								

									),

								
								__("Control Stylings",'ioa') => array(

										
										array( 
											"label" => __("Arrow Color",'ioa') , 
											"name" => "arc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => " .bx-wrapper .bx-controls-direction a " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Arrow Background Color",'ioa') , 
											"name" => "arbg" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#111111",
											 "data" => array(

										 			"target" => " .bx-wrapper .bx-controls-direction a " ,
										 			"property" => "background-color" 

							 					)     
										),

									)
		)

	));


/**
 * Testimonials
 */

$radunits['rad_testimonials_widget'] = new RADUnit(array(
	'label' => __('Testimonials','ioa'),
	'id' => 'rad_testimonials_widget',
	'feedback' => " Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> testimonials . ",
	'template' => 'testimonials',
	'group'	=> 'widgets',
	'icon' => 'usersicon-',
	'heading' => 'Testimonials Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array(  "label" => __("Number of Testimonials (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							array( "label" => __("Sort by",'ioa') , "name" => "sort_by" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("date" => __("Date",'ioa'),"title" => __("Title",'ioa'),"random" =>__("Random",'ioa'))   )  ,
							array( "label" => __("Order",'ioa') , "name" => "order" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("ASC" => __("Ascending",'ioa'),"DESC" => __("Descending",'ioa'))   )  ,
							
							)
			),

	'styles' => array(

			__("Stylings",'ioa') => array(
										array( 
											"label" => __("Image Border Color",'ioa') , 
											"name" => "ibc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#f4f4f4",
											 "data" => array(

										 			"target" => " div.testimonials-inner-wrap div.image " ,
										 			"property" => "border-color" 

							 					)     
										)
									)

		)

	));

/**
 * Single Testimonial Unit
 */

$testimonials = get_posts('post_type=testimonial&posts_per_page=-1');
$ts = array();
foreach ($testimonials as $post) {
   $ts[$post->ID] = get_the_title($post->ID) ;
}

$radunits['rad_testimonial_widget'] = new RADUnit(array(
	'label' => __('Testimonial','ioa'),
	'id' => 'rad_testimonial_widget',
	'template' => 'testimonial_bubble',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-t_id'>".__('Testimonial of','ioa')." {t_id}</h4></div> ",
	'group'	=> 'widgets',
	'icon' => 'user-1icon- ',
	'heading' => 'Testimonial Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array(  "label" => __("Select Testimonial",'ioa') , "name" => "t_id" ,"default" => "" ,"type" => "select","options" => $ts , "description" => "", "length" => 'medium') ,
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa') ) , "data" => array("attr" => "clear-float" )  )  ,
							array(  "label" => __("Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In",'ioa') , "fade-left" => __("Fade from Left" ,'ioa'), "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom" ,'ioa'),"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left" ,'ioa'), "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top" ,'ioa')   )  ),
							

							)
			),

	'styles' => array(

			__("Stylings",'ioa') => array(
										array( 
											"label" => __("Image Border Color",'ioa') , 
											"name" => "ibc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#f4f4f4",
											 "data" => array(

										 			"target" => " div.testimonial_bubble-inner-wrap div.image " ,
										 			"property" => "border-color" 

							 					)     
										)
									)

		)

	));


/**
 * Video Widget
 */

$radunits['rad_video_widget'] = new RADUnit(array(
	'label' => __('Video','ioa'),
	'id' => 'rad_video_widget',
	'template' => 'video',
	'group'	=> 'media',
	'icon' => 'video-1icon-',
	'feedback' => "<div class='min-rad-highlight'>".__("Showing Video",'ioa')." <strong class='vf-v_id'>{v_id}</strong></div>",
	'heading' => 'Video Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Caption",'ioa') , "name" => "text_caption" ,"default" => "Sub Title" ,"type" => "text","description" => "","length" => 'medium')  ,
							array(  "label" => __("Video URL",'ioa') , "name" => "v_id" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							
							array(  "label" => __("Width",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
							array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text", "description" => "", "length" => 'medium') ,
							

							)
			),

	'styles' => array(

			__(" Text Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.video-inner-wrap h2.text_title" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "24px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.video-inner-wrap h2.text_title" ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											 "data" => array(

										 			"target" => " div.video-inner-wrap h2.text_title" ,
										 			"property" => "font-weight" 

							 				)     
										),
										array( 
											"label" => __("Caption Color",'ioa') , 
											"name" => "text_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.video-inner-wrap h4.text_caption" ,
										 			"property" => "color" 

							 				)     
										),


									)

		)

	));


// Pie Chart Widget
 

$cinputs = array(
					array( 
							"label" => __("Section Color",'ioa') , 
							"name" => "chart_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Label",'ioa') , 
							"name" => "chart_label" , 
							"default" => "Label" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Value",'ioa') , 
							"name" => "chart_value" , 
							"default" => "20" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) 

					
							

			);

$radunits['rad_piechart_widget'] = new RADUnit(array(
	'label' => __('Pie Chart','ioa'),
	'id' => 'rad_piechart_widget',
	'template' => 'pie_chart',
	'group'	=> 'infographic',
	'icon' => 'chart-pieicon-',
	'feedback' => "<div class='min-rad-highlight'> Showing Pie Chart <strong class='vf-text_title'>{text_title}</strong></div>",
	'heading' => 'Chart Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array(  "label" => __("Width",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
							array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							
							),
							"Add Chart Data" => array(
								array( 'inputs' => $cinputs, 'label' => __('Chart','ioa'), 'default' =>'',	'name' => 'rad_tab','type'=>'module','unit' => __('Section','ioa'))
							
							)
			),

	'styles' => array(

		__(" Text Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "24px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											 "data" => array(

										 			"target" => " div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-weight" 

							 				)     
										),
										

									)	

	 )

	));

// Bar Graph Widget

$cinputs = array(
					array( 
							"label" => __("Bar Background color",'ioa') , 
							"name" => "bar_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Bar Stroke Color",'ioa') , 
							"name" => "bar_stroke" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					
					array( 
							"label" => __("Enter Values for all Labels(ex 12,34)",'ioa') , 
							"name" => "bar_value" , 
							"default" => "20,30" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) 

			);

$radunits['rad_bargraph_widget'] = new RADUnit(array(
	'label' => __('Bar Graph','ioa'),
	'id' => 'rad_bargraph_widget',
	'feedback' => "<div class='min-rad-highlight'> Showing Bar Graph <strong class='vf-text_title'>{text_title}</strong></div>",
	'template' => 'bar_graph',
	'group'	=> 'infographic',
	'icon' => 'chart-bar-2icon-',
	'heading' => 'Bar Graph Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Enter Labels separated by comma(Ex Mon,Tue)",'ioa') , "name" => "labels" ,"default" => "A,B" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array(  "label" => __("Width",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
							array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							
							),
							"Add Chart Data" => array(
								array( 'inputs' => $cinputs, 'label' => __('Chart','ioa'), 'default' =>'',	'name' => 'rad_tab','type'=>'module','unit' => __('Section','ioa'))
							
							)
			),

	'styles' => array(

		__(" Text Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "24px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											 "data" => array(

										 			"target" => " div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-weight" 

							 				)     
										),
										

									)	

	 )

	));

// Line Graph


$cinputs = array(
					array( 
							"label" => __("Line Background color",'ioa') , 
							"name" => "line_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Line Stroke Color",'ioa') , 
							"name" => "line_stroke" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,

					array( 
							"label" => __("Line Point Color",'ioa') , 
							"name" => "line_pointcolor" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Line Point Stroke Color",'ioa') , 
							"name" => "line_pointstrokecolor" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					
					array( 
							"label" => __("Enter Values for all Labels(ex 12,34)",'ioa') , 
							"name" => "bar_value" , 
							"default" => "20,30" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) 

					
							

			);


$radunits['rad_linegraph_widget'] = new RADUnit(array(
	'label' => __('Line Graph','ioa'),
	'id' => 'rad_linegraph_widget',
	'template' => 'line_graph',
	'group'	=> 'infographic',
	'icon' => 'chart-lineicon-',
	'heading' => 'Line Graph Settings',
	'feedback' => "<div class='min-rad-highlight'> Showing Line graph <strong class='vf-text_title'>{text_title}</strong></div>",

	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Enter Labels separated by comma(Ex Mon,Tue)" ,'ioa'), "name" => "labels" ,"default" => "A,B" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array(  "label" => __("Width",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
							array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							
							),
							__("Add Chart Data",'ioa') => array(
								array( 'inputs' => $cinputs, 'label' => __('Chart','ioa'), 	'name' => 'rad_tab','type'=>'module','unit' => __('Section','ioa'))
							
							)
			),

	'styles' => array(

		__(" Text Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "24px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Font Weight",'ioa') , 
											"name" => "title_w" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											 "data" => array(

										 			"target" => " div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-weight" 

							 				)     
										),
									

									)	

	 )

	));

// Doughnut


$cinputs = array(
					array( 
							"label" => __("Section Color" ,'ioa'), 
							"name" => "chart_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Label",'ioa') , 
							"name" => "chart_label" , 
							"default" => "Label" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Value",'ioa') , 
							"name" => "chart_value" , 
							"default" => "20" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) 
							

			);

$radunits['rad_doughnut_widget'] = new RADUnit(array(
	'label' => __('Doughnut','ioa'),
	'id' => 'rad_doughnut_widget',
	'template' => 'doughnut_chart',
	'group'	=> 'infographic',
	'feedback' => "<div class='min-rad-highlight'> Showing Doughnut Graph <strong class='vf-text_title'>{text_title}</strong></div>",
	'icon' => 'cdicon-',
	'heading' => 'Doughnut Graph Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array(  "label" => __("Width",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
							array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							
							),
							__("Add Chart Data",'ioa') => array(
								array( 'inputs' => $cinputs, 'label' => __('Chart','ioa'), 	'name' => 'rad_tab','type'=>'module','unit' => __('Section','ioa'))
							
							)
			),

	'styles' => array(

		__(" Text Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "24px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Font Weight",'ioa') , 
											"type" => "slider",
											"name" => "font_weight",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											 "data" => array(

										 			"target" => " div.pie_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-weight" 

							 				)     
										),
										
									)	

	 )

	));


// Progress Bars Widget
 
$cinputs = array(
					array( 
							"label" => __("Section Color",'ioa') , 
							"name" => "pr_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Label",'ioa') , 
							"name" => "pr_label" , 
							"default" => "Label" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Value",'ioa') , 
							"name" => "pr_value" , 
							"default" => "20" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) 
							

			);

$radunits['rad_progressbar_widget'] = new RADUnit(array(
	'label' => __('Progress Bar','ioa'),
	'id' => 'rad_progressbar_widget',
	'template' => 'progress_bar',
	'feedback' => "<div class='min-rad-highlight'>Showing  Progess Bars</div>",
	'group'	=> 'infographic',
	'icon' => 'progress-2icon-',
	'heading' => 'Progress Bar Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Enter Value Unit",'ioa') , "name" => "unit" ,"default" => "%" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" =>__("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							
							),
							__("Add Bars",'ioa') => array(
								array( 'inputs' => $cinputs, 'label' => __('Progress Bars','ioa'), 	'name' => 'rad_tab','type'=>'module','unit' => __('Section','ioa'))
							
							)
			),

	'styles' => array(

		__(" Text Styling",'ioa') => array(

					array( 
						"label" => __("Title Color",'ioa') , 
						"name" => "title_color" , 
						"default" => "" , 
						"type" => "colorpicker",
						"description" => "",
						"length" => 'small',
						"value" => "#333D3D",
						 "data" => array(

					 			"target" => "div.progress_bar-inner-wrap h2.text_title" ,
					 			"property" => "color" 

		 				)     
					),
					array( 
						"label" => __("Size",'ioa') , 
						"name" => "title_size" , 
						"default" => "24px" , 
						"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
						 "data" => array(

					 			"target" => " div.progress_bar-inner-wrap h2.text_title" ,
					 			"property" => "font-size" 

		 				)     
					),
					array( 
						"label" => __("Font Weight",'ioa') , 
						"name" => "title_w" , 
						"default" => "600" , 
						"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
						 "data" => array(

					 			"target" => " div.progress_bar-inner-wrap h2.text_title" ,
					 			"property" => "font-weight" 

		 				)     
					),
					

				)

	 )

	));

// Radial Widget


$radunits['rad_radial_widget'] = new RADUnit(array(
	'label' => __('Radial Chart','ioa'),
	'id' => 'rad_radial_widget',
	'template' => 'radial_chart',
	'feedback' => " <div class='min-rad-highlight'>Showing Radial Chart <strong class='vf-text_title'>{text_title}</strong> with value <strong class='vf-value'>{value}</strong></div>",
	'group'	=> 'infographic',
	'icon' => 'dot-circledicon- ',
	'heading' => 'Radial Chart Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Enter Label",'ioa') , "name" => "label" ,"default" => "A" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Enter Value (1 to 100)",'ioa'), "name" => "value" ,"default" => "60" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Font Size",'ioa'), "name" => "font_size" ,"default" => "48" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array(  "label" => __("Size",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
							array(  "label" => __("Line Width",'ioa'), "name" => "line_width" ,"default" => "3" ,"type" => "text", "description" => "", "length" => 'medium') ,
							
							array(  "label" => __("Bar Color",'ioa'),"alpha" => false, "name" => "bar_color" ,"default" => "#199dda" ,"type" => "colorpicker", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Track Color",'ioa'), "alpha" => false, "name" => "track_color" ,"default" => "#f2f2f2" ,"type" => "colorpicker", "description" => "", "length" => 'medium') ,


							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')  ) , "data" => array("attr" => "clear-float" )  )  ,
							
							)
			),

	'styles' => array(

			__(" Text Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.radial_chart-inner-wrap h2.text_title" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Chart Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "24px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.radial_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											 "data" => array(

										 			"target" => " div.radial_chart-inner-wrap h2.text_title" ,
										 			"property" => "font-weight" 

							 				) ,
							 				  
										),
										array( 
											"label" => __("Radial Information Color",'ioa') , 
											"name" => "rtc" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333333",
											 "data" => array(

										 			"target" => "div.radial-chart" ,
										 			"property" => "color" 

							 				)     
										),


									)

	 )

	));


// Stacked Circle Widget

$cinputs = array(
					array( 
							"label" => __("Section Color",'ioa') , 
							"name" => "pr_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Section Background Color",'ioa') , 
							"name" => "pr_bgcolor" , 
							"default" => "" , 
							"type" => "colorpicker",
							"description" => "",
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Label",'ioa') , 
							"name" => "pr_label" , 
							"default" => "Label" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Value",'ioa') , 
							"name" => "pr_value" , 
							"default" => "20" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Value Unit",'ioa') , 
							"name" => "pr_unit" , 
							"default" => "%" , 
							"type" => "text",
							"description" => "",
							"length" => 'long',
							"value" => ""   
					) 
							

			); 

// Stacked Circle

$radunits['rad_stackcircle_widget'] = new RADUnit(array(
	'label' => __('Stacked Circle','ioa'),
	'id' => 'rad_stackcircle_widget',
	'template' => 'stacked_circle',
	'group'	=> 'infographic',
	'feedback' => "<div class='rad-module-info'>Stacked Circle - <h4 class='vf-text_title'>{text_title}</h4></div>",
	'icon' => 'up-circled-1icon-',
	'heading' => 'Stacked Circle Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Size",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text", "description" => "", "length" => 'medium', 'addMarkup' => '<a href="" class="button-default width-correction">'.__('Get Proper Width','ioa').'</a>') ,
							
							
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							
							),
							"Add Circles" => array(
								array( 'inputs' => $cinputs, 'label' =>__('Circles','ioa'), 	'name' => 'rad_tab','type'=>'module','unit' => __('Section','ioa'))
							
							)
							
			),

	'styles' => array(

			__(" Text Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.stacked_circle-inner-wrap h2.text_title" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "24px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " div.stacked_circle-inner-wrap h2.text_title" ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "600" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											 "data" => array(

										 			"target" => " div.stacked_circle-inner-wrap h2.text_title" ,
										 			"property" => "font-weight" 

							 				)     
										),
										

									)

	 )

	));

// Team Widget

$radunits['rad_teamwidget_widget'] = new RADUnit(array(
	'label' => __('Person','ioa'),
	'id' => 'rad_teamwidget_widget',
	'template' => 'person',
	'group'	=> 'widgets',
	'feedback' => "<div class='rad-person-info'><h2 class='vf-mem_name'>{mem_name}</h2><img src='{photo}' /> <span class='vf-mem_information'>{mem_information}</span> </div>",
	'icon' => 'usericon-',
	'heading' => 'Person Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Photo",'ioa') , "name" => "photo" ,"default" => $demo_imgs[0] ,"type" => "upload", "description" => "", "length" => 'medium' , 'class' => 'has-input-button') ,
							array(  "label" => __("Name",'ioa'), "name" => "mem_name" ,"default" => "Tony Stark" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Designation",'ioa'), "name" => "mem_desig" ,"default" => "CEO" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Information",'ioa'), "name" => "mem_information" ,"default" => "" ,"type" => "textarea", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Label color",'ioa'), "name" => "mem_color" ,"default" => "" ,"type" => "colorpicker", "description" => "", "length" => 'medium') ,
							array( "label" => __("Clear Float After Element",'ioa') , "name" => "clear_float" , "default" => "" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) , "data" => array("attr" => "clear-float" )  )  ,
							array(  "label" => __("Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In",'ioa') , "fade-left" => __("Fade from Left" ,'ioa'), "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom" ,'ioa'),"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left" ,'ioa'), "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top" ,'ioa')   )  ),
							
							),
							__("Social Links",'ioa') => array(
								array(  "label" => __("Twitter Link",'ioa'), "name" => "twitter_v" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Facebook Link",'ioa'), "name" => "facebook_v" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Google Link",'ioa'), "name" => "google_v" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Linkedin Link",'ioa'), "name" => "linkedin_v" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Dribbble Link",'ioa'), "name" => "dribbble_v" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,
							array(  "label" => __("Youtube Link",'ioa'), "name" => "youtube_v" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium') ,

								) 
							
			),

	'styles' => array(

			__(" Text Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "#333D3D",
											 "data" => array(

										 			"target" => "div.person h4" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Below Title Border Color",'ioa') , 
											"name" => "spacer_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											"description" => "",
											"length" => 'small',
											"value" => "",
											 "data" => array(

										 			"target" => "div.person .person-top-area span.spacer" ,
										 			"property" => "border-color" 

							 				)     
										),
										array( 
											"label" => __("Title Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "17px" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => "div.person h4" ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Title Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "100" , 
											"type" => "slider",
											"description" => "",
											"length" => 'small',
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											 "data" => array(

										 			"target" => "div.person h4" ,
										 			"property" => "font-weight" 

							 				)     
										),
										

									)

	 )

	));

}
