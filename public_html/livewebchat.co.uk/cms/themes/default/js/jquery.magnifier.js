/**
 * @author DIO5 aka Dieter Orens
 * @version 0.1
 *
 * A simple plugin to show a magnifier effect on images, falls back as link to a larger image.
 *
 */
(function($){
    $.fn.magnify = function(options){
        var settings = {
            lensWidth: 160,
            lensHeight: 160,
            link: true,
	    fixed: false
        }
        
        var opts = $.extend(settings, options);
		
        return this.each(function(){
            var $a = $(this).click(function(){
                return false;
            });
            var $img = $("img", this);
            var $largeImage = $(new Image());
            var $lens = $("<div id='dio-lens' style='display:none; overflow:hidden; position:absolute;'></div>");
            var $sensor = $("<div id='dio-sensor' style='position:absolute;'></div>");
            var $loader = $("<div id='dio-loader'>loading</div>").css({
                width: settings.lensWidth,
                height: settings.lensHeight
            });
            
            $largeImage.attr('src', $a[0].href);
            
            if (settings.link) {
                $sensor.click(function(){
                    window.location = $a[0].href;
                })
            }
            
            $lens.append($loader);
            
            $largeImage.load(function(){
                loadCallback();
            });
			
			if($largeImage[0].complete)
			{
				loadCallback();
			}
			
			function loadCallback()
			{
				$lens.append($largeImage);
                $loader.remove();
			}
            
            $('body').append($lens).append($sensor);
            
            $lens.css({
/*              width: settings.lensWidth,
                height: settings.lensHeight*/
            });
            
	function isScrolledIntoView(elem,scrollEl)
	{
		var docViewTop = $(scrollEl).offset().top;
		var docViewBottom = docViewTop + $(scrollEl).height();
		
		var elemTop = $(elem).offset().top;
		var elemBottom = elemTop + $(elem).height();
		
		return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom)
			&& (elemBottom <= docViewBottom) &&  (elemTop >= docViewTop) );
	}

	    $(window).load(function(){
	            $sensor.css({
        	        width: $img.width() + "px",
                	height: $img.height() + "px",
	                top: $img.offset().top + "px",
        	        left: $img.offset().left + "px",
                	backgroundColor: '#fff',
	                opacity: '0'
			});
		});
	    $img.closest('.scrollable,body').scroll($.debounce(function(){
	            $sensor.css({
        	        width: $img.width() + "px",
                	height: $img.height() + "px",
	                top: $img.offset().top + "px",
        	        left: $img.offset().left + "px",
			display: isScrolledIntoView($img,$img.closest('.scrollable,body'))?'block':'none',
                	backgroundColor: '#fff',
	                opacity: '0'
			});
		},300));
            $sensor.css({
                width: $img.width() + "px",
                height: $img.height() + "px",
                top: $img.offset().top + "px",
                left: $img.offset().left + "px",
                backgroundColor: '#fff',
		display: isScrolledIntoView($img,$img.closest('.scrollable,body'))?'block':'none',
                opacity: '0'
            }).mousemove(function(e){
                $lens.css({
                    left: parseInt(e.pageX - (settings.lensWidth * .5)) + "px",
                    top: parseInt(e.pageY - (settings.lensHeight * .5)) + "px"
                }).show();
                var scale = {};
                scale.x = $largeImage.width() / $img.width();
                scale.y = $largeImage.height() / $img.height();
                
                var left = -scale.x * Math.abs((e.pageX - $img.offset().left)) + settings.lensWidth / 2 + "px";
                var top = -scale.y * Math.abs((e.pageY - $img.offset().top)) + settings.lensHeight / 2 + "px";
                
		if(settings.fixed){
			left=0;
			top=0;
		}
                $largeImage.css({
            /*        position: 'absolute',*/
                    left: left,
                    top: top
                });
                
            }).mouseout(function(){
                $lens.hide();
            });
        });
    }
})(jQuery);
