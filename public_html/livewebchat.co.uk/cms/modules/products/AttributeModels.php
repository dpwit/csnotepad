<?
	class Product_Attribute extends BozModel {
		function __construct($obj=null,$table=false){
			parent::__construct($obj,$table);
			$this->hasMany('options',array('model'=>'product_attribute_option','composition'=>true,'quick-ui'=>true));
			$this->hasMM('product_types',array('table'=>'product_types_mm_product_attributes'));
		}
		function filter_composition_form_view($view,$relationship){
			switch($relationship){
				case 'options':
					return 'compact-form';
			}
			return $view;
		}
	}

	class Product_Attribute_Option extends SortableModel {
		function __construct($obj=null,$table=false){
			parent::__construct($obj,$table);
			$this->doInternalSql();
			$this->hasOne('attribute',array('model'=>'Product_Attribute','field'=>'product_attribute_uid'));
			$this->hasMM('products',array('table'=>'products_mm_product_attribute_options'));
			$this->hasFile('image',array('file_type'=>'img',
				'extraSizes'=>array(
					'icon'=>array( 'width'=>50,'height'=>50, 'resizer'=>'ImageResizerCropSquare' ,),
				)
			));
		}

		function filter_fields_built($fields){
			$fields['image']->setParam('preview-size','icon');
			unset($fields['status']);
			unset($fields['slug']);
			return $fields;
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
