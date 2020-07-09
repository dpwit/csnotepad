<?
/**
* @package Boz_Orders
*/
include(dirname(__FILE__).'/list-init.php');
	include(__MODELS_BASE__.'/boz/views/default/csv.php');

		echo "\n\n";
echo format_csv(array("Total Orders","Total Value"))."\n";
echo format_csv(array($orderStats['count'],$orderStats['sum']))."\n";

?>
