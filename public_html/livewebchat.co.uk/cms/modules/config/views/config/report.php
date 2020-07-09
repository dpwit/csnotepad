<div class="config-section">
<form method='post' action='<?=$model->urlFor('save')?>'>
<input type='hidden' name='page' value='<?=htmlspecialchars($_GET['page'],ENT_QUOTES)?>'/>
<h2>Config Section <?=htmlspecialchars(ucwords($_GET['page']))?></h2>
<table>
<?
	$config = $GLOBALS['CONFIG'][$_GET['page']];
	foreach($config as $k=>$v){
?>
	<tr><th><?=$k?></th><td>
		<input type='text' name='<?=$_GET['page']?>.<?=$k?>' value='<?=htmlspecialchars($v,ENT_QUOTES)?>'/>
	</td></tr>
<?
	}
?>
</table>
<input type='submit' value='Save Config'/>
</form>
</div>