				<div class="thinBorder box" id="featuredShop">
						<h2>Shop</h2>
						<ul>
							<?php
								$featuredFactory = Model::loadModel('feature');
								$featured = $featuredFactory->getFirst();
								$limit = $limit? $limit : 3;
								$products = $featured->products(cms_apply_filter('product_browsing_restrict',array()),array('order'=>'sorting asc','limit'=>$limit));
								foreach($products as $prod){
											//var_dump($prod);

									$artistsNames = "";
									//var_dump($prod);
									if($prod->artists())
										foreach($prod->artists() as $artist) $artistsNames .= ($artistsNames ? ', ' : '') . $artist->name;
										
									?>
										<li>
											<a href="<?=$prod->getURL()?>"><img alt="<?=$prod->name?>" src="<?=$prod->image('thumb',array('default'=>'png','defaultFileName'=>@$defaultFileName))?>"></a>
											<h3><a href="<?=$prod->getURL()?>" title="<?=$prod->name?>"><?=$prod->name?></a></h3>
											<p><?=$artistsNames?></p>
											<!--<p><?=substr(strip_tags($prod->description),0,50)?></p>-->
											<div class="left buylisten">
												<?php if ($prod->product_type_uid < 3 && $prod->getPreviewUrl()) { ?><a onclick="return false" class="listen mp3-link" href="<?=$prod->getPreviewUrl()?>" title="Preview">Preview</a><?php } ?>
												<a class="buy" href="<?=$prod->getPurchaseUrl()?>" title="Buy">Buy</a>
												<a class="info" href="<?=$prod->getUrl()?>" title="Info">Info</a>
											</div>
										</li>
									<?php
								}
							?>
						</ul>
					</div>
