
						<div id="artistYouTube" class="thinBorder box">
							<h2>Videos<!-- (<a href="http://youtube.com/<?=$youtubeChannel?>"><?=$youtubeChannel?></a>)--></h2>
							<div id="videoBar"></div>
							<div style="clear: both"></div>
<script>
	$('#videoBar').youtubeWidget({userName:'<?=$youtubeChannel?>',numberToDisplay:4});
	//$('.youtubeTest2').youtubeWidget({userName:'loadedrecords'});
</script>
						</div>
						
