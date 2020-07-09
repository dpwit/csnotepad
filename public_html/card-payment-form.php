<!DOCTYPE HTML>
<html>
	<head>
		<title></title>

		<link rel="stylesheet" type="text/css" href="https://www.csnotepad.co.uk/html/css/support-contact.css">
		
		<script>
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-2882596-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>	

		<script src="https://cdn.worldpay.com/v1/worldpay.js"></script>      
		<script>
         window.onload = function() {
           Worldpay.useTemplateForm({
             'clientKey':'T_C_a32148c2-8151-4e44-b359-eb1c55cc3c93',
             'form':'paymentForm',
             'paymentSection':'paymentSection',
             'display':'inline',
             'reusable':true,
             'callback': function(obj) {
               if (obj && obj.token) {
                 var _el = document.createElement('input');
                 _el.value = obj.token;
                 _el.type = 'hidden';
                 _el.name = 'token';
                 document.getElementById('paymentForm').appendChild(_el);
                 document.getElementById('paymentForm').submit();
               }
             }
           });
         }
      </script>
	</head>
	<body>
		<?php 

		if($_SESSION['user-feedback']['success']) : 

		?>
		<!-- Google Code for Pricelist Conversion Page --> 
		<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 1055112536;
			var google_conversion_language = "en";
			var google_conversion_format = "3";
			var google_conversion_color = "ffffff";
			var google_conversion_label = "5262CN-YjWkQ2PqO9wM"; var google_remarketing_only = false;
			/* ]]> */
		</script>
		<script src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
			<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt=""  
			src="//www.googleadservices.com/pagead/conversion/1055112536/?label=5262CN-YjWkQ2PqO9wM&amp;guid=ON&amp;script=0"/>
			</div>
		</noscript>
			
		<?php else : ?>
			
			<div class="box-fancy">
				<form id="paymentForm" action="/complete" method="POST">
					
					<div id="container" style="width: 550px;">
						<h1 class="fancy" style="font-size: 34px">Payment information</h1>
						<h2 class="fancy" style="text-align: center; margin-top: 10px; margin-bottom: 5px;">Please complete the payment sections below.</h2>
						
						<div id="first" style="width: 550px; display: inline-block; margin-top:-10px;">
							<h3 class="fancy" style="font-size: 15px; padding: 0px; text-decoration-line: underline; text-underline-position: under;"><strong>Your name and address</strong></h3>
							<h3 class="fancy" style="font-size: 15px; padding: 0px;">Please enter your name and address details below.</h3>
						</div>
						<div id="first" style="width: 250px; display: inline-block;">
							<div class="form_row"> 
								<label for="accountName" style="font-size: 15px"><asterix>*</asterix> Full name:</label>
								<input type="text" name="accountName" required placeholder=""
								    oninvalid="this.setCustomValidity('Full name required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="error"><?php echo $accountNameErr;?></span>
							</div>

							<div class="form_row"> 
								<label for="acAddr" style="font-size: 15px;"><asterix>*</asterix> Address:</label>
								<input type="text" name="acAddr" required placeholder=""
								    oninvalid="this.setCustomValidity('Full address required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acAddr']; ?></span>
							</div>

							<div class="form_row"> 
								<label for="country" style="font-size: 15px;"><asterix>*</asterix> Country of residence:</label>
								<input type="text" name="country" required placeholder=""
								    oninvalid="this.setCustomValidity('Country required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['country']; ?></span>
							</div>
							
						</div>
						
					</div>
					<br>
					<br>

					<div id='paymentSection'></div>
			        <div>
			        	<input type="submit" value="Place Order" onclick="Worldpay.submitTemplateForm()" />
			        </div>

				</form>
				
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
	</body>
</html>