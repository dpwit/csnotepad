				<div id="galleryPlayer">
				
					<div class="image">
						<div class="main">
							<img src="images/gallery_temp.jpg" />
						</div>
					</div>
					<ul>
						<li><a href=""><img src=""></a></li>
						<li><a href=""><img src=""></a></li>
						<li><a href=""><img src=""></a></li>
						<li><a href=""><img src=""></a></li>
						<li><a href=""><img src=""></a></li>
						<li><a href=""><img src=""></a></li>
						<li><a href=""><img src=""></a></li>
						<li><a href=""><img src=""></a></li>
					</ul>
					<div class="arrows">
						<a href="" class="left"></a>
						<a href="" class="right"></a>
					</div>
				
				</div>
<script>
				var xxxxx = function(){ alert('NOT SET'); };
				$(document).ready(function(){
					var gallerySettings = $.Boz.BuildGallery({
						thumbTargets : $('#galleryPlayer > ul > li'),
						gallery_uid : <?=$gallery_uid?>,
						displayTarget : $('#galleryPlayer > .image > .main > img')
					});
					/*$('.info > a.left').click(function(){
						gallerySettings.selectedIndex++;
						gallerySettings.draw();
						return false;
					});
					$('.info > a.right').click(function(){
						gallerySettings.selectedIndex--;
						gallerySettings.draw();
						return false;
					});*/
					$('.arrows > .left').click(function(){
						gallerySettings.page--;
						gallerySettings.drawPage();
						return false;
					});
					$('.arrows > .right').click(function(){
						gallerySettings.page++ ;
						gallerySettings.drawPage();
						return false;
					});
					
					xxxx = function(){
						alert(gallerySettings.selectedIndex);
					}
				});
</script>