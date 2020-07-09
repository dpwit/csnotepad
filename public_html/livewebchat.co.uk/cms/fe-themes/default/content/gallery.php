<div class="inner">
	
	<div class="col">		
		<div class="thinBorder box" id="artistsList">
			<h2>Galleries</h2>
			<ul>
				<?php
					$galleries = Model::loadModel('gallery')->getAll();
					$page = Model::g('Page',array('shortName'=>'Gallery'));
					$labelUrl = $page->getUrl()."/";
					foreach($galleries as $gallery){
						
						?><li class="s"><a href="<?=$labelUrl . $gallery->urlTitle?>"><?=$gallery->galleryTitle?></a></li><?php
					}
					
					$targetGallery = basename($_SERVER['REQUEST_URI']);
					$gallery_uid = 2; 
					if($targetGallery && count($urlParts) > 1){
						$gallery = Model::loadModel('gallery')->getFirst(array('urlTitle'=>$targetGallery));
						$gallery_uid = $gallery->uid;
					}
					else $noGallerySelected = true;
				?>

			</ul>
		</div>
	</div>
	<div id="breadcrumb">						
		<h3><a href="/">Home &gt;</a> <a href="/gallery">Gallery<?php if(!$noGallerySelected) { ?> &gt;<?php } ?></a> <?php if(!$noGallerySelected) { ?><a href="<?=$_SERVER['REQUEST_URI']?>"><?=$gallery->galleryTitle?></a><?php } ?></h3>
	</div>
	<div id="breadcrumb-search-fields" style="display: none;">

	</div>
	<div class="last col">						
		<div id="gallery">
		
			<div class="image">
				<div class="main"><img src="images/gallery_temp.jpg" /></div>
				<div class="info">
					<a class="left" href=""><img src="images/right_arrow.png" class="social arrow" /></a>
					<a class="right" href=""><img src="images/left_arrow.png" class="social arrow" /></a>
					<!--<a href=""><img src="images/like.png" class="social" /></a>-->
					
					<!--<a href=""><img src="images/tweet_this.png" class="social" /></a>-->
					<h3></h3>
				</div><fb:like href="<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" show_faces="false" width="300" font="arial"></fb:like>
			</div>
			<ul>
				<?php foreach(range(1,28) as $k) { ?><li><a href=""><img src=""></a></li><?php } ?>
			</ul>
			<div class="arrows">
				<span class="left"><a href="">Back</a></span>
				<span class="right"><a href="">Next</a></span>
			</div> 

			<script> 
				$(document).ready(function(){
					
					var gallerySettings = $.Boz.BuildGallery({
						gallery_uid : <?=$gallery_uid?>
					});
					
					$('.info > a.left').click(function(){
						gallerySettings.selectedIndex++;
						gallerySettings.draw();
						return false;
					});
					
					$('.info > a.right').click(function(){
						gallerySettings.selectedIndex--;
						gallerySettings.draw();
						return false;
					});
					
					$('.arrows > .left > a').click(function(){
						gallerySettings.page--;
						gallerySettings.drawPage();
						return false;
					});
					
					$('.arrows > .right > a').click(function(){
						gallerySettings.page++ ;
						gallerySettings.drawPage();
						return false;
					});
					
				});
			</script>
		</div>		
	</div>
</div>
		
