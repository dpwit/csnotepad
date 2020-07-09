

<div id="skintvideos"></div>
	<div id="content">
		<div id="VideoPage" class="inner">
		<div class="col">
			<div id="artistsList" class="thinBorder box">
				<h2>YouTube Channels</h2>
				<div class="labels">
					<a href="/skint/videos">Skint</a>
					<a href="/loaded/videos" style="margin-right: 0">Loaded</a>
				</div>
				<ul>
	<?php
				$currentLabel = MultiLabelContext::getLabel();
				$where = array('status'=>1);
				if($currentLabel) 
					$where['uid'] = $currentLabel->uid;
				
				$labelUrl = MultiLabelContext::getLabel()->labelname ? ('/'. MultiLabelContext::getLabel()->labelname) : '';

				$labels = Model::loadModel('label')->getVisible(array('uid >'=>'0'),array());
				foreach($labels as $label){
							switch($label->uid)
							{
								case 1: $class = 's'; break;
								case 2: $class = 'l'; break;
							}
						?><li class="<?=$class?>"><a href="<?=strtolower($label->getSlug())?>/videos"><strong><?=$label->labelname?> Records</strong></a></li><?php
						foreach($label->artists(array('youtube_ChannelName !='=>'')) as $artist){
									
							switch($artist->label_uid)
							{
								case 1: $class = 's'; break;
								case 2: $class = 'l'; break;
								default: $class = ''; break;
							}
							
							?><li><a class="<?=$class?>" href="<?=strtolower($label->getSlug()).'/videos/'.$artist->getSlug()?>"><?=$artist->name?></a></li><?php
						}
				}
	?>
				</ul>

				<?
					$urlParts = MultiLabelContext::getUrlParts();
					$artistSlug = $urlParts[count($urlParts)-1];
					$gallery_uid = 1;
					if($artistSlug){
						$artist = Model::loadModel('artist')->getBySlug($artistSlug,array('visible'=>0));
						if($artist){
							$ytChanName = $artist->youtube_ChannelName;
							//var_dump($artist);die;
						}
						elseif($currentLabel){
							$ytChanName = $currentLabel->youtubeChannel;
							//var_dump($currentLabel);die;
						}
						else
							$ytChanName = 'skintrecords';
					}
					//$gallery = Model::loadModel('gallery')->getAll();
				?>

		<script type="text/javascript">
			$(document).ready(function(){
				//alert('<?=$ytChanName?>');
				$('#skintvideos').youTubeChannel({ 
		            userName: '<?=$ytChanName?>', 
		            channel: 'uploads', 
		            hideAuthor: true,
		            numberToDisplay: 15,
		            linksInNewWindow: false,
								page:0,
								
		            //other options
		            //loadingText: "Loading...",                    
		        });
        		//$(document).pngFix();
				var p = 0;
				hasMore = false;
				$('#ytLast').click(function(){
					if(p>0)
					$('#skintvideos').youTubeChannel({ 
						userName: 'skintrecords', 
						channel: 'uploads', 
						hideAuthor: true,
						numberToDisplay: 15,
						linksInNewWindow: true,
						page:--p,
						//other options
						//loadingText: "Loading...",                    
					});					
				});
				$('#ytNext').click(function(){
					if(hasMore)
					$('#skintvideos').youTubeChannel({ 
						userName: 'skintrecords', 
						channel: 'uploads', 
						hideAuthor: true,
						numberToDisplay: 15,
						linksInNewWindow: true,
						page:++p
						//other options
						//loadingText: "Loading...",                    
					});
				hasMore = false;
				});
			});
			
		</script>
				
<!--<ul><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li></ul>-->
					</div>
                    </div>
			<div class="last col">
					<div id="breadcrumb">
						<h3><a href="/">Home &gt;</a> <a href="/videos">Videos</a></h3>
					</div>
				<div id="Videos" class="thinBorder box">
					<div class="bigVideo">
						<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/MNKt8RBk4wY&amp;hl=en_US&amp;fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/MNKt8RBk4wY&amp;hl=en_US&amp;fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>
					</div>
				<div class="videoList">
                    	
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
                        
					<div class="VideoHolder"> 
						<img src="/images/VideoHolder.png" />
					</div>
                       
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
                        
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
						
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
						
					<br />
									
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
					
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
								
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
								
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
								
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>						
						
					<br />
									
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
					
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
							
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
							
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
							
					<div class="VideoHolder">
						<img src="/images/VideoHolder.png" />
					</div>
					
					<br clear="all" />
						
						<button id="ytLast"> Last 15 </button>
						<button id="ytNext" > Next 15 </button>
	<div id="youtubeComments"></div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
