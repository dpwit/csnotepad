<?
	class BasketSummary extends FileInclude {
		function __construct(){
			$basket = Model::g('Basket',0);
			if($basket && ($p = $basket->products())){
				$template = "modules/basket/summary";
			} else {
				$template = "modules/basket/empty";
			}
			parent::__construct($template,array('basket'=>$basket,'products'=>$p));
		}
	}
?>
