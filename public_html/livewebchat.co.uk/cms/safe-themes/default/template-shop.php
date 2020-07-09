<?include($context->findTemplate('structure/header'));?>
		<? $this->renderComponent('content-header');?>

            <div id="columnThin" class="column">
		<? $this->renderComponent('col1');?>
            </div>
            <div id="columnWide" class="column last">

		<? $this->renderComponent('main');?>
            </div>
<?include($context->findTemplate('structure/footer'));?>
