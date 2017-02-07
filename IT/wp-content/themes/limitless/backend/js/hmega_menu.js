// JavaScript Document

jQuery(function($){
	var temp, type, obj ;

	jQuery(document).on('click','.ioa-test-deletion',function(e){
		e.preventDefault();
		jQuery(this).parents('.menu-item').find('.item-delete.submitdelete.deletion').trigger('click');
	});

	
	jQuery(document).on("click",".ioa-menu-custom-settings",function(e){
		e.preventDefault();
		jQuery(this).children('i').toggleClass('plus-squared-1icon- minus-1icon-');
		jQuery(this).parent().find('.ioa-custom-menu-settings').slideToggle('normal');
		
		});

	

var tid = [];
	if(typeof wpNavMenu != 'undefined'){ 
	
	wpNavMenu.addItemToMenu = function(menuItem, processMethod, callback) {
			var menu = jQuery('#menu').val(),
				nonce = jQuery('#menu-settings-column-nonce').val();

			processMethod = processMethod || function(){};
			callback = callback || function(){};

			params = {
				'action': 'ioa_MegaMenu_AJAX_Menu',
				'menu': menu,
				'menu-settings-column-nonce': nonce,
				'menu-item': menuItem
			};

			jQuery.post( ajaxurl, params, function(menuMarkup) {
				var ins = jQuery('#menu-instructions');
				tid = [];

				jQuery(jQuery.trim(menuMarkup)).each(function(j){
					tid[j] = jQuery(this).attr('id');
				});
			
				processMethod(menuMarkup, params);
				if( ! ins.hasClass('menu-instructions-inactive') && ins.siblings().length )
					ins.addClass('menu-instructions-inactive');
				callback();

				
			});
		}; 
		
		}
		
	
	
	});