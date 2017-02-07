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
$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';

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

if( ! isset($w['tab_orientation'])) $w['tab_orientation'] = "left";



 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class=" tabs-align-<?php echo $w['tab_orientation']; ?> tabs-inner-wrap" >
		
		<div class="text-title-wrap">
			
			<div class="text-title-inner-wrap"  itemscope itemtype="http://schema.org/Thing">
				<h2 itemprop="name" class="text_title  custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
			</div>	
			
		</div>
		

		<div class="ioa_tabs clearfix ">
  		
		<?php if( $w['tab_orientation']!="bottom") : ?>
  			<ul class='clearfix'>
    
 				<?php $i=0; foreach ($tabs as  $tab) {
  				$icon = '';
  				if(isset($tab['tab_icon'])) 
  					$icon = "<i class='icon ".$tab['tab_icon']."'></i>";

 					echo '<li><a itemprop="name" href="#'.$tab['id'].'" style="color:'.$tab['tab_color'].';background-color:'.$tab['tab_bgcolor'].'">'.$icon.' '.stripslashes($tab['tab_title']).'</a></li>';
 				} ?>
 			</ul>
 		<?php endif; ?>
		
		<?php $i=0; foreach ($tabs as  $tab) {
 					echo '<div class="clearfix" id="'.$tab['id'].'" itemprop="description">'.$helper->format($tab['tab_text']).'</div>';
 				
 			} ?>

		<?php if( $w['tab_orientation']=="bottom") : ?>
  			<ul class='clearfix'>
    
 				<?php $i=0; foreach ($tabs as  $tab) {
 					echo '<li><a itemprop="name" href="#'.$tab['id'].'" style="color:'.$tab['tab_color'].';background-color:'.$tab['tab_bgcolor'].'">'.stripslashes($tab['tab_title']).'</a></li>';
 				} ?>
 			</ul>
 		<?php endif; ?>
  
		</div>

	
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>