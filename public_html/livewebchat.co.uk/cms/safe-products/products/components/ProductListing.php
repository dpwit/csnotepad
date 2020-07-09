<?
	cms_module_require('components','Table.php');
	class ProductListing extends PaginatedTable {
		function __construct($parent_cat){
			$this->cat = $parent_cat;
			parent::__construct(array('category'=>$parent_cat));
		}
		function doQuery($where=array(),$params=array()){
			$this->model = 'Product';
			$where=cms_apply_filter('product_browsing_restrict',$where);
			$where['categories.uid'] = $this->cat ? $this->cat->getId() : 0;
			return parent::doQuery($where,$params);
		}
	}
?>
