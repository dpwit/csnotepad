<html>
<body style='background: white; color: #555555; font-size: 14px; width: 600px;'>
<p style="font-family: Arial; font-size:14px; color: #555555">Dear <?=$this->customer_title?> <?=$this->customer_lastname?></p>

<?php /* <p style="font-family: Arial">Thank you for shopping at <?=Config::value('title','site')?>, your order has been accepted.</p> */ ?>
<p style="font-family: Arial; font-size:14px; color: #555555">Thank you for your order.</p>

<p style="font-family: Arial; font-size:14px; color: #555555">We will be in contact shortly to arrange the setup of your service.</p>

<p style="font-family: Arial; font-size:14px; color: #555555">Order details:</p>

<table><tr><th width="80%" style="border-bottom:4px double black; font-family: Arial; font-size:14px; color: #555555" align="left">Item</th><th width="10%" style="border-bottom:4px double black; font-family: Arial; font-size:14px; color: #555555" align="center">Quantity</th><th width="10%" style="border-bottom:4px double black; font-family: Arial; font-size:14px; color: #555555" align="right">Price</th></tr>
<?

foreach($this->order_items() as $item){
?>
	<tr><td width="80%" style="font-family: Arial; font-size:14px; color: #555555"><?=$item->getLabel()?></td><td width="10%" align="center" style="font-family: Arial; font-size:14px"><?=number_format($item->quantity,0)?></td><td width="10%" align="right" style="font-family: Arial; font-size:14px; color: #555555"><?=$item->getTotalPriceFormatted(false)?></td></tr>
<? } ?>
<tr><td style="font-family: Arial; font-size:14px; color: #555555">Total</td><td>&nbsp;</td><td width="10%" align="right" style="font-family: Arial; font-size:14px"><?=$this->getPrice(true)?></td></tr>

</table>
<?php /*
<p style="font-family: Arial">Your items will be posted to your address in the next 2-3 working days, subject to availability.</p>
<p style="font-family: Arial">If you have ordered any digital products, you can download them by <a href="<?=MASTERURL?>/login.html">logging in</a> to your account and clicking on your recent orders.</p>
*/ ?>
<?
	$products = array();
	$downloadable = array();
	foreach($this->order_items() as $item){
		$product = $item->product();
		if($product instanceof Product)
		foreach($product->getLeafProducts() as $product){
			if($product->isDownloadable())
				$downloadable[] = $product;
		}
	}
	
	if($downloadable && false){
?>
<h2 style="font-family: Arial; color: #555555">Downloadable Products</h2>
<?php /*<p style="font-family: Arial">Some of the products you purchased are digital, you can get these from the following links:</p>*/?>
<p style="font-family: Arial; color: #555555">Your MP3s are ready for you to download. Please login by clicking <a href="<?=MASTERURL?>/login.html">here</a> and go to your recent orders to download them.</p>
<ul>
<? foreach($downloadable as $product) { ?>
	<li><a href='<?=$product->download_link()?>'><?=$product->getLabel()?></a></li>
<? } ?>
</ul>
<? } ?><br>
<br>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Billing Address:</strong> <?=$this->customer_address?>, <?=$this->customer_city?>, <?=$this->customer_country?>, <?=$this->customer_postcode?></p>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Email Address:</strong> <?=$this->customer_email?></p>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Telephone Number:</strong> <?=$this->customer_phone?></p>
<?php /*if(true || extra_checkout_fields::isCMSLoggedIn()){*/ ?>
<br/>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Company Name:</strong> <?=$this->company_name?></p>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Your Role:</strong> <?=$this->company_position?></p>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Company Address:</strong> <?=$this->company_address?></p>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Company Activity:</strong> <?=$this->company_activity?></p>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Company Phone Number:</strong> <?=$this->company_phone?></p>
<br/>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Where You Heard About Us:</strong> <?=$this->refered_from?></p>
<br/>
<p style="font-family: Arial; font-size:14px; color: #555555"><strong>Prefered Contact Method:</strong> <?=$this->prefered_contact?></p>
<? /*}*/ ?>

<span style='font-size:10px;font-family:"Arial","sans-serif";color: #888'>CSnotepad, Gemini House, 136-140 Old Shoreham Road, Brighton, BN3 7BD.</span>
<br>
<strong><span style='font-size:10px;font-family:"Verdana","sans-serif";color:#FF8000'>T: </span></strong>
<span style='font-size:10px;font-family:"Verdana","sans-serif";color:#888'>0330 300 3990 </span>
<strong><span style='font-size:10px;font-family:"Verdana","sans-serif";color:#FF8000'>F: </span></strong>
<span style='font-size:10px;font-family:"Verdana","sans-serif";color: #888'>0330 300 3991</span>
<span style='font-size:10px;font-family:"Verdana","sans-serif";color: #888'><a href="http://www.csnotepad.co.uk/" style='color:#FF8000'>www.csnotepad.co.uk</a></span>
<br>
<span style='font-size:10px;font-family:"Arial","sans-serif";color: #888'>Use of your service constitutes acceptance of our pricing and terms and conditions. CSnotepad is a trading division of Call Solution Ltd Registered in England 6107188.<br></span>
</body>
</html>
