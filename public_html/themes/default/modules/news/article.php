<?php
	$defaultFileName = 'default-skint';
	if($news->label_uid==2) $defaultFileName = 'default-loaded';
?>
<div class='news-article'>
<img class="newsarticleimg" src='<?=$article->image('home',array('default'=>'png','defaultFileName'=>$defaultFileName))?>'/>
<h3><?=$article->title?></h3>
<p class='summary'><?=@$article->shorttext?></p>
<?=paragraphs($article->content)?>
</div>
