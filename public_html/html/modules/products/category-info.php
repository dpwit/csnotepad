<div class="productContent">
<?php if($item->alternativeHeading) { ?>
	<h1><?=$item->alternativeHeading?></h1>
<?php } else { ?>
	<h1><?=$item->name?></h1>
<?php } ?>
<?=$item->content?>
</div>