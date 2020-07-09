<?
/**
* @package Boz_Orders
*/

	cms_module_require('orders','GatewayInterface.php');
	require_once(dirname(__FILE__).'/../../includes/class.CURLRequest.php');
	class SagePayGateway implements SubscriptionInterface {
		function __construct(){
			foreach(array('vendor','live') as $var){
				$this->$var = Config::value($var,'sagepay');
			}
		}
		function init(){
			require_once(dirname(__FILE__).'/ProtxDirectRequest.php');
		}
		function getEngineName(){
			return "sagepay/direct";
		}

		function cardTypeForProtx($type){
			$type = strtoupper($type);
			$mapping = array('MASTERCARD'=>'MC','MAESTRO/SWITCH'=>'MAESTRO','DELTA'=>'DELTA','SOLO'=>'SOLO');
			if(@$mapping[$type]) return $mapping[$type];
			return $type;
		}

		function getPaymentFields($order){
			$street = explode("\n",$order->customer_address);
			$request = array(
				"ID"=>$order->getId(),
				"CardNumber"=>$order->card_number,
				"CardHolder"=>$order->card_name,
				"ExpiryDate"=>$order->card_expiry("my"),
				"CV2"=>$order->card_cvv,
				"CardType"=>$this->cardTypeForProtx($order->card_type),
				"StartDate"=>$order->card_start("my"),
				"IssueNumber"=>@$order->card_issue_number,
				"BillingFirstnames"=>"$order->customer_firstname",
				"BillingSurname"=>"$order->customer_lastname",
				"BillingAddress1"=>@$street[0],
				"BillingAddress2"=>@$street[1],
				"BillingPostCode"=>$order->customer_postcode,
				"BillingCity"=>$order->customer_city,
				"BillingState"=>(strtolower($order->customer_country)=='us') ? $order->customer_state : '',
				"BillingCountry"=>$order->customer_country,
				"Amount"=>$order->getTotal(),
				"Currency"=>'GBP',
				"Description"=>"",
				"CustomerName"=>"$order->customer_firstname $order->customer_lastname",
				"CustomerEMail"=>"$order->customer_email",
				"ContactNumber"=>"$order->customer_phone",
			);
			foreach(array('StartDate','IssueNumber','BillingState') as $blank){
				if(!$request[$blank]) unset($request[$blank]);
			}
			foreach($request as $k=>$v){
				$k = str_replace("Billing","Delivery",$k);
				if(!@$request[$k]) $request[$k]=$v;
			}
			$index=0;
			foreach($order->order_items() as $item){
				$request["Description"][]="$item->quantity x $item->name";
				$item->tax = 0;
				$request['Basket'][] = 
					"$item->name:$item->quantity:".number_format($item->price,2)
					.":" //.number_format($item->tax,2)
					.":" //.number_format($item->price,2)
					.":".number_format($item->quantity*$item->price,2);
					
			}
			$request['Description'] = join(", ",$request['Description']);
			$request['Description'] = "Order From "+$GLOBALS['project_title'];
			$request['Basket'] = count($request['Basket']).":".join(":",$request['Basket']);

			return $request;
		}
		function process($order){
			$this->init();
			if(!$order->exists()) $order->writeToDB();
			if(!$order->canTransition('Complete'))
				throw new Exception("Order is not valid for processing (".$order->order_state()->name.")");

			if(!($order->validateUserDetails()&&$order->validateCardDetails())){
				throw new Exception(join("\n",$order->errors));
			}
			$requestFields = $this->getPaymentFields($order);
			$request = new ProtxProcessRequest($requestFields);
			$success = $request->sendRequest();

			$order->payment_engine = $order->payment_gateway = $this->getEngineName();
			$order->payment_environment=$this->live ? "live.sagepay.com" : "test.sagepay.com";
			$order->payment_message = join("\n",$request->errors);
			$order->payment_status = $request->status;
			$fields = $request->getResponseBody();
			global $_SESSION;
			$fields['VendorTxCode'] = $_SESSION['VendorTxCode'];
			switch($request->status){
			case 'OK':
				$order->payment_id1 = $fields['VPSTxId'];
				$order->payment_id2 = $fields['SecurityKey'];
				$order->payment_data = $fields;
				$order->total_processed = $requestFields['Amount'];
				$order->doTransition('Complete');
				return true;
			case '3DAUTH':
				$order->payment_id1 = @$request->vpstx_id;
				$order->payment_id2 = @$request->vendor_id;
				$order->payment_data = $fields;
				$order->total_processed = $requestFields['Amount'];
				$order->doTransition('3DAUTH');
				return false;
			default:
				$order->payment_id1 = @$request->vpstx_id;
				$order->payment_id2 = @$request->vendor_id;
				$order->payment_message = $fields['StatusDetail'];
				$order->payment_data = $fields;
				$order->doTransition('Failed');
				throw new Exception("Sage Pay Response: ".$order->payment_status." ".$order->payment_message);
			}
		}
		function handle3dAuthReturn($order){
			$this->init();
			$request = new Auth3DRequest($_POST);
			$fields = $request->getResponseBody();
			switch($request->status){
			case 'OK':
				$order->payment_id1 = $fields['VPSTxId'];
				$order->payment_id2 = $fields['SecurityKey'];
				$order->payment_data = $fields;
				$order->doTransition('Complete');
				return true;
			default:
				$order->payment_id1 = @$request->vpstx_id;
				$order->payment_id2 = @$request->vendor_id;
				$order->payment_message = $fields['StatusDetail'];
				$order->payment_data = $fields;
				$order->doTransition('Failed');
				throw new Exception("Sage Pay Response: ".$order->payment_status." ".$order->payment_message);
			}
		}

		function reprocessSubscription($order,$subscription,$value=false){
			$this->init();
			$original = $subscription->order();
			if($value===false){
				$value = $original->getTotal();
			}

			$reprocess = new ProtxRepeatRequest($original,array('amount'=>$value));
			$reprocess->sendRequest();
			$this->setFrom($order,$reprocess);
			return false;
		}
		function setFrom($order,$request){
			$order->payment_engine = $this->getEngineName();
			$order->payment_environment=$this->live ? "live.sagepay.com" : "test.sagepay.com";
			$order->payment_message = join("\n",$request->errors);
			$order->payment_status = $request->status;
			$fields = $request->getResponseBody();
			global $_SESSION;
			$fields['VendorTxCode'] = $_SESSION['VendorTxCode'];
			switch($request->status){
			case 'OK':
				$order->payment_id1 = $fields['VPSTxId'];
				$order->payment_id2 = $fields['SecurityKey'];
				$order->payment_data = $fields;
				$order->total_processed = $request->values['Amount'];
				$order->doTransition('Complete');
				return true;
			default:
				$order->payment_id1 = @$request->vpstx_id;
				$order->payment_id2 = @$request->vendor_id;
				$order->doTransition('Failed');
				throw new Exception("Sage Pay Response: ".$order->payment_status." ".$order->payment_message);
			}
		}

		function process3dAuth($order){
			throw new Exception(__FUNCTION__." Not Implemented in ".__CLASS__);
		}

		function refund($order,$amount=false){
			$this->init();
			if($amount===false) $amount = $order->getTotal();
			$refund = new ProtxRefundRequest($order,array('amount'=>$amount));
			$fields = $refund->getResponseBody();
			if($refund->isSuccessful()){
				$order->payment_data = $fields;
				$order->total_processed -= $refund->values['Amount'];
				$order->doTransition('Refunded');
				return true;
			} else {
				$order->payment_data['refund'][] = $fields;
				$order->writeToDB();
				throw new Exception("Sage Pay Response: ".$order->payment_status." ".$order->payment_message);
			}
			return $refund->isSuccessful();
		}

		function createSubscription($order){
			$ret = $this->process($order);
			return $ret;
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
		function hidden3DAuthForOrder($order){
			$p = $order->payment_data;

			$https_url = defined('__HTTPS_BASE_URL__')?__HTTPS_BASE_URL__:("https://".__SERVER_DOMAIN__);

			$html = "
			<script>
				var ACSURL='".$p['ACSURL']."';
				var MD='".$p['MD']."';
				var PAReq='".$p['PAReq']."';
				var TermURL='$https_url/checkout/3dauth-return?txId={$order->uid}';
			</script>
			";
			return $html;
		}

		function getFeatures(){
			return array(
				"manualRenewal"=>1,
				"autoRenewal"=>0,
				"subscriptions"=>1,
				"process-card-details"=>1,
				"refund"=>1,
				"require-state"=>true,
			);
		}
		function hasFeature($key){
			$features = $this->getFeatures();
			return @$features[$key];
		}
		function getPaymentMethods($amount){
			$methods = array();
			if($amount>=$this->getMinimumCheckout()){
				return array('card'=>'Debit/Credit Card');
			}
			return $methods;
		}
		function getMinimumCheckout(){
			return Config::value('sagepay_minimum_checkout','orders');
		}

		function getSupportedCards(){
			$cards = array('Visa','Mastercard','Maestro/Switch','Delta','Solo');

			if(Config::value('allow_amex','sagepay')) $cards[]='American Express';

			return $cards;
		}
	}
?>
