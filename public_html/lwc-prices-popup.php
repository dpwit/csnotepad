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
				<div id="support-form" class="fancybox-inner">
					<!--Page 1-->
					
					<h1 class="fancy" style="font-size: 34px;">Live Web Chat Prices</h1>

					<!--<h3 class="fancy" style="font-size: 16px; width: 525px; padding: 0px;">
						What would you like us to do with your post... forward it on to you at a different address, store it for collection or open, scan it and email it to you?
					</h3>
					<br>-->
					

					<div class="form-row">
						<h3 class="fancy" style="font-size: 18px; padding-left: 0px; text-align: center; width: 525px;">

							<div style="border: 1px solid black; border-radius: 5px; box-shadow: 3px 3px 5px #505050; display: inline-block; margin-bottom: 20px; padding: 5px; width: 45%;">
								<font style="color: #39f; font-size: 28px; font-weight: 700;">Sofware only</font>
								<br>
								<br>
								&pound;12 /mo
								<br>
								<br>
								<font color="#ff8834">•</font> Unlimted chats
								<br>
								<font color="#ff8834">•</font> No setup fees
							</div>

							<div style="border: 1px solid black; border-radius: 5px; box-shadow: 3px 3px 5px #505050; display: inline-block; margin: 0 0 20px 10px; padding: 5px; width: 45%;">
								<font style="color: #39f; font-size: 28px; font-weight: 700;">Overflow service</font>
								<br>
								<br>
								&pound;14.50 /mo
								<br>
								<br>
								<font color="#ff8834">•</font> PAYG chat service
								<br>
								<font color="#ff8834">•</font> 50p a minute
							</div>
							<img src="/images/tick-orange.png" style="display: inline-block; vertical-align: middle;" alt="Orange tick" height=21 width=24 />No upfront fees
							<br>
							<img src="/images/tick-orange.png" style="display: inline-block; vertical-align: middle;" alt="Orange tick" height=21 width=24 />No tie-in period
							<br>
							60 day rolling contract if you continue after your free trial
							<br>
							<div class="innerDivHome" style="width:100%; background-color: #29B8EF; -webkit-padding-before: 12px; box-shadow: 3px 3px 5px #505050; height: 125px; margin-top: 20px;">
								<h2 style="color: #fff; font-size: 32px; margin-bottom: -5px; text-shadow: none;"><strong>Try Live Web Chat free</strong></h2>
								<h3 style="color: #fff; font-size: 13px; text-shadow: none;">Experience our full service completely free for 30 days,
								<br>
								To us, free means exactly that; no hidden costs, no set-up fees, no admin charges
								<br>
								and absolutely no ongoing commitment.
								<br>
								You've got nothing to lose.
								<br>
								</h3>
								<br>
							</div>
							<br>
							<div style="display: inline-block;">
								<a href="/signup-lwc-freeTrialForm" rel="fancybox-signup" title="30 day FREE trial" class="fancybox.iframe">
									<button type="submit" name="submit" value="submit" class="lwcPopupFreetrial" style="width: 249px;">30 day FREE trial</button>
								</a>
							</div>
						</h3>
					</div>
					
				</div>
				
			</div>
			
		<?php endif; ?>
		
		<?php unset($_SESSION['user-feedback']); ?>
		
		

	</body>
</html>