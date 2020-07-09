<?
/**
* @package Elite_Promo
*/

	class Component {
		function __construct($view=false,$params=array()){
			$this->view=$view;
			$this->params = $params;
		}
		var $visible = true;
		function isVisible(){
			return $this->visible;
		}
		function stripDocRoot($p){
			if(is_string($p)) {
				$p = preg_replace("_/[^/]*/\.\._","",$p);
				return str_replace($_SERVER['DOCUMENT_ROOT'],'~',$p);
			} else if(is_array($p)){
				foreach($p as $k=>$v){
					$p[$k] = $this->stripDocRoot($v);
				}
				return $p;
			} elseif($p instanceof Model){
				$p = array( '__class'=>get_class($p),'__label'=>$p->getModelName()."#".$p->getId()." '".$p->getLabel()."'",'obj'=>$p);
			}
			return $p;
		}
		function debugInfo($extraParams = array()){
			if(!$this->params) $this->params = array();
			if(@$this->shown_views)
				$extraParams['used_views'] = $this->shown_views;
			$p = array_merge($this->params,$extraParams);
			$p = $this->stripDocRoot($p);
			return array_merge(array('__class'=>get_class($this)),$p);
		}
		function getCacheKey(){
			throw new Exception("Uncachable");
		}

		function getHeaders(){
			return array();
		}

		function getHTML($context){
			ob_start();
			$this->doHTML($context);
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}
		function doHTML($context){
			if($this->view) $this->view($context,$this->view,$this->params);
			else echo "<h1>DUMMY CONTENT</h1>";
		}

		static $class_map = array();
		static function mapClass($name,$file=false,$class=false){
			Factory::mapClass("component_$name",array('file'=>$file,'class'=>$class?$class:$name));
		}
		static function get($name,$args=array(),$args2=array(),$args3=array()){
			return Factory::newInstance("component_$name",$args,$args2,$args3);
		}

		function getTemplateDirs(){
			static $dirs = array();
			if(!$dirs){
				$dirs = array_reverse(cms_apply_filter('get_theme_directories',array()));
				$dirs[] = $_SERVER['DOCUMENT_ROOT'].'/themes/elite';
				$modules = cms_get_module_directories();
				foreach($modules as $ext){
					$d = opendir($ext);
					while($dir = readdir($d)){
						if(is_dir("$ext/$dir/template"))
							$dirs[] = "$ext/$dir/template";
					}
				}
			}
			return $dirs;
		}
		
		function getView($context,$path,$data=array()){
			ob_start();
			$this->view($context,$path,$data);
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}
		function view($context,$path,$data=array()){
			$absolute_name = $context->findTemplate($path);
			$this->shown_views[] = array('file'=>$absolute_name,'data'=>$data);
			extract($data);
			include($absolute_name);
		}
		function findTemplate($orig){
			if(is_file($orig)) return $orig;
			$path="$orig.php";
			$debug = array();
			foreach($this->getTemplateDirs() as $dir){
				if(is_file($absolute_name = "$dir/$path")){
					$found= $absolute_name;
					break;
				}
			}
			FEContext::$views[] = array(
				"View"=>$orig,
				"Found"=>@$found,
				"Dirs"=>($this->getTemplateDirs())
			);
			if(@$found) return $found;
			throw new Exception("No View $orig");
		}
		var $params = array();
		function param($key,$default = null){
			return array_key_exists($key,$this->params) ? $this->params[$key] : $default;
		}
		function requiresSSL(){
			return false;
		}

		function preProcess(){
		}
	}

	class CompositeComponent extends Component {
		var $visible_components = array();
		var $components = array();
		var $template_file = false;
		function __construct($template_file=false){
			if(!$template_file) $template_file="structure/component_list";
			$this->template_file=$template_file;
		}

		function debugInfo($extraParams=array()){
			$extraParams['template_file']=$this->template_file;
			$out = parent::debugInfo($extraParams);
			foreach($this->components as $index =>$item){
				if(@$this->rendered && !@$this->rendered[$index]) continue;
				$out['child'][$index]=$item->debugInfo();
				$this->visible_components[$index] = $item;
			}
			return $this;
			return $out;
		}
		function addComponent($component){
			if(!is_array($component)){
				$component = array($component);
			}
			foreach($component as $component){
				$this->components[] = $component;
			}
		}
		function clearComponents(){
			$this->components = array();
		}
		function getCacheKey(){
			foreach($this->components as $v){
				$key.=$v->getCacheKey();
			}
			return $key;
		}

		function getHeaders(){
			$headers = array();
			foreach($this->components as $v){
				$headers = array_merge($headers,$v->getHeaders());
			}
			return $headers;
		}

		function doHtml($context){
			if(!is_file($this->template_file)){
				$this->template_file=$context->findTemplate($this->template_file);
			}
			$this->last_context = $context;
			$context->pushParams($this->params);
			extract($context->params);	
			$components = $this->components;
			include($this->template_file);
			$context->popParams();
		}
		function requiresSSL(){
			foreach($this->components as $k=>$v){
				if($v->requiresSSL()) return true;
			}
			return false;
		}
		function preProcess(){
			foreach($this->components as $v) $v->preProcess();
		}
	}

	class TemplateComponent extends CompositeComponent {
		function __construct($template_file=false){
			if(!$template_file) $template_file="template";
			parent::__construct($template_file);
		}
		var $params = array();
		function setTemplate($template){
			$this->template_file=$template;//$this->findTemplate($template);
		}
		function addAlias($from,$to){
			$this->alias[$from]=$this->resolveAlias($to);
		}

		function resolveAlias($from){
			return (@$this->alias[$from]) ? $this->alias[$from] : $from;
		}

		function getComponent($section){
			$section = $this->resolveAlias($section);
			if(!@$this->components[$section]) $this->components[$section] = new CompositeComponent;
			return $this->components[$section];
		}
		function clearSection($section){
			$section = $this->resolveAlias($section);
			$this->components[$section] = new CompositeComponent();
		}
		function addInclude($file,$section='main'){
			$section = $this->resolveAlias($section);
			$this->getComponent($section)->addComponent(Component::get('FileInclude',$file));
		}
		function addComponent($component,$section='main'){
			$section = $this->resolveAlias($section);
			$this->getComponent($section)->addComponent($component);
		}
		function renderComponent($section,$params=array()){
			$context=$this->last_context;
			$this->rendered[$section] = true;
			$context->pushParams($params);
			$this->getComponent($section)->doHTML($context);
			$context->popParams();
		}
	}

	cms_trigger_action('components_loaded');
?>
