<?php
/**
 *  Name - Header Construction panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Anthena
 */

if(!is_admin()) return;



// Output Settings
/*
function testVal()
{
	global $wp_registered_widgets;
	$widget_data = array();

    foreach($wp_registered_widgets as $k => $w)
    {
    	$key = ($w['callback'][0]->option_name); 
    	$widget_data[$key] = get_option($key);

    }	

    $output = json_encode($widget_data);
	$output = base64_encode($output);	
	echo "Widget Data <textarea> $output </textarea><br>"; 

	echo "Widget Strings <textarea>".base64_encode(json_encode(get_option('sidebars_widgets')))." </textarea><br>"; 
	 
}

add_action('admin_init','testVal');


global $wpdb;

$output = $wpdb->get_results("SELECT option_name,option_value FROM $wpdb->options WHERE option_name like '".SN."%'",ARRAY_A );
$output = json_encode($output);
$output = base64_encode($output);	
echo "Optiosn <textarea> $output </textarea><br>"; 
*/




class IOAInstaller extends IOA_PANEL_CORE {
	
	private $attach_ids = array();	

	
	// init menu
	function __construct () { parent::__construct( __('Installer','ioa'),'null','instl');  }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	 

		function setUpRestIOA()
					{

						/**
						 * Setup Header Data
						 */
						$header_data = "W1t7Im5hbWUiOiJUYWdsaW5lPGEgaHJlZj1cXFwiXFxcIiBjbGFzcz1cXFwiaGNvbi1lZGl0IGVudHlwbyBwZW5jaWxcXFwiPjxcL2E+IiwidmFsdWUiOiJ0YWdsaW5lIiwiYWxpZ24iOiJkZWZhdWx0IiwibWFyZ2luIjoiMDowOjA6MCJ9XSxbeyJjb250YWluZXIiOiJ0b3AtYXJlYSIsImV5ZSI6Im9uIiwicG9zaXRpb24iOiJzdGF0aWMiLCJoZWlnaHQiOiIwIiwiZGF0YSI6W3siYWxpZ24iOiJsZWZ0IiwiZWxlbWVudHMiOlt7InZhbCI6IndwbWwiLCJhbGlnbiI6ImRlZmF1bHQiLCJ0ZXh0IjoiIiwibWFyZ2luIjoiMDowOjA6MCIsIm5hbWUiOiJXUE1MIFNlbGVjdG9yIn0seyJ2YWwiOiJzb2NpYWwiLCJhbGlnbiI6ImRlZmF1bHQiLCJ0ZXh0IjoidHdpdHRlcjx2Yz5odHRwczpcL1wvdHdpdHRlci5jb21cL2FydGlsbGVnZW5jZTxzYz5mYWNlYm9vazx2Yz5odHRwczpcL1wvd3d3LmZhY2Vib29rLmNvbVwvYXJ0aWxsZWdlbmNlPHNjPmZsaWNrcjx2Yz5odHRwOlwvXC9mbGlja3IuY29tXC88c2M+dmltZW88dmM+aHR0cHM6XC9cL3ZpbWVvLmNvbVwvdXNlcjIwMDIyMDg5PHNjPnBpbnRlcmVzdDx2Yz5odHRwczpcL1wvcGludGVyZXN0LmNvbVwvPHNjPmRyaWJiYmxlPHZjPmh0dHA6XC9cL2RyaWJiYmxlLmNvbVwvYXJ0aWxsZWdlbmNlPHNjPnNreXBlPHZjPmNhbGw6YWJoaW4uc2hhcm1hPHNjPiIsIm1hcmdpbiI6IjA6MDowOjAiLCJuYW1lIjoiU29jaWFsIEljb25zIn0seyJ2YWwiOiJ0ZXh0IiwiYWxpZ24iOiJkZWZhdWx0IiwidGV4dCI6IkhlbHBsaW5lICsxIDM0MzMzMzMzMyIsIm1hcmdpbiI6IjEwOjA6MDoxNyIsIm5hbWUiOiJUZXh0ICJ9XX0seyJhbGlnbiI6ImNlbnRlciJ9LHsiYWxpZ24iOiJyaWdodCIsImVsZW1lbnRzIjpbeyJ2YWwiOiJ0b3AtbWVudSIsImFsaWduIjoiZGVmYXVsdCIsInRleHQiOiIwIiwibWFyZ2luIjoiMDowOjA6MCIsIm5hbWUiOiJNZW51IDIifV19XX0seyJjb250YWluZXIiOiJtZW51LWFyZWEiLCJleWUiOiJvbiIsInBvc2l0aW9uIjoic3RhdGljIiwiaGVpZ2h0IjoiMCIsImRhdGEiOlt7ImFsaWduIjoibGVmdCIsImVsZW1lbnRzIjpbeyJ2YWwiOiJsb2dvIiwiYWxpZ24iOiJkZWZhdWx0IiwidGV4dCI6IjAiLCJtYXJnaW4iOiIwOjA6MDowIiwibmFtZSI6IkxvZ28ifV19LHsiYWxpZ24iOiJjZW50ZXIifSx7ImFsaWduIjoicmlnaHQiLCJlbGVtZW50cyI6W3sidmFsIjoic2VhcmNoIiwiYWxpZ24iOiJkZWZhdWx0IiwidGV4dCI6IjAiLCJtYXJnaW4iOiI2OjA6MDowIiwibmFtZSI6IlNlYXJjaCBCYXIifSx7InZhbCI6Im1haW4tbWVudSIsImFsaWduIjoiZGVmYXVsdCIsInRleHQiOiIwIiwibWFyZ2luIjoiMDowOjA6MCIsIm5hbWUiOiJNZW51IDEifV19XX0seyJjb250YWluZXIiOiJ0b3AtZnVsbC1hcmVhIiwiZXllIjoib2ZmIiwicG9zaXRpb24iOiJzdGF0aWMiLCJoZWlnaHQiOiIiLCJkYXRhIjpbeyJhbGlnbiI6ImxlZnQifSx7ImFsaWduIjoiY2VudGVyIn0seyJhbGlnbiI6InJpZ2h0In1dfV1d";
						$header_data = base64_decode($header_data);	
						$header_data = json_decode($header_data,true);
						update_option(SN.'_header_construction_data',$header_data);

						update_option(SN.'font_selector','google');
						update_option(SN.'font_stacks',array( 'Raleway;;' ));	

			       	    $images = get_option('ioa_demo_images');
		
						setMenus();
						setMetaData();
						setWidgets();
						setShopData();

						
						$page = get_page_by_title( 'Home' );
						update_option( 'page_on_front', $page->ID );
			       	    update_option( 'show_on_front', 'page' );
						
			       	   
			       	    if(function_exists('rev_slider_shortcode'))
						{
							require_once(HPATH."/installer/rev_import_class.php");
							$c = new CustomREVInstaller();
							$c->importREVSliderFromPost(HPATH.'/installer/slider_export.txt');
							$c->importREVSliderFromPost(HPATH.'/installer/slider_export_1.txt');
							$c->importREVSliderFromPost(HPATH.'/installer/slider_export_2.txt');
						}
						


					}

