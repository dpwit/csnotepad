<?
/**
* @package BozBoz_CMS
*/

	cms_include_module('user');
	class CustomUserHooks {
		function __construct(){
//			cms_register_filter('get_module_links',array($this,'add_links'),false,2);
			cms_listen_action('models_loaded',array($this,'load_model'),false,2);
			cms_register_filter('check_access',array($this,'check_access'),false,2);
			cms_register_filter('cms_user_classes',array($this,'user_classes'));
			cms_listen_action('components_loaded',array($this,'load_components'),false);
			cms_register_filter('config_defaults',$this);
			cms_register_filter('validate_login',$this);
		}
		function config_defaults($config){
			$config['site']['users_require_activation'] = false;
			$config['site']['contact_email'] = "contact@".str_replace("www.","",__SERVER_DOMAIN__);
			return $config;
		}
		function add_links($array){
			unset($array['Manage Users']);
			$array['Users']='userManagement&model=CustomUser';
			return $array;
		}
		function check_access($errors,$action){
			$logged = Model::loadModel('User')->getLoggedInUser();
			if(!$logged){
				$errors['NOT_LOGGED_IN'] = 'You must log in to access the CMS';
			} else {
				$logged->accessErrors($action,$errors);
			}

			$whiteList = array('logout','exit_su');
			if(in_array($action['action'],$whiteList)) {
				return array();
			}
			
			return $errors;
		}
		function load_model(){
			Model::addModel('User',dirname(__FILE__).'/CustomUserModel.php','CustomUser');
			Model::addModel('AdminUser',dirname(__FILE__).'/CustomUserModel.php');
			foreach(cms_call_hook('cms_user_classes',array()) as $user_class){
				extract($user_class);
				Model::addModel($class,$file);
			}
		}
		function user_classes($classes){
			$classes = array_merge($classes,array(
				'admin'=>array('group'=>'Admin',
						'class'=>'AdminUser',
						'file'=>dirname(__FILE__).'/CustomUserModel.php'
					),
				'super_admin'=>array('group'=>'Super Admin',
						'class'=>'SuperAdminUser',
						'file'=>dirname(__FILE__).'/CustomUserModel.php'
					),
			));
			return $classes;
		}
		function load_components(){
			Component::mapClass('Registration',dirname(__FILE__).'/components/RegistrationProcess.php','Registration');
			Component::mapClass('AccountMenu',dirname(__FILE__).'/components/AccountMenu.php','AccountMenu');
			Component::mapClass('RecoverPasswordProcess',dirname(__FILE__).'/components/RecoverPasswordProcess.php','RecoverPasswordProcess');
			Component::mapClass('EditProfile',dirname(__FILE__).'/components/RegistrationProcess.php');
			Component::mapClass('ChangePassword',dirname(__FILE__).'/components/RegistrationProcess.php','PasswordChangeProcess');
			Component::mapClass('LoginBox',dirname(__FILE__).'/components/LoginBox.php');
			Component::mapClass('QuickRegistration',dirname(__FILE__).'/components/RegistrationProcess.php');
		}
		function validate_login($numRows,$data,$model){
			if($model->usergroup() && $model->usergroup()->canCMS()) return $numRows;
			return false;
		}
	}
	new CustomUserHooks();
?>
