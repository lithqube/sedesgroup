jQuery.noConflict();
/**
 * Main Javascript all plugins and theme code declared here.
 */


if (!jQuery.support.transition) {
    jQuery.fn.transition = jQuery.fn.animate;
}

/**
 * Code that needs to be executed at first.
 */

jQuery(document).ready(function() {
    "use strict";
   
    jQuery('.rad-holder').children('p').remove(); 
    
    jQuery('div.metro-blog-wrapper').width(jQuery(window).width() - 290);
    jQuery(".format-video, .video, .ioa-video ").fitVids();


    if (!jQuery('.super-wrapper').hasClass('no-np-loader'))
        NProgress.start();

    if ((window.retina || window.devicePixelRatio > 1)) {
        var logo = jQuery('#logo img');

        if (typeof logo.data('retina') != "undefined" && logo.data('retina') != "")
            logo.attr('src', logo.data('retina'));
    }

    var icon = 'angle-righticon-';
    if (jQuery('body').hasClass('rtl')) icon = 'angle-lefticon-';

    jQuery(".sidebar-wrap.widget_recent_entries ul li,.sidebar-wrap.widget_archive ul li, .sidebar-wrap.widget_categories ul li, .sidebar-wrap.widget_meta ul li, .sidebar-wrap.widget_recent_comments ul li , .sidebar-wrap.widget_nav_menu ul li  ").append('<i class="ioa-front-icon  ' + icon + ' w-pin"></i>');

});


/**
 * Main Code Starts From Here
 */
