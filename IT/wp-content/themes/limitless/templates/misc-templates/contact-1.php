<?php
global $helper, $ioa_meta_data,$post,$super_options;

switch($ioa_meta_data['featured_media_type'])
    {
      case "slider-full" :
      case "slider-contained" :
      case "slideshow-contained" :
      case "none-full" :
      case 'image-parallex' : 
      case 'image-full' : get_template_part('templates/content-featured-media'); break;
    }

  ?>

<div class="page-wrapper <?php echo $post->post_type ?>" itemscope itemtype="http://schema.org/ContactPage">
	<div class="skeleton clearfix auto_align">
    <div class="mutual-content-wrap <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout']; else echo 'full-layout'; ?>">
      <?php  
        switch($ioa_meta_data['featured_media_type'])
        {
          case 'slider' :
          case 'slideshow' :
          case 'video' :
          case 'proportional' :
          case 'none-contained' :
          case 'image' : get_template_part('templates/content-featured-media'); break;
        }

      ?>

      <?php if($super_options[SN.'_prop_address']!="") : ?>
        <div class="clearfix address-mutual-wrap">
          <div class="address-area" itemprop="address"><?php echo $helper->format( $super_options[SN.'_prop_address']); ?></div>
          <div class="map-wrapper">
            <div id="map"></div>
          </div>
        </div>
       <?php endif; ?>

      <?php  if(have_posts()): while(have_posts()) : the_post(); ?>

        <div class="page-content">

          <?php the_content(); ?>

        </div>
      <?php endwhile; endif; ?>
    </div>
		<?php get_sidebar();  wp_reset_query(); ?>



	</div>
</div>


 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
 <script type="text/javascript">

 var geocoder,map;
 function initialize() {
    <?php 
    $addr = trim(preg_replace('/\s\s+/', ' ', stripslashes($super_options[SN.'_address'])));
     ?>
    geocoder = new google.maps.Geocoder();
    var address  = '<?php echo $addr; ?>';


    var mapOptions = {
      zoom: <?php echo $super_options[SN.'_map_zoom'] ?>,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      mapTypeControlOptions: {
  	  mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
	}
    };

    var styles = [
    {
      stylers: [
        { hue: "<?php echo $super_options[SN.'_map_color'] ?>" },
        { saturation:0 }
      ]
    },{

      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: 0 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "off" }
      ]
    }
  ];

  var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});
  var image = '<?php echo URL ?>/sprites/i/map-pin.png';

 <?php if($super_options[SN.'_google_track'] == 'addr') : ?>

  geocoder.geocode( { 'address': address}, function(results, status) {

  if (status == google.maps.GeocoderStatus.OK) {

  google.maps.visualRefresh = true;
	map = new google.maps.Map(document.getElementById("map"),  mapOptions);
		map.mapTypes.set('map_style', styledMap);
		map.setMapTypeId('map_style');
    console.log(results[0].geometry.location);
		map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location,
             icon: image
        });

      } 
    });

<?php else: ?>

    var latlng = new google.maps.LatLng(<?php echo $super_options[SN.'_glat'] ?>,<?php echo $super_options[SN.'_glong'] ?>);

    var mapOptions = {
      zoom: <?php echo $super_options[SN.'_map_zoom'] ?>,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
  }, center: latlng
    };

map = new google.maps.Map(document.getElementById("map"),  mapOptions);
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');
    map.setCenter(latlng);
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
             icon: image
        });

<?php endif; ?>

}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

