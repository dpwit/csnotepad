<?
/**
* @package Boz_Orders
*/

	class PayPalFormHooks {
		function __construct(){
			cms_register_filter('get_payment_gateways',$this,false,200);
//			cms_register_filter('get_test_suites',array($this,'test_test_suite'),dirname(__FILE__).'/class.PayPalFormsTestSuite.php',-5);
			cms_register_filter('handle_url',array($this,'ipn'));
			cms_register_filter('config_defaults',$this);
			cms_listen_action('models_loaded',array($this,'load_model'));
		}	
		function test_test_suite($suites){
			$suites[] = new PayPalFormsTestSuite();
			return $suites;
		}
		function load_model(){
			Model::addModel('IPN',dirname(__FILE__).'/IPNModel.php');
		}
		function get_payment_gateways($gateways){
			require_once(dirname(__FILE__).'/PayPalFormsGateway.php');
			$gateways[] = new PayPalFormsGateway();
			return $gateways;
		}
		function config_defaults($config){
			$config['paypal']['account_email'] = 'don_1275409053_biz@don-benjamin.co.uk';
			$config['paypal']['live'] = '0';
			$config['orders']['paypalforms_minimum_checkout']=10;
			return $config;
		}
	}
	new PayPalFormHooks;
?>
