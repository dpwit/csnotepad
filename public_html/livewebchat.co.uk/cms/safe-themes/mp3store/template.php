<?
	include($context->findTemplate('/structure/header'));
?>
		<div id="columnCol1" class="column">
			<?$this->renderComponent('col1')?>
                       </div>

                       <div id="columnDouble" class="column">
			<?$this->renderComponent('main')?>
                       </div>
<?
	include($context->findTemplate('/structure/footer'));
?>
