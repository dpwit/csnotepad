<?
include($context->findTemplate('pages/products/default'));
BreadCrumb::setBreadCrumb(Model::g('Page',array('title'=>'Our Services')));
$template->addComponent(Component::get('CategoryListing',null,array('perPage'=>Config::value('per_page','products'))));
$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
$context->setTitle('Our Services');
?>