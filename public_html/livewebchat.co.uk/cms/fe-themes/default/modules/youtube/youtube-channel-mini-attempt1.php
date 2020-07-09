<div id="channel_div_<?=$youtube_channelName?>" style="display: block;">
<!--	<div class="video">
		<a class="ytLink" rel="MNKt8RBk4wY" style="cursor: pointer;">
		<img src="http://i.ytimg.com/vi/MNKt8RBk4wY/2.jpg">
		</a>
		<span class="ytLink" rel="MNKt8RBk4wY">So Cool by Martin (high res\Official video)</span>
		<p>
		</p>
	</div>
	
	<div class="video">
		<a class="ytLink" rel="txIhGEHoRZI" style="cursor: pointer;">
		<img src="http://i.ytimg.com/vi/txIhGEHoRZI/2.jpg">
		</a>
		<span class="ytLink" rel="txIhGEHoRZI">Free Delivery by Martin (high res\Official video)</span>
		<p>
		</p>
	</div>
	
	<div class="video">
		<a class="ytLink" rel="c1iXStjIX18" style="cursor: pointer;">
		<img src="http://i.ytimg.com/vi/c1iXStjIX18/2.jpg">
		</a>
		<span class="ytLink" rel="c1iXStjIX18">Let It Come Down by Lucky Jim (high res\Official video)</span>
		<p>
		</p>
	</div>
	-->
</div>
<script>
		var run;
			$(document).ready(function(){
				run = function(){
				$('#channel_div_<?=$youtube_channelName?>').youTubeChannel2({ 
	            userName: '<?=$youtube_channelName?>', 
	            channel: 'uploads', 
	            hideAuthor: true,
	            numberToDisplay: 10,
	            linksInNewWindow: true
	            //other options
	            //loadingText: "Loading...",                    
	        });
       		//$(document).pngFix();
					};
					run();
		});

</script>