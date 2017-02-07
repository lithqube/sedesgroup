/**
 * @description : Main file for Framework inputs / media api / widgets
 * @version : 1.0
 * @author Abhin Sharma [WPioas]
 */

jQuery(document).ready(function(){
   
   jQuery('#subtitlewrap').insertAfter('#titlewrap');

});

var DEBUGMODE = true,ioa_msg;
var utils = {

	debug : function(message) {

   			 if (window.console && window.console.log  && DEBUGMODE )
      			 window.console.log('~~ IOA Debug Mode: ' + message);
  		}
}

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


var zipFrame = null , zmedia = {

		init : function(title){
			

	  			zipFrame = wp.media({
						
						title:  title,
				 		multiple : true,
						library:   {
						type: 'application/zip'
						}
						
						});

	  		

		},

	    open : function(title,button_label,callback) {
	    	zmedia.init(title);
	    	zipFrame.on( 'toolbar:render:select', function( view ) {
				view.set({
					select: {
						style: 'primary',
						text:  button_label,

						click: function() {
							
							var attachment = zipFrame.state().get('selection'),
							models = attachment.models , zips = [];
							
							jQuery(models).each(function(i){ 
							
				
				 			zips[i] = this.attributes;
							
					  
							
							});
							
							zipFrame.close();
							callback(zips);
						}
					}
				});
			});
			zipFrame.setState('library').open();

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

String.prototype.replaceAll = function(token, newToken, ignoreCase) {
    var str, i = -1, _token;
    if((str = this.toString()) && typeof token === "string") {
        _token = ignoreCase === true? token.toLowerCase() : undefined;
        while((i = (
            _token !== undefined? 
                str.toLowerCase().indexOf(
                            _token, 
                            i >= 0? i + newToken.length : 0
                ) : str.indexOf(
                            token,
                            i >= 0? i + newToken.length : 0
                )
        )) !== -1 ) {
            str = str.substring(0, i)
                    .concat(newToken)
                    .concat(str.substring(i + token.length));
        }
    }
return str;
};


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

jQuery(function(){

	var inside = jQuery('#edit-slug-box');
	if(jQuery.trim(inside.html())=="") inside.remove();


});

jQuery(document).ready(function(){

var doc = jQuery(document) , ioa_wrap = jQuery('.ioa_wrap ');
var win = {
    obj : jQuery(window),
    width : null,
    height : null

},
responsive = {

    ratio : 1 ,
    width : 1060,
    height : 600 ,
    platform : 'web',
    getPlatform : function()
    {

    }

};


ioa_msg = {
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
		ioa_msg.msg_block.hide();
		ioa_msg.msg_block.fadeIn('normal');
        		setTimeout(function(){ ioa_msg.msg_block.fadeOut('fast'); },3000);

	},

	showStatic : function(){
		ioa_msg.msg_block.hide();
		ioa_msg.msg_block.fadeIn('normal');
	},

	hide : function(){
		 ioa_msg.msg_block.fadeOut('fast'); 
	}

	};

jQuery('.clear-switch').click(function(){ jQuery(this).prev().val(''); });	
	
if( jQuery('#concave_editor').length > 0 )
var myCodeMirror = CodeMirror.fromTextArea(jQuery('#concave_editor')[0],{
	lineNumbers : true
});

win.width = win.obj.width();
win.height = win.obj.height();
/**
 * Codes to be executed first
 */

win.obj.ready(function(){

	jQuery('.en_gloss').fadeOut('fast');
});



jQuery('.ioa-title-lightbox-tabs ,.ioa-page-lightbox-tabs , .ioa-tabs, .ioa-custom_post-lightbox-tabs').tabs();


function setupIOAStage()
{
	jQuery('.ioa_sidenav_wrap,#option-panel-tabs').css( "min-height" , ( win.height-120)+"px" );
}
	

if( jQuery('.fullscreen').length > 0 )
{
	setupIOAStage();
}
win.obj.resize(function(){
	
	win.width = win.obj.width();
	win.height = win.obj.height();

	setupIOAStage();
});

/**
 * Personalization Code
 */

function increase_brightness(hex, percent){
    var r = parseInt(hex.substr(1, 2), 16),
        g = parseInt(hex.substr(3, 2), 16),
        b = parseInt(hex.substr(5, 2), 16);

   return '#' +
       ((0|(1<<8) + r * (100 - percent) / 100).toString(16)).substr(1) +
       ((0|(1<<8) + g * (100 - percent) / 100).toString(16)).substr(1) +
       ((0|(1<<8) + b * (100 - percent) / 100).toString(16)).substr(1);
}

if( jQuery('.portfolio_override').val() == "true" ) jQuery('.pt-filter').show();

jQuery('.portfolio_override').change(function(){

	if( jQuery(this).val() == "true" ) jQuery('.pt-filter').show();
	else jQuery('.pt-filter').hide();

});


if( jQuery('.blog_override').val() == "true" ) jQuery('.bt-filter').show();

jQuery('.blog_override').change(function(){

	if( jQuery(this).val() == "true" ) jQuery('.bt-filter').show();
	else jQuery('.bt-filter').hide();

});


/**
 * Icon API =====================================================================================================
 */

var icon_canvas = '',icon_opts,icon_wrap='',icon_tabs,thumb;
var icon_obj;


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
	
	

/**
	  *  ============= Header Constructor Code ===========================================================================
	  */

	  doc.on('click','.delete-hcon',function(e){
	e.preventDefault();
	jQuery(this).parent().remove();
});
	 
	jQuery('.hcon-widget .container_height').focusout(function(){

		if( ! jQuery.isNumeric(jQuery(this).val()) ) jQuery(this).addClass('error');
		else jQuery(this).removeClass('error');

	}); 
	
	if(jQuery('div.hcon-widget-body').length >0 ) {

	 var block = jQuery('div.hide div.hcon-block ').clone();
	var url = jQuery('div.hcon-head').data('url');
	
	//jQuery('div.hcon-main-body').sortable();
	jQuery('div.hcon-widget-body').find('div.container').sortable();


	
	jQuery('div.hcon-widget-body').children('div').droppable({
		accept: "li,div.hcon-block",
      drop: function( event, ui ) {
       	

       	var el = ui.draggable.data('val');
       
       	temp = block.clone();
       	
       	temp.data('margin',ui.draggable.data('margin'));
		temp.data('align',ui.draggable.data('align'));
		temp.data('text',ui.draggable.data('text'));
       	
       	jQuery(this).children('div.container').append(temp.html( ui.draggable.html()));


       	temp.parent().sortable();
       	temp.data('val',el).addClass(el);

       	if(!ui.draggable.is('li'))
       	ui.draggable.remove(); 
      
       	jQuery(this).find('div.visual-ui').stop(true,true).animate({ opacity:0},'fast');

       	

      },
      over: function( event, ui ) { jQuery(this).find('div.visual-ui').stop(true,true).animate({ opacity:1},'fast'); } ,
      out: function( event, ui ) { jQuery(this).find('div.visual-ui').stop(true,true).animate({ opacity:0},'fast'); }
    });
	jQuery('#hcon-comps li').draggable({ helper: "clone" });

	

 var saveheaderdata =  jQuery('.save-header-data')
 var deleteheaderdata = jQuery('.delete-header-data');
 deleteheaderdata.click(function(e){

 	if( jQuery('.custom_head_data').length > 0 ) 
    	{
    		var id = jQuery('.custom_head_data').data('id');
    		jQuery.post( jQuery('#backend_link').attr('href') ,{ type : 'delheadercons' , id : id , action: 'ioalistener'},function(data){
    			ioa_msg.show(); loader.hide(); deleteheaderdata.html('Reseting'); setTimeout(function(){ deleteheaderdata.html('Reset'); },800);
    		});	
    		e.preventDefault();
    	}

 });





    saveheaderdata.click(function(e){
    	var unused_list = [];
    	var layouts = []; loader.show();
    	ioa_msg.setMessage('Header Settings Saved !');
    	
    	saveheaderdata.html('Saving');
    	jQuery('#hcon-comps li').each(function(i){
    		unused_list[i] = { name : jQuery(this).html() , value : jQuery(this).data('val'), text : jQuery(this).data('text')  , align : jQuery(this).data('align') , margin : jQuery(this).data('margin')}; 
    	});

    	jQuery('div.hcon-widget').each(function(i){
    		temp = [];
    		jQuery(this).find('div.hcon-widget-body').children('div').each(function(j){
    			var els = [];
    			jQuery(this).children('div.container').children().each(function(k){
    				els[k] =  { val : jQuery(this).data('val') , align : jQuery(this).data('align') , text : jQuery(this).data('text') , link : jQuery(this).data('link')  , margin : jQuery(this).data('margin') , name : jQuery(this).text() }
    			})
    			temp[j] = { align : jQuery(this).data('align') , elements : els }
    		});
    		layouts[i] = { 'container' : jQuery(this).data('val') ,'eye' : jQuery(this).data('eye') ,'position' : jQuery(this).data('position'),'height' : jQuery(this).find('.container_height').val() ,  data : temp } ;

    	})
    	var  id = 'general';
    	if( jQuery('.custom_head_data').length > 0 ) 
    	{
    		id = jQuery('.custom_head_data').data('id');
    		jQuery.post( jQuery('#backend_link').attr('href') ,{ type : 'headercons' , action: 'ioalistener', unused_list : unused_list , layout : layouts, id : id },function(data){
    			ioa_msg.show(); loader.hide(); saveheaderdata.html('Saved'); setTimeout(function(){ saveheaderdata.html('Save'); },800);
    		});	
    	}
    	else
    	{
    		jQuery.post(url,{ unused_list : unused_list , action: 'ioalistener', layout : layouts, save_data : true },function(data){
    			ioa_msg.show(); loader.hide(); saveheaderdata.html('Saved'); setTimeout(function(){ saveheaderdata.html('Save'); },800);
    		});
    	}	
    	


    	e.preventDefault();
    });

    jQuery('div.hcon-widget-body a.pin').click(function(e){
    	
    	if(!jQuery(this).hasClass('active')) {
    		jQuery(this).addClass('active');
    		jQuery(this).parents('div.hcon-widget').data('position','fixed');
    	}
    	else
    	{
    		jQuery(this).removeClass('active');
			jQuery(this).parents('div.hcon-widget').data('position','static');
   		}
    	e.preventDefault();
	});


	jQuery('div.hcon-widget-body a.eye').click(function(e){
    	
    	if(!jQuery(this).hasClass('active')) {
    		jQuery(this).addClass('active');
    		jQuery(this).parents('div.hcon-widget').data('eye','on');
    	}
    	else
    	{
    		jQuery(this).removeClass('active');
			jQuery(this).parents('div.hcon-widget').data('eye','off');
   		}
    	e.preventDefault();
	});
  
var hcon_parent;
  doc.on('click','a.hcon-edit',function(e){
  	e.preventDefault();
  	rl.set(jQuery('.honc-widgets-settings').html(),'hcon');
  	rl.show('Edit Options');	
  	var link = 'false', text = '';
  	hcon_parent = jQuery(this).parent();

  	if( jQuery(this).parent().data('val') == "text" )
  	{
  		rad_lightbox.find('.text-block').removeClass('hide');
  		text = hcon_parent.data('text');
  		jQuery('.hcon_w_txt').val(text);
  	} 
  	else if( jQuery(this).parent().data('val') == "social" )
  	{
  		 
  		rad_lightbox.find('.social-block').removeClass('hide');
  		text = hcon_parent.data('text');
  		
  		if(hcon_parent.data('link')!="")
  		link = hcon_parent.data('link');

  		jQuery('.hcon_s_w option[value='+link+']').attr('selected','selected');

  		if( typeof text !="undefined" && text!="")
  		{
  			var coll = [];
  			text = text.split('<sc>');
  			for(var i=0;i<text.length-1;i++)
  			{
  				var t = text[i].split('<vc>');

  				rad_lightbox.find('input[value='+t[0]+']').attr('checked','checked');

  				var v = t[1];
 				var t = "hcon_"+t[0];

  				t = rad_lightbox.find('input.'+t+'');
  				t.val(v);
  				t.parent().parent().show();
  				
  				
  				

  			}

  			
  		}

  	}

  	
  	var t = hcon_parent.data('margin');
  	var al = hcon_parent.data('align');
  	

  	jQuery('.hcon_w_align option[value='+al+']').attr('selected','selected');

  	t = t.split(':');

  	jQuery('.hcon_w_tm').val(t[0]);
  	jQuery('.hcon_w_rm').val(t[1]);
  	jQuery('.hcon_w_bm').val(t[2]);
  	jQuery('.hcon_w_lm').val(t[3]);
  	
  	


  });

  doc.on('click','div.social-block input[type=checkbox]',function(){

  	if(jQuery(this).is(":checked"))
  	{
  		rad_lightbox.find('input[name=hcon_'+jQuery(this).val()+']').parents('.ioa_input').show(); 
  	}
  	else rad_lightbox.find('input[name=hcon_'+jQuery(this).val()+']').parents('.ioa_input').hide();


  });
}

/**
 * Page Builder Code
 */

/**
 * IOA Custom Template
 */

jQuery('.ioa-template li').click(function(){
	jQuery('.ioa-template li').removeClass('active');
	jQuery('.ioa_custom_template').val(jQuery(this).data('tmp'));
	jQuery(this).addClass('active');
});

 jQuery('#ioa_custom_code').tabs();

if( jQuery('#ioa_title_area').length > 0 ) {


jQuery('#ioa_title_area').accordion({
      heightStyle: "content"
    });
}


jQuery('.ioa-portfolio-template li.'+jQuery('.single_portfolio_template').val()).addClass('active');

if( jQuery('div.ioa-tour-overlay').length > 0 )
{

	jQuery('div.ioa-tour-lightbox').css({  left: jQuery(window).width()/2 - 875/2 , top :   jQuery(window).height()/2 - 620/2 });
	jQuery('div.ioa-tour-lightbox a.cross').click(function(e){
		jQuery('div.ioa-tour-lightbox').animate({ top: - jQuery(window).height() },'normal',function(){
			jQuery('div.ioa-tour-overlay').fadeOut('fast');
		});
		
		e.preventDefault();
	});
}	

/**
 * Title Area API
 */

var title_bg_watch = jQuery('#ioa_background_opts') , titlebg_panel = jQuery('.ioa-title-lightbox-tabs') ; 

titlebg_panel.find('.ioa-title-filter').hide();
titlebg_panel.find('.ioa-title-filter.'+title_bg_watch.val()+"").show(); 

title_bg_watch.change(function(){
	
		titlebg_panel.find('.ioa-title-filter').hide();
		titlebg_panel.find('.ioa-title-filter.'+title_bg_watch.val()+"").show(); 

});


/**
 * Featured Media API
 */

var featured_media_watch = jQuery('#featured_media_type') , featured_panel = jQuery('#ioa_featured_media') ; 

featured_panel.find('.ioa-media-filterable').hide();
featured_panel.find('.ioa-media-filterable.'+featured_media_watch.val()+"").show(); 

featured_media_watch.change(function(){

		featured_panel.find('.ioa-media-filterable').hide();
		featured_panel.find('.ioa-media-filterable.'+featured_media_watch.val()+"").show(); 

});

/**
 * Page Title API
 */

var title_lightbox = jQuery('.ioa-title-lightbox,.ioa-title-overlay');

jQuery('.ioa-title-lightbox-head .ioa-front-icon').click(function(e){
	e.preventDefault();
	title_lightbox.fadeOut('fast');
});

jQuery('.ioa-title-settings-trigger').click(function(e){
	e.preventDefault();
	title_lightbox.fadeIn('normal');
});

var ptitle = jQuery('#title'), title_tip = jQuery('.ioa-title-edit-wrap .ioa-tooltip');
ptitle.focusin(function(){
	title_tip.fadeIn('normal');
});
ptitle.focusout(function(){
	title_tip.fadeOut('normal');
});

jQuery('.ioa-title-settings-trigger').hover(function(){
	title_tip.fadeIn('normal');
},function(){
	title_tip.fadeOut('normal');
});


/**
 * Page  API
 */

var page_lightbox = jQuery('.ioa-page-lightbox,.ioa-page-overlay');

jQuery('.ioa-page-lightbox-head .ioa-front-icon').click(function(e){
	e.preventDefault();
	page_lightbox.fadeOut('fast');
});

jQuery('.ioa-page-settings').click(function(e){
	e.preventDefault();
	page_lightbox.fadeIn('normal');
});

var ppage = jQuery('#page'), page_tip = jQuery('.ioa-page-edit-wrap .ioa-tooltip');
ppage.focusin(function(){
	page_tip.fadeIn('normal');
});
ppage.focusout(function(){
	page_tip.fadeOut('normal');
});


/**
 * Custom Post  API
 */

var custom_post_lightbox = jQuery('.ioa-custom_post-lightbox,.ioa-custom_post-overlay');

jQuery('.ioa-custom_post-lightbox-head .ioa-front-icon').click(function(e){
	e.preventDefault();
	custom_post_lightbox.fadeOut('fast');
});
var cpin = -1 , post_tabs = jQuery('.ioa-custom_post-lightbox-tabs'), template_selector = jQuery('#ioa-page-template');

if( template_selector.length > 0 ) {


if( template_selector.val().indexOf('blog') >= 0 || template_selector.val().indexOf('portfolio') >= 0 ||  template_selector.val().indexOf('custom-post') >= 0  ||  template_selector.val().indexOf('contact') >= 0 )
{
	jQuery('.set-template-settings-wrap').show();
}
else
	jQuery('.set-template-settings-wrap').hide();

jQuery('.set-template-settings').click(function(e){
	e.preventDefault();
	
	post_tabs.find('ul.ui-tabs-nav li').addClass('ui-state-disabled');	

	if( template_selector.val().indexOf('blog') >= 0 )
	{
		cpin =1; 
	}
	else if( template_selector.val().indexOf('portfolio') >= 0 )
	{
		cpin =0; 
	}
	else if( template_selector.val().indexOf('custom-post') >= 0 )
	{
		cpin =2; 
	}

	post_tabs.find('ul.ui-tabs-nav li').eq(cpin).removeClass('ui-state-disabled');	
	post_tabs.tabs( "option", "active", cpin  );

	custom_post_lightbox.fadeIn('normal');
});

template_selector.change(function(){

	if( template_selector.val().indexOf('blog') >= 0 || template_selector.val().indexOf('portfolio') >= 0 ||  template_selector.val().indexOf('custom-post') >= 0 )
	{
		jQuery('.set-template-settings-wrap').show();
	}
	else
		jQuery('.set-template-settings-wrap').hide();

});

var pcustom_post = jQuery('#custom_post'), custom_post_tip = jQuery('.ioa-custom_post-edit-wrap .ioa-tooltip');
pcustom_post.focusin(function(){
	custom_post_tip.fadeIn('normal');
});
pcustom_post.focusout(function(){
	custom_post_tip.fadeOut('normal');
});

}
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
/* ============================================ */

	


	var loader = {
		obj  : jQuery('span.waiting'),
		show : function() { loader.obj.fadeIn('normal');  },
		hide : function() { loader.obj.stop(true,true).fadeOut('fast');  }
	}



var hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 

//Function to convert hex format to a rgb color
function rgb2hex(rgb) {
 
if(  rgb =="transparent" || jQuery.trim(rgb) == "" || !rgb ) return "";

 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

 if(!rgb) return 'transparent';
 return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
 }
	var obj,temp,i,j;
    var version = parseFloat(jQuery('#wp_version').attr('href')) , query_engine, sicon_engine ,panes = [];
    var SN = jQuery('#option-panel-tabs').data('shortname');
    var icon_canvas = '',icon_opts,icon_wrap='',icon_tabs;
    var image_canvas, image_opts,image_wrap, rad_image_obj;
    var icon_obj;
    var options_panel = jQuery( ".option-panel-tabs" ) , inputs = options_panel.find('.ioa_input');

    jQuery('#options-search').focusin(function(){
	
	jQuery('body').addClass('ioa-panel-search-start');

	jQuery('.ioa-search-icon').hide();
	options_panel.tabs( "destroy" );	

	jQuery('div.ioa_options div.subpanel').tabs( "destroy" );

	options_panel.addClass('ioa-search-mode');
	
	jQuery('.search-close-wrap').fadeIn('normal');
	inputs.hide();

});

jQuery('#options-search').focusout(function(){ loader.hide(); });

jQuery('.close-options-search').click(function(e){
	e.preventDefault();
	inputs.show();
	
	
	options_panel.removeClass('ioa-search-mode');
	
	jQuery('div.ioa_options div.subpanel').tabs();
	options_panel.tabs();


	jQuery('.search-close-wrap').fadeOut('normal',function(){
		jQuery('.ioa-search-icon').show();
		jQuery('#options-search').val('');
	});

	jQuery('body').removeClass('ioa-panel-search-start');

});

var query , qlen , test ,qar , fn ;
    jQuery('#options-search').keyup(function(e){
     	query = jQuery(this).val().toLowerCase();
     	qar = query.split(' ');
     	qlen = 	qar[0].length;

     	inputs.hide();
   		
   		if(qlen >= 2)
    	{
    			
	    		inputs.each(function(){
	    			test = []; temp = jQuery(this); fn = true;
	    			for(var i=0;i<qar.length;i++) {

	    				if( typeof temp.data('label') !='undefined' &&  temp.data('label').indexOf(qar[i]) != -1 )
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
    		inputs.hide();
    	}

    });	


/**
 * Shortcode Engine
 */
var shortcode_lightbox = jQuery('div.shortcode-lightbox'), doc_pane = jQuery('div.preview-doc-pane');
doc.on('click', 'ul.top-shortcodes-menu li',function(){
	jQuery('.shortcode-help-desk').children().hide();
	jQuery('ul.top-shortcodes-menu li').removeClass('active');
	jQuery(this).addClass('active');
	jQuery('div.shortcodes-desc-area > div').hide();
	jQuery('#'+jQuery(this).data('id')).show(); 
	jQuery('.ex-shortcode-mods').hide();	
});

doc.on('click', 'a.info_shortcode',function(e){
	e.preventDefault();
	
	var attr = jQuery(this).parent().find('select').val();
	jQuery('.shortcode-help-desk').children().hide();
	jQuery('.shortcode-help-desk').find("."+attr).show();
});

doc.on('click', 'div.shortcode-l-head a',function(e){
	e.preventDefault();
	shortcode_lightbox.fadeOut('fast');
});

shortcode_lightbox.css({ left: jQuery(window).width()/2 - 700/2 , top: jQuery(window).height()/2 - 650/2 })

if(shortcode_lightbox.length > 0)
shortcode_lightbox.draggable({
	handle: ".shortcode-l-head"
});


doc.on('change','.select_shortcode',  function(e){
	e.preventDefault();

		var attr = jQuery(this).val();

		jQuery('.ex-shortcode-mods').hide();
		
		jQuery('#'+attr).show();
		doc_pane.hide();
		
		if(jQuery('#'+attr).length == 0) {

		temp = jQuery('.shortcode-help-desk').find("."+attr).find('span.syntax').html();
		
			if( jQuery('#content').is(':visible') ) {
			    jQuery('#content').insertAtCaret(temp);
			} else {
			    tinyMCE.activeEditor.selection.setContent(temp);    
			}
		 
		 }


});


doc.on('click','div.column-maker-area i',  function(e){
	
	jQuery(this).parent().remove();
});

doc.on('click',  '#column-maker-insert',function(e){ 
	e.preventDefault();
	var data = jQuery('div.column-maker-area').clone();
	
	data.find('i').remove();

	if( jQuery('#content').is(':visible') ) {
			    jQuery('#content').insertAtCaret("<div class='clearfix'>"+jQuery.trim(data.html())+"</div> &nbsp;");
	} else {
	    tinyMCE.activeEditor.selection.setContent("<div class='clearfix'>"+jQuery.trim(data.html())+"</div> &nbsp;");    
	}	
	jQuery('div.column-maker-area').html('');
});

jQuery('.ioa-admin-menu-wrap').hover(function(){
	jQuery(this).find('ul').stop(true,true).fadeIn('fast');
},function(){
	jQuery(this).find('ul').fadeOut('fast');
});


jQuery('.close-ioa-import-lightbox').click(function(e){
	e.preventDefault();
	jQuery('.ioa-import-lightbox').fadeOut('fast');
});

jQuery('.ioa-import-lightbox-trigger').click(function(e){
	e.preventDefault();
	jQuery('.ioa-import-lightbox').fadeIn('fast');
});


doc.on('click', 'a.add-mod-shortcode',function(e){
	e.preventDefault();


	var te=jQuery(this),id = jQuery(this).parents('div.ex-shortcode-mods').attr('id');
	var val,t,regex,sh = jQuery('.'+id).find('.syntax').html();
    var hidden = te.parent().find("#mod_data"),params='';
    

    
    if(hidden.length >0 )
    {
    	 te.parent().find('.parent_val').each(function(){
    	params += jQuery(this).data("value")+"='"+jQuery(this).find('input,select').val()+"' ";
    	
    });
    	 
    	var s,t,cols = hidden.val().split('[ioa_mod]'),code='',sdata='',applier=te.data('applier'),parent=te.data('parent');

    	
	 	for(var i=0;i<cols.length;i++)
	 	{
	 		if(cols[i]!="")
	 		{
	 			code += "["+applier+" ";
		 		t = cols[i].split("[inp]");
		 		
		 		for(var j=0;j<t.length;j++)
		 		{
		 			if(t[j]!="")
		 			{
		 				 s = t[j].split('[ioas]');
		 				 if(s[0]!="scontent" && s[1]!="")
	 				 		code += s[0]+"='"+s[1]+"' ";
	 				 	else
	 				 		sdata = s[1];


		 			}	
		 		}
		 		code += "]"+sdata+"[/"+applier+"]";
	 		}
	 	}
	 	if( jQuery('#content').is(':visible') ) {
			    jQuery('#content').insertAtCaret("["+parent+" "+params+"]"+code+"[/"+parent+"]");
		} else {
		    tinyMCE.activeEditor.selection.setContent("["+parent+" "+params+"]"+code+"[/"+parent+"]");  
	   		tinyMCE.activeEditor.onChange.dispatch();  
		    
		}

    	return;
    }	

    var content = te.parent().find('.shortcodes_content_holder').val(); 

    regex = new RegExp('\\](.*?)\\[',"g");
	sh = sh.replace(regex, "]"+content+"[");

	jQuery(this).parent().find('div.ioa_input').each(function(){

		val = jQuery(this).find('.shortcodes_val_holder').val();
		t = jQuery(this).data('value');
		regex = new RegExp(t+'="(.*?)"',"g");
		if(jQuery.trim(val)!="")
			sh = sh.replace(regex, t+'="'+val+'" ');
		else
			sh = sh.replace(regex, '');
		
	});

	if( jQuery('#content').is(':visible') ) {
			    jQuery('#content').insertAtCaret(sh);
	} else {
	    tinyMCE.activeEditor.selection.setContent(sh);   
	    tinyMCE.activeEditor.onChange.dispatch();  
	}
})

	function initCustomInputs()
	{
		/**
	 * Colorpicker for the framework with RGBA support
	 */
	jQuery('.ioa-minicolors').each(function(){
		obool = jQuery(this).data('opacity');
		
		jQuery(this).minicolors({
			textfield : true,

			opacity: false,
			change: function(hex, opacity) {
                     
                     jQuery(this).parent().next().val(opacity);    
                     jQuery(this).parent().next().trigger('rad_change');
                        
                    },
            hide: function(hex, opacity) {
                     
                     jQuery(this).trigger('mini-hidden');
                        
                    },        

		});

	});

	/**
	 * Slider Input Support for the framework
	 */
	

	jQuery( ".ioa_input .ioa_slider" ).each(function(){
		temp = jQuery(this),obj  =temp.parent().find("input");
		temp1 = obj.val();
		if(jQuery.trim(temp1) == "") temp1 = 0;
		//console.log(temp1+"test");
		temp.slider({
				value: parseInt(temp1),
				min: 0, range: "min",
				max:  parseInt(obj.data('max')),
				step : parseInt(obj.data('steps')),
				slide: function( event, ui ) {
					jQuery(this).parent().find("input").val(ui.value);
				}
			});
		
		});
	}
	 initCustomInputs();
	/**
	 * Add custom sidebar
	 */

	
	


	/**
	 * Framework MEDIA Api
	 */
	
	


	doc.on('click','a.picker-delete',function(e){
		e.preventDefault();
		jQuery(this).parent().find('.minicolors-input').minicolors('value',' ');
		jQuery(this).parent().find('span.minicolors-swatch >span').css('background','transparent');
		
		});
 	
	if( jQuery('div.ioa-image-area').length > 0 )
 	jQuery('div.ioa-image-area').sortable({

 		stop: function( event, ui ) {

 			var gl = '';
			var srcs = '';
			jQuery('div.ioa-image-area').children().each(function()
			{
				
				srcs +=  jQuery(this).data('img')+"<gl>"+jQuery(this).data('thumbnail')+"<gl>"+jQuery(this).data('alt')+"<gl>"+jQuery(this).data('title')+"<gl>"+jQuery(this).data('description')+";";
			
 			});
			
 			jQuery('#ioa_gallery_data').val(srcs);

		}

 	});
  	var parent;
  	doc.on('click','div.ioa-gallery-item a',function(e){
  		e.preventDefault();
  		jQuery(this).parent().remove();

  		var gl = '';
			var srcs = '';
			jQuery('div.ioa-image-area').children().each(function()
			{
				
				srcs +=  jQuery(this).data('img')+"<gl>"+jQuery(this).data('thumbnail')+"<gl>"+jQuery(this).data('alt')+"<gl>"+jQuery(this).data('title')+"<gl>"+jQuery(this).data('description')+";";
			
 			});
			
 			jQuery('#ioa_gallery_data').val(srcs);

  	});

  	doc.on('mouseover','.ioa-gallery-item',function(){
  		jQuery(this).children('a').fadeIn('fast');
  	});

  	doc.on('mouseleave','.ioa-gallery-item',function(){
  		jQuery(this).children('a').stop(true,true).fadeOut('fast');
  	});

 	jQuery('a.post-ioa-images-generator').click(function(e){
 		e.preventDefault();
		temp =	jQuery(this);

		hmedia.open(temp.data('title'),temp.data('label'),function(images){ 
		

			var gl = '',thumb ='';
			var srcs = temp.parent().find('input').val();
			for(var i=0;i<images.length;i++)
			{
				if( typeof images[i].sizes.thumbnail != 'undefined' )
					thumb = images[i].sizes.thumbnail.url;
				else
					thumb = images[i].sizes.full.url;


				gl += "<div class='ioa-gallery-item' data-img='"+images[i].url+"' data-thumbnail='"+thumb+"' data-alt='"+images[i].alt+"' data-title='"+images[i].title+"' data-description='"+images[i].description+"' ><img src='"+thumb+"' /> <a class='close  ioa-front-icon  cancel-2icon- ' href=''></a></div>";
				srcs +=  images[i].url+"<gl>"+thumb+"<gl>"+images[i].alt+"<gl>"+images[i].title+"<gl>"+images[i].description+";";
			}
			temp.parent().find('.ioa-image-area').append(gl); 
			temp.parent().find('input').val(srcs);

		});


 	});

 	

	doc.on('click','.image_upload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		hmedia.open(temp.data('title'),temp.data('label'),function(images){ 
		

			temp.next().val(images[0].url); 
			
			if(jQuery('.mediamanager').length > 0)
			{
				if( typeof images[0].sizes.thumbnail != 'undefined' )
					thumb = images[0].sizes.thumbnail.url;
				else
					thumb = images[0].sizes.full.url;

				temp.parents('.inner-body-wrap').find('.thumbnail').val(thumb);
				temp.parents('.media-slide').find('img').attr("src",thumb);
			}
			obj = temp.parent().parent().find('div.input-image-preview').show().find('img');	
			obj.attr('src',images[0].url);
			temp.next().trigger('change');

			if(temp.next().attr('id')== SN+"_logo")
			{
			  jQuery("."+SN+'_logo_width').val(images[0].width);
			  jQuery("."+SN+'_logo_height').val(images[0].height);
			}

			temp.parents('.ex-shortcode-mods').find('._width').val(images[0].width);
			temp.parents('.ex-shortcode-mods').find('._height').val(images[0].height);

			


		});

		
	});

	doc.on('click','.image_iupload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		hmedia.open('Add Image Icon','Add',function(images){ 

			temp.parents('.ioa_input').find('input').val(images[0].url).trigger('change'); 
		});

		
	});

 doc.on('click','.input-val-delete',function(e){
		e.preventDefault();
		jQuery(this).parents('.ioa_input').find('input,textarea').val(' ');
		
		if( jQuery(this).parents('.ioa_input').find('.ioa_slider').length > 0  )
			 jQuery(this).parents('.ioa_input').find( ".ioa_slider" ).slider( "value",0 );
		
		});
 

	doc.on('click','.zip_upload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		zmedia.open(temp.data('title'),temp.data('label'),function(zips){ 
		
			
			temp.next().val(zips[0].id); 
			temp.next().trigger('change');


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

if( jQuery('.mediamanager .slides').length > 0 )
jQuery('.mediamanager .slides').sortable();

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

	



	jQuery('div.input-image-preview span.himage-remove').click(function(){
		jQuery(this).parent().hide();
		jQuery(this).parent().find('img').attr('src','');
		jQuery(this).parent().prev().find('input').val('');
	});

	
  
	/**
	 * Theme Options Panel Code
	 */
	
	jQuery( ".option-panel-tabs" ).tabs({
  beforeActivate: function( event, ui ) {   }
});	
	jQuery('div.ioa_options div.subpanel').tabs({
  beforeActivate: function( event, ui ) {  }
});


jQuery('a.export-options-panel-settings').click(function(e){
	window.location.href = jQuery(this).attr('href')+"&ioa_export=true";
	e.preventDefault();
});	

	/**
	 *	Options Panel Code
	 * 
	 */
	var path = jQuery('#ioa_option_form').attr('action');

	jQuery(".button-save.options-panel-save").click(function(e){
		loader.show();
		
		jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"options_save",  values: jQuery("#ioa_option_form").serializeArray(), action: 'ioalistener'  },
			  function(data){
				loader.hide();
				ioa_msg.setMessage('Changes Saved','Options Panel changes were saved successfully.','success');
				ioa_msg.show();
					 
                     
				  }
			  );
		
	
	return false;
	});


	jQuery(".import-options-panel-settings").click(function(e){
		e.preventDefault();

		loader.show();
		if( jQuery("#import_ioa_settings").val() === "" )
		{
			ioa_msg.setMessage('Empty Field !','Export Textbox cannot be empty !','warning');
			ioa_msg.show();
			loader.hide();
			return;
		}
		jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"options_import",  data: jQuery("#import_ioa_settings").val(), action: 'ioalistener'  },
			  function(data){
				loader.hide();
				ioa_msg.setMessage('Settings Restored','Refreshing the page...','success');
				ioa_msg.show();
				
				setTimeout(function(){ location.reload(true); },2000);	 
                     	
				  }
			  );
		
	
	return false;
	});
	
	/**
	 * Typo Live preview code
	 */
	var font='',source = jQuery("#gfont-frame").attr("src");
	jQuery('#font_selector').change(function(){
		var font = jQuery.trim(jQuery(this).val());
		jQuery("#gfont-frame").attr("src",source+font+"&fontsize=12");
	});

	/**
	 * Footer Code 
	 */
	
	var footer_layout = jQuery("#ioa_footer_layout").val();
	if(footer_layout=="")
	footer_layout = "two-col";
	
	jQuery(".footer-layout").find("."+footer_layout).addClass('active');
	jQuery(".footer-layout li a").click(function(e){
	jQuery(".footer-layout li").removeClass('active');
	jQuery("#ioa_footer_layout").val(jQuery(this).parent().attr('class'));
	jQuery(this).parent().addClass('active'); 
	
	e.preventDefault();
	});

	/**
	 * Default Layout selection
	 */
	
	var post_layout = jQuery("#"+SN+"_post_layout").val();
    var page_layout = jQuery("#"+SN+"_page_layout").val();
    
	if(post_layout=="")
		post_layout = ".post-layout .full";
	else
   		post_layout = ".post-layout ."+post_layout;
    
     
    
	jQuery(post_layout).addClass('active');
   
     
	if(page_layout=="")
		page_layout = ".page-layout .full";
	else
   		page_layout = ".page-layout ."+page_layout;
    
	jQuery(page_layout).addClass('active');

	jQuery(".post-layout li,.page-layout li").click(function(e){
	
    jQuery(this).parents('div.ioa_input').find('ul li').removeClass('active');
	
    jQuery(this).parents('div.ioa_input').find('input[type=hidden]').val(jQuery(this).attr('class'));
	jQuery(this).addClass('active'); 
	
	e.preventDefault();
	
	});


	/**
	 * Custom Sidebar Code
	 */
	
	/**
	 * Add custom sidebar
	 */
	 var sidebar_block = jQuery("<div class='sidebar-tag'><span></span><i  class='ioa-front-icon cancel-circled-2icon- remove-c-sidebar'></i></div>");
	 jQuery('#add-sidebar').click(function(e){

	 	var s = jQuery(this).parent().find('input');

	 	temp = sidebar_block.clone();
	 	temp.children('span').html(s.val());

	 	temp.css({ scale:0 , opacity : 0 });
	 	
	 	jQuery('div.custom-sidebar-area').append(temp);

	 	temp.transition({ opacity: 1 , scale:1}, 500 ,'easeOutBack');

	 	var ss = jQuery('.custom-sidebars');
	 	ss.val(ss.val()+","+s.val());
	 	s.val('');

	 	e.preventDefault();
	 });

	 doc.on('click','i.remove-c-sidebar',function(e){
		e.preventDefault();

		var ss = jQuery('.custom-sidebars'),s='';
	 	
	 	jQuery(this).parent().transition({ opacity: 0 , scale:0}, 500 ,'easeInBack',function(){
			jQuery(this).remove();
			jQuery('div.custom-sidebar-area').children().each(function(){
	 		s = s + jQuery.trim(jQuery(this).find('span').html())+",";
	 		});
	 		ss.val(s);
	 		
	 	});

	 });


	 /**
	  *  ============= Header Constructor Code ===========================================================================
	  */
  
  doc.on('click','#shortcode-l-data',function(e){
  		e.preventDefault();


  		if(rad_lightbox.find('div.rad-l-body').data('key')=="icons")
		{
			var query ='[ioa_icon ';
			var du = icon_canvas.find('i').clone();
			du.removeClass('none ioa-front-icon border-style border-style-circ background-style background-style-circ longshadow-style longshadow-style-circ');
				
			switch(jQuery('.icn_style').val())
			{
				case 'none' :  query += ' icon_type="default" icon_class="'+du.attr('class') +'"  color="'+rad_lightbox.find('.color').val()+'"  '; break;
				case 'border-style' :  query += ' icon_type="border-style" icon_class="'+du.attr('class') +'" border_color="'+rad_lightbox.find('.border_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;
				case 'border-style-circ' :  query += ' icon_type="border-style-circ" icon_class="'+du.attr('class') +'"  border_color="'+rad_lightbox.find('.border_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;

				case 'background-style' :  query += ' icon_type="background-style" icon_class="'+du.attr('class') +'"  background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;
				case 'background-style-circ' :  query += ' icon_type="background-style-circ" icon_class="'+du.attr('class') +'"  background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;

				case 'longshadow-style' :  query += ' icon_type="longshadow-style" icon_class="'+du.attr('class') +'"   background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;
				case 'longshadow-style-circ' :  query += ' icon_type="longshadow-style-circ" icon_class="'+du.attr('class') +'"  background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'"'; break;
			}	
			
			query += ' /]';

			tinyMCE.activeEditor.selection.setContent(query);

			

		}
		else if(rad_lightbox.find('div.rad-l-body').data('key')=="shortcode_columns")
		{

			var data = jQuery('div.column-maker-area').clone();
	
			data.find('i').remove();

			if( jQuery('#content').is(':visible') ) {
					    jQuery('#content').insertAtCaret("<div class='clearfix'>"+jQuery.trim(data.html())+"</div> &nbsp;");
			} else {
			    tinyMCE.activeEditor.selection.setContent("<div class='clearfix'>"+jQuery.trim(data.html())+"</div> &nbsp;");    
			}	
			jQuery('div.column-maker-area').html('');

		}

		rl.hide();

  }) ;	

 
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
	
		else if(rad_lightbox.find('div.rad-l-body').data('key')=="hcon")
		{
			
		  	hcon_parent.data('align',rad_lightbox.find('.hcon_w_align').val());

		    var mr =  rad_lightbox.find('.hcon_w_tm').val()+":"+rad_lightbox.find('.hcon_w_rm').val()+":"+rad_lightbox.find('.hcon_w_bm').val()+":"+rad_lightbox.find('.hcon_w_lm').val();
			

			hcon_parent.data('margin',mr);
			hcon_parent.data('text',rad_lightbox.find('.hcon_w_txt').val());
			
        
			if( hcon_parent.data('val') == "social" )
			{
				var s_query = '';
				hcon_parent.data('link',rad_lightbox.find('.hcon_s_w').val());
				rad_lightbox.find('input[type=checkbox]').each(function(){

					if( jQuery(this).is(':checked') )
					{
						s_query += jQuery(this).val() + "<vc>" + rad_lightbox.find(".hcon_"+jQuery(this).val()).val()+"<sc>";
					}

				

				}); 	hcon_parent.data('text',s_query);
			}

		}

		rl.hide();
		rad_lightbox.find('.rad-l-body .component-opts').html('');
		
	});
 

	


