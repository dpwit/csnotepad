<?
/**
* @package Model_System
*/

	if(!@$fields) $fields = $model->getFields();
	$fields = $model->getFormForFields($fields);
	if(@$flattenFields) { 
		foreach($fields as $k=>$v){
			@list($table,$field) = explode(".",$k);
			if($field) {
				unset($fields[$k]);
				$fields[$field] = $v;
			}
		}
	}
	if(!@$action) $action = $model->urlFor('save');
	if(!@$submitLabel) $submitLabel = "Save ".$model->getEnglishName(false);

	if(!@$sections) {
		$sections = $model->applyFilters('cms_edit_form',@array($mainSection=>array_keys($fields)));
	}
	if(!@$suppressLabel){
		$suppressLabel = array();
	}
	if(!@$noForm){
?>
	<form method='post' enctype='multipart/form-data' action='<?=$action?>' class='warn-on-navigate <?=strtolower(get_class($model))?> <?=@$form_class?>'>
<? } ?>
<?=$model->form->hidden?>
<?= @$hidden ?>
<div class='form_main form_<?=$model->getTableName()?>'>
<? foreach($sections as $sectionName=>$fieldList) { ?>
<div class='formSection formSection-<?=$sectionName?> clearfix'> 
<? if($sectionName) { ?>
	<a name='<?= $sectionName ?>'><h3 class='formHeading'><?= $sectionName ?></h3></a>
<? } 
	cms_trigger_action('cms_form_section_header',$sectionName);
?>
<? foreach($fieldList as $fieldName){
	$field = @$fields[$fieldName];
	if(!$field) continue;
?>
	<div class='form_row <?=$field['field']->param('css_class')?> <?=$field['field']->getName()?> <?= $field['errors'] ? "formsubmit_error" : "ok"?>'>
	<?php if(!in_array($field['name'],$suppressLabel)) { ?>
		<div class='form_label'><?=$field['label']?>:</div>
	<? } ?>
		<div class='form_input'><?=$field['html']?></div>
		<? if($field['errors']) { ?>
		<div class='form_error'><?=$field['errors']?></div>
		<? } ?>
		<? if($field['notes']) { ?>
		<div class='form_notes'><?=$field['notes']?></div>
		<? } ?>
		<div class='form_row_footer'></div>
	</div>
<? } /* end foreach */ ?>
</div>
<? } ?>
<? if(!@$noForm) { ?>
<div class="submitButton">
<input type='submit' value='<?=$submitLabel?>' class='coolButton'/>
</div>
<? } ?>
</div>
<?php /* FOOTER NOT USED ???? 
<div class='clear form_section_footer'>
|<?
	$model->triggerAction('form_footer');
?>
</div>
*/
?>
<? if(!@$noForm) { ?>
</form>
<? } ?>
<br style="clear: both " />
