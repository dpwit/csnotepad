<?
/**
* @package Elite_Promo
*/

	class ScreenFlow extends Component {
		var $screens = array();
		var $processed = false;
		var $parent = null;
		var $doesRedirects = true;
		var $redirectTop = false;

		function addScreen($screen){
			$this->screens[] = $screen;
			$screen->setParent($this);
		}

		function preProcess(){
			if($this->shouldProcess()){
				$screen = $this->findLastScreen();
				if($screen){
					if($screen->process()) {
						if($url = $this->getNextScreenUrl()) {
							$this->redirectTo($url);
						}
						else return true;
					} else {
						//Ignore this for now so as not to lose validation stuff
						//should really redirect.
					}
				}
			}
		}

		function redirectTop(){
			$this->redirectTop=true;
			if($this->parent) $this->parent->redirectTop();
		}
		function redirectTo($url){
			if($this->doesRedirects){
				$this->storeSessionInfo();
				if(strpos($url,'?')===0){
					@list($old,$q) = explode('?',$_SERVER['REQUEST_URI'],2);
					$url = $old.$url;
				}
				if($this->redirectTop){
					die("<script>top.document.location = '$url';</script>");
				} else {
					redirectTo($url);
				}
			}
		}
		function initialiseScreenflow(){
		}
		function storeSessionInfo(){
			if($this->parent) $this->parent->storeSessionInfo();
		}
		function clearSessionInfo(){
			if($this->parent) $this->parent->clearSessionInfo();
		}

		function shouldProcess(){
			return $_POST || @$_GET['go'];
		}

		function processInput(){
return;
			if($this->processed) return;
			$this->processed = true;
			$screen = $this->findLastScreen();
			if($screen) {
				return $screen->process();
			}
			return false;
		}

		var $checkedKey = null;
		function findByKey($key,$screens=array()){
			if(!$screens) $screens = $this->screens;
			$this->checkedKey = $key;
			foreach($screens as $screen){
				if($screen->matchesKey($key)){
					return $screen;
				}
				if(!$screen->canSkip()){
//					trigger_error("FAILED Skipping to $key on {$screen->getKey()}");
					return false;
				}
			}
		}
		function findActiveScreen(){
			// Hmmm.....
			$myScreens = array(true=>array(),false=>array());
			$found=false;
			if(($selected = $this->checkedKey) || ($selected = @$_GET['select-screen'])){
				$screen = $this->findByKey($selected);
				if($screen) return $screen;
			}
			foreach($this->findFutureScreens() as $screen){
				if($screen->isActive()) return $screen;
			}
		}
		function findLastScreen(){
			if(@$_REQUEST['last-screen']) {
				return $this->findByKey($_REQUEST['last-screen']);
			}
			return false;
		}
		function doHTML($context){
			$screen = $this->findScreenFromUrl();
			if($screen){
				$this->used_screen = $screen;
				$screen->markLast();
				$screen->doHTML($context);
				$this->clearSessionInfo();
			}
		}

		function isComplete(){
			$screen = $this->getNextScreen();
			//TODO: Is this right??
			if(!$screen) return true;
			if($screen->isFinal()) return true;
			return false;
		}
		function setParent($parent){
			$this->parent = $parent;
		}

		function getHidden(){
			if($this->parent)
				return $this->parent->getHidden();
			else return array();
		}
		function getHiddenForm(){
			if($this->parent) return $this->parent->getHiddenForm();
			else return "";
		}
		function getKey(){
			if($this->parent)
				return $this->parent->getKey();
			else return "";
		}

		function getBasePath(){
			if(@$this->basePath) return $this->basePath;
			else return "modules/screenflows/".strtolower(get_class($this));
		}
		function getViewDirectories(){
			$origin = dirname(dirname(@$this->params['source_file']));
			$modelName = $this->getBasePath();
			$dirs = cms_apply_filter('get_theme_directories',array());
			foreach($dirs as $k=>$dir){
				$dirs[$k].="/$modelName";
			}
			return $dirs;
		}

		function getNextScreenUrl(){
			$screen = $this->getNextScreen();
			if($screen instanceof SubFlow){
				return $screen->screenFlow->getNextScreenUrl();
			} elseif($screen){
				return $this->urlFor($screen);
			}
		}
		function getNextScreen($after = false){
			$skipped = false;
			$screens = $this->screens;
			if($after) $last = $after;
			else $last=$this->findLastScreen();

			if(@$_REQUEST['next-screen']){
				$next = $this->findByKey($_GET['next-screen']);
				if($next && $next->isActive()) 
					return $next;
			}
			if($last)
			do {
				$test = array_shift($screens);
				if($test==$after){
					break;
				}
				if($test==$last){
					array_unshift($screens,$test);
					break;
				}
			} while($screens);

			foreach($screens as $screen){
				if($screen->isActive()){
					if($this->processed && !$skipped && $screen->canSkip()) $skipped=true;
					else return $screen;
				} 
			}
		}
		function urlFor($screen){
			if(is_string($screen)) $screen = $this->findByKey($screen);
			return "?next-screen=".$screen->getKey();
		}
		function findScreenFromUrl(){
			if($next=@$_GET['next-screen']){
				$next = $this->findByKey($next);
				if($next && $next->isActive()) return $next;
			}
			if($last=@$_REQUEST['last-screen']){
				$screen = $this->findByKey($last);
				if($screen && !$screen->isActive()){
					$screen = $this->getNextScreen($screen);
				}
				return $screen;
			} else {
				$this->initialiseScreenflow();
				foreach($this->screens as $screen){
					if($screen->isActive()) return $screen;
				}
			}
		}
	}

	class Screen extends Component {
		var $paypal = false;
		var $isFinal = false;
		var $processed = false;
		static $count;
		function __construct($name){
			$this->key = $name ? $name : (self::$count++."#".get_class($this));
		}

		function storeSessionInfo(){
			if($this->parent) $this->parent->storeSessionInfo();
		}
		function clearSessionInfo(){
			if($this->parent) $this->parent->clearSessionInfo();
		}

		function preProcess(){
			$this->markLast();
		}
		function isActive(){
			if($this->wasPosted() && !$this->processed) return true;
			return !$this->wasPosted();
		}
		function isFinal(){
			return $this->isFinal;
		}
		function getKey(){
			$key = $this->key;
			if($this->parent && $pref = $this->parent->getKey()){
				$key = "$pref/$key";
			}
			return $key;
		}

		function matchesKey($key){
			return $key==$this->getKey();
		}

		function getHiddenForm(){
			$html='';
			foreach($this->getHidden() as $k=>$v){
				$html.="<input type='hidden' name='$k' id='$k' value='$v'/>";
			}
			return $html;
		}
		function getHiddenLink($params=array()){
			foreach($this->getHidden($params) as $k=>$v){
				$out[]="$k=$v";
			}
			return join("&",$out);
		}
		function setParent($parent){
			$this->parent = $parent;
		}
		function linkTo($params=array()){
			if(is_string($params)) $params=array('next-screen'=>$params);
			return preg_replace('/\?.*$/','',$_SERVER['REQUEST_URI']).'?'.$this->getHiddenLink($params);
		}
		function getHidden($params = array()){
			$hidden = array('last-screen' => $this->getKey());
			if($this->parent) $hidden = array_merge($this->parent->getHidden(),$hidden);
			return array_merge($hidden,$params);
		}
		function markLast(){
			$_GLOBAL['lastScreen'][] = $this->getKey();
//			$_SESSION['lastScreen'] = $_GLOBAL['lastScreen'];
		}
		function wasPosted(){
			if($last = @$_REQUEST['last-screen']) return $this->getKey()==$last;
			return @in_array($this->getKey(),$_SESSION['lastScreen']);
		}
		function process(){
			if($this->wasPosted() && $this->validate()){
				$this->processed=true;
				return $_SESSION['Done'.get_class($this)] = true;
			}
			return false;
		}
		function validate(){
			return true;
		}

		function doHTML(){
			echo "<h1>".get_class($this)."</h1>";
		}

		function getViewDirectories(){
			return $this->parent->getViewDirectories();
		}

		function canSkip(){
			return (!$this->isActive()) || $this->validate();
		}
		function redirectTop(){
			$this->redirectTop=true;
			if($this->parent) $this->parent->redirectTop();
		}
	}
	class ConfirmationScreen extends Screen {
		function __construct($name,$view='screenflow/confirmation',$data = array()){
			parent::__construct($name);
			$this->data = $data;
			$this->view = $view;
			$this->isFinal = true;
		}
		function doHTML($context){
			$this->view($context,$this->view,$this->data);
		}
		function isActive(){
			return true;
		}
	}

	class SubFlow extends Screen {
		function __construct($name,$screenFlow=null){
			parent::__construct($name);
			if(!$screenFlow) $screenFlow = new ScreenFlow();
			$this->screenFlow = $screenFlow;
			$screenFlow->setParent($this);
		}

		function addScreen($screen){
			$this->screenFlow->addScreen($screen);
		}

		function isActive(){
			return !$this->screenFlow->isComplete();
		}
		function process(){
			return $this->preProcess();
		}
		function preProcess(){
			return $this->screenFlow->preProcess();
		}
		function doHTML($context){
			return $this->screenFlow->doHTML($context);
		}
		function debugInfo($extraParams=array()){
			$out = parent::debugInfo($extraParams);
			$out['flow']=$this->screenFlow->debugInfo();
			return $out;
		}
		function matchesKey($key){
			@list($pref,$post) = explode("/",$key,2);
			return ($pref==$this->getKey()) && $this->screenFlow->findByKey($key);
		}
	}
?>
