<?php
	if(!$youtube_channelName) return;
?>
<h3>YouTube Channel <a href="http://www.youtube.com/user/<?=$youtube_channelName?>"><?=$youtube_channelName?></a></h3>
<!-- ++Begin Video Bar Wizard Generated Code++ -->
  <!--
  // Created with a Google AJAX Search Wizard
  // http://code.google.com/apis/ajaxsearch/wizards.html
  --> 

  <!--
  // The Following div element will end up holding the actual videobar.
  // You can place this anywhere on your page.
  -->
  <div id="videoBar-bar">
    <span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
  </div>

  <!-- Ajax Search Api and Stylesheet
  // Note: If you are already using the AJAX Search API, then do not include it
  //       or its stylesheet again
  -->
  <script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-vbw" type="text/javascript"></script>
  <style type="text/css"> @import url("http://www.google.com/uds/css/gsearch.css"); </style>

  <!-- Video Bar Code and Stylesheet -->
  <script type="text/javascript"> window._uds_vbw_donotrepair = true; </script>
  <script src="http://www.google.com/uds/solutions/videobar/gsvideobar.js?mode=new" type="text/javascript"></script>
  <style type="text/css"> @import url("http://www.google.com/uds/solutions/videobar/gsvideobar.css");</style>

  <style type="text/css">
			.playerInnerBox_gsvb .player_gsvb
				{ width : 320px; height : 260px; }
		/* Garett + Mikes Little Hack */
			.playing_gsvb 
				{ background-color:#555555; }
			table.resultTable_gsvb td
				{ float:left; padding:10px; }
			.resultTable_gsvb tr + tr 
				{ display:none; }
		/* Garett + Mikes Little Hack */
  </style>
  <script type="text/javascript">
    function LoadVideoBar() {
			var videoBar;
			var options = {
					largeResultSet : true,
					horizontal : true,
					thumbnailSize : GSvideoBar.THUMBNAILS_MEDIUM,
					autoExecuteList : {
						cycleTime : GSvideoBar.CYCLE_TIME_EXTRA_SHORT,
						cycleMode : GSvideoBar.CYCLE_MODE_LINEAR,
						executeList : ["ytchannel:<?=$youtube_channelName?>"]
					}
				}

			videoBar = new GSvideoBar(document.getElementById("videoBar-bar"),
																GSvideoBar.PLAYER_ROOT_FLOATING,
																options);
    }
    // arrange for this function to be called during body.onload
    // event processing
    GSearch.setOnLoadCallback(LoadVideoBar);
  </script>
<!-- ++End Video Bar Wizard Generated Code++ -->