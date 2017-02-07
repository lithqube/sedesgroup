<?php

/* ======================================================================= */
/* == Custom Box Maker =================================================== */
/* ======================================================================= */

/* 

Author - WPIOAs
Code Name - Custom Box Maker
Version - 1.0
Description - Creates custom meta boxes for themes that works on Hades Plus Framework.

*/


if(!class_exists('IOAMetaBox')) {

// == Class defination begins	=====================================================
  class IOAMetaBox {
  
  private $params;


  function __construct($params)
  {
	
	$this->params = $params;
	
	add_action( 'add_meta_boxes', array( &$this, 'add_custom_meta_box' ) );
	add_action( 'save_post', array( &$this, 'custom_save_data' ));
  }
  
  
  
  function add_custom_meta_box(){
	
	$post_types = explode(',',$this->params['post_type']);
	
	foreach($post_types as $post_type)  
    	add_meta_box( 
		    $this->params['id'],
			$this->params['title'] , 
			array(&$this,"custom_html_wrap")  , 
			$post_type, 
			$this->params['context'], 
			$this->params['priority'] );
	 }
	 
  function custom_html_wrap(){
	    global $post;
	    
		$tag = $this->params['id'];
		$custom = get_post_meta($post->ID,$tag,true);
        echo '<input type="hidden" name="'.$tag.'" id="'.$tag.'" value="'.wp_create_nonce($tag).'" />';
      
		
	    $i = 0;
		$fields = $this->params['inputs'];
	    
	    foreach($fields as $field)
	    {
	    	if( get_post_meta($post->ID,$field['name'],true) !="" )
	    	$field['value']	= get_post_meta($post->ID,$field['name'],true);
			echo getIOAInput($field);
		}
	 
	  
	 }	 
	
	function custom_save_data() {
		global $post;
		if(!isset($post->ID)) return;

		$i = 0;
		$fields = $this->params['inputs'];
	    foreach($fields as $field)
	    {
			if(isset($_POST[$field['name']]))
			update_post_meta($post->ID, $field['name'] , $_POST[$field['name']]);
		}
		
		}
	 
	 
	 } // == Class Ends ================================================================
  }
  
