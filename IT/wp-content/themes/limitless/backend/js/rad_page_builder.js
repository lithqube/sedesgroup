/**
* RAD Page Builder Main Code
*
* @Dependency    - jQuery , Backbone JS , Underscore JS
* @Version - 3.2.2
* @Author - Abhin Sharma 
* @Rendering Engine  - Shadow X1
*/


jQuery(function(){


/**
*
* Return if builder is not supported
*
**/


if( jQuery('.ioa-page-builder-trigger').length == 0 ) return;

/**
*
* Variables Declaration and Caching
*
**/

/*==========  Lightox Holders  ==========*/

var lightbox_cache = null,lightbox_settings_ar = {};

/*==========  Window Object Caching  ==========*/

var win = {
  
        obj : jQuery(window),
        width : null,
        height : null,
        ori_width : null,
        ori_height : null

};


/*==========   Widget Views   ==========*/


var RAD_Views = {

  sectionView : jQuery("#RADSectionView").html(),
  containerView : jQuery("#RADContainerView").html(),
  widgetView : jQuery("#RADWidgetView").html()

} ;


// Get Height at loading state
  
win.ori_width = win.width = win.obj.width();
win.ori_height =win.height = win.obj.height();

// Constantly update dimensions for window object.

win.obj.resize(function(event) {
 
    win.width = win.obj.width();
    win.height = win.obj.height();
});


var doc = jQuery(document) , body = jQuery('body'),
        temp,temp1,obj,ioa_wp_obj,s_id,c_id,w_id,thumb,
        current_editing_obj = null,
        current_editing_container = null, 
        rad_sidebar = jQuery('.rad_toolbox') , widgets = jQuery('.rad-thumb'), frame = jQuery('.rad-builder-area'),rad_undo,rad_redo,saving_link =  jQuery('#backend_link').attr('href'),rad_el = jQuery('#rad_elements'),scroll_api= [];

/**
  * On window load the undo and redo state is same
  */

win.obj.load(function(){
 
        rad_undo = rad_redo = frame.html();
        setRADELparam();
});

function setRADELparam()
{
  rad_el.height( win.height );
rad_el.find('.rad-w-tab-content, .rad-w-scroll-area').height(

      win.height - ( (rad_el.find('.rad-widgets').children('h3').outerHeight()  + 7) *  rad_el.find('.rad-widgets').children('h3').length)      

  );
}

setRADELparam();

/*
 * Custom Scroll Bar Setup
 */

 rad_el.find('.rad-w-tab-content').each(function(i){
          scroll_api [i] =  jQuery(this).jScrollPane({ animateScroll :false,  mouseWheelSpeed :80 , verticalGutter :2 }).data('jsp');
 });




/*=====================================
=            Sidebar Setup            =
=====================================*/

rad_el.find('.rad-widgets').accordion({
         create: function( event, ui ) { 
          
            ui.header.find('i').addClass('angle-upicon-').removeClass('angle-downicon-');
          
          },
         beforeActivate: function( event, ui ) { 
          
             ui.newHeader.find('i').removeClass('angle-downicon-').addClass('angle-upicon-');
             ui.oldHeader.find('i').addClass('angle-downicon-').removeClass('angle-upicon-');
          
          },
         activate : function(e,ui){
          
           /*
            * Re Check API when section is active
            */


           setTimeout(function(){
                 for (var i = scroll_api.length - 1; i >= 0; i--) {
              scroll_api[i].reinitialise();
            };
           },200);
         
         },  
         heightStyle: "fill"
    });


/*
 * Init Panels in sidebars
 */



/*
 * Init Main Sidebar
 */



var tab_scroll  =  jQuery('.rad_tab_scroll').height( win.height - 130 ).jScrollPane({ animateScroll :false,  mouseWheelSpeed :80 , verticalGutter :2 });
tab_scroll = tab_scroll.data('jsp');
 
rad_sidebar.find('.rad-widgets').tabs({

      activate: function( event, ui ) {  

          tab_scroll.reinitialise(); 

        for (var i = scroll_api.length - 1; i >= 0; i--) {
              scroll_api[i].reinitialise();
            };

 
        }

});

/**
*
* Re organize  layout on window resize
*
**/

 win.obj.resize(function(){
        
         jQuery('.rad_tab_scroll').height( win.height - 130 );

        setRADELparam();

          for (var i = scroll_api.length - 1; i >= 0; i--) {
              scroll_api[i].reinitialise();
            };
        tab_scroll.reinitialise();
  });  

rad_sidebar.tabs({

      activate: function( event, ui ) {  

               tab_scroll.reinitialise(); 

               for (var i = scroll_api.length - 1; i >= 0; i--) {
                  scroll_api[i].reinitialise();
                };
      }

});



/*-----  End of Sidebar Setup  ------*/



/*=======================================
=            Phantom  Engine            =
=======================================*/

/**
*
*  HTML 5 Caching engine for RAD Builder
*
**/


var Phantom = {

        reset : false,
        widgets : [],

        /**
        *
        * Get RAD Skeleton  from Cache
        *
        **/
        
        getView : function(key,label) {
              var obj;
              
              obj = RAD_Views.widgetView.replace('{ID}','rpw'+routines.uniqueid());
              obj = obj.replace('{label}',key );
              obj = jQuery(obj);
              obj.find('.rad-s-title').html(label);

              setTimeout(function(){
              Phantom.requestDefaultStub(key,obj);
              },200);

              return obj;

        },

        /**
        *
        * Add to Cache 
        *
        **/
        
        addLocalRegistry : function(key,widget_string)
        {

                if(Modernizr.localstorage)
                {
                        localStorage.setItem(key,widget_string);
                }

        },

        /**
        *
        * Check if Key exists
        *
        **/
        
        checkRegistry : function(key)
        { 
             return false;
             
                if(Phantom.reset) return false;

                if( localStorage.getItem(key) )
                        return true;
                else
                        return false;
        },

        /**
        *
        * Get Data from cache
        *
        **/
        
        getRegistry : function(key)
        {
                  return localStorage.getItem(key);
        }
}  


/*-----  End of Phantom  Engine  ------*/


/*========================================
=            RAD Lightbox API            =
========================================*/

 var s_overlay =   jQuery('.settings-overlay'), lightbox =  jQuery('.settings-lightbox') , sapi = {

      /**
      *
      * Hide RAD Lightbox
      *
      **/
      
      hide : function() { 

            lightbox.fadeOut('fast');
           s_overlay.fadeOut('fast');

       },

       /**
       *
       * Show  RAD Lightbox
       *
       **/
       
      show : function() { 

              lightbox.fadeIn('fast');
              s_overlay.fadeIn('fast');
              
              lightbox.find('.save-settings').show();

       }


  }; 

/*-----  End of RAD Lightbox API  ------*/


/*===========================================
=            RAD Core Rountines            =
===========================================*/



var routines = {
       
       /**
        *
        * Add Key Based JSON values object to  RAD Sections Array
        *
        **/
         
      addRecord : function(id,values)
      {
     
              rad_sections[id] = values;

      },


      /**
      *
      *  Copy JSON settings from one widget to another
      *
      **/
      

      mapSettings : function (target,source)
      {
     
              rad_sections[target.attr('id')] = rad_sections[source.attr('id')];
     
      },

      /**
      *
      * Select Dropdown item by text
      *
      **/
      
      selectOptionByText : function(selectElement, targetText) {
             
              var $selectElement, $opts, $targetOption;

              $selectElement = jQuery(selectElement);
              $opts = $selectElement.find('option');
              $opts.removeAttr('selected');
              $targetOption = $opts.filter(
                     function () {return jQuery(this).val() == targetText}
              );
              if (jQuery().prop) {
                      $targetOption.prop('selected', true);
              } 
              else {
                      $targetOption.attr('selected', 'true');
              }
      },

      /**
      *
      * Generate Unique ID
      *
      **/
      

      uniqueid : function(){
   
           // always start with a letter (for DOM friendlyness)
            var idstr=String.fromCharCode(Math.floor((Math.random()*25)+65));
           
            do {                
            // between numbers and characters (48 is 0 and 90 is Z (42-48 = 90)
           
                     var ascicode=Math.floor((Math.random()*42)+48);
                     if (ascicode<58 || ascicode>64){
                    // exclude all chars between : (58) and @ (64)
                            idstr+=String.fromCharCode(ascicode);    
                    }                
            } while (idstr.length<32);

              return (idstr);
            },

         /**
              *
              * Visual Feedback for RAD Elements
              *
              **/
                   

          visualFeedback : function(widget,source)
          {
         
               widget.find('.widget-content').html(  source.find('.v-f-d').html() );
         
          }


}

/*-----  End of RAD Core Rountines  ------*/


/*==========================================
=            Cache Verification            =
==========================================*/

if(Modernizr.localstorage && Phantom.checkRegistry('RAD_BUILDER_VERSION') )
{

  if( parseFloat(Phantom.getRegistry('RAD_BUILDER_VERSION')) < RAD_BUILDER_VERSION)
  {
    Phantom.reset = true;
    setTimeout(function(){ Phantom.reset = false; Phantom.addLocalRegistry('RAD_BUILDER_VERSION',RAD_BUILDER_VERSION); },6000);
  }
  
}
else  
{
  Phantom.addLocalRegistry('RAD_BUILDER_VERSION',RAD_BUILDER_VERSION);
}



/*-----  End of Cache Verification  ------*/






/**
 * Core Builder Object
 */


var RAD_Builder = {

  /**
  *
  * Convert Cached objects to Array
  *
  **/
  
  presetLightbox : function(){

        jQuery(lightbox_cache).each(function(){
            lightbox_settings_ar[jQuery(this).data('id')] = jQuery(this);
         });

           /**
        *
        * Disable Loading State
        *
        **/
        
        setTimeout(function(){ 

              jQuery('div.rad-loading-state').fadeOut('fast');
       
        },400);

  },

  /**
   *
   * Init RAD Builder
   *
   **/
    

  init: function() { 


      /*==========  Make RAD Widgets draggable  ==========*/
      
      widgets.draggable(
          { 
              helper: "clone" ,
             appendTo: 'body' 
          });

      /*==========  Make Canvas Sortable  ==========*/

      
      /**
      *
      *  Make Sections Sortable
      *
      **/
      

      frame.sortable({ 

              handle:".section-move" ,
              cursorAt: { top:0, left: 0 },
              forceHelperSize:false ,  axis: "y" ,  
              tolerance: 'pointer',
              helper:function(){ return "<div class='section-c-helper'></div>"; },
              start: function(e, ui ){
                   ui.placeholder.height(30);
                   ui.helper.height(30);
              }, 
       }); 
      
      /**
      *
      * Prepare Sections
      *
      **/
      

      RAD_Builder.sectionHandle(frame.children('.rad_page_section'));


      frame.find('.rad_page_container').each(function(){
              RAD_Builder.containerHandle(jQuery(this));
        });

      /**
      *
      * Make Canvas Ready 
      *
      **/
      

      frame.droppable({

        accept : '.rad-thumb , .rad_page_widget , .rad_page_container',
        hoverClass: "rad-frame-dropping",
        greedy : true,

        drop: function( event, ui ) {
                                  
                                  rad_undo =  frame.html();
                                  frame.children('.rad-help').remove();

                                  if( ui.draggable.data('group') === "section" )
                                  {

                                            temp = jQuery(RAD_Views.sectionView.replace('{ID}','rps'+routines.uniqueid()));
                                            frame.append(temp);
                                            RAD_Builder.sectionHandle(temp);
                                            routines.addRecord(temp.attr('id'),rad_builder_data[ui.draggable.data('id')]['inputs']);

                                  }
                                  else if( (ui.draggable.data('group') !== "section" || ui.draggable.data('group') !== "structure") &&  !ui.draggable.hasClass('rad_page_widget')  &&  !ui.draggable.hasClass('rad_page_container'))
                                  {
                                 

                                          temp = jQuery(RAD_Views.sectionView.replace('{ID}','rps'+routines.uniqueid()));
                                          
                                          frame.append(temp);
                                          RAD_Builder.sectionHandle(temp);
                                          
                                          routines.addRecord(temp.attr('id'),rad_builder_data.rad_page_section['inputs']);

                                          var ctemp = jQuery(RAD_Views.containerView.replace('{ID}','rpc'+routines.uniqueid()));
                                          routines.addRecord(ctemp.attr('id'),rad_builder_data.rad_page_container['inputs']);

                                          routines.selectOptionByText(ctemp.find('.component_layout') , 'full');
                                          temp.find('.section-content').append(ctemp);


                                          wtemp = RAD_Views.widgetView.replace('{ID}','rpw'+routines.uniqueid());
                                          wtemp = wtemp.replace('{label}', ui.draggable.data('label') );
                                          wtemp = jQuery(wtemp);
                                          wtemp.data('key', ui.draggable.data('id'));

                                          routines.addRecord(wtemp.attr('id'),rad_builder_data[ui.draggable.data('id')]['inputs']);

                                          temp.find('.container-content').append(wtemp);
                                          routines.visualFeedback(wtemp,ui.draggable);

                                          RAD_Builder.containerHandle(ctemp);

                                  }
                                  else if( ui.draggable.hasClass('rad_page_widget')  )
                                  {


                                          var temp = jQuery(RAD_Views.containerView.replace('{ID}','rpc'+routines.uniqueid()));
                                          routines.addRecord(temp.attr('id'),rad_builder_data.rad_page_container['inputs']);

                                          routines.selectOptionByText(temp.find('.component_layout') ,'full');
                                          jQuery(this).find('.section-content').append(temp);

                                          wtemp = ui.draggable.clone();
                                          temp.find('.container-content').append(wtemp);
                                          routines.mapSettings(wtemp,ui.draggable);
                                          wtemp.removeClass('undefined').show();
                                          wtemp.addClass(ui.draggable.data('id'));
                                          ui.draggable.remove();

                                  }


                                  }
                          
                  });  // End of Droppable Function

  },


/**
*
*  Container Handling
*
**/


  containerHandle : function(obj){

       obj.droppable({
                         
                          accept: " .cl-widgets ,.rad_page_widget,.cl-plugins, .cl-media,.cl-infographic, .cl-advance",
                          greedy: true,
                         hoverClass: "rad-container-dropping",

                          drop: function( event, ui ) {
                                          rad_undo =  frame.html();

                                          if( ui.draggable.hasClass('rad_page_widget')  && ( jQuery(this).attr('id') !== ui.draggable.parents('.rad_page_container').attr('id')  )  )
                                          {
                                                   temp = ui.draggable.clone();
                                                   temp.removeClass('ui-sortable-helper').removeAttr('style');
                                                   jQuery(this).find('.container-content').append(temp);
                                                   routines.mapSettings(temp,ui.draggable);

                                                   ui.draggable.remove();
                                          }

                                          if( (ui.draggable.data('group') !== "section" || ui.draggable.data('group') !== "structure" ) &&  !ui.draggable.hasClass('rad_page_widget') && !ui.draggable.hasClass('rad_page_container'))
                                          {
                                                   temp = RAD_Views.widgetView.replace('{ID}','rpw'+routines.uniqueid());
                                                   temp = temp.replace('{label}', ui.draggable.data('label') );
                                                   temp = jQuery(temp);

                                                   jQuery(this).find('.container-content').append(temp);
                                                   temp.data('key', ui.draggable.data('id'));
                                                    temp.addClass(ui.draggable.data('id'));
                                                   routines.addRecord(temp.attr('id'),rad_builder_data[ui.draggable.data('id')]['inputs']);
                                                   routines.visualFeedback(temp,ui.draggable);

                                          }

                                          setTimeout(function(){ prediction(); },30);
                       
                        }
                      });

        obj.find('.container-content').sortable({

                         forceHelperSize: true , 
                         forcePlaceholderSize: true  , 
                         opacity:0.9,
                        handle : '.widget-move',
                        appendTo : 'body', 
                        tolerance: 'pointer',
                        cursorAt: { top:0, left: 0 }, items : '.rad_page_widget:not(.rad-template)' ,
                        helper : function(){ return "<div class='rad_widget_helper'></div>" }
                  
                   });

   },

/**
*
* Section Handler
*
**/


 sectionHandle : function(obj) {
        obj.droppable({
                      accept: ".cl-structure , .cl-widgets , .rad_page_container,.cl-plugins, .cl-media,.cl-infographic, .cl-advance", 
                      hoverClass: "rad-container-dropping",
                      greedy:true,

                      drop: function( event, ui ) {
                          rad_undo =  frame.html();
                          if( (ui.draggable.data('group') !== "section" || ui.draggable.data('group') !== "structure")  &&  !ui.draggable.hasClass('rad_page_widget') && !ui.draggable.hasClass('rad_page_container') )
                          {

                              var temp = jQuery(RAD_Views.containerView.replace('{ID}','rpc'+routines.uniqueid()));
                              routines.addRecord(temp.attr('id'),rad_builder_data.rad_page_container['inputs']);

                              routines.selectOptionByText(temp.find('.component_layout') ,'full');
                              jQuery(this).find('.section-content').append(temp);

                              wtemp = RAD_Views.widgetView.replace('{ID}','rpw'+routines.uniqueid());
                              wtemp = wtemp.replace('{label}', ui.draggable.data('label') );
                              wtemp = jQuery(wtemp);
                              wtemp.data('key', ui.draggable.data('id')).addClass(ui.draggable.data('id'));
                              routines.addRecord(wtemp.attr('id'),rad_builder_data[ui.draggable.data('id')]['inputs']);

                              temp.find('.container-content').append(wtemp);
                              routines.visualFeedback(wtemp,ui.draggable);

                              RAD_Builder.containerHandle(temp);

                          }
                          

                          if( ui.draggable.hasClass('rad_page_container') && ( jQuery(this).attr('id') !== ui.draggable.parents('.rad_page_section').attr('id')  ) )
                          {
                             
                             temp = ui.draggable.clone();
                             temp.removeClass('ui-sortable-helper').removeAttr('style');
                             jQuery(this).find('.section-content').append(temp);
                             RAD_Builder.containerHandle(temp);

                             routines.selectOptionByText(temp.find('.component_layout') ,ui.draggable.find('.component_layout').val());
                             routines.mapSettings(temp,ui.draggable);
                             ui.draggable.remove();
                            
                          }

                          if( ui.draggable.data('group') === "structure"  && ui.draggable.data('id')!="rad_page_section")
                          {
                            
                            temp = jQuery(RAD_Views.containerView.replace('{ID}','rpc'+routines.uniqueid()));
                            temp.addClass(ui.draggable.data('default'));
                            
                            routines.selectOptionByText(temp.find('.component_layout') ,ui.draggable.data('default'));
                            jQuery(this).find('.section-content').append(temp);

                            RAD_Builder.containerHandle(temp);

                            routines.addRecord(temp.attr('id'),rad_builder_data.rad_page_container['inputs']);

                          }

                          setTimeout(function(){ prediction(); },30);
                      }
                  });

        obj.find('.section-content').sortable({
           opacity:0.9 , forceHelperSize: true , forcePlaceholderSize: true ,tolerance: 'pointer', handle : '.container-move'
           , start: function( event, ui ) {
             rad_undo =  frame.html();
             ps = ui.item.parent();
             ps.sortable( "refresh" );
             ps.sortable( "refreshPositions" );
             jQuery('.rad_page_container').removeClass('first last');

          } 
          , stop: function( event, ui ) {

            setTimeout(function(){ prediction(); },30);
          } 
        });

        setTimeout(function(){ prediction(); },30);
   },
  
   /**
   *
   * Save Mechanism 
   *
   **/
   
    saveRADData : function(container)
   {
        var save_array = [],ctemp,widget_str,widget_content,generator_string='',container_str='', stemp,d,conts =[],container_settings = [],widgets=[],widget_settings=[], s_id, c_id, w_id,style_keys={},we=0;
        
          container.children('.rad-help').remove();

          container.children().each(function(i){
                 

                  d = [];
                  temp = jQuery(this);
                  s_id = temp.attr('id');

                  /**
                  * Save Section Settings
                  */

                  if(_.has(rad_sections,s_id))
                  d =  rad_sections[s_id];
                  d['id'] = s_id;
                  conts = [];


                  generator_string  += "[rad_page_section ";

                  generator_string += "id='"+s_id+"' ";
                  if(temp.hasClass('first-section')) generator_string += "first='true' ";
                  if(temp.hasClass('last-section')) generator_string += "last='true' ";

                  for(stemp=0;stemp<d.length;stemp++)
                  {
                  generator_string += d[stemp].name+"='"+d[stemp].value+"' ";
                  } 

                  generator_string  += "]";
                  container_str = '';

                  temp.find('.rad_page_container').each(function(k){

                          container_settings = [];
                          ctemp = jQuery(this);
                          c_id = ctemp.attr('id');

                          widgets=[];

                          if(_.has(rad_sections,c_id))
                          container_settings =  rad_sections[c_id];
                          container_settings['id'] = c_id;
                          container_str  += "[rad_page_container id='"+c_id+"' layout='"+ctemp.find('.component_layout').val()+"' ";

                          if(ctemp.hasClass('first')) container_str += "first='true' ";
                          if(ctemp.hasClass('last')) container_str += "last='true' ";
                          if(ctemp.hasClass('top')) container_str += "top='true' ";

                          for(stemp=0;stemp<container_settings.length;stemp++)
                          {
                          container_str += container_settings[stemp].name+"='"+container_settings[stemp].value+"' ";
                          }



                          container_str  += "]";



                          widget_str = '';
                          widget_str = '';
                          we=0;

                          ctemp.find('.rad_page_widget').each(function(l){

                                                    widget_settings=[];


                                                    if(_.has(rad_sections,jQuery(this).attr('id')))
                                                            widget_settings =  rad_sections[jQuery(this).attr('id')];

                                                    widgets[l] = { id : jQuery(this).attr('id') , data  : widget_settings  , type : jQuery(this).data('key')   };

                                                    widget_str  += "[rad_page_widget id='"+jQuery(this).attr('id')+"'  type='"+jQuery(this).data('key')+"' ";

                                                    if(jQuery(this).hasClass('last')) widget_str += "last='true' ";
                                                    if(jQuery(this).hasClass('top')) widget_str += "top='true' ";

                                                    widget_content = '';
                                                    
                                                    style_keys[jQuery(this).attr('id')] = { key :jQuery(this).data('key') , data:[]  };

                                                    for(stemp=0;stemp<widget_settings.length;stemp++)
                                                    {
                                                            if( jQuery.inArray( widget_settings[stemp].name , rad_rich_fields) > -1 ) 
                                                            {
                                                            widget_content =  widget_settings[stemp].value ;
                                                            widget_str += "rich_key='"+widget_settings[stemp].name+"' ";
                                                            }
                                                            else  
                                                            widget_str += widget_settings[stemp].name+"='"+htmlEntities(widget_settings[stemp].value)+"' ";

                                                            if( jQuery.inArray( widget_settings[stemp].name , rad_builder_data[jQuery(this).data('key')]['styles'] ) > -1 ) 
                                                            {
                                                            style_keys[jQuery(this).attr('id')]['data'][we++] = widget_settings[stemp];
                                                            } 

                                                    }

                                                    widget_str  += "]";

                                                    widget_str += jQuery.trim(widget_content)+"[/rad_page_widget]";


                                                   

                          });

                          style_keys[c_id] = { key :'rad_page_container' , data:container_settings  };
                          container_str += widget_str+"[/rad_page_container]";
                          conts[k] = { id : c_id , data  : container_settings , layout : ctemp.find('.component_layout').val() , widgets : widgets  };

                  });


                  generator_string += container_str+"[/rad_page_section]";

                  style_keys[s_id] = { key :'rad_page_section' , data:d  };
                  save_array[i] = { id : s_id , data  :  d , containers : conts  };


          });

          if(  jQuery('#ioa_template_mode').val() == 'rad-builder'  ) {

                  jQuery('#content-html').trigger('click');
                  jQuery('#content').val(generator_string);
                 jQuery('#style_keys').val( encodeRFC5987ValueChars ( JSON.stringify(style_keys) ) );  

          
          }

          return JSON.stringify(save_array); // Return the value for Other Purposes

      
   }



} // END of Object

function encodeRFC5987ValueChars (str) {
    return encodeURIComponent(str).
        replace(/\%/g, '[p]');
}

/*=====================================
=            Init Lightbox            =
=====================================*/

  if(Modernizr.localstorage && Phantom.checkRegistry('RAD_lightbox_data') && Phantom.reset ==false )
  {
    lightbox_cache = Phantom.getRegistry('RAD_lightbox_data');

    RAD_Builder.presetLightbox();
  }
  else  
  {
    jQuery.post(saving_link,{ type:"rad-builder-data", action: 'rad_query_listener' },function(data){
          
         lightbox_cache = data;
       
          RAD_Builder.presetLightbox();
          Phantom.addLocalRegistry('RAD_lightbox_data',data);
        
      });
   
  }

/*-----  End of Init Lightbox  ------*/




/**
 * Saving mechanism
 */


var save_button = jQuery('#publish'),save_template = jQuery('a.save-rad-template');
jQuery('#post').on('submit', function(e){  RAD_Builder.saveRADData(frame);  });
jQuery('.ioa-admin-menu').on('click', function(e){  RAD_Builder.saveRADData(frame); e.preventDefault(); });


/**
*
* Activate the Builder
*
**/


RAD_Builder.init();

/**
 * Menu Item Adding Mechanism
 */

var menu_code = jQuery('<li class="clearfix"><h6></h6><i class="ioa-front-icon cancel-2icon- delete"></i></li>');

doc.on('click','.rad_menu_area .delete',function(e){
    parent = jQuery(this).parents('.ui-tabs-panel');
    jQuery(this).parent().remove();

    setMenuCode(parent);

});

doc.on('click','.add_rad_menu_item',function(e){
    e.preventDefault();

    parent = jQuery(this).parents('.ui-tabs-panel');
    temp = menu_code.clone();
    temp.find('h6').html(jQuery(this).parent().find('select option:selected').text());
    temp.data('id',jQuery(this).parent().find('select').val());
    parent.find('.rad_menu_area').append(temp);

    setMenuCode(parent);

}); 

function setMenuCode(parent)
{
   var temp='';

   parent.find('.rad_menu_area li').each(function(){
      temp += jQuery(this).data('id')+':'+jQuery(this).find('h6').html()+';';
   });

   parent.find('.rad_added_menus').val(temp);
   
}

/*===========================================
=            RAD Builder Events             =
===========================================*/

doc.on('click', '.width-correction',function(e){
  e.preventDefault();
  var c = current_editing_obj.parents('.rad_page_container');
  if(c.hasClass('full')) c = 1060;
  else if(c.hasClass('one_half')) c = 505;
  else if(c.hasClass('one_third')) c = 320;
  else if(c.hasClass('one_fourth')) c = 227;
  else if(c.hasClass('one_fifth')) c = 172;
  else if(c.hasClass('two_third')) c = 690;
  else if(c.hasClass('three_fourth')) c = 783;
  else if(c.hasClass('four_fifht')) c = 838;

  jQuery(this).prev().val(c);
});

jQuery('.proxy-rad-page-trigger').click(function(e){
   e.preventDefault();
   jQuery('.rad-insta-page').trigger('click');
});

jQuery('.close-rad-library').click(function(e){
   e.preventDefault();
   jQuery('.rad-library-lightbox').fadeOut('normal');
});

jQuery('.rad-insta-page').click(function(e){
   e.preventDefault();
   jQuery('.rad-library-lightbox').fadeIn('normal');
});


jQuery('.close-rad-section-library').click(function(e){
   e.preventDefault();
   jQuery('.rad-library-section-lightbox').fadeOut('normal');
});

jQuery('.rad-insta-section').click(function(e){
   e.preventDefault();
   jQuery('.rad-library-section-lightbox').fadeIn('normal');
});



jQuery('.rad-swift-menu li a ').click(function(){ 

       rad_sidebar.addClass('toolbox-full');
        jQuery('.toggle-rad_toolbox').removeClass('left-open-bigicon-').addClass(' right-open-bigicon-');
        body.addClass('rad_toolbox_expanded');

 });

doc.on('click','.toggle-rad_toolbox',function(e){
    e.preventDefault();

    if( jQuery(this).hasClass('left-open-bigicon-') )
    {
        rad_sidebar.addClass('toolbox-full');
        jQuery(this).toggleClass('left-open-bigicon- right-open-bigicon-');
        body.addClass('rad_toolbox_expanded');
    }
    else
    {   
        rad_sidebar.removeClass('toolbox-full');
        jQuery(this).toggleClass('left-open-bigicon- right-open-bigicon-');
        body.removeClass('rad_toolbox_expanded');

    }

});

doc.on('click','.toggle-rad-state',function(e){
    e.preventDefault();

    if( jQuery(this).hasClass('maximize-builder') )
    {
        jQuery(this).toggleClass('resize-full-2icon- resize-small-2icon- maximize-builder');
        body.addClass('rad-maximize');
    }
    else
    {   
        jQuery(this).toggleClass('resize-full-2icon- resize-small-2icon- maximize-builder');
        body.removeClass('rad-maximize');
    }

});

doc.on('click','.rad-publish-button',function(e){
  RAD_Builder.saveRADData(frame);
  setTimeout(function(){ save_button.trigger('click'); },50);
})

/**
*
* Add RAD Sections
*
**/


doc.on('click','.append-rad-row',function(e){
   e.preventDefault();
   rad_undo =  frame.html();
    obj = jQuery(this).parents('.rad_page_section');
    
    jQuery('.rad-help').remove();
    
    temp = jQuery(RAD_Views.sectionView.replace('{ID}','rps'+routines.uniqueid()));
    
    obj.after(temp);
    RAD_Builder.sectionHandle(temp);
    routines.addRecord(temp.attr('id'),rad_builder_data['rad_page_section']['inputs']);

}) ;


doc.on('click','.add-rad-row',function(e){
  
    e.preventDefault();
    rad_undo =  frame.html();
    jQuery('.rad-help').remove();
    
    temp = jQuery(RAD_Views.sectionView.replace('{ID}','rps'+routines.uniqueid()));
    frame.append(temp);
    RAD_Builder.sectionHandle(temp);

     _.each(rad_builder_data['rad_page_section']['inputs'],function(k,v){
            if(k.name == 'section_name')
               {
                temp.find('.section-name').html(k.value);
               }
             if(k.name == 'visibility')
               {
                temp.find('.section-visibility').html(k.value);
               }   
        });

    routines.addRecord(temp.attr('id'),rad_builder_data['rad_page_section']['inputs']);

})

/**
*
* Export RAD Section as File
*
**/


doc.on('click', '.section-export',function(e){
  e.preventDefault();
  save_array = [];
  temp = jQuery(this).parents('.rad_page_section');
  
      d = [];
      
      /**
       * Section Settings
       */
       
       if(_.has(rad_sections,temp.attr('id')))
               d =  rad_sections[temp.attr('id')];

      conts = [];
      
      /**
       * Going Through all the Containers
       */
     
     temp.find('.rad_page_container').each(function(k){
         container_settings = [];
         widgets=[];
         
         if(_.has(rad_sections,jQuery(this).attr('id')))
               container_settings =  rad_sections[jQuery(this).attr('id')];

         jQuery(this).find('.rad_page_widget').each(function(l){
          
                  widget_settings=[];
                  
                   if(_.has(rad_sections,jQuery(this).attr('id')))
                       widget_settings =  rad_sections[jQuery(this).attr('id')];

                   widgets[l] = { id : jQuery(this).attr('id') , data  : widget_settings  , type : jQuery(this).data('key') };


         });

         conts[k] = { id : jQuery(this).attr('id') , data  : container_settings , layout : jQuery(this).find('.component_layout').val() , widgets : widgets  };
      
      });

      save_array[0] = { id : temp.attr('id') , data  : d , containers : conts  };
 
       jQuery.post(
          saving_link,{ type:"RAD-Template-Export", action: 'rad_query_listener' , data : JSON.stringify(save_array)  , id : frame.data('id') ,title : jQuery(this).prev().val() },function(data){
      

      window.location.href = jQuery('.export-templates').attr('href')+"&rad_export=true";
    });
    

});

/**
*
*  RAD Section  Triggers
*
**/

jQuery('.section-export-trigger').click(function(e){
   e.preventDefault();
   jQuery(this).parents('.rad_page_section').find('.export-section-panel').fadeToggle('normal');
});

doc.on('click','.close-ex-panel',function(e){
    jQuery(this).parent().fadeOut('fast');
});

doc.on('click','.section-delete',function(e){
    e.preventDefault();
    rad_undo =  frame.html();
    temp = jQuery(this).parents('.rad_page_section');
    temp.remove();
});

doc.on('click','.section-clone',function(e){
    e.preventDefault();
    
    rad_undo =  frame.html();

    obj = jQuery(this).parents('.rad_page_section');
    temp = obj.clone();
    temp.attr('id','rps'+routines.uniqueid());


    var srcs = obj.find('.rad_page_container') , ws = [];

    temp.find('.rad_page_container').each(function(j){

                jQuery(this).attr('id','rpc'+routines.uniqueid());
                routines.mapSettings(  jQuery(this), srcs.eq(j) );

                routines.selectOptionByText(jQuery(this).find('.component_layout') ,srcs.eq(j).find('.component_layout').val());

                ws = srcs.eq(j).find('.rad_page_widget');

                jQuery(this).find('.rad_page_widget').each(function(i){
                jQuery(this).attr('id','rpw'+routines.uniqueid());
                routines.mapSettings(  jQuery(this), ws.eq(i) );
                jQuery(this).data('key',ws.eq(i).data('key'));
                });  

    });  

    obj.after(temp);
    routines.mapSettings(temp,obj);
    RAD_Builder.sectionHandle(temp);
});

doc.on('click','.section-edit',function(e){
   
    e.preventDefault();
    rad_undo =  frame.html();
   
    current_editing_obj =  jQuery(this).parents('.rad_page_section');
    lightbox.data('key','rad_page_section');
    maptoLightbox( lightbox.find('.rad_page_section') ,current_editing_obj  );
    sapi.show();  

});

doc.on('change','.rad_page_section .background_opts',function(){
    
    lightbox.find('.rad_page_section').find('.sec-bg-listener').hide();

    switch( jQuery(this).val() )
    {
      case 'bg-color' : lightbox.find('.rad_page_section').find('.bg-color').show(); break;
      case 'bg-image' : lightbox.find('.rad_page_section').find('.bg-image').show(); break;
      case 'parallax' : lightbox.find('.rad_page_section').find('.parallax').show(); break;
      case 'bg-gr' : lightbox.find('.rad_page_section').find('.bg-gradient').show(); break;
      case 'bg-video' : lightbox.find('.rad_page_section').find('.bg-video').show(); break;
      case 'bg-texture' : lightbox.find('.rad_page_section').find('.bg-texture').show(); break;
      case 'custom'  : lightbox.find('.rad_page_section').find('.sec-bg-listener').show();  
                       lightbox.find('.rad_page_section').find('.bg-video,.bg-gradient').hide(); break;
    }
}); 

/**
*
* RAD Container Triggers
*
**/



doc.on('click','.container-clone',function(e){
    e.preventDefault();
    rad_undo =  frame.html();
    obj = jQuery(this).parents('.rad_page_container');
    temp = obj.clone();
    c_id = 'rpc'+routines.uniqueid();
    temp.attr('id',c_id);
    
    var  srcs = obj.find('.rad_page_widget') ;

    obj.after(temp);
    temp.find('.rad_page_widget').each(function(i){
        w_id = 'rpw'+routines.uniqueid();
        jQuery(this).attr('id',w_id);
        routines.addRecord( w_id, rad_sections[srcs.eq(i).attr('id')] );
        jQuery(this).data('key',srcs.eq(i).data('key'));
    }); 


    routines.mapSettings(temp,obj);
    RAD_Builder.containerHandle(temp);
    routines.selectOptionByText(temp.find('.component_layout') ,obj.find('.component_layout').val());
    
    prediction();

});


doc.on('click','.container-delete',function(e){
    e.preventDefault();
    rad_undo =  frame.html();
    temp = jQuery(this).parents('.rad_page_container');
    temp.remove();
    setTimeout(function(){ prediction(); },30);

});


doc.on('click','.container-edit',function(e){
    e.preventDefault();

    current_editing_obj =  jQuery(this).parents('.rad_page_container');
    
    lightbox.data('key','rad_page_container');
    maptoLightbox( lightbox.find('.rad_page_container') ,current_editing_obj  );

    sapi.show();  
});

/**
*
* RAD Widgets Triggers
*
**/

doc.on('click','.widget-clone',function(e){
    e.preventDefault();
    
    rad_undo =  frame.html();
    obj = jQuery(this).parents('.rad_page_widget');
    temp = obj.clone();
    temp.attr('id','rpw'+routines.uniqueid());

    obj.after(temp);
    temp.data('key',obj.data('key'));
    routines.mapSettings(temp,obj);
    
    setTimeout(function(){ widget_prediction(temp.parents('.container-content')); },30);

});

doc.on('click','.widget-edit',function(e){
    e.preventDefault();
    rad_undo =  frame.html();
    current_editing_obj =  jQuery(this).parents('.rad_page_widget');
    lightbox.data('key',current_editing_obj.data('key'));

    maptoLightbox( lightbox.find('.'+current_editing_obj.data('key')) ,current_editing_obj  );
    sapi.show();  

});



doc.on('click','.widget-delete',function(e){
    e.preventDefault();
    rad_undo =  frame.html();
    temp = jQuery(this).parents('.rad_page_widget');
    temp.remove();
    setTimeout(function(){ widget_prediction(temp.parents('.container-content')); },30);
});




/**
*
* Interactive Triggers
*
**/


jQuery('.ioa-close-wp-editor').click(function(e){ 
    e.preventDefault();
    jQuery('.ioa-wp-editor').fadeOut('normal');
});


doc.on('change','.col_style',function(){
   temp = jQuery(this).parents('.ui-tabs-panel');
   if(jQuery(this).val() == 'image-box') temp.find('.image-box').show();
   else temp.find('.image-box').hide();

   if(jQuery(this).val() == 'iconed-alt') temp.find('.iconed-alt').show();
   else temp.find('.iconed-alt').hide();

});


doc.on('change','.col_link',function(){
   temp = jQuery(this).parents('.ioa_input').parent();
   temp.find('.ioa-link-filter').hide();
   temp.find('.ioa-link-filter.'+jQuery(this).val()).show();
});


 doc.on('click','div.save-template-lightbox a.close-icon , div.import-template-lightbox a.close-icon',function(e){
    e.preventDefault();
    jQuery(this).parent().animate({ opacity : 0 },400,'',function(){
        jQuery(this).hide();
    });
});


jQuery('.save-menu  a.save-toggle').click(function(e){
    e.preventDefault();
});

jQuery('.save-toggle-wrap').hover(function(e){
    jQuery(this).find('ul').slideDown('fast');
    e.preventDefault();
},function(){
    jQuery(this).find('ul').slideUp('fast');
});


doc.on('click','.cancel-settings',function(e){
    e.preventDefault();
    sapi.hide();  
});



 doc.on('change','.rad_page_container .background_opts',function(){
    
    lightbox.find('.rad_page_container').find('.sec-bg-listener').hide();

    switch( jQuery(this).val() )
    {
      case 'bg-color' : lightbox.find('.rad_page_container').find('.bg-color').show(); break;
      case 'bg-image' : lightbox.find('.rad_page_container').find('.bg-image').show(); break;
      case 'bg-gr' : lightbox.find('.rad_page_container').find('.bg-gradient').show(); break;
      case 'bg-video' : lightbox.find('.rad_page_container').find('.bg-video').show(); break;
      case 'bg-texture' : lightbox.find('.rad_page_container').find('.bg-texture').show(); break;
      case 'custom'  : lightbox.find('.rad_page_container').find('.sec-bg-listener').show();  
                       lightbox.find('.rad_page_container').find('.bg-video,.bg-gradient').hide(); break;
    }
});



doc.on('change','.component_layout',function(){
    rad_undo =  frame.html();
    temp = jQuery(this).parents('.rad_page_container');
    temp.removeClass('full one_fifth one_fourth one_third one_half two_third three_fourth four_fifth');
    temp.addClass( jQuery(this).val() );
    setTimeout(function(){ prediction(); },30);

});


doc.on('click','.save-settings',function(e){
    e.preventDefault();
    maptoObj( current_editing_obj, lightbox.find('.'+lightbox.data('key')) );
    sapi.hide();  
});



if( jQuery('#ioa_template_mode').length > 0 )
{
      
      win.obj.load(function() {
        /* Act on the event */

            jQuery('#list-table').find('tr').each(function(){

                temp = jQuery(this);

               if( temp.find('input[type=text]').val() == 'rad_data'  )
               {
                    temp.remove();
               }

          });
            
        temp = jQuery('#ioa_template_mode').val();

        if( temp == "wp-editor")
        {
          jQuery('#postdivrich').show();
          jQuery('#rad_backend_builder').hide();
          jQuery('.ioa-page-builder-trigger').html('Switch To Page Builder');
        }
        else
        {
          jQuery('#postdivrich').hide();
          jQuery('#rad_backend_builder').show();
          jQuery('.ioa-page-builder-trigger').html('Switch To Default Editor');
          jQuery('body').addClass('show-rad-panel');
        }
  
      });
  
}

 jQuery('.ioa-page-builder-trigger').click(function(e){
  
  temp = jQuery(this);
  
  if( temp.html() == "Switch To Default Editor" )
  {
                  jQuery('#postdivrich').show();
                  

                  jQuery('#rad_backend_builder').hide();
                  temp.html('Switch To Page Builder');
                  jQuery('#ioa_template_mode').val('wp-editor');
                  body.removeClass('show-rad-panel');
                 

                   jQuery('html,body').scrollTop(1);

                  setTimeout(function(){
                      jQuery('html,body').scrollTop(0);
                  },1000);

                  
                 

  }
  else
  {
                  jQuery('#postdivrich').hide();
                  jQuery('#rad_backend_builder').show();
                  temp.html('Switch To Default Editor');
                  jQuery('#ioa_template_mode').val('rad-builder');
                  body.addClass('show-rad-panel');
  }


  e.preventDefault();
});

 
doc.on('change','.unit_type',function(){
    temp = jQuery(this).parents('.module_body');
          
    temp.find('.mason-image-filter, .mason-text-filter').hide();
    switch( jQuery(this).val() )
    {
      case 'image' : temp.find('.mason-image-filter').show(); break;
      case 'text' : temp.find('.mason-text-filter').show(); break;
    }
    
});

doc.on('change','.slider_image_source',function(){

    lightbox.find('.'+lightbox.data('key')).find('.sl-img-listener').hide();
    switch( jQuery(this).val() )
    {
      case 'custom_images' : lightbox.find('.'+lightbox.data('key')).find('.custom_images').show(); break;
      case 'post_featured' : lightbox.find('.'+lightbox.data('key')).find('.post_featured').show(); break;
      case 'portfolio_meta' : lightbox.find('.'+lightbox.data('key')).find('.portfolio_meta').show(); break;
     
    }
})

jQuery('.rad-css-section-toggle').click(function(e){
    e.preventDefault();
    jQuery('.rad-custom-css').slideToggle('normal');

});



/**
 * Gallery Thumb Code
 */

jQuery('ul.rad_gallery_thumbs').sortable({

        stop: function( event, ui ) {   

        var list = jQuery(this), temp = list.parents('.ioa_input');
        var srcs = '',stemp;

        list.children().each(function(){
              stemp = jQuery(this);
              srcs +=  stemp.data('image')+"[ioas]"+stemp.data('thumbnail')+"[ioas]"+stemp.data('alt')+"[ioas]"+stemp.data('title')+"[ioas]"+stemp.data('description')+";";
        });

        temp.find('input').val(srcs);

        }

});

doc.on('click','.rad_gallery_thumbs .close',function(e){
     
      e.preventDefault();

      var list = jQuery(this).parents('ul'), temp = jQuery(this).parents('.ioa_input');
      jQuery(this).parent().remove();

      var srcs = '',stemp;
      list.children().each(function(){
      stemp = jQuery(this);
      srcs +=  stemp.data('image')+"[ioas]"+stemp.data('thumbnail')+"[ioas]"+stemp.data('alt')+"[ioas]"+stemp.data('title')+"[ioas]"+stemp.data('description')+";";
      });

      temp.find('input').val(srcs);

});

var proxy_temp;
doc.on('click','.rad_gallery_upload', function(e){
      
      e.preventDefault();
      proxy_temp =  jQuery(this);

      hmedia.open(proxy_temp.data('title'),proxy_temp.data('label'),function(images){ 
                

                  var gl = '';
                  var srcs = '';
                  for(var i=0;i<images.length;i++)
                  {

                          thumb = images[i].sizes.full.url;
                          if( typeof images[i].sizes.thumbnail != 'undefined' )
                                   thumb = images[i].sizes.thumbnail.url;


                          gl += "<li data-image='"+images[i].url+"' data-thumbnail='"+thumb+"' data-alt='"+images[i].alt+"' data-title='"+images[i].title+"' data-description='"+images[i].description+"' ><img src='"+thumb+"' /> <a class='close' href=''></a></li>";
                          srcs +=  images[i].url+"[ioas]"+thumb+"[ioas]"+images[i].alt+"[ioas]"+images[i].title+"[ioas]"+images[i].description+";";
                  }
                  proxy_temp.parent().find('ul.rad_gallery_thumbs').append(gl); 

                  temp = proxy_temp.parent().find('input');  
                  temp.val(temp.val()+""+srcs);


      });


}); 

/*=======================================
=            Saving Triggers   & States         =
=======================================*/

doc.on('click','.rad-undo',function(e){
  rad_redo = frame.html();
    frame.html(rad_undo);
    e.preventDefault();
})


doc.on('click','.rad-redo',function(e){
    frame.html(rad_redo);
    e.preventDefault();
})

jQuery('#wp-admin-bar-trigger-post-update').click(function(e){

  e.preventDefault();
  jQuery('#publish').trigger('click');

});


jQuery('.rad-publish-post-trigger , .trigger-post-update').click(function(e){
 
  e.preventDefault();
  jQuery('#publish').trigger('click');

});


save_template.click(function(e){
  e.preventDefault();
  save_template.html('Saving');
 

   jQuery.post(saving_link,{
       type:"RAD-Template", 
       action: 'rad_query_listener' , 
       data : RAD_Builder.saveRADData(frame)  , 
       id : frame.data('id') ,
       title : jQuery('#rad-template-title').val() 

     },function(data){
     
      ioa_msg.setMessage('Saved','Template Has been saved !','success');
      ioa_msg.show();
      save_template.html('Save Template'); 

      jQuery('div.save-template-lightbox').fadeOut('fast');

     });
    

});


jQuery('.save-template').click(function(e){
    e.preventDefault();
    jQuery('div.save-template-lightbox').css({ opacity:0 , display:'block' }).animate({  opacity : 1 },400);

});

jQuery('.saved-templates').click(function(e){
    e.preventDefault();
    jQuery(this).next().css({ opacity:0 , display:'block'  }).animate({opacity : 1 },400);

});

jQuery('.import-page-templates').click(function(e){
    e.preventDefault();
    jQuery('.page-import-area').slideToggle('normal');

});

/**
*
* Save RAD Section
*
**/


doc.on('click', '.section-rad-save-s-t',function(e){
        e.preventDefault();
        save_array = [];

         ioa_msg.setMessage('Saved','Section Has been saved !','success');
         ioa_msg.showStatic();

        temp1 = jQuery(this);
        temp1.html('Saving');

        var s_title = 'ID '+current_editing_obj.attr('id');
        d = [];
        s_id   = current_editing_obj.attr('id');


        /**
        * Section Settings
        */
        if(_.has(rad_sections,s_id))
        d =  rad_sections[s_id];

         if(  jQuery.trim(jQuery(this).prev().val() )  != "" )
         {
                s_title = jQuery.trim(jQuery(this).prev().val() );
         }

         

        conts = [];
        temp = jQuery('#'+s_id);

        /**
        * Going Through all the Containers
        */
        temp.find('.rad_page_container').each(function(k){
       
                  container_settings = [];
                  widgets=[];
                  if(_.has(rad_sections,jQuery(this).attr('id')))
                  container_settings =  rad_sections[jQuery(this).attr('id')];

               
                  jQuery(this).find('.rad_page_widget').each(function(l){

                            widget_settings=[];

                            if(_.has(rad_sections,jQuery(this).attr('id')))
                                      widget_settings =  rad_sections[jQuery(this).attr('id')];

                            widgets[l] = { id : jQuery(this).attr('id') , data  : widget_settings  , type : jQuery(this).data('key')   };

                  });

                  conts[k] = { id : jQuery(this).attr('id') , data  : container_settings , layout : jQuery(this).find('.component_layout').val() , widgets : widgets  };

        });

        save_array[0] = { id : temp.attr('id') , data  : d , containers : conts  };


        jQuery.post(saving_link,{ 
        type:"RAD-Template-Section", 
        action: 'rad_query_listener' , 
        data : JSON.stringify(save_array)  , 
        id : frame.data('id') ,
        title : s_title },function(data){

               
                ioa_msg.hide();
                temp1.html('Save Row');

        });
    

});

jQuery('.export-templates').click(function(e){
  e.preventDefault();
  save_array = [];
 
   jQuery.post(saving_link,{ type:"RAD-Template-Export", action: 'rad_query_listener' , data : RAD_Builder.saveRADData(frame)  , id : frame.data('id') ,title : jQuery('#title').val() },function(data){
    
      window.location.href = jQuery('.export-templates').attr('href')+"&rad_export=true";

    });
    

});

jQuery('a.rad-clear-all').click(function(e){
    e.preventDefault();
   rad_undo =  frame.html();

    var r=confirm("Are you sure you want to delete all content ! This cannot be undone.");
    if (r==true)
      {
         frame.empty();
        
      }
  
});



jQuery('.import-old-backup').click(function(e){
e.preventDefault();
    ioa_msg.setMessage('Importing..','Importing Content for the Template','information');
    ioa_msg.showStatic();

    jQuery('.rad-library-lightbox-head').html('Importing Please wait...');

     jQuery.post(saving_link,{ type:"RAD-OldBackup", action: 'rad_query_listener' , pid : jQuery('#post_ID').val() },function(data){

                  data = jQuery(data);

                  frame.children('.rad-help').remove();  
                  frame.append(data);

                  data.each(function(){
                     
                     s_id =   jQuery(this).attr('id');
                   
                      
                      var sj = [];

                      jQuery(this).children('.save-data').find('textarea').each(function(i){
                          sj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
                       }); 

                      routines.addRecord(s_id,sj);


                      RAD_Builder.sectionHandle(jQuery(this));

                      jQuery(this).find('.rad_page_container').each(function(j){
                                       

                                       RAD_Builder.containerHandle(jQuery(this));
                                       c_id =   jQuery(this).attr('id');

                                      var cj = [];
                                      jQuery(this).children('.save-data').find('textarea').each(function(i){
                                        cj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
                                     });
                                       routines.addRecord(c_id,cj);

                                      jQuery(this).find('.rad_page_widget').each(function(i){
                                                      w_id = jQuery(this).attr('id');

                                                      var wj = [];
                                                  
                                                    jQuery(this).children('.save-data').find('textarea').each(function(i){
                                                        wj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
                                                    });

                                                     routines.addRecord(w_id,wj);
                                     
                                      });  

                    
                    });  

                  });
                 
                 data.find('.save-data').remove(); 
                ioa_msg.hide();

                 prediction();
    });

});



jQuery('.insta-template-trigger').click(function(){

    ioa_msg.setMessage('Importing..','Importing Content for the Template','information');
    ioa_msg.showStatic();

    jQuery('.rad-library-lightbox-head').html('Importing Please wait...');

     jQuery.post(saving_link,{ type:"RAD-InstaImport", action: 'rad_query_listener' , key : jQuery(this).data('source') },function(data){

                  data = jQuery(data);

                  frame.children('.rad-help').remove();  
                  frame.append(data);

                  data.each(function(){
                     
                     s_id = 'rps'+routines.uniqueid();
                     jQuery(this).attr('id', s_id );
                      
                      var sj = [];

                      jQuery(this).children('.save-data').find('textarea').each(function(i){
                          sj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
                       }); 

                      routines.addRecord(s_id,sj);


                      RAD_Builder.sectionHandle(jQuery(this));

                      jQuery(this).find('.rad_page_container').each(function(j){
                                       

                                       RAD_Builder.containerHandle(jQuery(this));
                                       c_id = 'rpc'+routines.uniqueid();
                                      jQuery(this).attr('id',c_id);

                                      var cj = [];
                                      jQuery(this).children('.save-data').find('textarea').each(function(i){
                                        cj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
                                     });
                                       routines.addRecord(c_id,cj);

                                      jQuery(this).find('.rad_page_widget').each(function(i){
                                                      w_id = 'rpw'+routines.uniqueid();
                                                      jQuery(this).attr('id',w_id);

                                                      var wj = [];
                                                  
                                                    jQuery(this).children('.save-data').find('textarea').each(function(i){
                                                        wj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
                                                    });

                                                     routines.addRecord(w_id,wj);
                                     
                                      });  

                    
                    });  

                  });
                 
                 data.find('.save-data').remove(); 
                 jQuery('.rad-library-lightbox-head').html('Imported Have Fun');
                ioa_msg.hide();
                 setTimeout(function(){
                    jQuery('.rad-library-lightbox-head').html('Select File to Import');
                 },2000);

                 prediction();
    });

});


jQuery('.insta-section-template-trigger').click(function(){

    ioa_msg.setMessage('Importing..','Importing Content for the Template','information');
    ioa_msg.showStatic();

    jQuery('.rad-library-lightbox-head').html('Importing Please wait...');

   jQuery.post(saving_link,{ type:"RAD-InstaImport-Section", action: 'rad_query_listener' , key : jQuery(this).data('source') },function(data){

      data = jQuery(data); 
       frame.children('.rad-help').remove();
      frame.append(data);

      data.each(function(){
         s_id = 'rps'+routines.uniqueid();
         jQuery(this).attr('id', s_id );
          
          var sj = [];
          jQuery(this).children('.save-data').find('textarea').each(function(i){
              sj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
           }); 

          routines.addRecord(s_id,sj);


          RAD_Builder.sectionHandle(jQuery(this));

          jQuery(this).find('.rad_page_container').each(function(j){
             RAD_Builder.containerHandle(jQuery(this));
             c_id = 'rpc'+routines.uniqueid();
            jQuery(this).attr('id',c_id);

            var cj = [];
            jQuery(this).children('.save-data').find('textarea').each(function(i){
              cj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
           });
             routines.addRecord(c_id,cj);

            jQuery(this).find('.rad_page_widget').each(function(i){
                w_id = 'rpw'+routines.uniqueid();
                jQuery(this).attr('id',w_id);

                var wj = [];
            
              jQuery(this).children('.save-data').find('textarea').each(function(i){
                  wj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
              });

               routines.addRecord(w_id,wj);
           
            });  

        
        });  

      });
     
     data.find('.save-data').remove();
     ioa_msg.hide();
     prediction();
     jQuery('.rad-library-lightbox-head').html('Imported Have Fun');
     setTimeout(function(){
        jQuery('.rad-library-lightbox-head').html('Select Section to Import');
     },2000);

    });

});


/*=========================================
=            Revision Handling            =
=========================================*/


var current_template = '' , current_lock = false;

jQuery('.rev-current-thumb').click(function(){
   
    rad_undo =  frame.html();
    frame.html(current_template);
    current_lock = false;
    current_template = '';
    jQuery(this).fadeOut('fast');

});

if( jQuery('#rad-rev').length  > 0  ) {
jQuery('.rev-thumb').click(function(){
      rad_undo =  frame.html();
     
      if(current_lock === false )
      {
              current_template = frame.html();
              jQuery('.rev-current-thumb').fadeIn('fast');
      }

      current_lock = true;

      jQuery.post(saving_link,{ type:"RAD-Revision-Import", action: 'rad_query_listener', post_id : frame.data('id') , key : jQuery(this).data('id') },function(data){

      data = jQuery(data);  
      frame.html(data);

      data.each(function(){
              
              s_id = 'rps'+routines.uniqueid();
              jQuery(this).attr('id', s_id );

              var sj = [];
              jQuery(this).children('.save-data').find('textarea').each(function(i){
              sj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
              }); 

              routines.addRecord(s_id,sj);
              RAD_Builder.sectionHandle(jQuery(this));

              jQuery(this).find('.rad_page_container').each(function(j){
             

                          RAD_Builder.containerHandle(jQuery(this));
                          c_id = 'rpc'+routines.uniqueid();
                          jQuery(this).attr('id',c_id);

                          var cj = [];
                          jQuery(this).children('.save-data').find('textarea').each(function(i){
                                cj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
                          });

                          routines.addRecord(c_id,cj);

                          jQuery(this).find('.rad_page_widget').each(function(i){
                                  
                                  w_id = 'rpw'+routines.uniqueid();
                                  jQuery(this).attr('id',w_id);

                                  var wj = [];

                                  jQuery(this).children('.save-data').find('textarea').each(function(i){
                                            wj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
                                  });

                                  routines.addRecord(w_id,wj);

                          });  


              });  

      });

      data.find('.save-data').remove();
      ioa_msg.setMessage('Revision Loaded','Revision Successfully loaded','information');
      ioa_msg.show();
      prediction();
      });


});

jQuery('.save-revision').click(function(e){
   
    e.preventDefault();

    var currentdate = new Date();
    var auto_title = 'Revision '+ currentdate.getDate() + "/"+(currentdate.getMonth()+1) + "/" + currentdate.getFullYear() + " @ " + currentdate.getHours() + ":"  + currentdate.getMinutes();

   jQuery.post(saving_link,{ type:"RAD-Revision", action: 'rad_query_listener' , data : RAD_Builder.saveRADData(frame)  , id : frame.data('id') ,title : auto_title },function(data){
      ioa_msg.setMessage('Revision Saved','Template revisions has been saved !','information');
    ioa_msg.show();

     });
 

});

}

/*-----  End of Revision Handling  ------*/

/*===========================================
=            Templates Searching            =
===========================================*/



var query , qlen , test ,qar , fn , files = jQuery('.insta-template,.import-s-template'), se;
    
 jQuery('.rad-file-input').keyup(function(e){
     
      query = jQuery(this).val().toLowerCase();
      qar = query.split(' ');
      qlen =  qar[0].length;

      files.hide();
      files.removeClass('first')
      
      if(qlen >= 2)
      {
          
          files.each(function(){
            test = []; temp = jQuery(this); fn = true;
            for(var i=0;i<qar.length;i++) {

              se = temp.data('source').toLowerCase();
              if( typeof se !='undefined' &&  se.indexOf(qar[i]) != -1 )
                test[i] = true;
              else
                test[i] = false;
            }
            
            for(var i=0;i<test.length;i++)  fn = fn && test[i];

            if(fn === true) jQuery(this).show();

          });

        
      }
      else
      {
        files.show();
      }
    

    }); 

var r_sections = jQuery('.insta-section-template,.import-s-template');
jQuery('.rad-section-file-input').keyup(function(e){
      query = jQuery(this).val().toLowerCase();
      qar = query.split(' ');
      qlen =  qar[0].length;

      r_sections.hide();
      
      if(qlen >= 2)
      {
          
          r_sections.each(function(){
            test = []; temp = jQuery(this); fn = true;
            for(var i=0;i<qar.length;i++) {

              se = temp.data('source').toLowerCase();
              if( typeof se !='undefined' &&  se.indexOf(qar[i]) != -1 )
                test[i] = true;
              else
                test[i] = false;
            }
            
            for(var i=0;i<test.length;i++)  fn = fn && test[i];

            if(fn === true) jQuery(this).show();

          });

        
      }
      else
      {
        r_sections.show();
      }


    }); 


 

/**
 * Reset Mechanism
 */

doc.on('click','.style-reset',function(e){
  e.preventDefault();

  jQuery(this).parent().next().find('.ioa_input').each(function(){
      temp = jQuery(this).find('input[type=text],textarea,select,input[type=checkbox]');

      if( temp.is('select') )
      {
         routines.selectOptionByText(temp,'');
      }
      else if(temp.is(':checkbox'))
      {
        temp.removeAttr('checked');
      }  
      else
      {

        if(temp.hasClass('ioa-minicolors'))
        {
          temp.minicolors("value",'');
        }
        else  
          temp.val('');
      }

      if( jQuery(this).find('.ioa_slider').length > 0 )
        {
           jQuery(this).find('.ioa_slider').slider( "value", 0 );
        } 


   });


});


/**
 * Template Saving Mechanism
 */


jQuery('.import-rad-page').click(function(e){
    e.preventDefault();
    if(jQuery('.import_rad_page').val()=="") return;

      ioa_msg.setMessage('Importing..','Importing Content, Please Wait','information'); 
      ioa_msg.show();

    jQuery.post(saving_link,{ type:"RAD-Page-Import", action: 'rad_query_listener' , data : jQuery('.import_rad_page').val()   },function(data){
      

      data = jQuery(data);  
       frame.children('.rad-help').remove();
      frame.append(data);

      data.each(function(){
         s_id = 'rps'+routines.uniqueid();
         jQuery(this).attr('id', s_id );
          
          var sj = [];
          jQuery(this).children('.save-data').find('textarea').each(function(i){
              sj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
           }); 

          routines.addRecord(s_id,sj);


          RAD_Builder.sectionHandle(jQuery(this));

          jQuery(this).find('.rad_page_container').each(function(j){
             RAD_Builder.containerHandle(jQuery(this));
             c_id = 'rpc'+routines.uniqueid();
            jQuery(this).attr('id',c_id);

            var cj = [];
            jQuery(this).children('.save-data').find('textarea').each(function(i){
              cj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
           });
             routines.addRecord(c_id,cj);

            jQuery(this).find('.rad_page_widget').each(function(i){
                w_id = 'rpw'+routines.uniqueid();
                jQuery(this).attr('id',w_id);

                var wj = [];
            
              jQuery(this).children('.save-data').find('textarea').each(function(i){
                  wj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
              });

               routines.addRecord(w_id,wj);
           
            });  

        
        });  

      });

     
      data.find('.save-data').remove();
      jQuery('.page-import-area').slideToggle('normal');
      prediction();
    });


});



jQuery('.import-s-template').click(function(e){
    e.preventDefault();

       ioa_msg.setMessage('Importing..','Importing Content for the Section','information');
       ioa_msg.showStatic();

     jQuery.post(saving_link,{ type:"RAD-Import-Section", action: 'rad_query_listener' , key : jQuery(this).data('key') },function(data){
       
      data = jQuery(data);  
       frame.children('.rad-help').remove();
      frame.append(data);

       data.each(function(){
         s_id = 'rps'+routines.uniqueid();
         jQuery(this).attr('id', s_id );
          
          var sj = [];
          jQuery(this).children('.save-data').find('textarea').each(function(i){
              sj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
           }); 

          routines.addRecord(s_id,sj);


          RAD_Builder.sectionHandle(jQuery(this));

          jQuery(this).find('.rad_page_container').each(function(j){
             RAD_Builder.containerHandle(jQuery(this));
             c_id = 'rpc'+routines.uniqueid();
            jQuery(this).attr('id',c_id);

            var cj = [];
            jQuery(this).children('.save-data').find('textarea').each(function(i){
              cj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
           });
             routines.addRecord(c_id,cj);

            jQuery(this).find('.rad_page_widget').each(function(i){
                w_id = 'rpw'+routines.uniqueid();
                jQuery(this).attr('id',w_id);

                var wj = [];
            
              jQuery(this).children('.save-data').find('textarea').each(function(i){
                  wj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
              });

               routines.addRecord(w_id,wj);
           
            });  

        
        });  

      });
    
    data.find('.save-data').remove();
   
    ioa_msg.hide();
    });

});

jQuery('.import-s-template i.delete-icon').click(function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    temp = jQuery(this).parent();
     jQuery.post(saving_link,{ type:"RAD-Section-Delete", action: 'rad_query_listener' , key : temp.data('key') },function(data){
      
      temp.remove();

     ioa_msg.setMessage('Deleted','RAD Section has been deleted.','error');
    ioa_msg.show();
    });

});


jQuery('.import-p-template').click(function(e){
    e.preventDefault();

      ioa_msg.setMessage('Importing..','Importing Content for the Template','information');
      ioa_msg.showStatic();

     jQuery.post(saving_link,{ type:"RAD-Import", action: 'rad_query_listener' , key : jQuery(this).data('key') },function(data){
       
      data = jQuery(data); 
       frame.children('.rad-help').remove(); 
      frame.append(data);

       data.each(function(){
         s_id = 'rps'+routines.uniqueid();
         jQuery(this).attr('id', s_id );
          
          var sj = [];
          jQuery(this).children('.save-data').find('textarea').each(function(i){
              sj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
           }); 

          routines.addRecord(s_id,sj);


          RAD_Builder.sectionHandle(jQuery(this));

          jQuery(this).find('.rad_page_container').each(function(j){
             RAD_Builder.containerHandle(jQuery(this));
             c_id = 'rpc'+routines.uniqueid();
            jQuery(this).attr('id',c_id);

            var cj = [];
            jQuery(this).children('.save-data').find('textarea').each(function(i){
              cj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
           });
             routines.addRecord(c_id,cj);

            jQuery(this).find('.rad_page_widget').each(function(i){
                w_id = 'rpw'+routines.uniqueid();
                jQuery(this).attr('id',w_id);

                var wj = [];
            
              jQuery(this).children('.save-data').find('textarea').each(function(i){
                  wj[i] = { name : jQuery(this).attr('name') , value : jQuery(this).val()  }; 
              });

               routines.addRecord(w_id,wj);
           
            });  

        
        });  

      });
    
    data.find('.save-data').remove();
    ioa_msg.hide();
    });

});

jQuery('.import-p-template i.delete-icon').click(function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    temp = jQuery(this).parent();
     jQuery.post(saving_link,{ type:"RAD-Template-Delete", action: 'rad_query_listener' , key : temp.data('key') },function(data){
      
      temp.remove();

     ioa_msg.setMessage('Deleted','RAD Template has been deleted.','error');
    ioa_msg.show();
    });

});


