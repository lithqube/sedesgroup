<?php 
/**
 * This template creates a RAD Section
 * All Components are available in Templates -> rad folder
 * @since IOA Framework V3
 */

global $ioa_meta_data;


$d = $ioa_meta_data['rad_section_data']['data'];	
$predict = 0; 
	
$cl = array();

if(count($d) > 0) :

if(isset($d['first']) && $d['first'])  $cl[] = 'first-section'; 
if(isset($d['last']) && $d['last'])  $cl[] = 'last-section'; 
if(isset($d['background_opts']) && $d['background_opts']=='primary-color')  $cl[] = 'section-primary-color '; 
if(isset($d['background_opts']) && $d['background_opts']=='secondary-color')  $cl[] = 'section-secondary-color '; 
if(isset($d['background_opts']) && $d['background_opts']=='tertiary-color')  $cl[] = 'section-tertiary-color '; 
if(isset($d['background_opts']) && $d['background_opts']!='' && trim($d['background_color'])!="")  $cl[] = ' senseSecBGModel ';

if(!isset($ioa_meta_data['rad_section_counter'])) $ioa_meta_data['rad_section_counter'] = 1;

$cl[] = $d['classes'];
?>
<div class="page-section <?php if(isset($d['background_opts']) && $d['background_opts']=='parallax') echo 'is-parallex-bg' ?> clearfix <?php echo join(' ',$cl) ?>" style="z-index:<?php echo $ioa_meta_data['rad_section_counter']++; ?>" id='<?php echo $d['id']; ?>'>
	
	<?php 
	
	if(isset($d['ov_use']) && $d['ov_use']=='yes') : ?>
					<div class="section-overlay"></div>
	<?php endif;

	if(!isset($d['layout']))
	$d['layout'] = 'contained';

	if(isset($d['layout']))
	$ioa_meta_data['section_width'] = $d['layout'];

	$ioa_meta_data['depth'] = 0;
	 ?>	

	<div class="<?php if($d['layout']!="Full Width") echo 'skeleton';  if($d['layout']=="Full Width") echo 'full_width'; if($d['layout']=="Cell Blocks") { echo " blocked-layout"; $ioa_meta_data['blocked'] = true; } ?> section-content auto_align clearfix">
			
		<?php 
			echo do_shortcode($ioa_meta_data['rad_section_data']['containers']);
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

<?php endif;