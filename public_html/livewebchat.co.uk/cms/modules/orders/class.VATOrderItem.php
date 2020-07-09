<?
	Model::loadModel('Order_Item');
	class VATOrderItem extends Extra_Charge {
		function getFields(){
			parent::getFields();
			$this->fields['name']->setDefault('VAT');
			return $this->fields;
		}

		function getAssignArray($obj=null){
			$ass=parent::getAssignArray($obj);
			if(!$obj) $obj=$this;
			$ass['ref_table'] = 'vat';
			return $ass;
		}

		function setPrice($price){
			//parent::setPrice($this->order()->addVat($price)-$price);

			$order = $this->order();
			if($order->requiresVAT()){
			$inc=$ex=0;
			$maxSort = 0;
			foreach($order->order_items() as $item){
				if($item->isTax()) continue;
				$inc+=$item->getTotalPrice(true);
				$ex+=$item->getTotalPrice(false);
				$maxSort = max($maxSort,$item->sorting);
			}
			$lessVAT = $ex;
			$vat = $inc-$lessVAT;
			} else {
				$vat = 0;
			}
			$this->sorting = $maxSort+1;
			parent::setPrice($vat);
		}

		function isTax(){
			return true;
		}
		function getDisplayQuantity(){
			return number_format_max_places($this->order()->getVatRate()*100,2)."%";
		}
	}
?>
