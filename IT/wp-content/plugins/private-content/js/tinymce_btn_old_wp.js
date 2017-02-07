(function(){
	var pg_H = 495;
	var pg_W = 560;
	
	// creates the plugin
	tinymce.create('tinymce.plugins.PrivateContent', {
		createControl : function(id, controlManager) {
			if (id == 'pg_btn') {
				// creates the button
				var pg_sc_button = controlManager.createButton('pg_btn', {
					title : 'PrivateContent Shortcode', // title of the button
					image : '../wp-content/plugins/private-content/img/users_icon_tinymce.png',  // path to the button's image
					onclick : function() {
						tb_show( 'PrivateContent Shortcodes', '#TB_inline?width=' + pg_W + '&height=' + pg_H + '&inlineId=privatecontent-form');
						
						if( jQuery('#pg_sc_ud').size() > 0){
							jQuery("#pg_sc_tabs").tabs();	
						}
						
						pg_scw_setup();
						pg_live_ip_checks();
						pg_live_chosen();
						

						////////////////////////////////////////////////////////////////////
						// CUSTOM JAVASCRIPT - USER DATA ADD-ON
						var data = { action: 'pcud_tinymce_add-on' };
						jQuery.post(ajaxurl, data, function(response) {
							if(response != 0) {
								resp = jQuery.parseJSON(response);
					
								jQuery('#pg_sc_ud').html(resp.html);
								jQuery('#pg_sc_ud > table').addClass('lcwp_tinymce_table');
								jQuery('#pg_sc_ud > table tr td:first-child').css('width', '33%');
								
								jQuery('#pg_sc_ud > hr, #pg_sc_ud > br').remove();
								jQuery('body').append(resp.js);			
							}
						});	
						///////////////////////////////////////////////////////////////////	
					}
				});
				return pg_sc_button;
			}
			return null;
		}
	});
	tinymce.PluginManager.add('PrivateContent', tinymce.plugins.PrivateContent);
	

	
	// manage the lightbox position
	function pg_scw_setup() {
		if( jQuery('#TB_window').is(':visible') ) {
			jQuery('#TB_window').css("height", pg_H);
			jQuery('#TB_window').css("width", pg_W);	
			jQuery('#TB_window, #TB_ajaxContent').css('overflow', 'visible');
			
			jQuery('#TB_window').css("top", ((jQuery(window).height() - pg_H) / 4) + 'px');
			jQuery('#TB_window').css("left", ((jQuery(window).width() - pg_W) / 4) + 'px');
			jQuery('#TB_window').css("margin-top", ((jQuery(window).height() - pg_H) / 4) + 'px');
			jQuery('#TB_window').css("margin-left", ((jQuery(window).width() - pg_W) / 4) + 'px');
			
			
		} else {
			setTimeout(function() {
				pg_scw_setup();
			}, 10);
		}
	}
	jQuery(window).resize(function() {
		if(jQuery('#pg_sc_tabs').is(':visible')) {
			var $pg_sc_selector = jQuery('#pg_sc_tabs').parents('#TB_window');
			
			$pg_sc_selector.css("height", pg_H).css("width", pg_W);	
			
			$pg_sc_selector.css("top", ((jQuery(window).height() - pg_H) / 4) + 'px');
			$pg_sc_selector.css("left", ((jQuery(window).width() - pg_W) / 4) + 'px');
			$pg_sc_selector.css("margin-top", ((jQuery(window).height() - pg_H) / 4) + 'px');
			$pg_sc_selector.css("margin-left", ((jQuery(window).width() - pg_W) / 4) + 'px');
		}
	});
	

	////////////////////////////////////////////////////////
	///// pvt-content
	
	// hide categories if ALL is checked
	jQuery('body').delegate('#pg_sc_type', 'change', function() {
		if( jQuery(this).val() == 'some' ) {jQuery('#pg_user_cats_row').slideDown();} 
		else {jQuery('#pg_user_cats_row').slideUp();}
	});
	
	
	// hide message text if no warning is shown
	jQuery('body').delegate('#pg-hide-warning_wrap', 'click', function() {
		if( jQuery('#pg-hide-warning_wrap .iPhoneCheckLabelOn').width() > 4 ) {jQuery('#pg-text_wrap').slideDown();} 
		else {jQuery('#pg-text_wrap').slideUp();}
	});
	
	
	// handles the click event of the submit button
	jQuery('body').delegate('#pg-pvt-content-submit', 'click', function(){
		var type = jQuery('#pg_sc_type').val();
		var sc = '[pc-pvt-content';
		
		// allowed
		if(type != 'some') {sc += ' allow="' + type + '"';}
		else {
			if( !jQuery('#pg_sc_cats').val() ) {
				alert('Choose at least one category');	
				return false;
			}
			
			sc += ' allow="' + jQuery('#pg_sc_cats').val() + '"';
		}
		
		// show warning box
		if( jQuery('#pg-hide-warning').is(':checked') ) {
			sc += ' warning="0"';	
		} else {
			sc += ' warning="1"';	
		}
		
		// custom message
		if( !jQuery('#pg-hide-warning').is(':checked') && jQuery('#pg-text').val() != '') {
			sc += ' message="' + jQuery('#pg-text').val() + '"';
		}

		// inserts the shortcode into the active editor
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sc + '][/pc-pvt-content]');
		
		// closes Thickbox
		tb_remove();
	});
	
	
	////////////////////////////////////////////////////////
	///// login-form
	jQuery('body').delegate('#pg-loginform-submit', 'click', function(){	
		var shortcode = '[pc-login-form]';
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
		tb_remove();
	});
	
	
	////////////////////////////////////////////////////////
	///// logout-box
	jQuery('body').delegate('#pg-logoutbox-submit', 'click', function(){	
		var shortcode = '[pc-logout-box]';
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
		tb_remove();
	});
	
	
	////////////////////////////////////////////////////////
	///// registration-form
	jQuery('body').delegate('#pg-regform-submit', 'click', function(){	
		var shortcode = '[pc-registration-form]';
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
		tb_remove();
	});
	
	
	///////
	
	// init chosen for live elements
	function pg_live_chosen() {
		jQuery('.lcweb-chosen').each(function() {
			var w = jQuery(this).css('width');
			jQuery(this).chosen({width: w}); 
		});
		jQuery(".lcweb-chosen-deselect").chosen({allow_single_deselect:true});
	}
	
	// init iphone checkbox
	function pg_live_ip_checks() {
		jQuery('.ip_checks').each(function() {
			jQuery(this).iphoneStyle({
			  checkedLabel: 'YES',
			  uncheckedLabel: 'NO'
			});
		});	
	}
	
})();
