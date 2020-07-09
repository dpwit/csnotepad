<?
/**
* @package Boz_Orders
*/

	cms_module_require('orders','GatewayInterface.php');

	class MultiGateway {
		function __construct($gateways){
			$this->gateways = $gateways;
		}

		function __call($func,$args){
			$order = @$args[0];
			$gateway = $this->getGatewayForOrder($order);
			return call_user_func_array(array($gateway,$func),$args);
		}

		function hasFeature($key,$order=false){
			if($order && $order->payment_gateway && $gateway = $this->getGatewayForOrder($order)) return $gateway->hasFeature($key);
			$features = $this->getFeatures();
			return @$features[$key];
		}
		function getFeatures($order = false){
			if($order) return $this->__call('getFeatures',func_get_args());
			$features = array();
			foreach($this->gateways as $gateway){
				if(@$order->payment_gateway && ($order->payment_gateway!=$gateway->getEngineName())) continue;
				foreach($gateway->getFeatures() as $k=>$v){
					if(!@$features[$k]) $features[$k]=$v;
				}
			}
			return $features;
		}
		function getGatewayForOrder($order){
			if(@$order && $order instanceof BaseOrder && $order->payment_gateway){
				foreach($this->gateways as $gateway){
					if($order->payment_gateway == $gateway->getEngineName())
						return $gateway;
				}
			}
			return $this->gateways[0];
		}

		function getPaymentMethods($orderTotal){
			$methods = array();
			foreach($this->gateways as $g){
				foreach($g->getPaymentMethods($orderTotal) as $s=>$method){
					$methods[$g->getEngineName().".".$s] = $method;
				}
			}
			return $methods;
		}
		function getMinimumCheckout(){
			$minimum=null;
			foreach($this->gateways as $g){
				if(is_null($minimum)) $minimum = $g->getMinimumCheckout();
				else $minimum = min($minimum,$g->getMinimumCheckout());
			}
			return $minimum;
		}
	}
?>
