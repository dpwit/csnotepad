<?
	ob_start();
	$template = $this;
	include(dirname(__FILE__).'/outputDebugInfo.php');
	$content = ob_get_contents();
	ob_end_clean();
?>
<script>
if(typeof $ != 'undefined' )
	$('#debug .debug-output').html("<pre><?=str_replace("\n","\\n",htmlspecialchars($content,ENT_QUOTES))?></pre>");
</script>
