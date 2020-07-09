<?
	$basket = Model::loadModel('Basket')->getFirst();
	if(!$basket) {
		$basket = Model::loadModel('Basket')->createNew();
		$basket->writeToDB();
	}

	$urls = array(
		"basket"=>array(
			"base"=>"summary",
			"add"=>array("func"=>array($basket,'addToBasket')),
			"remove"=>array("func"=>array($basket,'removeFromBasket')),
			"checkout"=>array("func"=>array($basket,'createOrder')),
		)
	);
	FEContext::addUrls($urls,dirname(__FILE__));
	
?>
