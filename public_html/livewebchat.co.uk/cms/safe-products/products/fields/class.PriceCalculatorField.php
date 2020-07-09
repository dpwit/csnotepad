<?
	class PriceCalculatorField extends NumericField {
		function renderHtml($obj){
			$v = $this->getValue($obj);
			$hn = $this->htmlName($obj);
			$html = "<div class='vat-calc' id='$hn-wrap'>";

			$vat = 1.15;
			$v = number_format($v/$vat,2);
			$html.= " Ex VAT <input type='text' value='".htmlspecialchars($v,ENT_QUOTES)."' class='ex-vat' id='$hn-vat'/>";
			$html.= " Inc VAT ".parent::renderHTML($obj);
			$html.= '<script>
				var id="'.htmlspecialchars($hn,ENT_QUOTES).'";
			$("div.vat-calc input").die(".vatcalc");
			$("div.vat-calc input").live("change.vatcalc",function(){
				var $this = $(this);
				var $other = $this.closest(".vat-calc").find("input").not($this);
				if($this.hasClass("ex-vat")){
					$other.val(($this.val()*'.$vat.').toFixed(2));
				} else {
					$other.val(($this.val()/'.$vat.').toFixed(2));
				}
			});
			$("div.vat-calc input").live("blur.vatcalc",function(){
				var $this = $(this);
				$this.val(($this.val()*1).toFixed(2));
			});
			</script></div>';
			return $html;

		}
		
	}
?>
