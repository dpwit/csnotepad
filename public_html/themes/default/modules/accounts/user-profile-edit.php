<div class="box thinBorder userprofile" id="shop">
<!--<h2>Personal Details</h2>-->
<?
	$hiddenFields = array('id');
	$sections = array();

	$main = array('title','firstName','lastName','email');
	if(!$model->exists()){
		$main = array_merge($main,array('passwordold','password','passwordconfirm'));
	} else {
		$hiddenFields = array_merge($hiddenFields,array('passwordold','password','passwordconfirm'));
	}
	$done = $hiddenFields;
	$done = array_merge($done,$main);

	$main = array(
		'Personal Details'=>array_merge($main,array_diff(array_keys($model->getFields()),$done))
	);

	$sections = array_merge($main,$sections);

	$remove = array('realName');
	
	foreach($sections['Personal Details'] as $k => $v) 
		if(in_array($v,$remove)) 
			unset($sections['Personal Details'][$k]);

	require_once(__MODELS_BASE__.'/boz/views/default/form.php');
?>
</div>
