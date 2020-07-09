<ul id='artistMenu' class='menu'>
<?
$func = $this->param('urlFunc');
foreach($list as $artist){
	$url = $artist->$func();
	$selected = BreadCrumb::selected($url)?"selected":"unselected";
?>
<li class='menuItem artistItem <?=$selected?>'>
<a class="menuItem clearfix" href='<?=$url?>'>
<img class="artistImage" src='<?=$artist->image('icon',array('default'=>'jpg'))?>'/>
	<span class="artistTitle"><?=$artist->getLabel()?></span><br/>
	<span class='artistShortDesc'><?=truncate($artist->getDescription(),62)?></span>
	</a>
</li>
<?
}	
?>
</ul>
