jQuery(function(){
	jQuery.noConflict();
	
	/* BACKGROUND */
	var theWindow    = jQuery(window),
	jQuerybg         = jQuery("#bg"),
	aspectRatio      = jQuerybg.width() / jQuerybg.height();
			    			    		
	function resizeBg() {				
		if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
			jQuerybg
				.removeClass()
				.addClass('bgheight');
		} else {
			jQuerybg
			   	.removeClass()
			   	.addClass('bgwidth');
		}						
	}
			                   			
	theWindow.resize(function() {
		resizeBg();
	}).trigger("resize");
			
}); 