					if(isset($_GET['page']) && $_GET['page'] == 'instl' ) 
					add_action('import_end','setUpRestIOA');

		if( isset($_GET['page']) && $_GET['page'] == "instl" && isset($_GET['instype']) )
		{
			global $lorem;
			
			$ids = $this->createImages();

			switch($_GET['instype'])
			{
				case 'express' : break;
				case 'demo' : 
					setDemoOptions();
					setDemoContent();
				break;
			}
			
			

		}
		

	 }	
	
	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){
		global $super_options;	
		
		


		?>

		 <div class="ioa_panel_wrap"> <!-- Panel Wrapper -->
		

        <div class=" clearfix">  <!-- Panel -->
        	<div id="option-panel-tabs" class="clearfix fullscreen ioa-tabs" data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
        
              
       			<div class="ioa_sidenav_wrap">
	                <ul id="" class="ioa_sidenav clearfix">  <!-- Side Menu -->
	                 
						 <li>
	             		   <a href="#installer_data" id=""> 
	             		  		 <span><?php _e('General','ioa') ?></span>
	             		   </a>
	             		 </li>
	             		  <!--
	             		  <li>
	             		   <a href="#installer_help" id=""> 
	             		  		 <span><?php _e('Help','ioa') ?></span>
	             		   </a>
	             		 </li>
	             		 -->
	             		
	                </ul>  <!-- End of Side Menu -->
	            </div>
                
                <div id="panel-wrapper" class="clearfix ">
					
					<div id="installer_data">
						<?php if(isset($_GET['instype']) && $_GET['instype']=="express" ) : ?>
						<div class="ioa-information-p">
							<p> <?php _e('Express Installation Successful.','ioa') ?> </p>
						</div>
					<?php endif; ?>	

					<?php if(isset($_GET['instype']) && $_GET['instype']=="demo" ) : ?>
						<div class="ioa-information-p">
							<p> <?php _e('Demo Installation Successful.','ioa') ?> </p>
						</div>
					<?php endif; ?>	

					<div class="installer-heading">
						<?php _e('Installer','ioa') ?>
					</div>

					<div class='installer-meta-info'>
					  <i class="ioa-front-icon info-circled-2icon-"></i>	Installer is meant for <strong>Fresh Wordpress Installations</strong> Only. Click Run and please wait until page is sucessfully loaded.
					</div>

					<div class="installer-selection clearfix">
						<?php 
							/*

							echo getIOAInput(array( 
									"label" => __("Select Installer Type",'ioa') , 
									"name" => "installer_type" , 
									"default" => "demo" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'small'  ,
									"value" => '',  
									"options" => array(  "demo" =>__("Same as Demo",'ioa')  , "express" =>  __("Compact Demo",'ioa')   )
												 
							) );
							*/
							 
						?>
						<a href="<?php echo admin_url() ?>admin.php?page=instl&amp;instype=demo" class="button-default run-installer"><?php _e('Run','ioa') ?></a>
					</div>	
					</div>
					<!----<div id="installer_help">
						<h4>Title</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eu vestibulum tortor, eu ultrices sem. Nulla volutpat libero sit amet nibh hendrerit lacinia. Cras pellentesque quam enim, semper luctus erat rhoncus et. Nunc vulputate vel est ac hendrerit. Praesent aliquet nibh sit amet tortor ultricies, id rutrum lectus feugiat. Cras a orci lobortis, ullamcorper libero id, aliquam lectus. Donec ornare, dolor vel scelerisque vestibulum, dui tellus sodales urna, ac scelerisque mi nisl et mauris. Suspendisse eu quam ultrices, sagittis sem at, gravida risus. Fusce sagittis diam porta feugiat tincidunt.</p>
						<p>Donec vestibulum erat vitae placerat placerat. Vestibulum dignissim commodo est, ut faucibus est aliquam in. Phasellus facilisis orci ante, ut tincidunt tortor ultrices nec. Mauris sit amet dolor eget metus rhoncus suscipit. Curabitur vestibulum arcu quam, et sodales urna varius ut. Mauris in auctor est.</p>
					</div>
				-->
   				</div>

   			</div>

   		</div>
	    <?php
	 }
	 function createImages()
	 {
	 	
	 	if( get_option('ioa_demo_images') ) return get_option('ioa_demo_images');

	 	$images = array( "d1.jpg" => "d1.jpg" , "d2.jpg" => "d2.jpg" , "d3.jpg" => "d3.jpg" );
	 	
	 	foreach ($images as $key => $image) {
	 		
	 		$path = wp_upload_dir(); 
	     	$cstatus =   copy( PATH."/sprites/i/demos/".$key,  $path['path'].'/'.$image  );
			$filename = $path['path'].'/'.$image;
		 
		 	$wp_filetype = wp_check_filetype(basename($filename), null );
		 	$attachment = array(
		  	  'guid' => $path['baseurl'] . _wp_relative_upload_path( $filename ), 
		   	  'post_mime_type' => $wp_filetype['type'],
		   	  'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
		   	  'post_content' => '',
		      'post_status' => 'inherit'
			);
			
			$attach_id = wp_insert_attachment( $attachment, $filename );
	    	require_once(ABSPATH . 'wp-admin/includes/image.php');
	    	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	    	wp_update_attachment_metadata( $attach_id, $attach_data );

	    	$this->attach_ids[] =  $attach_id; 	

	 	}

	 	update_option('ioa_demo_images',$this->attach_ids);

	 }
	
	 

}

