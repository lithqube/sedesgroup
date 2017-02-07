<?php
/**
 *  Name - Dummy panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Nobody
 */

if(!is_admin()) return;

class IOAMediaManager extends IOA_PANEL_CORE {
	

	
	// init menu
	function __construct () { parent::__construct( __('Slider Mananger','ioa'),'submenu','ioamed');  }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	

		if( isset($_POST['key']) && $_POST['key'] == "ioamediamanager" )
		{

			$type = $_POST['type'];

			switch($type)
			{
				case "create" : 

					$slider_title =  $_POST['value'];

					$slider_post = array(
					  'post_title'     => $slider_title ,
					  'post_type'      =>  'slider'  
					);  

					$id = wp_insert_post( $slider_post );

					echo "

						<div class='slider-item clearfix'>
							     		<a href='".admin_url()."admin.php?page=ioamed&edit_id={$id}' class='edit-icon pencil-3icon- ioa-front-icon'></a>
							     		<h6>".$slider_title."</h6>
							     		<span class='shortcode'> ".__('Shortcode','ioa')." [slider id='{$id}'] </span>
										<a href='{$id}' class='close cancel-circled-2icon- ioa-front-icon'></a>
						</div> 
					";
					break;
				case "update" :
					 $id = $_POST['id'];
					 $ioa_options =  $slides = '';
					 if(isset($_POST['options'])) $ioa_options = $_POST['options'];
					 if(isset($_POST['slides'])) $slides = $_POST['slides'];
					 wp_publish_post( $id );

					 update_post_meta($id,"options",$ioa_options);
					 update_post_meta($id,"slides",$slides);



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
		
		global $ioa_sliders, $helper;

		?>
		
		<div class="ioa_panel_wrap" data-url="<?php echo admin_url()."admin.php?page=ioamed"; ?>"> <!-- Panel Wrapper -->
			<div class=" clearfix">  <!-- Panel -->
        		<div id="option-panel-tabs" class="clearfix fullscreen ioa-tabs" data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
        

					<div class="ioa_sidenav_wrap">
	                <ul id="" class="ioa_sidenav clearfix">  <!-- Side Menu -->
	                 
					 <li>
	             		   <a href="#slider_slides" id=""> 
	             		  		 <span><?php _e('Overview','ioa') ?></span>
	             		   </a>
	             		 </li>
	             		 <?php if(isset($_GET['edit_id'])) : ?>
	             		 <li>
	             		   <a href="#slider_options" id=""> 
	             		  		 <span><?php _e('Options','ioa') ?></span>
	             		   </a>
	             		 </li>
	                  	<?php endif; ?>
	                </ul>  <!-- End of Side Menu -->

	                 </div>
       			
                
                	<div id="panel-wrapper" class="clearfix mediamanager">
						
						
						<div id="slider_slides">
							
							<?php if(!isset($_GET['edit_id'])) : ?>


							<div class="create-slider-section clearfix">
									<input type="text" placeholder="Enter Slider name" />
									<a href="" class="create_slider_button button-default"> <?php _e('Create Slider','ioa') ?> </a>
							</div>

							<div class="slider-title-area clearfix">
								<h4><?php _e('Existing Media Elements','ioa') ?></h4>

								<div class="filter-media-list clearfix">
									<span><?php _e('Sort','ioa') ?></span>
									<ul>
										<li class="<?php if( isset($_GET['qfilter']) && $_GET['qfilter'] =="title"  ) echo 'active'; ?>"><a href="<?php echo admin_url()."admin.php?page=ioamed&qfilter=title"; ?>"><?php _e('Title','ioa') ?></a></li>
										<li class="<?php if( isset($_GET['qfilter']) && $_GET['qfilter'] =="date"  ) echo 'active'; ?>"><a  href="<?php echo admin_url()."admin.php?page=ioamed&qfilter=date"; ?>"><?php _e('Date','ioa') ?></a></li>
										
									</ul>
								</div>
							</div>

							<div class="slider-list">
								  <?php 

								  	 $app_query = '';
								  	if( isset($_GET['qfilter']) && $_GET['qfilter'] =="title"  )
								  		$app_query = "&order=ASC&orderby=title";
								  	else if( isset($_GET['qfilter']) && $_GET['qfilter'] =="date"  )
								  		$app_query = "&order=ASC&orderby=date";

								  	$query = new WP_Query("post_type=slider&posts_per_page=-1".$app_query);  

								  	while ($query->have_posts()) : $query->the_post();   ?> 
							     	<div class="slider-item clearfix">
							     		<a href="<?php echo admin_url()."admin.php?page=ioamed&edit_id=".get_the_ID(); ?>" class="edit-icon pencil-3icon- ioa-front-icon"></a>
							     		
										
										<h6><?php the_title(); ?></h6>

										<span class="shortcode"> <?php _e('Shortcode','ioa') ?> [slider id="<?php echo get_the_ID() ?>"] </span>
										

										<a href="<?php echo get_the_ID(); ?>" class="close cancel-circled-2icon- ioa-front-icon"></a>
							     	</div> 
							       <?php  endwhile; ?>
							</div>

							<?php else:  $post_id = $_GET['edit_id']; ?>
									
										
												
												
												<div class="toolbox clearfix">
													<a href="" class="button-save save_media_slides" id=""><?php _e('Save Changes','ioa') ?></a>
													<a href="" class="button-default" id="add_media_slides"><?php _e('Add Image Slides','ioa') ?></a>
													<a href="<?php echo admin_url()."admin.php?page=ioamed"; ?>" class="button-default" id=""><?php _e('Back to Slider Lists','ioa') ?></a>
												</div>	

												<p class="note"> <?php _e(" To Select Multiple Images hold down control key or cmd for MAC. To select in a row in a single click, hold down shift click on first image then click on last image you want.",'ioa') ?> </p>
												

												<div class="slides-area-wrap">
													<div class="slider-options-pane">
													<div class="slides clearfix" data-id="<?php echo $_GET['edit_id']; ?>">
														<?php 

														$slides = get_post_meta($_GET['edit_id'],'slides',true);

														if( is_array($slides ))
														 {
														 	foreach ($slides as $key => $slide) {
														 		 
														 		 $w = $helper->getAssocMap($slide,'value');
														 		
														 		 echo $ioa_sliders['Slider']->getHTML($w);

														 		
														  	}
														 }
														 ?>	
													</div>
												</div>
												</div>

												<div class="hide">
													<?php 
												
													echo $ioa_sliders['Slider']->getHTML();
													 ?>
												</div>

									

							<?php endif;  ?>

								

								
						</div>
						
						<?php if(isset($_GET['edit_id'])) : ?>
						<div id="slider_options" class="clearfix">

							<div class="toolbox clearfix">
													<a href="" class="button-save save_media_slides" id=""><?php _e('Save Changes','ioa') ?></a>
													<a href="<?php echo admin_url()."admin.php?page=ioamed"; ?>" class="button-default" id=""><?php _e('Back to Slider Lists','ioa') ?></a>
							</div>	

							<?php 
									$ioa_options = get_post_meta($_GET['edit_id'],'options',true);
									$w = $helper->getAssocMap($ioa_options,'value');
										echo $ioa_sliders['Slider']->getOptionsHTML($w);
							 ?>
						</div>	
					<?php endif; ?>
					</div>		


							
                

            </div>
         </div>       	



		<?php
	

	    
	 }
	 

}

new IOAMediaManager();