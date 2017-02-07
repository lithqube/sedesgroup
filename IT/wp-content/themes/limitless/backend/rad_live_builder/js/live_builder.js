jQuery(function(){

var mediaFrame = null , hmedia = {

		init : function(title){
			

	  			mediaFrame = wp.media({
						
						title:  title,
				 		multiple : true,
						library:   {
						type: 'image'
						}
						
						});

	  		

		},

	    open : function(title,button_label,callback) {
	    	hmedia.init(title);
	    	mediaFrame.on( 'toolbar:render:select', function( view ) {
				view.set({
					select: {
						style: 'primary',
						text:  button_label,

						click: function() {
							
							var attachment = mediaFrame.state().get('selection'),
							models = attachment.models , images = [];
							
							jQuery(models).each(function(i){ 
							
				
				 			images[i] = this.attributes;
							
					  
							
							});
							
							mediaFrame.close();
							callback(images);
						}
					}
				});
			});
			mediaFrame.setState('library').open();

	    }	
	};
var videoFrame = null , vmedia = {

		init : function(title){
			

	  			videoFrame = wp.media({
						
						title:  title,
				 		multiple : true,
						library:   {
						type: 'video'
						}
						
						});

	  		

		},

	    open : function(title,button_label,callback) {
	    	vmedia.init(title);
	    	videoFrame.on( 'toolbar:render:select', function( view ) {
				view.set({
					select: {
						style: 'primary',
						text:  button_label,

						click: function() {
							
							var attachment = videoFrame.state().get('selection'),
							models = attachment.models , videos = [];
							
							jQuery(models).each(function(i){ 
							
				
				 			videos[i] = this.attributes;
							
					  
							
							});
							
							videoFrame.close();
							callback(videos);
						}
					}
				});
			});
			videoFrame.setState('library').open();

	    }	
	};


// Variables Declaration and Caching
var win = {
	obj : jQuery(window),
	width : null,
	height : null,
  ori_width : null,
  ori_height : null
};
	
win.ori_width = win.width = win.obj.width();
win.ori_height =win.height = win.obj.height();

win.obj.resize(function(event) {
 
    win.width = win.obj.width();
    win.height = win.obj.height();
});

var doc = jQuery(document) , body = jQuery('body'),
    temp,temp1,obj,ioa_wp_obj,s_id,c_id,w_id,
    current_editing_obj = null,
    current_editing_container = null , widgets = jQuery('.rad-thumb'), frame = jQuery('.rad-holder'),xc,xw,xr,EDITOR_FLAG = false , SIDEBAR_WIDTH = 300, RAD_CHANGE_FLAG = true ;

// == Message API ===================

var ioa_msg = {
  msg_block : jQuery(".ioa-message"),
  icon : jQuery(".ioa-message i"),
  
  setMessage : function(title){
    ioa_msg.msg_block.css('display','none');
    ioa_msg.msg_block.find('div.ioa-message-body h3').html(title);
    ioa_msg.msg_block.find('div.ioa-message-body p').html('');
  },
  setMessage : function(title,message){
    ioa_msg.msg_block.css('display','none');
    ioa_msg.msg_block.find('div.ioa-message-body h3').html(title);
    ioa_msg.msg_block.find('div.ioa-message-body p').html(message);
  },
  setMessage : function(title,message,type){
    
    ioa_msg.msg_block.removeClass('ioa-error ioa-warning ioa-information ioa-success').addClass("ioa-"+type);
    switch(type)
    {
      case 'success' : ioa_msg.icon.removeClass().addClass('ioa-front-icon checkicon-'); break;
      case 'information' : ioa_msg.icon.removeClass().addClass('ioa-front-icon  infoicon-'); break;
      case 'error' : ioa_msg.icon.removeClass().addClass('ioa-front-icon  cancel-circled-2icon-'); break;
      case 'warning' : ioa_msg.icon.removeClass().addClass('ioa-front-icon  attention-3icon-'); break;
      case 'custom' : ioa_msg.icon.removeClass().addClass('ioa-front-icon '+type); break;
      default : ioa_msg.icon.removeClass().addClass('ioa-front-icon checkicon-'); 
    }
    ioa_msg.msg_block.css('display','none');
    ioa_msg.msg_block.find('div.ioa-message-body h3').html(title);
    ioa_msg.msg_block.find('div.ioa-message-body p').html(message);

  },
  setIconMessage : function(title,message,icon){
    ioa_msg.msg_block.removeClass('error warning information success').addClass("ioa-"+type);
    ioa_msg.icon.removeClass().addClass('ioa-front-icon '+icon);
    ioa_msg.msg_block.css('display','none');
    ioa_msg.msg_block.find('div.ioa-message-body h3').html(title);
    ioa_msg.msg_block.find('div.ioa-message-body p').html(message);
  },
  show : function(){
    ioa_msg.msg_block.css({ display : 'block' , y : -150 });
    ioa_msg.msg_block.transition({ y : 0 },500,'easeOutBack');
        setTimeout(function(){ ioa_msg.msg_block.transition({ y : -150 },500,'easeInBack'); },3000);

  }

};

// Common Functions

doc.on('click','.image_upload',function(e){
		e.preventDefault();
		var img =	jQuery(this);
		
		hmedia.open(img.data('title'),img.data('label'),function(images){ 
		

			img.next().val(images[0].url); 
			
			img.next().trigger('change');
			img.next().trigger('keyup');
			img.parents('.image_upload_wrap').find('img').attr('src',images[0].url);

		});

		
	});

doc.on('click','.video_upload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		vmedia.open(temp.data('title'),temp.data('label'),function(video){ 
		
			temp.next().val(video[0].url); 
			temp.next().trigger('change');

		});

		
	});


/**
 * LightBox code
 */

var rad_lightbox = jQuery('div.rad-lightbox');

if(rad_lightbox.length > 0) {

	rad_lightbox.draggable({ handle : '.rad-l-head' });
	
	rad_lightbox.children('.rad-l-body').height( win.height - 260 );
	win.obj.resize(function(){
		rad_lightbox.children('.rad-l-body').height( win.height - 260 );
	});

	var rl = {
		show : function(msg) {
			
			rad_lightbox.css('opacity',1).fadeIn('slow');
			rad_lightbox.find('div.rad-l-head h4').html(msg);
		},
		hide: function() {
			rad_lightbox.fadeOut('fast');
		},
		set : function(html,key)
		{
			rad_lightbox.data("mode",'');
			rad_lightbox.find('div.rad-l-body div.component-opts').html(html);
			rad_lightbox.find('div.rad-l-body').data('key',key);

			if(key == "hcon")
			{
				var id = '';
				rad_lightbox.find('input[type=checkbox]').each(function(){
					id = jQuery(this).attr("id");
					jQuery(this).attr("id", id+"_rad" );
					jQuery(this).next().attr("for", id+"_rad")
				});
			}


		},
		map: function(current)
		{
			var name,temp;
			current.find('div.ioa_input').each(function(){
				temp = jQuery(this);
				name = temp.find('input,select,textarea').attr('name');
				
				if(temp.find('input[type=text]').length > 0)
					{
						temp.find('.'+name).val(rad_lightbox.find('input[name='+name+']').val());
						
					}
				else if(temp.find('textarea').length > 0)
					{
						temp.find('.'+name).val(rad_lightbox.find('textarea[name='+name+']').val());
						
					}	
			});
		}
	};

	doc.on('keyup',rad_lightbox, function(e) {
		
	  if (e.keyCode == 27) { rl.hide(); } 
	});

jQuery('#close-l').click(function(e){  e.preventDefault(); rl.hide(); });
}
 doc.on('click','#save-l-data',function(e){
		e.preventDefault();
		
		if( typeof rad_lightbox.data("mode") != "undefined" && rad_lightbox.data("mode") == "shortcode" ) return;

		if(rad_lightbox.find('div.rad-l-body').data('key')=="query_engine")
		{
			var query = '';
			var c = '';
			jQuery('input[name=select_post_cats]').each(function(){
	 			if( jQuery(this).is(':checked') ) c = c +jQuery(this).val()+",";
			});
			if(c!="," && c!="")
			query = query+"category_name="+c+"&";
			var t = '';
			jQuery('input[name=select_post_tags]').each(function(){
	 			if( jQuery(this).is(':checked') ) t = t +jQuery(this).val()+",";
			});

			if(t!="," && t!="")
			query = query+"tag_id="+t+"&";

			var a = '';
			jQuery('input[name=select_post_auhtors]').each(function(){
	 			if( jQuery(this).is(':checked') ) a = a +jQuery(this).val()+",";
			});

			if(a!="," && a!="")
			query = query+"author="+a+"&";

			var tax= '';
			rad_lightbox.find('div.custom-tax').each(function(){
				tax += jQuery(this).find('.taxonomy').val();

				var a = '';
				jQuery(this).find('input[type=checkbox]').each(function(){
	 				if( jQuery(this).is(':checked') ) a = a +jQuery(this).val()+",";
				});
				tax += "|"+a;

				if(a==","||a=="") tax = '';
				
			})	

			if(tax!="," && tax!="")
			query = query+"tax_query="+tax+"&";

			query = query+"order="+rad_lightbox.find('#order').val()+"&";
			query = query+"orderby="+rad_lightbox.find('#orderby').val()+"&";

			if(rad_lightbox.find('#year').val()!="")
			query = query+"year="+rad_lightbox.find('#year').val()+"&";
			
			if(rad_lightbox.find('#month').val()!="")
			query = query+"monthnum="+rad_lightbox.find('#month').val()+"&";

	 		query_engine.parent().find('input[type=text]').val(query);
	 		query_engine.parent().find('input[type=text]').trigger('keyup');

		}
		else if(rad_lightbox.find('div.rad-l-body').data('key')=="simple_icons")
		{
			var icon = jQuery('ul.sicon-list li.active').clone();
			sicon_engine.parent().find('input[type=text]').val(icon.children('i').removeClass('icon').attr('class'));
	 		sicon_engine.parent().find('input[type=text]').trigger('keyup');
		}
		else if(rad_lightbox.find('div.rad-l-body').data('key')=="icons")
		{
			var query = icon_canvas.html();
			
			
			icon_obj.parents('div.ioa_input').find('input,textarea').val(jQuery.trim(query));
			icon_obj.parents('div.ioa_input').find('input,textarea').trigger('change');
			icon_obj.parents('div.ioa_input').find('input,textarea').trigger('keyup');

			if(! icon_obj.parents('div.ioa_input').find('a.inp_button').hasClass('active') )
			{
				icon_obj.parents('div.ioa_input').find('a.inp_button').trigger('click');
			}

		}
		

		rl.hide();
		rad_lightbox.find('.rad-l-body .component-opts').html('');
		
	});
