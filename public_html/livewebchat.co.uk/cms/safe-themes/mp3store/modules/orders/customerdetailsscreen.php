<div class="thinBorder box" id="shop">
<h3 class="headerText">Checkout : Stage 1 of 2</h2>

<?



$details = array('customer_title','customer_firstname','customer_lastname','customer_email','customer_phone');

	$address = array('customer_address','customer_city','customer_postcode','customer_country');

	$sections = array("Personal Info"=>$details,"Billing Details"=>$address);



	require_once(__MODELS_BASE__.'/boz/views/default/form.php');

	

?>

</div>