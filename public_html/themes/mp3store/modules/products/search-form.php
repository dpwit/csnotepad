<?
	$shop = Model::loadModel('Page')->getFirst(array('title'=>'shop'))->getUrl();
?>
<div class='thinBorder box'>
<h2>Browse by Artist</h2>
<select id='artist-selector' class='navigation-select'>
	<option value=''>Select Artist</option>
<?
	foreach(Model::loadModel('Artist')->getAll(cms_apply_filter('artists_restrict',array('status >'=>0))) as $artist){
		$url = "$shop/".$artist->getSlug();
		$selected = BreadCrumb::selected($url) ? " selected='selected'":"";
?>
		<option value='<?=$url?>'<?=$selected?>><?=$artist->getLabel()?></option>
<?

	}
?>
</select>
<script>
	//$('select.navigation-select').live('change',function(){
	$('select.navigation-select').change(function(){
		var v = $(this).val();
		if(v) document.location.href=v;
	});
</script>
</div>

<div class='thinBorder box'>
<h2>Search</h2>
<form action="<?=$shop?>/search" style="margin-top: 5px; margin-bottom: 1px">
	<input class="searchbox" type="text" name="q" value="<?=@htmlspecialchars($_GET['q'],ENT_QUOTES)?>" />
	<input type="submit" value="Search" class="coolButton" style="cursor: pointer; width: 60px" />
</form>
</div>

