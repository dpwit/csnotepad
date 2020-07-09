<?php
?>
					<div class="thinBorder box" id="artistsList">
						<h2>Artists</h2>
						<ul>
							<?
								$artistsFactory = Model::loadModel('artists');
								$artistItems = $artistsFactory->getVisible(cms_apply_filter('artists_restrict',array()),array('order'=>'name'));
								foreach($artistItems as $artist){
									$urlPrefix = '';
									$url = $artist->getURL();

									$class = BreadCrumb::selected($url)? ' on' : '';
									?><li><a "<?=$class?>" href="<?=$urlPrefix.$artist->getURL()?>"><?=$artist->getLabel()?></a></li><?
								}	
							?>

						</ul>
					</div>
