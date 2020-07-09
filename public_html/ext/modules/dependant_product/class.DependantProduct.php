<?php
Model::g('ProductModel');
class DependantProduct extends ProductModel
{
		function __construct($obj=null){
			parent::__construct($obj);
			$this->hasMM('dependedby',array( 
				'table'=>'master_product_mm_dependant_product',
				'model'=>'Product',
				'foreign_id'=>'master_product_uid',
				'local_id'=>'dependant_product_uid',
				'back'=>'dependantproducts',
			));
		}
}