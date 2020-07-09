 //var __mainDiv;
 var __preLoaderHTML; 
 var __opts;


 function __jQueryYouTubeChannelReceiveData(data) {

	var cnt = 0;

	var selector = '.videoList > .VideoHolder:nth(0)';
	var selector_add = ' + .VideoHolder';
	
	__opts.pageMax = data.feed.openSearch$totalResults.$t;
	
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

				$(".bigVideo").html("<div id='ytPlayerInr'><object width='640' height='385'><param name='movie' value='http://www.youtube.com/v/"+ytVid+"&hl=en_US&fs=1&'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/"+ytVid+"&hl=en_US&fs=1&' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='640' height='385'></embed></object></div>");
				
				/*$.YouTubeComments({
					target:'#youtubeComments',
					videoId:ytVid
				});*/
			});
			if(firstload)
			{
				firstload=false;
				$($('.videoList > .VideoHolder a')[0]).trigger('click');
			}
		}
	});	 
	
	hasMore=true;
	for(var i = j+1 ; i<selectors.length;i++)
	{
		$(selectors[i]).html('');
		hasMore=false;
	}

	$(__preLoaderHTML).remove();

}

          
var firstload=true;
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
			,page:0
		}
		
		

        __opts = $.extend({}, $.fn.youTubeChannel.defaults, options);
        return this.each(function() {
            if (__opts.userName != null) {

                videoDiv.append(__preLoaderHTML);

				var page = (__opts.page * __opts.numberToDisplay)+1;
				
                $.ajax({
                    url: "http://gdata.youtube.com/feeds/base/users/" + __opts.userName + "/" + __opts.channel + "?alt=json&start-index=" + page + "&max-results=15",
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
           numberToDisplay: 3
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
						}
						
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
			
				$(settings.target).html('');
				$(settings.target).append($('<h3>'+object.title.$t +'</h3><p>'+object.content.$t + '</p><hr />'));
			});
			var temp=null;
		};
		
		$.ajax({
			url: "http://gdata.youtube.com/feeds/api/videos/"+settings.videoId+"/comments?alt=json",
			cache: true,
			dataType: 'jsonp',                    
			success: callback
		});
	};
	
	$.Boz = { 
		Twitter : function(params) {

			var settings = jQuery.extend({
				target:'#newsFeaturedImage',
				twitterId: 'bozbozweb',
				messageCount: 4,
				linkify : function(inputText) {
						//http:// ftp://
						var replacedText = inputText.replace(/(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim, '<a href="$1" rel="nofollow" target="_blank">$1</a>');

						//www.
						var replacedText = replacedText.replace(/(^|[^\/])(www\.[\S]+(\b|$))/gim, '$1<a href="http://$2" rel="nofollow" target="_blank">$2</a>');

						//Mail
						var replacedText = replacedText.replace(/(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})/gim, '<a href="mailto:$1" rel="nofollow">$1</a>');

						return replacedText;
				},
				drawMessageBox: function(index,message){
					var date = new Date(Date.parse(message.created_at) - new Date(0,0,0,1,0,0,0));
					
					var myDate = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' @ ' + 
						(date.getHours() < 10 ? '0' + date.getHours() : date.getHours())
						+ ':' + 
						(date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes())
					
					return $(
						'<li class="' + (this.messageCount==index ? 'last' : '' ) + '">' +
							'<p>' +
								this.linkify(message.text) +
							'</p>' +
							'<small>' +
								myDate + 
								//'<br />' + message.created_at +
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
		},
		
		BuildGallery : function(params) {

			var firstTime = true;
		
			var settings = jQuery.extend({
				thumbTargets : $('#gallery > ul > li'),
				gallery_uid : 2,
				displayTarget : $('#gallery > .image > .main > img'),
				titleTarget : $('#gallery > .image > .info > h3'),
				placeholderImg : 'placeholder.gif',
				data : null,
				page:0,
				selectedIndex:1,
				
				validate : function(){
					
					if(this.data.length-1 < this.selectedIndex)
						this.selectedIndex = 0;
					else if(this.selectedIndex < 0) 
						this.selectedIndex = this.data.length-1;
					
					var maxPages = Math.ceil( this.data.length / this.thumbTargets.length )-1;
					
					if(this.page>maxPages)
						this.page = maxPages;
					else if(this.page<0)
						this.page = 0;
					else{
						return true;
					}
					return false;
				},
				
				drawPage : function(){
					if(!this.validate()) return;
					var startIndex = (this.page * this.thumbTargets.length);
					var endIndex = Math.min(startIndex + this.thumbTargets.length, this.data.length);
					var i = startIndex;
					settings = this;
					thumbTargets = this.thumbTargets;

					$.each(this.thumbTargets, function(index,thumbHolder){
						$(thumbHolder).fadeOut(150,function(){
						
							if(i>=settings.data.length){
								var linkImage = '<img src="/images/'+settings.placeholderImg+'">';
								$(thumbHolder).html(linkImage);
								$(thumbHolder).fadeIn(150);
								return;
							}
							
							var imageData = settings.data[i];
							var linkImage = $(							
								'<a href="http://www.skintentertainment.com'+imageData.imageUrlOrig+'">'+
									'<img src="'+imageData.imageUrlThumb+'" />'+
								'</a>'
							);
							
							$(thumbHolder).html(linkImage);
							$(linkImage).find('img').load(function(){
								$(thumbHolder).fadeIn(150);
							});
							
							var x = i;
							
							$(linkImage).click(function(){
								if(!firstTime && x == settings.selectedIndex) return false;
								settings.selectedIndex = x;
								return settings.draw();
							});
							
							if(firstTime){
								$(linkImage).trigger('click');
								firstTime = false;
							}
							i++;
						});
					});
				},
				
				draw : function(){ 
					this.validate();
					imageData = this.data[this.selectedIndex];
					//$('#gallery > .image > .main > img').fadeOut(150 , function(){
						//$('#gallery > .image > .main > img').attr('src',imageData.imageUrl).load(
					var displayTarget = this.displayTarget;
					$(displayTarget).fadeOut(150 , function(){
						$(displayTarget).load(
							function(event) {
								$(event.currentTarget).fadeIn(150);
							}
						).attr('src',imageData.imageUrl);
					});
					this.titleTarget.html(imageData.title);
					return false;
				}
				
			}, params);
			
			
			
			var callback = function(data){
				settings.data = data;
				settings.drawPage(0);
			};
			
			$.ajax({
				url: "http://www.skintentertainment.com/webservice/gallery/gallery_detail.php?gallery_uid="+settings.gallery_uid,
				cache: true,
				dataType: 'json',                    
				success: callback
			});
			
			return settings;
			
		}
		
	};
	
	
})(jQuery);
 