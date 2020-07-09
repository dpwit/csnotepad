<?
	cms_no_template();
	$GLOBALS['ID_FIELD'] = $_GET['mfield'];
	$user = Model::loadModel('User')->getLoggedInUser();
	cms_register_filter('model_listing_actions','select_only');
cms_register_filter('cms_has_actions','yes',false,1000);
	$model->showView('list',$params);


	function select_only($actions,$object){
		global $ID_FIELD;

		$id = $ID_FIELD ? $object->$ID_FIELD : $object->getId();
?>
	<a class='overviewAction overViewAction-<?=@$label?> mm-selector-select' href='<?=$id?>:<?=$object->applyFilters('mm_listing_label',$object->getLabel())?>'><span class='actionText'>Select <?=$object->getEnglishName(false)?></span></a>  
<?
			return array();
		}
