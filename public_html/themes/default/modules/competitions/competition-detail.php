
<div id="newsDesc">
<h3><?=$competition->title?></h3>
<?=@$competition->content?>

					<div class="bookmark">
                    				
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c5a9a011907b706"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>

<fb:like show_faces="false" width="350" font="arial"></fb:like>

<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c5a9a011907b706"></script>
<!-- AddThis Button END -->

					</div><div class="tweetThis"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>

</div>
</div>
<?php
	$defaultFileName = 'default-skint';
	if($competition->label_uid==2) $defaultFileName = 'default-loaded';
?>
<div class='last col'>
<div id="newsFeaturedImage">
<img class="newsarticleimg" src='<?=$competition->image('photo',array('default'=>'png','defaultFileName'=>$defaultFileName))?>'/>

</div>
</div>
<br clear='all' />


</div>
