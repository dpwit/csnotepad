<?



	//$details = array('customer_title','customer_firstname','customer_lastname','customer_email','customer_phone');

	//$sections = array("Card Details"=>$details);



	$order=  $model;

	require_once(dirname(__FILE__).'/../../modules/checkout/order_confirm.php');

?>
<div id="shop" class="thinBorder box cardDetails">
	<div style="padding: 10px 10px 0px">
<?
	if($order->getErrors()){
?>
<ul class='error'>
<? foreach($order->getErrors() as $e){?>
	<li class='form_error'><?=$e?></li>
<?}?>
</ul>
<?
	}
?>
	<?php
		require_once(__MODELS_BASE__.'/boz/views/default/form.php');
	?>
	</div>
</div>
