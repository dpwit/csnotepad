<?
/**
* @package Boz_Orders
*/

	cms_module_require('components','ScreenFlow.php');
	cms_module_require('components','Form.php');

	function validForProcessing($order){
		switch($order->order_state()->name){
		case 'New':
		case '3DAUTH':
		case 'In Process':
			return true;
		default:
			return false;
		}
	}

	class PaymentFormScreen extends FormScreen {
		function __construct($name,$process,$params=array()){
			parent::__construct($name,null,$params);
			$this->process = $process;
		}
		function getObject(){
			return $this->getOrder();
		}
		function getOrder(){
			return $this->process->getOrder();
		}
		function changeAddressLink($type){
			return $this->linkTo(array('next-screen'=>$this->getOrder()->payment_method."/address",'change_address'=>$type));
		}
		function isActive(){
			return parent::isActive() && validForProcessing($this->getOrder());
		}
	}
	class PaymentScreen extends Screen {
		function __construct($name,$process,$params=array()){
			parent::__construct($name);
			$this->process = $process;
		}
		function getOrder(){
			return $this->process->getOrder();
		}
		function changeAddressLink($type){
			return $this->linkTo(array('next-screen'=>$this->getOrder()->payment_method."/address",'change_address'=>$type));
		}
	}
	class CustomerDetailsScreen extends PaymentFormScreen {
		function __construct($process){
			parent::__construct('customer-details',$process,array('submitLabel'=>'Next'));
//			$this->params['mainSection'] = 'Stage 2 - Personal Details'; 	
		}
		function getOrder(){
			$order = parent::getOrder();
			$user = Model::loadModel('User')->getLoggedInUser();
			$this->customer_title='Mr';
			if($user && !@$this->customer_firstname){
				$this->customer_firstname=$user->realName;
			}
			return $order;
		}
		function doHTML($context,$params=array()){
			return parent::doHTML($context,$params);
		}
		function getFields(){
			include(dirname(__FILE__).'/countries.php');
			 $unkeyed_fields = array(
				new TextField('customer_title',array('label'=>'Title','required'=>true,'notes'=>'e.g. Mr, Mrs, Miss, Ms.')),
				new TextField('customer_firstname',array('label'=>'First name','required'=>true)),
				new TextField('customer_lastname',array('label'=>'Last name','required'=>true)),
				new TextField('customer_email',array('label'=>'Email','required'=>true)),
				new TextArea('customer_address',array('label'=>'Address','required'=>true)),
				new TextField('customer_city',array('label'=>'City','required'=>true)),
				new TextField('customer_state',array('label'=>'County / State')),
				new TextField('customer_postcode',array('label'=>'Post Code','required'=>true)),
				new TextField('customer_phone',array('label'=>'Phone Number','required'=>true,'notes'=>'Please include your country and area code, e.g. +44 1234 123456')),
				new DropDownField('customer_country',array('label'=>'Country','required'=>true,'options'=>$countries)),
			);
		
			$fields = array();
			foreach($unkeyed_fields as $field){
				$fields[$field->getName()] = $field;
			}
			$gateway = $this->getOrder()->getPaymentGateway();
			if(!$gateway->hasFeature('require-state')) unset($fields['customer_state']);
			else $fields['customer_state']->addValidation(array($this,'requireUsState'));
			$fields['customer_phone']->addValidation(new RegExValidation("/([0-9].*){6}/","Please enter a valid phone number"));
			$fields['customer_email']->addValidation(new EmailValidation()); 
			$fields = $this->getOrder()->applyFilters('checkout_fields',$fields);
			//$fields['customer_postcode']->addValidation(new PostCodeValidation());

			 return $fields;
		}
		function requireUSState($value,$label,$field,$model){
			$name = $field->getName();
			$country = str_replace("state","country",$name);
			if(strtolower($model->$country)=='us' && !$value){
				return "$label is required";
			}
		}
		function validate(){
			return parent::validate();
		}
		function canSkip(){
			$order = $this->getOrder();
			return $order && $order->validateUserDetails();
		}
		function process(){
			if(parent::process()){
				$order = $this->getOrder();
				foreach($this->getFields() as $field){
					$field->transformPostData($_POST,$order);
					$name = $field->getName();
					$card = str_replace('customer_','card_',$name);
					if($card!=$name && !$order->$card) $order->$card=$order->$name;

				}
				if(!$order->validateUserDetails()){
					$this->processed = false;
					return false;
				}
				$order->writeToDB();
				if(Config::value('order_updates_customer','site') && ($user = Model::loadModel('User')->getLoggedInUser())){
					$order->updateToUser($user);
				}
				return true;
			}
		}
	}
	class CardDetailsScreen extends PaymentFormScreen {
		function __construct($process){
			parent::__construct("card-details",$process,array('submitLabel'=>'Next'));
			//$this->params['mainSection'] = 'Stage 3 - Payment Details'; 	
		}
		function getFields(){
			static $fields;
			if($fields) return $fields;
			require_once(dirname(__FILE__).'/../fields/CardDate.php');
		
			$order = $this->getOrder();
			$cards = $order->getPaymentGateway()->getSupportedCards($order);
			$cards = array_combine($cards,$cards);
			$fields = array(
				new DropDownField('card_type',array('label'=>'Card Type','required'=>true,'options'=>$cards)),
				new TextField('card_name',array('label'=>'Cardholder\'s name','required'=>true)),
				new TextField('card_number',array('label'=>'Card Number','required'=>true)),
				new CardDate('card_from',array('label'=>'Issue Date','years'=>array(date('Y')-20,date('Y')+0))),
				new CardDate('card_expiry',array('label'=>'Expiry Date','years'=>array(date('Y'),date('Y')+20),'required'=>true)),
				new TextField('issue_number',array('label'=>'Issue Number')),
//				new TextField('card_expiry_month',array('label'=>'Expiry Month','required'=>true)),
//				new TextField('card_expiry_year',array('label'=>'Expiry Year','required'=>true)),
//				new TextField('card_valid_month',array('label'=>'From Month')),
//				new TextField('card_valid_year',array('label'=>'From Year')),
				new TextField('card_cvv',array('size'=>'4','label'=>'*CVV Code','notes'=>'* The last 3 digits of the number on the signature strip of the card','css_class'=>'CVVField')),
			);
			return $fields;
		}
		//This should really be process...
		function process(){
			if(parent::process()){
				$values=array();
				$this->writeTo($this->getForm());
				foreach($this->getFields() as $field){
					$values[$field->name] = $field->getvalue($this->form);
				}
//				$values['card_expiry'] = "$values[card_expiry_month]/$values[card_expiry_year]";
//				$values['card_valid'] = "$values[card_valid_month]/$values[card_valid_year]";
				if(@$values['card_valid'] == '/') unset($values['card_valid']);
				$order = $this->getOrder();
				$order->storeEncrypted($values);
				if(!$order->validateCardDetails()){
					$this->processed = false;
					return false;
				}
				try {
					$this->processPayment();
					return true;
				} catch(Exception $e){
					$order->errors[] = $e->getMessage();
					return false;
				}
			}
		}
		function canSkip(){
			return $this->getOrder()->order_state()->name!='New';
		}
		function processPayment(){
			$order = $this->getOrder();
			if($order->process()){
				cms_trigger_action('checkout_processed_order',$order);
			} else {
				cms_trigger_action('checkout_attempted_order',$order);
			}
		}
	}

	class DoPayment extends SubFlow{
		function __construct($name,$process,$type){
			parent::__construct($name);
			$this->process=$process;
			$this->type=$type;
		}

		function getOrder(){
			return $this->process->getOrder();
		}
		function isActive(){
			return (@$this->getOrder()->payment_method==$this->type) && parent::isActive();
		}
		function canSkip(){
			$ret = (@$this->getOrder()->payment_method!=$this->type) || parent::canSkip();
			return $ret;
		}
		function validate(){
			return false;
		}

		function process(){
			if(parent::process()){
				return $_SESSION['paymentTaken'] = true;
			}
		}
	}
	class CreditCardProcess extends DoPayment {
		function __construct($process){
			parent::__construct('card',$process,'card');
			$this->screenFlow->addScreen(new CustomerDetailsScreen($process));
			$this->screenFlow->addScreen(new AddressDetailsScreen($process));
		//	$this->screenFlow->addScreen(new ConfirmOrder($process));
			$this->screenFlow->addScreen(new CardDetailsScreen($process));
			$this->screenFlow->addScreen(new Auth3D('auth-3d',$process));
			$this->screenFlow->addScreen(new OrderFailed('failed',$process));
		}
	}
	class AddressDetailsScreen extends PaymentFormScreen {
		function __construct($process,$params=array()){
			$params['write'] = true;
			parent::__construct('address',$process,$params);
		}
		function isActive(){
			return @$_REQUEST['change_address'];
		}
		function canSkip(){
			$order = $this->getOrder();
			return $order && $order->validateUserDetails();
		}
		function getFields(){
			include(dirname(__FILE__).'/countries.php');
			$type = @$_REQUEST['change_address'];
			$unkeyed_fields = array(
				new TextField($type.'_title',array('label'=>'Title','required'=>true,'notes'=>'e.g. Mr, Mrs, Miss, Ms.')),
				new TextField($type.'_firstname',array('label'=>'First name','required'=>true)),
				new TextField($type.'_lastname',array('label'=>'Last name','required'=>true)),
				new TextArea($type.'_address',array('label'=>'Address','required'=>true)),
				new TextField($type.'_city',array('label'=>'City','required'=>true)),
				new TextField($type.'_postcode',array('label'=>'Post Code','required'=>true)),
				'state'=>new TextField($type.'_state',array('label'=>'County / State','required'=>false)),
				new DropDownField($type.'_country',array('label'=>'Country','required'=>true,'options'=>$countries)),
			);
			$fields = array();
			foreach($unkeyed_fields as $field){
				$fields[$field->getName()] = $field;
			}
			
			$gateway = $this->getOrder()->getPaymentGateway();
			if(!$gateway->hasFeature('require-state')) unset($fields['state']);
			else $fields[$type.'_state']->addValidation(array($this,'requireUsState'));
			 //$fields[$type.'_postcode']->addValidation(new PostCodeValidation());

			 $fields = cms_apply_filter('checkout_field_addressdetailsscreen',$fields,$type);
				
			 return $fields;
		}

		function requireUSState($value,$label,$field,$model){
			$name = $field->getName();
			$country = str_replace("state","country",$name);
			if(strtolower($model->$country=='us') && !$value){
				return "$label is required";
			}
		}
		function showForm($context,$params){
			$params['action'] = $_SERVER['HTTP_REFERER'];
			//if(extra_checkout_fields::isCMSLoggedIn()){
				list($url,$qstring) = explode("?",$_SERVER['REQUEST_URI']);
				$params['action'] = $url.$this->parent->urlFor($this->parent->getKey().'/card-details');
			//}
			$params['hidden'] .= @"<input type='hidden' name='change_address' value='$_REQUEST[change_address]'/>";
			parent::showForm($context,$params);
		}
	}

	class ExternalPaymentProcess extends DoPayment {
		function __construct($process){
			parent::__construct('form',$process,'form');
			if(Config::value(''));
			$this->screenFlow->addScreen(new CustomerDetailsScreen($process));
			$this->screenFlow->addScreen(new AddressDetailsScreen($process));
			$this->screenFlow->addScreen(new ConfirmOrder('confirm-payment',$process));
			$this->screenFlow->addScreen(new PaymentFormRedirect('form-redirect',$process));
			$this->screenFlow->addScreen(new PaymentFormReturn('form-return',$process));
			$gw = $process->getOrder()->getGateway();
			if($gw->hasFeature('confirm-after-form')){
				$this->screenFlow->addScreen(new ConfirmOrder($process));
			}
//			$this->screenFlow->addScreen(new OrderFailed($process));
		}
	}

	class MinimumOrderScreen extends PaymentScreen {
		function __construct($process){
			parent::__construct('minimum',$process);
		}
		function isActive(){
			return parent::isActive() && !$this->getOrder()->meetsMinimumCheckout();
		}
		function validate(){
			return parent::validate() && $this->getOrder()->meetsMinimumCheckout();
		}
		function doHTML($context){
			$this->view($context,"modules/checkout/order_below_minimum",array('order'=>$this->getOrder()));
		}
	}

	class OrderDisplay extends PaymentScreen {
		function doHTML($context,$view='basket_display',$params = array()){
			$order = $this->getOrder();
			$order->writeToDB();
			$errors = $order->getAvailabilityErrors();
			$this->view($context,"modules/checkout/$view",array_merge($params,array('err'=>$errors,'order'=>$this->process->getOrder(),'screen'=>$this)));
			return;
		}
		function validate(){
			$order = $this->getOrder();
			return !$order->getAvailabilityErrors();
		}
	}
	class BasketEdit extends OrderDisplay {
		function doHTML($context){
			$order=$this->getOrder();
			$this->getOrder()->writeToDB();
			$availabilityErrors = $order->getAvailabilityErrors();
			$order->correctAvailabilityErrors();
			if(!$order->meetsMinimumCheckout()){
				$availabilityErrors .= "\nMinimum order is ".$order->getMinimumCheckout();
			}
			parent::doHTML($context,'basket_edit',array('errors'=>$availabilityErrors));
		}
		function validate(){
			$order=$this->getOrder();
			return $order->isComplete() || $order->canCheckout();
		}
		function process(){
			$order = $this->getOrder();
			$order->writeToDB();
			$updated=false;
			if(@$_POST['qty']){
				foreach($order->order_items_no_extras() as $item){
					if(!array_key_exists($item->getId(),$_POST['qty'])){
						$updated=true;
						continue;
					}
					$qty = @$_POST['qty'][$item->getId()];
					if($qty!=$item->getQuantity()) {
						if($qty>0){
							$item->setQuantity($qty);
							$item->writeToDB();
							cms_trigger_action('checkout_item_updated',$item);
							$updated=true;
						} else {
							cms_trigger_action('checkout_item_deleted',$item);
							$item->delete();
							$updated=true;
						}
					}
				}
			}
			if(!$this->validate()) return false;

			if(@$_POST['confirm'] && !$order->getAvailabilityErrors()){
				redirectTo('/shop/checkout.html');
				die();
			}
			if(@$_POST['back'] && !$order->getAvailabilityErrors()){
				redirectTo($_SESSION['referer']);
				die();
			}
			return false;
		}
	}
	class BasketEditFromCheckout extends BasketEdit { 
		function isActive(){
			$key = $this->getKey();
			$selected = (@$_REQUEST['next-screen'] == $this->getKey()) || (@$_REQUEST['last-screen']==$this->getKey());
			$selected = $selected || !$this->getOrder()->canCheckout();
			return parent::isActive() && $selected;
		}
	}
	class BasketConfirm extends OrderDisplay {
		function doHTML($context){
			$order = $this->getOrder();
			$errors = $order->getAvailabilityErrors();
			if($errors){
				$order->correctAvailabilityErrors();
			}
			if(!$order->meetsMinimumCheckout()){
				$errors .= "\nMinimum order is ".$order->getMinimumCheckout();
			}
			parent::doHTML($context,'basket_confirm',array('errors'=>$errors));
		}
		function isActive(){
			return parent::isActive();
		}
		function validate(){
			return parent::validate() && (@$_POST['method'] || $this->getOrder()->payment_method);
		}
		function process(){
			parent::process();
			$order = $this->getOrder();
			if(@$_POST['method']) $order->setPaymentMethod($_POST['method']);
			$order->writeToDB();
			return $order->payment_method && $order->canCheckout();
		}
	}
	class ConfirmOrder extends OrderDisplay {
		function doHTML($context){
			parent::doHTML($context,'order_confirm');
		}

		function isActive(){
			switch($this->getOrder()->order_state()->name){
			case 'New':
				return parent::isActive();
			default:
				return false;
			}
		}
		function canSkip(){
			return true;
		}
		function getHiddenForm(){
			return parent::getHiddenForm().$this->getOrder()->getHiddenFields();
		}
	}
	class ConfirmFormOrder extends ConfirmOrder {
	}
	class Auth3D extends PaymentScreen {
		function doHTML($context){
			$https_url = defined('__HTTPS_BASE_URL__')?__HTTPS_BASE_URL__:("https://".__SERVER_DOMAIN__);
			$http_url = defined('__HTTP_BASE_URL__')?__HTTP_BASE_URL__:("http://".__SERVER_DOMAIN__);
			$url = Config::value('can_ssl','site') ? $https_url : $http_url;
			list($old_uri,$query) = explode('?',$_SERVER['REQUEST_URI']);
			$returnUrl = $url.$old_uri."?return=true&".$this->getHiddenLink();
			//$returnUrl = $url.$_SERVER['REQUEST_URI'].($_SERVER['QUERY_STRING']?'&':'?')."return=true&".$this->getHiddenLink();
			$this->view($context,'modules/checkout/3dauth',array(
				'order'=>$this->getOrder(),
				'return_url'=> $returnUrl,
				'auth3d_iframe'=>$url.'/checkout/3dauth-iframe',
			));
		}
		function isActive(){
			if(@$_GET['handled']) return false;
			switch($this->getOrder()->order_state()->name){
			case '3DAUTH':
				return true;
			default:
				return false;
			}
		}
		function canSkip(){
			return ($this->getOrder()->order_state()->name!='3DAUTH');
		}
		function process(){
			if(parent::process()){
				if(@$_GET['screen_order']){
					$order = Model::g('Order',$_GET['screen_order']);
					if(!$order->handle3DAuthReturn()) return false;
				}
				$this->redirectTop();
				return true;
			}
		}
	}
	class OrderRegistrationScreen extends PaymentFormScreen {
		function __construct($process){
			parent::__construct('registration',$process,array('view'=>$process->findTemplate('modules/checkout/login_or_register'),'write'=>true));
		}
		function isActive(){
			$user = Model::loadModel('User')->getLoggedInUser();
			return Config::value('order_requires_login','site') && (!$this->processed) && !($user && !@$_POST['pw']);
		}
		function getFields(){
			$user = $this->getObject();
			return array(
				$user->getField('realName'),
				$user->getField('email'),
				$user->getField('userid'),
				$user->getField('password'),
			);
		}
		function getObject(){
			if(!@$this->user){
				$this->user = Model::loadModel('User')->createNew();
				$this->user->status=1;
			}
			return $this->user;
		}
		function process(){
			$user = Model::loadModel('User')->getLoggedInUser();
			$ret = $user;
			if(!$ret && !@$_POST['login']){
				$ret = parent::process();
			}
			if($ret){
				if(!$user){
					$user = $this->getObject();
					if($user->exists()) $user->forceLogin();
				}
				$this->initOrder();
			}
			return $ret;
		}
		function initOrder(){
			$this->processed=true;
			$order = $this->getOrder();
			$user = Model::loadModel('User')->getLoggedInUser();
			$order->updateFromUser($user);
			$order->writeToDB();
		}

		function validate(){
			$user = Model::loadModel('User')->getLoggedInUser();
			if($user) return true;
			return parent::validate();
		}
	}
	class PaymentFormRedirect extends PaymentScreen {
		function doHTML($context){
			if(!$this->processed){
				$order = $this->getOrder();
				$gateway = $order->getGateway();
				//TODO: Account for HTTPS
				$https_url = defined('__HTTPS_BASE_URL__')?__HTTPS_BASE_URL__:("https://".__SERVER_DOMAIN__);
				$http_url = defined('__HTTP_BASE_URL__')?__HTTP_BASE_URL__:("http://".__SERVER_DOMAIN__);
				$url = Config::value('can_ssl','site') ? $https_url : $http_url;
				@list($uri,$query) = explode("?",$_SERVER['REQUEST_URI'],2);
				$gateway->redirectForm($order,$url.$uri."?return=true&go=1&".$this->getHiddenLink()); // Should we append $query here?
				$this->view($context,'modules/checkout/checkout-redirect',array('order'=>$order,'gateway'=>$gateway));
			}
			return true;
		}
		function process(){
			if(@$_GET['return']){
				$order = $this->getOrder();
			       	if($order->canTransition('Complete')){
					$gateway = $order->getGateway();
					$gateway->handleFormReturn($order);
				}
				$this->processed=true;
			}
			return true;
		}
		function isActive(){
			$order = $this->getOrder();	
			return $order && validForProcessing($order);
		}
	}
	class PaymentFormReturn extends PaymentScreen {
		function isActive(){ return false; }
	}
	class OrderFailed extends PaymentScreen {
		function doHTML($context){
			$this->view($context,'modules/checkout/payment-failed',array('order'=>$this->getOrder()));
		}
		function isActive(){
			switch($this->getOrder()->order_state()->name){
			case 'Complete':
				return false;
			default:
				return true;
			}
		}
	}
	class FinalOrderDisplay extends OrderDisplay {
		function __construct($name,$process){
			parent::__construct($name,$process);
			$this->isFinal = true;
		}
		function isActive(){
			return $this->getOrder()->isComplete();
		}
		function doHTML($context){
			$this->view($context,'modules/checkout/order_complete',array('order'=>$this->getOrder()));
		}
		function validate(){
			return false;
		}
		function getOrder(){
			if($_SESSION['last_order']) return Model::g('Order',$_SESSION['last_order']);
			else return parent::getOrder();
		}
	}
	class PendingOrderDisplay extends OrderDisplay {
		function __construct($process){
			parent::__construct('pending',$process);
			$this->isFinal = true;
		}
		function isActive(){
			$state = $this->getOrder()->order_state();
			return $state->end_state && ($state->name!='Complete');
		}
		function doHTML($context){
			$this->view($context,'modules/checkout/order_pending',array('order'=>$this->process->getOrder()));
		}
		function validate(){
			return false;
		}
	}

	class PaymentScreenFlow extends ScreenFlow {
		function __construct(){
			parent::__construct();
			$referer=@$_SERVER['HTTP_REFERER'];
			if(!preg_match("_/shop/(checkout|view-cart)_",$referer)){
				$_SESSION['referer'] = $referer;
			}
		}
		function storeSessionInfo(){
			$_SESSION['screen_order'] = $this->getOrder()->getId();
		}
		function getOrder(){
			$index = @$_REQUEST['screen_order'];
			$reUsingFromSession=false;
			if(!$index) {
				$index = $_REQUEST['screen_order'] = @$_SESSION['screen_order'];
				$reUsingFromSession=true;
			}
			if(!@$this->orders[$index]) {
				$order = null;
				if($index){
					$order = Model::loadModel('Order')->get($index);
				} 
				if(!$order){
					$order = Model::loadModel('OneOffOrder')->createNew();
					$order->writeToDB();
					cms_trigger_action('checkout_created_order',$order);
					$order->writeToDB();
					$_REQUEST['screen_order'] = $index = $order->getID();
					$this->storeSessionInfo();
					//$order->payment_method='card';
				}
				if($reUsingFromSession){
//					cms_trigger_action('checkout_reinitialise_order',$order);
//					$order->writeToDB();
				}
				$this->orders[$index] = $order;
			}
			return $this->orders[$index];
		}
		function initialiseScreenflow(){
			$order = $this->getOrder();
			if($order->order_state()->name!='New') {
				unset($_SESSION['screen_order']);
				unset($_REQUEST['screen_order']);
				$order = $this->getorder();
			}
			cms_trigger_action('checkout_beginning',$this->getOrder());
		}

		function getHidden(){
			$o = $this->getOrder();
			return array_merge(parent::getHidden(),array('screen_order'=>$o?$o->getId():false));
		}
	}
	class ViewCartProcess extends PaymentScreenFlow {
		function __construct(){
			parent::__construct();
			$this->addScreen(new BasketEdit('edit',$this));
		}
	}
	class PaymentProcess extends PaymentScreenFlow {
		function __construct($trailing){
			parent::__construct();
			if($trailing){
				$vars = explode("&",base64_decode(array_shift($trailing)));
				foreach($vars as $v){
					list($k,$v) = explode("=",$v);
					$_GET[$k] = $_REQUEST[$k] = $v;
				}
				//TODO: Make this redirect?
			}
			parent::__construct();
			$this->addBasketScreens();
			$this->addMinimumOrderScreen();
			$this->addScreen($this->getRegistrationScreen());
			$this->addPaymentProcessScreen();
			$this->addScreen($this->getConfirmationScreen());
			$this->addScreen($this->getPendingScreen());
			$this->addScreen($this->getFailureScreen());
			$this->processInput();
		}
		function addMinimumOrderScreen(){
			$this->addScreen(new MinimumOrderScreen($this));
		}
		function addBasketScreens(){
			$this->addScreen(new BasketEditFromCheckout('basket-edit',$this));
			$this->addScreen(new BasketConfirm('basket-confirm',$this));
		}
		function addPaymentProcessScreen(){
			$gateway = $this->getOrder()->getGateway();

			if($gateway->hasFeature('process-card-details')){
				$this->addScreen(new CreditCardProcess($this));
			}
			if($gateway->hasFeature('process-via-form')){
				$this->addScreen(new ExternalPaymentProcess($this));
			}
		}
		function getRegistrationScreen(){
			return new OrderRegistrationScreen($this);
		}
		function getPendingScreen(){
			return new PendingOrderDisplay($this);
		}
		function getConfirmationScreen(){
			return new FinalOrderDisplay('confirmation',$this);
		}
		function getFailureScreen(){
			return new OrderFailed('error',$this);
		}
		function requiresSSL(){
			return true;
		}

		function redirectTo($url){
			//TODO: This is an ugly hack to make paypal work
			if($url[0]=='?'){
				$url='/shop/checkout.html'.$url;
			}
			parent::redirectTo($url);
		}
	}
?>
