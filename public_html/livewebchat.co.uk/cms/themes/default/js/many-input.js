$(function(){
	$('div.manyinput div.many-record-html-control input:not(:checked)').closest('.many-record').find('.many-sub-form').css({opacity:0.5});
	$('div.manyinput div.many-record-html-control input:checkbox').click(function(){
		$(this).closest('.many-record').find('.many-sub-form').css({opacity:$(this).is(':checked')?1:0.5});
	});
	$('div.manyinput div.many-sub-form').live('change',function(){
		var $check = $(this).closest('.many-record').find('.many-record-html-control input:checkbox');
		if(!$check.is(':checked')){
			$check.attr('checked',true).trigger('click').attr('checked',true);
		}
	});

	$('div.ajaxmanyinput div.many-record-html-control input:checked').closest('.many-record').find('.many-sub-form').css({opacity:0.5});
	$('div.ajaxmanyinput div.many-record-html-control input:checkbox').click(function(){
		$(this).closest('.many-record').find('.many-sub-form').css({opacity:$(this).is(':not(:checked)')?1:0.5});
	});
	$('div.ajaxmanyinput div.many-sub-form').live('change',function(){
		var $check = $(this).closest('.many-record').find('.many-record-html-control input:checkbox');
		if(!$check.is(':not(:checked)')){
			$check.attr('checked',true).trigger('click').attr('checked',true);
		}
	});
	$('a.many-add-link').die('click.many').live('click.many',function(){
		var $cont = $(this).closest('.many-container');
		var $template = $("div.many-template",$cont);
		var html = $template.html();
		var index = $cont.children('.many-record').length+1;
		var id = 'NEW'+index;

		html=html.replace(/###INDEX###/g,index).replace(/###ID###/g,id);

		$template.before(html);
		return false;
	});
	$('div.form_row.remove').replaceWith("<a class='many-remove-link'>Remove</a>");
	$('td.remove input:checkbox').replaceWith("<a class='many-remove-link'>Remove</a>");
	$('a.many-remove-link').live('click.remove',function(){
		var $record = $(this).closest('.many-record');
		$record.addClass('pending-delete');
		if(confirm('Delete this record?')) $record.remove();
		else $record.removeClass('pending-delete');
	});
});
