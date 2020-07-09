</div><!--.basket-summary-->
<script>
	$('body').die('basket-modified.basket-summary');
	$('body').live('basket-modified.basket-summary',function(){
		$(this).load("/basket/refresh");
	});
</script>
