<?
	$user = Model::loadModel('User')->getLoggedInUser();

	$basket = Model::loadModel('Basket')->getFirst();

?>
		<ul id="shoppingInfo">
	<? $count = $basket ? count($basket->products()) : 0; ?>

			<!--<li><a href="/dashboard.html">My Account</a></li>
			<li>|</li>-->
		<? if($user) { ?>
			<li><a href="/logout.html">Logout</a></li>
			<li>|</li>
			<li><a href="/profile.html">My Account</a></li>
		<? } else { ?>
			<li><a href="/login.html">Login / Register</a></li>
		<? } ?>
		<?// if($count) { ?>
			<li>|</li>
			<li><a href="/shop/view-cart.html" class="bag">View Cart</a></li>
			<li>|</li>
			<li><a href="/shop/view-cart.html"><?=$count?> Items</a></li>
			<li>|</li>
			<li><a href="/shop/checkout.html">Checkout</a></li>
		<?// } ?>
		</ul>
