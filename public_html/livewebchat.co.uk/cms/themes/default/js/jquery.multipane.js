$(function(){
	$('a.pane-activator').live('click',function(){
		var el = $(this);
		$('a.link-selected').removeClass('link-selected').addClass('link-noselected');
		el.addClass('link-selected').removeClass('link-noselected');
		var target = el.attr('href').replace(/^.*#/,"#");
		target = $(target);
		target.closest('.multi-pane').find('div.edit-pane').hide();
		target.show();
		reinit(target.attr('id'));
		$('img',el).trigger('shown');
		return false;
	}).addClass('link-noselected');
	$('div.multi-pane .edit-pane:eq(0)').show();
	$('a.pane-activator:eq(0)').removeClass('link-noselected').addClass('link-selected');
});
