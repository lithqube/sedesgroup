<?php
/**
 * The Template for 404
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */


get_header(); 
?>   
<div class="inner-super-wrapper">
<div class="title-wrap">
  	<div class="wrap">
    	<div class="skeleton auto_align title-text-algin-center"> 
        		<h1 class="custom-title" ><?php echo stripslashes($super_options[SN."_notfound_title"]); ?></h1>
                
         </div>
     </div>
</div>

<div class="page-wrapper ">
	
	<div class="skeleton clearfix auto_align">

		

		<div class="mutual-content-wrap ">
			

		 <div class="not-found-image">
        <img src=" <?php 
   		      if(!$super_options[SN."_notfound_logo"]) 
   		 		      echo URL."/sprites/i/notfound.png"; 
    	       else echo $super_options[SN."_notfound_logo"]; ?>" alt="Page Not Found" title="Page Not Found" />

          <canvas id="icon404" width="120" height="120"></canvas>
          <canvas id="icon404-subset" width="80" height="80"></canvas>

   		 </div>
    	 <div class="not-found-text clearfix"> <?php echo do_shortcode(stripslashes($super_options[SN."_notfound_text"])); ?> </div>
    	
    	<div class="error-search clearfix">
          <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
          <div>
              <input type="text" value="" name="s" id="s" placeholder='Search..' />
              <input type="submit" id="searchsubmit" value="Search" />
          </div>
           </form>
      </div>
		
		</div>


		
		<?php get_sidebar(); ?>

	</div>

</div></div>
<!--  Fancy Rain Animation -->

<?php get_footer(); ?>
<script>
 jQuery(function(){

    if(jQuery(window).width() > 767)
    {
       var skycons = new Skycons({"color": "<?php echo $super_options[SN.'_uc_cloudscolor']; ?>"});

  skycons.add(document.getElementById("icon404"), Skycons.RAIN);
  skycons.play();

  skycons.add(document.getElementById("icon404-subset"), Skycons.RAIN);
  skycons.play();
    }

 });

</script>

      