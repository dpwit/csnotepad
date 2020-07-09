<?php
	$index = 0;
	$skipped_first =false;
	$basket = Model::loadModel('Basket')->getFirst();
?>
					<div class="noBorder box" id="shop">
						<ul>
<?php 
	while ($prod = $this->getItem()) {
       	$row_start = ($index % 3 == 0);
        $row_end = (++$index % 3 == 0);
		
		$short = ($prod->product_type_uid == 3)? " short" : '';
    		?>
				<li class="product<?=$short?>">
                	<a href='<?=$prod->getUrl()?>' class="productImage"><img src="<?=$prod->image('list',array('default'=>'png'))?>" width="115" height="115"></a>
                    <ul class="buttons">
                        <?php $this->view($context,'modules/products/buy-link',array('product'=>$prod,'basket'=>$basket)); ?>
                        <li><a href="<?=$prod->getUrl()?>"><img src="/images/viewIcon.png" alt="headphones"/>Details</a></li>
                    </ul>
                    <h3><a href="<?=$prod->getUrl()?>"><?= $prod->getLabel() ?></a></h3>
					<span><?php
	$links=array();
	if($artists = $prod->manufacturerLinks()){
		foreach($artists as $url=>$label){
			if(is_numeric($url)){
				$links[] = $label;
			} else {
				$links[] = "<a href='".$url."'>".$label."</a>";
			}
		}
	}
?>
<? if($links) { ?>
								<?=join(", ",$links)?>
<? } ?></span>
				</li>
				<?php 
					if ($row_end) {
						?></ul><ul><?php
					}
				?>
			<?php
	} /* end while */ 
?>
</ul>
</div>
<?php if (!@$row_end) {?>
<?php  } ?>
    <?
    $next = $this->getNextLink();
    $prev = $this->getPrevLink();
    
    if ($next || $prev) {
        
        ?>
    <div class='pagination'>
				<div class='nextlink'>

<?php 
    
             if ($next) { ?>
        <a href="<?=$next?>" class="NextPage">NEXT PAGE</a>
                <? } ?>
    </div>
    <div class='previouslink'>
	
            <? if ($prev) { ?>
		<a href="<?=$prev?>" class="PreviousPage">PREVIOUS PAGE</a>
        
                <? } ?>
                </div>

                
                <?php
    //$pages = ($this->getNumPages() > 12)? 12 : $this->getNumPages();
    $pages = $this->getNumPages();
	$current = $this->getCurrentPage();
	$current = $current? $current+1 : 1;
	?>
				Page <?=$current?> of <?=$pages?>
	<?php
	/*
		for($a=0; $a<$pages ; $a++){
			$vis = $a+1;
			$selected = ($a==$current) ? "selected" : "not-selected";
?>
			<a href='<?=$this->getPageLink($a)?>' class='<?=$selected?>'><?=$vis?></a>
<?
		}
		if ($this->getNumPages() > 12) {
			?>
			.. <a href='<?=$this->getPageLink($this->getNumPages())?>' class='<?=$selected?>'><?=$this->getNumPages()?></a>
			<?php
		}*/
?>

        <?
        
    }
    ?>
</div><!-- #productList -->
