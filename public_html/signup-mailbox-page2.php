<?php
session_start();

$accountName = $_SESSION['accountName'] ;

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
		
			<!--Page 2-->
			<h3 class="fancy" style="font-size: 14px">
				<strong>Page 2 of 3</strong>
				<br>
				<br>
			</h3>
			<br>
			<div class="box-fancy">
				
				<form id="support-form" action="/signup-mailbox-page3" method="POST">
					<!--Page 2-->
					
					<a name="page2"></a>
					<input type="text" name="accountName" value="<?php
					echo $accountName;
					?>">
					<div class="form_row">
					<label for="service" style="font-size: 15px">Type of service required:</label>
					<select name="service">
						<option value="Forwarding">Mail forwarding</option>
						<option value="Collection">Mail stored for collection</option>
						<option value="Scan">Scan to email service</option>
					</select>
					</div>
					<div class="form-row">
						<h3 class="fancy" style="font-size: 16px; padding-left: 0px; width: 550px;">
							<strong>Handling charges</strong>
							<br>
							We apply a small charge for each item of mail that we receive and process for you;   to sign-for  (if necessary),  identify,  sort,  insure whilst on the premises and prep for forwarding.
							<br>
							<br>
							Mail forwarding:<br>
							Letters &ndash; 75p + postage<br>
							Parcels &ndash; &pound;1.50 + postage
							<br>
							<br>
							Scan to email: <br>
							50p per item
							<br>
							<br>
							Mail storage (1 month): <br>
							FREE<br>
							Additional months &ndash; &pound;5 a month (includes up to 50 letters)
						</h3>
					</div>
					<div class="form-row">
						<button><a href="/signup-mailbox-page3" class="bt-support" style="float: left; text-decoration: none;">Next...</a></button>
					</div>
				</form>

			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		

	</body>
</html>