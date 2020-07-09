<?
if(!defined('HTTP_REQUEST_METHOD_POST')) define('HTTP_REQUEST_METHOD_POST','POST');
/**
* @package Boz_Orders
*/
if(class_exists('CURLRequest')) return;
class CURLRequest {
	function __construct($url){
		$this->url=$url;
	}
	function setUrl($url){
		$this->url = $url;
	}

	function sendRequest(){
		if(@$this->ch) return $this->exec($this->ch);

		$h = $this->ch = curl_init();
		$url = $this->url;
		if(@$this->isPost){
			curl_setopt($h,CURLOPT_POST,1);
			curl_setopt($h,CURLOPT_POSTFIELDS,join("&",$this->post));
		} else {
			$url.="?".join("&",$this->post);
		}
		$this->sentUrl = $url;
		curl_setopt($h,CURLOPT_URL,$url);
		curl_setopt ($h, CURLOPT_RETURNTRANSFER, 1) ;
		$this->exec($h);
		if($e = curl_error($h)){
			throw new Exception($e);
		}
	}

	function exec($h){
		$this->res = curl_exec($h);
	}

	function getResponseBody(){
		if(!$this->isReady()) $this->sendRequest();
		return @$this->res;
	}
	function getResponseXML(){
		if($this->xml) return $this->xml;
		if($body = $this->getResponseBody()) return $this->xml = @simplexml_load_string($body);
		return false;
	}
	function getResponsePost(){
		if(!@$this->reponsePost){
			$body = $this->getResponseBody();
			$body = explode("&",$body);
			$data = array();
			foreach($body as $k=>$v){
				list($k,$v) = explode("=",$v);
				$data[urldecode($k)] = urldecode($v);
			}
			$this->responsePost = $data;
		}
		return $this->responsePost;
	}
	function getResponseHeader($k){
		return false;
	}
	function setMethod($method){
		$this->isPost = ($method==HTTP_REQUEST_METHOD_POST);
	}
	function isReady(){
		return @$this->res;
	}
	var $encode = true;
	var $noEncode = array();
	function addPostData($k,$v){
		$this->values[$k] = $v;
		if($this->encode && !in_array($k,$this->noEncode)) {
			$k = urlencode($k);
			$v = urlencode($v);
		}
		$this->post[$k] = "$k=$v";
	}
	function cleanUp(){
		curl_close($this->ch);
	}
}

class MultiCURLRequest extends CURLRequest {
	static $mh;
	static $maxRequests = 15;
	static $outRequests = 0;
	static $running = array();
	static $index = 1;
	var $timeout=20;
	function __construct($url,$multi=false){
		parent::__construct($url);
		$this->multi = $multi;
	}
	function getResponseBody($block=true){
		if(!$this->isReady()) {
			$this->exec($this->ch);
			if($this->multi && $block)
			       while(!$this->isReady()) {
					$this->block();
				}
		}
		return $this->res;
	}

	function exec($h){
		if($this->exec) return;
		$this->exec = time();
		if($this->multi){
			if((self::$maxRequests>0)&&(count(self::$running)>=self::$maxRequests)) $this->block(self::$maxRequests);
			self::$outRequests++;
			if(!self::$mh) self::$mh = curl_multi_init();
			curl_multi_add_handle(self::$mh,$h);
			curl_multi_exec(self::$mh,$running);
			$this->register();
		} else {
			parent::exec($h);
		}
	}

	function isReady(){
		if(parent::isReady()) return true;
		if($this->multi){
			$content = curl_multi_getcontent($this->ch);
			if($this->xml = @simplexml_load_string($content)){
				$this->res = $content;
				$this->cleanUp();
//				echo "Received $this->url\n";
				return true;
			}
		}
		return false;
	}
	static $displayEvery = 1;
	function register(){
		static $count;
		if($count++%self::$displayEvery==0) echo "+";
		self::$running[$this->index = ++self::$index] = $this;
	}
	function cleanUp($success=true){
		static $count;
		$success = $success ? 1:0;
		if($count[$success]++%self::$displayEvery==0) echo $success?"-":"x";

		curl_multi_remove_handle(self::$mh,$this->ch);
		unset(self::$running[$this->index]);
		$this->exec=false;
		parent::cleanUp();
	}
	function checkTimedOut($restart = true){
		if((!$this->isReady()) && (time()>$this->exec+$this->timeout)){
			$this->cleanUp(false);
			$this->sendRequest();
		}
	}

	function block($max = 0){
		$running = count(self::$running);
		$lastChange = time();
		while(($running>$max) && $lastChange>time()-10){
			foreach(self::$running as $request){
				$request->checkTimedOut();
			}
			$lastRunning = $running;
			$running = count(self::$running);
			curl_multi_exec(self::$mh,$actRunning);
			if($lastRunning!=$running){
				$lastChange=time();
			}
			self::$outRequests = $running;
			if($running) curl_multi_select(self::$mh);

			//NO GLOBAL TIMEOUT
			$lastChange=time();
		}
	}
}
