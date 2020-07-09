<?php include($context->findTemplate('structure/header')); ?>
	
	<div id="content">
	
		<div class="inner">

			<div id="feature">
				<?$this->renderComponent('featured_left')?>
			</div>
			<div class="last col">
				<?$this->renderComponent('featured_right')?>
			</div>
			<div class="col">
				<?$this->renderComponent('below_col1')?>
			</div>
			<div class="col">
				<?$this->renderComponent('below_col2')?>
			</div>
			<div class="col">
				<?$this->renderComponent('below_col3')?>
			</div>
			<div class="last col">
				<?$this->renderComponent('below_col4')?>
			</div>
			
		</div>

	</div>

		<div id="online">
		<h2 class="heading">Skint Entertainment Online</h2>
		<div class="inner">
			<div class="col">
				<?$this->renderComponent('online_col1')?>
			</div>
			<div class="middle col">
				<?$this->renderComponent('online_col2')?>
			</div>
			<div class="col">
				<?$this->renderComponent('online_col3')?>
			</div>
			<div class="last col">
				<?$this->renderComponent('online_col4')?>
			</div>
		</div>
	</div>
			
<?php include($context->findTemplate('structure/footer'));