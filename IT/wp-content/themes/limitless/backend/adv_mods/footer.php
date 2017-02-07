<?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );
global $super_options;


?>
<div class="ioa_input clearfix">

<label for=""> <?php _e('Select Layout','ioa') ?> </label>

<ul class="footer-layout clearfix">
  <li class="two-col"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>
  <li class="three-col"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>
  <li class="four-col"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>
  <li class="five-col"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>

  
  <li class="one-third"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>
  <li class="one-fourth"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>
  <li class="one-fifth"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>
</ul>
<input type="hidden" name="<?php echo SN; ?>_footer_layout" id="ioa_footer_layout" value="<?php if(isset($super_options[SN."_footer_layout"])) echo get_option(SN."_footer_layout"); else echo 'four-col'; ?>" />
</div>