doc.on('click','.ioa-editor-trigger', function(e){ 
    e.preventDefault();
    ioa_wp_obj = jQuery(this).parents('.ioa_input');


    if( jQuery('.ioa-wp-editor-area').find('.wp-editor-wrap').hasClass('html-active') ) {
        val  =  jQuery('.ioa_wp_editor').val( ioa_wp_obj.find('textarea').val());
    } else {
         tinyMCE.get('ioa_wp_editor').setContent( ioa_wp_obj.find('textarea').val());
    }


    jQuery('.ioa-wp-editor').fadeIn('normal');

});

jQuery('.ioa-save-wp-editor').click(function(e){ 
    e.preventDefault();

    if( jQuery('.ioa-wp-editor-area').find('.wp-editor-wrap').hasClass('html-active') ) {
        ioa_wp_obj.find('textarea').val(jQuery('.ioa_wp_editor').val());
    } else {
       ioa_wp_obj.find('textarea').val(tinyMCE.get('ioa_wp_editor').getContent());
    }

    jQuery('.ioa-wp-editor').fadeOut('normal');

});


/**
*
* Map settings from Lightbox to RAD Object
*
**/


function maptoObj(target,source)
{

   var str,s,te = [],inp,val;
   var visual = target.find('.v-feedback');

   computeModuleData( source.find('div.ioa_module_container')  );

   source.find('.ioa_input').each(function(){

     temp1 = jQuery(this);

      if(temp1.hasClass('ioa_mod_input')) return; // We already computed Module related Data

     
      inp = temp1.find('input[type=text],textarea,select,input[type=checkbox]'); // Input Object
      val =  inp.val(); // Input value

      if( inp.is(':checkbox') )
      {

        str = '';
        temp1.find('input[type=checkbox]').each(function(){

            if( jQuery(this).is(':checked') )
              str += jQuery(this).val()+';';
        });
        val = str;
      }
      
        if( jQuery(this).hasClass('hidden-field') )
        {
          
          inp = jQuery(this).find('input[type=hidden]');
          val = inp.val(); 

        }

        if(inp.attr('name') == 'section_name')
               {
                target.find('.section-name').html(val);
               }
             if(inp.attr('name') == 'visibility')
               {
                target.find('.section-visibility').html(val);
               }   

         // Add Values in a  JSON ket / value pair , which is pushed in array        
        te.push( { name :inp.attr('name') , value : val } );
        
        // Human Logic

        if(val=="-1") val = "all";

        visual.find('.vf-'+inp.attr('name')).html(val);


       if(val && val.indexOf('-front-icon') > 0) 
       {
          visual.find('.vf-'+inp.attr('name')).addClass(val).html('');
       }

       if( inp.attr('name') == 'icon_hidden' )
         {
            if( source.find('.col_style').val() != 'image-box'  )
             {
                if( inp.val().indexOf('</i>') != -1 )
                  visual.find('.vf-icon').html(inp.val() );
                else
                  visual.find('.vf-icon').html("<img src='"+ source.find('.icon').val() +"' />");
             }
            else
              visual.find('.vf-icon').html("<img src='"+ source.find('.top_image').val() +"' />");
             
         }

         if( inp.attr('name') == 'image' )
         {
             visual.find('img').attr('src',val);
         }

        
        if(inp.attr('name') =='slideshow')
        {
          visual.find('.vf-slideshow').html(inp.children('option:selected').text());
        }

         if(inp.attr('name') =='t_id')
        {
          visual.find('.vf-t_id').html('Testimonial of '+inp.children('option:selected').text());
        }
    if(inp.attr('name') =='contact_id')
        {
          visual.find('.vf-contact_id').html(inp.children('option:selected').text());
        }
        
        if( inp.attr('name') == 'slider_image_source' )
        {
           switch(val)
           {
              case 'custom_images' : 
                    var gl = '';
                    
                    source.find('.module_list').children().each(function(){

                          gl += '<img src="'+jQuery(this).find('.image_thumb').val()+'" />';

                    });


                     visual.html("<div class='rad-gallery-info clearfix'>"+gl+"</div>");
                     break;
              case 'post_featured' : visual.html("Showing Featured Images from <strong>"+source.find('.no_of_posts').val()+" "+source.find('.post_type').val()+"</strong>");    break;     
              case 'portfolio_meta' : visual.html("Showing Extra Images from <strong>"+source.find('.single_project_source').children('option:selected').text()+"</strong>");  break;       
           }
        }

        if( inp.attr('name') == 'gallery_images' )
      {

         var gl = '';
                    
          source.find('.rad_gallery_thumbs').children().each(function(){

                gl += '<img src="'+jQuery(this).data('thumbnail')+'" />';

          });

                     visual.html("<div class='rad-gallery-info clearfix'>"+gl+"</div>");

      }

 if(inp.attr('name') == 'rad_added_menus')
        {
           var menu = '<ul class="v-one-page-menu">',gls;
           var srcs = val.split(';');
           for(var i=0;i<srcs.length;i++)
           {
            if(srcs[i]!="")
            {
              gls = srcs[i].split(":");
             menu += "<li><a href='#"+gls[0]+"'>"+gls[1]+"</a></li>";
            
            }
           }
           menu += "</ul>";
           visual.html(menu);

        }

   });

     rad_sections[target.attr('id')] =  te;

     if( target.hasClass('rad_page_section') )
     {
            target.find('.helper-icon ').removeClass('blocked_layout full_width');
            switch(source.find('.layout').val())
            {
                    case 'Contained' : break;
                    case 'Full Width' :   target.find('.helper-icon ').addClass('full_width'); break;
                    case 'Cell Blocks' :   target.find('.helper-icon ').addClass('blocked_layout '); break;
            }
     }



}


