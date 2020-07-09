
<div id="shop" class="thinBorder box cardFailed">
<h2 class="headerText">Order Failed</h2>
<h3>Unfortunately there seemed to be a problem while processing your order.</h3>
<p>The error from the payment company is:</p>
<ul>
<? 
if($order->errors) {
	foreach($order->errors as $error) { ?>
<li class='error'><em><?=$error?></em></li>
<? 	} 
} else {?>
<li class='error'><em><?=$order->payment_message?></em></li>
<? } ?>
</ul>
<h3>We apologise for any inconvenience.</h3>
<h3>We have saved your details. If you would like to try again please click the button below. </h3> 
<p class="button"><a href='/shop/checkout.html' class="coolButton">Try Again?</a></p>

<h3>Alternatively please call us on 0800 849 3990 quoting order number <?=$order->uid?>. </h3>


</div>