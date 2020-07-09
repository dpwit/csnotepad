<div id="list">
<ul>
<?
$func = $this->param('urlFunc');
foreach($list as $item){
	$url = $item->$func();
	$selected = BreadCrumb::selected($url)?"on":"";
?>
	<li><a class="item <?=$selected?>" href="<?=$url?>"><?=$item->getLabel()?></a></li>
<?
}	
?>
</ul>
</div>