/**
*
* Map Settings from  a RAD Object to Lighbox
*
**/


function maptoLightbox(target,source)
{

  var settings_lightbox = jQuery('.settings-lightbox'),lightbox_inner = settings_lightbox.find('.inner-settings-body'), temp, te = { } , val,inp,s,obj;


  
  lightbox_inner.children().hide();



  if(lightbox_inner.find('.'+lightbox.data('key')).length > 0 ) // Check if Panel already exists
   {
      target = lightbox_inner.find('.'+lightbox.data('key'));
   }
  else // Add the panel at runtime
  {
     
        target = lightbox_settings_ar[lightbox.data('key')];
        lightbox_inner.append(target);
        lightbox.find( ".ioa_input .ioa_slider" ).each(function(){


                  temp = jQuery(this),obj  =temp.parent().find("input");
                  temp.slider({
                         
                          value: parseInt(obj.val()),
                          min: 0, range: "min",
                          max:  parseInt(obj.data('max')),
                          step : parseInt(obj.data('steps')),
                          slide: function( event, ui ) {
                                  jQuery(this).parent().find("input").val(ui.value);
                          }
                  });

        });



        lightbox.find('.ioa-minicolors').each(function(){

                obool = jQuery(this).data('opacity');

                jQuery(this).minicolors({
                          
                          textfield : true,
                          opacity: false,
                          
                          change: function(hex, opacity) {

                                  jQuery(this).parent().next().val(opacity);    
                                  jQuery(this).trigger('change');

                          },
                          hide: function(hex, opacity) {

                                 jQuery(this).trigger('mini-hidden');

                          }        

                });

        });


        lightbox.find(".input-section-tabs").tabs();

  } 

 

  target.show();
  
  
  if(_.has(rad_sections,source.attr('id')))
   {
     te =  rad_sections[source.attr('id')];

     

      var test = {};

      if( jQuery.isArray( te[0].value) )
    {
         temp = te[0].value;
          for(var i=0;i<temp.length;i++)
          {
              test[temp[i].name] = temp[i].value;
          }

          test['type'] = te[1].value;
    }
      else
      {
              for(var i=0;i<te.length;i++)
              {
                  test[te[i].name] = te[i].value;
              }
      }
    te = test;
   }



 if( lightbox.data('key') == 'rad_page_section') {

    temp =  lightbox.find('.rad_page_section');
   temp.find('.sec-bg-listener').hide();

    switch( te.background_opts)
    {
      case 'bg-color' :temp.find('.bg-color').show(); break;
      case 'bg-image' :temp.find('.bg-image').show(); break;
      case 'bg-gr' :temp.find('.bg-gradient').show(); break;
      case 'bg-video' :temp.find('.bg-video').show(); break;
      case 'bg-texture' :temp.find('.bg-texture').show(); break;
       case 'parallax' :temp.find('.parallax').show(); break;
      case 'custom'  :temp.find('.sec-bg-listener').show();  
                      temp.find('.bg-video,.bg-gradient').hide(); break;
    }
  }

if( lightbox.data('key') == 'rad_page_container') {

   temp =  lightbox.find('.rad_page_container');
   temp.find('.sec-bg-listener').hide();
    switch( te.background_opts)
    {
      case 'bg-color' : temp.find('.bg-color').show(); break;
      case 'bg-image' : temp.find('.bg-image').show(); break;
      case 'bg-gr' : temp.find('.bg-gradient').show(); break;
      case 'bg-video' : temp.find('.bg-video').show(); break;
      case 'bg-texture' : temp.find('.bg-texture').show(); break;
      case 'custom'  : temp.find('.sec-bg-listener').show();  
                       temp.find('.bg-video,.bg-gradient').hide(); break;
    }
 }

  target.find('.custom-id').show().html( "ID - "+source.attr('id') );
 

 
  target.find('.ioa_input').each(function(){
        
        obj = jQuery(this);     
        inp = obj.find('.ioa_input_holder').find('input[type=text],textarea,select,input[type=checkbox],input[type=hidden]');

       if(obj.hasClass('hidden-field')) 
       {
                  inp = obj.find('input[type=hidden]');
        }


       s = inp.attr('name');
      

       if(_.has(te,s))
          s = te[s];
       else if(typeof inp.data('default') != "undefined")
          s = inp.data('default');
       else 
          s = '';  

        

      if( inp.is('select') )
      {
       
          routines.selectOptionByText(inp,s);

      }
      else if(inp.is(':checkbox'))
      {

        if(s)
        s = s.split(';');
        else
          s = [];
        
        inp.removeAttr('checked');
        for(var i=0;i<s.length;i++)
                obj.find('input[value="'+s[i]+'"]').attr('checked','checked');

      }
      else
      {

        if(inp.hasClass('ioa-minicolors') && typeof s != "undefined" )
        {
         
                 inp.minicolors("value",s).trigger('click');
        
        }
        else
         {
         
                   inp.val(s);
         
         }

        if( jQuery(this).hasClass('ioa-image-upload-text') )
        {
                  jQuery(this).find('.input-image-preview img').attr('src',s);
        }  
     

        if(obj.find('.ioa_slider').length > 0 )
        {
          
                  obj.find('.ioa_slider').slider( "value", s );
        
        }  

      }

      temp  = obj.find('.rad_gallery_thumbs');

      if( temp.length > 0 )
      {

         s = te.gallery_images;
         var gl = '',srcs = s.split(';'),gls = [];
        
         for(var i=0;i<srcs.length;i++)
         {
                  if(srcs[i]!="")
                  {
                  
                          gls = srcs[i].split("[ioas]");
                          gl += "<li data-thumbnail='"+gls[1]+"' data-image='"+gls[0]+"' data-alt='"+gls[2]+"' data-title='"+gls[3]+"' data-description='"+gls[4]+"' ><img src='"+gls[1]+"' /> <a class='close' href=''></a></li>";
                  
                  }
         }

        temp.html(gl);
         obj.find('.gallery_images').val(te.gallery_images);

      }


      if( jQuery(this).find('.rad_added_menus').length > 0 )
      {
           s = te.rad_added_menus;         
          var srcs =[],gls,gl='';
          if(s) srcs =  s.split(';');
          for(var i=0;i<srcs.length;i++)
           {
            if(srcs[i]!="")
            {
              gls = srcs[i].split(":");
              gl += '<li class="clearfix" data-id='+gls[0]+'><h6>'+gls[1]+'</h6><i class="ioa-front-icon cancel-2icon- delete"></i></li>';
            }
           }
            parent = jQuery(this).parents('.ui-tabs-panel');
            parent.find('.rad_menu_area').html(gl);

      }


 });
  
  if(target.find('.rad_tab').length > 0)
         target.find('.rad_tab').val(te.rad_tab);

  var tabs,rt,it; 

if(   target.find('.ioa_module_container').length > 0 )
target.find('.ioa_module_container').each(function(){
        
        temp = jQuery(this);
        tabs = temp.find('.rad_tab').val();

        if(typeof tabs != "undefined")
              {
                    tabs = tabs.split('[ioa_mod]')
              }
        else
                tabs = [];

        var list = temp.find(".module_list");
        var tab,clone,mod =  temp.find('div.ioa_module.hide').clone().removeClass('hide'); 
        list.empty();

        for(var k=0;k<tabs.length;k++)
        {
                  if(jQuery.trim(tabs[k])!="")
                  {
                                  clone = mod.clone();
                                  tab = tabs[k];
                                  tab = tab.split("[ioas]");
                                  list.append(clone);

                                  var h =0;
                                  while(h<tab.length)
                                  {

                                            if(tab[h]!="")
                                            {
                                            tr = tab[h+1];
                                            it = tab[h].replace("[inp]","");

                                                      if(it == 'tab_text')
                                                      {
                                                              tr = (jQuery.trim(tr));
                                                      }
                                                      clone.find("."+it).val(tr);
                                                     
                                                      if(it == 'image_thumb' || it == 'logo_icon')
                                                      {
                                                              clone.find(".module_head").append('<img src="'+tr+'" />');
                                                      }

                                            } 
                                  h= h+2;
                  }

                  }
        }

});

  
  setTimeout(function(){
                  

                  temp = lightbox_inner.find('.'+lightbox.data('key'));

                  if(temp.find('.slider_image_source').length > 0)
                  {
                            temp.find('.sl-img-listener').hide();
                            switch( temp.find('.slider_image_source').val() )
                            {
                           
                                      case 'custom_images' : temp.find('.custom_images').show(); break;
                                      case 'post_featured' : temp.find('.post_featured').show(); break;
                                      case 'portfolio_meta' : temp.find('.portfolio_meta').show(); break;

                            }
                  } 

                  if(temp.find('.unit_type').length > 0)
                 {
                     
                     temp.find('.mason-image-filter, .mason-text-filter').hide();
                     
                     jQuery('.unit_type').each(function(){
                      
                            switch( jQuery(this).val() )
                            {
                              case 'image' : jQuery(this).parents('.module_body').find('.mason-image-filter').show(); break;
                              case 'text' : jQuery(this).parents('.module_body').find('.mason-text-filter').show(); break;
                            }

                      }); 
                 } 


                  target.find('.ioa_module_container').find('.ioa-minicolors').minicolors('destroy').minicolors({
                      
                      textfield : true,
                      opacity: false,
                      change: function(hex, opacity) {
                                 
                                   jQuery(this).parent().next().val(opacity);    
                                   jQuery(this).trigger('change');
                                    
                                }

                    });


                  target.find('.col_style').each(function(){
                  
                          temp = jQuery(this).parents('.ui-tabs-panel');
                          
                          if(jQuery(this).val() == 'image-box') 
                                   temp.find('.image-box').show();
                          else 
                                   temp.find('.image-box').hide();

                          if(jQuery(this).val() == 'iconed-alt') 
                                   temp.find('.iconed-alt').show();
                          else 
                                  temp.find('.iconed-alt').hide();

                  });

                  jQuery('.col_link').each(function(){
                  
                          temp = jQuery(this).parents('.ioa_input').parent();
                       
                          temp.find('.ioa-link-filter').hide();
                          temp.find('.ioa-link-filter.'+jQuery(this).val()).show();

                  });


      },100);

}



