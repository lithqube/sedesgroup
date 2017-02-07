jQuery(document).ready(function() {
	pg_login_is_acting = false; // security var to avoid multiple calls
	pg_cur_url = jQuery(location).attr('href');
	var pre_timestamp = (pg_cur_url.indexOf('?') !== -1) ? '&' : '?';
	
	/**************************
			 LOGIN
	**************************/
	
	// show login form for inline restrictions
	jQuery(document).delegate('.pg_login_trig', 'click', function() {
		var $subj = jQuery(this).parents('.pg_login_block');
		$subj.slideUp(350);
		
		setTimeout(function() {
			$subj.next('.pg_inl_login_wrap').slideDown(450);
		}, 350);
	});	
	
	
	// triggers
	jQuery(document).delegate('.pg_auth_btn', 'click', function() {	
		var $target_form = jQuery(this).parents('form');
		var f_data = $target_form.serialize();

		pg_submit_login($target_form, f_data);
	});
	jQuery('.pg_login_row input').keypress(function(event){
		if(event.keyCode === 13){
			var $target_form = jQuery(this).parents('form');
			var f_data = $target_form.serialize();

			pg_submit_login($target_form, f_data);
		}
		
		event.cancelBubble = true;
		if(event.stopPropagation) event.stopPropagation();
   	});
	
	
	// handle form
	pg_submit_login = function($form, f_data) {
		if(!pg_login_is_acting) {
			pg_login_is_acting = true;
			var forced_redirect = $form.attr('pg_redirect');

			$form.find('.pg_auth_btn').addClass('pg_loading_btn');
			$form.find('.pcma_psw_recovery_trigger').fadeTo(200, 0);

			jQuery.ajax({
				type: "POST",
				url: pg_cur_url,
				dataType: "json",
				data: "type=js_ajax_auth&" + f_data,
				success: function(pg_data){
					pg_login_is_acting = false;
					$form.find('.pg_auth_btn').removeClass('pg_loading_btn');
			
					if(pg_data.resp == 'success') {
						$form.find('#pg_auth_message').empty().append('<span class="pg_success_mess">' + pg_data.mess + '</span>');
						
						if(typeof(forced_redirect) == 'undefined') {
							if(pg_data.redirect == '') {var red_url = pg_cur_url + pre_timestamp + new Date().getTime();}
							else {var red_url = pg_data.redirect;}
						}
						else {red_url = forced_redirect;}
						
						setTimeout(function() {
						  window.location.href = red_url;
						}, 1000);
					}
					else {
						$form.find('#pg_auth_message').empty().append('<span class="pg_error_mess">' + pg_data.mess + '</span>');	
						$form.find('.pcma_psw_recovery_trigger').fadeTo(200, 1);
					}
				}
			});
		}
	}
	
	
	/* check to avoid smalls over button on small screens - only for remember me + password recovery */
	pg_login_display_check = function() {
		jQuery('.pg_rm_login .pcma_psw_recovery_trigger').each(function() {
            var $form = jQuery(this).parents('.pg_login_form');
			
			if( 
				($form.width() - ($form.find('.pcma_psw_recovery_trigger').outerWidth(true) + $form.find('.pg_login_remember_me').outerWidth(true))) < 
				($form.find('.pg_auth_btn').outerWidth(true) + 10)
			) {
				$form.addClass('pg_mobile_login');
			} else {
				$form.removeClass('pg_mobile_login');
			}
        });
	}
	pg_login_display_check();
	jQuery(window).resize(function() { pg_login_display_check(); });
	
	
	/**************************
			 LOGOUT
	**************************/
	
	// execute logout		 
	jQuery(document).delegate('.pg_logout_btn', 'click', function(e) {	
		e.preventDefault();
		var forced_redirect = jQuery(this).attr('pg_redirect');
		jQuery(this).addClass('pg_loading_btn');
		
		jQuery.ajax({
			type: "POST",
			url: pg_cur_url,
			data: "type=pg_logout",
			success: function(response){
				resp = jQuery.trim(response);
				
				if(typeof(forced_redirect) == 'undefined') {
					if(resp == '') {window.location.href = pg_cur_url + pre_timestamp + new Date().getTime();}
					else {window.location.href = resp;}
				}
				else {window.location.href = forced_redirect;}
			}
		});
	});
	
			
		
	/**************************
		   REGISTRATION
	**************************/	
	
	// triggers
	jQuery(document).delegate('.pg_reg_btn', 'click', function() {	
		var $target_form = jQuery(this).parents('form');
		var f_data = $target_form.serialize();
		$target_form.find('.pg_reg_btn').addClass('pg_loading_btn');
		
		pg_submit_registration($target_form, f_data);
	});
	jQuery('.pg_registration_form input, .pg_registration_form textarea').keypress(function(event){
		if(event.keyCode === 13){
			var $target_form = jQuery(this).parents('form');
			var f_data = $target_form.serialize();
			$target_form.find('.pg_reg_btn').addClass('pg_loading_btn');
			
			pg_submit_registration($target_form, f_data);
		}
		
		event.cancelBubble = true;
		if(event.stopPropagation) event.stopPropagation();
   	});
	
	
	// handle form
	pg_submit_registration = function($form, f_data) {
		var pg_cc = $form.attr('pg_cc');
		var reg_param = (typeof(pg_cc) == 'undefined') ? '' : 'pg_cc='+pg_cc+'&';
		
		jQuery.ajax({
			type: "POST",
			url: pg_cur_url,
			data: "type=js_ajax_registration&" + reg_param + f_data,
			dataType: "json",
			success: function(pg_data){
				if(pg_data.resp == 'success') {
					$form.find('#pg_reg_message').empty().append('<span class="pg_success_mess">' + pg_data.mess + '</span>');
					
					// redirect
					if(pg_data.redirect != '') {
						setTimeout(function() {
						  window.location.href = pg_data.redirect;
						}, 1000);
					}
				}
				else {
					$form.find('#pg_reg_message').empty().append('<span class="pg_error_mess">' + pg_data.mess + '</span>');
					
					// if exist recaptcha - reload
					if( jQuery('#recaptcha_response_field').size() > 0 ) {
						Recaptcha.reload();	
					}
				}
				
				$form.find('.pg_reg_btn').removeClass('pg_loading_btn');
			}
		});
	}
	
	
	/* fluid forms - columnizer */
	pg_fluid_form_columnizer = function(first_check) {
		jQuery('.pg_fluid_form').each(function() {
			// calculate
			var form_w = jQuery(this).width();

			var col = Math.round( form_w / 315 );
			if(col > 5) {col = 5;}
			if(col < 1) {col = 1;}

			// if is not first check - remove past column 
			if(typeof(first_check) == 'undefined') {
				var curr_col = jQuery(this).attr('pg_col');
				if(col != curr_col) {
					jQuery(this).removeClass('pg_form_'+curr_col+'col');	
				}
			}
			
			// apply
			jQuery(this).attr('pg_col', col);
			jQuery(this).addClass('pg_form_'+col+'col');		
        });	
	}
	pg_fluid_form_columnizer(true);
	jQuery(window).resize(function() { pg_fluid_form_columnizer(); });
});


// flag to center vertically labels in one-col forms
if(	navigator.appVersion.indexOf("MSIE 8.") == -1 ) {
	setTimeout(function() {
		document.body.className += ' pg_vcl';
	}, 400);
} 