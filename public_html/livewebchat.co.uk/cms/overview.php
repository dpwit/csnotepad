<?php include 'requiredConnections.php' ;
if (check_access($pageType,'overview')) {
	$model = Model::cmsLoadModel();
	$modelName = $model ? $model->getModelName(false) : $pageType;
	
	page_is_real();
	if(!cms_call_hook('handle_overview_'.$modelName,false,array('modelName'=>$modelName,'model'=>$model))) {
		$dir = cms_module_resolve($pageType);
		include $dir.'/'.$pageType.'Sql.php';
		include $dir.'/'.$pageType.'Links.php';	
		include $dir.'/'.$pageType.'OverviewTable.php';
	}
}	else	{
?> 
	<p>You are not authorised to view this page your level is not high enough</p> 
<?php 
}
include("footer.php"); 
?>
