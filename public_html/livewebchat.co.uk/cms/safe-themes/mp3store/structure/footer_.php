	
	<div id="footer">
		<div class="inner">
			<div class="footerMenu">
				<a href="/news">News</a> |
				<a href="/artists">Artists</a> | 
				<a href="/gallery">Gallery</a> | 
				<a href="/videos">Videos</a> |
				<a href="/events">Events</a> |
				<a href="/shop">Shop</a> |
				<a href="/contact">Contact</a>
			</div>
			<?=Config::value('copyright','site')?>.&nbsp; Site by <a href="http://www.bozboz.co.uk" title="Web Design Brighton">BozBoz</a>
		</div>
	<? cms_trigger_action('fe_template_footer',$this); ?>
	</div>

<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>
<?
	cms_trigger_action('fe_template_end');
?>