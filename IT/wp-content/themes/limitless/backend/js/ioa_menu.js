// JavaScript Document


var loc = jQuery('#shortcode_link').attr('href');

var img_loc = loc+"/css/i/shortcode_icon.png";

// Creates a new plugin class
tinymce.PluginManager.add('button', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('ioabutton', {
        icon: true,
        image : img_loc,
        onclick:function(){
          var body =  jQuery('.shortcode-l-body');

          if( body.find('.top-shortcodes-menu').length == 0 )   
          {
            console.log(jQuery('#backend_link').attr('href'));
                jQuery.post(jQuery('#backend_link').attr('href'),{ type:'shortcode' , action: 'ioalistener' },function(data){
                    body.html(data);
                    body.find('.ioa-minicolors').minicolors({
                            textfield : true,
                            opacity: false,
                            change: function(hex, opacity) {
                             
                               jQuery(this).parent().next().val(opacity);    
                               jQuery(this).trigger('change');
                                
                            }

                        });
                    body.css('background-image','none');
                });
          }
          
            jQuery('div.shortcode-lightbox').fadeIn('fast');


         }
    });

});

