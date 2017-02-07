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
$rad_attrs[] = 'class=" tabs-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
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

							if( count($te) == 1 ) $te = (explode(';',$m));  
							
							$inpval[$te[0]] =   $te[1]  ; 
							
						}

						
					}
					//$helper->prettyPrint($inpval);

					$tabs[] = $inpval;
				}	
		}
endif;			

$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';
 ?>

<div <?php echo join(" ",$rad_attrs) ?>>

	<div class="accordion-inner-wrap">
		
			<div class="text-title-wrap">
				
				<div class="text-title-inner-wrap" itemscope itemtype="http://schema.org/Thing">
					<?php if($w['text_title']!="") : ?>	<h2 itemprop="name" class="text_title custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2> <?php endif; ?>
				</div>	
				
			</div>
		<div class="ioa_accordion clearfix " itemscope itemtype="http://schema.org/ItemList">
  		
		
		<?php $i=0; foreach ($tabs as  $tab) {
					if(!isset($tab['tab_color'])) $tab['tab_color']= '';
					if(!isset($tab['tab_bgcolor'])) $tab['tab_bgcolor']= '';
					echo ' <h3 itemprop="name" style="border:none;color:'.$tab['tab_color'].';background-color:'.$tab['tab_bgcolor'].'"><i class="ioa-front-icon down-diricon-"></i> '.stripslashes($tab['tab_title']).'</h3>';
 					echo '<div itemprop="description" class="clearfix" id="'.$tab['id'].'">'.$helper->format($tab['tab_text']).'</div>';
 				
 			} ?>

		
  
		</div>

	
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>