$i = new IOAInstaller();

function setWidgets()
{

 
$fh = fopen( HPATH.'/installer/widget_strings.txt', 'r');
$widgets = fread($fh, filesize(HPATH.'/installer/widget_strings.txt'));
fclose($fh); 

$widgets = base64_decode($widgets);	
$widgets = json_decode($widgets,true);

update_option('sidebars_widgets',$widgets);

$fh = fopen( HPATH.'/installer/widget_data.txt', 'r');
$widgets_data = fread($fh, filesize(HPATH.'/installer/widget_data.txt'));
fclose($fh); 

$inputs = base64_decode($widgets_data);	
$inputs = json_decode($inputs,true);

 foreach ($inputs as $key => $input) {
 	update_option($key,$input);
 }

}

function setDemoContent()
{
	if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
	require_once ABSPATH . 'wp-admin/includes/import.php';
    $importer_error = false;
	
	if ( !class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if ( file_exists( $class_wp_importer ) )
		{
			require_once($class_wp_importer);
		}
		else
		{
			$importer_error = true;
		}
    }
	
	if ( !class_exists( 'WP_Import' ) ) {
	  $class_wp_import = HPATH . '/installer/importer/wordpress-importer.php';
	  if ( file_exists( $class_wp_import ) )
	  require_once($class_wp_import);
	  else
	  $importerError = true;
	  
    }

	  if($importer_error)
	  {
		  die("Error in import :(");
	  }
	  else
	  {
		  if ( class_exists( 'WP_Import' )) 
		  {
			  include_once(HPATH.'/installer/importer/odin-import-class.php');
		  }
		  
		  
		  if(!is_file(HPATH."/installer/dummy.xml"))
		  {
			  echo "The XML file containing the dummy content is not available or could not be read in <pre>".HPATH."</pre><br/> You might want to try to set the file permission to chmod 777.<br/>If this doesn't work please use the wordpress importer and import the XML file from hades_framework -> mods -> odin folder , dummy.xml manually <a href='/wp-admin/import.php'>here.</a>";
		  }
		  else
		  {
	  
			  $wp_import = new odin_wp_import();
			  $wp_import->fetch_attachments = false;
			  $wp_import->import(HPATH."/installer/dummy.xml");
			  $wp_import->saveOptions();
			
		  }
	  }
   
   
    
}

