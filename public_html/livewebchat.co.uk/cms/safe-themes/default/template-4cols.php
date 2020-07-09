<?
	include($context->findTemplate('structure/header'));
?>

	<div id="leftSide">
		<div id="feature"><?$this->renderComponent('featured')?></div>
		<div class="col"><?$this->renderComponent('left_col1')?></div>
		<div class="col"><?$this->renderComponent('left_col2')?></div>
		<div class="last col"><?$this->renderComponent('left_col3')?></div>
	</div>
	<div id="rightSide">
			<div class="last col"><?$this->renderComponent('right_col1')?></div>
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
