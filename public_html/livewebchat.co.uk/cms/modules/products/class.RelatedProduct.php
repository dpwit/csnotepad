<?
	class RelatedProductModel extends SortableModel {
		function __construct($obj=null){
			parent::__construct($obj,'related_product');
			$this->doInternalSQL();
			$this->hasOne('product',array('model'=>'Product'));
			$this->hasOne('related',array('model'=>'Product'));
		}

		function getLabelField(){
			return "relation";
		}
		function getLabel(){
			$rel = $this->related();
			return $rel->getLabel();
		}
		function filter_fields_built($fields){
			unset($fields['name']);
			unset($fields['status']);
			unset($fields['slug']);
			$fields['relation'] = new Field('relation');
			return $fields;
		}
	}
?>
