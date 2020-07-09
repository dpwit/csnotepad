<?
	include(dirname(__FILE__)."/default.php");
	$context->setTitle($item->name);
	$template->addComponent(Component::get('ProductDetail',$item),'main');
?>
