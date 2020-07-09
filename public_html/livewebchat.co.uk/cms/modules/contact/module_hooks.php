<?
/**
* @package BozBoz_CMS
*/

	class ContactHooks {
		function __construct(){
			cms_register_filter('cms_menu',$this);
			cms_listen_action('models_loaded',array($this,'load_model'));
			cms_register_filter('config_defaults',$this);
			cms_listen_action('render_config_contact.email',array($this,'caching_config'));
			cms_listen_action('save_config',array($this,'save_config'));
		}
		function config_defaults($config){
			$config['site']['admin-email'] = 'don@bozboz.co.uk';
			return $config;
		}
		function caching_config($value){
			echo "<input name='contact.email' value='".htmlspecialchars($value,ENT_QUOTES)."'/>";
		}
		function save_config(){
			Model::loadModel('Config')->setConfig('contact.email',$_POST['contact_email']);
		}
		function cms_menu($array){
		//	$array['Modules']['Contact Forms'] = "overview.php?pageType=contact";
			return $array;
		}
		function load_model(){
			Model::addModel('Contact',dirname(__FILE__).'/ContactModel.php');
		}
	}
	new ContactHooks();
?>
