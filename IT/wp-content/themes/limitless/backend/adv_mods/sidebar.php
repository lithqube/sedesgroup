<?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );
require_once( HPATH.'/classes/ui.php' );

$sidebars = '';
if(get_option(SN.'_custom_sidebars')) $sidebars = get_option(SN.'_custom_sidebars');
?>



<div id="sidebar_manager">

<?php 

echo getIOAInput( 
							array( 
									"label" => __("Add Sidebar",'ioa') , 
									"name" => SN."_enter_svalue" , 
									"default" => "" , 
									"type" => "text",
									"description" => "T",
									"length" => 'medium',
									"value" => ""   ,
									'addMarkup' => "<a href='' class='button-default' id='add-sidebar'>".__(' Add Sidebar ','ioa')."</a>"
							) 
						);

	
 ?>

 <input type="hidden" name="<?php echo SN.'_custom_sidebars'; ?>" class='custom-sidebars' value='<?php echo $sidebars ?>' />

<div class="custom-sidebar-area clearfix">
	<?php 
	$sidebars = explode(',',$sidebars);
	foreach($sidebars as $s)
	{
		if($s!="")
		{
			echo "<div class='sidebar-tag'><span>".$s."</span><i class='ioa-front-icon cancel-circled-2icon- remove-c-sidebar'></i></div>";
		}
	} 

	 ?>
</div>

</div>