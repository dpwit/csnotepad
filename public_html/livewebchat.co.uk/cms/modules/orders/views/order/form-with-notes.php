<div class='cms-two-col'>
<div class='cms-left cms-wide'>
<?
include(__MODELS_BASE__.'/boz/views/default/form.php');
?>
</div>
<div class='cms-right cms-thin'>
<?
	$noteFactory = Model::loadModel("Note");

	$note = $noteFactory->createNew(array('ref_id'=>$model->getId(),'ref_table'=>$model->getTableName(true)));
	$note->ref_table = $model->getTableName(true);
	$note->showEditForm(array('submitLabel'=>'Add Note'));
?>
</div>
<div class='clear'></div>
</div>
