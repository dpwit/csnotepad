<?
	cms_module_require('components','Table.php');
	class CategoryListing extends PaginatedTable {
		function __construct($parent_cat,$params){
			$this->cat = $parent_cat;
			
			$params = array_merge(array('category'=>$parent_cat),$params);
			
			parent::__construct($params);
			$this->perPage = $params['perPage'] ? $params['perPage'] : $this->perPage;
		}
		function doQuery($where=array(),$params=array()){
			$where=cms_apply_filter('product_category_browsing_restrict',$where);
			$this->model = 'ProductCategory';
			$where['parent_uid'] = $this->cat ? $this->cat->getId() : 0;
			
			//Hacked, didnt know how to make visible work;
			if(isset($where['visible'])){
				$where['status'] = $where['visible'];
			}
			
			return parent::doQuery($where,$params);
		}
	}
?>
