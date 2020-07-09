<?
	$q = $this->getQuantities();
	$json = array(
		'byId'=>$q,
		'total'=>array_sum($q),
	);
	echo json_encode($json);
?>