/**
*
* Layout Prediction for Columns
*
**/


function prediction()
{

  var predict = 0,len = frame.children().length , ctemp,depth =0;
  frame.children().each(function(i){
      
       predict = 0;
       jQuery(this).removeClass('first-section last-section');

       if(i==0) jQuery(this).addClass('first-section');
       if(i==len-1) jQuery(this).addClass('last-section');
       depth =0;

         jQuery(this).find('.rad_page_container').each(function(){


            ctemp = jQuery(this).removeClass('first last top');

            if(predict == 0) ctemp.addClass('first');
            if(depth == 0) ctemp.addClass('top');

            if(ctemp.hasClass('full')) predict += 100;
            if(ctemp.hasClass('three_fourth')) predict += 75;
            if(ctemp.hasClass('four_fifth')) predict += 80;
            if(ctemp.hasClass('two_third')) predict += 66;
            if(ctemp.hasClass('one_half')) predict += 50;
            if(ctemp.hasClass('one_third')) predict += 34;
            if(ctemp.hasClass('one_fourth')) predict += 25;
            if(ctemp.hasClass('one_fifth')) predict += 20;


            if(predict >= 99)
            {
              ctemp.addClass('last');
              predict = 0;
              depth++;
            }  

            widget_prediction(ctemp.find('.container-content'));

      });

  });
}

