<?php
	$videosPath = 'content/videosMain';
	$template->addComponent(new FileInclude($videosPath),'main');
		$context->setTitle('Videos');
?>
