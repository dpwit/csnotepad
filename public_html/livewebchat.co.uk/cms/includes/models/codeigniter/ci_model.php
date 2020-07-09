<?
/**
* @package Model_System
*/

class Decorator {
	function __construct($db,$model){
		$this->db = $db;
		$this->model=$model;
	}

	function __call($func,$args){
		return call_user_func_array(array($this->db,$func),$args);
	}
}
class DBDecorator extends Decorator{
	function __call($func,$args){
		switch($func){
			case 'get_where':
			case 'get':
				return new QueryDecorator(parent::__call($func,$args),$this->model);
			default:
				return parent::__call($func,$args);

		}
	}
}
class QueryDecorator extends Decorator{
	function __call($func,$args){
		switch($func){
		case 'first_row':
			$result= parent::__call($func,$args);
			if($result) return $this->createModel($result);
			else return $result;
		case 'result':
			$result= parent::__call($func,$args);
			foreach($result as $k=>$v)
				$result[$k] = $this->createModel($v);
			return $result;
		default:
			return parent::__call($func,$args);
		}
	}

	function createModel($stdObj){
		static $models=array();
		$id = $this->model->getIDField();
		$id = $stdObj->$id;
		$class = get_class($this->model);
		if(!@$models[$class][$id]){
			$models[$class][$id] = $this->model->createInstance($stdObj);
		}
		return $models[$class][$id];
	}
}
	class BaseModel extends Model {
		function __construct($obj=null){
			parent::Model();
			if(strtolower(get_class($this))=='user_model')
				$this->User_model = $this;
			else 
				$this->load->model('User_model');
			if(method_exists($this,'createInstance')){
				$db = $this->db;
				unset($this->db);
				$this->db = new DBDecorator($db,$this);
			}
			if(!is_null($obj)){
				$this->origObj = $obj;
				foreach($obj as $k=>$v){
					$this->$k=$v;
				}
			}
		}

		static function loadModel($key){
			if(!strpos($key,'_model')) $key.='_model';
			$CI = get_instance();
			if(!isset($CI->$key))
				$CI->load->model($key);
			return $CI->$key;
		}

		function requireModel($key){
			return self::loadModel($key);
		}

		function defaultModelClass($name){
			return ucfirst($name).'_model';
		}
	}

	include(dirname(__FILE__).'/../model.php');
	MyModel::$idField = 'id';

	class HistoryModel extends MyModel {
		function overrideFields(){
			$this->setField(new HistoryField());
		}
		function history(){
			$hist = $this->loadModel('history');
			return $hist->__getAll(array('ref_table'=>$this->getTableName(),'ref_id'=>$this->getID()));
		}
	}

?>
