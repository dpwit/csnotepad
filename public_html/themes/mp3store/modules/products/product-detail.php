						<div id="productDetail">
							<div id="pdContent">
				<?=$this->view($context,$product->template('summary'),array('product'=>$product,'basket'=>$basket))?>
				<?=$this->view($context,$product->template('sidebar'),array('product'=>$product,'basket'=>$basket))?>
						</div>		
