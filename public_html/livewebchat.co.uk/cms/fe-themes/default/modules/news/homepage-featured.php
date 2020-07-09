<ul>
<?
$news = Model::loadModel('News');
$isthislast=1;
foreach($news->getAll(array(),array('limit'=>2)) as $news){
	$defaultFileName = 'default-skint';
	if($news->label_uid==2) $defaultFileName = 'default-loaded';
?>
	<li class="newsfeature clearfix <? if ($isthislast==0) { echo "final"; } ?>">
	<img src="<?=$news->image(array('size'=>'home','default'=>'png','defaultFileName'=>$defaultFileName))?>" alt="" />
	<h3><?=$news->getLabel()?></h3>
	<p><?=$news->getDescription()?></p>
	<h4><a href="<?=$news->getUrl()?>">more</a></h4>
	</li>
	<?
	$isthislast--;
}
?>
</ul>
