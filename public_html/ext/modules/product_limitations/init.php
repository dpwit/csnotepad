<?php

	class product_limitations
	{
		function __construct()
		{
			cms_register_filter('config_defaults',$this);
			cms_listen_action('before_write_basket',$this);
			cms_listen_action('before_write_order_item',$this);
			//cms_listen_action('models_loaded',$this,false,100);
		}
		
//		function models_loaded(){
//			var _dump(Model::g('Order_Item')->getKeysForHooks('before_write'));
//		}
		
		function config_defaults($confArr)
		{
			$confArr['products']['max_one_of_each'] = true;
			return $confArr;
		}
		
		function before_write_basket($basket)
		{
			if(Config::value('max_one_of_each','products'))
				$basket->products = array_unique($basket->products);
		}
		function before_write_order_item($order_item)
		{
			if(Config::value('max_one_of_each','products')){
				$order_item->setQuantity(min($order_item->getQuantity(),1));
			}
		}
	}
	
	new product_limitations();