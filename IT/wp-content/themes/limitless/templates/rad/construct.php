<?php 
/**
 * This template intializes RAD Frontend Engine.
 * All Components are available in Templates -> rad folder
 * @since Hades Framework V5
 */

global $helper, $super_options , $ioa_meta_data ,$radunits, $post;

$data = $ioa_meta_data['rad_data'];



if(count($data) == 0) return;

$predict = 0;
$islast ='';
$depth = 0;
$section_count = 0;

$w_predict = 0;



 ?>
<div class="rad-holder clearfix" data-id="<?php echo get_the_ID(); ?>" >

<?php if(isset($data) && is_array($data)) : foreach($data as $section) :   $depth = 0;
	$d = array();

	if(isset($section['data']))
	{
		$d = $section['data'];
		if(! is_array($section['data'])) $d = json_decode($section['data'],true);
	}
 	


	$d = $helper->getAssocMap($d,'value');	
	$predict = 0; 
	
	$cl = array();

	if(count($d) > 0) :

	if($section_count==0)  $cl[] = 'first-section'; 
	if($section_count == count($data)-1)  $cl[] = 'last-section'; 
	if(isset($d['background_opts']) && $d['background_opts']=='primary-color')  $cl[] = 'section-primary-color '; 
	if(isset($d['background_opts']) && $d['background_opts']=='primary-alt-color')  $cl[] = 'section-primary-alt-color '; 
	if(isset($d['background_opts']) && $d['background_opts']=='secondary-color')  $cl[] = 'section-secondary-color '; 
	if(isset($d['background_opts']) && $d['background_opts']!='' && trim($d['background_color'])!="")  $cl[] = ' senseSecBGModel ';

	
	if( isset($section['containers']) )
			foreach ($section['containers'] as $key => $container) {
					$widgets = $container['widgets'];
					if(isset($widgets))
					foreach($widgets as $w)
					{
						if($w['type'] == 'rad_one_menu_widget') $cl[] = 'has-one-page-menu';
					}
			};


?>

