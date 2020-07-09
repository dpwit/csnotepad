$(function(){
var createPageSelectors = function(){
	$('div.date-selector').each(function(k,el){
		el = $(el);
		if(el.hasClass('date-selector-done')) return;
		id=el.find('input').attr('id');
		el.attr('id',id+"-wrapper");
		var def = $('#'+id).val().split("-");

		$params = $('input.params',el);

		var defParams = {
			dateFormat: "dd-mm-yy",
			defaultDate:def[1]+"-"+def[0]+"-"+def[2],
			changeYear: true,
			yearRange:'1880:'+(new Date().getFullYear()),
			duration: 0
		};

		var params = defParams;
		try {
			params = eval("params = "+$params.val());
			params = $.extend(defParams,params);
		} catch(err){
		}

		el.addClass('date-selector-done');
		el.find('input').datepicker(params);
	});
};

createPageSelectors();
$(document.body).bind('ajax_load',createPageSelectors);
});
