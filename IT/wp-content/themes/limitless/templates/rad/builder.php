<?php
global $radunits,$helper,$post;


?>
<div class="rad-builder-area" data-id='<?php echo get_the_ID(); ?>'>

	<?php 
	$data = get_post_meta(get_the_ID(),'rad_data',true);


	if( isset($data[0]) )
	{
		if(!isset($data[0]['data']))
		{
            $data = RADUpgrade($data);
		}
	}

	if(!is_array($data)) $data = array();
	foreach ($data as $key => $section) {
		$d = $section['data'];
		if(!is_array($d))
		$d = json_decode($section['data'],true);
		$d = $helper->getAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];

		RADMarkup::generateRADSection($d,$section['id'],$containers);
		?>
		

		<?php
	}
	?>	

</div>
