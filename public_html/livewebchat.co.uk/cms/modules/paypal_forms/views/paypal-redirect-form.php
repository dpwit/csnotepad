<form method='post' action='https://www.<?=$this->host?>/cgi-bin/webscr' id='paypal-form'>
<?
	$index = 0;
	foreach($order->order_items() as $item){
		$index++;
?>
	<input type='hidden' name='amount_<?=$index?>' value='<?=$item->getPrice(false)?>'/>
	<input type='hidden' name='quantity_<?=$index?>' value='<?=$item->getQuantity()?>'/>
	<input type='hidden' name='item_name_<?=$index?>' value='<?=$item->getLabel()?>'/>
<?
	}
?>
	<input type='hidden' name='email' value='<?=$order->customer_email?>'/>
	<input type='hidden' name='firstname' value='<?=$order->customer_firstname?>'/>
	<input type='hidden' name='lastname' value='<?=$order->customer_lastname?>'/>
<?
	$address = explode(",",$order->customer_address);
	$index=0;
	foreach($address as $line){
		$index++;
?>
		<input type='hidden' name='address<?=$index?>' value='<?=trim($line)?>'/>
<?	 } ?>
	<input type='hidden' name='city' value='<?=$order->customer_city?>'/>
	<input type='hidden' name='country' value='<?=$order->customer_country?>'/>
	<input type='hidden' name='zip' value='<?=$order->customer_postcode?>'/>
	<input type='hidden' name='cmd' value='_cart'/>
	<input type='hidden' name='currency_code' value='<?=Config::value('default_currency','orders')?>'/>
	<input type='hidden' name='upload' value='1'/>
	<input type='hidden' name='business' value='<?=Config::value('account_email','paypal')?>'/>
<?
	list($url,$qstring) = explode("?",$returnUrl);
	$returnUrl = "$url/".base64_encode($qstring);
	$cancelUrl = "$url/".base64_encode($qstring.'&cancel=true');
?>
	<input type='hidden' name='return' value='<?=$returnUrl?>'/>
	<input type='hidden' name='cancel_return' value='<?=$cancelUrl?>'/>
	<input type='hidden' name='rm' value='2'/>
	<input type='hidden' name='notify_url' value='<?=Config::value('can_ssl') ? __HTTPS_BASE_URL__ : __HTTP_BASE_URL__?>/forms-ipn'/>
	<input type='hidden' name='custom' value='<?=$order->getId()?>'/>
	<input type='submit' value='PayPal' style='display: none;'/>
</form>
<script>
	$(function(){
		$('#paypal-form').submit();
		//$('#paypal-form').html($('#paypal-form').html().replace(/hidden/g,'text'));
	});
</script>
