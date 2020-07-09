             <div id="categories"><h2>Account</h2>   
                	<ul>
				<li><a href='/profile.html'><h1>Personal Details</h1></a></li>
				<li><a href='/change-password.html'><h1>Change Password</h1></a></li>
<?
	$user = Model::loadModel('User')->getLoggedInUser();
	$orders = $user->orders(array('order_state.name in '=>array('complete','pending')),array('order'=>'uid desc','limit'=>5));
	if($orders){
?>
				<li><a href='/orders/'><h1>Recent Orders</h1></a>
<ul>
<?
	foreach($orders as $order){
?>
		<li><a href='/orders/<?=$order->getSlug()?>'><?=$order->getPrice()?> - <?=date("d/m/Y",$order->ctime)?></a></li>
<?
	}
?>
</ul>
				</li>
<? } ?>
			</ul>
		</div><!-- #categories -->