function updateRADOnePageMenus()
{
   var rad_section_markup = '',name;
    frame.children().each(function(i){
        name = "Section "+(i+1);
        
        _.each(rad_sections[jQuery(this).attr('id')],function(k,v){
            if(k.name == 'section_name')
               {
                name = k.value;

               }
        });
          
        rad_section_markup += '<option value="'+jQuery(this).attr('id')+'">'+name+'</option>';
    
    });  
    lightbox.find('.rad_menu_sections').html(rad_section_markup);
}

/**
*
* Widget Layout Prediction
*
**/


function widget_prediction(parent)
{
    parent.children('.rad_page_widget').removeClass('last top');
    parent.children('.rad_page_widget').first().addClass('top');
    parent.children('.rad_page_widget').last().addClass('last');
          
}

prediction(); // Trigger once after all code has been executed


function htmlEntities(str) {
return String(str).replace(/\\'/g, '&amp;squot;').replace(/"/g, '&amp;quot;').replace(/'/g,"&amp;squot;").replace(/\[/g,"&amp;sqstart;").replace(/\]/g,"&amp;sqend;");
}



}); // END OF SCOPE


/* Modernizr 2.7.1 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-localstorage-sessionstorage-webworkers
 */
;window.Modernizr=function(a,b,c){function t(a){i.cssText=a}function u(a,b){return t(prefixes.join(a+";")+(b||""))}function v(a,b){return typeof a===b}function w(a,b){return!!~(""+a).indexOf(b)}function x(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:v(f,"function")?f.bind(d||b):f}return!1}var d="2.7.1",e={},f=b.documentElement,g="modernizr",h=b.createElement(g),i=h.style,j,k={}.toString,l={},m={},n={},o=[],p=o.slice,q,r={}.hasOwnProperty,s;!v(r,"undefined")&&!v(r.call,"undefined")?s=function(a,b){return r.call(a,b)}:s=function(a,b){return b in a&&v(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=p.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(p.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(p.call(arguments)))};return e}),l.localstorage=function(){try{return localStorage.setItem(g,g),localStorage.removeItem(g),!0}catch(a){return!1}},l.sessionstorage=function(){try{return sessionStorage.setItem(g,g),sessionStorage.removeItem(g),!0}catch(a){return!1}},l.webworkers=function(){return!!a.Worker};for(var y in l)s(l,y)&&(q=y.toLowerCase(),e[q]=l[y](),o.push((e[q]?"":"no-")+q));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)s(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof enableClasses!="undefined"&&enableClasses&&(f.className+=" "+(b?"":"no-")+a),e[a]=b}return e},t(""),h=j=null,e._version=d,e}(this,this.document);

