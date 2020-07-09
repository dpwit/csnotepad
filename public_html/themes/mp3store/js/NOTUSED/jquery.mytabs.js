$.fn.tabs = function(options){
	if(typeof options == 'undefined') options = {};
	var defaults = {
		link_selector: 'h3 a',
		pane_selector: 'div.tab',
		init: 0	
	};
	var $tabs = $(this);
	$.extend(defaults,options);
	options = defaults;
	var links = $(options.link_selector,this);
	links.click(function(){
		var links = $(options.link_selector,$tabs);
		var tabs = $(options.pane_selector,$tabs);
		var curr = $('#'+$(this).attr('href'),$tabs);
		var inactive = tabs.not(curr);
		inactive.hide();
		curr.show();
		curr = $(this);
		inactive = links.not(curr);
		curr.addClass('tab-selected').removeClass('tab-not-selected');
		inactive.addClass('tab-not-selected').removeClass('tab-selected');
		return false;
	});
	links.filter(':eq(0)').click();
};
$(function(){
	
});
