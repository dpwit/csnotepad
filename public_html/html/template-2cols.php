<?
	include($context->findTemplate('/structure/header'));
?>
		<div id="contentMiddle">
			<div id="header">
			<a href="/contact">
			<img alt="Personalised business call handling, telephone answering services and virtual office services from CSnotepad" title="Call handling and telephone answering services from CSnotepad" src="/images/Header2.jpg">
			</a>
			<?php /*} else { ?>
			<img alt="Personalised business call handling, telephone answering services and virtual office services from CSnotepad" title="Call handling and telephone answering services from CSnotepad" src="/images/Header.jpg">
			<?php } */?>
			</div>
			
			<?php $this->renderComponent('main')?>
			<?php //if ($_SERVER['REQUEST_URI'] !== '/') {?>
			<div class="underContent">
				<div class="imagesFotter">
					<a href="http://www.linkedin.com/company/csnotepad/products?trk=tabs_biz_product" target="_blank" title="Linked in"><img src="/images/linkedin.png" style="width: 70px;"></a>
					<img src="/images/fsb.png" >
					<img src="/images/chamber.png">
					<img src="/images/hba.png" class="hba">
				</div>
				<div class="semiFooter">
					<a href="/our-services">
						<img src="images/signup3.jpg" alt="Signup" class="cards">
					</a>
					<a href="/support-contact" rel="fancybox-support" class="fancybox.iframe">
						<button type="submit" name="submit" value="submit" class="bt-support">  Get in Touch  </button>
					</a>

					<?/* else : ?>
					<a href="/our-services">
						<img src="images/signup2.jpg" alt="Signup">
					</a>
					<? endif;*/ ?>
					<span class="footerCallMore">Call now to find out more <strong>01273 741400</strong>.</span>
					<!--<span class="companyNo">CSnotepad is a trading division of Call Solution Ltd Registered in England 6107188.</span>-->
				</div>
			</div>
			<?php // } ?>
		</div>
<?
	include($context->findTemplate('/structure/footer'));
?>
