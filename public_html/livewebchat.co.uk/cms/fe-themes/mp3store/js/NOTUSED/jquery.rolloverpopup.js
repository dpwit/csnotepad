/*
 * imgPreview jQuery plugin
 * Copyright (c) 2009 James Padolsey
 * j@qd9.co.uk | http://james.padolsey.com
 * Dual licensed under MIT and GPL.
 * Updated: 09/02/09
 * @author James Padolsey
 * @version 0.21
 */
(function($){
    
    $.expr[':'].linkingToImage = function(elem, index, match){
        // This will return true if the specified attribute contains a valid link to an image:
        return !! ($(elem).attr(match[3]) && $(elem).attr(match[3]).match(/\.(gif|jpe?g|png|bmp)$/i));
    };
    
    $.fn.rolloverPopup = function(userDefinedSettings){
        
        var s = $.extend({
            
            /* DEFAULTS */
            
            // CSS to be applied to image:
            imgCSS: {},
            // Distance between cursor and preview:
            distanceFromCursor: {top:30, left:50},
            // Boolean, whether or not to preload images:
            preloadImages: true,
            // Callback: run when link is hovered: container is shown:
            onShow: function(){},
            // Callback: container is hidden:
            onHide: function(){},
            // Callback: Run when image within container has loaded:
            onLoad: function(){},
            // ID to give to container (for CSS styling):
            containerID: 'imgPreviewContainer',
            // Class to be given to container while image is loading:
            containerLoadingClass: 'loading',
            // Prefix (if using thumbnails), e.g. 'thumb_'
            thumbPrefix: '',
            // Where to retrieve the image from:
            popupClass: 'rollover-popup',
	    titleClass: 'rollover-title'
            
        }, userDefinedSettings),

        
        $container = $('<div class="popup-wrapper"/>').attr('id', s.containerID)
                        .append('<div class="loader"/>')
			.hide()
                        .css('position','absolute')
                        .appendTo('body');
	$container.css('opacity',0).css('display','none');
            
        $img = $('.loader', $container).css(s.imgCSS);
        
        // Get all valid elements (linking to images / ATTR with image link):
        $collection = this;
	var wrapper = $('.popup-wrapper');
        
        // Re-usable means to add prefix (from setting):
        function addPrefix(src) {
            return src.replace(/(\/?)([^\/]+)$/,'$1' + s.thumbPrefix + '$2');
        }
	var lastE;
	var scrollTo =
	    function(e){
		    if(!e){
			    e=lastE;
		    } else {
			    lastE=e;
		    }
      		//Move above
		var dwidth = ($('body').outerWidth());
		var dheight = $(window).height();
		var pwidth = $container.innerWidth();
		var pheight = $container.innerHeight();

		var x = (e.pageX<dwidth/2) ? 
			e.pageX+s.distanceFromCursor.left : 
			e.pageX-s.distanceFromCursor.left - pwidth;
		var y = (e.screenY<dheight/2) ? 
			e.pageY+s.distanceFromCursor.top : 
			e.pageY-s.distanceFromCursor.top - pheight;
		var max = function(a,b){ return a>b ? a:b; }
		var min = function(a,b){ return a>b ? b:a; }
		var sc = $(window).scrollTop();
		y = min(y,sc+$(window).height()-pheight);
		y = max(y,sc+0);
		x = min(x,sc+$(window).width()-pwidth);
		x = max(x,0);
                $container.css({
			top:	y,
			left:	x
                });
                
            };
        
	var els = [$collection,wrapper];
	for(i=0;i<2;i++)
		els[i]
            .mousemove(scrollTo)
            .hover(test = function(){
		var title = $(this).find('.'+s.titleClass).text();
                var link = $('.'+s.popupClass,this);
		var opacity = $container.css('opacity');
		if($(link).hasClass(s.popupClass)){
			$img.html($(link).html());
		}
		//$container.fadeTo("fast",1).show().css('opacity',opacity);
		$container.stop(true);
		$container.css('display','block').fadeTo("slow",1);
                
            }, function(){
		$container.stop(true);
		$container.fadeOut("slow",function(){ $(this).css('opacity',0).css('display','block');});
            });
        // Return full selection, not $collection!
        return this;
        
    };
    
})(jQuery);
