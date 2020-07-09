<?
/**
* @package Boz_Orders
*/

	cms_module_require('orders','GatewayInterface.php');
	require_once(dirname(__FILE__).'/../../includes/class.CURLRequest.php');
	class PayPalGateway implements SubscriptionInterface {
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
		function getEngineName(){
			return "paypal";
		}
		function pp_request($command,$data){
			$url = "https://api.$this->host/nvp";
			$req = new CURLRequest($url);
			$req->setMethod(HTTP_REQUEST_METHOD_POST);

			$base['METHOD'] = $command;
			$base['VERSION'] = "52.0";
			$base['USER'] = $this->user;
			$base['PWD'] = $this->pass;
			$base['SIGNATURE'] = $this->sig;
			$data = array_merge($base,$data);
			foreach($data as $k=>$v){
				$req->addPostData($k,$v);
			}

			$response = $req->getResponsePost();
			//var_dump(array('req'=>$data,'resp'=>$response));
			return $response;
		}

		function getPaymentFields($order){
			$street = explode("\n",$order->customer_address);
			$request = array(
				"IPADDRESS"=>@$order->ip_address,
				"CREDITCARDTYPE"=>@$order->card_type,
				"ACCT"=>@$order->card_number,
				"EXPDATE"=>$order->card_expiry("mY"),
				"CVV2"=>@$order->card_cvv,
				"STARTDATE"=>$order->card_start("mY"),
				"ISSUENUMBER"=>@$order->card_issue_number,
				"AMT"=>$order->getTotal(),
				"SALUTATION"=>@$order->customer_title,
				"FIRSTNAME"=>@$order->customer_firstname,
				"LASTNAME"=>@$order->customer_lastname,
				"STREET"=>$street[0],
				"STREET2"=>@$street[1],
				"ZIP"=>@$order->customer_postcode,
				"CITY"=>@$order->customer_city,
				"COUNTRYCODE"=>@$order->customer_country,
				"CURRENCYCODE"=>"GBP",
			);
			$index=0;
			foreach($order->order_items() as $item){
				$request["L_NAME$index"]=$item->name;
				$request["L_AMT$index"]=$item->price;
				$request["L_QTY$index"]=$item->quantity;
				$index++;
			}
			return $request;
		}
		function process($order){
			if(!@$order->payment_method) $order->payment_method='card';
			switch($order->payment_method){
			case 'form':
				$this->processForm($order);
				break;
			case 'card':
			default:
				return $this->processCard($order);
			}
		}
		function processCard($order){
			if(!$order->canTransition('Complete'))
				throw new Exception("Order is not valid for processing (".$order->order_state()->name.")");

			if(!($order->validateUserDetails()&&$order->validateCardDetails())){
				throw new Exception(join("\n",$order->errors));
			}
			$request = $this->getPaymentFields($order);
			$request["PAYMENTACTION"]="Sale";
			$response = $this->pp_request("DoDirectPayment",$request);
			$order->payment_engine = $this->getEngineName();
			$order->payment_environment="api.$this->host";
			$order->payment_message = @$response['L_LONGMESSAGE0'];
			$order->payment_status = $response['ACK'];
			switch($response['ACK']){
			case 'Success':
				$order->payment_id1 = @$response['PROFILEID'];
				$order->payment_id2 = $response['CORRELATIONID'];
				$order->payment_data = $response;
				$order->total_processed = $response['AMT'];
				$order->doTransition('Complete');
				return true;
			default:
				$order->payment_id1 = @$response['TRANSACTIONID'];
				$order->payment_id2 = @$response['CORRELATIONID'];
				$order->doTransition('Failed');
				throw new Exception("Paypal Response: ".$response['ACK']." ".$response['L_LONGMESSAGE0']);
			}
		}

		function redirectForm($order,$returnUrl){
			$fields = $this->getPaymentFields($order);
			$fields["PAYMENTACTION"]="Sale";
			$fields["ReturnURL"] = $returnUrl;
			$fields["CancelURL"] = $returnUrl;
			
			foreach($fields as $k=>$v){
				if(!$v){
					unset($fields[$k]);
				}
			}
			$response = $this->pp_request('SetExpressCheckout',$fields);
			switch($response['ACK']){
			case 'Success':
				$order->payment_id1 = @$response['TOKEN'];
				$order->payment_id2 = $response['CORRELATIONID'];
				$order->payment_data['SetCheckout'] = $response;
				$url = "https://www.$this->host/webscr?cmd=_express-checkout&token=$response[TOKEN]&AMT=$fields[AMT]&CURRENCYCODE=$fields[CURRENCYCODE]&RETURNURL=$fields[ReturnURL]&CANCELURL=$fields[CancelURL]";
				@header("Location: $url");
				echo "<script>document.location.href='$url';</script>";

				$order->writeToDB();
				$id = $order->getId();
				die("REDIRECTING....");
				return true;
			default:
				$order->payment_id1 = $response['TRANSACTIONID'];
				$order->payment_id2 = $response['CORRELATIONID'];
				$order->doTransition('Failed');
				throw new Exception("Paypal Response: ".$response['ACK']." ".$response['L_LONGMESSAGE0']);
			}
		}
		function handleFormReturn($order){
			$response = $this->pp_request('GetExpressCheckoutDetails',array('TOKEN'=>$order->payment_id1));
			switch($response['ACK']){
			case 'Success':
				$order->payment_id1 = @$response['TOKEN'];
				$order->payment_id2 = $response['CORRELATIONID'];
				$order->payment_data['GetCheckout'] = $response;
				$order->customer_firstname = $response['FIRSTNAME'];
				$order->customer_lastname = $response['LASTNAME'];
				$order->payment_country = $response['COUNTRYCODE'];
				$order->customer_country = $response['SHIPTOCOUNTRYCODE'];
				$order->customer_email = $response['EMAIL'];
				$order->customer_address = $response['SHIPTOSTREET']."\n".$response['SHIPTOCITY']."\n".$response['SHIPTOSTATE'];
				$order->customer_postcode = $response['SHIPTOZIP'];
				$order->writeToDB();
				return true;
			default:
				$order->payment_id1 = $response['TRANSACTIONID'];
				$order->payment_id2 = $response['CORRELATIONID'];
				$order->doTransition('Failed');
				throw new Exception("Paypal Response: ".$response['ACK']." ".$response['L_LONGMESSAGE0']);
			}
		}
		function processForm($order){
			$fields = $this->getPaymentFields($order);
			$fields["PAYMENTACTION"]="Sale";
			$fields['TOKEN'] = $order->payment_id1;
			$fields['PAYERID'] = $order->payment_data['GetCheckout']['PAYERID'];
			//$fields[
			$response = $this->pp_request('DoExpressCheckoutPayment',$fields);
			switch($response['ACK']){
			case 'Success':
				$order->payment_data['DoExpressCheckoutPayment'] = $response;
				$order->doTransition('Complete');
				return true;
			default:
				$order->payment_id1 = $response['TRANSACTIONID'];
				$order->payment_id2 = $response['CORRELATIONID'];
				$order->doTransition('Failed');
				throw new Exception("Paypal Response: ".$response['ACK']." ".$response['L_LONGMESSAGE0']);
			}

		}

		function process3dAuth($order){
			throw new Exception(__FUNCTION__." Not Implemented in ".__CLASS__);
		}

		function refund($order){
			throw new Exception(__FUNCTION__." Not Implemented in ".__CLASS__);
		}

		function createSubscription($order){
			if(!$order->exists()) $order->writeToDB();
			if(!$order->canTransition('Complete'))
				throw new Exception("Order is not valid for processing (".$order->order_state()->name.")");

			if(!($order->validateUserDetails()&&$order->validateCardDetails())){
				throw new Exception(join("\n",$order->errors));
			}
			$request = $this->getPaymentFields($order);

			$request['PROFILEREFERENCE'] = $order->getId();
			$request['AUTOBILLAMT'] = 'AddToNextBilling';
			$request['BILLINGPERIOD'] = 'Month';
			//$request['BILLINGPERIOD'] = 'Day';
			$request['BILLINGFREQUENCY'] = 1;
			$request['PROFILESTARTDATE'] = date("c");
			$request['DESC'] = 'Subscription to Elite Promo';

/*			$request['INITAMT'] = 100; //Setup Fee
 */

/*			$request['TRIALAMT'] = 0;
 *			$request['TRIALBILLINGFREQUENCY'] = 1;
 *			$request['TRIALBILLINGPERIOD'] = 'Month';
 *			$request['TRIALBILLINGCYCLES'] = 1;
 */

			$response = $this->pp_request("CreateRecurringPaymentsProfile",$request);

			$order->payment_engine = $this->getEngineName();
			$order->payment_environment="api.$this->host";
			$order->payment_message = @$response['L_LONGMESSAGE0'];
			$order->payment_status = $response['ACK'];
			switch($response['ACK']){
			case 'Success':
				$order->payment_id1 = @$response['PROFILEID'];
				$order->payment_id2 = $response['CORRELATIONID'];
				$order->payment_data = $response;
				$order->total_processed = @$response['AMT'];
				$order->doTransition('Complete');
				return true;
			default:
				$order->payment_id1 = $response['TRANSACTIONID'];
				$order->payment_id2 = $response['CORRELATIONID'];
				$order->doTransition('Failed');
				throw new Exception($response['ACK']." ".$response['L_LONGMESSAGE0']);
			}
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
		}

		function getPaymentMethods($amount){
			$methods = array();
			if($amount>=$this->getMinimumCheckout()){
				return array('card'=>'Debit/Credit Card',
					'form'=>'PayPal');
			}
			return $methods;
		}
		function getMinimumCheckout(){
			return Config::value('paypal_minimum_checkout','orders');
		}

		function getFeatures(){
			return array(
				"manualRenewal"=>0,
				"autoRenewal"=>1,
				"subscriptions"=>1,
				"process-card-details"=>1,
				"process-via-form"=>1,
				"confirm-after-form"=>1,
			);
		}
		function hasFeature($key){
			$feat = $this->getFeatures();
			return $feat[$key];
		}
		function getSupportedCards(){
			$cards = array('Visa','Mastercard','Maestro','American Express');
			return array_combine($cards,$cards);
		}
	}
?>
