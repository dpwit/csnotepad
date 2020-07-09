<?
	class ShippingHooks {
		function __construct(){
			cms_listen_action('items_modified',$this);
			cms_listen_action('models_loaded',$this);
			cms_listen_action('model_instantiated_order',$this);
			cms_listen_action('model_saved_order',$this);
			cms_register_filter('order_item_class',$this);
			cms_register_filter('config_defaults',$this);
			cms_register_filter('cms_menu',$this,false,10);
			cms_register_filter('cms_section_name',$this);
		}
		function cms_section_name($section,$model){
			if($model instanceof ShippingCost) return 'Shop Config';
			return $section;
}

		function model_saved_order($order,$old,$changes){
			if(@$changes['customer_country'])
				$this->items_modified($order,null);
		}

		function model_instantiated_order($order){
			$order->hasCustom('requiresShipping',array($this,'requiresShipping'));
			$order->hasCustom('getTotalWeight',array($this,'getTotalWeight'));
		}
		function requiresShipping($order){
			foreach($order->order_items() as $item){
				try {
					if($item->requiresShipping()) return true;
				} catch(BadRelationShipException $e){
				}
			}
			return false;
		}
		function getTotalWeight($order){
			$weight=0;
			foreach($order->order_items() as $item){
				try {
					if($item->requiresShipping()){
						$weight += $item->getTotalWeight();
					}
				} catch(BadRelationshipException $e){
					continue;
				}
			}
			return $weight;
		}

		function config_defaults($config){
			$config['orders']['shipping_by_weight'] = 1;
			$config['orders']['shipping_tare_price'] = 0;
			$config['orders']['default_shipping_cost'] = 1.99;
			return $config;
		}
		function cms_menu($menu){
			if(Config::value('shipping_by_weight','orders')){
				$menu['Shop Config']['Shipping Costs'] = "overview.php?pageType=ShippingCost";
				$menu['Shop Config']['Add Shipping'] = "newItem.php?pageType=ShippingCost";
			}
			return $menu;
		}

		function models_loaded(){
			Model::addModel('ShippingOrderItem',dirname(__FILE__).'/class.ShippingOrderItem.php');
			Model::addModel('ShippingCost',dirname(__FILE__).'/class.ShippingCost.php');
		}

		function shippingClass(){
			return get_class(Model::loadModel('ShippingOrderItem'));
		}
		function order_item_class($class,$model,$item){
			if(@$item->ref_table=='shipping'){
				return $this->shippingClass();
			}
			return $class;
		}

		function items_modified($order,$item){
			if($order->isComplete()) return;
			if($item instanceof Extra_Charge) return;
			$weight = 0 ;
			$requireShipping = $order->requiresShipping();
			$shipping = $order->order_items(array('ref_table'=>'shipping'));
			if($requireShipping){
				$weight = $order->getTotalWeight();
				foreach($shipping as $k=>$v){
					if($v->ref_table !='shipping') unset($shipping[$k]);
				}
				if($shipping) {
					$shipping = array_pop($shipping);
				}
				else {
					$shipping = Model::loadModel('ShippingOrderItem')->createNew(array(
						'order_uid'=>$order->getId()
					));
				}
				$shipping->setWeight($weight);
			} else {
				foreach($shipping as $shipping){
					$shipping->delete();
				}
			}
		}
	}
	new ShippingHooks();
?>
