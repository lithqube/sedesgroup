<?php
/**
 * @description : Helper class for Framework
 * @version : Version 6
 */


if(!defined('HPATH'))
die(' The File cannot be accessed directly ');



if(!class_exists('Helper')) {

/**
 * Class Begins here
 */


class Helper
{


	/**
	 * Initiates all frameworks core actions and  settings.
	 */
	function __construct() {

		global $wpdb,$super_options,$ioa_options;


		/**
		 * Cache all Theme options & if a option is not set map from default options.
		 */

		$special_options = array(
				
				);
		$resultSet =  $wpdb->get_results("SELECT option_name,option_value FROM $wpdb->options where option_name like '%".SN."%' ",ARRAY_A);
		
		$i =0;
		$data = array();
		
		foreach($resultSet as $rs)
			$data[$rs['option_name']] = apply_filters("option_".$rs['option_name'] , $rs['option_value'] );
		

		foreach($ioa_options as $k => $value)
		{
			
		  if( isset($value["id"])  ) 	
		  {
			  
			  $id = $value["id"];
			  $std = false;
			  
			
			  if( isset( $value["std"]) ) $std = $value["std"]; 
			  $super_options[$id] = $std ;
		  }
			
			
		}

		foreach($special_options as $k => $value)
		{
			
		  if( isset($value["id"])  ) 	
		  {
			  
			  $id = $value["id"];
			  $std = false;
			  
			
			  if( isset( $value["std"]) ) $std = $value["std"]; 
			  $super_options[$id] = $std ;
		  }
			
			
		}

		add_action( 'admin_bar_menu', 'wp_admin_ioa_links', 1000 );

			$link_s 	=  array(
			array(	"label" => 'Featured Image Link' , "name" => 'featured_link' , 	"default" => "" , "type" => "text",	"description" => "" )
			);
		new IOAMetaBox(array(
		"id" => "featured_image_link",
		"title" => "Featured Image Link",
		"inputs" => $link_s,
		"post_type" => 'post',
		"context" => "advanced",
		"priority" => "low"
		));	
		

		function wp_admin_ioa_links()
		{
			global $wp_admin_bar,$wpdb;
			
			
	

			$wp_admin_bar->add_menu(array(
								'href' =>  admin_url()."admin.php?page=ioa",
								'parent' => false, // false for a root menu, pass the ID value for a submenu of that menu.
								'id' => "#theme_admin", // defaults to a sanitized title value.
								'title' => 'Theme Admin',
								'meta' => array('title' => 'Theme Admin') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '', 'title' => '' );
							));	

				$wp_admin_bar->add_menu(array(
								'href' =>  admin_url()."admin.php?page=hcons",
								'parent' => "#theme_admin", // false for a root menu, pass the ID value for a submenu of that menu.
								'id' => "#hcons", // defaults to a sanitized title value.
								'title' => 'Header Constructor',
								'meta' => array('title' => 'Header Constructor') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '', 'title' => '' );
							));	

				$wp_admin_bar->add_menu(array(
								'href' =>  admin_url()."admin.php?page=ioamed",
								'parent' => "#theme_admin", // false for a root menu, pass the ID value for a submenu of that menu.
								'id' => "#ioamed", // defaults to a sanitized title value.
								'title' => 'Media Manager',
								'meta' => array('title' => 'Media Manager') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '', 'title' => '' );
							));

				$wp_admin_bar->add_menu(array(
								'href' =>  admin_url()."admin.php?page=ioapty",
								'parent' => "#theme_admin", // false for a root menu, pass the ID value for a submenu of that menu.
								'id' => "#ioapty", // defaults to a sanitized title value.
								'title' => 'Content Manager',
								'meta' => array('title' => 'Content Manager') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '', 'title' => '' );
							));				
				
				$wp_admin_bar->add_menu(array(
								'href' =>  home_url('/').'?&enigma=styler',
								'parent' => false, // false for a root menu, pass the ID value for a submenu of that menu.
								'id' => "#enigma", // defaults to a sanitized title value.
								'title' => 'Enigma Styler',
								'meta' => array('title' => 'Enigma Styler') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '', 'title' => '' );
							));

				
			if(is_admin())
			{
				$wp_admin_bar->add_menu(array(
							'href' =>  "#",
							'parent' => false, // false for a root menu, pass the ID value for a submenu of that menu.
							'id' => "trigger-post-update", // defaults to a sanitized title value.
							'title' => 'Update Post',
							'meta' => array('title' => 'Update Post') 
						));	
			}
		}
		

			function my_custom_login_logo() {
  
				  
				    echo '<style type="text/css">
				        #login h1 a { background:url('.get_option(SN."_admin_logo").') center center no-repeat !important;
						 
						  margin-top:0px;
						   }
				    </style>';

				}

				if(get_option(SN."_enable_admin_logo")=="Yes")
				add_action('login_head', 'my_custom_login_logo');

		
		$super_options = array_merge($super_options,$data);


		global $ioa_portfolio_name,$ioa_portfolio_slug,$portfolio_taxonomy_label,$portfolio_taxonomy;

		$ioa_portfolio_name = $super_options[SN.'_portfolio_label'];
		$ioa_portfolio_slug =$super_options[SN.'_portfolio_slug'];
		$portfolio_taxonomy_label = $super_options[SN.'_portfolio_taxonomy'];
		$portfolio_taxonomy =  str_replace(" ","",strtolower(trim($portfolio_taxonomy_label))) ;

		global $ioa_sidebars;
		if(isset($super_options[SN.'_custom_sidebars'])) :
			$sidebar_opts = $super_options[SN.'_custom_sidebars']; 
			$sidebar_opts = explode(',',$sidebar_opts);
			foreach($sidebar_opts as $s)
			{
				if($s!="")
				{
					$ioa_sidebars[] = $s;
				}
			} 
		endif;	

		if(is_admin())
		{
			$portfolio_fields = $super_options[SN.'_single_portfolio_meta'];

			if($portfolio_fields!="")
			{
				$portfolio_fields = explode(';',$portfolio_fields);
				$inps = array();
				foreach($portfolio_fields as $field)
				{
					if(trim($field)!="")
					$inps[trim($field)] 	=  array(	"label" => $field , "name" => str_replace(' ','_',strtolower(trim($field))) , 	"default" => "" , "type" => "textarea",	"description" => "" );
				}

				
				new IOAMetaBox(array(
				"id" => "IOA_portfolio_fields",
				"title" => "Portfolio Extra Fields",
				"inputs" => $inps,
				"post_type" => $ioa_portfolio_slug,
				"context" => "advanced",
				"priority" => "low"
				));	
			}
		}
		
		add_action('after_setup_theme',array(&$this,'customPosts'));
		 
		
		function add_lightbox_code( $mode= '' )
		{
						?>

			<div class="ioa-message">
		        
		          <div class="ioa-message-body clearfix">
		               <div class="ioa-icon-area">
		               		<i class="ioa-front-icon checkicon-"></i>
		               </div>
		               <div class="ioa-info-area">
		               		<h3 class='msg-title'>Settings Saved !</h3>
		               		<p class='msg-text'>Options Panel Settings were saved at 11 PM</p>
		               </div>
		              
		          </div>
		    </div>

			<div class="rad-lightbox">
			<div class="rad-l-head">
				<h4><?php _e('Text Widget[Edit mode]','ioa') ?></h4>
			</div>
			<div class="rad-l-body clearfix">
				<div class="component-opts">
					
				</div>
				
			</div>
			
			<div class="rad-l-footer clearfix">
				<a href="" class="button-hprimary" id="save-l-data" ><?php _e('Save Changes','ioa') ?></a><a href="" class="button-hprimary" id="close-l" ><?php _e('Close','ioa') ?></a>
			</div>
		</div>

		<div class="shortcode-lightbox">
			<div class="shortcode-l-head"><h4><?php   _e('Shortcodes','ioa') ?></h4><a href="" class="">x</a><span class="loader"></span></div>
			<div class="shortcode-l-body">
					
	
			</div>  	
		</div>
		<div class="temp-overlay"></div>
		<?php
		}	

		 if(is_admin())
		 	add_action('admin_footer','add_lightbox_code',10,1);
		 add_action('rad_footer','add_lightbox_code',10,1);



		if( ! ( isset($_GET['page']) && $_GET['page'] == "ioautoup" ) && get_option(SN.'_en_key') )
		add_action('admin_notices', 'checkioaUpdates');

		function checkioaUpdates()
		{
			global $super_options,$ioa_upgrader;
		    // include the library
		    
			$checker  =  $ioa_upgrader->check_for_theme_update();
		    
			if( isset($checker->updated_themes_count) && $checker->updated_themes_count > 0 )
			    {
			    	?>
						<div class="updated">
							<p style="text-align:center"><strong>Theme Update</strong> is available. Click <strong><a href="<?php echo admin_url()."admin.php?page=ioautoup"; ?>">here</a></strong> to update.</p>
						</div>

						
			    	<?php
			    } 
		   
		}

		

		/**
		 * Version Check for WP 
		 */
		
		function addversionw()
		{
			global $wp_version;
			echo "<link rel='tag' id='wp_version' href='".$wp_version."' />";
			echo "<link rel='tag' id='backend_link' href='". admin_url( 'admin-ajax.php' )."' />";
			echo "<link rel='tag' id='shortcode_link' href='".HURL."' />";
		}

		add_action('admin_head','addversionw');		

		/**
		 * Custom Exerpt Length
		 */
		
		function custom_excerpt_length( $length ) {
			return 10;
		}
		add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

		/**
		 *  Core WP Declarations 
		 */
		
		function custom_excerpt_more( $more ) {
			return '...';
		}
		add_filter( 'excerpt_more', 'custom_excerpt_more' );

		add_editor_style( 'backend/css/editor-style.css' );
		add_filter('widget_text', 'do_shortcode');
		add_filter( 'use_default_gallery_style', '__return_false' );
        add_theme_support( 'post-thumbnails' );

        add_filter( 'woocommerce_product_add_to_cart_text', 'ioa_woo_text' );    // 2.1 +
 
		function ioa_woo_text($text) {
		 		global $product;

		 		if( $product->product_type == 'simple')
		        	return __( '+<i class="ioa-front-icon basketicon-"></i>', 'ioa' );
		        else
		        	return $text;
		 
		}
		
		 add_theme_support( 'woocommerce' );
		add_theme_support( 'automatic-feed-links' );

		add_filter( 'woocommerce_enqueue_styles', '__return_false' );
		add_filter( 'woocommerce_breadcrumb_defaults', 'ioa_change_breadcrumb_home_text' );

		remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products',20);
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		
		

		function ioa_change_breadcrumb_home_text( $defaults ) {
		    global $super_options;

			return array(
            'delimiter'   => $super_options[SN."_breadcrumb_delimiter"],
            'wrap_before' => '',
            'wrap_after'  => '',
            'before'      => ' <span class="current">',
            'after'       => '</span> ',
            'home'        => $super_options[SN."_breadcrumb_home_label"],
        	);

			return $defaults;
		}

		add_action( 'init', 'ioa_remove_wc_breadcrumbs' );
		function ioa_remove_wc_breadcrumbs() {
		    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		}

		if ( ! isset( $content_width ) )
		$content_width = 1030;

		add_theme_support( 'post-formats', array(
		 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
		) );


		add_action('layerslider_ready', 'my_layerslider_overrides');
 
	    function my_layerslider_overrides() {
	        $GLOBALS['lsAutoUpdateBox'] = false;
	    }



		/**
		 * Theme Actions Declaration
		 */
		
		register_IOA_template(
			array(
					"default" => __('Default','ioa'),
					
					"Blog Classic" => __('Blog Classic','ioa'),
					"Blog Grid" => __('Blog Grid','ioa'),
					"Blog Thumb List" => __('Blog Thumb List','ioa'),
					"Blog Featured Post" => __('Blog Featured Post','ioa'),
					"Blog Full Width Side Posts" => __('Blog Full Width Side Posts','ioa'),
					"Blog Full Width Posts" => __('Blog Full Width Posts','ioa'),
					"Blog Timeline" => __('Blog Timeline','ioa'),
					"Blog Full Posts" => __('Blog Full Posts','ioa'),
					
					"Portfolio One Column" => $ioa_portfolio_name.__(' One Column','ioa'),
					"Portfolio Two Column" => $ioa_portfolio_name.__(' Two Column','ioa'),
					"Portfolio Three Column" => $ioa_portfolio_name.__(' Three Column','ioa'),
					"Portfolio Four Column" => $ioa_portfolio_name.__(' Four Column','ioa'),
					"Portfolio Five Column" => $ioa_portfolio_name.__(' Five Column','ioa'),
					"Portfolio Featured" => $ioa_portfolio_name.__(' Featured','ioa'),
					"Portfolio Full Screen Gallery" => $ioa_portfolio_name.__(' Full Screen Gallery','ioa'),
					"Portfolio Product Gallery" => $ioa_portfolio_name.__(' Product Gallery','ioa'),
					"Portfolio Modelie" => $ioa_portfolio_name.__(' Modelie','ioa'),
					"Portfolio Masonry" => $ioa_portfolio_name.__(' Masonry','ioa'),
					"Portfolio Metro" => $ioa_portfolio_name.__(' Metro','ioa'),
					"Portfolio Maerya" => $ioa_portfolio_name.__(' Maerya','ioa'),

					"Contact Variation 1" => __('Contact Variation 1','ioa'),
					"Contact Variation 2" => __('Contact Variation 2','ioa'),
					"Blank Page" => __('Blank Page','ioa'),
					"Sitemap" => __('Sitemap','ioa'),
					"Custom Post Template" => __('Custom Post Template','ioa'),


			));

		new IOAMetaBox(array(
			"id" => "IOA_testimonial_box",
			"title" => __("Enter Client Designation",'ioa'),
			"inputs" => array(
										
							 array(	"label" => __("Enter Designation",'ioa') , "name" => "design" , "length" => "small",	"default" => "" , "type" => "text",	"description" => "" ), 
							
							 ),
			"post_type" => "testimonial",
			"context" => "side",
			"priority" => "low"
			));

		add_action('wp_head',array(&$this,'RADStyler'));
		
		function IOA_addFooterScripts() {
			global $super_options;
			?>
			<script type="text/javascript">
			  <?php echo stripslashes(strip_tags($super_options[SN.'_tracking_code'])); ?>
			</script>
			<?php
		}	
		add_action('wp_footer','IOA_addFooterScripts');

		function setThemeSEO()
		{
			global $post, $super_options;
			 $ioa_options = array();


			if(isset($post)) :

			 $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
		 
		   $seo_title = '';
		  if(isset($ioa_options['seo_title'])) $seo_title =  $ioa_options['seo_title'];
		  endif;


			$title = $super_options[SN.'_title'];
			if(is_single() || is_page())
			{
				if($seo_title!="")
					$title = $seo_title.' '.$title;
				else	
					$title = get_the_title().' '. $title;
			}

			if(IOA_WOO_EXISTS && is_shop())
			{
				$title = get_the_title(get_option('woocommerce_shop_page_id'));
			}	

			if(IOA_WOO_EXISTS && is_product_category())
			{
				$title = 'Category';
			}
			if(IOA_WOO_EXISTS && is_product_tag())
			{
				$title = 'Tag';
			}

			echo stripslashes( $title);

		}	

		 if($super_options[SN.'_seo']!="false")
		 {
		 	add_action("IOA_title","setThemeSEO");

		 	function setMetaTags()
		 	{
		 		global $super_options,$post;

		 		$keywords = $super_options[SN.'_meta_keywords'];
		 		$desc = $super_options[SN.'_meta_description'];

		 		$ioa_options = "";
		 		if( is_single() || is_page() ) $ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
		  		if($ioa_options =="")  $ioa_options = array();
		 
			    $meta_keywords = $meta_description = '';	
		
		  		if(isset($ioa_options['meta_keywords'])) $meta_keywords =  $ioa_options['meta_keywords'];
		 		if(isset($ioa_options['meta_description'])) $meta_description =  $ioa_options['meta_description'];

		 		if(is_page() || is_single())
		 		{
		 			if($meta_keywords!="") $keywords = $meta_keywords;
		 			if($meta_description!="") $desc = $meta_description;
		 		}

		 		?>
		 		<meta name="description" content="<?php  echo  $desc;  ?>">
    			<meta name="keywords" content="<?php  echo $keywords;  ?>">
				<?php

		 	}
		 	add_action("wp_head","setMetaTags");
		 }
		function add_js_variables()
		{
			echo "
			<script>
			var ioa_listener_url = '".admin_url( 'admin-ajax.php' )."',
				theme_url  = '".URL."',
				backend_url  = '".HURL."';

			</script>
			";
		}
		add_action('IOA_head','add_js_variables');
		add_action('admin_footer','add_js_variables');


		// Comment Support ====================================
		
		if ( ! function_exists( 'ioa_comment' ) ) :

			function ioa_comment( $comment, $args, $depth ) {
				$GLOBALS['comment'] = $comment;
				switch ( $comment->comment_type ) :
					case '' :
				?>
				
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
						<div id="comment-<?php comment_ID(); ?>">
						
							<div class="comment-info  clearfix">
							   
							   <div class="image-info clearfix">
								<?php echo get_avatar( $comment, 40 ); 
								 printf( '<cite class="fn">%1$s </cite>',
						get_comment_author_link()
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'ioa' ), get_comment_date(), get_comment_time() )
					);?>
			
								 <?php if ( $comment->comment_approved == '0' ) : ?>
										<em><?php _e( 'Your comment is awaiting moderation.'  , 'ioa'); ?></em>
								  <?php endif; ?>
							   </div>
								
							   
							   <div class="comment-body clearfix"><span class="arrow"></span><?php comment_text(); ?></div>
								<div class="reply clearfix">
									<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
							   </div><!-- .reply -->
							 </div><!-- .comment-author .vcard -->
					
				</div><!-- #comment-##  -->
			
				<?php
						break;
					case 'pingback'  :
					case 'trackback' :
				?>
				<li class="post pingback">
					<p><?php _e( 'Pingback:' , 'ioa' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)' , 'ioa'), ' ' ); ?></p>
				<?php
						break;
				endswitch;
			}
			endif;


		/**
		 * Register Sidebars
		 */
		
		$this->initSidebars();
		
		
		if(is_admin())
		{
			add_action( 'edit_form_after_title', 'the_sub_form_register' );

		}

		/**
		 * Google Font adding
		 */
		
		function generateFonts()
		{
			global $post , $fonts,$super_options,$websafe_fonts;

			if(isset($post)) :

			$ioa_options = get_post_meta(  get_the_ID(), 'ioa_options', true );
			  if($ioa_options =="")
			{
			  $old_values  = get_post_custom($post->ID);
			  $ioa_options = array();
			  
			  if(isset($old_values) && is_array($old_values))
			  foreach ($old_values as $key => $value) {
			    if($key!='rad_data' && $key!='rad_styler')
			    {
			      $ioa_options[$key] = $value[0];
			    }
			  }
			}  

			$font =  $subfont = '';

			if(isset($ioa_options['title_font'])) $font = $ioa_options['title_font'];
			if(isset($ioa_options['subtitle_font'])) $subfont = $ioa_options['subtitle_font'];
			
			

			if($font!="" && (is_single() || is_page()) )
			{
				register_font_class('div.title-wrap h1','',$font,'dynamic font',true,true);
				register_font_class('h3.page-subtitle','',$subfont,'dynamic font',true,true);
			}


			$f = $fonts->getFonts();
			

			$fs = array();
			$i=0; 
			if(isset($f) && is_array($f)) 
			foreach($f as $font)
			{
				$val = $font['default_font'];
				$w = '';

				if( isset($super_options[SN.$font['default_class']] ) ) $val = $super_options[SN.$font['default_class']] ;
				$req = str_replace(" ","+",$val);

				
				if(isset($font['fontWeight']) && isset($super_options[SN.$font['default_class'].'_w']) ) 
					{
						$w = $super_options[SN.$font['default_class'].'_w'];
						if($super_options[SN.$font['default_class'].'_w']!="")
						$req .= ":".$w;
					}
				if(isset($font['subset']) && isset($super_options[SN.$font['default_class'].'_s']) ) 
					{
						$s = $super_options[SN.$font['default_class'].'_s'];
						if($super_options[SN.$font['default_class'].'_s']!="")
						$req .= "&amp;subset=".$s;
					}				
				
				$fs[] =  array("name" => $val , "link" => "http://fonts.googleapis.com/css?family={$req}");
	 	 	 		
			}
			
			$recall = array();
			foreach ($fs as $key => $f) {
				if( ! in_array($f["name"],$websafe_fonts) && $f["name"]!="None" && !in_array($f["name"],$recall) )

				if(trim($f["name"])!="")	
				wp_enqueue_style('custom-fontd-'.$i,$f["link"]);	 
				$recall[] = $f["name"];

	 	 		$i++;
			}

			endif;

			$fts = "google";
			if( get_option(SN.'font_selector') ) $fts = get_option(SN.'font_selector');

			

			switch ($fts) {
				case 'fontface' : 

				break;
				case 'google':
					$i=0;

					$font_stack = get_option(SN.'font_stacks'); 

					if($font_stack!="" && is_array($font_stack))
					{
						$i=0;
						foreach ($font_stack as $key => $font) {
							$font_br = explode(';',$font);
							$font_name = str_replace(" ","+",trim($font_br[0]));
							$font_weight = str_replace(" ","", strtolower($font_br[1]) );
							$font_subset = str_replace(" ","-",trim(strtolower($font_br[2]) ));
							$font_subset = str_replace("extended","ext",$font_subset );
							//echo "http://fonts.googleapis.com/css?family=$font_name:$font_weight&amp;subset=$font_subset <br>";
							wp_enqueue_style('custom-font-e-'.$i, "http://fonts.googleapis.com/css?family=$font_name:$font_weight&subset=$font_subset");	
							$i++;	
						}
					}
				
				break;
			}

			

		}
		if(!is_admin())
		add_action('wp_enqueue_scripts','generateFonts');

		function setupFontDeckScript()
		{
			global $super_options;
			?>
			<script type="text/javascript">
			WebFontConfig = { fontdeck: { id: '<?php echo $super_options[SN."_font_deck_project_id"] ?>' } };

			(function() {
			  var wf = document.createElement('script');
			  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			  wf.type = 'text/javascript';
			  wf.async = 'true';
			  var s = document.getElementsByTagName('script')[0];
			  s.parentNode.insertBefore(wf, s);
			})();
			</script>
			<?php
		}
		if(get_option(SN.'font_selector') && get_option(SN.'font_selector') =="fontdeck") add_action('wp_head','setupFontDeckScript');
		

		function declareStyleFonts()
		{
			global $fonts,$super_options;
			$f = $fonts->getFonts();

			$i=0; $query = '';
			$fontface_query = '';
			$fontdeck_query = '';

			$fts = "google";
			if( get_option(SN.'font_selector') ) $fts = get_option(SN.'font_selector');

			if(isset($f) && is_array($f)) 
					foreach($f as $font)
					{
						$val = $font['default_font'];

						if( isset($super_options[SN.$font['default_class']] ) ) $val = $super_options[SN.$font['default_class']] ;
						if( $val!="None" )
						$query .= $font['default_class']."{  font-family: '".$val."' , Helvetica, Arial; } \n ";
						
					}

			switch ($fts) {
				case 'google':
				default:
					
				break;
				case 'fontface' : 
					$folder_name = $super_options[SN.'_font_face_font'];
					$font_stack = array();
					$ffpath = PATH."/sprites/fontface/".$folder_name;
					if(is_dir($ffpath)) :

					$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($ffpath), RecursiveIteratorIterator::SELF_FIRST);

					foreach($objects as $name => $object){
						 	$details = pathinfo($ffpath.'/'. $object->getFilename());
						 	$font_stack[$details['extension']] = $details['basename'];
						 }

					$fontface_query = "

							@font-face {
										    font-family: '{$folder_name}';
										    src: url('".URL."/sprites/fontface/{$folder_name}/".$font_stack['eot']."');
										    src: url('".URL."/sprites/fontface/{$folder_name}/".$font_stack['eot']."?#iefix') format('embedded-opentype'),
										         url('".URL."/sprites/fontface/{$folder_name}/".$font_stack['woff']."') format('woff'),
										         url('".URL."/sprites/fontface/{$folder_name}/".$font_stack['ttf']."') format('truetype'),
										         url('".URL."/sprites/fontface/{$folder_name}/".$font_stack['svg']."#verbregular') format('svg');
										    font-weight: normal;
										    font-style: normal;

										}


							";
					$query .= $fontface_query;
					endif;		
				break;
				case 'fontdeck' : 


				break;
			}
			


			$cvals = '';
			if(get_option(SN.'concave_value')) $cvals = stripslashes(get_option(SN.'concave_value'));	

			echo "<style type='text/css'>
						$query
						".$super_options[SN.'_custom_css']."
					@media  only screen and (max-width: 767px) {  .skeleton {   width:".$super_options[SN.'_res_width']."%;   } }
					

				  </style><style id='concave-area-styles'>  /* Concave Stylings */  $cvals </style>";
			
			echo "<script type='text/javascript'> ".$super_options[SN.'_headjs_code']." </script>";

		}

		add_action('wp_head','declareStyleFonts');
		

		function the_sub_form_register(){
	
		global $post;
		
		if($post->post_type!='page') return;	

		$post_id = $post->ID;
		
		//get the subtitle value (if set)
		$sub = get_post_meta($post_id, '_post_subtitle', true);
		if($sub == null){
			$sub = '';
		}
		// echo the inputfield with the value.
		echo '
			<div id="subtitlewrap">
				<label id="subtitle-prompt-text" class="screen-reader-text" for="subtitle">'.__('Enter Subtitle here','ioa').'</label>
				<input id="subtitle" type="text" autocomplete="off" value="'.$sub.'" placeholder="'.__('Enter Subtitle Here','ioa').'" size="30" name="post_subtitle">
			</div>';
		}
		

		if(is_admin())
		{
			add_action( 'add_meta_boxes', 'ioa_add_panel' );
			
		}

		function ioa_add_panel() {
			global $registered_posts;
		    $screens = array( 'post', 'page' );

		    $scr = array();
		    foreach ($registered_posts as $rs) {
		    	if( $rs->getPostType()!="slider" && $rs->getPostType()!="custompost")
		    	$screens[] = $rs->getPostType();
		    }

		   

		    foreach ($screens as $screen) {
		        add_meta_box(
		            'ioa_custom_panel',
		            sprintf( __('Custom %s Settings', 'ioa'), $screen ),
		            'ioa_panel_markup',
		            $screen
		        );
		    }
		}

		/* Prints the box content */
		function ioa_panel_markup( $post ) {

		  // Use nonce for verification
		  wp_nonce_field( 'ioa_panel_markup', 'ioa_panel_markup_nonce' );
		  global $super_options , $google_webfonts,  $ioa_sidebars;
		  

		  

		  $ioa_options = get_post_meta( $post->ID, 'ioa_options', true );

		  $show_title = $title_icon = ''; $override_title_style = '';
		  if(isset($ioa_options['show_title'])) $show_title =  $ioa_options['show_title'];
		  if(isset($ioa_options['title_icon'])) $title_icon =  $ioa_options['title_icon'];
		  if(isset($ioa_options['override_title_style'])) $override_title_style =  $ioa_options['override_title_style'];



		  $tc = $tbc = $tbco = $stc = $stbc = $stbco = '';

		  if(isset($ioa_options['ioa_custom_title_color'])) $tc =  $ioa_options['ioa_custom_title_color'];
		  if(isset($ioa_options['ioa_custom_title_bgcolor'])) $tbc =  $ioa_options['ioa_custom_title_bgcolor'];
		  if(isset($ioa_options['ioa_custom_title_bgcolor-opacity'])) $tbco =  $ioa_options['ioa_custom_title_bgcolor-opacity'];
		  if(isset($ioa_options['ioa_custom_subtitle_color'])) $stc =  $ioa_options['ioa_custom_subtitle_color'];
		  if(isset($ioa_options['ioa_custom_subtitle_bgcolor'])) $stbc =  $ioa_options['ioa_custom_subtitle_bgcolor'];
		  if(isset($ioa_options['ioa_custom_subtitle_bgcolor-opacity'])) $stbco =  $ioa_options['ioa_custom_subtitle_bgcolor-opacity'];

		  $ttbc = $background_cover = '';
		  if(isset($ioa_options['ioa_titlearea_bgcolor'])) $ttbc =  $ioa_options['ioa_titlearea_bgcolor'];
		  if(isset($ioa_options['background_cover'])) $background_cover =  $ioa_options['background_cover'];

		  $background_animate_time = $background_animate_position = '';
		  if(isset($ioa_options['background_animate_time'])) $background_animate_time =  $ioa_options['background_animate_time'];
		  if(isset($ioa_options['background_animate_position'])) $background_animate_position =  $ioa_options['background_animate_position'];
		  	
		  $tbgimage = $tbgposition = $tbgpositionc = $tbgrepeat = '';	
		  if(isset($ioa_options['ioa_titlearea_bgimage'])) $tbgimage =  $ioa_options['ioa_titlearea_bgimage'];
		  if(isset($ioa_options['ioa_titlearea_bgposition'])) $tbgposition =  $ioa_options['ioa_titlearea_bgposition'];
		  if(isset($ioa_options['ioa_titlearea_bgpositionc'])) $tbgpositionc =  $ioa_options['ioa_titlearea_bgpositionc'];
		  if(isset($ioa_options['ioa_titlearea_bgrepeat'])) $tbgrepeat =  $ioa_options['ioa_titlearea_bgrepeat'];
          
          $ttgr_start = $ttgr_end =  $tbggradient_use =  $tbggradient_dir =  '';
		  if(isset($ioa_options['ioa_titlearea_grstart'])) $ttgr_start =  $ioa_options['ioa_titlearea_grstart'];
		  if(isset($ioa_options['ioa_titlearea_grend'])) $ttgr_end =  $ioa_options['ioa_titlearea_grend'];
		  if(isset($ioa_options['titlearea_gradient'])) $tbggradient_use =  $ioa_options['titlearea_gradient'];
		  if(isset($ioa_options['titlearea_gradient_dir'])) $tbggradient_dir =  $ioa_options['titlearea_gradient_dir'];

		  $title_font =  $subtitle_font =  $title_font_size =   $title_font_weight = '';
		  if(isset($ioa_options['title_font'])) $title_font =  $ioa_options['title_font'];
		  if(isset($ioa_options['subtitle_font'])) $subtitle_font =  $ioa_options['subtitle_font'];
		  if(isset($ioa_options['title_font_size'])) $title_font_size =  $ioa_options['title_font_size'];
		  if(isset($ioa_options['title_font_weight'])) $title_font_weight =  $ioa_options['title_font_weight'];

		  $ta = $ts = $title_effect =  $subtitle_effect = $effect_delay = $titlearea_effect =   $page_layout = $page_sidebar ='';
		  if(isset($ioa_options['title_align'])) $ta =  $ioa_options['title_align'];
		  if(isset($ioa_options['title_vspace'])) $ts =  $ioa_options['title_vspace'];
		  if(isset($ioa_options['title_effect'])) $title_effect =  $ioa_options['title_effect'];
		  if(isset($ioa_options['subtitle_effect'])) $subtitle_effect =  $ioa_options['subtitle_effect'];
		  if(isset($ioa_options['effect_delay'])) $effect_delay =  $ioa_options['effect_delay'];
		  if(isset($ioa_options['titlearea_effect'])) $titlearea_effect =  $ioa_options['titlearea_effect'];

		  if(isset($ioa_options['page_layout'])) $page_layout =  $ioa_options['page_layout'];
		  if(isset($ioa_options['page_sidebar'])) $page_sidebar =  $ioa_options['page_sidebar'];
		  
		  $blogmeta_enable = $meta_keywords = $meta_description = $seo_title ='';	
		  if(isset($ioa_options['blogmeta_enable'])) $blogmeta_enable =  $ioa_options['blogmeta_enable'];

		  if(isset($ioa_options['meta_keywords'])) $meta_keywords =  $ioa_options['meta_keywords'];
		  if(isset($ioa_options['meta_description'])) $meta_description =  $ioa_options['meta_description'];
		  if(isset($ioa_options['seo_title'])) $seo_title =  $ioa_options['seo_title'];

		  	
		  
		  if( $background_cover == "" )  $background_cover = "true";
		  if($page_layout == "")
		  {	
		  		$page_layout = "full"; 

		  		 if($post->post_type=="post")
				  {
				  	if(isset($super_options[SN.'_post_layout']))
				  		$page_layout=  $super_options[SN.'_post_layout'];
				  	else
				  		$page_layout = "right-sidebar";
				  }

				  if($post->post_type=="page") {
				 	if(isset($super_options[SN.'_page_layout']) && $super_options[SN.'_page_layout']!="")
				  		{
				  			$page_layout=  $super_options[SN.'_page_layout'];
				  		}
				    else
				  		$page_layout = "full";
				  }
				  
				 
				
		  }
		 
		  $dominant_bg_color = $dominant_color =  $blog_metadata = '';
		  if(isset($ioa_options['dominant_bg_color'])) $dominant_bg_color =  $ioa_options['dominant_bg_color'];
		  if(isset($ioa_options['dominant_color'])) $dominant_color =  $ioa_options['dominant_color'];
		  if(isset($ioa_options['blog_metadata'])) $blog_metadata =  $ioa_options['blog_metadata'];

		   $featured_media_type =  $layered_media_type =  $klayered_media_type = '';
		  if(isset($ioa_options['featured_media_type'])) $featured_media_type =  $ioa_options['featured_media_type'];
		  if(isset($ioa_options['layered_media_type'])) $layered_media_type =  $ioa_options['layered_media_type'];
		  if(isset($ioa_options['klayered_media_type'])) $klayered_media_type =  $ioa_options['klayered_media_type'];

		   $background_image =  $featured_media_height = $adaptive_height =  $featured_video =   $portfolio_image_resize =  '';
		  if(isset($ioa_options['background_image'])) $background_image =  $ioa_options['background_image'];
		  if(isset($ioa_options['featured_media_height'])) $featured_media_height =  $ioa_options['featured_media_height'];
		  if(isset($ioa_options['adaptive_height'])) $adaptive_height =  $ioa_options['adaptive_height'];
		  if(isset($ioa_options['featured_video'])) $featured_video =  $ioa_options['featured_video'];
		  if(isset($ioa_options['portfolio_image_resize'])) $portfolio_image_resize =  $ioa_options['portfolio_image_resize'];
		  
		 

		  if($blogmeta_enable =="") $blogmeta_enable = $super_options[SN.'_blog_meta_enable'] ;

		  $posts_item_limit = $ioa_gallery_data = $posts_item_limit = '';

		  if(isset($ioa_options['posts_item_limit'])) $posts_item_limit =  $ioa_options['posts_item_limit'];
		  if($posts_item_limit =="") $posts_item_limit = $super_options[SN.'_posts_item_limit'] ;

		  $enable_thumbnail =  $more_label = $posts_excerpt_limit = $blog_excerpt =  $query_filter = '';
		  if(isset($ioa_options['enable_thumbnail'])) $enable_thumbnail =  $ioa_options['enable_thumbnail'];
		  if(isset($ioa_options['more_label'])) $more_label =  $ioa_options['more_label'];
		  if(isset($ioa_options['posts_excerpt_limit'])) $posts_excerpt_limit =  $ioa_options['posts_excerpt_limit'];
		  if(isset($ioa_options['blog_excerpt'])) $blog_excerpt =  $ioa_options['blog_excerpt'];
		  if(isset($ioa_options['query_filter'])) $query_filter =  $ioa_options['query_filter'];
		  if(isset($ioa_options['ioa_gallery_data'])) $ioa_gallery_data =  $ioa_options['ioa_gallery_data'];

		  $ioa_template_mode	= '';
		  if(isset($ioa_options['ioa_template_mode'])) $ioa_template_mode =  $ioa_options['ioa_template_mode'];

 		
 			
			/**
			 * Portfolio Meta Data
			 */
		  $portfolio_item_limit = $portfolio_enable_thumbnail = $portfolio_more_label = $portfolio_excerpt_limit = $portfolio_excerpt = $portfolio_query_filter = $portfolio_enable_text ='';	
		  if(isset($ioa_options['portfolio_item_limit'])) $portfolio_item_limit =  $ioa_options['portfolio_item_limit'];
		  if($portfolio_item_limit =="") $portfolio_item_limit = $super_options[SN.'_portfolio_item_limit'] ;
 		  
		  if(isset($ioa_options['portfolio_enable_thumbnail'])) $portfolio_enable_thumbnail =  $ioa_options['portfolio_enable_thumbnail'];
		  if(isset($ioa_options['portfolio_enable_text'])) $portfolio_enable_text =  $ioa_options['portfolio_enable_text'];

		  

		  if(isset($ioa_options['portfolio_more_label'])) $portfolio_more_label =  $ioa_options['portfolio_more_label'];
		  if(isset($ioa_options['portfolio_excerpt_limit'])) $portfolio_excerpt_limit =  $ioa_options['portfolio_excerpt_limit'];
		  if(isset($ioa_options['portfolio_excerpt'])) $portfolio_excerpt =  $ioa_options['portfolio_excerpt'];
		  if(isset($ioa_options['portfolio_query_filter'])) $portfolio_query_filter =  $ioa_options['portfolio_query_filter'];

		  $custom_post_type = $custom_query_filter = $custom_enable_thumbnail = '';
		  if(isset($ioa_options['custom_post_type'])) $custom_post_type =  $ioa_options['custom_post_type'];
		  if(isset($ioa_options['custom_query_filter'])) $custom_query_filter =  $ioa_options['custom_query_filter'];
		  if(isset($ioa_options['custom_enable_thumbnail'])) $custom_enable_thumbnail =  $ioa_options['custom_enable_thumbnail'];

 		  $ioa_custom_posts_item_limit = '';
		  if(isset($ioa_options['custom_posts_item_limit'])) $ioa_custom_posts_item_limit =  $ioa_options['custom_posts_item_limit'];
		  if($ioa_custom_posts_item_limit =="") $ioa_custom_posts_item_limit = $super_options[SN.'_posts_item_limit'] ;

			
		 ?>
			
		<div id="ioa_custom_code" class="clearfix">
			<ul class='clearfix'>
				<?php if($post->post_type!="testimonial") : ?>
				<li><a href="#ioa_title_area" data-step='2' data-intro='<?php _e("This is title manager, customize title in any way you like.",'ioa') ?>' data-position='top'><?php _e('Title Area Settings','ioa') ?></a></li>
				<li><a href="#ioa_header_layout" data-step='3' data-intro='<?php _e("You can set Page/Post Layout and sidebar from here, default layout is taken from options panel -> layout tab.",'ioa') ?>' data-position='top'><?php _e('Layout Settings','ioa') ?></a></li>
				<?php endif; ?>	
				<li><a href="#ioa_dominant_color"  data-step='4' data-intro='<?php _e("Set  primary color(background color) and secondary color highlight here. These will show in highlights in templates and single items.",'ioa') ?>' data-position='top'><?php _e('Dominant Color','ioa') ?></a></li>
				<?php if($post->post_type!="testimonial") : ?>
				<li><a href="#ioa_media"  data-step='5' data-intro='<?php _e("Set Featured Media such has image , full width image or gallery here. For featured images be sure to Set Featured Image at top right corner",'ioa') ?>' data-position='top'><?php _e('Media','ioa') ?></a></li>
				
				<li><a href="#ioa_images"  data-step='7' data-intro='<?php _e("Add Group of images here, these are used in featured gallery and slider.",'ioa') ?>' data-position='top'><?php _e('Slideshow/Slider Images','ioa') ?></a></li>
				<li><a href="#ioa_seo"  data-step='8' data-intro='<?php _e("You can Custom SEO settings from here.",'ioa') ?>' data-position='top'><?php _e('SEO Settings','ioa') ?></a></li>
				<?php if($post->post_type=="page") :  ?>
				<li><a href="#ioa_portfolio_settings"  data-step='9' data-intro='<?php _e("You can filter and customize portfolio items for a portfolio template from here. For global settings you can set them at Theme Admin -> Portfolio Tab.",'ioa') ?>' data-position='top'><?php _e('Portfolio Settings','ioa') ?></a></li>
				<li><a href="#ioa_blog_settings"  data-step='10' data-intro='<?php _e("You can filter and customize post items for a blog template from here. For global settings you can set them at Theme Admin -> Blog Tab.",'ioa') ?>' data-position='top'><?php _e('Blog Settings','ioa') ?></a></li></li>
				<li><a href="#ioa_customtemplate"  data-step='10' data-intro='<?php _e("You can filter and customize custom post items here. Select Custom Post Template in set template to use this panel.",'ioa') ?>' data-position='top'><?php _e('Custom Post Settings','ioa') ?></a></li></li>
				<?php endif;endif; ?>

			

			</ul>
			<?php if($post->post_type!="testimonial") : ?>
			<div id="ioa_title_area">
				
				<h3 class="ioa_panel_heading" data-step='2' data-intro='<?php _e("This Panel consists of font related settings, you can select font,alignment and size. To disable title area you can set Show Title Area to no",'ioa') ?>' data-position='top'> <?php _e('General','ioa') ?> </h3>	
				<div>
					<?php 
						echo getIOAInput(array(
							"label" => "",
							"name" => 'ioa_template_mode',
							"type" => 'hidden',
							'default' => 'wp-editor',
							"value" => $ioa_template_mode,
							));
						

						echo getIOAInput(array( 
									"label" => __("Show Title Area",'ioa') , 
									"name" => "show_title" , 
									"default" => "yes" , 
									"type" => "select",
									"description" => "  " ,
									"length" => 'medium' ,
									"value" => $show_title,
									"options" => array("yes" => __("Yes",'ioa') ,"no" => __("No",'ioa')  )  
							) );

						echo getIOAInput(array( 
									"label" => __("Override Theme's Title Stylings",'ioa') , 
									"name" => "override_title_style" , 
									"default" => "no" , 
									"type" => "select",
									"description" => "  " ,
									"length" => 'medium' ,
									"value" => $override_title_style,
									"options" => array("no" => __("No",'ioa') , "yes" => __("Yes",'ioa') )  
							) );
						
						echo getIOAInput(array( 
									"label" => __("Set Icon for Title",'ioa') , 
									"name" => "title_icon" , 
									"default" => "" , 
									"type" => "text",
									"description" => "  " ,
									"length" => 'medium' ,
									"value" => $title_icon,
									'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>',
									"class" => 'has-input-button'  

							) );
				
						echo getIOAInput(array( 
									"label" => __("Select Title Alignment",'ioa') , 
									"name" => "title_align" , 
									"default" => "left" , 
									"type" => "select",
									"description" => "  " ,
									"length" => 'medium' ,
									"value" => $ta,
									"options" => array("left" => __("Left",'ioa') ,"right" => __("Right",'ioa') , "center" => __("Center",'ioa')  )  
							) );

						echo getIOAInput(array( 
									"label" => __("Select Title Vertical Spacing",'ioa') , 
									"name" => "title_vspace" , 
									"default" => "20" , 
									"type" => "slider",
									"description" => "  " ,
									"length" => 'medium' ,
									"value" => $ts,
									"max" => "100",
									"suffix" => "px"
							) );

						echo getIOAInput(array( 
									"label" => __("Select Title Font Size",'ioa') , 
									"name" => "title_font_size" , 
									"default" => "36" , 
									"type" => "slider",
									"description" => "  " ,
									"length" => 'medium' ,
									"value" => $title_font_size,
									"max" => "160",
									"suffix" => "px"
							) );

						echo getIOAInput(array( 
									"label" => __("Enter Font Weight",'ioa') , 
									"name" => "title_font_weight" , 
									"default" => "700" , 
									"type" => "text",
									"description" => "  " ,
									"value" => $title_font_weight,
							) );

						echo getIOAInput(array( 
											"label" => __("Select Title font",'ioa') , 
											"name" => "title_fontfamily", 
											"default" => '', 
											"type" => "select",
											"description" => "",
											"options" => $google_webfonts  ,
											"value" =>  $title_font 
									) 
								);

						if($post->post_type=="page")
						echo getIOAInput(array( 
											"label" => __("Select Sub Title font",'ioa') , 
											"name" => "subtitle_fontfamily", 
											"default" =>'', 
											"type" => "select",
											"description" => "",
											"options" => $google_webfonts  ,
											"value" =>  $subtitle_font 
									) 
								);

					
							?>
				</div>			


				<h3 class="ioa_panel_heading" data-step='2' data-intro='<?php _e("This panel contains background and text color styling of title and subtitle.",'ioa') ?>' data-position='top'>  
					<?php _e('Title ','ioa'); if($post->post_type=="page") _e('& Subtitle','ioa'); _e(' Stylings','ioa') ?> 
				</h3>	
				<div>
					<?php 
				
						echo getIOAInput(array( 
									"label" => __("Select Title Color",'ioa') , 
									"name" => "title_color" , 
									"default" => " << " , 
									"type" => "colorpicker",
									"description" => "  " , "alpha" => false,
									"length" => 'medium' ,
									"value" => $tc." << "
							) );

						

						echo getIOAInput(array( 
									"label" => __("Select Title Background Color",'ioa') , 
									"name" => "title_bgcolor" , 
									"default" => " << " , 
									"type" => "colorpicker",
									"description" => "  " , "alpha" => false,
									"length" => 'medium' ,
									"value" => $tbc." << "  
							) );	 

						echo getIOAInput(array( 
									"label" => __("Enter Title Background Opacity(Between 0 and 1)",'ioa') , 
									"name" => "title_bgcolor-opacity" , 
									"default" => "1" , 
									"type" => "text",
									"description" => "  " , 
									"length" => 'small' ,
									"value" => $tbco  
							) );

						if($post->post_type=="page")
						echo getIOAInput(array( 
									"label" => __("Select Sub Title Color",'ioa') , 
									"name" => "subtitle_color" , 
									"default" => " << " , 
									"type" => "colorpicker", "alpha" => false,
									"description" => "  " ,
									"length" => 'medium'  ,
									"value" => $stc." << "    
							) ); 
						
						if($post->post_type=="page")
						echo getIOAInput(array( 
									"label" => __("Select Sub Title Background Color" ,'ioa'), 
									"name" => "subtitle_bgcolor" , 
									"default" => " << " , 
									"type" => "colorpicker", "alpha" => false,
									"description" => "  " ,
									"length" => 'medium'  ,
									"value" => $stbc." << "
							) ); 

						if($post->post_type=="page")
						echo getIOAInput(array( 
									"label" => __("Enter Sub Title Background Opacity(Between 0 and 1)",'ioa') , 
									"name" => "subtitle_bgcolor-opacity" , 
									"default" => "1" , 
									"type" => "text",
									"description" => "  " , 
									"length" => 'small' ,
									"value" => $stbco  
							) );

				?>

				</div>



				<h3 class="ioa_panel_heading" data-step='2' data-intro='<?php _e("This panel contains settings to set background image , gradients and colors with all customizable options.",'ioa') ?>' data-position='top'>  <?php _e('Background Stylings','ioa') ?> </h3>	
				<div>
					<?php 
				
					echo getIOAInput(array( 
									"label" => __("Select Background Color for title area",'ioa') , 
									"name" => "titlearea_bgcolor" , 
									"default" => " << " , 
									"type" => "colorpicker",
									"description" => "  " ,
									"length" => 'medium'  ,
									"alpha" => false,
									"value" => $ttbc." << "     
							) ); 


					echo getIOAInput(array( 
									"label" => __("Enable Full Background Stretch",'ioa') , 
									"name" => "background_cover" , 
									"default" => "" , 
									"type" => "select",
									"value" => $background_cover ,
									"options" => array("", "auto","contain","cover")

							) ); 

					echo getIOAInput(array( 
									"label" => __("Add Background Image for Title Area",'ioa') , 
									"name" => "titlearea_bgimage" , 
									"default" => "" , 
									"type" => "upload",
									"description" => "" ,
									"class" => "has-input-button",
									"length" => 'medium'  ,
									"value" => $tbgimage,   
									"title" => __("Use as Background Image",'ioa'),
				  					"std" => "",
				 					 "button" => __("Add Image",'ioa')

							) );

					echo getIOAInput(array( 
									"label" => __("Background Position for Title Area Image",'ioa') , 
									"name" => "titlearea_bgposition" , 
									"default" => "" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $tbgposition,  
									 "options" => array("", "top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right")
												 
							) );

					echo getIOAInput(array( 
									"label" => __("Custom Background Position( 0px 0px format )",'ioa') , 
									"name" => "titlearea_bgpositionc" , 
									"default" => "" , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $tbgpositionc,   

							) );

					echo getIOAInput(array( 
									"label" => __("Background Repeat for Title Area Image",'ioa') , 
									"name" => "titlearea_bgrepeat" , 
									"default" => "" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $tbgrepeat,  
									 "options" => array("","repeat","repeat-x","repeat-y","no-repeat")
												 
							) );

					echo getIOAInput(array( 
									"label" => __("Use Background Gradient",'ioa') , 
									"name" => "titlearea_gradient" , 
									"default" => "no" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $tbggradient_use,  
									"options" => array("yes" => __("Yes",'ioa'),"no"=> __("No",'ioa') )
												 
							) );

					echo getIOAInput(array( 
									"label" => __("Use Background Gradient",'ioa') , 
									"name" => "titlearea_gradient_dir" , 
									"default" => "no" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $tbggradient_dir,  
									"options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left(Not Supported IE8-9)",'ioa'),"diagonalbr" => __("Diagonal Bottom Right(Not Supported IE8-9)",'ioa') )
												 
							) );

					echo getIOAInput(array( 
									"label" => __("Select Start Background Color for title area",'ioa') , 
									"name" => "titlearea_grstart" , 
									"default" => " << " , 
									"type" => "colorpicker",
									"description" => "  " ,
									"length" => 'medium'  ,
									"alpha" => false,
									"value" => $ttgr_start." << "     
							) );

					echo getIOAInput(array( 
									"label" => __("Select Start Background Color for title area",'ioa') , 
									"name" => "titlearea_grend" , 
									"default" => " << " , 
									"type" => "colorpicker",
									"description" => "  " ,
									"length" => 'medium'  ,
									"alpha" => false,
									"value" => $ttgr_end." << "     
							) );


				?>
				
				</div>
				<h3 class="ioa_panel_heading" data-step='2' data-intro='<?php _e("You can set title, subtitle and title area animation.",'ioa') ?>' data-position='top'>  <?php _e('Animation','ioa') ?> </h3>	
				<div>
					<?php 
				
					echo getIOAInput(array( 
									"label" => __("Title Effect",'ioa') , 
									"name" => "title_effect" , 
									"default" => "none" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $title_effect,  
									"options" => array("none" => __("None",'ioa'),"fade"=> __("Fade",'ioa') ,"fade-left" => __("Fade From Left",'ioa'),"fade-right" => __("Fade From Right",'ioa'),"fade-right" => __("Fade From Right",'ioa'),"rotate-right" => __("Rotate from Right",'ioa'),"rotate-left" => __("Rotate from Left",'ioa'),"scale-in" => __("Scale In",'ioa'),"scale-out" => __("Scale Out",'ioa'),"curtain-show" => __("Curtain Show",'ioa'),"curtain-fade" => __("Curtain Fade",'ioa'))
												 
							) );

					if($post->post_type=="page")
					echo getIOAInput(array( 
									"label" => __("Sub Title Effect",'ioa') , 
									"name" => "subtitle_effect" , 
									"default" => "none" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $subtitle_effect,  
									"options" => array("none" => __("None",'ioa'),"fade"=> __("Fade",'ioa') ,"fade-left" => __("Fade From Left",'ioa'),"fade-right" => __("Fade From Right",'ioa'),"fade-right" => __("Fade From Right",'ioa'),"rotate-right" => __("Rotate from Right",'ioa'),"rotate-left" => __("Rotate from Left",'ioa'),"scale-in" => __("Scale In",'ioa'),"scale-out" => __("Scale Out",'ioa'),"curtain-show" => __("Curtain Show",'ioa'),"curtain-fade" => __("Curtain Fade",'ioa'))
												 
							) );


					echo getIOAInput(array( 
									"label" => __("Enter Background Animation Time in minutes",'ioa') , 
									"name" => "background_animate_time" , 
									"default" => "60" , 
									"type" => "text",
									"description" => "  " , 
									"length" => 'small' ,
									"value" => $background_animate_time  
							) );

						echo getIOAInput(array( 
									"label" => __("Enter Background Position[Left Top] for animation(ex 9999px 9999px) ",'ioa') , 
									"name" => "background_animate_position" , 
									"default" => "-9999px -9999px" , 
									"type" => "text",
									"description" => "  " , 
									"length" => 'small' ,
									"value" => $background_animate_position  
							) );

					echo getIOAInput(array( 
									"label" => __("Effect Delay Between Title & Subtitle in seconds",'ioa') , 
									"name" => "effect_delay" , 
									"default" => "0.5" , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $effect_delay
							) );


					echo getIOAInput(array( 
									"label" => __("Title Area Effect",'ioa') , 
									"name" => "titlearea_effect" , 
									"default" => "none" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $titlearea_effect,  
									"options" => array("none" => __("None",'ioa'),"fade"=>__("Fade",'ioa'),"fade-left" => __("Fade From Left",'ioa'),"fade-right" => __("Fade From Right",'ioa'),"fade-right" => __("Fade From Right",'ioa'),"rotate-right" => __("Rotate from Right",'ioa'),"rotate-left" => __("Rotate from Left",'ioa'),"scale-in" => __("Scale In",'ioa'),"scale-out" => __("Scale Out",'ioa'),"metro" => __("Metro Tile Effect",'ioa'),"parallex" => __("Parallax Background Image",'ioa') , "animate-bg" => __("Animated Background Axis",'ioa'))
												 
							) );

						?>
				</div>		

	
			</div>
			<div id="ioa_header_layout">
				
				<h3 class="ioa_panel_heading"> <?php _e('Select Page Layout and Sidebar','ioa') ?> </h3>	
				<div>

					<ul class="layout-list clearfix">
						<li class='full' data-val='full' ></li>
						<li class='right-sidebar' data-val='right-sidebar' ></li>
						<li class='left-sidebar' data-val='left-sidebar' ></li>

						<li class='sticky-right-sidebar' data-val='sticky-right-sidebar' ></li>
						<li class='sticky-left-sidebar' data-val='sticky-left-sidebar' ></li>

						<li class='below-title' data-val='below-title' ></li>
						<li class='above-footer' data-val='above-footer' ></li>
					</ul>
					<input type="hidden" class="page_layout" name='page_layout' value="<?php echo $page_layout; ?>">
					
					<hr>
					
					<?php 

					echo getIOAInput(array( 
									"label" => __("Select Sidebar",'ioa') , 
									"name" => "page_sidebar" , 
									"default" => "Blog Sidebar" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $page_sidebar,  
									"options" => $ioa_sidebars
												 
							) );

					 ?>
				</div>	
			</div>	
			<?php endif; ?>			
			
			<div id="ioa_dominant_color">
				
				<h3 class="ioa_panel_heading"> <?php _e('Select Page Layout and Sidebar','ioa') ?> </h3>	
				<div>
				<?php 
					echo getIOAInput(array( 
									"label" => __("Select Primary Highlight Color",'ioa') , 
									"name" => "dominant_bg_color" , 
									"default" => " << " , 
									"type" => "colorpicker",
									"description" => "  " ,
									"length" => 'medium'  ,
									"alpha" => false,
									"value" => $dominant_bg_color." << "     
							) );

					echo getIOAInput(array( 
									"label" => __("Select Secondary Highlight Color" ,'ioa'), 
									"name" => "dominant_color" , 
									"default" => " << " , 
									"type" => "colorpicker",
									"description" => "  " ,
									"length" => 'medium'  ,
									"alpha" => false,
									"value" => $dominant_color." << "     
							) );

				 ?>
				</div>
			</div>

			<?php if($post->post_type!="testimonial") : ?>

			<div id="ioa_media">
				
				<?php 

					if(function_exists('rev_slider_shortcode'))
					{
						global $wpdb;
						 $table_db_name = GlobalsRevSlider::$table_sliders;
						 $lsliders = $wpdb->get_results("SELECT * FROM $table_db_name",ARRAY_A);

						 $slds = array("none" => "None");
						 foreach ($lsliders as $slider) {
						 	$slds[$slider['alias']] = $slider['title'];
						 }


						 echo getIOAInput(array( 
									"label" => __("Select Revolution Layered Slider for Featured Media",'ioa') , 
									"name" => "layered_media_type" , 
									"default" => "none" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $layered_media_type,  
									"options" => $slds
												 
							) );

					}
					
					if(function_exists('lsSliders'))
					{
						$layered_slds = array("none" => "None");
						$lsl = lsSliders();
						foreach ($lsl as $slider) {
						 	$layered_slds[$slider['id']] = $slider['name'];
						 }
						 echo getIOAInput(array( 
									"label" => __("Select Layered Slider for Featured Media",'ioa') , 
									"name" => "klayered_media_type" , 
									"default" => "none" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $klayered_media_type,  
									"options" => $layered_slds
												 
							) );

					}					

					echo getIOAInput(array( 
									"label" => __("Select Featured Media Type",'ioa') , 
									"name" => "featured_media_type" , 
									"default" => "image" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $featured_media_type,  
									"options" => array(
															"none" => __("None",'ioa') , 
															"image" => __("Featured Image",'ioa') , 
															"proportional" => __("Proportional Resized Featured Image",'ioa'),
															"none-full" => __("Top Featured Image(No Resizing)",'ioa') , 
															"none-contained" => __("Contained Featured Image(No Resizing)",'ioa'), 
															"image-full" =>__("Full Width Featured Image" ,'ioa'), 
															"image-parallex" =>__("Full Width Parallex Featured Image",'ioa'),
															"video" => __("Video",'ioa'),
															"slideshow" => __("Slideshow",'ioa'), 
															"slideshow-contained" => __("Full Contained Slideshow",'ioa'),
															"slider" => __("Slider",'ioa'),
															"slider-contained" => __("Full Contained Slider",'ioa'),
															"slider-full" => __("Full Width Slider",'ioa'),  )
												 
							) );

					echo getIOAInput(array( 
									"label" => __("Enter Featured Video Link",'ioa') , 
									"name" => "featured_video" , 
									"default" => "" , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $featured_video,  
												 
							) );

					echo getIOAInput(array( 
									"label" => __("Background Image for Full Featured Media",'ioa') , 
									"name" => "background_image" , 
									"default" => "" , 
									"type" => "upload",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $background_image, 
									"class" => 'has-input-button' 
												 
							) );

					

					echo getIOAInput(array(
                  "label"=> __("Featured Media Height",'ioa'),
				   "name" => "featured_media_height",
				   "type"=>"slider",
				   "max"=>800,
				   "default"=> 450, 
				   "value" => $featured_media_height,
				   "suffix"=>" px" ));	

					echo getIOAInput(array( 
									"label" => __("Enable Adaptive Height( doesn't work for parallex media)",'ioa') , 
									"name" => "adaptive_height" , 
									"default" => "false", 
									"type" => "toggle",
									"length" => 'medium'  ,
									"value" => $adaptive_height
							) );

					 ?>

			</div>
			
			<div id="ioa_images" class="clearfix">
				<p class="note"> <?php _e(" To Select Multiple Images hold down control key or cmd for MAC. To select in a row in a single click, hold down shift click on first image then click on last image you want.",'ioa') ?> </p>
				<a href="" class="post-ioa-images-generator button-default" data-title="Add Images" data-label="Add" ><?php _e(' Add Images ','ioa') ?></a>	
				

				 <div class="ioa-image-area clearifx">
				 	<?php 
				 	if(isset($ioa_gallery_data) && trim($ioa_gallery_data) != "" ) : $ar = explode(";",stripslashes($ioa_gallery_data));

				 	foreach( $ar as $image) :

							if($image!="") :
								$g_opts = explode("<gl>",$image);
							
							?>
								<div class='ioa-gallery-item' data-thumbnail='<?php echo $g_opts[1]; ?>' data-img='<?php echo $g_opts[0]; ?>' data-alt='<?php echo $g_opts[2]; ?>' data-title='<?php echo $g_opts[3] ?>' data-description='<?php echo $g_opts[4] ?>' ><img src='<?php echo $g_opts[1] ?>' /> <a class='close ioa-front-icon  cancel-2icon-' href=''></a></div>
							<?php 
						endif;
					endforeach; endif; ?>

				 </div>
				 <input type="hidden" name="ioa_gallery_data" class="ioa_gallery_data" id="ioa_gallery_data" value="<?php echo $ioa_gallery_data; ?>" />
			</div>	
			
			<div id="ioa_seo" class="clearfix">
				<?php 

			

		  		echo getIOAInput(array( 
									"label" => __("Meta Keywords for the Page",'ioa') , 
									"name" => "meta_keywords" , 
									"default" => $super_options[SN.'_meta_keywords'] , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $meta_keywords
							) );

		  		echo getIOAInput(array( 
									"label" => __("Meta Description for the Page",'ioa') , 
									"name" => "meta_description" , 
									"default" => $super_options[SN.'_meta_description'] , 
									"type" => "textarea",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $meta_description
							) );

		  		echo getIOAInput(array( 
									"label" => __("Seo Title for the Page",'ioa') , 
									"name" => "seo_title" , 
									"default" => '' , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $seo_title
							) );
				 ?>
			</div>

			<?php if($post->post_type=="page") : global $ioa_portfolio_slug; ?>
			<div id="ioa_portfolio_settings" class='ioa-query-box'>
				<input type="hidden" class="post_type" value="<?php echo $ioa_portfolio_slug; ?>">
			<?php 

			echo getIOAInput(array( 
									"label" => __("Portfolio Images Resizing",'ioa') , 
									"name" => "portfolio_image_resize" , 
									"default" => "default" , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $portfolio_image_resize,  
									"options" => array( "default" => __("Full Width",'ioa'), "proportional" => __("Proportional",'ioa') , "none" => __("None",'ioa') )
												 
							) );

			echo getIOAInput(array( 
									"label" => __("Generate Filters",'ioa') , 
									"name" => "portfolio_query_filter" , 
									"default" => "" , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"class" => 'has-input-button',
									"value" => $portfolio_query_filter, 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>'
							) );

				

				echo getIOAInput(array( 
									"label" => __("Enable lightbox icon on hover (if false link icon will show)",'ioa') , 
									"name" => "portfolio_enable_thumbnail" , 
									"default" => $super_options[SN.'_portfolio_enable_thumbnail'], 
									"type" => "toggle",
									
									"length" => 'medium'  ,
									"value" => $portfolio_enable_thumbnail
							) );

					echo getIOAInput(array( 
									"label" => __("Enable text description",'ioa') , 
									"name" => "portfolio_enable_text" , 
									"default" => 'false', 
									"type" => "toggle",
									
									"length" => 'medium'  ,
									"value" => $portfolio_enable_text
							) );

				echo getIOAInput(array( 
									"label" => __("Use wordpress default excerpt",'ioa') , 
									"name" => "portfolio_excerpt" , 
									"default" => $super_options[SN.'_portfolio_excerpt'], 
									"type" => "toggle",
									"length" => 'medium'  ,
									"value" => $portfolio_excerpt
							) );

				echo getIOAInput(array( 
									"label" => __("More Button Label",'ioa') , 
									"name" => "portfolio_more_label" , 
									"default" => $super_options[SN.'_portfolio_more_label'] , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $portfolio_more_label
							) );

				echo getIOAInput(array(
                  "label"=> __("Portfolio Items Limit",'ioa'),
				   "name" => "portfolio_item_limit",
				   "type"=>"slider",
				   "max"=>50,
				   "default"=>6,
				   "value" => $portfolio_item_limit,
				   "suffix"=>"Items" ));			

				echo getIOAInput(array(
                  "label"=> __("Portfolio Content Limit",'ioa'),
				   "name" => "portfolio_excerpt_limit",
				   "type"=>"slider",
				   "max"=>800,
				   "default"=>$super_options[SN.'_portfolio_excerpt_limit'], 
				   "value" => $portfolio_excerpt_limit,
				   "suffix"=>" Letters" ));	

				?>
	
			</div>
			<div id="ioa_blog_settings" class="ioa_query_box">
					<input type="hidden" class="post_type" value="post">
				<?php 
				$pmb ='';

				$post_meta_shortcodes =  array(

					"post_author" => array(
							"name" =>  __("Post Author",'ioa'),
							"syntax" => '[post_author_posts_link/]',
							),	
					"post_date" => array(
							"name" =>  __("Post Date",'ioa'),
							"syntax" => '[post_date format=\'l, F d S, Y\'/]',
							),					
					"post_time" => array(
							"name" =>  __("Post Time",'ioa'),
							"syntax" => '[post_time format=\'g:i a\'/]',
							),	
					"post_tags" => array(
							"name" =>  __("Post Tags",'ioa'),
							"syntax" => '[post_tags sep=\',\' icon=\'\' /]',
							),	
					"post_categories" => array(
							"name" =>  __("Post Categories",'ioa'),
							"syntax" => '[post_categories sep=\',\' icon=\'\' /]',
							),
					"get" => array(
							"name" =>  __("Post Meta",'ioa'),
							"syntax" => '[get name=\'\' /]',
							),
					"post_comments" => array(
							"name" => __("Post Comments",'ioa'),
							"syntax" => "[post_comments /]"
							)

						);

				foreach($post_meta_shortcodes as $sh) $pmb .= " <a class='button-default' href=\"".$sh['syntax']."\">".$sh['name']."</a> ";
				
				echo getIOAInput(array( 
									"label" => __("Generate Filters",'ioa') , 
									"name" => "query_filter" , 
									"default" => "" , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"class" => 'has-input-button',
									"value" => $query_filter, 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>'
							) );

				echo getIOAInput(array( 
									"label" => __("Blog Templates Posts shortcode Bar",'ioa') , 
									"name" => "blog_metadata" , 
									"default" => $super_options[SN.'_blog_meta'] , 
									"type" => "textarea",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $blog_metadata,
									"after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", 
									"buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>"
							) );

				echo getIOAInput(array( 
									"label" => __("Show Blog Templates Posts shortcode Bar",'ioa') , 
									"name" => "blogmeta_enable" , 
									"default" => "", 
									"type" => "toggle",
									"length" => 'medium'  ,
									"value" => $blogmeta_enable
							) );

				echo getIOAInput(array( 
									"label" => __("Enable lightbox icon on hover (if false link icon will show)",'ioa') , 
									"name" => "enable_thumbnail" , 
									"default" => $super_options[SN.'_enable_thumbnail'], 
									"type" => "toggle",
									"length" => 'medium'  ,
									"value" => $enable_thumbnail
							) );

				echo getIOAInput(array( 
									"label" => __("Use wordpress default excerpt",'ioa') , 
									"name" => "blog_excerpt" , 
									"default" => $super_options[SN.'_blog_excerpt'], 
									"type" => "toggle",
									"length" => 'medium'  ,
									"value" => $blog_excerpt
							) );

				echo getIOAInput(array( 
									"label" => __("More Button Label",'ioa') , 
									"name" => "more_label" , 
									"default" => $super_options[SN.'_more_label'] , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $more_label
							) );

				echo getIOAInput(array(
                  "label"=> __("Blog Posts Items Limit",'ioa'),
				   "name" => "posts_item_limit",
				   "type"=>"slider",
				   "max"=>50,
				   "default"=>6,
				   "value" => $posts_item_limit,
				   "suffix"=>"Items" ));			

				echo getIOAInput(array(
                  "label"=> __("Blog Posts Content Limit",'ioa'),
				   "name" => "posts_excerpt_limit",
				   "type"=>"slider",
				   "max"=>800,
				   "default"=>$super_options[SN.'_posts_excerpt_limit'], 
				   "value" => $posts_excerpt_limit,
				   "suffix"=>" Letters" ));	

				?>
 			
 			
			</div>
			<div id="ioa_customtemplate" class="ioa_query_box">
				
				<?php 
				$pmb ='';

				$post_meta_shortcodes =  array(

					"post_author" => array(
							"name" =>  __("Post Author",'ioa'),
							"syntax" => '[post_author_posts_link/]',
							),	
					"post_date" => array(
							"name" =>  __("Post Date",'ioa'),
							"syntax" => '[post_date format=\'l, F d S, Y\'/]',
							),					
					"post_time" => array(
							"name" =>  __("Post Time",'ioa'),
							"syntax" => '[post_time format=\'g:i a\'/]',
							),	
					"post_tags" => array(
							"name" =>  __("Post Tags",'ioa'),
							"syntax" => '[post_tags sep=\',\' icon=\'\' /]',
							),	
					"post_categories" => array(
							"name" =>  __("Post Categories",'ioa'),
							"syntax" => '[post_categories sep=\',\' icon=\'\' /]',
							),
					"get" => array(
							"name" =>  __("Post Meta",'ioa'),
							"syntax" => '[get name=\'\' /]',
							),
					"post_comments" => array(
							"name" => __("Post Comments",'ioa'),
							"syntax" => "[post_comments /]"
							)

						);

				foreach($post_meta_shortcodes as $sh) $pmb .= " <a href=\"".$sh['syntax']."\">".$sh['name']."</a> ";

				global $registered_posts;
			   	 $cps = array();
			   	 foreach ($registered_posts as $rs) {

			    	if($rs->getPostType()!="testimonial" && $rs->getPostType()!="slider" && $rs->getPostType()!="custompost" && $rs->getPostType()!=$ioa_portfolio_slug)
			    	$cps[] = $rs->getPostType();
			    }
			    $fitsv = '';
			    if(isset($cps[0])) $fitsv = $cps[0];


 				?>
 				<div class="ioa-query-box"> <?php
				echo getIOAInput(array( 
									"label" => __("Select Post Type",'ioa') , 
									"name" => "custom_post_type" , 
									"default" => $fitsv , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"value" => $custom_post_type,
									"options" => $cps
							) );

				echo getIOAInput(array( 
									"label" => __("Generate Filters",'ioa') , 
									"name" => "custom_query_filter" , 
									"default" => "" , 
									"type" => "text",
									"description" => "" ,
									"length" => 'medium'  ,
									"class" => 'has-input-button',
									"value" => $custom_query_filter, 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>'
							) );
					?> </div> <?php
				
				echo getIOAInput(array( 
									"label" => __("Enable lightbox icon on hover (if false link icon will show)",'ioa') , 
									"name" => "custom_enable_thumbnail" , 
									"default" => $super_options[SN.'_enable_thumbnail'], 
									"type" => "toggle",
									
									"length" => 'medium'  ,
									"value" => $custom_enable_thumbnail
							) );

				

				echo getIOAInput(array(
                  "label"=> __("Custom Posts Items Limit",'ioa'),
				   "name" => "custom_posts_item_limit",
				   "type"=>"slider",
				   "max"=>50,
				   "default"=>6,
				   "value" => $ioa_custom_posts_item_limit,
				   "suffix"=>"Items" ));			

				

				?>
 			
 			
			</div>
			<?php endif; ?>	

			<?php endif; ?>


			

		</div>		

		 <?php
		

		}

		/* When the post is saved, saves our custom data */
		function ioa_save_panel( $post_id ) {

		 global $post;

		 	  // Check if our nonce is set.
		  if ( ! isset( $_POST['ioa_panel_markup_nonce'] ) )
		    return $post_id;

		  $nonce = $_POST['ioa_panel_markup_nonce'];

		  // Verify that the nonce is valid.
		  if ( ! wp_verify_nonce( $nonce, 'ioa_panel_markup' ) )
		      return $post_id;

		  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
		  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		      return $post_id;

  
		  if ( isset( $_POST['post_type']) && 'page' == $_POST['post_type'] ) {
		    if ( ! current_user_can( 'edit_page', $post_id ) )
		        return;
		  } else {
		    if ( ! current_user_can( 'edit_post', $post_id ) )
		        return;
		  }

	
		  //if saving in a custom table, get post_ID
		  $post_ID = $post_id;
		  
		  if ($parent_id = wp_is_post_revision($post_id)) 
			$post_ID = $parent_id;

		  
		 // $ioa_options = get_post_meta( $post->ID, 'ioa_options', true );
		  
		  $ioa_options = array();

		  $ioa_options['dominant_bg_color'] = sanitize_text_field( $_POST['dominant_bg_color']);	
		 $ioa_options['dominant_color'] =sanitize_text_field( $_POST['dominant_color'] );	
		  
		  if($post->post_type!="testimonial") :

		  if(isset( $_POST['post_subtitle'] )) :
		  	$post_subtitle = sanitize_text_field( $_POST['post_subtitle'] );
		  	update_post_meta($post_ID, '_post_subtitle', $post_subtitle);	
		  endif;

		 $ioa_options['show_title'] =sanitize_text_field( $_POST['show_title'] );
		 $ioa_options['title_icon'] =sanitize_text_field( $_POST['title_icon'] );
		 $ioa_options['override_title_style'] =sanitize_text_field( $_POST['override_title_style'] );
		 $ioa_options['ioa_template_mode'] =sanitize_text_field( $_POST['ioa_template_mode'] );

		   // SEO
		   
		  $ioa_options['meta_keywords'] =sanitize_text_field( $_POST['meta_keywords'] );
		  $ioa_options['meta_description'] =sanitize_text_field( $_POST['meta_description'] );
		  $ioa_options['seo_title'] =sanitize_text_field( $_POST['seo_title'] );


		  // Title Color Settings
		 $ioa_options['ioa_custom_title_color'] =sanitize_text_field( $_POST['title_color'] );	

		 $ioa_options['ioa_custom_title_bgcolor'] =sanitize_text_field( $_POST['title_bgcolor'] );	
		 $ioa_options['ioa_custom_title_bgcolor-opacity'] =sanitize_text_field( $_POST['title_bgcolor-opacity'] );	

		  // Sub Title Color Settings
		  if(isset($_POST['subtitle_color']))
		 $ioa_options['ioa_custom_subtitle_color'] =sanitize_text_field( $_POST['subtitle_color'] );	

		  if(isset($_POST['subtitle_bgcolor']))
		 $ioa_options['ioa_custom_subtitle_bgcolor'] =sanitize_text_field( $_POST['subtitle_bgcolor'] );	
		  if(isset($_POST['subtitle_bgcolor-opacity']))
		 $ioa_options['ioa_custom_subtitle_bgcolor-opacity'] =sanitize_text_field( $_POST['subtitle_bgcolor-opacity'] );	
		  
		 $ioa_options['ioa_titlearea_bgcolor'] =sanitize_text_field( $_POST['titlearea_bgcolor'] );	
		 $ioa_options['ioa_titlearea_bgimage'] =sanitize_text_field( $_POST['titlearea_bgimage'] );
		 $ioa_options['ioa_titlearea_bgposition'] =sanitize_text_field( $_POST['titlearea_bgposition'] );
		 $ioa_options['ioa_titlearea_bgpositionc'] =sanitize_text_field( $_POST['titlearea_bgpositionc'] );
		 $ioa_options['ioa_titlearea_bgrepeat'] =sanitize_text_field( $_POST['titlearea_bgrepeat'] );	

		 $ioa_options['ioa_titlearea_grstart'] =sanitize_text_field( $_POST['titlearea_grstart'] );
		 $ioa_options['ioa_titlearea_grend'] =sanitize_text_field( $_POST['titlearea_grend'] );
		 $ioa_options['titlearea_gradient_dir'] =sanitize_text_field( $_POST['titlearea_gradient_dir'] );	
		 $ioa_options['titlearea_gradient'] =sanitize_text_field( $_POST['titlearea_gradient'] );	
		 $ioa_options['title_align'] =sanitize_text_field( $_POST['title_align'] );	
		 $ioa_options['title_vspace'] =sanitize_text_field( $_POST['title_vspace'] );		
		 $ioa_options['title_font'] =sanitize_text_field( $_POST['title_fontfamily'] );	
		  
		 $ioa_options['title_font_size'] =sanitize_text_field( $_POST['title_font_size'] );	
		 $ioa_options['title_font_weight'] =sanitize_text_field( $_POST['title_font_weight'] );	
		  
		  if(isset($_POST['subtitle_fontfamily']))
		 $ioa_options['subtitle_font'] =sanitize_text_field( $_POST['subtitle_fontfamily'] );	
		  
		 $ioa_options['title_effect'] =sanitize_text_field( $_POST['title_effect'] );	

		  if(isset($_POST['subtitle_effect']))
		 $ioa_options['subtitle_effect'] =sanitize_text_field( $_POST['subtitle_effect'] );	
		 $ioa_options['effect_delay'] =sanitize_text_field( $_POST['effect_delay'] );	
		 $ioa_options['page_layout'] =sanitize_text_field( $_POST['page_layout'] );
		 $ioa_options['page_sidebar'] =sanitize_text_field( $_POST['page_sidebar'] );	
		  
		 $ioa_options['background_cover'] =sanitize_text_field( $_POST['background_cover'] );	
		  
		 $ioa_options['background_animate_time'] =sanitize_text_field( $_POST['background_animate_time'] );	
		 $ioa_options['background_animate_position'] =sanitize_text_field( $_POST['background_animate_position'] );	
		  

		 


		 $ioa_options['titlearea_effect'] =sanitize_text_field( $_POST['titlearea_effect'] );	
		 $ioa_options['featured_media_type'] =sanitize_text_field( $_POST['featured_media_type'] );

		  if(isset( $_POST['layered_media_type']))
		 $ioa_options['layered_media_type'] =sanitize_text_field( $_POST['layered_media_type'] );

		  if(isset( $_POST['klayered_media_type']))
		 $ioa_options['klayered_media_type'] =sanitize_text_field( $_POST['klayered_media_type'] );	

		 $ioa_options['featured_media_height'] =sanitize_text_field( $_POST['featured_media_height'] );
		 $ioa_options['adaptive_height'] =sanitize_text_field( $_POST['adaptive_height'] );

		 $ioa_options['background_image'] =sanitize_text_field( $_POST['background_image'] );
		  
		  

		 $ioa_options['featured_video'] =sanitize_text_field( $_POST['featured_video'] );	
		 $ioa_options['ioa_gallery_data'] = $_POST['ioa_gallery_data'];
		  if(isset( $_POST['single_portfolio_template'] ))
		 $ioa_options['single_portfolio_template'] =sanitize_text_field( $_POST['single_portfolio_template'] );		
		  
		 if(isset($_POST['ioa_custom_template']))	$ioa_options['ioa_custom_template'] =sanitize_text_field( $_POST['ioa_custom_template'] );	
		  if($post->post_type=="page") : 	

		  	$ioa_options['blog_metadata'] =sanitize_text_field( $_POST['blog_metadata'] );	
			$ioa_options['blogmeta_enable'] =sanitize_text_field( $_POST['blogmeta_enable'] );
		 	$ioa_options['posts_item_limit'] =sanitize_text_field( $_POST['posts_item_limit'] );	
		   $ioa_options['portfolio_image_resize'] =sanitize_text_field( $_POST['portfolio_image_resize'] );

		   $ioa_options['enable_thumbnail'] =sanitize_text_field( $_POST['enable_thumbnail'] );	

		    if(isset($_POST['more_label']))
		   $ioa_options['more_label'] =sanitize_text_field( $_POST['more_label'] );	
		    
		   $ioa_options['posts_excerpt_limit'] =sanitize_text_field( $_POST['posts_excerpt_limit'] );	
		   $ioa_options['blog_excerpt'] =sanitize_text_field( $_POST['blog_excerpt'] );	
		   $ioa_options['query_filter'] =sanitize_text_field( $_POST['query_filter'] );	

		   $ioa_options['portfolio_enable_thumbnail'] =sanitize_text_field( $_POST['portfolio_enable_thumbnail'] );
		   $ioa_options['portfolio_enable_text'] =sanitize_text_field( $_POST['portfolio_enable_text'] );

		  

		    if(isset($_POST['portfolio_more_label']))
		   $ioa_options['portfolio_more_label'] =sanitize_text_field( $_POST['portfolio_more_label'] );	
		   $ioa_options['portfolio_excerpt_limit'] =sanitize_text_field( $_POST['portfolio_excerpt_limit'] );	
		   $ioa_options['portfolio_excerpt'] =sanitize_text_field( $_POST['portfolio_excerpt'] );	
		   $ioa_options['portfolio_query_filter'] =sanitize_text_field( $_POST['portfolio_query_filter'] );
		   $ioa_options['portfolio_item_limit'] =sanitize_text_field( $_POST['portfolio_item_limit'] );

		    if(isset($_POST['custom_post_type']))
		   $ioa_options['custom_post_type'] =sanitize_text_field( $_POST['custom_post_type'] );
		   
		    if(isset($_POST['custom_query_filter']))
		   $ioa_options['custom_query_filter'] =sanitize_text_field( $_POST['custom_query_filter'] );
		   
		    if(isset($_POST['custom_enable_thumbnail']))
		   $ioa_options['custom_enable_thumbnail'] =sanitize_text_field( $_POST['custom_enable_thumbnail'] );
		   
		    if(isset($_POST['custom_posts_item_limit']))
		   $ioa_options['custom_posts_item_limit'] =sanitize_text_field( $_POST['custom_posts_item_limit'] );
		   
	
		  endif;
		  endif;
		  			
		  update_post_meta( $post_id, 'ioa_options',$ioa_options );
		
		   $r_style = ''; $rad_custom_css = '';

		   if(isset($_POST['style_keys'])) $r_style = $_POST['style_keys'];
		   if(isset($_POST['rad_custom_css'])) $rad_custom_css = $_POST['rad_custom_css'];

		   update_post_meta( $post_ID, '_style_keys', $r_style );
		   update_post_meta( $post_ID, 'rad_custom_css', $rad_custom_css );
		     update_post_meta( $post_ID, 'rad_version',RAD_Version);

		}
		add_action( 'save_post', 'ioa_save_panel' );
		add_action( 'pre_post_update', 'ioa_save_panel' );
		
		


		if(is_admin())
		{
			add_action( 'edit_form_after_title', 'ioa_title_settings' );
		}

		
		function ioa_title_settings(){
	
		global $post,$IOA_templates,$ioa_portfolio_slug ;
		

		$post_id = $post->ID;
		$ioa_options = get_post_meta(  $post_id, 'ioa_options', true );
		$temp = "default";
		$link = appendableLink(get_permalink()); 
		if( isset($ioa_options['ioa_custom_template']) ) $temp = $ioa_options['ioa_custom_template'];	
		

		?>
			 <div class="clearfix ioa-below-title-area">
			 	
				<ul class="ioa-context-bar clearfix">
							<?php if($post->post_type=='page' || $post->post_type=='post' || $post->post_type == strtolower($ioa_portfolio_slug) ): ?>
								<li><a href="" class="ioa-page-builder-trigger">Switch To Page Builder</a></li>
							<?php endif; ?>
							<li><a href="" id="ioa-intro-trigger">Quick Tour</a></li>
			 	</ul>
				<?php if($post->post_type == $ioa_portfolio_slug || $post->post_type == 'page') :  ?>
			 	<ul class="ioa-template-bar clearfix">
			 				<li>
								<span>Scroll down to custom page settings to cutomize the template </span>	
							</li>
							<li class='custom-template-wrap'>
								<div class="custom-template-select-wrap">
									<select name="ioa_custom_template" id="ioa-page-template">
									
									<?php if($post->post_type == 'page') : ?>
									
											<?php foreach ($IOA_templates as $key => $template) { ?> 
											<option <?php if($temp == 'ioa-template-'.str_replace(" ","-",strtolower(trim($key))) ) echo "selected='selected' " ?> value="<?php echo 'ioa-template-'.str_replace(" ","-",strtolower(trim($key))) ?>"> 
												<?php echo $template ?>
											</option>

									<?php } 
											endif;
										   if($post->post_type == $ioa_portfolio_slug) : 

													$single_portfolio_templates =  array(
															"default" => __("Set $ioa_portfolio_slug Template",'ioa'), 
															"full-screen" => __("Full Screen",'ioa') , 
															"full-screen-porportional" => __("Full Screen Proportional",'ioa'), 
															"model" => __("Horizontal Images",'ioa') , 
															"side" => __("Side Layout",'ioa') );
											?>
									
											 <?php foreach ($single_portfolio_templates as $key => $template) {	?>  
												<option <?php if($temp == $key) echo "selected='selected' " ?> value="<?php echo $key ?>"> 
													<?php echo $template ?>
												</option>
												<?php } ?>
									<?php endif; ?>
									</select>	
								</div>
							</li>
							
			 	</ul>
			 <?php endif; ?>

			 </div>

		<?php
		


		}



		/**
		 * Registers All Javascript and CSS Files ( for both admin and frontend )
		 */


		$this-> registerScripts();
		
		/**
		 *  Menu Register
		 */
		
		$menus =  array(
			'top_menu1_nav' => __('Top Menu Holder 1','ioa'),
		  	'top_menu2_nav' => __('Top Menu Holder 2','ioa'),
			'footer_nav' => __('Bottom Footer Menu','ioa')
		  );
		
		$this->registerMenus($menus);		  
	}


	function preparePage($id=false)
	{
		global $post,$ioa_meta_data,$super_options;

		if( is_home() ) return;
		$ioa_options = array();


		$ioa_meta_data['subtitle'] = '';
		

		if( isset($post) ) :	

		$ioa_meta_data['rad_data'] = get_post_meta($post->ID,"rad_data",true);	
		
			if(  get_post_meta( $post->ID, 'rad_version', true ) == "" &&  !is_array($ioa_meta_data['rad_data'])  )	 
			 {
			 	

			 	if(  isJson($ioa_meta_data['rad_data']))
			 		$ioa_meta_data['rad_data'] = json_decode(stripslashes($ioa_meta_data['rad_data']),true);
			 	else
			 	{
			 		$ioa_meta_data['rad_data'] = base64_decode($ioa_meta_data['rad_data']);
			 		$ioa_meta_data['rad_data'] = json_decode(stripslashes($ioa_meta_data['rad_data']),true);
			 	}

			 	
			 }


		$ioa_meta_data['title'] = get_the_title();
		

		if(get_post_meta(get_the_ID(),'_post_subtitle',true)!="" && get_post_meta(get_the_ID(),'_post_subtitle',true)!="none") $ioa_meta_data['subtitle'] = get_post_meta(get_the_ID(),'_post_subtitle',true);

		$ioa_options = get_post_meta(  get_the_ID(), 'ioa_options', true );
		
		endif;

		if(!$id)	
			{ 
				$ioa_options = get_post_meta(  get_the_ID(), 'ioa_options', true );
				$ioa_meta_data['title'] = get_the_title();
			}
		else
			{
				$ioa_meta_data['title'] = get_the_title($id);
				$ioa_options = get_post_meta(  $id, 'ioa_options', true );
			}


		if($ioa_options=="")
		{
			 
			$ioa_options = array();
		} 

		$page_layout= $page_sidebar= '';

		if(isset($ioa_options['page_layout'])) $page_layout= $ioa_options['page_layout'];
		if(isset($ioa_options['page_sidebar'])) $page_sidebar= $ioa_options['page_sidebar'];
		
		 $ioa_meta_data['template_mode']	= 'wp-editor';

		if($page_layout=="") { 

			if(isset( $super_options[SN.'_page_layout']) && trim($super_options[SN.'_page_layout'])!='' )
				 $page_layout = $super_options[SN.'_page_layout'];
			else $page_layout = 'full';
			
			

			if(isset($post) && $post->post_type=="post")
			{
				if( isset( $super_options[SN.'_post_layout']) && $super_options[SN.'_post_layout']!='' )
					$page_layout = $super_options[SN.'_post_layout'];
				else 
					$page_layout = 'left-sidebar';

			} 
				
		}


		$ioa_meta_data['layout'] = $page_layout;
		$ioa_meta_data['sidebar'] = $page_sidebar;

		$flag = true;

		if(IOA_WOO_EXISTS && is_shop())
		{
			$flag = false;
		}	

		if(IOA_WOO_EXISTS && is_product_category())
		{
			$flag = false;
			$ioa_meta_data['sidebar'] = $super_options[SN.'_woo_category_sidebar'];
			$ioa_meta_data['layout'] = $super_options[SN.'_woo_category_layout'];
			$ioa_meta_data['title'] = single_term_title('',false);


		}
		if(IOA_WOO_EXISTS && is_product_tag())
		{
			$flag = false;
			$ioa_meta_data['sidebar'] = $super_options[SN.'_woo_tag_sidebar'];
			$ioa_meta_data['layout'] = $super_options[SN.'_woo_tag_layout'];
			$ioa_meta_data['title'] = single_term_title('',false);
		}

		if(is_tax())
			$ioa_meta_data['title'] = single_term_title('',false);

		if($flag)
		{
			if(is_author()|| is_search() || is_tag() || is_category() || is_archive()) $ioa_meta_data['layout'] = 'right-sidebar';

			if( ((is_author()|| is_search() || is_tag() || is_category() || is_archive() ) || is_home()) && ! (IOA_WOO_EXISTS && is_shop()) )
			{
				
				if( (is_author()|| is_search() || is_tag() || is_category() || is_archive() ) && $flag  ) $ioa_meta_data['layout'] = 'right-sidebar';
				if(is_archive()) 
				{
					
					$ioa_meta_data['title']="";
					if ( is_day() ) :
						$ioa_meta_data['title'] =  __( 'Daily Archives:', 'ioa' );
					elseif ( is_month() ) :
						$ioa_meta_data['title'] = __( 'Monthly Archives: ', 'ioa' );
					elseif ( is_year() ) :
						$ioa_meta_data['title'] = __( 'Yearly Archives: ', 'ioa' );
					elseif(is_tax()) : $ioa_meta_data['title'] =  single_term_title('',false);
					else :
						$ioa_meta_data['title'] = __( 'Archives', 'ioa' );

					endif;
					$show_title ="yes";
				}
				if(is_category())
				{
					
					$ioa_meta_data['title']= __('Category : ','ioa').single_cat_title( '', false );
				} 
				if(is_tag()) 
				{
					
					$ioa_meta_data['title']= __('Tag : ','ioa').single_tag_title( '', false );
				}
				if(is_search()) 
				{
					
					$ioa_meta_data['title'] =  __( 'Search Results for: ', 'ioa' ). '<span>' . get_search_query() . '</span>';
				}
				if(is_author())
				{
					if ( have_posts() ) : the_post();
						$ioa_meta_data['title'] = __( 'Author Posts :', 'ioa' ).  get_the_author();
					endif;
					rewind_posts();
					
				}

			} 
		}

		if( (function_exists('is_bbpress') && is_bbpress()) )
			{
				$ioa_meta_data['title'] = 'Forums';
			
				$ioa_meta_data['layout'] ="right-sidebar";
				$ioa_meta_data['sidebar']  = $super_options[SN.'_bbpress_sidebar'];
			
			}

		if( (function_exists('is_bbpress') && is_bbpress()) )
			{
				$ioa_meta_data['layout'] ="right-sidebar";
				$ioa_meta_data['sidebar']  = $super_options[SN.'_bbpress_sidebar'];
			
			}

		$ioa_meta_data['width'] = 1060;
		
		$ioa_meta_data['height'] = 	$ioa_meta_data['adaptive_height'] = '';

		if(isset($ioa_options['featured_media_height'])) $ioa_meta_data['height'] = $ioa_options['featured_media_height'];
		if(isset($ioa_options['adaptive_height'])) $ioa_meta_data['adaptive_height'] = $ioa_options['adaptive_height'];
		
		if($ioa_meta_data['height']=="") $ioa_meta_data['height'] = 450;
		
		$ioa_meta_data['featured_media_type'] = $ioa_meta_data['layered_media_type'] = $ioa_meta_data['klayered_media_type'] = '';

		if(isset($ioa_options['featured_media_type'])) $ioa_meta_data['featured_media_type'] = $ioa_options['featured_media_type'];
		if(isset($ioa_options['layered_media_type'])) $ioa_meta_data['layered_media_type'] = $ioa_options['layered_media_type'];
		if(isset($ioa_options['klayered_media_type'])) $ioa_meta_data['klayered_media_type'] = $ioa_options['klayered_media_type'];

		if($ioa_meta_data['layered_media_type']!="none" && $ioa_meta_data['layered_media_type']!="" && function_exists('rev_slider_shortcode'))
		{
			$ioa_meta_data['featured_media_type'] = 'image-full';
		}

		if($ioa_meta_data['klayered_media_type']!="none" && $ioa_meta_data['klayered_media_type']!="" && function_exists('lsSliders'))
		{
			$ioa_meta_data['featured_media_type'] = 'image-full';
		}

		$ioa_meta_data['background_image'] = $ioa_meta_data['featured_video'] = '';

		if(isset($ioa_options['background_image'])) $ioa_meta_data['background_image'] = $ioa_options['background_image'];
		if(isset($ioa_options['featured_video'])) $ioa_meta_data['featured_video'] = $ioa_options['featured_video'];

		

		if($ioa_meta_data['layout']=="left-sidebar" || $ioa_meta_data['layout'] == "right-sidebar" || $ioa_meta_data['layout'] == "sticky-right-sidebar" || $ioa_meta_data['layout'] == "sticky-left-sidebar")
		{
			$ioa_meta_data['width'] = 740;
			
		}

		$ioa_meta_data['single_portfolio_template']  =  $ioa_meta_data['ioa_custom_template'] = $ioa_meta_data['thumb_resize'] = $ioa_meta_data['post_extras'] = $ioa_meta_data['blogmeta_enable'] = $ioa_meta_data['posts_item_limit']  =  $ioa_meta_data['enable_thumbnail'] =  '';

		if(isset($ioa_options['single_portfolio_template']))  $ioa_meta_data['single_portfolio_template']  =  $ioa_options['single_portfolio_template'];
		if(isset($ioa_options['ioa_custom_template']))  $ioa_meta_data['ioa_custom_template'] = $ioa_options['ioa_custom_template'];
		if(isset($ioa_options['thumb_resize']))  $ioa_meta_data['thumb_resize'] = $ioa_options['thumb_resize'];
		if(isset($ioa_options['blog_metadata']))  $ioa_meta_data['post_extras'] = $ioa_options['blog_metadata'];
		if(isset($ioa_options['blogmeta_enable']))  $ioa_meta_data['blogmeta_enable'] = $ioa_options['blogmeta_enable'];
		if(isset($ioa_options['posts_item_limit']))  $ioa_meta_data['posts_item_limit']  =  $ioa_options['posts_item_limit'];
		if(isset($ioa_options['enable_thumbnail']))  $ioa_meta_data['enable_thumbnail'] =  $ioa_options['enable_thumbnail'];
		
		$ioa_meta_data['blog_excerpt'] = $ioa_meta_data['more_label'] = $ioa_meta_data['posts_excerpt_limit'] = '';

		if(isset($ioa_options['blog_excerpt']))  $ioa_meta_data['blog_excerpt'] =  $ioa_options['blog_excerpt'];
		if(isset($ioa_options['more_label']))  $ioa_meta_data['more_label'] =  $ioa_options['more_label'];
		if(isset($ioa_options['posts_excerpt_limit']))  $ioa_meta_data['posts_excerpt_limit'] =  $ioa_options['posts_excerpt_limit'];
		
		if($ioa_meta_data['posts_excerpt_limit']=="") $ioa_meta_data['posts_excerpt_limit'] = 150;

		$ioa_meta_data['query_filter'] = array();

		$ioa_meta_data['portfolio_item_limit']  =  $ioa_meta_data['portfolio_enable_thumbnail'] = '';

		if(isset($ioa_options['portfolio_item_limit']))  $ioa_meta_data['portfolio_item_limit']  =  $ioa_options['portfolio_item_limit'];
		if(isset($ioa_options['portfolio_enable_thumbnail']))  $ioa_meta_data['portfolio_enable_thumbnail'] =  $ioa_options['portfolio_enable_thumbnail'];
		if(isset($ioa_options['portfolio_enable_text']))  $ioa_meta_data['portfolio_enable_text'] =  $ioa_options['portfolio_enable_text'];

 
		$ioa_meta_data['portfolio_excerpt'] = $ioa_meta_data['portfolio_more_label'] = '';

		if(isset($ioa_options['portfolio_excerpt'])) $ioa_meta_data['portfolio_excerpt'] =  $ioa_options['portfolio_excerpt'];
		if(isset($ioa_options['portfolio_more_label'])) $ioa_meta_data['portfolio_more_label'] =  $ioa_options['portfolio_more_label'];
		
		if($ioa_meta_data['portfolio_more_label']=="") $ioa_meta_data['portfolio_more_label'] = "More";	
		if($ioa_meta_data['more_label']=="") $ioa_meta_data['more_label'] = "More";	

		if(isset($ioa_options['portfolio_excerpt_limit']))  $ioa_meta_data['portfolio_excerpt_limit'] =  $ioa_options['portfolio_excerpt_limit'];
		if(!isset($ioa_meta_data['portfolio_excerpt_limit']) || $ioa_meta_data['portfolio_excerpt_limit']=="") $ioa_meta_data['portfolio_excerpt_limit'] = 150;

		  if(isset($ioa_options['portfolio_image_resize'])) $ioa_meta_data['thumb_resize'] =  $ioa_options['portfolio_image_resize'];
      

		$ioa_meta_data['portfolio_query_filter'] = array();

		$query_s = $portfolio_query_s =  '';

		if(isset($ioa_options['query_filter']))  $query_s =  $ioa_options['query_filter'];
		if(isset($ioa_options['portfolio_query_filter']))  $portfolio_query_s =  $ioa_options['portfolio_query_filter'];

		if($query_s!="")
		{
			$gen = array();
			$query_s = explode("&",$query_s);
			foreach ($query_s as  $para) {
				$p = explode("=", $para); 

				if($para!="") $gen[$p[0]] = $p[1];		
				
			}
			$ioa_meta_data['query_filter'] = $gen;
		}

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


		
		
	}
   
   // == Custom Posts =====================

	function customPosts()
	{
		global $registered_posts,$portfolio_taxonomy_label,$portfolio_taxonomy,$ioa_portfolio_slug,$ioa_portfolio_name ;
		


	  $registered_posts["testimonial"] = new IOACustomPost("testimonial",array(),"", __("Testimonials", 'ioa'));	
	  $registered_posts[$ioa_portfolio_slug] = new IOACustomPost($ioa_portfolio_slug,array(),$portfolio_taxonomy_label,"$ioa_portfolio_name Items");	
	  $registered_posts["slider"] = new IOACustomPost("slider",array( 
	   				  'publicly_queryable' => false,
					  'show_ui' => false,
					  'exclude_from_search' => false,
					  'show_in_nav_menus' => false
					   ),"Slider Categories","Slider Items");
		$registered_posts["custompost"] =new IOACustomPost("custompost",array( 
	   				  'publicly_queryable' => false,
					  'show_ui' => false,
					  'exclude_from_search' => false,
					  'show_in_nav_menus' => false
					   ),"Categories","Custom Post Types");	
			
			
		

		$stack_custom = array();

		$custom_query = get_posts( array( "post_type" => "custompost" , "posts_per_page" => -1 ,  
			'cache_results' => false , 
			'no_found_rows' => true,
    		'update_post_term_cache' => false,
    		'update_post_meta_cache' => false,
    		'post_status' => 'publish'
			));  
	
		foreach( $custom_query as $post ) :  
			
			$metaboxes = get_post_meta($post->ID,'metaboxes',true);
			$coptions = get_post_meta($post->ID,'options',true);
			$post_type = str_replace(" ","_",strtolower(trim(get_the_Title($post->ID))));
			$opts = $this->getAssocMap($coptions,"value",true);
			
			$stack_custom[] = array ($metaboxes,$opts,$post_type);		
			
		endforeach;

		foreach ($stack_custom as $fs ) {
			$refine_meta = array();
			$tax ='' ;
			if(isset($fs[1]["taxonomies"]) && $fs[1]["taxonomies"]!="") $tax = $fs[1]["taxonomies"];	
			$registered_posts[$fs[2]] = new IOACustomPost($fs[2], array( 'labels' => $fs[1] ),$tax,"".ucwords($fs[2])." Items");	

			if( is_array($fs[0] ))
			{
				foreach ($fs[0] as  $metabox) {
					$temp = $this->getAssocMap($metabox,"value");
					$refine_meta[] = array(	"label" => $temp["meta_name"] , "name" => str_replace(" ","_",strtolower(trim($temp["meta_name"]))) , 	"default" => $temp["default"] , "type" =>  $temp["type"],	"description" => "" , "color"  =>  $temp["title_color"]);
				}

				new IOAMetaBox(array(
					"id" => "IOA_custom_values",
					"title" => __("Custom Fields", 'ioa'),
					"inputs" => $refine_meta,
					"post_type" => $fs[2],
					"context" => "advanced",
					"priority" => "low"
				));

			}
		}

	}

   // == Register Sidebars ===========================
  
  function initSidebars()
  {

  	$sidebars = array();

    $sidebars[] = array(
  		'name' => 'Blog Sidebar',
  		'id' => 'blog_sidebar',
  		'description' => __('This is the default sidebar for the theme', 'ioa'),
  		'before_widget' => '<div class="sidebar-wrap widget %2$s clearfix">',
  		'after_widget' => '</div><span class="widget-tail"></span>',
  		'before_title' => '<h3 class="custom-font heading">',
  		'after_title' => '</h3><span class="spacer"></span>'
	);

	
	$sidebars[] = array(
	  'name' =>  "Footer Mobile",
	  'id' => 'footer_mobile',
	  'description' => __('Widgets will be shown in the Footer for Mobile Devices.', 'ioa'),
	  'before_widget' => '<div class="footer-wrap widget %2$s clearfix">',
	  'after_widget' => '</div>',
	  'before_title' => '<h3 class="custom-font footer-heading">',
	  'after_title' => '</h3>'
	);
	
	
	
	
	if(function_exists('register_sidebar')){
		
		foreach($sidebars as $sidebar)
		register_sidebar($sidebar);
	
	} 
	
	 $this->registerDynamicFooter();

	  global $super_options;
	  $dynamic_active_sidebars = array();
	  
	 if( isset($super_options[SN."_custom_sidebars"]) ) 
	  $dynamic_active_sidebars = explode(',',$super_options[SN."_custom_sidebars"]);
	 
      
	  if( count($dynamic_active_sidebars ) >0 )
	  foreach($dynamic_active_sidebars as  $widget)
	  {
	  	if( $widget!="") {
		 $tid = strtolower ( str_replace(" ","_",trim($widget)) );
		 $temp_widget = array(
		
		'name' => $widget,
		'description' => __('This is a dynamic sidebar','ioa'),
		'before_widget' => '<div class="dynamic-wrap widget %2$s sidebar-wrap clearfix">',
		'after_widget' => '</div><span class="widget-tail"></span>',
		'before_title' => '<h3 class="custom-font heading">',
		'after_title' => '</h3><span class="spacer"></span>',
		'id' => 'sidebar_'.$tid
		);
	  register_sidebar($temp_widget);
	}
	  }
	  
  
  }
  
  // == Dynamic Footer =================================
  
	 
	 function registerDynamicFooter() {
		 
		 $footer_layout = get_option(SN."_footer_layout");
		
		 $count = 4;
		 switch($footer_layout)
		 {
			 case "two-col" : $count = 2 ; break;
			 case "three-col" : $count = 3 ; break;
			 case "four-col" : $count = 4 ; break;
			 case "five-col" : $count = 5 ; break;
			 case "six-col" : $count = 6 ; break;
			 case "one-third" : $count = 2 ; break;
			 case "one-fourth" : $count = 2 ; break;
			 case "one-fifth" : $count = 2 ; break;
			 case "one-sixth" : $count = 2 ; break;
			 default :  $count = 4;

		 }
		 
		for($i=1;$i<=$count;$i++)
		 {
		   $sidebar = array(
						'name' => ("Footer Column $i"),
						'id' => "footer_column_".$i ,
						'description' => __('Widgets will be shown in the footer.', 'ioa'),
						'before_widget' => '<div class="footer-wrap  %2$s clearfix">',
						'after_widget' => '</div>',
						'before_title' => '<h3 class="custom-font footer-heading">',
						'after_title' => '</h3><span class="spacer"></span>',
					  );	 
           
		   register_sidebar($sidebar);
		   
		 }
   }

    function getRating($val)
   {
   	$r = intval($val);
		$code ='' ;
		for($i=0;$i<5;$i++)
		{
			if($i < $r)
				$code .= '<li><i class="ioa-front-icon star-2icon- rated"></i></li>';
			else		
				$code .= '<li><i class="ioa-front-icon star-2icon- inactive"></i></li>';
		}
		return '<ul class="rating-bar clearfix">'.$code.'</ul>';
   }


   	public function breadcrumbs()
	{
		global $super_options,$ioa_portfolio_slug;
	 $delimiter = $super_options[SN."_breadcrumb_delimiter"];
 	 $portfolio_parent_link = $super_options[SN.'_portfolio_parent_link'];
 	 $blog_parent_link = $super_options[SN.'_blog_parent_link'];

 	 $blog_label = $super_options[SN.'_blog_label'];
 	 $portfolio_label = $super_options[SN.'_portfolio_blabel'];


			$name =  $super_options[SN."_breadcrumb_home_label"]; // text for the 'Home' link
			$currentBefore = ' <span class="current">';
			$currentAfter = '</span> ';
			$type=get_post_type();

			if(IOA_WOO_EXISTS && is_woocommerce()) {

				echo '<div id="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';	
				woocommerce_breadcrumb();
				echo '</div>';
			}
			else if( (function_exists('is_bbpress') && is_bbpress()) )
			{
				echo '<div id="breadcrumbs" class="clearfix"  itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';	
				bbp_breadcrumb(); 
				echo '</div>';
			}
			elseif (!is_home() && !is_front_page() && get_post_type() == $type || is_paged()) {

				echo '<div id="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
				global $post;
				$home = home_url('/');
				echo '<a href="' . $home . '"  itemprop="url"><span itemprop="title">' . $name . '</span></a> ' . $delimiter . ' ';
				if (is_category()) {
					global $wp_query;
					$cat_obj = $wp_query->get_queried_object();
					$thisCat = $cat_obj->term_id;
					$thisCat = get_category($thisCat);
					$parentCat = get_category($thisCat->parent);
					if ($thisCat->parent != 0) {
						echo(get_category_parents($parentCat, true, '' . $delimiter . ''));
					}
					echo $currentBefore . single_cat_title() . $currentAfter;
				}
				else if(is_tax())
				{
					echo $currentBefore . single_term_title() . $currentAfter;
				}
				else if (is_day()) {
					echo '<a href="' . get_year_link(get_the_time('Y')) . '"  itemprop="url"><span itemprop="title">' . get_the_time('Y') . '</span></a> ' . $delimiter . '';
					echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '"  itemprop="url"><span itemprop="title">' . get_the_time('F') . '</span></a> ' . $delimiter . ' ';
					echo $currentBefore . get_the_time('d') . $currentAfter;
				} else if (is_month()) {
					echo '<a href="' . get_year_link(get_the_time('Y')) . '"  itemprop="url"><span itemprop="title">' . get_the_time('Y') . '</span></a> ' . $delimiter . '';
					echo $currentBefore . get_the_time('F') . $currentAfter;
				} else if (is_year()) {
					echo $currentBefore . get_the_time('Y') . $currentAfter;
				} else if (is_attachment()) {
					echo $currentBefore;
					the_title();
					$currentAfter;
				} if (is_single()  ){
					$cat = null;
					if($post->post_type=="post") {	

						if(trim($blog_parent_link)!="")
						{
							echo "<a href='". $blog_parent_link ."'  itemprop='url'><span itemprop=\"title\">".$blog_label."</span></a> ". $delimiter . ' ';
						}	
						else
						{
							$cat = get_the_category();
							$cat = $cat[0];
							if ($cat !==NULL) {
								echo get_category_parents($cat, true, ' ' . $delimiter . '');
							}

						}
					
					}
					else if($post->post_type==$ioa_portfolio_slug && $portfolio_parent_link!="")
					{
						echo "<a href='". $portfolio_parent_link ."'  itemprop='url'><span itemprop=\"title\">".$portfolio_label."</span></a> ". $delimiter . ' ';
					
					}
					else
					{
						
						
					$taxonomies = get_object_taxonomies($post, 'names');

					if(count($taxonomies) > 0) :
						$cats =   get_the_terms($post->ID,$taxonomies[0]); 
						$cat = false; $i=0; 
						
						if($cats)
						foreach ($cats as $c) {
							 if($i==0)
							 {
							 	$cat = $c; $i++;
							 }
							 else break;
						}

						

					endif;


					}

					

					echo $currentBefore;
					the_title();
					echo $currentAfter;


				}
				else if (is_page() && !$post->post_parent) {
					echo $currentBefore;
					the_title();
					echo $currentAfter;
				} else if (is_page() && $post->post_parent) {
					$parent_id = $post->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '"  itemprop="url"><span itemprop="title">' . get_the_title($page->ID) . '</span></a>';
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					foreach($breadcrumbs as $crumb)
					echo $crumb . ' ' . $delimiter . ' ';
					echo $currentBefore;
					the_title();
					echo $currentAfter;
				} else if (is_search()) {
					echo $currentBefore . __('Search Results For:','ioa') . ' ' . get_search_query() . $currentAfter;
				} else if (is_tag()) {
					echo $currentBefore . single_tag_title() . $currentAfter;
				} else if (is_author()) {
					global $author;
					$userdata = get_userdata($author);
					echo $currentBefore . $userdata->display_name . $currentAfter;
				} else if (is_404()) {
					echo $currentBefore . __('404 Not Found', 'ioa') . $currentAfter;
				}
				if (get_query_var('paged')) {
					if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
						echo  $currentBefore;
					}
					echo __('Page','ioa') . ' ' . get_query_var('paged');
					if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
						echo $currentAfter;
					}
				}
				echo '</div>';
			}
		}



	    
   function RADBaseStyler()
		{

			global $post,$ioa_meta_data,$radunits;
			
			if( !is_singular() ) return;
			
			$styler_code = '';

			$responsive_view = array(
						'Screen' => array( 'el' => array() , 'query' => '@media (min-width:1024px)' ),
						'iPad Horizontal'=>  array( 'el' => array() , 'query' => '@media (min-width: 768px) and (max-width: 1024px)' ),
						'iPad Vertical & Small Tablets'=>  array( 'el' => array() , 'query' => '@media only screen and (min-width: 768px) and (max-width: 979px)' ),
						'Mobile Landscape'=>  array( 'el' => array() , 'query' => '@media only screen and (min-width: 480px) and (max-width: 767px) ' ),
						'Mobile Potrait'=>  array( 'el' => array() , 'query' => ' @media only screen and (max-width: 479px)' ),
						);
				

			if(isset($ioa_meta_data['rad_data']) && is_array($ioa_meta_data['rad_data'])) : foreach($ioa_meta_data['rad_data'] as $section) : 
				$sc ='';
				$d = array();

				if(isset($section['data']))
				$d = $section['data'];
				$view_test = array();

				if(isset($d['visibility']))
				$view_test = explode(';',$d['visibility']);
				foreach ($view_test as $key => $pkey) {
					
					if(isset($responsive_view[$pkey]))
					{
						$responsive_view[$pkey]['el'][] = '#'.$section['id'];
					}

				}

				if(!is_array($section['data']) ) $d = json_decode($section['data'],true);

				$d = $this->getAssocMap($d,'value');

				if( isset($d['ov_use']) && $d['ov_use']=="yes")
				{
					$ov = '';
					$styler_code .= "#".$section['id']." .section-overlay{   ";
					$styler_code.= "opacity:".(intval($d['ov_opacity'])/100).";";	
					$styler_code.= "background:url(".$d['ov_background_image'].") ".$d['ov_background_position']." ".$d['ov_background_repeat']." ".$d['ov_background_attachment']." ".$d['ov_background_color'].";;background-size:".$d['ov_background_cover']." ";
					

					if($d['ov_use_gradient_dir']=='yes') :
						$iefix = 0;
						$dir_gr ='top';
						$end_gr = $d['ov_end_gr'];
						$start_gr = $d['ov_start_gr'];
						switch($d['ov_background_gradient_dir'])
						{
							case "vertical" : $dir_gr = "top"; break;
							case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
							case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
							case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
						}	
								
						$styler_code .= "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

					endif;

					$styler_code .= "}";


				}

				if(isset($d['v_padding']) && $d['v_padding']!=""  && $d['v_padding']!="0") $sc = "padding: ".$d['v_padding']."px 0px;";

				if(isset($d['background_opts']))
				switch ($d['background_opts']) {
					case 'bg-color': 
									 $rgb = hex2RGB($d['background_color']);
									 if(isset($d['bg_opacity']) && $d['bg_opacity']!="") :
										 $op= $d['bg_opacity'];
										 if($op=="") $op = 100;
										 $op = $op/100;
										 $sc.= "background:rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.");";
									 else:	
									 	$sc.= "background:rgb(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].");";
									 endif;
									 	 
									 break;
					case 'bg-image': $sc.= "background:url(".$d['background_image'].") top left ".$d['background_attachment'].";background-size:cover;"; break;
					case 'bg-texture': $sc.= "background:url(".$d['background_image'].") ".$d['background_position']." ".$d['background_repeat']." ".$d['background_attachment'].";"; break;
					case 'custom': $sc.= "background-color:".$d['background_color'].";background:url(".$d['background_image'].") ".$d['background_position']." ".$d['background_repeat']." ".$d['background_attachment'].";background-size:".$d['background_cover'].";"; break;
					case 'bg-gr': 
					
					$iefix = 0;
					$dir_gr ='top';
					$end_gr = $d['end_gr'];
					$start_gr = $d['start_gr'];
					switch($d['background_gradient_dir'])
					{
						case "vertical" : $dir_gr = "top"; break;
						case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
						case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
						case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
					}	
							
					$code = "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

					$sc.= $code; 
					break;
					
				}

				if( isset($d['border_top_width']) && $d['border_top_width']!="" && $d['border_top_width']!="0")
				{
					$op = 1;
					if(isset($d['border_top_opacity'])) $op = $d['border_top_opacity']/100;
					$rgb = hex2RGB($d['border_top_color']);

					$color = "rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.")";
					$sc .= "border-top:".$d['border_top_width']."px ".$d['border_top_type']." ".$color.";";
				}	
				if( isset($d['border_bottom_width']) && $d['border_bottom_width']!="" && $d['border_bottom_width']!="0")
				{
					$op = 1;
					if(isset($d['border_bottom_opacity'])) $op = $d['border_bottom_opacity']/100;
					$rgb = hex2RGB($d['border_bottom_color']);

					$color = "rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.")";
					$sc .= "border-bottom:".$d['border_bottom_width']."px ".$d['border_bottom_type']." ".$color.";";
				}	

				if(trim($sc)!="")
				$styler_code .= "#".$section['id']."{ $sc  }";

				if( isset($section['containers']) )
				foreach ($section['containers'] as $key => $container) {
					$sc = '';
					$c = $container['data'];
					if( !is_array($container['data']) ) $c = json_decode($container['data'],true);
					$c = $this->getAssocMap($c,'value');

					if(isset($c['background_opts']))
					switch ($c['background_opts']) {
						case 'bg-color': $rgb = hex2RGB($c['background_color']);
										 $op= $c['background_opacity'];
										 if($op=="") $op = 1;
										 $sc.= "background:rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.");"; break;
						case 'bg-image': $sc.= "background:url(".$c['background_image'].") top left ".$c['background_attachment'].";background-size:cover;"; break;
						case 'bg-texture': $sc.= "background:url(".$c['background_image'].") ".$c['background_position']." ".$c['background_repeat']." ".$c['background_attachment'].";"; break;
						case 'custom': $sc.= "background-color:".$c['background_color'].";background:url(".$c['background_image'].") ".$c['background_position']." ".$c['background_repeat']." ".$c['background_attachment'].";background-size:".$c['background_cover'].";"; break;
						case 'bg-gr': 
						
						$iefix = 0;
						$dir_gr ='top';
						$end_gr = $c['end_gr'];
						$start_gr = $c['start_gr'];
						switch($c['background_gradient_dir'])
						{
							case "vertical" : $dir_gr = "top"; break;
							case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
							case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
							case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
						}	
								
						$code = "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

						$sc.= $code; 
						break;
						
					}

					if( isset($c['border_top_width']) && $c['border_top_width']!="" && $c['border_top_width']!="0")
						$sc .= "border-top:".$c['border_top_width']."px ".$c['border_top_type']." ".$c['border_top_color'].";";
					if(isset($c['border_bottom_width']) && $c['border_bottom_width']!="" && $c['border_bottom_width']!="0")
						$sc .= "border-bottom:".$c['border_bottom_width']."px ".$c['border_bottom_type']." ".$c['border_bottom_color'].";";

					if( isset($c['use_margin']) && $c['use_margin']=='yes')
						$sc.="margin-top:".$c['margin_top']."px;margin-bottom:".$c['margin_bottom']."px;";

					if(trim($sc)!="" && isset($container['id']))
					$styler_code .= "#".$container['id']."{ $sc  } ";
					$view_test = array();

					if(isset($c['visibility']))
					$view_test = explode(';',$c['visibility']);
					foreach ($view_test as $key => $pkey) {
						
						if(isset($responsive_view[$pkey]))
						{
							$responsive_view[$pkey]['el'][] = '#'.$container['id'];
						}

					}

					$widgets = array();
					if(isset($container['widgets'])) $widgets = $container['widgets'];

					foreach ($widgets as $key => $widget) {
						if( isset($radunits[str_replace('-','_',$widget['type'])]) ) :


						$widget_data = $widget['data'];

						if(!is_array($widget['data']) ) $widget_data = json_decode($widget['data'],true);

						$widget_data = $this->getAssocMap($widget_data,'value');
						
						$keys  = $radunits[str_replace('-','_',$widget['type'])]->getStyleKeys();

						 foreach ($keys as $key => $field) {
						 	if( isset($widget_data[$field['name']]) && trim($widget_data[$field['name']])!="" )
						 	{
						 		$v = $widget_data[$field['name']];
						 		$d = $field['data'];

						 		if($field['type']=='slider') $v .= $field['suffix'];

						 		if($v!="" || $v!="0" || $v!="0px")
						 		$styler_code .= ' #'.$widget['id'].' '.$d['target'].' { '.$d['property'].' : '.$v.' }';
						 		if( isset($d['extra_cl']) )
						 		{
						 			foreach ($d['extra_cl'] as $key => $value) {
						 					$styler_code .= ' #'.$widget['id'].' '.$key.' { '.$value.' : '.$v.'!important }';
						 			}
						 		}
						 	}
						 }

						 endif;

					}

				}
			endforeach; endif; 

			foreach($responsive_view as $view)
			{
				$styler_code .= " ".$view['query']." { ".join(',',$view['el'])." { display:none; } } ";
			}

			echo "<style type='text/css' id='rad_styler'> $styler_code </style>";

		}
	    
   function RADStyler()
		{

			global $post,$ioa_meta_data,$radunits;
			
			if( !is_singular() ) return;
			

			$styler_code = '';
			$responsive_view = array(
						'Screen' => array( 'el' => array() , 'query' => '@media (min-width:1024px)' ),
						'iPad Horizontal'=>  array( 'el' => array() , 'query' => '@media (min-width: 768px) and (max-width: 1024px)' ),
						'iPad Vertical & Small Tablets'=>  array( 'el' => array() , 'query' => '@media only screen and (min-width: 768px) and (max-width: 979px)' ),
						'Mobile Landscape'=>  array( 'el' => array() , 'query' => '@media only screen and (min-width: 480px) and (max-width: 767px) ' ),
						'Mobile Potrait'=>  array( 'el' => array() , 'query' => ' @media only screen and (max-width: 479px)' ),
						);
				

			$rad_styles = get_post_meta( get_the_ID(), '_style_keys', true );
			
			if( get_post_meta( $post->ID, '_style_keys', true ) == "" && is_array($ioa_meta_data['rad_data']))	 
			{
				$this->RADBaseStyler();
				return;
			}

			$rad_styles =  json_decode(urldecode(str_replace('[p]','%',$rad_styles)),true);
			
			if($rad_styles!="")
			foreach($rad_styles as $k => $element) : 
					
				switch($element['key'])
				{
					case 'rad_page_section' :
							$sc = '';
							$d = array();

							if(isset($element['data']))
							$d = $element['data'];

							$d = $this->getAssocMap($d,'value'); 

							if(isset($d['visibility']))
							{
								$view_test = explode(';',$d['visibility']);
								foreach ($view_test as $key => $pkey) {
									
									if(isset($responsive_view[$pkey]))
									{
										$responsive_view[$pkey]['el'][] = '#'.$k;
									}

								}
							}

							if( isset($d['ov_use']) && $d['ov_use']=="yes")
							{
								$ov = '';
								$styler_code .= "#".$k." .section-overlay{   ";
								$styler_code.= "opacity:".(intval($d['ov_opacity'])/100).";";	
								$styler_code.= "background:url(".$d['ov_background_image'].") ".$d['ov_background_position']." ".$d['ov_background_repeat']." ".$d['ov_background_attachment']." ".$d['ov_background_color'].";;background-size:".$d['ov_background_cover']." ";
								

								if($d['ov_use_gradient_dir']=='yes') :
									$iefix = 0;
									$dir_gr ='top';
									$end_gr = $d['ov_end_gr'];
									$start_gr = $d['ov_start_gr'];
									switch($d['ov_background_gradient_dir'])
									{
										case "vertical" : $dir_gr = "top"; break;
										case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
										case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
										case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
									}	
											
									$styler_code .= "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

								endif;

								$styler_code .= "}";


							}

							if(isset($d['v_padding_top']) && $d['v_padding_top']!=""  && $d['v_padding_top']!="0") $sc = "padding-top: ".$d['v_padding_top']."px;";
							if(isset($d['v_padding']) && $d['v_padding']!=""  && $d['v_padding']!="0") $sc = "padding: ".$d['v_padding']."px 0px;";
							if(isset($d['v_padding_bottom']) && $d['v_padding_bottom']!="" && $d['v_padding_bottom']!="0") $sc .= "padding-bottom: ".$d['v_padding_bottom']."px;";

							if(isset($d['background_opts']))
							switch ($d['background_opts']) {
								case 'bg-color': 
												 $rgb = hex2RGB($d['background_color']);
												 if(isset($d['bg_opacity']) && $d['bg_opacity']!="") :
													 $op= $d['bg_opacity'];
													 if($op=="") $op = 100;
													 $op = $op/100;
													 $sc.= "background:rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.");";
												 else:	
												 	$sc.= "background:rgb(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].");";
												 endif;
												 	 
												 break;
								case 'bg-image': $sc.= "background:url(".$d['background_image'].") top left ".$d['background_attachment'].";background-size:cover;"; break;
								case 'parallax': $sc.= "background:url(".$d['background_image'].") top center fixed;background-size:cover;"; break;
								case 'bg-texture': $sc.= "background:url(".$d['background_image'].") ".$d['background_position']." ".$d['background_repeat']." ".$d['background_attachment'].";"; break;
								case 'custom': $sc.= "background-color:".$d['background_color'].";background:url(".$d['background_image'].") ".$d['background_position']." ".$d['background_repeat']." ".$d['background_attachment'].";background-size:".$d['background_cover'].";"; break;
								case 'bg-gr': 
								
								$iefix = 0;
								$dir_gr ='top';
								$end_gr = $d['end_gr'];
								$start_gr = $d['start_gr'];
								switch($d['background_gradient_dir'])
								{
									case "vertical" : $dir_gr = "top"; break;
									case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
									case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
									case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
								}	
										
								$code = "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

								$sc.= $code; 
								break;
								
							}

							if( isset($d['border_top_width']) && $d['border_top_width']!="" && $d['border_top_width']!="0")
							{
								$op = 1;
								if(isset($d['border_top_opacity'])) $op = $d['border_top_opacity']/100;
								$rgb = hex2RGB($d['border_top_color']);

								$color = "rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.")";
								$sc .= "border-top:".$d['border_top_width']."px ".$d['border_top_type']." ".$color.";";
							}	
							if( isset($d['border_bottom_width']) && $d['border_bottom_width']!="" && $d['border_bottom_width']!="0")
							{
								$op = 1;
								if(isset($d['border_bottom_opacity'])) $op = $d['border_bottom_opacity']/100;
								$rgb = hex2RGB($d['border_bottom_color']);

								$color = "rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.")";
								$sc .= "border-bottom:".$d['border_bottom_width']."px ".$d['border_bottom_type']." ".$color.";";
							}	

							if(trim($sc)!="")
							$styler_code .= "#".$k."{ $sc  }";

						break;
					case 'rad_page_container' :
						

						$sc = '';
						$c = $element['data'];
						
						$c = $this->getAssocMap($c,'value');
						if(isset($c['background_opts'])) :

						switch ($c['background_opts']) {
							case 'bg-color': $rgb = hex2RGB($c['background_color']);
											 $op= $c['background_opacity'];
											 if($op=="") $op = 1;
											 $sc.= "background:rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.");"; break;
							case 'bg-image': $sc.= "background:url(".$c['background_image'].") top left ".$c['background_attachment'].";background-size:cover;"; break;
							case 'bg-texture': $sc.= "background:url(".$c['background_image'].") ".$c['background_position']." ".$c['background_repeat']." ".$c['background_attachment'].";"; break;
							case 'custom': $sc.= "background-color:".$c['background_color'].";background:url(".$c['background_image'].") ".$c['background_position']." ".$c['background_repeat']." ".$c['background_attachment'].";background-size:".$c['background_cover'].";"; break;
							case 'bg-gr': 
							
							$iefix = 0;
							$dir_gr ='top';
							$end_gr = $c['end_gr'];
							$start_gr = $c['start_gr'];
							switch($c['background_gradient_dir'])
							{
								case "vertical" : $dir_gr = "top"; break;
								case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
								case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
								case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
							}	
									
							$code = "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

							$sc.= $code; 
							break;
							
						}
						endif;

						if( isset($c['border_top_width']) && $c['border_top_width']!="" && $c['border_top_width']!="0")
							$sc .= "border-top:".$c['border_top_width']."px ".$c['border_top_type']." ".$c['border_top_color'].";";
						if( isset($c['border_bottom_width']) && $c['border_bottom_width']!="" && $c['border_bottom_width']!="0")
							$sc .= "border-bottom:".$c['border_bottom_width']."px ".$c['border_bottom_type']." ".$c['border_bottom_color'].";";

						if( isset($c['use_margin']) && $c['use_margin']=='yes' && $c['margin_top']!="" && $c['margin_top']!="0")
							$sc.="margin-top:".$c['margin_top']."px;";

					    if( isset($c['use_margin']) && $c['use_margin']=='yes' && $c['margin_bottom']!="" && $c['margin_bottom']!="0")
							$sc.="margin-bottom:".$c['margin_bottom']."px;";

						if(trim($sc)!="" )
						$styler_code .= "#".$k."{ $sc  } ";

						$view_test = array();

						if(isset($c['visibility']))
						{
							$view_test = explode(';',$c['visibility']);
							foreach ($view_test as $key => $pkey) {
								
								if(isset($responsive_view[$pkey]))
								{
									$responsive_view[$pkey]['el'][] = '#'.$k;
								}

							}
						}

					break;	
					default : 
								$widget_data = $element['data'];
								$widget_data = $this->getAssocMap($widget_data,'value');
									
								$keys  = $radunits[str_replace('-','_',$element['key'])]->getStyleKeys();

								foreach ($keys as $key => $field) {
								 	if( isset($widget_data[$field['name']]) && trim($widget_data[$field['name']])!="" )
								 	{
								 		$v = $widget_data[$field['name']];
								 		$d = $field['data'];

								 		if($field['type']=='slider') $v .= $field['suffix'];

								 		if($v!="" || $v!="0" || $v!="0px")
								 		$styler_code .= ' #'.$k.' '.$d['target'].' { '.$d['property'].' : '.$v.' }';
								 		if( isset($d['extra_cl']) )
								 		{
								 			foreach ($d['extra_cl'] as $key => $value) {
								 					$styler_code .= ' #'.$k.' '.$key.' { '.$value.' : '.$v.'!important }';
								 			}
								 		}
								 	}
								 }
					break;			 
				}

			endforeach; 

			$page_css = get_post_meta( get_the_ID() , 'rad_custom_css', true );

			$styler_code .= " ".$page_css;

			foreach($responsive_view as $view)
				{
					$styler_code .= " ".$view['query']." { ".join(',',$view['el'])." { display:none; } } ";
				}

			echo "<style type='text/css' id='rad_styler'> $styler_code </style>";

		}


   public function registerScripts()
	{

		if( IOA_WOO_EXISTS  )
		add_action( 'wp_enqueue_scripts', 'fc_remove_woo_lightbox', 99 );
		function fc_remove_woo_lightbox() {
		    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
		        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		        wp_dequeue_script( 'prettyPhoto' );
		        wp_dequeue_script( 'prettyPhoto-init' );
		}
		

		function addThemeStyles() { 
			global $enigma_runtime,$super_options;

			/**
			  *  WP Inbuilt Scripts
			  */

			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('jquery-ui-accordion');
			wp_enqueue_script('jquery-color');
			wp_enqueue_script('wp-mediaelement');

			/**
			*
			* External Scripts
			*
			**/
			
			
			wp_enqueue_script('ext-js',URL.'/sprites/js/ext.js');
			wp_enqueue_script('jquery-bxslider',URL.'/sprites/js/jquery.bxslider.min.js');
			wp_enqueue_script('jquery-isotope',URL.'/sprites/js/jquery.isotope.min.js');
			wp_enqueue_script('jquery-prettyphoto',URL.'/sprites/js/jquery.prettyPhoto.js');
			wp_enqueue_script('jquery-transit',URL.'/sprites/js/jquery.transit.min.js');
			
			wp_enqueue_script('selene',URL.'/sprites/js/jquery.selene.js');
			wp_enqueue_script('quartz',URL.'/sprites/js/jquery.quartz.js');
			
			wp_enqueue_script('custom',URL.'/sprites/js/custom.js');

			$translation_array = array( 
				'search_placeholder' => __('Type something..','ioa'),

			  );
		
		wp_localize_script( 'custom', 'ioa_localize', $translation_array );


			/**
			*
			* CSS Files
			*
			**/
			

			wp_enqueue_style('base',URL.'/sprites/stylesheets/base.css');
			wp_enqueue_style('layout',URL.'/sprites/stylesheets/layout.css');
			wp_enqueue_style('widgets',URL.'/sprites/stylesheets/widgets.css');
			wp_enqueue_style('style',CHURL.'/style.css');

			if(IOA_WOO_EXISTS )
			wp_enqueue_style('ioa-woocom',URL.'/sprites/stylesheets/woocommerce.css');

			if( (function_exists('is_bbpress') && is_bbpress()) )
				wp_enqueue_style('forums',URL.'/sprites/stylesheets/forums.css');
			
			if($super_options[SN.'_mobile_view']!="false")
				wp_enqueue_style('responsive',URL.'/sprites/stylesheets/responsive.css');
			
			  wp_enqueue_style('runtime-css', admin_url('admin-ajax.php?action=ioalistener&type=runtime_css'), array() );

			
		}

		 
		 function addAdminScripts() {
			

			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script('jquery-ui-accordion');
			wp_enqueue_script('jquery-minicolorpicker',HURL.'/js/jquery.minicolors.js');
			wp_enqueue_script('jquery-ext',HURL.'/js/ext.js');
			wp_enqueue_script('jquery-transit',URL.'/sprites/js/jquery.transit.min.js');
			
			wp_enqueue_script('jquery-intro',HURL.'/js/intro.min.js');
			
			wp_enqueue_style('global-css',HURL.'/css/global.css');

			$url = parse_url( $_SERVER['PHP_SELF']);	
			$url = explode("wp-admin/", $url['path']);
			
			if(  basename($url[1]) !='customize.php' )
			wp_enqueue_script('jquery-global',HURL.'/js/global.js');

			if( ( isset($url[1]) && basename($url[1]) == "widgets.php" ) || (  isset($_GET['page']) && ( $_GET['page'] == "ioa" || $_GET['page'] == "ioamed"  ) )  )
			wp_enqueue_media();
		
			}
		
				
			add_action('wp_enqueue_scripts','addThemeStyles');	
        			add_action('admin_enqueue_scripts','addAdminScripts');	 
		
				

				
	}	
  // == Image Display ======================================
 
 
 public function imageDisplay( $ioa_options )
	{
	  global $super_options;
	  extract( array_merge(  array( "src" => NULL , "crop"=> 'hard', "height" => 300 , "width" => 600 , "lightbox" => false , 'parent_wrap' => true , "hoverable" => false , "advance_query" => false , "gallery" => false  , "link" =>'' , "title" => ''  , 'class' => '', 'imageAttr' => '' , 'imgclass' => '' ) ,$ioa_options ) );
	  $o_src =  $src;
	
	    
	  $rel = '';
	  
	  if($imageAttr=='') $imageAttr=' alt="image" ';
	  if($hoverable)	$hoverable = '<span class="hover-image"> <small></small> </span>';
	  if($lightbox) {  $link = $o_src;  $lightbox = 'lightbox'; } 
	  if($gallery)    $rel = 'rel=prettyPhoto[pp_gal]';
	  $retina_image = array("url"=>'');	
	  
	  //if($super_options[SN.'_retina_enable']=="true")
	  //$retina_image = " data-at2x='".$this->wp_resize(NULL,$src,$width*2,$height*2,$crop)."'";
		
		$cr_img = $this->wp_resize(NULL,$src,$width,$height,$crop);
		

		$image = "  $hoverable  <img itemprop='image'  $imageAttr class='".$imgclass."' src='".$cr_img['url']."' width='".$cr_img['width']."' height='".$cr_img['height']."' ".$retina_image['url']."  />";
	
	  if($parent_wrap) $image = "<a href='$link' class='$lightbox imageholder $class' title='$title'> $image </a>";		 				 
			 
	  return $image;
	}
	
 
 
 // == WP Core resizer ==================
	
	 public function wp_resize($attach_id = null, $img_url = null, $width, $height, $crop = 'hard') {

	$src = $this->getMUFix($img_url); 
	
    if($src){

        $file_path = parse_url($src);
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

        $orig_size = @getimagesize($file_path);

        $image_src[0] = $img_url;
        $image_src[1] = $orig_size[0];
        $image_src[2] = $orig_size[1];
    }
 
    if(!isset($file_path) || $file_path== "")
    {
    	return $vt_image = array (
            'url' => $img_url,
            'width' => $width,
            'height' => $height
        );


    }

    if( $height > $orig_size[1] )
    {
    	return $vt_image = array (
            'url' => $img_url,
            'width' => $orig_size[0],
            'height' => $orig_size[1]
        );


    }
  
    $file_info = pathinfo($file_path);
    $extension = '.'. $file_info['extension'];

    // the image path without the extension
    $no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];


    if($crop=='proportional')
    {
    	$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
    	$width = $proportional_size[0];
    	$height = $proportional_size[1];

    }
    if($crop=='wproportional')
    {
    	
    	
    	$height = intval($image_src[2] * ( $width / $image_src[1] ));

    }
    if($crop=='hproportional')
    {
    	
    	
    	$width = intval($image_src[1] * ( $height / $image_src[2] ));

    }
     if($crop=='wproportional-max')
    {
    	if( $width > $image_src[1]   )
    	$width = $image_src[1];	
    	$height = intval($image_src[2] * ( $width / $image_src[1] ) );
    }

    $cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
  
	if ( file_exists($cropped_img_path) )
	{
		
		$new_img = str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);
		
		$vt_image = array (
            'url' => $new_img,
            'width' => $width,
            'height' => $height
        );

        return $vt_image;
	}
   
        // no cache files - let's finally resize it
        $new_img_path = null;
		if(  function_exists('wp_get_image_editor')) {

			$editor = wp_get_image_editor($file_path);

			if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) ) return $img_url ;

			$resized_file = $editor->save();
              
			
			  
			if(!is_wp_error($resized_file)) {
			 $new_img_path	= $resized_file['path'];
				
			} else {
				return false;
			}

		}
		
        $new_img_size = getimagesize($new_img_path);
        $new_img = str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);

        // resized output
        $vt_image = array (
            'url' => $new_img,
            'width' => $new_img_size[0],
            'height' => $new_img_size[1]
        );

        return $vt_image;
  

}	
 
 // == MU Fix ===================================
	
	public function getMUFix($src){
	   
	   global $super_options,$blog_id;
	  
	  if ( is_multisite() ) {

	  $image = $src;
	 
		$current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
	 	$site = $current_blog_details->siteurl;
	 	$master = $current_blog_details->domain;
	    $image = str_replace($site,$master,$image);
	    
	    if(is_ssl()) $image = 'https://'.$image; else $image = 'http://'.$image;

	    return $image;
	
	 }		  
	return  $src;		
	 
		}   
 
	public function getShortenContent($count , $content) {
	
		$excerpt = $content;
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, $count);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = $excerpt.'... ';
		return $excerpt;
	}
 
  // IOA Query string to Array
  
  public function ioaquery($query_string)
  {

  	$ioa_query = str_replace("&amp;","&", $query_string);
    $qr = explode('&',$ioa_query);
    $custom_tax = array();
    $filter = array();

	 foreach($qr as $q)
	 {
	  if(trim($q)!="")
	  {
	    $temp = explode("=",$q);
	    $filter[$temp[0]] = $temp[1];
	    if($temp[0]=="tax_query")
	    {
	      $vals = explode("|",$temp[1]);  
	      $custom_tax[] = array(
	          'taxonomy' => $vals[0],
	      'field' => 'id',
	      'terms' => explode(",", $vals[1])

	        );
	    }
	  }
	 }

     $custom_tax[] = array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                    'operator' => 'NOT IN'
                  );
     $filter['tax_query'] = $custom_tax;
     return $filter;

  }	


  function getHover($opts = array( 'format' => 'default' ))
	{
		$link = '';
		$image = '';
		$bg = '';
		$c = '';

		if(isset($opts['custom_link'])) $link = $opts['custom_link'];
		if(isset($opts['image'])) $image = $opts['image'];
		if(isset($opts['link'])) $link = $opts['link'];


		if(isset($opts['bg'])) $bg = $opts['bg'];
		if(isset($opts['c'])) $c = $opts['c'];



		switch($opts['format'])
		{
			
			case 'image' :  ?>
				 <a class="hover" itemprop='url' href="<?php echo $image; ?>" <?php if($bg!='') echo "style='background:$bg'" ?>  rel='prettyPhoto[pp_gal]'> 
				 		<i title="<?php the_title() ?>" <?php echo "style='color:$bg;background:$c;'" ?> class="hover-lightbox lightbox ioa-front-icon resize-full-2icon-"></i>
				 </a>	
				<?php
			break;
			case 'link' : ?>
				<a class="hover" itemprop='url' href="<?php echo $link; ?>" <?php if($bg!='') echo "style='background:$bg'" ?>>  
						<i <?php echo "style='color:$bg;background:$c;'" ?> class="hover-link ioa-front-icon hover-link link-3icon-"></i>
				</a>  	
				<?php
			break;
			

		}
		
	}

  // == Register Menus =====================================================	  
	
 public function registerMenus($menus)
	{
		

		  if ( function_exists( 'register_nav_menus' ) ) {
			 
			  register_nav_menus($menus);
		  }
	}

 // == Convert RAD inputs to assoctive Array
 
 function getAssocMap($inputs,$key,$noempty=false)
 {
 	$arr = array();
 	if(is_array($inputs))
 	{
 		foreach($inputs as $input)
		{
			if(isset( $input[$key]))
				{
					if( $noempty)
						{
							if(trim( $input[$key])!="" && isset($input['name']))
							$arr[$input['name']] =   stripslashes($input[$key]);
						}
					else
					{
						if(isset($input['name']))
						if(isset($input['name'])) $arr[$input['name']] =    stripslashes($input[$key]);
					}	
				}
			else
			{
			if(isset($input['name']))	
			$arr[$input['name']] =   false;	
			}	
		}
 	}
	return $arr;	
 }	
 
 // == Set Post Title ==========================

 function setPostTitle($title,$id)
 {
 	global $wpdb;


   $table_name = $wpdb->prefix . "posts";
   
   $alter_title = "UPDATE  $table_name SET post_title = '{$title}' WHERE ID = {$id} ";
   $wpdb->query($alter_title);
	  
 }

  // == Custom Formatter ======================
   
   public function format($content,$strip_tags = false,$shortcode=true,$autop=true,$strip_p=false){
	    $content = 	stripslashes($content);
	    
		if($shortcode) $content = do_shortcode( $content  ); 
	  
	   if($strip_tags) $content = strip_tags($content);
	   if($autop) $content =  wptexturize(wpautop($content)); 
	   
	   if($strip_p)
	   {
	   
	   	$content= str_replace('<p>','',$content);
	   	$content= str_replace('</p>','',$content);
	   }			 
	   return $content;
	   
	   }	

