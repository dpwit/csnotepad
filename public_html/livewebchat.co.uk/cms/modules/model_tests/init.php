<?
/**
* @package BozBoz_CMS
*/

	class ModelTestHooks {
		function __construct(){
			cms_register_filter('get_test_suites',array($this,'test_suite'),dirname(__FILE__).'/class.ModelSystemTestSuite.php',-25);
			cms_register_filter('model_listing_row_class',$this);
		}
		function model_listing_row_class($class,$model){
			$this->count++;
			return $class.($this->count%2?" odd":" even");
		}

		function test_suite($suites){
			$suites[] = new ModelSystemTestSuite();
			return $suites;
		}
	}
	new ModelTestHooks();
?>
