<?

/**
 * @package UpdateManager
 */
require_once(dirname(__FILE__).'/../cli-env.php');
ini_set('memory_limit','512M');
ini_set('max_execution_time',600);
$ignore = array('mmmodel');
$done = array();
$models = array_keys(Model::listModels());
foreach($models as $mname){
	$mname = str_replace('model_','',$mname);
	if(in_array($mname,$ignore)) continue;
	$mobj = Model::loadModel($mname);
	if(!$mobj->doesInternalSQL()) continue;
	$eng = $mobj->getEnglishName();
	if(@$done[$eng]) continue;
	echo ".";
	$mobj->createTable();
	//$mobj->__destroy();
}
?>
