<?php include($context->findTemplate('structure/header'));?>

				<div id="leftMenu">
<? $this->renderComponent('col1');?>
				</div>
<? $this->renderComponent('content-header');?>
				<div id="mainMenu">
<? $this->renderComponent('main');?>
				</div>
						
<?php include($context->findTemplate('structure/footer'));?>
