<?
	require_once(__MODELS_BASE__.'/engines/session_engine.php');
	class Basket extends BozModel {
		function __construct($obj=null){
			$this->engine = SessionEngine::getInstance();
			$this->hasRelationship('products',array(
				'manager'=>__MODELS_BASE__.'/relationships/class.MMCommaSeparated.php:MMCommaSeparated'
			));
			parent::__construct($obj,'basket');
			if(@$this->products && is_string($this->products)) $this->products = explode(",",$this->products);
			if(!@$this->products) $this->products=array();
		}

		function getFields(){
			require_once(__MODELS_BASE__.'/fields.php');
			$this->fields = array(
				'uid'=>new IDField('uid'),
				'name'=>new TextField('name'),
				'products'=>new HiddenField('products'),
			);
			return $this->fields;
		}

		function addToBasket($context,$extraUrl){
			if(count($_SESSION['baskets'])>1){
				unset($_SESSION['baskets']);
			}
			if(Config::value('clear_basket_on_add','products')) $this->products = array();
			$quantities = array();
			// Fixed a Tab & Added Some Hooks - Garett
			if(@$_POST['product_id']){
				if(array_key_exists('qty',$_POST)){
					$count = $_POST['qty'];
				} else {
					$count = 1;
				}
				$product = array_shift($extraUrl);
				if(!$product) $product=$_REQUEST['product_id'];
				$quantities[$product] = $count;
			} elseif(@$_POST['product_ids']){
				foreach($_POST['product_ids'] as $k=>$v){
					@$quantities[$v]++;
				}	
			} elseif(@$_POST['quantity']) {
				$quantities = $_POST['quantity'];
			} else {
				$quantities[array_shift($extraUrl)]++;
			}
			foreach($quantities as $product=>$count){
				if(!$product) continue;
				while($count-->0){
					$this->products[] = $product;
					$this->triggerAction('addToBasket',$product,$context,$extraUrl);
				}
			}
			// End Of Garett's Fixs
			$this->writeToDB();
//			if(cms_apply_filter('',true)) 
			if(@$_REQUEST['ajax']){
				$this->showView('json');
			} else {
				if(Config::value('basket_after_add','products')){
					redirectTo('/shop/view-cart.html');
				}
				elseif(Config::value('checkout_after_add','products'))
					redirectTo('/shop/checkout.html');
				elseif($ref = @$_GET['ref']){
					redirectTo($ref);
				} else {
					redirectReferer();
				}
			}
		}
		function removeFromBasket($context,$extraUrl){
			$this->products = array_diff($this->products,array_slice($extraUrl,0,1));
			$this->writeToDB();
			if(@$_REQUEST['ajax']){
				$this->showView('json');
			} else {
				redirectReferer();
			}
		}
		function emptyBasket(){
			$this->products = array();
			$this->writeToDB();
		}

		function contains($product){
			if(is_object($product)) $product=$product->getId();
			if(is_string($this->products)){
				$this->products = explode(",",$this->products);
			}
			return in_array($product,$this->products);
		}

		function getQuantities(){
			$byId = array();
			$products = $this->products();
			foreach($products as $p){
				if(!$p) continue;
				@$byId[$p->getId()]++;
			}
			return $byId;
		}
		function copyToOrder($order){
			$byId = $this->getQuantities();
			$products = $this->products();
			foreach($products as $p){
				if(!$p) continue;
				if($qty = @$byId[$p->getId()]){
					$order->addItem($p->getLabel(),$p->price,$qty,'products',$p->getId());
					unset($byId[$p->getId()]);
				}
			}
			$this->triggerAction('basket_copied_to_order',$order);
		}
		function setQuantity($id,$qty){
			foreach($this->products as $k=>$v){
				if($v==$id){
					if(--$qty<0) unset($this->products[$k]);
				}
			}
			while(--$qty>=0){
				$this->products[] = $id;
			}
			$this->writeToDB();
		}
		function removeItem($id){
			$this->setQuantity($id,0);
		}
	}
?>
