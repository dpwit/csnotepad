<?
/**
* @package Elite_Promo
*/

	class ComponentHooks {
		function __construct(){
			cms_listen_action('front_end_init',array($this,'load_components'));
			cms_listen_action('fe_template_footer',$this);
			cms_listen_action('fe_template_head',$this);
			cms_register_filter('config_defaults',$this);
		}
		function load_components(){
			require_once(dirname(__FILE__).'/DefaultComponents.php');
			Component::mapClass('TextComponent');
			Component::mapClass('PageComponent');
			Component::mapClass('Menu');
			Component::mapClass('BreadCrumb');
			Component::mapClass('FileInclude');
			Component::mapClass('AlternateContent');
			Component::mapClass('PageMenu');
			Component::mapClass('Text',false,'TextComponent');
			Component::mapClass('CompositeComponent');
			Component::mapClass('PaginatedTable',dirname(__FILE__).'/Table.php');
			cms_trigger_action('components_loaded');
		}

		function fe_template_footer($template){
			if($this->showDebug()){
				include(dirname(__FILE__).'/template/debugInfo.php');
			}
		}
		function fe_ajax_footer($template){
			if($this->showDebug()){
				include(dirname(__FILE__).'/template/debugInfo.php');
			}
		}
		function showDebug(){
			return (Config::value('debug','site') && (@$_SESSION['uid']));
		}
		function fe_template_head($template){
			if($this->showDebug()){
?>
	<link rel='stylesheet' type='text/css' href='/cms/modules/components/template/debug.css'/>
<?
			}
		}
		function config_defaults($config){
			$config['site']['debug'] = 1;
			$config['site']['can_ssl'] = 1;
			$config['site']['always_ssl'] = 0;
			return $config;
		}
	}
	new ComponentHooks;
?>
