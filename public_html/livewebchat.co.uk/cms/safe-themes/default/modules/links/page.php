<div class='links-page'>
<?
	$lc = Model::loadModel('LinkCategory')->getVisible();
 

	foreach($lc as $category) {	
?>
<div class='link-category'>
<h2 class="headerText"><?=$category->name?></h2>
<?=$category->description?>

	<div class='link-list'>
<? foreach($category->links() as $link) { 
?>
		<div class='link'>
<?
	if($link->image('exists')){
?>
	<div class='link-image'>
		<img src='<?=$link->image('thumb')?>'/>
	</div>
<?
	}
?>
<div class="link-text">
			<h3><?=$link->name?></h3>
			<?=$link->description?>
			<p><a href='<?=$link->link?>'><?=$link->humanReadableLink()?></a></p>
			<br/>
</div>
</div>
<? } ?>
	</div>
</div>
<? } ?>
</div>
