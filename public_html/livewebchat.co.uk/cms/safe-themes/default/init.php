<?
	class DefaultThemeHooks {
		function __construct(){
			cms_register_filter('get_theme_directories',$this,false,0);
		}
		function get_theme_directories($directories){
			$directories[] = dirname(__FILE__);
			return $directories;
		}
	}
	new DefaultThemeHooks();
?>
