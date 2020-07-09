<?
/**
* @package Model_System
*/

	require_once(dirname(__FILE__).'/CompositeField.php');

	class OldPasswordField extends Field {
		function renderTo($obj){
			if(!$obj->exists()) return;
			return parent::renderTo($obj);
		}
	}
	class MyPassword extends CompositeField {
		function __construct($name){
			parent::__construct($name,array(
				new Field($name,array('type'=>'password','label'=>'New Password','autocomplete'=>'off')),
				new Field($name."confirm",array('type'=>'password','label'=>'Confirm New Password','db'=>false,'autocomplete'=>'off')),
				new OldPasswordField($name."old",array('type'=>'password','autocomplete'=>'off','label'=>'Confirm Old Password','db'=>false)),
				//new Field($name."old",array('type'=>'password','autocomplete'=>'off','label'=>'Confirm Old Password','db'=>false)),
			));

			$this->fields[1]->addValidation(array($this,'checkMatching'));
			$this->fields[2]->addValidation(array($this,'checkCurrent'));
		}
		function addValidation($v){
			$this->fields[0]->addValidation($v);
		}

		function transformPostData($post,$obj){
			$hn = $this->htmlName($obj);
			if(!@$post[$hn]) return;
			else {
				$old = $this->getValue($obj);
				$name = $this->name;
				if($old)
					$obj->origObj->$name = $old;
				$obj->postedPassword = true;
				parent::transformPostData($post,$obj);
				$this->setValue($obj,md5($post[$hn]));
			}
		}
		function renderTo($obj){
			if(!$obj->exists()){
				$this->fields[0]->setParam('label','Choose Password');
				$this->fields[1]->setParam('label','Confirm Password');
			}
			$name = $this->name;
			$old = $obj->$name;
			foreach(array($name,$name."confirm",$name."old") as $field) unset($obj->$field);
			unset($obj->$name);
			parent::renderTo($obj);
			$obj->$name = $old;
		}

		function checkMatching($value,$label,$field,$obj){
			if(@$obj->postedPassword && ($this->getValue($obj)!=md5($this->getValue($obj,$this->name."confirm")))){
				return "New Passwords Do Not Match";
			}
			return false;
		}
		function checkCurrent($value,$label,$field,$obj){
			$name = $this->name;
			if($obj->exists() && @$obj->postedPassword && ($obj->origObj->$name != md5($this->getValue($obj,$this->name."old")))){
				return "Existing Password Is Incorrect";
			}
			return false;
		}

	}
?>
