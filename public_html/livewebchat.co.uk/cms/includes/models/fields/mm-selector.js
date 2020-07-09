$(function(){
	$.fn.mm_selector = function(values,options){
		var defaults = {
			inline: false,
			itemtag: 'div',
		};
		if(typeof options == 'undefined') options = {};
		$.extend(defaults,options);
		options = defaults;
		
		var $this = $(this);
			
		for(i=0;i<values.length;i++){
			appendMM($this,values[i]);	
		}
		$this.data('mm-options',options);
		$this.addClass('mm-selector');

		if(options.inline){
			setTimeout(function(){
				var $add = $('div.mm-selector-search a.mm-selector-add');
				var $placeholder = $add.closest('.mm-selector-search');
				$frame = $('<div class="placeholder"></div>');
				$frame.css({
					position: 'absolute',
					zIndex:1500
				});
				$frame.appendTo($('body'));
				$frame.addClass('ajax-form');
				$frame.load(
					$add.attr('href'),
					{},
					function(text,stat,resp){
						$this.trigger('ajaxFrame');
						$frame.find('form').addClass('ajax-form').attr('action',$add.attr('href'));
						$frame.addClass('ajax-iframe');
						setInterval(function(){
							var $place = $frame.data('placeholder');
							$place.css({width: $frame.width(),height: $frame.height()});

							var boxy = Boxy.get($place);
							if(boxy) 
								boxy.center();
							$frame.css($place.offset());
						},100);
					}
				);
				$add.hide();
				$frame.data('placeholder',$placeholder);
				$placeholder.closest('form').bind('submit',function(){$frame.hide();});
			},100);
		}

	};
	appendMM = function($el,values){
		var template = $('.mm-selector-prototype',$el).html(),
			$list = $('.mm-selector-list',$el);
		var myTemplate = template.replace(/###ID###/g,values.id).replace(/###LABEL###/g,values.label);
		$list.append(myTemplate);
		$list.trigger('mm-changed');
	}
	$('a.mm-selector-sort').live('click',function(){
		var $this = $(this);
		var options = $this.closest('.mm-selector').data('mm-options');
		var $me = $(this).closest('.mm-selector-item');
		if($this.hasClass('mm-selector-up')){
			var $prev = $me.prev();
			if($prev.length){
				$prev.before("<"+options.itemtag+" class='mm-selector-item'>"+$me.html()+"</"+options.itemtag+">");
				$me.remove();
			}
		} else {
			var $next = $me.next();
			if($next.length){
				$next.after("<"+options.itemtag+" class='mm-selector-item'>"+$me.html()+"</"+options.itemtag+">");
				$me.remove();
			}
		}
		return false;
	});

	$('a.mm-selector-add').live('ajaxClick',function(){
		lastMMSelect = $(this).closest('.mm-selector-wrapper');
	});
	$('a.mm-selector-add').live('click',function(){
		var $wrap = $(this).closest('.mm-selector-wrapper');
		if($wrap.length>0)
			lastMMSelect = $wrap;
	});
	$('a.mm-selector-select').live('click',function(){
		var $this = $(this);
		var values = $this.attr('href').split(":",2);

		var mySelect;
		if(typeof lastMMSelect == 'undefined'){
			mySelect = $this.closest('.placeholder').data('placeholder').closest('.mm-selector-wrapper');
		} else {
			mySelect = lastMMSelect;
		}
		appendMM(mySelect,{id:values[0],label:values[1]});
		if($.modal){
			$.modal.close();
		} else {
			var boxy = Boxy.get($this);
			if(boxy) boxy.close();
		}
		return false;
	});
	$('a.mm-selector-remove').live('click',function(){
		$list = $(this).closest('.mm-selector-list');
		$(this).closest('.mm-selector-item').remove();
		$list.trigger('mm-changed');
		return false;
	});

});
