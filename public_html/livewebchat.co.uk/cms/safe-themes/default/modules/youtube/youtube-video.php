<?php
	//if(!$youtube_videoCode) return;
	$where = array();
	$homePageNews = Model::loadModel('homePageNews')->getFirst($where,array('order'=>'uid desc'));
	if(!$homePageNews) return;
?>
<div class="featuredImage">
	<?php 
		if($homePageNews->useYoutubeVideo){ 
			$youtube_videoCode = $homePageNews->video_id;
			?>
				<object width="480" height="290">
					<param name="movie" value="http://www.youtube.com/v/<?=$youtube_videoCode?>&amp;hl=en_GB&amp;fs=1"></param>
					<param name="allowFullScreen" value="true"></param>
					<param name="allowscriptaccess" value="always"></param>
					<embed src="http://www.youtube.com/v/<?=$youtube_videoCode?>&amp;hl=en_GB&amp;fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="290"></embed>
				</object>
			<?php
		} 
		else { 
			?>
				<img src="<?=$homePageNews->image('thumbSmall',array('default'=>'png','defaultFileName'=>$defaultFileName))?>">
			<?php 
		} 
	?>
</div>
<h2><?=$homePageNews->title?></h2>
<?=$homePageNews->content?>
