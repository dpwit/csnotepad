$(function(){
	$('div.delete-link').live('click',function(){
		var $this = $(this);
		var $im = $this.closest('.variationimage');
		setTimeout(function(){
			$im.find('.reveal-hidden,.reveal-teaser').toggle();
		},300);
	});
});
