<?php

if ($event->artist()->name && $event->location) {
	$at = " at ";
}
?>
<div id="newsDesc">
	<h3 class="EventTitle"><?=$event->title?></h3>
	<h3 class="EventArtist"><?=$event->artist()->name . $at . @$event->location?></h3>
	<h3 class="EventDate"><?=date('jS M Y', strtotime(@$event->date))?></h3>
	<?php if ($event->promoter) { ?><p class="promoter"><strong>Promoter</strong>: <?=@$event->promoter?></p><?php } ?>
	<p class='summary'><?=@$event->shorttext?></p>
	<?=paragraphs($event->body)?>
	
	<?php if ($event->eventGenre) { ?><p class="EventEnd"><strong>Genre</strong>: <?=@$event->eventGenre?><?php if ($event->eventGenre2) { ?>, <?=@$event->eventGenre2?></p><?php } ?><?php } ?>
	<?php if ($event->startTime) { ?><p class="Times"><strong>Starts</strong>: <?=@$event->startTime?>, <?php } ?><?php if ($event->endTime) { ?><strong>Ends</strong>: <?=@$event->endTime?></p><?php } ?>
	<?php if ($event->ticketsAvailable) { ?><p class="EventStart"><strong>Tickets Available</strong>: <?=@$event->ticketsAvailable?></p><?php } ?>
	<?php if ($event->ticketPrice) { ?><p class="EventPrice"><strong>Price</strong>: <?=@$event->ticketPrice?> <?php if ($event->bookingFee) { ?>(+ <?=@$event->bookingFee?> booking fee)</p><?php } ?><?php } ?>
	<?php if ($event->eventType) { ?><p class="EventStart"><strong>Type</strong>: <?=@$event->eventType?></p><?php } ?>
	<?php if ($event->eventStatus) { ?><p class="EventStart"><strong>Status:</strong>: <?=@$event->eventStatus?></p><?php } ?>
	<?php if ($event->ageRestriction) { ?><p class="EventAge"><strong>Age</strong>: <?=@$event->ageRestriction?></p><?php } ?>
	<?php if ($event->disclaimers) { ?><div class="disclaimers"><?=@$event->disclaimers?></div><?php } ?>
</div>
</div>
<div class="last col">
<div id="newsFeaturedImage">
<img class="newsarticleimg" src='<?=$event->image('thumbLarge',array('default'=>'png'))?>'/>
</div>
					<div class="bookmark">
                    				
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c5a9a011907b706"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>

	<fb:like href="Your URL" layout="standard" show-faces="true" width="350" action="like" colorscheme="light" />
	
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c5a9a011907b706"></script>
<!-- AddThis Button END -->

					</div>

<div class="tweetThis"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>


</div>
</div>
</div>
