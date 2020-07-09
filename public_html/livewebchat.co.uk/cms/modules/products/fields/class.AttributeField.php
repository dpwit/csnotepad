<?
	require_once(__MODELS_BASE__.'/fields/CompositeField.php');
	require_once(__MODELS_BASE__.'/fields/MMInput.php');
	class AttributeField extends CompositeField {
		function __construct($name,$params = array()){
			parent::__construct($name,array(),$params);
		}
		function setAttributes($attributes){
			$this->fields =array();
			foreach($attributes as $attribute){
				$options = $attribute->options();
				$ids = array_method_map('getId',$options);
				$labels = array_method_map('getLabel',$options);
				$options = @array_combine($ids,$labels);
				if(!$options) $options = array();
				$fn = $this->name."-".$attribute->getId();
				$this->fields[$fn]  = new SingleAttributeField($fn,array_merge($this->params,array('options'=>$options,'label'=>$attribute->getLabel())));
			}
		}
		function getAssigns(){
			return array();
		}
	}
	class SingleAttributeField extends MMSelect {
		function getOptions(){
			return $this->param('options',array());
		}
		function getDBName(){
			return preg_replace("/-\d+$/","",$this->name);
		}
	}
?>
