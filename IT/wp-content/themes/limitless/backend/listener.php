<?php
/**
 * Listens for all Ajax Queries / Engines
 */


add_action('wp_ajax_nopriv_ioalistener', 'ioalistener');
add_action('wp_ajax_ioalistener', 'ioalistener');


/**
 * Query Maker Engine
 */

function ioalistener() {


global $ioa_sliders,$post,$super_options, $wpdb,$helper,$portfolio_taxonomy,$ioa_portfolio_slug,$ioa_meta_data;
$type = $_REQUEST["type"]; 
 

if($type=="query_engine") :
	$post_type = $_POST["post_type"];
?>

<div class="query_engine">
	<div class="posts-section">
		<?php 

			if($post_type == "post") :

				$categories=  get_categories(); $cats = array(); 
				foreach ($categories as $category) {
				  $cats[$category->slug] =  $category->cat_name;
				 }
				 
				echo getIOAInput( 
							array( 
									"label" => __("Select Category(if none is selected all categories will be included)",'ioa') , 
									"name" => "select_post_cats" , 
									"default" => "" , 
									"type" => "checkbox",
									"description" => "" ,
									"options" => $cats
							) 
						);

				$tags = get_tags(); $t = array();
		        foreach ($tags as $tag) {
		          $t[$tag->term_id] =  $tag->name;
		        }			

        		echo getIOAInput( 
							array( 
									"label" => __("Select Tags(if none is selected all tags will be included)",'ioa') , 
									"name" => "select_post_tags" , 
									"default" => "" , 
									"type" => "checkbox",
									"description" => "" ,
									"options" => $t
							) 
						);
        	else: 
        	 
        	  global $registered_posts;
				if(!isset($registered_posts[$post_type])) return;
			 	$tax = $registered_posts[$post_type]->getTax();
				if($tax)
				foreach ($tax as $t) {
					$ori = $t;
					$te = trim(str_replace(" ","",strtolower(strtolower($t))));	

					$terms = get_terms($te);
					$ta = array();

					foreach ($terms as $term) {
						$ta[$term->term_id] = $term->name;
					}

					?><div class="custom-tax">
						<?php
							echo getIOAInput( 
								array( 
									"label" => "" , 
									"name" => "taxonomy" , 
									"default" => $te , 
									"type" => "hidden",
									
								) 
							);

							echo getIOAInput( 
							array( 
									"label" => __("Select ",'ioa')."$t" , 
									"name" => "term_".$te , 
									"default" => "" , 
									"type" => "checkbox",
									"description" => "" ,
									"options" => $ta
							) 
						);
						?>
					</div><?php

				}
        		
				


        	endif;	
				$order = 'user_nicename';
				$user_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users ORDER BY $order");
				$all_authors = array();
				
				foreach($user_ids as $user_id) :
					$user = get_userdata($user_id);
					$all_authors[$user_id] = $user->display_name;
				endforeach;

				echo getIOAInput( 
							array( 
									"label" => __("Select Authors",'ioa') , 
									"name" => "select_post_auhtors" , 
									"default" => "" , 
									"type" => "checkbox",
									"description" => "" ,
									"options" => $all_authors
							) 
						);
        		
        		echo getIOAInput( 
							array( 
									"label" => __("Select Order of Posts",'ioa') , 
									"name" => "order" , 
									"default" => "ASC" , 
									"type" => "select",
									"description" => "" ,
									"options" => array("ASC" => "Ascending","DESC" => "Descending")
							) 
						);

        		echo getIOAInput( 
							array( 
									"label" => __("Show Posts by",'ioa') , 
									"name" => "orderby" , 
									"default" => "none" , 
									"type" => "select",
									"description" => "" ,
									"options" => array("none" => "None","ID" => "Post ID","author" => "Author","title" => "Title","date" => "Date","rand" => "Random","comment_count" => "Comments")
							) 
						);

        		echo getIOAInput( 
							array( 
									"label" => __("Show Posts by Year(enter year in 4 digits eg:2011)",'ioa') , 
									"name" => "year" , 
									"default" => "" , 
									"type" => "text",
									"description" => "" 
									
							) 
						);

        		echo getIOAInput( 
							array( 
									"label" => __("Show Posts by Month(enter year in 2 digits eg:12)",'ioa') , 
									"name" => "month" , 
									"default" => "" , 
									"type" => "text",
									"description" => "" 
									
							) 
						);
        		
		 ?>
	</div>
</div>

<?php
elseif($type=="icons") :
?>

<div class="scourge clearfix">
		
	<div class="sc-tabbed-area clearfix">
		<ul class="icons-menu clearfix">
			<li><a href="#foldericons"><?php _e('Image Icon','ioa') ?></a></li>
			<li><a href="#fonticons"><?php _e('Font Icons','ioa') ?></a></li>
			
		</ul>
		
		

		<div class="sc-tabs clearfix">
			<div id="foldericons">
				<a href="" id="sc-icon-import" class=" button-default" data-title="Add" data-label="Add"><?php _e('Import From Library','ioa') ?></a>	
				<div class="clearfix">
					
					<div class="preview_pane image-icon-pane clearfix">
						<h4><?php _e('Preview','ioa') ?></h4>
						
						<div class="icon-canvas">
							<span class="icon-wrap"><img src="" alt="" class=""></span>
						</div>	
						
						<div class="icon-opts clearfix">
							
							<h3> General Stylings </h3>
							<div class="grouping colorpicker-area clearfix">
								<?php 

								echo getIOAInput( 
										array( 
												"label" => __("Container background",'ioa') , 
												"name" => "icon_bg" , 
												"default" =>  "0.7 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "background" , "element" => "parent") 
										)  
									);
								
								 ?>
							</div>	
							<h3> Border Stylings </h3>
							<div class="grouping colorpicker-area clearfix">
								<?php 
								echo getIOAInput( 
										array( 
												"label" => __("Border Radius",'ioa') , 
												"name" => "icon_radius" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "border-radius" , "element" => "parent") 
										)  
									);

								echo getIOAInput( 
										array( 
												"label" => __("Border color",'ioa') , 
												"name" => "icon_brcolor" , 
												"default" =>  "0.7 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "border-color" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Border Width",'ioa') , 
												"name" => "icon_border" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "border-width" , "element" => "parent") 
										)  
									);
								
								
								 ?>
							</div>	
							<h3> <?php _e('Padding Settings','ioa') ?> </h3>
							<div class="grouping clearfix">
								<?php 

								echo getIOAInput( 
										array( 
												"label" => __("Container Horizontal Gap" ,'ioa'), 
												"name" => "icon_cwidth" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small' ,
												"data" => array("attr" => "padding-h" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Container Vertical Gap",'ioa') , 
												"name" => "icon_cheight" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "padding-v" , "element" => "parent") 
										)  
									);
								
								 ?>
							</div>	
							<h3> <?php _e('Width & Opacity Settings','ioa'); ?> </h3>
							<div class="grouping clearfix">
								<?php 

								echo getIOAInput( 
										array( 
												"label" => __("Width",'ioa') , 
												"name" => "icon_width" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "width" , "element" => "img") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Height",'ioa') , 
												"name" => "icon_height" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "height" , "element" => "img") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Opacity",'ioa') , 
												"name" => "icon_opacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "img") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Background Opacity",'ioa') , 
												"name" => "icon_copacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "parent") 
										)  
									);
								 ?>
							</div>	

							



						</div>


					</div> 


				</div>
			</div>
			<div id="fonticons">
	
				<div class="clearfix">
					
					<ul class="parent_dir">
						

						<li>
							<ul class="child_list clearfix">

		<?php 

		$icon_config_file = PATH.'/sprites/fonts/config.json';
		$fh = fopen($icon_config_file, 'r');

		$theData = fread($fh, filesize($icon_config_file));
		fclose($fh);
		
		$icons = json_decode($theData,true);
		$icons = $icons['glyphs'];



		foreach($icons as $icon){
		    ?> <li><i class="ioa-front-icon <?php echo $icon['css'].'icon-' ?> "></i></li> <?php
		}

		

		 ?>	
	</ul>
