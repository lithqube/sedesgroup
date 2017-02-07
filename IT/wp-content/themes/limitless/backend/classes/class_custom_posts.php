<?php

/* ======================================================================= */
/* == Custom Post Maker ================================================== */
/* ======================================================================= */

/* 

Code Name - Custom Post Maker
Version - 1.0
Description - Creates custom posts for themes that works on Hades Plus Framework.

*/


if(!class_exists('IOACustomPost')) {

// == Class defination begins	=====================================================
  class IOACustomPost {
  
  private $posts_options;
  private $name;
  private $taxonomy= '';
  private $label ='';
  private $multi = '';
  
  function __construct($title, $ioa_options = array() ,$taxonomy='',$plural='')
  {
	 
  	$title= ucwords($title);
  	$this->label = $title;
  	$this->multi = $plural;
    
    $menu_icon = null;
    if( isset($ioa_options['labels']['post_icon']) && $ioa_options['labels']['post_icon']!= "" ) $menu_icon = $ioa_options['labels']['post_icon'];



  	$default_labels = array(
					  'name' => _x($title, 'post type general name','ioa'),
					  'singular_name' => _x($title, 'post type singular name','ioa'),
					  'add_new' => _x("Add New", $title,'ioa'),
					  'add_new_item' => _x("Add New ".$title,'ioa','ioa'),
					  'edit_item' => _x("Edit ".$title,'ioa'),
					  'new_item' => _x("New ".$title,'ioa'),
					  'all_items' => _x("All ".$plural,'ioa'),
					  'view_item' => _x("View ".$title,'ioa'),
					  'search_items' => _x("Search ".$plural,'ioa'),
					  'not_found' =>  __("Not Found",'ioa'),
					  'not_found_in_trash' => __("Not Found in Trash",'ioa'), 
					  'parent_item_colon' => "",
					  'menu_name' => $title
				  
					);

 	$default_opts = array(
					  'labels' => $default_labels,
					  'description' => _x("Add your ".$title." here",'ioa'),
					  'public' => true,
					  'publicly_queryable' => true,
					  'show_ui' => true,
					  'exclude_from_search' => false,
					  'query_var' => true,
					  'rewrite' => true,
					  'capability_type' => 'post',
					  '_edit_link' => 'post.php?post=%d',
					  'hierarchical' => true,
					  'show_in_nav_menus' => true,
					  'supports' =>array('title','editor','thumbnail','excerpt'),
					  'menu_icon' => $menu_icon
					  );


 	$ioa_options = array_merge($default_opts,$ioa_options);


	 $this->posts_options = $ioa_options;


//	echo "<pre>"; print_r($custom_type); echo "</pre>";
	
	 $this->name = trim(str_replace(" ","",strtolower(strtolower($title))));
	 
	 
	 if(isset($this->posts_options['menu_icon']) && trim($this->posts_options['menu_icon'])=="")
	 $this->posts_options['menu_icon']  = NULL;
	 
	 add_action('init', array($this,'custom_register'));
	
	if(trim($taxonomy)!="")
	$this->taxonomy = explode(",",$taxonomy);
	
  }
  
  function getPostType()
  {
  	return trim($this->name);
  }

  function getPostLabel()
  {
  	return trim($this->label);
  }

  function getPostMulti()
  {
  	return trim($this->multi);
  }

  function getTax()
  {
  	return $this->taxonomy;
  }
  
  function custom_register(){
    
	
	register_post_type( $this->name , $this->posts_options );

  	
  	if( isset($this->taxonomy) && is_array($this->taxonomy) && $this->taxonomy !=""  )
	{
		foreach($this->taxonomy as $tax)
		{
			
			if(trim($tax)!="" )
			register_taxonomy(
								trim(str_replace(" ","",strtolower($tax))), 
								array($this->name), 
								array(
										"hierarchical" => true, 
										"labels" => array( 'name' => $tax  ) , 
										"singular_label" => "type", 
										"rewrite" => true
									  )
							 );
		}
	}
	
	flush_rewrite_rules();
	 }
	 
	 } // == Class Ends ================================================================
  }
  
   