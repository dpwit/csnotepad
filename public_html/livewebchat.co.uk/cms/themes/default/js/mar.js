var ajaxListeners = [];
var onInit = [],
    onInitK = {};
onPageInit = function(f,k){
	if(k){
		onInitK[k] = f;
	} else {
		onInit.push(f);
	} 
};
reinit = function($el){
	for(var a = 0 ; a<onInit.length ; a++)
		onInit[a]($el);
	for(k in onInitK){
		onInitK[k]($el);
	}
	$el.trigger('reinit');
}
$.fn.scrollTo = function(){
        var targetOffset = this.offset().top;
        $('html,body').animate({scrollTop: targetOffset}, 500);
};
$(function(){
	var myUrl=document.location.href;
	var setActions = function(){
		var el = $(this);
		var action = this.getAttribute('action');
		if(!isset(action)) el.attr('action',action = myUrl);
		el.attr('action',el.attr('action')+(action.match(/\?/)?'&':'?')+"no_template=true");
	};
	var isset = function(o){
		return o != null && typeof o != 'undefined';
	};
	var doShortCourseVisible = function($table){
		var $row = $table.find('tr.shortcourse-row');
		var $inputs = $row.find('input');
		var $checked = $inputs.filter('input:checked');
		if($checked.length==2){
			var start = $inputs.index($checked.eq(0));
			var end = $inputs.index($checked.eq(1));

			$table.find('tr').slice(2).each(function(){
				var $row = $(this);
				$inputs = $row.find('input.not-time');
				$inputs.slice(0,start).hide();
				$inputs.slice(start,end+1).show();
				$inputs.slice(end+1,28).hide();
			});
		 } else {
			 $table.find('input').show();
		 }
	};
	$('tr.shortcourse-row input').live('click',function(){
		var $this = $(this);
		var $row = $this.closest('tr');
		var $inputs = $row.find('input');
		var index = $inputs.index($this);

		$checked = $inputs.filter('input:checked');
		var start = -1;
		var end = -1;
		if($checked.length>2){
			$checked.each(function(){
				var $el = $(this);
				var myindex = $inputs.index($el);
				if(myindex==index) return;
				if(start==-1){
					start = myindex;
				} else {
					end = myindex;
				}
			});
			if(index<start) start=index;
			else if(index>end) end=index;
			else {
				if((index-start)<(end-index)){
					start=index;
				} else {
					end=index;
				}
			}
			$checked.attr('checked',false);
			$on = $inputs.eq(start).add($inputs.eq(end));
			$on.attr('checked',true);
		}
		doShortCourseVisible($this.closest('table'));
	});
	var checkRow = 	function(){
		var el = $(this);
		var checked = el.attr('checked');
		el.closest('tr').find('input:checkbox').attr('checked',checked);
	};
	$('input.hselect-all').live('change',checkRow).live('click',checkRow);
	$('input.vselect-all').live('change',function(){
		var el = $(this);
		var pos = el.closest('tr').find('td').index(el.closest('td'));

		var checked = el.val();
		el.closest('table').find('tr').each(function(){
			$(this).find('td:eq('+pos+') input').val(checked);
		});

	});
	$('a.magnify').live('click',function(ev){
		var $this=$(this);
		$('div.magnifier').remove();
		$('img.magnified').remove();
		var $mag = $('<div class="magnifier"></div>');
		$mag.css({position:'relative',width: '0px',height: '0px'});
		$image = $('<img class="magnified" src="'+$this.attr('href')+'"/>').appendTo($mag);
		$image.css({position:'absolute',top:"-80px",left:"-80px",border:'solid black 2px'});
		$mag.appendTo($this.parent());
		ev.preventDefault();
		ev.stopPropagation();
		return false;
	});
	$('div.magnifier').live('click',function(){$(this).remove();});
	$('div.initialised-ajax-iframe a').live('click',function(ev){
		if(ev.isPropagationStopped()) return false;
		var $a = $(this);
		var $frame = $a.closest('div.ajax-iframe');
		var e = $.Event('ajax-click');
		$a.trigger(e);
		if(e.isDefaultPrevented()) return false;
		if($a.hasClass('magnify')) return;
		$frame.load($a.attr('href'),{},function(req){
			$frame.addClass('ajax-iframe');
			$frame.html(req);
			var ev = $.Event('ajaxFrame');
			ev.url = $a.attr('href');
			$frame.trigger(ev);
			initPage($a.attr('href'),$frame);
		});
		ev.stopPropagation();
		ev.preventDefault();
		return false;
	});
	$('div.file-input input').live('change',function(){
		var $fakeInput = $('div.file-overlay input[type=text]',$(this).closest('.file-overlayer'));
		$fakeInput.attr('disabled',false);
		$fakeInput.val($(this).attr('value'));
		$fakeInput.attr('disabled',true);
	});
	$('input.manual-timer').live('click',function(){
		var $checkbox = $(this);
		var $table = $checkbox.closest('table');
		if($checkbox.is(':checked')){
			$table.find('tr.no-fixed-time').show();
			$table.find('span.non-fixed').show();
			$table.find('span.fixed-time').hide();
		} else {
			$table.find('tr.no-fixed-time').hide();
			$table.find('span.non-fixed').hide();
			$table.find('span.fixed-time').show();
		}
	});
	initPage = function(url,$el){
		if(!(isset($el) && typeof $el=='object')){
			$el = $(document.body);
		}
		myUrl = url;
		$el.trigger('ajax_load',{url:url});
		//$(document.body).trigger('ajax_load',{url:url});
		var displayByCheckbox = function($check){
			var on = $check.is(':checked');
			var wasVisible = $check.closest('div.checkbox-selector').find('div.checkbox-'+(on?'on':'off')+' img').is(':visible');
			$check.closest('div.checkbox-selector').find('div.checkbox-on').css({display:on?'block':'none'});
			$check.closest('div.checkbox-selector').find('div.checkbox-off').css({display:on?'none':'block'});
			if(!wasVisible)
				$check.closest('div.checkbox-selector').find('div.checkbox-'+(on?'on':'off')+' img').trigger('shown');
		}
		$('div.checkbox-control input:checkbox',$el).each(function(){
			$this = $(this);
			displayByCheckbox($this);
			$this.click(function(){ displayByCheckbox($(this)); });
		});
		$('form.ajaxForm',$el).each(function(){
			var el = $(this);
			var lastUrl = url;
			el.ajaxForm({
				target: el.closest('.ajax-target'),
				enctype: "multipart/form-data",
				beforeSubmit: function (data,form){
					data.push({name:'no_template',value:1});
					if(form.closest('div.simplemodal-data').size()) data.push({name:'simplemodal',value:1});
					lastUrl = form.attr('action');
					setTimeout(function(){form.html("<h2>Please Wait...</h2>");},300);
					return true;
				},
				success: function(resp){
					$(this).html(resp);
					if($('#response-container')[0]) {
						var resp = $('#response-container').val();
						$(this).html(resp);
					}
					$('form',this).addClass('ajaxForm');
					var ev = $.Event('ajaxFrame');
					ev.url = lastUrl;
					$(this).trigger(ev);
					initPage(lastUrl,$(this));
				},
				method:'post'
			});
		});
		$('form.ajaxForm',$el).addClass('oldAjaxForm').removeClass('ajaxForm');
		var $table = $('table:has(input.manual-timer)',$el);
		$table.find('table.application-input tr:has(input.hselect-all) input:checkbox').addClass('not-time');
		$('tr.shortcourse-row',$el).each(function(){
			doShortCourseVisible($(this).closest('table'));
		});
		$('div.ajax-iframe',$el).addClass('scrollable');
		$('a[rel*=magnify]',$el).attr('target','__blank');

		myUrl = url;
		$('div.ajax-iframe form',$el).each(setActions);

		var $frame = $('div.ajax-iframe',$el);
		$frame.removeClass('ajax-iframe').addClass('initialised-ajax-iframe');
		$('div.file-overlay input',$el).attr('disabled',true).css({'color':'#000'});

		$('tr.no-fixed-time',$el).hide();
		$('span.non-fixed',$el).hide();
		$('form.warn-on-navigate',$el).bind('submit',function(){
			$(this).removeClass('modified');
		});
		reinit($el);
	};
		$('div.initialised-ajax-iframe,div.ajax-iframe').live('ajaxFrame',function(ev){
			myUrl = ev.url;
			$('form',this).each(setActions);
		});
	$('li.action a').each(function(){
		$this = $(this);
		$this.attr('title',$this.text());
	});
	$('div.block-cover').each(function(){
		var el = $(this);
		el.css({height: el.parent().height(),width: el.parent().width(),zIndex:10});
	});
	$('li.selected').each(
		function(){
			$this=$(this);
			$this.parent().scrollTop($this.parent().scrollTop()+$this.offset().top-$this.parent().offset().top-50);
		}
	);
	initPage('',$(document.body));
	$('input,textarea,select').live('change',function(){$(this).trigger('value-changed');});
	$('input:checkbox').live('click',function(){$(this).trigger('value-changed');});
	$('form').live('value-changed',function(){$(this).addClass('modified');});
	$('div.form_row').addClass('highlight-changed');
	$('div.highlight-changed').live('value-changed',function(){$(this).addClass('changed'); $(this).parent().closest('div.highlight-changed').trigger('value-changed')});
	window.onbeforeunload = function(){ 
		if($('form.warn-on-navigate.modified').size()){
			$('form.warn-on-navigate div.highlight-changed.changed').scrollTo();
			return "You have unsaved changes"; 
		}
	};
	$('#simplemodal-data form.not-ajax').live('submit',function(){$.modal.close();});
	$("a.popup-link").live('click', function(e) {
		e.preventDefault();
		var href = $(this).attr('href');
		if(href.match(/\?/))href+="&";
		else href+="?";
		href+="no_template=true";
		var $link = $(this);
		$.get(href,function(data) {
			$.modal(data, { minHeight: 400, minWidth: 600, 
			onShow : function(){ 
				$('#simplemodal-data').addClass('ajax-target');
				$('#simplemodal-data').addClass('ajax-iframe');
				$('#simplemodal-data form').addClass('ajaxForm');
				$('#simplemodal-data form.not-ajax').removeClass('ajaxForm');
				$('#simplemodal-data form').append('<input type="hidden" name="simplemodal" value="1"/>');
				var ev = $.Event('ajaxFrame');
				ev.url = href;
				$('#simplemodal-data').trigger(ev);
				initPage(href,$('#simplemodal-data'));
				$link.trigger('popup-opened');
			},__onClose: function(){
				if($('#simplemodal-data form.warn-on-navigate.modified').size()){
					if(confirm("Your changes are not saved.\nIf you wish to close this window and lose your changes click OK\n If you wish to go keep this window open click Cancel")){
						$.modal.close();
						$.modal.close();
					}
				}
			}});
		});
	});
	$('div.reveal-hidden').hide();
	$('div.reveal-teaser').live('click',function(){
		$(this).closest('.reveal').find('.reveal-hidden').show();
		$(this).hide();
	});
	$('div.toggle-more').each(function(){
		var $this = $(this);
		$this.html("<a href='#' class='toggle-link'>More</a><div class='toggle-content'>"+$this.html()+"</div>");
		$('div.toggle-content',$this).hide();
	});
	$('a.toggle-link').live('click',function(){
		$(this).closest('.toggle-more').find('.toggle-content').show();
		$(this).hide();
		return false;
	});
});


