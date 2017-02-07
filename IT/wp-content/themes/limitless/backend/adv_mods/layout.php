<?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );

?>
<div class="ioa_input">

<label for=""> <?php _e('Select Default Post Layout','ioa') ?> </label>

<ul class="post-layout clearfix">
  <li class="full"><a href="#"></a> <span><?php _e('Active','ioa') ?></span> </li>
  <li class="left-sidebar"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>
  <li class="right-sidebar"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>

</ul>
<input type="hidden" name="<?php echo SN;?>_post_layout" id="<?php echo SN;?>_post_layout" value="<?php echo get_option(SN."_post_layout"); ?>" />
</div>


<div class="ioa_input">

<label for=""><?php _e(' Select Default Page Layout','ioa') ?> </label>

<ul class="page-layout clearfix">
  <li class="full"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>
  <li class="left-sidebar"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>
  <li class="right-sidebar"><a href="#"></a><span><?php _e('Active','ioa') ?></span></li>

</ul>
<input type="hidden" name="<?php echo SN;?>_page_layout" id="<?php echo SN;?>_page_layout" value="<?php echo get_option(SN."_page_layout"); ?>" />
</div>

