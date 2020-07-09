
				<div class="box" id="events">
					<ul>
<?
//var_dump($item);

$eventFactory = Model::loadModel('events');
//$events = $eventFactory->getAll(array(),array('limit'=>5));
$events = $eventFactory->getVisible(cms_apply_filter('events_restrict',array('status'=>1)),array('limit'=>5,'order'=>'date'));
$isthislast=count($events);
foreach($events as $event){
	$eventStatus = $event->eventStatus? $event->eventStatus : 'Coming Soon';
	$shortText = substr_words(200,$event->shorttext);
?>
						<li class="eventList">
							<?php 
								$defaultFileName = 'default-skint';	
								if($event->label_uid==2) $defaultFileName = 'default-loaded';
							?>
							<a href="<?=$event->getURL()?>"><img src="<?=$event->image(array('size'=>'thumb','default'=>'png','defaultFileName'=>$defaultFileName))?>" alt="<?=$event->title?>" /></a>
							<h3><a href="<?=$event->getURL()?>"><?=$event->artist()->name?> <?=$event->title?></a><?=date('l jS M Y', strtotime(@$event->date))?></h3>
							<div class="eventStatus">Ticket Availability: <strong><?=$eventStatus?></strong></div>
							<p><?=$shortText?></p>
							<a class="more" href="<?=$event->getURL()?>">More</a>
						</li>
	<?
	$isthislast--;
}
?>
					</ul>
				</div>