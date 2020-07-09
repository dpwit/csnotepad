<?
include($context->findTemplate('pages/products/default'));
BreadCrumb::setBreadCrumb(Model::g('Page',array('title'=>'Shop')));
$template->addComponent(Component::get('ProductBrowse',null,array('perPage'=>12)));
$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');

$context->setTitle('Shop');
?>
