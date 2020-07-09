<h3>Artist Top 10</h3>
<?php

	$top10s = Model::loadModel('artistTop10')->getAll(array('artist_uid'=>$artist->uid),array('order'=>'sorting', 'limit'=>10));

	foreach($top10s as $top10Item)
	{
		$product = $top10Item->product();
		var_dump($product->uid);
	}

?>