<?
/**
* @package BozBoz_CMS
*/

	class PageHooks {
		function __construct(){
			//cms_listen_hook('get_module_links',array($this,'add_links'));
			cms_register_filter('cms_menu',$this,false,10);
			cms_listen_hook('models_loaded',array($this,'load_model'));
			cms_listen_hook('content_classes',array($this,'content_classes'));
			cms_register_filter('categorise_modules',$this);
			cms_register_filter('cms_actions_page',$this);
			cms_register_filter('cms_section_name',$this);
			cms_register_filter('config_defaults',$this);
		}

		function config_defaults($config){
			$config['site']['allow_delete_pages'] = true;
			return $config;
		}
		function cms_section_name($section,$model){
			if($model instanceof Page) return 'Pages';
			return $section;
		}
		function add_links($array){
			//$array = array_merge(array("Pages" => 'pages'),$array);
			return $array; 
		}
		function load_model(){
			Model::addModel('Page',dirname(__FILE__).'/PageModel.php');
		}
		function content_classes($array){
			array_push($array,'Page');
			return $array;
		}
		function categorise_modules($modules){
			$modules['Content'] = array('Pages','News','Articles','Links');
			return $modules;
		}
		function cms_menu($menu){
			$menu['Pages']['View All Pages'] = "overview.php?model=Page&section=Page";
			$menu['Pages']['New Page'] = "newItem.php?model=Page&section=Page";
			return $menu;
		}
		function cms_actions_page($actions,$page){
			if(!Config::value('allow_delete_pages'))
				foreach($actions as $k=>$v) 
					if($v=='Delete') 
						unset($actions[$k]);
			return $actions;
		}
	}
	new PageHooks();
?>
