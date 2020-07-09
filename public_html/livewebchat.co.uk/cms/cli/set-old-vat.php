<?
	require_once(dirname(__FILE__).'/../fe-init.php');
	mysql_query("ALTER TABLE order_items ADD gross decimal(10,2) after total, add nett decimal(10,2) after total");
	$o = Model::loadModel('Order_Item')->getAll(array(),array('for_fetch'=>1));
	while($i = $o->fetch()){
		$order = $i->order();
		$i->nett = $i->getOldTotalBeforeVat();
		if(!$order->requiresVAT()) $i->gross = $i->nett;
		else	$i->gross = $i->isTax() ? 0 : $i->getTotalPrice();
var_dump(array($order->getId(),$i->getId(),$order->requiresVAT(),$i->gross,$i->nett));
		$i->writeToDB();
	}
?>
