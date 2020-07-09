/**
 *  Plugin which renders the YouTube channel videos list to the page
 *  @author:  H. Yankov (hristo.yankov at gmail dot com)
 *  @version: 1.0.0 (Nov/27/2009)
 *    http://yankov.us
 *  
 *  Modified my Dan Hounshell (Jan/2010) to work for favorites or 
 *  uploads feeds and simplified output 
 */

 //var __mainDiv;
 var __preLoaderHTML; 
 var __opts;



 function __jQueryYouTubeChannelReceiveData(data) {

	var cnt = 0;

	var selector = '.videoList > .VideoHolder:nth(0)';
	var selector_add = ' + .VideoHolder';
	
	$(selector).html('');
	
	var selectors = new Array();
	
	selectors[0] = selector;		
	for(var i=1 ;i<__opts.numberToDisplay; i++){
		if(i%5==0) 
			selector += ' + br';
		selectors[i] = selector += selector_add;		
	}
	var j=0;     

    $.each(data.feed.entry, function(i, e) {
		j=i;
		if (cnt < __opts.numberToDisplay) {
			var parts = e.id.$t.split('/');
			var videoId = parts[parts.length-1];
					 
			var out = '<a rel="' + 
				videoId + '" class="ytLink"><img src="http://i.ytimg.com/vi/' + 
				videoId + '/2.jpg"/></a><br clear="all"><a rel="' + 
				videoId + '" class="ytLink"><span rel="' + 
				videoId + '" class="ytLink">' + e.title.$t + '</span></a><p>';

			if (!__opts.hideAuthor) 
				out = out + 'Author: ' + e.author[0].name.$t;
				
			out = $(out + '</p>');
			$(selectors[i++]).html(out); 
			cnt = cnt + 1;

			$(out).css("cursor", "pointer");

			$(out).click(function(){
 
				$('.videoList > .YoutubeSelected').removeClass('YoutubeSelected');
				$(out).parents('.VideoHolder').addClass('YoutubeSelected');
			
				ytVid = $(out).attr("rel");

				//alert("yo "+ytVid);

				$(".bigVideo").html("<div id='ytPlayerInr'><object width='640' height='385'><param name='movie' value='http://www.youtube.com/v/"+ytVid+"&hl=en_US&fs=1&'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/"+ytVid+"&hl=en_US&fs=1&' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='640' height='385'></embed></object></div>");
				
				$.YouTubeComments({
					target:'#youtubeComments',
					videoId:ytVid
				});
			});
		}
	});	
	
	for(var i = j+1 ; i<selectors.length;i++)
	{
		$(selectors[i]).html('');
	}

  $(__preLoaderHTML).remove();

	$($('.videoList > .VideoHolder a')[0]).trigger('click');
	

}

          

