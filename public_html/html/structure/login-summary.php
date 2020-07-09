<?php
$user = Model::loadModel('User')->getLoggedInUser();
$basket = Model::loadModel('Basket')->getFirst();
?>
<ul id="shoppingInfo"><li><a rel="nofollow" href='/shop/view-cart.html'>Checkout</a></li></ul>
