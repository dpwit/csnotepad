<?
/**
* @package BozBoz_CMS
*/

	class UnitTestHooks {
		function __construct(){
			cms_listen_action('models_loaded',array($this,'load_model'));
			cms_register_filter('get_test_suites',array($this,'test_test_suite'),dirname(__FILE__).'/class.UnitTestTestSuite.php',-5);
		}
		function load_model(){
			Controller::addController('TestController',dirname(__FILE__).'/class.TestController.php');
		}

		function test_test_suite($suites){
			$suites[] = new UnitTestTestSuite();
			return $suites;
		}
	}
	new UnitTestHooks();
?>
