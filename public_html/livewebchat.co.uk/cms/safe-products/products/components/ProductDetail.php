<?
	class ProductDetail extends FileInclude {
		function __construct($product){
			parent::__construct("modules/products/product-detail.php",array('product'=>$product,'basket'=>Model::g('Basket',0)));
		}
	}
?>
