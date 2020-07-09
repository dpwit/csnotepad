<?php

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://api.twitter.com/1/users/show/$twitter_id.json ");
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
						<?php 
							if(!$_SESSION['label_uid']) {
								?><h2 class="twitter_<?=$twitter_screen_name?>"><a href="http://twitter.com/<?=$twitter_screen_name?>"><?=$twitter_name?></a> Twitter</h2><?php 
							}else { 
								?><h2 class="twitter_<?=$twitter_screen_name?>">Twitter</h2><?php 
							} ?>
						<ul>
						 
						
							<?php
			//$twitter_id = $object->twitter_id;
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://twitter.com/statuses/user_timeline/$twitter_id.json");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			$error = curl_error($ch);
			curl_close($ch);      
			$pattern = "@\b(https?://)?(([0-9a-zA-Z_!~*'().&=+$%-]+:)?[0-9a-zA-Z_!~*'().&=+$%-]+\@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-zA-Z_!~*'()-]+\.)*([0-9a-zA-Z][0-9a-zA-Z-]{0,61})?[0-9a-zA-Z]\.[a-zA-Z]{2,6})(:[0-9]{1,4})?((/[0-9a-zA-Z_!~*'().;?:\@&=+$,%#-]+)*/?)@";
			$data = json_decode($output);
			$counter = 0;

			//var_dump($error);
			//var_dump($data);

			foreach($data as $index => $post){
				if(!$post->user){
					continue;
				}
				
				//var_dump($post);
				
				$postDate = strtotime($post->created_at) + strtotime('1970-01-01 02:00:00');
				$nowDate = strtotime(date('Y-m-d H:i:s O'));
				
				$difference = $nowDate - $postDate;
				
				//var_dump(date('Y-m-d H:i:s O',$difference));
				//var_dump($post->created_at);
				
				
				//var_dump($difference < strtotime('1970-01-01 00:01:00'));
				//var_dump($difference < strtotime('1970-01-01 01:00:00'));
				//var_dump($difference < strtotime('1970-01-02 00:00:00'));
				
				$timeSincePost = '';
				if($difference < strtotime('1970-01-01 00:01:00'))
					$timeSincePost = date('s',$difference) . " seconds ago";
				else if($difference < strtotime('1970-01-01 01:00:00'))
					$timeSincePost = date('i',$difference) . " minutes ago";
				else if($difference < strtotime('1970-01-02 00:00:00'))
					$timeSincePost = date('H',$difference) . " hours ago";
				else
					$timeSincePost = date('G:i A M jS',$postDate);

				//BEGIN REGEX - Convery urls to <a>'s - http://www.phpro.org/examples/URL-to-Link.html
				/*** make sure there is an http:// on all URLs ***/
				$post->text = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2",$post->text);
				/*** make all URLs links ***/
				$post->text = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a rel=\"nofollow\" target=\"_blank\" href=\"$1\">$1</A>",$post->text);
				/*** make all emails hot links ***/
				$post->text = preg_replace("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<A rel=\"nofollow\" HREF=\"mailto:$1\">$1</A>",$post->text);
				//END REGEX
				
				if ($counter >= 3 || $counter==count($data)-1) { $last = ' class="last"'; }
				
				?>
					<!--<div class="TweetItem">
						<p class="TwitterText"><span class="TwitterName"><?=$post->user->name?></span> </p>
						<span class="TweetTime"><?=$timeSincePost?> via <?=$post->source?></span>
					</div>-->
							<li<?=$last?>>
								<p><?=$post->text?></p>
								<small><?=$timeSincePost?> via <?=$post->source?> <span><a href="http://twitter.com/?status=@<?=$twitter_screen_name?>%20&in_reply_to_status_id=<?=$post->id?>&in_reply_to=<?=$twitter_screen_name?>">reply</a></span></small>
							</li>
				<?php
				if($counter++==3) break;
			}
		?>
						</ul>
						<a href="http://twitter.com" title="Join the conversation" class="footer">Join the conversation</a>
					</div>
