<?php 
global $helper,$ioa_portfolio_slug,$ioa_portfolio_name;

$mode = false;

$sliders = array();

$query = new WP_Query("post_type=slider&posts_per_page=-1&post_status=publish");  
while ($query->have_posts()) : $query->the_post(); $sliders[get_the_ID()] = get_the_title(); endwhile; 

$query = new WP_Query("post_type=custompost&posts_per_page=-1&post_status=publish");  

$post_type_array = array("post" => __("Post",'ioa') , $ioa_portfolio_slug => $ioa_portfolio_name);

while ($query->have_posts()) : $query->the_post(); 
		$coptions = get_post_meta(get_the_ID(),'options',true);
		$w = $helper->getAssocMap($coptions,'value');
		$post_type_array[$w['post_type']] = get_the_title();
endwhile; 

$testimonials = get_posts('post_type=testimonial');
$ts = array();
foreach ($testimonials as $post) {
   $ts[$post->ID] = get_the_title($post->ID) ;
}


$ioa_shortcodes_array = array(

	__("Layout Elements",'ioa') => array(

			"icon" => "credit-card",
			"shortcodes" => array(
					
					"column-maker" => array(
						    "stripable" => true,
							"name" =>  __("Visual Column Builder",'ioa'),
							"syntax" => '',
							"description" =>  __("Allows you to create columns quickly",'ioa'),
							"custom" => true
							),	
					"col" => array(
							"name" =>  __("Column",'ioa'),
							"syntax" => '[col width="one_half" last=""] '.__('Your Content Here..','ioa').' [/col]',
							"description" =>  __("This allows you to create a properly spaced layout column",'ioa'),
							"parameters" =>  array( "width" => "values : one_fifth,one_forth,one_third,one_half,two_third,three_fourth,four_fifth,full" ,"last" => __("If column is last in the row set value to true. If will clear float problem of layouts. Values : true/false",'ioa') )
							,"inputs" => array(

									"width" => array("type" => "select" , "label" => __("Column Width",'ioa') , 'values' =>  array("one_fifth"=> __("One Fifth",'ioa') ,"one_fourth"=> __("One Fourth",'ioa') ,"one_third"=> __("One Third",'ioa') ,"one_half"=> __("One Half",'ioa') ,"two_third"=> __("Two Third",'ioa') ,"three_fourth"=> __("Three Fourth",'ioa') ,"four_fifth"=> __("Four Fifth",'ioa') ,"full"=> __("Full Width",'ioa') ) ) ,
									"last" =>  array("type" => "select",  "label" => __("Last Column of Row ?",'ioa'), 'values' =>  array("false"=> __("No",'ioa'),"true"=> __("Yes",'ioa') )  )

								),
					"content" => true									
							),
					"power_title" => array(
							"name" =>  __("Power Title",'ioa'),
							"syntax" => '[power_title color=""] '.__('Your Content Here..','ioa').' [/power_title]',
							"description" =>  __("This allows you to create beautiful headings",'ioa'),
							"parameters" =>  array( "color" => "color of title." )
							,"inputs" => array(

									"color" => array("type" => "colorpicker" , "label" => __("Title Color",'ioa') , 'values' => "" ) ,

								),
					"content" => true,
					"content_label" => __("Set Title",'ioa'),
					"content_type" => "text"									
							)			
				)

		),
	__("UI Elements",'ioa') => array(

			"icon" => "db-shape",
			"shortcodes" => array(

					"post_author" => array(
							"name" =>  __("Post Author",'ioa'),
							"syntax" => '[post_author_posts_link/]',
							"description" =>  __("Gets Current Post's Author with link to it's posts",'ioa'),
							"parameters" =>  array( "" => __("None",'ioa')  )
							),	
					"post_date" => array(
							"name" =>  __("Post Date",'ioa'),
							"syntax" => '[post_date format="l, F d S, Y"/]',
							"description" =>  __("Gets Current Post's date",'ioa'),
							"parameters" =>  array( "format" => sprintf( __("takes standard PHP date format, You can refer to format table %s .",'ioa') , "<a href='http://codex.wordpress.org/Formatting_Date_and_Time'>".__('here','ioa')."</a>"  ) )
							),					
					"post_time" => array(
							"name" =>  __("Post Time",'ioa'),
							"syntax" => '[post_time format="g:i a"/]',
							"description" =>  __("Gets Current Post's Time",'ioa'),
							"parameters" =>  array( "format" => sprintf( __("takes standard PHP date format, You can refer to format table %s .",'ioa') , "<a href='http://codex.wordpress.org/Formatting_Date_and_Time'>".__('here','ioa')."</a>"  ) )
							),	
					"post_tags" => array(
							"name" =>  __("Post Tags",'ioa'),
							"syntax" => '[post_tags sep="," icon="" /]',
							"description" =>  __("Gets Current Post's tags",'ioa'),
							"parameters" =>  array( "icon" => __("Icon Before Tags are display.",'ioa') , "sep" => __("Separator between tags, by default they are separated by comma.",'ioa')  )
							),	
					"post_categories" => array(
							"name" =>  __("Post Categories",'ioa'),
							"syntax" => '[post_categories sep="," icon="" /]',
							"description" =>  __("Gets Current Post's categories",'ioa'),
							"parameters" =>  array( "icon" => __("Icon Before Categories are display.",'ioa') , "sep" => __("Separator between categories, by default they are separated by comma.",'ioa')  )
							),
					"climate_icon" => array(
							"name" =>  __("Animated Climate Icon",'ioa'),
							"syntax" => '[climate_icon color="" width="120" height="120" type="" /]',
							"description" =>  __("Creates an animated Icon",'ioa'),
							"parameters" =>  array( "type" => __("Type of Icon. Values are :",'ioa')."rain,partly cloudy day,partly cloudy night,clear day,clear night,cloudy,fog,sleet,snow,wind" , "width" => __("Width of Icon",'ioa') , "height" => __("Height of Icon",'ioa'), "color" => __("Color of the Icon",'ioa')    )
							,"inputs" => array(

									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Weather Icon Color','ioa') ,  
														'values' =>  "" ,
													),
									"width" => array(
														"type" => "text" , 
														"label" => __('Icon Width','ioa') ,  
														'values' =>  "120" ,
													),
									"height" => array(
														"type" => "text" , 
														"label" => __('Icon Height','ioa') ,  
														'values' =>  "120" ,
													),

									"type" => array(
														"type" => "select",
														"label" => __('Select Weather','ioa'),
														"values" => array(
																		 "rain" => __('Rain','ioa'), 
																		 "partly cloudy day" => __('Partly Cloudy Day','ioa') ,
																		 "partly cloudy night" => __('Partly Cloudy Night','ioa'),
																		 "clear day" => __('Clear Day','ioa'),
																		 "clear night" => __('Clear Night','ioa') ,
																		 "cloudy" => __('Cloudy','ioa'),
																		 "fog" => __('Fog','ioa'),
																		 "sleet" => __('Sleet','ioa') ,
																		 "snow" => __('Snow','ioa') ,
																		 "wind" => __('Wind','ioa') 
																	)
													)
									
								)
							),

					"get" => array(
							"name" =>  __("Get Post Meta Field",'ioa'),
							"syntax" => '[get field="" /]',
							"description" =>  __("Gets the post meta field that have been generated in content types",'ioa'),
							"parameters" =>  array( "field" => __("Meta Field Name",'ioa')   )
							,"inputs" => array(

									"field" => array(
														"type" => "text" , 
														"label" => __('Post Meta Field Name','ioa') ,  
														'values' =>  "" ,
													),
									
									
								)
							),
					"button" =>array(
							"name" =>  __("Create Button",'ioa'),
							"syntax" => '[button size="normal" color="" background="" radius="3px" type="flat" link="" newwindow="" icon="" ]'.__('Button Label').'[/button]',
							"description" =>  __("Create buttons with following options",'ioa'),
							"parameters" =>  array( "size" => __("Button size small,normal or large",'ioa') ,
													"color" => __("Text Color",'ioa') ,
													"background" => __("Background Color",'ioa'),
													"radius" => __("Corner Radius",'ioa'),
													"type" => __("Button Style type - flat,classic,gloss,gradient",'ioa'),
													"link" => __("Link",'ioa'),
													"newwindow" => __("Open link in new window : true/false",'ioa'),
													"icon" => __("Add icon",'ioa')  ,
													"class" => "has-input-button" 
													 )
							,"inputs" => array(

									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Button Text Color','ioa') ,  
														'values' =>  "" 
														),
									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Button Background Color','ioa') ,  
														'values' =>  "" ,					
													),
									"icon" => array(
														"type" => "icon",
														"label" => __('Add Icon for Button','ioa'),
														"values" => ""
													),
									"type" => array(
														"type" => "select",
														"label" => __('Select button style','ioa'),
														"values" => array(
																		 "flat" => __('Flat','ioa'), 
																		 "classic" => __('Classic','ioa') ,
																		 "gloss" => __('Gloss','ioa'),
																		 "gradient" => __('Gradient','ioa'),
																	)
													),
									"size" => array(
														"type" => "select",
														"label" => __('Select Button Size','ioa'),
														"values" => array(
																		 "small" => __('Small','ioa'), 
																		 "medium" => __('Medium','ioa') ,
																		 "large" => __('Large','ioa'),
																	)
													),
									"radius" => array(
														"type" => "text",
														"label" => __('Enter Border Radius in px(ex 10px)','ioa'),
														"values" => "0px"
													),
									"link" => array(
														"type" => "text",
														"label" => __('Enter Button Link','ioa'),
														"values" => "http://"
													),
									"newwindow" => array(
														"type" => "select",
														"label" => __('Link should open in new window ?','ioa'),
														"values" => array(
																		 "false" => __('No','ioa'), 
																		 "true" => __('Yes','ioa') ,
																	)
													)
									
								),
					"content" => true,
					"content_label" => __("Add Button Label",'ioa'),
					"content_type" => "text"
							),

					"icon" =>array(
							"name" =>  __("Icon",'ioa'),
							"syntax" => '[icon size="14px" color="" background="" radius="3px" type="" spacing="10px" /]',
							"description" =>  __("Create icon with following options",'ioa'),
							"parameters" =>  array( "size" => __("Button size in px",'ioa') ,
													"color" => __("Text Color",'ioa') ,
													"background" => __("Background Color",'ioa'),
													"radius" => __("Corner Radius",'ioa'),
													"type" => __("icon type",'ioa'),
													"spacing" => __("padding from corners of icon",'ioa')   
													 )
							,"inputs" => array(

									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Icon Color','ioa') ,  
														'values' =>  "" 
														),
									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Icon Background Color','ioa') ,  
														'values' =>  "" ,					
													),
									"type" => array(
														"type" => "icon",
														"label" => __('Set Icon','ioa'),
														"values" => ""
													),
									"size" => array(
														"type" => "text",
														"label" => __('Enter Size in px(ex 10px)','ioa'),
														"values" => "14px"
													),
									"radius" => array(
														"type" => "text",
														"label" => __('Enter Border Radius in px(ex 10px)','ioa'),
														"values" => "0px"
													),
									"spacing" => array(
														"type" => "text",
														"label" => __('Enter Spacing in px(ex 10px) from corners','ioa'),
														"values" => "0px"
													),
																		
								)

							),
					

					

					"divider" =>array(
							"name" =>  __("Divider",'ioa'),
							"syntax" => '[divider type="default" vspace="10px" hspace="10px" /]',
							"description" =>  __("Add dividers between content",'ioa'),
							"parameters" =>  array( "vspace" => __("Vertical Distance in px",'ioa') ,
													"hspace" => __("Horizontal Distance in px",'ioa') ,
													"type" => __("type, options can be default,dotted,dashed and double",'ioa'),
													 )
							,"inputs" => array(

									"vspace" => array(
														"type" => "text" , 
														"label" => __('Vertical Spacing','ioa') ,  
														'values' =>  "10px" 
														),
									"hspace" => array(
														"type" => "text" , 
														"label" => __('Horizontal Spacing','ioa') ,  
														'values' =>  "0%" 
														),
									"type" => array(
														"type" => "select",
														"label" => __('Select Style','ioa'),
														"values" => array(
																		 "default" => __('Line','ioa'), 
																		 "dotted" => __('Dotted','ioa') ,
																		 "dashed" => __('Dashed','ioa') ,
																		 "double" => __('Double','ioa') ,
																	)
													)
									
									
								)
							),

					"map" =>array(
							"name" =>  __("Google Map",'ioa'),
							"syntax" => '[map height="300" width="300" address="" view="m" /]',
							"description" =>  __("Add google map ",'ioa'),
							"parameters" =>  array( "height" => __("height of map in px",'ioa') ,
													"width" => __("width of map in px",'ioa') ,
													"address" => __("address to show on map",'ioa'),
													"view" => __("map view type, options :m,k,h,p",'ioa')
													 )
							,"inputs" => array(

									"height" => array(
														"type" => "text" , 
														"label" => __('Height of Map','ioa') ,  
														'values' =>  "300px" 
														),
									"width" => array(
														"type" => "text" , 
														"label" => __('Width of Map','ioa') ,  
														'values' =>  "300px" 
														),
									"address" => array(
														"type" => "textarea" , 
														"label" => __('Address where you want to show in Map','ioa') ,  
														'values' =>  "" 
														),
									"view" => array(
														"type" => "select",
														"label" => __('Select Map View','ioa'),
														"values" => array(
																		 "m" => __('Normal','ioa'), 
																		 "k" => __('Satellite','ioa') ,
																		 "h" => __('Hybrid','ioa') ,
																		 "p" => __('Terrain','ioa') ,
																	)
													)
									
									
								)
							),
					"word_drop" =>array(
							"name" =>  __("Word Drop",'ioa'),
							"syntax" => '[word_drop color="" background="" effect="fade"][/word_drop]',
							"description" =>  __("Highlight words ",'ioa'),
							"parameters" =>  array( "color" => __("color of text",'ioa') ,
													"background" => __("background color of text",'ioa') ,
													"effect" => __("effect to show on visibility",'ioa'),
													 ),
							"content" => true,
							"content_label" => __("Set Content",'ioa'),
							"content_type" => "text",	
							"inputs" => array(
									
									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Word Color','ioa') ,  
														'values' =>  "" 
														),
									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Word Background Color','ioa') ,  
														'values' =>  "" ,					
													),
									"effect" => array(
														"type" => "select",
														"label" => __('Select Effect on word visibility','ioa'),
														"values" =>  array(

																			"none" => __("None",'ioa'), 
																			"fade" => __("Fade In" ,'ioa'), 
																			"fade-left" => __("Fade from Left",'ioa') , 
																			"fade-top" => __("Fade from Top",'ioa') , 
																			"fade-bottom" => __("Fade from Bottom",'ioa') ,
																			"fade-right" => __("Fade from Right",'ioa') , 
																			"scale-in" => __("Scale In",'ioa') ,
																			"scale-out" => __("Scale Out",'ioa') , 
																			"big-fade-left" => __("Long Fade from Left",'ioa') , 
																			"big-fade-right" => __("Long Fade from Right",'ioa'), 
																			"big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , 
																			"big-fade-top" => __("Long Fade from Top",'ioa')    
																	)
													)
									)
							),
					
				)

		),
	__("Widgets Elements",'ioa') => array(

			"icon" => "monitor",
			"shortcodes" => array(

					"slider" => array(
							"name" =>  __("Slider",'ioa'),
							"syntax" => '[slider id="" /]',
							"description" =>  __("This allows you to embed slider/gallery from Media MAnager.",'ioa'),
							"parameters" =>  array( "id" => __("Slider ID",'ioa')  )
							,"inputs" => array(

									"id" => array(
														"type" => "select" , 
														"label" => __('Select Slider','ioa') ,  
														"values" =>  $sliders
														),
								
									)
							),	
					"self_video" => array(
							"name" =>  __("Self Hosted Video",'ioa'),
							"syntax" => '[self_video url="" video_fallback="" /]',
							"description" =>  __("This allows you to embed video.",'ioa'),
							"parameters" =>  array( "width" => __("Video Width",'ioa') ,"height" => __("Maximum Height",'ioa') )
							,"inputs" => array(

									"url" => array(
														"type" => "text" , 
														"label" => __('Video URL','ioa') ,  
														'values' =>  "" 
														),
									"video_fallback" => array(
														"type" => "upload" , 
														"label" => __('Fallback Image for older browsers','ioa') ,  
														'values' =>  "" 
														)
									),
							),		
					"video" => array(
							"name" =>  __("Video",'ioa'),
							"syntax" => '[video width="" height=""] '.__('Video URL Here','ioa').' [/video]',
							"description" =>  __("This allows you to embed video.",'ioa'),
							"parameters" =>  array( "width" => __("Video Width",'ioa') ,"height" => __("Maximum Height",'ioa') )
							,"inputs" => array(

									"width" => array(
														"type" => "text" , 
														"label" => __('Video Width','ioa') ,  
														'values' =>  "300" 
														),
									"height" => array(
														"type" => "text" , 
														"label" => __('Video Maximum Height','ioa') ,  
														'values' =>  "250" 
														)
									),
							"content" => true,
							"content_label" => __("Enter Video URL",'ioa'),
							"content_type" => "text"
							),		
					"soundcloud" =>array(
							"name" =>  __("Sound Cloud",'ioa'),
							"syntax" => '[soundcloud url="http://api.soundcloud.com/tracks/109467484" params="" width=" 100%" height="166" iframe="true" /]',
							"description" =>  __("Embed Sound Cloud, you can also embed directly goto audio page. Click on share, select code from Wordpress Code(last text field) and paste it in editor.",'ioa'),
							"parameters" =>  array( "vspace" => __("url for audio",'ioa') ,
													"width" => __("width of audio player",'ioa') ,
													"height" => __("height of audio player",'ioa'),
													 )
							,"inputs" => array(

									"url" => array(
														"type" => "text" , 
														"label" => __('Enter Embed URL','ioa') ,  
														'values' =>  "http://api.soundcloud.com/tracks/109467484" 
														),
									"width" => array(
														"type" => "text" , 
														"label" => __('Enter Width','ioa') ,  
														'values' =>  "100%" 
														),
									"height" => array(
														"type" => "text" , 
														"label" => __('Enter Height','ioa') ,  
														'values' =>  "166px" 
														),
									
									
								)
							),

					"pricing_table" => array(
							"name" =>  __("Pricing Tables",'ioa'),
							"syntax" => '[pricing_table] [feature_column title="Features" info="Some info here" row_data="Feature 1,Feature 2,Feature 3,Feature 4" /] [column plan_name="Plan 1" plan_price="35" plan_price_info="monthly" row_data="Data 1,Data 2,Data 3" button_label="Sign Up" button_link="#"  " featured=false /] [/pricing_table]',
							"description" => sprintf(  __("This allows you to create pricing tables, %1s has no options, It is a wrapper.%2s Adds a left feature description column. It is optional. %3s has the options below .",'ioa'), "[pricing_table]" , "[feature_column]", "[column]"),
							"parameters" =>  array( "plan_name" => __("Name of Table Plan",'ioa') ,"plan_price" => __("Pricing Area",'ioa'),"plan_price_info" => __("Suffix after Price",'ioa') ,"row_data" => __("Comma separated values that will show as table rows",'ioa') ,"button_label" => __("Label of Button",'ioa') ,"button_link" => __("Button Label",'ioa'),"featured" => __("Set it to true if you want column to stand out. Values are true/false",'ioa') )
							),
					"list" => array(
							"name" =>  __("List",'ioa'),
							"syntax" => '[list icon="" color="" data="" /]',
							"description" =>  __("This allows you to create list.",'ioa'),
							"parameters" =>  array( "icon" => __("Code of Icon",'ioa') ,"color" => __("Color",'ioa'),"data" => __("List values separated by ;(semicolon)",'ioa')  )
							,"inputs" => array(

									"icon" => array(
														"type" => "icon" , 
														"label" => __('Set Icon','ioa') ,  
														'values' =>  "ioa-front-icon ok-2icon-" 
														),
									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set List Icon Color','ioa') ,  
														'values' =>  "" 
														),
									"data" => array(
														"type" => "text" , 
														"label" => __('Add list items separated by semi colon(;)','ioa') ,  
														'values' =>  "row 1;row 2;row 3" 
														)
									),
							),
					
					"ioa_accordion" => array(
							"name" =>  __("Accordion",'ioa'),
							"syntax" => '[ioa_accordion width="100%"][section title="Section Title" background="" color=""]'.__('Content Here...','ioa').'[/section][/ioa_accordion]',
							"description" =>  __("You can create collapsible panels. Section represents each panel.",'ioa'),
							"parameters" =>  array( "title" => __("Title of section",'ioa') , "background" => __("Background Color",'ioa') , "color" => __("Panel Color",'ioa') )
							,"parent_input" => array(

								"width" => array(
														"type" => "text" , 
														"label" => __('Set Width','ioa') ,  
														'values' =>  "" 
														),
							)
							,"module" => array(

									"title" => array(
														"type" => "text" , 
														"label" => __('Set Title','ioa') ,  
														'values' =>  "" 
														),
									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Text Color','ioa') ,  
														'values' =>  "" 
														),
									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),

									"scontent" => array(
														"type" => "textarea" , 
														"label" => __('Set Accordion Content','ioa') ,  
														'values' =>  "" 
														),

								),
							'mod_label' => __("Accordion",'ioa'),
							'mod_unit' => __(' Section','ioa'),
							'mod_applier' => __('section','ioa'),
							'mod_parent' => __('ioa_accordion','ioa')
							),
					"power_accordion" => array(
							"name" =>  __("Power Accordion",'ioa'),
							"syntax" => '[power_accordion width="100%" blocks="4" ][psection title="Section Title" icon="" background="" color=""]'.__('Content Here...','ioa').'[/psection][/power_accordion]',
							"description" =>  __("You can create overlay panels. Section represents each panel.",'ioa'),
							"parameters" =>  array( "title" => __("Title of section",'ioa') , "background" => __("Background Color",'ioa') , "color" => __("Panel Color",'ioa') ,"icon" => __("Icon for Panels",'ioa') )
							,"parent_input" => array(

								"width" => array(
														"type" => "text" , 
														"label" => __('Set Width','ioa') ,  
														'values' =>  "" 
														),
								"blocks" => array(
														"type" => "text" , 
														"label" => __('Number of Block','ioa') ,  
														'values' =>  "" 
														),
							),
							"module" => array(

									"title" => array(
														"type" => "text" , 
														"label" => __('Set Title','ioa') ,  
														'values' =>  "" 
														),
									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Text Color','ioa') ,  
														'values' =>  "" 
														),
									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),

									"scontent" => array(
														"type" => "textarea" , 
														"label" => __('Set Accordion Content','ioa') ,  
														'values' =>  "" 
														),

								),
							'mod_label' => __("Power Accordion",'ioa'),
							'mod_unit' => __(' Section','ioa'),
							'mod_applier' => __('psection','ioa'),
							'mod_parent' => __('power_accordion','ioa')
							),
					"props" => array(
							"stripable" => true,
							"name" =>  __("Props",'ioa'),
							"syntax" => '[props width="500px" height="500px"][prop left="0" top="0" effect="fade" delay="0" image=""][/prop][/props]',
							"description" =>  __("Create Amazing animated images sets.",'ioa'),
							"parameters" =>  array( "left" => __("Distance from Left of Parent",'ioa'), "top" => __("Distance from Top of Parent",'ioa') ,"effect" => __("Effect of image on visibility",'ioa') , "delay" => __("Delay on starting of animation",'ioa') , "image" => __("Image Source",'ioa')  )
							,"parent_input" => array(

								"width" => array(
														"type" => "text" , 
														"label" => __('Set Width','ioa') ,  
														'values' =>  "" 
														),
								"height" => array(
														"type" => "text" , 
														"label" => __('Set Height','ioa') ,  
														'values' =>  "" 
														),
							)
							,"module" => array(

									"left" => array(
														"type" => "text" , 
														"label" => __('Set Left value from Container','ioa') ,  
														'values' =>  "" 
														),
									"top" => array(
														"type" => "text" , 
														"label" => __('Set Top value from Container','ioa') ,  
														'values' =>  "" 
														),
									"delay" => array(
														"type" => "text" , 
														"label" => __('Set Time Delay for Animation to occur','ioa') ,  
														'values' =>  "" 
														),
									"image" => array(
														"type" => "upload" , 
														"label" => __('Set Image','ioa') ,  
														'values' =>  "" 
														),
									"effect" => array(
														"type" => "select",
														"label" => __('Select Effect on visibility','ioa'),
														"values" =>  array(

																			"none" => __("None",'ioa'), 
																			"fade" => __("Fade In" ,'ioa'), 
																			"fade-left" => __("Fade from Left",'ioa') , 
																			"fade-top" => __("Fade from Top",'ioa') , 
																			"fade-bottom" => __("Fade from Bottom",'ioa') ,
																			"fade-right" => __("Fade from Right",'ioa') , 
																			"scale-in" => __("Scale In",'ioa') ,
																			"scale-out" => __("Scale Out",'ioa') , 
																			"big-fade-left" => __("Long Fade from Left",'ioa') , 
																			"big-fade-right" => __("Long Fade from Right",'ioa'), 
																			"big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , 
																			"big-fade-top" => __("Long Fade from Top",'ioa')    
																	)
													)

								),
							'mod_label' => __("Props",'ioa'),
							'mod_unit' => __(' Prop','ioa'),
							'mod_applier' => __('prop','ioa'),
							'mod_parent' => __('props','ioa')
							),
					"toggle" => array(
							"name" =>  __("Toggle",'ioa'),
							"syntax" => '[toggle title="Your Title Here" collapse="true"]'.__('Content Here...','ioa').'[/toggle]',
							"description" =>  __("You can create toggle with this shortcode unlike accordion they are independent.",'ioa'),
							"parameters" =>  array( "title" => __("Title of toggle",'ioa')  ,"collapse" => __("Set true to set toggle to open by default.",'ioa') )
							,"inputs" => array(

									"title" => array(
														"type" => "text" , 
														"label" => __('Enter Toggle Title','ioa') ,  
														'values' =>  "" 
														),
									"collapse" => array(
														"type" => "select",
														"label" => __('Toggle should open on page load ?','ioa'),
														"values" => array(
																		 "true" => __('No','ioa') ,
																		 "false" => __('Yes','ioa'), 
																	)
													),
									),
							"content" => true,
							"content_label" => __("Enter Toggle Content",'ioa'),
							"content_type" => "textarea"
							),
					"box" => array(
							"name" =>  __("Information Box",'ioa'),
							"syntax" => '[box close="false" color="#777" icon="" ]'.__('Content Here...','ioa').'[/box]',
							"description" =>  __("You can create information boxes.",'ioa'),
							"parameters" =>  array( "close" => __("Shows close icon",'ioa')  ,"color" => __("Set color of box here",'ioa') , "icon" => __("Set Icon Here",'ioa') )
							,"inputs" => array(

									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set box color','ioa') ,  
														'values' =>  "" 
														),
									"icon" => array(
														"type" => "icon" , 
														"label" => __('Set Box Icon','ioa') ,  
														'values' =>  "" 
														),
									"close" => array(
														"type" => "select",
														"label" => __('Show Close Icon ?','ioa'),
														"values" => array(
																		 "false" => __('No','ioa'), 
																		 "true" => __('Yes','ioa') ,
																	)
													)
									
									),
							"content" => true,
							"content_label" => __("Enter Box Content",'ioa'),
							"content_type" => "textarea"
							),
					
					"cta" => array(
							"name" =>  __("CTA",'ioa'),
							"syntax" => '[cta label="Click Me" link="" background="#3e606f" effect="" ][/cta]',
							"description" => __("You can create call to action areas ",'ioa' ),
							"parameters" =>  array(  "label" => __("Button Label",'ioa')   ,"link" => __("Button Link",'ioa') , "background" => __("background color of cta",'ioa') , "effect" => __("effect of button on hover",'ioa')   )
							,"inputs" => array(

									"label" => array(
														"type" => "text" , 
														"label" => __('Button Label','ioa') ,  
														'values' =>  "" 
														),

									"link" => array(
														"type" => "text" , 
														"label" => __('Button Link','ioa') ,  
														'values' =>  "" 
														),
									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),
									"effect" => array(
														"type" => "select",
														"label" => __('Select Effect for button on hover','ioa'),
														"values" =>  array("none" => __("None",'ioa'), "flash" => __("Flash",'ioa') , "bounce" => __("Bounce",'ioa') , "shake" => __("Shake",'ioa') , "tada" => __("Tada",'ioa') ,"swing" => __("Swing",'ioa') , "wobble" => __("Wobble",'ioa') , "wiggle" => __("Wiggle",'ioa') , "pulse" => __("Pulse",'ioa'))
													)
									),
							"content" => true,
							"content_label" => __("Enter CTA Content",'ioa'),
							"content_type" => "textarea"
							),
					"tabs" => array(
							"name" =>  __("Tabs",'ioa'),
							"syntax" => '[tabs align="top"][tab title="Tab 1" background="" color="" icon=""][/tab][/tabs]',
							"description" =>  __("You can create tabs with this.[tabs] is the parent wrapper with option of tab alignment : top , left, bottom and right. ",'ioa' ),
							"parameters" =>  array(  "title" => __("Tab title",'ioa')   , "color" => __("text color of tab",'ioa')   , "background" => __("background color of tab",'ioa') , "icon" => __("set icon for tab area",'ioa')  )
							,"parent_input" => array(

								"align" => array(
														"type" => "select" , 
														"label" => __('Set Tab Layout','ioa') ,  
														'values' =>  array("top" => "Top","left" => "Left","right" => "Right","bottom" => "Bottom")
														),
							),"module" => array(

									"title" => array(
														"type" => "text" , 
														"label" => __('Set Title','ioa') ,  
														'values' =>  "" 
														),
									"icon" => array(
														"type" => "icon" , 
														"label" => __('Set Icon','ioa') ,  
														'values' =>  "" 
														),
									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Text Color','ioa') ,  
														'values' =>  "" 
														),
									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),

									"scontent" => array(
														"type" => "textarea" , 
														"label" => __('Set Tab Content','ioa') ,  
														'values' =>  "" 
														),

								),
							'mod_label' => __("Tabs",'ioa'),
							'mod_unit' => __(' Tab','ioa'),
							'mod_applier' => __('tab','ioa'),
							'mod_parent' => __('tabs','ioa')
							),	
					"magic_list" => array(
							"name" =>  __("Magic List",'ioa'),
							"syntax" => '[magic_list][magic_item title="List Item 1" background="" color="" icon="" image=""]content here[/magic_item][/magic_list]',
							"description" =>  __("You can create awesome animated lists with magic list, magic list is a parent wrapper. magic_item contains all major options. Below are the supported parameters",'ioa' ),
							"parameters" =>  array(  "title" => __("List item title",'ioa')   , "color" => __("Text color of list item",'ioa')   , "background" => __("background color of item",'ioa') , "icon" => __("set icon for list item",'ioa') , "image" => __("if you want a image instead of inbuild icons, use this. Max dimensions 20px",'ioa')  )
							
							,"module" => array(

									"title" => array(
														"type" => "text" , 
														"label" => __('Set Title','ioa') ,  
														'values' =>  "" 
														),
									"icon" => array(
														"type" => "icon" , 
														"label" => __('Set Icon','ioa') ,  
														'values' =>  "" 
														),
									"image" => array(
														"type" => "upload" , 
														"label" => __('Set Image(max width 25px)','ioa') ,  
														'values' =>  "" 
														),
									
									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),

									"scontent" => array(
														"type" => "textarea" , 
														"label" => __('Set List Content','ioa') ,  
														'values' =>  "" 
														),

								),
							'mod_label' => __("Items",'ioa'),
							'mod_unit' => __(' Item','ioa'),
							'mod_applier' => __('magic_item','ioa'),
							'mod_parent' => __('magic_list','ioa')
							),
					"image" => array(

							"name" =>  __("Image",'ioa'),
							"syntax" => '[image src="" resize="none" lightbox="false"  align="none" width="100%" height="250" link="" hoverbg="#1ed8ee" hoverc="" effect="" /]',
							"description" =>  __(" You can add images with effects",'ioa' ),
							"parameters" =>  array(  

													"src" => __("Image source",'ioa')  ,
													"resize" => __("resize Image",'ioa')  ,
													"align" => __("align image left,right or center",'ioa') , 
													"width" => __("Width of image",'ioa')  ,
													"height" => __("Height of image",'ioa') , 
													"link" => __("add link to image",'ioa') , 
													"hoverbg" => __("overlay background color of link",'ioa') , 
													"hoverc" => __("overlay  color of link",'ioa') , 
													"effect" => __("affect of image on visibility",'ioa') , 
													"title" => __("Image Title",'ioa') , 

													)
							,"inputs" => array(

									"src" => array(
														"type" => "upload" , 
														"label" => __('Add Image','ioa') ,  
														'values' =>  "" 
														),
									"width" => array(
														"type" => "text" , 
														"label" => __('Width','ioa') ,  
														'values' =>  "" 
														),
									"height" => array(
														"type" => "text" , 
														"label" => __('Height','ioa') ,  
														'values' =>  "" 
														),

									"title" => array(
														"type" => "text" , 
														"label" => __('Title','ioa') ,  
														'values' =>  "" 
														),
									"link" => array(
														"type" => "text" , 
														"label" => __('Link','ioa') ,  
														'values' =>  "" 
														),
									"hoverbg" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Overlay Background Color','ioa') ,  
														'values' =>  "" 
														),
									"hoverc" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Overlay Color','ioa') ,  
														'values' =>  "" 
														),
									"lightbox" => array(
														"type" => "select",
														"label" => __('Use Lightbox to show bigger images','ioa'),
														"values" => array(
																		 "false" => __('No','ioa'),	
																		 "true" => __('Yes','ioa'), 
																	)
													),
									"resize" => array(
														"type" => "select",
														"label" => __('Image Resize','ioa'),
														"values" => array(
																		 "none" => __('None','ioa'), 	
																		 "hard" => __('Hard Crop','ioa'), 
																		 "proportional" => __('Proportional','ioa') ,
																		 "hproportional" => __('Width Proportional','ioa') ,
																		 "wproportional" => __('Height Proportional','ioa') ,
																	)
													),
									
									"align" => array(
														"type" => "select",
														"label" => __('Set Image Alignment','ioa'),
														"values" => array(
															 			 "none" => __('None','ioa'),	
																		 "left" => __('Left','ioa'), 
																		 "right" => __('Right','ioa'), 
																		 "center" => __('Center','ioa'), 
																	)
													),
									"effect" => array(
														"type" => "select",
														"label" => __('Select Effect on visibility','ioa'),
														"values" =>  array(

																			"none" => __("None",'ioa'), 
																			"fade" => __("Fade In" ,'ioa'), 
																			"fade-left" => __("Fade from Left",'ioa') , 
																			"fade-top" => __("Fade from Top",'ioa') , 
																			"fade-bottom" => __("Fade from Bottom",'ioa') ,
																			"fade-right" => __("Fade from Right",'ioa') , 
																			"scale-in" => __("Scale In",'ioa') ,
																			"scale-out" => __("Scale Out",'ioa') , 
																			"big-fade-left" => __("Long Fade from Left",'ioa') , 
																			"big-fade-right" => __("Long Fade from Right",'ioa'), 
																			"big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , 
																			"big-fade-top" => __("Long Fade from Top",'ioa')    
																	)
													),
									
																		
									),
							),	

							

				)

		),
	__("Infographics",'ioa') => array(

			"icon" => "line-graph",
			"shortcodes" => array(

				

					"radial_counter" => array(
							"stripable" => true,
							"name" =>  __("Radial Counter",'ioa'),
							"syntax" => '[radialchart width="100" font_size="72"  line_width="20" percent="70" bar_color="" track_color=""][/radialchart]',
							"description" =>  __("You can create radial counter with this shortcode.",'ioa'),
							"parameters" =>  array( "width" => __("width of counter",'ioa')  ,"font_size" => __("Set font size of counter",'ioa') , "line_width" => __("Width of Arc",'ioa'), "percent" => __("Ending value between 0 to 100",'ioa')  , "bar_color" => __("Color of Arc",'ioa') ,"track_color" => __("Color of Track",'ioa')  )
							,"inputs" => array(
									"bar_color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set bar color','ioa') ,  
														'values' =>  "" 
														),
									"track_color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set track color','ioa') ,  
														'values' =>  "" 
														),
									"width" => array(
														"type" => "text" , 
														"label" => __('Set counter width','ioa') ,  
														'values' =>  "" 
														),
									"font_size" => array(
														"type" => "text" , 
														"label" => __('Set font size of counter text','ioa') ,  
														'values' =>  "" 
														),
									"line_width" => array(
														"type" => "text" , 
														"label" => __('line width of arc','ioa') ,  
														'values' =>  "20" 
														),
									"percent" => array(
														"type" => "text" , 
														"label" => __('Set percent','ioa') ,  
														'values' =>  "70" 
														),
																										
								),
								"content" => true,									
									"content_label" => __("Set Label",'ioa'),
									"content_type" => "text"			
							),
					"progress_bar" => array(
							"name" =>  __("Progress Bars",'ioa'),
							"syntax" => '[progress_set][progress_bar unit="%" percent="95" color=""]95[/progress_bar][/progress_set]',
							"description" =>  __("You can create progress bar with this shortcode.[progress_set] is a wrapper with height and width parameters.[progress_bar] is the actual circle with parameters below - ",'ioa'),
							"parameters" =>  array( "unit" => __("Suffix after percent value",'ioa')  ,"percent" => __("Ending value",'ioa') , "color" => __("Color of text",'ioa'), "background" => __("Color of Circle",'ioa')  )
							,
							"module" => array(

									"unit" => array(
														"type" => "text" , 
														"label" => __('Set Label Unit','ioa') ,  
														'values' =>  "%" 
														),
									"percent" => array(
														"type" => "text" , 
														"label" => __('Set percent','ioa') ,  
														'values' =>  "90" 
														),
									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Color','ioa') ,  
														'values' =>  "" 
														),
									"scontent" => array(
														"type" => "text" , 
														"label" => __('Set Label','ioa') ,  
														'values' =>  "" 
														),

								),
							'mod_label' => __("Progress Bar",'ioa'),
							'mod_unit' => __(' Bar','ioa'),
							'mod_applier' => __('progress_bar','ioa'),
							'mod_parent' => __('progress_set','ioa')
							),
					"stacked_circle_group" => array(
						"stripable" => true,
							"name" =>  __("Stacked Circle",'ioa'),
							"syntax" => '[stacked_circle_group width="300" height="300"][single_circle unit="%" percent="95" background="" color="" ]95[/single_circle][/stacked_circle_group]',
							"description" =>  __("You can create stacked circles with this shortcode.[stacked_circle_group] is a wrapper with height and width parameters.[single_circle] is the actual circle with parameters below - ",'ioa'),
							"parameters" =>  array( "unit" => __("Suffix after percent value",'ioa')  ,"percent" => __("Ending value",'ioa') , "color" => __("Color of text",'ioa'), "background" => __("Color of Circle",'ioa')  )
							,"parent_input" => array(

								"width" => array(
														"type" => "text" , 
														"label" => __('Set Width','ioa') ,  
														'values' =>  "" 
														),
								"height" => array(
														"type" => "text" , 
														"label" => __('Set Height','ioa') ,  
														'values' =>  "" 
														),
							),
							"module" => array(

									"unit" => array(
														"type" => "text" , 
														"label" => __('Set Label Unit','ioa') ,  
														'values' =>  "" 
														),
									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),
									"percent" => array(
														"type" => "text" , 
														"label" => __('Set percent','ioa') ,  
														'values' =>  "90" 
														),
									"color" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Color','ioa') ,  
														'values' =>  "" 
														),
									
									"scontent" => array(
														"type" => "text" , 
														"label" => __('Set Label','ioa') ,  
														'values' =>  "" 
														),

								),
							'mod_label' => __("Stacked Circle",'ioa'),
							'mod_unit' => __(' Circle','ioa'),
							'mod_applier' => __('single_circle','ioa'),
							'mod_parent' => __('stacked_circle_group','ioa')
							),
					"doughnut_chart" => array(
						"stripable" => true,
							"name" =>  __("Doughnut Chart",'ioa'),
							"syntax" => '[doughnut_chart width="300" height="300"][doughnut value="25" background="" label="Value 1"/][/doughnut_chart]',
							"description" =>  __("You can create doughnut charts with this [doughnut_chart] is parent wrapper with height and width options.[doughnut] is the actual arc section with parameters below - ",'ioa'),
							"parameters" =>  array( "value" => __("Value of section",'ioa')  ,"background" => __("section color",'ioa') , "label" => __("Section Label",'ioa') )
							,"parent_input" => array(

								"width" => array(
														"type" => "text" , 
														"label" => __('Set Width','ioa') ,  
														'values' =>  "" 
														),
								"height" => array(
														"type" => "text" , 
														"label" => __('Set Height','ioa') ,  
														'values' =>  "" 
														),
							),"module" => array(

									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),
									"value" => array(
														"type" => "text" , 
														"label" => __('Set Value','ioa') ,  
														'values' =>  "20" 
														),
									"label" => array(
														"type" => "text" , 
														"label" => __('Set Label','ioa') ,  
														'values' =>  "" 
														),

								),
							'mod_label' => __("Doughnut Chart",'ioa'),
							'mod_unit' => __(' Doughnut','ioa'),
							'mod_applier' => __('doughnut','ioa'),
							'mod_parent' => __('doughnut_chart','ioa')
							 ),
					"pie_chart" => array(
						"stripable" => true,
							"name" =>  __("Pie Chart",'ioa'),
							"syntax" => '[pie_chart width="300" height="300"][pie value="25" background="" label="Value 1"/][/pie_chart]',
							"description" =>  __("You can create pie charts with this [pie_chart] is parent wrapper with height and width options.[pie] is the actual arc section with parameters below - ",'ioa'),
							"parameters" =>  array( "value" => __("Value of section",'ioa')  ,"background" => __("section color",'ioa') , "label" => __("Section Label",'ioa') )
							,"parent_input" => array(

								"width" => array(
														"type" => "text" , 
														"label" => __('Set Width','ioa') ,  
														'values' =>  "" 
														),
								"height" => array(
														"type" => "text" , 
														"label" => __('Set Height','ioa') ,  
														'values' =>  "" 
														),
							),"module" => array(

									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),
									"value" => array(
														"type" => "text" , 
														"label" => __('Set Value','ioa') ,  
														'values' =>  "20" 
														),
									"label" => array(
														"type" => "text" , 
														"label" => __('Set Label','ioa') ,  
														'values' =>  "" 
														),

								),
							'mod_label' => __("Pie Chart",'ioa'),
							'mod_unit' => __(' Pie','ioa'),
							'mod_applier' => __('pie','ioa'),
							'mod_parent' => __('pie_chart','ioa')

							),
					"polar_chart" => array(
						"stripable" => true,
							"name" =>  __("Polar Chart",'ioa'),
							"syntax" => '[polar_chart width="300" height="300"][pole value="25" background="" label="Value 1"/][/polar_chart]',
							"description" =>  __("You can create polar charts with this [polar_chart] is parent wrapper with height , width options and poles value.[pole] is the actual  section with parameters below - ",'ioa'),
							"parameters" =>  array( "value" => __("Value of section",'ioa')  ,"background" => __("section color",'ioa')  )
							,"parent_input" => array(

								"width" => array(
														"type" => "text" , 
														"label" => __('Set Width','ioa') ,  
														'values' =>  "" 
														),
								"height" => array(
														"type" => "text" , 
														"label" => __('Set Height','ioa') ,  
														'values' =>  "" 
														),
							),"module" => array(

									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),
									"value" => array(
														"type" => "text" , 
														"label" => __('Set Value','ioa') ,  
														'values' =>  "20" 
														),
									"label" => array(
														"type" => "text" , 
														"label" => __('Set Label','ioa') ,  
														'values' =>  "" 
														),

								),
							'mod_label' => __("Polar Chart",'ioa'),
							'mod_unit' => __(' Pole','ioa'),
							'mod_applier' => __('pole','ioa'),
							'mod_parent' => __('polar_chart','ioa')
							),
					
					"bar_chart" => array(
						"stripable" => true,
							"name" =>  __("Bar Chart",'ioa'),
							"syntax" => '[bar_chart width="300" xlabels="A,B,C,D,E" height="300"][bar_set data="25,56,34,78,76" background="" strokecolor=""/][/bar_chart]',
							"description" =>  __("You can create bar charts with this [bar_chart] is parent wrapper with height , width options and point values.[bar] is the actual  section with parameters below - ",'ioa'),
							"parameters" =>  array( "data" => __("Values of section",'ioa')  ,"background" => __("section color",'ioa')   ,"strokecolor" => __("section stroke color",'ioa') )
							,"parent_input" => array(

								"width" => array(
														"type" => "text" , 
														"label" => __('Set Width','ioa') ,  
														'values' =>  "" 
														),
								"height" => array(
														"type" => "text" , 
														"label" => __('Set Height','ioa') ,  
														'values' =>  "" 
														),
								"xlabels" => array(
														"type" => "text" , 
														"label" => __('Set Labels separated by comma','ioa') ,  
														'values' =>  "" 
														),
							),"module" => array(

									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),
									"strokecolor" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Stroke Color','ioa') ,  
														'values' =>  "" 
														),
									"data" => array(
														"type" => "text" , 
														"label" => __('Set multiple values separated by comma','ioa') ,  
														'values' =>  "20" 
														),
									

								),
							'mod_label' => __("Bar Chart",'ioa'),
							'mod_unit' => __(' Bar Set','ioa'),
							'mod_applier' => __('bar_set','ioa'),
							'mod_parent' => __('bar_chart','ioa')
							),
					"line_chart" => array(
						"stripable" => true,
							"name" =>  __("Line Chart",'ioa'),
							"syntax" => '[line_chart width="300" xlabels="A,B,C,D,E" height="300"][line data="25,56,34,78,76" background="" strokecolor="" pointcolor="" pointstrokecolor=""/][/line_chart]',
							"description" =>  __("You can create line charts with this [line_chart] is parent wrapper with height , width options and point values.[line] is the actual  section with parameters below - ",'ioa'),
							"parameters" =>  array( "data" => __("Values of section",'ioa')  ,"background" => __("section color",'ioa')  ,"pointcolor" => __("section point color",'ioa') ,"strokecolor" => __("section stroke color",'ioa') ,"pointstrokecolor" => __("section point's stroke color",'ioa') )
							,"parent_input" => array(

								"width" => array(
														"type" => "text" , 
														"label" => __('Set Width','ioa') ,  
														'values' =>  "" 
														),
								"height" => array(
														"type" => "text" , 
														"label" => __('Set Height','ioa') ,  
														'values' =>  "" 
														),
								"xlabels" => array(
														"type" => "text" , 
														"label" => __('Set Labels separated by comma','ioa') ,  
														'values' =>  "" 
														),
							),"module" => array(

									"data" => array(
														"type" => "text" , 
														"label" => __('Set multiple values separated by comma','ioa') ,  
														'values' =>  "20" 
														),
									"background" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Background Color','ioa') ,  
														'values' =>  "" 
														),
									"strokecolor" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Stroke Color','ioa') ,  
														'values' =>  "" 
														),

									"pointcolor" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Point Color','ioa') ,  
														'values' =>  "" 
														),

									"pointstrokecolor" => array(
														"type" => "colorpicker" , 
														"label" => __('Set Point Stroke Color','ioa') ,  
														'values' =>  "" 
														),
									

								),
							'mod_label' => __("Line Chart",'ioa'),
							'mod_unit' => __(' Line','ioa'),
							'mod_applier' => __('line','ioa'),
							'mod_parent' => __('line_chart','ioa')
							),
				)

		),
	__("Social Elements",'ioa') => array(

			"icon" => "share",
			"shortcodes" => array(

					"tweets" => array(
							"name" =>  __("Twitter",'ioa'),
							"syntax" => '[tweets count="4" mode="list" /]',
							"description" =>  __("This allows you to your recent tweets",'ioa'),
							"parameters" =>  array( "count" => __("number of tweets to show",'ioa') )
							,"inputs" => array(

									"count" => array(
														"type" => "text" , 
														"label" => __('Set Number of tweets','ioa') ,  
														'values' =>  "" 
														),

									"mode" => array(
														"type" => "select",
														"label" => __('Select Layout List or Slider','ioa'),
														"values" => array(
														"list","slider" ) 
													)
									)

							),
					"social_icon" => array(
							"name" =>  __("Social Icon",'ioa'),
							"syntax" => '[social_icon url="" type=""/]',
							"description" =>  __("This allows you to add social buttons with their respective icons",'ioa'),
							"parameters" =>  array( "url" => __("link to the profile/page",'ioa') , "type" => __("select the network",'ioa')  ),
							"inputs" => array(

									"url" => array(
														"type" => "text" , 
														"label" => __('Enter Profile URL','ioa') ,  
														'values' =>  "" 
														),
									
									"type" => array(
														"type" => "select",
														"label" => __('Select Social Network','ioa'),
														"values" => array(
														"f500px","aim" ,"android","badoo","dailybooth" ,"dribbble","email","foursquare","github","google"
														,"hipstamatic","icq","instagram","lastfm","linkedin","path","picasa","pininterest","quora","rdio",
														"rss","skype","reddit","spotify","thefancy","tumblr","twitter","vimeo","xbox","youtube","zerply","facebook") 
													)
									)
							),
					"person" => array(
							"stripable" => true,
							"name" =>  __("Person",'ioa'),
							"syntax" => '[person name="Tony Stark" photo="" designation="CEO" info="Some information about person" twitter="" facebook="" google="" linkedin="" dribbble="" label_color=""  width="" /]',
							"description" =>  __("This allows you to add a person's profile",'ioa'),
							"parameters" =>  array( 
											 "photo" => __("Add photo of person",'ioa'),
											 "name" => __("Name of person",'ioa'),
											 "designation" => __("designation / post ",'ioa'),
											 "info" => __("information",'ioa'),
											 "twitter" => __("twitter profile link",'ioa'),
											 "facebook" => __("facebook profile link",'ioa'),
											 "google" => __(" google profile link",'ioa'),
											 "linkedin" => __("linkedin profile link",'ioa'),
											 "dribbble" =>  __("dribbble profile link",'ioa'),
											 "label_color" => __("label color of designation",'ioa'),
											 "width" => __("width of the block",'ioa'),
							  ),
							"inputs" => array(
									"photo" => array(
														"type" => "upload" , 
														"label" => __("Add Person's Photo",'ioa') ,  
														'values' =>  "" 
														),
									"name" => array(
														"type" => "text" , 
														"label" => __('Name of person','ioa') ,  
														'values' =>  "" 
														),
									"designation" => array(
														"type" => "text" , 
														"label" => __('Designation / Post','ioa') ,  
														'values' =>  "" 
														),
									"info" => array(
														"type" => "textarea" , 
														"label" => __('Information','ioa') ,  
														'values' =>  "" 
														),
									"label_color" => array(
														"type" => "colorpicker" , 
														"label" => __('Background color of designation Tag','ioa') ,  
														'values' =>  "" 
														),
									"twitter" => array(
														"type" => "text" , 
														"label" => __('Twitter profile link','ioa') ,  
														'values' =>  "" 
														),
									"facebook" => array(
														"type" => "text" , 
														"label" => __('Facebook profile link','ioa') ,  
														'values' =>  "" 
														),
									"google" => array(
														"type" => "text" , 
														"label" => __('Google+ profile link','ioa') ,  
														'values' =>  "" 
														),
									"linkedin" => array(
														"type" => "text" , 
														"label" => __('Linkedin profile link','ioa') ,  
														'values' =>  "" 
														),
									"dribbble" => array(
														"type" => "text" , 
														"label" => __('Dribbble profile link','ioa') ,  
														'values' =>  "" 
														),
									"width" => array(
														"type" => "text" , 
														"label" => __('Width(by default it is full width)','ioa') ,  
														'values' =>  "" 
														),
									

									),
					
									
							),
				)
			
      

		),
	__("WP Related",'ioa') => array(

			"icon" => "pencil",
			"shortcodes" => array(

					"grid" => array(
						"stripable" => true,
							"name" =>  __("Posts Grid",'ioa'),
							"syntax" => '[post_grid post_type="post" no="4"  ioa_query="" post_filter=""  /]',
							"description" =>  __("This allows you add posts in list layout",'ioa'),
							"parameters" =>  array( 

												"post_type" => __("Post type to show",'ioa'),
												"no" => __("number of posts",'ioa'),
												"category" => __("category to show",'ioa'),
												"tag" => __("which tag related posts to show",'ioa'),
												"order" => __("order posts : ASC/DESC",'ioa'),
												"excerpt_length" => __("length of characters to show",'ioa'),
												"orderby" => __("sort by title,rand,comment_count or date",'ioa'),
												"post_filter" => __("Show Animated Filter",'ioa'),
												"ioa_query" => __("Special WP Compatible query string for filters.",'ioa')
								 ),
							"inputs" => array(

									"post_type" => array(
														"type" => "select" , 
														"label" => __('Select Post Type','ioa') ,  
														'values' =>  $post_type_array
														),
									"no" => array(
														"type" => "text" , 
														"label" => __('Enter number of posts to show','ioa') ,  
														'values' => "4"
														),
									
									"excerpt_length" => array(
														"type" => "text" , 
														"label" => __('Length of characters to show','ioa') ,  
														'values' => "80"
														),

									"post_filter" => array(
														"type" => "select",
														"label" => __('Show Animated Filter','ioa') ,
														"values" => array("false" => __("No",'ioa') ,"true" => __("Yes",'ioa') )
														),
									"ioa_query" => array(
														"type" => "wp_query" , 
														"label" => __('Add Filters','ioa') ,  
														'values' => ""
														),
									)
							),
					"post_list" => array(
						"stripable" => true,
							"name" =>  __("Posts List",'ioa'),
							"syntax" => '[post_list post_type="post" no="4"  ioa_query=""  /]',
							"description" =>  __("This allows you add posts in list layout",'ioa'),
							"parameters" =>  array( 

												"post_type" => __("Post type to show",'ioa'),
												"no" => __("number of posts",'ioa'),
												"category" => __("category to show",'ioa'),
												"tag" => __("which tag related posts to show",'ioa'),
												"order" => __("order posts : ASC/DESC",'ioa'),
												"excerpt_length" => __("length of characters to show",'ioa'),
												"orderby" => __("sort by title,rand,comment_count or date",'ioa'),
												"ioa_query" => __("Special WP Compatible query string for filters.",'ioa')
								 ),
							"inputs" => array(

									"post_type" => array(
														"type" => "select" , 
														"label" => __('Select Post Type','ioa') ,  
														'values' =>  $post_type_array 
														),
									"no" => array(
														"type" => "text" , 
														"label" => __('Enter number of posts to show','ioa') ,  
														'values' => "4"
														),
									
									"excerpt_length" => array(
														"type" => "text" , 
														"label" => __('Length of characters to show','ioa') ,  
														'values' => "80"
														),

									"ioa_query" => array(
														"type" => "wp_query" , 
														"label" => __('Add Filters','ioa') ,  
														'values' => ""
														),
									)
							),
					"post_slider" => array(
						"stripable" => true,
							"name" =>  __("Posts Slider",'ioa'),
							"syntax" => '[post_slider post_type="post" no="4"  ioa_query=""  /]',
							"description" =>  __("This allows you add posts in slider layout",'ioa'),
							"parameters" =>  array( 

												"post_type" => __("Post type to show",'ioa'),
												"no" => __("number of posts",'ioa'),
												"category" => __("category to show",'ioa'),
												"tag" => __("which tag related posts to show",'ioa'),
												"order" => __("order posts : ASC/DESC",'ioa'),
												"orderby" => __("sort by title,rand,comment_count or date",'ioa'),
												"ioa_query" => __("Special WP Compatible query string for filters.",'ioa')
								 ),
							"inputs" => array(

									"post_type" => array(
														"type" => "select" , 
														"label" => __('Select Post Type','ioa') ,  
														'values' =>  $post_type_array 
														),
									"no" => array(
														"type" => "text" , 
														"label" => __('Enter number of posts to show','ioa') ,  
														'values' => "4"
														),
														
									"ioa_query" => array(
														"type" => "wp_query" , 
														"label" => __('Add Filters','ioa') ,  
														'values' => ""
														),
									)
							),
					"post_scrollable" => array(
						"stripable" => true,
							"name" =>  __("Posts Scrollable",'ioa'),
							"syntax" => '[post_scrollable post_type="post" no="4"  ioa_query=""  /]',
							"description" =>  __("This allows you add posts in scrollable layout",'ioa'),
							"parameters" =>  array( 

												"post_type" => __("Post type to show",'ioa'),
												"no" => __("number of posts",'ioa'),
												"category" => __("category to show",'ioa'),
												"tag" => __("which tag related posts to show",'ioa'),
												"order" => __("order posts : ASC/DESC",'ioa'),
												"orderby" => __("sort by title,rand,comment_count or date",'ioa'),
												"ioa_query" => __("Special WP Compatible query string for filters.",'ioa')
								 ),
							"inputs" => array(

									"post_type" => array(
														"type" => "select" , 
														"label" => __('Select Post Type','ioa') ,  
														'values' => $post_type_array 
														),
									"no" => array(
														"type" => "text" , 
														"label" => __('Enter number of posts to show','ioa') ,  
														'values' => "4"
														),
														
									"ioa_query" => array(
														"type" => "wp_query" , 
														"label" => __('Add Filters','ioa') ,  
														'values' => ""
														),
									)
							),
					"testimonial" => array(
							"name" =>  __("Single Testimonial",'ioa'),
							"syntax" => '[testimonial id=""/]',
							"description" =>  __("This allows you add single testimonial",'ioa'),
							"parameters" =>  array( 

												"id" => __("Select Testimonial",'ioa')
								 ),
								"inputs" => array(

									"id" => array(
														"type" => "select" , 
														"label" => __(' Testimonial','ioa') ,  
														'values' =>  $ts 
														),
									)
							),
					
				)

		)

	

);






 ?>