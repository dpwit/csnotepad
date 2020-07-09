$(document).ready(function() {
	$('#tabContent').width(parseInt($('#tabMask').width() * $('#tabContent .contentTab').length));

	$('a[rel="panel"]').click(function () {
		$('a[rel="panel"]').removeClass('selected');
		$(this).addClass('selected');
		$('#tabMask').animate({},{queue:false, duration:500});
		$('#tabMask').scrollTo($(this).attr('href'), 800);
		return false;
	});

	$('.shade_me').hide();
	$('#collapsingText').hide();

	$('#expandingtext').on('click',function(){
		var shade_text = $('.shade_me');
		shade_text.slideDown(500);

		$(this).hide();
		$('#collapsingText').show();

		return false;
	});
	$('#collapsingText').on('click',function(){
		var shade_text = $('.shade_me');
		shade_text.slideUp(500);

		$(this).hide();
		$('#expandingtext').show();

		return false;
	});
});