doc.on('click','a.query-maker',function(e){
    	e.preventDefault();
    	query_engine = jQuery(this);
	var pt = query_engine.parents('div.inner-body-wrap,div.ioa-query-box,.ex-shortcode-mods , .ui-tabs-panel').find('.post_type,.shortcodes_val_holder,.custom_post_type').val();
	
	if(pt=="" || typeof pt == "undefined") pt ="post";
	
	rl.show('Query Engine');
	jQuery.post(ajaxurl,{ type:'query_engine', action: 'ioalistener' , post_type : pt },function(data){
		rl.set(data,'query_engine');
	});

    });


// == Core Function Required for RAD Builder
var px_keys = ["font-size","margin","margin-top","margin-bottom","margin-left","maring-right","border-width"];
var routines = {
 storage : null,
 addRecord : function(id,values)
 {
    rad_sections[id] = values;

 },
 mapSettings : function (target,source)
  {
    rad_sections[target.attr('id')] = rad_sections[source.attr('id')];
  },
 hexToRgb : function(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
},
getWPEditor : function(content){

	//jQuery('.rad-w-editor-body iframe').attr('src',ajaxurl+"?type=rad_wp_editor&action=rad_query_listener");
	
	
		setTimeout(function(){ routines.setWPEditorContent(content);	 },300);

},
showEditor : function(input) { 
	if(!EDITOR_FLAG)
	  	routines.getWPEditor(input.val());
	else
		routines.setWPEditorContent(input.val());	  
    
    routines.storage = input;

	jQuery('.rad-w-editor').fadeIn('fast'); 
} , 
hideEditor : function() { jQuery('.rad-w-editor').fadeOut('fast'); } , 
getWPEditorContent : function(){

		if( jQuery('.r-w-editor-area').find('.wp-editor-wrap').hasClass('html-active')) {
              return jQuery('#rad_wp_editor').val();
            } else {
              return tinyMCE.get('rad_wp_editor').getContent();
            }

},
setWPEditorContent : function(text){
	
	if( jQuery('.r-w-editor-area').find('.wp-editor-wrap').hasClass('html-active')) {
              jQuery('#rad_wp_editor').val(text);
            } else {
               tinyMCE.get('rad_wp_editor').setContent(text);
            }

},
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
setGradient : function(parent)
{
	var dir = parent.find('.background_gradient_dir').val();
	var start = parent.find('.start_gr').val();
	var end = parent.find('.end_gr').val();

	switch(dir)
	{
		case "vertical" : dir = "top"; break;
		case "horizontal" : dir = "left";  break;
		case "diagonaltl" : dir = "45deg";  break;
		case "diagonalbr" : dir = "-45deg";  break;

	}
	
	
	
	current_editing_obj.css('background', "-ms-linear-gradient("+dir+", "+start+", "+end+")");
	current_editing_obj.css('background', "-o-linear-gradient("+dir+", "+start+", "+end+")");
	current_editing_obj.css('background' , "-moz-linear-gradient("+dir+", "+start+" 0%, "+end+" 100%)");
	current_editing_obj.css('background', "-webkit-gradient("+dir+", 0% 0%, 0% 100%, from("+end+"), to("+start+"))");
	current_editing_obj.css('background', "-webkit-linear-gradient("+dir+", "+start+", "+end+")");

	
},
generateVisualMap: function(el,operation,value)
  {
    

  if( el.hasClass('sec-bg-listener') ) {
  	if(el.data('label')=="background color")
  		operation =  "background_color";

  	if(el.data('label')=="background image")
  		operation =  "background_image";

  	if(el.data('label')=="background attachment")
  		operation =  "background_attachment";

  	if(el.data('label')=="background position")
  		operation =  "background_position";

  	if(el.data('label')=="background repeat")
  		operation =  "background_repeat";

  	if(el.data('label')=="background cover")
  		operation =  "background_cover";


  	if(el.data('label')=="background gradient")
  		operation =  "start_gr";

  	if(el.data('label')=="gradient start color ")
  		operation =  "start_gr";

  	if(el.data('label')=="gradient end color")
  		operation =  "end_gr";

  	if(jQuery.trim(el.data('label'))=="select background type")
  		operation =  "background_opts";

  


  }

	if(jQuery.trim(el.data('label'))=="border top width")
  		operation =  "border_top_width";

  		if(jQuery.trim(el.data('label'))=="border top color")
  		operation =  "border_top_color";

  		if(jQuery.trim(el.data('label'))=="border top type")
  		operation =  "border_top_type";

  	  	if(jQuery.trim(el.data('label'))=="border bottom width")
  		operation =  "border_bottom_width";

  		if(jQuery.trim(el.data('label'))=="border bottom color")
  		operation =  "border_bottom_color";

  		if(jQuery.trim(el.data('label'))=="border bottom type")
  		operation =  "border_bottom_type";
  	
   console.log(el.data('label')+' '+operation+' '+value);
if(  typeof operation == "undefined"  )
    {
    	current_editing_obj.find("."+el.find('input').attr('name')).html(value);
    	return;
    }	


    if(  typeof el.data('property') != "undefined" && el.data('property')!="" )
    {
    	if( jQuery.inArray(el.data('property'), px_keys) > -1 ) value +="px";
    	current_editing_obj.find(el.data('target')).css(el.data('property'),value);
    	return;
    }	




    switch(operation)
    {
    	case 'v_padding' : current_editing_obj.css({ 'padding-top' : value+"px" , 'padding-bottom' : value+"px" }); break;
    	case 'background_opts': if(value!="") current_editing_obj.addClass('senseBGModel'); else 
    							{
    								current_editing_obj.removeClass('senseBGModel');
    								current_editing_obj.css('background' ,'transparent');
    							}
    							break;
    	case 'background_color' : 
    							if(el.parents('.ui-tabs-panel').find('.background_opts').val() == 'bg-color')
    							{
    								current_editing_obj.css('background' ,'transparent');
    							}
								current_editing_obj.css('background' , value); break;
    	case 'background_image' :
    							temp1 = el.parents('.ui-tabs-panel').find('.background_opts').val();  
    							  if(temp1 == 'bg-image' || temp1 == 'custom' || temp1 == 'bg-texture')	
    							  		current_editing_obj.css('background-image' , "url("+value+")");
    							  		current_editing_obj.css('background-size' , "cover"); 	

    							   
    							  break;
    	case 'background_attachment' : 
    							temp1 = el.parents('.ui-tabs-panel').find('.background_opts').val();  
    							  if(temp1 == 'bg-image' || temp1 == 'custom' || temp1 == 'bg-texture')	
    								current_editing_obj.css('background-attachment' , value); break;	

    	case 'background_position' :
    							temp1 = el.parents('.ui-tabs-panel').find('.background_opts').val();  
    							  if(temp1 == 'custom' || temp1 == 'bg-texture')	
    							 	current_editing_obj.css('background-position' , value); break;					  
    	case 'background_repeat' : 
    							temp1 = el.parents('.ui-tabs-panel').find('.background_opts').val();  
    							 if(temp1 == 'custom' || temp1 == 'bg-texture')	
    							current_editing_obj.css('background-repeat' , value); break;					  
    	case 'background_cover' : 	 
    							temp1 = el.parents('.ui-tabs-panel').find('.background_opts').val();  
    							if(temp1 == 'custom' )	current_editing_obj.css('background-size' , value); break;


    	case 'start_gr' :
    	case 'end_gr' :
    					if(value!="" && el.parents('.ui-tabs-panel').find('.background_opts').val() == 'bg-gr')
    					routines.setGradient(el.parents('.ui-tabs-panel'));		 	
    					break;
    	
    	case 'border_top_width' : 	current_editing_obj.css('border-top-width' , value+"px"); break;					  
    	case 'border_top_color' : 	current_editing_obj.css('border-top-color' , value); break;					  
    	case 'border_top_type' : 	current_editing_obj.css('border-top-style' , value); break;	
    	

    	case 'border_bottom_width' : 	current_editing_obj.css('border-bottom-width' , value+"px"); break;					  
    	case 'border_bottom_color' : 	current_editing_obj.css('border-bottom-color' , value); break;					  
    	case 'border_bottom_type' : 	current_editing_obj.css('border-bottom-style' , value); break;	
   		case 'background_opacity' :

   		                            var c = el.parents('.ui-tabs-panel').find('.background_color').val(); 
   		                            if(c!="" && typeof c !== "undefined" )
   		                           {
   		                           	 c = routines.hexToRgb(c);
   									 current_editing_obj.css('background' ,"rgba("+c.r+","+c.g+","+c.b+","+value+")");
   		                           }

   									break;	
    	case 'text_subtitle' :
    	case 'text_title' : current_editing_obj.find('.'+operation).html(value);   break;					  
    	case 'text_data' : current_editing_obj.find('.'+operation).html(value);   break;					  
    }

  },

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
}

}


		

doc.on('click','.persist-editor',function(e){
		e.preventDefault();
		if( jQuery(this).hasClass('is-persistant') )
			{
				Phantom.addLocalRegistry('rad_persist','no');
				jQuery(this).removeClass('is-persistant');
				jQuery(this).html('Start Automatically');
			}
		else
			{
				Phantom.addLocalRegistry('rad_persist','yes');
				jQuery(this).addClass('is-persistant');
				jQuery(this).html('Start on Click');
			}
});

doc.on('click','.cancel-rad-w-editor',function(e){
		e.preventDefault();
		routines.hideEditor();
});

doc.on('click','.set-rad-w-editor',function(e){
		e.preventDefault();
		routines.storage.val( routines.getWPEditorContent() );
		routines.hideEditor();
});

// Intialize Lightbox Settings

doc.on('click','a.picker-delete',function(e){
		e.preventDefault();
		jQuery(this).parent().find('.minicolors-input').minicolors('value',' ');
		jQuery(this).parent().find('span.minicolors-swatch >span').css('background','transparent');
});

// Mod Computation


