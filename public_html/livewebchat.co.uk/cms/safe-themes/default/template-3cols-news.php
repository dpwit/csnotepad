<?
	include($context->findTemplate('structure/header'));
?>

	<div id="content">
	
		<div class="inner">
	
			<div class="col"><?$this->renderComponent('col1')?></div>
			<?$this->renderComponent('breadcrumb')?>
            <div class="newsarticle">
			<div class="col"><?$this->renderComponent('col2')?></div>
			<div class="last col"><?$this->renderComponent('col3')?></div>
            <br clear="all" /></div>
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
