<?
/**
* @package BozBoz_CMS
*/

	class NewsHooks {
		function __construct(){
			cms_listen_hook('get_module_links',array($this,'add_links'));
			cms_listen_hook('models_loaded',array($this,'load_model'));
			cms_listen_action('components_loaded',$this);
			cms_listen_hook('content_models',array($this,'content_models'));
			cms_register_filter('config_defaults',$this);
			cms_register_filter('cms_menu',$this);
		}
		function config_defaults($config){
			$config['site']['news-homepage-width'] = 278;
			return $config;
		}
		function cms_menu($menu){
			$menu['News'] = @$menu['Articles'];
			unset($menu['Articles']);
			return $menu;
		}
		function add_links($array){
			$array = array_merge(array("Articles" => 'news'),$array);
			return $array;
		}
		function load_model(){
			Model::addModel('News',dirname(__FILE__).'/NewsModel.php');
		}
		function components_loaded(){
			Component::mapClass('NewsArticle',dirname(__FILE__).'/components/NewsArticle.php');
			Component::mapClass('NewsListing',dirname(__FILE__).'/components/NewsListing.php');
			Component::mapClass('NewsFeature',dirname(__FILE__).'/components/NewsFeature.php');
			Component::mapClass('NewsImage',dirname(__FILE__).'/components/NewsImage.php');
		}
		function content_models($array){
			$array[] = "News";
			return $array;
		}
	}
	new NewsHooks();
