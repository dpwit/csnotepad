<?
					?><div class="thinBorder box" id="top10">
						<h2>Top 10</h2>
						<ul>
							<?php
								$top10Factory = Model::loadModel('ArtistTop10');
								$top10s = $top10Factory->getAll(cms_apply_filter('top_ten_restrict',array()),array('limit'=>10));
								foreach($top10s as $top10)
								{ 
									if(!$product = $top10->product()) continue;
								
							?><li>
								<a href="<?=$product->getURL()?>" title="<?=$product->name?> - Info"><?=$product->name?></a>
								<div class="buylisten">
									<a onclick="return false" class="listen mp3-link" href="<?=htmlspecialchars($product->getPreviewUrl())?>" title="Preview">Preview</a>
									<a class="buy" href="<?=$product->getPurchaseUrl()?>" title="Add To Cart">Buy</a>
								</div>
							</li>
							<?php 
							}
						?>
						</ul>
					</div>
