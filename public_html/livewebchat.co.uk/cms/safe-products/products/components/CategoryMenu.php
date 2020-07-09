<?
	class CategoryMenu extends FileInclude {
		function __construct(){
			parent::__construct("modules/products/category-menu",array(
				'where'=>cms_apply_filter('product_category_browsing_restrict',array()),
			));
		}
	}
?>