// == Pretty Print =========

function prettyPrint($obj)
{
	echo "<pre>";
	print_r($obj);
	echo "</pre>";
}	   
		  
} // End of Class

}

$helper = new Helper();


/**
 * Third Party Functions
 */

function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
} 

function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}


/**
 * Custom Theme Functions for Checking etc
 */

function IOATour()
{
	global $current_user,$themename;
	$url="http://support.artillegence.com/";
	?>
	
	<div class="ioa-tour-overlay">
		
		

	</div>

	<div class="ioa-tour-lightbox">
			<a href="" class="close ioa-front-icon  cancel-2icon-"></a>
			<div class="ioa-tour-body clearfix">
				<div class="heading-area">
					<h2> <?php printf( __("Hey %s",'ioa'), $current_user->user_login ); ?></h2>
					<p><?php printf( __("This is your first time using %s, Here is a quick guide to set things up. Please be sure to activate the plugins before running the installer else all settings won't be imported !",'ioa') , "<strong>  $themename </strong>" ) ?></p>	
				</div>	
				
				<ul class="ioa-tour-feature-list  clearfix">
					<li class='plugins-panel clearfix'>
						<span class="no">1</span> <?php printf( __("There are certain %1s that have to be activated before running installer and to enjoy full power of limitless. Don't worry you dont need to goto any where to get them.Click the Button below and theme will do it for you",'ioa') , "<strong>".__('plugins','ioa')."</strong>" ); ?>
						<a href="<?php echo admin_url(); ?>themes.php?page=install-required-plugins" class='more-link'><?php _e('Click Here','ioa') ?></a>				
					</li>

					<li class='installer-panel '>
						<span class="no">2</span> <?php printf( __("If this is a %1s	, you can use Installer to set up website in matter seconds. It will setup the site exactly as demo %2s The images seen on the demo, instead a dummy image will be placed.",'ioa'), "<strong>".__('fresh WordPress Installation','ioa')."</strong>" , '<strong>*'.__("excluding",'ioa').'*</strong>' ) ?>
						Once You have <strong>activated the required plugins</strong> goto Theme Admin panel from bottom left , click on Installer Menu on top right on Theme Admin page.
					</li>


				</ul>

			</div>
		</div>
		
	<?php
	update_option(SN.'ioa_tour',true);
}