</li></ul>
					

					<div class="preview_pane clearfix">
						<h4><?php _e('Preview','ioa') ?></h4>
						
						<div class="icon-canvas">
							<span class="icon-wrap"></span>
						</div>	
						
						<div class="icon-opts clearfix">
							
							<h3> <?php _e('General Stylings','ioa') ?> </h3>
							<div class="grouping colorpicker-area clearfix">
								<?php 
								echo getIOAInput( 
										array( 
												"label" => __("Icon color",'ioa') , 
												"name" => "icon_color" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "color" , "element" => "i") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Background",'ioa') , 
												"name" => "icon_bg" , 
												"default" =>  "0.7 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "background" , "element" => "parent") 
										)  
									);

								
								 ?>
							</div>	
							<h3><?php _e(' Border Related Stylings','ioa') ?> </h3>
							<div class="grouping colorpicker-area clearfix">
								<?php 
								echo getIOAInput( 
										array( 
												"label" => __("Border Radius",'ioa') , 
												"name" => "icon_radius" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "border-radius" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Border Width",'ioa') , 
												"name" => "icon_border" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "border-width" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Border color",'ioa') , 
												"name" => "icon_brcolor" , 
												"default" =>  "0.7 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false	,
												"data" => array("attr" => "border-color" , "element" => "parent")
										)  
									);
								
								
								 ?>
							</div>	

							
							<h3><?php _e('Opacity Stylings','ioa') ?></h3>
							<div class="grouping clearfix">
								<?php 
								
								
								
								echo getIOAInput( 
										array( 
												"label" => __("Opacity",'ioa') , 
												"name" => "icon_opacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "i") 
										)  
									);

								echo getIOAInput( 
										array( 
												"label" => __("Background Opacity",'ioa') , 
												"name" => "icon_copacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "parent") 
										)  
									);

								 ?>
							</div>	
							<h3> <?php _e('Size & Padding Settings','ioa') ?> </h3>
							<div class="grouping  clearfix">
								<?php 
								echo getIOAInput( 
										array( 
												"label" => __("Size",'ioa') , 
												"name" => "icon_size" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "font-size" , "element" => "i") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Container Horizontal Gap",'ioa') , 
												"name" => "icon_cwidth" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small' ,
												"data" => array("attr" => "padding-h" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Container Vertical Gap" ,'ioa'), 
												"name" => "icon_cheight" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "padding-v" , "element" => "parent") 
										)  
									);
								
								 ?>
							</div>	



						</div>


					</div> 


				</div>
	
			</div>
			
		</div>
	</div>	

</div>

<?php

elseif($type=="simple_icons") :
?>

<div class="simple-icons clearfix">
	<div class="icon-search-panel clearfix">
		<input type="text" class='sicon-search-input' placeholder="Search Icon">
		<i class="search-3icon- ioa-front-icon "></i>
	</div>
	<ul class="sicon-list clearfix">
								<?php 

								$icon_config_file = PATH.'/sprites/fonts/config.json';
								$fh = fopen($icon_config_file, 'r');

								$theData = fread($fh, filesize($icon_config_file));
								fclose($fh);
								
								$icons = json_decode($theData,true);
								$icons = $icons['glyphs'];



								foreach($icons as $icon){
								    ?> <li><i class="ioa-front-icon <?php echo $icon['css'].'icon-' ?> "></i></li> <?php
								}

								

								 ?>	
	</ul>	
		

	
</div>

<?php
elseif($type=="IOA_media") :
?>

<div class="IOA_api" data-url='<?php echo  URL.'/sprites/i' ; ?>'>
	<div class="IOA-api-top-bar clearfix">
		<a href="" data-title="Add Image" data-label="Add" class="import-IOA-media-image button-default "> <?php _e('Add Image','ioa') ?> </a>
		<a href=""  class="import-IOA-media-video button-default " > <?php _e('Add Video','ioa') ?> </a>
	</div>
	<div class="image-canvas">
		
		<div class="image-IOA-wrap " >
			<div class="inner-IOA-wrap"  ><img   src="" alt="" class='preview-image'></div>
		
			
		</div>



	</div>
	<div class="image-opts">
		<h6>Image Properties</h6>
		<div class="grouping clearfix">
								<?php 

								echo getIOAInput( 
										array( 
												"label" => __("Width",'ioa') , 
												"name" => "image_width" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "width" , "element" => "img") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Height",'ioa') , 
												"name" => "image_height" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "height" , "element" => "img") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Opacity",'ioa') , 
												"name" => "image_opacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "img") 
										)  
									);
								 ?>
							</div>	
							
							<h6><?php __('Select Image Prop','ioa') ?></h6>
		<div class="grouping clearfix">
								<?php 

							
								

								echo getIOAInput( 
										array( 
												"label" => __("Select Shadow",'ioa') , 
												"name" => "shadow" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"options" => array('none' => __('None','ioa') ,'shadow-1' => __('Shadow 1','ioa'),'shadow-2' => __('Shadow 2','ioa'),'shadow-3' => __('Shadow 3','ioa'),'shadow-4' => __('Shadow 4','ioa'),'shadow-5' => __('Shadow 5','ioa'),'shadow-6' => __('Shadow 6','ioa'),'shadow-7' => __('Shadow 7','ioa')),
												"length" => 'small'  ,
												"data" => array("attr" => "shadow" , "element" => "prop") 
										)  
									);

								/*
								echo getIOAInput( 
										array( 
												"label" => "Select Device" , 
												"name" => "shadow" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"options" => array('Phone','Laptop','Mac','Tablet','Browser'),
												"length" => 'small'  ,
												"data" => array("attr" => "prop" , "element" => "prop") 
										)  
									);
								 */

								echo getIOAInput( 
										array( 
												"label" => "Select Glare" , 
												"name" => "shadow" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"options" => array( 'none' => 'None' ,'prop-glare-1' => 'Glare 1','prop-glare-2' =>'Glare 2','prop-glare-3' =>'Glare 3','prop-glare-4' =>'Glare 4','prop-glare-5' =>'Glare 5','prop-glare-6' =>'Glare 6'),
												"length" => 'small'  ,
												"data" => array("attr" => "glare" , "element" => "prop") 
										)  
									);

								echo getIOAInput( 
										array( 
												"label" => "Select Effect(HTML 5)" , 
												"name" => "html5" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"options" => array('none' => 'None' ,'reflection' => 'Reflection','greyscale' => 'Greyscale', 'sepia' => 'Sepia', 'noise' => 'Noise', 'vintage' => 'Vintage', 'concentrate' => "Concentrate" , 'hemingway' => 'Hemingway' , 'nostalgia' => 'Nostalgia', 'hermajesty' => 'Hermajesty' ,'hazydays' => 'Hazydays', 'glowingsun' => 'Glowingsun', 'oldboot' => 'Old Boot' ,'pinhole' => 'Pin Hole', 'jarques' => 'Jarques', 'grungy' => 'Grungy' ,'love' => 'Love', 'orangePeel' => 'Orange Peel', 'crossprocess' => 'Cross Process', 'sincity' => 'Sincity', 'clarity' => 'Clarity', 'lomo' => 'Lomo', 'vintage' => 'Vintage', 'sunrise' => 'Sunrise'),
												"length" => 'small'  ,
												"data" => array("attr" => "html5" , "element" => "prop") 
										)  
									);

								 ?>
							</div>

							<h6>Image Container Properties</h6>
<div class="grouping  clearfix">
								<?php 


								

								echo getIOAInput( 
										array( 
												"label" => "Horizontal Gap" , 
												"name" => "image_cpwidth" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small' ,
												"data" => array("attr" => "padding-h" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => "Vertical Gap" , 
												"name" => "image_cpheight" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "padding-v" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => "Opacity" , 
												"name" => "image_copacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => "Border Radius" , 
												"name" => "image_radius" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "border-radius" , "element" => "parent") 
										)  
									);
								
								echo getIOAInput( 
										array( 
												"label" => "Border Width" , 
												"name" => "image_border" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "border-width" , "element" => "parent") 
										)  
									);
								 ?>
							</div>	
						<div class="grouping colorpicker-area clearfix">
								<?php 

								echo getIOAInput( 
										array( 
												"label" => "Background" , 
												"name" => "image_bg" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "background" , "element" => "parent") 
										)  
									);


								echo getIOAInput( 
										array( 
												"label" => "Border color" , 
												"name" => "image_brcolor" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false	,
												"data" => array("attr" => "border-color" , "element" => "parent")
										)  
									);

								echo getIOAInput( 
										array( 
												"label" => "Box Shadow color" , 
												"name" => "image_shcolor" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false	,
												"data" => array("attr" => "box-shadow-color" , "element" => "parent")
										)  
									);
								

								 ?>
							</div>	
					<div class="grouping">
						<?php 
						echo getIOAInput( 
										array( 
												"label" => "Horizontal Shadow Distance" , 
												"name" => "image_shh" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "box-shadow-h" , "element" => "parent") 
										)  
									);
								
								echo getIOAInput( 
										array( 
												"label" => "Vertical Shadow Distance" , 
												"name" => "image_shv" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "box-shadow-v" , "element" => "parent") 
										)  
									);

								echo getIOAInput( 
										array( 
												"label" => "Shadow Blur" , 
												"name" => "image_shb" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "box-shadow-b" , "element" => "parent") 
										)  
									);
						 ?>
					</div>

	</div>

