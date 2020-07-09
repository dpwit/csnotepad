<?include($context->findTemplate('structure/header'));?>

	<div id="content">
	
		<div class="inner">

				<div class="col">
				
<? $this->renderComponent('col1');?>
					
				</div>
<? $this->renderComponent('content-header');?>
				<div class="last col">
				
<? $this->renderComponent('main');?>
				</div>
			
		</div>

	</div>
				
<?include($context->findTemplate('structure/footer'));?>
