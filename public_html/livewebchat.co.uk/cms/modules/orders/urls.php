<?

	function validate_3dauth(){
		die("OLD PAGE");
		$order = Model::g('Order',$_GET['txId']);
		$val = $order->handle3DAuthReturn();
	}
	$urls = array(
		"orders"=>array(
			"base"=>"my-orders",
			"catchall"=> FEContext::forModel('Order','order-summary.php'),
		),
		"shop"=>array(
			"view-cart"=>"view-cart",
		),
		"checkout"=>array(
			"base"=>"checkout",
			"3dauth-iframe"=>FEContext::staticFile(dirname(__FILE__).'/template/3dauth-iframe.html'),
			"3dauth-return"=>array(
				'func'=>'validate_3dauth'
			),
		),
		"checkout.html"=>array(
			"catchall"=>"checkout",
		),
	);
	FEContext::addUrls($urls,dirname(__FILE__));
?>
