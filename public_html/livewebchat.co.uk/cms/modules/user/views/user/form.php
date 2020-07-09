<?
	if($model->hasRel('notes')){
		require(cms_module_resolve('orders','views/order/form-with-notes.php'));
	} else {
		require(__MODELS_BASE__.'/boz/views/default/form.php');
	}
?>
