<div class="last box thinBorder" id="shop">
<!--<h3 class="headerText">CheckOut</h3>-->
<form method='post'><?=$this->getHiddenForm()?>
<? $this->view($context,'modules/checkout/basket_reminder_table',array('order'=>$order)); ?>

<?
		$methods = $order->getPaymentMethods();
		if(count($methods)>1){
?>
	<div class='payment-method'><span>Payment Method:</span>&nbsp;
<?
			$first = true;
			foreach($methods as $key=>$name) {
				$checked = ($first ? " checked='true'":"");
				$first="";
?>
	<input type='radio' name='method' value='<?=$key?>' id='method-<?=$key?>'<?=$checked?>/> <label for='method-<?=$key?>'><?=$name?></label> 
<?	
			} 
?>
	</div>
<?
		} else {
			list($key,$name) = each($methods);
?>
	<input type='hidden' name='method' value='<?=$key?>' id='method-<?=$key?>'/><!-- <label for='method-<?=$key?>'><?=$name?></label> -->
<?
		}
?>
<p>Please check your order is correct before proceeding</p>
<div class='payment-navigation' style="text-align:right">
	<!--<input type='button' name='go-back' id="view-cart" class='coolButton' value='View Cart' onclick='document.location.href="<?=$screen->linkTo('basket-edit')?>";return false;'/>-->
	<a id="view-cart" class='coolButton' value='View Cart' href='<?=$screen->linkTo('basket-edit')?>'>View Cart</a>
	<input type='submit' name='confirm' id="next" value='Next' class="coolButton"/>
</div>
</form>
</div>
