<? if($this->params['title']) { ?><h3 class="formHeading"><?=$this->params['title']?></h3><? } ?>
<?php 
	$page = Model::g('page',array('slug'=>'our-services'));
?>
<h2><?=$page->label?></h2>
<?=$page->text?>
<div class='listing'>
<ul>
<?
	while($item = $this->getItem()){
?>
	<!--<div class='listing-item <?=$item->slug?>'>-->
	<a href="<?=$item->getUrl()?>" class="product mainSection2ColLeft3ColLeft <?=$item->slug?>" <?php if($item->image('exists')){ ?>style="background-image:url(<?=$item->image('csnotepadCategoryImage',array('as_url'=>true))?>)"<?php } ?>>
<?
		if($item instanceof Component){
			$item->doHTML($context);
		} else {
?>
		<div class='outlinehighlight'>
			
				<h3 class="title"><?=$item->getLabel()?></h3>
				<p><?=$item->description?></p>
			
			<span class="readMore">read more</span>
		</div>
<?
		}
?>
	</a>
	<!--</div>-->
<?
	}
?>
</ul>
</div><!--listing-table-->

<? include(dirname(__FILE__).'/../../../themes/default/modules/default/pagination.php'); ?>
<? if($this->params['footer']) { ?><?=$this->params['footer']?><? } ?>

