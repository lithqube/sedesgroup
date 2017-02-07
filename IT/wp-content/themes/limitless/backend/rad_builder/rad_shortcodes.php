<?php
/**
 * RAD Shortcode to Template Conversion
 */



function RAD_rad_page_section($atts,$content)
{
 global $ioa_meta_data;	
 
  $cl = array();
   $content = str_replace('&#215;','x',$content);
   $content = str_replace('<<','[ioas]',$content);
     $content  = str_replace(array( '&#091;','&#093;'), array('[',']'), $content );
     $content  = str_replace(array( '&#91;','&#93;'), array('[',']'), $content );

 $d = $atts;

  foreach ($d as $key => $f) {
  $temp = $f;
  $temp  = str_replace(array( '&squot;','&quot;','&sqstart;','&sqend;' ), array('\'','"','[',']'), $temp );
  $temp  = str_replace(array( '&amp;squot;','&amp;quot;','&amp;sqstart;','&amp;sqend;' ), array('\'','"','[',']'), $temp );
  $temp = str_replace(array("&#038;","#038;"), '&', $temp );
  
  $d[$key] = $temp; 

 }

 if(isset($ioa_meta_data['rad_editable']))
 {
    $ioa_meta_data['rad_reconstruct'][$d['id']] = array( 'data' => $d, 'containers' => array() ); 
    $ioa_meta_data['current_rad_section'] = $d['id'];
    do_shortcode($content);
    return;
 }

if(isset($d['layout']))
  $ioa_meta_data['section_container_width'] = $d['layout'];

  $ioa_meta_data['rad_section_data'] = array('data' => $d , 'containers' => $content );
  

  $section = '';
  
  ob_start();
    get_template_part('templates/rad/section');
    $section = ob_get_contents();
  ob_end_clean();


  return $section;
}


add_shortcode("rad_page_section","RAD_rad_page_section");



function RAD_rad_page_container($atts,$content)
{
 global $ioa_meta_data;	



 if(isset($ioa_meta_data['rad_editable']))
 {

    $current_section =  $ioa_meta_data['rad_reconstruct'][$ioa_meta_data['current_rad_section']];
    $current_section['containers'][$atts['id']] = array('data' => $atts , 'widgets' => array() );
    $ioa_meta_data['current_rad_container'] = $atts['id'];

    $ioa_meta_data['rad_reconstruct'][$ioa_meta_data['current_rad_section']] = $current_section;
 }
  
  $cl = array();

  $ioa_meta_data['rad_container_data'] = array('data' => $atts , 'widgets' => $content );

  $container = '';
  
  ob_start();
    get_template_part('templates/rad/container');
    $container = ob_get_contents();
  ob_end_clean();


  return $container;
}


add_shortcode("rad_page_container","RAD_rad_page_container");



/*===============================================
=            RAD Shortcode to Widget            =
===============================================*/


function RAD_rad_page_widget($atts,$content)
{
 global $ioa_meta_data,$radunits;
 $widget = '';
 $w = $atts;

 if(isset($w['rich_key']))
   $w[$w['rich_key']] = $content;
 
 foreach ($w as $key => $f) {
  $temp = $f;
  $temp  = str_replace(array( '&squot;','&quot;','&sqstart;','&sqend;' ), array('\'','"','[',']'), $temp );
  $temp  = str_replace(array( '&amp;squot;','&amp;quot;','&amp;sqstart;','&amp;sqend;' ), array('\'','"','[',']'), $temp );
  $temp = str_replace(array("&#038;","#038;"), '&', $temp );
  
  $w[$key] = $temp; 

 }


 if(isset($ioa_meta_data['rad_editable']))
 {

    $current_section =  $ioa_meta_data['rad_reconstruct'][$ioa_meta_data['current_rad_section']];
    $current_container = $current_section['containers'][$ioa_meta_data['current_rad_container']];


    $current_container['widgets'][$w['id']] = $w;

    $current_section['containers'][$ioa_meta_data['current_rad_container']] = $current_container;
    $ioa_meta_data['rad_reconstruct'][$ioa_meta_data['current_rad_section']] = $current_section;

    return;
 }

 $ioa_meta_data['widget'] = array();
 $ioa_meta_data['widget']['data'] =  $w;
 $ioa_meta_data['widget']['id'] =  $w['id'];
 $ioa_meta_data['widget']['type'] =  $w['type'];
 $ioa_meta_data['widget_classes'] = '';
 $ioa_meta_data['widget_attributes'] = '';


 ob_start();
            
  $istop = '';
  $islast = '';

if(isset($w['top']) && $w['top'])
{
  $istop = ' top ';
}


  $ioa_meta_data['widget_classes'] .= ' w_full w_layout_element '.$istop;
  
  if(isset($w['animation']) && $w['animation']!='none')
      $ioa_meta_data['widget_classes'] .= ' widget-animate widget-animate-'.$w['animation'];

  $ioa_meta_data['rad_type'] = $w['type'];

  if(isset($radunits[str_replace('-','_',$w['type'])]))
  {
    get_template_part("templates/rad/".$radunits[str_replace('-','_',$w['type'])]->data['template']);
  }

   $widget = ob_get_contents();
  ob_end_clean();


  return $widget;
}


add_shortcode("rad_page_widget","RAD_rad_page_widget");




/*-----  End of RAD Shortcode to Widget  ------*/