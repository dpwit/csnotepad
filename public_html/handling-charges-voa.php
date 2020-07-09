<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="/html/css/support-contact.css">
		
		<script type="text/javascript" src="http://elite-s001.com/js/24663.js" ></script>
<noscript><img src="http://elite-s001.com/images/track/24663.png?trk_user=24663&trk_tit=jsdisabled&trk_ref=jsdisabled&trk_loc=jsdisabled" height="0px" width="0px" style="display:none;" /></noscript>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2882596-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>	

	</head>
	<body>
		<?php 

if($_SESSION['user-feedback']['success']) : ?>
			<!-- Google Code for Pricelist Conversion Page --> <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1055112536;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "5262CN-YjWkQ2PqO9wM"; var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript"  
src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt=""  
src="//www.googleadservices.com/pagead/conversion/1055112536/?label=5262CN-YjWkQ2PqO9wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
		
			
		<?php else : ?>
			
			<div class="box-fancy">
				<form id="support-form" action="" method="POST">
					<!--Page 1-->
					
					<h1 class="fancy" style="font-size: 34px; margin-top: 30px;">Mail handling charges</h1>

					<!--<h3 class="fancy" style="font-size: 16px; width: 525px; padding: 0px;">
						What would you like us to do with your post... forward it on to you at a different address, store it for collection or open, scan it and email it to you?
					</h3>
					<br>-->
					

					<div class="form-row">
						<h3 class="fancy" style="font-size: 14px; padding-left: 0px; width: 525px;">
							
							The following charges will apply depending on what you would like us to do with your post...
							<br>
							<br>
							<font style="color: #39F;"><strong>Handling charges</strong></font>
							<br>
							We apply a small charge for each item of mail that we receive and process for you; to sign-for (if necessary), identify, sort, insure whilst on the premises and prep for forwarding.
							<br>
							<br>
							<font style="color: #39F; font-size: 14px;"><strong>Mail forwarding</strong></font>
							<br>
							<font style="font-size: 14px;">If you would like your mail forwarded on to you, we will charge:<br>
							Included free letters &ndash; 5 per month (excludes postage)<br>
							Additional letters &ndash; 75p + postage<br>
							Parcels/recorded delivery items &ndash; &pound;1.50 + postage
							<br>
							<br>
							Note, on months where post is forwarded we will charge a minimum monthly postage charge of &pound;3.
							<br>
							<br>
							<font style="color: #39F;"><strong>Scan to email</strong></font>
							<br>
							If you would like your mail scanned and emailed to you, we will charge: <br>
							Included free scans &ndash; 20 pages per month<br>
							Additional scans &ndash; 75p per scanned page
							<br>
							<br>
							<font style="color: #39F;"><strong>Stored for collection</strong></font>
							<br>
							If you would like your mail stored for collection, we will charge a handling fee of: <br>
							Included free letters &ndash; 30 per month<br>
							Additional letters &ndash; 75p<br>
							Parcels/recorded delivery items &ndash; &pound;1.50<br>
							<br>
							And a storage fee of:<br>
							1st month &ndash; FREE<br>
							Additional months &ndash; &pound;5 a month (includes up to 50 letters) 
							<br>
							<br>
							Note, on months where you exceed your inclusive allowance the total minimum handling charge is &pound;3.
							<br>
							<br>
						</h3>
					</div>
					
				</form>
				
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		

	</body>
</html>