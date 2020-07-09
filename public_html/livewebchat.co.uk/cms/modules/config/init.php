<?
	class ConfigHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this);
			cms_register_filter('cms_menu',$this);
			cms_register_filter('valid_modules',$this);
			cms_register_filter('config_defaults',$this);
			cms_register_filter('default_fck_toolbar',$this);
		}

		function models_loaded(){
			global $CONFIG;
			Model::addModel('Config',dirname(__FILE__).'/class.Config.php','Config');
//			Model::addModel('Update_Flag',dirname(__FILE__).'/class.UpdateFlagModel.php','UpdateFlagModel');
			$m = Model::loadModel('Config');

			$CONFIG = cms_apply_filter('config_defaults',array(''=>array()));
			foreach($CONFIG as $k=>$v){
				$CONFIG[''] = array_merge($CONFIG[''],$v);
			}

			try {
				$q = $m->getAll(array(),array('for_fetch'=>true));
				while($r = $q->fetch()){
					if(array_key_exists($r->section,$CONFIG) && array_key_exists($r->key,$CONFIG[$r->section]))
						$CONFIG[$r->section][$r->key] = $CONFIG[''][$r->key] = $r->value;
				}
			} catch(DBException $e){
				trigger_error('Loading of config failed '.$e->getMessage());
			}
		}

		function cms_menu($menu){
			$user = Model::loadModel('User')->getLoggedInUser();
			$config = $GLOBALS['CONFIG'];
			foreach($config as $k=>$items){
				if(!$k) continue;
				if(check_access('config',$k))
					$menu['Config'][ucwords($k)]="overview.php?model=Config&page=$k";
			}
			return $menu;
		}

		var $internal = false;
		function config_defaults($config){
			$this->internal = true;
			$modules = cms_get_modules();
			sort($modules);

			foreach($modules as $module){
				$path = cms_module_resolve($module,'optional.txt');
				if($module=='config') continue;
				$config['modules'][$module] = file_exists($path) ? 0 : 1;
			}

			$config['site']['date_format']='Y-m-d';
			$config['cms']['wysiwyg_toolbar']='Basic';

			$this->internal = false;
			return $config;
		}

		function valid_modules($modules){
			if($this->internal) return $modules;
			$q = mysql_query("SELECT * FROM config");
			$done = array();
			while($r = @mysql_fetch_assoc($q)){
				if(($r['section']=='modules')&&(!$r['value'])){
					$index = array_search($r['key'],$modules);
					if(is_numeric($index)) unset($modules[$index]);
				}
				if($r['section'] == 'modules')
					$done[$r['key']] = true;
			}
			foreach($modules as $k=>$v){
				if((!@$done[$v]) && file_exists(cms_module_resolve($v,'optional.txt'))) unset($modules[$k]);
			}
			return $modules;
		}
		function default_fck_toolbar($toolbar){
			return $GLOBALS['CONFIG']['cms']['wysiwyg_toolbar'];
		}
	}

	new ConfigHooks;
?>
