<?
	$index=0;
?>
                <div id="artistTracks" class="clearfix">

<?
if(@$categories){
?>
<? foreach($categories as $cat) { 
	if(++$index%4==0) $rowEnd = true;
?>
                        <li class="artistTrack <?php if ($rowEnd) { ?> rowEnd <?php } ?>" >
			<img src='<?=$cat->image('thumb',array('default'=>'png'))?>'>
				<h5 class='productTitle'><?=$cat->getLabel()?></h5>
				<p class='productDesc'><?=$cat->getDescription()?></p>
				<h6 class='productMore fr'><a href='<?=$cat->getUrl()?>'>Browse</a></h6>
                
			</li>
<? } ?>

<? } ?>
<?
if($products){ ?>
        <script type="text/javascript" src="/html/musicplayer/swfobject.js"></script>
    <div id="musicPlayer">
                <p>Please enable Flash to hear the tracks</p>
                <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
     </div>
        <script type="text/javascript" src="/html/musicplayer/playerscript.js"></script>    
<? foreach($products as $mp3) { 
	$prod = $mp3->product();
?>
                 <ul>
	<li class="artistTrack">
	<p class="productItemTitle"><span class="productItemTitle"><a onClick="handleClick('<?=htmlspecialchars($mp3->mp3('preview',array('as_url'=>true)),ENT_QUOTES)?>','<?=htmlspecialchars($prod->getLabel(),ENT_QUOTES)?>');" href="<?=$track->getPreviewUrl()?>"><?=$prod->getLabel()?></a></span>

<?php /*	<p class="productItemTitle"><span class="productItemTitle"><a onClick="handleClick('<?=htmlspecialchars($mp3->mp3('preview',array('as_url'=>true)),ENT_QUOTES)?>','<?=htmlspecialchars($prod->getLabel(),ENT_QUOTES)?>');" href="<?=htmlspecialchars($mp3->mp3('preview',array('as_url'=>true)),ENT_QUOTES)?>"><?=$prod->getLabel()?></a></span>
*/ ?>
	<span class="trackItemPrice"><?=$prod->prettyPrice()?></span></p>
	<p class="fr clearfix">
<!--	<a class='trackListen buttonInline mp3-link' href='#' onClick="handleClick('<?=htmlspecialchars($mp3->mp3('preview',array('as_url'=>true)),ENT_QUOTES)?>','<?=htmlspecialchars($prod->getLabel(),ENT_QUOTES)?>');">Listen<span class="play"></span></a>  -->	
	<a class='trackListen buttonInline mp3-link' title='<?=htmlspecialchars($prod->getLabel(),ENT_QUOTES)?>' href="<?=htmlspecialchars($mp3->mp3('preview',array('as_url'=>true)),ENT_QUOTES)?>">Listen<span class="play"></span></a>	
<?
	if(@$basket && $basket->contains($prod)) { 
?>
	<a class="addToCart buttonInline" href='/basket/remove/<?=$prod->getId()?>'>In Cart</a>
<?		} else { ?>
	<a class="addToCart buttonInline" href='/basket/add/<?=$prod->getId()?>'>Add To Cart</a>
<?
		}
?>
</p>
</li>
<? } ?>

<? } ?>
</ul>
</div><!-- #productList -->

<?php /*
OLD CODE
                        
                        <li <?php if ($rowEnd) { ?> class="rowEnd" <?php } ?> >
			<img src='<?=$prod->image('icon',array('default'=>'png'))?>' class='disocgraphyCover fl'>
            <div class='fl'><a href='<?=$prod->getPreviewUrl()?>' id="playButtonSmall" class='mp3-link'>&nbsp;</a></div>
            <h6 class='productMore'><a href='<?=$prod->getUrl()?>'>Details</a></h6>
            <div class="productBuy">
				    
<?
	if($basket && $basket->contains($prod)) { 
?>
	<h6 class='productAddToCart'><a href='/basket/remove/<?=$prod->getId()?>'>Remove From Cart</a>&nbsp; <?=$prod->prettyPrice()?></h6>
<?	} else {	?>
	<h6 class='productAddToCart'><a href='/basket/add/<?=$prod->getId()?>'>Add To Cart </a> &nbsp; <?=$prod->prettyPrice()?></h6>
<? 	} ?>

				    </div>    <div style="clear:both"></div>
				<h5 class='productTitle'><?=$prod->getLabel()?></h5>
				<p class='productDesc'><?=truncate($prod->getDescription(),75)?></p>
				
                                    
                                    
                    <div style='clear:both'></div>                    
			</li>
	*/ ?>