if(!get_option(SN.'ioa_tour'))
add_action('admin_footer','IOATour');



function register_IOA_template($templates)
{
	global $IOA_templates;

	foreach ($templates as $key => $template) {
		$IOA_templates[$key] = $template;
	}


}

function filterShortcodesP($content){
     $str = str_replace(
         array(
              '<p>',
             '<br />',
              '<br/>',
               '<br>',
             '</p>',
             '<p></p>',
             '<p></div>'
         ),
         array(
             '',
             '',
             '','','',
             '',
             '</div>'
         ),
         $content);
     return $str;
 }

add_filter( 'the_content' , 'fixwmode_omembed' , 15 );
 function fixwmode_omembed( $content ) {
 
// Regex to find all <ifram ... > YouTube tags
$mh_youtube_regex = "/\<iframe .*\.com.*><\/iframe>/";
 
// Populate the results into an array
preg_match_all( $mh_youtube_regex , $content, $mh_matches );
 
// If we get any hits then put the update the results
if ( $mh_matches ) {;
        for ( $mh_count = 0; $mh_count < count( $mh_matches[0] ); $mh_count++ )
                {
                // Old YouTube iframe
                $mh_old = $mh_matches[0][$mh_count];
 
                $mh_new = str_replace( "?feature=oembed" , "?wmode=transparent" , $mh_old );
                $mh_new = preg_replace( '/\><\/iframe>$/' , ' wmode="Opaque"></iframe>' , $mh_new );
 
                // make the substitution
                $content = str_replace( $mh_old, $mh_new , $content );
                }
        }
return $content;
}
function appendableLink($testlink)
	{
		
		if(strpos($testlink,'?'))
		 return	$testlink .= "&";
			 
		return	$testlink .= "?";
	}

