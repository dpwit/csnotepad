<?
include(dirname(__FILE__)."/default.php");
$context->setTitle($item->name);
$template->addComponent(Component::get('ProductBrowse',$item,array('perPage'=>12,'listFunc'=>'products','where'=>array('product_type.abstract'=>0))));
$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
