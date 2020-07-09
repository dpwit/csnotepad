<?
$func = $this->param('urlFunc');
foreach($list as $item){
	$url = $item->$func();
	$selected = BreadCrumb::selected($url)? ' class="on"' : '';
?>
			<li><a<?=$selected?> href="<?=$url?>"><?=$item->getLabel()?></a></li>
<?
}	
?>