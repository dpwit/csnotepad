<?
	class LinkCategoryModel extends SortableModel {
		function __construct($obj=null){
			parent::__construct($obj,'link_category');
			$this->hasMany('links');
		}
	}
?>
