<?
	class CompositeField extends Field {
		function __construct($name,$fields = array(),$params = array()){
			$this->fields = $fields;
			parent::__construct($name,$params);
		}
		function renderTo($obj){
			foreach($this->fields as $field){
				$field->renderTo($obj);
			}
		}
		function validate($obj){
			$valid = true;
			foreach($this->fields as $field){
				$valid = $valid && $field->validate($obj);
			}
			if(!$valid) throw new Exception("Password validation failed");
			return $valid;
		}
		function checkInvalid($obj){
			$errors = array();
			foreach($this->fields as $field){
				$errors = array_merge($errors,$field->checkInvalid($obj));
			}
			return $errors;
		}
		function transformPostData($post,$obj){
			foreach($this->fields as $field){
				$field->transformPostData($post,$obj);
			}
		}

		function getAssigns($obj){
			$assigns = array();
			foreach($this->fields as $field){
				$assigns = array_merge($assigns,$field->getAssigns($obj));
			}
			return $assigns;
		}
	}
