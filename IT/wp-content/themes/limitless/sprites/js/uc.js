

jQuery(function(){

jQuery('.radial-chart').each(function(){

	jQuery(this).easyPieChart({
		size : 260 ,
		lineWidth : jQuery(this).data('line_width'),
		barColor : jQuery(this).data('bar_color'),
		trackColor : false,
		scaleColor : false,
		lineCap : "butt" ,
		animate : 2000
    });

});


 jQuery('div.animate-uc-area').transit({  backgroundPosition: "-1999px 0" },60000,'linear');

});