doc.on('click','a.add-ioa-module',function(e){
	 	e.preventDefault();
	 	var mod = jQuery(this).parents('.ioa_module_container').find('div.module_list');
	 	var bl = jQuery(this).parents('.ioa_module_container').find('div.ioa_module.hide');
	 	bl = bl.clone().removeClass('hide');
	 	
	 	mod.append(bl);	
	 	bl.find('.ioa-minicolors').minicolors('destroy');
		bl.find('.ioa-minicolors').minicolors({
					textfield : true,
					opacity: false,
					change: function(hex, opacity) {
                     
                  	   jQuery(this).parent().next().val(opacity);    
                   	   jQuery(this).trigger('change');
                        
                    }

				});
	 	mod.sortable({ handle : '.module_head' , stop: function( event, ui ) { computeModuleData( ui.item.parents('div.ioa_module_container')  );  }  });
	 	
	 });



doc.on('click','a.save-ioa-module',function(e){
	e.preventDefault(); 
	computeModuleData( jQuery(this).parents('div.ioa_module_container')  );
	temp = jQuery(this);
	temp.html(temp.data('save'));
	setTimeout(function(){ temp.html(temp.data('restore')); },500)
});

if( jQuery('div.module_list').length > 0 )
jQuery('div.module_list').sortable({ stop: function( event, ui ) { computeModuleData( ui.item.parents('div.ioa_module_container')  );  }  });

	 jQuery(document).on('click','div.module_head a.edit-mod',function(e){
	 	e.preventDefault();

	 	jQuery(this).parent().next().slideToggle('normal',function(){ rad_live_builder.scroll_pane.reinitialise(); });

	 });

	  jQuery(document).on('click','div.module_head a.clone-mod',function(e){
	 	e.preventDefault();

	 	temp = jQuery(this).parents('.ioa_module');
	 	obj = temp.clone();	
	 	temp.after( obj );

	 	obj.find('.ioa-minicolors').minicolors('destroy');
		obj.find('.ioa-minicolors').minicolors({
					textfield : true,
					opacity: false,
					change: function(hex, opacity) {
                     
                  	   jQuery(this).parent().next().val(opacity);    
                   	   jQuery(this).trigger('change');
                        
                    }

				});
		obj.find('.minicolors.minicolors-theme-default').wrap('<div class="colorpicker-wrap"></div>');
		var v;
		obj.find('.ioa_input').each(function(){

			v = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
			v.val( temp.find( "."+v.attr('name')).val() );
		});

	 });

 

 jQuery(document).on('click','a.delete-mod',function(e){
	e.preventDefault();
	var p = jQuery(this).parents('div.ioa_module_container');
	jQuery(this).parents('div.ioa_module').remove();
	computeModuleData(p);
 	
 });


 function computeModuleData(parent)
	 {
	 	var code = '',temp;

	 	parent.find('div.module_list').children().each(function(){
	 		code += "[ioa_mod]";

	 		jQuery(this).find('div.ioa_input').each(function(){
	 			temp  = jQuery(this);

	 			code += "[inp]"+temp.find('input,select,textarea').attr('name')+"[ioas]"+temp.find('input,select,textarea').val()+"[ioas]";

	 		});

	 	});

	 	parent.find('.mod_data').find('input').val(code);
	 	parent.find('.mod_data').find('input').trigger('change');
	 }


// PHANTOM ENGINE
 
var Phantom = {
	reset : false,
	widgets : [],
	getView : function(key,label) {
			var obj;
 			obj =	RAD_Views.widgetView.replace('{ID}','rpw'+routines.uniqueid());
		    obj = obj.replace('{label}',key );
            obj = jQuery(obj);
            obj.find('.rad-s-title').html(label);
            
            setTimeout(function(){
            	Phantom.requestDefaultStub(key,obj);
            },200);

            return obj;

	},
	requestDefaultStub : function(key,obj)
	{

		temp = obj.attr('id');
		
		if(Modernizr.localstorage && Phantom.checkRegistry(key) )
		{
			 obj.removeClass('default_rad_stub');
      		 obj.html(Phantom.getRegistry(key)+RAD_Views.widgetToolbar);
      		 body.trigger('rad_widget_dropped',[ key , obj ]);
		}
		else	
		{
			obj.find('.filler').animate({ width:"80%" },40000);
			jQuery.post(ajaxurl,{ data:rad_builder_data[key]['inputs'] , id:temp , key:key  , action : 'rad_query_listener' , type :'rad-live-preview'  },function(data){

				data = jQuery(data);
				Phantom.addLocalRegistry(key,data.html());
				obj.find('.filler').stop(true).animate({ width:"100%" },400,function(){
					obj.removeClass('default_rad_stub');
					obj.html(data.html()+RAD_Views.widgetToolbar);	
					body.trigger('rad_widget_dropped', [ key, obj]);
				});
      		}); 

		}
      	
	},
	addLocalRegistry : function(key,widget_string)
	{

		if(Modernizr.localstorage)
		{
			localStorage.setItem(key,widget_string);
		}

	},
	checkRegistry : function(key)
	{	
		return false;
		if(Phantom.reset) return false;

		if( localStorage.getItem(key) )
			return true;
		else
			return false;
	},
	getRegistry : function(key)
	{
		return localStorage.getItem(key);
	}
} 


if(Modernizr.localstorage && Phantom.checkRegistry('RAD_Live_Version') )
{

	if( parseFloat(Phantom.getRegistry('RAD_Live_Version')) < RAD_Live_Version)
	{
		Phantom.reset = true;
		setTimeout(function(){ Phantom.reset = false; Phantom.addLocalRegistry('RAD_Live_Version',RAD_Live_Version); },6000);
	}
	
}
else	
{
	Phantom.addLocalRegistry('RAD_Live_Version',RAD_Live_Version);
}

// Live Builder Functions

