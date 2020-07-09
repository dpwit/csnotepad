					<div class="thinBorder box" id="artistsList">
						<h2>News Articles</h2>
						<ul>
<?
	$news = Model::loadModel('News');
	$where =  $news->applyFilter('frontend_restrict',$where,'homepage_listing')
	$newsItems = $news->getAll($where,array('order'=>'date asc','limit'=>20));
	foreach($newsItems as $news){	
		$url = $news->getUrl();
		$class = BreadCrumb::selected($url)? ' on' : '';
		$newsTitle = substr(strip_tags($news->title),0,28) . "...";
		
		?>
							<li><a class="<?=$class?>" href="<?=$news->getUrl()?>"><?=$newsTitle?></a></li>
<?php
	}	
?>						</ul>
					</div>
