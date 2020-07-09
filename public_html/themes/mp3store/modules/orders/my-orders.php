<div id="shop" class='order-listing box thinBorder'>
<div style="padding: 10px">
<h3>Recent Orders</h3>
<?
while($order = $this->getItem()){
?>
	<div class='order'>
		<a href='/orders/<?=$order->getSlug()?>'><?=date("d/m/Y",$order->ctime)?> - <?=$order->getPrice()?></a>
	</div>
<?
	}
?>
</div>
<?

$next = $this->getNextLink();
$prev = $this->getPrevLink();

if($next || $prev) { 
?>
<div class='pagination'>
<? if($prev) { ?>
<a href='<?=$prev?>'>Newer</a>
<? } ?>
<? if($next) { ?>
<a href='<?=$next?>'>Older</a>
<? } ?>
</div>

<? } ?>
</div>
