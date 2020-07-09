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
						<a href="/reasons" title="Why we're better than letting calls go to voicemail">
							<img width="217" height="75" alt="Why we're better than letting calls go to voicemail" src="images/answer_blue.jpg" onmouseover=this.src="images/answer_orange.jpg" onmouseout=this.src="images/answer_blue.jpg" title="Why we're better than letting calls go to voicemail" ></a>
						<a href="/Temp" title="Why we're better than employing extra staff">
							<img width="217" height="75" alt="Why we're better than employing extra staff" src="images/temp_blue.jpg" onmouseover=this.src="images/temp_orange.jpg" onmouseout=this.src="images/temp_blue.jpg" title="Why we're better than employing extra staff" ></a> 
						<a href="/competition" title="Why we're better than the competition">
							<img width="217" height="75" alt="Why we're better than the competition" src="images/competition_blue.jpg" onmouseover=this.src="images/competition_orange.jpg" onmouseout=this.src="images/competition_blue.jpg" title="Why we're better than the competition" ></a>
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
			<button type="submit" name="submit" value="submit" class="bt-support">&nbsp;&nbsp;Get in touch&nbsp;&nbsp;</button>
		</a>
		<span class="footerCallMore">Call now to find out more <strong>01273 741400</strong>.</span>
		<!--<span class="companyNo">CSnotepad is a trading division of Call Solution Ltd Registered in England 6107188.</span>-->
	</div>
</div>
</div>

						
<?php include($context->findTemplate('structure/footer'));?>
