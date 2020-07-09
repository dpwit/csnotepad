<?
cms_no_template();
header("Content-type: text/csv");
header("Content-disposition: attachment; filename=\"".$model->getModelName()."-listing.csv\";");
$perPage = 1000000;
$page = 0 ;
	include(dirname(__FILE__).'/list-init.php');
	$e = error_reporting();
	error_reporting($e&~E_NOTICE);
	$cols = $model->getCSVListingColumns();
	error_reporting($e);
	$colCount = count($cols)+1;

	echo format_csv(array_keys($cols))."\n";
	foreach($records as $obj){
		echo format_csv(array_map('html_entity_decode',$obj->getCSVListingColumns()))."\n";
		cms_trigger_action('model_listing_end',$obj);
	}

	function format_csv($values){
		return '"'.join('","',$values).'"';
	}
?>
