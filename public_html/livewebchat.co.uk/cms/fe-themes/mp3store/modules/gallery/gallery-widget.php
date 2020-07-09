<?php 
	$gallery = Model::loadModel('gallery')->getFirst(array('uid'=>$gallery_uid));
	if($gallery) { 
?>
<div class="gallery">
<h3>Gallery</h3>
<?
	
	foreach($gallery->galleryItems() as $galleryItem)
		{ ?><a href="<?=$galleryItem->image(array('as_url'=>true))?>"><img src="<?=$galleryItem->image(array('as_url'=>true,'size'=>'thumb'))?>"></a><?php }
?>
</div>
<? } ?>
