<?php 
/**
 * Text Template for RAD BUILDER
 */

global $helper, $super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];



$inner_wrap_classes = '';
$rad_attrs = array();

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none")  $rad_attrs[] = 'data-waycheck="'.$w['visibility'].'"';
if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

$way = '';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") $way = 'way-animated';
$rad_attrs[] = 'class=" stacked_circle-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';

if(!isset($w['width'])) $w['width'] = 350;

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="stacked_circle-inner-wrap" style='<?php if(isset($w['col_alignment'])) echo "text-align:".$w['col_alignment'] ?>'>
		
		<div class="text-title-wrap"  itemscope itemtype="http://schema.org/Thing">
			<div class="text-title-inner-wrap">
				<h2 itemprop="name" class="text_title  custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
			</div>	
		</div>
		
		<?php 
   		$tab_data = array();
		$values = array();

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

							if( count($te) == 1 ) $te = (explode(';',$m));  
							
							$inpval[$te[0]] =   $te[1]  ; 
							
						}

						
					}
					//$helper->prettyPrint($inpval);

					$values[] = $inpval;
				}	
		}
endif;		

		$code = '[stacked_circle_group width="'.$w['width'].'" height="'.$w['width'].'"] ';
		
			foreach ($values as $key => $value) {
				$code .= '[single_circle unit="'.$value['pr_unit'].'" percent="'.$value['pr_value'].'" background="'.$value['pr_bgcolor'].'" color="'.$value['pr_color'].'" ]'.$value['pr_label'].'[/single_circle]';				
			}
		$code .= '[/stacked_circle_group]';	
		echo do_shortcode($code);
		    ?>	

	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>