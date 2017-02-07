( function() {
    tinymce.PluginManager.add( 'cool_timeline', function( editor, url ) {
        editor.addButton( 'cool_timeline_btn', {
				title: 'Cool Timeline Shortcode',
				text: false,
				image: url + '/cooltimeline.png',
				onclick: function(){
				editor.insertContent( '[cool-timeline]' );
				}
			});
	});
})();