function setMenus()
{
	$gmes = "Menus ";
	global $wpdb;
    $table_db_name = $wpdb->prefix . "terms";
    $rows = $wpdb->get_results("SELECT * FROM $table_db_name where  name='Main Menu' OR name='Footer Menu' OR name='Top Menu'",ARRAY_A);
    $menu_ids = array();
	foreach($rows as $row)
	$menu_ids[$row["name"]] = $row["term_id"] ; 

	set_theme_mod( 'nav_menu_locations', array_map( 'absint', array(  'top_menu2_nav' => $menu_ids["Top Menu"] , 'top_menu1_nav' =>$menu_ids['Main Menu'] ,'footer_nav' => $menu_ids['Footer Menu'] ) ) );
	
}



function setDemoOptions() {

 
$fh = fopen( HPATH.'/installer/options.txt', 'r');
$theme_options = fread($fh, filesize(HPATH.'/installer/options.txt'));
fclose($fh); 

$theme_options = base64_decode($theme_options);	
$input = json_decode($theme_options,true);

	
foreach($input as $key => $val)
{
	if($val['option_name']!= SN."enigma_hash")
	 {		
		if( is_serialized($val["option_value"]) )
			update_option($val["option_name"],unserialize($val["option_value"]));
		else
			update_option($val["option_name"],$val["option_value"]);
	}	
}

$force_option = array(

SN.'_admin_logo' => "",
SN."_enable_admin_logo" => "No",
SN."_logo" => URL."/sprites/i/logo.png",
SN."_clogo" => URL."/sprites/i/clogo.png",
SN."_notfound_logo" =>  URL."/sprites/i/notfound.png",
SN."_notfound_title" => "Oeps, you've done something wrong here",
SN."_notfound_text" => "Page not found, try searching below",
SN.'_twitter_key' => '',
SN.'_twitter_secret_key' => '',
SN.'_twitter_token' => '',
SN.'_twitter_secret_token' => '',
SN.'_page_speed_key' => '',
SN.'_en_key' => '',
SN.'_en_username' => '' ,
SN.'_submenu_effect' => '',
SN.'_pre_schemes' => array()
);

foreach($force_option as $key => $val)
update_option($key,$val);
	
}