/*! Copyright (c) 2013 Brandon Aaron (http://brandon.aaron.sh)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version: 3.1.9
 *
 * Requires: jQuery 1.2.2+
 */

(function (factory) {
    if ( typeof define === 'function' && define.amd ) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS style for Browserify
        module.exports = factory;
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var toFix  = ['wheel', 'mousewheel', 'DOMMouseScroll', 'MozMousePixelScroll'],
        toBind = ( 'onwheel' in document || document.documentMode >= 9 ) ?
                    ['wheel'] : ['mousewheel', 'DomMouseScroll', 'MozMousePixelScroll'],
        slice  = Array.prototype.slice,
        nullLowestDeltaTimeout, lowestDelta;

    if ( $.event.fixHooks ) {
        for ( var i = toFix.length; i; ) {
            $.event.fixHooks[ toFix[--i] ] = $.event.mouseHooks;
        }
    }

    var special = $.event.special.mousewheel = {
        version: '3.1.9',

        setup: function() {
            if ( this.addEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.addEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = handler;
            }
            // Store the line height and page height for this particular element
            $.data(this, 'mousewheel-line-height', special.getLineHeight(this));
            $.data(this, 'mousewheel-page-height', special.getPageHeight(this));
        },

        teardown: function() {
            if ( this.removeEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.removeEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = null;
            }
        },

        getLineHeight: function(elem) {
            return parseInt($(elem)['offsetParent' in $.fn ? 'offsetParent' : 'parent']().css('fontSize'), 10);
        },

        getPageHeight: function(elem) {
            return $(elem).height();
        },

        settings: {
            adjustOldDeltas: true
        }
    };

    $.fn.extend({
        mousewheel: function(fn) {
            return fn ? this.bind('mousewheel', fn) : this.trigger('mousewheel');
        },

        unmousewheel: function(fn) {
            return this.unbind('mousewheel', fn);
        }
    });


    function handler(event) {
        var orgEvent   = event || window.event,
            args       = slice.call(arguments, 1),
            delta      = 0,
            deltaX     = 0,
            deltaY     = 0,
            absDelta   = 0;
        event = $.event.fix(orgEvent);
        event.type = 'mousewheel';

        // Old school scrollwheel delta
        if ( 'detail'      in orgEvent ) { deltaY = orgEvent.detail * -1;      }
        if ( 'wheelDelta'  in orgEvent ) { deltaY = orgEvent.wheelDelta;       }
        if ( 'wheelDeltaY' in orgEvent ) { deltaY = orgEvent.wheelDeltaY;      }
        if ( 'wheelDeltaX' in orgEvent ) { deltaX = orgEvent.wheelDeltaX * -1; }

        // Firefox < 17 horizontal scrolling related to DOMMouseScroll event
        if ( 'axis' in orgEvent && orgEvent.axis === orgEvent.HORIZONTAL_AXIS ) {
            deltaX = deltaY * -1;
            deltaY = 0;
        }

        // Set delta to be deltaY or deltaX if deltaY is 0 for backwards compatabilitiy
        delta = deltaY === 0 ? deltaX : deltaY;

        // New school wheel delta (wheel event)
        if ( 'deltaY' in orgEvent ) {
            deltaY = orgEvent.deltaY * -1;
            delta  = deltaY;
        }
        if ( 'deltaX' in orgEvent ) {
            deltaX = orgEvent.deltaX;
            if ( deltaY === 0 ) { delta  = deltaX * -1; }
        }

        // No change actually happened, no reason to go any further
        if ( deltaY === 0 && deltaX === 0 ) { return; }

        // Need to convert lines and pages to pixels if we aren't already in pixels
        // There are three delta modes:
        //   * deltaMode 0 is by pixels, nothing to do
        //   * deltaMode 1 is by lines
        //   * deltaMode 2 is by pages
        if ( orgEvent.deltaMode === 1 ) {
            var lineHeight = $.data(this, 'mousewheel-line-height');
            delta  *= lineHeight;
            deltaY *= lineHeight;
            deltaX *= lineHeight;
        } else if ( orgEvent.deltaMode === 2 ) {
            var pageHeight = $.data(this, 'mousewheel-page-height');
            delta  *= pageHeight;
            deltaY *= pageHeight;
            deltaX *= pageHeight;
        }

        // Store lowest absolute delta to normalize the delta values
        absDelta = Math.max( Math.abs(deltaY), Math.abs(deltaX) );

        if ( !lowestDelta || absDelta < lowestDelta ) {
            lowestDelta = absDelta;

            // Adjust older deltas if necessary
            if ( shouldAdjustOldDeltas(orgEvent, absDelta) ) {
                lowestDelta /= 40;
            }
        }

        // Adjust older deltas if necessary
        if ( shouldAdjustOldDeltas(orgEvent, absDelta) ) {
            // Divide all the things by 40!
            delta  /= 40;
            deltaX /= 40;
            deltaY /= 40;
        }

        // Get a whole, normalized value for the deltas
        delta  = Math[ delta  >= 1 ? 'floor' : 'ceil' ](delta  / lowestDelta);
        deltaX = Math[ deltaX >= 1 ? 'floor' : 'ceil' ](deltaX / lowestDelta);
        deltaY = Math[ deltaY >= 1 ? 'floor' : 'ceil' ](deltaY / lowestDelta);

        // Add information to the event object
        event.deltaX = deltaX;
        event.deltaY = deltaY;
        event.deltaFactor = lowestDelta;
        // Go ahead and set deltaMode to 0 since we converted to pixels
        // Although this is a little odd since we overwrite the deltaX/Y
        // properties with normalized deltas.
        event.deltaMode = 0;

        // Add event and delta to the front of the arguments
        args.unshift(event, delta, deltaX, deltaY);

        // Clearout lowestDelta after sometime to better
        // handle multiple device types that give different
        // a different lowestDelta
        // Ex: trackpad = 3 and mouse wheel = 120
        if (nullLowestDeltaTimeout) { clearTimeout(nullLowestDeltaTimeout); }
        nullLowestDeltaTimeout = setTimeout(nullLowestDelta, 200);

        return ($.event.dispatch || $.event.handle).apply(this, args);
    }

    function nullLowestDelta() {
        lowestDelta = null;
    }

    function shouldAdjustOldDeltas(orgEvent, absDelta) {
        return special.settings.adjustOldDeltas && orgEvent.type === 'mousewheel' && absDelta % 120 === 0;
    }

}));


