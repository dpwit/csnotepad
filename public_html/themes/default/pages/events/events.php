	<div id="content">
		<div id="EventsPage" class="inner">
		<div class="col"><div id="artistsList" class="thinBorder box comp">
<div id="upcomingdates">
<h2>Upcoming Events</h2>
<ul>
<?
//var_dump($item);

$eventFactory = Model::loadModel('events');
$events = $eventFactory->getAll(array(),array('limit'=>5));
$isthislast=count($events);
foreach($events as $event){
?>
	<li class="newsfeature clearfix <? if ($isthislast==0) { echo "final"; } ?>">
  	<a href="<?=$event->getUrl()?>"><h3><?=date('j-n-Y', strtotime(@$event->date))?></h3></a>  
	<?php // <img src="< ?=$news->image(array('size'=>'thumbLarge','default'=>'png'))? >" alt="" /> ?>
	<a href="<?=$event->getUrl()?>"><h3><?=$event->title?></h3></a>
	<p><?=$event->shorttext?></p>
	</li>
	<?
	$isthislast--;
}
?>
</ul>
</div>
</div>
                    </div>
			<div class="last col">
				<div id="Videos" class="box">
					<h2>Events</h2>


				</div>
			</div>
		</div>
	</div>
</div>
