<?
	class ProductSearchForm extends FileInclude {
		function __construct($file=false,$params=array()){
			if(!$file) $file='modules/products/search-form';
			parent::__construct($file,$params);
		}		
	}
?>