var rad_live_builder = {
	generator : null,
	styles : null,	
	scroll_pane : null,
	init : function() {

			body.find('#rad_live_widgets,#rad_live_panel').show();
			body.find('.page-section').addClass('rad_editable_section rad_page_section');
			body.find('.page-section').append(RAD_Views.sectionToolbar+RAD_Views.sectionDropper);
			body.find('.rad-container').addClass('rad_editable_container rad_page_container');
			body.find('.rad-container').append(RAD_Views.containerToolbar+RAD_Views.containerDropper);
			body.find('.page-rad-component').addClass('rad_page_widget');
			body.find('.page-rad-component').append(RAD_Views.widgetToolbar);
			body.find('#rad_live_panel').animate({ bottom:0 },'normal');
			body.find('.rad_live_widgets_container').jScrollPane();
			setTimeout(function(){ body.find('.rad_live_widgets_container').css({ 'visibility' : 'visible' , 'display' : 'none' }); },300);



			jQuery('.rad-container').each(function(){
				temp = jQuery(this).attr('class'); obj = 'full';

				if(temp.indexOf('full') > 0)  obj = 'full';
				else if(temp.indexOf('one_half') > 0)  obj = 'one_half';
				else if(temp.indexOf('one_third') > 0)  obj = 'one_third';
				else if(temp.indexOf('one_fourth') > 0)  obj = 'one_fourth';
				else if(temp.indexOf('one_fifth') > 0)  obj = 'one_fifth';
				else if(temp.indexOf('two_third') > 0)  obj = 'two_third';
				else if(temp.indexOf('three_fourth') > 0)  obj = 'three_fourth';
				else if(temp.indexOf('four_fifth') > 0)  obj = 'four_fifth';

				routines.selectOptionByText(jQuery(this).find('.component_layout') ,obj);

			});

			

			  widgets.draggable({ helper: "clone" ,
		         start: function( event, ui ) {
		         },
		         stop : function( event, ui ) {
		         } ,
		         appendTo: 'body' 
		      });

		    frame.sortable({ handle:".section-sortable-handle", 
		    				 cursorAt: { top:0, left: 0 },
		    				 forceHelperSize:false ,  axis: "y" ,  
		    				 tolerance: 'pointer',
		    				 helper:function(){ return "<div class='section-c-helper'></div>"; },
		    				 start: function(e, ui ){
		    				 	 
							     ui.placeholder.height(30);
							     ui.helper.height(30);
							}, 
		    				}); 

		     rad_live_builder.sectionHandle(jQuery('.rad_page_section'));
			        jQuery('.rad_page_container').each(function(){
			          rad_live_builder.containerHandle(jQuery(this));
			        });

		    frame.after('<a href="" class="rad_add_section">Add Section +</a>');

		    frame.droppable({
			        hoverClass: "rad-frame-dropping",
			        greedy : true,
			      drop: function( event, ui ) {
			        
			       if( ui.draggable.data('group') === "widgets"  ||  ui.draggable.data('group') === "advance"   ||  ui.draggable.data('group') === "media" ||  ui.draggable.data('group') === "infographic"  || ui.draggable.data('group') === "plugins" || ui.draggable.data('group') === "core" )
			        {
			          
			          temp = jQuery(RAD_Views.sectionView.replace('{ID}','rps'+routines.uniqueid()));
			          frame.append(temp);
			          rad_live_builder.sectionHandle(temp);
			          routines.addRecord(temp.attr('id'),rad_builder_data.rad_page_section['inputs']);

			          var ctemp = jQuery(RAD_Views.containerView.replace('{ID}','rpc'+routines.uniqueid()));
			          ctemp.append(RAD_Views.containerDropper);
			          routines.addRecord(ctemp.attr('id'),rad_builder_data.rad_page_container['inputs']);

			          var v = 'full';
			          
			          routines.selectOptionByText(ctemp.find('.component_layout') ,v);
			          temp.find('.section-content').append(ctemp);

		          		wtemp = Phantom.getView( ui.draggable.data('id'),ui.draggable.data('label'));
		                wtemp.data('key', ui.draggable.data('id'));

		                routines.addRecord(wtemp.attr('id'),rad_builder_data[ui.draggable.data('id')]['inputs']);

		                temp.find('.rad-inner-container').append(wtemp);
		                routines.selectOptionByText(wtemp.find('.widget_layout') ,ui.draggable.find('.widget_layout').val());

			           rad_live_builder.containerHandle(ctemp);

			       }
			        
			        	
			         	rad_live_builder.setupItems(); 
			         	prediction();  
			      }, 
			      over: function( event, ui ) {  } ,
			      out: function( event, ui ) {  }
			    });  
	},

	destroy : function() {

			body.find('#rad_live_widgets,#rad_live_panel').hide();
			body.find('.page-section').removeClass('rad_editable_section rad_page_section');
			body.find('.rad-container').removeClass('rad_editable_container rad_page_container');
			body.find('.page-rad-component').removeClass('rad_page_widget');

			body.find('.rad_live_widgets_container').css({ 'visibility' : 'hidden' , 'display' : 'block' });

			frame.find('.rad_section_toolbar,.section-dropper-helper,.section-sortable-handle,.rad_container_toolbar,.container-sortable-handle,.container-dropper-helper,.widget-toolbar').remove();
			body.find('.rad_add_section').remove();
			body.find('#rad_live_panel').animate({ bottom:-50 },'normal');


			if(Modernizr.localstorage && Phantom.checkRegistry('RAD_Live_Version') )
			{
			}
			else	
			{
				Phantom.addLocalRegistry('RAD_Live_Version',RAD_Live_Version);
			}

			sapi.hide();

	},

	setupImportedItems : function(obj)
	{	

		 obj.each(function(){
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

	},
	setupItems : function()
	{
		frame.find('.page-section').addClass('rad_editable_section rad_page_section');
		frame.find('.rad-container').addClass('rad_editable_container rad_page_container');
		frame.find('.page-rad-component').addClass('rad_page_widget');
	},
	getSettingsSidebar : function(){
		
		if(Modernizr.localstorage && Phantom.checkRegistry('rad_settings_sidebar') )
		{
			rad_live_builder.setSettings(Phantom.getRegistry('rad_settings_sidebar') );
		}
		else	
		{
			jQuery.post(ajaxurl,{ type:'RAD-Sidebar' , action : 'rad_query_listener' },function(data){
			 rad_live_builder.setSettings(data);
			});	
		}	
		

	},
	setSettings : function(html)
	{
		Phantom.addLocalRegistry('rad_settings_sidebar', html);
		body.append(html);
		lightbox = body.find('.settings-bar');
		
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


        lightbox.find('.ioa-minicolors').each(function(){
                  obool = jQuery(this).data('opacity');
                  
                  jQuery(this).minicolors({
                    textfield : true,

                    opacity: false,
                    change: function(hex, opacity) {
                    				if(RAD_CHANGE_FLAG)
                                   jQuery(this).trigger('rad_change');
                                  },
                          hide: function(hex, opacity) {
                                   
                                   jQuery(this).trigger('mini-hidden');
                                      
                                  },        

                  });

                });


     lightbox.find(".settings-pane").tabs({
     	activate: function( event, ui ) {
     		rad_live_builder.scroll_pane.reinitialise();
     	}
     });
     lightbox.find(".inner-visual-settings-panel").accordion({
     	 heightStyle: "content",
     	 activate: function( event, ui ) {
     		rad_live_builder.scroll_pane.reinitialise();
     	}
     });


     lightbox.find('.settings-body').height( win.height - 43 );
      temp1 = lightbox.find('.settings-body').jScrollPane();
			 rad_live_builder.scroll_pane = temp1.data('jsp');

	},
	containerHandle : function(obj){

       obj.droppable({
                          accept: " .cl-widgets,.cl-advance,.cl-media, .cl-infographic  ,.rad_page_widget,.cl-plugins",
                          greedy: true,
                         hoverClass: "rad-container-dropping",

                          drop: function( event, ui ) {
                         
                          if( ui.draggable.hasClass('rad_page_widget')  && ( jQuery(this).attr('id') !== ui.draggable.parents('.rad_page_container').attr('id')  )  )
                          {
                             temp = ui.draggable.clone();
                             temp.removeClass('ui-sortable-helper').removeAttr('style');
                             jQuery(this).find('.rad-inner-container').append(temp);
                            
                             routines.selectOptionByText(temp.find('.widget_layout') ,ui.draggable.find('.widget_layout').val());
                             routines.mapSettings(temp,ui.draggable);
                             ui.draggable.remove();
                          }

                         

                          if( ui.draggable.data('group') === "widgets" ||  ui.draggable.data('group') === "advance"   ||  ui.draggable.data('group') === "media"  ||  ui.draggable.data('group') === "infographic"  || ui.draggable.data('group') === "plugins" || ui.draggable.data('group') === "core" )
                          {
                          	

                             temp = Phantom.getView( ui.draggable.data('id'),ui.draggable.data('label'));

                             jQuery(this).find('.rad-inner-container').append(temp);
                             temp.data('key', ui.draggable.data('id'));
                             routines.addRecord(temp.attr('id'),rad_builder_data[ui.draggable.data('id')]['inputs']);
                          }

                          rad_live_builder.setupItems();
                          setTimeout(function(){
                          	prediction();
                          },100);

                       
                        }
                      });


      obj.find('.rad-inner-container').sortable({
          forceHelperSize: true , forcePlaceholderSize: true  , opacity:0.9,
           handle : '.rad-widget-handle',
           appendTo : 'body', 
		   tolerance: 'pointer',
		   cursorAt: { top:0, left: 0 },
		   helper : function(){ return "<div class='rad_widget_helper'></div>" } ,
         start: function( event, ui ) {



        } 
        , stop: function( event, ui ) {

        } 
        });


   },
   sectionHandle : function(obj) {
        obj.droppable({
                      accept: ".cl-structure , .cl-widgets,.cl-advance,.cl-media, .cl-infographic , .rad_page_container,.cl-plugins", 
                      hoverClass: "rad-section-dropping",
                      greedy:true,
                      drop: function( event, ui ) {
                          if( ui.draggable.data('group') === "widgets" ||  ui.draggable.data('group') === "advance"   ||  ui.draggable.data('group') === "media"  ||  ui.draggable.data('group') === "infographic" || ui.draggable.data('group') === "core" || ui.draggable.data('group') === "plugins")
                          {

                              var temp = jQuery(RAD_Views.containerView.replace('{ID}','rpc'+routines.uniqueid()));
                              routines.addRecord(temp.attr('id'),rad_builder_data.rad_page_container['inputs']);
                              temp.append(RAD_Views.containerDropper);
                              var v = 'full';
                              
                              routines.selectOptionByText(temp.find('.component_layout') ,v);
                              jQuery(this).find('.section-content').append(temp);

                              temp.css({ opacity :0 , scale :0  });
                              temp.transition({ scale:1, opacity: 1 },500,'easeOutBack',function(){

                                    wtemp =Phantom.getView( ui.draggable.data('id'),ui.draggable.data('label'));
                                    wtemp.data('key', ui.draggable.data('id'));

                                    routines.addRecord(wtemp.attr('id'),rad_builder_data[ui.draggable.data('id')]['inputs']);

                                    temp.find('.rad-inner-container').append(wtemp);
                                    wtemp.css({ opacity :0   });
                                    routines.selectOptionByText(wtemp.find('.widget_layout') ,ui.draggable.find('.widget_layout').val());
                                    wtemp.transition({  opacity: 1 },500,'easeOutBack');
                                    

                              });
                              rad_live_builder.containerHandle(temp);

                          }
                          

                          if( ui.draggable.hasClass('rad_page_container') && ( jQuery(this).attr('id') !== ui.draggable.parents('.rad_page_section').attr('id')  ) )
                          {
                             
                             temp = ui.draggable.clone();
                             temp.removeClass('ui-sortable-helper').removeAttr('style');
                             jQuery(this).find('.section-content').append(temp);
                             rad_live_builder.containerHandle(temp);

                             temp.css({ opacity :0 , scale :0  });
                             temp.transition({ scale:1, opacity: 1 },500,'easeOutBack');
                             
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

                            temp.css({ opacity :0 , scale :0  });
                            temp.transition({ scale:1, opacity: 1 },500,'easeOutBack');

                            rad_live_builder.containerHandle(temp);

                            routines.addRecord(temp.attr('id'),rad_builder_data.rad_page_container['inputs']);

                          }

                         
                          rad_live_builder.setupItems();
                          prediction();
                      }
                  });

        obj.find('.section-content').sortable({
           opacity:0.9 , forceHelperSize: true , forcePlaceholderSize: true,
           handle : '.container-sortable-handle', 

		   tolerance: 'pointer',

           start: function( event, ui ) {
             ps = ui.item.parent();
             ps.sortable( "refresh" );
             ps.sortable( "refreshPositions" );
             ps.find('.rad_page_container').removeClass('first last');

         	
         	ui.placeholder.height(ui.item.height());


          } 
          , stop: function( event, ui ) {
			 prediction();
          } 
        });


   },


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

                                                    console.log(widget_settings);
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

       rad_live_builder.generator = generator_string ;
      rad_live_builder.styles = encodeRFC5987ValueChars ( JSON.stringify(style_keys) ) ;

          return JSON.stringify(save_array); // Return the value for Other Purposes

      
   }

};	


function encodeRFC5987ValueChars (str) {
    return encodeURIComponent(str).
        replace(/\%/g, '[p]');
}

var RAD_Views = {

  sectionView : jQuery("#RADSectionView").html(),
  containerView : jQuery("#RADContainerView").html(),
  widgetView : jQuery("#RADWidgetView").html(),
  sectionToolbar : jQuery("#sectionToolbar").html(),
  containerToolbar : jQuery("#containerToolbar").html(),
  widgetToolbar : jQuery("#widgetToolbar").html(),

  sectionDropper : jQuery('#sectionDropper').html() ,
  containerDropper : jQuery('#containerDropper').html() 

} ;


doc.on('click','.trigger-live-editor',function(e){
	e.preventDefault();

	if( jQuery(this).hasClass('editor-is-active') )
	{
		jQuery(this).removeClass('editor-is-active officon-').addClass('flash-2icon-');
		rad_live_builder.destroy();
		ioa_msg.setMessage('Closing Editor','Cleaning Up','information');
		ioa_msg.show();
	}
	else
	{
		jQuery(this).addClass('editor-is-active officon-').removeClass('flash-2icon-');
		rad_live_builder.init();
		ioa_msg.setMessage('Activating Editor','Setting up Environment','information');
		ioa_msg.show();
	}

	
});

doc.on('click', 'div.input-image-preview span.himage-remove',function(){
		jQuery(this).parent().hide();
		jQuery(this).parent().find('img').attr('src','');
		jQuery(this).parent().prev().find('input').val('');
	});

doc.on('click','.ioa-editor-trigger',function(e){
	e.preventDefault();
	routines.showEditor( jQuery(this).parent().find('textarea') );
});

doc.on('click','.preview-trigger',function(e){
	e.preventDefault();

	if( lightbox.data('key') == 'rad_page_section' || lightbox.data('key') == 'rad_page_container' ) return;

	 jQuery(this).children('span').animate({ width:'90%' },40000);

     obj =  getObjData(lightbox.find('.'+lightbox.data('key')));
     temp1 = jQuery(this);



      jQuery.post(ajaxurl,{ data:obj , id:current_editing_obj.attr('id') , key:current_editing_obj.data('key')  , action : 'rad_query_listener' , type :'rad-live-preview'  },function(data){

      			data = jQuery(data);
      			current_editing_obj.removeClass('default_rad_stub');
      			current_editing_obj.html(data.html()+RAD_Views.widgetToolbar);

      			body.trigger('rad_widget_preview',[ current_editing_obj.data('key'), current_editing_obj ] );

      			lightbox.find('.'+current_editing_obj.data('key')).find('.rad-styler .ioa_input').each(function(){

		    	  xc = jQuery(this).find('input,select');
		    	  if(xc.val()!="")
				  routines.generateVisualMap(xc , xc.attr('name') , xc.val()  );		

				});

				setTimeout(function(){
      				temp1.children('span').stop(true).animate({ width:'100%' },500,function(){ jQuery(this).width(0) });
      			},300);

      } )      

});

doc.on('click', '#rad_page_save',function(e){
	e.preventDefault();

	if(current_editing_obj)
   		maptoObj( current_editing_obj, lightbox.find('.'+lightbox.data('key')) );

   	rad_live_builder.saveRADData(frame);

	jQuery.post(ajaxurl,{ id : frame.data('id') , data : rad_live_builder.generator , styles :  rad_live_builder.styles,  action : 'rad_query_listener' , type :'rad-live-save' },function(data){

		if(data=="1")
		{
			ioa_msg.setMessage('Saved','Yay data has been saved !','success');
   			ioa_msg.show();
		}
		else
		{
			ioa_msg.setMessage('Error','Oops cannot save data :(','error');
   			ioa_msg.show();
		}

	});


});

// == Lightbox API =================
 

 var lightbox =  null , sapi = {

      hide : function() { 
            lightbox.animate({ left:-(SIDEBAR_WIDTH+40) },'normal');
       },
      show : function() { 
              lightbox.css({ left:-(SIDEBAR_WIDTH+40) , 'display' :'block' }).animate({ left:0 },'normal');
       }

  }; 
 
doc.on('click','.cancel-settings',function(e){
    e.preventDefault();
    sapi.hide();  
});

doc.on('click','.save-settings',function(e){
    e.preventDefault();
    maptoObj( current_editing_obj, lightbox.find('.'+lightbox.data('key')) );
    sapi.hide();  
});

doc.on('click','#rad_page_section_clearall',function(e){
	e.preventDefault();

    var r=confirm("Are you sure you want to delete all content ! This cannot be undone.");
    if (r==true)
      {
         frame.empty();
      }
});

doc.on('change','.rad-panel-selector',function(){
	temp1 = jQuery(this).parents('.input-section-tabs')
	temp1.children().not('.rad-sidebar-panel-selector').hide();
	temp1.find(jQuery(this).val()).show();
	rad_live_builder.scroll_pane.reinitialise();	
})

/**
 * Section BASED Event Listener
 */


doc.on('click', '.rad_section_save_library',function(e){
  e.preventDefault();
  save_array = [];
  temp = jQuery(this).parents('.rad_page_section');
  var s_title = 'Section ID : '+temp.attr('id');
      d = [];
   s_id   = temp.attr('id');
      /**
       * Section Settings
       */
      if(_.has(rad_sections,s_id))
               d =  rad_sections[s_id];

         _.each(rad_sections[s_id],function(k,v){
            if(k.name == 'section_name')
               {
                s_title = k.value;
               }
        });
               

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

           widgets[l] = { id : jQuery(this).attr('id') , data  : widget_settings  , type : jQuery(this).data('key')  , layout : jQuery(this).find('.widget_layout').val() };


         });

         conts[k] = { id : jQuery(this).attr('id') , data  : container_settings , layout : jQuery(this).find('.component_layout').val() , widgets : widgets  };
      
      });

      save_array[0] = { id : temp.attr('id') , data  : d , containers : conts  };
 
  

   jQuery.post(ajaxurl,{ type:"RAD-Template-Section", action: 'rad_query_listener' , data : JSON.stringify(save_array)  , id : frame.data('id') ,title : s_title },function(data){

       ioa_msg.setMessage('Saved','Section Has been saved !','success');
       ioa_msg.show();


    });
    

});

