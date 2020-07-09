<?
/**
* @package Boz_Orders
*/

	class OrderHooks {
		function __construct(){
			cms_register_filter('cms_menu',$this);
			cms_listen_action('models_loaded',array($this,'load_model'));
			cms_listen_action('components_loaded',$this);
			cms_register_filter('get_cron_jobs',array($this,'daily_report'));
			cms_register_filter('config_defaults',$this);
			cms_register_filter('get_test_suites',array($this,'test_suite'),dirname(__FILE__).'/class.OrderTestSuite.php',-5);
			cms_register_filter('get_payment_gateway',array($this,'get_payment_gateway'));
			cms_register_filter('get_payment_gateways',$this,false,1000);
			cms_listen_action('model_instantiated_feuser',$this);
			cms_listen_action('model_instantiated_user',$this);
			cms_register_filter('cms_actions_user',$this);
			cms_listen_action('checkout_created_order',$this);
			cms_register_filter('categorise_modules',$this);
			cms_register_filter('cms_section_name',$this);
		}
		function cms_section_name($section,$model){
			if($model instanceof OrderState) return 'Orders';
			return $section;
		}
		function model_instantiated_user($user){
			$user->hasCustom('notes',array($this,'notes_for_user'));
		}
		function notes_for_user($user,$where=array(),$params=array()){
			$where['ref_id']=$user->getId();
			return Model::loadModel('UserNote')->getAll($where,$params);
		}
		function cms_actions_user($actions,$user){
			$actions[Model::loadModel('UserNote')->urlFor('new',array('about_uid'=>$user->getId()))] = 'Add Note ('.count($user->notes()).')';
			return $actions;
		}
		function cms_menu($array){
			$array['Orders']['View Orders'] = "overview.php?pageType=orders";
			if(Config::value('have_subscriptions','orders')){
				$array['Orders']['View Subscriptions'] = "overview.php?pageType=subscriptions";
			}
			if(Model::loadModel('User')->getUser()->isUnrestricted()){
				$array['Orders']['Order States']="overview.php?pageType=order_state";
				$array['Orders']['Add Order State']="newItem.php?pageType=order_state";
			}
//			$array = array_merge(array("Orders" => 'orders'),$array);
			return $array;
		}
		function config_defaults($config){
			$config['site']['order_requires_login']=1;
			$config['site']['order_updates_customer']=1;
			$config['orders']['default_currency']='GBP';
			$config['orders']['use_vat']=1;
			$config['orders']['vat_rate']=17.5;
			$config['orders']['have_subscriptions']=0;
			$config['orders']['dummy_uses_forms']=1;
			$config['orders']['dummy_uses_cards']=1;
			$config['orders']['dummy_minimum_checkout']=10;
			$config['orders']['order_reply_email_address']="orders@".str_replace('www.',"",__SERVER_DOMAIN__);
			$GLOBALS['CONFIG'] = $config;
			$gateways = cms_apply_filter('get_payment_gateways',array());
			foreach($gateways as $gateway){
				foreach($gateway->getPaymentMethods(1000000) as $k=>$v){
					$config['orders'][$gateway->getEngineName()."/".$k."/completion_state"] = 3;
				}
			}
			return $config;
		}
		function load_model(){
			Model::addModel('GenericOrder',dirname(__FILE__).'/OrderModel.php','BaseOrder');
			Model::addModel('Order',dirname(__FILE__).'/OrderModel.php','BaseOrder');
			Model::addModel('Order_Item',dirname(__FILE__).'/OrderModel.php');
			Model::addModel('OneOffOrder',dirname(__FILE__).'/OrderModel.php');
			Model::addModel('SubscriptionOrder',dirname(__FILE__).'/SubscriptionModel.php');
			Model::addModel('SubscriptionRepeatOrder',dirname(__FILE__).'/SubscriptionModel.php');
			Model::addModel('Subscription',dirname(__FILE__).'/SubscriptionModel.php');
			Model::addModel('OrderState',dirname(__FILE__).'/OrderModel.php');
			Model::addModel('Order_State',dirname(__FILE__).'/OrderModel.php','OrderState');
			Model::addModel('OrderNote',dirname(__FILE__).'/NoteModels.php','OrderNote');
			Model::addModel('Note',dirname(__FILE__).'/NoteModels.php','Note');
			Model::addModel('UserNote',dirname(__FILE__).'/NoteModels.php','UserNote');
		}
		function components_loaded(){
			Component::mapClass('CheckoutProcess',dirname(__FILE__).'/components/Checkout.php','PaymentProcess');
			Component::mapClass('ViewCartProcess',dirname(__FILE__).'/components/Checkout.php');
			Component::mapClass('MyOrders',dirname(__FILE__).'/components/MyOrders.php','MyOrders');
		}
		function daily_report($jobs){
//			require_once(dirname(__FILE__).'/OrderCron.php');
			require_once(dirname(__FILE__).'/SubscriptionCron.php');
//			$cron->addJob(new OrderCron);
			$jobs[] = new SubscriptionCron;
			return $jobs;
		}
		function test_suite($suites){
			$suites[] = new OrderTestSuite();
			return $suites;
		}
		function get_payment_gateways($array){
			if(!$array){
				require_once(dirname(__FILE__).'/DummyGateway.php');
				$array[]= new DummyGateway();
			}
			return $array;
		}
		function get_payment_gateway($gateway=null){
			if($gateway) return $gateway;
			if($gateways = cms_apply_filter('get_payment_gateways',array())){
				if(count($gateways)==1) return array_shift($gateways);
				require_once(dirname(__FILE__).'/MultiGateway.php');
				return new MultiGateway($gateways);
			}
		}
		function model_instantiated_feuser($user){
			$user->hasCustom('orders',array($this,'orders_for_user'));
		}
		function orders_for_user($user,$where=array(),$params=array()){
			$where['user.id'] = $user->getId();
			return Model::loadModel('Order')->getAll($where,$params);
		}
		function checkout_created_order($order){
			if($user = Model::loadModel('User')->getLoggedInUser())
				$order->updateFromUser($user);
		}
		function categorise_modules($modules){
			$modules['Shop'] = array('Orders','Catalogue','Customer');
			return $modules;

		}
	}
	new OrderHooks();

	class VATHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this);
			cms_listen_action('model_instantiated_order',$this);
			cms_listen_action('model_saved_order',$this,false,10000);
			cms_listen_action('items_modified',$this,false,10000);
			cms_register_filter('order_item_class',$this);
			cms_listen_action('orderConfirmed',$this);
		}

		function orderConfirmed($order){
			$_SESSION['last_order'] = $order->getId();
//			$_SESSION['screen_order'] = false;
		}

		function model_saved_order($order,$old,$changes){
			if(@$changes['card_country'] || @$changes['customer_country'])
				$this->items_modified($order,null);
		}

		function model_instantiated_order($order){
			$order->hasCustom('requiresVAT',array($this,'requiresVAT'));
		}
		function requiresVAT($order){
			include(dirname(__FILE__).'/data/vat-countries.php');
			if(!Config::value('use_vat','orders')) return false;
			if($order->requiresShipping()) return in_array($order->customer_country,$vat_countries);
			else return in_array($order->card_country,$vat_countries);
		}

		function models_loaded(){
			Model::addModel('VATOrderItem',dirname(__FILE__).'/class.VATOrderItem.php');
		}

		function vatClass(){
			return get_class(Model::loadModel('VATOrderItem'));
		}
		function order_item_class($class,$model,$item){
			if(@$item->ref_table=='vat'){
				return $this->vatClass();
			}
			return $class;
		}

		function items_modified($order,$item){
			if(is_a($item,$this->vatClass())) return;

			$vatItems = $order->order_items(array('ref_table'=>'vat'));
			if($order->requiresVAT()){
				$total=0;
				foreach($order->order_items() as $item){
					if(is_a($item,$this->vatClass())) continue;
					$total+=$item->getTotalPrice(false);
				}
				foreach($vatItems as $k=>$v){
					if($v->ref_table !='vat') unset($vatItems[$k]);
				}
				if($vatItems) {
					$vatItem = array_pop($vatItems);
				}
				else {
					$vatItem = Model::loadModel('VATOrderItem')->createNew(array(
						'order_uid'=>$order->getId()
					));
				}
				$vatItem->setPrice($total);
				$vatItem->setQuantity(1);
				$vatItem->writeToDB();
			} else {
				foreach($vatItems as $vatItem){
					$vatItem->delete();
				}
			}
		}
	}
	new VATHooks();
?>
