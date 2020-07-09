Dear <?=$this->customer_title?> <?=$this->customer_lastname?>

Your order has been accepted:

Item					Quantity	Price
<?

foreach($this->order_items() as $item){
?>
<?=$item->getLabel()?>		<?=$item->quantity?>	<?=$item->getPrice()?>
<? } ?>

