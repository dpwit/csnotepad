					<?php 
						// two variables being used:
							// $name
							// $listId
						$artistName = ($name)? '<strong>' . $name . ' </strong>' : ''; 
					?>
					<div class="thinBorder box" id="signUp">
						<h2 class="signupH2">
							<big>Sign Up</big>
							<span>to the <?=$artistName?>mailing List</span>
						</h2>
						<form id="signUpForm" action="/lists/newsletteradduser.php" method="post">
							<fieldset>
								<label>Name</label> <input type="text" name="name" id="nameForm">
								<label>Email</label> <input type="text" name="email" id="emailForm">
								<input type="hidden" name="listId" value="<?=$listId?>" />
								<input type="submit" class="go" value="Go" title="Submit Form">
							</fieldset>
						</form>
						<div id="ajaxReturn"></div>
					</div>
