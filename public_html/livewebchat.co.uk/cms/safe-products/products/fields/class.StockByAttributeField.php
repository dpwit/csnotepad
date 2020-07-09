<?
	class StockByAttributeField extends Field {
		function renderTo($obj){
			if(!($obj->product_type()&&$obj->product_type()->product_attributes())) return false;
			return parent::renderTo($obj);
		}
		function setParams($params){
			$params['db'] = false;
			$params['label'] = 'Availability By Attribute';
			parent::setParams($params);
		}
		function transformPostData($post,$obj){
			$hn = $this->htmlName($obj);
			$obj->newStock = array();
			foreach($obj->product_type()->product_attributes() as $attribute){
				foreach($attribute->options() as $option){
					$oid = $option->getId();
					if(@$post["$hn-$oid-exists"]){
						$qty = $post["$hn-$oid-qty"];
						$obj->newStock[$oid]=$qty;
					}
				}
			}
			// Check for variation data
		}
		function afterWrite($obj,$old,$assigns){
			if(!isset($obj->newStock)) return;
			foreach($obj->newStock as $id=>$qty){
				$variation = $obj->variations(array('product_attribute_options.uid'=>$id),array('single'=>1,'show_deleted'=>1));
				if(!$variation){
					$variation = $obj->createVariation();
					$variation->product_attribute_options[] = $id;
				}
				$variation->setStock($qty);
				$variation->status=1;
				$variation->writeToDB();
				$valid[$variation->getId()] = true;
			}
			foreach($obj->variations() as $var){
				if(!@$valid[$var->getId()]){
					$var->delete();
				}
			}
			unset($obj->newStock);
		}

		function renderHTML($product){
			ob_start();
			$variations = $product->variations(array(),array('visible'=>0));
			$byId = array();
			$hn = $this->htmlName($product);
			if(@$product->newStock){
				//If validation fails
				$byId = $product->newStock;
			} else {
				foreach($variations as $k=>$v){
					$attribute = $v->product_attribute_options(array(),array('single'=>1));
					if(!$attribute) continue;
					$byId[$attribute->getId()] = $v;
				}
			}
			$type = $product->product_type();
			if($type)
			foreach($type->product_attributes() as $attribute){
?>
			<div class='product-attribute'>
				<h2><?=$attribute->getLabel()?></h2>
				<ul>
<?
				foreach($attribute->options() as $option) {
					$ohn = $hn.'-'.$option->getId();
					$exists = array_key_exists($option->getId(),$byId);
					$var = @$byId[$option->getid()];
					$stock = is_object($var)?$var->stock:$var;
?>
					<li class='variation <?=$var?'has-variation':'no-variation'?>'>
					<span class='activator'><input type='checkbox' id='<?=$ohn?>-exists' name='<?=$ohn?>-exists' <?if($exists){?>checked='true'<?}?> class='exists-check'/>
					<label for='<?=$ohn?>-exists'><?=$option->getLabel()?></label></span>
<?
?>
					<span class='qty'>Quantity:<input type='text' name='<?=$ohn?>-qty' value='<?=@$stock?>' class='qty-field'/></span>
<?
?>
					</li>
<?
				}
?>
				</ul>
			</div>
			<script>
				$(function(){
					$('li.variation:has(input:checkbox:not(:checked)) input:text').attr('disabled',true);
					$('input.exists-check').die('click.variation').live('click.variation',function(){
						var $this = $(this);
						var checked = $this.is(':checked');
						$(this).closest('.variation').addClass(checked?'has-variation':'no-variation').removeClass(checked?'no-variation':'has-variation').find('input:text').attr('disabled',!checked);
						
					});
				});					
			</script>
			<style>
				li.no-variation {
					color: #aaa;
				}
			</style>
<?
			}
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}
	}
?>
