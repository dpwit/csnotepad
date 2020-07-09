<div id="shop" class="thinBorder box">
<h2 class="headerText">Order Failed</h2>
<p>There was a problem with your order.</p>
<ul>
<? 
if($order->errors) {
	foreach($order->errors as $error) { ?>
<li class='error'><?=$error?></li>
<? 	} 
} else {?>
<li class='error'><?=$order->payment_message?></li>
<? } ?>
</ul>
<p><a href='/shop/checkout.html'>Try Again?</a></p>
</div>