doc.on('click', '#s-column-maker .top-bar a' , function(e){
	e.preventDefault();
	var col = jQuery(this).attr('href');
	var last ='' ;
	 col+= ' col';
	if(jQuery(this).hasClass('last')) last = 'last';
	temp = "<div class='"+col+" "+last+"  clearfix'><p>Content</p> <i class='ioa-front-icon cancel-circled-1icon-'></i></div>";

	if(jQuery(this).hasClass('last')) temp += "<div class='clearfix'> &nbsp; </div> ";

	jQuery('div.column-maker-area').append(temp);

});

doc.on('click','div.column-maker-area i',  function(e){
	
	jQuery(this).parent().remove();
});



doc.on('change','.icn_style',function(){
	icon_canvas.find('i').removeClass('none default border-style border-style-circ background-style background-style-circ longshadow-style longshadow-style-circ');
	icon_canvas.find('i').addClass(jQuery(this).val());

	jQuery('.sc-icon-listener').hide();
	jQuery('.sc-icon-listener.'+jQuery(this).val()).show();

	icon_canvas.find('i').removeAttr('style');

	

});

doc.on('click','.sc-icon-list-wrap li',function(){
		temp = jQuery(this);
		var t = icon_canvas.find('i').attr('style');

		icon_canvas.html( temp.html() );
		icon_canvas.find('i').addClass(jQuery('.icn_style').val());
		icon_canvas.find('i').attr('style',t);	
		});

	doc.on('change','div.scourge input',function(){

		temp = jQuery(this).parents('div.ioa_input');
		var attr = temp.data('attr') ;
		var el = temp.data('element');

	});



	doc.on('click','#sc-icon-import',function(e){
		e.preventDefault();
		sc_oc =	jQuery(this);
		
		hmedia.open(sc_oc.data('title'),sc_oc.data('label'),function(images){ 
		

			icon_canvas.find('img').attr('src', images[0].url);
			

		});

		
	}); 

	/**
	 * Custom Panel , Layout settings
	 */
	
	if(jQuery('.page_layout').val()!="")
	jQuery('.layout-list').find('.'+jQuery('.page_layout').val()).addClass('active');
	
	jQuery('.layout-list  li').click(function(e){
		e.preventDefault();
		jQuery('.layout-list  li').removeClass('active');
		parent = jQuery(this).addClass('active');

		jQuery('.page_layout').val(parent.data('val'));

	});



