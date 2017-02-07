<?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );



?>

<div class="ioa_input clearfix">
	<label for="">Export Current Settings</label>
	<div class="ioa_input_holder medium">
		<a href="<?php echo admin_url()."admin.php?page=ioa"; ?>" class="button-default export-options-panel-settings">Click To Export Current Settings</a>
	</div>
</div>

<div class="ioa_input clearfix">
	<label for="">Import Settings(Open export file and paste text in the textbox)</label>
	<div class="ioa_input_holder medium">
		<textarea name="" id="import_ioa_settings" cols="30" rows="10"></textarea>	
		<a href="<?php echo admin_url()."admin.php?page=ioa"; ?>" class="button-default import-options-panel-settings">Import Settings</a>
	</div>
</div>