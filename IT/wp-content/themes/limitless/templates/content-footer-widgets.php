<?php
/**
 * The template used for generating ending markup for framework
 *
 * @package WordPress
 * @subpackage Titan Themes
 * @since Hades Framework V5
 */

// == ~~ To use native variables global is required ================================
global $super_options,$helper;     

?>

<?php   if($super_options[SN."_footer_widgets"]=="Yes") : ?>
<div class="inner-footer-wrapper page-content">
   <div  class=" clearfix skeleton auto_align">
   
    
    <div class="mobile_footer_widget">
      <?php 
	   echo '<div class="footer-cols  clearfix">';
		    dynamic_sidebar ("Footer Mobile"); 
       echo "</div>";
	  ?>
    </div>
      
     
     <?php 
	 if(isset($super_options[SN."_footer_layout"]))
	  $footer_layout = $super_options[SN."_footer_layout"];
	  else  $footer_layout = "four-col";
	  switch($footer_layout)
	  {
	  case "two-col" : 
	  
					  echo '<div class="footer-cols  col one_half clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  col one_half last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	  break;
	  case "three-col" : 
	  
					  echo '<div class="footer-cols  col one_third clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_third clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  col one_third last clearfix">';
					    dynamic_sidebar ("Footer Column 3"); 
					  echo "</div>"; 
	  
	  break;
	 case "four-col" : 
	  
					  echo '<div class="footer-cols  col one_fourth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_fourth clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  col one_fourth clearfix">';
					    dynamic_sidebar ("Footer Column 3"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_fourth last clearfix">';
					    dynamic_sidebar ("Footer Column 4"); 
					  echo "</div>"; 
	  
	  break;
	  case "five-col" : 
	  
					  echo '<div class="footer-cols  col one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  col one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 3"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 4"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_fifth last clearfix">';
					    dynamic_sidebar ("Footer Column 5"); 
					  echo "</div>"; 
	  
	  break;
	  case "six-col" : 
	  
					  echo '<div class="footer-cols  col one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  col one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 3"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 4"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 5"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  col one_sixth last clearfix">';
					    dynamic_sidebar ("Footer Column 6"); 
					  echo "</div>"; 
	  
	  break;
	  
	  case "one-third" : 
	  
					  echo '<div class="footer-cols  col one_third clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  col two_third last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	  break;
	  case "one-fourth" : 
	  
					  echo '<div class="footer-cols  col one_fourth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  col three_fourth last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	  break;
	  case "one-fifth" : 
	  
					  echo '<div class="footer-cols  col one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols col four_fifth last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	   break;
	   case "one-sixth" : 
	  
					  echo '<div class="footer-cols  col one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  col five_sixth last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	  break;
	 
	  
	  }
	 ?>
     
   
  
     </div>
   </div>
   
   <?php endif;  ?>