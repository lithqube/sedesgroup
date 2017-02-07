<?php 

$dominant_color = "#44aacc";
if(get_option(SN.'_global_color')) $dominant_color = get_option(SN.'_global_color');

$args = array(
					__("Headings & Body Font Settings",'ioa') => array(

						array(

							"label" => "Body Stylings",
							"matrix" => array(

 														"div.inner-super-wrapper   " =>  array( "prop" => "font-family" , "label" => __("Body Font Family",'ioa') , "default" => "Open Sans" ),
 														".custom-font " =>  array( "prop" => "font-family" , "label" => __("Titles Font Family",'ioa') , "default" => "Open Sans" ),
 														".custom-font1 " =>  array( "prop" => "font-family" , "label" => __("RAD Titles Font Family",'ioa') , "default" => "Open Sans" ),
														'div.inner-super-wrapper'  =>  array( "prop" => "parent-background-color,background-image" , "label" => __("Fixed Container Background Color",'ioa') , "default" => "#ffffff" ),
 														".page-wrapper  a" =>  array( "prop" => "color" , "label" => __("Links Color",'ioa') , "default" => "#333333" ),
 														".page-wrapper  a:hover" =>  array( "prop" => "color" , "label" => __("Links Hover Color",'ioa') , "default" => "#333333" ),
 														
 														
 														"div.inner-super-wrapper " =>  array( "prop" => "color" , "label" => __("Body Color",'ioa') , "default" => "#444444" ),
 														"div.inner-super-wrapper  " =>  array( "prop" => "font-size" , "label" => __("Body Font Size",'ioa') , "default" => "13px" ),
 														"div.inner-super-wrapper    " =>  array( "prop" => "line-height" , "label" => __("Body Line Height",'ioa') , "default" => "1.9" ),
 		 		
 												)
							),
						array(

							"label" => "Heading Stylings",
							"matrix" => array(

 														".page-wrapper h1" =>  array( "prop" => "color" , "label" => __("H1 Color",'ioa') , "default" => "#596a67" ),
 														".page-wrapper h2" =>  array( "prop" => "color" , "label" => __("H2 Color",'ioa') , "default" => "#596a67" ),
 														".page-wrapper h3" =>  array( "prop" => "color" , "label" => __("H3 Color",'ioa') , "default" => "#596a67" ),
 														".page-wrapper h4" =>  array( "prop" => "color" , "label" => __("H4 Color",'ioa') , "default" => "#596a67" ),
 														".page-wrapper h5" =>  array( "prop" => "color" , "label" => __("H5 Color",'ioa') , "default" => "#596a67" ),
 														".page-wrapper h6" =>  array( "prop" => "color" , "label" => __("H6 Color",'ioa') , "default" => "#596a67" ),

 														".page-wrapper h1 " =>  array( "prop" => "font-size" , "label" => __("H1 Font Size",'ioa') , "default" => "48px" ),
 														".page-wrapper h2 " =>  array( "prop" => "font-size" , "label" => __("H2 Font Size",'ioa') , "default" => "36px" ),
 														".page-wrapper h3 " =>  array( "prop" => "font-size" , "label" => __("H3 Font Size",'ioa') , "default" => "32px" ),
 														".page-wrapper h4 " =>  array( "prop" => "font-size" , "label" => __("H4 Font Size",'ioa') , "default" => "24px" ),
 														".page-wrapper h5 " =>  array( "prop" => "font-size" , "label" => __("H5 Font Size",'ioa') , "default" => "18px" ),
 														".page-wrapper h6 " =>  array( "prop" => "font-size" , "label" => __("H6 Font Size",'ioa') , "default" => "15px" ),

 														".page-wrapper h1  " =>  array( "prop" => "font-weight" , "label" => __("H1 Font Weight",'ioa') , "default" => "600" ),
 														".page-wrapper h2  " =>  array( "prop" => "font-weight" , "label" => __("H2 Font Weight",'ioa') , "default" => "600" ),
 														".page-wrapper h3  " =>  array( "prop" => "font-weight" , "label" => __("H3 Font Weight",'ioa') , "default" => "600" ),
 														".page-wrapper h4  " =>  array( "prop" => "font-weight" , "label" => __("H4 Font Weight",'ioa') , "default" => "600" ),
 														".page-wrapper h5  " =>  array( "prop" => "font-weight" , "label" => __("H5 Font Weight",'ioa') , "default" => "600" ),
 														".page-wrapper h6  " =>  array( "prop" => "font-weight" , "label" => __("H6 Font Weight",'ioa') , "default" => "600" ),
 														
							)

						)


						),
					__("Boxed Stylings",'ioa') => array(

						array(

							 			"label" => "Page Background",
							 			"matrix" => array(

														"div.super-wrapper " =>  array( "prop" => "parent-background-color,background-image" , "label" => __("Main Container ",'ioa') , "default" => "#fafafa" ),


							 				)

							)

						),
					__("Compact Menu Area",'ioa') => array(


										array(
										"label" => "Compact Bar Stylings",
										"matrix" => array(

 															"div.compact-bar" =>  array( "prop" => "parent-background-color,background-image" , "label" => __("Compact Area ",'ioa') , "default" => "#ffffff" ),
 		 		
				 										 )
										),
										array(

									    "label" => "Compact Bar Menu Stylings",
									    "matrix" => array(

									    					"div.compact-bar ul.menu li a" =>  array( "prop" => "color" , "label" => __("Menu Link Color ",'ioa') , "default" => "#999999" ),
									    					"div.compact-bar ul.menu li a " =>  array( "prop" => "font-size" , "label" => __("Menu Link Font Size ",'ioa') , "default" => "13px" ),
									    					"div.compact-bar ul.menu li a  " =>  array( "prop" => "font-family" , "label" => __("Menu Link Font Size ",'ioa') , "default" => "Open Sans" ),
													 		"div.compact-bar .menu-bar .menu li:hover>a" =>  array( "state" => "hover", "prop" => "color" , "default" => "#ffffff" , "label" => __("Menu Link Hover Color ",'ioa')),
													 		"div.compact-bar .menu-bar .menu div.hoverdir-wrap span.hoverdir"  =>  array( "default" => $dominant_color,"sync" => true, "prop" => "background-color" , "label" => __("Animated Hover Background Color",'ioa')),
													 		"div.compact-bar .menu-bar .menu-bar  .menu>li.current_page_item>a,div.compact-bar  .menu-bar  .menu>li.current-menu-ancestor>a,div.compact-bar  .menu-bar  .menu>li.menu-active>a,	div.compact-bar .menu-bar  .menu>li.current-menu-item>a"  =>  array( "default" => $dominant_color,"sync" => true, "prop" => "color" , "label" => __("Active Menu Color",'ioa')),
													 		
													 		"div.compact-bar .menu > li > a span.menu-arrow"  =>  array( "default" => "16px", "prop" => "top" , "label" => __("Menu Arrow Distance From Top",'ioa')),
													 		
													 		"div.compact-bar .menu-bar .menu > li.current_page_item > a > span.spacer, div.compact-bar .menu-bar .menu > li.current-menu-ancestor > a > span.spacer, div.compact-bar .menu-bar .menu > li.menu-active > a > span.spacer, div.compact-bar .menu-bar .menu > li.current-menu-item > a > span.spacer"   =>  array( "default" => $dominant_color,"sync" => true, "prop" => "border-color" , "label" => __("Active Menu Bottom Color",'ioa')),
													 		"div.compact-bar .menu-bar .menu > li.current_page_item > a > span.spacer, div.compact-bar .menu-bar .menu > li.current-menu-ancestor > a > span.spacer, div.compact-bar .menu-bar .menu > li.menu-active > a > span.spacer, div.compact-bar .menu-bar .menu > li.current-menu-item > a > span.spacer "   =>  array( "default" => '2px', "prop" => "border-bottom-width" , "label" => __("Active Menu Bottom Line Thickness",'ioa')),
													 		"div.compact-bar .menu-bar .menu > li.current_page_item > a > span.spacer, div.compact-bar .menu-bar .menu > li.current-menu-ancestor > a > span.spacer, div.compact-bar .menu-bar .menu > li.menu-active > a > span.spacer, div.compact-bar .menu-bar .menu > li.current-menu-item > a > span.spacer  "   =>  array( "default" => 'solid', "prop" => "border-bottom-style" , "label" => __("Active Menu Bottom Line Style",'ioa')),
													 		"div.compact-bar .menu-bar .menu > li.current_page_item > a > span.spacer, div.compact-bar .menu-bar .menu > li.current-menu-ancestor > a > span.spacer, div.compact-bar .menu-bar .menu > li.menu-active > a > span.spacer, div.compact-bar .menu-bar .menu > li.current-menu-item > a > span.spacer   "   =>  array( "default" => '8px', "prop" => "bottom" , "label" => __("Active Menu Bottom Line Distance",'ioa')),
													 		
													 		"div.compact-bar .menu-bar .menu-bar  .menu>li.current_page_item:hover>a,div.compact-bar  .menu-bar  .menu>li.current-menu-ancestor:hover>a,div.compact-bar  .menu-bar  .menu>li.menu-active:hover>a, div.compact-bar .menu-bar  .menu>li.current-menu-item:hover>a"  =>  array( "default" => "#ffffff", "prop" => "color" , "label" => __("Active Menu Hover Color",'ioa')),
													 		"div.compact-bar div.menu-bar  .menu li .sub-menu > li.current-menu-parent > a, div.compact-bar div.menu-bar  .menu li .sub-menu > li.current-menu-ancestor > a,div.compact-bar div.menu-bar  .menu li .sub-menu li.current-menu-item>a ,  div.compact-bar div.menu-bar  .menu li .sub-menu li.current_page_item>a " =>  array( "default" => "#ffffff", "prop" => "color" , "label" => __("Active Sub Menu Item Color",'ioa')),
													 		"div.compact-bar .menu-bar .sub-menu > li.current-menu-parent > a, div.compact-bar .menu-bar .sub-menu > li.current-menu-ancestor > a,div.compact-bar .menu-bar .sub-menu li.current-menu-item a ,  div.compact-bar .menu-bar .sub-menu li.current_page_item a" =>  array( "default" => $dominant_color,"sync" => true, "prop" => "background-color" , "label" => __("Active Sub Menu Item Background Color",'ioa')),
													 		"div.compact-bar .menu-bar ul.menu li ul.sub-menu , div.compact-bar div.sub-menu" =>  array( "default" => "#ffffff", "prop" => "background-color" , "label" => __("Dropdown Background Color",'ioa')),
													 		"div.compact-bar .menu-bar .menu li .sub-menu li a" =>  array( "default" => "#8b989a",  "prop" => "color" , "label" => __("Dropdown Menu Items Color",'ioa')),
													 		"div.compact-bar .menu-bar .menu li .sub-menu li:hover>a" =>  array( "default" => "#111111",  "prop" => "color" , "label" => __("Dropdown Menu Items Hover Color",'ioa')),
													 		"div.compact-bar div.sub-menu > div h6 a" =>  array( "default" => "#515d5e", "prop" => "color" , "label" => __("Megamenu Headings Link Color",'ioa')),
													 		"div.compact-bar div.sub-menu > div h6 a " =>  array( "default" => "13px", "prop" => "font-size" , "label" => __("Megamenu Headings Font Size",'ioa')),
													 		"div.compact-bar div.sub-menu > div h6" =>  array( "default" => "#eeeeee", "prop" => "border-bottom-color" , "label" => __("Megamenu Headings Border Color",'ioa')),


									    			)

									),
						),  
					__('Common Stylings','ioa') => array(
						array(
									"label" => "Slider Controls",
									"matrix" => array(

										"div.quartz-controls-wrap > a" =>  array( "prop" => "background-color" , "label" => __("Arrows Background Color",'ioa') , "default" => "#ffffff" ),	 
										"div.quartz-controls-wrap > a " =>  array( "prop" => "color" , "label" => __("Arrows Color",'ioa') , "default" => "#444444" ),	 


										)	
							 ),
						array(
									"label" => "Gallery Controls",
									"matrix" => array(

										".seleneGallery div.selene-controls-wrap a" =>  array( "prop" => "background-color" , "label" => __("Arrows Background Color",'ioa') , "default" => "#ffffff" ),	 
										".seleneGallery div.selene-controls-wrap a " =>  array( "prop" => "color" , "label" => __("Arrows Color",'ioa') , "default" => "#444444" ),	 


										)	
							 ),
						
						array( 
							"label" => "Filter Menu" ,
							"matrix" => array(

										"div.ioa-menu > span" =>  array( "prop" => "background-color" , "label" => __("Filter Label Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.ioa-menu > span  " =>  array( "prop" => "color" , "label" => __("Filter Label Color",'ioa') , "default" => "#ffffff" ),

										"div.ioa-menu a" =>  array( "prop" => "color" , "label" => __("Filter Icon Color",'ioa') , "default" => "#ffffff" ),
										"div.ioa-menu a  " =>  array( "prop" => "background-color" , "label" => __("Filter Icon Background Color",'ioa') , "default" => adjustBrightness($dominant_color,-30)  ,"sync" => true , "dark" => true ),

										"div.ioa-menu ul" =>  array( "prop" => "background-color" , "label" => __("Dropdown Background Color",'ioa') , "default" => adjustBrightness($dominant_color,-30)  ,"sync" => true , "dark" => true ),
										"div.ioa-menu ul " =>  array( "prop" => "border-left-color" , "label" => __("Dropdown Border Left Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										
										"div.ioa-menu ul li" =>  array( "prop" => "color" , "label" => __("Dropdown Text Color",'ioa') , "default" => "#ffffff" ),

										"div.ioa-menu ul li div.hoverdir-wrap span.hoverdir,div.ioa-menu ul li.active " =>  array( "prop" => "background-color" , "label" => __("Hover & Active Menu Item Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
									)
						),
						array( 
							"label" => "Pagination" ,
							"matrix" => array(
										
										"div.pagination ul li a" =>  array( "prop" => "background-color" , "label" => __("Pagination Link Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.pagination ul li a " =>  array( "prop" => "color" , "label" => __("Pagination Link Color",'ioa') , "default" => "#ffffff" ),
									
										"div.pagination ul li a:hover" =>  array( "prop" => "background-color" , "label" => __("Pagination Link Hover Background Color",'ioa') , "default" => "#929da5" ),
										"div.pagination ul li a:hover " =>  array( "prop" => "color" , "label" => __("Pagination Link Hover Color",'ioa') , "default" => "#ffffff" ),

										"div.pagination ul li span.current" =>  array( "prop" => "background-color" , "label" => __("Pagination Current Page Background Color",'ioa') , "default" => "#999999" ),
										"div.pagination ul li span.current  " =>  array( "prop" => "color" , "label" => __("Pagination Current Page Color",'ioa') , "default" => "#ffffff" ),
										
										"div.pagination-dropdown span" =>  array( "prop" => "color" , "label" => __("Pagination Dropdown Label Color",'ioa') , "default" => "#757575" ),
										"div.pagination-dropdown div.select-wrap i" =>  array( "prop" => "color" , "label" => __("Pagination Dropdown Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.pagination-dropdown div.select-wrap" =>  array( "prop" => "border-color" , "label" => __("Pagination Dropdown Area Border Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.pagination-dropdown div.select-wrap select" =>  array( "prop" => "color" , "label" => __("Pagination Dropdown  Color",'ioa') , "default" => "#888888" ),


										)
						  ),
						),
					__('Top Area Stylings','ioa') => array(
						
						array(
								"label" => "Progress Line & Border Top Stylings",
								"matrix" => array(
									"div.theme-header" => array( "prop" => "border-color" , "label" => __("Top Line Border Color",'ioa') , "default" => "#dddddd" ),
									"#nprogress .bar" => array( "prop" => "background-color" , "label" => __("Progress Bar Color",'ioa') , "default" => $dominant_color ,"sync" => true),
									"#nprogress .peg" => array( "prop" => "color" , "label" => __("Progress Bar Tip Color",'ioa') , "default" => adjustBrightness($dominant_color,-30)  ,"sync" => true , "dark" => true),
									)

							),
						array(
								"label" => "Social Icons Stylings",
								"matrix" => array(

									"ul.top-area-social-list li a" => array( "prop" => "background-color" , "label" => __("Icons Background Color",'ioa') , "default" => "#fbfbfb" ),

									)

							),
						array(
										"label" => "WPML Selector Stylings",
										"matrix" => array(

 		 													"a.wpml-lang-selector"  =>  array( "prop" => "color" , "label" => __("Switch Color",'ioa') , "default" => "#ffffff" ),
 		 													"a.wpml-lang-selector "  =>  array( "prop" => "background-color" , "label" => __("Switch Backgrond Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 													"div.wpml-selector:hover a.wpml-lang-selector"  =>  array( "prop" => "color" , "label" => __("Switch Hover Color",'ioa') , "default" => "#ffffff" ),
 		 													"div.wpml-selector:hover a.wpml-lang-selector"  =>  array( "prop" => "background-color" , "label" => __("Switch Hover Backgrond Color",'ioa') , "default" => "#464646" ),
 		 													"div.wpml-selector ul" =>  array( "prop" => "background-color" , "label" => __("Menu Backgrond Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 													"div.wpml-selector ul i" =>  array( "prop" => "color" , "label" => __("Menu Tip Backgrond Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 													"div.wpml-selector ul li a" =>  array( "prop" => "color" , "label" => __("Menu Item Text Color ",'ioa') , "default" => "#ffffff" ),
 		 													"div.wpml-selector ul li a " =>  array( "prop" => "border-bottom-color" , "label" => __("Menu Item Border Color ",'ioa') , "default" => adjustBrightness($dominant_color,-30) ,"sync" => true , "dark" => true),
 		 													
 		 													"div.wpml-selector ul li a:hover" =>  array( "prop" => "color" , "label" => __("Menu Item Hover Text Color ",'ioa') , "default" => adjustBrightness($dominant_color,-30) ,"sync" => true , "dark" => true),
 		 													"div.wpml-selector ul li a:hover " =>  array( "prop" => "background-color" , "label" => __("Menu Item Hover  Background Color ",'ioa') , "default" => "#ffffff" ),

				 										 	)
									),
						array(
										"label" => "Search Area Stylings",
										"matrix" => array(

 															"div.ajax-search-pane"  =>  array( "prop" => "background-color" , "label" => __("Search Bar Color",'ioa') , "default" => "#ffffff" ),
 		 													"a.ajax-search-close"  =>  array( "prop" => "color" , "label" => __("Close Icon Color",'ioa') , "default" => "#cccccc" ),
 		 													"div.ajax-search-pane div.form input[type=text]"  =>  array( "prop" => "color" , "label" => __("Search Text Color",'ioa') , "default" => "#657079" ),
				 										    "div.search-results ul li div.desc a.more,div.search-results ul li a.view-all"  =>  array( "prop" => "color" , "label" => __("Button Color",'ioa') , "default" => "#ffffff" ),
				 										    "div.search-results ul li div.desc a.more,div.search-results ul li a.view-all "  =>  array( "prop" => "background-color" , "label" => __("Button Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
				 										 	"div.search-results ul li h5 a" => array( "prop" => "color" , "label" => __("Titles Color",'ioa') , "default" => "#5b6770" ),
				 										 	"div.search-results ul li div.image img"  =>  array( "prop" => "border-color" , "label" => __("Image Border Color",'ioa') , "default" => "#f4f4f4" ),
				 										 	"div.search-results ul li"  =>  array( "prop" => "border-color" , "label" => __("Search Results Border Color",'ioa') , "default" => "#f4f4f4" ),
				 										 	"div.search-results ul li div.desc span.date" => array( "prop" => "color" , "label" => __("Extra Information Color",'ioa') , "default" => "#999999" ),
				 										 	"div.search-results strong" => array( "prop" => "color" , "label" => __("Extra Information Page Type Color",'ioa') , "default" => $dominant_color ,"sync" => true),
				 										 	)
									),
						array(
								"label" => "Top Bar Common Stylings",
								"matrix" => array(

														"#top-bar" =>  array( "prop" => "parent-background-color,background-image" , "label" => __("Top Bar ",'ioa') , "default" => "#fbfbfb" ),
														"#top-bar " =>  array( "prop" => "border-color" , "label" => __("Top Bar Bottom Border ",'ioa') , "default" => "#f1f1f1" ),
														"#top-bar h6.tagline,#top-bar div.top-text" =>  array( "prop" => "color" , "label" => __("Top Bar Color",'ioa') , "default" => "#777777" ),
														"#top-bar div.top-text a" =>  array( "prop" => "color" , "label" => __("Top Bar Text Area Link Color",'ioa') , "default" => "#444444" ),
														"#top-bar a.ajax-search-trigger" =>  array( "prop" => "color" , "label" => __("Top Bar Search Icon Color",'ioa') , "default" => "#888888" ),
														"#top-bar a.ajax-search-trigger.active" =>  array( "prop" => "color" , "label" => __("Top Bar Active Search Icon Color",'ioa') , "default" => "#ffffff" ),
														"#top-bar a.ajax-search-trigger.active " =>  array( "prop" => "background-color" , "label" => __("Top Bar Active Search Icon Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
														"#top-bar ul.top-area-social-list li a" => array( "prop" => "border-right-color" , "label" => __("Social Icons Right Border Color",'ioa') , "default" => "#f1f1f1" ),
														"#top-bar ul.top-area-social-list li a " => array( "prop" => "border-left-color" , "label" => __("Social Icons Border Left Color",'ioa') , "default" => "#ffffff" ),
														"#top-bar ul.top-area-social-list" => array( "prop" => "border-left-color" , "label" => __("Social Icons Parent Border Color",'ioa') , "default" => "#f1f1f1" ),
		 										 )
							),
						



						array(

							    "label" => "Top Bar Menu Stylings",
							    "matrix" => array(

							    					"#top-bar ul.menu li a" =>  array( "prop" => "color" , "label" => __("Menu Link Color ",'ioa') , "default" => "#777777" ),
							    					
							    					"#top-bar ul.menu li a " =>  array( "prop" => "font-size" , "label" => __("Menu Font Size",'ioa') , "default" => "12px" ),
							    					"#top-bar ul.menu li a  " =>  array( "prop" => "font-weight" , "label" => __("Menu Font Weight",'ioa') , "default" => "400" ),
							    					"#top-bar ul.menu li a   " =>  array( "prop" => "font-family" , "label" => __("Menu Font Family",'ioa') , "default" => "Open Sans" ),

							    					"#top-bar  .menu > li > a span.menu-arrow" =>  array( "prop" => "top" , "label" => __("Menu Arrow Distance From Top",'ioa') , "default" => "13px" ),

											 		"#top-bar .menu-bar .menu li:hover>a" =>  array( "state" => "hover", "prop" => "color" , "default" => "#ffffff" , "label" => __("Menu Link Hover Color ",'ioa')),
											 		"#top-bar .menu-bar .menu div.hoverdir-wrap span.hoverdir" =>  array( "default" => $dominant_color,"sync" => true, "prop" => "background-color" , "label" => __("Animated Background Color",'ioa')),
											 		"#top-bar .menu-bar  .menu>li.current_page_item>a,#top-bar .menu-bar  .menu>li.current-menu-ancestor>a,#top-bar .menu-bar  .menu>li.menu-active>a,	#top-bar  .menu-bar .menu>li.current-menu-item>a "  =>  array( "default" => $dominant_color,"sync" => true,  "prop" => "background-color" , "label" => __("Active Menu Background Color",'ioa')),
											 		"#top-bar .menu-bar  .menu>li.current_page_item>a,#top-bar .menu-bar  .menu>li.current-menu-ancestor>a,#top-bar .menu-bar  .menu>li.menu-active>a,	#top-bar  .menu-bar .menu>li.current-menu-item>a"  =>  array( "default" => "#ffffff", "prop" => "color" , "label" => __("Active Menu Color",'ioa')),
											 		
											 		"#top-bar div.menu-bar  .menu li .sub-menu > li.current-menu-parent > a, #top-bar div.menu-bar  .menu li .sub-menu > li.current-menu-ancestor > a,#top-bar .menu-bar .sub-menu li.current-menu-item a ,  #top-bar .menu-bar .sub-menu li.current_page_item a "  =>  array( "default" => "#ffffff", "prop" => "color" , "label" => __("Active Sub Menu Item Color",'ioa')),
											 		"#top-bar div.menu-bar  .menu li .sub-menu > li.current-menu-parent > a, #top-bar div.menu-bar  .menu li .sub-menu > li.current-menu-ancestor > a,#top-bar .menu-bar .sub-menu li.current-menu-item a ,  #top-bar .menu-bar .sub-menu li.current_page_item a"  =>  array( "default" => $dominant_color,"sync" => true, "prop" => "background-color" , "label" => __("Active Sub Menu Item Background Color",'ioa')),
											 		
											 		"#top-bar .menu-bar ul.menu li.relative ul.sub-menu , #top-bar div.sub-menu" =>  array( "default" => "#ffffff", "prop" => "background-color" , "label" => __("Dropdown Background Color",'ioa')),
											 		"#top-bar .menu-bar ul.sub-menu li a" =>  array( "default" => "#8b989a",  "prop" => "color" , "label" => __("Dropdown Menu Items Color",'ioa')),
											 		"#top-bar .menu-bar .menu .sub-menu li:hover>a" =>  array( "default" => "#ffffff",  "prop" => "color" , "label" => __("Dropdown Menu Items Hover Color",'ioa')),
											 		"#top-bar .menu-bar .menu  li .sub-menu div.hoverdir-wrap span.hoverdir" =>  array(  "default" => $dominant_color,"sync" => true,  "prop" => "background-color" , "label" => __("Dropdown Animated Background Color",'ioa')),
											 		"#top-bar div.sub-menu > div h6 a" =>  array( "default" => "#515d5e", "prop" => "color" , "label" => __("Megamenu Headings Link Color",'ioa')),
											 		"#top-bar div.sub-menu > div h6 a" =>  array( "default" => "13px", "prop" => "font-size" , "label" => __("Megamenu Headings Link Font Size",'ioa')),
											 		"#top-bar div.sub-menu > div h6" =>  array( "default" => "#eeeeee", "prop" => "border-bottom-color" , "label" => __("Megamenu Headings Border Color",'ioa')),


							    			)

							),

							
							array(
										"label" => "Main Menu Area Bar Stylings",
										"matrix" => array(

 															"div.top-area-wrapper" =>  array( "prop" => "parent-background-color,background-image" , "label" => __("Main Area ",'ioa') , "default" => "#fcfcfc" ),
 															".top-area-wrapper div.top-area " =>  array( "prop" => "border-color" , "label" => __("Main Menu Area Border Top Color ",'ioa') , "default" => "#ffffff" ),
 															" .top-area-wrapper div.top-area h6.tagline, .top-area-wrapper  div.top-area div.top-text" =>  array( "prop" => "color" , "label" => __("Main Area Color",'ioa') , "default" => "#333333" ),
 															".top-area-wrapper div.top-area div.top-text a" =>  array( "prop" => "color" , "label" => __("Main Area Text Area Link Color",'ioa') , "default" => "#666666" ),
 															".top-area-wrapper div.top-area a.ajax-search-trigger" =>  array( "prop" => "color" , "label" => __("Main Area Search Icon Color",'ioa') , "default" => "#aaa" ),
 															".top-area-wrapper div.top-area a.ajax-search-trigger " =>  array( "prop" => "font-size" , "label" => __("Main Area Search Icon Font Size",'ioa') , "default" => "14px" ),
 															".top-area-wrapper div.top-area a.ajax-search-trigger.active" =>  array( "prop" => "color" , "label" => __("Main Area Active Search Icon Color",'ioa') , "default" => "#ffffff" ),
 		 													".top-area-wrapper div.top-area a.ajax-search-trigger.active " =>  array( "prop" => "background-color" , "label" => __("Main Area Active Search Icon Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 													
				 										 )
									),

							

							array(

									    "label" => "Main Area Menu Stylings",
									    "matrix" => array(

									    					".top-area-wrapper div.top-area  .menu>li>a" =>  array( "prop" => "color" , "label" => __("Menu Link Color ",'ioa') , "default" => "#666666" ),
									    					".top-area-wrapper div.top-area  .menu>li>a " =>  array( "prop" => "font-size" , "label" => __("Menu Link Font Size ",'ioa') , "default" => "13px" ),
									    					".top-area-wrapper div.top-area  .menu>li>a  " =>  array( "prop" => "font-family" , "label" => __("Menu Link Font Family ",'ioa') , "default" => "Open Sans" ),
									    					".top-area-wrapper div.top-area  .menu>li>a   " =>  array( "prop" => "font-weight" , "label" => __("Menu Link Font Weight ",'ioa') , "default" => "400" ),
													 		".top-area-wrapper div.top-area .menu-bar .menu li:hover>a" =>  array( "state" => "hover", "prop" => "color" , "default" => "#ffffff" , "label" => __("Menu Link Hover Color ",'ioa')),
													 		".top-area-wrapper div.top-area .menu-bar .menu div.hoverdir-wrap span.hoverdir" =>  array( "default" => $dominant_color,"sync" => true, "prop" => "background-color" , "label" => __("Animated Area Background Color",'ioa')),
													 		".top-area-wrapper .menu-wrapper .menu li span.spacer"  =>  array( "default" => $dominant_color,"sync" => true,  "prop" => "border-color" , "label" => __("Active Menu Line Border Color",'ioa')),
													 		".top-area-wrapper div.top-area .menu-bar .menu-bar  .menu>li.current_page_item>a,.top-area-wrapper div.top-area  .menu-bar  .menu>li.current-menu-ancestor>a,.top-area-wrapper div.top-area  .menu-bar  .menu>li.menu-active>a,	.top-area-wrapper div.top-area .menu-bar  .menu>li.current-menu-item>a"  =>  array( "default" => $dominant_color,"sync" => true, "prop" => "color" , "label" => __("Active Menu Color",'ioa')),
													 		
													 		".top-area-wrapper .menu > li > a span.menu-arrow"  =>  array( "default" => "12px", "prop" => "top" , "label" => __("Menu Arrow Distance From Top",'ioa')),
													 		
													 		".top-area-wrapper .menu-wrapper .menu li span.spacer "   =>  array( "default" => '2px', "prop" => "border-bottom-width" , "label" => __("Active Menu Bottom Line Thickness",'ioa')),
													 		".top-area-wrapper .menu-wrapper .menu li span.spacer  "   =>  array( "default" => 'solid', "prop" => "border-bottom-style" , "label" => __("Active Menu Bottom Line Style",'ioa')),
													 		".top-area-wrapper .menu-wrapper .menu li span.spacer   "   =>  array( "default" => '8px', "prop" => "bottom" , "label" => __("Active Menu Bottom Line Distance",'ioa')),
													 		

													 		".top-area-wrapper div.top-area .menu-bar .menu-bar  .menu>li.current_page_item:hover>a,.top-area-wrapper div.top-area  .menu-bar  .menu>li.current-menu-ancestor:hover>a,.top-area-wrapper div.top-area  .menu-bar  .menu>li.menu-active:hover>a, .top-area-wrapper div.top-area .menu-bar  .menu>li.current-menu-item:hover>a"  =>  array( "default" => "#ffffff", "prop" => "color" , "label" => __("Active Menu Hover Color",'ioa')),
													 		"div.top-area-wrapper div.top-area div.menu-bar .sub-menu > li.current-menu-parent > a, div.top-area-wrapper div.top-area div.menu-bar .sub-menu > li.current-menu-ancestor > a,div.top-area-wrapper div.top-area div.menu-bar .sub-menu li.current-menu-item>a ,  div.top-area-wrapper div.top-area div.menu-bar .sub-menu li.current_page_item>a " =>  array( "default" => "#ffffff", "prop" => "color" , "label" => __("Active Sub Menu Item Color",'ioa')),
													 		"div.top-area-wrapper .menu-bar .sub-menu > li.current-menu-parent > a, div.top-area-wrapper .menu-bar .sub-menu > li.current-menu-ancestor > a,div.top-area-wrapper .menu-bar .sub-menu li.current-menu-item>a ,  div.top-area-wrapper .menu-bar .sub-menu li.current_page_item>a" =>  array( "default" => $dominant_color,"sync" => true, "prop" => "background-color" , "label" => __("Active Sub Menu Item Background Color",'ioa')),
													 		".top-area-wrapper div.top-area .menu-bar ul.menu li.relative ul.sub-menu , .top-area-wrapper div.top-area div.sub-menu" =>  array( "default" => "#ffffff", "prop" => "background-color" , "label" => __("Dropdown Background Color",'ioa')),
													 		".top-area-wrapper div.top-area .menu-bar .sub-menu li a" =>  array( "default" => "#888888",  "prop" => "color" , "label" => __("Dropdown Menu Items Color",'ioa')),
													 		".top-area-wrapper div.top-area .menu-bar ul.sub-menu li:hover>a" =>  array( "default" => "#ffffff",  "prop" => "color" , "label" => __("Dropdown Menu Items Hover Color",'ioa')),
													 		".top-area-wrapper div.top-area .menu-bar .menu  li .sub-menu div.hoverdir-wrap span.hoverdir" =>  array(  "default" => $dominant_color,"sync" => true,  "prop" => "background-color" , "label" => __("Dropdown Animated Background Color",'ioa')),
													 		".top-area-wrapper div.top-area div.sub-menu > div h6 a" =>  array( "default" => "#444444", "prop" => "color" , "label" => __("Megamenu Headings Link Color",'ioa')),
													 		".top-area-wrapper div.top-area div.sub-menu > div h6 a" =>  array( "default" => "13px", "prop" => "font-size" , "label" => __("Megamenu Headings Link Font Size",'ioa')),
													 		".top-area-wrapper div.top-area div.sub-menu > div h6" =>  array( "default" => "#f4f4f4", "prop" => "border-bottom-color" , "label" => __("Megamenu Headings Border Color",'ioa')),


									    			)

									),

							
							array(
										"label" => "Bottom Head Area  Stylings",
										"matrix" => array(

 															"div.bottom-area div.top-area" =>  array( "prop" => "parent-background-color,background-image" , "label" => __("Bottom Area ",'ioa') , "default" => "#ffffff" ),
 															"div.bottom-area div.top-area " =>  array( "prop" => "border-top-color" , "label" => __("Bottom Area Border Top Color",'ioa') , "default" => "#f5f5f5" ),
 															"div.bottom-area div.top-area h6.tagline,div.bottom-area div.top-area div.top-text" =>  array( "prop" => "color" , "label" => __("Bottom Area Text Color",'ioa') , "default" => "#333333" ),
 															"div.bottom-area div.top-area div.top-text a" =>  array( "prop" => "color" , "label" => __("Bottom Area Text Area Link Color",'ioa') , "default" => "#666666" ),
 															"div.bottom-area div.top-area a.ajax-search-trigger" =>  array( "prop" => "color" , "label" => __("Bottom Area Search Icon Color",'ioa') , "default" => "#aaa" ),
 															"div.bottom-area div.top-area a.ajax-search-trigger.active" =>  array( "prop" => "color" , "label" => __("Bottom Area Active Search Icon Color",'ioa') , "default" => "#ffffff" ),
 															"div.bottom-area div.top-area a.ajax-search-trigger.active " =>  array( "prop" => "background-color" , "label" => __("Bottom Area Active Search Icon Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 		
				 										 )
									),

							array(

									    "label" => "Bottom Head Area Menu Stylings",
									    "matrix" => array(

									    					"div.bottom-area div.top-area  .menu>li>a" =>  array( "prop" => "color" , "label" => __("Menu Link Color ",'ioa') , "default" => "#84888d" ),
									    					"div.bottom-area div.top-area  .menu>li>a " =>  array( "prop" => "font-size" , "label" => __("Menu Link Font Size ",'ioa') , "default" => "13px" ),
									    					"div.bottom-area div.top-area  .menu>li>a  " =>  array( "prop" => "font-family" , "label" => __("Menu Link Font Family ",'ioa') , "default" => "Open Sans" ),
									    					"div.bottom-area div.top-area  .menu>li>a   " =>  array( "prop" => "font-weight" , "label" => __("Menu Link Font Weight ",'ioa') , "default" => "400" ),
													 		"div.bottom-area div.top-area .menu-bar .menu li:hover>a" =>  array( "state" => "hover", "prop" => "color" , "default" => "#ffffff" , "label" => __("Menu Link Hover Color ",'ioa')),
													 		"div.bottom-area div.top-area .menu-bar .menu div.hoverdir-wrap span.hoverdir" =>  array( "default" => $dominant_color,"sync" => true, "prop" => "background-color" , "label" => __("Animated Background Color",'ioa')),
													 		"div.bottom-area .menu-wrapper .menu li span.spacer"  =>  array( "default" => $dominant_color,"sync" => true,  "prop" => "border-color" , "label" => __("Active Menu Border Color",'ioa')),
													 		"div.bottom-area div.top-area .menu-bar .menu-bar  .menu>li.current_page_item>a,div.bottom-area div.top-area  .menu-bar  .menu>li.current-menu-ancestor>a,div.bottom-area div.top-area  .menu-bar  .menu>li.menu-active>a,	div.bottom-area div.top-area .menu-bar  .menu>li.current-menu-item>a"  =>  array( "default" => $dominant_color,"sync" => true, "prop" => "color" , "label" => __("Active Menu Color",'ioa')),
													 		
													 		"div.bottom-area .menu > li > a span.menu-arrow"  =>  array( "default" => "12px", "prop" => "top" , "label" => __("Menu Arrow Distance From Top",'ioa')),
													 		
													 		"div.bottom-area .menu-wrapper .menu li span.spacer "   =>  array( "default" => '2px', "prop" => "border-bottom-width" , "label" => __("Active Menu Bottom Line Thickness",'ioa')),
													 		"div.bottom-area .menu-wrapper .menu li span.spacer  "   =>  array( "default" => 'solid', "prop" => "border-bottom-style" , "label" => __("Active Menu Bottom Line Style",'ioa')),
													 		"div.bottom-area .menu-wrapper .menu li span.spacer   "   =>  array( "default" => '8px', "prop" => "bottom" , "label" => __("Active Menu Bottom Line Distance",'ioa')),
													 		

													 		"div.bottom-area div.top-area .menu-bar .menu-bar  .menu>li.current_page_item:hover>a,div.bottom-area div.top-area  .menu-bar  .menu>li.current-menu-ancestor:hover>a,div.bottom-area div.top-area  .menu-bar  .menu>li.menu-active:hover>a, div.bottom-area div.top-area .menu-bar  .menu>li.current-menu-item:hover>a"  =>  array( "default" => "#ffffff", "prop" => "color" , "label" => __("Active Menu Hover Color",'ioa')),
													 		"div.bottom-area div.top-area .menu-bar .sub-menu li.current-menu-item>a , div.bottom-area div.top-area .menu-bar .sub-menu li.current-menu-ancestor>a ,div.bottom-area div.top-area .menu-bar .sub-menu li.current-menu-parent>a , div.bottom-area div.top-area .menu-bar .sub-menu li.current_page_item>a " =>  array( "default" => "#ffffff", "prop" => "color" , "label" => __("Active Sub Menu Item Color",'ioa')),
													 		"div.bottom-area .menu-bar .sub-menu li.current-menu-item>a ,div.bottom-area div.top-area .menu-bar .sub-menu li.current-menu-parent>a ,div.bottom-area div.top-area .menu-bar .sub-menu li.current-menu-ancestor>a ,  div.bottom-area .menu-bar .sub-menu li.current_page_item >a" =>  array( "default" => $dominant_color,"sync" => true, "prop" => "background-color" , "label" => __("Active Sub Menu Item Background Color",'ioa')),
													 		"div.bottom-area div.top-area .menu-bar ul.menu li.relative ul.sub-menu , div.bottom-area div.top-area div.sub-menu" =>  array( "default" => "#ffffff", "prop" => "background-color" , "label" => __("Dropdown Background Color",'ioa')),
													 		"div.bottom-area div.top-area .menu-bar .sub-menu li a" =>  array( "default" => "#8b989a",  "prop" => "color" , "label" => __("Dropdown Menu Items Color",'ioa')),
													 		"div.bottom-area div.top-area .menu-bar ul.sub-menu li:hover>a" =>  array( "default" => "#ffffff",  "prop" => "color" , "label" => __("Dropdown Menu Items Hover Color",'ioa')),
													 		"div.bottom-area div.top-area .menu-bar .menu  li .sub-menu div.hoverdir-wrap span.hoverdir" =>  array(  "default" => $dominant_color,"sync" => true,  "prop" => "background-color" , "label" => __("Dropdown Animated Background Color",'ioa')),
													 		"div.bottom-area div.top-area div.sub-menu > div h6 a" =>  array( "default" => "#515d5e", "prop" => "color" , "label" => __("Megamenu Headings Link Color",'ioa')),
													 		"div.bottom-area div.top-area div.sub-menu > div h6 a" =>  array( "default" => "13px", "prop" => "font-size" , "label" => __("Megamenu Headings Link Font Size",'ioa')),
													 		"div.bottom-area div.top-area div.sub-menu > div h6" =>  array( "default" => "#eeeeee", "prop" => "border-bottom-color" , "label" => __("Megamenu Headings Border Color",'ioa')),


									    			)

									),


					),

			__("Page Title Area Stylings",'ioa') => array(

					array(
										"label" => "Main Title Stylings",
										"matrix" => array(

 															"div.title-wrap" =>  array( "prop" => "parent-background-color,background-image" , "label" => __("Title Area Background",'ioa') , "default" => $dominant_color ,"sync" => true),
 															"div.title-wrap h1" =>  array( "prop" => "color" , "label" => __("Title Text Color",'ioa') , "default" => "#ffffff" ),
 															"div.title-wrap h1 " =>  array( "prop" => "font-size" , "label" => __("Title Text Font Size",'ioa') , "default" => "24px" ),
 															"div.title-wrap h1  " =>  array( "prop" => "font-weight" , "label" => __("Title Text Font Weight",'ioa') , "default" => "100" ),
 		 		
				 										 )
					),
					array(
										"label" => "Breadcrumb Stylings",
										"matrix" => array(

 															"#breadcrumbs" =>  array( "prop" => "parent-background-color" , "label" => __("Breadcrumb Area Background",'ioa') , "default" => "#ffffff" ),
 															"#breadcrumbs span.current,#breadcrumbs" =>  array( "prop" => "color" , "label" => __("Current Page Link Color",'ioa') , "default" => "#999999" ),
 															"#breadcrumbs a" =>  array( "prop" => "color" , "label" => __("Links Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 		
				 										 )
					),


				),

			__("Sidebar Stylings",'ioa') => array(

					array(
										"label" => "Sidebar General Stylings",
										"matrix" => array(

 															".sidebar .widget-tail" =>  array( "prop" => "border-bottom-color" , "label" => __("Sidebar Tail Color",'ioa') , "default" => "#eeeeee" ),
 															".sidebar-wrap ul li a" =>  array( "prop" => "color" , "label" => __("Sidebar Link Color",'ioa') , "default" => "#333333" ),
 															"div.sidebar-wrap ul.menu li a" =>  array( "prop" => "color" , "label" => __("Sidebar Menu Item Color",'ioa') , "default" => "#747878" ),
 															"div.sidebar-wrap .menu>li.current_page_item>a, div.sidebar-wrap .menu>li.current-menu-ancestor>a, div.sidebar-wrap .menu>li.menu-active>a, div.sidebar-wrap .menu>li.current-menu-item>a"  =>  array( "prop" => "color" , "label" => __("Sidebar Active Menu Item Color",'ioa') , "default" => "#242a2b" ),
 															"div.sidebar-wrap .menu>li.current_page_item>a, div.sidebar-wrap .menu>li.current-menu-ancestor>a, div.sidebar-wrap .menu>li.menu-active>a, div.sidebar-wrap .menu>li.current-menu-item>a "  =>  array( "prop" => "background-color" , "label" => __("Sidebar Active Menu Item Background Color",'ioa') , "default" => "#ffffff" ),
 															".sidebar-wrap ul li a:hover" =>  array( "prop" => "color" , "label" => __("Sidebar Link Hover Color",'ioa') , "default" => "#333333" ),
 															".sidebar-wrap span.spacer" =>  array( "prop" => "border-bottom-color" , "label" => __("Title Bottom Border Color",'ioa') , "default" => "#dddddd" ),
 															".sidebar-wrap ul li " =>  array( "prop" => "color" , "label" => __("List Text Color",'ioa') , "default" => "#777777" ),
 															".sidebar-wrap ul li" =>  array( "prop" => "border-bottom-color" , "label" => __("List Bottom Border Color",'ioa') , "default" => "#dddddd" ),
 															".sidebar-wrap,.sidebar-wrap .widget-posts .description p , .sidebar-wrap div.custom-box-content, div.custom-box-content p" =>  array( "prop" => "color" , "label" => __("Text Color",'ioa') , "default" => "#757575" ),
 															".sidebar-wrap div.dribble_widget_media a,div.sidebar-wrap div.google-map" =>  array( "prop" => "border-color" , "label" => __("Image Border Color",'ioa') , "default" => "#eeeeee" ),
 		 												 	"div.sidebar-wrap ul.menu>li"  =>  array( "prop" => "border-color" , "label" => __("Menu Border Color",'ioa') , "default" => "#eeeeee" ),
 		 												 	".sidebar-wrap div.tweets-wrapper i.icon"  =>  array( "prop" => "color" , "label" => __("Twitter Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 												 )
					),
					array(
										"label" => "Sidebar Below Title Stylings",
										"matrix" => array(

 															".below-title.sidebar" =>  array( "prop" => "border-bottom-color" , "label" => __("Bottom Border Color",'ioa') , "default" => "#eeeeee" ),
 															".below-title.sidebar " =>  array( "prop" => "background-color" , "label" => __("Sidebar Area Background Color",'ioa') , "default" => "#ffffff" ),

 		 												 )
					),
					array(
										"label" => "Sidebar Above Footer Stylings",
										"matrix" => array(

 															".above-footer.sidebar" =>  array( "prop" => "border-top-color" , "label" => __("Border Top Color",'ioa') , "default" => "#eeeeee" ),
 															".above-footer.sidebar " =>  array( "prop" => "background-color" , "label" => __("Sidebar Area Background Color",'ioa') , "default" => "#ffffff" ),
 		 												 )
					),
					array(
										"label" => "Sidebar Inputs & Button Stylings",
										"matrix" => array(

															"div.sidebar-wrap input[type=text]" =>  array( "prop" => "border-color" , "label" => __("Textfields Border Color",'ioa') , "default" => "#dddddd" ),
															"div.sidebar-wrap input[type=text] " =>  array( "prop" => "color" , "label" => __("Textfields Color",'ioa') , "default" => "#aaaaaa" ),
															"div.sidebar-wrap input[type=submit],.sidebar-wrap  a.more" =>  array( "prop" => "background-color" , "label" => __("Buttons Background Color",'ioa') , "default" => "#494949" ,"sync" => true ),
															"div.sidebar-wrap input[type=submit]:hover,.sidebar-wrap  a.more:hover" =>  array( "prop" => "background-color" , "label" => __("Buttons Background Hover Color",'ioa') , "default" => $dominant_color ),


														)
					),
					array(
										"label" => "Sidebar Title Stylings",
										"matrix" => array(

 															".sidebar-wrap h3.heading" =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#444444" ),
 															".sidebar-wrap span.spacer" =>  array( "prop" => "border-bottom-color" , "label" => __("Title Bottom Border Color",'ioa') , "default" => "#dddddd" ),
 		 		
				 										 )
					),
					array(
										"label" => "Sidebar Tags Stylings",
										"matrix" => array(

 															"div.sidebar-wrap div.tagcloud a" =>  array( "prop" => "color" , "label" => __("Tag Text Color",'ioa') , "default" => "#ffffff" ),
 															"div.sidebar-wrap div.tagcloud a " =>  array( "prop" => "background-color" , "label" => __("Tag Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 		
				 										 )
					),
					array(
										"label" => "Sidebar Calendar Stylings",
										"matrix" => array(

 															".sidebar-wrap.widget_calendar table caption" =>  array( "prop" => "color" , "label" => __("Sidebar Calendar Caption Color",'ioa') , "default" => "#777777" ),
 		 													".sidebar-wrap.widget_calendar table th" =>  array( "prop" => "background-color" , "label" => __("Sidebar Calendar Head Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 													".sidebar-wrap.widget_calendar table th " =>  array( "prop" => "color" , "label" => __("Sidebar Calendar Head Color",'ioa') , "default" => "#ffffff" ),
 		 												 	".sidebar-wrap.widget_calendar table td a"  =>  array( "prop" => "color" , "label" => __("Sidebar Calendar Link Color",'ioa') , "default" => "#ffffff" ),
 		 												 	".sidebar-wrap.widget_calendar table td a "  =>  array( "prop" => "background-color" , "label" => __("Sidebar Calendar Link Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 												 )
					),
			

				),

			__("Footer Stylings",'ioa') => array(
					array(
							"label" => "Back to Top Button" ,
							"matrix" => array(

										"a.back-to-top" =>  array( "prop" => "background-color" , "label" => __("Button Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"a.back-to-top " =>  array( "prop" => "color" , "label" => __("Button Color",'ioa') , "default" => "#ffffff" ),

									)
						),
					array(
										"label" => "Footer Widget Area Stylings",
										"matrix" => array(

															"#footer" =>  array( "prop" => "background-color,background-image" , "label" => __("Footer Background Color",'ioa') , "default" => "#2d3033" ),
															"div.inner-footer-wrapper.page-content" =>  array( "prop" => "border-color" , "label" => __("Footer Width Bottom Border Color",'ioa') , "default" => "#202325" ),

														)
						), 
					array(
										"label" => "Bottom Footer Area Stylings",
										"matrix" => array(

															"#footer-menu" =>  array( "prop" => "background-color,background-image" , "label" => __("Footer Background Color",'ioa') , "default" => "#26292b" ),


														)
						),
					array(
										"label" => "Bottom Footer Text & Link Stylings",
										"matrix" => array(

															"#footer-menu p.footer-text" =>  array( "prop" => "color" , "label" => __("Footer Text Color",'ioa') , "default" => "#ffffff" ),
															"#footer-menu p.footer-text " =>  array( "prop" => "font-size" , "label" => __("Footer Text Font Size",'ioa') , "default" => "12px" ),
															"#footer-menu p.footer-text  " =>  array( "prop" => "font-weight" , "label" => __("Footer Text Font Weight",'ioa') , "default" => "400" ),
															"#footer-menu .menu li a" =>  array( "prop" => "color" , "label" => __("Footer Link Color",'ioa') , "default" => "#ffffff" ),
															"#footer-menu .menu li a " =>  array( "prop" => "font-size" , "label" => __("Footer Link Font Size",'ioa') , "default" => "11px" ),
															"#footer-menu .menu li a  " =>  array( "prop" => "font-weight" , "label" => __("Footer Link Font Weight",'ioa') , "default" => "400" ),
															"#footer-menu .menu li a:hover" =>  array( "prop" => "color" , "label" => __("Footer Link Hover Border Color",'ioa') , "default" => "#ffffff" ),
															"#footer-menu .menu li a:hover " =>  array( "prop" => "border-bottom-color" , "label" => __("Footer Link Hover Color",'ioa') , "default" => "#666666" ),


														)
						),
					array(
										"label" => "Footer General Stylings",
										"matrix" => array(
 															".footer-wrap ul li a" =>  array( "prop" => "color" , "label" => __("Footer Link Color",'ioa') , "default" => "#ffffff" ),
 															"div.footer-wrap ul.menu li a" =>  array( "prop" => "color" , "label" => __("Footer Menu Item Color",'ioa') , "default" => "#ffffff" ),
 															"div.footer-wrap ul.menu li a:hover" =>  array( "prop" => "color" , "label" => __("Footer Link Hover Color",'ioa') , "default" => "#eeeeee" ),
 															"div.footer-wrap  .menu>li.current_page_item>a,div.footer-wrap  .menu>li.current-menu-ancestor>a,div.footer-wrap  .menu>li.menu-active>a,div.footer-wrap .menu>li.current-menu-item>a"  =>  array( "prop" => "color" , "label" => __("Footer Widget Active Menu Color",'ioa') , "default" => "#ffffff" ),
 															"div.footer-wrap  .menu>li.current_page_item>a,div.footer-wrap  .menu>li.current-menu-ancestor>a,div.footer-wrap  .menu>li.menu-active>a,div.footer-wrap .menu>li.current-menu-item>a "  =>  array( "prop" => "background-color" , "label" => __("Footer Widget Active Menu Background Color",'ioa') , "default" => $dominant_color ,"sync" => true ),
 															".footer-wrap ul li " =>  array( "prop" => "color" , "label" => __("List Text Color",'ioa') , "default" => "#aaaaaa" ),
 															".footer-wrap ul li" =>  array( "prop" => "border-bottom-color" , "label" => __("List Bottom Border Color",'ioa') , "default" => "#3c4646" ),
 															"div.footer-wrap,.footer-wrap div.widget-posts .description p , div.footer-wrap div.custom-box-content, div.footer-wrap div.custom-box-content p" =>  array( "prop" => "color" , "label" => __("Text Color",'ioa') , "default" => "#eeeeee" ),
 															".footer-wrap div.dribble_widget_media a,.footer-wrap div.testimonial-bubble div.image,.footer-wrap .widget-posts .image,div.footer-wrap div.google-map" =>  array( "prop" => "border-color" , "label" => __("Image Border Color",'ioa') , "default" => "#474b45" ),
 		 												 )
					),
					
					array(
										"label" => "Footer Inputs & Button Stylings",
										"matrix" => array(

															"div.footer-wrap input[type=text]" =>  array( "prop" => "border-color" , "label" => __("Textfields Border Color",'ioa') , "default" => "#555" ),
															"div.footer-wrap input[type=text] " =>  array( "prop" => "color" , "label" => __("Textfields Color",'ioa') , "default" => "#dddddd" ),
															"div.footer-wrap input[type=submit],div.footer-wrap  a.more" =>  array( "prop" => "background-color" , "label" => __("Buttons Background Color",'ioa') , "default" => "#494949" ),
															"div.footer-wrap input[type=submit]:hover, div.footer-wrap  a.more:hover" =>  array( "prop" => "background-color" , "label" => __("Buttons Background Hover Color",'ioa') , "default" => $dominant_color ,"sync" => true),


														)
					),
					array(
										"label" => "Title Stylings",
										"matrix" => array(

 															"div.footer-wrap h3.footer-heading" =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#ffffff" ),
 															"#footer .footer-cols .spacer" =>  array( "prop" => "border-bottom-color" , "label" => __("Title Bottom Border Color",'ioa') , "default" => "#282e2e" ),
 		 		
				 										 )
					),
					array(
										"label" => "Tags Stylings",
										"matrix" => array(

 															"div.footer-wrap div.tagcloud a" =>  array( "prop" => "color" , "label" => __("Tag Text Color",'ioa') , "default" => "#ffffff" ),
 															"div.footer-wrap div.tagcloud a " =>  array( "prop" => "background-color" , "label" => __("Tag Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 		
				 										 )
					),
					array(
										"label" => "Calendar Stylings",
										"matrix" => array(

 															"div.footer-wrap.widget_calendar table caption" =>  array( "prop" => "color" , "label" => __("Footer Calendar Caption Color",'ioa') , "default" => "#ffffff" ),
 		 													"div.footer-wrap.widget_calendar table th" =>  array( "prop" => "background-color" , "label" => __("Footer Calendar Head Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 													"div.footer-wrap.widget_calendar table th " =>  array( "prop" => "color" , "label" => __("Footer Calendar Head Color",'ioa') , "default" => "#ffffff" ),
 		 												 	"div.footer-wrap.widget_calendar table td a"  =>  array( "prop" => "color" , "label" => __("Footer Calendar Link Color",'ioa') , "default" => "#ffffff" ),
 		 												 	"div.footer-wrap.widget_calendar table td a "  =>  array( "prop" => "background-color" , "label" => __("Footer Calendar Link Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
 		 													"div.footer-wrap.widget_calendar table td"  =>  array( "prop" => "color" , "label" => __("Footer Calendar Text Color",'ioa') , "default" => "#ffffff" ),
 		 												 )
					),
					
			

				),

		__("Blog Stylings",'ioa') => array(
					
					
					
					array( 
							"label" => "Blog Classic Stylings" ,
							"matrix" => array(

										"div.blog-format1-posts small.date,div.blog-format1-posts small.month" =>  array( "prop" => "color" , "label" => __("Date Area Text Color",'ioa') , "default" => "#555555" ),
										"div.blog-format1-posts div.datearea" =>  array( "prop" => "background-color" , "label" => __("Date Area Background Color",'ioa') , "default" => "#fafafa" ),
										
										"div.blog-format1-posts ul li div.proxy-datearea small.date,div.blog-format1-posts ul li div.proxy-datearea small.month" =>  array( "prop" => "color" , "label" => __("Animated Date Area Text Color ",'ioa') , "default" => "#ffffff" ),
										"div.blog-format1-posts ul li div.proxy-datearea " =>  array( "prop" => "background-color" , "label" => __("Animated Date Area Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										
										"div.blog-format1-posts ul li .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format1-posts ul li .hover i.hover-lightbox,div.blog-format1-posts ul li .hover i.hover-link" =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format1-posts ul li .hover i.hover-lightbox,div.blog-format1-posts ul li .hover i.hover-link " =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
									
										"div.blog-format1-posts span.line" =>  array( "prop" => "border-color" , "label" => __("Animated Line Color",'ioa') , "default" => "#eeeeee" ),
										
										"div.blog-format1-posts ul li div.desc h2 a"=>  array( "prop" => "color" , "label" => __("Heading Color",'ioa') , "default" => "#666666" ),	

										"div.blog-format1-posts ul li div.desc a.read-more" =>  array( "prop" => "background-color" , "label" => __("Button Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format1-posts ul li div.desc a.read-more " =>  array( "prop" => "color" , "label" => __("Button  Color",'ioa') , "default" => "#ffffff" ),
										"div.blog-format1-posts ul li div.desc a.read-more:hover" =>  array( "prop" => "background-color" , "label" => __("Button Hover Background Color",'ioa') , "default" => "#494949" ),
										"div.blog-format1-posts ul li div.desc a.read-more:hover " =>  array( "prop" => "color" , "label" => __("Button Hover Color",'ioa') , "default" => "#ffffff" ),
									
										"div.blog-format1-posts ul li div.extra" => array( "prop" => "border-color" , "label" => __("Extra Information Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.blog-format1-posts ul li div.extra " => array( "prop" => "color" , "label" => __("Extra Information Color",'ioa') , "default" => "#888888" ),
										"div.blog-format1-posts ul li div.extra a" => array( "prop" => "color" , "label" => __("Extra Information Link Color",'ioa') , "default" => "#666666" ),

										"div.blog-format1-posts ul li.format-gallery i.icon-camera-retro,div.blog-format1-posts ul li.format-link i,div.blog-format1-posts ul li.format-status i,div.blog-format1-posts ul li.format-chat i.icon-comments-alt,div.blog-format1-posts ul li.format-video i" => array( "prop" => "color" , "label" => __("Post Format Icon Color",'ioa') , "default" => "#ffffff" ),
										"div.blog-format1-posts ul li.format-gallery i.icon-camera-retro,div.blog-format1-posts ul li.format-link i,div.blog-format1-posts ul li.format-status i,div.blog-format1-posts ul li.format-chat i.icon-comments-alt,div.blog-format1-posts ul li.format-video i " => array( "prop" => "background-color" , "label" => __("Post Format Icon Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format1-posts ul li.format-link a" => array( "prop" => "color" , "label" => __("Post Format Link Color",'ioa') , "default" => "#111111" ),
										"div.blog-format1-posts ul li.format-link a " => array( "prop" => "border-color" , "label" => __("Post Format Link Border Color",'ioa') , "default" => "#222222" ),
										"div.blog-format1-posts ul li.format-status div.desc,div.blog-format1-posts ul li.format-chat div.desc,div.blog-format1-posts ul li.format-chat img.avatar" => array( "prop" => "border-color" , "label" => __("Post Format Border Color",'ioa') , "default" => "#eee" ),
									)
						),
					

					array( 
							"label" => "Blog Featured Stylings" ,
							"matrix" => array(

										
										"div.blog-format5-posts ul li .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format5-posts ul li .hover i.hover-lightbox,div.blog-format5-posts ul li .hover i.hover-link" =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format5-posts ul li .hover i.hover-lightbox,div.blog-format5-posts ul li .hover i.hover-link " =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
									
										"div.blog-format5-posts ul li div.desc h2 a"=>  array( "prop" => "color" , "label" => __("Heading Color",'ioa') , "default" => "#666666" ),	

										"div.blog-format5-posts ul li div.desc a.read-more" =>  array( "prop" => "background-color" , "label" => __("Button Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format5-posts ul li div.desc a.read-more " =>  array( "prop" => "color" , "label" => __("Button Color",'ioa') , "default" => "#ffffff" ),
										"div.blog-format5-posts ul li div.desc a.read-more:hover" =>  array( "prop" => "background-color" , "label" => __("Button Hover Background Color",'ioa') , "default" => "#494949" ),
										"div.blog-format5-posts ul li div.desc a.read-more:hover " =>  array( "prop" => "color" , "label" => __("Button Hover Color",'ioa') , "default" => "#ffffff" ),
										"div.blog-format5-posts ul li.spacer"	=>  array( "prop" => "border-color" , "label" => __("Bottom Spacer Color",'ioa') , "default" => "#eeeeee" ),
										"div.blog-format5-posts ul li div.extra" => array( "prop" => "border-color" , "label" => __("Extra Information Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.blog-format5-posts ul li div.extra " => array( "prop" => "color" , "label" => __("Extra Information Color",'ioa') , "default" => "#888888" ),
										"div.blog-format5-posts ul li div.extra a" => array( "prop" => "color" , "label" => __("Extra Information Link Color",'ioa') , "default" => "#666666" ),

										"div.blog-format5-posts ul li.format-gallery i.icon-camera-retro,div.blog-format5-posts ul li.format-link i,div.blog-format5-posts ul li.format-status i,div.blog-format5-posts ul li.format-chat i.icon-comments-alt,div.blog-format5-posts ul li.format-video i" => array( "prop" => "color" , "label" => __("Post Format Icon",'ioa') , "default" => "#ffffff" ),
										"div.blog-format5-posts ul li.format-gallery i.icon-camera-retro,div.blog-format5-posts ul li.format-link i,div.blog-format5-posts ul li.format-status i,div.blog-format5-posts ul li.format-chat i.icon-comments-alt,div.blog-format5-posts ul li.format-video i " => array( "prop" => "background-color" , "label" => __("Post Format Icon",'ioa') , "default" => $dominant_color ,"sync" => true),
									
										"div.blog-format5-posts ul li.format-link a" => array( "prop" => "color" , "label" => __("Post Format Link Color",'ioa') , "default" => "#111111" ),
										"div.blog-format5-posts ul li.format-link a " => array( "prop" => "border-color" , "label" => __("Post Format Link Border Color",'ioa') , "default" => "#222222" ),
										"div.blog-format5-posts ul li.format-chat img.avatar" => array( "prop" => "border-color" , "label" => __("Post Format Border Color",'ioa') , "default" => "#eee" ),
								
									)
						),
					
					array( 
							"label" => "Blog Grid Stylings" ,
							"matrix" => array(

										"div.blog-format3-posts ul li,div.blog-format3-posts ul li.format-gallery div.gallery"  =>  array( "prop" => "border-color" , "label" => __("Grid Border Color",'ioa') , "default" => "#eeeeee" ),
										"div.blog-format3-posts ul li .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format3-posts ul li .hover i.hover-lightbox,div.blog-format3-posts ul li .hover i.hover-link" =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format3-posts ul li .hover i.hover-lightbox,div.blog-format3-posts ul li .hover i.hover-link " =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
									
										"div.blog-format3-posts ul li h2 a"=>  array( "prop" => "color" , "label" => __("Heading Color",'ioa') , "default" => "#555555" ),	

										"div.blog-format3-posts ul li div.extra " => array( "prop" => "color" , "label" => __("Extra Information Color",'ioa') , "default" => "#888888" ),
										"div.blog-format3-posts ul li div.extra a" => array( "prop" => "color" , "label" => __("Extra Information Link Color",'ioa') , "default" => "#666666" ),

										"div.blog-format3-posts ul li.format-gallery i.icon-camera-retro,div.blog-format3-posts ul li.format-link i,div.blog-format3-posts ul li.format-status i,div.blog-format3-posts ul li.format-chat i.icon-comments-alt,div.blog-format3-posts ul li.format-video i" => array( "prop" => "color" , "label" => __("Post Format Icon",'ioa') , "default" => "#ffffff" ),
										"div.blog-format3-posts ul li.format-gallery i.icon-camera-retro,div.blog-format3-posts ul li.format-link i,div.blog-format3-posts ul li.format-status i,div.blog-format3-posts ul li.format-chat i.icon-comments-alt,div.blog-format3-posts ul li.format-video i " => array( "prop" => "background-color" , "label" => __("Post Format Icon",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format3-posts ul li.format-link a" => array( "prop" => "color" , "label" => __("Post Format Link Color",'ioa') , "default" => "#111111" ),
										"div.blog-format3-posts ul li.format-link a " => array( "prop" => "border-color" , "label" => __("Post Format Link Border Color",'ioa') , "default" => "#222222" ),
										"div.blog-format3-posts ul li.format-status div.desc,div.blog-format3-posts ul li.format-chat div.desc,div.blog-format3-posts ul li.format-chat img.avatar" => array( "prop" => "border-color" , "label" => __("Post Format Border Color",'ioa') , "default" => "#eee" ),
								
									)
						),
					
					array( 
							"label" => "Blog List Stylings" ,
							"matrix" => array(

										
										"div.blog-format2-posts ul li .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format2-posts ul li .hover i.hover-lightbox,div.blog-format2-posts ul li .hover i.hover-link" =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format2-posts ul li .hover i.hover-lightbox,div.blog-format2-posts ul li .hover i.hover-link " =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
									
										"div.blog-format2-posts ul li div.desc h2 a"=>  array( "prop" => "color" , "label" => __("Heading Color",'ioa') , "default" => "#666666" ),	

										"div.blog-format2-posts ul li div.desc a.read-more" =>  array( "prop" => "background-color" , "label" => __("Button Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format2-posts ul li div.desc a.read-more " =>  array( "prop" => "color" , "label" => __("Button Color",'ioa') , "default" => "#ffffff" ),
										"div.blog-format2-posts ul li div.desc a.read-more:hover" =>  array( "prop" => "background-color" , "label" => __("Button Hover Background Color",'ioa') , "default" => "#494949" ),
										"div.blog-format2-posts ul li div.desc a.read-more:hover " =>  array( "prop" => "color" , "label" => __("Button Hover Color",'ioa') , "default" => "#ffffff" ),
										
										"div.blog-format2-posts ul li div.extra" => array( "prop" => "border-color" , "label" => __("Extra Information Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.blog-format2-posts ul li div.extra " => array( "prop" => "color" , "label" => __("Extra Information Color",'ioa') , "default" => "#888888" ),
										"div.blog-format2-posts ul li div.extra a" => array( "prop" => "color" , "label" => __("Extra Information Link Color",'ioa') , "default" => "#666666" ),
									
										"div.blog-format2-posts ul li.format-link a" => array( "prop" => "color" , "label" => __("Post Format Link Color",'ioa') , "default" => "#111111" ),
										"div.blog-format2-posts ul li.format-link a " => array( "prop" => "border-color" , "label" => __("Post Format Link Border Color",'ioa') , "default" => "#222222" ),
										"div.blog-format2-posts ul li.format-link div.desc,div.blog-format2-posts ul li.format-quote div.quote,div.blog-format2-posts ul li.format-status div.desc,div.blog-format2-posts ul li.format-chat div.desc,div.blog-format2-posts ul li.format-chat img.avatar" => array( "prop" => "border-color" , "label" => __("Post Format Border Color",'ioa') , "default" => "#eee" ),
								
									)
						),
					
					array( 
							"label" => "Blog Full Posts Stylings" ,
							"matrix" => array(

										
										"div.blog-format4-posts ul li .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format4-posts ul li .hover i.hover-lightbox,div.blog-format4-posts ul li .hover i.hover-link" =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format4-posts ul li .hover i.hover-lightbox,div.blog-format4-posts ul li .hover i.hover-link " =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
									
										"div.blog-format4-posts ul li div.desc h2 a"=>  array( "prop" => "color" , "label" => __("Heading Color",'ioa') , "default" => "#666666" ),	

										"div.blog-format4-posts ul li div.desc a.read-more" =>  array( "prop" => "background-color" , "label" => __("Button Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.blog-format4-posts ul li div.desc a.read-more " =>  array( "prop" => "color" , "label" => __("Button Color",'ioa') , "default" => "#ffffff" ),
										"div.blog-format4-posts ul li div.desc a.read-more:hover" =>  array( "prop" => "background-color" , "label" => __("Button Hover Background Color",'ioa') , "default" => "#494949" ),
										"div.blog-format4-posts ul li div.desc a.read-more:hover " =>  array( "prop" => "color" , "label" => __("Button Hover Color",'ioa') , "default" => "#ffffff" ),
										
										"div.blog-format4-posts ul li div.extra" => array( "prop" => "border-color" , "label" => __("Extra Information Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.blog-format4-posts ul li div.extra " => array( "prop" => "color" , "label" => __("Extra Information Color",'ioa') , "default" => "#888888" ),
										"div.blog-format4-posts ul li div.extra a" => array( "prop" => "color" , "label" => __("Extra Information Link Color",'ioa') , "default" => "#666666" ),
										"div.blog-format4-posts ul li a.bottom-view-toggle" => array( "prop" => "color" , "label" => __("Bottom Arrow Color",'ioa') , "default" => "#444444" ),
										"div.blog-format4-posts ul li a.bottom-view-toggle " => array( "prop" => "background-color" , "label" => __("Bottom Arrow Background Color",'ioa') , "default" => "#ffffff" ),
										"div.blog-format4-posts ul li  a.bottom-view-toggle " => array( "prop" => "border-color" , "label" => __("Bottom Arrow Border Color",'ioa') , "default" => "#eeeeee" ),
										
									)
						),
					array( 
							"label" => "Blog Full Variation 1 Stylings" ,
							"matrix" => array( 

										"div.blog-format6-posts ul li" =>  array( "prop" => "color" , "label" => __("Post Color",'ioa') , "default" => "#444444" ),
										"div.blog-format6-posts ul li div.desc a.read-more" =>  array( "prop" => "border-color" , "label" => __("Button Border Color",'ioa') , "default" => "#444444" ),


								   )
						),
					array( 
							"label" => "Blog Full Variation 2 Stylings" ,
							"matrix" => array( 

										"div.blog-format7-posts ul li" =>  array( "prop" => "color" , "label" => __("Post Color",'ioa') , "default" => "#444444" ),
										"div.blog-format7-posts ul li span.spacer"  =>  array( "prop" => "background" , "label" => __("Below Extra Information Border Color",'ioa') , "default" => "#777777" ),

								   )
						),
					array( 
							"label" => "Blog Timeline Stylings" ,
							"matrix" => array(

										"div.posts-tree div.left-post,div.posts-tree div.right-post" =>  array( "prop" => "border-color" , "label" => __("Post Border Color",'ioa') , "default" => "#f4f4f4" ),	
										"div.posts-tree div.left-post,div.posts-tree div.right-post " =>  array( "prop" => "background-color" , "label" => __("Post Background Color",'ioa') , "default" => "#ffffff" ),	
										"div.posts-tree span.line" =>  array( "prop" => "background-color" , "label" => __("Connecting Line Color",'ioa') , "default" => "#eeeeee" ),	
										"div.posts-tree div.right-post span.dot,div.posts-tree div.right-post span.tip,div.posts-tree div.right-post span.connector,div.posts-tree div.left-post span.dot,div.posts-tree div.left-post span.tip,div.posts-tree div.left-post span.connector" =>  array( "prop" => "background-color" , "label" => __("Connecting Dots & Sub Line Color",'ioa') , "default" => "#eeeeee" ),	
										"div.posts-tree h4.month-label" =>  array( "prop" => "color" , "label" => __("Month Text Color",'ioa') , "default" => $dominant_color ,"sync" => true),	
										"div.posts-tree  h4.month-label " =>  array( "prop" => "background-color" , "label" => __("Month Background Color",'ioa') , "default" => "#ffffff" ),	
										"div.posts-tree h4.month-label " =>  array( "prop" => "border-color" , "label" => __("Month Border Color",'ioa') , "default" => $dominant_color ,"sync" => true),	
										
										"div.posts-tree h4.post-end" =>  array( "prop" => "color" , "label" => __("Posts End Area Color",'ioa') , "default" => "#ffffff" ),
										"div.posts-tree h4.post-end " =>  array( "prop" => "background-color" , "label" => __("Posts End Area Color",'ioa') , "default" => "#444444" ),

										"div.posts-tree .hover " =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => "#494949" ),
										"div.posts-tree .hover  i.hover-lightbox,div.posts-tree .hover i.hover-link" =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => "#494949" ),
										"div.posts-tree .hover  i.hover-lightbox,div.posts-tree .hover i.hover-link " =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
										
										"div.posts-tree div.left-post h3.title a,div.posts-tree div.right-post h3.title a" =>  array( "prop" => "color" , "label" => __("Heading Color",'ioa') , "default" => "#262A30" ),	

										"div.posts-tree div.left-post span.date,div.posts-tree div.right-post span.date" =>  array( "prop" => "color" , "label" => __("Date Color",'ioa') , "default" => "#ffffff" ),	
										"div.posts-tree div.left-post span.date,div.posts-tree div.right-post span.date " =>  array( "prop" => "background-color" , "label" => __("Date Background Color",'ioa') , "default" => "#777777" ),	

										"div.posts-tree div.left-post a.main-button,div.posts-tree div.right-post a.main-button" =>  array( "prop" => "background-color" , "label" => __("Button Background Color",'ioa') , "default" => "#777777" ),
										"div.posts-tree div.left-post a.main-button,div.posts-tree div.right-post a.main-button " =>  array( "prop" => "color" , "label" => __("Button Color",'ioa') , "default" => "#ffffff" ),
										"div.posts-tree div.left-post a.main-button:hover,div.posts-tree div.right-post a.main-button:hover" =>  array( "prop" => "background-color" , "label" => __("Button Hover Background Color",'ioa') , "default" => "#494949" ),
										"div.posts-tree div.left-post a.main-button:hover,div.posts-tree div.right-post a.main-button:hover " =>  array( "prop" => "color" , "label" => __("Button Hover Color",'ioa') , "default" => "#ffffff" ),
										
									)
						),

				)	,																
		
		__("Single Post Stylings",'ioa') => array( 

					array( 
							"label" => "Extra Information Stylings" ,
							"matrix" => array(
										"div.meta-info" =>  array( "prop" => "border-color" , "label" => __("Border Color",'ioa') , "default" => "#eeeeee" ),
										"div.meta-info " =>  array( "prop" => "color" , "label" => __("Text Color",'ioa') , "default" => "#757575" ),
										"div.meta-info div.inner-meta-info a" =>  array( "prop" => "color" , "label" => __("Links Color",'ioa') , "default" => "#333333" ),

								)
						),
					array( 
							"label" => "Post Tag Area Stylings" ,
							"matrix" => array(
										"div.post-tags " =>  array( "prop" => "border-color" , "label" => __("Tag Area Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.post-tags a" =>  array( "prop" => "color" , "label" => __("Tag Text Color",'ioa') , "default" => "#888888" ),
										"div.post-tags a " =>  array( "prop" => "background-color" , "label" => __("Tag Background Color",'ioa') , "default" => "#f4f4f4" ),

										"div.post-tags a:hover" =>  array( "prop" => "color" , "label" => __("Tag Text Hover Color",'ioa') , "default" => "#ffffff" ),
										"div.post-tags a:hover " =>  array( "prop" => "background-color" , "label" => __("Tag Background Hover Color",'ioa') , "default" => $dominant_color ,"sync" => true),

								)
						),
					array( 
							"label" => "Author Area Stylings" ,
							"matrix" => array(
										"#authorbox" =>  array( "prop" => "border-color" , "label" => __("Author Area Border Color",'ioa') , "default" => "#f4f4f4" ),
										"#authorbox .authortext h3" =>  array( "prop" => "color" , "label" => __("Heading Color",'ioa') , "default" => "#333333" ),
										"#authorbox .authortext p" =>  array( "prop" => "color" , "label" => __("Links Color",'ioa') , "default" => "#777777" ),

								)
						),

					array( 
							"label" => "Related Posts Area Stylings" ,
							"matrix" => array(
										"ul.single-related-posts li .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"ul.single-related-posts li .hover h3" =>  array( "prop" => "color" , "label" => __("Heading Color",'ioa') , "default" => "#ffffff" ),
										"ul.single-related-posts li .hover i" =>  array( "prop" => "color" , "label" => __("Icon Color",'ioa') , "default" => "#ffffff" ),
										"ul.single-related-posts li .hover i " =>  array( "prop" => "background-color" , "label" => __("Icon Background Color",'ioa') , "default" => "#12B8DB" ),
								)
						),

					array( 
							"label" => "Comment Stylings" ,
							"matrix" => array(
										"h2.comments-title" =>  array( "prop" => "border-color" , "label" => __("Comments Title Border Color",'ioa') , "default" => "#444444" ),
										"h2.comments-title " =>  array( "prop" => "color" , "label" => __("Comments Title Color",'ioa') , "default" => "#596A67" ),

										"#comments div.reply a" =>  array( "prop" => "color" , "label" => __("Reply Button Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"#comments div.reply a " =>  array( "prop" => "border-color" , "label" => __("Reply Button Border Color",'ioa') , "default" => $dominant_color ,"sync" => true),

										"#comments a#cancel-comment-reply-link" =>  array( "prop" => "color" , "label" => __("Cancel Button Color",'ioa') , "default" => "#ffffff" ),
										"#comments a#cancel-comment-reply-link " =>  array( "prop" => "background-color" , "label" => __("Cancel Button Background Color",'ioa') , "default" => "#D40A18" ),

										"div.image-info img,div.comment-body" =>  array( "prop" => "border-color" , "label" => __("Image & Comments Border Color",'ioa') , "default" => "#eeeeee" ),


										"#respond h3#reply-title" =>  array( "prop" => "border-color" , "label" => __("Reply Title Border Color",'ioa') , "default" => "#eeeeee" ),
										"#respond h3#reply-title " =>  array( "prop" => "color" , "label" => __("Reply Title Color",'ioa') , "default" => "#596A67" ),
										"#comments , #comments p " =>  array( "prop" => "color" , "label" => __("Comments Text Color",'ioa') , "default" => "#757575" ),
										"#comments a" =>  array( "prop" => "color" , "label" => __("Comments Link Color",'ioa') , "default" => "#333333" ),
										
										"#commentform label" =>  array( "prop" => "color" , "label" => __("Label Color",'ioa') , "default" => "#777777" ),
										"#commentform textarea,#commentform input[type=text]" =>  array( "prop" => "border-color" , "label" => __("Input & Textarea Border Color",'ioa') , "default" => "#dddddd" ),
										"#commentform textarea,#commentform input[type=text] " =>  array( "prop" => "color" , "label" => __("Input & Textarea Color",'ioa') , "default" => "#777777" ),
										"#commentform textarea, #commentform input[type=text] " =>  array( "prop" => "background-color" , "label" => __("Input & Textarea Background Color",'ioa') , "default" => "#ffffff" ),
										
										"#commentform code" =>  array( "prop" => "color" , "label" => __("Below Form, Allowed HTML Color",'ioa') , "default" => "#333333" ),

										"#commentform input[type=submit]" =>  array( "prop" => "color" , "label" => __("Submit Button Color",'ioa') , "default" => "#ffffff" ),
										"#commentform input[type=submit] " =>  array( "prop" => "background-color" , "label" => __("Submit Button Background Color",'ioa') , "default" => "#494949" ),

										"#commentform input[type=submit]:hover" =>  array( "prop" => "color" , "label" => __("Submit Button Hover Color",'ioa') , "default" => "#ffffff" ),
										"#commentform input[type=submit]:hover " =>  array( "prop" => "background-color" , "label" => __("Submit Button Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),

								)
						),


			 ),
		
		__("Portfolio Template Stylings",'ioa') => array( 
					
						array( 
							"label" => "Portfolio View Switcher" ,
							"matrix" => array(

										"div.portfolio-view" =>  array( "prop" => "background-color" , "label" => __("Switcher Area Background Color",'ioa') , "default" => "#fafafa" ),
										"div.portfolio-view a" =>  array( "prop" => "color" , "label" => __("Default Link Color",'ioa') , "default" => "#666666" ),
										"div.portfolio-view a.active" =>  array( "prop" => "color" , "label" => __("Active Link Color",'ioa') , "default" => "#ffffff" ),
										"div.portfolio-view a.active " =>  array( "prop" => "background-color" , "label" => __("Active Link Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),

								)
							), 
						array( 
							"label" => "Portfolio List Column" ,
							"matrix" => array(

										"div.portfolio-list ul li div.inner-item-wrap h2 a" =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#555555" ),
										"div.portfolio-list div.desc, div.portfolio-list div.desc p"  =>  array( "prop" => "border-color" , "label" => __("Portfolio Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.portfolio-list ul li div.inner-item-wrap  .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.portfolio-list ul li .hover .hover-link,div.portfolio-list ul li .hover .hover-lightbox"  =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.portfolio-list ul li .hover .hover-link,div.portfolio-list ul li .hover .hover-lightbox "  =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
										"div.portfolio-list ul li div.inner-item-wrap a.read-more "  =>  array( "prop" => "color" , "label" => __("Link  Color",'ioa') , "default" => "#ffffff" ),
										"div.portfolio-list ul li div.inner-item-wrap a.read-more  "  =>  array( "prop" => "background-color" , "label" => __("Link Background Color",'ioa') , "default" => "#46759B" ),

										"div.portfolio-list div.proxy-datearea "  =>  array( "prop" => "color" , "label" => __("Date Area  Color",'ioa') , "default" => "#ffffff" ),
										"div.portfolio-list div.proxy-datearea"  =>  array( "prop" => "background-color" , "label" => __("Date Area Background Color",'ioa') , "default" => "#46759B" ),
								)
							),
						array( 
							"label" => "Portfolio 1 Column" ,
							"matrix" => array(
										"div.one-column ul li" =>  array( "prop" => "background-color" , "label" => __("Items Background Color",'ioa') , "default" => "#ffffff" ),

										"div.one-column ul li div.inner-item-wrap h2 a" =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#555555" ),
										"div.one-column ul li div.inner-item-wrap p.tags a,div.one-column ul li div.inner-item-wrap p.tags" =>  array( "prop" => "color" , "label" => __("Category Tags Color",'ioa') , "default" => "#999999" ),
										"div.one-column ul li div.inner-item-wrap p.tags a:hover" =>  array( "prop" => "border-color" , "label" => __("Category Tags Hover Border Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.one-column ul li div.inner-item-wrap,div.one-column ul li div.inner-item-wrap div.desc"  =>  array( "prop" => "border-color" , "label" => __("Portfolio Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.one-column ul li div.inner-item-wrap  .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.one-column ul li .hover .hover-link,div.one-column ul li .hover .hover-lightbox"  =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.one-column ul li .hover .hover-link,div.one-column ul li .hover .hover-lightbox "  =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
								)
							),
						array( 
							"label" => "Portfolio 2 Column" ,
							"matrix" => array(
										"div.two-column ul li" =>  array( "prop" => "background-color" , "label" => __("Items Background Color",'ioa') , "default" => "#ffffff" ),

										"div.two-column ul li div.inner-item-wrap h2 a" =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#555555" ),
										"div.two-column ul li div.inner-item-wrap p.tags a,div.two-column ul li div.inner-item-wrap p.tags" =>  array( "prop" => "color" , "label" => __("Category Tags Color",'ioa') , "default" => "#999999" ),
										"div.two-column ul li div.inner-item-wrap p.tags a:hover" =>  array( "prop" => "border-color" , "label" => __("Category Tags Hover Border Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.two-column ul li div.inner-item-wrap,div.two-column ul li div.inner-item-wrap div.desc"  =>  array( "prop" => "border-color" , "label" => __("Portfolio Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.two-column ul li div.inner-item-wrap  .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.two-column ul li .hover .hover-link,div.two-column ul li .hover .hover-lightbox"  =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.two-column ul li .hover .hover-link,div.two-column ul li .hover .hover-lightbox "  =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
								)
							),		
						array( 
							"label" => "Portfolio 3 Column" ,
							"matrix" => array(
										"div.three-column ul li div.inner-item-wrap" =>  array( "prop" => "background-color" , "label" => __("Items Background Color",'ioa') , "default" => "#ffffff" ),

										"div.three-column ul li div.inner-item-wrap h2 a" =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#555555" ),
										"div.three-column ul li div.inner-item-wrap p.tags a,div.three-column ul li div.inner-item-wrap p.tags" =>  array( "prop" => "color" , "label" => __("Category Tags Color",'ioa') , "default" => "#999999" ),
										"div.three-column ul li div.inner-item-wrap p.tags a:hover" =>  array( "prop" => "border-color" , "label" => __("Category Tags Hover Border Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.three-column ul li div.inner-item-wrap,div.three-column ul li div.inner-item-wrap div.desc"  =>  array( "prop" => "border-color" , "label" => __("Portfolio Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.three-column ul li div.inner-item-wrap  .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.three-column ul li div.inner-item-wrap .hover .hover-lightbox,div.three-column ul li div.inner-item-wrap .hover .hover-link"  =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.three-column ul li div.inner-item-wrap .hover .hover-lightbox,div.three-column ul li div.inner-item-wrap .hover .hover-link "  =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
								)
							),
						array( 
							"label" => "Portfolio 4 Column" ,
							"matrix" => array(
										"div.four-column ul  li div.inner-item-wrap" =>  array( "prop" => "background-color" , "label" => __("Items Background Color",'ioa') , "default" => "#ffffff" ),

										"div.four-column ul li div.inner-item-wrap h2 a" =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#555555" ),
										"div.four-column ul li div.inner-item-wrap p.tags a,div.four-column ul li div.inner-item-wrap p.tags" =>  array( "prop" => "color" , "label" => __("Category Tags Color",'ioa') , "default" => "#999999" ),
										"div.four-column ul li div.inner-item-wrap p.tags a:hover" =>  array( "prop" => "border-color" , "label" => __("Category Tags Hover Border Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.four-column ul li div.inner-item-wrap,div.four-column ul li div.inner-item-wrap div.desc"  =>  array( "prop" => "border-color" , "label" => __("Portfolio Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.four-column ul li div.inner-item-wrap  .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.four-column ul li div.inner-item-wrap .hover .hover-lightbox,div.four-column ul li div.inner-item-wrap .hover .hover-link"  =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.four-column ul li div.inner-item-wrap .hover .hover-lightbox,div.four-column ul li div.inner-item-wrap .hover .hover-link "  =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
								)
							),
						
						array( 
							"label" => "Portfolio 5 Column" ,
							"matrix" => array(
										"div.five-column ul li div.inner-item-wrap" =>  array( "prop" => "background-color" , "label" => __("Items Background Color",'ioa') , "default" => "#ffffff" ),

										"div.five-column ul li div.inner-item-wrap h2 a" =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#555555" ),
										"div.five-column ul li div.inner-item-wrap p.tags a,div.five-column ul li div.inner-item-wrap p.tags" =>  array( "prop" => "color" , "label" => __("Category Tags Color",'ioa') , "default" => "#999999" ),
										"div.five-column ul li div.inner-item-wrap p.tags a:hover" =>  array( "prop" => "border-color" , "label" => __("Category Tags Hover Border Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.five-column ul li div.inner-item-wrap,div.five-column ul li div.inner-item-wrap div.desc"  =>  array( "prop" => "border-color" , "label" => __("Portfolio Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.five-column ul li div.inner-item-wrap  .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.five-column ul li div.inner-item-wrap .hover .hover-lightbox,div.five-column ul li div.inner-item-wrap .hover .hover-link"  =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.five-column ul li div.inner-item-wrap .hover .hover-lightbox,div.five-column ul li div.inner-item-wrap .hover .hover-link "  =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
								)
							),
						
						array( 
							"label" => "Portfolio Featured Column" ,
							"matrix" => array(

										"div.featured-column ul li.featured-block div.inner-item-wrap div.overlay" =>  array( "prop" => "background-color" , "label" => __("Featured Item Overlay Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.featured-column ul li.featured-block h2 a"	=>  array( "prop" => "color" , "label" => __("Featured Item Title Color",'ioa') , "default" => "#ffffff" ),
										"div.featured-column ul li.featured-block div.inner-item-wrap span.spacer"=>  array( "prop" => "border-color" , "label" => __("Featured Item Title Bottom Border",'ioa') , "default" => "#ffffff" ),
										"div.featured-column ul li.featured-block div.excerpt"=>  array( "prop" => "color" , "label" => __("Featured Item Text Color",'ioa') , "default" => "#ffffff" ),

										"div.featured-column span.spacer"=>  array( "prop" => "border-color" , "label" => __("Below Featured Item Divider",'ioa') , "default" => "#f4f4f4" ),


										"div.featured-column ul li div.title-area" =>  array( "prop" => "color" , "label" => __("Title Area Color",'ioa') , "default" => "#ffffff" ),
										"div.featured-column ul li div.title-area " =>  array( "prop" => "background-color" , "label" => __("Title Area Background Color",'ioa') , "default" => "#494949" ),
										"div.featured-column ul li div.inner-item-wrap .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.featured-column ul li div.inner-item-wrap .hover .hover-lightbox,div.featured-column ul li div.inner-item-wrap .hover .hover-link"  =>  array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.featured-column ul li div.inner-item-wrap .hover .hover-lightbox,div.featured-column ul li div.inner-item-wrap .hover .hover-link "  =>  array( "prop" => "background-color" , "label" => __("Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),
										"div.featured-column ul li div.excerpt"  =>  array( "prop" => "color" , "label" => __("Description Text Color",'ioa') , "default" => "#757575" ),
										
										"div.featured-column ul li a.read-more" =>  array( "prop" => "background-color" , "label" => __("Button Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.featured-column ul li a.read-more " =>  array( "prop" => "color" , "label" => __("Button Color",'ioa') , "default" => "#ffffff" ),
										"div.featured-column ul li a.read-more:hover" =>  array( "prop" => "background-color" , "label" => __("Button Hover Background Color",'ioa') , "default" => "#494949" ),
										"div.featured-column ul li a.read-more:hover " =>  array( "prop" => "color" , "label" => __("Button Hover Color",'ioa') , "default" => "#ffffff" ),
										"div.featured-column ul li div.inner-item-wrap div.desc" =>  array( "prop" => "border-color" , "label" => __("Item Description Border Color",'ioa') , "default" => "#f4f4f4" ),

								)
							),
						
						array( 
							"label" => "Product Gallery" ,
							"matrix" => array(

										"div.portfolio-gallery div.gallery-desc h4 " =>  array( "prop" => "background-color" , "label" => __("Title Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.portfolio-gallery div.gallery-desc h4 a" =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#ffffff" ),
										
										"div.portfolio-gallery div.gallery-desc div.caption"=>  array( "prop" => "background-color" , "label" => __("Caption Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),		
										"div.portfolio-gallery div.gallery-desc div.caption p" =>  array( "prop" => "color" , "label" => __("Caption Color",'ioa') , "default" => "#ffffff" ),

										"div.portfolio-gallery div.gallery-desc div.caption a.hover-link"	=>  array( "prop" => "color" , "label" => __("Link Color",'ioa') , "default" => "#ffffff" ),	
										"div.portfolio-gallery div.gallery-desc div.caption a.hover-link "	=>  array( "prop" => "background-color" , "label" => __("Link Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),

										" div.portfolio-gallery .seleneGallery ul.selene-thumbnails li" =>  array( "prop" => "border-color" , "label" => __("Thumbnails Border Color",'ioa') , "default" => "#f4f4f4" ),

										"div.portfolio-gallery div.ioa-gallery div.selene-controls-wrap a"	=>  array( "prop" => "color" , "label" => __("Controls Color",'ioa') , "default" => "#ffffff" ),
										"div.portfolio-gallery div.ioa-gallery div.selene-controls-wrap a "	=>  array( "prop" => "background-color" , "label" => __("Controls Background Color",'ioa') , "default" => "#000000" ),
								)
							),
						
						array( 
							"label" => "Full Screen Gallery" ,
							"matrix" => array(

										"div.portfolio-full-screen div.gallery-desc h4" =>  array( "prop" => "background-color" , "label" => __("Title Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.portfolio-full-screen div.gallery-desc h4 " =>  array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#ffffff" ),
										
										"div.portfolio-full-screen div.gallery-desc div.caption"=>  array( "prop" => "background-color" , "label" => __("Caption Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),		
										"div.portfolio-full-screen div.gallery-desc div.caption p" =>  array( "prop" => "color" , "label" => __("Caption Color",'ioa') , "default" => "#ffffff" ),

										"div.portfolio-full-screen div.gallery-desc div.caption a.hover-link"	=>  array( "prop" => "color" , "label" => __("Link Color",'ioa') , "default" => $dominant_color ,"sync" => true),	
										"div.portfolio-full-screen div.gallery-desc div.caption a.hover-link "	=>  array( "prop" => "background-color" , "label" => __("Link Background Color",'ioa') , "default" => "#ffffff" ),

										" div.portfolio-full-screen .seleneGallery ul.selene-thumbnails li" =>  array( "prop" => "border-color" , "label" => __("Thumbnails Border Color",'ioa') , "default" => "#f4f4f4" ),

										"div.portfolio-full-screen div.ioa-gallery div.selene-controls-wrap a"	=>  array( "prop" => "color" , "label" => __("Controls Color",'ioa') , "default" => "#ffffff" ),
										"div.portfolio-full-screen div.ioa-gallery div.selene-controls-wrap a "	=>  array( "prop" => "background-color" , "label" => __("Controls Background Color",'ioa') , "default" => "#000000" ),
								)
							),
						
						array( 
							"label" => "Portfolio Masonry" ,
							"matrix" => array(

										"div.portfolio-masonry ul li div.inner-item-wrap .hoverdir" =>  array( "prop" => "background-color" , "label" => __("Overlay Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.portfolio-masonry ul li div.inner-item-wrap .hoverdir " =>  array( "prop" => "color" , "label" => __("Overlay Text Color",'ioa') , "default" => "#ffffff" ),

										"div.portfolio-masonry ul li .hoverdir-wrap .hover-link" =>  array( "prop" => "color" , "label" => __("Overlay Icon  Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.portfolio-masonry ul li .hoverdir-wrap .hover-link " =>  array( "prop" => "background-color" , "label" => __("Overlay Icon Background Color",'ioa') , "default" => "#ffffff" ),
								)
							), 
						array( 
							"label" => "Portfolio Modelie" ,
							"matrix" => array(

										"div.view-pane ul li div.hover" =>  array( "prop" => "background-color" , "label" => __("Overlay Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.view-pane ul li div.hover " =>  array( "prop" => "color" , "label" => __("Overlay Background Color",'ioa') , "default" => "#ffffff" ),

										"div.view-pane ul li div.hover a.hover-lightbox,div.view-pane ul li div.hover a.hover-link" =>  array( "prop" => "color" , "label" => __("Overlay Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.view-pane ul li div.hover a.hover-lightbox,div.view-pane ul li div.hover a.hover-link " =>  array( "prop" => "background-color" , "label" => __("Overlay Icon Background Color",'ioa') , "default" => "#ffffff" ),
										"div.view-pane .jspTrack" =>  array( "prop" => "background-color" , "label" => __("Scroll Bar Area Background Color",'ioa') , "default" => "#f4f4f4" ),
										"div.view-pane .jspDrag"  =>  array( "prop" => "background-color" , "label" => __("Scroll Bar Background Color",'ioa') , "default" => "#999999" ),
								
								)
							),
						array( 
							"label" => "Portfolio Maeyra" ,
							"matrix" => array(

										"ul.portfolio-maerya-list li div.hover" =>  array( "prop" => "background-color" , "label" => __("Overlay Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"ul.portfolio-maerya-list li div.proxy" =>  array( "prop" => "background-color" , "label" => __("Overlay Text Area Background Color",'ioa') , "default" => "#ffffff" ),
										"ul.portfolio-maerya-list li div.proxy " =>  array( "prop" => "color" , "label" => __("Overlay Text Area Color",'ioa') , "default" => $dominant_color ,"sync" => true),

										"ul.portfolio-maerya-list li div.stub" =>  array( "prop" => "background-color" , "label" => __("Text Area Background Color",'ioa') , "default" => "#ffffff" ),
										"ul.portfolio-maerya-list li div.stub " =>  array( "prop" => "color" , "label" => __("Text Area Color",'ioa') , "default" => "#596A67" ),
										"ul.portfolio-maerya-list li div.stub p.tags a" =>  array( "prop" => "color" , "label" => __("Text Area Category Color",'ioa') , "default" => "#888888" ),
								
								)
							),
						
						array( 
							"label" => "Portfolio Metro" ,
							"matrix" => array(

										"div.portfolio-metro ul li div.inner-item-wrap" =>  array( "prop" => "background-color" , "label" => __("Post Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.portfolio-metro ul li div.inner-item-wrap " =>  array( "prop" => "color" , "label" => __("Post Color",'ioa') , "default" => "#ffffff" ),

										"div.portfolio-metro ul li div.inner-item-wrap .hover" =>  array( "prop" => "background-color" , "label" => __("Overlay Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),

										"div.portfolio-metro ul li div.inner-item-wrap .hover i.hover-lightbox,div.portfolio-metro ul li div.inner-item-wrap .hover i.hover-link" =>  array( "prop" => "color" , "label" => __("Overlay Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.portfolio-metro ul li div.inner-item-wrap .hover i.hover-lightbox,div.portfolio-metro ul li div.inner-item-wrap .hover i.hover-link " =>  array( "prop" => "background-color" , "label" => __("Overlay Icon Background Color",'ioa') , "default" => "#ffffff" ),
										"div.metro-wrapper .jspTrack" =>  array( "prop" => "background-color" , "label" => __("Scroll Bar Area Background Color",'ioa') , "default" => "#f4f4f4" ),
										"div.metro-wrapper .jspDrag"  =>  array( "prop" => "background-color" , "label" => __("Scroll Bar Background Color",'ioa') , "default" => "#999999" ),
								)
							),
				),
			
			__("Single Portfolio Styling",'ioa') => array(

					array( 
							"label" => "Extra Information Stylings" ,
							"matrix" => array(
										"div.portfolio div.meta-info" =>  array( "prop" => "border-color" , "label" => __("Border Color",'ioa') , "default" => "#eeeeee" ),
										"div.portfolio div.meta-info " =>  array( "prop" => "color" , "label" => __("Text Color",'ioa') , "default" => "#757575" ),
										"div.portfolio div.meta-info div.inner-meta-info a" =>  array( "prop" => "color" , "label" => __("Links Color",'ioa') , "default" => "#333333" ),

								)
						),
					array(
							"label" => "Portfolio Post Navigation" ,
							"matrix" => array( 
										"div.portfolio-navigation" =>   array( "prop" => "border-color" , "label" => __("Navigation Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.portfolio-navigation a,div.portfolio-navigation span" =>   array( "prop" => "color" , "label" => __("Links Color",'ioa') , "default" => "#666666" ),
										"div.portfolio-navigation a:hover,div.portfolio-navigation span:hover" =>   array( "prop" => "color" , "label" => __("Links Hover Color",'ioa') , "default" => "#666666" ),

								)
						),
					array(
						"label" => "Related Portfolio Items",
						"matrix" => array(

										"div.related_posts-title-area h3" =>   array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#596A67" ),
										"div.portfolio ul.single-related-posts li .hover" =>  array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.portfolio ul.single-related-posts li .hover h3" =>  array( "prop" => "color" , "label" => __("Heading Color",'ioa') , "default" => "#ffffff" ),
										"div.portfolio ul.single-related-posts li .hover i" =>  array( "prop" => "color" , "label" => __("Icon Color",'ioa') , "default" => "#ffffff" ),
										"div.portfolio ul.single-related-posts li .hover i " =>  array( "prop" => "background-color" , "label" => __("Icon Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
								
							)

						),
					array(

						"label" => "Modelie Stylings",	
						"matrix" => array(
							"div.single-portfolio-modelie div.view-pane .jspTrack" =>  array( "prop" => "background-color" , "label" => __("Scroll Bar Area Background Color",'ioa') , "default" => "#f4f4f4" ),
							"div.single-portfolio-modelie div.view-pane .jspDrag"  =>  array( "prop" => "background-color" , "label" => __("Scroll Bar Background Color",'ioa') , "default" => "#999999" ),
								
							
							)
						),
					array(
						"label" => "Full Screen Template",
						"matrix" => array(
										"div.single-full-screen-view-pane div.gallery-desc h4"  =>   array( "prop" => "background-color" , "label" => __("Title Background Color",'ioa') , "default" => "#ffffff" ),
										"div.single-full-screen-view-pane div.gallery-desc h4 "  =>   array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#596A67" ),

										"div.single-full-screen-view-pane div.gallery-desc div.caption"  =>   array( "prop" => "background-color" , "label" => __("Caption Background Color",'ioa') , "default" => "#ffffff" ),
										"div.single-full-screen-view-pane div.gallery-desc div.caption "  =>   array( "prop" => "color" , "label" => __("Caption Color",'ioa') , "default" => "#757575" ),

										"div.single-full-screen-view-pane .seleneGallery div.selene-controls-wrap a" =>   array( "prop" => "color" , "label" => __("Controls Color",'ioa') , "default" => "#555555" ),
										"div.single-full-screen-view-pane .seleneGallery div.selene-controls-wrap a " =>   array( "prop" => "background-color" , "label" => __("Controls Background Color",'ioa') , "default" => "#ffffff" ),
							)
						),
					array(
						"label" => "Proportional Gallery Template",
						"matrix" => array(
										"div.single-prop-screen-view-pane div.gallery-desc h4"  =>   array( "prop" => "background-color" , "label" => __("Title Background Color",'ioa') , "default" => "#ffffff" ),
										"div.single-prop-screen-view-pane div.gallery-desc h4 "  =>   array( "prop" => "color" , "label" => __("Title Color",'ioa') , "default" => "#596A67" ),

										"div.single-prop-screen-view-pane div.gallery-desc div.caption"  =>   array( "prop" => "background-color" , "label" => __("Caption Background Color",'ioa') , "default" => "#ffffff" ),
										"div.single-prop-screen-view-pane div.gallery-desc div.caption "  =>   array( "prop" => "color" , "label" => __("Caption Color",'ioa') , "default" => "#757575" ),

										"div.single-prop-screen-view-pane .seleneGallery div.selene-controls-wrap a" =>   array( "prop" => "color" , "label" => __("Controls Color",'ioa') , "default" => "#555555" ),
										"div.single-prop-screen-view-pane .seleneGallery div.selene-controls-wrap a " =>   array( "prop" => "background-color" , "label" => __("Controls Background Color",'ioa') , "default" => "#ffffff" ),
							)
						),

				),
		__("Contact Styling",'ioa') => array(

				array(
						"label" => "Contact Form 7 Stylings",
						"matrix" => array(
										"form.wpcf7-form p" =>   array( "prop" => "color" , "label" => __("Label Color",'ioa') , "default" => "#757575" ),
										"form.wpcf7-form .wpcf7-text,form.wpcf7-form .wpcf7-textarea"  =>   array( "prop" => "border-color" , "label" => __("Text Field's Border Color",'ioa') , "default" => "#eeeeee" ),
										"form.wpcf7-form .wpcf7-text,form.wpcf7-form .wpcf7-textarea "  =>   array( "prop" => "color" , "label" => __("Text Field's  Color",'ioa') , "default" => "#666666" ),
										"form.wpcf7-form  .wpcf7-text,form.wpcf7-form .wpcf7-textarea "  =>   array( "prop" => "background-color" , "label" => __("Text Field's Background Color",'ioa') , "default" => "#ffffff" ),
										
										"form.wpcf7-form .wpcf7-submit" =>   array( "prop" => "color" , "label" => __("Submit Button Color",'ioa') , "default" => "#ffffff" ),
										"form.wpcf7-form .wpcf7-submit " =>   array( "prop" => "background-color" , "label" => __("Submit Button Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),

										"form.wpcf7-form .wpcf7-submit:hover" =>   array( "prop" => "color" , "label" => __("Submit Button Hover Color",'ioa') , "default" => "#ffffff" ),
										"form.wpcf7-form .wpcf7-submit:hover " =>   array( "prop" => "background-color" , "label" => __("Submit Button Hover Background Color",'ioa') , "default" => adjustBrightness($dominant_color,-30) ,"sync" => true , "dark" => true),

							)
						),
				array(
						"label" => "Sticky Contact Stylings",
						"matrix" => array(
										"div.sticky-contact" =>   array( "prop" => "background-color" , "label" => __("Sticky Area Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"div.sticky-contact a.trigger" =>   array( "prop" => "color" , "label" => __("Sticky Icon Color",'ioa') , "default" => "#ffffff" ),
										"div.sticky-contact a.trigger " =>   array( "prop" => "background-color" , "label" => __("Sticky Icon Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										".inner-sticky-contact p"  =>   array( "prop" => "color" , "label" => __("Sticky Area Text Color",'ioa') , "default" => "#ffffff" ),
										".inner-sticky-contact input[type=text] , .inner-sticky-contact input[type=email] , .inner-sticky-contact textarea"  =>   array( "prop" => "color" , "label" => __("Sticky Area Input Color",'ioa') , "default" => "#888888" ),
										".inner-sticky-contact input[type=submit]"  =>   array( "prop" => "color" , "label" => __("Sticky Area Submit Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										".inner-sticky-contact input[type=submit] "  =>   array( "prop" => "background-color" , "label" => __("Sticky Area Submit Background Color",'ioa') , "default" => "#ffffff" ),
										".inner-sticky-contact input[type=submit]:hover"  =>   array( "prop" => "color" , "label" => __("Sticky Area Submit Color",'ioa') , "default" => "#ffffff" ),
										".inner-sticky-contact input[type=submit]:hover "  =>   array( "prop" => "background-color" , "label" => __("Sticky Area Submit Background Color",'ioa') , "default" => "#464646" ),
							)			
						),
				array(
						"label" => "Contact Template Stylings",
						"matrix" => array(
										"div.address-mutual-wrap" =>   array( "prop" => "border-color" , "label" => __("Address Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.address-mutual-wrap " =>   array( "prop" => "color" , "label" => __("Address  Color",'ioa') , "default" => "#777777" ),

							)
						),

			),
		__('Shortcode Stylings','ioa') => array(

			array( 
						"label" => "Shortcode Stylings",
						"matrix" => array(
										"div.separator.sep-default,div.separator.sep-dotted,div.separator.sep-dashed,div.separator.sep-double" =>   array( "prop" => "border-color" , "label" => __("Divider Color",'ioa') , "default" => "#dddddd" ),
										"div.power-title span.spacer" =>   array( "prop" => "border-color" , "label" => __("Power Title Bottom Color",'ioa') , "default" => "#ffffff" ),
										"a.toggle-title " =>   array( "prop" => "color" , "label" => __("Toggle Title Color",'ioa') , "default" => "#444444" ),
										"a.toggle-title" =>   array( "prop" => "border-color" , "label" => __("Toggle Title Bottom Color",'ioa') , "default" => "#eeeeee" ),
										"a.toggle-title i" =>   array( "prop" => "color" , "label" => __("Toggle Icon Color",'ioa') , "default" => "#777777" ),
										".google-map"  =>   array( "prop" => "border-color" , "label" => __("Google Map Border Color",'ioa') , "default" => "#eeeeee" ),
										".ui-tabs .tab-content,.tabs-align-left .ui-tabs .tab-content,.tabs-align-right .ui-tabs .tab-content"  =>   array( "prop" => "border-color" , "label" => __("Tabs Border Color",'ioa') , "default" => "#f4f4f4" ),
										".magic-list-wrapper ul li"  =>   array( "prop" => "border-color" , "label" => __("Magic list Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.testimonial_bubble-wrapper div.image"  =>   array( "prop" => "border-color" , "label" => __("Testimonial Border Color",'ioa') , "default" => "#f4f4f4" ),
										"ul.tweets li,div.tweets-wrapper.slider"=>   array( "prop" => "border-color" , "label" => __("Tweets Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.tweets-wrapper.slider .bx-wrapper .bx-prev, div.tweets-wrapper.slider .bx-wrapper .bx-next"  =>   array( "prop" => "color" , "label" => __("Tweets Scrollable Controls Color",'ioa') , "default" => "#ffffff" ),
										"div.tweets-wrapper.slider .bx-wrapper .bx-prev, div.tweets-wrapper.slider .bx-wrapper .bx-next "  =>   array( "prop" => "background-color" , "label" => __("Tweets Scrollable Controls Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
							

							)			
						),
			array(
						"label" => "Posts Stylings",
						"matrix" => array(

							'ul.posts-grid li div.image'  =>   array( "prop" => "border-color" , "label" => __("Posts Grid Border Color",'ioa') , "default" => "#46759b" ),
							'.hoverable .hover i'  =>   array( "prop" => "color" , "label" => __("Hover Icon Color",'ioa') , "default" => "#46759b" ),
							'.hoverable .hover i '  =>   array( "prop" => "background-color" , "label" => __("Hover Background Color",'ioa') , "default" => "#ffffff" ),

							'ul.posts li div.image a.hover'  =>   array( "prop" => "background-color" , "label" => __("Posts Grid Hover Background Color",'ioa') , "default" => "#46759b" ),
							'ul.posts-grid div.extras i,ul.posts-grid div.extras'  =>   array( "prop" => "color" , "label" => __("Posts Grid Extras Color",'ioa') , "default" => "#46759b" ),
							

							'ul.posts-grid h2 a' =>   array( "prop" => "color" , "label" => __("Posts Grid Title Color",'ioa') , "default" => "#333333" ),
							'ul.posts-grid h2 a' =>   array( "prop" => "color" , "label" => __("Posts Grid Title Color",'ioa') , "default" => "#525252" ),
							'ul.posts-grid li div.desc'  =>   array( "prop" => "color" , "label" => __("Posts Grid Text Color",'ioa') , "default" => "#777777" ),
							'ul.thumb-list div.image'  =>   array( "prop" => "border-color" , "label" => __("Posts List Border Color",'ioa') , "default" => "#f4f4f4" ),
							'ul.thumb-list li '  =>   array( "prop" => "border-color" , "label" => __("Posts List Border Color",'ioa') , "default" => "#f4f4f4" ),
							'ul.thumb-list li h2 a' =>   array( "prop" => "color" , "label" => __("Posts List Title Color",'ioa') , "default" => "#646464" ),
							'ul.thumb-list li h2 a:hover' =>   array( "prop" => "bottom-color" , "label" => __("Posts List Title Hover Underline Color",'ioa') , "default" => "#cccccc" ),
							'ul.thumb-list div.desc'  =>   array( "prop" => "color" , "label" => __("Posts List Text Color",'ioa') , "default" => "#777777" ),
							'.bx-wrapper .bx-prev,.bx-wrapper .bx-next' =>   array( "prop" => "color" , "label" => __("Posts Scrollable Controls Color",'ioa') , "default" => "#ffffff" ),
							'.bx-wrapper .bx-prev,.bx-wrapper .bx-next ' =>   array( "prop" => "background-color" , "label" => __("Posts Scrollable Controls Background Color",'ioa') , "default" => "#000000" ),
							'div.scrollable div.slide div.image a.hover'  =>   array( "prop" => "background-color" , "label" => __("Posts Scrollable Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
							'div.scrollable a.hover .hover-link' =>   array( "prop" => "color" , "label" => __("Posts Scrollable Hover Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
							'div.scrollable a.hover .hover-link '  =>   array( "prop" => "background-color" , "label" => __("Posts Scrollable Hover Icon Background Color",'ioa') , "default" => "#ffffff" ),

							),

				 ),
			array( 
						"label" => "Pricing Table Stylings",
						"matrix" => array(
										"div.pricing-table  div.plan" =>   array( "prop" => "background-color" , "label" => __("Plans Background Color",'ioa') , "default" => "#ffffff" ),
										"div.pricing-table  div.plan " =>   array( "prop" => "border-color" , "label" => __("Plans Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.pricing-table div.plan h6" =>   array( "prop" => "color" , "label" => __("Plan Name Color",'ioa') , "default" => "#777777" ),
										"div.pricing-table div.plan h6 " =>   array( "prop" => "border-color" , "label" => __("Plan Name Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.pricing_area h2" =>   array( "prop" => "color" , "label" => __("Pricing Color",'ioa') , "default" => "#333333" ),
										"div.pricing_area span.suffix"  =>   array( "prop" => "color" , "label" => __("Pricing Suffix Color",'ioa') , "default" => "#999999" ),
										"div.pricing-table ul.pricing-row,div.pricing-table ul.pricing-row li" =>   array( "prop" => "border-color" , "label" => __("Plan Rows Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.pricing-table  ul.pricing-row li " =>   array( "prop" => "color" , "label" => __("Plan Rows Color",'ioa') , "default" => "#888888" ),
										"ul.pricing-row li.sign-up a" =>   array( "prop" => "color" , "label" => __("Sign Up Color",'ioa') , "default" => "#ffffff" ),
										"ul.pricing-row li.sign-up a " =>   array( "prop" => "background-color" , "label" => __("Sign Up Background Color",'ioa') , "default" => "#222222" ),
										"div.feature-column" =>   array( "prop" => "background-color" , "label" => __("Feature Area Background Color",'ioa') , "default" => "#ffffff" ),
										"div.feature-column " =>   array( "prop" => "border-color" , "label" => __("Feature Area Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.feature-column div.feature_area h2"  =>   array( "prop" => "color" , "label" => __("Feature Area Title Color",'ioa') , "default" => "#777777" ),
										"div.feature-column div.feature_area span.info"  =>   array( "prop" => "color" , "label" => __("Feature Area Information Color",'ioa') , "default" => "#909090" ),
										"div.pricing-table div.feature-column ul.pricing-row li " =>   array( "prop" => "color" , "label" => __("Plan Rows Color",'ioa') , "default" => "#888888" ),
										
										"div.pricing-table div.featured-plan.plan" =>   array( "prop" => "background-color" , "label" => __("Featured Plan Background Color",'ioa') , "default" => "#ffffff" ),
										"div.pricing-table div.featured-plan.plan " =>   array( "prop" => "border-color" , "label" => __("Featured Plan Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.pricing-table div.featured-plan.plan h6" =>   array( "prop" => "color" , "label" => __("Featured Plan Name Color",'ioa') , "default" => "#777777" ),
										"div.pricing-table div.featured-plan.plan h6 " =>   array( "prop" => "border-color" , "label" => __("Featured Plan Name Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.pricing-table div.featured-plan.plan h2" =>   array( "prop" => "color" , "label" => __("Featured Pricing Color",'ioa') , "default" => "#333333" ),
										"div.pricing-table div.featured-plan.plan span.suffix"  =>   array( "prop" => "color" , "label" => __("Featured Pricing Suffix Color",'ioa') , "default" => "#999999" ),
										"div.pricing-table div.featured-plan.plan ul.pricing-row,div.pricing-table div.featured-plan.plan ul.pricing-row li" =>   array( "prop" => "border-color" , "label" => __("Featured Plan Rows Border Color",'ioa') , "default" => "#f4f4f4" ),
										"div.pricing-table div.featured-plan.plan ul.pricing-row li " =>   array( "prop" => "color" , "label" => __("Featured Plan Rows Color",'ioa') , "default" => "#888888" ),
										"div.pricing-table div.featured-plan.plan ul.pricing-row li.sign-up a" =>   array( "prop" => "color" , "label" => __("Featured Sign Up Color",'ioa') , "default" => "#ffffff" ),
										"div.pricing-table div.featured-plan.plan ul.pricing-row li.sign-up a " =>   array( "prop" => "background-color" , "label" => __("Featured Sign Up Background Color",'ioa') , "default" => "#bf0000" ),

										)
						),	

		 ),
		__('Sitemap Stylings','ioa') => array(

			array( 
						"label" => "Sitemap Stylings",
						"matrix" => array(
										"div.sitemap h2" =>   array( "prop" => "color" , "label" => __("Sitemap Heading Color",'ioa') , "default" => "#596a67" ),
										"div.sitemap h2 " =>   array( "prop" => "border-color" , "label" => __("Sitemap Heading Border Color",'ioa') , "default" => "#dddddd" ),
										"div.sitemap h5" =>   array( "prop" => "color" , "label" => __("Sitemap Heading Color",'ioa') , "default" => "#666666" ),
										"div.sitemap ul li a" =>   array( "prop" => "color" , "label" => __("Sitemap Link Color",'ioa') , "default" => "#444444" ),
										"div.sitemap ul li" =>   array( "prop" => "border-color" , "label" => __("List Border Color",'ioa') , "default" => "#eeeeee" ),
							)
						),

		 ),
		__("404 Styling",'ioa') => array(

				array(
						"label" => "Search Stylings",
						"matrix" => array(
										"div.error-search input[type=text]"  =>   array( "prop" => "border-color" , "label" => __("Text Field's Border Color",'ioa') , "default" => "#eeeeee" ),
										"div.error-search input[type=text] "  =>   array( "prop" => "color" , "label" => __("Text Field's  Color",'ioa') , "default" => "#616268" ),
										"div.error-search input[type=text]  "  =>   array( "prop" => "background-color" , "label" => __("Text Field's Background  Color",'ioa') , "default" => "#ffffff" ),
										
										"div.error-search input[type=submit]" =>   array( "prop" => "color" , "label" => __("Submit Button Color",'ioa') , "default" => "#ffffff" ),
										"div.error-search input[type=submit] " =>   array( "prop" => "background-color" , "label" => __("Submit Button Background Color",'ioa') , "default" => "#494949" ),

										"div.error-search input[type=submit]:hover" =>   array( "prop" => "color" , "label" => __("Submit Button Hover Color",'ioa') , "default" => "#ffffff" ),
										"div.error-search input[type=submit]:hover " =>   array( "prop" => "background-color" , "label" => __("Submit Button Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),

							)
						),

			),

		__("Mobile & Tablets Styling",'ioa') => array(

				array(
						"label" => "Mobile Top bar Stylings",
						"matrix" => array(
										"div.mobile-head"  =>   array( "prop" => "background-color" , "label" => __("Area Background Color",'ioa') , "default" => "#ffffff" ),
										"a.mobile-menu , a.mobile-menu:visited"  =>   array( "prop" => "color" , "label" => __("Mobile Menu Icon Color",'ioa') , "default" => $dominant_color ,"sync" => true),
										"a.mobile-menu , a.mobile-menu:visited "  =>   array( "prop" => "background-color" , "label" => __("Mobile Menu Icon Background Color",'ioa') , "default" => "#ffffff" ),
										
										"a.mobile-menu:hover"  =>   array( "prop" => "color" , "label" => __("Mobile Menu Icon Hover Color",'ioa') , "default" => "#ffffff" ),
										"a.mobile-menu:hover "  =>   array( "prop" => "background-color" , "label" => __("Mobile Menu Icon Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),

										"a.majax-search-trigger"  =>   array( "prop" => "color" , "label" => __("Search Icon Color",'ioa') , "default" => "#aaaaaa" ),
										"a.majax-search-trigger "  =>   array( "prop" => "background-color" , "label" => __("Search Icon Background Color",'ioa') , "default" => "#ffffff" ),

										"a.sidebar-mobile-menu"  =>   array( "prop" => "color" , "label" => __("Sidebar Icon Color",'ioa') , "default" => "#444444" ),
										"a.sidebar-mobile-menu "  =>   array( "prop" => "background-color" , "label" => __("Sidebar Icon Color",'ioa') , "default" => "#ffffff" ),

										"a.mobile-menu ,a.sidebar-mobile-menu, a.majax-search-trigger"  =>   array( "prop" => "border-color" , "label" => __("Icons Border Color",'ioa') , "default" => "#f4f4f4" ),


							)
						),
				array(
						"label" => "Mobile Search Area Stylings",
						"matrix" => array(

												"div.majax-search-pane"  =>  array( "prop" => "background-color" , "label" => __("Search Bar Color",'ioa') , "default" => "#ffffff" ),
												"a.majax-search-close"  =>  array( "prop" => "color" , "label" => __("Close Icon Color",'ioa') , "default" => "#cccccc" ),
												"div.majax-search-pane div.form input[type=text]"  =>  array( "prop" => "color" , "label" => __("Search Text Color",'ioa') , "default" => "#657079" ),
											    "div.msearch-results ul li div.desc a.more,div.msearch-results ul li a.view-all"  =>  array( "prop" => "color" , "label" => __("Button Color",'ioa') , "default" => "#ffffff" ),
											    "div.msearch-results ul li div.desc a.more,div.msearch-results ul li a.view-all "  =>  array( "prop" => "background-color" , "label" => __("Button Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
											 	"div.msearch-results ul li h5 a" => array( "prop" => "color" , "label" => __("Titles Color",'ioa') , "default" => "#5b6770" ),
											 	"div.msearch-results ul li div.image img"  =>  array( "prop" => "border-color" , "label" => __("Image Border Color",'ioa') , "default" => "#f4f4f4" ),
											 	"div.msearch-results ul li"  =>  array( "prop" => "border-color" , "label" => __("Search Results Border Color",'ioa') , "default" => "#f4f4f4" ),
											 	"div.msearch-results ul li div.desc span.date" => array( "prop" => "color" , "label" => __("Extra Information Color",'ioa') , "default" => "#999999" ),
											 	"div.msearch-results strong" => array( "prop" => "color" , "label" => __("Extra Information Page Type Color",'ioa') , "default" => $dominant_color ,"sync" => true),
											 	)
					),
				array(
						"label" => "Mobile Menu Area Stylings",
						"matrix" => array(

												"#mobile-menu,div.mobile-side-wrap,#mobile-side-menu"  =>  array( "prop" => "background-color" , "label" => __("Menu Area Color",'ioa') , "default" => "#ffffff" ),
												"#mobile-menu "  =>  array( "prop" => "border-color" , "label" => __("Menu Area Border Color",'ioa') , "default" => "#eeeeee" ),
											
												"#mobile-menu li a,#mobile-side-menu li a"  =>  array( "prop" => "color" , "label" => __("Menu Area Link Color",'ioa') , "default" => "#444444" ),
												"#mobile-menu li ul.sub-menu,#mobile-side-menu li ul.sub-menu"  =>  array( "prop" => "border-color" , "label" => __("Sub Menu Area Border Color",'ioa') , "default" => "#f4f4f4" ),
												"#mobile-menu .sub-menu>li.current-menu-item>a ,  #mobile-menu .sub-menu>li.current_page_item>a,#mobile-menu .sub-menu>li.current-menu-parent>a ,#mobile-menu .menu>li.current-menu-parent>a,#mobile-menu .sub-menu>li.current-menu-ancestor>a,#mobile-side-menu .sub-menu>li.current-menu-item>a ,  #mobile-menu .sub-menu>li.current_page_item>a,#mobile-side-menu .sub-menu>li.current-menu-parent>a ,#mobile-side-menu .menu>li.current-menu-parent>a ,#mobile-menu .sub-menu>li.current-menu-ancestor>a"  =>  array( "prop" => "color" , "label" => __("Active Menu Color",'ioa') , "default" => "#fff" ),
												"#mobile-menu .sub-menu>li.current-menu-item>a ,  #mobile-menu .sub-menu>li.current_page_item>a,#mobile-menu .sub-menu>li.current-menu-parent>a ,#mobile-menu .menu>li.current-menu-parent>a,#mobile-menu .sub-menu>li.current-menu-ancestor>a ,#mobile-side-menu .sub-menu>li.current-menu-item>a ,  #mobile-menu .sub-menu>li.current_page_item>a,#mobile-side-menu .sub-menu>li.current-menu-parent>a ,#mobile-side-menu .menu>li.current-menu-parent>a ,#mobile-menu .sub-menu>li.current-menu-ancestor>a "  =>  array( "prop" => "background-color" , "label" => __("Active Menu Background Color",'ioa') , "default" => $dominant_color ,"sync" => true),
												
												"#mobile-menu li a:hover, #mobile-side-menu li a:hover"  =>  array( "prop" => "color" , "label" => __("Menu Hover  Color",'ioa') , "default" => "#ffffff" ),
												"#mobile-menu li a:hover, #mobile-side-menu li a:hover "  =>  array( "prop" => "background-color" , "label" => __("Menu Hover Background Color",'ioa') , "default" => $dominant_color ,"sync" => true ),
												
												"#mobile-menu .jspTrack"  =>  array( "prop" => "background-color" , "label" => __("Scrollbar Area Background Color",'ioa') , "default" => "#f5f5f5" ),
												"#mobile-menu .jspDrag "  =>  array( "prop" => "background-color" , "label" => __("Scrollbar Background Color",'ioa') , "default" => "#999999" ),

											
											)
					),
				array(
						"label" => "Tablet Sidebar Area Stylings",
						"matrix" => array(
					   "div.super-wrapper .flexi-sidebar.sidebar,#res-sidebar-trigger"	=>  array( "prop" => "background-color" , "label" => __("Flex Sidebar Background Color",'ioa') , "default" => "#ffffff" ),
					   "#res-sidebar-trigger "	=>  array( "prop" => "color" , "label" => __("Flex Sidebar Icon Color",'ioa') , "default" => "#222222" ),
					   "#res-sidebar-trigger"	=>  array( "prop" => "border-color" , "label" => __("Flex Sidebar Icon Border Color",'ioa') , "default" => "#eeeeee" ),

						),

					),
						
			),
			
			);
