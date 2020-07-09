<?
/**
* @package Model_System
*/

	require_once(dirname(__FILE__).'/ManagerInterface.php');
	abstract class CompositionManager implements IExternalManager {
		function __construct($name,$rel,$model){
			$this->name=$name;
			$this->rel=$rel;
			$this->model = $model;
		}
		function includeTable($field,&$tables,$value){
			$table = $this->name;
			$tableName = $this->model->pluralize($this->model->getTableName(true));
			$rel = $this->rel;
			$tables.=" JOIN $rel[table] $table ON $tableName.$rel[field]=$table.$rel[ref_field]";
			$field = ("`$table`.`$field`");
			return $field;
		}
		function initRel($rel){ return $rel;}
		function pre_delete(){
			foreach($this->fetchArray() as $instance) $instance->delete();
		}
		function store($new,$old,$assigns){
			$ref = $this->rel['ref_field'];
			$ar = $this->fetchArray();
			$sort = null;
			try {
				$old=1;
				$sort = Model::loadModel($this->rel['model'])->getSortField();
			} catch(BadRelationShipException $e){
			}
			foreach($ar as $instance) {
				if($ref!=$instance->getIDField())
					$instance->$ref = $this->model->getId();
				if($sort){
				       if($instance->$sort<$old){
						$instance->$sort = $old+1;
				       }
				       $old = $instance->$sort;
				}
				try {
					$instance->writeToDB();
					} catch(Exception $e){
					error_log($e->getMessage());
					}
				$field = $this->rel['field'];
				if($field !=$this->model->getIDField()){
					$value = $instance->$ref;
					if($value!=$this->model->$field){
						$this->model->$field = $value;
						$this->model->writeToDB();
					}
				}

			}
		}
		function setDataFromPost($data,$form='default'){
			foreach($this->fetchArray() as $instance){
				$instance->triggerAction('pre_composition_post_data',$this->name,$this->model);
				$instance->setDataFromPost($data,$instance);
			}
		}
		function fetch($where=array(),$params=array()){
			$name = $this->name;
			$val = @$this->model->$name;

			//THIS WILL NOT WORK PROPERLY FOR ALL RELATONSHIP TYPES
			if($where) {
				$f = $this->rel['field'];
				$where[$this->rel['ref_field']] = $this->model->$f;
				return Model::loadModel($this->rel['model'])->getAll($where,$params);
			}
			if(is_array($val) && @$params['single']) $val = array_shift($val);
			if(is_null($val)) $val=array();
			return $val;
		}
		function __destroy(){
			foreach(get_object_vars($this) as $k=>$v){
				unset($this->$k);
			}
		}
		function copy_from($other){
			$name = $this->name;
			$old = $other->$name();
			if(is_object($old)){
				$other = $other->createCopy(false);
			} elseif(is_array($old)){
				foreach($old as $k=>$v){
					$old[$k] = $v->createCopy(false);
				}
			}
			$this->model->$name = $old;
		}
	}
class BelongsCompositionManager extends CompositionManager {
	function __destroy(){
		if($this->composed){
			$this->fetch()->__destroy();
		}
		
		parent::__destroy();
	}
	function composition(){
		try {
			$field = $this->rel['field'];
			$name = $this->name;
			$model = Model::loadModel($this->rel['model']);
			$instance = $model->getFirst(array($this->rel['ref_field']=>$this->model->$field),array('show_deleted'=>true));
		} catch(Exception $e){
			throw $e;
			trigger_error("Composition of $this->name in ".$this->model->getEnglishName()." failed");
		}
		if(!@$instance) {
			$instance = $this->createRelated();
		}
		$this->model->$name = $instance;
		$this->composed = true;
	}
	function createRelated(){
		$model = Model::loadModel($this->rel['model']);
		$ref = $this->rel['ref_field'];
		$params = array();
		if($ref !=$model->getIdField()){
			$params['ref'] = $this->model->getId();
		}
		$params = $this->model->applyFilters('relation_new_'.$this->name,$params);
		return $model->createNew($params);
	}

