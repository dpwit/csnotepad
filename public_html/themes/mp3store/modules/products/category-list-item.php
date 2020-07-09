<? $prod=$product;?>
                	<a href='<?=$prod->getUrl()?>' class="productImage" title="<?= $prod->getLabel() ?>"><img src="<?=$prod->image('list',array('default'=>'png'))?>" width="115" height="115" alt="<?= $prod->getLabel() ?>"></a>
                    <ul class="buttons">
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
