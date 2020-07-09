<?php include($context->findTemplate('structure/header'));?>
<div id="contentMiddle">
		<div id="header">
			<a href="/contact">
			<img alt="Personalised business call handling, telephone answering services and virtual office services from CSnotepad" title="Call handling and telephone answering services from CSnotepad" src="/images/Header2.jpg">
			</a>
			<?php /*} else { ?>
			<img alt="Personalised business call handling, telephone answering services and virtual office services from CSnotepad" title="Call handling and telephone answering services from CSnotepad" src="/images/Header.jpg">
			<?php } */?>
		</div>
	<div id="mainSection">
		<div id="mainSectionFullWidth">
			<? $this->renderComponent('content-header');?>
			<? $this->renderComponent('above-main');?>
			
		</div>
		<div id="mainSection2ColLeft">
			<? $this->renderComponent('main');?>
			<div class="clear"></div>
		</div>
		<div id="mainSection2ColRight">
			<div id="sideBarBoxTop"></div>
			<div id="sideBarBoxMiddle">
				<?php
					include BASEPATH.'../includes/testimonials.php';
				?>
			</div>
			<div id="sideBarBoxBottom"></div>
				<p><br></p>
				<p>
						<a href="/reasons" title="10 reasons why we're better than an answerphone">
							<img width="217" height="75" alt="10 reasons why our call handling services beat answerphone" src="images/answer.jpg" title="10 reasons why we're better than an answerphone" ></a>
						<a href="/Temp" title="10 reasons we're better than a temp">
							<img width="217" height="75" alt="10 reasons why our telephone answering services are better than a temp" src="images/temp.jpg" title="10 reasons we're better than a temp" ></a> 
						<a href="/competition" title="10 reasons why we're better than the competition">
							<img width="217" height="75" alt="10 reasons that our call handling and telephone answering services are better than those of competition" src="images/competition.jpg" title="10 reasons why we're better than the competition" ></a>
				</p>
				<br>
			
	</div>
	<div class="clear"></div>
</div>
<br>
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
			<button type="submit" name="submit" value="submit" class="bt-support">Want help now</button>
		</a>
		<span class="footerCallMore">Call now to find out more <strong>01273 741400</strong>.</span>
		<span class="companyNo">CSnotepad is a trading division of Call Solution Ltd Registered in England 6107188.</span>
	</div>
</div>
</div>

						
<?php include($context->findTemplate('structure/footer'));?>
