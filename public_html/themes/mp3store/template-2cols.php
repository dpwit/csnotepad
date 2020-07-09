<?
	include($context->findTemplate('/structure/header'));
?>
		<div id="leftMenu" class="col">
			<?$this->renderComponent('col1')?>
		</div>

		<div id="mainMenu" class="col">
			<?$this->renderComponent('main')?>
		</div>
<?
	include($context->findTemplate('/structure/footer'));
?>
