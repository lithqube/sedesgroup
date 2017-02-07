/*
   ~~ == SELENE ==================================
   
   Development Version : 0.1 
   This Product is copyrighted and cannot be used without proper license or Author's Permission
   
*/



var SELENE_GLOBALS = {
	
	
	};

//;(function ( $, window, document, undefined ) {



// == Global Constants for plugin ================

var pluginName = 'Selene',
	VERSION = 0.1,
	defaults = {
					width:600 , 
				    height:450 ,
					
					duration :8000,
					caption : true,
					autoplay :  true,
					
					
					// Panel 2 
					
					
					arrow_control :  true,
					thumbnails : true,
					compact : false

					
			 };



// == constructor ================================

function Selene( element, options ) {
	
	this.options = jQuery.extend(defaults, options) ;
	
	this._defaults = defaults;
	this._name = "Selene";
	this.rawEl = element;
	this.element = jQuery(element);
	this.holder = this.element.children('div.gallery-holder');
	this.timer = null;
	this.len = 0;
	this.offset = 0;
	this.current = null;
	this.prev = null;
	this.next = null;
	this.thumb_wrap = null;
	this.thumb_holder = null;
	
	this.isTranslatable = true;
	this.circularTimer = null;
	
	this.thumbnails = null;
	this.bullets = null;
	this.counter = null;

	this.slides =null;
	
	this.flag = false;
	this.autoplay_flag = false;
	this.responsivePercent = 100;
	this.isresponsive = false;
	this.r = {};

	this.videos = [];
	
	
	var  wait , index , src , 
	  	in_animation = false , // Flag for checking if slide is in animation
		controls , len , controls_override = false ,
		i , j , k , temp , obj = this, slides = null,
		layers = null,
		mainImages = null;
		
		this.htmldatamap = function()
		{
	     
	     var temp = this.element.data();

		
		  this.options = temp;
		  this.options.duration = parseFloat(this.options.duration) * 1000;	
		 
		}
		
		this.setup = function(){

			  if (!jQuery.support.transition) this.isTranslatable = false
			 
			  if(this.options.domMapping===true) this.htmldatamap();
			 
			  this.element.addClass('seleneGallery');
			  

			  if(typeof this.options.fullscreen!='undefined' && this.options.fullscreen )
			  {
			  			obj.options.height = jQuery(window).height() - (jQuery('.header-cons-area').height() - jQuery('#bottom_bar_area').height() - 45 ) - jQuery('.supper-title-wrapper').height()  ;
			  			this.options.width = jQuery(window).width();

			  			if( jQuery('.ioa-boxed-layout').length > 0 ) this.options.width = jQuery('.skeleton').width();

			  			this.element.addClass('fullscreen');
			  }


			  this.element.width(this.options.width);
			  this.holder.width(this.options.width);
			  this.holder.height(this.options.height);
			  
			  this.r.w = this.options.width;
			  this.r.h = this.options.height;

			  this.element.parent().css('overflow','hidden');
			  
			  this.slides = this.element.find('div.gallery-item').addClass('hidden');

			  this.current = this.slides.first().addClass('active').removeClass('hidden');
			  this.prev = this.slides.last().addClass('reset');
			  this.next = this.slides.eq(1);

			  if(this.options.thumbnails && this.slides.length > 1) this.addThumbnail();
			  if(this.options.arrow_control && this.slides.length > 1) this.addControls();


		};  
		
		this.init = function() {
			  

				this.element.parent().css('background','none');

			   this.holder.hover(function(){
		  
				  if(obj.flag === true) return;

				 	clearTimeout(obj.timer);
				 	obj.resetProgressBar();

				 },function(){

				 	if(obj.flag === true) return;

				 	obj.updateSlide();
				 	obj.startProgressBar( obj.slides.index(obj.current) );

				 });

			 

			  this.startProgressBar(obj.slides.index(this.current));
			  
			  if(obj.options.autoplay === true)
			  this.timer = setTimeout(function(){  obj.effect();  } ,this.options.duration);

				  jQuery(window).resize(function(){
                      clearTimeout(test_resize);
                      obj.responsiveAuto();
                      test_resize = setTimeout(function(){ obj.responsiveAuto(); 
						if(obj.options.thumbnails === true )
                      		obj.adjustThumbArea();  
                      },150);
                      });
			 
			  var test_resize = setTimeout(function(){
			  	obj.responsiveAuto();
                     obj.responsiveAuto(); 
						if(obj.options.thumbnails === true )
                      		obj.adjustThumbArea();  
                    obj.showDesc(obj.current.find('div.gallery-desc'));

			
		

			 obj.element.parent().css({ 'overflow':'visible'  , 'background' : 'none' });
			 obj.element.css({ 'overflow':'visible'  });
			  obj.element.parent().find('.loader').remove();
		 	 obj.element.css("visibility","visible").animate({ opacity :1 },'normal');

		 	 var temp;
		 	obj.slides.each(function(i){

		 		temp = jQuery(this).find('.quant_video-bg');

		 		if(temp.length > 0) {

		       		temp.css({ width : obj.options.width , height :  obj.options.height });
		            obj.videos[i] =  { el : new MediaElement(temp.children('video').attr('id'),
		            		{ 
		            			loop:true , 
		            			features : [] , 
					        	videoWidth: obj.options.width,
			  					videoHeight: obj.options.height,
			  					enableAutosize: true,
					            success: function(mediaElement, domObject) {
					           
					                mediaElement.play();
					   			 }
					        }) , id : jQuery(this).find('video').attr('id') };

		        }
		     


		    });


		 	  	  },60);



		 }; 
		 
		 this.resize = function(h,w, maxh, maxw) {
                          var ratio = maxh/maxw;
                         
                          if (h/w > ratio){
                    
                            if (h > maxh){
                              w = Math.round(w*(maxh/h));
                              h = maxh;
                            }
                          } else if (h/w < ratio) {
                                // width is the problem
                            if (w > maxh){
                              h = Math.round(h*(maxw/w));
                              w = maxw;
                            }
                            else
                            {
                                h = Math.round(h*(maxw/w));
                            }
                          } 
                    
                          return [h,w];
                        };
                
             this.scale = function(h,w, maxh, maxw) {
                          var ratio = maxh/maxw;
                          if (h/w < ratio) {
                            // width is the problem
                            if (w >= maxw){
                              h = Math.round(maxh*(w/maxw));
                              w = w;
                            }
                         
                          
                          } 
                         
                          return [h,w];
                        };

          this.responsiveAuto = function(){
            
            
            var cf = this.options.width , h = this.options.height,w;
            if( this.options.fullscreen )
            {
            	
            	  w = this.element.parent().width();
            	  h = jQuery(window).height() - (jQuery('.header-cons-area').height() - jQuery('#bottom_bar_area').height() - 45 ) - jQuery('.supper-title-wrapper').height() ;
 	             
 	              if( this.current.find('img').height() < h ) h = this.current.find('img').height();	
	              this.element.css({ width:w   });
	              this.holder.css({ width:w, height :h });
	               
            }
            else if( this.element.parent().width() <=  cf  ) {     
                        	

                          temp = this.resize(this.options.height, cf ,h,this.element.parent().width());
                          if(temp[1]>this.element.parent().width())
                            {
                                 temp[1] = this.element.parent().width() ;
                                
                            }
                          this.responsivePercent = ( temp[1] / cf ) * 100;
                          this.isresponsive = true;
                          temp[0] = this.current.find('img').height();

                          this.element.css({ width: temp[1]  });
                          this.holder.css({ width: temp[1] , height : temp[0] });
                          obj.r.w = temp[1];

                          if( this.options.caption)
							{	
								if( this.current.find('div.slider-desc').hasClass('s-c-l') ||  this.current.hasClass('s-c-c') ||  this.current.hasClass('s-c-r'))
								{
									this.current.find('div.slider-desc').css('top', temp[0]/2 - this.current.find('div.slider-desc').outerHeight()/2+"px" );
								}

							}
                           
                       }
                     
                       else
                       {
                            this.responsivePercent = 100;
                            this.isresponsive = false;
                       
                           this.element.css({ width: obj.options.width   });
                           this.holder.css({ width: obj.options.width , height : obj.options.height  });
                           obj.r.w = obj.options.width;

                           if( this.options.caption)
							{	
								if( this.current.find('div.slider-desc').hasClass('s-c-l') ||  this.current.hasClass('s-c-c') ||  this.current.hasClass('s-c-r'))
								{
									this.current.find('div.slider-desc').css('top', temp[0]/2 - this.current.find('div.slider-desc').outerHeight()/2+"px" );
								}

							}
                           
                        
                       }
                       obj.offset = 0;	

                       
                       if(this.options.thumbnails && this.thumb_holder)
                       {
                       	this.thumb_holder.width(obj.r.w);	
                       obj.thumb_wrap.stop(true,true).css( "left" , obj.offset+"px");
               
                       }
                 
              
             }; 

		 this.prepareSlide = function(slide)
		 {
		 		obj.element.trigger('seleneSlideBeforeChange',[obj.slides.index(slide)]);
		 		obj.flag = false;

		 		if( this.current.find('.quant_video-bg').length > 0 )
		 		{
		 			//obj.videos[0].pause();

		 			for(var i=0;i<obj.videos;i++)
		 			{
		 				if(obj.videos[i].id ==  this.current.find('video').attr('id'))
			               {
			                  obj.videos[i].el.pause();
			               }
		 			}
		 		}
		 		
		 		switch(this.options.effect_type)
		 		{
		 			case 'fade' : slide.css({  opacity :0  }); break;
		 			case 'scroll' : slide.css({ x : this.r.w+80+'px'  }); break;
		 			case 'overlap-left' : slide.css({ x : this.r.w+'px'  }); break;
		 			case 'overlap-right' : slide.css({ x : -this.r.w+'px'  }); break;
		 			case 'overlap-top' : slide.css({ y : this.r.h+'px'  }); break;
		 			case 'overlap-bottom' : slide.css({ y : -this.r.h+'px'  }); break;
		 			case 'scroll-perspective' : slide.css({ x : this.r.w+'px' , opacity :0 , perspective :400 , rotateY : '-50deg' }); break;
		 		}


		 		this.prev.removeClass('reset').addClass('hidden');
		 		this.prev = this.current.addClass('reset').removeClass('active');
		 		this.current = slide.addClass('active');
		 		this.current.find('div.gallery-desc').hide();

		 		if( this.current.next('div.gallery-item').length > 0 ) 
		 			this.next = this.current.next('div.gallery-item');
		 		else
		 			this.next = this.slides.first('div.gallery-item');
		 		
		 		clearTimeout(this.timer);


		 
		 	 

		 	

		 		this.animate(slide);
		 		
		 }

		 this.effect = function(){

		 	this.prepareSlide(this.next);	

		 };

		 this.animate = function(slide)
		 {
		 	
		 	this.startProgressBar(obj.slides.index(slide));
		 	
		 	 
		 	
		 	switch(this.options.effect_type)
		 	{
		 		case 'fade' :
		 			slide.removeClass('hidden').transition({ opacity:1 },700,'',function(){  obj.element.trigger('seleneSlideChanged',[obj.slides.index(slide)]);

		 				 

		 		});
		 			this.prev.transition({  opacity:0   },700,'');
		 		break;

		 		case 'overlap-left' :
		 		case 'overlap-right' :
					slide.removeClass('hidden').transition({  x : 0  },700,'',function(){  obj.element.trigger('seleneSlideChanged',[obj.slides.index(slide)]); });
		 		break;
		 		case 'overlap-bottom' :
		 		case 'overlap-top' :
					slide.removeClass('hidden').transition({  y : 0  },700,'',function(){  obj.element.trigger('seleneSlideChanged',[obj.slides.index(slide)]); });
		 		break;

		 		case 'scroll' :
					this.prev.transition({  x : -this.options.width-80  },700);
		 			slide.removeClass('hidden').transition({  x : 0  },700,'',function(){  obj.element.trigger('seleneSlideChanged',[obj.slides.index(slide)]); });
		 		break;

		 		case 'scroll-perspective' :
					this.prev.transition({ x : -this.options.width , opacity:0 , perspective :400 , rotateY : '30deg'  },700);
		 			slide.removeClass('hidden').transition({ x : 0 , opacity:1 , rotateY : '0deg'  },700,'',function(){  obj.element.trigger('quartzSlideChanged',[obj.slides.index(slide)]); });
		 		break;


		 	}

		 	if(obj.options.fullscreen)
				 	{

				 		var h = jQuery(window).height() - ( jQuery('.header-cons-area').height() - jQuery('#bottom_bar_area').height() - 45) - jQuery('.supper-title-wrapper').height() ;
		 	             
		 	            if( slide.find('img').height() < h ) h = slide.find('img').height();	
			            //obj.element.css({  height :h });
			            obj.holder.css({ height :h });

				 	}

			if( this.current.find('.quant_video-bg').length > 0 )
		 		{
		 			
		 			for(var i=0;i<obj.videos;i++)
		 			{
		 				if(obj.videos[i].id ==  this.current.find('video').attr('id'))
			               {
			                  obj.videos[i].el.play();
			               }
		 			}
		 		}


		 	this.updateSlide();
		 }

		 this.updateSlide = function()
		 {
		 	clearTimeout(this.timer);
		 	
		 	
		 	if(this.flag === false && this.autoplay_flag === false &&  obj.options.autoplay === true)
		 	this.timer = setTimeout(function(){  obj.effect();  } ,this.options.duration);
		 }

		this.addControls = function()
		{
			var lc='',str = '<div class="selene-controls-wrap"> <a href="" class="selene-controls ioa-front-icon angle-lefticon- gallery-prev"></a>';
			
			if( this.element.find('.ioa-lightbox-icon').length == 0 ) lc = 'no-lightbox';

			if(obj.options.autoplay === true) str += '<a href="" class="selene-controls '+lc+' autoplay-control ioa-front-icon pause-2icon- gallery-pause"></a>';

			str += '<a href="" class="selene-controls ioa-front-icon angle-righticon- gallery-next"></a> </div>';
			this.holder.append(str);

			this.element.on("click",'a.gallery-prev',function(e){
			e.preventDefault();
			var index = obj.slides.index(obj.current);
			
			if(index==0) index = obj.slides.length-1;
			else index = index - 1;



			obj.resetProgressBar();
			clearTimeout(obj.timer);

			obj.flag = true;
			obj.prepareSlide(obj.slides.eq(index));
			
			});

			obj.element.bind('swiperight',function(){
				var index = obj.slides.index(obj.current);
			
				if(index==0) index = obj.slides.length-1;
				else index = index - 1;

				obj.resetProgressBar();
				clearTimeout(obj.timer);

				obj.flag = true;
				obj.prepareSlide(obj.slides.eq(index));
			});
			
			obj.element.bind('swipeleft',function(){
				var index = obj.slides.index(obj.current);
				if(index==obj.slides.length-1) index = 0;
				else index = index + 1;
					
				obj.resetProgressBar();
				clearTimeout(obj.timer);

				obj.flag = true;
				obj.prepareSlide(obj.slides.eq(index));

			});


			this.element.on("click",'a.gallery-next',function(e){
			
			var index = obj.slides.index(obj.current);
			e.preventDefault();
			if(index==obj.slides.length-1) index = 0;
			else index = index + 1;

			obj.resetProgressBar();
			clearTimeout(obj.timer);

			obj.flag = true;
			obj.prepareSlide(obj.slides.eq(index));
			
			

			});

			this.element.on("click",'a.gallery-pause',function(e){
			
			
			e.preventDefault();
			
			if( jQuery(this).hasClass('pause-2icon-') )
			{
				obj.autoplay_flag = true; obj.flag = true;
				jQuery(this).addClass('play-2icon-').removeClass('pause-2icon-');
				clearTimeout(obj.timer);
				obj.resetProgressBar();
			}
			else
			{
				obj.autoplay_flag = false;  obj.flag = false;
				jQuery(this).addClass('pause-2icon-').removeClass('play-2icon-');
				obj.updateSlide();
		 		obj.startProgressBar( obj.slides.index(obj.current) );

			}


			});



			 


		} 
			 
		this.addThumbnail = function()
		{
			
			var str = '<div class="selene-thumbnails-wrap greyscale-imgs"><ul class="selene-thumbnails hoverable">' , thumbs_arrow = '';
			
			var compact = '';

			this.slides.each(function(){
				str += "<li style='opacity:0;'><img src='"+jQuery(this).data('thumbnail')+"' alt='thumb' /><span class='gallery-loader'></span></li>";
				if(obj.options.compact === true)
				{
					compact += "<li><span class='gallery-loader'></span></li>";
				}

			});

			str += "</ul></div>";




			this.element.append(str);
			this.thumbnails = this.element.find('ul.selene-thumbnails li');

			this.thumbnails.first().addClass('active');

			if(jQuery(window).width() > 1024)
			setTimeout(function(){
				obj.thumbnails.each(function(i){
					jQuery(this).delay(i*170).transition({ opacity:1 },700);
				}); 
			},200);
			else
				obj.thumbnails.css("opacity",1);

			

			
		 this.element.bind('seleneSlideBeforeChange',function(event,index){
		 		
		 		obj.thumbnails.removeClass('active');	
		 		obj.thumbnails.eq(index).addClass('active');

		 		if(obj.options.compact === true) 
		 		{
		 			obj.bullets.removeClass('active');	
		 			obj.bullets.eq(index).addClass('active');
		 		}

		 		event.stopImmediatePropagation();
		 		event.stopPropagation();

		 });


			this.thumb_wrap = this.element.find('ul.selene-thumbnails');
			this.thumb_holder = this.thumb_wrap.parent();
			this.thumb_holder.width(obj.r.w);	
			
			var li_w =  (this.thumbnails.outerWidth()+2)  * this.thumbnails.length ;

			thumbs_arrow = "<a href='' class='angle-lefticon- ioa-front-icon thumb-arrow-left' style='display:none'></a><a href='' style='display:none' class='angle-righticon- ioa-front-icon thumb-arrow-right'></a>";
			this.thumb_holder.append(thumbs_arrow);

			if( li_w > this.r.w)
			{
				this.thumb_wrap.addClass('push_right');
			}
			

			obj.thumbnails.on("click",function(){
			
			var index = obj.thumbnails.index(jQuery(this));
			
			if( jQuery(this).hasClass('active') ) return;

			obj.resetProgressBar();
			clearTimeout(obj.timer);

			obj.flag = true;
			obj.prepareSlide(obj.slides.eq(index));


			});

			this.element.find('a.thumb-arrow-left').on("click",function(e){
					e.preventDefault();

					if(  obj.offset > 0 )
					{
						obj.offset -= ( obj.thumbnails.outerWidth() + 2 )* 2;
						obj.thumb_wrap.animate({ left : -obj.offset },'normal');
						
					}

			});


			this.element.find('a.thumb-arrow-right').on("click",function(e){
					e.preventDefault();

					if(  (obj.offset+obj.r.w) <= li_w )
					{
						obj.offset += ( obj.thumbnails.outerWidth() + 2 )* 2;	
						obj.thumb_wrap.animate({ left : -(obj.offset+20) },'normal');
					}

			});




		}
		
		this.adjustThumbArea = function()
		{

			var li_w = (this.thumbnails.outerWidth()+2)  * this.thumbnails.length ;

			if( li_w > obj.r.w)
			{
				obj.element.find('a.thumb-arrow-left , a.thumb-arrow-right').show();
				obj.thumb_wrap.addClass('push_right');
			}
			else
			{
				obj.element.find('a.thumb-arrow-left , a.thumb-arrow-right').hide();
				obj.thumb_wrap.removeClass('push_right');	
			}

		}

		this.showDesc = function(desc)
		{
			
			if( this.options.captions)
			{	
				if(desc.hasClass('s-c-l') || desc.hasClass('s-c-c') || desc.hasClass('s-c-r'))
				{
					desc.css('top', this.holder.height()/2 - desc.outerHeight()/2+"px" );
				}

				var h = desc.find('h4').css({ opacity:0, marginTop : 15 });
				var cap = desc.find('.caption').css({  opacity:0, marginTop : 15 });
				desc.show();

				h.transition({ opacity : 1, marginTop:0 },200,'easeOutCubic');
				cap.transition({ opacity :1, marginTop:0 },200,'easeOutCubic');
			

			}
				
		}

		this.startProgressBar = function(index)
		{
			if(this.flag === false && this.autoplay_flag === false &&  obj.options.autoplay === true &&  obj.options.thumbnails === true) {

			var th = this.thumbnails.eq(index);
			this.thumbnails.find('span.gallery-loader').stop(true,true).css("width",0);
			th.find('span.gallery-loader').animate({ "width" : 80 }, this.options.duration );
		}
		}

		this.resetProgressBar = function()
		{
			if(obj.options.thumbnails === true)
			this.thumbnails.find('span.gallery-loader').stop(true,false).animate({ "width":0 },'fast');
			
		}
	

		/**
		 * Custom Listeners
		 */
		 this.element.bind('seleneSlideChanged',function(event,index){
		 		
		 		obj.showDesc(obj.slides.eq(index).find('div.gallery-desc'));
		 		event.stopImmediatePropagation();
		 		event.stopPropagation();
		 });

		
		function ioapreloader(obj,callback)
{
	var images =[];
	images = jQuery.makeArray(obj.find('img'));
	var limit = images.length , timer,i,index;

	timer = setInterval(function(){

		if(limit<=0)
		{

			callback();
			clearInterval(timer);
			return;
		}

		for(i=0;i<images.length;i++)
		{
				if(images[i].complete  || images[i].readyState == 4)
					{
						images.splice(i,1);
			  			limit--;			 		
				   	}	

		}

	},200);
	
}
		

		 obj.setup();
		 ioapreloader(this.element,function(){

		 		
		 		obj.init();
		 		
				 	
		 });

		
		

}

// == Plugins Initiation =========================    
    
jQuery.fn.seleneGallery = function ( options ) {
	return this.each(function () {
		if (!jQuery.data(this, 'plugin_' + pluginName)) {
			jQuery.data(this, 'plugin_' + pluginName, 
			new Selene( this, options ));
		}
	});
}


//})( jQuery, window, document );  // == End of Scope =======================
