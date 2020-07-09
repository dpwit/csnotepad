<?php
	if($item instanceof ProductOrderItem){
		$prod=$item->product(); 
		?>
		<!--
			<a href="<?=$prod->getURL()?>"><img src="<?=$prod->image('icon',array('as_url'=>true))?>" class="basket-image" alt="<?=$prod->getLabel()?>"/></a>
		-->
		<span class='basket-label'>
			<?php	
				$category= $prod->categories();
				$category=$category[0];
				if($item->product()->product_type_uid!=19){
					?><a href="<?=$category->getURL()?>"><?php
				}
					try{
						if($prod->variation_of())
							$cat = $prod->variation_of()->categories(array(),array('single'=>true));
						else
							$cat = $prod->categories(array(),array('single'=>true));
						$cat = $cat->name;
					}
					catch(Exception $ex){
						$cat = "Uncategorised";
					}
				?><strong><?=$cat?></strong><br />
				<?=$prod->name?>
				
				<?php
						$displayThisMonth = $prod->product_type_uid!=19;
						foreach($prod->product_attribute_options() as $attr)
						{
							if(false !== strpos($attr->name,'Annual ')){
								$displayThisMonth = false;
								break;
							}
						}
						
						if($displayThisMonth)
						{ ?> - Next Month<?php } 
				
				?><br /><?php
				
					if($prod->variation_of())
					{
						?><?=$prod->describeVariation()?><?php
					}
					else
					{
						foreach($prod->product_attribute_options() as $attr)
						{
							?><?=$attr->getLabel()?><?php
						}
					}
				?><?php
					if($prod->getDisplayPrice()!='0.00')
					{ ?> &pound;<?=$prod->getDisplayPrice(t)?> Ex Vat<br /><?php }
				if($item->product()->product_type_uid!=19){
					?></a><?php
				}
				?>
		</span>
		<?php
		try {
			if($url = $prod->getPreviewUrl()) { 
				?>
					<!--<div class='preview-wrapper'>-->
					<ul class="buttons" style="width: 90px">
						<li>
							<a onClick="handleClick('<?=htmlspecialchars($prod->getPreviewUrl(),ENT_QUOTES)?>','<?=htmlspecialchars($prod->getLabel(),ENT_QUOTES)?>'); return false;" class="trackListen" href="<?=htmlspecialchars($prod->getPreviewUrl() ,ENT_QUOTES)?>" title="<?=htmlspecialchars($prod->getLabel(),ENT_QUOTES)?>">
								<img src="/images/headphones.png" alt="headphones"/>Preview</a>
							</li>
					</ul>
					<!--</div>-->
				<?php
			}
		} catch(BadRelationshipException $e){}
	} else {  
		?><span class='basket-label'><?=$item->getLabel()?></span><?php
	} 
?>
