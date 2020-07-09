<html>
<body style='background: white; color: black;  font-size: 12px; width: 600px;'>
<p>Dear <?=$this->customer_title?> <?=$this->customer_lastname?></p>

	<p>Your Order (Ref: <?=@$this->order_ref?>) has been cancelled</p>
<?
switch($this->order_state()->getLabel()){
case 'Refunded':
?>
	<p>The amount of <?=$this->getPrice(false)?> has been refunded to your card</p>
<?
	break;
}
?>

</body>
</html>
