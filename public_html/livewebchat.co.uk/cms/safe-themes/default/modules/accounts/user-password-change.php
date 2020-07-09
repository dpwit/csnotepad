<div class="box thinBorder" id="shop">
<!--<h3>Change Password</h3>-->
<?
	$form = $model->getForm();
	$sections["Change Password"] = array('passwordold','password','passwordconfirm');
	include(__MODELS_BASE__.'/boz/views/default/form.php');
?></div>
