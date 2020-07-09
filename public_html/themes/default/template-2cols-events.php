<?	
include($context->findTemplate('structure/header'));?>	
<div id="content">	

<div class="inner">	
<div class="col"><?$this->renderComponent('col1')?></div>	
<?$this->renderComponent('breadcrumb')?>
<div class="last col"><?$this->renderComponent('col2')?></div>
</div>	
<?php include($context->findTemplate('structure/footer'));?>