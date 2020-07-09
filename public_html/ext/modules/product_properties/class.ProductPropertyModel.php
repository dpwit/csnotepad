<?php

class ProductPropertyModel extends BozModel
{

	function __construct($obj = null)
	{
		parent::__construct($obj,"product_property");
		
		$this->hasMM(
			'product_types',
			array(
				'table'=>'product_types_mm_product_properties',
				'composition'=>1,
				'model'=>'Product_Type',
				'foreign_id'=>'product_type_uid',
				'local_id'=>'product_property_uid'
			)
		);		
		
	}
	
	function getLabelField(){ return 'property_name'; }

}