var section_temp;
doc.on('click','.rad_section_clone',function(e){
	e.preventDefault();
	
	obj = jQuery(this).parents('.rad_page_section');
    section_temp = obj.clone();
    section_temp.attr('id','rps'+routines.uniqueid());

    var srcs = obj.find('.rad_page_container') , ws = [];
    

    section_temp.find('.rad_page_container').each(function(j){
    	container_temp = jQuery(this);

    	current_editing_obj = jQuery(this);
	    lightbox.data('key',current_editing_obj.data('key'));
		maptoLightbox( lightbox.find('.'+current_editing_obj.data('key')) ,current_editing_obj  );
		lightbox.find('.'+current_editing_obj.data('key')).find('.ioa_input').each(function(){

		    	  xc = jQuery(this).find('input,select');
				  routines.generateVisualMap(xc , xc.attr('name') , xc.val()  );		

		});

        container_temp.attr('id','rpc'+routines.uniqueid());
        routines.mapSettings( container_temp, srcs.eq(j) );
        routines.selectOptionByText(container_temp.find('.component_layout') ,srcs.eq(j).find('.component_layout').val());

		ws = srcs.eq(j).find('.rad_page_widget');
        jQuery(this).find('.rad_page_widget').each(function(i){
        	xw = jQuery(this);
            xw.attr('id','rpw'+routines.uniqueid());
            routines.mapSettings(  xw, ws.eq(i) );
            xw.data('key',ws.eq(i).data('key'));

            current_editing_obj = xw;
		    lightbox.data('key',current_editing_obj.data('key'));
			maptoLightbox( lightbox.find('.'+current_editing_obj.data('key')) ,current_editing_obj  );

			lightbox.find('.'+current_editing_obj.data('key')).find('.rad-styler .ioa_input').each(function(){
		    	  xr = jQuery(this).find('input,select');
				  routines.generateVisualMap(xr , xr.attr('name') , xr.val()  );		

		    });


        });  
    
    });  

    obj.after(section_temp);
    routines.mapSettings(section_temp,obj);
    rad_live_builder.sectionHandle(section_temp);

    current_editing_obj = section_temp;
    current_editing_obj.data('key','rad_page_section');

    lightbox.data('key',current_editing_obj.data('key'));
	maptoLightbox( lightbox.find('.'+current_editing_obj.data('key')) ,current_editing_obj  );
	lightbox.find('.'+current_editing_obj.data('key')).find('.ioa_input').each(function(){

	    	  xc = jQuery(this).find('input,select');
			  routines.generateVisualMap(xc , xc.attr('name') , xc.val()  );		

	});


});


doc.on('click','.rad_section_delete',function(e){
    e.preventDefault();
    temp = jQuery(this).parents('.rad_page_section');
    temp.remove();
    sapi.hide();
});

doc.on('click','.rad_add_section',function(e){
	e.preventDefault();
	s_id = 'rps'+routines.uniqueid();
	temp = jQuery(RAD_Views.sectionView.replace('{ID}',s_id));
    frame.append(temp);
    temp.append(RAD_Views.sectionDropper);
    temp.addClass('rad_editable_section rad_page_section no-container');
    routines.addRecord(temp.attr('id'),rad_builder_data['rad_page_section']['inputs']);
    rad_live_builder.sectionHandle(temp);
});


doc.on('click','.rad_section_edit',function(e){
	e.preventDefault();
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
      case 'bg-gr' : lightbox.find('.rad_page_section').find('.bg-gradient').show(); break;
      case 'bg-video' : lightbox.find('.rad_page_section').find('.bg-video').show(); break;
      case 'bg-texture' : lightbox.find('.rad_page_section').find('.bg-texture').show(); break;
      case 'custom'  : lightbox.find('.rad_page_section').find('.sec-bg-listener').show();  
                       lightbox.find('.rad_page_section').find('.bg-video,.bg-gradient').hide(); break;
    }
});


// End   

/**
 * Container BASED Event Listener
 */
var container_temp;
doc.on('click','.container-clone',function(e){
    e.preventDefault();

    obj = jQuery(this).parents('.rad_page_container');
    container_temp = obj.clone();
    c_id = 'rpc'+routines.uniqueid();
    container_temp.attr('id',c_id);
    
    var  srcs = obj.find('.rad_page_widget') ;

    obj.after(container_temp);
    container_temp.find('.rad_page_widget').each(function(i){
        w_id = 'rpw'+routines.uniqueid();
        temp1 = jQuery(this);
        temp1.attr('id',w_id);
        routines.selectOptionByText(temp1.find('.widget_layout') ,srcs.eq(i).find('.widget_layout').val());
        routines.addRecord( w_id, rad_sections[srcs.eq(i).attr('id')] );
        temp1.data('key',srcs.eq(i).data('key'));

        current_editing_obj = temp1;
        lightbox.data('key',current_editing_obj.data('key'));
	    maptoLightbox( lightbox.find('.'+current_editing_obj.data('key')) ,current_editing_obj  );

	    lightbox.find('.'+current_editing_obj.data('key')).find('.rad-styler .ioa_input').each(function(){

	    	  xw = jQuery(this).find('input,select');
	    	  if(xw.val()!="")
			  routines.generateVisualMap(xw , xw.attr('name') , xw.val()  );		

	    });

    }); 
   

    routines.mapSettings(container_temp,obj);
    
    routines.selectOptionByText(container_temp.find('.component_layout') ,obj.find('.component_layout').val());
    
    current_editing_obj = container_temp;
    lightbox.data('key','rad_page_container');
	maptoLightbox( lightbox.find('.rad_page_container') ,current_editing_obj  );

	lightbox.find('.rad_page_container').find('.ioa_input').each(function(){

	    	  xc = jQuery(this).find('input,select');
	    	  if(xw.val()!="")
			  routines.generateVisualMap(xc , xc.attr('name') , xc.val()  );
			  
	});

	rad_live_builder.containerHandle(container_temp);

   prediction();
   sapi.hide();

});


