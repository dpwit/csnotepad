<style>
	.auth3d-iframe {
		width: 100%;
		height: 400px;
		background: white;
	}
</style>
<?= $order->hidden3DAuthStuff(); ?>
<script>
	var TermURL = '<?=$return_url?>';
</script>
<iframe src='<?=$auth3d_iframe?>' class='auth3d-iframe'>
</iframe>
