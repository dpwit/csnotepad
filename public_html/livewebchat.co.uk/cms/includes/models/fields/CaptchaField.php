<?
/**
* @package Model_System
*/

	class Captcha extends Field {
		var $publicKey = '6LfWYwcAAAAAAISX77obVYqB7DeHlda5tB1bxx-m';
		var $privateKey = '6LfWYwcAAAAAAPDlmuKMH0VJ5ecy0evazoTXdJnN';
		function __construct(){
			parent::__construct('captcha');
		}
		function setParams($params=array()){
			$params['db'] = false;
			parent::setParams($params);
		}
		function checkInvalid($value){
			$ip = array_key_exists('HTTP_REMOTE_HOST',$_SERVER) ? $_SERVER['HTTP_REMOTE_HOST'] : $_SERVER['REMOTE_ADDR'];
			$captcha = file_post_contents("http://api-verify.recaptcha.net/verify?privatekey=$this->privateKey&remoteip=$ip&challenge=$_POST[recaptcha_challenge_field]&response=$_POST[recaptcha_response_field]");
			if(!preg_match("/success/",$captcha)){
				return "Captcha Doesn't match";
			}
		}
		function renderHtml($obj){
			return '
			  <div id="recaptcha_widget">
			  <div id="recaptcha_image"></div>
			  <div class="recaptcha_response"><input id="recaptcha_response_field" name="recaptcha_response_field"/></div>
			  <div class="captcha-controls">
				<p class="captcha-message" >Please enter the two words displayed in the image above before clicking send. This prevents used being <a href="http://en.wikipedia.org/wiki/Spam_(electronic)" target="_blank">spammed</a> by robots while also helping to digitalize books.
				Captcha Technology courtesy of <a href="http://recaptcha.net/" target="_blank">Recaptcha</a></p>
				<p>Hard to <span class="recaptcha_only_if_image">read</span> <span class="recaptcha_only_if_audio">hear</span> this?</p> 
				<p><a href="javascript:Recaptcha.reload()">Try Another</a>
				<span class="recaptcha_only_if_image">or try an <a href="javascript:Recaptcha.switch_type(\'audio\')">audio based captcha.</a></span>
				<span class="recaptcha_only_if_audio">or try an <a href="javascript:Recaptcha.switch_type(\'image\')"> image based captcha.</a></span></p>
				<p></p>
			  </div>


			   <script>
				var RecaptchaOptions = {
					theme: "custom"
				};
				</script>
			<script type="text/javascript"
				   src="http://api.recaptcha.net/challenge?k='.$this->publicKey.'&theme=custom">
				   </script>
			   <noscript>
			   <iframe src="http://api.recaptcha.net/noscript?k='.$this->publicKey.'"
			          height="300" width="500" frameborder="0"></iframe><br>
			     <textarea name="recaptcha_challenge_field" rows="3" cols="40">
			        </textarea>
			   <input type="hidden" name="recaptcha_response_field" 
			          value="manual_challenge">
			  </noscript>
			  </div>
			  ';
		}
	}
function file_post_contents($url,$returnHeaders=false) {
    $url = parse_url($url);

    if (!isset($url['port'])) {
      if ($url['scheme'] == 'http') { $url['port']=80; }
      elseif ($url['scheme'] == 'https') { $url['port']=443; }
    }
    $url['query']=isset($url['query'])?$url['query']:'';

    $url['protocol']=$url['scheme'].'://';
    $eol="\r\n";

    $headers =  "POST ".$url['protocol'].$url['host'].$url['path']." HTTP/1.0".$eol.
                "Host: ".$url['host'].$eol.
                "Referer: ".$url['protocol'].$url['host'].$url['path'].$eol.
                "Content-Type: application/x-www-form-urlencoded".$eol.
                "Content-Length: ".strlen($url['query']).$eol.
                $eol.$url['query'];
    $fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);
    if($fp) {
      fputs($fp, $headers);
      $result = '';
      while(!feof($fp)) { $result .= fgets($fp, 128); }
      fclose($fp);
      if (!$returnHeaders) {
        //removes headers
        $pattern="/^.*\r\n\r\n/s";
        $result=preg_replace($pattern,'',$result);
      }
      return $result;
    }
}
