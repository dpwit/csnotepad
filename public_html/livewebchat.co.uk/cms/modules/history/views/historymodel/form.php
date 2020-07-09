<?
	foreach($model->getAll(array('ref_id'=>$model->ref_id,'ref_table'=>$model->ref_table)) as $history){
		echo "<hr/>";
		echo "<h2>On ".date("Y-m-d H:i",$history->cdate)."</h2>";
		echo "<a href='".$history->urlFor('revert')."'>Revert Changes</a>";
		echo "<pre>$history->changes</pre>";
	}
?>
