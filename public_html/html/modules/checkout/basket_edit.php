
<div class="last box thinBorder" id="shop">
<!--<h2 class="headerText">Items in Cart</h2>-->
<?
	$err.=$errors;
	if($err) {
?>
<div class='errors'>
<p>Some of the products selected are not available:</p>
<?=paragraphs($err)?>
</div>
<? } ?>
<? $relatedCategories = array(); ?>
<form method='post'><?=$this->getHiddenForm()?>
	<table class="basket" cellspacing="5">
		<thead>
			<tr>
				<th class="basketItem">Item</th>
				<th class="basketQty">Qty</th>
				<th class="basketPrice">Price</th>
			</tr>
		</thead>			
			<? foreach($order->order_items_no_extras(array(),array('order'=>'sorting')) as $item){ ?>
			<tr>
				<td class="item"> <?=$this->view($context,'modules/checkout/item-description',array('item'=>$item))?> </td>
				<td class="quantity"> &nbsp;
				<?php 
							
					if($item->ref_table=="products" && $item->product()->product_type_uid!=19) 
						{ ?><input class="inputQty" type="text" name="qty[<?=$item->getId()?>]" value="<?=$item->getQuantity()?>" style="float: left" size="2"/> 
						<a href="/basket/remove/<?=$item->product()->getId()?>" title="Remove item from basket"><img class="remove-item" src="/images/remove_item.png"/></a><?php 
						?><!-- <?php foreach($item->product()->categories() as $cat){
							foreach($cat->CategoryRelatedCategory() as $relatedCat)
								$relatedCategories[] = $relatedCat->related();
						}
						$relatedCategories = array_unique($relatedCategories);
						?> --> <?php
						}
				?>
				</td><td class="checkoutPrice"><?=$item->getTotalPriceFormatted(false)?></td>
			</tr>
			<? } ?>
			<tr>
				<td colspan="2"><strong>Total</strong></td>
				<td class="checkoutPrice totalCost">&pound;<?=number_format($order->deductVat($order->getTotal(false)),2)//$order->getPrice(false)?></td>
			</tr>
		</table>

<div class='payment-navigation'>
<div class="formButtons">
<a href="/our-services" value="View Cart" class="coolButton" id="view-cart">Continue Shopping</a>
	<input type='button' name='back' id="back" class="coolButton" value='Back' onClick='$("#back-input").val("back"); $("#back-input").closest("form").submit()'/>
	<input type='hidden' name='back' id='back-input' value=''/>

	<input type='submit' name='update' id="update" class="coolButton" value='Update Cart'/>

	<input type='submit' name='confirm' id="next" class="coolButton" value='Checkout'/>
</div>
</div>
</form>
<?php if($relatedCategories && ($_GET['demo']=='1' && false)){?>
		<br clear="both" />
		<h2>Recommendations:</h2>
		<h3>Other customers that purchased this service also purchased... </h3>
		<div class='listing relatedProductsList'>
			<ul>
			<?
				foreach($relatedCategories as $i => $relCat){
			?>
			<?
					if(false || $relCat instanceof Component){
						$relCat->doHTML($context);
					} else {
			?>
					<li class='relatedProducts'>
				<a href="<?=$relCat->getUrl()?>">
				<span class="relatedProd" <?php if($relCat->image('exists')){ ?>style="background-image:url(<?=$relCat->image('detail',array('as_url'=>true))?>)"<?php } ?>>&nbsp;</span>
				<h3 class="title"><?=$relCat->getLabel()?></h3>
				<p><?=$relCat->description?></p>
				<p class="link">Read more</p>
				</a>
				</li>
			<?
					}
			?>
			<?
				}
			?>
			</ul>
			</div>
<? } /*END DEMO*/?>
<?php if($relatedCategories && ($_GET['demo']=='2' || true)){?>
<div class="relatedCategoriesDiv">
		<h2 class="blueHeading"><strong>Other customers who purchased this service also purchased... </strong></h2>
		<div class='listing relatedProductList'>
			<ul>
			<?
				$lastOne = end($relatedCategories);
				foreach($relatedCategories as $i => $relCat){
			?>
			<?
					if(false || $relCat instanceof Component){
						$relCat->doHTML($context);
					} else {
			?>
						<li class='relatedProducts<?=$lastOne->uid==$relCat->uid?' last':''?>'>
						<a href="<?=$relCat->getUrl()?>">
						<?php if($relCat->image('exists')){ ?><span class="relatedProdImge"><img src="<?=$relCat->image('csnotepadCategoryImage',array('as_url'=>true))?>" height="78"></span><?php } ?>
						<h3 class="title"><?=$relCat->getLabel()?></h3>
						<p><?=$relCat->description?></p>
						<p class="link">Read more</p>
						</a>
						</li>
			<?
					}
			?>
			<?
				}
			?>
			</ul>
			</div>
			</div>
<? } /*END DEMO*/?>
</div>
