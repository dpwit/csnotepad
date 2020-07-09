<?
	//$template->addComponent(Component::get('YoutubeVideo',				'MNKt8RBk4wY'),	'featured');
	$template->addComponent(Component::get('HomePageNews',				null),	'featured');
	$template->addComponent(Component::get('NewsHome',						null),					'left_col1');
	$template->addComponent(Component::get('Featured',						8),					'left_col2');
	$template->addComponent(Component::get('LatestMerchandise',		null),					'left_col2');
	$template->addComponent(Component::get('UpcomingDates',				null),					'left_col3');
	$template->addComponent(Component::get('Signup',							null),					'left_col3');
	$template->addComponent(Component::get('Competition',					null),					'left_col3');
	$template->addComponent(Component::get('SkintTop10',					null),					'right_col1');
	$template->addComponent(Component::get('TwitterWidget_Skint',	'59408149'),		'right_col1');
	$template->addComponent(Component::get('FacebookWidget',	'7580024401','fb-widget.css'),		'right_col1');
	$template->addComponent(Component::get('YoutubeChannelMini',	'SkintRecords'),'right_col1');
	
	/*
		$template->addComponent(Component::get('TextComponent','<h2 class="headerText">Welcome</h2>'),'col1Header');	
		$template->addComponent(Component::get('FileInclude','modules/news/homepage-featured'),'col2');
		$template->addComponent(Component::get('FileInclude','modules/news/homepage-listing'),'col3');
		$template->addComponent(Component::get('TwitterWidget','skintrecords'),'col3');
		$template->addComponent(Component::get('TextComponent','<div id="columnHeader"><h2 class="headerText" style="margin-bottom:0 !important;">Latest News</h2></div>'),'doubleColHeader');
	*/

?>
