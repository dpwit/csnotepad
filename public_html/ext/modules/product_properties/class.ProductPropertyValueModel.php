<?php

class ProductPropertyValueModel extends BozModel
{

	function __construct($obj = null)
	{
		parent::__construct($obj,"product_property_value");
		
		$this->hasOne('product');
		$this->hasOne('product_property');
	}
	
	function getLabelField(){ return 'property_value'; }

}