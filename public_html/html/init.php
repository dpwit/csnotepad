<?
	require_once(dirname(__FILE__).'/../themes/mp3store/init.php');
	class DefaultStoreThemeHooks {
		function __construct(){
			cms_register_filter('get_theme_directories',$this,false,20);
			cms_listen_action('fe_logged_out',$this);
			cms_listen_action('fe_template_head',$this);
		}
		function get_theme_directories($directories){
			$directories[] = dirname(__FILE__);
			return $directories;
		}
		function fe_logged_out($user){
			$_SESSION['messages'] = 'You have been logged out';
		}
		function fe_template_head(){
		}
	}
	new DefaultStoreThemeHooks();
?>
