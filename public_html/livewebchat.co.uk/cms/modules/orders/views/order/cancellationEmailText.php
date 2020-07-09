Dear <?=$this->customer_title?> <?=$this->customer_lastname?>,


Your Order (Ref: <?=@$this->order_ref?>) has been cancelled.

<?
switch($this->order_state()->getLabel()){
case 'Refunded':
?>
The amount of <?=$this->getPrice(false)?> has been refunded to your card.
<?
	break;
}
?>

