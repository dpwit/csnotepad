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
	}
	$('.basketForm').each(function(k,el){ el = $(el); el.attr('action',el.attr('action').replace('addToBasket','addAjax'));});
	$('.basketForm').ajaxForm({target: '#basket_div',success:initBasket});
	initBasket();
});

