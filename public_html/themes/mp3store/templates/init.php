<?
	$template = new TemplateComponent("template-2cols");
	$template->addAlias('left','col1');
	$template->addAlias('leftnav','col1');
	$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
	$template->addComponent(Component::get('FileInclude','modules/products/player_freemasons'),'mp3player_freemasons');
	$template->addComponent(Component::get('PageMenu'),'menu');
	$template->addComponent(Component::get('LoginBox','structure/login-summary'),'top');
	$template->addComponent(Component::get('PageMenu',array('show_all'=>1,'template_file'=>'structure/footer-menu')),'footer');
	//$template->addComponent(Component::get('Menu',Model::loadModel('Category')->getAll(array('parent_uid'=>0)),'structure/left-menu'),'left');
	//$template->addComponent(Component::get('CategoryMenu',Model::loadModel('Category')->getAll(array('parent_uid'=>0)),'structure/left-menu'),'left');
	$template->addComponent(Component::get('TextComponent',Config::value('copyright','site')),'bottom');
?>
