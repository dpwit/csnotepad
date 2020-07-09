<?php
	$template->setTemplate('template-4cols');
	$template->addComponent(Component::get('FileInclude','modules/products/player'),'mp3player');
	$template->addComponent(Component::get('YoutubeVideo',				'lOBRcG-Dhtg'),	'featured');
	$template->addComponent(Component::get('NewsHome',						9,true),					'left_col1');
	$template->addComponent(Component::get('Featured',						7),					'left_col2');
	//$template->addComponent(Component::get('LatestMerchandise',		null),					'left_col2');	
	$template->addComponent(Component::get('UpcomingDates',				null,4),					'left_col3');
	$template->addComponent(new FileInclude(dirname(__FILE__).'/../../mp3store/modules/myspace/myspace-widget.php',array('myspaceAddress'=>'http://www.myspace.com/skintrecords')),'left_col3');
	$template->addComponent(Component::get('Signup',						'Skint',3),				'left_col3');	
	$template->addComponent(Component::get('Competition',					null),					'left_col3');	
	$template->addComponent(Component::get('SkintTop10',					null),					'right_col1');	
	$template->addComponent(Component::get('FacebookWidget',	'7580024401','fb-widget.css'),'right_col1');	
	$template->addComponent(Component::get('TwitterWidget_Skint',	'59408149',3),		'right_col1');	
	$template->addComponent(Component::get('YoutubeChannelMini',	'SkintRecords'),'right_col1');	
?>