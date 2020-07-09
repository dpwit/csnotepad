<?
	class ErrorReportingHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this,false,1000);
			cms_register_filter('config_defaults',$this);
		}
		function dump_error($severity,$message,$file,$line){
			if(!Config::value('ignore_suppression') && !error_reporting()) return;
			$allowed = 2570;
			if(!($severity&~$allowed)){
				var_dump($message);
				return;
			}
			var_dump(func_get_args());
			die();
		}
		function config_defaults($config){
			$config['error_reporting']['ignore_suppression'] = 0;
			return $config;
		}
		function models_loaded(){
			set_error_handler(array($this,'dump_error'));
		}
	}
	new  ErrorReportingHooks;
?>
