<?
	$template->setTemplate('template-3cols-artists');
	$template->clearSection('col1');
	$template->clearSection('col2');
	$template->clearSection('col3');
	$template->addComponent(Component::get('TextComponent','<h2 class="headerText">Artists</h2>'),'col1');	
	$template->addComponent(Component::get('ArtistMenu'),'leftnav');
	$template->addComponent(Component::get('ArtistProfile',$item),'col2');
	
	$template->addComponent(Component::get('ArtistTop10',$item),'col3' );
	if($item->twitterUsername) 
		$template->addComponent(Component::get('TwitterWidget',$item->twitterUsername),'col3' );
	$template->addComponent(Component::get('GalleryWidget',$item->gallery_uid),'col3' );
	$template->addComponent(Component::get('YoutubeChannel',$item->youtube_ChannelName),'col3' );
	
	$template->addComponent(Component::get('ArtistDiscography',$item),'col3');
?>
