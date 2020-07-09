<div style="text-align: center; width: 100%;">
<div id="skintvideos"><!-- muwahahahahahaha --></div>

	<div id="content">
		<div id="VideoPage" class="inner">
		<div class="col">
			<div id="artistsList" class="thinBorder box">
				<h2>YouTube Channels</h2>
				<ul>
			<?php
					$where=array();
				
					$labels = Model::loadModel('labels')->getVisible($where,array());
				
					$gallery_uid = 1;
					if($artistSlug){
						$artist = Model::loadModel('artist')->getBySlug(basename($_SERVER['REQUEST_URI']),array('visible'=>0));
						if($artist){
							$ytChanName = $artist->youtubeChannel;
						}
						else
							$ytChanName = 'skintrecords';
					}
				
				
				
				
				
				
				
				
					$where = array();
					$where['youtubeChannel !='] = '';
					$artists = Model::loadModel('artists')->getVisible($where,array());
	
					foreach($artists as $artist){
						$linkUrl = '/videos/' . $artist->getSlug();
						
						$class="";
						
						if(
							explode('/',$linkUrl) ==
							$urlParts
						) $class .= " on";
						?><li><a class="<?=$class?>" href="<?=$linkUrl?>"><?=$artist->name?></a></li><?php
					}
				}
			?>
				</ul>

		<script type="text/javascript">
			$(document).ready(function(){
				//alert('<?=$ytChanName?>');
				$('#skintvideos').youTubeChannel({ 
		            userName: '<?=$ytChanName?>', 
		            channel: 'uploads', 
		            hideAuthor: true,
		            numberToDisplay: 15,
		            linksInNewWindow: false,
								page:0
								
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
						page:--p
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
						
						<button id="ytLast" class="coolButton"> Last 15 </button>
						<button id="ytNext" class="coolButton"> Next 15 </button>
	<div id="youtubeComments"></div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
</div>