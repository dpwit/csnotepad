<?
/**
* @package Boz_Orders
*/

	cms_module_require('orders','GatewayInterface.php');

	class DummyGateway implements SubscriptionInterface {
		var $user = 'don_1266260258_biz@don-benjamin.co.uk ';
		var $pass = '1266260273';
		var $sig = 'Aj0BNEq7jA3OHhATJCGJNcM0bfm3AHr8eCHr5MKlK2C-cSGWmRT1M6cd';
		var $use3DAuth = false;

		function getEngineName($order=false,$english=false){
			return $english ? "Test Payments" : 'dummy';
		}

		function getFeatures(){
			return array(
				"manualRenewal"=>0,
				"autoRenewal"=>1,
				"subscriptions"=>1,
				"process-card-details"=>Config::value('dummy_uses_cards','orders'),
				"process-via-form"=>Config::value('dummy_uses_forms','orders'),
				"confirm-after-form"=>0,
			);
		}
		function process($order){
			if($order->canTransition('Complete')){
//				$order->payment_method='Dummy';
				$order->payment_version='0.1';
				$order->payment_data.="\nDummy Processing";
				if($this->use3DAuth){
					$order->doTransition('3DAUTH');
				} else {
					$order->doTransition('Complete');
				}
				return true;
			}
			return false;
		}

		function process3dAuth($order){
			if($order->state()=='3DAUTH'){
//				$order->payment_method='Dummy';
				$order->payment_version='0.1';
				$order->payment_data.="\nDummy 3D Auth";
				$order->doTransition('Complete');
				return true;
			}
			return false;
		}

		function refund($order){
			if($order->canTransition('Refunded')){
//				$order->payment_method='Dummy';
				$order->payment_version='0.1';
				$order->payment_data.="\nDummy Refund";
				$order->doTransition('Refund');
				return true;
			}
			return false;
			throw new Exception(__FUNCTION__." Not Implemented in ".__CLASS__);
		}
		function createSubscription($order){
			if($order->canTransition('Complete')){
//				$order->payment_method='Dummy';
				$order->payment_version='0.1';
				$order->payment_data.="\nDummy Subscription";
				$order->doTransition('Complete');
				return true;
			}
			return false;
		}
		function reprocessSubscription($order,$subscription){
			$oldOrder = $subscription->order();
			if(!(($oldOrder->order_state()->name=='Complete') && ($oldOrder instanceof SubscriptionOrder))){
				throw new Exception("Can only reprocess completed subscriptions");
			}
			if($order->canTransition('Complete') && ($oldOrder->order_state()->name=='Complete') && ($oldOrder instanceof SubscriptionOrder)){
//				$order->payment_method='Dummy';
				$order->payment_version='0.1';
				$order->payment_data.="\nDummy Subscription";
				$order->doTransition('Complete');
				return true;
			}
			throw new Exception(__FUNCTION__." Not Implemented in ".__CLASS__);
		}
		function getSubscription($order){
			throw new Exception(__FUNCTION__." Not Implemented in ".__CLASS__);
		}
		function updateSubscription($order){
			throw new Exception(__FUNCTION__." Not Implemented in ".__CLASS__);
		}
		function cancelSubscription($order){
			throw new Exception(__FUNCTION__." Not Implemented in ".__CLASS__);
		}
		function hasFeature($key){
			$feat = $this->getFeatures();
			return @$feat[$key];
		}
		function getPaymentMethods($amount){
			$methods = array();
			if($amount>=$this->getMinimumCheckout()){
				if($this->hasFeature('process-card-details')) $methods['card']='Debit/Credit Card (Test)';
				if($this->hasFeature('process-via-form')) $methods['form']='HTML Forms (Test)';
			}
			return $methods;
		}
		function getMinimumCheckout(){
			return Config::value('dummy_minimum_checkout','orders');
		}

		function redirectForm($order,$returnUrl){
			list($uri,$qstring) =explode("?",$returnUrl);
			$returnUrl="$uri/".base64_encode($qstring);
			redirectTo($returnUrl);
		}
		function handleFormReturn($order){
			$order->doTransition('Complete');
		}
		function processForm($order){
		}
		function getSupportedCards(){
			$cards = array('Visa','Mastercard','Maestro','American Express');
			return array_combine($cards,$cards);
		}
	}
?>