require_once('class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'ioa_activate_preplugins' );

function ioa_activate_preplugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
				'name'     				=> 'Contact Form 7', // The plugin name
				'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
				'source'   				=> 'http://downloads.wordpress.org/plugin/contact-form-7.3.7.2.zip', // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			),
		array(
		    'name' => 'Revolution WP',
		    'slug' => 'revslider',
		    'source' => HPATH . '/plugins/revslider.zip',
		    'required' => true,
		    'force_activation' => false,
		    'force_deactivation' => false
		)

	);

	// Change this to your theme text domain, used for internationalising strings
	

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'ioa',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Recommended Plugins', 'ioa'),
			'menu_title'                       			=> __( 'Install Plugins', 'ioa'),
			'installing'                       			=> __( 'Installing Plugin: %s', 'ioa'), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'ioa'),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'ioa'),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'ioa'),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'ioa'), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}




/**
 * Dashboard Widgets
 */



function ioa_dashboard_panel() {
	global $super_options;
	?>
	
	<div class="ioa-page-speed-dashboard">

		<div class="speed-radial-chart radial-chart"  >
			
			  <?php if(get_transient(SN.'_gspeed') && get_transient(SN.'_gspeed')!="") : ?>
			<div class="g-progress-bar ">
				<div class="filler"></div>
				<span></span>
			  
			</div>	
			<?php else: ?>
			  	Add Google API Key in Admin Panel > Advanced > Misc Tab.
			  <?php endif; ?>	

		</div>	
	</div>	
	 <?php if(get_transient(SN.'_gspeed') && get_transient(SN.'_gspeed')!="") : ?>
	<script>
		// Specify your actual API key here:
		var API_KEY = '<?php echo $super_options[SN.'_page_speed_key'] ?>';
		var URL_TO_GET_RESULTS_FOR = '<?php  echo home_url('/') ?>';
		var API_URL = 'https://www.googleapis.com/pagespeedonline/v1/runPagespeed?';

		var colorsets = ["#e81515" , "#e26b0c" , "#b4e815" , "#15bee8"];


		function runPagespeed() {
			var score = <?php if(get_transient(SN.'_gspeed')) echo get_transient(SN.'_gspeed'); else echo -1; ?>;

		if(score > 0)
		{
			var uin = 0;
			  if(score <=25 ) uin = colorsets[0];
			  else if(score > 25 && score <=50 ) uin = colorsets[1];
			  else if(score > 50 && score <=75 ) uin = colorsets[2];
			  else if(score > 75  ) uin = colorsets[3];

			  jQuery('.g-progress-bar > div').css("backgroundColor",uin).animate({ width : score+'%' },'normal');
			  jQuery('.g-progress-bar span').html(score+"/100");	
			return;
		}	

		  var s = document.createElement('script');
		  s.type = 'text/javascript';
		  s.async = true;
		  var query = [
		    'url=' + URL_TO_GET_RESULTS_FOR,
		    'callback=runPagespeedCallbacks',
		    'key=' + API_KEY,
		  ].join('&');
		  s.src = API_URL + query;
		  document.head.insertBefore(s, null);
		}


		function runPagespeedCallbacks(result) {
		  
		  if(jQuery.trim(API_KEY)=='') 
		  {
		  	jQuery('.speed-radial-chart').addClass('error-google-speed').html('Add Google API Key in Admin Panel > Advanced > Misc Tab.');
		  	return;
		  }

		  if (result.error) {
		    var errors = result.error.errors;
		    for (var i = 0, len = errors.length; i < len; ++i) {
		      if (errors[i].reason == 'badRequest' && API_KEY == API_URL) {
		        jQuery('.speed-radial-chart').addClass('error-google-speed').html(errors[i].message);
		      } else {
		        jQuery('.speed-radial-chart').addClass('error-google-speed').html(errors[i].message);
		      }
		    }
		    return;
		  }
		  var uin = 0;
		  if(result.score <=25 ) uin = colorsets[0];
		  else if(result.score > 25 && result.score <=50 ) uin = colorsets[1];
		  else if(result.score > 50 && result.score <=75 ) uin = colorsets[2];
		  else if(result.score > 75  ) uin = colorsets[3];
			
		  jQuery('.g-progress-bar > div').css("backgroundColor",uin).animate({ width : score+'%' },'normal');
		  jQuery('.g-progress-bar span').html(score+"/100");	
		
		 jQuery.post( ioa_listener_url,  { type:'gspeed' , score : result.score, action: 'ioalistener' },function(data){ console.log(data); } )	
		 
		}

		jQuery(window).load(function(){
			runPagespeed();
		});
	</script>
	
	<?php
	endif;
} 

