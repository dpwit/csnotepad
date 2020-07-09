<?
	class FEHooks {
		function __construct(){
			cms_listen_action('handle_front_end',$this);
			cms_register_filter('config_defaults',$this);
			cms_listen_action('models_loaded',$this);
			cms_register_filter('get_theme_directories',$this,false,30);
		}

		function handle_front_end(){
			$ext = preg_replace("/^.*\./","",$_SERVER['REQUEST_URI']);
			if(in_array($ext,array('jpeg','jpg','css','gif','png','js','ico','swf'))) {
				header("HTTP/1.1 404 File Not Found");
				die();
			}

			require_once(dirname(__FILE__).'/FEContext.php');
			$context = Factory::newInstance('RenderingContext');
			$context->render();
		}
		function config_defaults($config){
			$config['site']['copyright'] = '&copy; 2010 BozBoz';
			$config['site']['title'] = 'New Content Managed Site';
			return $config;
		}

		function models_loaded(){
			Factory::mapClass('RenderingContext',array('class'=>'FEContext','file'=>dirname(__FILE__).'/FEContext.php'));
		}

		function get_theme_directories($dirs){
			foreach($dirs as $k=>$v){
				$dirs[$k] = str_replace("cms/fe-themes","themes",$v);
			}
			return $dirs;
		}
	}

	new FEHooks;
?>
