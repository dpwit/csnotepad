<?php
	require_once(__MODELS_BASE__.'/fields/CompositeField.php');
	require_once(__MODELS_BASE__.'/fields/MMInput.php');
	class ProductPropertyField extends CompositeField {
			function __construct($name,$params = array()){
			$params['db'] = false;
			parent::__construct($name,array(),$params);
		}
		function setProperties($properties)
		{
						if($this->properties==$properties) return;
						
						$this->properties = $properties;
						$this->fields =array();
						foreach($properties as $property){
							$property_name = $property->property_name;
							
							$fn = $this->name."-".$property->getId();
							$this->fields[$fn]  = new SinglePropertyField($fn,array_merge($this->params,array('label'=>$property->getLabel(),'property'=>$property)));
						}
		}
		function renderTo($obj){
				if($type = $obj->product_type()){
					$this->setProperties($type->product_properties());
				}
				parent::renderTo($obj);
		}

		function transformPostData($post,$obj){
			if($type = $obj->product_type()){
				$this->setProperties($type->product_properties());
			}
		
			$values = $test = array();
			foreach($this->fields as $field){
				$property = $field->param('property');
				$hn = $this->htmlName($obj,$this->name."-".$property->getId());
				//var _dump($hn);
				foreach($obj->product_property_values() as $v) $values[$v->product_property_uid] = $v;
				if(array_key_exists($hn,$post)){
					$propertyv = $values[$property->getId()];
					if(!$propertyv){
						$propertyv =Model::loadModel('product_property_value')->createNew(array('product_property_uid'=>$property->getId()));
					}
					$propertyv->property_value = $post[$hn];
					$test[$property->getId()] = $post[$hn];
					$values[$property->getId()]= $propertyv;
					$propertyv=null;
				}
			}
		$obj->product_property_values=$values;
		}	 
	}
	
	class SinglePropertyField extends Field {
		function getDBName(){
			return preg_replace("/-\d+$/","",$this->name);
		}
		function getValue($obj)
		{
			return $obj->product_property_values(array('product_property_uid'=>$this->params['property']->getId()),array('single'=>true))->property_value;
		}
	}