// Create the function use in the action hook



function add_page_speed() {
	wp_add_dashboard_widget('ioa_dashboard_widget', __('Current Home Page Speed','ioa'), __('ioa_dashboard_panel','ioa'));
	global $super_options,$wp_meta_boxes;

	
	

} 


function ioa_external_links() {
	global $super_options; 
	

	$link = appendableLink(home_url('/')); 
$frontpage_id = get_option('page_on_front');
 $url="http://support.artillegence.com/";
	?>
	
	<ul class="ioa-admin-linksc clearfix">
		<li class="clearfix first theme_dashboard"><a class="" href='<?php echo $link; ?>rad=on&amp;mode=builder&amp;pid=<?php echo $frontpage_id ?>'><?php _e('RAD Builder','ioa') ?></a> </li>
		<li class="clearfix first slideshow"><a class="" href="<?php echo $link; ?>enigma=styler&amp;pid=<?php echo $frontpage_id ?>"><?php _e('Enigma Styler','ioa') ?></a></li>
	</ul>
	

	<?php
} 

// Create the function use in the action hook



function add_ioa_external_links() {
	wp_add_dashboard_widget('ioa_extlinks_widget', __('Editors','ioa'), 'ioa_external_links');

} 


function ioa_admin_links() {
	global $super_options;
	?>
	
	<ul class="ioa-admin-links clearfix">
		<li class="clearfix first theme_dashboard"><a class="" href="<?php echo admin_url()."admin.php?page=ioa"; ?>"><i class="entypo gauge"></i><?php _e('Theme Dashboard','ioa') ?></a> </li>
		<li class="clearfix last builders"><a class="" href="<?php echo admin_url()."admin.php?page=hcons"; ?>"><i class="entypo pencil"></i><?php _e('Builders','ioa') ?></a></li>
		<li class="clearfix first slideshow"><a class="" href="<?php echo admin_url()."admin.php?page=ioamed"; ?>"><i class="entypo docs"></i><?php _e('Create Slideshow','ioa') ?></a></li>
		<li class="clearfix last content_types"><a class="" href="<?php echo admin_url()."admin.php?page=ioapty"; ?>"><i class="entypo text-doc"></i><?php _e('Manage Content Types','ioa') ?></a></li>
	</ul>

	<?php
} 

