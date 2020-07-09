<?
/**
* @package Model_System
*/

	require_once(dirname(__FILE__).'/ManagerInterface.php');
	class ManyManager extends DummyManager {
		function fetch($where=array(),$params=array()){	
			return $this->instance->getRelated($this->name,$where,$params);
		}
		function pre_delete(){
			if(@$this->params['cascade_on_delete']){
				$this->toDelete = $this->fetch(array(),array('for_fetch'=>1));
			}
		}
		function __destroy(){
			foreach(get_object_vars($this) as $k=>$v){
				unset($this->$k);
			}
		}

		function post_delete(){
			if(@$this->toDelete){
				while($el = $this->toDelete->fetch()){
			//		echo "Cascading $el\n";
					$el->delete();
				}
				unset($this->toDelete);
			}
		}
	}
