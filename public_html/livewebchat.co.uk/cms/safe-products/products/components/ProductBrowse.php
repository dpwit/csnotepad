<?
	cms_module_require('components','Table.php');
	class ProductBrowse extends PaginatedTable {
		function __construct($parentCategory=null,$params=array()){
			$template = "modules/products/browse";
			if($parentCategory){
				$parent = $parentCategory;
				$listFunc = Config::value('category_display_descendant_products') ? 'descendant_products_browsing' : 'products';
			} else {
				$parent = Model::g('Feature',cms_apply_filter('default_product_feature',1));
				$listFunc='availableProducts';
				//$template = "modules/products/featured";
			}

			if(!@$params['where']) $params['where'] = array();
			$params['where'] = cms_apply_filter('product_browsing_restrict',$params['where']);
			parent::__construct(array_merge(array(
				'listing'=>$template,
				'model'=>$parent,
				'listFunc'=>$listFunc,
				'alternate'=>Component::get('FileInclude',"modules/products/no-products",array('category'=>$parentCategory)),
				'query-debug'=>false,
				'category'=>$parentCategory,
			),$params));
		}

		function describeSearch(){
			return $_GET['q'];
		}

	}
?>
