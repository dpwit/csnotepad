<?
	$labelFactory = Model::loadModel('labels');
	$loadedLabel = $labelFactory->getFirst(array('labelname'=>'Loaded'));
	
	$template->setTemplate('template-4cols');
	$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
	$template->addComponent(Component::get('YoutubeVideo',				'olraKYzjSfA'),	'featured');	
	$template->addComponent(Component::get('NewsHome',						9),							'left_col1');
	$template->addComponent(Component::get('Featured',						7),					'left_col2');
	//$template->addComponent(Component::get('LatestMerchandise',		null),					'left_col2');	
	$template->addComponent(Component::get('UpcomingDates',				null,4),					'left_col3');	
	$template->addComponent(new FileInclude(dirname(__FILE__).'/../../mp3store/modules/myspace/myspace-widget.php',array('myspaceAddress'=>'http://www.myspace.com/loadedrecords')),'left_col3');
	$template->addComponent(Component::get('Signup',							'Loaded',4),					'left_col3');	
	$template->addComponent(Component::get('Competition',					2),					'left_col3');	
	$template->addComponent(Component::get('SkintTop10',					null),					'right_col1');	
	$template->addComponent(Component::get('FacebookWidget',	$loadedLabel->facebookID,'fb-widget.css'),		'right_col1');	
	$template->addComponent(Component::get('TwitterWidget_Skint',	$loadedLabel->twitterID),		'right_col1');
	$template->addComponent(Component::get('YoutubeChannelMini',	$loadedLabel->youtubeChannel),'right_col1');
	
	/*
		$template->addComponent(Component::get('TextComponent','<h2 class="headerText">Welcome</h2>'),'col1Header');	
		$template->addComponent(Component::get('FileInclude','modules/news/homepage-featured'),'col2');
		$template->addComponent(Component::get('FileInclude','modules/news/homepage-listing'),'col3');
		$template->addComponent(Component::get('TwitterWidget','skintrecords'),'col3');
		$template->addComponent(Component::get('TextComponent','<div id="columnHeader"><h2 class="headerText" style="margin-bottom:0 !important;">Latest News</h2></div>'),'doubleColHeader');
	*/

?>