doc.on('click','.container-delete',function(e){
    e.preventDefault();
    temp = jQuery(this).parents('.rad_page_container');

    temp.remove();
        prediction();

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


doc.on('click','.container-edit',function(e){
    e.preventDefault();

    if(current_editing_obj)
   		maptoObj( current_editing_obj, lightbox.find('.'+lightbox.data('key')) );

    current_editing_obj =  jQuery(this).parents('.rad_page_container');
    
    lightbox.data('key','rad_page_container');
    maptoLightbox( lightbox.find('.rad_page_container') ,current_editing_obj  );

    sapi.show();  
});

doc.on('change','.component_layout',function(){

    temp = jQuery(this).parents('.rad_page_container');
    temp.removeClass('full one_fifth one_fourth one_third one_half two_third three_fourth four_fifth');
    temp.addClass( jQuery(this).val() );
    prediction();

});

// END 

// MISC FIle Functions

jQuery('.save-template').click(function(e){
    e.preventDefault();
    jQuery('div.save-template-lightbox').css({ opacity:0 , display:'block' , scale:0 }).transition({ scale : 1, opacity : 1 },400);

});

jQuery('.save-revision').click(function(e){
  e.preventDefault();

    var currentdate = new Date();
    var auto_title = 'Revision '+ currentdate.getDate() + "/"+(currentdate.getMonth()+1) + "/" + currentdate.getFullYear() + " @ " + currentdate.getHours() + ":"  + currentdate.getMinutes();

   jQuery.post(ajaxurl,{ type:"RAD-Revision", action: 'rad_query_listener' , data : rad_live_builder.saveRADData(frame)  , id : frame.data('id') ,title : auto_title },function(data){
      ioa_msg.setMessage('Revision Saved','Template revisions has been saved !','information');
    ioa_msg.show();

     });
 

});

jQuery('.export-templates').click(function(e){
  e.preventDefault();
  save_array = [];

   jQuery.post(ajaxurl,{ type:"RAD-Template-Export", action: 'rad_query_listener' , data : rad_live_builder.saveRADData(frame)  , id : frame.data('id') ,title : jQuery('title').text() },function(data){
      window.location.href = jQuery('.export-templates').attr('href')+"&rad_export=true";
    });
    

});


jQuery('.import-page-templates').click(function(e){
    e.preventDefault();
    jQuery('.page-import-area').show();

});

jQuery('.import-rad-page').click(function(e){
    e.preventDefault();
    if(jQuery('.import_rad_page').val()=="") return;

      ioa_msg.setMessage('Importing..','Importing Content','information'); 
      ioa_msg.show();

    jQuery.post(ajaxurl,{ type:"RAD-Live-Page-Import", action: 'rad_query_listener' , data : jQuery('.import_rad_page').val()   },function(data){

      data = jQuery(data);  
      frame.append(data);
	  
	  rad_live_builder.setupImportedItems(data);


     body.trigger('rad_widget_dropped',[ 'import_page' , data ]);
      jQuery('.page-import-area').hide();
   
    });


});

var save_template = jQuery('.save-rad-template');
save_template.click(function(e){
  e.preventDefault();
  save_template.html('Saving');

   jQuery.post(ajaxurl,{ type:"RAD-Template", action: 'rad_query_listener' , data : rad_live_builder.saveRADData(frame)  , id : frame.data('id') ,title : jQuery('#rad-template-title').val() },function(data){
      ioa_msg.setMessage('Saved','Template Has been saved !','success');
    ioa_msg.show();
    save_template.html('Save Template'); 

     });
    
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
        gl += "<li data-image='"+images[i].url+"' data-thumbnail='"+images[i].sizes.thumbnail.url+"' data-alt='"+images[i].alt+"' data-title='"+images[i].title+"' data-description='"+images[i].description+"' ><img src='"+images[i].sizes.thumbnail.url+"' /> <a class='close' href=''></a></li>";
        srcs +=  images[i].url+"[ioas]"+images[i].sizes.thumbnail.url+"[ioas]"+images[i].alt+"[ioas]"+images[i].title+"[ioas]"+images[i].description+";";
      }
      proxy_temp.parent().find('ul.rad_gallery_thumbs').append(gl); 
      
      temp = proxy_temp.parent().find('input');  
      temp.val(temp.val()+""+srcs);
    });

    
  }); 

doc.on('click', 'a.width-correction',function(e){
	e.preventDefault();
	temp = current_editing_obj.parents('.rad_page_container');
	if( temp.hasClass('senseBGModel') ) temp = temp.width() - 60;
	else 	temp = temp.width();
	
	jQuery(this).prev().val(temp);
});

doc.on('click','div.post-meta-panel a',function(e){
	e.preventDefault();
	temp = jQuery(this).attr('href');
	jQuery(this).parents('.ioa_input').find('input,textarea').insertAtCaret(temp);
	jQuery(this).parents('.ioa_input').find('input,textarea').trigger('keyup');
});
	

doc.on('click','.shortcode-extra-insert', function(e){
	e.preventDefault();
	jQuery(this).parents('.ioa_input').find('div.post-meta-panel').slideToggle('normal');
});

/**
 * Widget BASED Event Sections
 */
doc.on('click','.widget-edit',function(e){
    e.preventDefault();

    if(current_editing_obj)
   		maptoObj( current_editing_obj, lightbox.find('.'+lightbox.data('key')) );

    current_editing_obj =  jQuery(this).parents('.rad_page_widget');
    lightbox.data('key',current_editing_obj.data('key'));
    maptoLightbox( lightbox.find('.'+current_editing_obj.data('key')) ,current_editing_obj  );

    sapi.show();  
}); 

doc.on('click','.widget-clone',function(e){
    e.preventDefault();
    
    obj = jQuery(this).parents('.rad_page_widget');
    temp = obj.clone();
    temp.attr('id','rpw'+routines.uniqueid());

    obj.after(temp);
    temp.data('key',obj.data('key'));
    routines.selectOptionByText(temp.find('.widget_layout') ,obj.find('.widget_layout').val()); 
    routines.mapSettings(temp,obj);
    setTimeout(function(){ widget_prediction(temp.parents('.rad-inner-container')); },30);

    current_editing_obj =  temp;
    lightbox.data('key',current_editing_obj.data('key'));
    maptoLightbox( lightbox.find('.'+current_editing_obj.data('key')) ,current_editing_obj  );

    lightbox.find('.'+current_editing_obj.data('key')).find('.rad-styler .ioa_input').each(function(){

    	  temp = jQuery(this).find('input,select');
		  routines.generateVisualMap(temp , temp.attr('name') , temp.val()  );		

    });

    sapi.hide();

});


doc.on('click','.widget-delete',function(e){
    e.preventDefault();
    temp = jQuery(this).parents('.rad_page_widget');
    temp.remove();
    setTimeout(function(){ widget_prediction(temp.parents('.rad-inner-container')); },10);
    sapi.hide();
});

doc.on('keyup','.ioa_input textarea',function(){
	temp = jQuery(this);
	routines.generateVisualMap(temp , temp.attr('name') , temp.val()  );		

});

doc.on('rad_change','.ioa_input input',function(){
	temp = jQuery(this);

	routines.generateVisualMap(temp.parents('.ioa_input') , temp.parents('.ioa_input').data('property') , temp.val()  );		

});

doc.on('keyup','.ioa_input input',function(){
	temp = jQuery(this);
	routines.generateVisualMap(temp.parents('.ioa_input') , temp.parents('.ioa_input').data('property') , temp.val()  );			

});

doc.on('focusout','.ioa_input input',function(){
	temp = jQuery(this);
	routines.generateVisualMap(temp.parents('.ioa_input') , temp.parents('.ioa_input').data('property') , temp.val()  );		

});


doc.on('change','.ioa_input select',function(){
	temp = jQuery(this);
	routines.generateVisualMap(temp.parents('.ioa_input') , temp.parents('.ioa_input').data('property') , temp.val()  );			

});

rad_live_builder.getSettingsSidebar();

/**
 * Icon API =====================================================================================================
 */

var icon_canvas = '',icon_opts,icon_wrap='',icon_tabs;
var icon_obj;


doc.on('click','a.icon-maker',function(e){
    	e.preventDefault();
    	sicon_engine = jQuery(this);
  
	rl.show('Icons');
	jQuery.post(ajaxurl,{ type:'simple_icons', action: 'ioalistener' },function(data){
		rl.set(data,'simple_icons');
		
	});

    });

doc.on('click', 'ul.sicon-list li', function(e){
	jQuery('ul.sicon-list li').removeClass('active');
	jQuery(this).addClass('active');
	e.preventDefault();
});


var sclist = '';
 doc.on('keyup','.sicon-search-input',function(e){
     	query = jQuery(this).val().toLowerCase();
     	qar = query.split(' ');
     	qlen = 	qar[0].length;

     	if(rad_lightbox.find('div.rad-l-body').data('key') == 'simple_icons')
     		sclist = rad_lightbox.find('.sicon-list li');
     	else
     		sclist = rad_lightbox.find('.sc-icon-list li');


     	sclist.hide();
   		
   		if(qlen >= 2)
    	{
    			
	    		sclist.each(function(){
	    			test = []; temp = jQuery(this); fn = true;
	    			for(var i=0;i<qar.length;i++) {

	    				if( temp.children('i').attr('class').indexOf(qar[i]) != -1 )
	    					test[i] = true;
	    				else
	    					test[i] = false;

	    			}
	    			
	    			for(var i=0;i<test.length;i++) 	fn = fn && test[i];

	    			if(fn === true) jQuery(this).show();

	    		});

    		
    	}
    	else
    	{
    		sclist.show();
    	}

    });	

doc.on('click','#sc-icon-import',function(e){
		e.preventDefault();
		sc_oc =	jQuery(this);
		
		hmedia.open(sc_oc.data('title'),sc_oc.data('label'),function(images){ 
			icon_canvas.find('img').attr('src', images[0].url);
		});
	}); 
