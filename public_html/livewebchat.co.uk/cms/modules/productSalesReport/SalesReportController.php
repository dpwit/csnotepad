<?
	require_once(__MODELS_BASE__.'/reportable.php');
ini_set('memory_limit','1028M');

	class DateGrouper extends StringGrouper {
		function extractKey($model){
			$string = parent::extractKey($model);
			return date("Y-m-d",$string);
		}
	}
	class SortAndUngroupFilter extends SortFilter {
		function doParams($model,$params,$selected=null){
			$params = parent::doParams($model,$params,$selected);
			if($params['order']!='uid'){
				$params['group']['ctime'] = 'ref_id';
			}
			return $params;
		}

	}
	class SalesReport extends ModelReporter {
		var $current = null, $last = null;

		function __construct(){
			parent::__construct(Model::g('Product_Order_Item'),array('order.order_state.end_state'=>1),array(
				'group'=>array(
					'ctime'=>new DateGrouper("order.ctime"),"ref_table","ref_id",
					'order.payment_method',
					'order.payment_gateway',
				),
				'aggregate'=>array('price','quantity','total','nett',new AnyAggregator('name'),new AnyAggregator('uid'),new AnyAggregator('ref_id')),
				'order'=>'uid desc',
			));
		}

		function on_report_summary(){
			switch($this->format){
			case 'csv':
				echo '"","","","Quantity","Total"'."\n";
				echo csv_format(array('Totals:','','',$this->totalQ,$this->totalT))."\n";
				break;
			default:
?>
<table class='cmstable'><thead><tr><th></th><th class='col-quantity'>Quantity</th><th class='col-total'>Total</th></tr></thead>
<tbody><tr class='overall-summary'><td class='tablecell'>Totals</td><td><?=$this->totalQ?></td><td><?=number_format($this->totalT,2)?></td></tr></tbody></table>
<?
				break;
			}
		}
		function on_after_table(){
			if($this->isBydate()){
				$q = $this->prevQ-@$this->lastQ;
				$this->lastQ=$this->prevQ;
				$n = $this->prevN-@$this->lastN;
				$this->lastN=$this->prevN;
				$t = $this->prevT-@$this->lastT;
				$this->lastT=$this->prevT;

			switch($this->format){
			case 'csv':
				echo csv_format(array('Daily Total:','','','',$q,$n,$t))."\n";
				break;
			default:
?>
<tr class='daily-summary'>
<td class='tablecell daily-total'>Daily Total</td>
<td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td>
<td class='tablecell'><?=$q?></td>
<td class='tablecell'><?=number_format($n,2)?></td>
<td class='tablecell'><?=number_format($t,2)?></td></tr>
<?
				break;
			}
			}
		}
		function filter_model_listing_filters($filters=array()){
			$cats = Model::ga('ProductCategory',array(),array('for_fetch'=>1));
			$categories=array();
			while($cat = $cats->fetch()){
				$categories[$cat->getId()] = $cat->getLabel();
			}
			$filters[] = $categoryFilter = new ListingFilter('product.category.uid',$categories,'Category');

			$min = Model::loadModel('Order')->getFirst(array('ctime >'=>0),array('order'=>'ctime','single'=>1))->ctime;
			$min = strtotime(date("Y-m",$min));
			$months=array();
			while($min < time()){
				$end = strtotime("+1 month",$min);
				$months["$min-$end"] = date("M Y",$min);
				$min=$end;
			}
			$months = array_reverse($months);
			$filters[] = $monthFilter = new RangeFilter('order.ctime',$months,'Date');
			$monthFilter->default = array_shift(array_keys($months));
			$filters[] = $sortFilter = new SortAndUngroupFilter('sort',array('uid'=>'Date','name'=>'Product Name','total'=>'Total','quantity'=>'Quantity'),'Sort By');
			$sortFilter->default='uid';

			$this->filters['Month'] = $monthFilter;
			$this->filters['Category'] = $categoryFilter;
			$this->sortFilter = $sortFilter;
			$this->monthFilter = $monthFilter;

			return $filters;
		}

		function getReportTitle(){
			$limits=array();
			foreach($this->filters as $k=>$f){
				$id = $f->getSelected();
				$val = $f->options[$id];
				if($id!='any'){
					$limits[] = "$k $val";
				}
			}
			$sel = $this->sortFilter->getSelected();
			$sel = $this->sortFilter->options[$sel];

			if($limits) $limits = " for ".join(", ",$limits);
			else $limits='';

			if(@$this->where['like']) $limits.=" matching '{$this->where['like']}'";
			return "Sales $limits by $sel";
		}

		function getListingHeadings(){
			return array('Product','Cat No','Category','Payment Type','Quantity','Nett','Total');
		}
		function getListingValues(){
			$product = Model::g('Product',$this->current['keys'][2]);
			if($product){
				$catno = $product->catalogue_number;
				$category =  $product->categories(array(),array('single'=>1));
				$category = $category ? $category->getLabel() : '';
			}
			$product = $product ? $product->getLabel() : $this->current['name']." (deleted)";
			return array($product,
				$catno,
				$category,
				$this->current['keys'][4]."/".$this->current['keys'][3],
				$this->current['quantity'],
				number_format($this->current['nett'],2),
				number_format($this->current['total'],2),
			);
		}

		function isByDate(){
			return (@$this->params['group']['ctime']!='ref_id');
		}
		function on_head_report_table(){
			if($this->isByDate()){
				$date = date('l jS \of F, Y',strtotime($this->current['keys'][0]));
				switch($this->format){
				case 'csv':
					echo "\"$date\"\n";
					break;
				default:
					echo "<tr class='report-title-row'><th colspan='3'>$date</th></tr>";
				}
			}
		}
		
		function newTable(){
			if(parent::newTable()) return true;
			if($this->isByDate()){
				if($this->current['keys'][0]!=$this->last['keys'][0]) {
					return true;
				}
			}
			return false;
		}

		function startQuery(){
			if(is_string($this->params['order']) && !in_array($this->params['order'],$this->params['aggregate'])){
//				$this->params['aggregate'][] = str_replace(' desc','',$this->params['order']);
			}
//			$this->params['debug'] = 1;
			$this->params['destroy'] = 1;
			$this->q = $this->model->countMatching($this->where,$this->params);
			if(!in_array($this->params['order'],array('uid','uid desc'))){
				usort($this->q,array($this,'manualSort'));
			}
		}
		function manualSort($a,$b){
			$f = str_replace(" desc","",$of = $this->params['order']);
			$mul = ($of!=$f) ? -1 : 1;
			if($a[$f]==$b[$f]) return 0;
			return $mul * (($a[$f]<$b[$f]) ? -1 : 1);
		}

		function next(){
			$this->last = $this->current;
			if(!is_array($this->q)) $this->startQuery();

			while($this->skip) {
				$this->skip--;
				do {
					$this->current = array_shift($this->q);
				} while($this->q && !$this->appropriate($this->current));
			}
			do {
				$this->current = array_shift($this->q);
			} while($this->q && !$this->appropriate($this->current));
			$order = Model::loadModel('Order');
			if($this->current){
				$t = $this->current['total'];
				$q = $this->current['quantity'];
				//$this->current['nett'] = $this->current['quantity'] * $order->deductVat(floor($this->current['total']/$this->current['quantity']));
//				$this->current['nett'] = floor($q *$order->deductVat(floor(100*$t/$q)))/100;
				$this->current['total'] = $t;
			}
			$this->prevN = @$this->totalN;
			$this->prevQ = @$this->totalQ;
			$this->prevT = @$this->totalT;
			$this->totalQ+= $this->current['quantity'];
			$this->totalN+= $this->current['nett'];
			$this->totalT+= $this->current['total'];
			return $this->current;
		}
		function appropriate($row){
			return $row['keys'][1]=='products';
		}
	}

	class SalesReportController extends Controller {
		function cms_index($params){
			// Do something
			
			$params['report'] = new SalesReport();
			$params['perPage'] = 0;
			switch(@$params['format']){
			case 'csv':
				return $this->showView('csv-report',$params);
			case 'html':
			default:
				// Show View
				return $this->showView('report',$params);
			}
		}
		
		function cms_reportProduct($params){
			$this->showView('reportProduct',$params);
		}

		function cms_reportCategory($params){
			$this->showView('reportCategory',$params);
		}
		
		function getModelName(){
			return "SalesReport";
		}
	}
?>
