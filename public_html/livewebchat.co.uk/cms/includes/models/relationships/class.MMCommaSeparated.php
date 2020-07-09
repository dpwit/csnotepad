<?
class MMCommaSeparated extends DummyManager {
	function fetch($where=array(),$params=array()){
		$f=$this->name;
		$values = $this->instance->$f;
		if(is_string($values)) $values = explode(",",$values);
		$m = $this->getRelatedModel();
		$where[$m->getIdField()." in"] = $values;
		if(!$values) return array();
		foreach($values as $id){
			$res[] = $m->get($id,$where,$params);
		}
		return $res;
	}
	function before_write(){
		$name = $this->name;
		$v = $this->instance->$name;
		if(is_array($v)) $v = join(",",$v);
		$this->instance->$name=$v;
	}

	function after_write(){
		$name = $this->name;
		$v = $this->instance->$name;
		if(is_string($v)) $v = explode(",",$v);
		$this->instance->$name=$v;
	}

	function on_init(){
		$this->after_write();
	}
}
?>
