<?
	cms_module_require('components','Table.php');
	class CombinedListing extends PaginatedTable {
		function __construct($parent_cat){
			$this->cat = $parent_cat;
			$template = "modules/products/browse";
			if(@$this->cat) $template = $this->cat->template('browse');
			parent::__construct(array(
				'category'=>$parent_cat,
				'listing'=>$template,
				'alternate'=>Component::get('FileInclude',"modules/products/no-products",array('category'=>$parentCategory)),
			));
		}
		function doQuery($where=array(),$params=array()){
			$wherec=cms_apply_filter('product_category_browsing_restrict',$where);
			$wherec['parent_uid'] = $this->cat ? $this->cat->getId() : 0;
			$wherep=cms_apply_filter('product_browsing_restrict',$where);
			if(Config::value('category_display_descendant_products')){
				$key = 'categories.ancestors.uid';
			} else {
				$key = 'categories.uid';
			}
			$wherep[$key] = $this->cat ? $this->cat->getId() : 0;
			$this->model = 'ProductCategory';
			return new MultiFetcher(array(
				Model::g('ProductCategory')->getAll($wherec,$params),
				Model::g('Product')->getAll($wherep,$params),
			));
		}
	}
?>
