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
$rad_attrs[] = 'class=" progress_bar-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';

$rad_attrs[] = 'data-key="'.str_replace('-','_',$ioa_meta_data['widget']['type']).'"';

$colors = array("#8ccdc1","#c0aee1","#aee1bd","#8ad6d7","#d7d28a","#d7998a","#d78a9c","#d68ad7");

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="progress_bar-inner-wrap" style='<?php if(isset($w['col_alignment'])) echo "text-align:".$w['col_alignment'] ?>'>
		
		<div class="text-title-wrap">
			
			<div class="text-title-inner-wrap"  itemscope itemtype="http://schema.org/Thing">
				<h2 itemprop="name" class="text_title  custom-font1"><?php echo $helper->format($w['text_title'],true,false,false); ?></h2>
			</div>	
			
		</div>
			
		<div class="progress-bar-group" data-type="area" data-unit="<?php echo $w['unit'] ?>"  itemscope itemtype="http://schema.org/Dataset">
			
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
							$inpval[$te[0]] =   $te[1]  ; 
							
						}
						
					}
					//$helper->prettyPrint($inpval);

					$values[] = $inpval;
				}	
		}
endif;		

		
			foreach ($values as $key => $value) {
				 $end_gr = $value['pr_color'];
           		 $start_gr = adjustBrightness($value['pr_color'],80);

			$code = "
                     background: -webkit-gradient(left, 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));
                     background: -webkit-linear-gradient(left, ".$start_gr.", ".$end_gr.");
                     background: -moz-linear-gradient(left, ".$start_gr.", ".$end_gr.");
                     background: -ms-linear-gradient(left, ".$start_gr.", ".$end_gr.");
                     background: -o-linear-gradient(left, ".$start_gr.", ".$end_gr.");
                    ";
				?>
				<div class="progress-bar">
					<h6 class='progress-bar-title' itemprop="name"><?php echo stripslashes($value['pr_label']) ?></h6>
					<div class="filler" style="<?php echo $code; ?>" data-fill="<?php echo $value['pr_value']; ?>"><span itemprop="spatial"> <i class="icon icon-sort-down"></i> <?php echo $value['pr_value'].' '.$w['unit']; ?></span></div>
				</div>
				<?php
			}
		    ?>	

				
				
			
		</div>	
		
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>