						<div id="productDetail">
						<?=$this->view($context,$product->template('sidebar'),array('product'=>$product,'basket'=>$basket))?>
							<div id="pdContent">
				
				<?=$this->view($context,$product->template('summary'),array('product'=>$product,'basket'=>$basket))?>
						</div>		
<form id="questionnaire" action="<?=$product->getPurchaseUrl()?>" method="POST" >
<?php include $product->form_name; ?>
<input class="QuestionnaireSubmit" type="submit" value="Submit" />
</form>
<script>
$(document).ready(function() { 
	$('#questionnaire').validationEngine();
});
</script>