</div>


<?php
elseif($type=="IOA_bg") :
?>

<div class="background-engine">
	
	<div class="background-head clearfix">
		<?php 
		echo getIOAInput( 
							array( 
									"label" => "Select Background Mode" , 
									"name" => "order" , 
									"default" => "Theme's Style" , 
									"type" => "select",
									"description" => "" ,
									"options" => array('none' => "Theme's Style","css" => "Custom Code")
							) 
						);
		 ?>
	</div>


	<div class="bg-preview-mode clearfix">
		<div class="bg-overlay"></div>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, at officia odit quas aliquam natus tempora modi animi. Suscipit, fuga, nulla tenetur nesciunt temporibus nostrum necessitatibus facere possimus incidunt quaerat animi atque architecto totam provident veniam dolor velit illum sint pariatur optio repellendus aspernatur praesentium recusandae sapiente expedita corrupti eius voluptate eligendi doloremque quibusdam. Voluptatem, modi, illo, quos alias enim vel ipsa hic magni blanditiis illum itaque repellendus numquam sint. Libero, eaque consectetur sit doloremque laudantium. Sit iste totam consectetur.</p>
	</div>
	
	
	<div class="grouping bg-opts colorpicker-area clearfix"> 
		<h6>Container Settings</h6>
								<?php 

								echo getIOAInput( 
										array( 
												"label" => "Background Color" , 
												"name" => "el_bg" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "background-color" , "element" => "el") 
										)  
									);


								
								echo getIOAInput( 
										array( 
												"label" => "Background Repeat " , 
												"name" => "el_bgrepeat" , 
												"default" =>  "repeat" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("repeat","repeat-x","repeat-y","no-repeat"),
												"data" => array("attr" => "background-repeat" , "element" => "el") 
										)  
									);
								
								echo getIOAInput( 
										array( 
												"label" => "Background Position " , 
												"name" => "el_bgposition" , 
												"default" =>  "repeat" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("top left","top right","bottom left","bottom right","center top","center center","center bottom"),
												"data" => array("attr" => "background-position" , "element" => "el") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => "Background Effect" , 
												"name" => "el_parallex" , 
												"default" =>  "none" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("none"=>"None","parallex"=> "Paralllex" ,"sps" => "Particle System","animate-bg-x" => "Animate Background X axis","animate-bg-y" => "Animate Background Y axis" ,"softlight-top" => 'Soft Light At Top',"softlight-bottom" => 'Soft Light At Bottom'),
												"data" => array("attr" => "parallex" , "element" => "el") 
										)  
									);



								 ?>
	</div>

	<div class="bg-opts bg-image">
		<?php 
		echo getIOAInput( 
										array( 
												"label" => "Background Image " , 
												"name" => "el_bgimage" , 
												"default" =>  "" , 
												"type" => "upload",
												"description" => "",
												"length" => 'small' ,
												"data" => array("attr" => "background-image" , "element" => "el") 
										)  
									);
		 ?>
	</div>

	<div class="grouping bg-opts colorpicker-area clearfix"> 
		<h6>Container Overlay Settings</h6>
								<?php 
								
								echo getIOAInput( 
										array( 
												"label" => "Background Color" , 
												"name" => "ov_bg" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "background-color" , "element" => "ov") 
										)  
									);


								
								echo getIOAInput( 
										array( 
												"label" => "Background Repeat " , 
												"name" => "ov_bgrepeat" , 
												"default" =>  "repeat" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("repeat","repeat-x","repeat-y","no-repeat"),
												"data" => array("attr" => "background-repeat" , "element" => "ov") 
										)  
									);
								
								echo getIOAInput( 
										array( 
												"label" => "Background Position " , 
												"name" => "ov_bgposition" , 
												"default" =>  "repeat" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("top left","top right","bottom left","bottom right","center top","center center","center bottom"),
												"data" => array("attr" => "background-position" , "element" => "ov") 
										)  
									);
							
								echo getIOAInput( 
										array( 
												"label" => "Opacity" , 
												"name" => "ov_opacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "ov") 
										)  
									);


								 ?>
	</div>

	<div class="grouping bg-opts colorpicker-area clearfix">
		<?php 
		echo getIOAInput( 
										array( 
												"label" => "Background Image " , 
												"name" => "ov_bgimage" , 
												"default" =>  "" , 
												"type" => "upload",
												"description" => "",
												"length" => 'small' ,
												"data" => array("attr" => "background-image" , "element" => "ov") 
										)  
									); ?>
	</div>

</div>

<?php


elseif($type=="search") :
	
	$q = $_POST['query'];
	 $nos = 4;
	 if(get_option(SN.'_ajax_nos')) $nos = get_option(SN.'_ajax_nos');
	  $query = new WP_Query( 
	  						array(
	  								'posts_per_page' => $nos,
	  								's' => $q,
	  								'cache_results' => false,
	  								'no_found_rows' => true,
	  								'post_status' => 'publish'
	  								)
	  						 );
	  $output = '';

	  if ( $query->have_posts() ) {
	  while ( $query->have_posts() ) {
	    $query->the_post();
	    $img ='';
	    if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail(get_the_ID()))) :

	    $id = get_post_thumbnail_id(get_the_ID());
	      $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
	      $img = $helper->imageDisplay( array( "src"=> $ar[0] ,"height" =>  50 , "width" =>  50 , "parent_wrap" => false ) );  
	    endif; 

	    $output .= '<li class="clearfix"><div class="image">'.$img.'</div> <div class="desc ';
	    if(has_post_thumbnail()) $output .= 'hasImage'; 
	    $output .= ' "><h5><a href="'.get_permalink().'">' . get_the_title() . '</a></h5><span class="date">'.get_the_date("j M, Y").__(' in ','ioa')."<strong>".ucfirst(get_post_type( get_the_ID()) ).'</strong></span><a class="more" href="'.get_permalink().'">'.__('more','ioa').'</a> </div></li>';
	  
	  }
	  	$output .= "<li><a href='".get_search_link($q)."' class='view-all'>".__('View All Results','ioa')."</a></li>";
	  } else {
	    
	    $output = '<li class="not-found">'.__('No Results Found','ioa').' </li>'; 

	  }

	  echo $output;
elseif($type=='posts-timeline') :

global $helper,$ioa_meta_data,$super_options; 


$ioa_meta_data['width'] = 333;
$ioa_meta_data['height'] = 230;

$months = array( 
	"january" => __("January",'ioa') , 
	"february" => __("February",'ioa') , 
	"march" => __("March",'ioa') , 
	"april"  => __("April",'ioa') , 
	"may" => __("May",'ioa') , 
	"june" => __("June",'ioa') , 
	"july" => __("July",'ioa') , 
	"august" => __("August",'ioa') , 
	"september" => __("September",'ioa') , 
	"october" => __("October",'ioa') , 
	"november" => __("November",'ioa') , 
	"december" => __("December",'ioa') 
	); 

$offset = $_POST['offset'];
$month = $_POST['month'];
$post_id = $_POST['id'];
$post_type = $_POST['post_type'];

$helper->preparePage($post_id);

