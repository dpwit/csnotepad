<?php

	class dependant_product{
	
		function __construct()
		{
			cms_listen_action('models_loaded',$this,false,100);
			cms_register_filter('get_product_class',$this);
			cms_listen_action('model_instantiated_product',$this);
			//cms_listen_action('before_write_order_item',$this);
			cms_listen_action('items_modified',$this);
		}
		
		function models_loaded(){
			Model::addModel('DependantProduct',dirname(__FILE__).'/class.DependantProduct.php','DependantProduct');
		}
		
		function get_product_class($default,$typeId,$instance){
			if($typeId==19) // Dependant Product Type == 19
				$default = "DependantProduct";
			return $default;
		}
		
		function model_instantiated_product($product)
		{
			$product->hasMM('dependantproducts',array(
				'table'=>'master_product_mm_dependant_product',
				'composition'=>1,
				'model'=>'DependantProduct',
				'local_id'=>'master_product_uid',
				'foreign_id'=>'dependant_product_uid',
				'quick-ui'=>true,
				"where" => array('product_type_uid'=>19),
				'back'=>'dependedby',
				'label' => 'Dependant Products'
			));
		}

/* 		function items_modified($order){
			//if($this->internal) return ;
			if($this->internal) return $order;
			$this->internal = true;
			$recurse = false;
			foreach($order->order_items() as $item){
			
				if($item->ref_table!="products") continue;
				$p = $item->product();
				$found[$p->getid()]+=$item->getQuantity();
				$items[$p->getId()][] = $item;
				if($p instanceof DependantProduct) $dep[$p->getid()] = $p;
				foreach($item->product()->dependantproducts() as $depProd){
					$need[$depProd->getId()]+=$item->getQuantity();
					$dep[$depProd->getid()] = $depProd;
				}
			}			

			$found_keys = array_keys($found);
			$need_keys = array_keys($need);
			$real_keys = array_keys($dep);

			foreach($real_keys as $key){
				$diff = $need[$key] - $found[$key] ;
	
				if($diff) $recurse = true;
				while($diff<0){
				//die("???");
					$item = array_shift($items[$key]);
					$remove = max($diff,-$item->getQuantity());
					if($remove==-$item->getQuantity()){
						$item->delete();
					} else {
						$item->setQuantity($item->getQuantity()+$remove);
					}
					$diff+=$remove;
				}
				while($diff>0){
				//die("!!!");
					$prod = Model::g('Product',$key);
					$item = $order->addItem($prod->getLabel(),$prod->getPrice(),$diff,'products',$key);
					$item->writeToDB();
					$diff=0;
				}
			
			}
			$this->internal=false;
			if($recurse) $this->items_modified($order);
		} */
		
		function items_modified($order){
			//if($this->internal) return ;
			//die('sdfasdf');
			if($this->internal) return $order;
			$this->internal = true;
			$recurse = false;
			$dep = $found = $need = array();
			
			foreach($order->order_items(array(),array('no_cache'=>true)) as $item){
				if($item->ref_table!="products") continue;
				$p = $item->product();
				$found[$p->getid()]+=$item->getQuantity();
				$items[$p->getId()][] = $item;
				if($p instanceof DependantProduct) $dep[$p->getid()] = $p;
				foreach($item->product()->dependantproducts() as $depProd){
					$need[$depProd->getId()]+=$item->getQuantity();
					//var _dump("Checking ".$p->uid.' Setting to '.$need[$depProd->getId()]);
					$dep[$depProd->getid()] = $depProd;
					$dep_item[$depProd->getid()] = $item;
				}
			}			

			$found_keys = array_keys($found);
			$need_keys = array_keys($need);
			$real_keys = array_keys($dep);
			
			/* ?><hr><pre><?php
			var _dump($found_keys,$need_keys,$real_keys);*/

			foreach($real_keys as $key){
				$diff = $need[$key] - $found[$key] ;
				/*?><hr><pre><?php
				var _dump($need[$key],$found[$key] ,$diff,$key);*/
	
				if($diff) $recurse = true;
				while($diff>0){
					$prod = Model::g('Product',$key);
					//var _dump("Adding $key");
					$item = $order->addItem($prod->getLabel(),$prod->getPrice(),$diff,'products',$key);
					$item->sorting = $dep_item[$key]->sorting+0.1;
					$item->writeToDB();
					$diff=0;
				}
				while($diff<0){
					$item = array_shift($items[$key]);
					$remove = min(-$diff,$item->getQuantity());
					//var _dump("DELETING $remove from $key");
					if($remove==$item->getQuantity()){
						//var _dump("DELETE ".$item->getQuantity()." ".$remove);
						$item->delete();
					} else {
						//var _dump("SET Quantity ".$item->getQuantity()." ".$remove);
						$item->setQuantity($item->getQuantity()-$remove);
						$item->writeToDB();
					}
					$diff+=$remove;
				}

			
			}
			$this->internal=false;
			if($recurse) $this->items_modified($order);
		}
		
		function before_write_order_item($orderItem)
		{
			if($orderItem->ref_table!="products") return;
			if(!($dependants = $orderItem->product()->dependantproducts())) return;
			
			//die('here?');
			
			$order = $orderItem->order();
			foreach($dependants as $depProd){
				if($order->order_items(array('ref_table'=>'product','ref_id'=>$depProd->uid))) continue;
				$order->addItem($depProd->name,$depProd->price,1,'products',$depProd->uid)->writeToDb();
			}
		}
		
	}
	
	new dependant_product();