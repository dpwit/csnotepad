<?
class HistoryHooks {
	function __construct(){
		cms_listen_action('models_loaded',array($this,'load_model'));
		cms_listen_action('model_instantiated',array($this,'add_history'));
	}

	function add_history($obj){
		$obj->hasCustom('history',array($this,'get_history'));
	}
	function get_history($obj,$where=array(),$params=array()){
		$where['ref_table'] = $obj->getTableName();
		$where['ref_id'] = $obj->getId();
		return Model::loadModel('History')->getAll($where,$params);
	}
	function load_model(){
		Model::addModel('History',dirname(__FILE__).'/HistoryModel.php','HistoryModel');
	}

}
new HistoryHooks;
?>