(function($) {
    $.fn.youTubeChannel = function(options) {
        var videoDiv = $(this);

        $.fn.youTubeChannel.defaults = {
           //userName: null,
           // channel: "uploads", //options are favorites or uploads
           loadingText: "Loading..."
           // numberToDisplay: 3,
           // linksInNewWindow: true,
           //hideAuthor: true
        }

        __opts = $.extend({}, $.fn.youTubeChannel.defaults, options);

        return this.each(function() {
            if (__opts.userName != null) {

                videoDiv.append(__preLoaderHTML);

                $.ajax({
                    url: "http://gdata.youtube.com/feeds/base/users/"+__opts.userName + "/"+__opts.channel+"?alt=json&start=1ndex=0&max-results=15",
                    cache: true,
                    dataType: 'jsonp',                    
                    success: __jQueryYouTubeChannelReceiveData
                });

           }
        });
    };
		
		$.fn.youtubeWidget = function(options) {
        var videoDiv = $(this);

        $.fn.youTubeChannel.defaults = {
           //userName: null,
           channel: "uploads", //options are favorites or uploads
           loadingText: "Loading...",
           numberToDisplay: 3,
           // linksInNewWindow: true,
           //hideAuthor: true
        }

        var localOptions = $.extend({}, $.fn.youTubeChannel.defaults, options);
				
				var callback = function(data){
					targetDiv.find('*').remove();

					var cnt = 0;

					$.each(data.feed.entry, function(i, e) {
							if (cnt < localOptions.numberToDisplay) {
							var parts = e.id.$t.split('/');
							var videoId = parts[parts.length-1];
							var out = '<div class="video"><a rel="' + 
								videoId + '" class="ytLink"><img src="http://i.ytimg.com/vi/' + 
								videoId + '/2.jpg"/></a><span rel="' + 
								videoId + '" class="ytLink">' + e.title.$t + '</span><p>';
							if (!localOptions.hideAuthor) {
								out = out + 'Author: ' + e.author[0].name.$t + '';
							}
							out = out + '</p></div>';
							videoDiv.append(out);
							cnt = cnt + 1;
							}
					});

						if (localOptions.linksInNewWindow) {
							$(videoDiv).find("li > a").attr("target", "_blank");
						}<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/a0qMe7Z3EYg&amp;hl=en_GB&amp;fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/a0qMe7Z3EYg&amp;hl=en_GB&amp;fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>
						
						videoDiv.show();

					videoDiv.find("a.ytLink").each(function(){
						$(this).css("cursor", "pointer");
						$(this).click(function(){
							ytVid = $(this).attr("rel");
							//alert("yo "+ytVid);
							$('#content').append("<div id='ytPlayer'><div id='ytPlayerInr'><object width='640' height='385'><param name='movie' value='http://www.youtube.com/v/"+ytVid+"&hl=en_US&fs=1&'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/"+ytVid+"&hl=en_US&fs=1&' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='640' height='385'></embed></object></div></div>");
							$("#ytPlayer").dialog({ autoOpen: true, width:653, height:450, modal:true, resizable:false })
						});
					});
					
				}

        return this.each(function() {
            if (options.userName != null) {
                videoDiv.append(targetDiv = $("<div id=\"channel_div\"></div>"));
								targetDiv.hide();
								targetDiv.data('youTubeChannel.localOptions',localOptions);
				
                $.ajax({
                    url: "http://gdata.youtube.com/feeds/base/users/"+localOptions.userName + "/" +localOptions.channel + "?alt=json",
                    cache: true,
                    dataType: 'jsonp',                    
                    success: callback
                });
            }
        });
    };
	
	$.YouTubeComments = function(params) {

		var settings = jQuery.extend({
			target:'#youtubeComments', 
			videoId:'D7RCE9FjQ90'
		}, params);
		
		var callback = function(data){
			$.each(data.feed.entry,function(index, object){
				$(settings.target).append($('<h3>'+object.title.$t +'</h3><p>'+object.content.$t + '</p><hr />'));
			});
			var temp=null;
			$(settings.target).append(temp = $('<form id="comment_from" method="post" action="'+data.feed.id.$t+'"><textarea name="comment"></textarea><input type="submit" value="send" name="action" /></form>'));
			temp.submit(function(event){
				event.preventDefault();
				$.ajax({
					url: data.feed.id.$t+'?alt=json',
					cache: true,
					type:'post',
					dataType: 'jsonp',                    
					data:"<?xml version=\"1.0\" encoding=\"UTF-8\"?><entry xmlns=\"http://www.w3.org/2005/Atom\" xmlns:yt=\"http://gdata.youtube.com/schemas/2007\"> <content>This is a crazy video.</content> </entry>",
					contentType:'application/atom+xml',
					complete: function(data){
						alert(data);
					},
					beforeSend:function(xhr){
						xhr.setRequestHeader('X-GData-Key',' key=DEVELOPER_KEY');
					}
				});
				return false;
			});
			
		};
		
		$.ajax({
			url: "http://gdata.youtube.com/feeds/api/videos/"+settings.videoId+"/comments?alt=json",
			cache: true,
			dataType: 'jsonp',                    
			success: callback
		});
	};
	
	$.Boz = { Twitter : function(params) {

		var settings = jQuery.extend({
			target:'#newsFeaturedImage',
			twitterId: 'bozbozweb',
			messageCount: 4,
			drawMessageBox: function(index,message){
				return $(
					'<li class="' + (this.messageCount==index ? 'last' : '' ) + '">' +
						'<p>' +
							message.text +
						'</p>' +
						'<small>' +
							message.created_at +
							' via ' +
							message.source +
							'<span>' +
								'<a href="http://twitter.com/?status=' + 
									this.twitterId +
									'%20&in_reply_to_status_id=' +
									message.id +
									'&in_reply_to=' +
									this.twitterId +
									'">reply' +
								'</a>' +
							'</span>' + 
						'</small>' +
					'</li>'
				);
			},
			drawHeader : function(user){
				$(this.target).before($(
				'<h2 class="twitter_'+user.screen_name+'">Twitter asds</h2>'
				));
			}
			}, params);

		var drawMessage = function(messageSet){
			var temp = messageSet;
			$.each(messageSet,function(index,message){
				if(index>=settings.messageCount) return;
				var messageBox = settings.drawMessageBox(index,message);
				$(settings.target).append(messageBox);
			});
			
		};
			
		var drawTitle = function(user){
			settings.drawHeader(user);
		};
		
			
		$.ajax({
			url: "http://api.twitter.com/1/users/show/"+settings.twitterId+".json",
			cache: true,
			dataType: 'jsonp',                    
			success: drawTitle
		});
		
		$.ajax({
			url: "https://twitter.com/statuses/user_timeline/"+settings.twitterId+".json",
			cache: true,
			dataType: 'jsonp',                    
			success: drawMessage
		});

	}};

})(jQuery);
 