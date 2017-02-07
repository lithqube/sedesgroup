<?php 
/**
 * The Footer Template. 
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */

global $super_options,$helper,$ioa_meta_data ;        
?>


<?php 
 /**
  * This Code runs for Above Footer Sidebar Layout.
  */
 if(isset($ioa_meta_data['layout']) && $ioa_meta_data['layout']=="above-footer") : ?>

    <div class="sidebar <?php echo $ioa_meta_data['layout']; ?>" id="sidebar" itemscope itemtype="http://schema.org/WPSideBar"><!-- start of one-third column -->

        <div class="skeleton auto_align clearfix">
        <?php 
            if ($ioa_meta_data['layout']!="none" && trim($ioa_meta_data['layout'])!=""  ) {
              dynamic_sidebar ($ioa_meta_data['sidebar']); 
            }
           else  {
              dynamic_sidebar ("Blog Sidebar"); 
            }
        ?>  
        </div>
    </div>


<?php endif; ?>


<?php if($ioa_meta_data['ioa_custom_template']!='ioa-template-blank-page') :  ?>
<div id="footer" itemscope itemtype="http://schema.org/WPFooter">
	<!-- Footer Widgets area -->
	<?php  get_template_part('templates/content-footer-widgets'); ?>
	
	<!-- Footer Menu area -->
	<?php get_template_part('templates/content-footer-menu'); ?>

</div>

<?php  get_template_part('templates/sticky-contact'); ?>

  </div>
</div>
<?php endif; ?>


<a href="" class="back-to-top  angle-upicon- ioa-front-icon"></a>




<?php  wp_footer();   ?>
</body>
</html>
