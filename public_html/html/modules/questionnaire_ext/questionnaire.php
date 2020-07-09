<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php
/*
	<TODO>
		Make sure all labels are labels
		wire up the form with validation
	</TODO>
*/


$items = $order->order_items(array('ref_table'=>'products'));
$products = array();
foreach($items as $item)
	if(
		($product = $item->product()) &&
		($product instanceof ProductModel)
	){
		if(
			($product instanceof ProductVariation) &&
			($parent = $product->variationOf())
		)
			$product = $parent;
		$products[] = $product;
	}

/*
$telephone_answering = true;
$virtual_address = true;
$call_patching = true;
$virtual_phone_number = true;
$order_taking = true;
$voicemail = true;
*/

$keys = array(
	'telephone_answering',
	'virtual_address',
	'call_patching',
	'virtual_phone_number',
	'order_taking',
	'voicemail'
);

foreach($keys as $key)
	${$key} = isset($_GET[$key]);


/*foreach($products as $product) {
	echo '<h2>';
	foreach($product->categories() as $cat)
		echo $cat->getLabel();
	echo ' - ';
	echo $product->getLabel();
	echo '</h2>';
}*/
?>
<h1 class="blueHeading">Online sign up</h1>
<p>Please complete the details below to the best to of your ability and click send form.</p>
<div id="mainSection">

	<style>
		h2 {margin-top: 10px;}

		.questionnaire {overflow:hidden;}

		input[type=text] {width:220px; padding: 5px;}
		input[type=checkbox] {float: left; border: 0px;}
		input[type=radio] {float: left; border: 0px;}
		.agroupofitems {float: left;}
		textarea {width: 400px; max-width: 600px; height: 140px; max-height:300px; padding: 5px;}
		.questionnaire label { clear:left; line-height: 22px; width: 250px; text-align: right; margin-right: 20px; font-weight: bold;}

		.formfield.first {border-top: 1px solid #ccc; margin-top: 10px;}
		.formfield { border-bottom: 1px solid #ccc; padding: 10px; overflow: hidden;}
		.formfield:nth-child(odd) {background: #F3F3F3;}

		label sub {display: block; font-weight: 100; font-size: 10px;}
		.questionnaire ul li { list-style: circle outside }
		.questionnaire { margin-bottom:30px; }


		fieldset {display: block; margin-bottom: 5px;}
		label.checkboxlabel {float: left; clear: none; padding-left: 10px; width:  80px; text-align: left; height: 28px; font-weight: 100;}
		label.checkboxlabel.maily {width:  245px;}
		label.checkboxlabelnotick {float: left; clear: none; padding-left: 10px; text-align: left;width: auto; font-weight: 100;}
		.checkbox_enabled {float: left;}
		.checkbox_enabled label {width: auto; font-weight: bold; bordeR-left: 1px solid #ddd; padding-left: 10px;}
		fieldset input[type="text"] {width: 180px;}

		.questionnaire ul {list-style: outside disc; margin-left: 30px; margin-bottom: 10px;}

		.clearButton {display: block; margin-top: 10px;}
		.sigWrapper.current {border-color: #ccc;}
		.questionnaire .sigWrapper { width: 250px; height: 100px;}

		.callme {margin-top: 10px; float: right;}

		.byclicking {margin-top: 10px; display: block; line-height: 50px; font-size: 14px;}
	</style>
	<form action="/questionnaire/submit" method="POST" class="questionnaire" >

		<input type="hidden" name="post_key" id="post_key" value="questionnariesubmit" />
		<input type="hidden" name="orderuid" id="orderuid" value="<?=$order->uid;?>" />

		<div class="formfield first">
			<label>Business Name</label>
			<input type="text" name="business_name" />
		</div>
		<div class="formfield">
			<label>Contact Name</label>
			<input type="text" name="contact_name">
		</div>
		<div class="formfield">
			<label>Correspondence Address - For Customers</label>
			<textarea name="correspondence_address_customer"></textarea>
		</div>
		<div class="formfield">
			<label>Correspondence Address - Internal Use</label>
			<input type="text" name="correspondence_address_internal" />
		</div>
		<div class="formfield">
			<label>Business Contact Number</label>
			<input type="text" name="business_contact_number" />
		</div>
		<div class="formfield">
			<label>2nd Contact Number - Use In Event of Problem</label>
			<input type="text" name="business_contact_number_2" />
		</div>
		<div class="formfield">
			<label>Fax</label>
			<input type="text" name="fax" />
		</div>
		<?php if($telephone_answering || $call_patching || $order_taking){ ?>
			<div class="formfield">
				<label>Email Address - For Customers</label>
				<input type="text" name="email_customer" />
			</div>
		<? } ?>
		<div class="formfield">
			<label>Email Address - For Internal Use</label>
			<input type="text" name="email_internal" />
		</div>
		<div class="formfield">
			<label>Website</label>
			<input type="text" name="website" />
		</div>

		<!-- END OF PAGE 1 OF SCANS -->

		<?php if($telephone_answering || $call_patching || $order_taking || $voicemail) { ?>
			<div class="formfield">
				<label>How you Would Like Your Telephone Calls Answered<sub>"Good morning, ABC. How may I help you?</sub></label>
				<textarea name="message_answer"></textarea>
			</div>
		<?php } ?>
		<?php if($telephone_answering || $call_patching || $order_taking) { ?>
			<div class="formfield">
				<label>Your Status When You Are Unavailable</label>
				<textarea name="message_unavailable"></textarea>
			</div>
			<div class="formfield">
				<label>How Would You Like Your Messages Delivered</label>
				<fieldset>
					<input type="checkbox" class="checkbox_enabled" name="delivery_by_email" id="delivery_by_email" value="Email"><label for="delivery_by_email" class="checkboxlabel">Email</label>
					<div class="checkbox_enabled">
						<label>Your Email Address for Messages</label>
						<input type="text" name="delivery_email" />
					</div>
				</fieldset>
				<fieldset>
					<input type="checkbox" class="checkbox_enabled" name="delivery_by_text" id="delivery_by_text" value="Text"><label class="checkboxlabel" for="delivery_by_text">Text</label>
					<div class="checkbox_enabled">
						<label>Your Mobile Number for Messages</label>
						<input type="text" name="delivery_text" />
					</div>
				</fieldset>
			</div>
			<div class="formfield">
				<label>Email Address For Your Daily Summary</label>
				<input type="text" name="summary_email" />
			</div>
			<div class="formfield">
				<label>List of Staff Members - So We May Determine Wrong Numbers</label>
				<textarea name="staff_list"></textarea>
			</div>
		<?php } ?>
		<?php /*if($call_patching){ ?>
			<div class="formfield">
				<label>Staff Mobile Numbers for Call Patching</label>
				<textarea name="staff_mobiles"></textarea>
			</div>
		<?php }*/ ?>
		<?php if($telephone_answering || $call_patching || $order_taking) { ?>
			<div class="formfield">
				<label>Directions to your Premises to Assist Any visitors/Deliveries</label>
				<textarea name="directions"></textarea>
			</div>
			<div class="formfield">
				<label>Opening Times</label>
				<textarea name="opening_times"></textarea>
			</div>

			<!-- END OF PAGE 2 OF SCANS -->

			<div class="formfield">
				<label>Any Other FAQ to Assist Customers</label>
				<textarea name="faq"></textarea>
			</div>
			<div class="formfield">
				<label>Information You Would Like Obtained From Callers.</label>
					<div class="agroupofitems">
					<fieldset><input type="checkbox" name="caller_information[]" id="cicallername" value="Caller Name" /><label class="checkboxlabelnotick" for="cicallername">Caller Name</label></fieldset>
					<fieldset><input type="checkbox" name="caller_information[]" id="cicompname" value="Company Name" /><label class="checkboxlabelnotick" for="cicompname">Company Name</label></fieldset>
					<fieldset><input type="checkbox" name="caller_information[]" id="citelno" value="Telephone Number" /><label class="checkboxlabelnotick" for="citelno">Telephone Number</label></fieldset>
					<fieldset><input type="checkbox" name="caller_information[]" id="ciemail" value="Email Address" /><label class="checkboxlabelnotick" for="ciemail">Email Address</label></fieldset>
					<fieldset><input type="checkbox" name="caller_information[]" id="cireason" value="Reason For Call" /><label class="checkboxlabelnotick" for="cireason">Reason For Call</label></fieldset>
					<fieldset>
						<input type="checkbox" class="checkbox_enabled" id="ciother" /><label class="checkboxlabel" for="ciother">Other</label>
						<div class="checkbox_enabled">
							<label>Other Information to Gather</label>
							<input type="text" name="caller_information_other" />
						</div>
					</fieldset>
				</div>
			</div>
		<?php } ?>
		<div class="formfield">
			<label>Any Other Information We May find Useful<sub>If you have no website please include an outline of what your business does here.</sub></label>
			<textarea name="other_information"></textarea>
		</div>
		<?php if($telephone_answering || $call_patching || $order_taking) { ?>
			<div class="formfield">
				<label>The Cover You Require</label>
				<div class="agroupofitems">
					<?php
						$days = array(
							"Monday",
							"Tuesday",
							"Wednesday",
							"Thursday",
							"Friday",
							"Saturday"
						);
						foreach($days as $day)
						{ ?><fieldset><input type="checkbox" name="cover_days[]" value="<?=$day?>" id="<?=$day?>" /><label class="checkboxlabelnotick" for="<?=$day?>"><?=$day?></label></fieldset><?php }
					?>
				</div>
			</div>
			<div class="formfield">
				<label>How Your Calls Will Reach Us.</label>
				<div class="agroupofitems">
					<fieldset><input type="checkbox" name="call_source[]" value="divert_line" id="divert_line" /><label class="checkboxlabelnotick" for="divert_line">I have a divert on my telephone line.</label></fieldset>
					<fieldset><input type="checkbox" name="call_source[]" value="divert_system"id="divert_system" /><label class="checkboxlabelnotick" for="divert_system">I have a divert on my telephone system.</label></fieldset>
					<fieldset><input type="checkbox" name="call_source[]" value="forward" id="forward" /><label class="checkboxlabelnotick" for="forward">I will forward my own non-geographic number to you.</label></fieldset>
					<fieldset><input type="checkbox" name="call_source[]" value="direct" id="direct" /><label class="checkboxlabelnotick" for="direct">I will provide the number you give me directly to customers.</label></fieldset>
				</div>
			</div>
		<?php } ?>
		<?php if($virtual_address) { ?>

			<h2>Business Details</h2>

			<div class="formfield first">
				<label>Your Business Type</label>
				<div class="agroupofitems">
					<fieldset><input type="radio" name="business_type" value="sole trader" id="sole_trader" /><label class="checkboxlabelnotick" for="sole_trader">Sole Trader</label></fieldset>
					<fieldset><input type="radio" name="business_type" value="partnership" id="partnership" /><label class="checkboxlabelnotick" for="partnership">Partnership</label></fieldset>
					<fieldset><input type="radio" name="business_type" value="ltd" id="ltd" /><label class="checkboxlabelnotick" for="ltd">Private Limited Company (Ltd)</label></fieldset>
					<fieldset><input type="radio" name="business_type" value="plc" id="plc" /><label class="checkboxlabelnotick" for="plc">Public Limited Company (Plc)</label></fieldset>
					<fieldset><input type="radio" name="business_type" value="other" id="other" /><label class="checkboxlabel" for="other">Other</label><input type="text" name="business_type_other" />
				</div>
			</div>
			<div class="formfield">
				<label>Registered Name of the Business</label>
				<input type="text" name="registered_business_name" />
			</div>
			<div class="formfield">
				<label>Trading Name of the Business<sub>If different to registered business name above</sub></label>
				<input type="text" name="business_trade_name" />
			</div>
			<div class="formfield">
				<label>Business Website</label>
				<input type="text" name="registered_company_number" />
			</div>
			<div class="formfield">
				<label>Registered Company Number <sub>Ltd & Plc only</sub></label>
				<input type="text" name="registered_company_number" />
			</div>
			<div class="formfield">
				<label>VAT Number<sub>If applicable</sub></label>
				<input type="text" name="vat_number" />
			</div>
			<div class="formfield">
				<label>Registered Office Address</label>
				<input type="text" name="registered_office_address" />
			</div>
			<div class="formfield">
				<label>Trade Address<sub>If different to your registered business address above</sub></label>
				<input type="text" name="trade_address" />
			</div>

			<!-- DIRECTOR / PARTNET / OWNER Details -->

			<h2>Director / Partner / Owner Details</h2>

			<div class="formfield first">
				<label>Title</label>
			<div class="agroupofitems">
					<?php
						$titles = array(
							'Mr',
							'Mrs',
							'Miss',
							'Ms',
							'Dr',
							'Rev'
						);
						foreach($titles as $title)
						{ ?><input type="radio" name="title" value="<?=$title?>" id="<?=$title?>" /><label class="checkboxlabelnotick" for="<?=$title?>"><?=$title?></label><?php }
					?>
				</div>
			</div>
			<div class="formfield">
				<label>First Names<sub>Including middle names</sub></label>
				<input type="text" name="first_names" />
			</div>
			<div class="formfield">
				<label>Surname</label>
				<input type="text" name="surname" />
			</div>
			<div class="formfield">
				<label>Telephone Numbers</label>
			</div>
			<div class="formfield">
				<label>Home</label>
				<input type="text" name="home_telephone" />
			</div>
			<div class="formfield">
				<label>Work</label>
				<input type="text" name="work_telephone" />
			</div>
			<div class="formfield">
				<label>Mobile</label>
				<input type="text" name="mobile_telephone" />
			</div>

			<h2>ID</h2>

<h3>Money Laundering Regulations 2007 (as updated) and the London
Local Authorities Act 2007 (where applicable).<h3>
<p>We would be grateful if you would take the time to complete the following
form. We are required to verify the identity of both your customer and their
business. This is a statutory obligation imposed on us under the Money
Laundering Regulations 2001 (as updated) and where applicable the London
Local Authorities Act 2007 which relate to mail forwarding businesses. We will
check against other databases (public or otherwise) to verify the information
provided in this form by you. By signing the form you give us the authority to
do this.</p>
<h3>Data Protection Act 1998 (the Act)</h3>
<p>The information on this form will be used to verify the identity of your
customer and their business. The information will be held on our client file
and database systems.It will not be passed on to any third party without your
consent unless we are required to do so by law or regulation. We will store
the information and our verification for a period of 5 years after which it will
be destroyed.</p>
			<p>Please provide recent (dated within 3 months) and legible photocopies or scanned copies of at least two (one photo ID and one proof of address) of the following to confirm your customer identity:</p>

			<h3>Photo Identification:</h3>

			<ul>
				<li>Passport</li>
				<li>Driving Licence</li>
				<li>National Identity Card</li>
				<li>HM Forces Identity Card</li>
			</ul>

			<h3>Proof of Residence:</h3>

			<ul>
				<li>Gas or Electricity Bill</li>
				<li>Telephone (Landline) Bill</li>
				<li>Water Bill</li>
				<li>Mortgages Statement</li>
				<li>Council Tax Bill</li>
				<li>Bank/Building Society Statement</li>
				<li>TV Licence</li>
			</ul>

			<h2>Postal Requirements</h2>

			<div class="formfield first">
				<label>Would you like your mail</label>
				<div class="agroupofitems">
					<fieldset><input type="radio" name="mail_forwarding_method" value="Forwarded" id="Forwarded" /><label class="checkboxlabelnotick" for="Forwarded">Forward</label></fieldset>
					<fieldset><input type="radio" name="mail_forwarding_method" value="Collected" id="Collected" /><label class="checkboxlabelnotick" for="Collected">Collected</label></fieldset>
					<fieldset><input type="radio" name="mail_forwarding_method" value="Scanned and Emailed" id="scanned" /><label class="checkboxlabel maily" for="scanned">Scanned &amp; Emailed (to following address)</label><input type="text" name="mail_forwarding_email"></fieldset>
					<fieldset><input type="radio" name="mail_forwarding_method" value="Other" id="Other" /><label class="checkboxlabel maily" for="Other">Other</label><input type="text" name="othermail"></fieldset>
					</div>
			</div>
		<?php } ?>

		<h2>Agreement</h2>
		<p>To read the Terms &amp; Conditions, please click below:</p>

		<div id="accordion">

			<h3><a href="#">Terms &amp; Conditions</a></h3>
			<div>
				<ol class="content-ol">
					<strong>General</strong>

					<li>This agreement is between Call Solution Ltd trading as CSnotepad (“us”, “we” or “our”) and you (“you” or “your”), as an authorised user of our services, and governs the terms and conditions of your use of our services.</li>
					<li>We may change or supplement these terms and conditions from time to time, including, without limitation, the charges. We will ensure that any such changes or supplements are made reasonably apparent to you by emailing you on the e-mail address you supply us at least 1 month in advance. If we do change or supplement these terms and conditions then you may terminate this Agreement in accordance with the provisions set out below. Otherwise you will be bound by such changes or supplements.</li>
					<li>Our terms and conditions apply to all our services offered. It is your responsibility to familiarise yourselves with all relevant terms and conditions.</li>
					<li>These Terms and Conditions apply to Call Solution Ltd, Gemini House, 136-140 Old Shoreham Road, Brighton, BN3 7BD and are subject to English Law.</li>

					<strong>Service</strong>

					<li>We will advise you regarding the information that is required to fulfil the role and the parameters of our service.</li>
					<li>All information and other facilities reasonably requested by us to enable us to perform our service shall be supplied by you within reasonable timescales and any information or data supplied by you shall be accurate and sufficient to enable us to perform the services as agreed. You maintain responsibility for full payment of our services in the event of a delay in providing or failure to provide the necessary information and facilities.</li>
					<li>We reserve the right not to begin work until any specified sign up process is completed.</li>
					<li>You must be of at least 18 years of age to use our service and agree not to use our service for any illegal, immoral, obscene or defamatory purpose. If you do so you acknowledge that we may report to law enforcement and/or other relevant authorities. If inappropriate uses are suspected, we reserve the right to cancel your service without notice and report to law enforcement and/or other relevant authorities.</li>
					<li>To use our virtual address service you must provide copies of your: photographic ID, proof of address (for where mail is to be forwarded to) and company registration certificate (if the company is limited).</li>
					<li>You are charged a monthly fee as well as a call charge for calls taken on your behalf and/or a mail charge for mail forwarded on to you at the rate applicable to your call/virtual address plan. You will also be charged for any additional services that are taken up, including but not exclusive to SMS services, voicemail, call patching, etc. You will be liable for all calls that agents take and you are subsequently invoiced. Changes to your account after your initial set up and any retraining are charged at £20.00 per hour in increments of 1 hour at our discretion. We cannot be held liable for any costs incurred by you during the contract.</li>
					<li>We reserve the right to terminate a call if the caller is abusive or proper communication is not possible.</li>
					<li>Mail held for collection may only be collected by persons for whom we have received prior authorisation from the service  holder in the form of a clear copy of photographic identification such as passport or driving license.  We reserve the right to refuse the request if we have any reasonable concern over the identity of the person collecting the mail.</li>
					13.	We are dedicated to providing you with a quality service. However in the unlikely event you should have a complaint with regard to CSnotepad please e-mail customerservice@csnotepad.co.uk. We will investigate your complaint and notify you within 2 working days of receipt of your e-mail as to the time needed to resolve the complaint.</li>

					<strong>Payment</strong>

					<li>Standard terms for our service are payments by credit or debit card.</li>
					<li>Deposit monies may be requested for any service. Valid credit or debit card details must be provided before set up can be enabled. We only accept certain credit or debit cards, which we will inform you of upon your request. All new customers must provide these details before they are able to commence use of our service. By supplying credit or debit card details you accept and agree to allow us to save these details and take monies via debit or credit card for all monies due and outstanding monies owing. Failed transactions due to insufficient funds or non-automated payments such as cheques will incur an administration fee of £12.00 per transaction.</li>
					<li>For customers on a plan where no initial payment is required, non-refundable call credit to the value of £27.00 must be purchased in advance of use of service. A minimum charge of 10 calls per month applies on all call plans.</li>
					<li>All late payments will be subject to 5% compound interest on a daily basis. All costs of recovery will be paid for by you, including the administrative costs of recovery. We reserve the right to charge administration fees for recovery of all late payments.</li>
					<li>In order to be eligible for credit terms, you may be required to supply two trade references and a bank reference. Should late payment occur you will not be eligible for credit terms in the future. Should we incur any additional costs in order to recover outstanding debts then these costs will be added to the total amount due.</li>
					<li>If you fail to make any payment on the date due then we shall be entitled, without prejudice and without liability, to cancel or suspend the contract and/or with hold any data, property and information we have in our possession without notice. A suspended service due to non payment is charged as per an active service.</li>
					<li>You must ensure that your payment and contact details are kept up to date and any changes not notified that result in a manual process will incur a £12.00 administration fee.</li>
					<li>All our prices are subject to Value Added Tax (VAT).</li>

					<strong>Privacy &amp; Compliance</strong>

					<li>You are wholly responsible for providing us with data that is compliant of any legislation and take full responsibility for data compliance.</li>
					<li>We will not hold data any longer than necessary.</li>
					<li>We may share your information when required by law or in the prevention or detection of crime.</li>

					<strong>Liability &amp; Exclusions</strong>

					<li>Subject, as expressly provided in these conditions, all warranties, conditions and other terms implied by statute or common law are excluded to the fullest extent permitted by law. We shall not accept liability for consequential loss, and we shall not be liable to you for any act or omission or for any breach of the contract if such due to any cause beyond our reasonable control. We do not pay compensation.</li>
					<li>Whilst every reasonable effort is made to ensure that staffing requirements match your call volumes, we cannot offer any guarantees on staffing levels. We reserve the right to call record.</li>
					<li>We accept no liability whatsoever for the content of any verbal communication on behalf of you although we will always endeavour to represent your organisation in a professional manner.</li>
					<li>We agree to provide you with a telephone answering service (when purchased) where all reasonable efforts will be made to ensure that accurate data is recorded and your customers' requirements are fulfilled. We also agree to provide you with a postal address (when purchased) to which your mail can be sent. We will subsequently forward mail to you within 1 working day by first class post or where the method of receipt is more expeditious mail will be dispatched by a service of equal effect.</li>
					<li>We use third parties and while all reasonable measures will be taken by us to maintain levels of service, we cannot guarantee or be held liable in full or in part to the level of </li>service provided by these parties.</li>
					<li>We cannot accept any liability for any third party transaction on behalf of you. Any disputes must be taken up with the third party. You shall absolve us of any responsibility for any cost, claims, liabilities and expenses suffered or incurred by you as a result of this business relationship.</li>
					<li>Whilst we have stringent quality control procedures in place we work within a normal tolerance level for errors of around 5%. This applies to all aspects of the business including IT, systems, human error etc. If we fail to deliver the service for any reason other than any cause beyond our reasonable control over and above the tolerance level, our liability (if any) shall be limited to a refund on monies paid in advance for the job or service.</li>

					<strong>Disputes &amp; Termination</strong>

					<li>The minimum contract period for all contracts is two months unless otherwise agreed.</li>
					<li>Termination and notice terms are subject to one month notice which commences from the end of the month notice is given.</li>
					<li>Monthly subscriptions recur on the first day of each calendar month. Annual subscriptions recur annually on the anniversary of the agreement. Termination notices must be received at least one calendar month before recurrence.</li>
					<li>We shall, without prejudice, be entitled to amend/terminate your contract or service without liability by notice given at any time.</li>
					<li>If there is any query or dispute with any invoice, this must be raised within 28 days of the date of invoice in writing, otherwise the invoice will be deemed to be accepted by you and there will be no further redress whatsoever.</li>
					<li>Written documentation is the only accepted method to serve notice and this must be sent to us via recorded delivery or emailed and acknowledged for the avoidance of all doubt.</li>
					<li>Fees will continue to be invoiced and due for payment until the termination notice is received in the format stated in these terms and conditions and the notice period has expired.</li>
				</ol>
			</div>
		</div>
		<script>
			$(function() {
				$( "#accordion" ).accordion({
					collapsible: true,
					autoHeight: false,
					active: false
				});
			});
		</script>

		<div class="formfield first">
			<label for="name">Tick here to confirm you’re happy to proceed with this agreement</label>
			<input type="checkbox" name="agree_agreement" id="agree_agreement" class="agree_agreement">
		</div>

		<input type="submit" value="Send Form" id="callmegreen" class="callme">
	</form>

	<script>
		$(document).ready(function(){
			$('div.checkbox_enabled').hide();

			var checkbox_hide_show = function(){
				$('input.checkbox_enabled').each(function(i,e){
					var self = $(e);
					var target = self.nextAll('div.checkbox_enabled').first();

					if(self.attr('checked'))
						target.show();
					else
						target.hide();
				});
			}

			checkbox_hide_show();

			$('input.checkbox_enabled').click(checkbox_hide_show);
		});
	</script>
</div>