doc.on('click','a.query-maker',function(e){
    	e.preventDefault();
    	query_engine = jQuery(this);
	var pt = query_engine.parents('div.inner-body-wrap,div.ioa-query-box,.ex-shortcode-mods , .ui-tabs-panel').find('.post_type,.shortcodes_val_holder,.custom_post_type').val();
	
	if(pt=="" || typeof pt == "undefined") pt ="post";
	
	rl.show('Query Engine');
	jQuery.post(jQuery('#backend_link').attr('href'),{ type:'query_engine', action: 'ioalistener' , post_type : pt },function(data){
		rl.set(data,'query_engine');
	});

    });

jQuery('.ioa-desc-tooltip').hover(function(){

	jQuery(this).children('div').css({ display : 'block' , opacity : 0, bottom:36 }).transition({ opacity : 1 , bottom:26 },300);

},function(){

	jQuery(this).children('div').transition({ opacity : 0 , bottom:36 },300,'',function(){
		jQuery(this).hide();
	});

});

doc.on('click','a.icon-maker',function(e){
    	e.preventDefault();
    	sicon_engine = jQuery(this);
  
	rl.show('Icons');
	jQuery.post(jQuery('#backend_link').attr('href'),{ type:'simple_icons', action: 'ioalistener' },function(data){
		rl.set(data,'simple_icons');
		
	});

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

/**
 * Media Manager Code
 */



var current_media_item = null,mediamanager = jQuery('div.mediamanager') , mtemp ;
var options_tab = mediamanager.find('#slider_options');
var sl, mlist=  jQuery('div.slides'), mslide= jQuery('div.hide div.media-slide') , slides_tab = mediamanager.find('#slider_slides');

jQuery('.inner-slide-body-wrap').tabs();



mlist.children('div.media-slide').each(function(){
	
	parent = jQuery(this);
	//temp = parent.find('.slide_type').val();
	obj =  parent.find('.background_opts').val();

	if( options_tab.find('.slider_type').val() == "quantum_slider" )
	{
		parent.find('.mm-filter.full-image').hide();
	}
	else
		parent.find('.mm-filter.full-image').show();

	if(obj!="")
    parent.find('.mm-bg-listener.'+obj).show();

   

});





var murl = jQuery('.ioa_panel_wrap').data('url');
jQuery('a.create_slider_button').click(function(e){
	e.preventDefault();
	loader.show();
	sl = jQuery('.create-slider-section input[type=text]').val();
	jQuery.post(murl,{ type:"create", action: 'ioalistener', key :  "ioamediamanager" , value : sl },function(data){

		loader.hide();
		ioa_msg.setMessage('Slider Added','Slider '+sl+' successfully added !','information');
		ioa_msg.show();

		jQuery('div.slider-list').append( data );

	});

});




doc.on('click','a.close-media-body',function(e){
	e.preventDefault() 
	jQuery(this).parent().parent().fadeOut('fast');
});



doc.on('click','a.mslide-edit',function(e){
	e.preventDefault();
	var body = jQuery(this).parent().next();
		body.slideToggle('normal');
		

});

doc.on('click','a.mslide-delete',function(e){
	e.preventDefault();
	jQuery(this).parents('div.media-slide').hide('normal',function(){ jQuery(this).remove() });



});

jQuery('#add_media_quantum').click(function(e){

	e.preventDefault();
	temp =	jQuery(this);

	var tslide = mslide.clone();
	
	mlist.append(tslide);
	tslide.find('.ioa-minicolors').minicolors('destroy');
	tslide.find('.slider-component-tab').tabs();
	tslide.find('.ioa-minicolors').minicolors({
		textfield : true,
		opacity: false,
		change: function(hex, opacity) {
         
      	   jQuery(this).parent().next().val(opacity);    
       	   jQuery(this).trigger('change');
            
        }

	});


});

options_tab.find('.so-opts').hide();
options_tab.find('.so-opts.so-'+jQuery('.slider_type').val()).show();

jQuery('.slider_type').change(function(){

	options_tab.find('.so-opts').hide();
	options_tab.find('.so-opts.so-'+jQuery(this).val()).show();

	if( jQuery(this).val() == "quantum_slider" )
	{
		slides_tab.find('.mm-filter.full-image').hide();
	}
	else
		slides_tab.find('.mm-filter.full-image').show();

});

var targetOption;
jQuery('#add_media_slides').click(function(e){
	e.preventDefault();
	temp =	jQuery(this);
		
		hmedia.open("Add Media Slides","Add",function(images){ 
		
			for(var i=0;i<images.length;i++)
			{
				var tslide = mslide.clone();

				if( typeof images[i].sizes.thumbnail != 'undefined' )
					thumb = images[i].sizes.thumbnail.url;
				else
					thumb = images[i].sizes.full.url;

				tslide.find('.alt_text').val(images[i].alt);
				tslide.find('.image,.background_image').val(images[i].url); 
				tslide.find('.thumbnail').val(thumb);

				obj = tslide.find('.background_opts').find('option');

				targetOption = obj.filter(
			        function () { return jQuery(this).val() == 'bg-image' }
			    );


			    if (jQuery().prop) {
			        targetOption.prop('selected', true);
			    } 
			    else {
			        targetOption.attr('selected', 'true');
			    }



				tslide.find('.text_title').val(images[i].title);
				tslide.find('.text_desc').val(images[i].description);
				tslide.find('div.media-slide-head').append("<img src='"+thumb+"' />");
				mlist.append(tslide);
				tslide.find('.ioa-minicolors').minicolors('destroy');
				tslide.find('.slider-component-tab').tabs();
				tslide.find('.ioa-minicolors').minicolors({
					textfield : true,
					opacity: false,
					change: function(hex, opacity) {
                     
                  	   jQuery(this).parent().next().val(opacity);    
                   	   jQuery(this).trigger('change');
                        
                    }

				});

			}

			

		});

});



jQuery('.save_media_slides').click(function(e){
	e.preventDefault();
	loader.show();
	var input, val ,options = [] , slides = [];

	options_tab.find('div.ioa_input').each(function(i){

		input = jQuery(this).find('input,textarea,select');
		val = input.val();
		options[i] = { name : input.attr('name') , value : val  }

	});

	

	mlist.children('div.media-slide').each(function(j){

		var data = [];
		

		jQuery(this).find('div.ioa_input').each(function(k){

		input = jQuery(this).find('input,textarea,select');
		val = input.val();
		data[k] = { name : input.attr('name') , value : val  }

		});

		slides[j] = data;

	});

	jQuery.post(murl , { options : options, action: 'ioalistener' , slides : slides , key :  "ioamediamanager" , id : mlist.data('id') , type : 'update' } , function(data){
		loader.hide();
		ioa_msg.setMessage('Changes Saved','Slider Settings Saved successfully !','success');
		ioa_msg.show();


	});

});



doc.on('click','.slider-item a.cancel-circled-2icon-', function(e){
	e.preventDefault();
	loader.show();
	temp = jQuery(this);
	jQuery.post(cpurl,{ type:"delete", action: 'ioalistener', key :  "ioamediamanager" , id : temp.attr('href') },function(data){

		loader.hide();
		ioa_msg.setMessage('Slider Deleted !','Slider '+temp.parent().find('h6').html()+' has been deleted !','warning' );
		ioa_msg.show();

		temp.parent().transition({ opacity: 0 , scale:0}, 500 ,'', function(){ jQuery(this).remove() });	
	});

});

doc.on('mouseenter','div.media-slide',function(e){
	e.preventDefault();
	jQuery(this).find('div.media-slide-head>a.edit-icon').stop(true,true).fadeIn('normal');

});
doc.on('mouseleave','div.media-slide',function(e){
	e.preventDefault();
	jQuery(this).find('div.media-slide-head>a.edit-icon').stop(true,true).fadeOut('normal');

});



/**
 * Custom posts Manager code
 */


var ct = '',cpurl = jQuery('.ioa_panel_wrap').data('url')  , cpitem = jQuery('#cp_slides').find('div.hide div.cp-item');
jQuery('a.create_cp_button').click(function(e){
	e.preventDefault();
	loader.show();
	ct = jQuery('.create-cp-section input[type=text]').val();
	jQuery.post(cpurl,{ type:"create", action: 'ioalistener', key :  "custompostsmanager" , value : ct },function(data){

		loader.hide();
		ioa_msg.setMessage('New Post Type Added','Custom Post with name '+ct+' has been created.','information');
		ioa_msg.show();

		jQuery('div.cp-list').append( data );
	});

});
var cp_button = null;
doc.on('click','.cp-item a.cancel-circled-2icon-', function(e){
	e.preventDefault();
	loader.show();
	cp_button = jQuery(this);
	jQuery('.post_type_label').html(cp_button.prev().html());
	jQuery('div.ioac-delete-message').slideDown('fast');

});

jQuery('div.ioac-delete-message a').click(function(e){
	e.preventDefault();

	if( jQuery(this).attr('href') =="yes" )
	{
		jQuery.post(cpurl,{ type:"delete", action: 'ioalistener', key :  "custompostsmanager" , id : cp_button.attr('href') },function(data){

			loader.hide();
			ioa_msg.setMessage('Post Type Deleted !','Custom Post '+cp_button.parent().find('h6').html()+' has been deleted !' ,'warning' );
			ioa_msg.show();
			jQuery('div.ioac-delete-message').slideUp('fast');

			
			cp_button.parent().transition({ opacity: 0 , scale:0}, 500 ,'', function(){ jQuery(this).remove() });	
		
		});
	}
	else
	{
		loader.hide();
		jQuery('div.ioac-delete-message').slideUp('fast');

	}

});

 

jQuery('.save_cp_slides').click(function(e){
	e.preventDefault();
	loader.show();
	var input, val ,options = [] , mb = [];

	jQuery('#cp_slides').find('div.ioa_input').each(function(i){

		input = jQuery(this).find('input,textarea,select');
		val = input.val();
		options[i] = { name : input.attr('name') , value : val  }

	});

	jQuery('div.metaboxes-list').children('div.cp-slide').each(function(j){
		var opts = [];

		 jQuery(this).find('div.ioa_input').each(function(i){

		 		input = jQuery(this).find('input,textarea,select');
				val = input.val();
				opts[i] = { name : input.attr('name') , value : val  }

		 });

		 mb[j] = opts;
	});

	ct = jQuery('#cp_slides').find('.post_type').val();
	jQuery.post(murl , { title : ct, action: 'ioalistener',  options : options , metaboxes : mb , key :  "custompostsmanager" , id : jQuery('.metaboxes-list').data('id') , type : 'update' } , function(data){
		loader.hide();
		ioa_msg.setMessage('Changes Saved','Settings to Post Type '+ct+' has been successfully saved !','success');
		ioa_msg.show();
	});
	

});



doc.on('click','a.mcp-edit',function(e){
	e.preventDefault();
	var body = jQuery(this).parent().next();
	body.slideToggle('normal');
});


doc.on('click','a.mcp-delete',function(e){
	e.preventDefault();
	jQuery(this).parents('div.cp-slide').transition({ opacity: 0 , scale:0}, 500 ,'', function(){ jQuery(this).remove() });	

});

var cpslide = jQuery('#cp_options').find('.hide .cp-slide').clone();

jQuery('#add-cp-slides').click(function(e){
	e.preventDefault();
	temp =	jQuery(this);
		
		
				var tslide = cpslide.clone();
				
				tslide.find('.meta_name').val("Field "+(jQuery('.metaboxes-list').children().length+1));
				tslide.find('.cp-slide-head span').html("Field "+(jQuery('.metaboxes-list').children().length+1));

				tslide.find('.ioa-minicolors').minicolors('destroy');
				tslide.find('.slider-component-tab').tabs();
				tslide.find('.ioa-minicolors').minicolors({
					textfield : true,
					opacity: false,
					change: function(hex, opacity) {
                     
                  	   jQuery(this).parent().next().val(opacity);    
                   	   jQuery(this).trigger('change');
                        
                    }

				});
				jQuery('.metaboxes-list').find('.information').slideUp('normal');
				jQuery('.metaboxes-list').append(tslide);

				ioa_msg.setMessage('New Metabox Added','New MetaBox has been added, click to edit.','information');
				ioa_msg.show();
		
});


/**
 * IOA Custom Template
 */

jQuery('.ioa-template li').click(function(){
	jQuery('.ioa-template li').removeClass('active');
	jQuery('.ioa_custom_template').val(jQuery(this).data('tmp'));
	jQuery(this).addClass('active');
});

jQuery('#ioa-custom-templates-toggle').click(function(e){
	e.preventDefault(); 
	
	if(jQuery(this).children('i').hasClass('plus'))  jQuery(this).children('i').addClass('minus').removeClass('plus');
	else jQuery(this).children('i').removeClass('minus').addClass('plus');

	jQuery('.ioa-template-section').slideToggle('normal');
});

jQuery('.ioa-template li.'+jQuery('.ioa_custom_template').val()).addClass('active');

jQuery('.ioa-portfolio-template li').click(function(){
	jQuery('.ioa-portfolio-template li').removeClass('active');
	jQuery('.single_portfolio_template').val(jQuery(this).data('tmp'));
	jQuery(this).addClass('active');
});

jQuery('.ioa-portfolio-template li.'+jQuery('.single_portfolio_template').val()).addClass('active');

if( jQuery('div.ioa-tour-overlay').length > 0 )
{

	jQuery('div.ioa-tour-lightbox').css({  left: win.width/2 - 875/2 , top :   win.height/2 - 620/2 });
	jQuery('div.ioa-tour-lightbox a.ioa-front-icon').click(function(e){
		jQuery('div.ioa-tour-lightbox').animate({ top: - win.height },'normal',function(){
			jQuery('div.ioa-tour-overlay').fadeOut('fast');
		});
		
		e.preventDefault();
	});
}	





doc.on('click', 'ul.sicon-list li', function(e){
	jQuery('ul.sicon-list li').removeClass('active');
	jQuery(this).addClass('active');
	e.preventDefault();
});



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

	 	jQuery(this).parent().next().slideToggle('normal');

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


jQuery(document).on('click','.feature-column-head',function(e){
	jQuery(this).next().slideToggle('normal');

	});

var pr = jQuery("#s-pricing_table");

doc.on('click','#pricingtable-insert',function(e){
	pr = jQuery("#s-pricing_table");
	e.preventDefault();
	var code = '';
 	
 	if( pr.find('.feature_column').val() == "true" )
 	{
 		code += '[feature_column ';

 		pr.find('.feature-col').each(function(){
 			code += jQuery(this).data('value')+"='"+jQuery(this).find('input,textarea').val()+"' ";
 		});

 		code += ' /]';
 	}
 	var s,t,cols = jQuery('.pricing_cols').val().split('[ioa_mod]');

 	for(var i=0;i<cols.length;i++)
 	{
 		if(cols[i]!="")
 		{
 			code += "[column ";
	 		t = cols[i].split("[inp]");
	 		
	 		for(var j=0;j<t.length;j++)
	 		{
	 			if(t[j]!="")
	 			{
	 				 s = t[j].split('[ioas]');
 				 	code += s[0]+"='"+s[1]+"' ";
	 			}	
	 		}
	 		
	 		code += "/]";
 		}
 	}
 		
 	if( jQuery('#content').is(':visible') ) {
			    jQuery('#content').insertAtCaret("[pricing_table]"+code+"[/pricing_table]");
	} else {
	    tinyMCE.activeEditor.selection.setContent("[pricing_table]"+code+"[/pricing_table]");    
	}
	
 });

jQuery('#ioa-intro-trigger').click(function(e){
	e.preventDefault();
	
	introJs().start().onchange(function(targetElement) {  
  		
  		if( jQuery(targetElement).hasClass('ui-tabs-anchor') )
  		{
  			jQuery(targetElement).trigger('click');
  		}

	});
	

	});

var installer_url = jQuery('a.run-installer').attr('href');

	jQuery('.installer_type').change(function(){

		jQuery('a.run-installer').attr('href', installer_url+"&instype="+jQuery(this).val() );

	});

doc.on('click','.vdelete',function(e){
	jQuery(this).parent().remove();
	e.preventDefault();
})
jQuery('#save_visualizer').click(function(e){
  var data = [],bgs = [];

  jQuery('.vlist-item').each(function(i){
  	data[i] = { key : jQuery(this).find('.key').val() ,  logo : jQuery(this).find('.vlogo').val() , thumb : jQuery(this).find('.vthumb').val()  } ;
  });

  jQuery('.bg-image-area .vimage').each(function(i){
  		bgs[i] = { src : jQuery(this).find('img').attr('src') ,  thumb : jQuery(this).find('img').data('thumb') ,  alt : jQuery(this).find('img').attr('alt') } ;
  });


	jQuery.post( jQuery('#backend_link').attr('href') ,{ type : 'visualizer_save', action: 'ioalistener' , data : data , images : bgs},function(data){
    			ioa_msg.show(); loader.hide(); 
    		});	
    		e.preventDefault();
});


doc.on('click','.v-image-upload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		hmedia.open(temp.data('title'),temp.data('label'),function(images){ 
		

		var str = '';

		for(var i=0;i<images.length;i++)
		{
			if( typeof images[0].sizes.thumbnail != 'undefined' )
					thumb = images[0].sizes.thumbnail.url;
				else
					thumb = images[0].sizes.full.url;

			str += "<div class='vimage'><a class='vdelete' href=''></a><img src='"+images[i].url+"' data-thumb='"+thumb+"' alt='"+images[i].alt+"'  /></div>";
		}
		temp.next().append(str);
		});

		
	}); 



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


function maptoHconObj(target,source)
{

   var str,s,te =  target.children('.save-data'),inp,val;
   
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

           if( typeof  tinyMCE.get(0) == "undefined" ) {
                val  =  inp.val();
            } else {
                 val  = tinyMCE.get(0).getContent();
            }


        }

        if( jQuery(this).hasClass('hidden-field') )
        {
          inp = jQuery(this).find('input[type=hidden]');
          val = inp.val(); 

        }

        te.find('.'+inp.attr('name')).val( val );

   });

}