$ioa_options = get_post_meta( $post_id, 'ioa_options', true );
if($ioa_options =="")  $ioa_options = array();

	$ioa_meta_data['query_filter'] = array();
	 $query_s = '';
	if(isset($ioa_options['query_filter'] )) $query_s = $ioa_options['query_filter'];

	if(isset($ioa_options['posts_excerpt_limit'] )) $ioa_meta_data['posts_excerpt_limit'] =  $ioa_options['posts_excerpt_limit'];

	if($query_s!="")
		{
			$gen = array(); $custom_tax = array();
			$query_s = explode("&",$query_s);
			foreach ($query_s as  $para) {
				$p = explode("=", $para); 

					
				if($p[0]=="tax_query")
		        {
		        	$vals = explode("|",$p[1]); 	
		        	$custom_tax[] = array(
		        			'taxonomy' => $vals[0],
							'field' => 'id',
							'terms' => explode(",", $vals[1])

		        		);
		        }
		        else if($para!="") $gen[$p[0]] = $p[1];	
				
			}
			$gen["tax_query"] =   array(
		                 array(
		                    'taxonomy' => 'post_format',
		                    'field' => 'slug',
		                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
		                    'operator' => 'NOT IN'
		                  )
		              );
			$gen['offset'] = $offset;
			$ioa_meta_data['query_filter'] = $gen;
		}
			

query_posts(array_merge(array(

					"posts_per_page" => 4 ,
					"offset" => $offset, 
					"post_type" => $post_type,
					"tax_query" => array(
		                 array(
		                    'taxonomy' => 'post_format',
		                    'field' => 'slug',
		                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
		                    'operator' => 'NOT IN'
		                  )
		              )
					),$ioa_meta_data['query_filter']));

$rs = array(); $count = 0;

if(have_posts()) {
while(have_posts()) : the_post();  
	$row = array();	
	$row["bg"] = '' ; $row["c"] = '';

	$ioa_options = get_post_meta(get_the_ID(), 'ioa_options', true );
	if($ioa_options =="")  $ioa_options = array();

	if(isset( $ioa_options['dominant_bg_color'] )) $row["bg"] =  $ioa_options['dominant_bg_color'];
	if(isset( $ioa_options['dominant_color'] )) $row["c"] = $ioa_options['dominant_color'];

	
	$row["start_time"] = get_the_time();
	$row["start_date"] = get_the_date("d-n-Y");
	$row["ori_date"] = get_the_date();
	$f = get_the_date("d-n-Y");
	$row["factor"] = $f[2].$f[1].$f[0];
	$row["id"] = get_the_ID();


	if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :

		$id = get_post_thumbnail_id();
		$ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		$row["image"] =	 $helper->imageDisplay(array( "crop" => "wproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  

	endif;

	if(!isset($ioa_meta_data['posts_excerpt_limit'])) $ioa_meta_data['posts_excerpt_limit'] = 150;

	$row["title"] = get_the_title();
	$row["permalink"] =  get_permalink();
	$row["content"] =  $helper->getShortenContent($ioa_meta_data['posts_excerpt_limit'], strip_tags(strip_shortcodes(get_the_excerpt())) );
	$rs[] = $row;

	$count++;
endwhile;
}
else
{
	echo "<h4 class='post-end'>".__('End of post','ioa')."</h4>";
	return;
}


$posts  = '';

$i=0;

if( isset($rs[0]["start_date"]) ) :

$opts = explode("-",$rs[0]["start_date"]); 
$transmonth =  $months[strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2])))];
$month = $opts[1];		

endif;

$posts = $posts. " <h4 class='month-label' data-month='$month'>". $transmonth.' <span class="year">'.$opts[2]."</span></h4> ";

foreach($rs as $post)
{
	

	$opts = explode("-",$post["start_date"]); 
	$transmonth =  $months[strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2])))];

	if($opts[1]!=$month)
	{
		$month = $opts[1];	
		$posts = $posts. " <h4 class='month-label' data-month='$month'> ". $transmonth.' <span class="year">'.$opts[2]."</span></h4> ";
	}


$s_date =  $opts[0];
$s_date = str_replace(strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2]))),$transmonth,strtolower($s_date));

if($i%2==0) $clname = 'left-post'; else $clname = "right-post";                 

$posts  = $posts ." <div class=\"clearfix $clname timeline-post\"><span class=\"dot\" ></span><span  class=\"tip\"><span class=\"connector\"></span></span>
<h3 class=\"title\">  <a href=\"".$post['permalink']."\"> ".$post['title']." </h3>   </a><div class=\"image\"><span class='date'>". $s_date."</span>";

if(isset($post['image']))
$posts  = $posts.$post['image']; 

echo $posts;

 
 if($ioa_meta_data['enable_thumbnail']!="true"): 
              $helper->getHover( array('format' => 'link' , 'link' => $post['permalink'] , 'bg' => $post['bg'] , 'c' => $post['c'] )  ); 
           else:  
              $helper->getHover( array('format' => 'image' , 'image' => $post['image_url'], 'bg' => $post['bg'] , 'c' => $post['c'] )  );  
           endif;  
               

$posts  = "</div>
<div class=\"desc clearfix\">".$post['content']."
</div>  <a itemprop='url' href=\"".$post['permalink']."\" class=\"main-button\"> ".__('More','ioa')." </a>
</div>";



$i++;
} ?>

