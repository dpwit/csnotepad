<div class="thinBorder box" id="shop">
<h3 class="headerText">Checkout : Stage 1 of 2</h3>

<?

	$details = cms_apply_filter('checkout_field_details',
		array('customer_title','customer_firstname','customer_lastname','customer_email','customer_phone')
	);

	$address = cms_apply_filter('checkout_field_address',
		array('customer_address','customer_city','customer_postcode','customer_state','customer_country')
	);

	$sections = cms_apply_filter('checkout_field_sections',
		array("Personal Info"=>$details,"Billing Details"=>$address)
	);



	require_once(__MODELS_BASE__.'/boz/views/default/form.php');

	
	/*if(extra_checkout_fields::isCMSLoggedIn()){
		?>
			<p>Thank you for your order. Once payment has been received an account manager will contact you to complete the set up of your account. Please confirm your preferred method of contact</p>
		<?php	
	}*/
?>

</div>

<script>	

	<?php
	
		//if(extra_checkout_fields::isCMSLoggedIn()){
			?>
				$(document).ready(function(){
					htmlAfter = '<h3 class="formHeading">Thank you for your order</h3><p><strong>Once payment has been received an account manager will contact you to complete the set up of your account.</strong></p>';
					
					$('.formSection-').before(htmlAfter);					
				});
			<?php	
		//}
	?>

	$('.submitButton .coolButton').each(function(e,i){
												 
		$(this).parent().addClass('absolute');
	
		var htmlBefore = '<div class="tAndCBox"><input type="checkbox" value="1" id="validateMe" />';
		htmlBefore += '<p id="findMe"><label for="validateMe">To continue your order you must agree to our <a href="/terms-and-conditions" target="_blank">Terms of Service</a>.</label></p>';
		htmlBefore += '<p style="display:block;" id="errorMessage">Please agree to the Terms of Service</p></div>';
		$(i).before(htmlBefore);
		//$(i).html({'before':htmlBefore,'after':htmlAfter});
		
		text = $('#findMe');
		input = $('#validateMe');
		error = $('#errorMessage');
		error.hide();
		
		//$$('form.formfromfieldfactory')[0].observe('submit',function(ev){
		$('form.formfromfieldfactory').submit(function(ev){
			if($('#validateMe:checked').length == 0){
				error.fadeIn();
				//ev.stop();
				return false;
			} else {
				error.fadeOut();
			}
		});		
	});
	
</script>
