<?php

class AutoAddressField extends TextArea
{

		function renderHTML($obj){
			$str = parent::renderHTML($obj);
			$field_prefix="order-{$obj->uid}-";
			
			$db_filed_prefix = $this->params['field_prefix'];
			
			$fields = array(
				"{$db_filed_prefix}_address",
				"{$db_filed_prefix}_city",
				"{$db_filed_prefix}_postcode",
				"{$db_filed_prefix}_country",
			);
			
			foreach($fields as $k=>$v)
			{
				$selectors .= ($selectors?',':'').'input[name='.$field_prefix.$v.'], textarea[name='.$field_prefix.$v.'], select[name='.$field_prefix.$v.']'; 
			}
			
			$target = $field_prefix.'company_address';
			
			$str.=<<<JAVASCRIPT
<br /><button class="coolButton billingAddy" id="auto_address">Use Billing Address</button>
<script>
	$('#auto_address').click(function(ev){
		ev.stopPropagation();
		var address= "";
		$('{$selectors}').each(function(i,e){ 
			address += (address ? ",\\n" :"") + $(e).val() 
		});
		
		$('textarea[name={$target}]').val(address);
		return false;
	});
</script>
JAVASCRIPT;
			return $str;
		}
}