<?php echo $posts;

 elseif ( $type == "portfolio_modelie") :
	global $helper,$ioa_meta_data;

	$offset = $_POST['offset'];
	$height = $_POST['height'];
	$width = $_POST['width'];
	$id = $_POST['id'];

	$ioa_options = get_post_meta( $id, 'ioa_options', true );
	if($ioa_options =="")  $ioa_options = array();

	 if(isset($ioa_options['portfolio_item_limit'])) $ioa_meta_data['portfolio_item_limit'] =  $ioa_options['portfolio_item_limit'];
	 if(!isset($ioa_meta_data['portfolio_item_limit'])) $ioa_meta_data['portfolio_item_limit'] = $super_options[SN.'_portfolio_item_limit'] ;
	
	$ioa_meta_data['portfolio_query_filter'] = array();
	$portfolio_query_s = $ioa_options['portfolio_enable_thumbnail'] = $ioa_meta_data['portfolio_more_label'] =  $ioa_meta_data['portfolio_excerpt_limit'] =	 $ioa_meta_data['portfolio_excerpt'] = $ioa_meta_data['portfolio_query_filter'] = '';  
	  if(isset($ioa_options['portfolio_enable_thumbnail'])) $ioa_meta_data['portfolio_enable_thumbnail'] =  $ioa_options['portfolio_enable_thumbnail'];
	  if(isset($ioa_options['portfolio_more_label'])) $ioa_meta_data['portfolio_more_label'] = $ioa_options['portfolio_more_label'];
	  if(isset($ioa_options['portfolio_excerpt_limit'])) $ioa_meta_data['portfolio_excerpt_limit'] =  $ioa_options['portfolio_excerpt_limit'];
	  if(isset($ioa_options['portfolio_excerpt'])) $ioa_meta_data['portfolio_excerpt'] =  $ioa_options['portfolio_excerpt'];
	  if(isset($ioa_options['portfolio_query_filter'])) $portfolio_query_s =  $ioa_options['portfolio_query_filter'];


	if($portfolio_query_s!="")
		{
			$gen = array(); $custom_tax = array();
			$portfolio_query_s = explode("&",$portfolio_query_s);
			foreach ($portfolio_query_s as  $para) {
				$p = explode("=", $para); 

					
				if($p[0]=="tax_query")
		        {
		        	$vals = explode("|",$p[1]); 	
		        	$custom_tax[] = array(
		        			'taxonomy' => $vals[0],
							'field' => 'id',
							'terms' => explode(",", $vals[1])

		        		);
		        }
		        else if($para!="") $gen[$p[0]] = $p[1];	
				
			}
			$gen["tax_query"] = $custom_tax;
			$ioa_meta_data['portfolio_query_filter'] = $gen;
		}

	if($ioa_meta_data['portfolio_query_filter']=="") $ioa_meta_data['portfolio_query_filter']  = array();	

	$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $ioa_meta_data['portfolio_item_limit'] , 'offset' => $offset) , $ioa_meta_data['portfolio_query_filter']);
	query_posts($opts); 

	if(have_posts()) :
	while(have_posts()) : the_post(); 
	

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
        <?php 

         $dbg = '' ; $dc = '';

         $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
		if($ioa_options =="")  $ioa_options = array();


         if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
			if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
         ?>  
          
        <li data-dbg='<?php echo $dbg; ?>' data-dc='<?php echo $dc; ?>' class="post clearfix " style="color:<?php echo $dc ?>;">
        	<span class="loader"></span>
          <div class="inner-item-wrap">
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
            	
              <div class="image-wrap">
             	 <div class="image" >
                <?php
					  	      $id = get_post_thumbnail_id();
	          		    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );

	          		    if($width > 767)
					    	echo $helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$height , "width" => 600 , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'")); 
						else	
					    	echo $helper->imageDisplay(array( "crop" => "wproportional", "src" => $ar[0] , "height" =>$height , "width" => $width , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'")); 
				?>

				      <div class="hover" <?php echo 'style="background-color:'.$dbg.'"' ?>>
				      	<h2 class=""> <a href="<?php the_permalink(); ?>" class="clearfix" <?php echo 'style="color:'.$dc.'"' ?>><?php the_title(); ?></a></h2> 
            	<?php
                  $terms = get_the_terms( $post->ID, $portfolio_taxonomy );
                    
                   if ( $terms && ! is_wp_error( $terms ) ) : 

                   $links = array();
                   foreach ( $terms as $term ) { $links[] = '<a href="' .get_term_link($term->slug, $portfolio_taxonomy) .'">'.$term->name.'</a>'; }
                   $terms = join( " | ", $links );
                  ?>

                  <p class="tags" <?php echo 'style="color:'.$dc.'"' ?>>
                     <?php echo $terms; ?>
                  </p>

              <?php endif; ?>
                	 <a href="<?php the_permalink(); ?>" style='color:<?php echo $dbg; ?>;background-color:<?php echo $dc; ?>' class="hover-lightbox ioa-front-icon link-2icon-"></a>  
              </div>
                
               </div>
              </div>
              
             <?php endif; ?>
          </div>  
        </li>
	


	<?php endwhile; ?>

	<li class="load-more-posts clearfix">
			<a href="" class="load-more-posts-button" style="line-height:<?php echo $height; ?>px" data-loading="<?php _e('Loading','ioa') ?>" data-default="<?php _e('Load More','ioa') ?>"><?php _e('Load More','ioa') ?></a>
	</li>
	
	<?php else : ?>
		
	<li class="end-more-posts clearfix" style="line-height:<?php echo $height; ?>px"  >
			<?php _e('No More Posts','ioa') ?>
	</li>		
		
	<?php endif; ?>

	<?php

elseif($type=='options_import') :

$theme_options = $_POST['data'];

$theme_options = base64_decode($theme_options);	
$input = json_decode($theme_options,true);
	
foreach($input as $key => $val)
{
	$data = @unserialize($val["option_value"]);

	if (  $data === false) $data = $val["option_value"];
	else $data = unserialize($data);

	update_option($val["option_name"],$data);
}

echo 'done';

elseif($type=="portfolio_fullscreen") :	

	global $helper,$ioa_meta_data,$paged;
	
	$width = $_POST['width'];
	$height = $_POST['height'];
	$id = $_POST['id'];

	

	$ioa_options = get_post_meta( $id, 'ioa_options', true );
	if($ioa_options =="")  $ioa_options = array();

	 if(isset($ioa_options['portfolio_item_limit'])) $ioa_meta_data['portfolio_item_limit'] =  $ioa_options['portfolio_item_limit'];
	 if(!isset($ioa_meta_data['portfolio_item_limit'])) $ioa_meta_data['portfolio_item_limit'] = $super_options[SN.'_portfolio_item_limit'] ;
	
	$ioa_meta_data['portfolio_query_filter'] = array();
	$portfolio_query_s = $ioa_options['portfolio_enable_thumbnail'] = $ioa_meta_data['portfolio_more_label'] =  $ioa_meta_data['portfolio_excerpt_limit'] =	 $ioa_meta_data['portfolio_excerpt'] = $ioa_meta_data['portfolio_query_filter'] = '';  
	 
	  if(isset($ioa_options['portfolio_enable_thumbnail'])) $ioa_meta_data['portfolio_enable_thumbnail'] =  $ioa_options['portfolio_enable_thumbnail'];
	  if(isset($ioa_options['portfolio_more_label'])) $ioa_meta_data['portfolio_more_label'] = $ioa_options['portfolio_more_label'];
	  if(isset($ioa_options['portfolio_excerpt_limit'])) $ioa_meta_data['portfolio_excerpt_limit'] =  $ioa_options['portfolio_excerpt_limit'];
	  if(isset($ioa_options['portfolio_excerpt'])) $ioa_meta_data['portfolio_excerpt'] =  $ioa_options['portfolio_excerpt'];
	  if(isset($ioa_options['portfolio_query_filter'])) $portfolio_query_s =  $ioa_options['portfolio_query_filter'];
	  if(isset($ioa_options['portfolio_image_resize']))$ioa_meta_data['thumb_resize'] =  $ioa_options['portfolio_image_resize'];
	

	if($portfolio_query_s!="")
		{
			$gen = array(); $custom_tax = array();
			$portfolio_query_s = explode("&",$portfolio_query_s);
			foreach ($portfolio_query_s as  $para) {
				$p = explode("=", $para); 

					
				if($p[0]=="tax_query")
		        {
		        	$vals = explode("|",$p[1]); 	
		        	$custom_tax[] = array(
		        			'taxonomy' => $vals[0],
							'field' => 'id',
							'terms' => explode(",", $vals[1])

		        		);
		        }
		        else if($para!="") $gen[$p[0]] = $p[1];	
				
			}
			$gen["tax_query"] = $custom_tax;
			$ioa_meta_data['portfolio_query_filter'] = $gen;
		}

	if($ioa_meta_data['portfolio_query_filter']=="") $ioa_meta_data['portfolio_query_filter'] = array();

	$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $ioa_meta_data['portfolio_item_limit'] , 'paged' => $paged) , $ioa_meta_data['portfolio_query_filter']);
	query_posts($opts); 

	?> 

	<div class="ioa-gallery seleneGallery" data-effect_type="fade" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>" data-duration="5" data-autoplay="true" data-captions="true" data-arrow_control="true" data-thumbnails="true" > 
                      <div class="gallery-holder"> 
                      	<?php
         if(have_posts()) :             	
	while(have_posts()) : the_post(); 
	

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
        <?php 

         $dbg = '' ; $dc = '';

         $ioa_options = get_post_meta( get_the_ID() , 'ioa_options', true );
		if($ioa_options =="")  $ioa_options = array();


         if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
			if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];
        
         ?>  
          
       	
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) :

               $id = get_post_thumbnail_id();
	           $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
	                if(!isset($ioa_meta_data['thumb_resize'])) $ioa_meta_data['thumb_resize'] = 'default';

               ?>   
            	
               <div class="gallery-item <?php echo $ioa_meta_data['thumb_resize']; ?>" data-thumbnail="<?php $th = wp_get_attachment_image_src($id); echo $th[0]; ?>">

	                <?php

                	switch ($ioa_meta_data['thumb_resize']) {
                		
                		case 'default': echo $helper->imageDisplay(array( "src" => $ar[0] , "height" =>$height , "width" => $width , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                		case 'proportional': echo $helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$height , "width" => $width , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                		case 'none' :	
                		default: echo "<img src='". $ar[0]."' />"; break;
                	}
					  	     
					   // 
					
				?>

		      
		      <div class="gallery-desc" >
		      		<h4 class="" <?php echo 'style="color:'.$dc.';background-color:'.$dbg.'"' ?>> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h4>
		      		<div class="caption" <?php echo 'style="color:'.$dc.';background-color:'.$dbg.'"' ?>>
					
					
                  <?php  if(  $ioa_meta_data['portfolio_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      if(!isset($ioa_meta_data['portfolio_excerpt_limit'])) $ioa_meta_data['portfolio_excerpt_limit'] = 150;	
                      $content = get_the_excerpt();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);

                      echo $helper->getShortenContent( 150,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>

                 
                  
                  	 <a href="<?php the_permalink(); ?>" style='color:<?php echo $dbg; ?>;background:<?php echo $dc; ?>' class="hover-link"><?php echo stripslashes($ioa_meta_data['portfolio_more_label']) ?></a>  

		      		</div> 
              </div>
                
              
              </div>
              
             <?php endif; ?>
          
      
	


	<?php endwhile;
			else : 
				echo '<div class="no-posts-found skeleton auto_align"><h4>'.__('Sorry no posts found','ioa').'</h4></div>';
				
			endif;
	?> </div></div> <?php

 elseif ( $type == "single_portfolio_modelie") :
	global $helper,$ioa_meta_data;

	$height = $_POST['height'];
	$width = $_POST['width'];
	$id = $_POST['id'];
	$gallery_images = '';

	$ioa_options = get_post_meta( $id, 'ioa_options', true );
	if($ioa_options =="")  $ioa_options = array();

	if(isset($ioa_options['ioa_gallery_data'])) $gallery_images =  $ioa_options['ioa_gallery_data'];	
      
         ?>  
          
          <?php if(isset($gallery_images) && trim($gallery_images) != "" ) : $ar = explode(";",stripslashes($gallery_images));
						
						foreach( $ar as $image) :
							if($image!="") :
								$g_opts = explode("<gl>",$image); ?>
							 <li  class=" clearfix " ><span class="loader"></span>
        			  <div class="inner-item-wrap">
            
              
              <div class="image-wrap">
             	 <div class="image" >
                <?php
                	if($width > 767)
					    echo $helper->imageDisplay(array( "crop" => "hproportional", "src" => $g_opts[0] , "height" =>$height , "width" => 600 , "parent_wrap" => false,"imageAttr" => " alt='".get_the_title()."'")); 
					else
					    echo $helper->imageDisplay(array( "crop" => "wproportional", "src" => $g_opts[0] , "height" =>$height , "width" => $width , "parent_wrap" => false,"imageAttr" => " alt='".get_the_title()."'")); 
				?>
                
               </div>
              </div>
           
          </div>  
        </li>
											<?php 
						endif;
					endforeach; endif;

       
elseif($type=="single_portfolio_fullscreen") :	

	global $helper,$ioa_meta_data,$paged;
	
	$width = $_POST['width'];
	$height = $_POST['height'];
	$id = $_POST['id'];
	$gallery_images = '';

	$ioa_options = get_post_meta( $id, 'ioa_options', true );
	if($ioa_options =="")  $ioa_options = array();

	if(isset($ioa_options['ioa_gallery_data'])) $gallery_images =  $ioa_options['ioa_gallery_data'];	

	?> 

	<div class="ioa-gallery seleneGallery" data-effect_type="scroll" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>" data-duration="5" data-autoplay="true" data-captions="true" data-arrow_control="true" data-thumbnails="true" > 
                     <div class="gallery-holder">
					<?php if(isset($gallery_images) && trim($gallery_images) != "" ) : $ar = explode(";",stripslashes($gallery_images));
						
						foreach( $ar as $image) :
							if($image!="") :
								$g_opts = explode("<gl>",$image);

							
						 ?>
						 <div class="gallery-item" data-thumbnail="<?php echo $g_opts[1]; ?>">
                      		<?php echo $helper->imageDisplay(array( "crop" => "proportional" ,"src" =>$g_opts[0] , 'imageAttr' =>  $g_opts[2], "parent_wrap" => false , "width" => $width , "height" => $height )); ?> 
                     		 <div class="gallery-desc">
                         	 	<?php if(trim($g_opts[3])!="") echo '<h4>'.$g_opts[3].'</h4>'; ?>
                         	 	<?php if(trim($g_opts[4])!="") echo '<div class="caption">'.$g_opts[4].'</div>'; ?>
                         	 </div>  
                  		 </div>	
					<?php 
						endif;
					endforeach; endif; ?>
				</div></div> <?php

elseif ($type =="portfolio_maerya") :

	$pid = $_POST['id'];
	$ajax_post = get_post($pid);
	?>
	
	<div class="one_half left">
		<?php    
			$id = get_post_thumbnail_id($pid);
            $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
             echo $helper->imageDisplay(array( "src" => $ar[0], "height" =>530 , "width" => 530 , "link" => get_permalink($pid) ,"imageAttr" => ""));  
            ?>

	</div>
	<div class="one_half left">
		<h2><a href="<?php echo get_permalink($pid) ?>"><?php  echo $ajax_post->post_title; ?></a></h2>
		<div class="desc clearfix">
				
				<div class="clearfix">
                    <p>
                      <?php
                      
                      $content = $ajax_post->post_content ;
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $helper->getShortenContent( 320 ,   $content); ?>
                    </p>
                  </div>
                       <a href="<?php echo get_permalink($pid) ?>" class="read-more"><?php _e('View the Post','ioa') ?></a>  

	
		</div>
	</div>


	<?php

elseif($type == "shortcode") :

require_once(HPATH.'/shortcode_engine.php');

 ?>

					<ul class="top-shortcodes-menu clearfix">
						<?php 
						$i=0;
						foreach( $ioa_shortcodes_array as $key => $menu_item)
						{
							if($i==0)
								echo "<li class='active' data-id=".str_replace(' ','-',strtolower(trim($key)))."> <span class='icon-label'>{$key}</span> </li>";
							else	
								echo "<li data-id=".str_replace(' ','-',strtolower(trim($key)))."> <span class='icon-label'>{$key}</span> </li>";
							$i++;
						}
						 ?>	
					</ul>	
					
					<div class="shortcodes-desc-area clearfix">
						
						<?php 
						foreach( $ioa_shortcodes_array as $key => $item) : ?>
							<div id="<?php echo str_replace(' ','-',strtolower(trim($key))) ?>">
								
								<?php $opts = array("none" => "None"); foreach ($item['shortcodes'] as $key => $shortcode)

												
									$opts["s-".str_replace(' ','-',strtolower(trim($key)))] =  $shortcode['name'];

									echo getIOAInput(array( 
												"label" => __("Select Shortcode",'ioa'), 
												"name" => "select_shortcode" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"length" => 'medium',
												"options" => $opts   
													));

								 ?>
								<a href="" class="info_shortcode button-default"><?php _e('Help','ioa'); ?></a>
							</div>
						<?php 	
						endforeach;
					 ?>	
					 
					</div>	
					
					<div id="s-column-maker" class='ex-shortcode-mods'>
						<h6><?php _e('Click the layout you want, a layout grid will be generated. Once satisfied, click on Insert Column Layout. When you are adding last column select the column with last suffix to ensure proper spacings.','ioa') ?></h6>
						<div class="top-bar clearfix">
							<a href="full" class='button-default'><?php _e('100%','ioa'); ?></a>
							<a href="one_half" class='button-default'><?php _e('50%','ioa'); ?></a>
							<a class="last button-default" href="one_half"><?php _e('50% Last','ioa'); ?></a>
							<a href="one_fourth" class='button-default'><?php _e('25%','ioa'); ?></a>
							<a class="last button-default" href="one_fourth"><?php _e('25% Last','ioa'); ?></a>
							<a href="one_third" class='button-default'><?php _e('33%','ioa'); ?></a>
							<a class="last button-default" href="one_third"><?php _e('33% Last','ioa'); ?></a>
							<a href="one_fifth" class='button-default'><?php _e('20%','ioa'); ?></a>
							<a class="last button-default" href="one_fifth"><?php _e('20% Last','ioa'); ?></a>
							<a href="three_fourth" class='button-default'><?php _e('75%','ioa'); ?></a>
							<a class="last button-default" href="three_fourth"><?php _e('75% Last','ioa'); ?></a>
							<a href="two_third" class='button-default'><?php _e('66%','ioa'); ?></a>
							<a class="last button-default" href="two_third"><?php _e('66% Last','ioa'); ?></a>
							<a href="four_fifth" class='button-default'><?php _e('80%','ioa'); ?></a>
							<a class="last button-default" href="four_fifth"><?php _e('80% Last','ioa'); ?></a>
						</div>
						<div class="clearfix">
							<a href="" id="column-maker-insert"><?php _e(' Insert Column Layout ','ioa'); ?></a>	
						</div>
						<div class="column-maker-area clearfix">
							
						</div>	

					</div>
					
					<div id="s-pricing_table" class='ex-shortcode-mods clearfix'>
						<a href="" id="pricingtable-insert"><?php _e(' Insert Table ','ioa'); ?></a>	
						<h4 class="feature-column-head clearfix"><?php _e('Feature Column Input(Click to edit)','ioa') ?></h4>
						<div class="feature-column-body clearfix">
							<?php 
						echo getIOAInput(array( 
												"label" => __("Enable use of Feature Column",'ioa'), 
												"name" => "feature_column" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"length" => 'medium',
												"options" => array( "true" => "True" ,"false" => "False" )   
													));
						echo getIOAInput(array( 
												"label" => __("Title",'ioa'), 
												"name" => "feature_column" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'medium',
												"data" => array("value" => "title") ,
												"class" => ' feature-col '
													));
						echo getIOAInput(array( 
												"label" => __("Information below Title",'ioa'), 
												"name" => "feature_column" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'medium',
												"data" => array("value" => "info")  ,
												"class" => ' feature-col '
													));
						echo getIOAInput(array( 
												"label" => __("Rows data, separate values by , ",'ioa'), 
												"name" => "feature_column" , 
												"default" => "" , 
												"type" => "textarea",
												"description" => "",
												"length" => 'medium',
												"data" => array("value" => "row_data")  ,
												"class" => ' feature-col '
													));
						 ?>	
						</div>
						<?php 

						$inputs = array(

									array( 
											"label" => __("Plan Name",'ioa'), 
											"name" => "plan_name" , 
											"default" => "" , 
											"value" => "" , 
											"type" => "text",
											"description" => "",
											"length" => 'medium'
											),
									array( 
											"label" => __("Plan Price",'ioa'), 
											"name" => "plan_price" , 
											"default" => "" , 
											"value" => "" , 
											"type" => "text",
											"description" => "",
											"length" => 'medium'
											),
									array( 
											"label" => __("Plan Price Information",'ioa'), 
											"name" => "plan_price_info" , 
											"default" => "" , 
											"value" => "" , 
											"type" => "text",
											"description" => "",
											"length" => 'medium'
											),

									array( 
											"label" => __("Plan Row Data",'ioa'), 
											"name" => "row_data" , 
											"default" => "" , 
											"value" => "" , 
											"type" => "text",
											"description" => "",
											"length" => 'medium'
											),

									
									array( 
											"label" => __("Button Label",'ioa'), 
											"name" => "button_label" , 
											"default" => "" , 
											"value" => "" , 
											"type" => "text",
											"description" => "",
											"length" => 'medium'
											),

									array( 
											"label" => __("Button Link",'ioa'), 
											"name" => "button_link" , 
											"default" => "" , 
											"value" => "" , 
											"type" => "text",
											"description" => "",
											"length" => 'medium'
											),

									array( 
												"label" => __("Is Featured Column",'ioa'), 
												"name" => "featured" , 
												"default" => "false" , 
												"type" => "select",
												"description" => "",
												"length" => 'medium',
												"options" => array( "true" => "True" ,"false" => "False" )   
													)

								);	

							echo getIOAInput( array(

												'inputs' => $inputs,
												'label' => __('Add Column','ioa'),
												'name' => 'pricing_cols',
												'type'=>'module',
												'unit' => __('Column','ioa')
												)
																
										);


						?>
					</div>
					<?php 

						foreach( $ioa_shortcodes_array as $key => $item) : ?>
							<?php foreach ($item['shortcodes'] as $key => $shortcode) {
								  

								if(isset($shortcode['module'])){
									?>
							<div id="<?php echo "s-".str_replace(' ','-',strtolower(trim($key))); ?>" class='ex-shortcode-mods  clearfix'>
								<a href="" data-applier="<?php echo $shortcode['mod_applier']; ?>" data-parent="<?php echo $shortcode['mod_parent']; ?>" class="add-mod-shortcode"><?php _e('Insert Shortcode','ioa') ?></a>
								<?php 
								 if(isset($shortcode['parent_input']))	
								 foreach ($shortcode['parent_input'] as $key => $input) {

								 	switch($input['type'])
								  			{
								  				case 'select' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "parent_val_holder" , 
																						"default" => "" , 
																						"type" => "select",
																						"description" => "",
																						"length" => 'medium',
																						"options" => $input['values'] , 
																						"data" => array("value" => $key) ,
																						"class" => "parent_val"  
																							));
								  								break;

								  				case 'colorpicker' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "parent_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "colorpicker",
																						"description" => "",
																						"length" => 'small',
																						"data" => array("value" => $key)  ,
																						"class" => "parent_val" 
																							));
								  								break;
								  				case 'text' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "parent_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "text",
																						"description" => "",
																						"length" => 'medium',
																						"data" => array("value" => $key) ,
																						"class" => "parent_val"   
																							));
								  								break;
								  				case 'upload' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "parent_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "upload",
																						"description" => "",
																						"length" => 'medium',
																						"data" => array("value" => $key)  ,
																						"class" => "parent_val"  
																							));
								  								break;					
								  				case 'textarea' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "parent_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "textarea",
																						"description" => "",
																						"length" => 'medium',
																						"data" => array("value" => $key)  ,
																						"class" => "parent_val"  
																							));
								  								break;					
								  				case 'icon' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "parent_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "text",
																						"description" => "",
																						"length" => 'small',
																						"data" => array("value" => $key) ,
																						"class" => "parent_val" ,
																						'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>'   
																							));
								  								break;								

								  			}

								 }
								$mod = array();
								  foreach ($shortcode['module'] as $key => $input) {

								  		if( isset($input['values']) )
								  		{
								  			switch($input['type'])
								  			{
								  				case 'select' :
								  								$mod[] = array( 
																						"label" => $input['label'], 
																						"name" => $key , 
																						"default" => "" , 
																						"type" => "select",
																						"description" => "",
																						"length" => 'medium',
																						"options" => $input['values'] , 
																						);
								  								break;
								  				case 'upload' :
								  								$mod[] = array( 
																						"label" => $input['label'], 
																						"name" => $key , 
																						"default" => "" , 
																						"type" => "upload",
																						"description" => "",
																						"length" => 'small',
																						"value" => $input['values'] , 
																						);
								  								break;				
								  				case 'colorpicker' :
								  								$mod[] = array( 
																						"label" => $input['label'], 
																						"name" => $key , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "colorpicker",
																						"description" => "",
																						"length" => 'small',
																						);
								  								break;
								  				case 'text' :
								  								$mod[] = array( 
																						"label" => $input['label'], 
																						"name" => $key , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "text",
																						"description" => "",
																						"length" => 'medium',
																						);
								  								break;	
								  				case 'textarea' :
								  								$mod[] =  array( 
																						"label" => $input['label'], 
																						"name" => $key , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "textarea",
																						"description" => "",
																						"length" => 'medium',
																						);
								  								break;					
								  				case 'icon' :
								  								$mod[] = array( 
																						"label" => $input['label'], 
																						"name" => $key , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "text",
																						"description" => "",
																						"length" => 'small',
																						'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>'   
																						);
								  								break;								

								  			}
								  			
								  		}

								  		
								  }

								  echo getIOAInput( array(

												'inputs' => $mod,
												'label' => $shortcode['mod_label'],
												'name' => 'mod_data',
												'type'=>'module',
												'unit' => $shortcode['mod_unit']
												)
										);

								 ?>
							</div>	
						<?php
								}


								if(isset($shortcode['inputs'])){
									?>
							<div id="<?php echo "s-".str_replace(' ','-',strtolower(trim($key))); ?>" class='ex-shortcode-mods clearfix'>
								<a href="" class="add-mod-shortcode"><?php _e('Insert Shortcode','ioa') ?></a>
								<?php 
								 if( isset($shortcode["content"]))
								 {
								 	$l = __("Add Content",'ioa'); $t = "textarea";
								 	if(isset($shortcode['content_label'])) $l = $shortcode['content_label'];
								 	if(isset($shortcode['content_type'])) $t = $shortcode['content_type'];
								 	echo getIOAInput(array( 
																"label" => $l, 
																"name" => "shortcodes_content_holder" , 
																"default" => "",
																"value" => "", 
																"type" => $t,
																"description" => "",
																"length" => 'medium'
											));
								 }
								  foreach ($shortcode['inputs'] as $key => $input) {

								  		if( isset($input['values']) )
								  		{
								  			switch($input['type'])
								  			{
								  				case 'select' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "shortcodes_val_holder" , 
																						"default" => "" , 
																						"type" => "select",
																						"description" => "",
																						"length" => 'medium',
																						"options" => $input['values'] , 
																						"data" => array("value" => $key)   
																							));
								  								break;

								  				case 'colorpicker' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "shortcodes_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "colorpicker",
																						"description" => "",
																						"length" => 'medium',
																						"data" => array("value" => $key)   
																							));
								  								break;
								  				case 'text' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "shortcodes_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "text",
																						"description" => "",
																						"length" => 'medium',
																						"data" => array("value" => $key)   
																							));
								  								break;
								  				case 'upload' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "shortcodes_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "upload",
																						"description" => "",
																						"length" => 'medium',
																						"data" => array("value" => $key)   
																							));
								  								break;					
								  				case 'textarea' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "shortcodes_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "textarea",
																						"description" => "",
																						"length" => 'medium',
																						"data" => array("value" => $key)   
																							));
								  								break;					
								  				case 'icon' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "shortcodes_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "text",
																						"description" => "",
																						"length" => 'small',
																						"data" => array("value" => $key) ,
																						'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>'   
																							));
								  								break;
								  				case 'wp_query' :
								  								echo getIOAInput(array( 
																						"label" => $input['label'], 
																						"name" => "shortcodes_val_holder" , 
																						"default" => "",
																						"value" => $input['values'] , 
																						"type" => "text",
																						"description" => "",
																						"length" => 'small',
																						"data" => array("value" => $key) ,
																						'addMarkup' => '<a href="" class="button-default query-maker">'.__('Add Filter','ioa').'</a>'   
																							));
								  								break;												

								  			}
								  			
								  		}


								  }
								 ?>
							</div>	
						<?php
								} } endforeach; ?>


					<div class="shortcode-help-desk">
						<?php
						foreach( $ioa_shortcodes_array as $key => $item) : ?>
							<?php foreach ($item['shortcodes'] as $key => $shortcode)  { 
								?>
						<div class="desc-area <?php echo "s-".str_replace(' ','-',strtolower(trim($key))); ?>">
							<ul>
								<li class='clearfix'><strong><?php _e('Syntax','ioa') ?> :</strong> <span class="syntax"><?php echo $shortcode['syntax'] ?></span></li>
								<li class='clearfix'><strong><?php _e('Description','ioa') ?> :</strong><span> <?php echo $shortcode['description'] ?></span></li>
								<?php if(isset($shortcode['parameters'])) : ?>
								<li class='clearfix'><strong><?php _e('Options','ioa') ?> : </strong>
									<ul>
										<?php foreach ( $shortcode['parameters'] as $key => $value) {
											echo "<li> <strong>$key -</strong>  <p>$value</p> </li>";
										} ?>
									</ul>
								</li>
								<?php endif; ?>
								
							</ul>
						</div>
						<?php  } endforeach; ?>
					</div>


