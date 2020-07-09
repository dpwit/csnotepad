<?
	$index=0;
?>
<div id="playerTracks" class="clearfix">
<?
if(@$categories){
?>
<ul>
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
			</ul>
<? } ?>
<?
if($products){ ?>
<div id="musicPlayer">
	<h1>Please enable Flash to hear the tracks</h1>
	<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
</div>
<script type="text/javascript" src="musicplayer/swfobject.js"></script>
<script type="text/javascript" src="musicplayer/playerscript.js"></script>  
<div id="productItems" class="clearfix">
<ul>
<? foreach($products as $mp3) { 
	$tracks = $mp3->product();
?>
<li>
	<div class="playerTrack clearfix">
	<a onClick="handleClick('<?=htmlspecialchars($tracks->getPreviewUrl(),ENT_QUOTES)?>','<?=htmlspecialchars($tracks->getLabel(),ENT_QUOTES)?>'); return false;" class='trackTitle mp3-link' href='<?=htmlspecialchars($tracks->getPreviewUrl() ,ENT_QUOTES)?>' title='<?=htmlspecialchars($tracks->getLabel(),ENT_QUOTES)?>'><span class="trackPlayIcon"><img src="/html/images/headphones.png" alt="headphones"/></span><?=$tracks->getLabel()?></a>
<?
	if(@$basket && $basket->contains($tracks)) { 
?>
	<a class="addToCart buttonInline" href='/basket/remove/<?=$tracks->getId()?>'><span class="trackPrice"><?=$tracks->prettyPrice()?><img src="/html/images/silkicons/basket_delete.png" alt="basket"/></span>
	</a>
<?		} else { ?>
	<a class="addToCart buttonInline" href='/basket/add/<?=$tracks->getId()?>'><span class="trackPrice"><?=$tracks->prettyPrice()?><img src="/html/images/silkicons/basket_add.png" alt="basket"/></span>
	</a>
<? } ?>
	</div>
</li>
<? } ?>
</ul>
<? } ?>
</div>
</div><!-- #playerTracks end -->
