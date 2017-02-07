<?php

/**
 *  Core Class for Admin Template function 
 *  Version : 1.0
 */

if(!class_exists('IOAAdminTemplate')) {

class IOAAdminTemplate {

	private $paths
		
	function __construct()
	{
		$paths = array();
	}

	}

}

$admin_templates = new IOAAdminTemplate();
// Framework Function To include Template

function get_IOA_admin_template($path)
{
  include_once(HURL.'/'.$path);
}
