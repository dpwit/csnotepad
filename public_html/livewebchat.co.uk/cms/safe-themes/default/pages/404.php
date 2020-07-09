<?
	header("HTTP/1.0 404 Not Found");
	//$template->addComponent(Component::get('Text','404 - Page Not Found'),'main');
	$path = 'content/404';
	$template->addComponent(new FileInclude($path),'main');
		$context->setTitle('Page Not Found');

?>
