/*
   ~~ == Quartz ==================================
   
   Development Version : 0.1 
   This Product is copyrighted and cannot be used without proper license or Author's Permission
   
*/



var QUARTZ_GLOBALS = {
	
	
	};

//;(function ( $, window, document, undefined ) {



// == Global Constants for plugin ================

var pluginName = 'Quartz',
	VERSION = 0.1,
	defaults = {
					width:600 , 
				    height:450 ,
					
					duration :8000,
					caption : true,
					autoplay :  true,
					effect_type : 'fade',
					
					// Panel 2 
					
					
					arrow_control :  true,
					bullets : true

					
			 };


// == constructor ================================

function Quartz( element, options ) {
	
	this.options = jQuery.extend(defaults, options) ;
	
	this._defaults = defaults;
	this._name = "Quartz";
	this.rawEl = element;
	this.element = jQuery(element);
	this.holder = this.element.children('div.items-holder');
	this.timer = null;
	this.len = 0;
	this.offset = 0;
	this.current = null;
	this.prev = null;
	this.next = null;
	this.thumb_wrap = null;
	this.thumb_holder = null;
	this.progress_bar = null;
	this.isTranslatable = true;
	
	this.bullets = null;
	this.counter = null;

	this.slides =null;
	
	
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
			 
			  if( this.options.full_width == true ) 
			  {
			  	 this.options.width = this.element.parent().width();
				 this.element.addClass('full-stretch');
				 this.element.find('.inner-desc-wrap').addClass('skeleton auto_align');

			  }
			  this.element.parent().css('overflow','hidden');
			  


			  this.element.width(this.options.width);
			  this.holder.width(this.options.width);
			  
			  this.r.w = this.options.width;
			  this.r.h = this.options.height;

			  this.slides = this.element.find('div.slider-item').addClass('hidden');

			  this.current = this.slides.first().addClass('active').removeClass('hidden');
			  this.prev = this.slides.last().addClass('reset');
			  this.next = this.slides.eq(1);

			  if(this.options.bullets === true && this.slides.length > 1) this.addBullets();
			  if(this.options.arrow_control === true && this.slides.length > 1) this.addControls();

			  if(this.options.autoplay === true)
			  {
			  	 this.holder.append('<span class="progress-bar"></span>');
			  	 this.progress_bar = this.holder.find('.progress-bar');
			  }

			 

		};  
		
		this.init = function() {
			  
			  this.startProgressBar();
			  
			  if(obj.options.autoplay === true)
			  this.timer = setTimeout(function(){  obj.effect();  } ,this.options.duration);

			  

			  if(this.options.adaptive)
		 		{
		 			obj.element.addClass('adaptive');
		 		}
			  
			  jQuery(window).resize(function(){
                      clearTimeout(test_resize);
                      obj.responsiveAuto();
                      test_resize = setTimeout(function(){ 
                      	obj.responsiveAuto(); 
				                    },100);
                      });		
		 		
			  
			  var test_resize = setTimeout(function(){ obj.responsiveAuto(); 	
			  

			 obj.element.parent().css({ 'overflow':'visible'  , 'background' : 'none' });
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
		 	obj.showDesc(obj.current.find('div.slider-desc'));
		     },100);

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
            
            var cf = this.options.width ;
             
             if( this.options.full_width )
            {
            	
            	temp = this.resize(this.options.height, cf ,this.options.height,this.element.parent().width());
                
                temp[1] = this.element.parent().width() ;
                
              this.responsivePercent = ( temp[1] / cf ) * 100;
              this.isresponsive = true;

              if( obj.options.adaptive || (  this.current.find('img').length > 0 && this.current.find('img').height() < temp[0] ) )
              	temp[0] = obj.current.find('img').height();
             

              if(this.current.find('img').length == 0 && temp[1] < 1060 )
              {
              	 temp[0] =  temp[0] *  temp[1]/1060 ;
              	 if(temp[0]<250) temp[0] = 250;
              }

              this.element.css({ height: temp[0] , width: temp[1]  });
              this.holder.css({ height: temp[0] , width: temp[1]   });


              obj.r.w = temp[1];
              obj.r.h = temp[0];

               this.element.find("ul.quartz-bullets").css({ "left" : temp[1] - ( temp[1]/2 + this.element.find("ul.quartz-bullets").width()/2 )  });

               if(obj.options.bullets == true && this.slides.length > 1)
               {
               	obj.bullets.parent().css({ 
					"left" :  temp[1] - (  temp[1]/2 + obj.bullets.parent().width()/2 )  });
				
               }


                if( this.options.caption)
				{	

					if( this.current.find('div.slider-desc').hasClass('s-c-l') ||  this.current.find('div.slider-desc').hasClass('s-c-c') ||  this.current.find('div.slider-desc').hasClass('s-c-r'))
					{
						this.current.find('div.slider-desc').css('top', temp[0]/2 - this.current.find('div.slider-desc').outerHeight()/2+"px" );
						
					}

				}
	               
            }
            else if( this.element.parent().width() <=  cf   ) {     
                        
                        
                            temp = this.resize(this.options.height, cf ,this.options.height,this.element.parent().width());
                            if(temp[1]>this.element.parent().width())
                            {
                                 temp[1] = this.element.parent().width() ;
                                
                            }
                          this.responsivePercent = ( temp[1] / cf ) * 100;
                          this.isresponsive = true;
                        
                          this.element.css({ width: temp[1]  });
                          this.holder.css({ width: temp[1]  });



                          if( obj.options.adaptive )
                          	temp[0] = obj.current.find('img').height();
                        
                          this.holder.css({ height: temp[0]  });


                          obj.r.w = temp[1];
 							obj.r.h = temp[0];

                           this.element.find("ul.quartz-bullets").css({ "left" : temp[1] - ( temp[1]/2 + this.element.find("ul.quartz-bullets").width()/2 )  });

                           if(obj.options.bullets == true && this.slides.length > 1)
                           {
                           	obj.bullets.parent().css({ 
								"left" :  temp[1] - (  temp[1]/2 + obj.bullets.parent().width()/2 )  });
							
                           }

                            if( obj.options.caption)
							{	
								if( obj.current.find('div.slider-desc').hasClass('s-c-l') ||  obj.current.hasClass('s-c-c') ||  obj.current.hasClass('s-c-r'))
								{
									obj.current.find('div.slider-desc').css('top', temp[0]/2 - obj.current.find('div.slider-desc').outerHeight()/2+"px" );

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
                           obj.r.h = obj.options.height;
                           
                           this.element.find("ul.quartz-bullets").css({ "left" : this.options.width - ( this.options.width/2 + this.element.find("ul.quartz-bullets").width()/2 )  });
                           if(obj.options.bullets == true && this.slides.length > 1)
                           {
                           	obj.bullets.parent().css({ 
								"left" :  this.options.width - (  this.options.width/2 + obj.bullets.parent().width()/2 )  });
							
                           }

                           if( this.options.caption)
							{	
								if( this.current.find('div.slider-desc').hasClass('s-c-l') ||  this.current.find('div.slider-desc').hasClass('s-c-c') ||  this.current.find('div.slider-desc').hasClass('s-c-r'))
								{
									this.current.find('div.slider-desc').css('top', obj.options.height/2 - this.current.find('div.slider-desc').outerHeight()/2+"px" );
								}

							}

                        
                       }
              
             }; 

		 this.prepareSlide = function(slide)
		 {
		 		obj.element.trigger('quartzSlideBeforeChange',[obj.slides.index(slide)]);
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
		 		
		 		slide.removeClass('hidden');

		 		switch(this.options.effect_type)
		 		{
		 			case 'fade' : slide.css({  opacity :0  }); break;
		 			case 'scroll' : slide.css({ marginLeft : this.r.w+'px'  }); break;
		 			case 'overlap-left' : slide.css({ x : this.r.w+'px'  }); break;
		 			case 'overlap-right' : slide.css({ x : -this.r.w+'px'  }); break;
		 			case 'overlap-top' : slide.css({ y : this.r.h+'px'  }); break;
		 			case 'overlap-bottom' : slide.css({ y : -this.r.h+'px'  }); break;
		 			case 'scroll-perspective' : slide.css({ x : this.r.w+'px' , opacity :0 , perspective :400 , rotateY : '-50deg' }); break;
		 		}


		 		

		 		this.prev.removeClass('reset').addClass('hidden');
		 		this.prev = this.current.addClass('reset').removeClass('active');
		 		this.current = slide.addClass('active').removeClass('hidden');
		 		this.current.find('div.slider-desc').hide();

		 		if( this.current.next('div.slider-item').length > 0 ) 
		 			this.next = this.current.next('div.slider-item');
		 		else
		 			this.next = this.slides.first('div.slider-item');
		 		


		 		clearTimeout(this.timer);
		 		this.animate(slide);
		 		
		 }

		 this.effect = function(){

		 	this.prepareSlide(this.next);	

		 };

		 this.animate = function(slide)
		 {
		 	this.startProgressBar();


		 	
		 	switch(this.options.effect_type)
		 	{
		 		case 'fade' :
					this.prev.transition({  opacity:0   },700,'');
		 			slide.transition({ opacity:1 },700,'',function(){  obj.element.trigger('quartzSlideChanged',[obj.slides.index(slide)]); });
		 			
		 		break;

		 		case 'overlap-left' :
		 		case 'overlap-right' :
					slide.transition({  x : 0  },700,'',function(){  obj.element.trigger('quartzSlideChanged',[obj.slides.index(slide)]); });
		 		break;
		 		case 'overlap-bottom' :
		 		case 'overlap-top' :
					slide.transition({  y : 0  },700,'',function(){  obj.element.trigger('quartzSlideChanged',[obj.slides.index(slide)]); });
		 		break;

		 		case 'scroll' :
					this.prev.transition({  marginLeft : -this.r.w },700,'');
		 			slide.transition({  marginLeft : 0  },700,'',function(){  obj.element.trigger('quartzSlideChanged',[obj.slides.index(slide)]); });
		 		break;

		 		case 'scroll-perspective' :
					this.prev.transition({ x : -this.r.w , opacity:0 , perspective :400 , rotateY : '30deg'  },700);
		 			slide.transition({ x : 0 , opacity:1 , rotateY : '0deg'  },700,'',function(){  obj.element.trigger('quartzSlideChanged',[obj.slides.index(slide)]); });
		 		break;


		 	}
		 	if(this.options.adaptive)
		 		{
		 			this.holder.animate({ height : slide.find('img').height() } ,400 );	
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
		 	
		 	
		 	if( this.autoplay_flag === false &&  obj.options.autoplay === true)
		 	this.timer = setTimeout(function(){  obj.effect();  } ,this.options.duration);
		 }

		this.addControls = function()
		{
			var lc='', str = '<div class="quartz-controls-wrap"> <a href="" class="quartz-controls ioa-front-icon angle-lefticon- slider-prev"></a>';
			
			if( this.element.find('.ioa-lightbox-icon').length == 0 ) lc = 'no-lightbox';

			if(obj.options.autoplay === true) str += '<a href="" class="quartz-controls '+lc+' ioa-front-icon pause-2icon- autoplay-control slider-pause"></a>';

			str += '<a href="" class="quartz-controls ioa-front-icon angle-righticon- slider-next"></a> </div>';
			this.holder.after(str);

			this.element.on("click",'a.slider-prev',function(e){
			e.preventDefault();
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

			obj.element.bind('swiperight',function(){
				var index = obj.slides.index(obj.current);
			
				if(index==0) index = obj.slides.length-1;
				else index = index - 1;

				obj.resetProgressBar();
				clearTimeout(obj.timer);

				obj.flag = true;
				obj.prepareSlide(obj.slides.eq(index));
			});

			this.element.on("click",'a.slider-next',function(e){
			
			var index = obj.slides.index(obj.current);
			e.preventDefault();
			if(index==obj.slides.length-1) index = 0;
			else index = index + 1;
				
			obj.resetProgressBar();
			clearTimeout(obj.timer);

			obj.flag = true;
			obj.prepareSlide(obj.slides.eq(index));

			});

			this.element.on("click",'a.slider-pause',function(e){
			
			
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
		 		obj.startProgressBar();

			}


			});



			 this.element.find("ul.quartz-bullets").css({ "left" : this.options.width - ( this.options.width/2 + this.element.find("ul.quartz-bullets").outerWidth()/2 )  });


		} 
			 
		this.addBullets = function()
		{
			var str = '<div class="quartz-bullets-wrap"><ul class="quartz-bullets">' ;
			
			
			this.slides.each(function(){
				str += "<li style='opacity:0;'></li>";
			
			});

			str += "</ul></div>";




			this.element.append(str);
			this.bullets = this.element.find('ul.quartz-bullets li');

			this.bullets.first().addClass('active');

			if(jQuery(window).width()>1024)
			setTimeout(function(){
				obj.bullets.each(function(i){
					jQuery(this).css("scale",0.5);
					jQuery(this).delay(i*170).transition({ opacity:1 , scale:1 },700);
				}); 
			},200);
			else
				obj.bullets.css("opacity",1);

			

			

			this.thumb_wrap = this.element.find('ul.quartz-bullets');
			this.thumb_holder = this.thumb_wrap.parent();
					

			

			obj.bullets.on("click",function(){
			
			var index = obj.bullets.index(jQuery(this));
			
			if( jQuery(this).hasClass('active') ) return;

			obj.resetProgressBar();
			clearTimeout(obj.timer);

			obj.flag = true;
			obj.prepareSlide(obj.slides.eq(index));


			});

			




		}
		
		this.showDesc = function(desc)
		{
			
			if( this.options.caption)
			{	
				if(desc.hasClass('s-c-l') || desc.hasClass('s-c-c') || desc.hasClass('s-c-r'))
				{
					desc.css('top', obj.r.h/2 - desc.outerHeight()/2+"px" );
				}

				var h = desc.find('h4').css({ opacity:0, marginTop : 15 });
				var cap = desc.find('.caption').css({  opacity:0, marginTop : 15 });
				desc.show();

				h.transition({ opacity : 1, marginTop:0 },200,'easeOutCubic');
				cap.transition({ opacity :1, marginTop:0 },200,'easeOutCubic');
			

			}
				
		}

		this.startProgressBar = function()
		{
			if( this.autoplay_flag === false &&  obj.options.autoplay === true ) {

			
			this.progress_bar.stop(true,true).css("width",0);
			this.progress_bar.animate({ "width" : obj.r.w }, this.options.duration );
		}
		}

		this.resetProgressBar = function()
		{
			if( obj.options.autoplay === true ) {
			this.progress_bar.stop(true,false).animate({ "width":0 },'fast');
		}
			
		}
		
		if(this.options.domMapping===true) this.htmldatamap();

		/**
		 * Custom Listeners
		 */
		 this.element.bind('quartzSlideChanged',function(event,index){
		 		
		 		obj.showDesc(obj.slides.eq(index).find('div.slider-desc'));
		 	
		 });
		
		 if(obj.options.bullets === true)
		 {
		 	this.element.bind('quartzSlideBeforeChange',function(event,index){
		 		
		 		obj.bullets.removeClass('active');	
		 		obj.bullets.eq(index).addClass('active');

		 });
		 }

		

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
    
jQuery.fn.quartzSlider = function ( options ) {
	return this.each(function () {
		if (!jQuery.data(this, 'plugin_' + pluginName)) {
			jQuery.data(this, 'plugin_' + pluginName, 
			new Quartz( this, options ));
		}
	});
}


//})( jQuery, window, document );  // == End of Scope =======================
