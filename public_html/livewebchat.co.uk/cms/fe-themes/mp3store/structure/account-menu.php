<?
	$user = Model::loadModel('User')->getLoggedInUser();
	if($user){
?>
      
				<h2>Account</h2>          
                	<ul class="cats">
						<li><a href='/profile.html'>Personal Details</a></li>
						<li><a href='/change-password.html'>Change Password</a></li>
						<li><a href='/orders/'>Recent Orders</a>
							<ul class="subCat">
<?
	$orders = $user->orders(array('order_state.name in'=>array('complete','pending')),array('order'=>'uid desc','limit'=>5));
	foreach($orders as $order){
?>
								<li><a href='/orders/<?=$order->getSlug()?>'><?=$order->getPrice()?> - <?=date("d/m/Y",$order->ctime)?></a></li>
<?
	}
?>
							</ul>
					</li>
						<li><a href='/shop/view-cart.html'>View Cart</a>
				</ul>
<? } else { ?>
<h2>Not Logged In</h2>

<? } ?>
