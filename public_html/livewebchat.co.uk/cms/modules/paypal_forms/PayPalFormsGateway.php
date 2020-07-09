<?
/**
* @package Boz_Orders
*/

	cms_module_require('orders','GatewayInterface.php');
	require_once(dirname(__FILE__).'/../../includes/class.CURLRequest.php');
	class PayPalFormsGateway implements FormGatewayInterface {
		var $user = 'don_1266260258_biz@don-benjamin.co.uk ';
		var $pass = '1266260273';
		var $sig = 'Aj0BNEq7jA3OHhATJCGJNcM0bfm3AHr8eCHr5MKlK2C-cSGWmRT1M6cd';

		function __construct(){
			include(dirname(__FILE__).'/config.php');
			if($paypal_config){
				foreach($paypal_config as $k=>$v) $this->$k=$v;
			}
			$this->user = Config::value('account_email','paypal');
			$this->host = Config::value('live','paypal') ? 'paypal.com' : 'sandbox.paypal.com';
		}
		function getEngineName($order=null,$english=false){
			return $english ? "PayPal" : "paypal-forms";
		}

		function redirectForm($order,$returnUrl){
			if($order->isSubscription()) throw new Exception("PayPal Forms Doesn't handle subscriptions");
			$order->total_processed = $order->getTotal(true);
			$order->doTransition('In Process');
			include(dirname(__FILE__).'/views/paypal-redirect-form.php');
		}
		function handleFormReturn($order){
			switch($_POST['payment_status']){
			case 'Completed':
				$order->lockTablesWrite();
				if($order->canTransition('Pending')){
					$order->payment_data = $_POST;
					$order->doTransition('Pending');
				}
				$order->unlockTables();
				break;
			}
		}

		function process3dAuth($order){
			throw new Exception(__FUNCTION__." Not Implemented in ".__CLASS__);
		}

		function refund($order){
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

		function callback(){
			$ipn = Model::loadModel('IPN')->createNew();
			$ipn->post = $_POST;
			$ipn->get = $_GET;
			$verify = new CURLRequest("https://www.$this->host/cgi-bin/webscr");
			$verify->addPostData('cmd','_notify-validate');
			foreach($_POST as $k=>$v){
				$verify->addPostData($k,$v);
			}
			$ipn->validity = $ipn->valid_text = $verify->getResponseBody();
			$ipn->valid_url = $verify->sentUrl;
			$ipn->writeToDB();

			$order = $ipn->order();
			switch($ipn->post['payment_status']){
				case 'Completed':
					$order->payment_data['ipn'] = $ipn->post;
					$order->payment_data['ipns'][] = $ipn->getId();
					if($ipn->post['mc_gross']>=$order->total_processed){
						$order->doTransition('Complete');
					} else {
						$order->doTransition('Failed');
					}
					if($ipn->post['mc_gross']!=$order->total_processed){
						$order->adminMail('Mismatched Accounts in PayPal Transaction',
							"Order {$order->getId()} should have totalled {$order->total_processed} but PayPal Reported {$ipn->post['mc_gross']}");
					}
					break;
			}

		}

		function getPaymentMethods($amount){
			$methods = array();
			if($amount>=$this->getMinimumCheckout()){
				return array( 'form'=>'PayPal');
			}
			return $methods;
		}
		function getMinimumCheckout(){
			return Config::value('paypalforms_minimum_checkout','orders');
		}

		function getFeatures(){
			return array(
				"manualRenewal"=>0,
				"autoRenewal"=>0,
				"subscriptions"=>0,
				"process-card-details"=>0,
				"process-via-form"=>1,
				'no-billing-address'=>1,
			);
		}
		function hasFeature($key){
			$feat = $this->getFeatures();
			return @$feat[$key];
		}
	}
?>
