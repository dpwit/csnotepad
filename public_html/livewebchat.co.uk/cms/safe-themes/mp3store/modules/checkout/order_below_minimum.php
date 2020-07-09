<div id="shop" class="thinBorder box">

<h3>Minimum Order <?=$order->getMinimumCheckout()?></h3>

<p>You must order at least <?=$order->getMinimumCheckout()?> before you can checkout of the shop</p>

<? $this->view($context,'modules/checkout/basket_reminder_table',array('order'=>$order)); ?>

<form method='post'><?=$this->getHiddenForm()?>
<div class='payment-navigation'>
	<div class="formButtons">
		<input type='submit' name='go-back' id="view-cart" class='coolButton' value='View Cart'/>
	</div>
</div>
</form>

</div>
