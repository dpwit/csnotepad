<?phpif ($infoPage->artist()->name && $infoPage->location) {	$at = " at ";}?><div id="newsDesc">	<h3 class="EventTitle"><?=$infoPage->title?></h3>	<h3 class="EventArtist"><?=$infoPage->artist()->name . $at . @$infoPage->location?></h3>	<h3 class="EventDate"><?=date('jS M Y', strtotime(@$infoPage->date))?></h3>	<?php if ($infoPage->promoter) { ?><p class="promoter"><strong>Promoter</strong>: <?=@$infoPage->promoter?></p><?php } ?>	<p class='summary'><?=@$infoPage->shorttext?></p>	<?=paragraphs($infoPage->body)?>		<?php if ($infoPage->eventGenre) { ?><p class="EventEnd"><strong>Genre</strong>: <?=@$infoPage->eventGenre?><?php if ($infoPage->eventGenre2) { ?>, <?=@$infoPage->eventGenre2?></p><?php } ?><?php } ?>	<?php if ($infoPage->startTime) { ?><p class="Times"><strong>Starts</strong>: <?=@$infoPage->startTime?>, <?php } ?><?php if ($infoPage->endTime) { ?><strong>Ends</strong>: <?=@$infoPage->endTime?></p><?php } ?>	<?php if ($infoPage->ticketsAvailable) { ?><p class="EventStart"><strong>Tickets Available</strong>: <?=@$infoPage->ticketsAvailable?></p><?php } ?>	<?php if ($infoPage->ticketPrice) { ?><p class="EventPrice"><strong>Price</strong>: <?=@$infoPage->ticketPrice?> <?php if ($infoPage->bookingFee) { ?>(+ <?=@$infoPage->bookingFee?> booking fee)</p><?php } ?><?php } ?>	<?php if ($infoPage->eventType) { ?><p class="EventStart"><strong>Type</strong>: <?=@$infoPage->eventType?></p><?php } ?>	<?php if ($infoPage->eventStatus) { ?><p class="EventStart"><strong>Status:</strong>: <?=@$infoPage->eventStatus?></p><?php } ?>	<?php if ($infoPage->ageRestriction) { ?><p class="EventAge"><strong>Age</strong>: <?=@$infoPage->ageRestriction?></p><?php } ?>	<?php if ($infoPage->disclaimers) { ?><div class="disclaimers"><?=@$infoPage->disclaimers?></div><?php } ?></div></div><div class="last col"><div id="newsFeaturedImage"><img class="newsarticleimg" src='<?=$infoPage->image('thumbLarge',array('default'=>'png'))?>'/></div>					<div class="bookmark">                    				<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c5a9a011907b706"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>	<fb:like href="Your URL" layout="standard" show-faces="true" width="350" action="like" colorscheme="light" />	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c5a9a011907b706"></script><!-- AddThis Button END -->					</div><div class="tweetThis"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div></div></div></div>