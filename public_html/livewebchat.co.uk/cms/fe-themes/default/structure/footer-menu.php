<?
$func = $this->param('urlFunc');
$done=false;
foreach($list as $item){
if($done) echo " | ";
$done=true;
?>
	<a class="menuitem" href='<?=$item->$func()?>'><span><?=$item->getLabel()?></span></a>
<?
}	
?>
