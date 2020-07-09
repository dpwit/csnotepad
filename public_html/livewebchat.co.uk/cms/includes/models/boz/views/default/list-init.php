<?
	if(!isset($perPage))
		$perPage = 50;
	$page = @$_GET['page'];

	if(!@$restrict) $restrict = array();

	$params['limit'] = 1000000;
	$params['offset'] = $page*$perPage;
	$params['for_fetch'] = true;
	$textFields = $model->getTextFields();
	$model->checkAccess('view',false);
	if($textFields && @$_REQUEST['search']){
		$params['restrict'] = $restrict;
		if(get_magic_quotes_gpc()) $_REQUEST['search'] = stripslashes($_REQUEST['search']);
		if(get_magic_quotes_gpc()) $_GET['search'] = stripslashes($_GET['search']);
		$restrict['like'] = $_REQUEST['search'];
	}

	$restrict = cms_apply_filter('model_listing_restrict_preprocess',$restrict,$model);
	$params = cms_apply_filter('model_listing_param_preprocess',$params,$model);

	if(($o = $model->getDefaultOrder())&&(!@$params['order'])) {
		$params['order'] = $o;
	}
	$results = $model->getAll($restrict,$params);

	$results = cms_apply_filter('model_listing_array_filter',$results);

	$records = array();
	while((count($records)<=$perPage) && ($obj=$results->fetch())){
		if(!$obj->checkAccess('view',false)) {
			continue;
		}
		$records[] = $obj;
	}

	if(count($records)>$perPage) {
		array_pop($records);
		$hasNext=true;
	} else {
		$hasNext=false;
	}


	$totalRecords = $model->numResults();
?>
