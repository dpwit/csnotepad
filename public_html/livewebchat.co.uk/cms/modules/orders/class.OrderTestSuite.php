<?
/**
* @package Boz_Orders
*/

	class OrderTestSuite extends BaseTestSuite {
		function __construct(){
			parent::__construct('Order Test', array('createGateway','createTest','writeTest','processTest','cleanUp'));
		}

		function getGateway(){
			static $pp;
			if(!$pp){
				cms_module_require('orders','DummyGateway.php');
				$pp = new  DummyGateway();
			}
			return $pp;
		}


		function createGateway($test){
			$test->assert($this->getGateway(),"Could not create gateway");
			return true;
		}
		function createTest($test){
			$this->order = $order = $this->createTestOrder();
			$items = $order->order_items(array(),array('debug'=>1));
			$test->assertEqual(count($items),2,"Should be 2 items before write - actually ".count($items));
			$test->assertEqual($order->getTotal(),0.03,"Should be 0.03p total before write - actually ".$order->getTotal());
			return true;
		}
		function writeTest($test){
			$order = $this->order;
			$order->writeToDB();
			$items = $order->order_items();
			$test->assertEqual(count($items),2,"Should be 2 items after write - actually ".count($items));
			$test->assertEqual($order->getTotal(),0.03,"Should be 0.03p total after write - actually ".$order->getTotal());
			return true;
		}
		function processTest($test){
			$order = $this->order;
			$pp = $this->getGateway();
			$order->setGateway($pp);
			$order->process();
			$test->assert($order->isComplete(),"Order Failed");
			return true;
		}

		function cleanUp($test){
			$this->order->delete();
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
	}
?>