// Create the function use in the action hook



function add_ioa_admin_links() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('ioa_admin_link', __('Quick Links','ioa'), 'ioa_admin_links');
	

	$my_widget = $wp_meta_boxes['dashboard']['normal']['core']['ioa_admin_link'];
    unset($wp_meta_boxes['dashboard']['normal']['core']['ioa_admin_link']);
    $wp_meta_boxes['dashboard']['side']['core']['ioa_admin_link'] = $my_widget;

	
} 


function ioa_infographics() {
	global $super_options,$registered_posts;
	?>
	
	
	<div class="clearfix wp-admin-ioa-info">
	<?php 
	$i=0;
	$info = array();
	$colors = array("#74d0d1","#6ee5e1", "#74bed1","#74d1ad","#bd9dcd","#a4d174","#9dcdb8","#cdcc9d","#cdaf9d","#e5886e","#6ee582","#6ebfe5","#b46ee5",);
	$str = '[doughnut_chart width="300" height="300"]';
	$count_posts = wp_count_posts();
	$info['Posts'] = $count_posts->publish;

	$str .= "[doughnut value='".$count_posts->publish."' background='".$colors[$i++]."']";

	$count_posts = wp_count_posts('page');
	$info['Pages'] = $count_posts->publish;

	$str .= "[doughnut value='".$count_posts->publish."' background='".$colors[$i++]."']";
	
	foreach ($registered_posts as $key => $rpost) {
		$count_posts = wp_count_posts($rpost->getPostType());
		$info[$rpost->getPostMulti()] = $count_posts->publish;
		$str .= "[doughnut value='".$count_posts->publish."' background='".$colors[$i++]."']";
	}

	$str .="[/doughnut_chart]";

	echo do_shortcode($str);
    
	 ?>
		<div class="legend">
			<ul>
				<?php $i =0;
				foreach ($info as $key => $nos) {
				echo "<li><span class='block' style='background:".$colors[$i++]."'>$nos</span> <span>".$key."</span></li>";	
				}
				 ?>
			</ul>
		</div>
		</div>
		<script src="<?php echo URL."/sprites/js/chart.min.js" ?>"></script>
		<script>
		jQuery(function(){

		if(jQuery('.donut-chart-wrap').length > 0) {	

			jQuery('.donut-chart-wrap').each(function(){
		         temp = jQuery(this);
		         temp = jQuery(this);
		         var ds = [],total=0;
		         temp.find('.donut-val').each(function(i){

		         total += parseInt(jQuery(this).data('value'));
		            
		         });
		         temp.find('.donut-val').each(function(i){

		             ds[i] =  {
		                            color : jQuery(this).data('fillcolor'),
		                            value : jQuery(this).data('value')
		                     };
		                    
		            jQuery(this).children('.block').html(  Math.round(parseInt(jQuery(this).data('value'))/total * 1000)/10  +"%" );    
		         });
		        
		        var ctx = temp.children('canvas')[0].getContext("2d");
		        var myNewChart = new Chart(ctx);        
		        new Chart(ctx).Doughnut(ds,{
		            animationEasing : "easeOutExpo"
		        });
		    });
		    jQuery(document).on('click' , '.graph-info-toggle',  function(){

			    if( jQuery(this).hasClass('info-2icon-') )
			        jQuery(this).addClass('cancel-2icon-').removeClass('info-2icon-');
			    else
			        jQuery(this).removeClass('cancel-2icon-').addClass('info-2icon-');

			    jQuery(this).parent().children('.info-area').fadeToggle('normal');
			});

		}


		})
		</script>
	<?php
} 

