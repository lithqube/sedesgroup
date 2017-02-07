<?php
/**
 *  Name - Dummy panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Nobody
 */

if(!is_admin()) return;

class IOACustomPostsManager extends IOA_PANEL_CORE {
	

	
	// init menu
	function __construct () { parent::__construct( __('Content Manager','ioa'),'submenu','ioapty');  }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	

		if(isset($_GET['page']) && $_GET['page'] == 'ioapty' )
		{
			wp_enqueue_media();
		}

		if( isset($_POST['key']) && $_POST['key'] == "custompostsmanager" )
		{		

			$type = $_POST['type'];

			switch($type)
			{
				case "create" : 

					$cp_title =  $_POST['value'];

					$cp_post = array(
					  'post_title'     => $cp_title ,
					  'post_type'      =>  'custompost'  
					);  

					$id = wp_insert_post( $cp_post );
					
					echo "
						<div class='cp-item clearfix'>
							     		<a href='".admin_url()."admin.php?page=ioapty&edit_id={$id}' class='edit-icon pencil-3icon- ioa-front-icon'></a>
							     		<h6>".$cp_title."</h6>
										<a href='{$id}' class='close cancel-circled-2icon- ioa-front-icon'></a>
						</div> 
					";

					break;
				case "update" :
					 $id = $_POST['id'];
					 $ioa_options =  $metaboxes = '';

					 if(isset($_POST['options'])) $ioa_options = $_POST['options'];
					 if(isset($_POST['metaboxes'])) $metaboxes = $_POST['metaboxes'];

					 $title =  $_POST['title'];
					 global $helper;

					 $helper->setPostTitle($title,$id);
					 	wp_publish_post( $id );
					 update_post_meta($id,"options",$ioa_options);
					echo update_post_meta($id,"metaboxes",$metaboxes);

					 break;	

				case "delete" : $id = $_POST['id'];
						 wp_delete_post( $id, true ); 	 
			}


			die();

		}

	  }	
	
	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){	
		
		global $custom_posts, $helper;

		?>
		
		<div class="ioa_panel_wrap" data-url="<?php echo admin_url()."admin.php?page=ioapty"; ?>"> <!-- Panel Wrapper -->
			<div class=" clearfix">  <!-- Panel -->
        		<div id="option-panel-tabs" class="clearfix fullscreen ioa-tabs" data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
        

					<div class="ioa_sidenav_wrap">
	                <ul id="" class="ioa_sidenav clearfix">  <!-- Side Menu -->
	                 
					 <li>
	             		   <a href="#cp_slides" id=""> 
	             		  		 <span><?php _e('General','ioa') ?></span>
	             		   </a>
	             		 </li>
	             		 <?php if(isset($_GET['edit_id'])) : ?>

	             		 <li>
	             		   <a href="#cp_options" id=""> 
	             		  		 <span><?php _e('Meta Boxes','ioa') ?></span>
	             		   </a>
	             		 </li>
	                  	<?php endif; ?>
	                </ul>  <!-- End of Side Menu -->
	            </div>
       			
                
                	<div id="panel-wrapper" class="clearfix custompostsmanager">
						
						
						<div id="cp_slides">
							
							<?php if(!isset($_GET['edit_id'])) : ?>


							<div class="create-cp-section clearfix">
									<input type="text" placeholder="Enter Post Name (only Letters, _ and numbers)" />
									<a href="" class="create_cp_button button-default"> <?php _e('Create Custom Post','ioa') ?> </a>
							</div>

							<div class="cp-title-area clearfix">
								<h4><?php _e('Existing Custom Posts Elements','ioa') ?></h4>

								<div class="filter-media-list clearfix">
									<span><?php _e('Sort','ioa') ?></span>
									<ul>
										
										<li class="<?php if( isset($_GET['qfilter']) && $_GET['qfilter'] =="title"  ) echo 'active'; ?>"><a href="<?php echo admin_url()."admin.php?page=ioapty&qfilter=title"; ?>"><?php _e('Title','ioa') ?></a></li>
										<li class="<?php if( isset($_GET['qfilter']) && $_GET['qfilter'] =="date"  ) echo 'active'; ?>"><a  href="<?php echo admin_url()."admin.php?page=ioapty&qfilter=date"; ?>"><?php _e('Date','ioa') ?></a></li>
										
									</ul>
								</div>
							</div>
							
							<div class="ioac-delete-message">
								<p><?php _e('Are you sure you want to Delete Post Type ','ioa'); ?> <span class="post_type_label"></span></p>
								<a href="yes" class="button-default"><?php _e('Yes','ioa') ?></a>
								<a href="no" class="button-default"><?php _e('No','ioa') ?></a>
							</div>	

							<div class="cp-list">
								  <?php 
								    $app_query = '';
								  	if( isset($_GET['qfilter']) && $_GET['qfilter'] =="title"  )
								  		$app_query = "&order=ASC&orderby=title";
								  	else if( isset($_GET['qfilter']) && $_GET['qfilter'] =="date"  )
								  		$app_query = "&order=ASC&orderby=date";
								  	$query = new WP_Query("post_type=custompost&posts_per_page=-1".$app_query);  

								  	while ($query->have_posts()) : $query->the_post();   ?> 
							     	<div class="cp-item clearfix">
							     		<a href="<?php echo admin_url()."admin.php?page=ioapty&edit_id=".get_the_ID(); ?>" class="edit-icon pencil-3icon- ioa-front-icon"></a>
							     		
										
										<h6><?php the_title(); ?></h6>


										<a href="<?php echo get_the_ID(); ?>" class="close cancel-circled-2icon- ioa-front-icon"></a>
							     	</div> 
							       <?php  endwhile; ?>
							</div>


							<?php else:  $post_id = $_GET['edit_id']; ?>
									
										
												
								<div class="toolbox clearfix">
									<a href="" class="button-save save_cp_slides" id=""><?php _e('Save Changes','ioa') ?></a>
									<a href="<?php echo admin_url()."admin.php?page=ioapty"; ?>" class="button-default" id=""><?php _e('Back to Overview Panel','ioa') ?></a>
								</div>	
								
								<?php 
									
									echo getIOAInput(array( 
									"label" => __("Post Type(Should only contain Letters, _ and numbers)",'ioa') , 
									"name" => "post_type" , 
									"default" => "" , 
									"type" => "text",
									"class" => " custom_post_input ",
									"description" => "",
									"length" => 'long',
									"value" => strtolower(str_replace(" ","_",get_the_title($post_id)))  
										));

								 ?>	

								<?php 
										$ioa_options = get_post_meta($_GET['edit_id'],'options',true);
										
										$w = $helper->getAssocMap($ioa_options,'value');

										echo $custom_posts['default']->getOptionsHTML($w,get_the_title($post_id));
							 	?>									

							<?php endif;  ?>

								

								
						</div>
						
						<?php if(isset($_GET['edit_id'])) : ?>

						<div id="cp_options" class="clearfix">
							

								<div class="toolbox clearfix">
									<a href="" id="add-cp-slides" class="button-default add-cp-slides"> <?php _e('Add Meta Box','ioa') ?> </a>
									<a href="" class="button-save save_cp_slides" id=""><?php _e('Save Changes','ioa') ?></a>

									<a href="<?php echo admin_url()."admin.php?page=ioapty"; ?>" class="button-default" id=""><?php _e('Back to Overview Panel','ioa') ?></a>
								</div>	

							
							 <div class="custom-area-wrap">
								<div class="cp-options-pane">
								<div class="metaboxes-list clearfix" data-id="<?php echo $_GET['edit_id']; ?>">
									<?php 

									$slides = get_post_meta($_GET['edit_id'],'metaboxes',true);

									if( is_array($slides ))
									 {
									 	foreach ($slides as $key => $slide) {
									 		 
									 		 $w = $helper->getAssocMap($slide,'value');
									 		
									 		 echo $custom_posts['default']->getHTML($w);

									 		
									  	}
									 }
									 else
									 {
									 	?>
										
										<div class="information clearfix">
											<p>This Custom Post Does not container any Metaboxes.</p>
										</div>

									 	<?php
									 }
									 ?>	
								</div>
							</div>
							</div>

							<div class="hide">
								<?php 
								$ioa_options = get_post_meta($_GET['edit_id'],'custom_data',true);
								//$w = $helper->getAssocMap($ioa_options,'value');
								echo $custom_posts['default']->getHTML();

								 ?>
							</div>


						</div>	<?php endif; ?>	
					</div>		
					
					

							
                

            </div>
         </div>       	



		<?php
	

	    
	 }
	 

}

new IOACustomPostsManager();