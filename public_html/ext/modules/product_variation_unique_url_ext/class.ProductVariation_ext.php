<?
	Model::loadModel('Product');
	cms_module_require('products','class.ProductVariation.php');
	class ProductVariation_ext extends ProductVariation {
		function __construct($obj=null){
			parent::__construct($obj);
		}
		
		function getLabel()
		{
			/*try{
				if(!$this->variation_of())
					throw new Exception();
				$cat = $this->variation_of()->categories(array(),array('single'=>true));
				$cat = $cat->name;
			}
			catch(Exception $ex){}*/
			return $this->name.' - '.$this->describeVariation();
		}
		
		function getURL()
		{
			return $this->applyFilters('geturl',parent::getURL().'-'.$this->uid);
		}
		
		function dependantproducts($where=array(),$params=array()){
			if(!$dep = $this->getRelated('dependantproducts',$where,$params)) $dep = $this->variation_of()->dependantproducts($where,$params);
			return $dep;
		}
		

	}