<div class="page-section clearfix <?php echo join(' ',$cl) ?>" id='<?php echo $section['id']; ?>'>
	
	<?php 

	if(isset($d['ov_use']) && $d['ov_use']=='yes') : ?>
					<div class="section-overlay"></div>
	<?php endif;

	if(!isset($d['layout']))
	$d['layout'] = 'contained';

	if(isset($d['layout']))
	$ioa_meta_data['section_width'] = $d['layout'];

	 ?>	

	<div class="<?php if($d['layout']!="Full Width") echo 'skeleton';  if($d['layout']=="Full Width") echo 'full_width'; if($d['layout']=="Cell Blocks") { echo " blocked-layout"; $ioa_meta_data['blocked'] = true; } ?> section-content auto_align clearfix" data-key='rad_page_section'>
			
		<?php 
			if( isset($section['containers']) )
			{
				$pen = count($section['containers']);
				//echo $pen;
			}	

			if( isset($section['containers']) )
			foreach ($section['containers'] as $key => $container) {
					$c = $container['data'];
					if(!is_array($container['data'])) $c = json_decode($container['data'],true);
					$c = $helper->getAssocMap($c,'value');
					$v = 0;

					$isfirst = '';
					$istop = '';
					if($predict == 0)
					{
						$isfirst = " first ";
					}
					
					$ioa_meta_data['playout'] = $container['layout'];
					
					switch ($container['layout']) {
						case 'one_half': $v = 50;  break;
						case 'one_third': $v = 33.333333;  break;
						case 'one_fourth': $v = 25;  break;
						case 'one_fifth': $v = 20;  break;
						case 'two_third': $v = 66.666666;  break;
						case 'three_fourth': $v = 75;  break;
						case 'four_fifth': $v = 80;  break;
						case 'full': $v = 100;  break;
						
						
						
					}

					$predict += $v;
					$islast = '';

					if($depth == 0)
					{
						$istop = ' top ';
					}

					if(round($predict) >= 100)
					{
						//echo $depth;
						$islast = ' last'; 
					}

					 $float = '';
					if( isset($c['float']) && $c['float']!="" && $c['float']!="left" ) $float = $c['float'];

				?>
				
				<div class="rad-container  layout_element <?php echo $float.' '.$container['layout'].$islast.$isfirst.$istop; if($c['background_opts']!='' ) echo ' senseBGModel '; if($c['border_top_width']!="" && $c['border_top_width']!="0") echo ' senseTopBorderModel '; if($c['border_bottom_width']!="" && $c['border_bottom_width']!="0") echo ' senseBottomBorderModel '; ?> clearfix" id="<?php echo $container['id'] ?>" data-key="rad_page_container">
					<?php 
							if(isset($ioa_meta_data['blocked']) && $depth > 0 ) echo '<span class="vline"></span>';
							if(isset($ioa_meta_data['blocked']) && $islast == '' ) echo '<span class="hline"></span>';
					 ?>
					<div class="rad-inner-container nested clearfix">
					<?php 
					$widgets = array(); 
					if(isset($container['widgets'])) $widgets = $container['widgets'];

					$w_predict = 0; $w_depth = 0;

					foreach ($widgets as $key => $widget) {
						
						 if(  isset($widget['data'][0]['value'])   )
						 {
						 	$widget['data'] = $helper->getAssocMap($widget['data'],'value');
						 }

						if(isset($widget['data']) && gettype($widget['data']) == "string" )	
							$widget['data'] =  $helper->getAssocMap(json_decode($widget['data'],true),'value'); 	

						$ioa_meta_data['widget'] = $widget;

						if(!is_array($ioa_meta_data['widget']['data'])  ) $ioa_meta_data['widget']['data'] = json_decode($ioa_meta_data['widget']['data'],true);
						
						$ioa_meta_data['widget_classes'] = ' w_layout_element ';

						$w_v = 0;

						$w_isfirst = '';
						$w_istop = '';
						if($w_predict == 0)
						{
							$w_isfirst = " first ";
						}
						
						if(isset($widget['layout']))
						switch ($widget['layout']) {
							case 'one_half': $w_v = 50;  break;
							case 'one_third': $w_v = 33.333333;  break;
							case 'one_fourth': $w_v = 25;  break;
							case 'one_fifth': $w_v = 20;  break;
							case 'two_third': $w_v = 66.666666;  break;
							case 'three_fourth': $w_v = 75;  break;
							case 'four_fifth': $w_v = 80;  break;
							case 'full': $w_v = 100;  break;
							case 'auto': $w_v = 10;  break;
							
							
						}

						$w_predict += $w_v;
						$w_islast = '';

						if($w_depth == 0)
						{
							$w_istop = ' top ';
						}

						if(round($w_predict) >= 100)
						{
							//echo $depth;
							$w_islast = ' last'; 
						}

						if(isset($widget['layout'])) $ioa_meta_data['widget_classes'] .= ' w_'.$widget['layout'].' '.$w_isfirst.' '.$w_islast.' '.$w_istop;
						else $ioa_meta_data['widget_classes'] .= ' w_full ';

						if($ioa_meta_data['playout'] == 'one_fourth' || $ioa_meta_data['playout']=='one_fifth')
						{
							$ioa_meta_data['widget_classes'] = ' w_layout_element w_full '.$w_istop; $w_predict = 100;
						}

						$ioa_meta_data['rad_type'] = $widget['type'];
						

						if(isset($radunits[str_replace('-','_',$widget['type'])]))
						get_template_part("templates/rad/".$radunits[str_replace('-','_',$widget['type'])]->data['template']);


						if(round($w_predict) >= 100) { $w_depth++; $w_predict = 0;  }
					
					}

					if(round($predict) >= 100) { $depth++; $predict = 0;  }
					
					 ?>		
					</div>
					
				</div>
	
				<?php	

			}
		 ?>

	</div>
	<?php if( $d['background_opts'] =="bg-video" ) : ?>
		<div class="video-bg <?php if(isset($d['video_pos'])) echo $d['video_pos'] ?>" style="background:url(<?php if(isset($d['video_fallback'])) echo $d['video_fallback'] ?>)">
		   		<video poster="<?php if(isset($d['video_fallback'])) echo $d['video_fallback'] ?>"  id="<?php echo uniqid('vs') ?>" >
		   			<!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
		   	 	<source type="video/mp4" src="<?php echo $d['video_url'] ?>" />
		    		<!-- Flash fallback for non-HTML5 browsers without JavaScript -->
		    		<object width="1800" height="600" type="application/x-shockwave-flash" data="<?php echo includes_url().'js/mediaelement/' ?>flashmediaelement.swf">
		        		<param name="movie" value="<?php echo includes_url().'js/mediaelement/' ?>flashmediaelement.swf" />
		        		<param name="flashvars" value="controls=false&amp;file=<?php echo $d['video_url'] ?>" />
		        		<!-- Image as a last resort -->
		        		<img src="<?php if(isset($d['video_fallback'])) echo $d['video_fallback'] ?>" width="1800" height="600" title="No video playback capabilities"   alt="No video playback capabilities" />
		    		</object>
			</video>
		    		<img src="<?php if(isset($d['video_fallback'])) echo $d['video_fallback'] ?>" alt="" class="ie-fallback" >

		</div>
	<?php endif; ?>
	
</div>	

<?php $section_count++; endif; endforeach; endif; ?>
<?php rad_after_content(); ?>

</div>