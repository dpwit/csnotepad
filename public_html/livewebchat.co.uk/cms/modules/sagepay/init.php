<?
/**
* @package Boz_Orders
*/
	cms_require_module('orders');

	class SagePayHooks {
		function __construct(){
			cms_register_filter('get_payment_gateways',array($this,'get_payment_gateways'));
			cms_register_filter('get_test_suites',array($this,'test_test_suite'),dirname(__FILE__).'/class.SagePayTestSuite.php',-5);
			cms_register_filter('handle_url',array($this,'ipn'));
			cms_listen_action('models_loaded',array($this,'load_model'));
			cms_register_filter('config_defaults',array($this,'config_defaults'));
		}	
		function test_test_suite($suites){
			$suites[] = new SagePayTestSuite();
			return $suites;
		}
		function load_model(){
		}
		function get_payment_gateways($gateways){
			require_once(dirname(__FILE__).'/SagePayGateway.php');
			$gateways[] = new SagePayGateway();
			return $gateways;
		}
		function ipn($handled,$url,$template){
			if($url=='/ipn'){
				$gateway = cms_apply_filter('get_payment_gateway');
				$gateway->callback();
				die();
			}
			return $handled;
		}
		function config_defaults($config){
			$config['sagepay']['vendor'] = 'bozboz';
			$config['sagepay']['live'] = 0;
			$config['sagepay']['allow_amex'] = 0;
			$config['orders']['sagepay_minimum_checkout']=10;
			return $config;
		}
	}
	new SagePayHooks;
?>
