<?
	include($context->findTemplate('structure/header'));
?>

	<div id="content">
	
		<div class="inner">
	
			<div class="col"><?$this->renderComponent('col1')?></div>
			<?$this->renderComponent('breadcrumb')?>
			<div class="col"><?$this->renderComponent('col2')?></div>
			<div class="last col">
			
				<?$this->renderComponent('col3')?>
				
				<div class="noBorder box" id="socialMedia">
					<h2 class="large">Become a Fan</h2>
					
					<div class="col"><?$this->renderComponent('right_col1')?></div>
					<div class="last col"><?$this->renderComponent('right_col2')?></div>
				
				</div>
				
			</div>

		</div>
		
	</div>
			
			
			
			<?php /*<div id="columnCol1" class="column">
				<?$this->renderComponent('col1')?>
                        </div>

                        <div id="columnDouble" class="column">
				<?$this->renderComponent('main')?>
                        </div>
<? */
	include($context->findTemplate('structure/footer'));
?>