doc.on('click','a.add-rad-icon',function(e){
		e.preventDefault();

		icon_obj = jQuery(this);

		rl.show('Select Icon');
		jQuery.post(ioa_listener_url,{ type:'icons', action: 'ioalistener'},function(data){
			
			rl.set(data,'icons');
			jQuery('div.sc-tabbed-area').tabs({
				activate: function( event, ui ) {
					parent = ui.newPanel;
					icon_canvas = parent.find('div.icon-canvas');
					icon_opts = parent.find('div.icon-opts');
					icon_wrap = icon_canvas.find('span.icon-wrap');

				}


			});
		
			

			parent = jQuery('#foldericons');
			icon_canvas = parent.find('div.icon-canvas');
			icon_opts = parent.find('div.icon-opts');
			icon_wrap = icon_canvas.find('span.icon-wrap');

			var html_conv = jQuery(icon_obj.parents('div.ioa_input').find('input').val()) , val;
			setupIconPickers();


			if( html_conv.find('img').length > 0 )
			{
				jQuery('div.sc-tabbed-area').tabs({ active: 0 });
				icon_wrap.replaceWith(html_conv);
				icon_wrap = icon_canvas.find('span.icon-wrap');
				icon_opts.find('.ioa_input').each(function(){

					if( jQuery(this).data('element') == "parent" )
					{
						
						switch(jQuery(this).data('attr'))
						{
							case 'background' : 
							if(html_conv.css('background-color')!="") { 

								val = rgb2hex(html_conv.css('background-color'));
								jQuery(this).find('input[type=text]').minicolors("value",val).trigger('click');
							}
								 break;
							case 'border-radius' : jQuery(this).find('input').val(html_conv[0].style.borderTopLeftRadius); break;
							case 'border-color' :  
								if(html_conv.css('border-color')!="") {
									val = rgb2hex(html_conv.css('border-color'));
									jQuery(this).find('input[type=text]').minicolors("value",val).trigger('click');
								}
								 break;
							case 'padding-v' : jQuery(this).find('input').val(html_conv.css('padding-top')); break;
							case 'padding-h' : jQuery(this).find('input').val(html_conv.css('padding-left')); break;
							case 'opacity' : jQuery(this).find('input').val(html_conv.css('opacity')); break;


						}
						

					}
					else 
						{

							switch(jQuery(this).data('attr'))
							{
							
							
							case 'opacity' : jQuery(this).find('input').val(html_conv.find('img').css('opacity')); break;
							}	

						}

				});
			}
			else if( html_conv.find('i').length > 0 )
			{
				jQuery('div.sc-tabbed-area').tabs({ active: 1 });
				icon_wrap.replaceWith(html_conv);
				icon_wrap = icon_canvas.find('span.icon-wrap');
				icon_opts.find('.ioa_input').each(function(){

					if( jQuery(this).data('element') == "parent" )
					{
						
						switch(jQuery(this).data('attr'))
						{
							case 'background' :  
							if(html_conv.css('background-color')!="" && html_conv.css('background-color')!="rgba(0, 0, 0, 0)") { 
								val = rgb2hex(html_conv.css('background-color'));
								jQuery(this).find('input[type=text]').minicolors("value",val).trigger('click');
								 }
								 break;
							case 'border-radius' : jQuery(this).find('input').val(html_conv[0].style.borderTopLeftRadius); break;
							case 'border-color' :  
								if(html_conv.css('border-color')!="" && html_conv.css('border-color')!="rgba(0, 0, 0, 0)") {
									val = rgb2hex(html_conv.css('border-color'));
									jQuery(this).find('input[type=text]').minicolors("value",val).trigger('click');
								}
								 break;
							case 'padding-v' : jQuery(this).find('input').val(html_conv.css('padding-top')); break;
							case 'padding-h' : jQuery(this).find('input').val(html_conv.css('padding-left')); break;
							case 'opacity' : jQuery(this).find('input').val(html_conv.css('opacity')); break;


						}
						

					}
					else
						{

							switch(jQuery(this).data('attr'))
							{
							
						
							case 'opacity' : jQuery(this).find('input').val(html_conv.children('i').css('opacity')); break;
							case 'color' :  
								if(html_conv.css('color')!="") {
									val = rgb2hex(html_conv.css('color'));
									jQuery(this).find('input[type=text]').minicolors("value",val).trigger('click');
								}
								 break;
							case 'font-size' : 	 jQuery(this).find('input').val(html_conv.children('i').css('font-size')); break;
							}	

						}

				});

			}


			
		});
	});	


doc.on('click','div.preview_pane h3',function(){

		jQuery(this).next().slideToggle('normal');

	});

doc.on('click','ul.parent_dir>li>strong',function(){

		jQuery(this).parent().toggleClass('active').children('ul').slideToggle('normal');

	});
	
	doc.on('click','ul.child_list li',function(){
		temp = jQuery(this);

		
		if(temp.find('img').length > 0 )
		{
			icon_wrap.find('img').attr('src', temp.find('img').attr('src'));
		
			setTimeout(function(){
				icon_wrap.width(icon_canvas.find('img').width());
				icon_wrap.height(icon_canvas.find('img').height());
				
			},40)
		}
		else
		{
			icon_wrap.html( temp.find('i').clone());
		
			setTimeout(function(){
				if( icon_wrap.children('i').hasClass('entypo') )
				icon_wrap.find('i').css('line-height',parseInt(icon_canvas.find('i').css('font-size'))/2+"px");
				
				icon_opts.find('.icon_size').val(icon_canvas.find('i').css('font-size'));
				
			
			},40)
		}

	});

	
	function setupIconPickers()
	{
		jQuery('div.icon-opts .ioa-minicolors,div.image-opts .ioa-minicolors,div.bg-opts .ioa-minicolors').each(function(){

		jQuery(this).minicolors({
			textfield : true,

			opacity: true,
			change: function(hex, opacity) {
                     
                    jQuery(this).parent().next().val(opacity);    
               
                   if( jQuery(this).attr('id') == "icon_bg" ) icon_wrap.css('background',hex);
                   if( jQuery(this).attr('id') == "icon_brcolor" ) icon_wrap.css('border-color',hex);
                   if( jQuery(this).attr('id') == "icon_color" ) icon_wrap.css('color',hex);     
                   if( jQuery(this).attr('id') == "image_bg" ) image_wrap.children('div').css('background',hex);     
                   if( jQuery(this).attr('id') == "image_brcolor" ) image_wrap.css('border-color',hex);     
                   if( jQuery(this).attr('id') == "image_shcolor" ) 
                   {
                   		var bq = image_opts.find('.image_shh').val()+"px "+image_opts.find('.image_shv').val()+"px "+image_opts.find('.image_shb').val()+"px "+jQuery('#image_shcolor').val();	  
						image_wrap.children('div').css( "box-shadow" , bq  );
                   }
                   if( jQuery(this).attr('id') == "el_bg" ) 
                   {
                   		bg_el.css('background-color',hex);
                   }
                    if( jQuery(this).attr('id') == "ov_bg" ) 
                   {
                   		bg_overlay.css('background-color',hex);
                   }


                  

                    }

		});

		});
	}


	doc.on('change keyup','div.icon-opts input',function(){

		temp = jQuery(this).parents('div.ioa_input');
		var attr = temp.data('attr') ;
		var el = temp.data('element');
		
		if(el=="parent")
		{
			switch(attr)
			{
				case "padding-h" : icon_wrap.animate({ "padding-left" : jQuery(this).val() , "padding-right" : jQuery(this).val() },'normal'); break;
				case "padding-v" :icon_wrap.animate({ "padding-top" : jQuery(this).val() , "padding-bottom" : jQuery(this).val() },'normal'); break;
				case "opacity" : icon_wrap.animate({ "opacity" : jQuery(this).val()  },'normal'); break;
				case "border-width" : icon_wrap.animate({ "border-width" : jQuery(this).val()  },'normal'); break;
				case "border-radius" : icon_wrap.animate({ "border-radius" : jQuery(this).val()  },'normal'); break;
			}
		}
		if(el=="img")
		{
			switch(attr)
			{
				
				case "opacity" :icon_wrap.children('img').animate({ opacity : jQuery(this).val() },'normal'); break;
			}
		}
		if(el=="i")
		{
			switch(attr)
			{
				case "font-size" :  
				if( icon_wrap.children('i').hasClass('entypo') )
				icon_wrap.children('i').css("line-height",parseInt(jQuery(this).val())/2+"px");	
									icon_wrap.children('i').animate({ "font-size" : jQuery(this).val()  , width : jQuery(this).val() , height : jQuery(this).val()},'normal');
									icon_wrap.animate({ width : jQuery(this).val() , height : jQuery(this).val()},'normal');	
									
									break;
				case "opacity" :icon_wrap.children('i').animate({ opacity : jQuery(this).val() },'normal'); break;					 
				
			}
		}

	});


if(Modernizr.localstorage && Phantom.checkRegistry('rad_persist') )
		{
			
			if( Phantom.getRegistry('rad_persist') == 'yes')
			{
				jQuery('.persist-editor').addClass('is-persistant').html('Start on Click');
				jQuery('.trigger-live-editor').trigger('click');
			}
		}

function maptoObj(target,source)
{

   var str,s,te = [],inp,val;
      
   computeModuleData( source.find('div.ioa_module_container')  );

   source.find('.ioa_input').each(function(){
      inp = jQuery(this).find('input[type=text],textarea,select,input[type=checkbox]');
      val = inp.val();

      if( inp.is(':checkbox') )
      {
        str = '';
        jQuery(this).find('input[type=checkbox]').each(function(){

            if( jQuery(this).is(':checked') )
              str += jQuery(this).val()+';';
        });
        val = str;
      }

       if( jQuery(this).children('.ioa_input_holder').hasClass('editor') )
        {

           if( jQuery(this).find('.wp-editor-wrap').hasClass('html-active') ) {
                val  =  inp.val();
            } else {
                 val  = tinyMCE.get(inp.attr('id')).getContent();
            }

        }

        if( jQuery(this).hasClass('hidden-field') )
        {
          inp = jQuery(this).find('input[type=hidden]');
          val = inp.val(); 

        }

        te.push( { name :inp.attr('name') , value : val } );
        
   });

     rad_sections[target.attr('id')] =  te;

}

