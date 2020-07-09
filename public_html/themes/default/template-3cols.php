<?
	include($context->findTemplate('structure/header'));
?>
			<div id="columnCol1" class="column">
				<?$this->renderComponent('col1Header')?>
				<?$this->renderComponent('col1')?>
			</div>
			
			<? $this->renderComponent('doubleColHeader',array('skipWrap'=>true))?>
				<div id="columnCol2" class="column">
					<?$this->renderComponent('col2')?>
	            </div>
	
	            <div id="columnCol3" class="column">
					<?$this->renderComponent('col3')?>
				</div>
<?
	include($context->findTemplate('structure/footer'));
?>
