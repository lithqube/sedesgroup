console.log('running');
		jQuery.post(ajaxurl,{ type:'RAD-Sidebar' , action : 'rad_query_listener' },function(data){
			jQuery('body').append(data);
      var 
			 lightbox.find( ".ioa_input .ioa_slider" ).each(function(){
                      temp = jQuery(this),obj  =temp.parent().find("input");
                      temp.slider({
                          value: parseInt(obj.val()),
                          min: 0, range: "min",
                          max:  parseInt(obj.data('max')),
                          step : parseInt(obj.data('steps')),
                          slide: function( event, ui ) {
                          	obj  = jQuery(this).parent().find("input");
                            obj.parent().find("input").val(ui.value);
                            obj.parent().find("input").trigger('rad_change');
                          }
                        });
                      
                      });


            lightbox.find('.minicolors').each(function(){
                      obool = jQuery(this).data('opacity');
                      
                      jQuery(this).minicolors({
                        textfield : true,

                        opacity: false,
                        change: function(hex, opacity) {
                                       jQuery(this).trigger('rad_change');
                                      },
                              hide: function(hex, opacity) {
                                       
                                       jQuery(this).trigger('mini-hidden');
                                          
                                      },        

                      });

                    });


         lightbox.find(".input-section-tabs,.settings-pane").tabs();
         lightbox.find(".inner-visual-settings-panel").accordion({
         	 heightStyle: "content"
         });

		});	