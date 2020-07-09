<?
	cms_module_require('components','Table.php');
	class CategoryListing extends PaginatedTable {
		function __construct($parent_cat){
			$this->cat = $parent_cat;
			parent::__construct(array('category'=>$parent_cat));
		}
		function doQuery($where=array(),$params=array()){
			$where=cms_apply_filter('product_category_browsing_restrict',$where);
			$this->model = 'ProductCategory';
			$where['parent_uid'] = $this->cat ? $this->cat->getId() : 0;
			return parent::doQuery($where,$params);
		}
	}
?>
