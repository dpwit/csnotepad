<div id="pdSidebar" class='collection-sidebar'>
<form method='post' action='/basket/add'>
<?
$available = true;
$collection = $product;
$total=0;
	foreach($collection->products_in() as $product){
?>
<h3 class="trackH3"><?=$product->getLabel()?>:</h3>
	<ul class="tracks">
<?
			$variations = $product->variations();

			if(!$variations){
?>
	<li><?=$product->getLabel()?><input type='hidden' name='product_ids[]' value='<?=$product->getId()?>'/>
<?
			} else {
				$first = true;
				foreach($variations as $variation) { 
					$img = $variation->variationImage('icon',array('as_url'=>true));
?>
					<li>
						<input type='hidden' class='price' value='<?=$variation->getPrice()?>'/>
						<? if($img) { ?>
							<img src='<?=$img?>'/>
						<? } ?>
						<?=$variation->describeVariation()?>
						<?=$variation->prettyPrice()?>
						<? if($variation->isAvailableForSale()) { ?>
						<input type='radio' name='product_ids[<?=$product->getId()?>]' value='<?=$variation->getId()?>'
							<? if($first) { ?>checked='true'<? $first=false; $total+=$variation->getPrice(); } ?>
/>
						<? } else { ?>
							Out Of Stock
						<? } ?>

					</li>
<?
				}
			}

?>
								</ul>

<? 		}  ?>
	<h3 class="trackH3"><?=$collection->getLabel()?>:</h3>
	<ul class="tracks">
<?
		if($collection->isAvailableForSale()) { 
?>
	<li>Add To Basket <a class="add_to_basket submit-link collection_add" href='/basket/add/<?=$collection->getId()?>'>&pound;<span class='collection-price'><?=number_format($total,2)?></span><img src="images/shop/basket_add.png" alt="basket"/></a></li>
<?
		} else { 
?>
	<li>Out Of Stock</li>
<?
		}
?>
	</ul>
</form>
							</div>
<script>
$(function(){
	$('a.collection_add').bind('click',function(){
		$(this).closest('form').submit();
		return false;
	});

	var updateSidebar = function($div){
		var $prices = $('input:radio:checked',$div).closest('li').find('input.price');
		var total=0;
		$prices.each(function(){total+=parseFloat($(this).val());});
		$('span.collection-price',$div).html(total.toFixed(2));
	};

	updateSidebar($('#pdSidebar'));
	$('#pdSidebar input:radio')
		.bind('click',function(){updateSidebar($('#pdSidebar'));})
		.bind('change',function(){updateSidebar($('#pdSidebar'));});
});
</script>
