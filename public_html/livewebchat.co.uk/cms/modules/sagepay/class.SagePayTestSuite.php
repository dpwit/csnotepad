<?
/**
* @package Boz_Orders
*/

	class SagePayTestSuite extends BaseTestSuite {
		function __construct(){
			//parent::__construct('SagePay Test', array('subscriptionTest'));
			parent::__construct('SagePay Test', array('installedTest','payTest','subscriptionTest','refundTest'));
		}

		function getGateway(){
			static $pp;
			if(!$pp){
				$pps = cms_apply_filter('get_payment_gateways',null);
				foreach($pps as $pp){
					if($pp instanceof SagePayGateway) break;
				}
			}
			return $pp;
		}


		function installedTest($test){
			$pp = $this->getGateway();
			$test->assert($pp instanceof SagePayGateway,"SagePay Is Not The Default Gateway '".get_class($pp));
			return true;
		}
		function payTest($test){
			$pp = $this->getGateway();
			$order = $this->createTestOrder();
			$this->testOrder = $order;
			$response = $pp->process($order);
			$test->assertEqual($order->total_processed,$order->getTotal(),"Order Amount Differs From Processed - '$response[amount]' should be '{$order->getTotal()}'");
			return true;
		}
		function subscriptionTest($test){
			$pp = $this->getGateway();
			$order = $this->createTestSubscriptionOrder();
			$response = $pp->createSubscription($order);
			$test->assert($order->isComplete(),"Subscription Request Failed (".$order->order_state()->name.")");
			$subscription = $order->subscription();
			$test->assert($subscription,"Subscription request didn't create subscription");
			$success = $subscription->attemptRenewal();
			$repeats = $subscription->repeats();
			$test->assertEqual(count($repeats),1,'Should be %2$s repeats actually %1$s');
			$repeat = array_pop($repeats);
			$test->assert($repeat->isComplete(),'Repeat not successful '.$repeat->payment_status.' - '.$repeat->payment_message);
			$success = $subscription->attemptRenewal();
			$repeats = $subscription->repeats();
			$test->assertEqual(count($repeats),2,'Should be %2$s repeats actually %1$s');
			$test->assert($success,"Subscription Renewal Failed");
			return true;
		}

		function createTestOrder(){
			$order = Model::loadModel('OneOffOrder')->createNew();
			$order = $this->addCustomerDetails($order);
			$order->addItem("Test Item",0.01,1,'tests',1);
			$order->addItem("Test Item 2",0.01,2,'tests',2);
			return $order;
		}
		function createTestSubscriptionOrder(){
			$order = Model::loadModel('SubscriptionOrder')->createNew();
			$order = $this->addCustomerDetails($order);
			$order->addItem("Test Item",0.01,1,'tests',1);
			$order->addItem("Test Item 2",0.01,2,'tests',2);
			return $order;
		}
		function addCustomerDetails($order){
			$order->card_type='Visa';
			$order->card_number='4929000000006';
			$order->card_cvv='123';
			$order->card_expiry="03/15";

			$order->customer_email='test-orders@don-benjamin.co.uk';
			$order->customer_title='Mr';
			$order->customer_firstname='Testy';
			$order->customer_lastname='Tester';

			$order->card_name="$order->customer_title $order->customer_firstname $order->customer_lastname";

			$order->customer_address="88 Fake Street\nHannover";
			$order->customer_city='Brighton';
			$order->customer_country='GB';
			$order->customer_postcode='T4 12T';

			$order->customer_phone='01273 123456';

			$order->ip_address='87.194.161.4';
			return $order;
		}

		function refundTest($test){
			$pp = $this->getGateway();
			$response = $pp->refund($this->testOrder);
			$test->assert($response,"Refund is unsuccessful - ".$this->testOrder->payment_status);
			return true;
		}
	}
?>
