<?
	require_once(dirname(__FILE__).'/../default/init.php');
	class MP3StoreThemeHooks {
		function __construct(){
			cms_register_filter('get_theme_directories',$this,false,10);
			cms_listen_action('fe_template_head',$this);
		}
		function get_theme_directories($directories){
			$directories[] = dirname(__FILE__);
			return $directories;
		}
		function fe_template_head(){
?>
	<script src='/themes/mp3store/js/mp3store.js'></script>
<?
		}
	}
	new MP3StoreThemeHooks();
?>
