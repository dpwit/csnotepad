<? include(dirname(__FILE__).'/basket-header.php'); ?>

<?
	$products = $basket->products();
?>
	<p><?=count($products)?> items in your basket</p>
	<ul>
<?
foreach($products as $product){
?>
		<li><a href='/basket/remove/<?=$product->getId()?>'><?=$product->getlabel()?></a></li>
<? } ?>
	</ul>

<? include(dirname(__FILE__).'/basket-footer.php'); ?>
