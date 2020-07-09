$('div.filter').live('click',function(){
	var $this = $(this);
	$this.find('ul.filter-list li.not-selected').toggle();
});
$('a.selected').live('click',function(){
	var $div = $(this).closest('div.filter');
	if($div.length>0) {
		$div.click();
		return false;
	}
});
