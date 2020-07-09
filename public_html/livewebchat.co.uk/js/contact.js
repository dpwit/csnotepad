contactFormShowMessage = function (){
	$('#contact_form').slideUp();
	$('#contact_message').slideDown();
}
contactFormSubmit = function(){
	var formId = '#contact_form_form';
	var form = $(formId);
	var required = [ "full_name" , "telephone" , "email" ] ;
	var failed = false;
	$('.popup-error').remove();
	for(var a=0;a<required.length;a++){
		var sel = formId+" input[name='"+required[a]+"']";
		var el = $(sel);

		if(!el.val()){
			el.parent().children().each(function(k,el){
				el = $(el);
				if(el.hasClass('error'))
					el.remove();
			});
			$('<div class="popup-error error">Required Field</div>').appendTo(el.parent());
			if(!failed) el.focus();
			failed=true;
		}
	}
	$('.popup-error').each(function(k,el){
		$(el).fadeIn("fast",function(){ 
			el = this;
			setTimeout(function(){$(el).fadeOut("slow");},1000);
		});
	});
	if(!failed) form.ajaxSubmit({target:'#contact_message',success:contactFormShowMessage});
	return false;
};

$(function(){
	initBasket = function(){
		$('.basket-remove-link').click(function(ev){
			var el = $(this);
			id=el.closest('.basket-item').attr('id').replace(/.*-/,'');
			$('#basket_div').load("/includes/modules/basket/addAjax.php?remove["+id+"]=true",{},initBasket);
			return false;
		});
	};
	$('.basketForm').each(function(k,el){ el = $(el); el.attr('action',el.attr('action').replace('addToBasket','addAjax'));});
	$('.basketForm').ajaxForm({target: '#basket_div',success:initBasket});
	initBasket();

//	$('.propitem').rolloverPopup();
	$('tt.prop_popup').hover(
		function(){
			var el = $(this);
			var title = el.closest('.propitem').find('a').text();
			Boxy.load($(this).attr('href')+"?ajax=1",
			{
				modal: false, closable: false, title: title,
				unloadOnHide: true, draggable: false,
				y: 100,
				afterShow: function(){
					$('.prop-popup .basketForm').each(function(k,el){ el = $(el); el.attr('action',el.attr('action').replace('addToBasket','addAjax'));});
					$('.prop-popup .basketForm').ajaxForm({target: '#basket_div',
						success:	function(){
							initBasket();
							Boxy.get($('.prop-popup')).hide();
						}
					});
				}
			}
			);
		return false;
	},
	function(){
		$('.boxy-content').each(function(){
			Boxy.get($(this)).hide();
			$(this).addClass('hide-me');
		});
		setTimeout(1000,function(){$('.hide-me').closest('table').remove()});
	}
	);
	var fitImageToDiv = function(){
		var img = $(this);
		var el = img.closest('span');
		var eh = el.height(),
		    ih = img.height();
		eh=180;
		el.css('padding-top',(eh-ih)/2);
	};
	$('.scrolling-image img').each(fitImageToDiv);
	$('.scrolling-image img').load(fitImageToDiv);
	$('a').mouseover(function(){
		$(this).addClass('hover');
	}).mouseout(function(){
		$(this).removeClass('hover');
	});
	$('.image-scroller-wrapper').each(function(){
		var el = $(this);
		el.prepend("<span class='next-wrapper'><a id='"+el.attr('id')+"-prev' class='next image-nav'><span>Prev</span></a></span>");
		el.append("<span class='prev-wrapper'><a id='"+el.attr('id')+"-next' class='prev image-nav'><span>Next</span></a></span>");
	
		el.imageScroller({
			prev:	el.attr('id')+"-next",
			next:	el.attr('id')+"-prev",
			frame:	"scroller-frame-"+el.attr('id').replace("scroller-",""),
			width:	146,
			child:	".scrolling-image",
			auto:	false
		});
	});
});

