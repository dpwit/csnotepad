<?
/**
* @package Boz_Orders
*/

	class PayPalHooks {
		function __construct(){
			cms_register_filter('get_payment_gateways',array($this,'get_payment_gateways'));
			cms_register_filter('get_test_suites',array($this,'test_test_suite'),dirname(__FILE__).'/class.PayPalTestSuite.php',-5);
			cms_register_filter('handle_url',array($this,'ipn'));
			cms_listen_action('models_loaded',array($this,'load_model'));
			cms_register_filter('config_defaults',$this);
		}	
		function test_test_suite($suites){
			$suites[] = new PayPalTestSuite();
			return $suites;
		}
		function load_model(){
			Model::addModel('IPN',dirname(__FILE__).'/IPNModel.php');
		}
		function get_payment_gateways($gateways){
			require_once(dirname(__FILE__).'/PayPalGateway.php');
			$gateways[] = new PayPalGateway();
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
			$config['paypal']['account_email'] = 'don_1275409053_biz@don-benjamin.co.uk';
			$config['paypal']['live'] = '0';
			return $config;
		}
	}
	new PayPalHooks;
?>
