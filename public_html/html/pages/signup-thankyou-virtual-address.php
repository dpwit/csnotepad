<?php
session_start();
?>
<!DOCTYPE HTML>

<html>
	<head>

		<!-- Global site tag (gtag.js) - Google Ads: 1055112536 -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1055112536"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'AW-1055112536');
		</script>

		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-NVWB2MG');</script>
		<!-- End Google Tag Manager -->

		<title>Thank you | Signup Virtual Address</title>
		<link rel="stylesheet" href="/css/cs_notepad-min.css">
		<link rel="stylesheet" type="text/css" href="/html/css/support-contact.css">
		
		<script type="text/javascript" src="http://elite-s001.com/js/24663.js" ></script>
		<noscript><img src="http://elite-s001.com/images/track/24663.png?trk_user=24663&trk_tit=jsdisabled&trk_ref=jsdisabled&trk_loc=jsdisabled" height="0px" width="0px" style="display:none;" /></noscript>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>

	</head>
	<body>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NVWB2MG"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		
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
		<script type="text/javascript"  
			src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
			<div style="display:inline;">
				<img height="1" width="1" style="border-style:none;" alt=""  
				src="//www.googleadservices.com/pagead/conversion/1055112536/?label=5262CN-YjWkQ2PqO9wM&amp;guid=ON&amp;script=0"/>
			</div>
		</noscript>
		
			<div style="text-align: center;">
				<img src="/images/logo_dark.png" style="width: 660px; height: 330px; margin-top: -55px;" alt="CSnotepad Logo." title="CSnotepad Virtual Receptionists" />
			</div>
			<hr style="margin-top: -50px; width: 500px;">
			<br>
			<h1 class="fancy" style="border-bottom: none; color: #505050; font-size: 24px; font-weight: 400; width: 885px;">Check your email</h1>
			<br>
			<hr style="width: 500px;">
			
			<p class="validation-success notes" style="color: #505050; margin-left: auto; margin-right: auto; text-align: left; width: 810px;">
				<br>
				<br>
				<strong>Hurrah...</strong> your details have been passed to one of our account managers who will be in-touch shortly to complete the set up of your service.
				<br>
				<br>
				<?php
				echo "In the meantime we've sent a message to " . $_SESSION["get-email"] . " with a link to your Terms & Conditions."
				?>
				<br>
				<br>
				<strong>Haven't received your email?</strong>
				<br>
				If you haven't received an email from us within a few minutes then please use the link below to access, review and sign your Terms & Conditions:
				<br>
				<br>
				<a href="/csnotepad-agreement.php">CSnotepad agreement</a>
			</p>


			<p class="validation-success notes">
				<strong>Thank you for choosing CSnotepad</strong>
				<br>
				<br>
				<a href="/virtual-address" title="Back to Home page">
					<button type="submit" name="submit" value="submit" class="homepageleft" style="float: none; margin-left: 0; width: auto;">Back</button>
				</a>
			</p>
	</body>
</html>
