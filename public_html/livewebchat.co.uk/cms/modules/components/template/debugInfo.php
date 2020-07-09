<div id='debug' style='color: black; border: solid red 2px; background: white; padding: 3px; position: absolute; top:5px; left: 5px; z-index: 1500;'>
<div class='debug-trigger'>
	<a href='#' style='color: red;'>Show Debug</a>
</div>
<div class='debug-output' style='display: none'>
<?
include(dirname(__FILE__).'/outputDebugInfo.php');
?>
</div>
</div>
	<script>
	$(function(){
		$('div.debug-trigger a').click(function(){
			$('div.debug-output').toggle();
			return false;
		});
		$('ul.debug-list li').live('click',function(){
			$(this).children().filter('span.head').toggleClass("debug-handle-open debug-handle-closed");
			$(this).children().not('span.head').toggle();
			return false;
		})
		$('ul.debug-list ul').each(function(){
			var $this = $(this);
			$this.before('<span>*'+$this.children().filter(':eq(0)').text().substr(0,40)+"</span>");
		});
		$('body').live('click',function(ev){
			$('div.debug-output').hide();
		});
	});
	</script>
