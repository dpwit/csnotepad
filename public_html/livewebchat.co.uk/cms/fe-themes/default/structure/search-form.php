<form method='get' id ='search-input' action='/search.html'>
	<input name='q' id="searchbox" value='<?=htmlspecialchars(stripslashes_if($_REQUEST['q']))?>'/>
	<input type='submit' id="searchSubmit" class="buttongo" value=' '/>
<script>
	$(function(){
		$('#search-input').append($('#breadcrumb-search-fields').html());
	});
</script>
</form>
