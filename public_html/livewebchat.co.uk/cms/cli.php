<?php 
/**
* @package BozBoz_CMS
*/

	include_once 'common.php';
	load_theme_hooks();
	include_once 'db.php';
	include_once 'includes/functions/generalFunctions.php';
	Model::loadModel('User')->logInCLI();
	list($model,$action,$args) = Model::cliLoadModel();
	//$cms_uid = $model->getId();
	$modelName = $model ? $model->getModelName(false) : $pageType;
	$errors = array();
	if(!$_SESSION['uid']) $errors['USER_LEVEL'] = 'You must log in to edit items';
	$access_denied = cms_apply_filter('check_access',$errors,array('pageType'=>@$pageType,'uid'=>@$cms_uid,'action'=>$action));
	$args = array_slice($_SERVER['argv'],3);
	if(!$access_denied && !cms_call_hook('handle_despatch_'.@$modelName,false,array('action'=>$action,'uid'=>@$cms_uid,'pageType'=>@$pageType,'modelName'=>@$modelName,'model'=>$model,'params'=>$args))) {
		call_user_func(array($model,"cms_$action"),$args);
	}
?>
