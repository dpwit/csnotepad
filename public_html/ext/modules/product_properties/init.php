<?php
class product_properties_ext
{
	function __construct()
	{
			cms_listen_action('models_loaded',$this,false,10);
			cms_register_filter('cms_menu',$this,false,10);
			
			cms_listen_action('model_instantiated_product_type',$this);
			cms_listen_action('model_instantiated_product',$this);
			
			cms_listen_action('getting_fields_product',$this);
			cms_register_filter('fields_built_product',$this,false,10);
			
			cms_register_filter('cms_edit_form_product',$this);	
	}
	
	function cms_edit_form_product($sections,$product){

		unset($sections['Stock'][2]); // Stock Quantity Suppression [All subscription services currently.]
	
		$arr = $sections['Other'];
		foreach($arr as $k=>$v)
		{
			if(preg_match('/^product_property_values-/',$v))
			{
				unset($sections['Other'][$k]);
				$sections['Properties'][] = $v;
			}
		}

		//var_dump($sections);

		return $sections;

		if(!@$sections['Other']) 
		return $sections;

		$sections['Basics'] = array_merge($sections['Basics'],$sections['Other']);
		unset($sections['Other']);

		return $sections;
		
	}

	function fields_built_product($fields,$product){
		$pv = $fields['product_property_values'];
		unset($fields['product_property_values']);
		$fields['product_property_values'] = $pv;
		return $fields;
	}

	function getting_fields_product($product)
	{
		if($t = $product->product_type())	
				$product->fields['product_property_values']->setProperties($t->product_properties());
	}
	
	function models_loaded()
	{
		Model::addModel('product_property',dirname(__FILE__).'/class.ProductPropertyModel.php','ProductPropertyModel');
		Model::addModel('ProductProperty',dirname(__FILE__).'/class.ProductPropertyModel.php','ProductPropertyModel');
		
		Model::addModel('product_property_value',dirname(__FILE__).'/class.ProductPropertyValueModel.php','ProductPropertyValueModel');
		Model::addModel('ProductPropertyValue',dirname(__FILE__).'/class.ProductPropertyValueModel.php','ProductPropertyValueModel');
	}
	
	function cms_menu($array)
	{	
		$array['Shop Config']['View Properties'] = "overview.php?model=product_property&section=Shop Config";
		$array['Shop Config']['New Property'] = "newItem.php?model=product_property&section=Shop Config";
		
		//$array['Shop Config']['View Property Values'] = "overview.php?model=product_property_value&section=Shop Config";
		//$array['Shop Config']['New Property Value'] = "newItem.php?model=product_property_value&section=Shop Config";
		return $array;
	}
	
	function model_instantiated_product_type($product_type)
	{
		$product_type->hasMM(
			'product_properties',
			array(
				'table'=>'product_types_mm_product_properties',
				'composition'=>1,
				'model'=>'Product_Property',
				'local_id'=>'product_type_uid',
				'foreign_id'=>'product_property_uid',
				'input'=>__MODELS_BASE__.'/fields/MMSortedSelector.php:MMSortedSelector',
				'order'=>'sorting',
			)
		);
	}
	
	function model_instantiated_product($product)
	{
		$product->hasMany('product_property_values',array(
			'composition'=>true,
			'input'=>dirname(__FILE__).'/fields/class.ProductPropertyField.php:ProductPropertyField',
		));
	}
	
}
new product_properties_ext;