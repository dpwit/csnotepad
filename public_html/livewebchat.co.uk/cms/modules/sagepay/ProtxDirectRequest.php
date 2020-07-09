<?
	define('__PROTX_LIVE__',Config::value('live','sagepay'));
	define('__PROTX_VENDOR__',Config::value('vendor','sagepay'));
	require_once(dirname(__FILE__).'/../../includes/class.CURLRequest.php');
	class ProtxRequest extends CURLRequest {
		var $isSent = false;
		var $errors = array();
		var $params = array();
		function __construct($url,$params=array()){
			static $base;
			if(!$base){
				$base = __PROTX_LIVE__ ? 'live' : 'test';
			}

			$url = preg_replace("_https://[^.]*_","https://$base",$url);
			parent::__construct($url,$params);
			$this->encode=true;
//			$this->noEncode = array("CustomerEMail","CardHolder");
		}
		function defaultParams(){
			return array();
		}
		function getResponseBody(){
			$data = parent::getResponseBody();
			$data = explode("\n",$data);
			$return = array();
			foreach($data as $v){
				@list($k,$v)=explode("=",$v,2);
				$return[$k]=trim($v);
			}
			return $return;
		}
		function pp($k,$v){
			$this->p($k,$this->param($k,$v));
		}
		function p($k,$v){
			$this->addPostData($k,$v);
		}
		function param($k,$default=null){
			if(array_key_exists($k,$this->params)) return $this->params[$k];
			else return $default;
		}
		function processIfNecessary(){
			if(!($this->isSent || $this->errors)) 
				$this->sendRequest();
		}
		function sendRequest(){
			if(@$this->isSent || @$this->errors) 
				return $this->isSuccessful();
			parent::sendRequest();
			$this->isSent=true;
			$output = $this->getResponseBody();

			$this->succeeded=(@$output['Status']=='OK');
			$this->status = @$output['Status'];
			$this->errors[] = @$output['StatusDetail'];
			$this->response = $output;

			return $this->isSuccessful();
		}
		function isSuccessful(){
			$this->processIfNecessary();
			return $this->succeeded;
		}
	}
	class ProtxProcessRequest extends ProtxRequest {
		function __construct($orderData,$params=array()){
			$this->orderData = $orderData;
			$this->params = array_merge($this->defaultParams(),$params);
			parent::__construct("https://test.sagepay.com/gateway/service/vspdirect-register.vsp");

			$this->addAccountPost();
			foreach($orderData as $k=>$v){
				$this->p($k,$v);
			}
			if(@$this->errors){
				$this->status='validation-errors';
			} else {
				$this->status='unsent';
			}
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
			global $_SESSION;
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

		function setParam($k,$v){
			$this->params[$k]=$v;
		}

		function getParam($k,$default=null){
			if(array_key_exists($k,$this->params)) return $this->params[$k];
			else return $default;
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
	class Auth3DRequest extends ProtxRequest {
		function __construct($post,$params = array()){
			parent::__construct("https://test.sagepay.com/gateway/service/direct3dcallback.vsp",$params);
			$this->isPost=true;
			$this->p('MD',$post['MD']);
			$this->p('PaRes',urlencode($post['PaRes']));
		}
		function defaultParams(){
			return array(
				'IsBackend'=>false,
				'deferred'=>false,
			);
		}

		function sendRequest(){
			parent::sendRequest();
			$output = $this->getResponseBody();

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
	class ProtxDeferredActionRequest extends ProtxRequest {
		function __construct($order,$params=array()){
			$def = $this->defaultParams();
			if(!$service = $params['service'])
				$service = $def['abort'] ? 'abort': 'release';
			parent::__construct("https://test.sagepay.com/gateway/service/".$service.".vsp",$params);
			$this->p('VPSProtocol',2.23);
			$this->p('TxType',strtoupper($service));
			$this->p('VendorTxCode',$order->uid);
			$this->p('Vendor',__PROTX_VENDOR__);
			$this->p('VPSTxId',$order->payment_id1);
			$this->p('SecurityKey',$order->payment_id2);
			$this->p('TxAuthNo',$order->payment_data['TxAuthNo']);
			$this->p('ReleaseAmount',$order->total);
		}

		function sendRequest(){
			parent::sendRequest();
			$output = $this->getResponseBody();
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
	class ProtxBaseRequest extends ProtxRequest {
		function __construct($order,$params=array()){
			$def = $this->defaultParams();
			if(!$service = $params['service'])
				$service = $def['abort'] ? 'abort': 'release';
			parent::__construct("https://test.sagepay.com/gateway/service/".$service.".vsp",$params);
			$this->p('VPSProtocol',2.23);
			$this->p('TxType',strtoupper($service));
			$this->p('VendorTxCode',__PROTX_VENDOR__.'-'.$order->uid.'-'.(rand(0,32000)*rand(0,32000)));
			$this->p('Vendor',__PROTX_VENDOR__);
			if($order->payment_id2)
				$this->p('SecurityKey',$order->payment_id2);
			if($order->payment_data['TxAuthNo'])
				$this->p('TxAuthNo',$order->payment_data['TxAuthNo']);
		}

		function sendRequest(){
			parent::sendRequest();
			$output = $this->getResponseBody();
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
			$this->p('VPSTxId',$order->payment_id1);
			$this->p('TxAuthNo',$order->payment_data['TxAuthNo']);
			$this->p('VendorTxCode',$order->payment_data['VendorTxCode']);
		}
	}
	class ProtxRefundRequest extends ProtxBaseRequest {
		var $void = null;
		function __construct($order,$params=array()){
			$params['service']='refund';
			parent::__construct($order,$params);
			$this->p('TxType','REFUND');
			$this->p('RelatedVPSTxId',$order->payment_id1);
			$this->p('RelatedTxAuthNo',$order->payment_data['TxAuthNo']);
			$this->p('RelatedVendorTxCode',$order->payment_data['VendorTxCode']);
			$this->p('Currency','GBP');
			if((!$params['amount']) || ($params['amount']==$order->getTotal())){
				$this->void = new ProtxVoidRequest($order);
				$this->p('Amount',$order->getTotal());
			} else {
				$this->p('Amount',$params['amount']);
			}
			$this->p('RelatedSecurityKey',$order->payment_id2);
			$this->p('Description',"Refund through CMS");
		}
		function sendRequest(){
			if($this->void && ($this->succeeded = $this->void->sendRequest())){
				$this->res = $this->void->res;
				$this->status = $this->void->status;
				return $this->succeeded;
			}
			unset($this->res);
			parent::sendRequest();
			if(!$this->isSuccessful()){
				$this->isSent=false;
				$this->p('TxType','REFUND');
				$this->status = $this->res['status'];
				parent::sendRequest();
			}
		}
	}
	class ProtxRepeatRequest extends ProtxBaseRequest {
		function __construct($order,$params=array()){
			$params['service']='repeat';
			parent::__construct($order,$params);
			$this->p('TxType','REPEAT');
			$this->p('RelatedVPSTxId',$order->payment_id1);
			$this->p('RelatedTxAuthNo',$order->payment_data['TxAuthNo']);
			$this->p('RelatedVendorTxCode',$order->payment_data['VendorTxCode']);
			$this->p('Currency','GBP');
			if((!$params['amount']) || ($params['amount']==$order->total)){
				$this->p('Amount',$order->total);
			} else {
				$this->p('Amount',$params['amount']);
			}
			$this->p('RelatedSecurityKey',$order->payment_id2);
			$this->pp('Description',"Subscription Renewal");
		}
	}
?>