function getObjData(source)
{
 
   var str,s,te = [],inp,val;
      
   computeModuleData( source.find('div.ioa_module_container')  );

   source.find('.ioa_input').each(function(){
      inp = jQuery(this).find('input[type=text],textarea,select,input[type=checkbox]');
      val = inp.val();

      if( inp.is(':checkbox') )
      {
        str = '';
        jQuery(this).find('input[type=checkbox]').each(function(){

            if( jQuery(this).is(':checked') )
              str += jQuery(this).val()+';';
        });
        val = str;
      }

       if( jQuery(this).children('.ioa_input_holder').hasClass('editor') )
        {

           if( jQuery(this).find('.wp-editor-wrap').hasClass('html-active') ) {
                val  =  inp.val();
            } else {
                 val  = tinyMCE.get(inp.attr('id')).getContent();
            }

        }

        if( jQuery(this).hasClass('hidden-field') )
        {
          inp = jQuery(this).find('input[type=hidden]');
          val = inp.val(); 

        }

        te.push( { name :inp.attr('name') , value : val } );
        
   });

    return te;

}

function maptoLightbox(target,source)
{
  var settings_lightbox = jQuery('.settings-bar'),temp, te = { } ;
  RAD_CHANGE_FLAG = false;

  if(lightbox.data('key')=='rad_one_menu_widget')
    updateRADOnePageMenus();

  if(_.has(rad_sections,source.attr('id')))
   {
     te =  rad_sections[source.attr('id')];
      var test = {};
      
      for(var i=0;i<te.length;i++)
      {
          test[te[i].name] = te[i].value;
       }
    te = test;
   }
  
 
 if( lightbox.data('key') == 'rad_page_section') {
    lightbox.find('.rad_page_section').find('.sec-bg-listener').hide();
    switch( te.background_opts)
    {
      case 'bg-color' : lightbox.find('.rad_page_section').find('.bg-color').show(); break;
      case 'bg-image' : lightbox.find('.rad_page_section').find('.bg-image').show(); break;
      case 'bg-gr' : lightbox.find('.rad_page_section').find('.bg-gradient').show(); break;
      case 'bg-video' : lightbox.find('.rad_page_section').find('.bg-video').show(); break;
      case 'bg-texture' : lightbox.find('.rad_page_section').find('.bg-texture').show(); break;
      case 'custom'  : lightbox.find('.rad_page_section').find('.sec-bg-listener').show();  
                       lightbox.find('.rad_page_section').find('.bg-video,.bg-gradient').hide(); break;
    }
  }

if( lightbox.data('key') == 'rad_page_container') {
lightbox.find('.rad_page_container').find('.sec-bg-listener').hide();
    switch( te.background_opts)
    {
      case 'bg-color' : lightbox.find('.rad_page_container').find('.bg-color').show(); break;
      case 'bg-image' : lightbox.find('.rad_page_container').find('.bg-image').show(); break;
      case 'bg-gr' : lightbox.find('.rad_page_container').find('.bg-gradient').show(); break;
      case 'bg-video' : lightbox.find('.rad_page_container').find('.bg-video').show(); break;
      case 'bg-texture' : lightbox.find('.rad_page_container').find('.bg-texture').show(); break;
      case 'custom'  : lightbox.find('.rad_page_container').find('.sec-bg-listener').show();  
                       lightbox.find('.rad_page_container').find('.bg-video,.bg-gradient').hide(); break;
    }
 }


 target.find('.ui-tabs-panel').first().show();
 routines.selectOptionByText(target.find('.rad-panel-selector'),'');

  var val,inp,s;

  settings_lightbox.find('.inner-settings-body').children().hide();

  target.show();
  rad_live_builder.scroll_pane.reinitialise();	
  
  target.find('.custom-id').html( "ID - "+source.attr('id') );
  
  target.find('.ioa_input').each(function(){
       
       inp = jQuery(this).find('.ioa_input_holder').find('input[type=text],textarea,select,input[type=checkbox],input[type=hidden]');

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
          jQuery(this).find('input[value="'+s[i]+'"]').attr('checked','checked');
      }
      else
      {

        if(inp.hasClass('ioa-minicolors') && typeof s != "undefined" )
        {
          inp.minicolors("value",s);
        }
        else if( jQuery(this).children('.ioa_input_holder').hasClass('editor') )
        {

            if( jQuery(this).find('.wp-editor-wrap').hasClass('html-active')) {
              inp.val(s);
            } else {
               tinyMCE.get(inp.attr('id')).setContent(s);
            }
        }
        else
          inp.val(s);

     

        if( jQuery(this).find('.ioa_slider').length > 0 )
        {
           jQuery(this).find('.ioa_slider').slider( "value", s );
        }  

      }

      if( jQuery(this).find('.rad_gallery_thumbs').length > 0 )
      {

         s = te.gallery_images;
         var gl = '';
         var srcs = s.split(';'),gls;
         for(var i=0;i<srcs.length;i++)
         {
          if(srcs[i]!="")
          {
            gls = srcs[i].split("[ioas]");
          gl += "<li data-thumbnail='"+gls[1]+"' data-image='"+gls[0]+"' data-alt='"+gls[2]+"' data-title='"+gls[3]+"' data-description='"+gls[4]+"' ><img src='"+gls[1]+"' /> <a class='close' href=''></a></li>";
          
          }
         }

         jQuery(this).find('.rad_gallery_thumbs').html(gl);

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

   var tabs,testOldTab = false; 
 
  target.find('.ioa_module_container').each(function(){
      temp = jQuery(this);
      tabs = temp.find('.rad_tab').val();
       if(tabs.indexOf('titan_module') >= 0 )
      {
        testOldTab = true;
      }
      if(typeof tabs != "undefined")
      {
        if(testOldTab)
          tabs = tabs.split('<titan_module>');
         else 
        tabs = tabs.split('[ioa_mod]');
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
           if(testOldTab)
            tab = tab.split("<s>");
          else  
            tab = tab.split("[ioas]");

          list.append(clone);
          
          var h =0;
          while(h<tab.length)
          {
            
           
            if(tab[h]!="")
             {
            if(testOldTab)
            clone.find("."+tab[h].replace("<inp>","")).val(tab[h+1]);
            else   
            clone.find("."+tab[h].replace("[inp]","")).val(tab[h+1]);
             } 
            h= h+2;
          }

        }
      }

  });

  
  setTimeout(function(){

      target.find('.ioa_module_container').find('.ioa-minicolors').minicolors('destroy');
      target.find('.ioa_module_container').find('.ioa-minicolors').minicolors({
          textfield : true,
          opacity: false,
          change: function(hex, opacity) {
                     
                       jQuery(this).parent().next().val(opacity);    
                       jQuery(this).trigger('change');
                        
                    }
        });


      jQuery('.col_style').each(function(){
      
      temp = jQuery(this).parents('.ui-tabs-panel');
      
      if(jQuery(this).val() == 'image-box') temp.find('.image-box').show();
      else temp.find('.image-box').hide();

      });

      jQuery('.col_link').each(function(){
      
      temp = jQuery(this).parents('.ui-tabs-panel');
   
      temp.find('.ioa-link-filter').hide();
      temp.find('.ioa-link-filter.'+jQuery(this).val()).show();

      });


      },100);

  	RAD_CHANGE_FLAG = true;
}
 
 function htmlEntities(str) {
return String(str).replace(/\\'/g, '&amp;squot;').replace(/"/g, '&amp;quot;').replace(/'/g,"&amp;squot;").replace(/\[/g,"&amp;sqstart;").replace(/\]/g,"&amp;sqend;");
}

function prediction()
{
  var predict = 0 , ctemp,depth=0,stemp;
  frame.children('div').each(function(){
       predict = 0; depth=0;
       jQuery(this).removeClass('no-container');

      if( jQuery(this).find('.rad_page_container').length == 0 )  jQuery(this).addClass('no-container');
       
      jQuery(this).find('.rad_page_container').each(function(){
            ctemp = jQuery(this).removeClass('first last top no-widget');

            if(jQuery(this).find('.rad_page_widget').length == 0 ) jQuery(this).addClass('no-widget');

            if(predict == 0) ctemp.addClass('first');

            if(ctemp.hasClass('full')) predict += 100;
            if(ctemp.hasClass('three_fourth')) predict += 75;
            if(ctemp.hasClass('four_fifth')) predict += 80;
            if(ctemp.hasClass('two_third')) predict += 66;
            if(ctemp.hasClass('one_half')) predict += 50;
            if(ctemp.hasClass('one_third')) predict += 33;
            if(ctemp.hasClass('one_fourth')) predict += 25;
            if(ctemp.hasClass('one_fifth')) predict += 20;

            if(depth ==0) ctemp.addClass('top');

            if(predict >= 99)
            {
              ctemp.addClass('last');
              predict = 0;
              depth++;
            }  

      });

  });
}
function updateRADOnePageMenus()
{
   var rad_section_markup = '',name;
    frame.children('div').each(function(i){
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

function widget_prediction(parent)
{
  var predict = 0 , ctemp;
      parent.children('.rad_page_widget').each(function(){
            ctemp = jQuery(this).removeClass('first last');
            if(!ctemp.hasClass('auto'))
            {
                if(predict == 0) ctemp.addClass('first');

                if(ctemp.hasClass('full')) predict += 100;
                if(ctemp.hasClass('three_fourth')) predict += 75;
                if(ctemp.hasClass('four_fifth')) predict += 80;
                if(ctemp.hasClass('two_third')) predict += 66;
                if(ctemp.hasClass('one_half')) predict += 50;
                if(ctemp.hasClass('one_third')) predict += 33;
                if(ctemp.hasClass('one_fourth')) predict += 25;
                if(ctemp.hasClass('one_fifth')) predict += 20;

                if(predict >= 99)
                {
                  ctemp.addClass('last');
                  predict = 0;
                }  
            }

      });
}


});

// === Extra Utils =========

jQuery.fn.extend({
insertAtCaret: function(myValue){
  return this.each(function(i) {
    if (document.selection) {
      //For browsers like Internet Explorer
      this.focus();
      sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();
    }
    else if (this.selectionStart || this.selectionStart == '0') {
      //For browsers like Firefox and Webkit based
      var startPos = this.selectionStart;
      var endPos = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;
    } else {
      this.value += myValue;
      this.focus();
    }
  })
}
});
var hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 
function rgb2hex(rgb) {
 
if(  rgb =="transparent" || jQuery.trim(rgb) == "" || !rgb ) return "";

 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

 if(!rgb) return 'transparent';
 return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
 }