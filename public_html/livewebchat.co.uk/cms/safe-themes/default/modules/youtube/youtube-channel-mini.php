<?php
	if(!$youtube_channelName) return;
?>
 <style type="text/css">
			.videoBar-bar-scroll
				{ height:250px; overflow:auto; }
</style>
<div class="youTube">
<h3><a href="http://www.youtube.com/user/<?=$youtube_channelName?>" target="_blank"><strong><?=$youtube_channelName?></strong> on YouTube</a></h3>
<!-- ++Begin Video Bar Wizard Generated Code++ -->
  <!--
  // Created with a Google AJAX Search Wizard
  // http://code.google.com/apis/ajaxsearch/wizards.html
  -->

  <!--
  // The Following div element will end up holding the actual videobar.
  // You can place this anywhere on your page.
  -->
  <div class="" id="videoBar-bar-<?=$youtube_channelName?>">
    <!--<span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>-->
  </div>
	<script>
		$('#videoBar-bar-<?=$youtube_channelName?>').youtubeWidget({userName:'<?=$youtube_channelName?>'});
		//$('.youtubeTest2').youtubeWidget({userName:'loadedrecords'});
	</script>
</div>
<!-- ++End Video Bar Wizard Generated Code++ -->