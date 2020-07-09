<?php
	$limit = $limit? $limit : 4; 
	$competitionFactory = Model::loadModel('competitions');
	$competitions = $competitionFactory->getAll(
		cms_apply_filter('competitions_restrict',array()),array('order'=>'cdate desc','limit'=>$limit)
	)
?>
<div class="noBorder box" id="competitions">
	<h2>Competitions</h2>
	<ul>
		<?php
		foreach($competitions as $competition){
		
			$defaultFileName = 'default-skint';
			if($competition->label_uid==2) $defaultFileName = 'default-loaded';
			?><li>
			<a href="<?=$competition->getUrl()?>" title="<?=$competition->title?>"><img alt="<?=substr_words(60,strip_tags($competition->content))?>" title="<?=substr_words(60,strip_tags($competition->content))?>" src="<?=$competition->image('thumb',array('default'=>'png','defaultFileName'=>$defaultFileName))?>"></a>
			<div class="headingShortDesc">
				<h3><a href="<?=$competition->getUrl()?>" title="<?=$competition->title?>"><?=$competition->title?></a></h3>
				<p><?=substr_words(30,$competition->content)?></p>
			</div>
			<a class="more" href="<?=$competition->getUrl()?>" title="<?=$competition->title?> - Read more">More</a>
		</li>
<?php
			}
		?>
	</ul>
</div>