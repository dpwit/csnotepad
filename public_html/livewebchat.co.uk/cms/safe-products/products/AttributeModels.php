<?
	class Product_Attribute extends BozModel {
		function __construct($obj=null,$table=false){
			parent::__construct($obj,$table);
			$this->hasMany('options',array('model'=>'product_attribute_option','composition'=>true,'quick-ui'=>true));
			$this->hasMM('product_types',array('table'=>'product_types_mm_product_attributes'));
		}
	}

	class Product_Attribute_Option extends SortableModel {
		function __construct($obj=null,$table=false){
			parent::__construct($obj,$table);
			$this->hasOne('attribute',array('model'=>'Product_Attribute','field'=>'product_attribute_uid'));
			$this->hasMM('products',array('table'=>'products_mm_product_attribute_options'));
		}

		function getListingColumns(){
			return array("Attribute"=>$this->attribute()->name,"Option"=>$this->name);
		}
		function getDefaultOrder(){
			return array('product_attribute_uid','sorting');
		}
		function getSiblings($where=array(),$params=array()){
			$where['product_attribute_uid'] = $this->product_attribute_uid;
			return $this->getAll($where,$params);
		}
	}
?>
