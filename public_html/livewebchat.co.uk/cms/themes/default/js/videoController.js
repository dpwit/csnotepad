Video = {
	animating: false,
	toggleNav: function(){
		var navEl = $('video-navigation-menu');
		Video.switchNav(navEl.style.visibility!='visible');
	},
	switchNav : function (on){
		if(Video.animating) return;
		$('video-navigation-menu').style.visibility=on?'visible':'hidden';
		return;

		var navEl = $('video-navigation-menu');
		if((!on)&&(navEl.style.visibility!='visible')) return;
		if((on)&&(navEl.style.visibility=='visible')) return;

		var duration =0.75;
		if(on){
			Video.animating = true;
			navEl.style.height=0;
			var maxHeight = Video.accordions['video-navigation-menu'].maxHeight+50;
		        var options = {
		            scaleFrom: 0,
		            scaleContent: false,
		            transition: Effect.Transitions.sinoidal,
		            scaleMode: {
		                originalHeight: maxHeight
		            },
		            scaleX: false,
		            scaleY: true,
			    duration: duration,
			    afterFinish: function(){Video.animating=false;}
		        };
        		new Effect.Scale(navEl, 100, options);
			navEl.style.visibility='visible';
		} else {
			Video.animating = true;
		        var options = {
		            scaleContent: false,
		            transition: Effect.Transitions.sinoidal,
		            scaleX: false,
		            scaleY: true,
			    duration: duration,
			    afterFinish: function(){Video.animating=false; navEl.style.visibility='hidden'; }
		        };
        		new Effect.Scale(navEl, 0, options);
		}
	},
	accordions: {},
	setAccordion: function(id,obj){
		Video.accordions[id] = obj;
	},
	loadVideo: function(id,name,baseUrl){
		Video.switchNav(false);
		Video.playVideo(name);

		new Ajax.Request( baseUrl+'/modules/doCourse/viewVideo.php?cms_uid='+id,
			{
				onSuccess: function(tr){
					$('unviewed-panel').innerHTML=tr.responseText;
						$('course-video-link-'+id).removeClassName('video_unviewed');
						$('course-video-link-'+id).addClassName('video_viewed');
				}
			});
	},
	playVideo: function(name){
	//	Video.createFlashPlayer(name);
		new Effect.Fade('videoBoxHolder',
			{
			afterFinish: function(){
				Video.createFlashPlayer(name);
				new Effect.Appear('videoBoxHolder',{
					afterFinish: function(){
					}
				});
			}
		});
		
	},
	createFlashPlayer: function(videoName){
		$('videoBoxHolder').innerHTML='';
		var div = document.createElement("div");
		div.id='videoBox';
//		div.id='videoBox-'+Math.random();
		$('videoBoxHolder').appendChild(div);
		$('videoBox').innerHTML='<h1>TESTING</h1>';
		var flashvars = {};
		flashvars.movieURL = videoName;
		var params = { wmode: 'transparent'};
		params.scale = "noscale";
		var attributes = {};
		swfobject.embedSWF(Video.url, div.id, "800", "401", "9.0.0", false, flashvars, params, attributes);
	},
	url: "VIANETPlayer.swf",
	setPlayerURL: function(url){
		Video.url = url;
	},

	test:false
};
