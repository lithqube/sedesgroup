<?php 
/**
 * Text Template for RAD BUILDER
 */

global $helper, $super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];



$inner_wrap_classes = '';
$rad_attrs = array();
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none")  $rad_attrs[] = 'data-waycheck="'.$w['visibility'].'"';
if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

$way = '';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") $way = 'way-animated';
$rad_attrs[] = 'class=" props-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
$tab_data = array();
$tabs = array();

if( isset($w['rad_tab']) && $w['rad_tab']!="" ) :
	$tab_data = $w['rad_tab'];
	$temp = str_replace("<titan_module>","[ioa_mod]",$tab_data);
	$temp = str_replace("<inp>","[inp]",$temp);
	$temp = str_replace("<s>","[ioas]",$temp);
	$tab_data = explode('[ioa_mod]',$temp);
	

	foreach ($tab_data as $key => $value) {
				
				if($value!="")
				{
					$inpval = array('id' => uniqid('ioa_accordion_'));
					$mods = explode('[inp]', $value);	
					
					foreach($mods as $m)
					{
						
						if($m!="")
						{
							$te = (explode('[ioas]',$m));  
							$inpval[$te[0]] =   $te[1]  ; 
						}

						
					}
					//$helper->prettyPrint($inpval);

					$tabs[] = $inpval;
				}	
		}
endif;				

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="props-inner-wrap" >
		
		
		<?php 
			$i=0;  
			$shortcode = '[props width="'.$w['width'].'" height="'.$w['height'].'" ]' ;
			foreach ($tabs as  $prop) {
					$l = '';
					if(isset($prop['p_link'])) $l = $prop['p_link'];
					
 					$shortcode .= '[prop left="'.$prop['p_left'].'" top="'.$prop['p_top'].'" delay="'.$prop['p_delay'].'" image="'.$prop['p_upload'].'" effect="'.$prop['p_animation'].'" link="'.$l.'" ][/prop]';
 			} 
 			$shortcode .= '[/props]'; echo do_shortcode($shortcode); 
 			?>


	
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>