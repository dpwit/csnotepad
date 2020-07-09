<?
/**
* @package Model_System
*/

class Decoratable {
	function __construct(){
		$this->setDecorated($this);
	}

	function setDecorated($decorated){
		$this->decorated = $decorated;
	}
	function hasMethod($method){
		return method_exists($this,$method);
	}
}
class Decorator extends Decoratable {
	function __construct($decoratee){
		$this->decoratee = $decoratee;
		parent::__construct();
	}
	function setDecorated($decorated){
		parent::setDecorated($decorated);
		if($this->decoratee instanceof Decoratable){
			$this->decoratee->setDecorated($decorated);
		}
	}
	function hasMethod($method){
		if(method_exists($this,$method)) return true;
		else if(is_a($this->decoratee,'Decoratable')){
			return $this->decoratee->hasMethod($method);
		} else {
			return method_exists($this->decoratee,$method);
		}
	}
	function __call($function , $args){
		return @call_user_func_array(array($this->decoratee,$function),$args);
	}
	function __toString(){
		return get_class($this)." - ".$this->decoratee;
	}
}
?>
