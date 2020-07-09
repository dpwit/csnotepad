<div class='previous-notes'>
<? if($subject = $model->subject()){ ?>
<h2>Notes on <?=$subject->getEnglishName(false)?></h2>
<?
	$s = $model->subject();
	if($subject->exists())
	foreach($subject->notes() as $note){
?>
	<div class='note <?=$note->public?'note-public':'note-private'?>'>
		<div class='author'><?=$note->author()->getLabel()?></div>
		<div class='date'><?=date("Y-m-d H:i",$note->ctime)?></div>
		<div class='comment'><?=$note->notes?></div>
	</div>
<? } ?>
<? } else { ?>
<h2>No Notes</h2>
<? } ?>
</div>

<?
	require(__MODELS_BASE__.'/boz/views/default/form.php');
?>
