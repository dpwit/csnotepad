$(function(){
	$('li.accordion-element').not('.selected').find('.accordion-content').hide();
	$('a.accordion-handle').live('click',function(){
		var $this = $(this);
		var old = $this.closest('ul').find('li.accordion-element').filter('.selected');

		old.removeClass('selected').addClass('not-selected');
		old.find('.accordion-content').removeClass('selected').addClass('not-selected').slideUp();
	
		$this.closest('.accordion-element').addClass('selected').removeClass('not-selected');
		$this.closest('.accordion-element').find('.accordion-content').addClass('selected').removeClass('not-selected').slideDown();
		return false;
	});
        $('body').live('ajaxFrame',function(ev){
                $('#simplemodal-data a').not('.overviewAction').not('.no-ajax').addClass('ajax-link');
                $('#simplemodal-data form.ajaxForm').each(function(){
			var $this = $(this);
			if(!$this.attr('action')) $this.attr('action',ev.url);
			$this.ajaxForm({
				target:'#simplemodal-data',
				complete:function(req){
					doAjaxFrame($this.attr('action'));
				}
			});
		});
        });
        $('a.ajax-link').live('click',function(){
		var $link = $(this);
                $.get($link.attr('href'),function(data){
                        $('#simplemodal-data').html(data);
			doAjaxFrame($link.attr('href'));
                });
                return false;
        });
        $('form.ajaxForm overviewAction').addClass('ajax-link');

	var doAjaxFrame = function (href){
				$('#simplemodal-data').addClass('ajax-target');
				$('#simplemodal-data').addClass('ajax-iframe');
				$('#simplemodal-data form').addClass('ajaxForm');
				$('#simplemodal-data form.not-ajax').removeClass('ajaxForm');
				$('#simplemodal-data form').append('<input type="hidden" name="simplemodal" value="1"/>');
				var ev = $.Event('ajaxFrame');
				ev.url = href;
				$('#simplemodal-data').trigger(ev);

	};
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
				doAjaxFrame(href);
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

	var maxHeight = 0;
	$('div.product-attribute').each(function(){
		var height = $(this).height();
		if(height>maxHeight) maxHeight=height;
	}).css({height:maxHeight});

	$('.sortable').sortable({
		handle:'.sortable-handle',
	});
	$('.sortable').live('mm-changed',function(){
		$(this).sortable({
			handle:'.sortable-handle',
		});
	});
	$('.sortable').disableSelection();
	$(".ajax-sortable").live('sortstop',function(ev,ui){
		var me = $(typeof ev.srcElement != 'undefined' ? ev.srcElement : ev.originalTarget);
		me=me.closest('.sortable>*');
		var table = me.find('.type-field').val();
		var prev = me.prev();
		var ptable = prev.find('.type-field').val();
		var command='move_after';
		if(ptable!=table){
			command='move_before';
			prev = me.next();
			ptable = prev.find('.type-field').val();
			if(ptable!=table){
				alert("Can't move here");
				return;
			}
		}
		$.get('/cms/despatch.php',{action:command,model:me.find('.model-field').val(),
			cms_uid:me.find('.id-field').val(),
			other:prev.find('.id-field').val()
		});
	});

	$('a.confirm-link').die('click.confirm').live('click.confirm',function(){
		return confirm($(this).attr('title')+". Are you sure?");
	});

});
