<?
/**
* @package Model_System
*/

	if(!@$fields) $fields = $model->getFields();
	$fields = $model->getFormForFields($fields);

?>
<table class='compact-form'>
<tr>
<?
	foreach($fields as $field){
		?><th class='<?=$field['field']->getName()?>'><?=$field['label']?></th><?
	}
?></tr>
<tr>
<?
	foreach($fields as $field){
		?><td class='<?=$field['field']->param('css_class')?> <?=$field['field']->getName()?> <?= $field['errors'] ? "formsubmit_error" : "ok"?>'><?=$field['html']?></td><?
	}
?>
</tr></table>
<?=$model->form->hidden?>
<?= @$hidden ?>
