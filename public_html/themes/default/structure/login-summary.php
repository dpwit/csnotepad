<?
	$user = Model::loadModel('User')->getLoggedInUser();

	$basket = Model::loadModel('Basket')->getFirst();

?>

	<div id="loginDetails"><span class="cartDetails">
	<? $count = $basket ? count($basket->products()) : 0; ?>

		<? if($count) { ?>
		<?=$count?> items in cart / 
			<a href='/shop/view-cart.html'>view cart</a> / 
			<a href='/shop/checkout.html'>checkout</a> / 
		<? } ?>
		<?if($user) { ?>
			<a href='/dashboard.html'>my account</a> /
		<a href='/logout.html'>logout</a>
		<? } else { ?>
			<a href='/login.html'>login/signup</a> 
		<? } ?>
	</span></div>
