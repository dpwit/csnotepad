<?
/**
* @package Boz_Orders
*/
include(dirname(__FILE__).'/list-init.php');
	include(__MODELS_BASE__.'/boz/views/default/list.php');
?>

<table class='order-summary'>
	<tr><td>Total Orders</td><td>Total Value</td></tr>
	<tr><td><?=$orderStats['count']?></td><td>&pound;<?=number_format($orderStats['sum'],2)?></td></tr>
</table>
