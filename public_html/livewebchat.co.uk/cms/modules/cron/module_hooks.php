<?
/**
* @package BozBoz_CMS
*/

	class CronHooks {
		function __construct(){
			cms_listen_action('models_loaded',array($this,'add_models'));
		}

		function add_models(){
			Controller::addController('CronController',dirname(__FILE__).'/class.CronController.php');
		}
	}
	new CronHooks;
?>
