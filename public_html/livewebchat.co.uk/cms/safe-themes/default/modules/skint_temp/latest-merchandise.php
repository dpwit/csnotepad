<div class="thinBorder box" id="featuredShop">
	<div class="overflow">
		<?php
		$productFactory = Model::loadModel('products');
		$productLatest = $productFactory->getFirst(cms_apply_filter('product_category_browsing_restrict',array()),array('order'=>'ctime desc'));
		?>
		<h2 class="smaller blue">Latest Merchandise</h2>
		<a href="<?=$productLatest->getURL()?>">
			<img alt="Shirt" src="images/skint/merch.jpg">
		</a> 
		<h3><?=$productLatest->description?><br>
		&pound;<?=$productLatest->price?></h3>
		<a class="more" href="<?=$productLatest->getURL()?>">More</a>
	</div>
</div>