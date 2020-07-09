				<div id="newsDesc">
<?
$news = Model::loadModel('News');
$where =  $news->applyFilter('frontend_restrict',array(),'homepage_featured')
$isthislast=1;
foreach($news->getAll(array($where),array('limit'=>1)) as $news){
?>
					<h3><?=$news->title?></h3>
					<p><?=@$news->shorttext?></p>
					<p><?=paragraphs($news->content)?></p>
					<div class="bookmark">
						<span>Bookmark:</span> 
						<a href="http://www.facebook.com/sharer.php?u="><img src="images/social_fb.gif" alt="Bookmark with Facebook"></a> 
						<a href="http://del.icio.us/post?url="><img src="images/social_del.gif" alt="Bookmark with Delicious"></a>
						<a href="http://digg.com/submit?url="><img src="images/social_digg.gif" alt="Bookmark with Digg"></a> 
						<a href="http://reddit.com/submit?url="><img src="images/social_red.gif" alt="Bookmark with Reddit"></a> 
						<a href="http://www.stumbleupon.com/submit?url="><img src="images/social_su.gif" alt="Bookmark with StumbleUpon"></a>
					</div>
<?php 
}
?>
				</div>