function main_code() {
    "use strict";


    setTimeout(function() {
        jQuery('div.ioa_overlay').transition({
            opacity: 0
        }, 400, '', function() {
            jQuery(this).remove();
        });

    }, 1000);
    /**
     * Basic Variables Declaration
     */

    var DEBUGMODE = false;
    var obj, temp, i, j, k, parent, str = '',
        super_wrapper = jQuery('.super-wrapper'),
        doc = jQuery(document);

    /**
     * Window Dimensions Here
     */


    var win = {
            obj: jQuery(window),
            width: null,
            height: null

        },
        responsive = {

            ratio: 1,
            width: 1060,
            height: 600,
            platform: 'web',
            getPlatform: function() {

            }

        },
        utils = {

            debug: function(message) {

                if (window.console && window.console.log && DEBUGMODE)
                    window.console.log('~~ IOA Debug Mode: ' + message);
            },

            exists: function(cl) {
                if (bowser.msie && bowser.version < 8)
                    if (getElementsByClassName(document.body, cl).length > 0) return true;
                    else return false;


                if (bowser.msie && bowser.version <= 8)
                    if (document.querySelectorAll('.' + cl).length > 0) return true;
                    else return false;
                else
                if (typeof super_wrapper[0] != "undefined" && super_wrapper[0].getElementsByClassName(cl).length > 0) return true;
                else return false;
            },
            existsP: function(cl, parent) {
                if (bowser.msie && bowser.version < 8)
                    if (getElementsByClassName(parent, cl).length > 0) return true;
                    else return false;


                if (bowser.msie && bowser.version <= 8)
                    if (document.querySelectorAll('.' + cl).length > 0) return true;
                    else return false;
                else
                if (parent.getElementsByClassName(cl).length > 0) return true;
                else return false;
            }
        };

    win.width = win.obj.width();
    win.height = win.obj.height();

    responsive.ratio = jQuery('.skeleton').width() / 1060;
    responsive.width = win.width;
    responsive.height = win.height;

    var iso_layout = 'fitRows',
        iso_opts;

    jQuery('.video-bg').each(function() {
        jQuery(this).css({
            width: responsive.width,
            height: jQuery(this).parents('.page-section').outerHeight()
        });
        jQuery(this).children('video').mediaelementplayer({
            loop: true,
            features: []
        });
    });

    if (!super_wrapper.hasClass('no-np-loader')) {
        win.obj.load(function() {
            NProgress.done(true);
        });
    }

    if (jQuery('.video-player').length > 0)
        jQuery('.video-player video').mediaelementplayer({
            features: ['playpause', 'progress', 'current', 'duration', 'tracks', 'volume', 'fullscreen']
        });

    if (win.width <= 767) {
        responsive.ratio = (win.obj.width() * 0.7) / 1060;

    }

    jQuery('a.wpml-lang-selector').click(function(e) {
        e.preventDefault();
        var l = jQuery(this).next();

        if (l.is(':hidden')) {
            l.css({
                opacity: 0,
                marginTop: -10,
                display: "block"
            }).transition({
                opacity: 1,
                marginTop: 0
            }, 400);
        } else {
            l.transition({
                opacity: 0,
                marginTop: 0
            }, 400, '', function() {
                l.hide();
            });

        }
    });

    jQuery('.live_search').focusin(function() {
        if (jQuery(this).val() == "" || jQuery(this).val() == ioa_localize.search_placeholder) jQuery(this).val('');
    });

    jQuery('.live_search').focusout(function() {
        if (jQuery(this).val() == "") jQuery(this).val(ioa_localize.search_placeholder);
    });


    jQuery('.sc_name,.sc_email,.sc_msg').focusin(function() {
        if (jQuery(this).val() == "" || jQuery(this).val() == jQuery(this).data('default')) jQuery(this).val('');
    });

    jQuery('.sc_name,.sc_email,.sc_msg').focusout(function() {
        if (jQuery(this).val() == "") jQuery(this).val(jQuery(this).data('default'));
    });


    var valFlag = false;
    jQuery(".sc_submit").click(function(e) {

        e.preventDefault();
        obj = jQuery(this);
        valFlag = false;
        obj.parent().find("input[type=text],input[type=email],textarea").each(function() {
            temp = jQuery(this);
            if (jQuery(this).hasClass('sc_email') && !validateEmail(jQuery(this).val())) {
                temp.addClass("error");
                valFlag = true;
                temp.parent().find('.error-note').css('visibility', 'visible').transition({
                    opacity: 0.8
                }, 300);

            } else if (jQuery.trim(jQuery(this).val()) === "" || temp.val() === jQuery(this).data('default')) {
                temp.addClass("error");
                valFlag = true;
                temp.parent().find('.error-note').css('visibility', 'visible').transition({
                    opacity: 0.8
                }, 300);
            } else {
                temp.removeClass("error");
                temp.parent().find('.error-note').transition({
                    opacity: 0
                }, 300, '', function() {
                    jQuery(this).css('visibility', 'hidden');
                });
            }

        });

        if (valFlag) {
            return;
        }

        var msg = obj.parent().find(".success");

        obj.val(obj.data('sending'));
        jQuery.post(ioa_listener_url, {
            type: 'sticky_contact',
            action: 'ioalistener',
            name: obj.parent().find('.sc_name').val(),
            email: obj.parent().find('.sc_email').val(),
            msg: obj.parent().find('.sc_msg').val(),
            notify_email: obj.parent().find(".notify_email").val()
        }, function(data) {
            obj.val(obj.data('sent'));

            msg.fadeIn("slow").delay(3000).fadeOut("fast");
            obj.parent().find("input[type=text],input[type=email],textarea").each(function() {
                jQuery(this).val(jQuery(this).data('default'));
            });

        });



    });


    jQuery('div.sticky-contact a.trigger').click(function(e) {
        e.preventDefault();

        if (jQuery('div.sticky-contact').offset().left > responsive.width - 50) {
            jQuery('div.sticky-contact').transition({
                right: 0
            }, 400);
        } else {
            jQuery('div.sticky-contact').transition({
                right: -301
            }, 400);
            jQuery('div.sticky-contact').parent().find('.error-note').transition({
                opacity: 0
            }, 300, '', function() {
                jQuery(this).css('visibility', 'hidden');
            });

        }

    });


    /**
     * Header Constructor Code Begins Here
     */


    var compact_menu = jQuery('div.compact-bar ul.menu'),
        compact_bar = jQuery('div.compact-bar'),
        themeheader = jQuery('.theme-header').height();
    var topbar = jQuery('#top-bar'),
        menu_area = jQuery('div.top-area-wrapper'),
        menu_bar, bottombar = jQuery('.bottom-area');

    win.obj.scroll(function() {

        if (win.obj.scrollTop() > (themeheader)) {
            if (compact_bar.is(':hidden'))
                compact_bar.fadeIn('normal');
            jQuery('a.back-to-top').stop(true, true).fadeIn('normal')
        }

        if (win.obj.scrollTop() < (themeheader)) {
            if (compact_bar.is(':visible'))
                compact_bar.fadeOut('fast');
            jQuery('a.back-to-top').stop(true, true).fadeOut('normal')

        }

    });



    /**
     * Menu Layout / Effects Builder
     */

    var Menu_builder = {
        center: function(menu) {
            var childs = menu.children('li'),
                width = 0;
            childs.each(function() {

                width += jQuery(this).outerWidth() + 4 + parseInt(jQuery(this).css('margin-right'));
                //console.log(parseInt(jQuery(this).css('margin-right')));
            });
            setTimeout(function() {

                if (menu.hasClass('menu')) {
                    var fz = parseInt(childs.children('a').css('font-size'));
                    menu.parents('.menu-wrapper').width(width + 2 + (fz * 2)).animate({
                        opacity: 1
                    }, 'normal');
                } else {
                    menu.width(width + 2);
                    menu.animate({
                        opacity: 1
                    }, 'normal');
                }


            }, 30);
        },

        appendMenuTail: function(menu) {
            var arrow = '';

            menu.find('li').each(function() {

                if (jQuery(this).children('.sub-menu').length > 0) {
                    if (jQuery(this).is(menu.children())) {
                        arrow = '<span class="menu-arrow ioa-front-icon down-diricon-"></span>';
                    } else {
                        arrow = '<span class="menu-arrow ioa-front-icon rights-dir-1icon-"></span>';
                    }


                    jQuery(this).children('a').append('<span class="menu-tail"></span>' + arrow);

                    if (jQuery(this).children('ul.sub-menu').length > 0) {
                        jQuery(this).addClass('hasDropDown relative');
                    } else {
                        jQuery(this).addClass('hasDropDown');
                    }

                    jQuery(this).children('.sub-menu').append('<span class="faux-holder"></span>');


                }

            });



        },
        childHoverEffect: function(menu) {

            menu.find('li.menu-item').each(function() {
                obj = jQuery(this);
                obj.hoverdir();

            });

        },

        registerMenuHover: function(menu) {

            var effect = menu.parents('div.menu-wrapper').data('effect'),
                sense;
            //console.log(responsive.width);

            menu.find('li').hoverIntent(function() {
                temp = jQuery(this);
                temp.removeClass('forceRightChain');

                if (temp.find('.sub-menu .sub-menu').length > 0)
                    sense = (responsive.width - (temp.offset().left + temp.width()) - (180 * 2));
                else
                    sense = (responsive.width - (temp.offset().left + temp.width()) - (180));

                if (sense < 0 && temp.children('div.sub-menu').length === 0 && temp.is(menu.children())) {
                    temp.addClass('forceRightChain');
                    temp.find('ul.sub-menu').find('.menu-arrow').addClass('left-dir-1icon-').removeClass('right-dir-1icon-');
                } else {
                    temp.find('ul.sub-menu').find('.menu-arrow').addClass('right-dir-1icon-').removeClass('left-dir-1icon-');
                }


                if (utils.existsP('sub-menu', this)) {

                    switch (effect) {
                        case 'None':
                            temp.children('.sub-menu').stop(true, true).show();
                            break;

                        case 'Fade':
                            temp.children('.sub-menu').stop(true, true).fadeIn('normal');
                            break;
                        case 'Fade Shift Down':

                            temp.children('.sub-menu').css({
                                'opacity': 0,
                                'display': 'block',
                                marginTop: -10
                            });
                            temp.children('.sub-menu').stop(true, true).animate({
                                opacity: 1,
                                marginTop: 0
                            }, 300);

                            break;
                        case 'Fade Shift Right':

                            temp.children('.sub-menu').css({
                                'opacity': 0,
                                'display': 'block',
                                marginLeft: -10
                            });
                            temp.children('.sub-menu').stop(true, true).transition({
                                opacity: 1,
                                marginLeft: 0
                            }, 300);

                            break;
                        case 'Scale In Fade':

                            temp.children('.sub-menu').css({
                                'opacity': 0,
                                'display': 'block',
                                scale: 1.2
                            });
                            temp.children('.sub-menu').stop(true, true).transition({
                                opacity: 1,
                                scale: 1
                            });

                            break;
                        case 'Scale Out Fade':

                            temp.children('.sub-menu').css({
                                'opacity': 0,
                                'display': 'block',
                                scale: 0.8
                            });
                            temp.children('.sub-menu').stop(true, true).transition({
                                opacity: 1,
                                scale: 1
                            });

                            break;
                        case 'Grow':
                            temp.children('.sub-menu').stop(true, true).show('normal');
                            break;
                        case 'Slide':
                            temp.children('.sub-menu').stop(true, true).slideDown('normal');
                            break;
                        default:
                            temp.children('.sub-menu').stop(true, true).fadeIn('normal');
                            break;
                    }

                }

            }, function() {
                if (utils.existsP('sub-menu', this)) {
                    temp = jQuery(this);
                    switch (effect) {
                        case 'None':
                            temp.children('.sub-menu').stop(true, true).hide();
                            break;

                        case 'Fade':
                            temp.children('.sub-menu').stop(true, true).fadeOut('normal');
                            break;
                        case 'Fade Shift Down':
                            temp.children('.sub-menu').stop(true, true).transition({
                                opacity: 0,
                                marginTop: -10
                            }, 300, function() {
                                jQuery(this).hide()
                            });
                            break;
                        case 'Fade Shift Right':
                            temp.children('.sub-menu').stop(true, true).transition({
                                opacity: 0,
                                marginLeft: -10
                            }, 300, function() {
                                jQuery(this).hide()
                            });
                            break;
                        case 'Scale In Fade':
                            temp.children('.sub-menu').stop(true, true).transition({
                                opacity: 0,
                                scale: 1.2
                            }, 200, '', function() {
                                jQuery(this).hide()
                            });
                            break;
                        case 'Scale Out Fade':
                            temp.children('.sub-menu').stop(true, true).transition({
                                opacity: 0,
                                scale: 0.8
                            }, 200, '', function() {
                                jQuery(this).hide()
                            });
                            break;
                        case 'Grow':
                            temp.children('.sub-menu').stop(true, true).hide('normal');
                            break;
                        case 'Slide':
                            temp.children('.sub-menu').stop(true, true).slideUp('normal');
                            break;
                        default:
                            temp.children('.sub-menu').stop(true, true).fadeOut('normal');
                            break;
                    }



                }

            });
        }

    }

    /**
     * Menu Effects & Stuff
     */

    Menu_builder.childHoverEffect(jQuery('.theme-header .menu, div.sidebar-wrap ul.sub-menu, .compact-bar .menu'));

    Menu_builder.appendMenuTail(compact_menu);
    Menu_builder.registerMenuHover(compact_menu);


    if (utils.exists('menu-centered')) {
        jQuery('.menu-centered .menu').each(function() {
            Menu_builder.center(jQuery(this));
        });
    }

    Menu_builder.appendMenuTail(jQuery('.theme-header .menu'));
    Menu_builder.registerMenuHover(jQuery('.theme-header .menu , div.sidebar-wrap ul.menu'));


    setTimeout(function() {

        if (compact_menu.length > 0) {
            var cposi = compact_bar.find('.menu-wrapper').position().left;

            compact_menu.children('li').each(function() {

                if (jQuery(this).find('div.sub-menu').length > 0) {
                    jQuery(this).find('div.sub-menu').css("left", -(cposi + jQuery(this).position().left) + "px");
                }
            });
            compact_bar.css({
                'display': 'none',
                'visibility': 'visible'
            });

        }


        if (menu_area.find('.menu').length > 0) {
            menu_area.find('.menu-wrapper').each(function() {
                var temp = jQuery(this),
                    posi = temp.position().left;
                temp.find('.menu').children('li').each(function() {

                    if (jQuery(this).find('div.sub-menu').length > 0) {
                        jQuery(this).find('div.sub-menu').css("left", -(posi + jQuery(this).position().left) + "px");
                    }

                    if (jQuery('.fluid-menu').length > 0) {
                        jQuery(this).find('div.sub-menu').width(responsive.width);
                    }

                });
            });
        }





        if (topbar.find('.menu').length > 0) {
            topbar.find('.menu-wrapper').each(function() {

                var temp = jQuery(this),
                    posi = temp.position().left;
                temp.find('.menu').children('li').each(function() {

                    if (jQuery(this).find('div.sub-menu').length > 0) {
                        jQuery(this).find('div.sub-menu').css("left", -(posi + jQuery(this).position().left) + "px");
                    }
                });

            });

        }

        if (bottombar.find('.menu').length > 0) {
            bottombar.find('.menu-wrapper').each(function() {

                var temp = jQuery(this),
                    posi = temp.position().left;
                temp.find('.menu').children('li').each(function() {

                    if (jQuery(this).find('div.sub-menu').length > 0) {
                        jQuery(this).find('div.sub-menu').css("left", -(posi + jQuery(this).position().left) + "px");
                    }
                });

            });
        }

        if (win.obj.scrollTop() > (themeheader)) {
            jQuery('a.back-to-top').stop(true, true).fadeIn('normal')
            compact_bar.stop(true, true).fadeIn('normal');
        }


    }, 80);



    jQuery('div.sub-menu li a').hover(function() {
            jQuery(this).stop(true, true).transition({
                paddingLeft: 24
            }, 400);
        },
        function() {

            if (!(jQuery(this).parent().hasClass('current-menu-item') || jQuery(this).parent().hasClass('current_page_item')))
                jQuery(this).stop(true, true).transition({
                    paddingLeft: 0
                }, 400);
        }
    );

    /**
     * Social Icons code
     */

    jQuery('ul.top-area-social-list li a').hover(function() {
        temp = jQuery(this);
        temp.children('.proxy-color').stop(true, true).transition({
            opacity: 1
        }, 300);
    }, function() {
        temp = jQuery(this);
        temp.children('span.proxy-color').stop(true, true).transition({
            opacity: 0
        }, 300);
    });




    /**
     * Ajax Search Code
     */

    var search_parent = jQuery('.ajax-search'),
        search_loader = search_parent.find('span.search-loader');

    jQuery('.ajax-search-pane input[type=text]').keyup(function(e) {
        var val = jQuery(this).val().length;

        if (e.keyCode == 27) {
            jQuery('a.ajax-search-trigger').trigger('click');
            return;
        }

        if (val >= 2) {

            search_loader.fadeIn('fast');
            jQuery.post(search_parent.data('url'), {
                type: 'search',
                action: 'ioalistener',
                query: jQuery(this).val()
            }, function(data) {
                if (jQuery.trim(data) == "") return;


                search_parent.find('.no-results').fadeOut('fast');
                search_parent.find('.search-results ul').html(data);
                search_parent.find('div.search-results').stop(true, true).fadeIn('fast', function() {
                    search_loader.fadeOut('fast');
                });

            });

        } else {
            search_parent.find('div.search-results').hide();
            search_parent.find('.search-results ul').html('');

        }

    });

    jQuery('body').bind('rad_widget_dropped', function(e, key, obj) {
        PageWidgets(obj);

    });

    jQuery('body').bind('rad_widget_preview', function(e, key, obj) {
        PageWidgets(obj);

    });


    jQuery('a.ajax-search-trigger').click(function(e) {
        e.preventDefault();
        temp = jQuery(this).parent().find('div.ajax-search-pane');

        if (temp.is(":hidden")) {
            temp.css({
                'opacity': 0,
                'display': 'block',
                marginTop: -20
            });
            temp.stop(true, true).transition({
                opacity: 1,
                marginTop: 0
            });
            jQuery('a.ajax-search-trigger').addClass('active');
        } else {
            temp.stop(true, true).transition({
                opacity: 0,
                marginTop: -20
            }, 200, '', function() {
                jQuery(this).hide()
            });
            jQuery('a.ajax-search-trigger').removeClass('active');
        }
    });

    jQuery('a.ajax-search-close').click(function(e) {
        e.preventDefault();
        jQuery(this).parent().stop(true, true).transition({
            opacity: 0,
            marginTop: -20
        }, 200, '', function() {
            jQuery(this).hide()
        });
        jQuery('a.ajax-search-trigger').removeClass('active');
    });


    /**
     * Title Effects & Intro
     */


    var title_area = jQuery('div.title-wrap'),
        delay = 0,
        delay_inc = parseFloat(title_area.data('delay')) * 1000,
        animate_delay = parseFloat(title_area.data('duration')) * 1000,
        animate_position = title_area.data('position');
    var effect_builder = {

        animate: function(el, effect) {

            switch (effect) {
                case 'fade':
                    el.delay(delay).transition({
                        opacity: 1
                    }, 'slow');
                    break;
                case 'fade-left':
                case 'fade-right':
                    el.delay(delay).transition({
                        margin: '0px',
                        opacity: 1,
                        duration: 500
                    });
                    break;

                case 'rotate-left':
                    el.css({
                        rotate: '-40deg'
                    }).delay(delay).transition({
                        opacity: 1,
                        rotate: '0deg'
                    });
                    break;
                case 'rotate-right':
                    el.css({
                        rotate: '40deg'
                    }).delay(delay).transition({
                        opacity: 1,
                        rotate: '0deg'
                    });
                    break;

                case 'scale-in':
                    el.css({
                        scale: 1.2
                    }).delay(delay).transition({
                        opacity: 1,
                        scale: 1
                    });
                    break;
                case 'scale-out':
                    el.css({
                        scale: 0.8
                    }).delay(delay).transition({
                        opacity: 1,
                        scale: 1
                    });
                    break;

                case 'curtain-fade':

                    setTimeout(function() {

                        el.data("width", el.width() + parseInt(el.children().css("padding-left")));
                        el.width(0);
                        el.children().css({
                            "opacity": 0,
                            "width": el.data("width")
                        });
                        el.transition({
                            width: el.data("width"),
                            opacity: 1,
                            duration: 500
                        });
                        setTimeout(function() {
                            el.children().transition({
                                opacity: 1
                            }, 'fast');
                        }, 600);

                    }, delay);

                    break;
                case 'curtain-show':

                    setTimeout(function() {

                        el.data("width", el.width() + parseInt(el.children().css("padding-left")));
                        el.css({
                            width: 0,
                            overflow: "hidden"
                        });
                        el.children().css({
                            "opacity": 0,
                            "width": el.data("width"),
                            x: -el.data("width")
                        });
                        el.transition({
                            width: el.data("width"),
                            opacity: 1,
                            duration: 500
                        });
                        setTimeout(function() {
                            el.children().transition({
                                opacity: 1,
                                x: 0
                            }, 'fast');
                        }, 600);

                    }, delay);


                    break;
                case 'metro':
                    el.transition({
                        perspective: '800px',
                        rotateY: '0deg',
                        opacity: 1
                    });
                    break;
                case 'animate-bg':
                    el.transition({
                        backgroundPosition: animate_position
                    }, animate_delay, 'linear');
                    break;

            }

            delay += delay_inc;
        }

    }

    if (title_area.length > 0) {
        if (title_area.data('effect') == "metro") title_area.css({
            perspective: '400px',
            rotateY: '25deg',
            opacity: 0
        });


        jQuery(window).load(function() {

            effect_builder.animate(title_area, title_area.data('effect'));

            setTimeout(function() {
                if (utils.exists('animate-block'))
                    jQuery('.animate-block').each(function() {
                        effect_builder.animate(jQuery(this), jQuery(this).data('effect'));
                    });
            }, 200);

        });
    }

    /**
     * Shortcodes Coding Starts Here ===================================
     */

    if (utils.exists('power-section')) {

        if (!utils.exists('power-overlay'))
            jQuery('body').append('<div class="power-overlay"></div> <div class="power-overlay-content clearfix"><div class="filler"></div> <a href="" class="close  cancel-2icon- ioa-front-icon"></a> </div>');

        var ov = jQuery('body').find('.power-overlay');
        var ovc = jQuery('body').find('.power-overlay-content');

        jQuery('.power-section h3').click(function() {
            ovc.children('div.filler').html(jQuery(this).next().html());
            ov.css({
                display: 'block',
                'opacity': 0,
                "background-color": jQuery(this).css("background-color")
            }).transition({
                opacity: 0.7
            }, 400);
            ovc.css({
                display: 'block',
                opacity: 0,
                scale: 0.5,
                "background-color": jQuery(this).css("background-color")
            });

            ovc.css({

                height: ovc.children('div.filler').height() + 40,
                left: responsive.width / 2 - 225,
                top: responsive.height / 2 - ovc.height() / 2

            }).transition({
                opacity: 1,
                scale: 1
            }, 400);

        });

        ovc.find('a.close').on("click", function(e) {
            e.preventDefault();
            ov.fadeOut('normal');
            setTimeout(function() {
                ovc.transition({
                    opacity: 0,
                    scale: 0
                }, 400, '');
            }, 100);
        });
    }
    jQuery('div.posts_slider div.slide').hover(function() {

        jQuery(this).children('div.desc').fadeIn('normal');

    }, function() {

        jQuery(this).children('div.desc').fadeOut('normal');
    });

    if (utils.exists('media-listener')) {

        jQuery('.media-listener').waypoint(function() {

            var c = jQuery(this);

            switch (c.data('effect')) {
                case 'fade':
                    c.transition({
                        opacity: 1
                    }, 400);
                    break;
                case 'fade-right':
                    c.css({
                        x: -20
                    }).transition({
                        opacity: 1,
                        x: 0
                    }, 400);
                    break;
                case 'fade-left':
                    c.css({
                        x: 20
                    }).transition({
                        opacity: 1,
                        x: 0
                    }, 400);
                    break;
                case 'fade-grow':
                    c.css({
                        scale: 0.4
                    }).transition({
                        opacity: 1,
                        scale: 1
                    }, 400);
                    break;
            }

        }, {
            offset: '70%',
            triggerOnce: true
        });

    }

    /**
     * Sticky Sidebars
     */
    var topspace = 0;
    if (compact_menu.length > 0) topspace = 45;
    jQuery('.sticky-right-sidebar,.sticky-left-sidebar').sticky({
        topSpacing: topspace,
        bottomSpacing: jQuery('#footer').outerHeight()
    });


    /**
     * Tabs Shortcode
     */

    jQuery('div.ioa_box a.close').click(function(e) {
        e.preventDefault();
        jQuery(this).parent().parent().slideUp('normal', function() {
            jQuery(this).remove();
        })
    });

    if (utils.exists('ioa_tabs')) {
        jQuery(".ioa_tabs").tabs({
            show: {
                effect: "fadeIn",
                duration: 300
            }
        })
    }
    if (utils.exists('ioa_accordion')) {
        jQuery(".ioa_accordion").accordion({
            create: function(event, ui) {
                ui.header.find('i').removeClass('down-diricon-').addClass('up-diricon-')
            },
            beforeActivate: function(event, ui) {
                ui.newHeader.find('i').removeClass('down-diricon-').addClass('up-diricon-');
                ui.oldHeader.find('i').addClass('down-diricon-').removeClass('up-diricon-');
            },
            heightStyle: "content"
        });
    }


    function hexToRgb(hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return "rgba(" + parseInt(result[1], 16) + "," + parseInt(result[2], 16) + "," + parseInt(result[3], 16) + ",0.6)";

    }


    win.obj.load(function() {
        if (utils.exists('menu-centered')) {
            jQuery('.menu-centered .top-area-social-list').each(function() {
                Menu_builder.center(jQuery(this));
            });
        }

        if (utils.exists('line-chart-wrap')) {
            jQuery('.line-chart-wrap').waypoint(function() {
                temp = jQuery(this), vals;
                var ds = [];
                temp.find('.line-val').each(function(i) {
                    vals = jQuery(this).data('values').toString();

                    if (vals.indexOf(',') != -1) {
                        vals = vals.split(',');
                    } else
                        vals = [parseInt(vals)];

                    for (var j = 0; j < vals.length; j++) vals[j] = parseInt(vals[j]);

                    ds[i] = {
                        fillColor: jQuery(this).data('fillcolor'),
                        strokeColor: jQuery(this).data('strokecolor'),
                        pointColor: jQuery(this).data('pointcolor'),
                        pointStrokeColor: jQuery(this).data('pointstrokecolor'),
                        data: vals
                    };

                });

                var data = {
                    labels: temp.data('labels').split(','),
                    datasets: ds
                }


                var ctx = temp.children('canvas')[0].getContext("2d");
                var myNewChart = new Chart(ctx);

                var options = {};
                if (bowser.msie && bowser.version <= 8) options.animation = false;

                new Chart(ctx).Line(data, options);
            }, {
                offset: '70%',
                triggerOnce: true
            });
        }


        if (utils.exists('polar-chart-wrap')) {
            jQuery('.polar-chart-wrap').waypoint(function() {
                temp = jQuery(this);
                var ds = [],
                    total = 0;
                temp.find('.polar-val').each(function(i) {

                    total += parseInt(jQuery(this).data('value'));

                });
                temp.find('.polar-val').each(function(j) {

                    ds[j] = {
                        value: parseInt(jQuery(this).data('value')),
                        color: jQuery(this).data('fillcolor')
                    };

                    jQuery(this).children('.block').html(Math.round(parseInt(jQuery(this).data('value')) / total * 1000) / 10 + "%");
                });

                var ctx = temp.children('canvas')[0].getContext("2d");
                var myNewChart = new Chart(ctx);

                var options = {};
                if (bowser.msie && bowser.version <= 8) options.animation = false;

                new Chart(ctx).PolarArea(ds, options);

            }, {
                offset: '70%',
                triggerOnce: true
            });
        }



        if (utils.exists('pie-chart-wrap')) {
            jQuery('.pie-chart-wrap').waypoint(function() {

                temp = jQuery(this);
                var ds = [],
                    total = 0;
                temp.find('.pie-val').each(function(i) {

                    total += parseInt(jQuery(this).data('value'));

                });
                temp.find('.pie-val').each(function(i) {

                    ds[i] = {
                        color: jQuery(this).data('fillcolor'),
                        value: jQuery(this).data('value')
                    };
                    jQuery(this).children('.block').html(Math.round(parseInt(jQuery(this).data('value')) / total * 1000) / 10 + "%");

                });
                var ctx = temp.children('canvas')[0].getContext("2d");
                var myNewChart = new Chart(ctx);
                new Chart(ctx).Pie(ds, {
                    animateScale: true,
                    animationEasing: "easeOutExpo"
                });

            }, {
                offset: '70%',
                continuous: false,
                triggerOnce: true
            });
        }


        if (utils.exists('donut-chart-wrap')) {
            jQuery('.donut-chart-wrap').waypoint(function() {
                temp = jQuery(this);
                temp = jQuery(this);
                var ds = [],
                    total = 0;
                temp.find('.donut-val').each(function(i) {

                    total += parseInt(jQuery(this).data('value'));

                });
                temp.find('.donut-val').each(function(i) {

                    ds[i] = {
                        color: jQuery(this).data('fillcolor'),
                        value: jQuery(this).data('value')
                    };

                    jQuery(this).children('.block').html(Math.round(parseInt(jQuery(this).data('value')) / total * 1000) / 10 + "%");
                });

                var ctx = temp.children('canvas')[0].getContext("2d");
                var myNewChart = new Chart(ctx);
                new Chart(ctx).Doughnut(ds, {
                    animationEasing: "easeOutExpo"
                });
            }, {
                offset: '70%',
                triggerOnce: true
            });
        }

        if (utils.exists('bar-chart-wrap')) {
            var vals;
            jQuery('.bar-chart-wrap').waypoint(function() {
                temp = jQuery(this);
                var ds = [],
                    j;
                temp.find('.bar-val').each(function(i) {
                    vals = jQuery(this).data('values').toString();

                    if (vals.indexOf(',') != -1) {
                        vals = vals.split(',');
                    } else
                        vals = [parseInt(vals)];
                    for (var j = 0; j < vals.length; j++) vals[j] = parseInt(vals[j]);

                    ds[i] = {
                        fillColor: jQuery(this).data('fillcolor'),
                        strokeColor: jQuery(this).data('strokecolor'),
                        data: vals
                    };

                });

                var data = {
                    labels: temp.data('labels').split(','),
                    datasets: ds
                }
                console.log(ds);
                var ctx = temp.children('canvas')[0].getContext("2d");
                var myNewChart = new Chart(ctx);

                var options = {};
                if (bowser.msie && bowser.version <= 8) options.animation = false;

                new Chart(ctx).Bar(data, options);
            }, {
                offset: '70%',
                triggerOnce: true
            });
        }

    });


    if (utils.exists('toggle-title')) {

        jQuery('a.toggle-title').click(function(e) {
            e.preventDefault();
            if (jQuery(this).next().is(':hidden')) {
                jQuery(this).children('i').removeClass('plus-1icon-').addClass(' minusicon-');
            } else {
                jQuery(this).children('i').addClass('plus-1icon-').removeClass(' minusicon-');
            }
            jQuery(this).next().slideToggle('normal');

        });

    }

    jQuery('a.ioa-button').hover(function() {
        jQuery(this).children('span.underlay').stop(true, true).fadeIn('normal');
    }, function() {
        jQuery(this).children('span.underlay').stop(true, true).fadeOut('normal');
    });

    jQuery("div.text-inner-wrap").hoverIntent(function() {
        var icon = jQuery(this).find('.icon,.ioa-front-icon');

        if (icon.data('icon_hover') != "")
            icon.children('.icon-wrap').addClass(icon.data('icon_hover'));


    }, function() {
        var icon = jQuery(this).find('.icon,.ioa-front-icon');

        if (icon.data('icon_hover') != "")
            icon.children('.icon-wrap').removeClass(icon.data('icon_hover'));

    });




    /**
     * Gallery
     */

    if (utils.exists('ioa-gallery')) {
        jQuery('.ioa-gallery').seleneGallery({
            domMapping: true
        });
    }


    /**
     * Slider
     */

    if (utils.exists('ioaslider')) {
        jQuery('.ioaslider').quartzSlider({
            domMapping: true
        });
    }

    /**
     * Scrollable
     */

    if (utils.exists('scrollable')) {
        var t, n, minx;
        jQuery('.scrollable').each(function() {

            t = jQuery(this).parent().width();
            n = jQuery(this).children().width() + 20;
            minx = Math.ceil(t / n);
            //console.log(t+" "+n+minx);
            jQuery(this).bxSlider({
                slideWidth: n,
                maxSlides: minx,
                moveSlides: minx,
                infiniteLoop: false,
                slideMargin: 20,

                pager: false
            });

        });
    }

    jQuery(document).on('mouseenter', '.bx-wrapper', function() {

        jQuery(this).find('.bx-controls ').stop(true, true).transition({
            opacity: 1
        }, 400);

    });
    jQuery(document).on('mouseleave', '.bx-wrapper', function() {


        jQuery(this).find('.bx-controls ').stop(true, true).transition({
            opacity: 0
        }, 400);

    });

    /**
     * Magic Lists
     */

    if (utils.exists('magic-list-wrapper')) {
        var hf = 0,
            line;
        win.obj.load(function() {

            jQuery('.magic-list-wrapper').each(function() {
                hf = 0;
                line = jQuery(this).children('.line');
                jQuery(this).find('li').each(function(i) {

                    if (jQuery(this).next().length > 0) hf += jQuery(this).outerHeight(true);

                    temp = jQuery(this).children('div.icon-area');
                    temp.delay(i * 200).transition({
                        opacity: 1,
                        scale: 1,
                        backgroundColor: temp.data('color')
                    }, 500);
                });

            });

        });
    }


    /**
     * Testimonials
     */


    if (utils.exists('rad-testimonials-list')) {


        jQuery('ul.rad-testimonials-list').bxSlider({
            mode: 'fade',
            adaptiveHeight: true,

            pager: false,
            auto: true,
            maxSlides: minx,
            moveSlides: minx,
        });

    }



    /**
     * Easy Chart
     */
    var w;
    if (utils.exists('radial-chart')) {

        jQuery('.radial-chart').each(function() {
            w = jQuery(this).data('width');
            if (w > jQuery(this).width()) w = jQuery(this).width() - 20;
            jQuery(this).easyPieChart({
                size: w,
                lineWidth: jQuery(this).data('line_width'),
                barColor: jQuery(this).data('bar_color'),
                trackColor: jQuery(this).data('track_color'),
                scaleColor: false,
                lineCap: "butt",
                animate: 2000
            }).data('easyPieChart').update(0);

        });

        jQuery('.radial-chart').waypoint(function() {

            jQuery(this).data('easyPieChart').update(jQuery(this).data('start_percent'));

        }, {
            offset: '70%',
            triggerOnce: true
        });

    }


    /**
     * Progress Bar
     */

    if (utils.exists('progress-bar-group')) {

        if (!bowser.msie) jQuery(' div.progress-bar div.filler span').show();

        win.obj.load(function() {

            jQuery('.progress-bar-group').waypoint(function() {

                jQuery(this).find('div.progress-bar').each(function(i) {

                    jQuery(this).find('div.filler').delay(i * 100).transition({
                        opacity: 1,
                        width: parseInt(jQuery(this).find('div.filler').data('fill')) + "%"
                    }, 1500, 'easeInOutQuint', function() {
                        jQuery(this).children().fadeIn('fast');
                    });
                });

            }, {
                offset: '70%',
                triggerOnce: true
            });


        });
    }



    /**
     * Stacked Circles
     */

    if (utils.exists('circles-group')) {

        win.obj.load(function() {

            jQuery('div.circles-group').waypoint(function() {

                var parentw = jQuery(this).width();

                if (parentw >= jQuery(this).parent().width()) {
                    parentw = jQuery(this).parent().width();
                    jQuery(this).width(parentw);
                    jQuery(this).height(parentw);
                }

                jQuery(this).find('div.circle').each(function(j) {
                    jQuery(this).css({
                        "left": (parentw - parseInt(jQuery(this).data('fill')) / 100 * parentw) / 2,
                        scale: 0.2
                    });
                    jQuery(this).delay(j * 100).transition({
                        opacity: 1,
                        scale: 1,
                        width: parseInt(jQuery(this).data('fill')) + "%",
                        height: parseInt(jQuery(this).data('fill')) + "%"
                    }, 500);

                });

            }, {
                offset: '70%',
                triggerOnce: true
            });


        });
    }



    jQuery('div.related-menu li').click(function() {
        jQuery('div.related-menu li').removeClass('active');
        jQuery(this).addClass('active');

        temp = jQuery(this).data('val');

        jQuery('div.related-posts-wrap ul').not("." + temp).transition({
            opacity: 0,
            scale: 0
        }, 300, '', function() {
            jQuery(this).css({
                visibility: "hidden",
                opacity: 0
            })
        });
        jQuery("div.related-posts-wrap ul." + temp).css({
            visibility: "visible",
            opacity: 0,
            scale: 0
        }).transition({
            opacity: 1,
            scale: 1
        }, 300);
    });

    /**
     * Blog Formats Coding
     */
    var iso_posts;

    jQuery('.ioa-menu ul li').click(function() {
        temp = jQuery(this).data('cat');
        jQuery('div.ioa-menu ul li').removeClass('active');
        jQuery(this).addClass('active');
        iso_posts = jQuery(this).parents('.iso-parent').find('.isotope');
        if (iso_posts.length > 0) {
            if (temp == "all") {
                iso_posts.isotope({
                    filter: "*"
                });
            } else {
                iso_posts.isotope({
                    filter: ".category-" + temp
                });
            }
            return;
        }
        if (utils.exists('blog-format4-posts')) {
            var blog_posts = jQuery(this).parents('.mutual-content-wrap').find('.blog_posts');
            if (temp == "all") {
                blog_posts.find('li.post').slideDown('normal');
                return;
            }

            blog_posts.find('li.post').each(function() {

                if (!jQuery(this).hasClass("category-" + temp))
                    jQuery(this).slideUp('slow');
                else
                    jQuery(this).slideDown('slow');

            });

        }

    });


    win.obj.load(function() {


        if (utils.exists('portfolio-masonry') || utils.exists('proportional-resize') || utils.exists('blog_posts')) iso_layout = 'masonry';

        iso_opts = {
            itemSelector: '.isotope li.iso-item ',
            layoutMode: iso_layout
        };

        if (utils.exists('blog_posts')) iso_opts.transformsEnabled = false;

        if (win.width > 767 && jQuery('.isotope').length > 0)
            jQuery('.isotope').isotope(iso_opts);

        window.parent.jQuery("body").trigger('radChildReady');

        jQuery('.blog-format1-posts ul li').waypoint(function() {

            var c = jQuery(this).find('div.proxy-datearea');
            var p = jQuery(this).prev();

            if (p.length > 0)
                p.find('span.line').animate({
                    height: p.height() + 20
                }, 500, '', function() {
                    c.transition({
                        height: 101
                    }, 900);
                });
            else
                c.transition({
                    height: 101
                }, 900);

        }, {
            offset: '70%',
            triggerOnce: true
        });

    });
    // Format 2 Coding ================

    jQuery('div.blog-format2-posts ul li').waypoint(function() {

        var bgc = jQuery(this).data('dbg');
        var c = jQuery(this).data('dc');

        if (bgc != "")
            jQuery(this).find('a.read-more').transition({
                backgroundColor: bgc,
                color: c
            }, 'slow');


    }, {
        offset: '50%',
        triggerOnce: true
    });

    // Format 6 Coding ================

    jQuery('div.blog-format6-posts ul li').waypoint(function() {

        var bgc = jQuery(this).data('dbg');
        var c = jQuery(this).data('dc');

        if (bgc != "") {
            jQuery(this).transition({
                backgroundColor: bgc,
                color: c
            }, 'slow');
            jQuery(this).find('a.read-more').transition({
                borderColor: c,
                color: c
            }, 'slow');
        }

    }, {
        offset: '50%',
        triggerOnce: true
    });


    jQuery('div.blog-format5-posts ul li').waypoint(function() {

        var bgc = jQuery(this).data('dbg');
        var c = jQuery(this).data('dc');

        if (bgc != "")
            jQuery(this).find('a.read-more').transition({
                backgroundColor: bgc,
                color: c
            }, 'slow');
    }, {
        offset: '50%',
        triggerOnce: true
    });

    // Format 7 Coding ================

    win.obj.load(function() {

        jQuery('div.blog-format7-posts ul li').waypoint(function() {

            var te = jQuery(this),
                c = jQuery(this).data('dc');

            if (c != "") {
                te.find('.desc').animate({
                    color: c
                }, 'slow');
                te.find('span.spacer').animate({
                    backgroundColor: c
                }, 'slow');
            }

            te.children('div.overlay').transition({
                height: jQuery(this).height() + 1
            }, 'slow');
        }, {
            offset: '50%',
            triggerOnce: true
        });

    });


    // Blog & Portfolio Format Timeline

    var month, offset = jQuery('div.timeline-post').length,
        position, tesfl, circle = jQuery('span.circle');
    var post_type = circle.data('post_type'),
        line = jQuery('span.line');
    var offset_line = 0,
        distance = 0;

    if (utils.exists('timeline-post')) {


        offset_line = line.position().left
        jQuery('div.left-post').find('span.dot').css("left", (offset_line - 6) + "px");

        if (jQuery('div.right-post').length > 0) {
            distance = jQuery('div.right-post').position().left - offset_line
            jQuery('div.right-post').find('span.dot').css("left", -(distance + 6) + "px");
        }

        circle.css("left", (offset_line - 19) + "px");
        win.obj.load(function() {
            jQuery('div.timeline-post').waypoint(function(dir) {

                if (dir == "down") {
                    var c = jQuery(this).data('dc');
                    var bgc = jQuery(this).data('dbg');

                    if (bgc != "")
                        jQuery(this).find('span.date,a.main-button').transition({
                            color: c,
                            backgroundColor: bgc
                        }, 500);
                    jQuery(this).find('span.tip,span.dot').css({
                        opacity: 0,
                        display: 'block',
                        scale: 0.2
                    }).transition({
                        scale: 1,
                        opacity: 1
                    }, 700, '', function() {


                        jQuery(this).children('span.connector').transition({
                            width: distance
                        }, 400);
                    });
                }

            }, {
                offset: '50%',
                triggerOnce: true
            });
        });

        circle.waypoint(function(direction) {

            if (direction == "down") {

                if (jQuery('.post-end').length > 0) return;


                circle.transition({
                    opacity: 1
                }, 400);
                month = jQuery('div.posts-timeline').find('h4.month-label').last();

                offset = jQuery('div.timeline-post').length;
                jQuery.post(ioa_listener_url, {
                    type: 'posts-timeline',
                    action: 'ioalistener',
                    id: circle.data('id'),
                    post_type: post_type,
                    offset: offset,
                    month: month.data('month')
                }, function(data) {
                    jQuery('span.circle').transition({
                        opacity: 0
                    }, 400);


                    temp = jQuery(jQuery.trim(data));



                    jQuery('div.posts-timeline').append(temp);



                    jQuery('div.posts-timeline').find('div.left-post').find('span.dot').css("left", (offset_line - 6) + "px");
                    jQuery('div.posts-timeline').find('div.right-post').find('span.dot').css("left", -(distance + 6) + "px");

                    offset = jQuery('div.timeline-post').length;

                    ioapreloader(temp, function() {
                        setTimeout(function() {
                            temp.waypoint(function(dir) {

                                if (dir == "down") {
                                    var c = jQuery(this).data('dc');
                                    var bgc = jQuery(this).data('dbg');

                                    if (bgc != "")
                                        jQuery(this).find('span.date,a.main-button').transition({
                                            color: c,
                                            backgroundColor: bgc
                                        }, 600);
                                    jQuery(this).find('span.tip,span.dot').css({
                                        opacity: 0,
                                        display: 'block',
                                        scale: 0.2
                                    }).transition({
                                        scale: 1,
                                        opacity: 1
                                    }, 700, '', function() {
                                        jQuery(this).children('span.connector').transition({
                                            width: distance
                                        }, 400);
                                    });
                                }

                            }, {
                                offset: '50%',
                                triggerOnce: true
                            });

                        }, 50);
                    });
                });




            }

        }, {
            offset: 'bottom-in-view'
        });



    }

    /**
     * All formats common codes
     */

    if (utils.exists('way-animated')) {
        if (win.width <= 1024) {
            jQuery('.way-animated').css('opacity', 1);
        }

        if (win.width > 1024)
            jQuery('.way-animated').waypoint(function(dir) {

                if (dir == "down") {

                    var temp = jQuery(this),
                        effect = temp.data('waycheck'),
                        delay = 0;

                    if (typeof temp.data('delay') != "undefined") delay = parseInt(temp.data('delay'));

                    if (bowser.msie && bowser.version <= 8) effect = 'fade';

                    switch (effect) {
                        case 'fade-left':
                            temp.css({
                                x: -30
                            }).delay(delay).transition({
                                opacity: 1,
                                x: 0
                            }, 400);
                            break;
                        case 'fade-right':
                            temp.css({
                                x: 30
                            }).delay(delay).transition({
                                opacity: 1,
                                x: 0
                            }, 400);
                            break;
                        case 'fade-top':
                            temp.css({
                                y: -30
                            }).delay(delay).transition({
                                opacity: 1,
                                y: 0
                            }, 400);
                            break;
                        case 'fade-bottom':
                            temp.css({
                                y: 30
                            }).delay(delay).transition({
                                opacity: 1,
                                y: 0
                            }, 400);
                            break;

                        case 'big-fade-left':
                            temp.css({
                                x: -100
                            }).delay(delay).transition({
                                opacity: 1,
                                x: 0
                            }, 700);
                            break;
                        case 'big-fade-right':
                            temp.css({
                                x: 100
                            }).delay(delay).transition({
                                opacity: 1,
                                x: 0
                            }, 700);
                            break;
                        case 'big-fade-top':
                            temp.css({
                                y: -100
                            }).delay(delay).transition({
                                opacity: 1,
                                y: 0
                            }, 700);
                            break;
                        case 'big-fade-bottom':
                            temp.css({
                                y: 100
                            }).delay(delay).transition({
                                opacity: 1,
                                y: 0
                            }, 700);
                            break;

                        case 'scale-in':
                            temp.css({
                                scale: 1.5
                            }).delay(delay).transition({
                                opacity: 1,
                                scale: 1
                            }, 400);
                            break;
                        case 'scale-out':
                            temp.css({
                                scale: 0.5
                            }).delay(delay).transition({
                                opacity: 1,
                                scale: 1
                            }, 400);
                            break;

                        case 'fade':
                        default:
                            temp.delay(delay).transition({
                                opacity: 1
                            }, 400);
                    }

                }

            }, {
                offset: '70%',
                triggerOnce: true
            });
    }

    if (utils.exists('chain-animated')) {
        if (win.width <= 1024) {
            jQuery('.chain-animated').find('.chain-link').css('opacity', 1);
        }

        if (win.width > 1024)
            jQuery('.chain-animated').waypoint(function(dir) {

                if (dir == "down") {

                    var temp = jQuery(this),
                        effect = temp.data('chain'),
                        delay = 0;

                    if (bowser.msie && bowser.version <= 8) {
                        temp.find('.chain-link').css("opacity", 1);
                        return;
                    }

                    temp.find('.inner-item-wrap').each(function(i) {
                        delay = i * 100;
                        switch (effect) {
                            case 'fade-left':
                                jQuery(this).css({
                                    x: -30
                                }).delay(delay).transition({
                                    opacity: 1,
                                    x: 0
                                }, 400);
                                break;
                            case 'fade-right':
                                jQuery(this).css({
                                    x: 30
                                }).delay(delay).transition({
                                    opacity: 1,
                                    x: 0
                                }, 400);
                                break;
                            case 'fade-top':
                                jQuery(this).css({
                                    y: -30
                                }).delay(delay).transition({
                                    opacity: 1,
                                    y: 0
                                }, 400);
                                break;
                            case 'fade-bottom':
                                jQuery(this).css({
                                    y: 30
                                }).delay(delay).transition({
                                    opacity: 1,
                                    y: 0
                                }, 400);
                                break;

                            case 'big-fade-left':
                                jQuery(this).css({
                                    x: -100
                                }).delay(delay).transition({
                                    opacity: 1,
                                    x: 0
                                }, 700);
                                break;
                            case 'big-fade-right':
                                jQuery(this).css({
                                    x: 100
                                }).delay(delay).transition({
                                    opacity: 1,
                                    x: 0
                                }, 700);
                                break;
                            case 'big-fade-top':
                                jQuery(this).css({
                                    y: -100
                                }).delay(delay).transition({
                                    opacity: 1,
                                    y: 0
                                }, 700);
                                break;
                            case 'big-fade-bottom':
                                jQuery(this).css({
                                    y: 100
                                }).delay(delay).transition({
                                    opacity: 1,
                                    y: 0
                                }, 700);
                                break;

                            case 'scale-in':
                                jQuery(this).css({
                                    scale: 1.5
                                }).delay(delay).transition({
                                    opacity: 1,
                                    scale: 1
                                }, 400);
                                break;
                            case 'scale-out':
                                jQuery(this).css({
                                    scale: 0.5
                                }).delay(delay).transition({
                                    opacity: 1,
                                    scale: 1
                                }, 400);
                                break;

                            case 'fade':
                            default:
                                jQuery(this).delay(delay).transition({
                                    opacity: 1
                                }, 400);
                        }

                    });

                }

            }, {
                offset: '80%',
                triggerOnce: true
            });
    }

    jQuery('.bx-wrapper .bx-controls-direction a').click(function(e) {
        e.preventDefault();
    });

    jQuery('div.ioa-menu').find('li').each(function() {
        jQuery(this).hoverdir();
    });

    jQuery('div.ioa-menu a').click(function(e) {

        if (!jQuery(this).next().is(':hidden'))
            jQuery(this).next().fadeOut('normal');
        else
            jQuery(this).next().fadeIn('normal');

        e.preventDefault();
    });

    jQuery('div.ioa-menu').hoverIntent(function(e) {
        if (jQuery(this).hasClass('ioa-menu-open')) return;
        jQuery(this).children('ul').fadeIn('normal');
    }, function(e) {
        if (jQuery(this).hasClass('ioa-menu-open')) return;
        jQuery(this).children('ul').fadeOut('normal');
    });

    var hovers = jQuery('div.hoverable  div.image, div.image-frame');

    win.obj.load(function() {



        doc.on('mouseenter', 'div.hoverable  div.image, div.image-frame ', function() {
            var h = jQuery(this).find('.hover'),
                i = h.children('i');

            i.css({
                opacity: 0,
                scale: 0.5
            });
            h.css({
                opacity: 0,
                display: "block"
            }).stop(true, true).transition({
                opacity: 0.9
            }, 500);
            setTimeout(function() {
                h.children('i').transition({
                    opacity: 1,
                    scale: 1
                }, 400);
            }, 60);

        });

        doc.on('mouseleave', 'div.hoverable  div.image, div.image-frame ', function() {
            var h = jQuery(this).find('.hover');
            h.children('a').transition({
                opacity: 0
            }, 400);
            h.transition({
                opacity: 0
            }, 300, '');

        });



    });



    jQuery('ul.single-related-posts li div.image').hover(function() {

        jQuery(this).children('.hover').stop(true, true).fadeIn(400);

    }, function() {

        jQuery(this).children('.hover').stop(true, true).fadeOut(400);

    });

    jQuery('div.portfolio-list ul li').waypoint(function() {

        var c = jQuery(this).find('div.proxy-datearea');
        var p = jQuery(this).prev();

        c.transition({
            height: 101
        }, 900);

    }, {
        offset: '70%',
        triggerOnce: true
    });

    /**
     * Woo Commerce Code
     */
    var button_parent;
    jQuery('body').bind('adding_to_cart', function(evt, button) {

        button_parent = button.parents('.product');
        button.fadeOut('fast');
        button_parent.find('.cart-loader').css({
            marginTop: -15,
            opacity: 0,
            display: 'block'
        }).transition({
            marginTop: 0,
            opacity: 1
        }, 300, '');
        button_parent.find('.product-data').transition({
            opacity: 0.6
        }, 400);

    })

    jQuery('.ajax-cart-trigger').click(function(e) {
        e, preventDefault();
    });

    jQuery('.ajax-cart').hover(function() {

        jQuery('.ajax-cart-items').css({
            marginTop: 15,
            opacity: 0,
            display: 'block'
        }).animate({
            marginTop: 0,
            opacity: 1
        }, 300, '');

    }, function() {

        jQuery('.ajax-cart-items').animate({
            opacity: 0,
            marginTop: 15
        }, 200, '', function() {
            jQuery(this).hide();
        })

    });

    jQuery('body').bind('added_to_cart', function(evt, fragments, cart_hash) {

        button_parent.find('.cart-loader').transition({
            marginTop: -15,
            opacity: 0
        }, 300, '', function() {
            jQuery(this).hide();
        });
        button_parent.find('.product-data').transition({
            opacity: 1
        }, 400);

    })

    jQuery('.show_review_form').click(function() {
        jQuery('#review_form').slideToggle('normal');
    });

    jQuery('.products li').hover(function() {
        obj = jQuery(this);
        obj.find('.button').css({
            marginTop: -15,
            display: "block",
            opacity: 0
        }).transition({
            opacity: 1,
            marginTop: 0
        }, 200);
    }, function() {
        obj = jQuery(this);
        obj.find('.button').transition({
            opacity: 0,
            marginTop: -15
        }, 200, '', function() {
            jQuery(this).hide();
        });


    });

    /**
     * Pagination code
     */

    jQuery('div.pagination-dropdown select').change(function() {

        window.location.href = jQuery(this).val();
    });


    win.obj.load(function() {
        jQuery('div.blog-format4-posts ul li div.post-content-area').each(function() {
            obj = jQuery(this);

            if (obj.height() >= 250) {
                obj.data('height', obj.height());
                obj.animate({
                    height: 250
                }, 'normal');
                obj.parents('li').find('a.bottom-view-toggle').css('visibility', 'visible').transition({
                    opacity: 1
                }, 300);

            } else {
                obj.parents('li').find('a.bottom-view-toggle').remove();
            }


        });
    });


    jQuery('a.bottom-view-toggle').click(function(e) {
        temp = jQuery(this);
        var cl = temp.parent().find('div.post-content-area');
        if (temp.hasClass('down-diricon-')) {
            cl.animate({
                height: cl.data('height')
            }, 'normal');
            temp.addClass('up-diricon-').removeClass('down-diricon-');
        } else {
            cl.animate({
                height: 250
            }, 'normal');
            temp.addClass('down-diricon-').removeClass('up-diricon-');
        }

        e.preventDefault();
    });


    /**
     * Contact Template
     */

    jQuery('div.map-wrapper').hover(function() {

        jQuery(this).children('div.overlay-address-area').stop(true, true).fadeOut(700);

    }, function() {

        jQuery(this).children('div.overlay-address-area').stop(true, true).fadeIn(400);

    });




    if (utils.exists('portfolio-masonry')) {
        if (jQuery('.no-posts-found').length > 0) {
            jQuery('div.portfolio-masonry').css({
                background: 'none',
                'min-height': 0
            });
            jQuery('div.portfolio-masonry ul').transition({
                opacity: 1
            }, 300);
        } else {
            var masonry_items = jQuery('div.portfolio-masonry ul li');
            masonry_items.find('.image').each(function() {
                jQuery(this).hoverdir()
            });



            win.obj.load(function() {


                masonry_items.each(function(i) {
                    temp = jQuery(this);
                    temp.find('.loader').remove();
                    temp.find('.inner-item-wrap').delay(i * 50).transition({
                        opacity: 1
                    });

                });

            });
        }

    }

    var portfolio_posts = super_wrapper.find('.portfolio_posts');

    if (win.width <= 1024) {
        jQuery('.theme-header .menu a').on('click touchend', function(e) {
            var el = jQuery(this);
            var link = el.attr('href');
            if (link === "#" || link === "http://#" || el.parent().children('.sub-menu').length > 0) return;
            window.location = link;
        });
    }

    jQuery('div.ioa-menu ul li').on('touchend', function(e) {
        jQuery(this).trigger('click');
    });


    if (utils.exists('metro-wrapper')) {

        var metro_lists = jQuery('div.portfolio-metro ul'),
            metro_items = metro_lists.children();


        if (bowser.msie && bowser.version <= 8) {
            metro_items.each(function() {
                jQuery(this).find('div.image-wrap').width(jQuery(this).find('div.image-wrap img').width());
            });
        }

        var testwidth = metro_lists.first().width();
        if (jQuery('.no-posts-found').length == 0) {


            if (win.width > 767) {

                if (metro_lists.last().width() > testwidth) testwidth = metro_lists.last().width();

                jQuery('div.portfolio-metro').width(testwidth);
                metro_lists.css('display', 'block');


                win.obj.load(function() {
                    jQuery('div.portfolio-metro').height(metro_lists.height() * 2);
                    jQuery('div.metro-wrapper').jScrollPane({
                        animateScroll: false,
                        mouseWheelSpeed: 80
                    });
                    metro_items.each(function(i) {

                        temp = jQuery(this);
                        temp.css({
                            scale: 0.5
                        }).delay(i * 20).transition({
                            opacity: 1,
                            scale: 1
                        }, 700);

                    });
                    jQuery('.jspHorizontalBar').animate({
                        height: 25
                    }, 'fast');
                    jQuery('.jspDrag').stop(true, true).animate({
                        height: 22
                    }, 'fast');
                });

            } else {
                metro_items.css('opacity', 1);
            }

        } else {
            metro_lists.css('display', 'block');
            jQuery('div.portfolio-metro').css('width', 'auto');
        }

    }
    /**
     * Portfolio Featured
     */

    if (utils.exists('featured-column')) {
        jQuery('li.featured-block').hover(function() {
            jQuery(this).find('div.overlay').transition({
                scale: 0,
                opacity: 0
            }, 300);
        }, function() {
            jQuery(this).find('div.overlay').transition({
                scale: 1,
                opacity: 1
            }, 300);
        });

        jQuery('div.featured-column ul li').waypoint(function(dir) {

            if (dir == "down") {
                var c = jQuery(this).data('dc');
                var bgc = jQuery(this).data('dbg');

                if (bgc != "") {
                    jQuery(this).find('div.title-area,a.read-more').animate({
                        color: c,
                        backgroundColor: bgc
                    }, 'slow');
                    jQuery(this).find('div.desc').animate({
                        borderColor: bgc
                    }, 'slow');

                }
            }

        }, {
            offset: '80%',
            triggerOnce: true
        });
    }



    /**
     * Portfolio Modelie
     */


    /**
     * Scroll Pane usability
     */


    if (utils.exists('portfolio-modelie')) {
        var la, modelie_wrap = jQuery('div.portfolio-modelie'),
            view_pane = modelie_wrap.find('div.view-pane'),
            view_data, view_scroll, modelie_list = modelie_wrap.find('ul');
        var calc_height = win.height - (jQuery('div.theme-header').height());


        var compute_width = 0,
            current_loader, testable_width = responsive.width;

        if (jQuery('.inner-super-wrapper').hasClass('ioa-boxed-layout')) testable_width = modelie_wrap.width();

        if (calc_height < 200) calc_height = 250;

        jQuery.post(ioa_listener_url, {
            type: 'portfolio_modelie',
            action: 'ioalistener',
            id: view_pane.data('id'),
            offset: modelie_list.children('li.post').length,
            height: calc_height - 20,
            width: responsive.width
        }, function(data) {

            jQuery('div.view-pane ul li.span-class').remove();
            modelie_list.append(data);

            view_pane.children('.loader').remove();
            ioapreloader(modelie_list, function() {
                modelie_list.children('li').each(function() {
                    temp = jQuery(this);
                    temp.height(calc_height - 20);
                    la = temp.find('a.hover-lightbox');
                    compute_width += jQuery(this).outerWidth();
                    la.css({
                        top: temp.height() / 2 - la.height() / 2 - 25,
                        left: temp.width() / 2 - la.width() / 2 - 25
                    });

                });

                if (responsive.width > 767) {
                    view_pane.height(calc_height - 20);

                    modelie_list.width(compute_width);
                    setTimeout(function() {


                        view_scroll = view_pane.jScrollPane({
                            mouseWheelSpeed: 100
                        });
                        view_data = view_scroll.data('jsp');

                        modelie_list.children('li').each(function(i) {
                            temp = jQuery(this);
                            temp.css('background-image', 'none');
                            temp.find('.loader').remove();
                            temp.children('.inner-item-wrap').stop(true, true).delay(i * 90).transition({
                                opacity: 1
                            }, 700);

                        });

                        jQuery('.jspHorizontalBar').animate({
                            height: 25
                        }, 'fast');
                        jQuery('.jspDrag').stop(true, true).animate({
                            height: 22
                        }, 'fast');

                        if (bowser.msie && bowser.version <= 8) {
                            setTimeout(function() {
                                jQuery('.jspHorizontalBar').animate({
                                    height: 25
                                }, 'fast');
                                jQuery('.jspDrag').stop(true, true).animate({
                                    height: 22
                                }, 'fast');
                            }, 300);
                        }
                    }, 40);

                } else {
                    modelie_list.find('.inner-item-wrap').css("opacity", 1);
                    modelie_list.find('.loader').remove();
                }

            });



        });

        doc.on('click', 'a.load-more-posts-button', function(e) {
            e.preventDefault()
            current_loader = jQuery(this);
            current_loader.html(current_loader.data('loading'));

            jQuery.post(ioa_listener_url, {
                type: 'portfolio_modelie',
                action: 'ioalistener',
                width: responsive.width,
                id: view_pane.data('id'),
                offset: modelie_list.children('li.post').length,
                height: calc_height - 20
            }, function(data) {



                var test = jQuery(jQuery.trim(data));

                if (!test.hasClass('end-more-posts')) {

                    if (responsive.width > 767) {

                        modelie_list.css("width", "20000em");
                        modelie_list.append(test);
                        compute_width = 0;


                        ioapreloader(modelie_list, function() {

                            current_loader.parent().animate({
                                width: 0
                            }, 'normal', function() {
                                jQuery(this).remove();

                                modelie_list.children('li').each(function() {
                                    temp = jQuery(this);
                                    temp.height(calc_height - 20);
                                    la = temp.find('a.hover-lightbox');
                                    compute_width += jQuery(this).outerWidth();

                                    la.css({
                                        top: temp.height() / 2 - la.height() / 2 - 25,
                                        left: temp.width() / 2 - la.width() / 2 - 25
                                    });

                                });
                                modelie_list.width(compute_width);
                                setTimeout(function() {

                                    view_data.reinitialise();
                                    test.each(function(i) {

                                        temp = jQuery(this);
                                        temp.css('background-image', 'none');
                                        temp.find('.loader').remove();

                                        temp.children('.inner-item-wrap').stop(true, true).delay(i * 90).transition({
                                            opacity: 1
                                        }, 700);

                                    });
                                    view_data.scrollByX(testable_width - 400, true);
                                    jQuery('.jspHorizontalBar').animate({
                                        height: 25
                                    }, 'fast');
                                    jQuery('.jspDrag').stop(true, true).animate({
                                        height: 22
                                    }, 'fast');


                                }, 40);

                            });

                        });

                    } else {
                        current_loader.parent().animate({
                            width: 0
                        }, 'normal', function() {
                            jQuery(this).remove();
                            modelie_list.append(test);
                            modelie_list.find('.loader').remove();

                            modelie_list.find('.inner-item-wrap').css("opacity", 1);
                        });
                    }



                } else {
                    current_loader.parent().replaceWith(test);
                    test.stop(true, true).delay(i * 90).transition({
                        opacity: 1
                    }, 700);
                }

            });

        });



        jQuery(document).on('mouseenter', 'div.view-pane li div.image', function() {

            jQuery(this).children('.hover').stop(true, true).fadeIn(400);

        });


        jQuery(document).on('mouseleave', 'div.view-pane li div.image', function() {

            jQuery(this).children('.hover').stop(true, true).fadeOut(400);

        });

    }



    /**
     * Portfolio Full Screen
     */

    if (utils.exists('portfolio-full-screen')) {

        var fs_wrap = jQuery('div.portfolio-full-screen'),
            fsview_pane = fs_wrap.find('div.full-screen-view-pane');
        var calc_height = win.height - (jQuery('div.theme-header').height());
        if (calc_height < 200) calc_height = 250;
        jQuery.post(ioa_listener_url, {
            type: 'portfolio_fullscreen',
            action: 'ioalistener',
            id: jQuery('.full-screen-view-pane').data('id'),
            height: calc_height - 83,
            width: win.width
        }, function(data) {


            if (jQuery(data).find('.no-posts-found').length == 0) {
                fsview_pane.append(data);
                fsview_pane.find('.ioa-gallery').seleneGallery({
                    domMapping: true
                });
            } else
                fsview_pane.html(jQuery(data).find('.gallery-holder').html());

        })


    }


    /**
     * Portfolio Maerya
     */

    if (utils.exists('portfolio-maerya-list')) {

        if (jQuery('.no-posts-found').length == 0) {

            var dybg, dyc, current_obj = null,
                maerya_list = jQuery('ul.portfolio-maerya-list li'),
                check_flag = false,
                dynamic = jQuery('div.dynamic-content');
            maerya_list.width(maerya_list.parent().width() / 4);
            win.obj.on("debouncedresize", function(event) {

                if (current_obj)
                    jQuery('.portfolio-maerya-wrap .close-section').trigger('click');

                maerya_list.width(maerya_list.parent().width() / 4);
                maerya_list.data('width', maerya_list.width());

            });
            maerya_list.hover(function() {
                if (check_flag) return;

                jQuery(this).find('.hover').stop(true, true).transition({
                    height: 470
                }, 400);

            }, function() {

                jQuery(this).find('.hover').stop(true, true).transition({
                    height: 0
                }, 400);

            });

            maerya_list.find('a').click(function(e) {
                if (responsive.width > 767) e.preventDefault();
            });
            maerya_list.data('width', maerya_list.width());
            maerya_list.click(function() {

                current_obj = jQuery(this);

                if (responsive.width < 767) {
                    window.location.href = current_obj.find('h2 a').attr('href');
                    return;
                }

                if (bowser.msie && bowser.version <= 8)
                    current_obj.find('div.stub').transition({
                        left: -(maerya_list.width() + 4)
                    }, 500);
                else
                    current_obj.find('div.stub').transition({
                        x: -(maerya_list.width() + 4)
                    }, 500);

                maerya_list.not(current_obj).transition({
                    width: 0
                }, 500);
                current_obj.transition({
                    width: current_obj.parent().width()
                }, 500);

                jQuery('.portfolio-maerya-wrap .close-section').fadeIn('fast');

                var temp = jQuery(this).find('div.meta-info');

                check_flag = true;
                current_obj.find('.hover').stop(true, true).transition({
                    height: 0
                }, 400, '', function() {

                });
                dybg = temp.css('background-color');
                dyc = temp.css('color');

                if (!dybg || dybg === "" || dybg === "transparent") dybg = '';
                if (!dyc || dyc === "" || dyc === "transparent") dyc = 'inherit';

                dynamic.css({
                    backgroundColor: dybg,
                    color: dyc
                });


                dynamic.html(temp.html());
                dynamic.show();

                if (bowser.msie && bowser.version <= 8)
                    setTimeout(function() {
                        dynamic.transition({
                            top: -(maerya_list.height() + 4)
                        }, 400, '');
                        dynamic.prev().transition({
                            top: -(maerya_list.height() + 4)
                        }, 400, '');
                    }, 300);
                else
                    setTimeout(function() {
                        dynamic.transition({
                            y: -(maerya_list.height() + 4)
                        }, 400, '');
                        dynamic.prev().transition({
                            y: -(maerya_list.height() + 4)
                        }, 400, '');
                    }, 300);


            });

            doc.on('click', 'a.close-section', function(e) {
                e.preventDefault();

                if (bowser.msie && bowser.version <= 8) {
                    dynamic.transition({
                        top: 0
                    }, 400, '', function() {
                        dynamic.html('');
                    });
                    dynamic.prev().transition({
                        top: 0
                    }, 400, '');
                } else {
                    dynamic.transition({
                        y: 0
                    }, 400, '', function() {
                        dynamic.html('');
                    });
                    dynamic.prev().transition({
                        y: 0
                    }, 400, '');
                }

                setTimeout(function() {

                    if (bowser.msie && bowser.version <= 8)
                        current_obj.find('div.stub').transition({
                            left: 0
                        }, 500);
                    else
                        current_obj.find('div.stub').transition({
                            x: 0
                        }, 500);


                    maerya_list.transition({
                        width: parseInt(maerya_list.data('width')) - 0.5
                    }, 500);



                }, 300);
                jQuery(this).fadeOut('fast');
                check_flag = false;

            });

        } else {
            jQuery('div.portfolio-maerya div.three_fourth').css('height', 'auto').removeClass('three_fourth left');
            jQuery('div.portfolio-maerya div.one_fourth').hide();
        }

    }


    if (utils.exists('climacon-shortcode')) {


        var cl = null;
        if (!(bowser.msie && bowser.version <= 8)) {
            jQuery('.climacon-shortcode').each(function() {

                switch (jQuery(this).data('type')) {
                    case "rain":
                        cl = Skycons.RAIN;
                        break;
                    case "partly cloudy day":
                        cl = Skycons.PARTLY_CLOUDY_DAY;
                        break;
                    case "partly cloudy night":
                        cl = Skycons.PARTLY_CLOUDY_NIGHT;
                        break;
                    case "clear day":
                        cl = Skycons.CLEAR_DAY;
                        break;
                    case "clear night":
                        cl = Skycons.CLEAR_NIGHT;
                        break;
                    case "cloudy":
                        cl = Skycons.CLOUDY;
                        break;
                    case "fog":
                        cl = Skycons.FOG;
                        break;
                    case "sleet":
                        cl = Skycons.SLEET;
                        break;

                    case "snow":
                        cl = Skycons.SNOW;
                        break;
                    case "wind":
                        cl = Skycons.WIND;
                        break;

                }
                var skycons = new Skycons({
                    "color": jQuery(this).data('color')
                });
                skycons.add(this, cl);
                skycons.play();

            });
        } else {
            jQuery('.climacon-shortcode').each(function() {

                switch (jQuery(this).data('type')) {
                    case "rain":
                        cl = "rain";
                        break;
                    case "partly cloudy day":
                        cl = "partly_cloudy_day";
                        break;
                    case "partly cloudy night":
                        cl = "partly_cloudy_night";
                        break;
                    case "clear day":
                        cl = "clear_day";
                        break;
                    case "clear night":
                        cl = "clear_night";
                        break;
                    case "cloudy":
                        cl = "cloudy";
                        break;
                    case "fog":
                        cl = "fog";
                        break;
                    case "sleet":
                        cl = "sleet";
                        break;

                    case "snow":
                        cl = "snow";
                        break;
                    case "wind":
                        cl = "wind";
                        break;

                }

                jQuery(this).replaceWith('<div class="climafallback"><img src="' + theme_url + '/sprites/i/' + cl + '.jpg" alt="climate image" width="' + jQuery(this).attr('width') + '" height="' + jQuery(this).attr('height') + '" /></div>');

            });

        }

    }

    /**
     * Back to Top Button
     */


    jQuery('a.back-to-top').click(function(e) {
        e.preventDefault();
        jQuery('body,html').animate({
            scrollTop: 0
        }, 'normal');
    });

    if (jQuery("a[rel^='prettyPhoto']").length > 0 && jQuery('.rad-page-section').length == 0)
        jQuery("a[rel^='prettyPhoto']").prettyPhoto({
            social_tools: '',
            theme: 'light_square'
        });

    if (jQuery('.rad-page-section').length == 0)
        jQuery(".gallery-icon>a").prettyPhoto({
            social_tools: '',
            theme: 'light_square'
        });



    /**
     * Single Portfolio Coding
     */

    if (utils.exists('single-prop-screen-view-pane')) {

        var fsview_pane = jQuery('div.single-prop-screen-view-pane');
        var calc_height = win.height - (jQuery('div.theme-header').height());
        if (calc_height < 200) calc_height = 250;

        jQuery.post(ioa_listener_url, {
            type: 'single_portfolio_fullscreen',
            action: 'ioalistener',
            id: jQuery('.single-prop-screen-view-pane').data('id'),
            height: calc_height - 83,
            width: win.width
        }, function(data) {

            fsview_pane.append(data);
            fsview_pane.find('.ioa-gallery').seleneGallery({
                domMapping: true
            });

        })


    }


    if (utils.exists('single-full-screen-view-pane')) {

        var fsview_pane = jQuery('div.single-full-screen-view-pane');
        var calc_height = win.height - (jQuery('div.theme-header').height()) - 83;
        if (calc_height < 200) calc_height = 250;

        fsview_pane.find('.spfs-gallery').seleneGallery({
            effect_type: 'fade',
            width: win.width,
            height: calc_height,
            duration: 5000,
            autoplay: false,
            captions: true,
            arrow_control: true,
            thumbnails: true
        });


    }


    if (utils.exists('single-portfolio-modelie')) {
        var la, modelie_wrap = jQuery('div.single-portfolio-modelie'),
            view_pane = modelie_wrap.find('div.view-pane'),
            modelie_list = modelie_wrap.find('ul.portfolio_posts');
        var calc_height = jQuery(window).height() - (jQuery('div.theme-header').height());
        if (calc_height < 200) calc_height = 250;

        var compute_width = 0;

        view_pane.scroll(function(event) {
            /* Act on the event */
            event.stopImmediatePropagation();
            return false;
        });

        jQuery.post(ioa_listener_url, {
            type: 'single_portfolio_modelie',
            action: 'ioalistener',
            id: view_pane.data('id'),
            height: calc_height - 20,
            width: responsive.width
        }, function(data) {

            view_pane.children('.loader').remove();
            modelie_list.html(data);

            if (responsive.width > 767) {

                ioapreloader(modelie_list, function() {
                    view_pane.height(calc_height - 10);
                    modelie_list.children('li').each(function() {
                        temp = jQuery(this);
                        temp.height(calc_height - 10);

                        compute_width += jQuery(this).outerWidth();

                    });

                    modelie_list.width(compute_width);

                    setTimeout(function() {

                        view_scroll = view_pane.jScrollPane({
                            mouseWheelSpeed: 100
                        });
                        view_data = view_scroll.data('jsp');
                        modelie_list.children('li').each(function(i) {
                            temp = jQuery(this);
                            temp.css('background-image', 'none');
                            temp.find('.loader').remove();
                            temp.children('.inner-item-wrap').stop(true, true).delay(i * 90).transition({
                                opacity: 1
                            }, 700);

                        });
                        jQuery('.jspHorizontalBar').animate({
                            height: 25
                        }, 'fast');
                        jQuery('.jspDrag').stop(true, true).animate({
                            height: 22
                        }, 'fast');

                    }, 40);

                    setTimeout(function() {

                        view_pane.find('.jspDrag').transition({
                            backgroundColor: view_pane.data('dc')
                        }, 400);

                    }, 2000);

                });

            } else {
                modelie_list.find('.inner-item-wrap').css('opacity', 1);
                modelie_list.find('.loader').remove();
            }


        });


    }

    if (jQuery('.tweets-wrapper.slider ul').length > 0)
        jQuery('.tweets-wrapper.slider ul').bxSlider({
            mode: 'fade',
            adaptiveHeight: true,

            pager: false,
            auto: true
        });

    /**
     * Graphs overlay toggle
     */

    doc.on('click', '.graph-info-toggle', function() {

        if (jQuery(this).hasClass('info-2icon-'))
            jQuery(this).addClass('cancel-2icon-').removeClass('info-2icon-');
        else
            jQuery(this).removeClass('cancel-2icon-').addClass('info-2icon-');

        jQuery(this).parent().children('.info-area').fadeToggle('normal');
    });

    /**
     * Prop Manager
     */


    win.obj.load(function() {

        jQuery('.prop-wrapper').each(function() {

            jQuery(this).data({
                width: jQuery(this).width(),
                height: jQuery(this).height()
            });

            jQuery(this).css({
                width: jQuery(this).width() * responsive.ratio,
                height: jQuery(this).height() * responsive.ratio
            });

            jQuery(this).find('.prop').each(function() {

                t = jQuery(this);
                i = t.children('img');

                t.css({

                    top: t.data('top') * responsive.ratio,
                    left: t.data('left') * responsive.ratio

                });
                i.data({
                    width: i.width(),
                    height: i.height()
                });
                i.css({
                    width: i.width() * responsive.ratio,
                    height: i.height() * responsive.ratio
                });


            });

        });

        if (win.width <= 1024)
            jQuery('div.prop-wrapper').children().each(function() {
                jQuery(this).css('opacity', 1);
            });

        if (win.width > 1024)
            jQuery('div.prop-wrapper').waypoint(function() {

                var prop, props = jQuery(this),
                    effect;

                props.children().each(function(i) {

                    prop = jQuery(this);
                    prop.css("z-index", i + 1);

                    effect = prop.data('effect');
                    switch (effect) {
                        case 'fade-left':
                            prop.css({
                                x: -30
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                x: 0
                            }, 400);
                            break;
                        case 'fade-right':
                            prop.css({
                                x: 30
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                x: 0
                            }, 400);
                            break;
                        case 'fade-top':
                            prop.css({
                                y: -30
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                y: 0
                            }, 400);
                            break;
                        case 'fade-bottom':
                            prop.css({
                                y: 30
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                y: 0
                            }, 400);
                            break;

                        case 'big-fade-left':
                            prop.css({
                                x: -100
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                x: 0
                            }, 700);
                            break;
                        case 'big-fade-right':
                            prop.css({
                                x: 100
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                x: 0
                            }, 700);
                            break;
                        case 'big-fade-top':
                            prop.css({
                                y: -100
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                y: 0
                            }, 700);
                            break;
                        case 'big-fade-bottom':
                            prop.css({
                                y: 100
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                y: 0
                            }, 700);
                            break;

                        case 'scale-in':
                            prop.css({
                                scale: 1.5
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                scale: 1
                            }, 400);
                            break;
                        case 'scale-out':
                            prop.css({
                                scale: 0.5
                            }).delay(prop.data('delay')).transition({
                                opacity: 1,
                                scale: 1
                            }, 400);
                            break;

                        case 'fade':
                        default:
                            prop.delay(prop.data('delay')).transition({
                                opacity: 1
                            }, 400);
                    }



                });

            }, {
                offset: '70%',
                triggerOnce: true
            });

    });


    /**
     * Mobile Search
     */

    var msearch_parent = jQuery('div.majax-search'),
        msearch_loader = msearch_parent.find('span.msearch-loader');

    jQuery('.majax-search-pane input[type=text]').keyup(function(e) {
        var val = jQuery(this).val().length;

        if (e.keyCode == 27) {
            jQuery('a.majax-search-trigger').trigger('click');
            return;
        }

        if (val >= 2) {

            msearch_loader.fadeIn('fast');
            jQuery.post(msearch_parent.data('url'), {
                type: 'search',
                action: 'ioalistener',
                query: jQuery(this).val()
            }, function(data) {
                if (jQuery.trim(data) == "") return;


                msearch_parent.find('.no-results').fadeOut('fast');
                msearch_parent.find('.msearch-results ul').html(data);
                msearch_parent.find('div.msearch-results').stop(true, true).fadeIn('fast', function() {
                    msearch_loader.fadeOut('fast');
                });

            });

        } else {
            msearch_parent.find('div.msearch-results').hide();
            msearch_parent.find('.msearch-results ul').html('');

        }

    });


    jQuery('a.majax-search-trigger').click(function(e) {
        e.preventDefault();
        temp = msearch_parent.find('div.majax-search-pane');

        if (temp.is(":hidden")) {
            jQuery('a.majax-search-trigger').addClass('active');
            jQuery('body,html').animate({
                scrollTop: 0
            }, 'normal');
        } else {
            jQuery('a.majax-search-trigger').removeClass('active');
        }
        temp.stop(true, true).slideToggle('normal');

    });

    jQuery('a.majax-search-close').click(function(e) {
        e.preventDefault();
        temp.stop(true, true).slideToggle('normal');
        jQuery('a.majax-search-trigger').removeClass('active');
    });


    /**
     * Person Code
     */

    jQuery('.person-info-toggle').click(function() {

        if (jQuery(this).hasClass('info-2icon-')) {
            jQuery(this).addClass('cancel-2icon-').removeClass('info-2icon-');
            jQuery(this).parent().children('.desc').css({
                opacity: 0,
                scale: 0.5,
                display: "block"
            }).transition({
                opacity: 0.95,
                scale: 1
            }, 400);
        } else {
            jQuery(this).removeClass('cancel-2icon-').addClass('info-2icon-');
            jQuery(this).parent().children('.desc').transition({
                opacity: 0,
                scale: 0
            }, 400);

        }


    });

    if (utils.exists('menu-centered')) {
        jQuery('.menu-centered .menu,.menu-centered .top-area-social-list').each(function() {
            Menu_builder.center(jQuery(this));
        });
    }


    function PageWidgets(obj) {
        var t, n, minx, vals;
        obj.find('.way-animated, .chain-animated .chain-link').css("opacity", 1);
        obj.find(".ioa_tabs").tabs({
            show: {
                effect: "fadeIn",
                duration: 300
            }
        });
        obj.find(".ioa_accordion").accordion({
            create: function(event, ui) {
                ui.header.find('i').removeClass('down-diricon-').addClass('up-diricon-')
            },
            beforeActivate: function(event, ui) {
                ui.newHeader.find('i').removeClass('down-diricon-').addClass('up-diricon-');
                ui.oldHeader.find('i').addClass('down-diricon-').removeClass('up-diricon-');
            },
            heightStyle: "content"
        });
        obj.find('.ioa-gallery').seleneGallery({
            domMapping: true
        });
        obj.find('.ioaslider').quartzSlider({
            domMapping: true
        });
        obj.find('ul.rad-testimonials-list').bxSlider({
            mode: 'horizontal',
            adaptiveHeight: true,

            pager: false,
            auto: true
        });
        obj.find('.isotope').isotope(iso_opts);
        obj.find('.scrollable').each(function() {

            t = jQuery(this).parent().width();
            n = jQuery(this).children().width() + 20;
            minx = Math.ceil(t / n);
            //console.log(t+" "+n+minx);
            jQuery(this).bxSlider({
                slideWidth: n,
                maxSlides: minx,
                moveSlides: minx,
                infiniteLoop: false,
                slideMargin: 20,

                pager: false
            });

        });

        obj.find('.line-chart-wrap').each(function() {
            temp = jQuery(this), vals;
            var ds = [];
            temp.find('.line-val').each(function(i) {
                vals = jQuery(this).data('values').toString();

                if (vals.indexOf(',') != -1) {
                    vals = vals.split(',');
                } else
                    vals = [parseInt(vals)];

                for (var j = 0; j < vals.length; j++) vals[j] = parseInt(vals[j]);

                ds[i] = {
                    fillColor: jQuery(this).data('fillcolor'),
                    strokeColor: jQuery(this).data('strokecolor'),
                    pointColor: jQuery(this).data('pointcolor'),
                    pointStrokeColor: jQuery(this).data('pointstrokecolor'),
                    data: vals
                };

            });

            var data = {
                labels: temp.data('labels').split(','),
                datasets: ds
            }


            var ctx = temp.children('canvas')[0].getContext("2d");
            var myNewChart = new Chart(ctx);

            var options = {};
            if (bowser.msie && bowser.version <= 8) options.animation = false;

            new Chart(ctx).Line(data, options);
        });

        obj.find('.progress-bar-group').each(function() {

            jQuery(this).find('div.progress-bar').each(function(i) {

                jQuery(this).find('div.filler').delay(i * 100).transition({
                    opacity: 1,
                    width: parseInt(jQuery(this).find('div.filler').data('fill')) + "%"
                }, 1500, 'easeInOutQuint', function() {
                    jQuery(this).children().fadeIn('fast');
                });
            });

        });

        obj.find('.polar-chart-wrap').each(function() {
            temp = jQuery(this);
            var ds = [],
                total = 0;
            temp.find('.polar-val').each(function(i) {

                total += parseInt(jQuery(this).data('value'));

            });
            temp.find('.polar-val').each(function(j) {

                ds[j] = {
                    value: parseInt(jQuery(this).data('value')),
                    color: jQuery(this).data('fillcolor')
                };

                jQuery(this).children('.block').html(Math.round(parseInt(jQuery(this).data('value')) / total * 1000) / 10 + "%");
            });

            var ctx = temp.children('canvas')[0].getContext("2d");
            var myNewChart = new Chart(ctx);

            var options = {};
            if (bowser.msie && bowser.version <= 8) options.animation = false;

            new Chart(ctx).PolarArea(ds, options);

        });

        obj.find('.pie-chart-wrap').each(function() {

            temp = jQuery(this);
            var ds = [],
                total = 0;
            temp.find('.pie-val').each(function(i) {

                total += parseInt(jQuery(this).data('value'));

            });
            temp.find('.pie-val').each(function(i) {

                ds[i] = {
                    color: jQuery(this).data('fillcolor'),
                    value: jQuery(this).data('value')
                };
                jQuery(this).children('.block').html(Math.round(parseInt(jQuery(this).data('value')) / total * 1000) / 10 + "%");

            });
            var ctx = temp.children('canvas')[0].getContext("2d");
            var myNewChart = new Chart(ctx);
            new Chart(ctx).Pie(ds, {
                animateScale: true,
                animationEasing: "easeOutExpo"
            });

        });

        obj.find('.donut-chart-wrap').each(function() {
            temp = jQuery(this);
            temp = jQuery(this);
            var ds = [],
                total = 0;
            temp.find('.donut-val').each(function(i) {

                total += parseInt(jQuery(this).data('value'));

            });
            temp.find('.donut-val').each(function(i) {

                ds[i] = {
                    color: jQuery(this).data('fillcolor'),
                    value: jQuery(this).data('value')
                };

                jQuery(this).children('.block').html(Math.round(parseInt(jQuery(this).data('value')) / total * 1000) / 10 + "%");
            });

            var ctx = temp.children('canvas')[0].getContext("2d");
            var myNewChart = new Chart(ctx);
            new Chart(ctx).Doughnut(ds, {
                animationEasing: "easeOutExpo"
            });
        });

        obj.find('.bar-chart-wrap').each(function() {
            temp = jQuery(this);
            var ds = [],
                j;
            temp.find('.bar-val').each(function(i) {
                vals = jQuery(this).data('values').toString();

                if (vals.indexOf(',') != -1) {
                    vals = vals.split(',');
                } else
                    vals = [parseInt(vals)];
                for (var j = 0; j < vals.length; j++) vals[j] = parseInt(vals[j]);

                ds[i] = {
                    fillColor: jQuery(this).data('fillcolor'),
                    strokeColor: jQuery(this).data('strokecolor'),
                    data: vals
                };

            });

            var data = {
                labels: temp.data('labels').split(','),
                datasets: ds
            }

            var ctx = temp.children('canvas')[0].getContext("2d");
            var myNewChart = new Chart(ctx);

            var options = {};
            if (bowser.msie && bowser.version <= 8) options.animation = false;

            new Chart(ctx).Bar(data, options);
        });

        obj.find('div.circles-group').each(function() {

            var parentw = jQuery(this).width();

            if (parentw >= jQuery(this).parent().width()) {
                parentw = jQuery(this).parent().width();
                jQuery(this).width(parentw);
                jQuery(this).height(parentw);
            }

            jQuery(this).find('div.circle').each(function(j) {
                jQuery(this).css({
                    "left": (parentw - parseInt(jQuery(this).data('fill')) / 100 * parentw) / 2,
                    scale: 0.2
                });
                jQuery(this).delay(j * 100).transition({
                    opacity: 1,
                    scale: 1,
                    width: parseInt(jQuery(this).data('fill')) + "%",
                    height: parseInt(jQuery(this).data('fill')) + "%"
                }, 500);

            });

        });


        obj.find('.radial-chart').each(function() {
            w = jQuery(this).data('width');
            if (w > jQuery(this).width()) w = jQuery(this).width() - 20;
            jQuery(this).easyPieChart({
                size: w,
                lineWidth: jQuery(this).data('line_width'),
                barColor: jQuery(this).data('bar_color'),
                trackColor: jQuery(this).data('track_color'),
                scaleColor: false,
                lineCap: "butt",
                animate: 2000
            }).data('easyPieChart').update(jQuery(this).data('start_percent'));

        });

    }

    win.obj.on("debouncedresize", function(event) {
        responsive.ratio = jQuery('.skeleton').width() / 1060;
        responsive.width = win.obj.width();
        responsive.height = win.obj.height();
        if (responsive.width < 767) {
            responsive.ratio = (win.obj.width() * 0.7) / 1060;

        }
        resizable();
    });

    window.onorientationchange = function() {
        responsive.ratio = jQuery('.skeleton').width() / 1060;
        responsive.width = win.obj.width();
        responsive.height = win.obj.height();
        if (responsive.width < 767) {
            responsive.ratio = (win.obj.width() * 0.7) / 1060;

        }
        resizable();
        setTimeout(function() {
            resizable();
        }, 150);
    };


    function resizable() {
        var t, i, k;

        if (jQuery('.isotope').length > 0 && jQuery('.rad-page-section').length == 0)

            jQuery('.isotope').isotope('reLayout');


        if (responsive.width > 767)
            jQuery('#mobile-menu').hide();

        if (utils.exists('prop-wrapper')) {

            jQuery('.prop-wrapper').each(function() {

                jQuery(this).css({
                    width: jQuery(this).data('width') * responsive.ratio,
                    height: jQuery(this).data('height') * responsive.ratio
                });

                jQuery(this).find('.prop').each(function() {

                    t = jQuery(this);
                    i = t.children('img');

                    t.css({

                        top: t.data('top') * responsive.ratio,
                        left: t.data('left') * responsive.ratio

                    });

                    i.css({
                        width: i.data('width') * responsive.ratio,
                        height: i.data('height') * responsive.ratio
                    });

                });

            });

        }

        if (utils.exists('single-portfolio-modelie')) {
            var la, modelie_wrap = jQuery('div.single-portfolio-modelie'),
                view_pane = modelie_wrap.find('div.view-pane'),
                view_data, modelie_list = modelie_wrap.find('ul');
            var compute_width = 0,
                calc_height = win.height - (jQuery('div.theme-header').height());
            if (calc_height < 200) calc_height = 250;
            if (responsive.width > 767) {
                view_pane.width(responsive.width);
                modelie_wrap.find('ul.portfolio_posts li').each(function() {
                    compute_width += jQuery(this).outerWidth();
                });
                modelie_list.width(compute_width);
                view_pane.height(calc_height - 10);
                view_pane.jScrollPane({
                    mouseWheelSpeed: 100
                });

                jQuery('.jspHorizontalBar').animate({
                    height: 25
                }, 'fast');
                jQuery('.jspDrag').stop(true, true).animate({
                    height: 22
                }, 'fast');

            } else {
                view_data = jQuery('div.view-pane').data('jsp');
                if (view_data) {
                    view_data.destroy();
                }
                modelie_list.width(responsive.width);
                view_pane.css('height', 'auto');
            }
        }

        if (utils.exists('portfolio-modelie')) {
            var la, modelie_wrap = jQuery('div.portfolio-modelie'),
                view_pane = modelie_wrap.find('div.view-pane'),
                view_data, modelie_list = modelie_wrap.find('ul');
            var compute_width = 0,
                calc_height = win.height - (jQuery('div.theme-header').height());
            if (calc_height < 200) calc_height = 250;

            if (responsive.width > 767) {
                view_pane.width(responsive.width);
                view_pane.height(calc_height - 16);

                modelie_list.children('li').each(function() {
                    temp = jQuery(this);
                    la = temp.find('a.hover-lightbox');
                    compute_width += jQuery(this).outerWidth();
                    la.css({
                        top: temp.height() / 2 - la.height() / 2 - 25,
                        left: temp.width() / 2 - la.width() / 2 - 25
                    });

                });
                modelie_list.width(compute_width);
                view_pane.jScrollPane({
                    mouseWheelSpeed: 100
                });

                jQuery('.jspHorizontalBar').animate({
                    height: 25
                }, 'fast');
                jQuery('.jspDrag').stop(true, true).animate({
                    height: 22
                }, 'fast');

            } else {
                view_data = jQuery('div.view-pane').data('jsp');
                if (view_data) {
                    view_data.destroy();
                }
                modelie_list.width(responsive.width);
                modelie_list.children('li').each(function() {
                    temp = jQuery(this);
                    la = temp.find('a.hover-lightbox');
                    la.css({
                        top: temp.height() / 2 - la.height() / 2 - 25,
                        left: temp.width() / 2 - la.width() / 2 - 25
                    });

                });
                view_pane.css('height', 'auto');

            }


        }


        if (utils.exists('metro-wrapper')) {

            if (jQuery('.no-posts-found').length == 0) {



                var dpi = jQuery('div.metro-wrapper').data('jsp');
                if (responsive.width > 767) {
                    jQuery('div.portfolio-metro').css("width", "2000em");

                    metro_lists.css('display', 'inline-block')
                    var testwidth = metro_lists.first().width();

                    if (metro_lists.last().width() > testwidth) testwidth = metro_lists.last().width();
                    jQuery('div.portfolio-metro').css({
                        "height": metro_lists.height() * 2,
                        "width": testwidth
                    });
                    jQuery('div.metro-wrapper').jScrollPane({
                        animateScroll: false,
                        mouseWheelSpeed: 80
                    });
                    jQuery('.jspHorizontalBar').animate({
                        height: 25
                    }, 'fast');
                    jQuery('.jspDrag').stop(true, true).animate({
                        height: 22
                    }, 'fast');
                    jQuery('div.portfolio-metro').height(metro_lists.height() * 2);
                } else {
                    if (dpi)
                        dpi.destroy();
                    metro_items.css('opacity', 1);
                    jQuery('div.portfolio-metro').width(responsive.width);
                    jQuery('div.portfolio-metro').css('height', 'auto');
                }

            } else {
                metro_lists.css('display', 'block');
                jQuery('div.portfolio-metro').css('width', 'auto');
            }

        }


        if (utils.exists('timeline-post')) {

            offset = jQuery('div.timeline-post').length;
            offset_line = line.position().left;

            jQuery('div.left-post').find('span.dot').css("left", (offset_line - 6) + "px");

            if (jQuery('div.right-post').length > 0) {
                distance = jQuery('div.right-post').position().left - offset_line
                jQuery('div.right-post').find('span.dot').css("left", -(distance + 6) + "px");
            }

            circle.css("left", (offset_line - 15) + "px");
            jQuery('div.timeline-post').find('span.connector').transition({
                width: distance
            }, 400);

        }



        if (compact_menu.length > 0) {
            compact_bar.css({
                'display': 'block',
                'visibility': 'hidden'
            });

            var cposi = compact_bar.find('.menu-wrapper').position().left;

            compact_menu.children('li').each(function() {

                if (jQuery(this).find('div.sub-menu').length > 0) {
                    jQuery(this).find('div.sub-menu').css("left", -(cposi + jQuery(this).position().left) + "px");
                }
            });
            compact_bar.css({
                'display': 'none',
                'visibility': 'visible'
            });

        }

        if (menu_area.find('.menu').length > 0) {

            var posi = menu_area.find('.menu-wrapper').position().left;
            if (posi === 0) {
                posi = menu_area.find('.skeleton').width() / 2 - menu_area.find('.menu-wrapper').width() / 2;
            }
            menu_area.find('.menu').children('li').each(function() {

                if (jQuery(this).find('div.sub-menu').length > 0) {
                    jQuery(this).find('div.sub-menu').css("left", -(posi + jQuery(this).position().left) + "px");
                }

                if (jQuery('.fluid-menu').length > 0) {
                    jQuery(this).find('div.sub-menu').width(responsive.width);
                }

            });
        }

        if (topbar.find('.menu').length > 0) {
            var posi = topbar.find('.menu-wrapper').position().left;
            if (posi === 0) {
                posi = topbar.find('.skeleton').width() / 2 - topbar.find('.menu-wrapper').width() / 2;
            }
            topbar.find('.menu').children('li').each(function() {

                if (jQuery(this).find('div.sub-menu').length > 0) {
                    jQuery(this).find('div.sub-menu').css("left", -(posi + jQuery(this).position().left) + "px");
                }
            });
        }

        if (bottombar.find('.menu').length > 0) {
            var posi = bottombar.find('.menu-wrapper').position().left;

            if (posi === 0) {
                posi = bottombar.find('.skeleton').width() / 2 - bottombar.find('.menu-wrapper').width() / 2;
            }

            bottombar.find('.menu').children('li').each(function() {
                if (jQuery(this).find('div.sub-menu').length > 0) {
                    jQuery(this).find('div.sub-menu').css("left", -(posi + jQuery(this).position().left) + "px");
                }
            });
        }


        jQuery('div.circles-group').each(function() {

            var parentw = jQuery(this).width();

            if (parentw >= jQuery(this).parent().width()) {
                parentw = jQuery(this).parent().width();
                jQuery(this).width(parentw);
                jQuery(this).height(parentw);
            }

            jQuery(this).find('div.circle').each(function(j) {
                jQuery(this).css({
                    "left": (parentw - parseInt(jQuery(this).data('fill')) / 100 * parentw) / 2,
                    scale: 0.2
                });
                jQuery(this).delay(j * 100).transition({
                    opacity: 1,
                    scale: 1,
                    width: parseInt(jQuery(this).data('fill')) + "%",
                    height: parseInt(jQuery(this).data('fill')) + "%"
                }, 500);

            });

        });



        if (responsive.width < 767) {
            jQuery('#mobile-logo').width(jQuery('#mobile-logo img').width());
            jQuery('div.mobile-head img').transition({
                opacity: 1
            }, 400);
        }

        if (jQuery('.mobile-side-wrap').length > 0) {
            jQuery('div.mobile-side-wrap').height(responsive.height);
            jQuery('#mobile-side-menu').height(responsive.height - 45);
            var sidemobile = jQuery('#mobile-side-menu').data('jsp');
            if (typeof sidemobile !== "undefined") sidemobile.reinitialise();
            else jQuery('#mobile-side-menu').jScrollPane({
                mouseWheelSpeed: 80
            });
        }

    } // End of function

    // Mobile Menu

    if (win.width < 767) {
        win.obj.load(function() {

            jQuery('#mobile-logo').width(jQuery('#mobile-logo img').width());
            jQuery('div.mobile-head img').transition({
                opacity: 1
            }, 400);

        });

    }
    var sidemobile = null;

    if (jQuery('.mobile-side-wrap').length > 0) {
        jQuery('div.mobile-side-wrap').height(responsive.height);
        jQuery('#mobile-side-menu').height(responsive.height - 45);
        jQuery('#mobile-side-menu').jScrollPane({
            mouseWheelSpeed: 80
        });
        sidemobile = jQuery('#mobile-side-menu').data('jsp');
    }

    jQuery('#mobile-side-menu li a').click(function(e) {

        if (jQuery(this).parent().children('.sub-menu').length > 0) {
            e.preventDefault();
            jQuery(this).parent().children('i').toggleClass('plus-2icon- minus-2icon-');
            jQuery(this).parent().children('.sub-menu').slideToggle('normal', function() {
                setTimeout(function() {
                    sidemobile.reinitialise();
                }, 200);
            });
        }

    });

    jQuery('#mobile-menu,#mobile-side-menu').find('li').each(function() {
        if (jQuery(this).children('.sub-menu').length > 0) jQuery(this).append('<i class="ioa-front-icon plus-2icon-"></i>');
    });


    jQuery('a.mobile-menu').click(function(e) {
        e.preventDefault();

        if (jQuery('#mobile-menu').length > 0) {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 'normal');
            jQuery('#mobile-menu').slideToggle('normal');
        } else {

            if (jQuery('.mobile-side-wrap').offset().left === 0) {
                jQuery('.mobile-side-wrap').transition({
                    left: -210
                }, 400);
            } else {
                jQuery('.mobile-side-wrap').transition({
                    left: 0
                }, 400);
            }

        }


    });

    jQuery('#mobile-menu li i').click(function(e) {

        if (jQuery(this).parent().children('.sub-menu').length > 0) {
            e.preventDefault();
            jQuery(this).parent().children('.sub-menu').slideToggle('normal');
            jQuery(this).toggleClass('plus-2icon- minus-2icon-');
        }

    });


}
jQuery(main_code);

function ioapreloader(obj, callback) {
    var images = [];
    images = jQuery.makeArray(obj.find('img'));
    var limit = images.length,
        timer, i, index;

    timer = setInterval(function() {

        if (limit <= 0) {

            callback();
            clearInterval(timer);
            return;
        }

        for (i = 0; i < images.length; i++) {
            if (images[i].complete || images[i].readyState == 4) {
                images.splice(i, 1);
                limit--;
            }

        }

    }, 200);

}

/**
 * IE 7 Class checker ~~ Basic Support
 */
function getElementsByClassName(node, classname) {
    var a = [];
    var re = new RegExp('(^| )' + classname + '( |$)');
    var els = node.getElementsByTagName("*");
    for (var i = 0, j = els.length; i < j; i++)
        if (re.test(els[i].className)) a.push(els[i]);
    return a;
}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
