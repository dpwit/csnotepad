<div id="shop" class="noBorder box">
<?php if($this->model->alternativeHeading) { ?>
	<h2><?=$category->alternativeHeading?> Costs</h2>
<?php } else { ?>
	<h2><?=$category->name?> Costs</h2>
<?php } ?>
	<table class="ProductTable">
		<thead>
			<tr>
				<th></th>
				<th class="ProductName">Telephone</th>
			</tr>
		</thead>
		<tr>
			<th>Please Call For Costs</th>
			<td>0800 849 3990</td>
		</tr>
	</table>
</div>
<?php return; ?>
<div class="productContent">
<?php if($this->model->alternativeHeading) { ?>
	<h2><?=$category->alternativeHeading?></h2>
<?php } else { ?>
	<h2><?=$category->name?></h2>
<?php } ?>
<?=$category->content?>
</div>