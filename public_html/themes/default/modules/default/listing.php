<? if($this->params['title']) { ?><h3 class="formHeading"><?=$this->params['title']?></h3><? } ?>
<div class='listing'>
<?
	while($item = $this->getItem()){
?>
	<div class='listing-item'>
<?
		if($item instanceof Component){
			$item->doHTML($context);
		} else {
?>
		<div class='outlinehighlight'><a href="<?=$item->getUrl()?>">
				<h3 class="title"><?=$item->getLabel()?></h3>
				<p><?=$item->getDescription()?></p>
		</a></div>
<?
		}
?>
	</div>
<?
	}
?>
</div><!--listing-table-->

<? include(dirname(__FILE__).'/pagination.php'); ?>
<? if($this->params['footer']) { ?><?=$this->params['footer']?><? } ?>

