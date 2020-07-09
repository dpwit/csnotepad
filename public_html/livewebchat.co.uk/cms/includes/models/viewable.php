<?
	/** This class includes some generic stuff useful for cms managed objects.
	 *
	 * e.g. functionality for generating urls, functionality for rendering views based
	 * on template directories, functionality for triggering actions/hooks.
	 */
	class Viewable {
		function __construct(){
			$this->modelName = preg_replace('/model$/i','',get_class($this));
			$this->modelNames[] = strtolower($this->modelName);
			$this->setView('index');
		}
		var $autoRender = true, $autoView='index';
		var $viewData = array();
		function despatch($function,$args){
			$this->autoView=$function;
			call_user_func(array($this,"cms_$function"),$args);
			if($this->autoRender) $this->autoRender();
		}
		function autoRender(){
			$this->showView($this->autoView,$this->getViewData());
		}
		function getViewData(){
			return $this->viewData;
		}
		function setView($view){
			$this->autoView=$view;
		}
		static $origins;
		function setOrigin($file){
			self::$origins[get_class($this)] = $file;
		}
		function getOrigin(){
			return @self::$origins[get_class($this)];
		}

		function setModelName($name){
			$this->modelName = $name;
		}
		function getModelName(){
			return $this->modelName;
		}
		function getEnglishName($plural=true){
			return $this->getModelName($plural);
		}
		function getPageType(){
			return basename(dirname($this->getOrigin()));
		}

		function getViewDirectories(){
			$views=array();
			$origin = dirname($this->getOrigin());
			foreach($this->getModelNamesForHooks() as $name){
				$views[] = "$origin/views/".strtolower($name);
			}
			$views[] = dirname(__FILE__).'/boz/views/default';
			$views[] = dirname(__FILE__).'/views/default';
			$views = $this->applyFilters('view_dirs',$views);
			return $views;
		}
		function getKeysForHooks($key){
			$keys = array($key);
			foreach($this->getModelNamesForHooks() as $name){
				$keys[] = $key."_".$name;
			}
			return $keys;
		}
		function addModelNameForHooks($name){
			$this->modelNames[] = strtolower($name);
		}
		function getModelNamesForHooks(){
			return $this->modelNames;
		}
		function showView($view,$params=array()){
			$this->autoRender = false;
			$model = $this;
			foreach($this->getViewDirectories() as $dir){
				if(file_exists($file = "$dir/$view" ) || file_exists($file="$file.php")){
					if($params)
						extract($params);
					include($file);
					return;
				}
			}
			throw new Exception("Could not find view ".strtolower(get_class($this)).".$view");

		}

		function urlFor($action,$params=array()){
			$pageType = $this->getPageType();
			$params['action'] = $action;
			$string='';
			foreach($params as $k=>$v){
				$string.="&".urlencode($k)."=".urlencode($v);
			}
			return "despatch.php?pageType=$pageType&model=".$this->getModelName(false).$string;
		}

		function triggerAction($key){
			$args = func_get_args();
			$key = array_shift($args);
			if(method_exists($this,$f = "on_$key")){
				call_user_func_array(array($this,$f),$args);
			}
			array_unshift($args,$this);
			foreach($this->getKeysForHooks($key) as $key) {
				$args2 = $args;
				array_unshift($args2,$key);
				call_user_func_array('cms_trigger_action',$args2);
			}
		}
		function applyFilters($key,$arg1){
			$args = func_get_args();
			$key = array_shift($args);
			if(method_exists($this,$f = "filter_$key")){
				$arg1 = call_user_func_array(array($this,$f),$args);
			}
			array_shift($args);
			array_unshift($args,$this);
			foreach($this->getKeysForHooks($key) as $key) {
				$args2 = $args;
				array_unshift($args2,$arg1);
				array_unshift($args2,$key);
				$arg1 = call_user_func_array('cms_apply_filter',$args2);
			}
			return $arg1;
		}
	}
?>