/*!
 * jScrollPane - v2.0.19 - 2013-11-16
 * http://jscrollpane.kelvinluck.com/
 *
 * Copyright (c) 2013 Kelvin Luck
 * Dual licensed under the MIT or GPL licenses.
 */
!function(a,b,c){a.fn.jScrollPane=function(d){function e(d,e){function f(b){var e,h,j,l,m,n,q=!1,r=!1;if(P=b,Q===c)m=d.scrollTop(),n=d.scrollLeft(),d.css({overflow:"hidden",padding:0}),R=d.innerWidth()+tb,S=d.innerHeight(),d.width(R),Q=a('<div class="jspPane" />').css("padding",sb).append(d.children()),T=a('<div class="jspContainer" />').css({width:R+"px",height:S+"px"}).append(Q).appendTo(d);else{if(d.css("width",""),q=P.stickToBottom&&C(),r=P.stickToRight&&D(),l=d.innerWidth()+tb!=R||d.outerHeight()!=S,l&&(R=d.innerWidth()+tb,S=d.innerHeight(),T.css({width:R+"px",height:S+"px"})),!l&&ub==U&&Q.outerHeight()==V)return d.width(R),void 0;ub=U,Q.css("width",""),d.width(R),T.find(">.jspVerticalBar,>.jspHorizontalBar").remove().end()}Q.css("overflow","auto"),U=b.contentWidth?b.contentWidth:Q[0].scrollWidth,V=Q[0].scrollHeight,Q.css("overflow",""),W=U/R,X=V/S,Y=X>1,Z=W>1,Z||Y?(d.addClass("jspScrollable"),e=P.maintainPosition&&(ab||db),e&&(h=A(),j=B()),g(),i(),k(),e&&(y(r?U-R:h,!1),x(q?V-S:j,!1)),H(),E(),N(),P.enableKeyboardNavigation&&J(),P.clickOnTrack&&o(),L(),P.hijackInternalLinks&&M()):(d.removeClass("jspScrollable"),Q.css({top:0,left:0,width:T.width()-tb}),F(),I(),K(),p()),P.autoReinitialise&&!rb?rb=setInterval(function(){f(P)},P.autoReinitialiseDelay):!P.autoReinitialise&&rb&&clearInterval(rb),m&&d.scrollTop(0)&&x(m,!1),n&&d.scrollLeft(0)&&y(n,!1),d.trigger("jsp-initialised",[Z||Y])}function g(){Y&&(T.append(a('<div class="jspVerticalBar" />').append(a('<div class="jspCap jspCapTop" />'),a('<div class="jspTrack" />').append(a('<div class="jspDrag" />').append(a('<div class="jspDragTop" />'),a('<div class="jspDragBottom" />'))),a('<div class="jspCap jspCapBottom" />'))),eb=T.find(">.jspVerticalBar"),fb=eb.find(">.jspTrack"),$=fb.find(">.jspDrag"),P.showArrows&&(jb=a('<a class="jspArrow jspArrowUp" />').bind("mousedown.jsp",m(0,-1)).bind("click.jsp",G),kb=a('<a class="jspArrow jspArrowDown" />').bind("mousedown.jsp",m(0,1)).bind("click.jsp",G),P.arrowScrollOnHover&&(jb.bind("mouseover.jsp",m(0,-1,jb)),kb.bind("mouseover.jsp",m(0,1,kb))),l(fb,P.verticalArrowPositions,jb,kb)),hb=S,T.find(">.jspVerticalBar>.jspCap:visible,>.jspVerticalBar>.jspArrow").each(function(){hb-=a(this).outerHeight()}),$.hover(function(){$.addClass("jspHover")},function(){$.removeClass("jspHover")}).bind("mousedown.jsp",function(b){a("html").bind("dragstart.jsp selectstart.jsp",G),$.addClass("jspActive");var c=b.pageY-$.position().top;return a("html").bind("mousemove.jsp",function(a){r(a.pageY-c,!1)}).bind("mouseup.jsp mouseleave.jsp",q),!1}),h())}function h(){fb.height(hb+"px"),ab=0,gb=P.verticalGutter+fb.outerWidth(),Q.width(R-gb-tb);try{0===eb.position().left&&Q.css("margin-left",gb+"px")}catch(a){}}function i(){Z&&(T.append(a('<div class="jspHorizontalBar" />').append(a('<div class="jspCap jspCapLeft" />'),a('<div class="jspTrack" />').append(a('<div class="jspDrag" />').append(a('<div class="jspDragLeft" />'),a('<div class="jspDragRight" />'))),a('<div class="jspCap jspCapRight" />'))),lb=T.find(">.jspHorizontalBar"),mb=lb.find(">.jspTrack"),bb=mb.find(">.jspDrag"),P.showArrows&&(pb=a('<a class="jspArrow jspArrowLeft" />').bind("mousedown.jsp",m(-1,0)).bind("click.jsp",G),qb=a('<a class="jspArrow jspArrowRight" />').bind("mousedown.jsp",m(1,0)).bind("click.jsp",G),P.arrowScrollOnHover&&(pb.bind("mouseover.jsp",m(-1,0,pb)),qb.bind("mouseover.jsp",m(1,0,qb))),l(mb,P.horizontalArrowPositions,pb,qb)),bb.hover(function(){bb.addClass("jspHover")},function(){bb.removeClass("jspHover")}).bind("mousedown.jsp",function(b){a("html").bind("dragstart.jsp selectstart.jsp",G),bb.addClass("jspActive");var c=b.pageX-bb.position().left;return a("html").bind("mousemove.jsp",function(a){t(a.pageX-c,!1)}).bind("mouseup.jsp mouseleave.jsp",q),!1}),nb=T.innerWidth(),j())}function j(){T.find(">.jspHorizontalBar>.jspCap:visible,>.jspHorizontalBar>.jspArrow").each(function(){nb-=a(this).outerWidth()}),mb.width(nb+"px"),db=0}function k(){if(Z&&Y){var b=mb.outerHeight(),c=fb.outerWidth();hb-=b,a(lb).find(">.jspCap:visible,>.jspArrow").each(function(){nb+=a(this).outerWidth()}),nb-=c,S-=c,R-=b,mb.parent().append(a('<div class="jspCorner" />').css("width",b+"px")),h(),j()}Z&&Q.width(T.outerWidth()-tb+"px"),V=Q.outerHeight(),X=V/S,Z&&(ob=Math.ceil(1/W*nb),ob>P.horizontalDragMaxWidth?ob=P.horizontalDragMaxWidth:ob<P.horizontalDragMinWidth&&(ob=P.horizontalDragMinWidth),bb.width(ob+"px"),cb=nb-ob,u(db)),Y&&(ib=Math.ceil(1/X*hb),ib>P.verticalDragMaxHeight?ib=P.verticalDragMaxHeight:ib<P.verticalDragMinHeight&&(ib=P.verticalDragMinHeight),$.height(ib+"px"),_=hb-ib,s(ab))}function l(a,b,c,d){var e,f="before",g="after";"os"==b&&(b=/Mac/.test(navigator.platform)?"after":"split"),b==f?g=b:b==g&&(f=b,e=c,c=d,d=e),a[f](c)[g](d)}function m(a,b,c){return function(){return n(a,b,this,c),this.blur(),!1}}function n(b,c,d,e){d=a(d).addClass("jspActive");var f,g,h=!0,i=function(){0!==b&&vb.scrollByX(b*P.arrowButtonSpeed),0!==c&&vb.scrollByY(c*P.arrowButtonSpeed),g=setTimeout(i,h?P.initialDelay:P.arrowRepeatFreq),h=!1};i(),f=e?"mouseout.jsp":"mouseup.jsp",e=e||a("html"),e.bind(f,function(){d.removeClass("jspActive"),g&&clearTimeout(g),g=null,e.unbind(f)})}function o(){p(),Y&&fb.bind("mousedown.jsp",function(b){if(b.originalTarget===c||b.originalTarget==b.currentTarget){var d,e=a(this),f=e.offset(),g=b.pageY-f.top-ab,h=!0,i=function(){var a=e.offset(),c=b.pageY-a.top-ib/2,f=S*P.scrollPagePercent,k=_*f/(V-S);if(0>g)ab-k>c?vb.scrollByY(-f):r(c);else{if(!(g>0))return j(),void 0;c>ab+k?vb.scrollByY(f):r(c)}d=setTimeout(i,h?P.initialDelay:P.trackClickRepeatFreq),h=!1},j=function(){d&&clearTimeout(d),d=null,a(document).unbind("mouseup.jsp",j)};return i(),a(document).bind("mouseup.jsp",j),!1}}),Z&&mb.bind("mousedown.jsp",function(b){if(b.originalTarget===c||b.originalTarget==b.currentTarget){var d,e=a(this),f=e.offset(),g=b.pageX-f.left-db,h=!0,i=function(){var a=e.offset(),c=b.pageX-a.left-ob/2,f=R*P.scrollPagePercent,k=cb*f/(U-R);if(0>g)db-k>c?vb.scrollByX(-f):t(c);else{if(!(g>0))return j(),void 0;c>db+k?vb.scrollByX(f):t(c)}d=setTimeout(i,h?P.initialDelay:P.trackClickRepeatFreq),h=!1},j=function(){d&&clearTimeout(d),d=null,a(document).unbind("mouseup.jsp",j)};return i(),a(document).bind("mouseup.jsp",j),!1}})}function p(){mb&&mb.unbind("mousedown.jsp"),fb&&fb.unbind("mousedown.jsp")}function q(){a("html").unbind("dragstart.jsp selectstart.jsp mousemove.jsp mouseup.jsp mouseleave.jsp"),$&&$.removeClass("jspActive"),bb&&bb.removeClass("jspActive")}function r(a,b){Y&&(0>a?a=0:a>_&&(a=_),b===c&&(b=P.animateScroll),b?vb.animate($,"top",a,s):($.css("top",a),s(a)))}function s(a){a===c&&(a=$.position().top),T.scrollTop(0),ab=a;var b=0===ab,e=ab==_,f=a/_,g=-f*(V-S);(wb!=b||yb!=e)&&(wb=b,yb=e,d.trigger("jsp-arrow-change",[wb,yb,xb,zb])),v(b,e),Q.css("top",g),d.trigger("jsp-scroll-y",[-g,b,e]).trigger("scroll")}function t(a,b){Z&&(0>a?a=0:a>cb&&(a=cb),b===c&&(b=P.animateScroll),b?vb.animate(bb,"left",a,u):(bb.css("left",a),u(a)))}function u(a){a===c&&(a=bb.position().left),T.scrollTop(0),db=a;var b=0===db,e=db==cb,f=a/cb,g=-f*(U-R);(xb!=b||zb!=e)&&(xb=b,zb=e,d.trigger("jsp-arrow-change",[wb,yb,xb,zb])),w(b,e),Q.css("left",g),d.trigger("jsp-scroll-x",[-g,b,e]).trigger("scroll")}function v(a,b){P.showArrows&&(jb[a?"addClass":"removeClass"]("jspDisabled"),kb[b?"addClass":"removeClass"]("jspDisabled"))}function w(a,b){P.showArrows&&(pb[a?"addClass":"removeClass"]("jspDisabled"),qb[b?"addClass":"removeClass"]("jspDisabled"))}function x(a,b){var c=a/(V-S);r(c*_,b)}function y(a,b){var c=a/(U-R);t(c*cb,b)}function z(b,c,d){var e,f,g,h,i,j,k,l,m,n=0,o=0;try{e=a(b)}catch(p){return}for(f=e.outerHeight(),g=e.outerWidth(),T.scrollTop(0),T.scrollLeft(0);!e.is(".jspPane");)if(n+=e.position().top,o+=e.position().left,e=e.offsetParent(),/^body|html$/i.test(e[0].nodeName))return;h=B(),j=h+S,h>n||c?l=n-P.horizontalGutter:n+f>j&&(l=n-S+f+P.horizontalGutter),isNaN(l)||x(l,d),i=A(),k=i+R,i>o||c?m=o-P.horizontalGutter:o+g>k&&(m=o-R+g+P.horizontalGutter),isNaN(m)||y(m,d)}function A(){return-Q.position().left}function B(){return-Q.position().top}function C(){var a=V-S;return a>20&&a-B()<10}function D(){var a=U-R;return a>20&&a-A()<10}function E(){T.unbind(Bb).bind(Bb,function(a,b,c,d){var e=db,f=ab,g=a.deltaFactor||P.mouseWheelSpeed;return vb.scrollBy(c*g,-d*g,!1),e==db&&f==ab})}function F(){T.unbind(Bb)}function G(){return!1}function H(){Q.find(":input,a").unbind("focus.jsp").bind("focus.jsp",function(a){z(a.target,!1)})}function I(){Q.find(":input,a").unbind("focus.jsp")}function J(){function b(){var a=db,b=ab;switch(c){case 40:vb.scrollByY(P.keyboardSpeed,!1);break;case 38:vb.scrollByY(-P.keyboardSpeed,!1);break;case 34:case 32:vb.scrollByY(S*P.scrollPagePercent,!1);break;case 33:vb.scrollByY(-S*P.scrollPagePercent,!1);break;case 39:vb.scrollByX(P.keyboardSpeed,!1);break;case 37:vb.scrollByX(-P.keyboardSpeed,!1)}return e=a!=db||b!=ab}var c,e,f=[];Z&&f.push(lb[0]),Y&&f.push(eb[0]),Q.focus(function(){d.focus()}),d.attr("tabindex",0).unbind("keydown.jsp keypress.jsp").bind("keydown.jsp",function(d){if(d.target===this||f.length&&a(d.target).closest(f).length){var g=db,h=ab;switch(d.keyCode){case 40:case 38:case 34:case 32:case 33:case 39:case 37:c=d.keyCode,b();break;case 35:x(V-S),c=null;break;case 36:x(0),c=null}return e=d.keyCode==c&&g!=db||h!=ab,!e}}).bind("keypress.jsp",function(a){return a.keyCode==c&&b(),!e}),P.hideFocus?(d.css("outline","none"),"hideFocus"in T[0]&&d.attr("hideFocus",!0)):(d.css("outline",""),"hideFocus"in T[0]&&d.attr("hideFocus",!1))}function K(){d.attr("tabindex","-1").removeAttr("tabindex").unbind("keydown.jsp keypress.jsp")}function L(){if(location.hash&&location.hash.length>1){var b,c,d=escape(location.hash.substr(1));try{b=a("#"+d+', a[name="'+d+'"]')}catch(e){return}b.length&&Q.find(d)&&(0===T.scrollTop()?c=setInterval(function(){T.scrollTop()>0&&(z(b,!0),a(document).scrollTop(T.position().top),clearInterval(c))},50):(z(b,!0),a(document).scrollTop(T.position().top)))}}function M(){a(document.body).data("jspHijack")||(a(document.body).data("jspHijack",!0),a(document.body).delegate("a[href*=#]","click",function(c){var d,e,f,g,h,i,j=this.href.substr(0,this.href.indexOf("#")),k=location.href;if(-1!==location.href.indexOf("#")&&(k=location.href.substr(0,location.href.indexOf("#"))),j===k){d=escape(this.href.substr(this.href.indexOf("#")+1));try{e=a("#"+d+', a[name="'+d+'"]')}catch(l){return}e.length&&(f=e.closest(".jspScrollable"),g=f.data("jsp"),g.scrollToElement(e,!0),f[0].scrollIntoView&&(h=a(b).scrollTop(),i=e.offset().top,(h>i||i>h+a(b).height())&&f[0].scrollIntoView()),c.preventDefault())}}))}function N(){var a,b,c,d,e,f=!1;T.unbind("touchstart.jsp touchmove.jsp touchend.jsp click.jsp-touchclick").bind("touchstart.jsp",function(g){var h=g.originalEvent.touches[0];a=A(),b=B(),c=h.pageX,d=h.pageY,e=!1,f=!0}).bind("touchmove.jsp",function(g){if(f){var h=g.originalEvent.touches[0],i=db,j=ab;return vb.scrollTo(a+c-h.pageX,b+d-h.pageY),e=e||Math.abs(c-h.pageX)>5||Math.abs(d-h.pageY)>5,i==db&&j==ab}}).bind("touchend.jsp",function(){f=!1}).bind("click.jsp-touchclick",function(){return e?(e=!1,!1):void 0})}function O(){var a=B(),b=A();d.removeClass("jspScrollable").unbind(".jsp"),d.replaceWith(Ab.append(Q.children())),Ab.scrollTop(a),Ab.scrollLeft(b),rb&&clearInterval(rb)}var P,Q,R,S,T,U,V,W,X,Y,Z,$,_,ab,bb,cb,db,eb,fb,gb,hb,ib,jb,kb,lb,mb,nb,ob,pb,qb,rb,sb,tb,ub,vb=this,wb=!0,xb=!0,yb=!1,zb=!1,Ab=d.clone(!1,!1).empty(),Bb=a.fn.mwheelIntent?"mwheelIntent.jsp":"mousewheel.jsp";"border-box"===d.css("box-sizing")?(sb=0,tb=0):(sb=d.css("paddingTop")+" "+d.css("paddingRight")+" "+d.css("paddingBottom")+" "+d.css("paddingLeft"),tb=(parseInt(d.css("paddingLeft"),10)||0)+(parseInt(d.css("paddingRight"),10)||0)),a.extend(vb,{reinitialise:function(b){b=a.extend({},P,b),f(b)},scrollToElement:function(a,b,c){z(a,b,c)},scrollTo:function(a,b,c){y(a,c),x(b,c)},scrollToX:function(a,b){y(a,b)},scrollToY:function(a,b){x(a,b)},scrollToPercentX:function(a,b){y(a*(U-R),b)},scrollToPercentY:function(a,b){x(a*(V-S),b)},scrollBy:function(a,b,c){vb.scrollByX(a,c),vb.scrollByY(b,c)},scrollByX:function(a,b){var c=A()+Math[0>a?"floor":"ceil"](a),d=c/(U-R);t(d*cb,b)},scrollByY:function(a,b){var c=B()+Math[0>a?"floor":"ceil"](a),d=c/(V-S);r(d*_,b)},positionDragX:function(a,b){t(a,b)},positionDragY:function(a,b){r(a,b)},animate:function(a,b,c,d){var e={};e[b]=c,a.animate(e,{duration:P.animateDuration,easing:P.animateEase,queue:!1,step:d})},getContentPositionX:function(){return A()},getContentPositionY:function(){return B()},getContentWidth:function(){return U},getContentHeight:function(){return V},getPercentScrolledX:function(){return A()/(U-R)},getPercentScrolledY:function(){return B()/(V-S)},getIsScrollableH:function(){return Z},getIsScrollableV:function(){return Y},getContentPane:function(){return Q},scrollToBottom:function(a){r(_,a)},hijackInternalLinks:a.noop,destroy:function(){O()}}),f(e)}return d=a.extend({},a.fn.jScrollPane.defaults,d),a.each(["arrowButtonSpeed","trackClickSpeed","keyboardSpeed"],function(){d[this]=d[this]||d.speed}),this.each(function(){var b=a(this),c=b.data("jsp");c?c.reinitialise(d):(a("script",b).filter('[type="text/javascript"],:not([type])').remove(),c=new e(b,d),b.data("jsp",c))})},a.fn.jScrollPane.defaults={showArrows:!1,maintainPosition:!0,stickToBottom:!1,stickToRight:!1,clickOnTrack:!0,autoReinitialise:!1,autoReinitialiseDelay:500,verticalDragMinHeight:0,verticalDragMaxHeight:99999,horizontalDragMinWidth:0,horizontalDragMaxWidth:99999,contentWidth:c,animateScroll:!1,animateDuration:300,animateEase:"linear",hijackInternalLinks:!1,verticalGutter:4,horizontalGutter:4,mouseWheelSpeed:3,arrowButtonSpeed:0,arrowRepeatFreq:50,arrowScrollOnHover:!1,trackClickSpeed:0,trackClickRepeatFreq:70,verticalArrowPositions:"split",horizontalArrowPositions:"split",enableKeyboardNavigation:!0,hideFocus:!1,keyboardSpeed:0,initialDelay:300,speed:30,scrollPagePercent:.8}}(jQuery,this);