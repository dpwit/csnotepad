<?php
	$urlParts = array_push(explode('http://',$weblink);
	$myspaceUser = $myspaceParts[1];
	if (strpos($weblink, 'http://') === 0) {
		$niceLink = substr($weblink,strlen('http://');
		if (strpos($niceLink, 'www.') === 0) {
			$niceLink = substr($niceLink,strlen('www.'));
		}
	}
?>
						<div class="thinBorder myspace box">
							<h2>Homepage</h2>
							<a href="<?=$weblink?>" rel="nofollow" target="_blank"><?=$niceLink?></a>
						</div>