function setMetaData()
{
	 	
	$attach_ids = get_option('ioa_demo_images');

	$fn_i = array();
	foreach ($attach_ids as $key => $id) {
		$fn_i[]  = wp_get_attachment_image_src($id,'full'); 
	}
	 
	  $wp_query = new WP_Query("post_type=portfolio&posts_per_page=-1");
	 while ( $wp_query->have_posts() ) : $wp_query->the_post();
	 
	 $len = rand(0,6);
	 $str = '';
	 for($i=0;$i<=$len;$i++)
	 {
	 	$r = rand(0,2);
	 	$str .=   $fn_i[$r][0]."[ioabre]".$fn_i[$r][0]."[ioabre][ioabre][ioabre];";
	 }

	 $id =  get_the_ID();
	 $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
	 $ioa_options['ioa_portfolio_data'] = $str;
	 update_post_meta( get_the_ID(), 'ioa_options', $ioa_options);
	   set_post_thumbnail($id,   $attach_ids[$rand = rand(0,2)] );
	endwhile; 

	$query = new WP_Query("post_type=slider&posts_per_page=-1");  

	while ($query->have_posts()) : $query->the_post();  
		$slides =get_post_meta(get_the_ID(),'slides',true);
		if($slides =="") $slides = array();
		$new_slides = array();
		foreach ($slides as $slide) {
			$temp = array();
			foreach($slide as $k => $pair)
			{
				if($pair['name']=='image' || $pair['name']=='background_image')  $pair['value'] = $fn_i[rand(0,2)][0];
				$temp[] = $pair;
			}
			$new_slides[] = $temp;

		}
		update_post_meta(get_the_ID(),'slides',$new_slides);
	endwhile;


	 $wp_query = new WP_Query("post_type=product&posts_per_page=-1");
	 
	 while ( $wp_query->have_posts() ) : $wp_query->the_post();
	 
	 $id =  get_the_ID();
	 $rand = rand(0,2);
	 set_post_thumbnail($id,   $attach_ids[$rand] );
	 $r = wp_get_attachment_image_src($attach_ids[$rand], 'full');
	 update_post_meta($id ,'sec_thumb', $r[0]  );
	

	 endwhile;  
	
	 $wp_query = new WP_Query("post_type=post&posts_per_page=-1");
	 
	 while ( $wp_query->have_posts() ) : $wp_query->the_post();
	 
	 $id =  get_the_ID();
	  set_post_thumbnail($id,   $attach_ids[rand(0,2)] );
	
	endwhile; 

	$wp_query = new WP_Query("post_type=testimonial&posts_per_page=-1");
	 
	 while ( $wp_query->have_posts() ) : $wp_query->the_post();
	 
	 $id =  get_the_ID();
	  set_post_thumbnail($id,   $attach_ids[rand(0,2)] );
	  
	endwhile;  


	$wp_query = new WP_Query("post_type=page&posts_per_page=-1");
	 
	 while ( $wp_query->have_posts() ) : $wp_query->the_post();
	
	  
	$data =get_post_meta(get_the_ID(),"ioa_options",true);
	  
 	  if(isset($data['ioa_gallery_data']) && $data['ioa_gallery_data'] !="")
      {
      	$len = rand(0,6);
		 $str = '';
		 for($i=0;$i<=$len;$i++)
		 {
		 	$r = rand(0,2);
		 	$str .=   $fn_i[$r][0]."<gl>".$fn_i[$r][0]."<gl><gl><gl>;";
		 }
		 $data['ioa_gallery_data'] = $str;
      }

 	  update_post_meta(get_the_ID(),"ioa_options",$data);	


 	 endwhile;  
 	

}


function setShopData()
{

	$shop = get_page_by_title( 'Shop' );
	$cart = get_page_by_title( 'Cart' );
	$logout = get_page_by_title('Logout');
	$checkout = get_page_by_title('Checkout');

	
	update_option('woocommerce_shop_page_id',$shop->ID);
	update_option('woocommerce_cart_page_id',$cart->ID);
	update_option('woocommerce_logout_page_id',$logout->ID);
	update_option('woocommerce_checkout_page_id',$checkout->ID);
	

	$def = array ( "size" => array ( "name" => "Size", "value" => "M | L", "position" => 0 ,"is_visible" => 1 ,"is_variation" => 1 ,"is_taxonomy" => 0 ) ); 
	$wp_query = new WP_Query("post_type=product&posts_per_page=-1");
	 
	 while ( $wp_query->have_posts() ) : $wp_query->the_post();
	 	
 	$attributes = maybe_unserialize( get_post_meta( get_the_ID(), '_product_attributes', true ) );
	$demo_ids = implode(',',get_option('ioa_demo_images')); 

	 $variation_attribute_found = false;
	if ( $attributes ) foreach( $attributes as $attribute ) {
		if ( isset( $attribute['is_variation'] ) ) {
			$variation_attribute_found = true;
			break;
		}
	}

	if($variation_attribute_found ) update_post_meta( get_the_ID(), '_product_attributes', $def );
	
	 update_post_meta(get_the_ID(),'_product_image_gallery', $demo_ids); 

	 endwhile; 

}

/*
require_once(HPATH."/installer/rev_import_class.php");

$c = new CustomREVInstaller();
//$c->importSlider(HPATH.'/installer/test.zip');
*/