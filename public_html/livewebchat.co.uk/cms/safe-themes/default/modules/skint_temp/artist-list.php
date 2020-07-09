				<div id="artistsMain" class="box">
					<ul>
						<?php
						$artistsFactory= Model::loadModel('artists');
						$artistItems = $artistsFactory->getVisible(cms_apply_filter('artists_restrict',array('label_uid >'=>'0')),array('order'=>'name'));
						$i = 0;
						foreach($artistItems as $artist){
							if ($i%5 == 0) {
								$class = ' class="nl"';
							} else {
								$class = '';
							}
						?>
						<li<?=$class?>><a href="<?=$artist->getUrl()?>"><span class="image"><img src="<?= $artist->image ? $artist->image('galleryThumb',array('default'=>'png')) : 'images/placeholder.png'?>" /></span><span><?=$artist->name?></span></a></li>
						<?php $i++; } ?>
					</ul>
				</div>
