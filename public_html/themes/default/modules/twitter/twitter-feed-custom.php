<?php

			/*$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://api.twitter.com/1/users/show/$twitter_id.json");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			$error = curl_error($ch); 
			
			 
			curl_close($ch);      
			$data = json_decode($output);
			$twitter_name = ucwords($data->name);
			$twitter_screen_name = $data->screen_name;
			/*<h2 class="twitter_<?=$twitter_screen_name?>"><a href="http://twitter.com/<?=$twitter_screen_name?>"><?=$twitter_name?></a> on Twitter</h2> */

?>

					<div class="thinBorder twitter box">
						<ul id="twitter_<?=$twitter_id?>">
						 
						
						</ul>
						<a target="_blank" href="http://twitter.com" title="Join the conversation" class="footer">Join the conversation</a>
					</div>
<script>
	$.Boz.Twitter({
		target:'#twitter_<?=$twitter_id?>',
		twitterId:'<?=$twitter_id?>',
		drawHeader : function(user){
			$(this.target).before($(
				<?php if(!$_SESSION['label_uid']) {
					?>'<h2 class="twitter_'+user.screen_name+'">Twitter</h2>'<?php 
				}else { 
					?>'<h2 class="twitter_'+user.screen_name+'">Twitter</h2>'<?php 
				} ?>
			));
		}
		
	});
</script>
