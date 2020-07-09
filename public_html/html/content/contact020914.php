
			
			<div id="mainSection">
				
				<div id="mainSection2ColLeft">
					<h2>
						Contact Us<br>
						<br>
                    </h2>
				<div id="contactusgrey">	
					<div id="mainSection2ColLeftContactLeft">
                      <p>Email</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p><a href="mailto:info@csnotepad.co.uk"><img alt="" src="images/email_grey.jpg"></a></p>
                    </div>
                    <div class="clear"></div>
                    <div id="mainSection2ColLeftContactLeft">
                      <p>Address</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p> Gemini House, 136-140 Old Shoreham Road, Brighton, BN3 7BD</p>
                    </div>
                    <div class="clear"></div>
                    <div id="mainSection2ColLeftContactLeft">
                      <p>Telephone</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p>01273 741400<br />

</p>
                    </div>
                    <div class="clear"></div>
                    <div id="mainSection2ColLeftContactLeft">
                      <p>Fax</p>
                    </div>
                    <div id="mainSection2ColLeftContactRight">
                      <p>0330 300 3991</p>
                    </div>
				</div>	
                    <div class="clear"></div>
				
				<br>
                    <br>
					<strong>Or why not let us contact you? Just fill in the form below.</strong><br>
					<br>
					
					<h2>Contact form</h2>
					
					<br>
					
					<form method="post" action="contact-process.php" id="contact-form">
					
					<div id="contactformgrey">	
					<div>
							<label for="interestedIn">I am interested in:</label>
						    <select name="interestedIn">
                              <option value="Telephone Answering Services">Telephone Answering Services</option>
                              <option value="Call Patching">Call Patching</option>
                              <option value="Brochure / Quote Line">Brochure / Quote Line</option>
                              <option value="Order Taking">Order Taking</option>
                              <option value="Voicemail / Information Address">Voicemail / Information Address</option>
                              <option value="Virtual Address">Virtual Address</option>
                              <option value="Outbound Calling">Outbound Calling</option>
                              <option value="Something I haven't seen on your website">Something I haven't seen on your website</option>
                            </select>
					</div>	
						<br>
						<div><label for="name">Name</label><input type="text" size="40" name="name" id="name" value="<?=$_SESSION['contactValues']['name']?>" class="validate[required]"></div>
						<br>
						<div><label for="businessName">Business name</label><input type="text" size="40" name="businessName" id="businessName" value="<?=$_SESSION['contactValues']['businessName']?>"></div>
						<br>
						<div><label for="email">Email</label><input type="text" size="40" name="email" id="email" class="validate[required,custom[email]]" value="<?=$_SESSION['contactValues']['email']?>"></div>
						<br>
						<div><label for="phone">Phone</label><input type="text" size="40" name="phone" id="phone" class="validate[required,custom[onlyNumber]]" value="<?=$_SESSION['contactValues']['phone']?>"></div>
						<br>
						<div>
							<label for="contactBy">Please contact me by:</label>
							<select name="contactBy">
								<option value="Phone">Phone</option>
								<option value="Email">Email</option>
							</select>
						</div>
						<br>
							<div><label for="additionalInfo">Additional info</label><textarea wrap="wrap" cols="40" rows="" name="additionalInfo" id="additionalInfo"  value="<?=$_SESSION['contactValues']['additionalInfo']?>"></textarea></div>
							<br>
						
						<!--<label for="submit">&nbsp;</label>
						<input type="submit" value="Submit" class="coolButton">
						<div align="center"><input name="submit" class="callme" id="callmegreen" type="submit" value="Submit"/></div>-->
						
						<div style="left: 170px; position: relative; visibility: show;"><input name="submit" class="callme" id="callmegreen" type="submit" value="Submit"/></div>
					</form>
					</div>
					
					
	        <br>
					<br>
					
					<p>
						<em><strong>Our core office hours are: </strong><br>
						<br>
					  	Monday - Friday<br>
					  	8.30am - 6pm<br>
						<br>
						Saturday<br>
					  	9am - 3pm<br>
					  	</em>
					</p>
					<p>
						<em>
						<br>
						Telephone answering extended hours are 24/7
						</em>
					</p>
					
					<br>
			    <br>
					<br>
					
				</div>
				<div id="mainSection2ColRight">
					<div id="sideBarBoxTop">
						
					</div>
					<div id="sideBarBoxMiddle">
						<?php
							include BASEPATH.'../includes/testimonials.php';
						?>
					</div>
					<div id="sideBarBoxBottom">
						
					</div>
					<p>
						<a href="/reasons" title="10 reasons why we're better than an answerphone">
							<img width="217" height="75" alt="10 reasons why our call handling services beat answerphone" src="images/answer.jpg" title="10 reasons why we're better than an answerphone" ></a>
						<a href="/temp" title="10 reasons we're better than a temp">
							<img width="217" height="75" alt="10 reasons why our telephone answering services are better than a temp" src="images/temp.jpg" title="10 reasons we're better than a temp" ></a> 
						<a href="/competition" title="10 reasons why we're better than the competition">
							<img width="217" height="75" alt="10 reasons that our call handling and telephone answering services are better than those of competition" src="images/competition.jpg" title="10 reasons why we're better than the competition" ></a>
					</p>
				</div>
				<div class="clear"></div>
				
			</div>