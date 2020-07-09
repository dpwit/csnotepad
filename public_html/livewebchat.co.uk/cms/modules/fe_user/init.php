<?
/**
* @package Elite_FE
*/

	class FEUserHooks {
		function __construct(){
			cms_register_filter('cms_user_classes',array($this,'user_classes'),false,10);
			cms_listen_action('models_loaded',array($this,'override_user'),false,50);
			cms_listen_action('front_end_init',array($this,'fe_mode'));
			cms_register_filter('config_defaults',$this);
		}
		function config_defaults($config){
			$config['site']['registration_email'] = "registration@".str_replace("www.","",__SERVER_DOMAIN__);
			return $config;
		}
		function even_odd_rows($class,$model){
			$this->count++;
			return $class.($this->count%2?" odd":" even");
		}
		function fe_mode(){
			$user = Model::loadModel('FEUser');
			require_once(dirname(__FILE__).'/FEUser.php');
			FEUser::$fe = true;
			$user->checkLogin();
		}
		function user_classes($classes){
			$classes = array_merge($classes,array(
				'fe'=>array('group'=>'Anonymous','model'=>'FEUser'),
			));
			return $classes;
		}

		function override_user(){
			Model::addModel('User',dirname(__FILE__).'/FEUser.php','FEUser');
			Model::addModel('FEUser',dirname(__FILE__).'/FEUser.php','FEUser');
		}
	}
	new FEUserHooks();
?>