// Create the function use in the action hook



function add_ioa_infographics() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('ioa_infographic', 'Stats', 'ioa_infographics');
	

	$my_widget = $wp_meta_boxes['dashboard']['normal']['core']['ioa_infographic'];
    unset($wp_meta_boxes['dashboard']['normal']['core']['ioa_infographic']);
    $wp_meta_boxes['dashboard']['side']['core']['ioa_infographic'] = $my_widget;

	
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions

if( $super_options[SN.'_def_dbwidgets'] =="true" ) :
	add_action('wp_dashboard_setup', 'add_page_speed' );
	add_action('wp_dashboard_setup', 'add_ioa_external_links' );
	add_action('wp_dashboard_setup', 'add_ioa_admin_links' );
	//add_action('wp_dashboard_setup', 'add_ioa_infographics' );
endif;

function isJson($string) {
	return is_object(json_decode($string));
}

function IOA_theme_activate() {
  
$stylePath =   get_template_directory()."/styles";
$get_styles = scandir($stylePath);

foreach ($get_styles as $key => $style) {
	if(strpos($style,'.txt'))
	{
		$file =$stylePath ."/$style";
		$fh = fopen($file, 'r');
		$super_query = fread($fh, filesize($file));

		$data = base64_decode($super_query);	
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
		
	}
}

   
}
wp_register_theme_activation_hook('IOA_Plus', 'IOA_theme_activate');

function wp_register_theme_activation_hook($code, $function) {
    $optionKey="theme_is_activated_" . $code;
    if(!get_option($optionKey)) {
        call_user_func($function);
        update_option($optionKey , 1);
    }
}

 function my_theme_deactivate() {
    // code to execute on theme deactivation
 }

wp_register_theme_deactivation_hook('IOA_Plus', 'my_theme_deactivate');
function wp_register_theme_deactivation_hook($code, $function) {
     $GLOBALS["wp_register_theme_deactivation_hook_function" . $code]=$function;
     $fn=create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code. '");');
     add_action("switch_theme", $fn);
}
