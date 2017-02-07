<?php
/**
 * Initialize RAD Live Editor
 */

require_once('rad_live_builder/rad_hooks.php');
require_once('rad_live_builder/class_live_radmarkup.php');
require_once('rad_live_builder/class_radlivebuilder.php');


	function addRADLiveBar()
	{
		if( is_rad_editable() )
		get_template_part('backend/rad_live_builder/settings_bar');
	}

	add_action('wp_footer','addRADLiveBar');

