<!--<h2>Our Services, Virtual Reception Services</h2><p><br>
We've done our best to be as clear and upfront with our pricing as  possible. We know it's frustrating when you want a basic price, but all  you can find is<strong> 'Call us for a quote.'</strong> However if you do have a special  requirement, we'll be pleased to go through it with you. Where services  are more individual in their nature, we've provided an example based on  our highest cost, not our lowest.<strong> Select a service below for more details or to sign up online now.</strong><br><br>
</p>-->

<?php
	$index = 0;
	$skipped_first =false;
	$basket = Model::loadModel('Basket')->getFirst();
	$catName = $category? $category->name : $model->name;
?>
<?php if($this->model->alternativeHeading) { ?>
		<h2><?=$this->model->alternativeHeading?> Costs</h2>
	<?php } else { ?>
		<h2><?=$this->model->name?> Costs</h2>
	<?php } ?>
<div id="ProductTableBox">
<table class="ProductTable <?=$this->model->name?>">
<thead><tr><th></th> <!-- TOP LEFT BLANK CELL -->
<?php  
	$products = array();
	$productType = null;
	$productProperties = array();
	$productAttributes = array();
	while ($prod = $this->getItem()) {
		$products[] = $prod;
		if(!$productType && $productType = $prod->product_type()){
		
			$propOrder = array();
		
			foreach($productType->product_properties() as $property){ 
				$propOrder[] = $property->uid;
				?><th class="PropertyName" scope="col"><?=$property->property_name?></th><?php 
			}
							
		}
		if(!$prod->variations())
			foreach($prod->product_attribute_options() as $attribute_option)
				$productAttributes[$attribute_option->uid] = $attribute_option->name;
		else 
			foreach($prod->variations() as $vari)
				foreach($vari->product_attribute_options() as $attribute_option)
					$productAttributes[$attribute_option->uid] = $attribute_option->name;	
	}
	//var_dump(array_keys($productAttributes));
	ksort($productAttributes);
	foreach($productAttributes as $attr)
	{
		?><th class="AttributeName" colspan="2" scope="col"><?=$attr?></th><?php
	}
	?></tr></thead><?php
	foreach($products as $prod)
	{
		?><tr><?php
			?><th scope="row" class="ProductHeader"><?=$prod->name?></th><?php

			$propertyArr = array();
			foreach($prod->product_property_values as $propTemp)
			{
				$propertyArr[$propTemp->product_property_uid] = $propTemp->property_value;
			}

			//var_dump($propOrder);
			//var_dump($propertyArr);
			//die();
			
			foreach($propOrder as $k)
				{ ?><td class="PropertyValue"><?=$propertyArr[$k]?></td><?php }

			/*foreach($propertyArr as $propVal)
				{ ?><td class="PropertyValue"><?=$propVal?></td><?php }*/
			
			/*
			foreach( as $propVal)
				{ ?><td class="PropertyValue"><?=$propVal->property_value?></td><?php }
			*/
				
			$prodAttrs = array();
			
			if($prod->variations())
				foreach($prod->variations() as $vari)
					foreach($vari->product_attribute_options() as $attrVal){ 
						$prodAttrs[$attrVal->uid] = $vari;
						/* ?><td>&pound;<?=$vari->getDisplayPrice()?><br /><a href="<?=$vari->form_name ? $vari->getURL() : $vari->getPurchaseUrl()?>" class="BuyLink">BUY</a></td><?php */
					}
			else{
				foreach($prod->product_attribute_options() as $attrVal){ 
						$prodAttrs[$attrVal->uid] = $prod;
					/*?><td>&pound;<?=$prod->getDisplayPrice()?><br /><a href="<?=$prod->form_name ? $prod->getURL() : $prod->getPurchaseUrl()?>" class="BuyLink">BUY</a></td><?php */
				}
			}
			//var_dump(array_keys($prodAttrs));
			foreach($productAttributes as $key => $attr){
				if($prod = $prodAttrs[$key])
				{ 
					?><td class="AttributeValue"><?php
						?><span class="cost leftFloat">&pound;<?=$prod->getDisplayPrice()?></span> <?php
					?></td><?php
					?><td class="AttributeValue"><?php
						?><a rel="nofollow" href="<?=$prod->getPurchaseUrl()?>" class="BuyLink leftFloat">Add to Basket</a><?php 
					?></td><?php
					/*?><td class="AttributeValue"><span class="cost leftFloat">&pound;<?=$prod->getDisplayPrice()?></span> <?php
						/* ?><a href="<?=$prod->form_name ? $prod->getURL() : $prod->getPurchaseUrl()?>" class="BuyLink">BUY</a><?php * /
						?><a rel="nofollow" href="<?=$prod->getPurchaseUrl()?>" class="BuyLink leftFloat">BUY</a><?php 
					?></td><?php */
				}
				else{
					?><td class="AttributeValue">&nbsp;</td><?php 
				}
			}

		?></tr><?php
	}
?>
</table>
</div>
<?php return ?>
<div class="productContent">
<?php if($this->model->alternativeHeading) { ?>
	<h2><?=$this->model->alternativeHeading?></h2>
<?php } else { ?>
	<h2><?=$this->model->name?></h2>
<?php } ?>
<?=$this->model->content?>
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