<?
include(dirname(__FILE__)."/default.php");
$context->setTitle($item->name);
$template->addComponent(Component::get('ProductBrowse',Model::loadModel('Product'),array('perPage'=>12,'listFunc'=>'getAll')));
$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
