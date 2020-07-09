<?
/**
* @package Boz_Orders
*/

$pm = $model->getPaymentGateway();
	if(($model->order_state_uid==3) && $pm && $pm->hasFeature('refund')){
?>
	<input type='button' onClick='if (confirm("Are you sure you want to refund and cancel this order?")) document.location.href="despatch.php?model=Order&cms_uid=<?=$model->uid?>&action=refund"' value='Refund Order'><br/><br/>
<?
	}
	$all_fields = array_keys($model->getFields());
	$done = array();
	$sections = array('Status'=>array('uid','order_state_uid','ctime','mtime'),'Delivery'=>array(),'Billing'=>array(),'Order Data'=>array());
	foreach($all_fields as $k=>$v){
		@list($pref,$post) = explode("_",$v);
		switch($pref){
		case 'customer':
			$sections['Delivery'][] = $v;
			break;
		case 'card':
			$sections['Billing'][] = $v;
			break;
		default:
			if(!in_array($v,$sections['Status']))
				$sections['Order Data'][] = $v;
		}
	}
	include(dirname(__FILE__).'/form-with-notes.php');


	foreach($model->history() as $history){
		echo "<hr/>";
		echo "<h2>On ".date("Y-m-d H:i",$history->cdate)."</h2>";
		echo "<a href='".$history->urlFor('revert')."'>Revert Changes</a>";
		echo "<pre>$history->changes</pre>";
	}
?>
