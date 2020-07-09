<?
	$user = Model::loadModel('User')->getLoggedInUser();

	$basket = Model::loadModel('Basket')->getFirst();

?>
		<ul id="shoppingInfo">
	<? $count = $basket ? count($basket->products()) : 0; ?>

			<!--<li><a href="/dashboard.html">My Account</a></li>
			<li>|</li>-->
		<? if($user) { ?>
			<li><a href="/logout.html" rel="nofollow" title="Logout">Logout</a></li>
			<li>|</li>
			<li><a href="/profile.html" rel="nofollow" title="My Account">My Account</a></li>
		<? } else { ?>
			<li><a href="/login.html" rel="nofollow" title="Login or Register">Login / Register</a></li>
		<? } ?>
		<? // if($count) { ?>
			<li>|</li>
			<li><a href="/shop/view-cart.html" rel="nofollow" title="View Cart" class="bag">View Cart</a></li>
			<li>|</li>
			<li><a href="/shop/view-cart.html" rel="nofollow" title="<?=$count?> Items"><?=$count?> Items</a></li>
			<li>|</li>
			<li><a href="/shop/checkout.html" rel="nofollow" title="Checkout">Checkout</a></li>
		<? // } ?>
		</ul>