<?php
elseif($type == "gspeed") :
	$score = -1;
	
	if(isset($_POST['score']))
		$score = $_POST['score'];

		echo set_transient( SN.'_gspeed', $score, 60*60*12 );

elseif($type=='headercons') :

	$list = $_POST['unused_list'];
	$data = $_POST['layout'];
	$post_id = $_POST['id'];
	$form_array = array($list , $data);

	update_post_meta($post_id,'ioaheader_data',$form_array);

elseif($type=='delheadercons') :

	$post_id = $_POST['id'];
	delete_post_meta($post_id,'ioaheader_data');

elseif($type=="Enigma-styler-add") :

	$name = $_POST['label'];
	$key = uniqid();

	$table = get_option(SN.'enigma_hash');

	if(!$table || !is_array($table)) $table = array();

	$table['en'.$key] = $name;

	update_option(SN.'enigma_hash',$table);



	echo 'en'.$key;

elseif($type=="Enigma-typo") :

	$font_stacks = json_decode(stripslashes($_POST['fontstack']));

	update_option(SN.'font_stacks',$font_stacks);

	$font_selector = $_POST['font_selector'];
	update_option(SN.'font_selector',$font_selector);

	$fontface = $_POST['fontface'];
	update_option(SN.'_font_face_font',$fontface);

	$font_deck_project_id = $_POST['font_deck_id'];
	update_option(SN.'_font_deck_project_id',$font_deck_project_id);

	$font_deck_name = $_POST['font_deck_name'];
	update_option(SN.'_font_deck_name',$font_deck_name);
	
