<?
	function handle_ipn($trailing){
		require_once(dirname(__FILE__).'/PayPalFormsGateway.php');
		$gateway = new PayPalFormsGateway();
		$gateway->callback();
		die();
	}
	$urls = array(
		'forms-ipn'=>array('func'=>'handle_ipn')
	);
	FEContext::addUrls($urls,dirname(__FILE__));

