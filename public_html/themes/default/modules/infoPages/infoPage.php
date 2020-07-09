<div id="infoPage">
<?
$infoPageFactory = Model::loadModel('infoPages');
$where['status'] = 1;
$infoPages = $infoPageFactory->getVisible($where,array('order'=>'sorting asc'));
foreach($infoPages as $infoPage) {
	?>
		<h3><a href="<?=$infoPage->getURL()?>"><?=$infoPage->title?></a></h3>
		<p><?=$infoPage->short_text?></p>
		<a href="<?=$infoPage->getURL()?>" class="more">More</a>
		<hr />

<?php
}
?>
</div>