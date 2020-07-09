				<div class="thinBorder eventsList box" id="artistsList">
					<h2>Upcoming Events</h2>
					<ul>
<?
$eventFactory = Model::loadModel('events');
$where = array();
$where['status'] = 1;
$events = $eventFactory->getAll($where,array('limit'=>15,'order'=>'date'));
$isthislast=count($events);
foreach($events as $event){
	
		$url = $event->getURL();
		
		$urlPrefix = '';
									
		//switch(MultiLabelContext::getLabel()->uid)

		$class = BreadCrumb::selected($url)? ' on' : '';
		$nameTitle = ($event->artist()->name)? $event->artist()->name . ' ' : '';
		$nameTitle .= $event->title;
		//$nameTitle = substr_words(32,$nameTitle);
?>
						<li class="<?=$class?>">
							<h3><a href="<?=$event->getURL()?>"><?=$nameTitle?></a></h3>
							<?=date('jS M Y', strtotime(@$event->date))?>
							<?php // <img src="< ?=$news->image(array('size'=>'thumbLarge','default'=>'png'))? >" alt="" /> ?>
							</li>
							<?
						}
						?>
					</ul>
				</div>
		
