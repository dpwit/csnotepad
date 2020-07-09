<?
	class ProductDetail extends FileInclude {
		function __construct($product){
			parent::__construct(
				$product->template('detail'),
				array('product'=>$product,'basket'=>Model::g('Basket',0)
			));
		}
	}
?>
