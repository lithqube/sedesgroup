
// let's burn the heaven



jQuery(function(){


var myCodeMirror = CodeMirror.fromTextArea(jQuery('#concave_editor')[0],{
	lineNumbers : true
});


jQuery('a.insert-concave-element').click(function(e){
	 e.preventDefault();
	 
	 myCodeMirror.setLine(myCodeMirror.lastLine() , jQuery('#concave_selectors').val() + " {  } \n " );

});


var enigma_lightbox = jQuery('.enigma-lightbox') , concave_lightbox = jQuery('.concave-lightbox') ;

enigma_lightbox.css({ left: jQuery(window).width()/2 - 700/2 , top: jQuery(window).height()/2 - 650/2 })
concave_lightbox.css({ left: jQuery(window).width()/2 - 700/2 , top: jQuery(window).height()/2 - 650/2 })
	
jQuery('#close-l').click(function(e){  e.preventDefault(); enigma_lightbox.fadeOut('normal');  });
jQuery('#close-c').click(function(e){  e.preventDefault();  concave_lightbox.fadeOut('normal');  });
jQuery('a.manage-enigma').click(function(e){  e.preventDefault(); enigma_lightbox.fadeIn('normal'); });

jQuery('.concave-editor-init').click(function(e){  e.preventDefault(); concave_lightbox.fadeIn('normal'); });
jQuery('.preview-concave').click(function(e){  e.preventDefault();

	temp = myCodeMirror.getValue();

	frame.contents().find('#concave-area-styles').html(temp); 

});


if( jQuery('#wpadminbar').length > 0 )
{
	jQuery('#enigma_sidebar').css('top','28px');
}

jQuery('.erase-concave').click(function(e){  e.preventDefault();
	myCodeMirror.setValue('');
	frame.contents().find('#concave-area-styles').html(''); 
});


var fts = jQuery('.font_type_selector') , font_area = jQuery('.font-select-area').children('.inner-font-select-area') ;
fts.change(function(){
	font_area.children().not('.font-usage-type,.font-save-button').addClass('hide');	
	font_area.find('.'+fts.val()).removeClass('hide');
});
font_area.find('.'+fts.val()).removeClass('hide');

jQuery('a.export-style').click(function(e){
	 e.preventDefault();
	 window.location.href = jQuery(this).attr('href')+"&id="+jQuery('.enigma_export').val();
});

jQuery('.font-close-button').click(function(e){
	e.preventDefault();
	jQuery('.font-select-area').fadeOut('normal');
});


var query , qlen , test ,qar , fn, inputs = jQuery('.panels').find('.en-sub-sec') ;
    jQuery('#en_search').keyup(function(e){
     	query = jQuery(this).val().toLowerCase();
     	qar = query.split(' ');
     	qlen = 	qar[0].length;

     	inputs.hide();
   		
   		if(qlen >= 2)
    	{
    			jQuery('.enigma-styler-section').addClass('opened').show();
	    		inputs.each(function(){
	    			test = []; temp = jQuery(this); fn = true;
	    			for(var i=0;i<qar.length;i++) {

	    				if( typeof temp.data('search') !='undefined' &&  temp.data('search').indexOf(qar[i]) != -1 )
	    					test[i] = true;
	    				else
	    					test[i] = false;

	    			}
	    			

	    			for(var i=0;i<test.length;i++) 	fn = fn && test[i];

	    			if(fn === true) 
	    			{
	    				temp.parent().parent().show();
	    				temp.show();
	    				temp.children().children().show();
	    			}

	    		});

    		
    	}
    	else
    	{
    		inputs.show();
    		jQuery('.enigma-styler-section').removeClass('opened').hide();
    	}

    });	

jQuery('.help-menu > a').click(function(e){
	 e.preventDefault();
	 jQuery(this).next().slideToggle('normal');
	 });

jQuery('a.import-style').click(function(e){
	 e.preventDefault();
	 jQuery(this).html('Importing');
	 loader.animate({ opacity:1 },'slow');
   	enigma_sidebar.find('a.refresh-icon-cl').hide();

	 jQuery.post(ioa_listener_url,{ type:"Enigma-import" , action: 'ioalistener', value : jQuery('.enigma_import').val()  },function(data){ 

	 		jQuery('.enigma_container_layout').append(data);
   			jQuery('.enigma_export').append(data);
   			
   		 sticky_save.fadeIn('slow');
   		 jQuery('a.import-style').html('Imported');
   		 
   		 setTimeout(function(){ sticky_save.fadeOut('fast'); jQuery('a.import-style').html('Import'); },2000);

   		 loader.animate({ opacity:0 },'normal',function(){
   		 		enigma_sidebar.find('a.refresh-icon-cl').show();
   		 });
   

	 });
});


var sticky_save = jQuery('div.sticky-save-message');

var win = {
	obj : jQuery(window),
	width : null,
	height : null

},

 utils = {

	debug : function(message) {

   			 if (window.console && window.console.log  && DEBUGMODE )
      			 window.console.log('~~ IOA Debug Mode: ' + message);
  		},
  	elCenter : function(obj){
  		
  		obj.width(obj.width()+2).css('display','block'); 
		
  	},
  	exists : function(cl)
  	{

  		if( super_wrapper[0].getElementsByClassName(cl).length > 0 ) return true; else return false;
  	},
  	existsP : function(cl,parent)
  	{

  		if( parent.getElementsByClassName(cl).length > 0 ) return true; else return false;
  	}
};
	
win.width = win.obj.width();
win.height = win.obj.height();


var iframe_win = null, initTrigger = false, ripple = jQuery('#ripple'); alo = null, frame = jQuery('#enigma_edit_frame'), doc = jQuery(document) , body = jQuery('body');
var temp,obj,current_editing_obj = null , enigma_sidebar = jQuery('#enigma_sidebar'),area, loader = jQuery('span.save-loader');
var logger ;


loader.css({
	top: win.height/2 ,
	left : win.width/2
});

frame.width( win.width  );
frame.height( win.height  );
frame.attr({ 'width' : win.width , 'height' : win.height });

jQuery('div.edit-page-button-wrap a').hover(function(){
	jQuery(this).children('p').fadeIn('fast');
},function(){
	jQuery(this).children('p').stop(true,true).fadeOut('fast');
});

win.obj.resize(function(){

	win.width = win.obj.width();
	win.height = win.obj.height();

	frame.width( win.width  );
	frame.height( win.height  );
	frame.attr({ 'width' : win.width , 'height' : win.height });
	enigma_sidebar.height(win.height);
});



jQuery('.enigma-styles-menu').click(function(e){
	e.preventDefault();
	jQuery('div.edit-page-button-wrap a').not(this).removeClass('active');
	jQuery('.style-select-area').slideToggle('normal');
	jQuery(this).toggleClass('active');
});

jQuery('.fonts-enigma-styler').click(function(e){
	e.preventDefault();
	jQuery('.font-select-area').fadeToggle('normal');
	jQuery(this).toggleClass('active');
});


jQuery('.close-info').click(function(e){
	e.preventDefault();
	jQuery(this).parent().slideUp('normal');
});


win.obj.load(function(){
	frame.attr('src',enigma_source);
	jQuery('.en_gloss').fadeOut('slow');
	jQuery('#enigma_visual_mode').height(win.height-20);
	jQuery('div.concave-lightbox').css({ display:'none' , 'visibility' : 'visible' });
});

doc.on("click",'.edit-s-font',function(e){
	e.preventDefault();
	jQuery(this).parent().next().slideToggle('normal');

});

doc.on("click",'.delete-s-font',function(e){
	e.preventDefault();
	jQuery(this).parent().parent().slideUp('normal',function(){
		jQuery(this).remove();
	});

});

var font_block = jQuery('.font-s-block.clonable').clone();
font_block.removeClass('clonable');
jQuery('.font-adder').click(function(e){
	e.preventDefault();
	var f = jQuery('#font_selector').val();
	temp = font_block.clone();
	temp.find('input').removeAttr('id');
	temp.find('.font-s-head strong').html(f);
	jQuery('.font-stack').append(temp);

});

jQuery('.gcolor').click(function(e){
	e.preventDefault();
	loader.animate({ opacity:1 },'slow');
   	enigma_sidebar.find('a.refresh-icon-cl').hide();

	var s = jQuery('.gcolor-field').val();

	jQuery('.panels').find('.sync input').each(function(){
			jQuery(this).minicolors('value', s );
	});
    
	s =  shadeColor(s,-30);
	jQuery('.panels').find('.sync-dark input').each(function(){
		jQuery(this).minicolors('value', s );
	});
   


	setTimeout(function(){
		loader.animate({ opacity:0 },'slow',function(){
   			enigma_sidebar.find('a.refresh-icon-cl').show();

		});

	},800);
});

frame.height(win.height);
enigma_sidebar.height(win.height);




body.bind("radChildReady",function(){


	area = frame.contents().find('body');
	
	jQuery('title').html('Styler Mode : '+frame.contents().find('title').html());
	

	iframe_win = frame[0].contentDocument || frame[0].contentWindow.document;
	iframe_win = jQuery(iframe_win);


	});


jQuery('.sub-styler-section .minicolors').change(function(){
	temp = jQuery(this).parents('.ioa_input');
	
	prop = temp.data('property');
	target = temp.data('target');
	
	prop_val = jQuery(this).val();

	if(prop_val!="")
	{
		area.find(target).css(prop,prop_val);
	}
	

});

jQuery('.sub-styler-section input[type=text]:not(.minicolors),.sub-styler-section select').change(function(){
	temp = jQuery(this).parents('.ioa_input');
	
	prop = temp.data('property');
	target = temp.data('target');
	
	prop_val = jQuery(this).val();

	if(prop_val!="")
	{
		area.find(target).css(prop,prop_val);
	}
	

});

jQuery('.sub-styler-section input[type=text]:not(.minicolors)').bind( 'keyup', function(){
	temp = jQuery(this).parents('.ioa_input');
	
	prop = temp.data('property');
	target = temp.data('target');
	
	prop_val = jQuery(this).val();

	if(prop_val!="")
	{
		area.find(target).css(prop,prop_val);
	}
	

});


jQuery('.sub-styler-section input[type=text]').bind('pickertrans',function(){
	temp = jQuery(this).parents('.ioa_input');
	prop = temp.data('property');
	target = temp.data('target');
	prop_val = "inherit";
	console.log('tes');
	area.find(target).css(prop,'');
});


jQuery('.sub-styler-section .rad_style_property input[type=text],.sub-styler-section .rad_style_property select').change(function(){
	
	temp = jQuery(this).parents('.ioa_input');
	prop = temp.data('property');
	target = temp.data('target');
	prop_val = jQuery(this).val();
 	
	if(prop=="background-image") prop_val = "url("+prop_val+")";

 	
	area.find(target).css(prop,prop_val);
});



jQuery('h5.sub-styler-title').click(function(){

	if(jQuery(this).children('i').hasClass('icon-caret-down'))
		jQuery(this).children('i').addClass('icon-caret-up').removeClass('icon-caret-down');
	else
		jQuery(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');

	jQuery(this).next().slideToggle('normal');

	jQuery(this).next().toggleClass('sub-opened');
	jQuery(this).toggleClass('sub-opened-title');

});

jQuery('h4.engima-styler-title').click(function(){

	if(jQuery(this).children('i').hasClass('icon-caret-down'))
		jQuery(this).children('i').addClass('icon-caret-up').removeClass('icon-caret-down');
	else
		jQuery(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');

	jQuery(this).next().slideToggle('normal');
	jQuery(this).next().toggleClass('opened');
	jQuery(this).toggleClass('opened-title');
});


jQuery('a.refresh-icon-cl').click(function(e){
	e.preventDefault();

	iframe_win[0].location.reload(true);
});


jQuery('.en-section-reset').click(function(e){
	e.preventDefault();

	var section = jQuery(this).parent().next();

	section.find('.minicolors').each(function(){

		jQuery(this).minicolors('value', jQuery(this).data('default') );

	});
	section.find('.image_upload_wrap input').val('').trigger('change');

	section.find('select').each(function(){

		selectOptionByText(jQuery(this),jQuery(this).data('default'));

	});

	e.stopImmediatePropagation();
}); 

jQuery('.en-comp-reset').click(function(e){
	e.preventDefault();

	var section = jQuery(this).parent().next();

	section.find('.minicolors').each(function(){

		jQuery(this).minicolors('value', jQuery(this).data('default') );

	});
	section.find('.image_upload_wrap input').val('').trigger('change');

	section.find('select').each(function(){

		selectOptionByText(jQuery(this),jQuery(this).data('default'));

	});

	e.stopImmediatePropagation();
}); 


jQuery('a.new-enigma-container').click(function(e){
	e.preventDefault();
	
	loader.animate({ opacity:1 },'slow');
   	enigma_sidebar.find('a.refresh-icon-cl').hide();

    sticky_save.css({ top: jQuery(window).height()/2 - 20 , left: jQuery(window).width()/2 - 40  });

	jQuery.post(ioa_listener_url,{ type:"Enigma-styler-add" , action: 'ioalistener', label : jQuery('.new-enigma-template').val()  },function(data){

   		loader.animate({ opacity:0 },'slow',function(){

   			enigma_sidebar.find('a.refresh-icon-cl').show();
   			jQuery('.enigma_container_layout').append("<option value='"+data+"'>"+jQuery('.new-enigma-template').val()+"</option>");
   			jQuery('.enigma_export').append("<option value='"+data+"'>"+jQuery('.new-enigma-template').val()+"</option>");
   			
   			jQuery('.new-enigma-template').val('');
				selectOptionByText(jQuery('.enigma_container_layout'),data);
				selectOptionByText(jQuery('.enigma_export'),data);


   		});
   		 sticky_save.fadeIn('slow');
   		 setTimeout(function(){ sticky_save.fadeOut('fast'); },2000);

   		 
   	});

});

jQuery('a.delete-enigma-container').click(function(e){
	e.preventDefault();
	loader.animate({ opacity:1 },'slow');
   	enigma_sidebar.find('a.refresh-icon-cl').hide();

    sticky_save.css({ top: jQuery(window).height()/2 - 20 , left: jQuery(window).width()/2 - 40  });

	 jQuery.post(ioa_listener_url,{ type:"Enigma-delete" , action: 'ioalistener' , template : jQuery('.enigma_container_layout').val()  },function(data){
   		
		jQuery('.enigma_container_layout').find('option[value="'+data+'"]').remove();
		jQuery('.enigma_export').find('option[value="'+data+'"]').remove();

   		loader.animate({ opacity:0 },'slow',function(){

   			enigma_sidebar.find('a.refresh-icon-cl').show();
			selectOptionByText(jQuery('.enigma_container_layout'),'default');
			selectOptionByText(jQuery('.enigma_export'),'default');

   		});
   		 sticky_save.fadeIn('slow');
   		 setTimeout(function(){ sticky_save.fadeOut('fast'); },2000);

   		 
   	});

});

jQuery('a.load-enigma-container').click(function(e){
	e.preventDefault();
	loader.animate({ opacity:1 },'slow');
   	enigma_sidebar.find('a.refresh-icon-cl').hide();

    sticky_save.css({ top: jQuery(window).height()/2 - 20 , left: jQuery(window).width()/2 - 40  });

	 jQuery.post(ioa_listener_url,{ type:"Enigma-active" , action: 'ioalistener' , template : jQuery('.enigma_container_layout').val()  },function(data){
   		
   		loader.animate({ opacity:0 },'slow',function(){

   			enigma_sidebar.find('a.refresh-icon-cl').show();

   		});
   		 sticky_save.fadeIn('slow',function(){
					location.reload(true);
   		 });
   		 setTimeout(function(){ sticky_save.fadeOut('fast'); },2000);

   		 
   	});

});

jQuery('a.reset-enigma-styler').click(function(e){
	e.preventDefault();
	 loader.animate({ opacity:1 },'slow');
   enigma_sidebar.find('a.refresh-icon-cl').hide();

   sticky_save.css({ top: jQuery(window).height()/2 - 20 , left: jQuery(window).width()/2 - 40  });

	jQuery.post(ioa_listener_url,{ type:"Enigma-styler-reset", action: 'ioalistener' , template : jQuery('.enigma_container_layout').val()   },function(data){

   		loader.animate({ opacity:0 },'slow',function(){
   			enigma_sidebar.find('a.refresh-icon-cl').show();
   			jQuery('a.refresh-icon-cl').trigger('click');

   			enigma_sidebar.find('.minicolors').each(function(){

				jQuery(this).minicolors('value', jQuery(this).data('default') );

			});
			enigma_sidebar.find('.image_upload_wrap input').val('').trigger('change');

			enigma_sidebar.find('select').each(function(){

				selectOptionByText(jQuery(this),jQuery(this).data('default'));

			});

   		});
   		 sticky_save.fadeIn('slow');
   		 setTimeout(function(){ sticky_save.fadeOut('fast'); },2000);

   		 
   	});

});

/**
 * Saving mechanism
 */
var styles_save_array = [],style_temp,tar;
jQuery('a.style-save-button').click(function(e){
	e.preventDefault();
   
   loader.animate({ opacity:1 },'slow');
   enigma_sidebar.find('a.refresh-icon-cl').hide();

   sticky_save.css({ top: jQuery(window).height()/2 - 20 , left: jQuery(window).width()/2 - 40  });

   		
   	enigma_sidebar.find('.ioa_input').each(function(j){
   		
   		style_temp = jQuery(this);
   		
   			prop = style_temp.data('property');
   		
   			var d = { 'target' : encodeURIComponent(style_temp.data('target')) , 'name' : encodeURIComponent(prop) , 'value' : encodeURIComponent(style_temp.find('input,select').val())  };
   			styles_save_array[j] =  JSON.stringify( d );
   			
   	});
   	
	var custom_editor = encodeURIComponent(myCodeMirror.getValue());
	
	jQuery.post(ioa_listener_url,{ 
		type:"Enigma-styler", 
		action: 'ioalistener', 
		concave_val :custom_editor , 
		template : jQuery('.enigma_container_layout').val() , 
		data : styles_save_array, 
		global_color : encodeURIComponent(jQuery('.gcolor-field').val()) 
		},function(data){
   		
   		loader.animate({ opacity:0 },'slow',function(){
   			enigma_sidebar.find('a.refresh-icon-cl').show();
   		});

   		

   		 sticky_save.fadeIn('slow');
   		 setTimeout(function(){ sticky_save.fadeOut('fast'); },2000);
   	});
	
	

});


jQuery('a.font-save-button').click(function(e){
	e.preventDefault();
   
   loader.animate({ opacity:1 },'slow');
   enigma_sidebar.find('a.refresh-icon-cl').hide();

   sticky_save.css({ top: jQuery(window).height()/2 - 20 , left: jQuery(window).width()/2 - 40  });

   var font_stack = [] , font_gnames = [];

   jQuery('.font-stack').children('.font-s-block').each(function(i){

  	var w = [], s=[],t =jQuery(this),j=0;
	t.find('input[name=fn_w]').each(function(){
			if( jQuery(this).is(':checked')  )
			{
				 w[j] = jQuery(this).val(); j++;
			}
	});
	w = w.join();

	j = 0;
	t.find('input[name=fn_s]').each(function(){
			if( jQuery(this).is(':checked') )
			{
				 s[j++] = jQuery(this).val();
			}
	}); 		
	s = s.join();
	font_stack[i] = t.find('div.font-s-head strong').html()+";"+w+";"+s;
	font_gnames[i] = t.find('div.font-s-head strong').html();
   });
   
  
	
	jQuery.post(ioa_listener_url,{ 
		type:"Enigma-typo", 
		action: 'ioalistener', 
		fontstack : JSON.stringify(font_stack) , 
		font_selector : jQuery('#font_type_selector').val()  ,
		fontface : jQuery('#font_face_name').val() ,
		font_deck_id : jQuery('#font_deck_id').val(),
		font_deck_name : jQuery('#font_deck_name').val()
		},function(data){
   		
   		jQuery('a.refresh-icon-cl').trigger('click');
   		
   		 //div.safe-font-opts 
   		 
   		 switch(jQuery('#font_type_selector').val())
   		 {
   		 	case 'google' : var str = '';
   		 					for(var i=0;i<font_gnames.length;i++) str += '<option value="'+font_gnames[i]+'">'+font_gnames[i]+'</option>';
   		 					jQuery('.font-family-sel select').html( str+" "+ jQuery('div.safe-font-opts').html()); 	
   		 					break;
   		 	case 'fontface' : var str = '';
   		 					 str += '<option value="'+jQuery('#font_face_name').val()+'">'+jQuery('#font_face_name').val()+'</option>';
   		 					jQuery('.font-family-sel select').html( str+" "+ jQuery('div.safe-font-opts').html()); 	
   		 					break;
   		 	case 'fontdeck' : var str = '';
   		 					 str += '<option value="'+jQuery('#font_deck_name').val()+'">'+jQuery('#font_deck_name').val()+'</option>';
   		 					jQuery('.font-family-sel select').html( str+" "+ jQuery('div.safe-font-opts').html()); 	
   		 					break;								
   		 }
   		 loader.animate({ opacity:0 },'slow');
   		 sticky_save.fadeIn('slow');
   		 setTimeout(function(){ sticky_save.fadeOut('fast'); },2000);
   	});
	
	

});

jQuery('a.toggle-sidebar').click(function(e){
	e.preventDefault();

	if( enigma_sidebar.position().left < 0  )
	{
	  enigma_sidebar.animate({ left:0 },'normal');
	  jQuery('a.toggle-sidebar').removeClass('closed');
	}
	else   
	 {
	 	
	 	enigma_sidebar.animate({ left:-300 },'normal',function(){ jQuery('a.toggle-sidebar').addClass('closed'); });
	 } 

});

jQuery('.panels').height( win.height - 255  );

});

var hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 

//Function to convert hex format to a rgb color
function rgb2hex(rgb) {
 

 rgb = rgb.split("(")[1].split(")")[0];
 rgb = rgb.split(',');
  return "#" + hex(parseInt(rgb[0])) + hex(parseInt(rgb[1])) + hex(parseInt(rgb[2]));
}

function hex(x) {
  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
 }

 function selectOptionByText(selectElement, targetText) {
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
}


function shadeColor(color, percent) {

    var R = parseInt(color.substring(1,3),16);
    var G = parseInt(color.substring(3,5),16);
    var B = parseInt(color.substring(5,7),16);

    R = parseInt(R * (100 + percent) / 100);
    G = parseInt(G * (100 + percent) / 100);
    B = parseInt(B * (100 + percent) / 100);

    R = (R<255)?R:255;  
    G = (G<255)?G:255;  
    B = (B<255)?B:255;  

    var RR = ((R.toString(16).length==1)?"0"+R.toString(16):R.toString(16));
    var GG = ((G.toString(16).length==1)?"0"+G.toString(16):G.toString(16));
    var BB = ((B.toString(16).length==1)?"0"+B.toString(16):B.toString(16));

    return "#"+RR+GG+BB;
}