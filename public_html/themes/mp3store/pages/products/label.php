<?
include($context->findTemplate('pages/products/default'));
$context->setTitle($item->name);
$template->addComponent(Component::get('ProductBrowse',Model::loadModel('Product'),array('perPage'=>12,'listFunc'=>'getAll')));
$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
