<?
	class StockControlController extends Controller {
		function index(){
			$this->showView('stock_report');
		}
		function cms_updateStock($params){
			$prod = Model::loadModel('Product')->get($params['product']);
			$amount = $_POST['stock'];
			if(@$_POST['remove']){
				$amount=-$amount;
			}
			$prod->addStock($amount);
			header("Location: $_SERVER[HTTP_REFERER]");
		}
		function getModelName(){
			return "StockControl";
		}
	}
?>
