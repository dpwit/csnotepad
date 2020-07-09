<?
	//BreadCrumb::set($item->getUrl(),$item->getLabel(),Model::g('Page',array('title'=>'Artists'),array('single'=>1)));
	$template->setTemplate('template-3cols-artists');
	//$template->clearSection('col1');
	//$template->clearSection('col2');
	//$template->clearSection('col3');
	$template->addComponent(Component::get('ArtistMenu'),'leftnav');
	$template->addComponent(Component::get('Breadcrumb'),'breadcrumb');
	$template->addComponent(Component::get('ArtistProfile',$item),'col2');
	
	$template->addComponent(Component::get('ArtistGallery',$item->gallery_uid),'col3' );
	$template->addComponent(Component::get('Releases',$item->uid),'col3');
	if($item->twitterUsername) 
		$template->addComponent(Component::get('TwitterWidget_Skint',$item->twitterUsername),'right_col1' );
	$template->addComponent(Component::get('Signup'),'right_col1' );
	if ($item->facebookId)
		$template->addComponent(Component::get('FacebookWidget',$item->facebookId),'right_col2' );
	
	$template->addComponent(Component::get('UpcomingDates',$item->uid),'right_col2');
?>
