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
		<?php
      // define variables and set to empty values
      $nameErr = $emailErr = $phoneErr = "";
      $name = $email = $phone = "";

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        } else {
        $name = signup_request($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed"; 
        }
        }
  
      if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        } else {
        $email = signup_request($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format"; 
        }
        }
    
      if (empty($_POST["phone"])) {
        $phoneErr = "Number required";
        } else {
        $phone = signup_request($_POST["phone"]);
        // check if telephone syntax is valid 
        if (!preg_match("/^[0-9]*$/",$phone)) {
        $phoneErr = "Only numbers"; 
        }
        }
      }

          function signup_request($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
          }
      ?>
			
		<?php else : ?>
		<a name="recaptchaerror"></a>
		<h1 class="fancy">GET STARTED FOR FREE</h1>
		<h3 class="fancy" style="text-align: center"><strong>21 day trial.  No credit card required</strong></h3>
		<h3 class="fancy"><strong>Note:</strong> Your free trial is an opportunity for you to experience how the Telephone Answering service works and to make sure that it is right for your business.  Your free trial is available for calls between the hours of 8:30am - 6:00pm
		Monday to Friday and is limited to your first 100 calls.</h3>

			<!--<div class="box-fancy">
				<h2>Have our info pack emailed to you instantly</h2>
				<img src="/images/email-icon2.png" alt="">		
			</div>-->
			
			<div class="box-fancy" style="margin-left:120px">
				<form id="support-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" style="margin-left: 42px">
					Name: <input type="text" name="name" value="<?php echo $name;?>">
      <span class="error">* <?php echo $nameErr;?></span>
      <br><br>
      E-mail: <input type="text" name="email" value="<?php echo $email;?>">
      <span class="error">* <?php echo $emailErr;?></span>
      <br><br>
      Telephone: <input type="text" name="phone" value="<?php echo $phone;?>">
      <span class="error">* <?php echo $phoneErr;?></span>
      <br><br>
					
					
					<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 0px; margin-top: 10px; margin-bottom: -20px; transform:scale(0.77);transform-origin:0 0">
						</div>
					<?php if(isset($_GET['CaptchaFail'])){ ?>
							<div style="color: red; font-family: arial; font-size: 12px; width: 200px;"><strong>Please check the reCAPTCHA box and try again</strong></div>
							<?php } ?>
					<div class="form-row">
						<button type="submit" name="submit" value="submit" class="bt-support" style="margin-left: 21px; font-size: 16px;">START YOUR FREE TRIAL</button>
					</div>
					
				</form>
		
			</div>
			
		<?php endif; ?>
		
				
	</body>
</html>