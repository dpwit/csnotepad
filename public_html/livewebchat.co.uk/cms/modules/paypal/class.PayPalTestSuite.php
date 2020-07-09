<?
/**
* @package Boz_Orders
*/

	class PayPalTestSuite extends BaseTestSuite {

		var $formTest = array(
			'user'=>'don_1268328720_per@don-benjamin.co.uk',
			'pass'=>'272470459',
		);
		function __construct(){
			//parent::__construct('PayPal Test', array('subscriptionTest'));
			parent::__construct('PayPal Test', array('installedTest','payTest','subscriptionTest','refundTest'));
		}

		function getGateway(){
			static $pp;
			if(!$pp){
				$pp = cms_apply_filter('get_payment_gateway',null);
			}
			return $pp;
		}


		function installedTest($test){
			$pp = $this->getGateway();
			$test->assert($pp instanceof PayPalGateway,"PayPal Is Not The Default Gateway '".get_class($pp));
			return true;
		}
		function payTest($test){
			$pp = $this->getGateway();
			$order = $this->createTestOrder();
			$response = $pp->process($order);
			$test->assertEqual($order->total_processed,$order->getTotal(),"Order Amount Differs From Processed - '$response[amount]' should be '{$order->getTotal()}'");
			$this->testOrder = $order;
			return true;
		}
		function subscriptionTest($test){
			$pp = $this->getGateway();
			$order = $this->createTestSubscriptionOrder();
			$response = $pp->createSubscription($order);
			$test->assert($order->isComplete(),"Subscription Request Failed (".$order->order_state()->name.")");
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
			$order->card_number='4572153027136164';
			$order->card_cvv='080';
			$order->card_expiry="03/15";

			$order->customer_email='don_1268328720_per@don-benjamin.co.uk';
			$order->customer_title='Mr';
			$order->customer_firstname='Testy';
			$order->customer_lastname='Tester';

			$order->card_name="$order->customer_title $order->customer_firstname $order->customer_lastname";

			$order->customer_address="123 Fake Street\nHannover";
			$order->customer_city='Brighton';
			$order->customer_country='GB';
			$order->customer_postcode='T3 5T';

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