elseif($type=="Enigma-styler") :
	global $enigma_runtime;

	$data = $_POST['data'];

	$template =  $_POST['template'];
	
	$gc = urldecode($_POST['global_color']);
    
	$concave_val =  urldecode($_POST['concave_val']);
	update_option(SN.'concave_value',$concave_val);



	$new_data = array();
	foreach($data as $style )
	{
		$style = json_decode(stripslashes($style));
   

		if($style->target!="undefined")
		$new_data[] = array( "target" => urldecode($style->target) , "value" => urldecode($style->value) , "name" => urldecode($style->name)  ); 
	} 
	$data = $new_data;
	update_option(SN.'_global_color',$gc);
	
	if($template=="default")
		update_option(SN.'_enigma_data',$data);
	else
		update_option($template,$data);


	update_option(SN.'_active_etemplate',$template);

	$enigma_runtime->createCSSFile();

	

	echo $template;
elseif($type=="Enigma-active") :

	$template = $_POST['template'];
	update_option(SN.'_active_etemplate',$template);
elseif($type=="Enigma-delete") :

	$table = get_option(SN.'enigma_hash');
	$key = $_POST['template'];	
	if(!$table  || !is_array($table)) $table = array();

	unset($table[$key]);
	
	update_option(SN.'enigma_hash',$table);
	update_option(SN.'_active_etemplate','default');

	echo $key;

