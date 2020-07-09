$(function(){
	$('a.submit-link').live('click',function(){
		$(this).closest('form').submit();
		return false;
	});
});
