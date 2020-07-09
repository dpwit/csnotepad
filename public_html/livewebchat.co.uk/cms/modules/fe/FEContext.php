<?
	cms_module_require('components','DefaultComponents.php');
	
	class NoSuchTemplateException extends Exception{}
	class FEContext extends Viewable{ 
		public $pageTitle = false;
		public $metaDescription = false;
		public function setTitle($pageTitle){ $this->pageTitle = $pageTitle; }
		public function setDescription($metaDescription){ $this->metaDescription = $metaDescription; }
		
		static $globalUrls = array();
		static function recursivelyPairStrings($urls,$base){
			$safe_list = array('func');
			foreach($urls as $k=>$v){
				if(in_array($k,$safe_list)) continue;
				if(is_string($v)) $urls[$k] = array($base,$v);
				if(is_array($v)) $urls[$k] = self::recursivelyPairStrings($v,$base);
				if($v instanceof CanSetBase) $v->setBase($base);
			}
			return $urls;
		}
		static function addUrls($urls,$baseDir){
			$baseDir = "$baseDir";
			$urls = self::recursivelyPairStrings($urls,$baseDir);
			self::$globalUrls = self::mergeUrls(self::$globalUrls,$urls);
		}
		static function mergeUrls($u1,$u2){
			foreach($u1 as $k=>$v){
				if(@$u2[$k]){
					switch($k){
					case 'catchall':
						if(!$v instanceof OneOfPage){
							$u1[$k] = new OneOfPage(array($v));
						}
						$u1[$k]->addPage($u2[$k]);
						break;
					default:
						$u1[$k] = self::mergeUrls($v,$u2[$k]);
					}
					unset($u2[$k]);
				}
			}
			foreach($u2 as $k=>$v){
				$u1[$k]=$v;
			}
			return $u1;
		}
		function render(){
			$url = @$_SERVER['SCRIPT_URL'];
			if(!$url) {
				$url=urldecode($_SERVER['REQUEST_URI']);
				@list($url,$qstring) =explode("?",$url);
			}
			error_log("PHP Handling $url");

			foreach(cms_get_modules() as $module){
				cms_module_include($module,'urls.php');
			}
			$url = preg_replace("#/$#","",$url);
			$url = preg_replace("#\.html$#","",$url);
			if(!$url) $url='/home';
			if($url=='/index.php') $url='/home';
			$url = $this->applyFilters('raw_url',$url);

			$parts = $orig_parts = explode("/",$url);
			array_shift($parts);
			$parts = $this->applyFilters('url_parts',$parts);
			$current =  self::$globalUrls;

			while(!is_null($section = array_shift($parts))){
				if(!$section) continue;
				$next = @$current[$section];
				if(!$next) {
					array_unshift($parts,$section);
					break;
				}
				$current = $next;
			}
			$last = $current;

			if(is_array($last) && @$last['func']){
				$f = $last['func'];
				call_user_func($f,$this,$parts);
				return;
			}
			if($parts && @$last['catchall']){
				$last = $last['catchall'];
			}
			if(is_array($last) && @$last['base']) $last = @$last['base'];
			if(is_array($last) && is_array($last[0])) $last = $last[0];

			if(!$last) $last = $url;
			if(!$this->renderPage($last,array('trailing'=>$parts,'full'=>$url))  && !cms_apply_filter('front_end_404',false)){
				error_log("PHP Handling 404 for $_SERVER[REQUEST_URI]");
				$this->renderPage("404.php",array('trailing'=>$parts,'full'=>$url));

				error_log("PHP Handled 404 for $_SERVER[REQUEST_URI]");
			}
		}

		function renderPage($urlOrObject,$params=array()){
			$path = null;
			if(is_array($urlOrObject)){
				list($base,$path) = $urlOrObject;
			} 
			if(is_string($urlOrObject)){
				$path = $urlOrObject;
			}
			if($path) {
				$myFile = $urlOrObject;
				extract($params);
				$init = $this->findTemplate("templates/init");

				$context =$this;
				$page = $this->findTemplate("pages/".@basename($base)."/$path");
			//	if(!file_exists($page)) $page = $this->findTemplate("content/pages/$path",$base);
				include($init);
				try {
					$init2 = $this->findTemplate("pages/".@basename($base)."/init");
					include($init2);
				} catch(Exception $e){}
				$return = include($page);
				$template->params['page_file'] = $page;
				$this->requireSSL($template->requiresSSL());
				if($return) {
					$template->preProcess();
					$template->doHTML($this);
				}
				return $return;
			}

			if(is_object($urlOrObject)){
//				$this->requireSSL($urlOrObject->requiresSSL());
				return $urlOrObject->render($this,$params['trailing']);
			}
		}
		function requireSSL($on=true){
                        $on = $on || Config::value('always_ssl','site');
                        $on = $on && Config::value('can_ssl','site');
			$need = $on;
			$have = @$_SERVER['HTTPS'];
			if($need xor $have){
				$port = '';
				if($need){
					$proto = "https";
					if(defined('__HTTPS_PORT__') && (__HTTPS_PORT__!=443)) $port = ":".__HTTPS_PORT__;
				} else {
					$proto = "http";
					if(defined('__HTTP_PORT__') && (__HTTP_PORT__!=80)) $port = ":".__HTTP_PORT__;
				}
				error_log("Location: $proto://".__SERVER_DOMAIN__.$port.$_SERVER['REQUEST_URI']);
				header("Location: $proto://".__SERVER_DOMAIN__.$port.$_SERVER['REQUEST_URI']);
				die();
			}
		}
		static function forFunc($modelName,$modelPage,$where=array(),$params=array()){
			return new PageForFunc($modelName,$modelPage,$where,$params);
		}
		static function forModel($modelName,$modelPage,$where=array(),$params=array()){
			if(!$where) $where=array();
			return new PageForModel($modelName,$modelPage,$where,$params);
		}
		static function staticFile($file){
			return new StaticFile($file);
		}

		var $params = array();
		function pushParams($params){
			$this->param_stack[] = $this->params;
			if($params)
				$this->params = array_merge($this->params,$params);
		}

		function popParams(){
			$this->params = array_pop($this->param_stack);
		}

		function getThemeDirs(){
			static $dirs;
			if(!$dirs){
				$dirs = cms_apply_filter('get_theme_directories',array());
			}
			return $dirs;
		}
		function showTemplate($template,$params=array()){
			extract($params);
			include($this->findTemplate($template));
		}
		function findTemplate($template,$defaultsDir=false){
			$found=false;
			if($defaultsDir){
				if(!is_array($defaultsDir)) $defaultsDir=array($defaultsDir);
			} else {
				$defaultsDir = array();
			}
			$debug = array('View'=>$template);

			$themes = $this->getThemeDirs();

			$dirs = array_merge($defaultsDir,$themes);
			$dirs = array_reverse($dirs);


			if(!strpos($template,".php"))
				$template.=".php";

			foreach($dirs as $d){
				if(file_exists($file = "$d/$template")){
					$found=$file;
					break;
				}
			}
			$debug['Found View'] = $found;
			$debug['Search Path'] = $dirs;
			self::$views[] = $debug;
			if($found) return $found;
			throw new NoSuchTemplateException("Could not find template $template");
		}
		function getHeaders($template){
			return cms_apply_filter('fe_headers',$template->getHeaders());
		}

		static $views;
	}
	interface Renderable {
		public function render($context,$extraUrl);
	}
	interface CanSetBase {
		public function setBase($base);
	}
	class OneOfPage implements Renderable, CanSetBase {
		function __construct($pages){
			$this->pages = $pages;
		}
		function addPage($page){
			$this->pages[] = $page;
		}
		function render($context,$extraUrl){
			foreach($this->pages as $page){
				if($page->render($context,$extraUrl)) return true;
			}
			return false;
		}
		function setBase($base){
			$this->base = $base;
			foreach($this->pages as $page) $page->setBase($base);
		}
	}
	class PageForModel implements Renderable, CanSetBase {
		function __construct($modelName,$file,$where=array(),$params=array()){
			$this->modelName = $modelName;
			$this->file = $file;
			$this->where = $where;
			$this->params = $params;
		}

		function findInstance($context,$extraUrl){
			$factory = Model::loadModel($this->modelName);
			$slug = join("/",$extraUrl);
			$instance = $factory->getBySlug("/".$slug,$this->where,$this->params);
			return $instance;
		}
		function render($context,$extraUrl){
			$instance = $this->findInstance($context,$extraUrl);
			if(!$instance) return false;
			BreadCrumb::setBreadCrumb($instance);
			$context->renderPage(array($this->base,$this->file),array('item'=>$instance,strtolower($this->modelName)=>$instance));
			return true;
		}
		function setBase($base){
			$this->base = $base;
		}
	}
	class PageForFunc extends PageForModel {
		function findInstance($context,$extraUrl){
			return call_user_func($this->modelName,$context,$extraUrl);
		}
	}
	class StaticFile implements Renderable {
		function __construct($file){
			$this->file=$file;
		}
		function render($context,$extraUrl){
			include($this->file);
			return true;
		}
	}
?>
