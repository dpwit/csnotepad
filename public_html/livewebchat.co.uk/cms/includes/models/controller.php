<?
/**
* @package Model_System
*/

	require_once(dirname(__FILE__).'/viewable.php');
	class Controller extends Viewable {
		static $controllers;
		static $instance;
		static $origins;
		static function addController($name,$file,$class=false){
			Factory::mapClass($name,array('file'=>$file,'class'=>$class));
			cms_listen_hook('handle_overview_'.strtolower($name),array(get_class(),'static_cms_overview'));
			cms_listen_hook('handle_despatch_'.strtolower($name),array(get_class(),'static_cms_despatch'));
		}
		static function getInstance($key=''){
			if(!$key) $key='Controller';
			try {
				return Factory::getInstance($key);
			} catch(NoMappingException $e){
				if($key=='Controller') {
					Factory::mapClass($key,'Controller');
					return Factory::getInstance($key);
				} else throw $e;
			}
		}

		function static_cms_overview($handled,$args){
			$args['action'] = 'index';
			return self::static_cms_despatch($handled,$args);
		}
		function static_cms_despatch($handled,$args){
			extract($args);
			if(!$action) $action='index';
			if($action != 'index') $action="cms_$action";
			$controller = self::getInstance(Model::unpluralize($modelName));
			$controller->$action($args);
			return true;
		}

		function getPageType(){
			return basename(dirname($this->getOrigin()));
		}
		function getModelName(){
			return get_class($this);
		}
		function getTableName(){
			return strtolower($this->getModelName());
		}
		function findView($view){
			return BozModel::findView($view);
		}
		function getViewDirectories(){
			return BozModel::getViewDirectories();
		}
		function applyFilters($key,$value,$value2=false,$value3=false,$value4=false){
			return BozModel::applyFilters($key,$value,$value2,$value3,$value4);
		}
		function getKeysForHooks($v){
			return BozModel::getKeysForHooks($v);
		}
		function getModelNamesForHooks(){
			return BozModel::getModelNamesForHooks();
		}
		functioN __call($func,$args){
			return call_user_func_array(array('BozModel',$func),$args);
		}

	}

	cms_trigger_action('controllers_loaded');
?>
