<?
	class NotificationHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this);
			cms_register_filter('cms_landing_page',$this);
		}
		function models_loaded(){
			Model::addModel('Notification',dirname(__FILE__).'/models/class.CMSNotification.php','CMSNotification');
			Model::addModel('CMS_Notification',dirname(__FILE__).'/models/class.CMSNotification.php','CMSNotification');
			Model::addModel('CMSNotification',dirname(__FILE__).'/models/class.CMSNotification.php','CMSNotification');
		}
		function cms_landing_page(){
			return "overview.php?pageType=cms_notifications";
		}
	}
	new NotificationHooks;
?>
