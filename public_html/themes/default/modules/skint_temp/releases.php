				<?php 
				
					$artistFactory = Model::loadModel('artist');
					$artist = $artistFactory->getFirst(array('uid'=>$artist_uid,'status'=>1));
					$releases = $artist->releases();
													//var_dump($releases);

					if ($this->getTotalResults() > 0) {
				
				?>
				<div class="thin box" id="releases">
						<h2>Releases</h2>
						<div>
						<ul>
							<?php
							
								//$releasesFactory = Model::loadModel('feature');
								//$featured = $releasesFactory->getFirst();

								//$products = $featured->products(cms_apply_filter('product_browsing_restrict',array('artist_uid'=>$artist_uid)));
								/*foreach($tracks as $track){
									$prod = $track->product();
//									var_dump($prod);
									$artistsNames = "";
									//var_dump($prod);
									//if($prod->artists())
										//foreach($prod->artists() as $artist) $artistsNames .= $artist->name;
										
									?>
										<li>
											<img alt="JGB - The Guild Master" src="images/placeholder.png">
											<h3><?=$prod->uid?><br>
											<?=$artistsNames?></h3>
											<p><?=substr(strip_tags($prod->description),0,50)?></p>
											<div class="left buylisten"><a class="listen" href="#">Listen</a> <a class="buy" href="<?=$prod->getUrl()?>">Buy</a></div>
										</li>
									<?php
								}*/
									//var_dump($releases);
									while($release = $this->getItem()){
									//$prod = $track->product();
//									var_dump($prod);
									$artistsNames = "";
									//var_dump($prod);
									//if($prod->artists())
										//foreach($prod->artists() as $artist) $artistsNames .= $artist->name;
									//var_dump($release);
									$title = (strlen($release->getLabel()) > 36)? substr($release->getLabel(),0,40) . "..." : $release->getLabel();
									?>
										<li>
											<a href="<?=$release->getURL()?>" title="<?=$release->getLabel()?>"><img alt="<?=$artist->name?> - <?=$release->getLabel()?>" src="<?=$release->image('home',array('default'=>'png','defaultFileName'=>@$defaultFileName))?>"></a>
											<h3><a href="<?=$release->getURL()?>" title="<?=$release->getLabel()?>"><?=$title?></a></h3>
											<p><?=$artist->name?></p>
											<!--<p><?=substr(strip_tags($release->description),0,50)?></p>-->
											<div class="left buylisten">
												<a onclick="return false" class="listen mp3-link" href="<?=$release->getPreviewUrl()?>">Preview</a>
												<a class="buy" href="<?=$release->getPurchaseUrl()?>">Buy</a>
												<a class="info" href="<?=$release->getUrl()?>">Info</a>
												</div>
										</li>
									<?php
								}
							?>
						</ul>
						</div>
						<?php if($prevURL = $this->getPrevLink()) { ?><a id="release_prev" class="coolButton" href="<?=$prevURL?>">prev</a><?php } ?>
						<?php if($nextURL = $this->getNextLink()) { ?><a id="release_next" class="coolButton" href="<?=$nextURL?>">next</a><?php } ?>
						<?php if($nextURL || $prevURL) { ?>
							<script>
								(function($){
									var successCallback = function(data){
										$('#release_prev, #release_next').remove();
										$('#releases > div > ul').html(data);
										$('#releases > div').addClass('ArtistReleases');
										
										$('#releases > div.ArtistReleases').after($('<a id="release_prev" class="coolButton" href="#">prev</a><a id="release_next" class="coolButton" href="#">next</a>'));
										

										$('#release_prev').click(function(){
											marginTopTarget = parseFloat($('#releases > div > ul').css('margin-top')) + $('#releases > div').height();
											if(marginTopTarget <= 0 ) 
												$('#releases > div > ul').animate({
													marginTop: marginTopTarget
												},0);
											return false;
										});
										$('#release_next').click(function(){
											marginTopTarget = parseFloat($('#releases > div > ul').css('margin-top')) - $('#releases > div').height();
											if(Math.abs(marginTopTarget) < $('#releases > div > ul').height())
												$('#releases > div > ul').animate({
													marginTop: marginTopTarget
												},0);
											return false;
										});
									}
									
									$.ajax({ url: "/webservice/releases/releases_list.php?artist_uid=<?=$artist_uid?>", dataTypeString: 'html', context: document.body, success: successCallback});
									
								})(jQuery);
							</script>
						<?php } ?>
					</div>
					
					<? } ?>
