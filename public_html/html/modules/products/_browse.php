<h2>Our Services, Virtual Reception Services</h2><p><br>
We've done our best to be as clear and upfront with our pricing as  possible. We know it's frustrating when you want a basic price, but all  you can find is<strong> 'Call us for a quote.'</strong> However if you do have a special  requirement, we'll be pleased to go through it with you. Where services  are more individual in their nature, we've provided an example based on  our highest cost, not our lowest.<strong> Select a service below for more details or to sign up online now.</strong><br><br>
</p>

<?php
	$index = 0;
	$skipped_first =false;
	$basket = Model::loadModel('Basket')->getFirst();
	$catName = $category? $category->name : $model->name;
?>
						<ul>
<?php 
	while ($prod = $this->getItem()) {
		$row_start = ($index % 3 == 0);
		$row_end = (++$index % 3 == 0);		
		$short = ($prod->product_type_uid == 3)? " short" : '';
		?>
		<li class="product<?=$short?> <?=$prod->slug?> mainSection2ColLeft3ColLeft">
			<?=$this->view($context,$prod->template('list-item'),array('product'=>$prod,'basket'=>$basket))?>
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