<?
	cms_require_module('products');
	cms_require_module('orders');
	class BasketHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this,false,20);
			cms_listen_action('components_loaded',$this);
			cms_listen_action('checkout_created_order',$this);
			cms_listen_action('checkout_beginning',$this);
			cms_listen_action('model_saved_order_item',$this);
			cms_listen_action('model_deleted_order_item',$this);
			cms_listen_action('orderConfirmed',$this);
			cms_register_filter('config_defaults',$this);
		}

		function config_defaults($config){
			$config['products']['basket_after_add'] = 0;
			$config['products']['checkout_after_add'] = 0;
			$config['products']['clear_basket_on_add'] = 0;
			return $config;
		}
		function models_loaded(){
			Model::addModel('Basket',dirname(__FILE__).'/class.Basket.php');
		}

		function components_loaded(){
			Component::mapClass('BasketSummary',dirname(__FILE__).'/components/class.BasketSummary.php');
		}
		function getBasket(){
			return Model::loadModel('Basket')->getFirst();
		}

		function orderConfirmed($order){
			$basket = $this->getBasket();
			$basket->emptyBasket();
		}

		function checkout_beginning($order){
			$this->internal = true;
			if(strtoupper($order->order_state()->name)!='NEW') throw new Exception("Order already processed {$order->order_state()->name}");
			foreach($order->order_items() as $i){
				$i->delete();
			}
			unset($order->order_items);
			$this->checkout_created_order($order);
			$order->writeToDB();
		}
		var $internal = false;
		function checkout_created_order($order){
			$basket = $this->getBasket();
			$this->internal = true;
			$basket->copyToOrder($order);
			$order->writeToDB();
			error_log("CREATED ORDER ".$order->getID()." (".count($order->order_items()).") items");
			$this->internal = false;
		}
		function model_saved_order_item($item){
			if($this->internal) return;
			if(!$item instanceof ProductOrderItem) return;
			$basket = $this->getBasket();
			if(!$basket) return;
			$product = $item->referenced();
			if($product && $product instanceof ProductModel)
				$basket->setQuantity($product->getId(),$item->getQuantity());
		}
		function model_deleted_order_item($item){
			if($this->internal) return;
			$basket = $this->getBasket();
			$product = $item->product();
			if($product)
				$basket->removeItem($product->getId(),$item->getQuantity());
		}
	}

	new BasketHooks;
?>