elseif($type=="Enigma-styler-reset") :
	
	$template = $_POST['template'];
	if($template=="default")
		update_option(SN.'_enigma_data',array());
	else
		update_option($template,array());

	delete_option(SN.'_global_color');

elseif($type=='Enigma-import') :
	
	$data=  $_POST['value'];
	
	$data = base64_decode($data);	
	$input = json_decode($data,true);

	$name = str_replace("_"," ",$input[0]);
	$style = $input[1];
	$name = ucwords($name);

	$key = uniqid();

	$table = get_option(SN.'enigma_hash');

	if(!$table  || !is_array($table)) $table = array();

	$table['en'.$key] = $name;

	update_option(SN.'enigma_hash',$table);
	update_option('en'.$key,$style);

	echo "<option value='en".$key."'> $name </option>";
elseif($type=="visualizer_save"):
	$data = $_POST['data'];
	$bgs = $_POST['images'];
	update_option(SN.'visualizer_hash',$data);
	update_option(SN.'visualizer_images',$bgs);



elseif($type=="sticky_contact") :


$qname = $_POST["name"];
$qemail = $_POST["email"];
$qmsg = $_POST["msg"];
$notify_email = $_POST["notify_email"];

$form_data = "Name : $qname \n Email : $qemail \n Message : $qmsg ";



function isEmail($email) { 
	
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));		
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");


$comments = strip_tags($form_data);

if(get_magic_quotes_gpc()) {
	$comments = stripslashes($comments);
}

$address = $notify_email;
$e_subject = 'You\'ve have a message from '.$qname;

$e_body = $form_data . PHP_EOL . PHP_EOL;
$e_content = "\"$comments\"" . PHP_EOL . PHP_EOL;
		
$msg = wordwrap( $e_body , 70 );

$headers = "From: $qemail " . PHP_EOL;
$headers .= "Reply-To: $notify_email " . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;


if(mail($notify_email, $e_subject, $msg, $headers)) 
	echo "success";
else 
	echo 'ERROR!';

elseif($type=="options_save" && current_user_can('edit_pages') ) :

	$new_values =  $_POST['values'];

	foreach($new_values as $value)
	{
	 	update_option( $value["name"], $value["value"] );
	}

elseif($type=='runtime_css') :
	header('Content-Type: text/css');
	echo get_option(SN.'_compiled_css');

endif;

die();
}