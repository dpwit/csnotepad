<div class="thinBorder box comp">
<div id="competitions">
<h2>Competitions</h2>
<ul>
<?
//var_dump($item);

$competitionFactory = Model::loadModel('competitions');
$competitions = $competitionFactory->getAll(array(),array('limit'=>5));
$isthislast=count($competitions);
foreach($competitions as $competition){
	$defaultFileName = 'default-skint';
	if($competition->label_uid==2) $defaultFileName = 'default-loaded';
?>
	<li class="newsfeature clearfix <? if ($isthislast==0) { echo "final"; } ?>">
	<a href="<?=$competition->getURL()?>" title="<?=$competition->getLabel()?>"><img src="<?=$competition->image(array('size'=>'thumb','default'=>'png','defaultFileName'=>$defaultFileName))?>" alt="<?=$competition->getLabel()?>" /></a>
	<h3><?=$competition->getLabel()?></h3>
	<p><?=$competition->getDescription()?></p>
	<a class="more" href="<?=$competition->getUrl()?>">more</a>
	</li>
	<?
	$isthislast--;
}
?>
</ul>
</div>
</div>