<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Cost effective website support and development for businesses" />
    <meta name="keywords" content="Low cost website support, PAYG website support, website support and development">
    <!-- Scripts -->	  	 

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- style CSS -->
    <link rel="stylesheet" type="text/css" href="/css/reset.css?Cache-Control: max-age=2592000" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-style.css?Cache-Control: max-age=2592000" />
    <link rel="stylesheet" type="text/css" href="/css/fonts/fonts-min.css?Cache-Control: max-age=2592000" />
    <link rel="stylesheet" type="text/css" href="/css/support-contact.css?Cache-Control: max-age=2592000" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.fancybox.css" />
    <link rel="stylesheet" type="text/css" href="/html/js/stylesheets/boxy.css" />
     <title>Low cost, pay monthly website support services | CSnotepad</title>
  </head>
  <body>
    <div class="container-fluid" id="wrappernewfullwebsitesupport" title="CSnotepad Website Support Services">
      <div class="row align-items-center">
        <div class="col-md-3">
         <img src="/images/logo_light_noshadow_responsive.png" class="img-fluid" alt="CSnotepad virtual office address cost effective alternative to renting office" title="CSnotepad Virtual Receptionists">
        </div>
        <div class="col-md-7">
          	<div class="topnav" id="myTopnav">
			  <a href="#home">Home</a>
			  <a href="#how" title="How it works">How it works</a>
			  <a href="#prices" title="Prices">Prices</a>
			  <a href="#more" title="More detail">More detail</a>
			  <a href="#faqs" title="FAQ">FAQ</a>
			  <a href="#contact" title="Contact">Contact</a>
			  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
			    <i class="fa fa-bars"></i>
			  </a>
			</div>
        </div>
        <div class="col-md-2 menunav">
         <a href="tel:01273741400"><img src="/images/phone-nos.png" class="img-fluid align-items-center" alt="CSnotepad telephone number" title="CSnotepad 01273 741400"></a>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-9">
         <h1>Website Support Service...</h1>
        </div>
        <div class="col-sm-3">
          
        </div>
      </div>
      <div class="row">
        <div class="col-sm-9">
         <p class="headertext">CSnotepad website support service is a cost-effective solution for any business wanting their website's content regularly updated and maintained without the typically high associated price.</p>
        </div>
        <div class="col-sm-3">
          
        </div>
      </div>
      <div class="row">
        <div class="col-sm-9">
         <ul class="header">
          <li style="margin-left: 15px;">Website support from as little as &pound;50 a month</li>
          <li style="margin-left: 15px;">Low monthly commitment &ndash; minimum of 1 hour a month</li>
          <li style="margin-left: 15px;">Google Certified</li>
          <li style="margin-left: 15px;">No long contracts</li>
         </ul>
        </div>
        <div class="col-sm-3">
          
        </div>
      </div>
	  	<div class="container-fluid">
		    <div class="row">
			    <div class="col-xs-12" style="margin-left: auto; margin-right: auto;">
					<button id="btnYes" type="submit" name="submit" value="submit" class="websiteSupportYes" style="margin-top: 10px; margin-bottom: 50px;">
						Yes I would like to talk to someone about website support
					</button>
					<!-- The Modal -->
					<div id="yesModal" class="modal">

					  <!-- Modal content -->
					  <div class="modal-content">
					    			<div class="box-fancy">
				<form id="support-form" action="/form-to-email" method="POST">
					<!--Page 1-->
					<div id="container" style="width: 550px;">
						<h1 class="fancy" style="font-size: 34px">Set up your address service&hellip;</h1>

						
							
						
						 
						<div id="first" style="width: 250px; display: inline-block; margin-top: 10px;">
							<div class="form_row"> 
								<label for="accountName" style="font-size: 15px"><asterix>*</asterix> Name:</label>
								<input type="text" name="accountName" required placeholder=""
								    oninvalid="this.setCustomValidity('Full name required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="error"><?php echo $accountNameErr;?></span>
							</div>
						
							<div class="form_row">
								<label for="email" style="font-size: 15px"><asterix>*</asterix> Email address:</label>
								<input type="text" name="email" required placeholder=""
								    oninvalid="this.setCustomValidity('Email address required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['email']; ?></span>
							</div>
							
							<div class="form_row">
								<label for="telephone" style="font-size: 15px"><asterix>*</asterix> Telephone number:</label>
								<input type="text" name="telephone" required placeholder=""
								    oninvalid="this.setCustomValidity('Phone number required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['telephone']; ?></span>
							</div>

							<div class="form_row"> 
								<label for="acAddr" style="font-size: 15px;"><asterix>*</asterix> Full address:</label>
								<input type="text" name="acAddr" required placeholder=""
								    oninvalid="this.setCustomValidity('Full address required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acAddr']; ?></span>
							</div>

							<!-- <div class="form_row"> 
								<label for="acPcode" style="font-size: 15px;"><asterix>*</asterix> Postcode:</label>
								<input type="text" name="acPcode" required placeholder=""
								    oninvalid="this.setCustomValidity('Postcode required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['acPcode']; ?></span>
							</div> -->

							<div class="form_row"> 
								<label for="country" style="font-size: 15px;"><asterix>*</asterix> Country of residence:</label>
								<input type="text" name="country" required placeholder=""
								    oninvalid="this.setCustomValidity('Country required')"
								    oninput="this.setCustomValidity('')"  />
								<span class="validation-error"><?= $_SESSION['user-feedback']['errors']['country']; ?></span>
							</div>
						</div>
						<div id="second" style="width: 295px; display: inline-block;">
							
								<img style="height: 100px; display: inline-block;" src="/images/SSL-Certificate.jpg" alt="SSL Certificate">
								<img style="height: 100px; display: inline-block; margin-left: 10px;" src="/images/ico-logo.jpg" alt="ICO image">
								<br>
								<br>
								<h3 class="fancy" style="font-size: 12px; color: #555; margin-left: -10px;">
								<font color="#ff8834">•</font>&nbsp;Fully-licensed, insured and regulated postal 
								<br>
								&nbsp; address provider<br>
								<font color="#ff8834">•</font>&nbsp;Trusted by hundreds of customers<br>
								<font color="#ff8834">•</font>&nbsp;Established in 2007<br>
								<font color="#ff8834">•</font>&nbsp;Based in Brighton, East Sussex (UK)<br>
								</h3>
						</div>
					</div>
					<br>
					<h3 class="fancy" style="font-size: 15px; color: #555; width: 525px; padding: 0px; margin-top: 0px;">
						How would you like to pay for your service... quarterly, every 6 months or once a year?<br>
						<br>
						<font color="#ff8834">•</font>&nbsp;3 months in advance &ndash; &pound;30 (equivalent to just &pound;10 a month)<br>
					 <font color="#ff8834">•</font>&nbsp;6 months in advance &ndash; &pound;49.98 (equivalent to just &pound;8.33 a month)<br>
					 <font color="#ff8834">•</font>&nbsp;12 months in advance &ndash; &pound;72.60 (equivalent to just &pound;6.05 a month)<br>
					 <font style="font-size: 11px;">All prices are subject to VAT at 20%</font>
					</h3>

					<div class="form_row">
					<label for="term" style="font-size: 15px">Payment terms:</label>
					<select name="term">
						<option value="Quarterly">3 months (equivalent to just &pound;10 a month)</option>
						<option value="BiAnnually">6 months (equivalent to just &pound;8.33 a month)</option>
						<option value="Annually">12 months (equivalent to just &pound;6.05 a month)</option>
					</select>
					</div>

					<br>

					<div class="form_row">
					<label for="method" style="font-size: 15px">Preferred payment method:</label>
					<select name="method">
						<option value="CreditCard">Credit card</option>
						<option value="DebitCard">Debit card</option>
						<option value="DebitCard">Direct debit</option>
					</select>
					</div>

					<br>

					<div class="form_row">
						<label for="service" style="font-size: 15px">Type of service required:</label>
						<select name="service">
							<option value="Forwarding">Mail forwarding</option>
							<option value="Collection">Mail stored for collection</option>
							<option value="Scan">Scan to email service</option>
						</select>
					</div>

					<br>
					<!-- <div class="form-row"> -->
						<!--<button class="bt-support" style="float: left;"><a href="#page2" style="float: left; text-decoration: none; color: #ffffff">Next...</a></button>-->
						<!-- <a href="#page2" style="float: left; text-decoration: none; color: #ffffff; cursor: pointer; background-color: #f57922; font-family: Arial, Helvetica, sans-serif; font-size: 18px; padding: 10px 30px;  background: -webkit-gradient(
							linear, left top, left bottom, 
							from(#ff8731),
							to(#df5d00)); border-radius: 4px; -moz-border-radius: 4px;
						-webkit-border-radius: 4px;
						border-radius: 4px;
						border: 1px solid #949494;
						-moz-box-shadow:
							0px 1px 3px rgba(000,000,000,0.3),
							inset 0px 1px 2px rgba(255,255,255,1);
						-webkit-box-shadow:
							0px 1px 3px rgba(000,000,000,0.3),
							inset 0px 1px 2px rgba(255,255,255,1);
						box-shadow:
							0px 1px 3px rgba(000,000,000,0.3),
							inset 0px 1px 2px rgba(255,255,255,1);
						text-shadow:
							0px 1px 0px rgba(92,92,92,1);">Next...
						</a>
					</div> -->
					
					<!--Page 2-->
					<a name="page2"></a>
					<h1 class="fancy" style="font-size: 34px; margin-top: 30px;">Mail forwarding options</h1>

					<!--<h3 class="fancy" style="font-size: 16px; width: 525px; padding: 0px;">
						What would you like us to do with your post... forward it on to you at a different address, store it for collection or open, scan it and email it to you?
					</h3>
					<br>-->
					

					<div class="form-row">
						<h3 class="fancy" style="font-size: 14px; padding-left: 0px; width: 525px;">
							
							
							We apply a small charge for each item of mail that we receive and process for you; to sign-for (if necessary), 
							identify, sort, insure whilst on the premises and prep for forwarding.
							<br>
							<br>
							The following charges will apply depending on what you would like us to do with your post...
							<br>
							<br>
							<font style="color: #39F; font-size: 14px;"><strong>Mail forwarding</strong></font>
							<br>
							<font style="font-size: 14px;">If you would like your mail forwarded on to you, we will charge:<br>
							Letters &ndash; 75p + postage<br>
							Parcels/recorded delivery items &ndash; &pound;1.50 + postage
							<br>
							<br>
							<font style="color: #39F;"><strong>Scan to email</strong></font>
							<br>
							If you would like your mail scanned and emailed to you, we will charge: <br>
							50p per scanned page
							<br>
							<br>
							<font style="color: #39F;"><strong>Stored for collection</strong></font>
							<br>
							If you would like your mail stored for collection, we will charge a handling fee of: <br>
							Letters &ndash; 75p<br>
							Parcels/recorded delivery items &ndash; &pound;1.50<br>
							<br>
							And a storage fee of:<br>
							1st month &ndash; FREE<br>
							Additional months &ndash; &pound;5 a month (includes up to 50 letters)</font>
						</h3>

					</div>

					<h1 class="fancy" style="font-size: 34px; margin-top: 30px;">Important information</h1>

					<div class="form-row">
						<h3 class="fancy" style="font-size: 14px; padding-left: 0px; width: 525px;">
							
							<font style="color: #39F; font-size: 14px;"><strong>Security Deposit</strong></font>
							<br>
							<font style="font-size: 14px;">
								As part of your postal address service we will hold a fully-refundable &pound;30 security deposit on account.  When you stop your service with us, your security 
								deposit will be automatically refunded back to you.
								<br>
								<br>
								By clicking to confirm your order, you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) as per our <a href="/privacypolicy" target="_blank">Privacy Policy</a> and you agree to our <a href="/terms-and-conditions.php" target="_blank">Terms and Conditions</a>.
								<br>
								<br>
							</font>
						</h3>

					</div>
					
					<div class="g-recaptcha" data-theme="light" data-sitekey="6LekVxoTAAAAAH0YQzUy1uOSeuuOK6_OZpIul_ad" style="margin-left: 0px; margin-top: 10px; margin-bottom: -20px; transform:scale(0.77);transform-origin:0 0">
						</div>
					<?php if(isset($_GET['CaptchaFail'])){ ?>
							<div style="color: red; font-family: arial; font-size: 12px; width: 200px;"><strong>Please check the reCAPTCHA box and try again</strong></div>
							<?php } ?>
					<div class="form-row" style="margin-top: -80px; margin-left: 80px; width: 450px;">
						<button type="submit" name="submit" value="submit" class="bt-support">Click to confirm your order</button>
					</div>

					
				</form>
				
				<div class="fancy" style="margin-top: 75px; padding-left: 0px; width: 525px;"><img src="/images/DD_logo_small.png" style="float: left; width: 33.33%" alt="Direct Debit logo"><img src="/images/Worldpay.png" style="float: right; width: 33.33%" alt="Worldpay logo"></div>
				<h3 class="fancy" style="font-size: 11px; margin-top: 150px; padding-left: 0px; width: 525px;">By clicking submit you hereby agree to your details being held by Call Solution Ltd (trading as CSnotepad) for the purposes of contacting you via email and/or telephone regarding the services it provides.</h3>
			</div>
					    <span class="close">&times;</span>
					  </div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-9" style="border: 2px solid black">
         <h2 style="margin-top: 20px;">Welcome to CSnotepad</h2>
         <p>Are you looking for a premium website support service without the premium prices?</p>
         <p>CSnotepad we provide cost-effective, in-house website support and  development, enabling our clients to continually update and improve their website with regular amendments.</p>
         <p>We recognise the challenge businesses face with the high cost of website support due to the expensive nature of this area of expertise. We're not saying that the costs associated with website support aren't justified, but we recognise that for many businesses rates such as &pound;500+ per day, and minimum half day bookings can be a huge stretch on budgets.</p>
         <p>With CSnotepad, we challenge the status quo by offering 4 very simple plans, ranging from as little as just 1-hour support per month to 20+ hours per month with minimum job requests of just 30 minutes.</p>
         <p>The support and development we can offer includes:</p>
         <ul>
         	<li>Amending information on your site</li>
			<li>Creating new pages</li>
			<li>Constructing data feeds</li>
			<li>Setting up management information reports</li>
			<li>&hellip;in fact, pretty much anything website related including building new websites!</li>

         </ul>
         <p>&nbsp;</p>
        </div>
        <div class="col-sm-3" style="border: 2px solid black">
          <h2 style="margin-top: 20px;">Testimonials</h2>
        </div>
      </div>
    </div>
    
     <div class="container-fluid">
      <div class="row">
        <div class="col-sm-4" style="border: 2px solid black">
         <img src="/images/Share-your-vision-520x530.jpg" class="img-fluid" alt="Share your vision sticky note" title="share your vision" style="margin-left: 11px;">
        </div>
        <div class="col-sm-8" style="border: 2px solid black">
         <h2 style="margin-top: 20px;">How it works</h2>
         <p>Once you have setup your account and selected the plan that is best for you, a website developer will give you a call at a time that suits you. On this call, they will ask you to share with them your vision and requirements for the website. Furthermore, should you wish, they can share with you their initial thoughts and recommendations based on their many years of experience.</p>
         <p>Following this discussion, your website developer will commence work on your website and they will regularly update you on all work completed.</p>
         <p>At any point in time, you can request new website work or amend any existing work.</p>
         <p>It really is that simple&hellip;</p>
         	<button id="btnYes" type="submit" name="submit" value="submit" class="websiteSupportYes" style="margin-top: 10px; margin-bottom: 50px;">
				Yes I would like to talk to someone about website support
			</button>
        </div>
      </div>
    </div>
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
</script>
<script>
// Get the modal
var modal = document.getElementById('yesModal');

// Get the button that opens the modal
var btn = document.getElementById("btnYes");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

  </body>
</html>