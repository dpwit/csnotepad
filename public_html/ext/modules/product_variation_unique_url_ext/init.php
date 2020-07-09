<?php
class product_variation_unique_url_ext
{
	function __construct(){
			//cms_register_filter('geturl_productvariation',$this);
			//cms_register_filter('geturl_ProductVariation',array($this,'geturl_productvariation'));
			cms_listen_action('components_loaded',$this);
			cms_listen_action('models_loaded',$this,false,100);
	}
	
	/*function geturl_productvariation($slug,$prod)
	{
		die('HERE'); 
		if(!$prod || !($prod instanceof ProductVariation)) return $slug;
		
		return $slug.'-'.$prod->uid;
	}*/

	function models_loaded(){
		Model::addModel('ProductVariation',dirname(__FILE__).'/class.ProductVariation_ext.php','ProductVariation_ext');
	}
	
	function components_loaded(){
		Component::mapClass('ProductVariationDetail',dirname(__FILE__).'/components/ProductVariationDetail.php');
	}
}
new product_variation_unique_url_ext;