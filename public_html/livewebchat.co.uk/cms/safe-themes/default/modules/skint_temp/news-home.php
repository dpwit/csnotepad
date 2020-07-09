<div id="news" class="noBorder box">
	<h2>News</h2>
	<ul>
		<?php
			$newsFactory= Model::loadModel('news');
			$newsItems = $newsFactory->getVisible(
				$arr = cms_apply_filter('news_restrict',array()),
				array('order'=>'sorting asc','limit'=> ( $limit ? $limit : 10 ) )
			);
			foreach($newsItems as $news){
				$newsTitle = (strlen($news->title) > 30)? substr(strip_tags($news->title),0,30) . '...' : $news->title;
				$shortText = (strlen($news->shorttext) > 24)? substr(strip_tags($news->shorttext),0,24) . "..." : $news->shorttext;
				?><li><?php
				
					$defaultFileName = 'default-skint';
					if($news->label_uid==2) $defaultFileName = 'default-loaded';
				
					?><a href="<?=$news->getURL()?>" title="<?=$news->title?>"><img alt="<?=$news->title?>" src="<?=$news->image('home',array('default'=>'png','defaultFileName'=>$defaultFileName)) ?>"></a><?php
					?><h3><a href="<?=$news->getURL()?>" title="<?=$news->title?>"><?=$newsTitle?></a></h3><?php
					?><p><?=$shortText?></p><?php
					?><a class="more" href="<?=$news->getURL()?>" title="<?=$news->title?> - Read more">More</a><?php
				?></li><?php
			}
		?>
	</ul>
	<?php 
		if ($archiveLink) {
			?><a href="/news" class="footer">News Archive</a><? 
		} 
	?>
</div>