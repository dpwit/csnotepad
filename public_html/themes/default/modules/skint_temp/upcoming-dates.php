						<?php
							$eventFactory = Model::loadModel('Event');
							$artistRestrict = array('date >'=>date('Y-m-d'));
							if($artist_uid) $artistRestrict['artist_uid']=$artist_uid;
							
							$limit = $limit? $limit : 5;
							$events = $eventFactory->getAll(
								cms_apply_filter('events_restrict',$artistRestrict),array('limit'=>$limit,'order'=>'date asc')
							);
							if (count($events) > 0) {
						?>
				<div class="thinBorder box" id="upcomingDates">
					<h2>Upcoming Events</h2>
					<ul>
						<?php
							foreach($events as $event){
								$eventTitle = $event->artist()->name . " " . $event->title;
								$eventTitle = (strlen($eventTitle) > 28)? substr($eventTitle,0,28) . "..." : $eventTitle;
								?>
									<li>
										<h3><?=date('j F Y',strtotime($event->date));?><br>
										<a href="<?=$event->getUrl()?>" title="<?=$event->title?>"><?=$eventTitle?></a></h3>
										<p><?=substr_words(45,strip_tags($event->shorttext))?></p>
									</li>
								<?php
							}
						?>
					</ul>
				</div>
				<?php
							} 
						?>