		var mp3Index=0;
		//var playMP3 = function(mp3){
        var flashvars = {};
	 	var ms = $('#musicWrapper');
	    if(ms.length) {
		    ms.html('<div class="musicPlayer" id="musicPlayer-'+(++mp3Index)+'"></div>');
		    ms.show();
	    }
	   // flashvars.JStrackURL = "/html/musicplayer/1.mp3";
	   // flashvars.JStrackLabel = "No Track Loaded";
		
		var params = {};
			params.wmode = "transparent";
			params.allowscriptaccess = "always";	
	    var id = 'musicPlayer';
	    if(ms.length) id+="-"+mp3Index;
           swfobject.embedSWF("/html/musicplayer/mp3player.swf", id, "350", "25", "9.0.0", "/html/musicplayer/expressInstall.swf", flashvars, params);
		
//            $(function(){
  //              $('#musicPlayer').hide();
//	    	});
		//}
	   function extractGet(url,key){
		re = new RegExp(".*[?&]"+key+"=");
		return Url.decode(url.replace(re,'').replace(/&.*/,'')).replace(/\+/g,' ');
	   }
        function handleClick(newMp3URL, newTrackLabel)
  		{
      		try {
	//		newMp3URL='/html/musicplayer/1.mp3';
//      		newMp3URL = "http://"+document.location.host+newMp3URL;
//	      		newMp3URL = newMp3URL.substr(1);
//			alert(newTrackLabel + ':' + newMp3URL);
			var uid = extractGet(newMp3URL,'uid');	
			var title = extractGet(newMp3URL,'name');
			var url = extractGet(newMp3URL,'url');
			if(!newTrackLabel) newTrackLabel=title;
   			document.getElementById( "musicPlayer" ).callMe( newMp3URL, newTrackLabel , uid, url);
      		} catch(err){
//            	alert("flash.callMe('"+newMp3URL+"','"+newTrackLabel+"');");
            		if(typeof console != 'undefined') console.log(err);
      		}
   			
   		}
   		$('a.mp3-link').live('click',function(){
   	   		handleClick($(this).attr('href'));//,$(this).attr('title'));
   	   		return false;
   		});
	   	 //playMP3("musicplayer/1.mp3");
