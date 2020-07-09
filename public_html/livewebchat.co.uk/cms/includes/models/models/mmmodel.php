<?
/**
* @package Model_System
*/

	class MMModel extends Model {
		function setRelationship($name,$params=array()){
			$this->name = $name;
			$this->table = $params['table'];
			$this->order = @$params['sorting'] ? $params['sorting'] : $params['foreign_id'];
			$this->params = $params;
		}
		static function canCache(){
			return false;
		}
		function getDefaultOrder(){
			return $this->order;
		}

		function getRelatedId(){
			$field = $this->params['foreign_id'];
			return $this->$field;
		}

		function getIDField(){
			if($this->uid) return 'uid';
			return @$this->params['foreign_id'];
		}

		function remote($params=array()){
			$model = Model::loadModel($this->params['model']);
			$for = $this->params['foreign_id'];
			return $model->get($this->$for,$params);
		}
		function createNew($values=array()){
			$inst = parent::createNew($values);
			return $this->init($inst);
		}
		function create($class,$record,$table=false){
			$inst = parent::create($class,$record,$table);
			return $this->init($inst);
		}
		function init($inst){
			if($inst instanceof MMModel) $inst->setRelationship($this->name,$this->params);
			return $inst;
		}

		function do_delete(){
			$local = $this->params['local_id'];
			$localv = $this->$local;
			mysql_query("DELETE FROM ".$this->getTableName()." WHERE ".$this->getIDField()."='".$this->getID()."' AND `$local`='$localv'");
		}

		function exists(){
			if($this->uid) return is_numeric($this->uid);
			return false; // Bit of a hack to make saving work... possibly need to rework the id field stuff to support compound keys...
		}
		function getTableName($plural = false){
			return $this->table;
		}
	}
?>
