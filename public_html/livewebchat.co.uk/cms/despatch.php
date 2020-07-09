<?php 
/**
* @package BozBoz_CMS
*/

	include 'requiredConnections.php' ;
	extract($_GET);
	if(!@$action) $action='index';
	$model = Model::cmsLoadController();
	$modelName = $model ? $model->getModelName(false) : $pageType;
	$errors = array();
	if(!$_SESSION['uid']) $errors['USER_LEVEL'] = 'You must log in to edit items';
	$access_denied = cms_call_hook('check_access',$errors,array('pageType'=>$pageType,'uid'=>@$cms_uid,'action'=>@$action,'model'=>$model,'modelName'=>$modelName));
	if (!$access_denied) {
		call_user_func(array($model,"cms_$action"),$_GET);
	} else {
		echo "<li>".join("</li><li class='error'>",$access_denied)."</li>";
	}

	include("footer.php"); 
?>
