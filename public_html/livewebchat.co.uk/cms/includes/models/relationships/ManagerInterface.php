<?
/**
* @package Model_System
*/

	require_once(dirname(__FILE__).'/../relationships/FileManagers.php');
	interface IExternalManager {
		function initRel($rel);
		function fetch();
		function store($newModel,$oldValues,$assigns);
		function getAssigns();
		function setDataFromPost($data,$formName='default'); //Shouldn't really be here.
		function validate(); //Shouldn't really be here.
		function on_init();
	}
	class DummyManager {
		function __construct($field,$params,$model){
			$this->name = $field;
			$this->params = $params;
			$this->instance = $model;
		}

		function getRelatedModelType(){
			$m = @$this->params['model'];
			if(!$m) $m=$this->instance->unpluralize($this->name);
			return $m;
		}
		function getRelatedModel(){
			return Model::loadModel($this->getRelatedModelType());
		}
		function initRel($rel){return $rel;}
		function fetch(){return false;}
		function store($newModel,$oldValues,$assign){}
		function getAssigns(){return array();}
		function setDataFromPost($data,$formName='default'){}
		function validate(){return true;}
		function on_init(){}
	}
?>
