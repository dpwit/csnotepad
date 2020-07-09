
		</div>
		
	<div id="footer">
		<div class="inner">
         <img src="images/boz.png" alt="Site by Bozboz"/> Site by BozBoz <a href="http://www.bozboz.co.uk" class="site-by">web design Brighton</a>
		<div id="copyright"><?=Config::value('copyright','site')?></div>
		</div>
	</div>	
	
	<? cms_trigger_action('fe_template_footer',$this); ?>

</body>
</html>
<?
	cms_trigger_action('fe_template_end');
?>