	function getInputs(){
		if(@$this->fields) return $this->fields;

		$instance = $this->fetch();
		$fields = $instance->getFields();
		$fields = $this->model->applyFilters('composition_fields',$fields,$this->name);
		foreach($fields as $k=>$v){
			$this->fields[$this->name.".".$k] = new FieldObjectDecorator($v,$instance);
		}

		$this->escape();
		$ref = $this->rel['ref_field'];
		$fields[$ref]->setParam('hidden',true);
		$field = $this->rel['field'];
		if($field != $this->model->getIDField()){
			$this->fields[$field] = new HiddenField($field);
		}
//		$this->fields[$this->name.".".$ref] = new FieldObjectDecorator(new HiddenField($ref),$instance);
		return $this->fields;
	}
	function escape(){
		return;
		foreach($this->getInputs() as $field){
			$field->pushParam('old-db',$field->param('db',true));
			$field->setParam('db',false);
			$field->pushParam('related',$this->name);
		}
	}
	function unescape(){
		return;
		foreach($this->getInputs() as $field){
			$field->popParam('related');
			$db = $field->popParam('old-db',true);
			$field->setParam('db',$db);
		}
	}

	function setDataFromPost($data,$form='default'){
		$instance = $this->fetch();
		$instance->setDataFromPost($data,$instance);
	}

	function getAssigns(){
		return array();
	}
	function store($new,$old,$assigns){
		$this->unescape();
		$instance=$this->fetch();
		$ref = $this->rel['ref_field'];
		if($ref !=$instance->getIDField())
			$instance->$ref = $this->model->getId();
		$instance->writeToDB();
		$local = $this->rel['field'];
		if($local!=$this->model->getIDField()){
			$id = $instance->getID();
			if($id!=$this->model->$local){
				$this->model->$local = $instance->GetID();
				$this->model->writeToDB();
			}
		}
		$this->escape();
	}

	function pre_delete(){
		$this->fetch()->delete();
	}

	function validate(){
		return $this->fetch()->validate();
	}
	function on_init(){}
	function fetchArray($where=array(),$params=array()){
		$inst = $this->fetch($where,$params);
		if($inst) return array($inst);
		else return array();
	}

}

class ManyCompositionManager extends CompositionManager {
	function composition(){
		try {
		$name = $this->name;
		$model = $this->model;
		$field = $this->rel['field'];
		$this->initialValues = $model->$name = Model::loadModel($this->rel['model'])->getAll(
			$model->applyFilters('relation_query_'.$name,array($this->rel['ref_field']=>$model->$field))
		);
		} catch(Exception $e){
			trigger_error("Composition of $this->name in ".$this->model->getEnglishName()." failed ({$e->getMessage()})");
		}
	}
	function createRelated($params = array()){
		$model = Model::loadModel($this->rel['model']);
		$ref = $this->rel['ref_field'];
		if($ref !=$model->getIdField()){
			$params[$ref] = $this->model->getId();
		}
		$params = $this->model->applyFilters('relation_new_'.$this->name,$params);
		return $model->createNew($params);
	}

	function validate(){
		$valid = true;
		foreach($this->fetch() as $instance){
			try {
				if(!$instance) continue;
				$valid = $valid && $instance->validate();
			} catch(Exception $e){
				$valid = false;
			}
		}
		if(@$e) throw $e;
		return $valid;
	}

	function store($new,$old,$assigns){
		parent::store($new,$old,$assigns);
		$new = $this->fetch();
		if(!is_array($new)) $new=array();
		foreach($new as $i){
			$found[$i->getId()]=true;
		}
		foreach($this->initialValues as $i){
			if(!@$found[$i->getId()]) {
				$i->delete();
			}
		}
		$this->initialValues = $new;
	}

	function on_init(){}

	function pre_delete(){
		foreach($this->fetch() as $instance) $instance->delete();
	}
	function getInputs(){
		$input = @$this->rel['input'];
		if($input){
			list($file,$class) = explode(":",$input);
			if($class) require_once($file);
			else $class=$file;
			return array($this->name=>new $class($this->name,array('rel'=>$this->rel)));
		} else {
			$class = @$this->rel['quick-ui'] ? 'AjaxManyInput' : 'ManyInput';
			require_once(dirname(__FILE__).'/../fields/class.'.$class.'.php');
			$name = $this->name;
			$remote = Model::loadModel($this->rel['model']);
			return array($this->name=>new $class($this->name,array('label'=>$remote->getEnglishName(true))));
		}
	}
	function getAssigns(){
		return array();
	}
	function fetchArray($where=array(),$params=array()){
		return $this->fetch($where,$params);
	}

}
?>
