<?
	class CategoryRelatedCategory extends SortableModel {
		function __construct($obj=null){
			parent::__construct($obj,'related_categories');
			$this->doInternalSQL();
			$this->hasOne('category',array('model'=>'ProductCategory','field'=>'category_uid','back'=>'CategoryRelatedCategory'));
			$this->hasOne('related',array('model'=>'ProductCategory','field'=>'related_uid'));
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
			unset($fields['relation']);
			//$fields['relation'] = new Field('relation');
			return $fields;
		}
	}
?>
