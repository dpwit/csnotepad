<?
/**
* @package Boz_Orders
*/

	if(!@include_once(dirname(__FILE__).'/../../../../config/config.php')){
		define('__PROTX_LIVE__',true);
		define('__PROTX_VENDOR__','concorde2');
	}
	class CURL_Request {
		var $isSent=false;
		var $errors='';
		function __construct($url,$params=array()){
			$this->url=$this->fixURL($url);
			$this->params = array_merge($this->defaultParams(),$params);
		}

		function fixURL($url){
			static $base;
			if(!$base){
				$base = __PROTX_LIVE__ ? 'ukvps' : 'ukvpstest';
			}

			$url = preg_replace("_https://[^.]*_","https://$base",$url);
			return $url;
		}

		function addPostParameter($k,$v){
			$this->post[$k]=$v;
			$this->assign[$k]=$k.'='.str_replace('+',' ',$v);
		}

		function send(){
			$this->body = $this->requestPost($this->url,join('&',$this->assign));
		}

		function getBody(){
			return $this->body;
		}
		function requestPost($url, $data){
			// Set a one-minute timeout for this script
			set_time_limit(60);
		
			// Initialise output variable
			$output = array();
		
			// Open the cURL session
			$curlSession = curl_init();
		
			// Set the URL
			curl_setopt ($curlSession, CURLOPT_URL, $url);
			// No headers, please
			curl_setopt ($curlSession, CURLOPT_HEADER, 0);
			// It's a POST request
			curl_setopt ($curlSession, CURLOPT_POST, 1);
			// Set the fields for the POST
			curl_setopt ($curlSession, CURLOPT_POSTFIELDS, $data);
			// Return it direct, don't print it out
			curl_setopt($curlSession, CURLOPT_RETURNTRANSFER,1); 
			// This connection will timeout in 30 seconds
			curl_setopt($curlSession, CURLOPT_TIMEOUT,1200); 
			//The next two lines must be present for the kit to work with newer version of cURL
			//You should remove them if you have any problems in earlier versions of cURL
		    curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, FALSE);
		    curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, 1);
		
			//Send the request and store the result in an array
			
			$rawresponse = curl_exec($curlSession);
			//Store the raw response for later as it's useful to see for integration and understanding 
			$_SESSION["rawresponse"]=$rawresponse;
			//Split response into name=value pairs
			$response = split(chr(10), $rawresponse);
			// Check that a connection was made
			if (curl_error($curlSession)){
				// If it wasn't...
				$output['Status'] = "FAIL";
				$output['StatusDetail'] = curl_error($curlSession);
			}
		
			// Close the cURL session
			curl_close ($curlSession);
		
			// Tokenise the response
			for ($i=0; $i<count($response); $i++){
				// Find position of first "=" character
				$splitAt = strpos($response[$i], "=");
				// Create an associative (hash) array with key/value pairs ('trim' strips excess whitespace)
				$output[trim(substr($response[$i], 0, $splitAt))] = trim(substr($response[$i], ($splitAt+1)));
				
			}
			return $output;
		}
		function defaultParams(){
			return array();
		}
		function param($k,$default=null){
			if(array_key_exists($k,$this->params)) return $this->params[$k];
			else return $default;
		}
		function pp($k,$v){
			$this->p($k,$this->param($k,$v));
		}
		function p($k,$v){
			$this->addPostParameter($k,$v);
		}

		function setParam($k,$v){
			$this->params[$k]=$v;
		}

		function getParam($k,$default=null){
			if(array_key_exists($k,$this->params)) return $this->params[$k];
			else return $default;
		}
		function processIfNecessary(){
			if(!($this->isSent || $this->errors)) 
				$this->process();
		}
		function process(){
			if($this->isSent || $this->errors) 
				return $this->isSuccessful();
			$this->send();
			$this->isSent=true;
		}
	}
	class ProtxProcessRequest extends CURL_Request {
		function __construct($orderData,$params=array()){
			$this->orderData = $orderData;
			$this->params = array_merge($this->defaultParams(),$params);
			parent::__construct("https://ukvpstest.protx.com/vspgateway/service/vspdirect-register.vsp");

			$this->addAccountPost();
			foreach($orderData as $k=>$v){
				$this->p($k,$v);
			}
			if($this->errors){
				$this->status='validation-errors';
			} else {
				$this->status='unsent';
			}
		}
		function param($k,$default=null){
			if(array_key_exists($k,$this->params)) return $this->params[$k];
			else return $default;
		}
		function defaultParams(){
			return array(
				'IsBackend'=>false,
				'deferred'=>false,
			);
		}

		function addAccountPost(){
			// M For mail order - E for ecommerce
			$this->p('AccountType',$this->param('IsBackend',false)?'M':'E');

			$this->p('VPSProtocol',2.23);
			$this->p('TxType',$this->param('deferred',false)?'DEFERRED':'PAYMENT');
			$this->p('Vendor',__PROTX_VENDOR__);
			$strTimeStamp = date("y-m-d _ H.i.s", time());
			$intRandNum = rand(0,32000)*rand(0,32000);
			$this->orderId = $strVendorTxCode=$intRandNum; //$strTimeStamp . "-" . $intRandNum);
			$_SESSION["VendorTxCode"] = __PROTX_VENDOR__.'-'.$this->orderData['ID'].'-'.$strVendorTxCode;
			$this->p('VendorTxCode',$_SESSION['VendorTxCode']);
		}

		function translateCardType($f){
			$paymentArr = array('Visa'=>'VISA','Mastercard'=>'MC','Maestro/Switch'=>'MAESTRO','Delta'=>'DELTA','Solo'=>'SOLO');
			return $paymentArr[$f];
		}
		function addUserPost(){
			$user = $this->user;
			$fields = array(
				'CardHolder','CardNumber',
				'ExpiryDate', 'StartDate' , 'CV2',
				'CardType',
				'CustomerEmail',
			);
			$addressFields = array('Firstnames','Surname','Address1','Address2','City','PostCode','Country','Phone');
			foreach(array('Billing','Delivery') as $type)
				foreach($addressFields as $field ){
					$fields[]= $type.$field;
				}

			foreach($fields as $field){
				$this->addUserField($field);
			}
		}
		function addOrderPost(){
			foreach($this->order->items() as $item){
				$basket.=$item->title();
			}
			$this->p('Amount',$this->order->total());
			$this->pp('Currency','GBP');
			$this->pp('Description','Your Order');
		}

		function pp($k,$v){
			$this->p($k,$this->param($k,$v));
		}
		function p($k,$v){
			$this->addPostParameter($k,$v);
		}

		function setParam($k,$v){
			$this->params[$k]=$v;
		}

		function getParam($k,$default=null){
			if(array_key_exists($k,$this->params)) return $this->params[$k];
			else return $default;
		}
		function processIfNecessary(){
			if(!($this->isSent || $this->errors)) 
				$this->process();
		}
		function process(){
			if($this->isSent || $this->errors) 
				return $this->isSuccessful();
			$this->send();
			$this->isSent=true;
			$output = $this->getBody();

			$this->succeeded=($output['Status']=='OK');
			$this->status = $output['Status'];
			$this->errors[] = $output['StatusDetail'];
			$this->response = $output;

			return $this->isSuccessful();
		}
		function isSuccessful(){
			$this->processIfNecessary();
			return $this->succeeded;
		}
		function status(){
			return $this->status;
		}
		function errors(){
			return $this->errors;
		}
		function orderId(){
			return $this->orderId;
		}
	}
	class Auth3DRequest extends CURL_Request {
		function __construct($post,$params = array()){
			parent::__construct("https://ukvpstest.protx.com/vspgateway/service/direct3dcallback.vsp",$params);
			$this->addPostParameter('MD',$post['MD']);
			$this->addPostParameter('PaRes',urlencode($post['PaRes']));
		}
		function defaultParams(){
			return array(
				'IsBackend'=>false,
				'deferred'=>false,
			);
		}

		function process(){
			parent::process();
			$output = $this->getBody();

			$this->succeeded=($output['Status']=='OK');
			$this->status = $output['Status'];
			$this->errors[] = $output['StatusDetail'];

			return $this->isSuccessful();
		}
		function isSuccessful(){
			$this->processIfNecessary();
			return $this->succeeded;
		}
		function status(){
			return $this->status;
		}
		function errors(){
			return $this->errors;
		}
		function orderId(){
			return $this->orderId;
		}
	}
	class ProtxDeferredActionRequest extends CURL_Request {
		function __construct($order,$params=array()){
			$def = $this->defaultParams();
			if(!$service = $params['service'])
				$service = $def['abort'] ? 'abort': 'release';
			parent::__construct("https://ukvpstest.protx.com/vspgateway/service/".$service.".vsp",$params);
			$this->p('VPSProtocol',2.23);
			$this->p('TxType',strtoupper($service));
			$this->p('VendorTxCode',$order->uid);
			$this->p('Vendor',__PROTX_VENDOR__);
			$this->p('VPSTxId',$order->vpstxid);
			$this->p('SecurityKey',$order->security_key);
			$this->p('TxAuthNo',$order->tx_auth_no);
			$this->p('ReleaseAmount',$order->total);
		}

		function process(){
			parent::process();
			$output = $this->getBody();
			$this->succeeded=(@$output['Status']=='OK');
			$this->status = @$output['Status'];
			$this->errors[] = @$output['StatusDetail'];

			return $this->isSuccessful();
		}
		function isSuccessful(){
			$this->processIfNecessary();
			return $this->succeeded;
		}
		function status(){
			return $this->status;
		}
		function errors(){
			return $this->errors;
		}
		function orderId(){
			return $this->orderId;
		}
	}
	class ProtxBaseRequest extends CURL_Request {
		function __construct($order,$params=array()){
			$def = $this->defaultParams();
			if(!$service = $params['service'])
				$service = $def['abort'] ? 'abort': 'release';
			parent::__construct("https://ukvpstest.protx.com/vspgateway/service/".$service.".vsp",$params);
			$this->p('VPSProtocol',2.23);
			$this->p('TxType',strtoupper($service));
			$this->p('VendorTxCode',__PROTX_VENDOR__.'-'.$order->uid.'-'.(rand(0,32000)*rand(0,32000)));
			$this->p('Vendor',__PROTX_VENDOR__);
			if($order->security_key)
				$this->p('SecurityKey',$order->security_key);
			if($order->tx_auth_no)
				$this->p('TxAuthNo',$order->tx_auth_no);
		}

		function process(){
			parent::process();
			$output = $this->getBody();
			$this->succeeded=(@$output['Status']=='OK');
			$this->status = @$output['Status'];
			$this->errors[] = @$output['StatusDetail'];

			return $this->isSuccessful();
		}
		function isSuccessful(){
			$this->processIfNecessary();
			return $this->succeeded;
		}
		function status(){
			return $this->status;
		}
		function errors(){
			return $this->errors;
		}
		function orderId(){
			return $this->orderId;
		}
	}
	class ProtxReleaseRequest extends ProtxDeferredActionRequest{
		function defaultParams(){
			return array('abort'=>false);
		}
	}
	class ProtxAbortRequest extends ProtxDeferredActionRequest{
		function defaultParams(){
			return array('abort'=>true);
		}
	}
	class ProtxVoidRequest extends ProtxBaseRequest {
		function __construct($order,$params=array()){
			$params['service']='void';
			parent::__construct($order,$params);
			$this->p('TxType','VOID');
			$this->p('VPSTxId',$order->vpstxid);
			$this->p('TxAuthNo',$order->tx_auth_no);
			$this->p('VendorTxCode',$order->vendor_tx_code);
		}
		function process(){
			$res = parent::process();
			return $res;
		}
	}
	class ProtxRefundRequest extends ProtxBaseRequest {
		function __construct($order,$params=array()){
			$params['service']='refund';
			parent::__construct($order,$params);
			$this->p('TxType','REFUND');
			$this->p('RelatedVPSTxId',$order->vpstxid);
			$this->p('RelatedTxAuthNo',$order->tx_auth_no);
			$this->p('RelatedVendorTxCode',$order->vendor_tx_code);
			$this->p('Currency','GBP');
			if((!$params['amount']) || ($params['amount']==$order->total)){
				$this->void = new ProtxVoidRequest($order);
				$this->p('Amount',$order->total);
			} else {
				$this->p('Amount',$params['amount']);
			}
			$this->p('RelatedSecurityKey',$order->security_key);
			$this->p('Description',"Refund through CMS");
		}
		function process(){
			if($this->void && ($this->succeeded = $this->void->process())){
				return $this->succeeded;
			}
			parent::process();
			if(!$this->isSuccessful()){
				$this->isSent=false;
				$this->p('TxType','REFUND');
				$this->url=$this->fixURL("https://ukvpstest.protx.com/vspgateway/service/refund.vsp",$params);
				parent::process();
			}
		}
	}
?>
