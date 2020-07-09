			<ul id="menu">
<?
$func = $this->param('urlFunc');
foreach($list as $item){
	$url = $item->$func();
	$selected = BreadCrumb::selected($url)?"selected":"unselected";
?>
				<li class="<?=$item->getSlug()?> <?=$selected?>"><a href="<?=$url?>"><?=$item->getLabel()?></a></li>
<?
}	
?>
			</ul>
