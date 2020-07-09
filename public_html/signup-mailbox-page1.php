<?php
session_start();

$_SESSION['accountName'] = $accountName;

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
		<?php if($_SESSION['user-feedback']['success']) : ?>
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
		
		<h1 class="fancy" style="font-size: 34px">Set up your service</h1>

		<h3 class="fancy" style="font-size: 14px">
			<strong>Page 1 of 3</strong>
		</h3>
			<br>
		<h3 class="fancy" style="font-size: 16px">
			<strong>Please remember;</strong> although you can start using your new accommodation address immediately,  incoming mail cannot be forwarded or scanned until this <strong>ID verification</strong> process has been completed.
		</h3>
		<br>
		<h3 class="fancy" style="font-size: 12px; color: red;">
			(all fields must be completed)
		</h3>
			<!--Page 1-->

			<div class="box-fancy">
				<form id="support-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
					<div class="form_row"> 
					<label for="accountName" style="font-size: 15px"><asterix>*</asterix> Account holders name:</label>
					<input type="text" name="accountName" value="<?= $_SESSION['user-feedback']['fields']['accountName']; ?>">
					<span class="error">* <?php echo $accountNameErr;?></span>
					</div>
				
					<div class="form_row">
					<label for="email" style="font-size: 15px"><asterix>*</asterix> Contact email address:</label>
					<input type="text" name="email" value="<?= $_SESSION['user-feedback']['fields']['email']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
					</div>
					
					<div class="form_row">
					<label for="telephone" style="font-size: 15px"><asterix>*</asterix> Contact telephone number:</label>
					<input type="text" name="telephone" value="<?= $_SESSION['user-feedback']['fields']['telephone']; ?>">
					<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['telephone']; ?></span>
					</div>

					<br>

					<div class="form_row">
					<label for="term" style="font-size: 15px">Account term:</label>
					<select name="term">
						<option value="Quarterly">Quarterly (equivalent to just &pound;10 a month)</option>
						<option value="BiAnnually">Bi-annually (equivalent to just &pound;8.33 a month)</option>
						<option value="Annually">Annually (equivalent to just &pound;6.05 a month)</option>
					</select>
					</div>
					<br>
					<div class="form-row">
						<button><a href="/signup-mailbox-page2" class="bt-support" style="float: left; text-decoration: none;">Next...</a></button>
					</div>
					<br>
					<br>
					
				</form>
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		

	</body>
</html>