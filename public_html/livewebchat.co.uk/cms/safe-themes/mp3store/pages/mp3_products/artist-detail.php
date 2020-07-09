<?
	//BreadCrumb::set($item->getUrl(),$item->getLabel(),Model::g('Page',array('title'=>'Artists'),array('single'=>1)));
	$template->setTemplate('template-3cols-artists');
	//$template->clearSection('col1');
	//$template->clearSection('col2');
	//$template->clearSection('col3');
	$template->addComponent(Component::get('ArtistMenu'),'leftnav');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb'); 
	$template->addComponent(Component::get('ArtistProfile',$item),'col2');
	
	if ($item->gallery_uid)
	$template->addComponent(Component::get('ArtistGallery',$item->gallery_uid),'col3' );
	$template->addComponent(Component::get('Releases',$item->uid),'col3');

	if($item->myspaceAddress)
		$template->addComponent(new FileInclude(dirname(__FILE__).'/../../modules/myspace/myspace-widget.php',array('myspaceAddress'=>$item->myspaceAddress)),'right_col1');

	if($item->twitterUsername) 
		$template->addComponent(Component::get('TwitterWidget_Skint',$item->twitterUsername),'right_col1' );
	
	$subscribeName = ($item->listId > 4)? $item->name : $item->label()->labelname;
	$template->addComponent(Component::get('Signup',$subscribeName,$item->listId),'right_col1' );
	
	if ($item->facebookId) {
		$usingBlack = array('Mirrors','Goose','Alloy Mental','Midfield General','Dave Clarke');
		$cssFile = 'fb-widget.css'; 
		foreach($usingBlack as $artist) {
			if ($item->name == $artist) {
				$cssFile = 'fb-skintentertainment.css';
				break;
			}
		}
		$template->addComponent(Component::get('FacebookWidget',$item->facebookId,$cssFile),'right_col2' );
	}
	if(Model::loadModel('Events')->getFirst(array('artist_uid'=>$item->uid,'date >'=>date('Y-m-d')),array()))
		$template->addComponent(Component::get('UpcomingDates',$item->uid,5),'right_col2');

	$context->setTitle($item->name);

?>
